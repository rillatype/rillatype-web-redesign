"""P10 evidence: does the lettering in each source actually reach the edges?

C12 only means something if the artwork has content at the border: a sheet with
white margins would survive any crop. This measures the darkness (ink) in the
outermost 6px ring of every preview and per side, and writes a magnified corner
crop of two covers so the edge can be looked at instead of inferred.
"""
import pathlib

import numpy as np
from PIL import Image

ROOT = pathlib.Path(__file__).resolve().parent.parent
OUT = ROOT / ".impeccable" / "review"
RING = 6
INK = 200  # luminance below this counts as ink on the sheet


def main():
    rows = []
    for f in sorted((ROOT / "static" / "previews").glob("*.jpg")):
        im = np.asarray(Image.open(f).convert("L"), dtype=np.int16)
        h, w = im.shape
        sides = {
            "top": (im[:RING, :] < INK).mean() * 100,
            "bottom": (im[-RING:, :] < INK).mean() * 100,
            "left": (im[:, :RING] < INK).mean() * 100,
            "right": (im[:, -RING:] < INK).mean() * 100,
        }
        rows.append((f.name, w, h, sides))

    print(f"{'file':28s} {'size':10s} {'top':>7s} {'bottom':>7s} {'left':>7s} {'right':>7s}  edges with ink")
    touching = 0
    for name, w, h, s in rows:
        hits = sum(1 for v in s.values() if v > 0.5)
        touching += hits == 4
        print(f"{name:28s} {w}x{h:<6} {s['top']:6.1f}% {s['bottom']:6.1f}% "
              f"{s['left']:6.1f}% {s['right']:6.1f}%  {hits}/4")
    print(f"\n{len(rows)} previews, {touching} have ink on all four outermost edges")

    # A lookable magnified corner: if the edge pixel row is missing, the dark
    # frame on the left and top of this crop is missing too.
    for src in ("chronoa-1.jpg", "mango-1.jpg"):
        im = Image.open(ROOT / "static" / "previews" / src).convert("RGB")
        crop = im.crop((0, 0, 240, 160)).resize((960, 640), Image.NEAREST)
        out = OUT / f"P10-edge-corner-{src.replace('.jpg', '')}.png"
        crop.save(out)
        print(f"corner crop written: {out.relative_to(ROOT)}")


if __name__ == "__main__":
    main()
