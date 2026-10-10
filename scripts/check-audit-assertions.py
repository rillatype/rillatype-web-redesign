"""A01 check: the assertions that replaced or survived the audit can actually fail.

Background. The P03, P04, P07 and P11 suites each carried a `... or True` assertion
that could never fail, so their totals counted checks that proved nothing. A01 removed
the ones that measured no requirement and replaced the ones whose requirement was real.
A PASS is only worth counting when a wrong state makes the run exit non-zero, so this
script drives the corrupted state for each retained or replacement assertion and
requires the failing outcome.

  A. Dead conditions, measured on the repository's own data.
  B. Replacement assertions against corrupted data, run through the suite that owns
     them (RILLA_CATALOG points the suite at a scratch copy) or through the same
     rendered observable where the assertion lives in a browser suite.

Nothing here edits the repository: corrupted catalogs are written to a temporary
directory and removed afterwards.

Usage: python scripts/check-audit-assertions.py [base-url]
Exit 0 only when every control behaved the way its assertion requires.
"""
import ast
import asyncio
import json
import os
import re
import shutil
import subprocess
import sys
import tempfile
from pathlib import Path

from playwright.async_api import async_playwright

sys.stdout.reconfigure(encoding="utf-8", errors="replace")

ROOT = Path(__file__).resolve().parent.parent
SRC = ROOT / "static" / "redesign"
CATALOG = SRC / "font-catalog.js"
BASE = sys.argv[1].rstrip("/") if len(sys.argv) > 1 else "http://127.0.0.1:9402/static/redesign"

FACTS_SEMIBOLD = "Chronoa SemiBold · 219 glyphs · no OpenType features"
FACTS_THIN = "Chronoa Thin · 219 glyphs · no OpenType features"

results = []
notes = []


def check(ok, label):
    results.append((bool(ok), label))
    return bool(ok)


def note(label):
    notes.append(label)


def catalog_json(path=CATALOG):
    out = subprocess.run(["node", "scripts/_p03_catalog_json.mjs", str(path)],
                         cwd=ROOT, capture_output=True, text=True, shell=True)
    return json.loads(out.stdout)


def chronoa_slice(text):
    start = text.index("['chronoa'")
    return start, text.index("}],", start)


def corrupt(kind, directory):
    """Write a scratch catalog that is wrong in exactly one way."""
    text = CATALOG.read_text(encoding="utf-8")
    if kind == "unmatched-cut-name":
        start, end = chronoa_slice(text)
        block = text[start:end].replace("label: 'Thin'", "label: 'Hairline'", 1)
        out = text[:start] + block + text[end:]
    elif kind == "duplicate-live-permalink":
        data = catalog_json()
        live = [p["permalink"] for p in data.values() if p.get("storeStatus") == "live"]
        if len(live) < 2:
            return None
        out = text.replace(live[1], live[0])
    else:
        raise ValueError(kind)
    path = Path(directory) / f"font-catalog.{kind}.js"
    path.write_text(out, encoding="utf-8")
    return path


def run_suite(command, catalog=None):
    env = dict(os.environ)
    if catalog:
        env["RILLA_CATALOG"] = str(catalog)
    done = subprocess.run(command, cwd=ROOT, capture_output=True, text=True, shell=True, env=env)
    return done.returncode, (done.stdout or "") + (done.stderr or "")


def head():
    return subprocess.run(["git", "rev-parse", "--short", "HEAD"], cwd=ROOT,
                          capture_output=True, text=True, shell=True).stdout.strip()


def last_total(out):
    """The suite's own total: child suites print theirs first."""
    totals = re.findall(r"(\d+)/(\d+) checks passed", out)
    return totals[-1] if totals else None


def dead_shapes(tree):
    """(line, kind) pairs in `tree` where an assertion cannot fail.

    Two shapes: `X or True`, and a local `check()` call whose first argument is a
    constant. Detection works on the parsed tree, so prose that mentions either
    pattern is ignored and only executable code counts.
    """
    found = []
    for node in ast.walk(tree):
        if (isinstance(node, ast.BoolOp) and isinstance(node.op, ast.Or)
                and any(isinstance(value, ast.Constant) and value.value is True
                        for value in node.values)):
            found.append((node.lineno, "X or True"))
        if (isinstance(node, ast.Call) and isinstance(node.func, ast.Name)
                and node.func.id == "check" and node.args
                and isinstance(node.args[0], ast.Constant)
                and bool(node.args[0].value)):
            # A constant first argument can never reflect what the run measured. Only
            # always-true constants count: `check(False, ...)` is the deliberate
            # always-fail idiom for a path that must never be reached.
            found.append((node.lineno, "check takes a constant that is always true"))
    return sorted(found)


