"""P12 check: the homepage Graphics section is real, data-driven, and not a font.

The card's acceptance criteria:
- the section can be found on desktop and mobile
- it does not use a drawn placeholder circle as if it were real artwork
- its entries do not point at another font
- a Graphic entry never renders a type tester

A test that only reads the shipped fixture cannot prove the last three, because
the shipped fixture happens to hold four real products with real images. So this
script serves *different* data at the same URLs with Playwright route overrides
and asserts the page follows it:

  A. shipped   - every card is asserted against the catalog: name, kind label,
                 price, route, artwork source, and the natural size of the image
                 that actually loaded. A placeholder mockup or a cropped
                 thumbnail fails here, not in review.
  B. mobile    - the same section at 390x844, with the artwork still intact and
                 no horizontal overflow.
  C. controls  - the section has to disappear or follow the data when the data is
                 wrong: a font slug in the fixture, an empty list, a Graphic whose
                 artwork is not mapped, and a Graphic that renames itself.
  D. no JS     - without JavaScript the section must still be findable, and it
                 must not pretend to hold cards it cannot build.

The two products used by the controls are fixtures. They never ship.

Usage: python scripts/check-homepage-graphics.py [base-url]
Exit 0 only when every assertion passes.
"""
import asyncio
import re
import sys
from pathlib import Path

from playwright.async_api import async_playwright

# Failure labels quote real UI strings; the Windows console cannot encode them in
# its default code page, and a report must never be the thing that breaks.
sys.stdout.reconfigure(encoding="utf-8", errors="replace")

ROOT = Path(__file__).resolve().parent.parent
SRC = ROOT / "static" / "redesign"
PREVIEWS = ROOT / "static" / "previews"
BASE = sys.argv[1].rstrip("/") if len(sys.argv) > 1 else "http://127.0.0.1:9402/static/redesign"

results = []
notes = []

# Mockups drawn by static/previews/generate-sections.py. They are ellipses plus a
# colour block, not product artwork, so they must never stand in for a Graphic.
PLACEHOLDER_MOCKUPS = (
    "brush-set-1.jpg", "brush-set-2.jpg", "brush-set-3.jpg",
    "graphic-pack-1.jpg", "graphic-pack-2.jpg",
)


def check(ok, label):
    results.append((bool(ok), label))
    return bool(ok)


def info(label):
    notes.append(label)


# ------------------------------------------------------------------- fixtures
# Which entries the section shows is a content choice; these fixtures change only
# that choice, and the catalog overrides change only facts.
def fixture(graphics, specimen=("chronoa", "mango")):
    return (
        "window.RillaHome = {\n"
        "  specimen: %s,\n"
        "  featured: { slug: 'chronoa', copy: 'x', artAlt: 'x' },\n"
        "  strips: [],\n"
        "  graphics: %s\n"
        "};\n" % (list(specimen), list(graphics))
    )


CATALOG_PATCH_UNMAPPED = """
catalog.set('graphic-fixture-nopic', {
  name: 'Fixture Graphic Without Artwork', kind: 'graphic', storeStatus: 'live',
  permalink: 'https://example.invalid/fixture-graphic', sku: '0', style: 'Fixture',
  price: 7, free: false, images: [], specimen: false, styles: [],
  evidence: 'Fixture pemeriksaan saja, tidak pernah dikirim.',
});
"""

CATALOG_PATCH_RENAMED = """
catalog.set('graphic-fixture-renamed', {
  name: 'Fixture Graphic Renamed', kind: 'graphic', storeStatus: 'live',
  permalink: 'https://example.invalid/fixture-renamed', sku: '0', style: 'Fixture',
  price: 42, free: false, images: ['../previews/palm-tree-1.jpg'], specimen: false,
  styles: [], evidence: 'Fixture pemeriksaan saja, tidak pernah dikirim.',
});
"""


