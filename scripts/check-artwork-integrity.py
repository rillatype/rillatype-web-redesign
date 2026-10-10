"""P10 check: every product image renders whole, undistorted, and un-clipped.

C12 says a 1200x800 source whose lettering reaches the edges must render with
all four edges intact and a currentSrc that is not cropped. This script proves
that on the real pages at the six widths the card names.

Phases, each covering a failure mode the others cannot see:

  1. CSS audit  - static. No rule may crop (`object-fit: cover`), distort
                  (`fill`), zoom (`transform: scale()` on an image), or squeeze
                  a preview into a box whose ratio is not 3/2 or auto. Static,
                  so it also catches rules whose markup is not rendered yet --
                  the classic hiding place (`.hero-art`, `.shelf-art`).
  2. Geometry   - per image, at 320/390/768/1280/1440/1600px. The whole source
                  must sit inside the content box, and the scale must be equal
                  on both axes. Uses clientWidth/Height, which excludes
                  transforms, so a hover zoom cannot hide from this phase.
  3. Clip       - per image. The painted box (getBoundingClientRect, which does
                  include transforms) must fit inside every ancestor that clips
                  with overflow hidden/clip. This is the phase that catches a
                  zoom that phase 2 cannot see.
  4. Probe      - a generated 1200x1000 image (ratio 1.200) is loaded into the
                  real media element of each container. Every real asset is
                  already exactly 3:2, so a container that only survives because
                  of that coincidence cannot be caught any other way. This is
                  the only test of the card's "other dimensions keep their ratio".
  5. Pixels     - the geometry model is validated against real pixels: the
                  element screenshot must match the source cropped to the rect
                  the geometry claims is visible, and a negative control (a 70%
                  centred crop of the same source) must score clearly worse.
                  Without the control the comparison could pass on anything.
                  (P09 lesson: a check that cannot fail is not a check.)

Usage: python scripts/check-artwork-integrity.py [base-url]
Exit 0 only when every assertion passes.
"""
import asyncio
import io
import json
import re
import sys
from pathlib import Path

import numpy as np
from PIL import Image
from playwright.async_api import async_playwright

BASE = sys.argv[1].rstrip("/") if len(sys.argv) > 1 else "http://127.0.0.1:9402/static/redesign"
ORIGIN = "http://127.0.0.1:9402"
ROOT = Path(__file__).resolve().parent.parent
WIDTHS = [320, 390, 768, 1280, 1440, 1600]
PAGES = [
    ("home", "/index.html"),
    ("catalog", "/catalog.html"),
    ("chronoa", "/product.html?font=chronoa"),
    ("mango", "/product.html?font=mango"),
    ("components", "/components.html"),
]
CSS_FILES = ["editorial.css", "home.css", "style.css"]
# One rendered pixel of an image may fall outside its content box. Integer
# clientWidth/clientHeight rounding is worth about half a pixel; a real crop is
# tens of pixels, so the gap between the two is wide and the threshold is safe.
SLOP_PX = 1.0

results = []
inventory = {}
notes = []


def check(ok, label):
    results.append((bool(ok), label))
    return bool(ok)


def info(label):
    notes.append(label)


# --------------------------------------------------------------------- phase 1
def strip_comments(text):
    return re.sub(r"/\*.*?\*/", "", text, flags=re.S)


# A media box is a container that holds artwork. Narrowed on purpose: the
# audit must not fire on `.glyph-cell { aspect-ratio: 1 }`, which holds a
# character, not an image.
MEDIA_BOX = re.compile(
    r"(gallery|thumb|thumbnail|product-image|hero-art|shelf-art|featured-art|"
    r"gallery-main|artwork|preview-img|detail-image)", re.I)
# object-fit is only meaningful on a replaced element, but a future rule could
# put it on a wrapper; both spellings are audited when the selector names one of
# these containers or an img.
FIT_BOX = re.compile(r"img|" + MEDIA_BOX.pattern, re.I)


