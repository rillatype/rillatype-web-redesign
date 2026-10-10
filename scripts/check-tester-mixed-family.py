"""P06 check: the mixed Sans + Handwritten family (case C03, Mondriel).

The card and docs/redesign/font-test-handoff.md ask for five real style files, each
with its own identity, proven in the browser. The five Mondriel files share weight
400 and the typographic family `RT Mondriel`, so a FontFace descriptor cannot tell
them apart; the data carries a `faceFamily` per style instead. This suite proves the
result and refuses the failure mode that matters:

  A. files      - the five specimens exist, are big enough to be real, and still
                  hash-match the user's source when that folder is present.
  B. identity   - five styles, five files, five loaded faces; sample, glyph grid,
                  status, and character count follow the active style at 1440 and 390.
  C. distinct   - the five rendered samples differ pairwise in pixels, so a build
                  where every style shares one face cannot pass.
  D. round trip - text, size, leading, tracking, alignment, theme, and license
                  survive every switch; clear and retype keep the style.
  E. failure    - Outline Slant is aborted, named in the error state, retried without
                  a reload, and then loads its own file.
  F. race       - Handwritten is released late, after the newest Regular is ready;
                  the stale response must not overwrite the newest facts.
  G. dockhand   - the remaining unavailable case: no files, no tester, no selector.
  H. control    - a catalog override that points all five styles at one file has to
                  fail the same measurement section B passes on the real data.

Usage: python scripts/check-tester-mixed-family.py [base-url]
Exit 0 when every assertion passes, 1 when any fails.
"""
import asyncio
import hashlib
import io
import itertools
import re
import sys
from pathlib import Path

from PIL import Image, ImageChops
from playwright.async_api import async_playwright

sys.stdout.reconfigure(encoding="utf-8", errors="replace")

ROOT = Path(__file__).resolve().parent.parent
FONTS = ROOT / "static" / "redesign" / "fonts"
SOURCE = ROOT / "Font Test" / "Mondriel-Font-Duo" / "Fonts"
BASE = sys.argv[1].rstrip("/") if len(sys.argv) > 1 else "http://127.0.0.1:9402/static/redesign"

results = []
notes = []

# (label, local file, face family, characters shown, source file in Font Test/)
EXPECTED = [
    ("Regular", "Mondriel-Regular.otf", "RT Mondriel", 194, "RT Mondriel-Regular.otf"),
    ("Slant", "Mondriel-Slant.otf", "RT Mondriel Slant", 194, "RT Mondriel-Slant.otf"),
    ("Outline", "Mondriel-Outline.otf", "RT Mondriel Outline", 194, "RT Mondriel-Outline.otf"),
    ("Outline Slant", "Mondriel-OutlineSlant.otf", "RT Mondriel Outline Slant", 194, "RT Mondriel-Outline Slant.otf"),
    ("Handwritten", "Mondriel-Handwritten.otf", "RT Mondriel handwritten", 187, "RT Mondriel-Handwritten.otf"),
]
SAMPLE = "Aa Bb Cc 123"

READ_STYLE = """() => {
  const one = s => document.querySelector(s);
  const txt = s => { const el = one(s); return el ? (el.textContent || '').trim() : null; };
  const out = one('#sample-output');
  const cells = [...document.querySelectorAll('#glyph-grid .glyph-cell')];
  const sw = id => { const el = one(id); return el ? { disabled: el.disabled, checked: el.checked } : null; };
  const note = id => { const el = one(id); const n = el ? el.querySelector('.switch-note') : null; return n ? n.textContent.trim() : null; };
  const checked = name => { const el = one(`input[name="${name}"]:checked`); return el ? el.value : null; };
  return {
    status: txt('#font-status'),
    selected: one('#sample-style') ? one('#sample-style').value : null,
    options: [...document.querySelectorAll('#sample-style option')].map(o => o.textContent),
    styleFieldHidden: one('#style-field') ? one('#style-field').hidden : null,
    weightPicker: !!one('#weight-picker, input[name="weight"]'),
    frameHidden: one('#tester-frame') ? one('#tester-frame').hidden : null,
    frameState: one('#tester-frame') ? (one('#tester-frame').dataset.state || '') : null,
    retryHidden: one('#retry-font') ? one('#retry-font').hidden : null,
    sampleFamily: out ? getComputedStyle(out).fontFamily : null,
    sampleWeight: out ? getComputedStyle(out).fontWeight : null,
    sampleText: out ? (out.textContent || '') : null,
    sampleSize: out ? getComputedStyle(out).fontSize : null,
    sampleLeading: out ? getComputedStyle(out).lineHeight : null,
    sampleTracking: out ? getComputedStyle(out).letterSpacing : null,
    sampleAlign: out ? (out.dataset.align || '') : null,
    stageTheme: one('#tester-stage') ? (one('#tester-stage').dataset.theme || '') : null,
    license: checked('license'),
    glyphCount: txt('#glyph-count'),
    glyphCells: cells.length,
    cellFamily: cells.length ? getComputedStyle(cells[0]).fontFamily : null,
    cellWeight: cells.length ? getComputedStyle(cells[0]).fontWeight : null,
    gridCut: one('#glyph-grid') ? (one('#glyph-grid').dataset.cut || '') : '',
    liga: sw('#opentype-liga'), dlig: sw('#opentype-dlig'), salt: sw('#opentype-salt'),
    dligNote: note('#dlig-switch'),
    loadedFaces: [...document.fonts].filter(f => f.status === 'loaded').map(f => f.family),
    overflow: document.documentElement.scrollWidth - window.innerWidth,
  };
}"""


