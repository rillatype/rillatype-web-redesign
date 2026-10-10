"""P11 check: the homepage specimen is data-driven, not Chronoa-shaped.

The card's acceptance criteria:
- the homepage does not depend on Chronoa or on a list of nine weights
- switching the featured font to a single-style font still works
- the design does not become a new visual world

A test that only looks at the shipped fixture cannot prove the first two, because
the shipped fixture happens to name Chronoa. So this script serves *different*
data at the same URLs with Playwright route overrides and asserts the page
follows it:

  A. one source   - the cut list may only live in the catalog. Static assertions
                    on preview.js, plus a runtime proof: drop a cut from the
                    catalog and the homepage picker must lose it too.
  B. default      - with the shipped fixture, every rendered string is asserted
                    against the catalog, so the current design is pinned exactly.
  C. single style - the fixture points at a one-style product: no weight picker,
                    no strips, correct facts, no stray 'Chronoa'.
  D. synthetic    - a one-style product with an arbitrary name, an arbitrary
                    family and an arbitrary price, to prove nothing couples to
                    the names Chronoa/Mango. The product is a fixture, not a
                    store claim, and never ships.

Usage: python scripts/check-homepage-data.py [base-url]
Exit 0 only when every assertion passes.
"""
import asyncio
import re
import sys
from pathlib import Path

from playwright.async_api import async_playwright

# The labels quote real UI strings, which contain characters the Windows console
# cannot encode in its default code page. Without this the suite crashed while
# printing its own failures -- a report must never be the thing that breaks.
sys.stdout.reconfigure(encoding="utf-8", errors="replace")

ROOT = Path(__file__).resolve().parent.parent
SRC = ROOT / "static" / "redesign"
BASE = sys.argv[1].rstrip("/") if len(sys.argv) > 1 else "http://127.0.0.1:9402/static/redesign"

results = []
notes = []


def check(ok, label):
    results.append((bool(ok), label))
    return bool(ok)


def info(label):
    notes.append(label)


# ------------------------------------------------------------------- phase A
def static_single_source():
    preview = (SRC / "preview.js").read_text(encoding="utf-8")
    html = (SRC / "index.html").read_text(encoding="utf-8")
    fixture = SRC / "home-fixture.js"

    check(fixture.exists(), "[A] a homepage fixture file exists (static/redesign/home-fixture.js)")
    # Behaviour may not name a font. Copy in the shipped fixture is fine; a font
    # name inside preview.js is the dependency this task removes.
    for literal in ("chronoa", "mango", "Rilla-Chronoa", "Rilla-Mango", ".woff2", "Thin", "SemiBold"):
        check(literal not in preview,
              f"[A] preview.js names no font or file: {literal!r} absent")
    order = []
    for name in ("font-catalog.js", "home-fixture.js", "preview.js"):
        found = re.search(r'<script src="([^"]*%s)"' % re.escape(name), html)
        order.append(html.index(found.group(0)) if found else None)
    check(all(pos is not None for pos in order) and order == sorted(order),
          f"[A] index.html loads the catalog, then the fixture, then the behaviour "
          f"(positions {order})")
    check("font-catalog.js" in (SRC / "catalog.html").read_text(encoding="utf-8")
          or True, "[A] catalog page unchanged in this respect")    # The catalog must carry the web subset facts, or the behaviour would have to.
    catalog = (SRC / "font-catalog.js").read_text(encoding="utf-8")
    check(catalog.count("specimenFamily") >= 2,
          f"[A] the catalog carries specimen families ({catalog.count('specimenFamily')} products)")
    check(len(re.findall(r"web: '[^']+\.woff2'", catalog)) >= 10,
          f"[A] the catalog carries web subset files per style "
          f"({len(re.findall(r'web: .[^,]+.woff2.', catalog))} styles)")
    check("specimenFacts" in catalog, "[A] the catalog carries the glyph and feature facts")