def css_audit():
    for name in CSS_FILES:
        raw = (ROOT / "static" / "redesign" / name).read_text(encoding="utf-8")
        css = strip_comments(raw)
        for match in re.finditer(r"([^{}]+)\{([^{}]*)\}", css):
            selector = " ".join(match.group(1).split())
            body = match.group(2)
            for prop in re.finditer(r"([a-z-]+)\s*:\s*([^;]+)", body):
                key, value = prop.group(1), " ".join(prop.group(2).split())
                if key == "object-fit" and FIT_BOX.search(selector):
                    check(value in ("contain", "scale-down"),
                          f"[css/{name}] `{selector}` sets object-fit: {value}; "
                          f"only contain/scale-down keep artwork whole")
                if key == "transform" and "scale(" in value and FIT_BOX.search(selector):
                    check(False,
                          f"[css/{name}] `{selector}` applies {value} to an image; "
                          f"a scaled image is cropped by its clipping parent")
                if key == "aspect-ratio" and MEDIA_BOX.search(selector):
                    check(value in ("auto", "3 / 2", "3/2"),
                          f"[css/{name}] `{selector}` sets aspect-ratio: {value}; "
                          f"a 1200x800 source stays whole only in a 3/2 or auto box")


# ------------------------------------------------------------- phases 2 and 3
GEOMETRY_BUILD = r"""
const posOffset = (pos, box, content) => {
  const parts = pos.split(/\s+/).filter(Boolean);
  const kx = parts[0] || '50%', ky = parts[1] || '50%';
  const val = (k, free) => {
    if (k === 'left' || k === 'top') return 0;
    if (k === 'center') return free / 2;
    if (k === 'right' || k === 'bottom') return free;
    if (k.endsWith('%')) return free * parseFloat(k) / 100;
    return parseFloat(k) || 0;
  };
  return [val(kx, box.w - content.w), val(ky, box.h - content.h)];
};
const clipAncestors = el => {
  const out = [];
  let node = el.parentElement;
  while (node && node !== document.documentElement) {
    const cs = getComputedStyle(node);
    // Per axis, and only hidden/clip. `overflow-x: hidden` makes overflow-y
    // compute to auto (CSS overflows-3), and body uses exactly that: counting
    // auto as clipping reported every card below the first viewport as cropped.
    const clipX = cs.overflowX === 'hidden' || cs.overflowX === 'clip';
    const clipY = cs.overflowY === 'hidden' || cs.overflowY === 'clip';
    if (clipX || clipY) {
      const r = node.getBoundingClientRect();
      out.push({ tag: node.tagName.toLowerCase(), cls: node.className || '',
                 x: r.x, y: r.y, w: r.width, h: r.height,
                 clipX: clipX, clipY: clipY });
    }
    node = node.parentElement;
  }
  return out;
};
const build = (img, i) => {
  const cs = getComputedStyle(img);
  const r = img.getBoundingClientRect();
  const nw = img.naturalWidth, nh = img.naturalHeight;
  const box = { w: img.clientWidth, h: img.clientHeight };
  let content = { w: box.w, h: box.h };
  if (nw && nh && box.w && box.h) {
    const sc = Math.min(box.w / nw, box.h / nh);
    const sv = Math.max(box.w / nw, box.h / nh);
    if (cs.objectFit === 'contain') content = { w: nw * sc, h: nh * sc };
    else if (cs.objectFit === 'cover') content = { w: nw * sv, h: nh * sv };
    else if (cs.objectFit === 'none') content = { w: nw, h: nh };
    else if (cs.objectFit === 'scale-down') {
      const s = Math.min(1, sc); content = { w: nw * s, h: nh * s };
    }
  }
  const off = posOffset(cs.objectPosition || '50% 50%', box, content);
  const ox = off[0], oy = off[1];
  const visW = Math.max(0, Math.min(box.w, ox + content.w) - Math.max(0, ox));
  const visH = Math.max(0, Math.min(box.h, oy + content.h) - Math.max(0, oy));
  return {
    i: i, src: img.currentSrc || img.src, alt: img.alt,
    natural: { w: nw, h: nh }, box: box, content: content,
    visible: { w: visW, h: visH },
    missing: { w: content.w - visW, h: content.h - visH },
    objectFit: cs.objectFit, objectPosition: cs.objectPosition,
    hidden: img.hidden, display: cs.display,
    layout: { x: r.x, y: r.y, w: r.width, h: r.height },
    clips: clipAncestors(img),
    classes: img.className, parent: (img.parentElement || {}).className || ''
  };
};
"""

