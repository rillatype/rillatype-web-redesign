"""P11 evidence: look at the region the rewrite rebuilt.

The specimen band, the featured block, and the strips are now built from data.
Pixels prove the result is unchanged; this exists so the result can also be seen.
"""
import asyncio
import sys
from pathlib import Path

from playwright.async_api import async_playwright

ROOT = Path(__file__).resolve().parent.parent
OUT = ROOT / ".impeccable" / "review"
BASE = "http://127.0.0.1:9402/static/redesign"
REGIONS = [
    ("specimen", "#live-specimen", 1440),
    ("featured", ".featured-type", 1440),
    ("strips", "#specimen-strips", 1440),
    ("specimen-mobile", "#live-specimen", 390),
]


async def main():
    prefix = sys.argv[1] if len(sys.argv) > 1 else "P11"
    async with async_playwright() as p:
        browser = await p.chromium.launch()
        for label, selector, width in REGIONS:
            ctx = await browser.new_context(viewport={"width": width, "height": 900})
            page = await ctx.new_page()
            await page.goto(f"{BASE}/index.html", wait_until="load")
            await page.wait_for_function(
                "() => document.querySelector('#specimen-frame').dataset.state === 'ready'",
                timeout=15000)
            await page.evaluate("window.scrollTo(0, 400)")
            await page.wait_for_timeout(900)
            await page.evaluate("window.scrollTo(0, 0)")
            await page.wait_for_timeout(400)
            box = await page.locator(selector).first.bounding_box()
            out = OUT / f"{prefix}-{label}.png"
            # full_page so a region below the viewport can be clipped too.
            await page.screenshot(path=str(out), clip=box, full_page=True)
            print(f"{label:18s} {width}px  {out.name}  {round(box['width'])}x{round(box['height'])}")
            await ctx.close()
        await browser.close()


if __name__ == "__main__":
    sys.exit(asyncio.run(main()))
