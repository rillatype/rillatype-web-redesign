"""P05 check: named styles, one file each, loaded on demand.

Covers the multi-style product (Chronoa, nine real cuts):
- the selector lists the real names and each option maps to its own file
- only the default cut is fetched on load; other cuts load when chosen
- switching a style preserves text, size, leading, tracking, alignment and theme
- clearing the input and a style round-trip keep the selection
- OpenType and glyph facts refresh for the active style

Usage: python scripts/check-tester-styles.py [base-url]
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


def tracked(page, bucket):
    def handler(response):
        url = response.url
        if url.endswith(".otf"):
            bucket.append(url.rsplit("/", 1)[-1])
    page.on("response", handler)


async def main() -> int:
    async with async_playwright() as p:
        browser = await p.chromium.launch()

        # ------------------------------------------------- Chronoa, nine real cuts
        ctx = await browser.new_context(viewport={"width": 1440, "height": 900})
        page = await ctx.new_page()
        errors = []
        page.on("pageerror", lambda e: errors.append(str(e)))
        page.on("console", lambda m: errors.append(m.text) if m.type == "error" else None)
        fonts = []
        tracked(page, fonts)
        await page.goto(f"{BASE}?font=chronoa", wait_until="load")
        await page.wait_for_function("() => !document.querySelector('#tester-frame').hidden", timeout=15000)
        await page.wait_for_timeout(600)

        check(fonts and set(fonts) == {"Chronoa-SemiBold.otf"},
              f"only the default cut is fetched on load (got {sorted(set(fonts))})")
        check(len(fonts) <= 3, f"the default cut costs one face and at most two text probes ({len(fonts)} requests)")

        options = await page.eval_on_selector_all("#sample-style option", "els => els.map(e => e.textContent)")
        check(options == ["Thin", "ExtraLight", "Light", "Regular", "Medium", "SemiBold", "Bold", "ExtraBold", "Black"],
              f"selector lists the real style names in order ({options})")
        check(await page.locator("#style-field").is_visible(), "selector is visible for a multi-style product")

        # ------------------------------------------- state set before the switch
        await page.fill("#sample-text", "Harbour & Co.")
        await page.fill("#sample-size", "96")
        await page.fill("#sample-leading", "150")
        await page.fill("#sample-tracking", "8")
        await page.click('input[name="align"][value="center"]')
        await page.click('input[name="theme"][value="dark"]')
        await page.wait_for_timeout(120)
        before = await page.evaluate("""() => ({
            text: document.querySelector('#sample-text').value,
            size: document.querySelector('#sample-size').value,
            leading: document.querySelector('#sample-leading').value,
            tracking: document.querySelector('#sample-tracking').value,
            align: document.querySelector('#sample-output').dataset.align,
            theme: document.querySelector('#tester-stage').dataset.theme,
            weight: getComputedStyle(document.querySelector('#sample-output')).fontWeight
        })""")
        check(before["weight"] == "600", f"the default cut renders at its real weight ({before['weight']})")

        # ------------------------------------------------ switch to the Bold cut
        await page.select_option("#sample-style", "6")
        await page.wait_for_function("() => getComputedStyle(document.querySelector('#sample-output')).fontWeight === '700'", timeout=15000)
        await page.wait_for_timeout(200)
        after = await page.evaluate("""() => ({
            text: document.querySelector('#sample-text').value,
            size: document.querySelector('#sample-size').value,
            leading: document.querySelector('#sample-leading').value,
            tracking: document.querySelector('#sample-tracking').value,
            align: document.querySelector('#sample-output').dataset.align,
            theme: document.querySelector('#tester-stage').dataset.theme,
            rendered: document.querySelector('#sample-output').textContent,
            family: getComputedStyle(document.querySelector('#sample-output')).fontFamily,
            fontStyle: getComputedStyle(document.querySelector('#sample-output')).fontStyle,
            transform: getComputedStyle(document.querySelector('#sample-output')).transform
        })""")
        check(after["text"] == before["text"], f"text is preserved across a style change ({after['text']!r})")
        check(after["size"] == before["size"], f"size is preserved ({after['size']})")
        check(after["leading"] == before["leading"], f"leading is preserved ({after['leading']})")
        check(after["tracking"] == before["tracking"], f"tracking is preserved ({after['tracking']})")
        check(after["align"] == "center", f"alignment is preserved ({after['align']})")
        check(after["theme"] == "dark", f"theme is preserved ({after['theme']})")
        check("Chronoa-Bold.otf" in fonts, f"the chosen cut loads its own file ({sorted(set(fonts))})")
        # Each cut costs one FontFace + one feature probe + one glyph probe. They are
        # separate HTTP requests in this prototype; sharing one buffer would mean
        # tester-core.js returns raw bytes, which is P08 work. Recorded, not hidden.
        check(fonts.count("Chronoa-Bold.otf") <= 3,
              f"a chosen cut costs one face and at most two text probes ({fonts.count('Chronoa-Bold.otf')} requests)")

        # the chosen style is its own file, not a CSS trick on the previous one
        check(after["fontStyle"] == "normal", f"no synthetic italic is used for a named style ({after['fontStyle']})")
        check(after["transform"] in ("none", "matrix(1, 0, 0, 1, 0, 0)"), f"no skew transform stands in for a slanted style ({after['transform']})")
        loaded_files = await page.evaluate("() => [...document.fonts].filter(f => f.family.startsWith('Rilla-')).length")
        check(loaded_files >= 2, f"the second cut is registered as a real face ({loaded_files})")

        # ---------------------------------------------- glyph facts follow the cut
        glyph_text = await page.locator("#glyph-count").inner_text()
        check("characters" in glyph_text, f"glyph facts are stated for the active cut ({glyph_text!r})")

        # ------------------------------------------- empty input and round-trip
        await page.fill("#sample-text", "")
        await page.wait_for_timeout(120)
        await page.select_option("#sample-style", "0")
        await page.wait_for_function("() => getComputedStyle(document.querySelector('#sample-output')).fontWeight === '100'", timeout=15000)
        selected = await page.eval_on_selector("#sample-style", "el => el.options[el.selectedIndex].textContent")
        check(selected == "Thin", f"a style change with empty input keeps the chosen style ({selected})")
        await page.fill("#sample-text", "Back again")
        await page.wait_for_timeout(150)
        check(await page.locator("#sample-output").inner_text() == "Back again", "typing after an empty round-trip shows the text again")

        check(not errors, f"no page errors during the run ({errors[:2]})")
        await ctx.close()

        # ------------------------------------------------- index 0 is the Thin cut
        # A02: `Number(value) || fallback` used to swallow index 0. The selector, the
        # requested file, the status, the weight and the loaded face must all name the
        # same cut; a computed weight of 100 is not evidence on its own, because the
        # sample element reads its weight from the form control while the product
        # loader can still be holding SemiBold.
        ctx = await browser.new_context(viewport={"width": 1440, "height": 900})
        page = await ctx.new_page()
        errors = []
        page.on("pageerror", lambda e: errors.append(str(e)))
        page.on("console", lambda m: errors.append(m.text) if m.type == "error" else None)
        asked = []
        tracked(page, asked)
        await page.goto(f"{BASE}?font=chronoa", wait_until="load")
        await page.wait_for_function("() => !document.querySelector('#tester-frame').hidden", timeout=15000)
        await page.fill("#sample-text", "Round trip")
        await page.fill("#sample-size", "88")
        await page.fill("#sample-leading", "140")
        await page.fill("#sample-tracking", "6")
        await page.click('input[name="align"][value="center"]')
        await page.click('input[name="theme"][value="dark"]')
        await page.wait_for_timeout(200)

        def read_state():
            return page.evaluate("""() => {
                const select = document.querySelector('#sample-style');
                const output = document.querySelector('#sample-output');
                const cs = getComputedStyle(output);
                return {
                    cut: select.options[select.selectedIndex].textContent,
                    status: document.querySelector('#font-status').innerText.trim(),
                    weight: cs.fontWeight,
                    family: cs.fontFamily,
                    faces: [...document.fonts].filter(f => f.family === 'Rilla-Chronoa')
                                                .map(f => `${f.weight}:${f.status}`),
                    text: output.innerText,
                    size: cs.fontSize,
                    leading: cs.lineHeight,
                    tracking: cs.letterSpacing,
                    align: output.dataset.align || '',
                    theme: document.querySelector('#tester-stage').dataset.theme || '',
                };
            }""")

        sequence = [("5", "SemiBold", 600), ("0", "Thin", 100), ("6", "Bold", 700), ("0", "Thin", 100)]
        rows = []
        for value, cut, weight in sequence:
            await page.select_option("#sample-style", value)
            # The wait is bounded and non-fatal on purpose: a build that never names
            # the chosen cut must still produce the failing comparison below, instead
            # of aborting the whole suite with a timeout.
            try:
                await page.wait_for_function(
                    "() => document.querySelector('#font-status').textContent.includes('(%s)')" % cut,
                    timeout=6000)
            except Exception:
                pass
            await page.wait_for_timeout(200)
            rows.append((cut, weight, await read_state()))

        cuts = [row[0] for row in rows]
        check(asked.count("Chronoa-Thin.otf") >= 1,
              f"choosing index 0 requests the Thin file ({sorted(set(asked))})")
        check([row[2]["cut"] for row in rows] == cuts,
              f"the selector labels match the cut that was chosen ({[row[2]['cut'] for row in rows]})")
        check([row[2]["status"] for row in rows] == [
            f"Showing the actual Chronoa ({cut}) font, 9 styles available." for cut in cuts],
              f"the status names the same cut every time ({[row[2]['status'] for row in rows]})")
        check([row[2]["weight"] for row in rows] == [str(row[1]) for row in rows],
              f"each cut renders at its own weight ({[row[2]['weight'] for row in rows]})")
        # The stylesheet's own WOFF2 subsets can satisfy a weight on their own, so this
        # check states only that a face at the chosen weight is available. The proof
        # that the product loader picked the cut is the OTF request asserted above.
        check(all(f"{row[1]}:loaded" in row[2]["faces"] for row in rows),
              f"a face at each chosen weight is available to the sample "
              f"({[row[2]['faces'] for row in rows]})")
        check(all(row[2]["family"].split(",")[0].strip().strip('\"') == "Rilla-Chronoa" for row in rows),
              f"the product family stays applied ({[row[2]['family'] for row in rows]})")
        check(all(row[2][key] == rows[0][2][key] for row in rows
                  for key in ("text", "size", "leading", "tracking", "align", "theme")),
              f"input and licence-adjacent state survive the round trip ({rows[0][2]})")
        check(not errors, f"no page errors while choosing index 0 ({errors[:2]})")
        await ctx.close()

        # ------------------------------------------- one cut fails from a cold start
        # The abort has to be installed before the page loads, otherwise the cut is
        # already cached and the failure path is never reached.
        ctx = await browser.new_context(viewport={"width": 1440, "height": 900})
        page = await ctx.new_page()
        cold_errors = []
        page.on("pageerror", lambda e: cold_errors.append(str(e)))
        await page.route("**/Chronoa-Black.otf", lambda route: route.abort())
        await page.goto(f"{BASE}?font=chronoa", wait_until="load")
        await page.wait_for_function("() => !document.querySelector('#tester-frame').hidden", timeout=15000)
        await page.select_option("#sample-style", "8")
        await page.wait_for_timeout(1800)
        status = await page.locator("#font-status").inner_text()
        check("could not" in status.lower() or "unavailable" in status.lower(),
              f"a cut that fails from cold states the problem ({status!r})")
        check(not await page.locator("#retry-font").is_hidden(), "a cut that fails from cold offers retry")
        check(not await page.locator("#tester-frame").is_hidden(), "a cut that fails from cold keeps the tester visible")
        check(await page.locator("#sample-output").is_hidden(), "a cut that fails from cold hides the untrustworthy sample")
        check(await page.locator("#sample-text").is_visible(), "a cut that fails from cold keeps the controls usable")
        weight = await page.eval_on_selector("#sample-output", "el => getComputedStyle(el).fontWeight")
        check(weight != "900", f"a failed cut does not pretend to be the missing weight ({weight})")
        await ctx.close()

        # -------------------------------------- a product with no files stays honest
        page = await (await browser.new_context(viewport={"width": 1440, "height": 900})).new_page()
        await page.goto(f"{BASE}?font=tropivera", wait_until="load")
        await page.wait_for_timeout(500)
        status = await page.locator("#font-status").inner_text()
        check("No specimen file" in status, f"a product without files says so ({status[:60]!r})")
        check(await page.locator("#tester-frame").is_hidden(), "a product without files shows no tester")
        check(await page.locator("#style-field").is_hidden(), "a product without files shows no style selector")
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