GEOMETRY_ALL = "() => { " + GEOMETRY_BUILD + " return [...document.images].map(build); }"


def geometry_one(selector, index):
    """Geometry for one chosen element; `index` counts within `selector`.

    Addressing document.images[0] measured the brand mark instead of the probed
    card (three failures in the first run of this script were exactly that), so
    the probe and the pixel comparison must both address the element they
    actually changed.
    """
    return ("() => { " + GEOMETRY_BUILD
            + f" const el = document.querySelectorAll({json.dumps(selector)})[{index}];"
            + " return el ? [build(el, 0)] : []; }")


def where(m):
    parent = (str(m["parent"]).split() or ["?"])[0]
    own = (str(m["classes"]).split() or [""])[0]
    return f"{m['src'].split('/')[-1]} in .{parent}" + (f" (img.{own})" if own else "")


def undistorted(m):
    nw, nh = m["natural"]["w"], m["natural"]["h"]
    cw, ch = m["content"]["w"], m["content"]["h"]
    if not (nw and nh and cw and ch):
        return True
    sx, sy = cw / nw, ch / nh
    return abs(sx - sy) / sy < 0.01


def clipped(m, tol=SLOP_PX):
    """The first clipping ancestor the painted box escapes, if any.

    Only the axis that ancestor actually clips counts: a wide image inside a
    body that hides horizontal overflow is not cropped vertically.
    """
    for c in m["clips"]:
        if c["w"] <= 0 or c["h"] <= 0:
            continue
        over_x = max(c["x"] - m["layout"]["x"],
                     m["layout"]["x"] + m["layout"]["w"] - c["x"] - c["w"])
        over_y = max(c["y"] - m["layout"]["y"],
                     m["layout"]["y"] + m["layout"]["h"] - c["y"] - c["h"])
        over = max(over_x if c["clipX"] else 0.0, over_y if c["clipY"] else 0.0)
        if over > tol:
            return c, over
    return None, 0.0


def judge(prefix, m, hover=""):
    miss = max(m["missing"]["w"], m["missing"]["h"])
    check(miss <= SLOP_PX,
          f"{prefix}{hover}{where(m)}: whole source inside the content box "
          f"(missing {m['missing']['w']:.1f}x{m['missing']['h']:.1f}px, "
          f"fit={m['objectFit']}, box {m['box']['w']}x{m['box']['h']})")
    check(undistorted(m),
          f"{prefix}{hover}{where(m)}: uniform scale, no distortion "
          f"(fit={m['objectFit']} content {m['content']['w']:.1f}x{m['content']['h']:.1f} "
          f"vs source {m['natural']['w']}x{m['natural']['h']})")
    c, over = clipped(m)
    check(c is None,
          f"{prefix}{hover}{where(m)}: painted image inside its clipping container "
          f"(escapes {c['tag']}.{str(c['cls']).split()[0] or '-'} by {over:.1f}px)" if c
          else f"{prefix}{hover}{where(m)}: painted image inside its clipping container")
    check(m["natural"]["w"] > 0 and m["natural"]["h"] > 0,
          f"{prefix}{where(m)}: image file loaded ({m['natural']['w']}x{m['natural']['h']})")


SETTLE_JS = """
async () => {
  const step = Math.max(200, Math.round(window.innerHeight * 0.8));
  for (let y = 0; y < document.body.scrollHeight; y += step) {
    window.scrollTo(0, y);
    await new Promise(r => setTimeout(r, 25));
  }
  window.scrollTo(0, 0);
  await new Promise(r => setTimeout(r, 25));
}
"""


async def settle_images(page):
    """Scroll the page so `loading="lazy"` artwork actually loads.

    Without this, images below the fold report naturalWidth 0 and the check
    fails them as broken files. That was 8 of the first run's failures.
    """
    await page.evaluate(SETTLE_JS)
    try:
        await page.wait_for_function(
            "() => [...document.images].every(i => !i.getAttribute('src') "
            "|| (i.complete && i.naturalWidth > 0))", timeout=8000)
    except Exception:
        pass


