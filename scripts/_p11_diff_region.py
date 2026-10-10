"""P11 evidence: which pixels changed on the homepage, and are they only the label?

The rewrite changed one thing on purpose: the Mango label in the cut picker was
the only control label with a per-font class (font-weight 400, letter-spacing 0,
and a checked state that set it in Chronoa). It now uses the same control
typography as every other label. This finds the bounding box of every changed
pixel and compares it with the bounding box of that label, so the claim is
checked against pixels instead of assumed.
"""
import asyncio
import sys
from pathlib import Path

import numpy as np
from PIL import Image
from playwright.async_api import async_playwright

ROOT = Path(__file__).resolve().parent.parent
OUT = ROOT / ".impeccable" / "review"
BASE = "http://127.0.0.1:9402/static/redesign"
PAIRS = [("home", "desktop", 1440, 900), ("home", "mobile", 390, 844)]


def changed_box(before: Path, after: Path):
    a = np.asarray(Image.open(before).convert("RGB"), dtype=np.int16)
    b = np.asarray(Image.open(after).convert("RGB"), dtype=np.int16)
    if a.shape != b.shape:
        return None, 0
    mask = np.abs(a - b).max(axis=2) > 8
    count = int(mask.sum())
    if not count:
        return None, 0
    ys, xs = np.where(mask)
    return (int(xs.min()), int(ys.min()), int(xs.max()), int(ys.max())), count


async def main():
    async with async_playwright() as p:
        browser = await p.chromium.launch()
        for label, mode, width, height in PAIRS:
            before = OUT / f"P11PRE-{label}-{mode}.png"
            after = OUT / f"P11POST-{label}-{mode}.png"
            box, count = changed_box(before, after)
            print(f"\n{label}/{mode}: {count} changed pixels, bounding box {box}")
            ctx = await browser.new_context(viewport={"width": width, "height": height})
            page = await ctx.new_page()
            await page.goto(f"{BASE}/index.html", wait_until="load")
            await page.wait_for_timeout(600)
            labels = await page.evaluate("""() => [...document.querySelectorAll('#cut-picker label span')]
                .map(el => { const r = el.getBoundingClientRect();
                  return { text: el.textContent, x: Math.round(r.x), y: Math.round(r.y + window.scrollY),
                           w: Math.round(r.width), h: Math.round(r.height) }; })""")
            for item in labels:
                print(f"   label {item['text']!r}: x {item['x']}..{item['x'] + item['w']}, "
                      f"y {item['y']}..{item['y'] + item['h']}, width {item['w']}")
            if box:
                x0, y0, x1, y1 = box
                # The fieldset is right-aligned, so widening one label shifts the
                # other. The honest unit to test is the whole label row.
                left = min(item["x"] for item in labels)
                right = max(item["x"] + item["w"] for item in labels)
                top = min(item["y"] for item in labels)
                bottom = max(item["y"] + item["h"] for item in labels)
                m = 3
                inside = (x0 >= left - m and x1 <= right + m
                          and y0 >= top - m and y1 <= bottom + m)
                print(f"   row spans x {left}..{right}, y {top}..{bottom}")
                print(f"   changed pixels inside the cut-picker label row: {inside}")
                print(f"   changed pixels inside one single label: "
                      f"{[item['text'] for item in labels if x0 >= item['x'] - m and x1 <= item['x'] + item['w'] + m and y0 >= item['y'] - m and y1 <= item['y'] + item['h'] + m]}")
            await ctx.close()
        await browser.close()


if __name__ == "__main__":
    sys.exit(asyncio.run(main()))