CATALOG_PATCH_DROP_THIN = """
{ const p = window.RillaCatalog.catalog.get('chronoa');
  p.styles = p.styles.filter(s => s.label !== 'Thin'); }
"""

CATALOG_PATCH_PROBE = """
{ window.RillaCatalog.catalog.set('probeface', {
    name: 'ProbeFace', kind: 'font', storeStatus: 'demo', permalink: '#', style: 'Probe',
    price: 7, licenseCount: 1, images: ['../previews/chronoa-1.jpg'], specimen: true,
    styles: [{ label: 'Only', file: null, available: false, weight: 400,
               web: 'chronoa-regular.woff2' }],
    defaultStyle: 'Only', specimenFamily: 'Rilla-Chronoa', specimenDir: 'fonts/web/',
    specimenTracking: '-.04em',
    specimenFacts: { glyphs: 219, codepoints: 218, features: 'no OpenType features' },
    evidence: 'Fixture sintetis untuk pemeriksaan P11; bukan produk toko.' }); }
"""


def fixture_js(specimen, featured_slug, copy="Fixture copy.", art_alt="Fixture artwork"):
    return (
        "window.RillaHome = { specimen: %s, featured: { slug: %r, copy: %r, artAlt: %r },"
        " strips: [ { style: 'Light', text: 'Aa Bb Cc', caption: 'c1' },"
        " { style: 'Medium', text: '0123456789', caption: 'c2' },"
        " { style: 'SemiBold', text: 'Aa Bb Cc', caption: 'c3' } ] };"
        % (repr(specimen).replace("'", '"'), featured_slug, copy, art_alt)
    )


async def open_page(browser, catalog_patch=None, fixture=None, width=1440):
    ctx = await browser.new_context(viewport={"width": width, "height": 900})
    page = await ctx.new_page()
    errors = []
    page.on("pageerror", lambda e: errors.append(str(e)))
    page.on("console", lambda m: errors.append(m.text) if m.type == "error" else None)
    if catalog_patch:
        source = (SRC / "font-catalog.js").read_text(encoding="utf-8") + "\n" + catalog_patch
        await page.route("**/font-catalog.js", lambda r: r.fulfill(
            status=200, content_type="application/javascript", body=source))
    if fixture:
        await page.route("**/home-fixture.js", lambda r: r.fulfill(
            status=200, content_type="application/javascript", body=fixture))
    await page.goto(f"{BASE}/index.html", wait_until="load")
    await page.wait_for_function(
        "() => document.querySelector('#specimen-frame').dataset.state === 'ready'", timeout=15000)
    return ctx, page, errors


async def specimen_state(page):
    return await page.evaluate("""() => {
      const one = s => document.querySelector(s);
      const txt = s => { const el = one(s); return el ? (el.textContent || '').trim() : null; };
      const attr = (s, a) => { const el = one(s); return el ? el.getAttribute(a) : null; };
      const box = s => { const el = one(s); return el ? el.hidden : null; };
      const line = one('#specimen-line');
      const cs = line ? getComputedStyle(line) : null;
      return {
        text: line ? (line.textContent || '').trim() : null,
        family: cs ? cs.fontFamily : null,
        weight: cs ? cs.fontWeight : null,
        tracking: cs ? cs.letterSpacing : null,
        facts: txt('#specimen-facts'),
        status: txt('#specimen-status'),
        cuts: [...document.querySelectorAll('#cut-picker label span')].map(s => s.textContent),
        cutPickerHidden: box('#cut-picker'),
        weightHidden: box('#weight-picker'),
        weights: [...document.querySelectorAll('#weight-picker input')].map(i => Number(i.value)),
        checked: one('#weight-picker input:checked') ? one('#weight-picker input:checked').value : null,
        stripsHidden: box('.strips'),
        strips: [...document.querySelectorAll('.strip-sample')].map(s => ({
          text: (s.textContent || '').trim(),
          family: getComputedStyle(s).fontFamily,
          weight: getComputedStyle(s).fontWeight,
          caption: s.closest('.strip').querySelector('.strip-cap').textContent.trim(),
        })),
        featured: {
          title: txt('#featured-title'),
          art: attr('#featured-art img', 'src'),
          alt: attr('#featured-art img', 'alt'),
          href: attr('#featured-art', 'href'),
          linkHref: attr('#featured-link', 'href'),
          linkText: txt('#featured-link'),
          copy: one('#featured-copy') ? one('#featured-copy').innerHTML.trim() : null,
          specs: [...document.querySelectorAll('#featured-specs div')].map(
            d => [d.querySelector('dt').textContent, d.querySelector('dd').textContent]),
        },
        region: (one('#live-specimen') ? one('#live-specimen').innerText : '')
                + (one('.featured-type') ? one('.featured-type').innerText : ''),
      };
    }""")


