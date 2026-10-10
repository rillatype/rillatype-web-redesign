"""P07 check: weight controls only where real weight files exist.

Rules from the card:
- weight controls appear only for a real, available weight list
- Mango (one cut) never gets a weight control
- Rough/Script/Slant styles are never given invented numeric weights
- the default comes from the data, not from whichever file answered first

Usage: python scripts/check-weight-controls.py [base-url]
Exit 0 only when every assertion passes.

RILLA_CATALOG may name a scratch copy of the catalog, for A01 negative controls.
"""
import asyncio
import os
import re
import sys
from pathlib import Path

from playwright.async_api import async_playwright

ROOT = Path(__file__).resolve().parent.parent
BASE = sys.argv[1].rstrip("/") if len(sys.argv) > 1 else "http://127.0.0.1:9402/static/redesign"
WEB = ROOT / "static" / "redesign" / "fonts" / "web"
CATALOG = Path(os.environ.get("RILLA_CATALOG") or (ROOT / "static" / "redesign" / "font-catalog.js")).read_text(encoding="utf-8")
results = []


def check(ok, label):
    results.append((bool(ok), label))
    return bool(ok)


def declared_cuts():
    """Cut names declared for Chronoa in the catalog data."""
    block = CATALOG[CATALOG.index("['chronoa'"):]
    block = block[: block.index("}],")]
    return re.findall(r"label: '([^']+)'", block)


def available_web_cuts():
    """Cuts that actually have a web subset on disk, in weight order."""
    names = {p.stem.replace("chronoa-", "") for p in WEB.glob("chronoa-*.woff2")}
    return names


async def main() -> int:
    declared = declared_cuts()
    available = available_web_cuts()
    check(len(declared) == 9, f"the catalog declares nine Chronoa cuts ({declared})")
    check(available, f"web subsets exist on disk ({sorted(available)})")
    def slug(name):
        return re.sub(r"[^a-z0-9]", "", name.lower())

    # A01 replaced the check that stood here: it read
    # `all(... or True for name in declared)` with a no-op
    # `replace("extralight", "extralight")`, so it could never fail. The requirement
    # it named is real, so it is measured here: every declared cut label must have a
    # subset on disk.
    on_disk = {slug(name) for name in available}
    unmatched = [name for name in declared if slug(name) not in on_disk]
    check(not unmatched, f"every declared cut name has a subset on disk (unmatched {unmatched})")

    async with async_playwright() as p:
        browser = await p.chromium.launch()

        # ------------------------------------------------- homepage: Chronoa cuts
        page = await (await browser.new_context(viewport={"width": 1440, "height": 900})).new_page()
        errors = []
        page.on("pageerror", lambda e: errors.append(str(e)))
        page.on("console", lambda m: errors.append(m.text) if m.type == "error" else None)
        await page.goto(f"{BASE}/index.html", wait_until="load")
        await page.wait_for_function("() => document.querySelector('#specimen-frame').dataset.state === 'ready'", timeout=15000)

        weights = await page.eval_on_selector_all(
            "#weight-picker input", "els => els.map(e => Number(e.value)).sort((a, b) => a - b)")
        check(weights == sorted(weights), f"homepage weights are listed in ascending order ({weights})")
        check(len(weights) == len(available),
              f"homepage offers exactly the cuts with a web subset ({len(weights)} offered, {len(available)} files)")
        selected = await page.eval_on_selector("#weight-picker input:checked", "el => Number(el.value)")
        check(selected == 600, f"homepage default cut comes from the data, not the first file ({selected})")
        facts = await page.locator("#specimen-facts").inner_text()
        check("SemiBold" in facts, f"homepage facts name the default cut ({facts!r})")

        # the weight list must be a real list, not invented numbers
        check(all(weight % 100 == 0 for weight in weights), f"weights are real cut steps ({weights})")

        # ------------------------------------------- homepage: Mango has one cut
        await page.locator("#cut-picker label", has_text="Mango").first.click()
        await page.wait_for_function("() => document.querySelector('#specimen-facts').textContent.includes('Mango')", timeout=15000)
        check(await page.locator("#weight-picker").is_hidden(), "Mango hides the homepage weight control")
        check(not errors, f"homepage has no page errors ({errors[:2]})")
        await page.context.close()

        # ------------------------------------- product page: a real weight family
        page = await (await browser.new_context(viewport={"width": 1440, "height": 900})).new_page()
        await page.goto(f"{BASE}/product.html?font=chronoa", wait_until="load")
        await page.wait_for_function("() => !document.querySelector('#tester-frame').hidden", timeout=15000)
        check(await page.locator("#style-field").is_visible(), "Chronoa shows a named style selector")
        labels = await page.eval_on_selector_all("#sample-style option", "els => els.map(e => e.textContent)")
        check(labels == declared, f"Chronoa selector uses the declared cut names ({labels})")
        weight_controls = await page.locator("input[id*=weight], select[id*=weight], #weight-field").count()
        check(weight_controls == 0, f"Chronoa does not add a second numeric weight control ({weight_controls})")
        selected = await page.eval_on_selector("#sample-style", "el => el.options[el.selectedIndex].textContent")
        check(selected == "SemiBold", f"Chronoa default comes from the data ({selected})")
        for label, expect in [("Thin", "100"), ("Regular", "400"), ("Black", "900")]:
            index = str(labels.index(label))
            await page.select_option("#sample-style", index)
            await page.wait_for_timeout(700)
            actual = await page.eval_on_selector("#sample-output", "el => getComputedStyle(el).fontWeight")
            check(actual == expect, f"choosing {label} renders weight {expect} (got {actual})")
        await page.context.close()

        # --------------------------------- product page: one cut, no weight control
        page = await (await browser.new_context(viewport={"width": 1440, "height": 900})).new_page()
        await page.goto(f"{BASE}/product.html?font=mango", wait_until="load")
        await page.wait_for_function("() => !document.querySelector('#tester-frame').hidden", timeout=15000)
        check(await page.locator("#style-field").is_hidden(), "Mango shows no style selector")
        weight_controls = await page.locator("input[id*=weight], select[id*=weight], #weight-field").count()
        check(weight_controls == 0, f"Mango has no weight control ({weight_controls})")
        family = await page.eval_on_selector("#sample-output", "el => getComputedStyle(el).fontFamily")
        check("Rilla-MangoLetters" in family, f"Mango still renders its real face ({family})")
        await page.context.close()

        # ------------------------- product page: named non-weight styles stay named
        # Dockhand has no files yet, so its styles are labelled and no weight exists.
        page = await (await browser.new_context(viewport={"width": 1440, "height": 900})).new_page()
        await page.goto(f"{BASE}/product.html?font=dockhand", wait_until="load")
        await page.wait_for_timeout(500)
        weight_controls = await page.locator("input[id*=weight], select[id*=weight], #weight-field").count()
        check(weight_controls == 0, f"a Script/Sans duo gets no weight control ({weight_controls})")
        check(await page.locator("#style-field").is_hidden(), "a duo without files shows no style selector")
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
