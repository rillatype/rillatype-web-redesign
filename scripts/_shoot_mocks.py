"""Capture the three decision comps at desktop and mobile widths.

Usage: python scripts/_shoot_mocks.py
Writes .impeccable/mocks/decision/shots/<name>-<width>.png (full page)
"""
import asyncio, sys
from pathlib import Path
from playwright.async_api import async_playwright

ROOT = Path(__file__).resolve().parent.parent
BASE = ROOT / ".impeccable" / "mocks" / "decision"
OUT = BASE / "shots"
OUT.mkdir(parents=True, exist_ok=True)

PAGES = ["1-specimen-hall", "2-night-marquee", "3-press-grid"]
SIZES = [(1440, 900, "desktop"), (390, 844, "mobile")]


async def main():
    failures = []
    async with async_playwright() as p:
        browser = await p.chromium.launch()
        for name in PAGES:
            for w, h, tag in SIZES:
                ctx = await browser.new_context(viewport={"width": w, "height": h}, device_scale_factor=1)
                page = await ctx.new_page()
                errors = []
                page.on("console", lambda m: errors.append(f"console.{m.type}: {m.text}") if m.type == "error" else None)
                page.on("pageerror", lambda e: errors.append(f"pageerror: {e}"))
                page.on("requestfailed", lambda r: errors.append(f"requestfailed: {r.url}"))
                url = (BASE / f"{name}.html").as_uri()
                await page.goto(url, wait_until="load")
                await page.evaluate("document.fonts.ready")
                # settle entrance animation: stop CSS animation/transition clocks
                await page.add_style_tag(content="*,*::before,*::after{animation-play-state:paused!important;transition:none!important}")
                await page.wait_for_timeout(400)
                # force lazy images to decode
                await page.evaluate("""() => Promise.all(
                    [...document.images].map(i => i.complete ? null : new Promise(r => { i.onload = i.onerror = r; }))
                )""")
                meta = await page.evaluate("""() => ({
                    h: document.documentElement.scrollHeight,
                    overflow: document.documentElement.scrollWidth > window.innerWidth + 1,
                    sw: document.documentElement.scrollWidth,
                    broken: [...document.images].filter(i => !i.naturalWidth).map(i => i.getAttribute('src'))
                })""")
                path = OUT / f"{name}-{tag}.png"
                await page.screenshot(path=str(path), full_page=True)
                flag = ""
                if meta["overflow"]:
                    flag += f"  !! horizontal overflow {meta['sw']}px > {w}px"
                if meta["broken"]:
                    flag += f"  !! broken images: {meta['broken']}"
                if errors:
                    flag += f"  !! {len(errors)} page errors: {errors[:3]}"
                    failures.append((name, tag, errors))
                print(f"{name:18s} {tag:8s} {w}x{meta['h']}px -> {path.name}{flag}")
                await ctx.close()
        await browser.close()
    if failures:
        print("\nFAILURES")
        for n, t, e in failures:
            print(f"  {n} {t}: {e}")
        return 1
    print("\nAll three comps captured, zero console errors, zero broken images.")
    return 0


if __name__ == "__main__":
    sys.exit(asyncio.run(main()))