async def open_page(browser, catalog_patch=None, fixture_body=None, width=1440, height=900,
                    java_script_enabled=True):
    ctx = await browser.new_context(
        viewport={"width": width, "height": height}, java_script_enabled=java_script_enabled)
    page = await ctx.new_page()
    errors = []
    page.on("pageerror", lambda e: errors.append(str(e)))
    page.on("console", lambda m: errors.append(m.text) if m.type == "error" else None)
    if catalog_patch:
        source = (SRC / "font-catalog.js").read_text(encoding="utf-8") + "\n" + catalog_patch
        await page.route("**/font-catalog.js", lambda r: r.fulfill(
            status=200, content_type="application/javascript", body=source))
    if fixture_body:
        await page.route("**/home-fixture.js", lambda r: r.fulfill(
            status=200, content_type="application/javascript", body=fixture_body))
    await page.goto(f"{BASE}/index.html", wait_until="load")
    if java_script_enabled:
        # The section is built by preview.js; the authored label is the marker that
        # it has not run yet.
        await page.wait_for_function(
            "() => { const c = document.querySelector('#graphics-count');"
            " return c && c.textContent.trim() !== 'From the shop'; }", timeout=15000)
        # A hidden section (the controls hide it) has no box to scroll to, so the
        # scroll is guarded instead of assumed.
        visible = await page.evaluate(
            "() => { const el = document.querySelector('#graphics');"
            " return !!(el && !el.hidden); }")
        if visible:
            await page.locator("#graphics").scroll_into_view_if_needed()
            # Lazy images: read them only once the browser has finished fetching
            # every one of them, so an empty naturalWidth cannot pass as intact.
            await page.wait_for_function(
                "() => [...document.querySelectorAll('#graphics-grid img')].every(i => i.complete)",
                timeout=15000)
        await page.wait_for_timeout(600)
    return ctx, page, errors


READ_SECTION = """() => {
  const one = s => document.querySelector(s);
  const section = one('#graphics');
  const cards = [...document.querySelectorAll('#graphics-grid .graphic-card')];
  const rect = el => { const r = el.getBoundingClientRect(); return { w: Math.round(r.width), h: Math.round(r.height), top: Math.round(r.top + window.scrollY) }; };
  return {
    hidden: section ? section.hidden : null,
    rect: section ? rect(section) : null,
    heading: one('#graphics-title') ? one('#graphics-title').textContent.trim() : null,
    count: one('#graphics-count') ? one('#graphics-count').textContent.trim() : null,
    view: one('#graphics .section-link') ? {
      href: one('#graphics .section-link').getAttribute('href'),
      text: one('#graphics .section-link').textContent.trim(),
    } : null,
    collectionTop: one('.collection') ? rect(one('.collection')).top : null,
    cards: cards.map(card => {
      const img = card.querySelector('img');
      const box = img ? img.getBoundingClientRect() : null;
      return {
        href: card.getAttribute('href'),
        kind: card.dataset.kind,
        slug: card.dataset.slug,
        art: card.dataset.art || 'mapped',
        name: card.querySelector('.graphic-name').textContent.trim(),
        meta: card.querySelector('.graphic-meta').textContent.trim(),
        price: card.querySelector('.graphic-price').textContent.trim(),
        src: img ? img.getAttribute('src') : null,
        currentSrc: img && img.currentSrc ? img.currentSrc : null,
        natural: img && img.naturalWidth ? `${img.naturalWidth}x${img.naturalHeight}` : null,
        loaded: img ? !!(img.complete && img.naturalWidth > 0) : null,
        box: img && img.naturalWidth && box.height ? +(box.width / box.height).toFixed(3) : null,
        alt: img ? img.getAttribute('alt') : null,
        note: card.querySelector('.graphic-art-note') ? card.querySelector('.graphic-art-note').textContent.trim() : null,
        tester: !!card.querySelector('#tester-frame, .tester, .glyph-cell, input[type="radio"], .opentype, .feature-switch'),
      };
    }),
    testerInSection: !!one('#graphics #tester-frame, #graphics .tester, #graphics .glyph-cell, #graphics input[type="radio"], #graphics .opentype'),
    overflow: document.documentElement.scrollWidth - window.innerWidth,
  };
}"""


def catalog_js():
    """The shipped catalog, read without a browser: the ground truth for facts."""
    text = (SRC / "font-catalog.js").read_text(encoding="utf-8")
    entries = {}
    for match in re.finditer(r"\['([a-z0-9-]+)', \{(.*?)\}\],", text, re.S):
        key, body = match.group(1), match.group(2)

        def grab(field):
            found = re.search(r"%s: '([^']*)'" % field, body)
            return found.group(1) if found else None

        price = re.search(r"price: (\d+)", body)
        images = re.search(r"images: \[([^\]]*)\]", body)
        entries[key] = {
            "name": grab("name"),
            "kind": grab("kind"),
            "style": grab("style"),
            "storeStatus": grab("storeStatus"),
            "price": int(price.group(1)) if price else None,
            "images": re.findall(r"'([^']+)'", images.group(1)) if images else [],
        }
    return entries


