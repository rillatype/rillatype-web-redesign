"""P02 acceptance check: inventory evidence, C01-C12 mapping, scope.

Usage: python scripts/_p02_verify.py
Exit 0 only when every P02 acceptance criterion has evidence.
"""
import re
import subprocess
import sys
from pathlib import Path

ROOT = Path(__file__).resolve().parent.parent
INV = (ROOT / "docs" / "redesign" / "reference-inventory.md").read_text(encoding="utf-8")
REPORT = (ROOT / "docs" / "reports" / "P02.md").read_text(encoding="utf-8")
PROGRESS = (ROOT / "PROGRESS.md").read_text(encoding="utf-8")

results = []


def check(ok, label):
    results.append((bool(ok), label))
    return bool(ok)


def run(cmd):
    return subprocess.run(cmd, cwd=ROOT, capture_output=True, text=True, shell=True)


# --- 1. every claim is sourced and dated
check("## Cara observasi dan batasnya" in INV, "inventory states its observation method")
check("10 Oktober 2026" in INV, "inventory carries the observation date")
urls = set(re.findall(r"https://rillatype\.com(?:/[^\s)|`]*)?", INV))
check(len(urls) >= 15, f"inventory cites live URLs per product (found {len(urls)} unique)")
check("https://rillatype.com/" in INV, "the homepage is cited as a source")
check(not any(u.endswith(".") for u in urls), "no canonical URL has a trailing dot")
check("wp-content/uploads" in INV, "inventory records image sources")

# --- 2. required facts per product row
for field in ["Slug", "Nama terlihat", "SKU", "Harga low–high", "Variasi lisensi", "Gambar utama", "Gambar terdaftar"]:
    check(field in INV, f"product table has a {field} column")
check("1200x800" in INV and "1.500" in INV, "image dimensions are measured and recorded")
check("14 URL" in REPORT or "12 URL" in REPORT, "report states how many URLs were read")
check("belum dibaca" in INV, "unread pages are marked rather than invented")

# --- 3. public observation separated from staging data
check("menunggu staging" in INV or "Menunggu staging" in INV, "staging-dependent data is separated")
missing = INV[INV.find("## Yang belum terverifikasi"):]
check("W03" in missing and "W04" in missing, "unverified data names the owning tasks")
check("Tidak ada login" in INV or "tidak ada login" in INV, "observation states it performed no logged-in action")

# --- 4. C01-C12 mapping complete, C03 resolved, C11 honest
mapping = INV[INV.find("## Pemetaan contoh wajib C01"):INV.find("## Aset demo lokal")]
for n in range(1, 13):
    check(f"| C{n:02d} |" in mapping, f"C{n:02d} is mapped")
check("TERSEDIA" in mapping, "C03 Sans + Script is resolved as available with samples")
for sample in ["Dockhand", "Highway Patrol"]:
    check(sample in mapping, f"C03 sample recorded: {sample}")
check("BUTUH BUKTI" in mapping, "C11 is marked as needing evidence rather than filled with a wrong sample")

# --- 5. demo assets flagged, no invented prices
check("DEMO, bukan produk nyata terkonfirmasi" in INV, "placeholder brush/bundle/graphic assets are flagged as demo")
for slug in ["brush-set-1", "font-bundle-1", "graphic-pack-1"]:
    check(slug in INV, f"demo asset named: {slug}")
check("bukan konstanta" in INV, "the Redline variation prices are labelled as case evidence, not constants")
check("Demo" in INV, "prototype prices keep the Demo label rule")

# --- 6. no transaction, no draft licence published
check("Belum boleh ditampilkan sebagai ketentuan resmi" in INV or "belum boleh ditampilkan sebagai ketentuan resmi" in INV,
      "the Graphics licence draft is not published as terms")

# --- 7. tracker and scope
check("| Simpan inventaris referensi yang benar | SELESAI |" in PROGRESS, "P02 is closed in PROGRESS.md")
check("docs/reports/P02.md" in PROGRESS, "PROGRESS.md links the P02 report")

status = run("git status --short").stdout
changed = [line[3:].strip() for line in status.splitlines() if line.strip()]
# The scope check reads the working tree, so a later task's prototype edits look
# like P02 drift. Pass --scope-only=docs,scripts,_p02,PROGRESS.md to check just P02's work.
scope = next((a.split("=", 1)[1] for a in sys.argv if a.startswith("--scope-only=")), None)
changed_scope = changed
if scope:
    prefixes = tuple(scope.split(","))
    changed_scope = [p for p in changed if p.startswith(prefixes)]
website = [p for p in changed_scope if p.startswith(("static/", "rillatype-v2-extracted/", "wp-content/")) or p.endswith((".php", ".css", ".js", ".json", ".html"))]
check(not website, f"no website source changed inside P02 scope (found {website})")
allowed = {"PROGRESS.md", "docs/reports/P01.md", "docs/reports/P02.md", "docs/reports/P03.md", "docs/redesign/reference-inventory.md", "debug.log"}
unexpected = [p for p in changed_scope if p not in allowed and not p.startswith(("scripts/_p0", "scripts/check-"))]
check(not unexpected, f"only P02 scope changed (unexpected {unexpected})")
check(run("git diff --check").returncode == 0, "git diff --check is clean")

# --- 8. report completeness
for heading in ["## Kondisi terakhir", "## Hasil yang wajib dicapai", "## Log unit kerja", "## Handoff", "## Daftar selesai"]:
    check(heading in REPORT, f"report has {heading}")
check(REPORT.count("### 2026-") >= 4, f"report logs every unit (found {REPORT.count('### 2026-')})")
check("Task berikutnya yang siap" in REPORT and "P03" in REPORT, "report names P03 as the next ready task")

failed = 0
for ok, label in results:
    print(f"{'PASS' if ok else 'FAIL'}  {label}")
    failed += 0 if ok else 1
print(f"\n{len(results) - failed}/{len(results)} checks passed")
sys.exit(1 if failed else 0)