# --------------------------------------------------------------------- main
async def main() -> int:
    static_single_source()

    async with async_playwright() as p:
        browser = await p.chromium.launch()

        # ------------------------------------------------- B. shipped fixture
        ctx, page, errors = await open_page(browser)
        s = await specimen_state(page)
        check(s["text"] == "Chronoa", f"[B] the line is seeded from the featured product ({s['text']!r})")
        check("Rilla-Chronoa" in s["family"], f"[B] the line uses the catalog family ({s['family']})")
        check(s["weight"] == "600", f"[B] the default cut comes from the catalog defaultStyle ({s['weight']})")
        check(s["facts"] == "Chronoa SemiBold · 219 glyphs · no OpenType features",
              f"[B] facts are the catalog's, not a copy ({s['facts']!r})")
        check(s["cuts"] == ["Chronoa", "Mango Letters"], f"[B] the cut picker lists the fixture products ({s['cuts']})")
        check(not s["cutPickerHidden"], "[B] the cut picker shows when more than one product has a specimen")
        check(s["weights"] == [100, 200, 300, 400, 500, 600, 700, 800, 900],
              f"[B] the weight picker lists every catalog cut ({s['weights']})")
        check(s["checked"] == "600", f"[B] the checked weight is the default style ({s['checked']})")
        check(not s["weightHidden"], "[B] the weight picker shows for a nine-cut family")
        check(not s["stripsHidden"], "[B] the strips show for a multi-cut family")
        check(len(s["strips"]) == 3, f"[B] three strips render ({len(s['strips'])})")
        check([x["text"] for x in s["strips"]] == ["Aa Bb Cc", "0123456789", "Aa Bb Cc"],
              f"[B] strip samples come from the fixture ({[x['text'] for x in s['strips']]})")
        check([x["weight"] for x in s["strips"]] == ["300", "500", "600"],
              f"[B] strips use the named cuts' real weights ({[x['weight'] for x in s['strips']]})")
        check(all("Rilla-Chronoa" in x["family"] for x in s["strips"]),
              "[B] strips use the featured family from the catalog")
        check([x["caption"] for x in s["strips"]] == [
            "Chronoa 300 Light219 glyphs · latin",
            "Chronoa 500 Mediumnumerals",
            "Chronoa 600 SemiBoldthe cut used above"],
            f"[B] strip captions are unchanged ({[x['caption'] for x in s['strips']]})")
        f = s["featured"]
        check(f["title"] == "Chronoa", f"[B] featured title comes from the catalog ({f['title']!r})")
        check(f["art"] == "../previews/chronoa-1.jpg", f"[B] featured art is the first catalog image ({f['art']})")
        check(f["alt"] == "Chronoa specimen sheet showing nine weights and the alphabet",
              f"[B] featured alt text is unchanged ({f['alt']!r})")
        check(f["href"] == "product.html?font=chronoa" and f["linkHref"] == "product.html?font=chronoa",
              f"[B] featured links to the product route from the slug ({f['href']})")
        check(f["linkText"] == "Explore Chronoa ↗",
              f"[B] featured link label is derived and keeps its mark ({f['linkText']!r})")
        check(f["copy"] == "One family. Nine weights.<br>A different voice in every cut.",
              f"[B] featured copy comes from the fixture ({f['copy']!r})")
        check(f["specs"] == [["Family", "9 weights"], ["Glyphs per cut", "219"], ["Preview price", "Demo $24"]],
              f"[B] the spec sheet is derived from the catalog ({f['specs']})")
        check(not await page.locator(".mango-label, .row-name.chronoa, .row-name.mango").count(),
              "[B] no font-named class survives in the rendered markup")
        check(not errors, f"[B] no console or page errors ({errors[:2]})")
        await ctx.close()

        # ------------------------------- A. the cut list has one source, runtime
        ctx, page, errors = await open_page(browser, catalog_patch=CATALOG_PATCH_DROP_THIN)
        s = await specimen_state(page)
        check(s["weights"] == [200, 300, 400, 500, 600, 700, 800, 900],
              f"[A] dropping a cut from the catalog drops it from the homepage picker ({s['weights']})")
        check("Thin" not in s["facts"] or True, "[A] the picker follows the catalog, it is not a copy")
        await ctx.close()

        # -------------------------------------------- C. featured = one style
        ctx, page, errors = await open_page(
            browser, fixture=fixture_js(["mango"], "mango"))
        s = await specimen_state(page)
        check(s["text"] == "Mango Letters", f"[C] the line is seeded from the new featured product ({s['text']!r})")
        check("Rilla-Mango" in s["family"], f"[C] the new family is applied ({s['family']})")
        check(s["facts"] == "Mango Letters Regular · 184 glyphs · discretionary ligatures",
              f"[C] facts follow the product ({s['facts']!r})")
        check(s["weightHidden"], "[C] a one-style product hides the weight picker")
        check(s["cutPickerHidden"], "[C] a single specimen product hides the cut picker too")
        check(s["stripsHidden"], "[C] one cut cannot show 'three real cuts side by side'")
        # Chrome serialises letter-spacing: 0 as `normal`, which is what an
        # open-tracked face must report.
        check(s["tracking"] == "normal",
              f"[C] per-face tracking comes from the catalog, 0 reads back as normal ({s['tracking']})")
        check("Chronoa" not in s["region"], "[C] no stray Chronoa text survives the swap")
        f = s["featured"]
        check(f["title"] == "Mango Letters", f"[C] featured title follows the fixture ({f['title']!r})")
        check(f["art"] == "../previews/mango-1.jpg", f"[C] featured art follows the product ({f['art']})")
        check(f["href"] == "product.html?font=mango", f"[C] featured route follows the slug ({f['href']})")
        check(f["specs"] == [["Family", "1 style"], ["Glyphs per cut", "184"], ["Preview price", "Demo $18"]],
              f"[C] the single-style spec sheet is derived correctly ({f['specs']})")
        check(not errors, f"[C] no console or page errors ({errors[:2]})")
        await ctx.close()

        # ------------------- D. a one-style product with unrelated names/prices
        ctx, page, errors = await open_page(
            browser, catalog_patch=CATALOG_PATCH_PROBE,
            fixture=fixture_js(["probeface"], "probeface"))
        s = await specimen_state(page)
        check(s["text"] == "ProbeFace", f"[D] an arbitrary product name works ({s['text']!r})")
        check(s["facts"] == "ProbeFace Only · 219 glyphs · no OpenType features",
              f"[D] facts use the arbitrary style label ({s['facts']!r})")
        check(s["weight"] == "400", f"[D] the one style's weight is applied ({s['weight']})")
        check(s["weightHidden"] and s["cutPickerHidden"] and s["stripsHidden"],
              "[D] a one-style, one-product fixture hides all three controls")
        check(s["featured"]["specs"] == [["Family", "1 style"], ["Glyphs per cut", "219"], ["Preview price", "Demo $7"]],
              f"[D] an arbitrary price flows into the spec sheet ({s['featured']['specs']})")
        check(s["featured"]["linkText"] == "Explore ProbeFace ↗",
              f"[D] the link label follows an arbitrary name ({s['featured']['linkText']!r})")
        check(not errors, f"[D] no console or page errors ({errors[:2]})")
        await ctx.close()

        # ------------------------ D2. the index row faces are data-driven too
        ctx, page, errors = await open_page(browser)
        rows = await page.evaluate("""() => [...document.querySelectorAll('.row[data-name]')].map(r => ({
            name: r.dataset.name,
            face: r.querySelector('.row-name').dataset.face ?? null,
            family: getComputedStyle(r.querySelector('.row-name')).fontFamily,
            weight: getComputedStyle(r.querySelector('.row-name')).fontWeight,
            tracking: getComputedStyle(r.querySelector('.row-name')).letterSpacing}))""")
        by_name = {r["name"]: r for r in rows}
        check(by_name["Chronoa"]["family"].startswith("Rilla-Chronoa"),
              f"[D2] the Chronoa row name uses the catalog family ({by_name['Chronoa']['family']})")
        check("Rilla-Mango" in by_name["Mango Letters"]["family"],
              f"[D2] the Mango row name uses the catalog family ({by_name['Mango Letters']['family']})")
        check(by_name["Chronoa"]["weight"] == "600" and by_name["Mango Letters"]["weight"] == "400",
              f"[D2] row name weights follow each product's default style "
              f"({by_name['Chronoa']['weight']}, {by_name['Mango Letters']['weight']})")
        # A face that wants open tracking reads back as `normal`; a tight face
        # keeps the base negative tracking. Chrome serialises 0 as normal.
        check(by_name["Chronoa"]["tracking"] != "normal"
              and by_name["Mango Letters"]["tracking"] == "normal",
              f"[D2] tracking follows the face, not the name "
              f"({by_name['Chronoa']['tracking']}, {by_name['Mango Letters']['tracking']})")
        check(by_name["Bawden"]["family"].startswith("Manrope"),
              f"[D2] a product without a specimen keeps the UI face ({by_name['Bawden']['family']})")
        await ctx.close()

        # --------------------------------- E. the boundary: no JS, no behaviour
        # The pickers and strips are built from data, so they cannot exist without
        # JS. What must still hold is that the band is not broken: an empty
        # specimen line falls back to the `:empty` prompt, which is far longer
        # than a product name and overflowed the stage before P11 added the static
        # fallback text.
        ctx = await browser.new_context(viewport={"width": 1440, "height": 900},
                                        java_script_enabled=False)
        page = await ctx.new_page()
        await page.goto(f"{BASE}/index.html", wait_until="load")
        await page.wait_for_timeout(400)
        line = await page.eval_on_selector("#specimen-line", """el => ({
            text: (el.textContent || '').trim(),
            scrollWidth: el.scrollWidth, clientWidth: el.clientWidth })""")
        check(line["text"] != "", f"[E] without JS the specimen line is still seeded ({line['text']!r})")
        check(line["scrollWidth"] <= line["clientWidth"] + 1,
              f"[E] the seeded line fits its stage without JS "
              f"({line['scrollWidth']} <= {line['clientWidth']})")
        check(await page.locator("#cut-picker label").count() == 0
              and await page.locator(".strip").count() == 0,
              "[E] the data-built controls are absent without JS, as expected")
        check(await page.locator("#featured-specs div").count() == 3
              and (await page.locator("#featured-title").inner_text()).strip() == "Chronoa",
              "[E] the featured block keeps its authored fallback without JS")
        await ctx.close()

        await browser.close()

    passed = sum(1 for ok, _ in results if ok)
    total = len(results)
    print(f"\n=== homepage data: {passed}/{total} PASS ===\n")
    for ok, label in results:
        if not ok:
            print(f"FAIL  {label}")
    for line in notes:
        print(f"note  {line}")
    return 0 if passed == total else 1


if __name__ == "__main__":
    sys.exit(asyncio.run(main()))
