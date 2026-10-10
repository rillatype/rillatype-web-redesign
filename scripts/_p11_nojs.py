"""P11 evidence: what the homepage looks like with JavaScript disabled.

The pickers and strips are built from data, so without JS they are absent while
the authored fallback in index.html remains. This records that state so the
progressive-enhancement boundary is known instead of assumed.
"""
import asyncio
import sys
from pathlib import Path

from playwright.async_api import async_playwright

ROOT = Path(__file__).resolve().parent.parent
OUT = ROOT / ".impeccable" / "review"
BASE = "http://127.0.0.1:9402/static/redesign"


async def main():
    async with async_playwright() as p:
        browser = await p.chromium.launch()
        ctx = await browser.new_context(viewport={"width": 1440, "height": 900}, java_script_enabled=False)
        page = await ctx.new_page()
        await page.goto(f"{BASE}/index.html", wait_until="load")
        await page.wait_for_timeout(500)
        state = {
            "cut labels": await page.locator("#cut-picker label").count(),
            "weight inputs": await page.locator("#weight-picker input").count(),
            "specimen line": (await page.locator("#specimen-line").inner_text()).strip(),
            "strips": await page.locator(".strip").count(),
            "facts": (await page.locator("#specimen-facts").inner_text()).strip(),
            "featured title": (await page.locator("#featured-title").inner_text()).strip(),
            "featured specs rows": await page.locator("#featured-specs div").count(),
            "product cards": await page.locator(".row[data-name]").count(),
        }
        for key, value in state.items():
            print(f"{key}: {value!r}")
        await page.screenshot(path=str(OUT / "P11-nojs-specimen.png"),
                              clip=await page.locator("#live-specimen").bounding_box(),
                              full_page=True)
        print("written: .impeccable/review/P11-nojs-specimen.png")
        await browser.close()


if __name__ == "__main__":
    sys.exit(asyncio.run(main()))
