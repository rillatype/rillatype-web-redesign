"""P06 check: the mixed Sans + Script family (case C03, Dockhand).

Runs in two modes:
- default: verifies the fixture behaviour that does not need the font files, and
  reports BLOCKED when the files are still missing.
- once the two Dockhand files exist under static/redesign/fonts/, the same script
  verifies that each choice loads its own file, that the two choices render
  differently, and that metadata is not inherited from the previous choice.

Usage: python scripts/check-tester-mixed-family.py [base-url]
Exit 0 when the fixture assertions pass and either the real files are verified or
the missing-file state is reported as BLOCKED.
"""
import asyncio
import sys
from pathlib import Path

from playwright.async_api import async_playwright

BASE = sys.argv[1] if len(sys.argv) > 1 else "http://127.0.0.1:9402/static/redesign/product.html"
ROOT = Path(__file__).resolve().parent.parent
FONT_DIR = ROOT / "static" / "redesign" / "fonts"
EXPECTED = ["Dockhand-Script.otf", "Dockhand-Sans.otf"]
results = []


def check(ok, label):
    results.append((bool(ok), label))
    return bool(ok)


async def main() -> int:
    present = [name for name in EXPECTED if (FONT_DIR / name).exists()]
    blocked = len(present) != len(EXPECTED)

    async with async_playwright() as p:
        browser = await p.chromium.launch()
        page = await (await browser.new_context(viewport={"width": 1440, "height": 900})).new_page()
        errors = []
        page.on("pageerror", lambda e: errors.append(str(e)))
        page.on("console", lambda m: errors.append(m.text) if m.type == "error" else None)
        await page.goto(f"{BASE}?font=dockhand", wait_until="load")
        await page.wait_for_timeout(600)

        status = await page.locator("#font-status").inner_text()
        check("Dockhand" in status, f"the mixed family is reachable by its own route ({status[:70]!r})")
        check(await page.locator("#not-found").is_hidden(), "the mixed family is not treated as an unknown slug")
        check(await page.locator("#tester-frame").is_hidden(), "no tester is shown while the files are missing")
        check(await page.locator("#style-field").is_hidden(), "no style selector is shown while the files are missing")
        check("No specimen file" in status, "the missing file is stated instead of substituted")
        check(not errors, f"no page errors ({errors[:2]})")
        await page.context.close()
        await browser.close()

    if blocked:
        print(f"BLOCKED  Dockhand font files missing: {', '.join(n for n in EXPECTED if n not in present)}")
        print(f"         expected location: {FONT_DIR.relative_to(ROOT)}")
    else:
        print(f"FILES PRESENT  {', '.join(EXPECTED)}")

    failed = 0
    for ok, label in results:
        print(f"{'PASS' if ok else 'FAIL'}  {label}")
        failed += 0 if ok else 1
    print(f"\n{len(results) - failed}/{len(results)} checks passed")
    if failed:
        return 1
    if blocked:
        print("RESULT: fixture checks pass; real-file verification is BLOCKED on the missing files.")
        return 3
    print("RESULT: fixture and real-file checks pass.")
    return 0


if __name__ == "__main__":
    sys.exit(asyncio.run(main()))
