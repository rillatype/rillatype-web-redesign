"""Build web-specimen subsets for the homepage live specimen.

The product page keeps the full OTF files. The homepage only needs the latin
character set a visitor can type into the live specimen, so each cut is
subset and shipped as WOFF2 next to the originals.

Usage: python scripts/build-font-subsets.py
"""
import sys
from pathlib import Path
from fontTools import subset

ROOT = Path(__file__).resolve().parent.parent
SRC = ROOT / "static" / "redesign" / "fonts"
OUT = ROOT / "static" / "redesign" / "fonts" / "web"
MANGO = ROOT / "static" / "previews" / "mango-letter.otf"

# Everything a visitor can realistically type into the specimen.
UNICODES = (
    "U+0020-007E,"          # basic latin
    "U+00A0-00FF,"          # latin-1 supplement
    "U+2010-2015,"          # hyphens and dashes
    "U+2018-201D,"          # curly quotes
    "U+2022,U+2026,U+2039,U+203A,"
    "U+20AC,U+00A3,U+00A5,U+20A9,"
    "U+00B0,U+00BD,U+00BC,U+00BE,"
    "U+2190-2193,U+00D7,U+00F7"
)


def build(src: Path, dest: Path, family: str) -> tuple[int, int]:
    dest.parent.mkdir(parents=True, exist_ok=True)
    args = [
        str(src),
        f"--unicodes={UNICODES}",
        "--layout-features=*",
        "--flavor=woff2",
        "--no-hinting",
        "--desubroutinize",
        f"--output-file={dest}",
    ]
    subset.main(args)
    return src.stat().st_size, dest.stat().st_size


def main() -> int:
    rows = []
    for src in sorted(SRC.glob("*.otf")):
        weight = src.stem.replace("Chronoa-", "").lower()
        dest = OUT / f"chronoa-{weight}.woff2"
        a, b = build(src, dest, "Chronoa")
        rows.append((f"Chronoa {weight}", a, b))
    if MANGO.exists():
        a, b = build(MANGO, OUT / "mango-letters.woff2", "Mango")
        rows.append(("Mango Letters", a, b))

    print(f"{'cut':22s} {'otf':>8s} {'woff2':>8s}  saved")
    total_a = total_b = 0
    for name, a, b in rows:
        total_a += a
        total_b += b
        print(f"{name:22s} {a / 1024:7.1f}K {b / 1024:7.1f}K  {100 - b * 100 / a:5.1f}%")
    print(f"{'TOTAL':22s} {total_a / 1024:7.1f}K {total_b / 1024:7.1f}K  {100 - total_b * 100 / total_a:5.1f}%")
    return 0


if __name__ == "__main__":
    sys.exit(main())
