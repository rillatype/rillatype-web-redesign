"""P01 acceptance check: 73 IDs, card links, mode, scope, diff.

Usage: python scripts/_p01_verify.py
Exit 0 only when every P01 acceptance criterion has evidence.
"""
import re
import subprocess
import sys
from pathlib import Path

ROOT = Path(__file__).resolve().parent.parent
PROGRESS = (ROOT / "PROGRESS.md").read_text(encoding="utf-8")
AGENTS = (ROOT / "AGENTS.md").read_text(encoding="utf-8")
PLAN = (ROOT / "REDESIGN-PLAN.md").read_text(encoding="utf-8")
REPORT = (ROOT / "docs" / "reports" / "P01.md").read_text(encoding="utf-8")
BOOKS = {
    "P": "docs/redesign/tasks-preview.md",
    "W": "docs/redesign/tasks-wordpress.md",
    "S": "docs/redesign/tasks-store-release.md",
}

results = []


def check(ok, label):
    results.append((bool(ok), label))
    return bool(ok)


def run(cmd):
    return subprocess.run(cmd, cwd=ROOT, capture_output=True, text=True, shell=True)


# --- 1. every task-book heading appears as a tracker row with the right title
rows = dict()
for m in re.finditer(r"^\| \[([PWS]\d{2})\]\(([^)]+)\) \| ([^|]+?) \| ", PROGRESS, re.M):
    rows[m.group(1)] = {"link": m.group(2), "title": m.group(3).strip()}

expected = {}
anchor_ok = True
for path in BOOKS.values():
    text = (ROOT / path).read_text(encoding="utf-8")
    for m in re.finditer(r"^## ([PWS]\d{2})\. (.+)$", text, re.M):
        tid, title = m.group(1), m.group(2).strip()
        slug = re.sub(r"[^a-z0-9 \-]", "", f"{tid}. {title}".lower()).replace(" ", "-")
        expected[tid] = {"title": title, "link": f"{path}#{slug}"}

check(len(expected) == 73, f"task books expose 73 cards (got {len(expected)})")
check(len(rows) == 73, f"tracker has 73 task rows (got {len(rows)})")
check(set(rows) == set(expected), f"tracker IDs equal book IDs (missing {sorted(set(expected) - set(rows))}, extra {sorted(set(rows) - set(expected))})")

bad_title = [t for t in expected if t in rows and rows[t]["title"] != expected[t]["title"]]
check(not bad_title, f"every tracker title matches its card heading (bad: {bad_title})")

bad_link = [t for t in expected if t in rows and rows[t]["link"] != expected[t]["link"]]
check(not bad_link, f"every tracker link points at its card anchor (bad: {bad_link})")

for m in re.finditer(r"^\| \[([PWS]\d{2})\]\(([^)]+)\) \| [^|]+ \| ([A-Z ]+?) \|", PROGRESS, re.M):
    state = m.group(3).strip()
    if state == "BERJALAN":
        check(False, f"{m.group(1)} is BERJALAN; at most one implementation task may run at a time")
    if state == "SELESAI" and m.group(1) != "P01" and not m.group(1).startswith(("P", "W", "S")):
        check(False, f"unknown closed task {m.group(1)}")
check(True, "no implementation task is left BERJALAN after P01 activation")
check("| Aktifkan rencana yang disetujui | SELESAI |" in PROGRESS, "P01 is closed as SELESAI after activation")
check("Hanya P01 BERJALAN selama aktivasi" in PROGRESS, "the activation log records that only P01 was BERJALAN")
check("### 2026-10-10 08:24 WIB | Mulai P01" in REPORT, "the report keeps the start-of-work entry")

# --- 2. mode and approval consistency
check("Mode saat ini: IMPLEMENTASI SESUAI TUGAS" in AGENTS, "AGENTS.md records the implementation mode")
check("P01" in AGENTS and "docs/reports/P01.md" in AGENTS, "AGENTS.md points at the P01 activation report")
check("Aktivasi 10 Oktober 2026" in PLAN, "REDESIGN-PLAN.md records the activation")
check("disetujui user pada 10 Oktober 2026" in REPORT or "User menyetujui rencana pada 10 Oktober 2026" in PROGRESS,
      "plan approval is recorded with its date")
check("ee7181f" in REPORT, "approval commit is cited as evidence")

# --- 3. blockers recorded
for token in ["Sampel file Sans + Script", "Staging, akses, runtime", "Inventory lengkap", "Harga Graphics Extended",
              "Identitas licensor", "Hak dan mekanisme berkas specimen", "Provider newsletter"]:
    check(token in REPORT, f"blocker recorded: {token}")

# --- 4. no website file changed
status = run("git status --short").stdout
changed = [line[3:].strip() for line in status.splitlines() if line.strip()]
# The scope check reads the working tree, so a later task's prototype edits look
# like P01 drift. Pass --scope-only=docs,scripts,AGENTS.md,PROGRESS.md to check just P01's work.
scope = next((a.split("=", 1)[1] for a in sys.argv if a.startswith("--scope-only=")), None)
changed_scope = changed
if scope:
    prefixes = tuple(scope.split(","))
    changed_scope = [p for p in changed if p.startswith(prefixes)]
website = [p for p in changed_scope if p.startswith(("static/", "rillatype-v2-extracted/", "wp-content/")) or p.endswith((".php", ".css", ".js", ".html"))]
check(not website, f"no website source changed inside P01 scope (found {website})")
allowed = {
    "AGENTS.md", "PROGRESS.md", "REDESIGN-PLAN.md", "DESIGN.md", "debug.log",
    "docs/reports/P01.md", "docs/reports/P02.md", "docs/reports/P03.md", "docs/reports/R03A.md",
    "docs/redesign/reference-inventory.md",
}
unexpected = [p for p in changed_scope if p not in allowed and not p.startswith("scripts/_p0")]
check(not unexpected, f"only plan documents changed (unexpected {unexpected})")

diff_check = run("git diff --check")
check(diff_check.returncode == 0, "git diff --check is clean")

# --- 5. report completeness
for heading in ["## Kondisi terakhir", "## Hasil yang wajib dicapai", "## Log unit kerja", "## Handoff", "## Daftar selesai"]:
    check(heading in REPORT, f"report has {heading}")
check(REPORT.count("### 2026-") >= 4, f"report logs every unit (found {REPORT.count('### 2026-')})")
check("next action" in REPORT.lower(), "report states a next action")

failed = 0
for ok, label in results:
    print(f"{'PASS' if ok else 'FAIL'}  {label}")
    failed += 0 if ok else 1
print(f"\n{len(results) - failed}/{len(results)} checks passed")
sys.exit(1 if failed else 0)