def unguarded_or_true():
    """Every script that still carries a condition which cannot fail."""
    offenders = []
    bom = []
    for path in sorted((ROOT / "scripts").glob("*.py")):
        raw = path.read_bytes()
        if raw.startswith(b"\xef\xbb\xbf"):
            # Five older helper scripts carry a BOM; Python imports them fine, so parse
            # them as utf-8-sig rather than reporting them as unparsable code.
            bom.append(path.name)
        try:
            tree = ast.parse(raw.decode("utf-8-sig"))
        except SyntaxError as error:
            offenders.append(f"{path.name}: unparsable ({error})")
            continue
        for line, kind in dead_shapes(tree):
            offenders.append(f"{path.name}:{line} ({kind})")
    return offenders, bom


async def specimen_facts(page):
    return await page.evaluate(
        "() => (document.querySelector('#specimen-facts') || {}).textContent")


async def main() -> int:
    scratch = Path(tempfile.mkdtemp(prefix="a01-negative-"))
    print(f"A01 negative controls | HEAD {head()} | scratch {scratch}\n")
    try:

        offenders, bom = unguarded_or_true()
        check(not offenders,
              f"[A] no script keeps a condition that cannot fail ({offenders})")
        if bom:
            note(f"[A] helper scripts still carrying a UTF-8 BOM (parsed as utf-8-sig): {bom}")
        # The guard itself must be able to fail, or it is just another check without
        # teeth: feed it both dead shapes plus a real one and require the exact lines.
        sample = ast.parse("x = a or True\ny = check(True, 'probe')\n"
                           "z = check(value != 0, 'real')\nw = check(False, 'bad path')\n")
        check(dead_shapes(sample) == [(1, "X or True"), (2, "check takes a constant that is always true")],
              f"[A] the guard flags both dead shapes and leaves real checks alone "
              f"({dead_shapes(sample)})")
        # ------------------------------------------------ A. dead conditions
        catalog_html = (SRC / "catalog.html").read_text(encoding="utf-8")
        loaded = "font-catalog.js" in catalog_html
        check(loaded is False,
              f"[A] the removed catalog.html condition is false on real data "
              f"(font-catalog.js present: {loaded})")

        data = catalog_json()
        permalinks = [p.get("permalink", "") for p in data.values()]
        all_unique = len(permalinks) == len(set(permalinks))
        live = [p["permalink"] for p in data.values() if p.get("storeStatus") == "live"]
        note(f"permalinks: {len(permalinks)} rows, {len(set(permalinks))} unique, "
             f"{len(live)} live ({'unique' if all_unique else 'demo rows repeat a URL'})")
        note(f"[A] the removed all-rows uniqueness condition measured {all_unique} on real data; "
             f"the live-only rule below is the requirement that was actually asserted")

        css = (SRC / "editorial.css").read_text(encoding="utf-8")
        check("font-synthesis" not in css,
              "[A] no rule declares font-synthesis, so the removed page.url check read "
              "a property the page never sets")
        note(f"[A] base URL {BASE} cannot contain a CSS property name, so that check "
             f"was false by construction")

        declared = re.findall(r"label: '([^']+)'", CATALOG.read_text(encoding="utf-8"))
        files = {p.stem.replace("chronoa-", "").lower() for p in (SRC / "fonts" / "web").glob("chronoa-*.woff2")}
        raw = [n for n in declared if n.lower() in files]
        note(f"declared labels: {len(declared)}; lowercase name already in the file set: {len(raw)}")
        note("[A] the removed weight-controls condition was true on real data, so `or True` "
             "hid nothing there -- it only made the check unable to report a regression")

        # ------------------------------- B.1 replacement: declared cuts have files
        bad_name = corrupt("unmatched-cut-name", scratch)
        code, out = run_suite("python scripts/check-weight-controls.py", bad_name)
        check(code != 0 and "FAIL" in out and "has a subset on disk" in out,
              f"[B] weight-controls rejects a declared cut with no file (exit {code}, "
              f"FAIL line present: {'has a subset on disk' in out and 'FAIL' in out})")
        code, out = run_suite("python scripts/check-weight-controls.py")
        total = last_total(out)
        check(code == 0 and total and total[0] == total[1],
              f"[B] weight-controls passes on the real catalog (exit {code}, "
              f"{total[0] + '/' + total[1] if total else 'no total'})")

        # ---------------------------------- B.2 retained: live permalinks unique
        dup = corrupt("duplicate-live-permalink", scratch)
        code, out = run_suite("python scripts/_p03_verify.py", dup)
        check(code != 0 and re.search(r"FAIL +live permalinks are unique", out) is not None,
              f"[B] the retained live-permalink assertion fails on duplicated live URLs "
              f"(exit {code})")
        code, out = run_suite("python scripts/_p03_verify.py")
        total = last_total(out)
        check(code == 0 and total and total[0] == total[1],
              f"[B] the same assertion passes on the real catalog (exit {code}, "
              f"{total[0] + '/' + total[1] if total else 'no total'})")

        # --------------------------------------- browser controls (B.3 and B.4)
        async with async_playwright() as p:
            browser = await p.chromium.launch()

            # B.3 retained: the real Mango file reports as loaded (single-style suite)
            ctx = await browser.new_context(viewport={"width": 1440, "height": 900})
            page = await ctx.new_page()
            await page.route("**/mango-letter.otf", lambda r: r.abort())
            await page.goto(f"{BASE}/product.html?font=mango", wait_until="load")
            await page.wait_for_timeout(1500)
            blocked = await page.evaluate(
                "() => [...document.fonts].filter(f => f.family === 'Rilla-MangoLetters').map(f => f.status)")
            check("loaded" not in blocked,
                  f"[B] with the product file blocked the loaded-face assertion would fail "
                  f"(statuses {blocked})")
            await ctx.close()

            ctx = await browser.new_context(viewport={"width": 1440, "height": 900})
            page = await ctx.new_page()
            await page.goto(f"{BASE}/product.html?font=mango", wait_until="load")
            await page.wait_for_timeout(1500)
            ok_faces = await page.evaluate(
                "() => [...document.fonts].filter(f => f.family === 'Rilla-MangoLetters').map(f => f.status)")
            check("loaded" in ok_faces,
                  f"[B] and it passes when the file is served (statuses {ok_faces})")
            await ctx.close()

            # B.4 replacement: the facts line follows the declared default
            ctx = await browser.new_context(viewport={"width": 1440, "height": 900})
            page = await ctx.new_page()
            await page.goto(f"{BASE}/index.html", wait_until="load")
            await page.wait_for_function(
                "() => document.querySelector('#specimen-frame').dataset.state === 'ready'",
                timeout=15000)
            shipped = await specimen_facts(page)
            check(shipped == FACTS_SEMIBOLD,
                  f"[B] the shipped default cut renders its own facts ({shipped!r})")
            await ctx.close()

            ctx = await browser.new_context(viewport={"width": 1440, "height": 900})
            page = await ctx.new_page()
            patch = "{ const p = window.RillaCatalog.catalog.get('chronoa'); p.defaultStyle = 'Thin'; }"
            source = CATALOG.read_text(encoding="utf-8") + "\n" + patch
            await page.route("**/font-catalog.js", lambda r: r.fulfill(
                status=200, content_type="application/javascript", body=source))
            await page.goto(f"{BASE}/index.html", wait_until="load")
            await page.wait_for_function(
                "() => document.querySelector('#specimen-frame').dataset.state === 'ready'",
                timeout=15000)
            moved = await specimen_facts(page)
            check(moved == FACTS_THIN,
                  f"[B] moving the declared default rewrites the facts line ({moved!r})")
            check(shipped != moved,
                  "[B] the two runs differ, so the facts assertion is data-driven and can fail")
            await ctx.close()

            await browser.close()
    finally:
        shutil.rmtree(scratch, ignore_errors=True)

    passed = sum(1 for ok, _ in results if ok)
    print(f"=== A01 negative controls: {passed}/{len(results)} PASS ===\n")
    for ok, label in results:
        print(f"{'PASS' if ok else 'FAIL'}  {label}")
    for line in notes:
        print(f"note  {line}")
    return 0 if passed == len(results) else 1


if __name__ == "__main__":
    sys.exit(asyncio.run(main()))