async def main():
    async with async_playwright() as pw:
        browser = await pw.chromium.launch()
        catalog = catalog_js()
        fixture_text = (SRC / "home-fixture.js").read_text(encoding="utf-8")
        fixture_slugs = re.search(r"graphics: \[(.*?)\]", fixture_text, re.S).group(1)
        wanted = re.findall(r"'([^']+)'", fixture_slugs)

        # ------------------------------------------------ A. the shipped section
        ctx, page, errors = await open_page(browser)
        shipped = await page.evaluate(READ_SECTION)
        check(shipped["hidden"] is False and shipped["rect"]["h"] > 0,
              f"[A] the Graphics section is rendered, not hidden ({shipped['rect']})")
        check(shipped["heading"] == "Graphicsfor the work.",
              f"[A] the section carries its own heading ({shipped['heading']!r})")
        check(shipped["collectionTop"] is not None
              and shipped["collectionTop"] < shipped["rect"]["top"],
              f"[A] the section sits after the font collection "
              f"({shipped['collectionTop']} < {shipped['rect']['top']})")
        check(bool(shipped["view"]) and shipped["view"]["href"] == "catalog.html?category=graphic",
              f"[A] View graphics points at the Graphics catalogue ({shipped['view']})")
        check(bool(shipped["view"]) and shipped["view"]["text"].startswith("View graphics"),
              f"[A] the link says View graphics ({shipped['view']})")
        check(len(shipped["cards"]) == len(wanted),
              f"[A] one card per chosen entry ({len(shipped['cards'])} of {len(wanted)})")
        check(shipped["count"] == f"{len(wanted)} graphics",
              f"[A] the count line follows the data ({shipped['count']!r})")
        check(not errors, f"[A] no console or page errors ({errors[:2]})")

        slugs = [card["slug"] for card in shipped["cards"]]
        check(slugs == wanted, f"[A] the rendered order follows the fixture ({slugs})")

        for card in shipped["cards"]:
            slug = card["slug"]
            product = catalog.get(slug, {})
            check(product.get("kind") == "graphic",
                  f"[A] {slug}: the catalog calls it a graphic ({product.get('kind')})")
            check(card["kind"] == "graphic",
                  f"[A] {slug}: the rendered card is marked graphic ({card['kind']})")
            check(card["href"] == f"product.html?font={slug}",
                  f"[A] {slug}: the card points at its own detail route ({card['href']})")
            check(not re.search(r"chronoa|mango|dockhand|wildkins|solaya|darkwell|redline",
                                card["href"] or ""),
                  f"[A] {slug}: the card does not point at a font ({card['href']})")
            check(card["name"] == product.get("name"),
                  f"[A] {slug}: the name is the catalog name ({card['name']!r})")
            check(card["meta"] == product.get("style"),
                  f"[A] {slug}: the kind label is the catalog style ({card['meta']!r})")
            check(card["price"] == f"Demo ${product.get('price')}",
                  f"[A] {slug}: the price is a Demo price from the catalog ({card['price']!r})")
            check(card["tester"] is False, f"[A] {slug}: the card holds no type tester")
            check(card["loaded"] is True and card["natural"] == "1200x800",
                  f"[A] {slug}: the artwork really loaded at its own size ({card['natural']})")
            check(card["box"] is not None and abs(card["box"] - 1.5) < 0.02,
                  f"[A] {slug}: the artwork keeps the 3:2 box ({card['box']})")
            check(bool(card["src"]) and card["src"] in product.get("images", []),
                  f"[A] {slug}: the artwork is the image the catalog mapped ({card['src']!r})")
            check(bool(card["currentSrc"]) and bool(card["src"])
                  and card["currentSrc"].endswith(card["src"].split("/")[-1]),
                  f"[A] {slug}: nothing re-encoded or cropped the source ({card['currentSrc']})")
            check(not re.search(r"-\d+x\d+\.(jpg|png)$", card["currentSrc"] or ""),
                  f"[A] {slug}: no WordPress thumbnail size is used ({card['currentSrc']})")
            check(not any(name in (card["src"] or "") for name in PLACEHOLDER_MOCKUPS),
                  f"[A] {slug}: no drawn placeholder mockup is used as artwork ({card['src']})")
            check(bool(card["alt"]) and card["name"].split(" - ")[0] in card["alt"],
                  f"[A] {slug}: the image carries a derived alt ({card['alt']!r})")
            check(card["art"] == "mapped" and card["note"] is None,
                  f"[A] {slug}: a mapped artwork never shows the missing-artwork state")
        check(shipped["testerInSection"] is False,
              "[A] no type tester, glyph grid, or feature switch exists inside the section")
        check(shipped["overflow"] <= 1,
              f"[A] the section adds no horizontal overflow ({shipped['overflow']}px)")
        await ctx.close()

        # -------------------------------------------------- B. the same at 390px
        ctx, page, errors = await open_page(browser, width=390, height=844)
        narrow = await page.evaluate(READ_SECTION)
        check(narrow["hidden"] is False and len(narrow["cards"]) == len(wanted),
              f"[B] the section is findable at 390px too ({len(narrow['cards'])} cards)")
        check(all(card["loaded"] and card["box"] and abs(card["box"] - 1.5) < 0.02
                  for card in narrow["cards"]),
              f"[B] the artwork is still intact at 390px "
              f"({[card['natural'] for card in narrow['cards']][:2]})")
        check(narrow["overflow"] <= 1,
              f"[B] no horizontal overflow at 390px ({narrow['overflow']}px)")
        check(not errors, f"[B] no console or page errors at 390px ({errors[:2]})")
        await ctx.close()

        # ------------------------------------- C1. a font slug is not a Graphic
        ctx, page, _ = await open_page(browser, fixture_body=fixture(["chronoa", "mango"]))
        fonts_only = await page.evaluate(READ_SECTION)
        check(fonts_only["hidden"] is True and not fonts_only["cards"],
              f"[C1] a fixture that names fonts renders no Graphic "
              f"(hidden={fonts_only['hidden']}, cards={len(fonts_only['cards'])})")
        await ctx.close()

        # --------------------------------------- C2. no chosen entry, no section
        ctx, page, _ = await open_page(browser, fixture_body=fixture([]))
        empty = await page.evaluate(READ_SECTION)
        check(empty["hidden"] is True and not empty["cards"] and empty["count"] == "",
              f"[C2] an empty Graphics list hides the section "
              f"(hidden={empty['hidden']}, count={empty['count']!r})")
        await ctx.close()

        # --------------------------- C3. facts follow the catalog, artwork too
        ctx, page, _ = await open_page(
            browser, catalog_patch=CATALOG_PATCH_RENAMED,
            fixture_body=fixture(["graphic-fixture-renamed"]))
        renamed = await page.evaluate(READ_SECTION)
        card = renamed["cards"][0] if renamed["cards"] else {}
        check(card.get("name") == "Fixture Graphic Renamed"
              and card.get("price") == "Demo $42",
              f"[C3] a renamed, repriced entry renders those facts "
              f"({card.get('name')!r}, {card.get('price')!r})")
        check(card.get("href") == "product.html?font=graphic-fixture-renamed",
              f"[C3] the route follows the slug, not a hard-coded product ({card.get('href')})")
        await ctx.close()

        # ------------------- C4. a Graphic without artwork says so, keeps the box
        ctx, page, _ = await open_page(
            browser, catalog_patch=CATALOG_PATCH_UNMAPPED,
            fixture_body=fixture(["graphic-fixture-nopic"]))
        unmapped = await page.evaluate(READ_SECTION)
        card = unmapped["cards"][0] if unmapped["cards"] else {}
        check(card.get("art") == "missing" and card.get("src") is None,
              f"[C4] an unmapped Graphic renders no image element "
              f"(art={card.get('art')!r}, src={card.get('src')!r})")
        check(card.get("note") == "Artwork not mapped yet",
              f"[C4] and it states that in words ({card.get('note')!r})")
        check(card.get("name") == "Fixture Graphic Without Artwork",
              f"[C4] the entry is still listed with its name ({card.get('name')!r})")
        await ctx.close()

        # ------------------------------------------------ D. the no-JS boundary
        ctx, page, _ = await open_page(browser, java_script_enabled=False)
        await page.wait_for_timeout(400)
        nojs = await page.evaluate(READ_SECTION)
        check(nojs["hidden"] is False and bool(nojs["heading"]),
              f"[D] without JS the section is still there ({nojs['heading']!r})")
        check(bool(nojs["view"]) and nojs["view"]["href"] == "catalog.html?category=graphic",
              f"[D] and its View graphics link still works ({nojs['view']})")
        check(not nojs["cards"] and nojs["count"] == "From the shop",
              f"[D] without JS it claims no cards it cannot build "
              f"({len(nojs['cards'])} cards, count={nojs['count']!r})")
        await ctx.close()

        # ----------------------------- A2. the artwork files are the real files
        for card in shipped["cards"]:
            path = PREVIEWS / card["src"].split("/")[-1]
            check(path.exists() and path.stat().st_size > 100 * 1024,
                  f"[A2] {path.name} is a real artwork file, not a drawn stub "
                  f"({path.stat().st_size if path.exists() else 'missing'} bytes)")
        check(not any(name in [card["src"].split("/")[-1] for card in shipped["cards"]]
                      for name in PLACEHOLDER_MOCKUPS),
              "[A2] none of the five drawn mockups appears in the section")

        await browser.close()

    passed = sum(1 for ok, _ in results if ok)
    total = len(results)
    print(f"\n=== homepage graphics: {passed}/{total} PASS ===\n")
    for ok, label in results:
        if not ok:
            print(f"FAIL  {label}")
    for line in notes:
        print(f"note  {line}")
    return 0 if passed == total else 1


if __name__ == "__main__":
    sys.exit(asyncio.run(main()))
