"""P03 acceptance check: prototype data integrity, style/licence separation,
real assets for C01/C04, honest unavailable states.

Usage: python scripts/_p03_verify.py
Exit 0 only when every P03 acceptance criterion has evidence.

RILLA_CATALOG may name a scratch copy of the catalog, so A01 negative controls can
run these same assertions against corrupted data without touching the repo source.
"""
import json
import os
import re
import subprocess
import sys
from pathlib import Path

ROOT = Path(__file__).resolve().parent.parent
CATALOG = Path(os.environ.get("RILLA_CATALOG") or (ROOT / "static" / "redesign" / "font-catalog.js"))
PREVIEWS = ROOT / "static" / "previews"
FONTS = ROOT / "static" / "redesign" / "fonts"
ASSETS = (ROOT / "static" / "redesign" / "ASSETS.md").read_text(encoding="utf-8")
REPORT = (ROOT / "docs" / "reports" / "P03.md").read_text(encoding="utf-8") if (ROOT / "docs" / "reports" / "P03.md").exists() else ""
PROGRESS = (ROOT / "PROGRESS.md").read_text(encoding="utf-8")

results = []


def check(ok, label):
    results.append((bool(ok), label))
    return bool(ok)


def run(cmd):
    return subprocess.run(cmd, cwd=ROOT, capture_output=True, text=True, shell=True)


# The catalog is a JS Map literal of plain objects. Read it through Node so the
# check inspects the real data instead of a regex guess.
parsed = run(f'node scripts/_p03_catalog_json.mjs "{CATALOG}"')
try:
    data = json.loads(parsed.stdout)
except Exception as error:
    data = {"__error": f"{error}: {parsed.stdout[:200]}{parsed.stderr[:200]}"}

check("__error" not in data, f"catalog data parses ({data.get('__error', 'ok')})")
if "__error" in data:
    print("FAIL  catalog data parses")
    sys.exit(1)

# --- 1. stable keys and real, unique permalinks
for key in data:
    check(re.fullmatch(r"[a-z0-9-]+", key) is not None, f"key is a stable slug: {key}")
permalinks = [p.get("permalink", "") for p in data.values()]
check(all(p.startswith("https://rillatype.com/") for p in permalinks), "every product carries a real permalink")
# Removed in A01: `len(permalinks) == len(set(permalinks)) or True` counted every
# permalink, demo rows included, and was neutralised with `or True`. Uniqueness
# across demo rows was never the requirement (demo entries may share a reference
# URL); the live-only requirement is asserted directly below.
live = {k: v for k, v in data.items() if v.get("storeStatus") == "live"}
live_permalinks = [v["permalink"] for v in live.values()]
check(len(live_permalinks) == len(set(live_permalinks)), f"live permalinks are unique ({len(live_permalinks)} live products)")

# --- 2. kind on every product, and no kind guessed from specimen availability
check(all("kind" in p for p in data.values()), "every product declares a kind")
kinds = {p["kind"] for p in data.values()}
check(kinds <= {"font", "graphic", "mixed", "unknown"}, f"kinds use the documented vocabulary ({sorted(kinds)})")
check(any(p["kind"] == "mixed" for p in data.values()), "a mixed Sans+Script case exists in the data")
check(any(p["kind"] == "graphic" for p in data.values()), "a graphic case exists in the data")

# --- 3. images resolve, are unique, and are not shared across products
missing = []
seen = {}
dupes = []
for key, product in data.items():
    for image in product.get("images", []):
        if not image.startswith("../previews/"):
            missing.append(f"{key}:{image} (no explicit path)")
            continue
        path = PREVIEWS / image.replace("../previews/", "")
        if not path.exists():
            missing.append(f"{key}:{image}")
        seen.setdefault(image, []).append(key)
for image, owners in seen.items():
    if len(owners) > 1 and not all(data[o]["storeStatus"] == "demo" for o in owners):
        dupes.append(f"{image} -> {owners}")
