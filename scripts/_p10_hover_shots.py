"""P10 evidence: the replacement hover affordance, looked at before shipping.

The old hover zoom had to go (it cropped), so the gallery frame and the catalog
card now carry the feedback instead. This captures each hover state.
"""
import asyncio
from pathlib import Path

from playwright.async_api import async_playwright

BASE = "http://127.0.0.1:9402/static/redesign"
OUT = Path(__file__).resolve().parent.parent / ".impeccable" / "review"

SHOTS = [
    ("gallery-hover", "/index.html", ".gallery figure", ".gallery", 1440),
    ("gallery-hover-mobile", "/index.html", ".gallery figure", ".gallery", 390),
    ("card-hover", "/catalog.html", ".product", ".products", 1440),
    ("row-hover", "/index.html", ".row", ".index", 1440),
]


async def main():
    async with async_playwright() as p:
        browser = await p.chromium.launch()
        for label, path, target, region, width in SHOTS:
            ctx = await browser.new_context(viewport={"width": width, "height": 900})
            page = await ctx.new_page()
            await page.goto(f"{BASE}{path}", wait_until="load")
            await page.wait_for_timeout(400)
            el = page.locator(target).first
            await el.scroll_into_view_if_needed()
            await el.hover()
            await page.wait_for_timeout(500)
            box = await page.locator(region).first.bounding_box()
            out = OUT / f"P10-{label}.png"
            await page.screenshot(path=str(out), clip=box)
            print(f"{label:22s} {width}px  wrote {out.name} "
                  f"({round(box['width'])}x{round(box['height'])})")
            await ctx.close()
        await browser.close()


if __name__ == "__main__":
    asyncio.run(main())