# --------------------------------------------------------------------- phase 4
def png_bytes(w, h):
    """A probe with hard edges, so a crop is unmistakable in pixels."""
    img = Image.new("RGB", (w, h), (250, 250, 248))
    px = img.load()
    for x in range(w):
        for y in range(h):
            if x < 12 or y < 12 or x >= w - 12 or y >= h - 12:
                px[x, y] = (16, 17, 20)
            elif x < w // 2 and y < h // 2:
                px[x, y] = (96, 121, 215)
            elif x >= w // 2 and y < h // 2:
                px[x, y] = (232, 226, 214)
            elif x < w // 2:
                px[x, y] = (200, 60, 60)
            else:
                px[x, y] = (40, 140, 90)
    buf = io.BytesIO()
    img.save(buf, format="PNG")
    return buf.getvalue()


PROBE_URL = "p10-probe-1200x1000.png"
PROBE_W, PROBE_H = 1200, 1000


async def probe_real_element(page, selector, label, index=0):
    """Swap a real element's src for the probe, measure it, then restore."""
    count = await page.locator(selector).count()
    if count <= index:
        check(False, f"[probe/{label}] {selector} has {count} element(s); "
                     f"cannot probe index {index}")
        return None
    await page.eval_on_selector_all(
        selector,
        "(els, a) => { const el = els[a.i]; el.dataset.p10src = el.src;"
        " el.dataset.p10loading = el.loading || 'auto';"
        # Native lazy loading defers the fetch while the element sits far below the
        # fold, so a swapped src can stay unrequested and the wait below times out on
        # an element that never asked for the file. The probe measures geometry, not
        # the browser's scroll heuristic, so this one image is forced eager for the
        # duration of the measurement and put back afterwards.
        " el.loading = 'eager'; el.src = a.url; }",
        {"i": index, "url": PROBE_URL})
    await page.wait_for_function(
        "(a) => document.querySelectorAll(a.sel)[a.i].naturalWidth === a.w",
        arg={"sel": selector, "i": index, "w": PROBE_W}, timeout=8000)
    m = (await page.evaluate(geometry_one(selector, index)))[0]
    await page.eval_on_selector_all(
        selector, "(els, i) => { els[i].src = els[i].dataset.p10src; }", index)
    await page.wait_for_function(
        "(a) => document.querySelectorAll(a.sel)[a.i].naturalWidth > 0",
        arg={"sel": selector, "i": index}, timeout=8000)
    await page.eval_on_selector_all(
        selector,
        "(els, i) => { const el = els[i]; el.loading = el.dataset.p10loading || 'auto'; }",
        index)
    return m


# --------------------------------------------------------------------- phase 5
def source_path(url):
    path = url.split("://", 1)[-1]
    path = path[path.index("/"):] if "/" in path else path
    rel = path.lstrip("/")
    for cand in (ROOT / rel, ROOT / "static" / rel):
        if cand.exists():
            return cand
    return None


def mean_abs_diff(a: Image.Image, b: Image.Image) -> float:
    target = (240, max(1, round(240 * b.height / b.width)))
    a2 = np.asarray(a.convert("RGB").resize(target, Image.LANCZOS), dtype=np.int16)
    b2 = np.asarray(b.convert("RGB").resize(target, Image.LANCZOS), dtype=np.int16)
    return float(np.abs(a2 - b2).mean())