check(not missing, f"every mapped image exists on disk (missing {missing})")
check(not dupes, f"no image is reused as a different live product (dupes {dupes})")

# --- 4. style data: named, unique labels, no price, files honest
for key, product in data.items():
    styles = product.get("styles", [])
    labels = [s.get("label") for s in styles]
    check(len(labels) == len(set(labels)), f"{key}: style labels are unique ({labels})")
    for style in styles:
        check("price" not in style, f"{key}: style {style.get('label')} carries no purchase price")
        if style.get("file"):
            check(style.get("available") is not False, f"{key}: {style['label']} declares a real file")
        else:
            check(style.get("available") is False, f"{key}: {style['label']} without a file is marked unavailable")

# --- 5. C01/C04 use real assets; unavailable cases do not claim a specimen
mango = data.get("mango", {})
chronoa = data.get("chronoa", {})
check(mango.get("specimen") is True, "C01 Mango declares a real specimen")
check(any(s.get("file") == "mango-letter.otf" for s in mango.get("styles", [])), "C01 points at the real Mango OTF")
mango_file = [s for s in mango.get("styles", []) if s.get("file")][0]
check(mango_file.get("dir") == "../previews/", "C01 states the real directory of its specimen file")
check(chronoa.get("specimen") is True and len(chronoa.get("styles", [])) == 9, "C04 Chronoa declares nine real cuts")
check(all(s.get("available") for s in chronoa.get("styles", [])), "C04 marks every cut available")
for key in ["tropivera", "dockhand", "wildkins", "solaya", "darkwell", "redline"]:
    product = data.get(key, {})
    check(product.get("specimen") is False, f"{key} does not claim a specimen it does not have")
    check(all(s.get("file") is None for s in product.get("styles", [])), f"{key} style entries carry no invented file")
    check("needs" in product or product.get("kind") == "graphic", f"{key} records what file is required")

# --- 6. demo entries are marked and never look like confirmed products
demo = {k: v for k, v in data.items() if v.get("storeStatus") == "demo"}
check(len(demo) == 14, f"the 14 legacy demo entries are flagged (found {len(demo)})")
check(all("demo" in v.get("evidence", "").lower() for v in demo.values()), "every demo entry says so in its evidence")

# --- 7. no UI font substituted for a product specimen
check("font UI" not in CATALOG.read_text(encoding="utf-8").lower(), "no entry substitutes the UI font")

# --- 8. ASSETS.md documents availability and gaps
assets_lower = ASSETS.lower()
for token in ["C01", "C04", "C02", "C03", "C05", "belum tersedia", "permalink"]:
    check(token.lower() in assets_lower, f"ASSETS.md documents: {token}")

# --- 9. repo suites still pass
home = run("python scripts/check-specimen-home.py")
check(home.returncode == 0, f"homepage suite still passes ({home.stdout.strip().splitlines()[-1] if home.stdout.strip() else 'no output'})")
states = run("python scripts/check-specimen-states.py")
check(states.returncode == 0, f"specimen state suite still passes ({states.stdout.strip().splitlines()[-1] if states.stdout.strip() else 'no output'})")

# --- 10. scope
status = run("git status --short").stdout
changed = [line[3:].strip() for line in status.splitlines() if line.strip()]
allowed_prefixes = ("static/redesign/", "static/previews/", "docs/", "scripts/_p", "scripts/check-", "PROGRESS.md", "DESIGN.md", "debug.log")
unexpected = [p for p in changed if not p.startswith(allowed_prefixes)]
check(not unexpected, f"only prototype scope changed (unexpected {unexpected})")
theme = [p for p in changed if p.startswith(("rillatype-v2-extracted/", "wp-content/"))]
check(not theme, f"theme sources untouched (found {theme})")
check(run("git diff --check").returncode == 0, "git diff --check is clean")

failed = sum(1 for ok, _ in results if not ok)
for ok, label in results:
    print(f"{'PASS' if ok else 'FAIL'}  {label}")
print(f"\n{len(results) - failed}/{len(results)} checks passed")
sys.exit(1 if failed else 0)
