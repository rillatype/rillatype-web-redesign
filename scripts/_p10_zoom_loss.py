"""P10 evidence: how much visible design the pre-fix hover zoom discarded.

The old rules scaled the artwork by 1.025 (catalog cards) or 1.03 (gallery) and
the parent clipped it, so 1.25% / 1.5% of the source was lost on every side.
A flat paper margin disappearing is harmless; a band that carries colour or
lettering is a real defect. This measures the band each zoom discarded: its
luminance spread (flat margin vs content), and its share of the sheet's ink.

Also writes an outlined copy of one cover so the discarded band is lookable.
"""
import pathlib

import numpy as np
from PIL import Image, ImageDraw

ROOT = pathlib.Path(__file__).resolve().parent.parent
OUT = ROOT / ".impeccable" / "review"
INK = 200


def main():
    print(f"{'file':28s} {'zoom 1.025 band (L/R/T/B px)':30s} {'std':>6s} {'ink in band':>12s}")
    discarded = []
    rows = []
    for f in sorted((ROOT / "static" / "previews").glob("*.jpg")):
        im = np.asarray(Image.open(f).convert("L"), dtype=np.int16)
        h, w = im.shape
        # scale(1.025): the painted image is 2.5% larger, centred, then clipped.
        # Each side therefore loses 1.25% of the source.
        bx = int(round(w * 0.0125))
        by = int(round(h * 0.0125))
        band = np.concatenate([
            im[:, :bx].ravel(), im[:, -bx:].ravel(),
            im[:by, :].ravel(), im[-by:, :].ravel(),
        ])
        total_ink = (im < INK).mean() * 100
        band_ink = (band < INK).mean() * 100
        std = float(band.std())
        rows.append((f, w, h, bx, by, std, band_ink, total_ink))
        if std > 6.0:
            discarded.append(f.name)
        print(f"{f.name:28s} {bx} / {bx} / {by} / {by:<24} {std:6.1f} {band_ink:11.1f}%")

    print(f"\n{len(rows)} previews; {len(discarded)} have a non-flat band (std > 6) "
          f"that the old zoom cut away:")
    print("  " + ", ".join(discarded))

    # Lookable proof: outline the discarded band on the worst offender.
    worst = max(rows, key=lambda r: r[5])
    f, w, h, bx, by, _, _, _ = worst
    im = Image.open(f).convert("RGB")
    d = ImageDraw.Draw(im)
    d.rectangle([0, 0, w - 1, h - 1], outline=(255, 0, 0), width=4)
    d.rectangle([bx, by, w - 1 - bx, h - 1 - by], outline=(255, 0, 0), width=3)
    out = OUT / f"P10-discarded-band-{f.stem}.png"
    im.save(out)
    print(f"\nworst offender: {f.name} (band std {worst[5]:.1f}); "
          f"red frame = the 1.25% per side the old hover zoom discarded")
    print(f"written: {out.relative_to(ROOT)}")


if __name__ == "__main__":
    main()