def check(ok, label):
    results.append((bool(ok), label))
    return bool(ok)


def info(label):
    notes.append(label)


def sha256(path):
    return hashlib.sha256(path.read_bytes()).hexdigest()


def pixels_differ(a, b):
    ia = Image.open(io.BytesIO(a)).convert("RGB")
    ib = Image.open(io.BytesIO(b)).convert("RGB")
    if ia.size != ib.size:
        return 255.0
    diff = ImageChops.difference(ia, ib)
    if diff.getbbox() is None:
        return 0.0
    data = list(diff.getdata())
    return sum(sum(pixel) for pixel in data) / (len(data) * 3)


def identity_failures(data, label, filename, face, characters, requested):
    """The measurement section B passes and the patched control must fail."""
    bad = []
    if label not in (data["status"] or ""):
        bad.append(f"status names {label} ({data['status']!r})")
    if not any(filename in url for url in requested):
        bad.append(f"{label} requested its own file ({sorted(set(u.split('/')[-1] for u in requested))})")
    if face not in (data["sampleFamily"] or ""):
        bad.append(f"sample uses {face} ({data['sampleFamily']!r})")
    if face not in data["loadedFaces"]:
        bad.append(f"{face} is loaded")
    if not (data["glyphCount"] or "").startswith(str(characters)):
        bad.append(f"glyph panel shows {characters} ({data['glyphCount']!r})")
    if data["glyphCells"] != characters:
        bad.append(f"glyph cells are {characters} ({data['glyphCells']})")
    if face not in (data["cellFamily"] or ""):
        bad.append(f"glyph cells use {face} ({data['cellFamily']!r})")
    if data["gridCut"] != label:
        bad.append(f"glyph grid is labelled {label} ({data['gridCut']!r})")
    if data["weightPicker"]:
        bad.append("no weight picker is offered")
    if data["frameState"]:
        bad.append("the frame is in its ready state")
    return bad


async def open_product(browser, width=1440, height=900, patch=None):
    ctx = await browser.new_context(viewport={"width": width, "height": height})
    page = await ctx.new_page()
    errors = []
    otf = []
    page.on("pageerror", lambda e: errors.append(str(e)))
    page.on("console", lambda m: errors.append(m.text) if m.type == "error" else None)
    page.on("request", lambda r: otf.append(r.url) if r.url.lower().endswith(".otf") else None)
    if patch:
        source = (ROOT / "static" / "redesign" / "font-catalog.js").read_text(encoding="utf-8") + "\n" + patch
        await page.route("**/font-catalog.js", lambda r: r.fulfill(
            status=200, content_type="application/javascript", body=source))
    await page.goto(f"{BASE}/product.html?font=mondriel", wait_until="load")
    await page.fill("#sample-text", SAMPLE)
    await page.wait_for_function(
        "() => document.querySelector('#tester-frame') && document.querySelector('#tester-frame').dataset.state === undefined",
        timeout=20000)
    return ctx, page, errors, otf


