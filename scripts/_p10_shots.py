"""P10 evidence: full-page captures of the three pages at desktop and mobile.

Writes to .impeccable/review/ (gitignored). Also prints the full-page height and
a pixel diff against the committed R05H screenshots, so an unintended layout
shift from the artwork rules shows up as a number and not just an impression.
"""
import asyncio
import sys
from pathlib import Path

import numpy as np
from PIL import Image
from playwright.async_api import async_playwright

BASE = "http://127.0.0.1:9402/static/redesign"
ROOT = Path(__file__).resolve().parent.parent
OUT = ROOT / ".impeccable" / "review"
PREFIX = sys.argv[1] if len(sys.argv) > 1 else "P10"
OUT.mkdir(parents=True, exist_ok=True)
SHOTS = [
    ("home", "/index.html", "rillatype-home"),
    ("catalog", "/catalog.html", "rillatype-catalog"),
    ("product", "/product.html?font=chronoa", "rillatype-product"),
]


def diff(a: Path, b: Path):
    ia, ib = Image.open(a).convert("RGB"), Image.open(b).convert("RGB")
    if ia.size != ib.size:
        return None
    d = np.abs(np.asarray(ia, dtype=np.int16) - np.asarray(ib, dtype=np.int16))
    return float(d.mean()), float((d.max(axis=2) > 24).mean() * 100)


async def main():
    async with async_playwright() as p:
        browser = await p.chromium.launch()
        for label, path, stem in SHOTS:
            for mode, w, h in (("desktop", 1440, 900), ("mobile", 390, 844)):
                ctx = await browser.new_context(viewport={"width": w, "height": h})
                page = await ctx.new_page()
                errors = []
                page.on("pageerror", lambda e: errors.append(str(e)))
                page.on("console", lambda m: errors.append(m.text) if m.type == "error" else None)
                await page.goto(f"{BASE}{path}", wait_until="load")
                await page.wait_for_timeout(500)
                await page.evaluate("""async () => {
                  for (let y = 0; y < document.body.scrollHeight; y += 600) {
                    window.scrollTo(0, y); await new Promise(r => setTimeout(r, 40));
                  }
                  window.scrollTo(0, 0); await new Promise(r => setTimeout(r, 60));
                }""")
                out = OUT / f"{PREFIX}-{label}-{mode}.png"
                await page.screenshot(path=str(out), full_page=True)
                size = Image.open(out).size
                base = OUT / f"PRE-{label}-{mode}.png"
                if PREFIX == "PRE":
                    base = None
                note = "no PRE baseline captured"
                if base.exists():
                    d = diff(base, out)
                    note = ("same size, identical pixels" if d and d[1] == 0
                            else f"mean {d[0]:.2f}, {d[1]:.2f}% of pixels changed"
                            if d else f"size changed {Image.open(base).size} -> {size}")
                print(f"{label:8s} {mode:8s} {size[0]}x{size[1]:<6} errors={len(errors)}  vs PRE-P10: {note}")
                if errors:
                    print("   ERROR:", errors[0][:120])
                await ctx.close()
        await browser.close()


if __name__ == "__main__":
    sys.exit(asyncio.run(main()))