async def pixel_validate(label, page, selector, index=0):
    """Prove the geometry model matches real pixels, with a negative control."""
    m = (await page.evaluate(geometry_one(selector, index)))
    if not m:
        check(False, f"[pixels/{label}] {selector} index {index} not found")
        return
    m = m[0]
    path = source_path(m["src"])
    if path is None:
        check(False, f"[pixels/{label}] source file for {m['src']} not found on disk")
        return
    shot = Image.open(io.BytesIO(await page.locator(selector).nth(index).screenshot()))
    src = Image.open(path)

    nw, nh = m["natural"]["w"], m["natural"]["h"]
    crop_w = max(1, round(m["visible"]["w"] / m["content"]["w"] * nw))
    crop_h = max(1, round(m["visible"]["h"] / m["content"]["h"] * nh))
    visible_rect = src.crop((0, 0, crop_w, crop_h))
    # Negative control: same ratio, 70% of the content, so only edges differ.
    cw2, ch2 = max(1, round(crop_w * 0.7)), max(1, round(crop_h * 0.7))
    cx, cy = (crop_w - cw2) // 2, (crop_h - ch2) // 2
    control = src.crop((cx, cy, cx + cw2, cy + ch2))

    good = mean_abs_diff(shot, visible_rect)
    bad = mean_abs_diff(shot, control)
    check(good < 26,
          f"[pixels/{label}] the element screenshot matches the source rect the "
          f"geometry claims is visible (mean abs diff {good:.1f} < 26)")
    check(bad > good + 12,
          f"[pixels/{label}] the metric discriminates a crop: a 70% centred crop "
          f"scores {bad:.1f}, clearly worse than the correct match at {good:.1f}")
    info(f"pixels {label}: src={m['src']} natural={nw}x{nh} "
         f"rendered={m['box']['w']}x{m['box']['h']} fit={m['objectFit']} "
         f"diff_match={good:.1f} diff_crop={bad:.1f}")


