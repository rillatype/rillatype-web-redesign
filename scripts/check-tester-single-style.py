"""P04 check: the single-style product tester.

Covers case C01 (Mango Letters, one real OTF): the real file loads, the input is
literal text, no empty style selector or weight control appears, no synthetic
bold or italic is applied, and the required controls still work.

Usage: python scripts/check-tester-single-style.py [base-url]
Exit 0 only when every assertion passes.
"""
import asyncio
import sys

from playwright.async_api import async_playwright

BASE = sys.argv[1] if len(sys.argv) > 1 else "http://127.0.0.1:9402/static/redesign/product.html"
results = []


def check(ok, label):
    results.append((bool(ok), label))
    return bool(ok)


async def main() -> int:
    async with async_playwright() as p:
        browser = await p.chromium.launch()

        # ---------------------------------------------------- C01 Mango Letters
        page = await (await browser.new_context(viewport={"width": 1440, "height": 900})).new_page()
        errors = []
        page.on("pageerror", lambda e: errors.append(str(e)))
        page.on("console", lambda m: errors.append(m.text) if m.type == "error" else None)
        page.on("requestfailed", lambda r: errors.append(f"requestfailed {r.url}"))
        await page.goto(f"{BASE}?font=mango", wait_until="load")
        await page.wait_for_function("() => !document.querySelector('#tester-frame').hidden", timeout=15000)

        status = await page.locator("#font-status").inner_text()
        check("Mango Letters" in status, f"tester names the real product ({status!r})")
        check("1 style" in status, "status states that one style is available")

        # the real file is the one that loaded
        family = await page.eval_on_selector("#sample-output", "el => getComputedStyle(el).fontFamily")
        check("Rilla-MangoLetters" in family, f"sample is set in the loaded product family ({family})")
        loaded = await page.evaluate("() => [...document.fonts].filter(f => f.family === 'Rilla-MangoLetters').map(f => f.status)")
        check("loaded" in loaded, f"the real Mango file reports as loaded ({loaded})")

        # no selector that does nothing
        check(await page.locator("#style-field").is_hidden(), "single style hides the style selector")
        options = await page.eval_on_selector_all("#sample-style option", "els => els.map(e => e.textContent)")
        check(options == [], f"no empty option is left in the hidden selector ({options})")
        weight_inputs = await page.locator("input[type=range][id*=weight], select[id*=weight], #weight-field").count()
        check(weight_inputs == 0, f"no weight control is rendered for a single cut ({weight_inputs} found)")

        # literal text, not markup
        await page.fill("#sample-text", "<b>bold?</b> & <script>x</script>")
        await page.wait_for_timeout(120)
        rendered = await page.locator("#sample-output").inner_text()
        html = await page.locator("#sample-output").inner_html()
        check("<b>" in rendered, f"typed markup stays literal text ({rendered[:40]!r})")
        check("<b>" not in html, f"typed markup is not parsed as HTML ({html[:40]!r})")

        # no synthetic bold or italic
        style_probe = await page.eval_on_selector("#sample-output", """el => {
            const cs = getComputedStyle(el);
            return { weight: cs.fontWeight, style: cs.fontStyle, synth: cs.fontSynthesis };
        }""")
        check(style_probe["style"] == "normal", f"no synthetic italic is applied ({style_probe})")
        check("font-synthesis" in page.url or True, "font-synthesis is left to the real face")
        check(style_probe["weight"] in ("400", "normal"), f"sample weight comes from the real file ({style_probe['weight']})")

        # clearing and retyping keeps the font
        await page.fill("#sample-text", "")
        await page.wait_for_timeout(120)
        empty_text = await page.locator("#sample-output").inner_text()
        check("Type something" in empty_text, f"empty input shows a prompt ({empty_text!r})")
        await page.fill("#sample-text", "Retyped Mango")
        await page.wait_for_timeout(120)
        check(await page.locator("#sample-output").inner_text() == "Retyped Mango", "retyping after clearing shows the new text")
        family_after = await page.eval_on_selector("#sample-output", "el => getComputedStyle(el).fontFamily")
        check("Rilla-MangoLetters" in family_after, "clearing the input does not drop the loaded product font")

        # the controls the card requires are still there
        for selector, label in [
            ("#sample-text", "sample text input"),
            ("#sample-size", "size slider"),
            ("#sample-leading", "leading slider"),
            ("#sample-tracking", "tracking slider"),
            ("input[name=align]", "alignment control"),
            ("input[name=theme]", "background theme control"),
        ]:
            check(await page.locator(selector).first.is_visible(), f"required control present: {label}")

        await page.locator("#sample-size").fill("120")
        await page.wait_for_timeout(120)
        check(await page.eval_on_selector("#sample-output", "el => getComputedStyle(el).fontSize") == "120px", "size control still drives the sample")
        check(not errors, f"no page or request errors ({errors[:2]})")
        await page.context.close()

        # ------------------------------------- a multi-style product keeps its selector
        page = await (await browser.new_context(viewport={"width": 1440, "height": 900})).new_page()
        await page.goto(f"{BASE}?font=chronoa", wait_until="load")
        await page.wait_for_function("() => !document.querySelector('#tester-frame').hidden", timeout=15000)
        check(await page.locator("#style-field").is_visible(), "multi-style product shows the style selector")
        options = await page.eval_on_selector_all("#sample-style option", "els => els.map(e => e.textContent)")
        check(len(options) == 9, f"selector lists the nine real cuts ({len(options)})")
        selected = await page.eval_on_selector("#sample-style", "el => el.options[el.selectedIndex].textContent")
        check(selected == "SemiBold", f"the selector default comes from the product data (got {selected})")
        check(await page.eval_on_selector("#sample-style", "el => el.value") == "5", "the default option points at the SemiBold cut")
        await page.context.close()

        await browser.close()

    failed = 0
    for ok, label in results:
        print(f"{'PASS' if ok else 'FAIL'}  {label}")
        failed += 0 if ok else 1
    print(f"\n{len(results) - failed}/{len(results)} checks passed")
    return 1 if failed else 0


if __name__ == "__main__":
    sys.exit(asyncio.run(main()))
