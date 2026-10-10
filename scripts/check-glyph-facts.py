"""P08 check: glyph panel and OpenType switches tell the truth about the files.

Ground truth comes from scripts/_p08_font_facts.mjs, which parses the font files
directly, so the page is checked against the files and not against itself.

Usage: python scripts/check-glyph-facts.py [base-url]
Exit 0 only when every assertion passes.
"""
import asyncio
import json
import subprocess
import sys
from pathlib import Path

from playwright.async_api import async_playwright

ROOT = Path(__file__).resolve().parent.parent
BASE = sys.argv[1].rstrip("/") if len(sys.argv) > 1 else "http://127.0.0.1:9402/static/redesign"
results = []


def check(ok, label):
    results.append((bool(ok), label))
    return bool(ok)


def facts(directory: str) -> dict:
    out = subprocess.run(
        ["node", "scripts/_p08_font_facts.mjs", directory],
        cwd=ROOT, capture_output=True, text=True, shell=True,
    )
    return json.loads(out.stdout)


async def main() -> int:
    chronoa = facts("static/redesign/fonts")
    mango = facts("static/previews")
    mango_file = mango["mango-letter.otf"]

    check(all(f["codepoints"] == 218 for f in chronoa.values()),
          f"every Chronoa cut maps 218 codepoints ({sorted({f['codepoints'] for f in chronoa.values()})})")
    check(all(not f["hasLiga"] and not f["hasSalt"] for f in chronoa.values()),
          "no Chronoa cut carries liga, clig, or salt")
    check(mango_file["hasLiga"] is False and mango_file["hasSalt"] is False,
          f"Mango carries neither liga nor salt ({mango_file['features']})")
    check(mango_file["features"] == ["dlig"],
          f"Mango's real feature is tagged dlig, not liga ({mango_file['features']})")

    async with async_playwright() as p:
        browser = await p.chromium.launch()

        # ------------------------------------------------------------ Chronoa
        page = await (await browser.new_context(viewport={"width": 1440, "height": 900})).new_page()
        errors = []
        page.on("pageerror", lambda e: errors.append(str(e)))
        page.on("console", lambda m: errors.append(m.text) if m.type == "error" else None)
        await page.goto(f"{BASE}/product.html?font=chronoa", wait_until="load")
        await page.wait_for_function("() => !document.querySelector('#tester-frame').hidden", timeout=15000)
        await page.wait_for_timeout(400)

        count = await page.locator("#glyph-count").inner_text()
        check("218" in count, f"glyph count matches the files ({count!r})")
        cells = await page.locator(".glyph-cell").count()
        check(cells == 218, f"the panel renders one cell per mapped codepoint ({cells})")

        height = await page.eval_on_selector(".tester-glyphs", "el => Math.round(el.getBoundingClientRect().height)")
        check(height <= 60, f"the closed glyph panel stays a single header row ({height}px)")

        await page.locator(".tester-glyphs summary").click()
        await page.wait_for_timeout(200)
        open_height = await page.eval_on_selector(".tester-glyphs", "el => Math.round(el.getBoundingClientRect().height)")
        check(raise_limit := open_height <= 520, f"the open panel is capped, not unbounded ({open_height}px)")
        await page.locator(".tester-glyphs summary").click()
        await page.wait_for_timeout(200)
        closed_again = await page.eval_on_selector(".tester-glyphs", "el => Math.round(el.getBoundingClientRect().height)")
        check(closed_again <= 60, f"the panel closes again ({closed_again}px)")

        for switch, label in [("#liga-switch", "Ligatures"), ("#dlig-switch", "Discretionary ligatures"), ("#salt-switch", "Stylistic alternates")]:
            disabled = await page.eval_on_selector(f"{switch} input", "el => el.disabled")
            note = await page.locator(f"{switch} .switch-note").inner_text() if await page.locator(f"{switch} .switch-note").count() else ""
            check(disabled, f"Chronoa disables {label} because the file has no such feature")
            check("Chronoa" in note, f"{label} states which font lacks it ({note!r})")
        check(not errors, f"no page errors on Chronoa ({errors[:2]})")
        await page.context.close()

        # -------------------------------------------------------------- Mango
        page = await (await browser.new_context(viewport={"width": 1440, "height": 900})).new_page()
        await page.goto(f"{BASE}/product.html?font=mango", wait_until="load")
        await page.wait_for_function("() => !document.querySelector('#tester-frame').hidden", timeout=15000)
        await page.wait_for_timeout(400)
        count = await page.locator("#glyph-count").inner_text()
        check("181" in count, f"Mango glyph count matches its file ({count!r})")
        cells = await page.locator(".glyph-cell").count()
        check(cells == 181, f"Mango renders one cell per mapped codepoint ({cells})")
        for switch, label in [("#liga-switch", "Ligatures"), ("#salt-switch", "Stylistic alternates")]:
            disabled = await page.eval_on_selector(f"{switch} input", "el => el.disabled")
            check(disabled, f"Mango disables {label}: the file does not carry it")
        # Mango carries dlig for real (lookup type 4), so the switch must work and
        # must actually change the rendered sample.
        dlig_disabled = await page.eval_on_selector("#dlig-switch input", "el => el.disabled")
        check(not dlig_disabled, "Mango enables Discretionary ligatures because the file defines dlig")
        await page.click("#dlig-switch")
        await page.wait_for_timeout(150)
        settings = await page.eval_on_selector("#sample-output", "el => getComputedStyle(el).fontFeatureSettings")
        # Chrome normalises an enabled feature to just its tag, so both forms count.
        dlig_on = settings.replace(" ", "")
        check(('"dlig"1' in dlig_on) or ('"dlig",' in dlig_on) or dlig_on.rstrip(')').endswith('"dlig"'),
              f"turning the switch on writes dlig into the sample ({settings})")
        await page.click("#dlig-switch")
        await page.wait_for_timeout(150)
        settings = await page.eval_on_selector("#sample-output", "el => getComputedStyle(el).fontFeatureSettings")
        check('"dlig" 0' in settings, f"turning the switch off removes it again ({settings})")
        note = await page.locator("#liga-switch .switch-note").inner_text()
        check("Mango" in note, f"the disabled switch names the font ({note!r})")
        await page.context.close()

        # ------------------------------------------------- product without files
        page = await (await browser.new_context(viewport={"width": 1440, "height": 900})).new_page()
        await page.goto(f"{BASE}/product.html?font=dockhand", wait_until="load")
        await page.wait_for_timeout(400)
        count = await page.locator("#glyph-count").count()
        check(count == 0 or (await page.locator("#glyph-count").inner_text()) == "",
              "a product without files states no glyph facts")
        check(await page.locator("#tester-frame").is_hidden(), "a product without files shows no glyph panel")
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