# ------------------------------------------------------------------------ main
async def main() -> int:
    css_audit()
    errors = []

    async with async_playwright() as p:
        browser = await p.chromium.launch()
        ctx = await browser.new_context(viewport={"width": 1440, "height": 900})
        page = await ctx.new_page()
        page.on("pageerror", lambda e: errors.append(str(e)))
        page.on("console", lambda m: errors.append(m.text) if m.type == "error" else None)
        await page.route(f"**/{PROBE_URL}", lambda r: r.fulfill(
            status=200, content_type="image/png", body=png_bytes(PROBE_W, PROBE_H)))

        # -------------------------------------------- phases 2 and 3, six widths
        for name, path in PAGES:
            for width in WIDTHS:
                await page.set_viewport_size({"width": width, "height": 900})
                await page.goto(f"{BASE}{path}", wait_until="load")
                await page.wait_for_timeout(120)
                await settle_images(page)
                for m in await page.evaluate(GEOMETRY_ALL):
                    if m["hidden"] or m["display"] == "none" or not m["box"]["w"]:
                        continue
                    judge(f"[{name}@{width}] ", m)
                    if width == 1440:
                        inventory[f"{name} | {m['src'].split('/')[-1]}"] = (
                            f"source {m['natural']['w']}x{m['natural']['h']} "
                            f"rendered {m['box']['w']}x{m['box']['h']} "
                            f"fit={m['objectFit']} "
                            f"missing={m['missing']['w']:.1f}x{m['missing']['h']:.1f}px")

        # -------------------------------------------------------- phase 4, probe
        await page.set_viewport_size({"width": 1440, "height": 900})
        probes = [
            ("catalog card", "/catalog.html", ".product-image img", 0),
            ("product main", "/product.html?font=mango", "#detail-image", 0),
            ("product thumbnail", "/product.html?font=mango", ".thumbnail img", 0),
            ("home featured", "/index.html", ".featured-art img", 0),
            ("home row thumb", "/index.html", ".row-thumb img", 0),
            ("home gallery", "/index.html", ".gallery img", 0),
            ("brand mark", "/index.html", ".brand img", 0),
        ]
        for label, path, selector, index in probes:
            await page.goto(f"{BASE}{path}", wait_until="load")
            await page.wait_for_timeout(200)
            m = await probe_real_element(page, selector, label, index)
            if m is None:
                continue
            check(m["natural"]["w"] == PROBE_W and m["natural"]["h"] == PROBE_H,
                  f"[probe/{label}] the 1200x1000 probe actually loaded "
                  f"({m['natural']['w']}x{m['natural']['h']})")
            miss = max(m["missing"]["w"], m["missing"]["h"])
            check(miss <= SLOP_PX,
                  f"[probe/{label}] a 1200x1000 graphic keeps its whole area "
                  f"(missing {m['missing']['w']:.1f}x{m['missing']['h']:.1f}px, "
                  f"fit={m['objectFit']}, box {m['box']['w']}x{m['box']['h']})")
            check(undistorted(m), f"[probe/{label}] a 1200x1000 graphic is not distorted")
            info(f"probe {label}: fit={m['objectFit']} box={m['box']['w']}x{m['box']['h']} "
                 f"missing={m['missing']['w']:.1f}x{m['missing']['h']:.1f}px")

        # ------------------------------------------------------- phase 5, pixels
        await page.set_viewport_size({"width": 1440, "height": 900})
        await page.goto(f"{BASE}/catalog.html", wait_until="load")
        await page.wait_for_timeout(200)
        await pixel_validate("catalog@1440", page, ".product-image img", 0)
        await page.goto(f"{BASE}/product.html?font=chronoa", wait_until="load")
        await page.wait_for_timeout(200)
        await pixel_validate("product-main@1440", page, "#detail-image", 0)
        await page.goto(f"{BASE}/index.html", wait_until="load")
        await page.wait_for_timeout(200)
        await pixel_validate("home-featured@1440", page, ".featured-art img", 0)
        await page.set_viewport_size({"width": 390, "height": 900})
        await page.goto(f"{BASE}/index.html", wait_until="load")
        await page.wait_for_timeout(200)
        await pixel_validate("home-featured@390", page, ".featured-art img", 0)

        # --------------------------------------------------- hover must not zoom
        await page.set_viewport_size({"width": 1440, "height": 900})
        await page.goto(f"{BASE}/catalog.html", wait_until="load")
        await page.wait_for_timeout(150)
        before = (await page.evaluate(GEOMETRY_ALL))[0]
        await page.locator(".product").first.hover()
        await page.wait_for_timeout(350)
        after = (await page.evaluate(GEOMETRY_ALL))[0]
        check(abs(after["layout"]["w"] - before["layout"]["w"]) < SLOP_PX
              and abs(after["layout"]["h"] - before["layout"]["h"]) < SLOP_PX,
              f"[hover/catalog] hovering a card does not scale the artwork "
              f"({before['layout']['w']:.1f}x{before['layout']['h']:.1f} -> "
              f"{after['layout']['w']:.1f}x{after['layout']['h']:.1f})")
        judge("[hover/catalog] ", after, hover="(on hover) ")

        await page.goto(f"{BASE}/product.html?font=chronoa", wait_until="load")
        await page.wait_for_timeout(150)
        main_before = (await page.evaluate(GEOMETRY_ALL))[0]
        await page.locator("#detail-image").hover()
        await page.wait_for_timeout(350)
        main_after = (await page.evaluate(GEOMETRY_ALL))[0]
        check(abs(main_after["layout"]["w"] - main_before["layout"]["w"]) < SLOP_PX,
              f"[hover/product] hovering the main artwork does not scale it "
              f"({main_before['layout']['w']:.1f} -> {main_after['layout']['w']:.1f})")

        # ------------------------------------------------ lightbox: none exists
        has_dialog = await page.evaluate(
            "() => document.querySelectorAll('dialog, [class*=lightbox], [id*=lightbox]').length")
        check(has_dialog == 0,
              f"[lightbox] no lightbox exists in this preview ({has_dialog} found), so no "
              f"step can crop there; the sweeps above enumerate every rendered image, "
              f"so a lightbox added by P13 is asserted automatically")
        info(f"lightbox: {has_dialog} dialog/lightbox element(s) on the font detail page")

        await browser.close()

    for m in sorted(set(errors)):
        check(False, f"page/console error on the preview pages: {m[:120]}")

    passed = sum(1 for ok, _ in results if ok)
    total = len(results)
    print(f"\n=== artwork integrity: {passed}/{total} PASS ===\n")
    for ok, label in results:
        if not ok:
            print(f"FAIL  {label}")
    print()
    for line in notes:
        print(f"note  {line}")
    if passed == total:
        print(f"\nall {total} assertions passed")
    print("\n--- INVENTORY: actual image URL, source size, rendered size @1440 ---")
    for key in sorted(inventory):
        print(f"{key}: {inventory[key]}")
    return 0 if passed == total else 1


if __name__ == "__main__":
    sys.exit(asyncio.run(main()))