async def select_style(page, index, label):
    await page.select_option("#sample-style", value=str(index))
    await page.wait_for_function(
        "() => document.querySelector('#font-status').textContent.includes('Showing the actual')",
        timeout=20000)
    await page.wait_for_function(
        "() => document.querySelector('#glyph-count').textContent.includes('characters')",
        timeout=20000)


PATCH_ONE_FACE = """
{ const p = window.RillaCatalog.catalog.get('mondriel');
  p.styles = p.styles.map(s => Object.assign({}, s, {
    file: 'Mondriel-Regular.otf', faceFamily: 'RT Mondriel' })); }
"""


async def main() -> int:
    # ------------------------------------------------------------------- A. files
    for label, filename, face, characters, source_name in [
            (e[0], e[1], e[2], e[3], e[4]) for e in EXPECTED]:
        local = FONTS / filename
        check(local.exists(), f"[A] {filename} exists")
        if not local.exists():
            continue
        check(local.stat().st_size > 10_000, f"[A] {filename} is a real font file ({local.stat().st_size} B)")
        source = SOURCE / source_name
        if source.exists():
            same = sha256(local) == sha256(source)
            check(same, f"[A] {filename} still matches the user's source hash")
        else:
            info(f"[A] SKIP: user source folder absent, hash of {filename} not compared "
                 f"(expected {SOURCE})")
    check((FONTS / "Mondriel-OutlineSlant.otf").exists(),
          "[A] the Outline Slant file is present (old plan expected only two Dockhand files)")

    async with async_playwright() as pw:
        browser = await pw.chromium.launch()

        # ------------------------------------------------------- B/C. identity
        wide_shots = {}
        for width, height in ((1440, 900), (390, 844)):
            ctx, page, errors, otf = await open_product(browser, width, height)

            for index, (label, filename, face, characters, _src) in enumerate(EXPECTED):
                await select_style(page, index, label)
                data = await page.evaluate(READ_STYLE)
                bad = identity_failures(data, label, filename, face, characters, otf)
                check(not bad, f"[B/{width}] {label}: {bad if bad else 'own file, face, glyphs'}")
                if width == 1440:
                    check(data["sampleText"] == SAMPLE,
                          f"[B] {label}: the visitor text survives the switch ({data['sampleText']!r})")
                    wide_shots[label] = await page.locator("#sample-output").screenshot()
            check(not errors, f"[B/{width}] no console or page errors ({errors[:2]})")
            narrow_overflow = (await page.evaluate(READ_STYLE))["overflow"]
            check(narrow_overflow <= 1,
                  f"[B/{width}] no horizontal overflow ({narrow_overflow}px)")
            if width == 1440:
                pairs = list(itertools.combinations(wide_shots, 2))
                diffs = {pair: pixels_differ(wide_shots[pair[0]], wide_shots[pair[1]]) for pair in pairs}
                identical = [pair for pair, value in diffs.items() if value < 0.5]
                check(not identical,
                      f"[C] all five rendered samples differ "
                      f"({len(pairs)} pairs, min {min(diffs.values()):.2f}, identical {identical})")
                for label, shot in wide_shots.items():
                    (ROOT / ".impeccable" / "review").mkdir(parents=True, exist_ok=True)
                    (ROOT / ".impeccable" / "review" /
                     f"P06-sample-{label.replace(' ', '')}-1440.png").write_bytes(shot)
                info(f"[C] pairwise differences: "
                     f"{ {f'{a}/{b}': round(v, 2) for (a, b), v in diffs.items()} }")
            await ctx.close()

        # --------------------------------------------------------- D. round trip
        ctx, page, errors, _otf = await open_product(browser)
        await page.fill("#sample-text", "Kept through every switch")
        await page.evaluate("""() => {
            const fire = (sel, value) => { const el = document.querySelector(sel);
              el.value = value; el.dispatchEvent(new Event('input', { bubbles: true })); };
            fire('#sample-size', '96'); fire('#sample-leading', '130'); fire('#sample-tracking', '4');
            document.querySelector('input[name="align"][value="center"]').click();
            document.querySelector('input[name="theme"][value="dark"]').click();
            document.querySelector('input[name="license"][value="standard"]').click();
        }""")
        before = await page.evaluate(READ_STYLE)
        for index, (label, _f, face, _c, _s) in enumerate(EXPECTED):
            await select_style(page, index, label)
            data = await page.evaluate(READ_STYLE)
            check(data["sampleText"] == before["sampleText"]
                  and data["sampleSize"] == before["sampleSize"]
                  and data["sampleLeading"] == before["sampleLeading"]
                  and data["sampleTracking"] == before["sampleTracking"]
                  and data["sampleAlign"] == before["sampleAlign"]
                  and data["stageTheme"] == before["stageTheme"]
                  and data["license"] == before["license"],
                  f"[D] {label}: text, size, leading, tracking, align, theme, license kept "
                  f"({data['sampleText']!r} {data['sampleSize']} {data['sampleLeading']} "
                  f"{data['sampleTracking']} {data['sampleAlign']} {data['stageTheme']} {data['license']})")
        # Clear and retype: the chosen style must survive an empty line.
        await select_style(page, 3, "Outline Slant")
        await page.fill("#sample-text", "")
        await page.fill("#sample-text", "Retyped")
        after = await page.evaluate(READ_STYLE)
        check(after["selected"] == "3" and "RT Mondriel Outline Slant" in (after["sampleFamily"] or ""),
              f"[D] clear and retype keep the selected style ({after['selected']}, {after['sampleFamily']})")
        check(after["sampleText"] == "Retyped", f"[D] the retyped text is literal ({after['sampleText']!r})")
        await ctx.close()

        # ------------------------------------------------------ E. abort + retry
        ctx = await browser.new_context(viewport={"width": 1440, "height": 900})
        page = await ctx.new_page()
        page_errors = []
        console_errors = []
        page.on("pageerror", lambda e: page_errors.append(str(e)))
        page.on("console", lambda m: console_errors.append(m.text) if m.type == "error" else None)
        aborting = {"on": True}
        await page.route("**/Mondriel-OutlineSlant.otf",
                         lambda r: r.abort() if aborting["on"] else r.continue_())
        await page.goto(f"{BASE}/product.html?font=mondriel", wait_until="load")
        await page.wait_for_function(
            "() => document.querySelector('#tester-frame') && document.querySelector('#tester-frame').dataset.state === undefined",
            timeout=20000)
        await page.fill("#sample-text", "Kept while broken")
        await select_style(page, 0, "Regular")
        await page.select_option("#sample-style", value="3")
        await page.wait_for_function(
            "() => document.querySelector('#tester-frame').dataset.state === 'error'", timeout=20000)
        broken = await page.evaluate(READ_STYLE)
        check("Outline Slant" in (broken["status"] or "") and "could not load" in (broken["status"] or ""),
              f"[E] the error names the cut that failed ({broken['status']!r})")
        check(not broken["frameHidden"] and broken["sampleText"] == "Kept while broken",
              "[E] the frame stays and the visitor text is kept")
        check(broken["glyphCount"] == "Character list unavailable" and broken["glyphCells"] == 0,
              f"[E] the glyph panel is cleared ({broken['glyphCount']!r}, {broken['glyphCells']} cells)")
        check(broken["retryHidden"] is False, "[E] retry is offered")
        aborting["on"] = False

        await page.click("#retry-font")
        await page.wait_for_function(
            "() => document.querySelector('#font-status').textContent.includes('Showing the actual')",
            timeout=20000)
        retried = await page.evaluate(READ_STYLE)
        check(retried["glyphCount"].startswith("194") and "RT Mondriel Outline Slant" in (retried["sampleFamily"] or ""),
              f"[E] retry loads the same cut without a reload ({retried['glyphCount']!r})")
        check(retried["sampleText"] == "Kept while broken",
              f"[E] the text survives the retry ({retried['sampleText']!r})")
        # The aborted request is expected to show up as a console error; an uncaught
        # page error is not. The third check keeps the first two honest: if the abort
        # never happened, the suite must say so instead of passing quietly.
        check(not page_errors, f"[E] no uncaught page errors ({page_errors[:2]})")
        unexpected = [text for text in console_errors if "ERR_FAILED" not in text]
        check(not unexpected,
              f"[E] the only console error is the deliberate abort "
              f"(unexpected {unexpected[:2]}, all {console_errors[:3]})")
        check(any("ERR_FAILED" in text for text in console_errors),
              f"[E] the aborted cut really was aborted ({console_errors[:1]})")
        await ctx.close()

        # ------------------------------------------------------------- F. race
        ctx = await browser.new_context(viewport={"width": 1440, "height": 900})
        page = await ctx.new_page()
        errors = []
        page.on("pageerror", lambda e: errors.append(str(e)))
        page.on("console", lambda m: errors.append(m.text) if m.type == "error" else None)
        release = asyncio.Event()

        async def hold(route):
            await release.wait()
            await route.continue_()

        await page.route("**/Mondriel-Handwritten.otf", hold)
        await page.goto(f"{BASE}/product.html?font=mondriel", wait_until="load")
        await page.wait_for_function(
            "() => document.querySelector('#tester-frame') && document.querySelector('#tester-frame').dataset.state === undefined",
            timeout=20000)
        await select_style(page, 0, "Regular")
        # Handwritten is requested but held; Regular is chosen again while it hangs.
        await page.select_option("#sample-style", value="4")
        await page.wait_for_timeout(150)
        await page.select_option("#sample-style", value="0")
        await page.wait_for_function(
            "() => document.querySelector('#glyph-count').textContent.startsWith('194')", timeout=20000)
        release.set()
        await page.wait_for_timeout(1500)
        after_race = await page.evaluate(READ_STYLE)
        check(after_race["glyphCount"].startswith("194"),
              f"[F] the late Handwritten response does not replace Regular glyphs ({after_race['glyphCount']!r})")
        check("RT Mondriel\"" in (after_race["sampleFamily"] or "")
              and after_race["gridCut"] == "Regular" and after_race["selected"] == "0",
              f"[F] the newest choice still owns the sample and grid "
              f"({after_race['sampleFamily']!r}, {after_race['gridCut']!r})")
        check("Regular" in (after_race["status"] or ""),
              f"[F] the status still names the newest choice ({after_race['status']!r})")
        check(not errors, f"[F] no console or page errors during the race ({errors[:2]})")
        await ctx.close()

        # --------------------------------------------------- G. Dockhand absent
        ctx = await browser.new_context(viewport={"width": 1440, "height": 900})
        page = await ctx.new_page()
        errors = []
        page.on("pageerror", lambda e: errors.append(str(e)))
        page.on("console", lambda m: errors.append(m.text) if m.type == "error" else None)
        await page.goto(f"{BASE}/product.html?font=dockhand", wait_until="load")
        await page.wait_for_timeout(600)
        status = await page.locator("#font-status").inner_text()
        check("Dockhand" in status, f"[G] the unavailable duo is still reachable by its route ({status[:60]!r})")
        check(await page.locator("#not-found").is_hidden(), "[G] it is not treated as an unknown slug")
        check(await page.locator("#tester-frame").is_hidden(), "[G] no tester is shown while its files are missing")
        check(await page.locator("#style-field").is_hidden(), "[G] no style selector is shown while its files are missing")
        check("No specimen file" in status, "[G] the missing file is stated instead of substituted")
        check(not errors, f"[G] no page errors ({errors[:2]})")
        await ctx.close()

        # ----------------------------------------------------- H. negative control
        ctx, page, _errors, otf = await open_product(browser, patch=PATCH_ONE_FACE)
        await select_style(page, 1, "Slant")
        control = await page.evaluate(READ_STYLE)
        label, filename, face, characters, _src = EXPECTED[1]
        failures = identity_failures(control, label, filename, face, characters, otf)
        info(f"[H] control failures: {failures[:4]}")
        check(bool(failures),
              f"[H] the same measurement fails when all five styles point at one file ({failures[:2]})")
        check("Mondriel-Regular.otf" in " ".join(otf) and "Mondriel-Slant.otf" not in " ".join(otf),
              f"[H] the control really swapped the file "
              f"({sorted(set(u.split('/')[-1] for u in otf))})")
        control_shot = await page.locator("#sample-output").screenshot()
        await ctx.close()
        await browser.close()

        # The control must also look different from the real Slant: same measurement,
        # wrong data, visibly different result.
        check(pixels_differ(wide_shots["Slant"], control_shot) > 1.0,
              f"[H] the patched Slant renders differently from the real Slant "
              f"({pixels_differ(wide_shots['Slant'], control_shot):.2f})")
    passed = sum(1 for ok, _ in results if ok)
    total = len(results)
    print(f"\n=== mixed family C03 (Mondriel): {passed}/{total} PASS ===\n")
    for ok, label in results:
        if not ok:
            print(f"FAIL  {label}")
    for line in notes:
        print(f"note  {line}")
    return 0 if passed == total else 1


if __name__ == "__main__":
    sys.exit(asyncio.run(main()))
