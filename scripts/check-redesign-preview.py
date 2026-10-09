"""Check the editorial preview. Run node server.js first.

Usage: python scripts/check-redesign-preview.py
Requires the locally installed Playwright package and Chromium.
"""

import argparse
from pathlib import Path
from urllib.parse import urljoin

from playwright.sync_api import sync_playwright


def main():
    parser = argparse.ArgumentParser()
    parser.add_argument("--url", default="http://localhost:9402/static/redesign/index.html")
    parser.add_argument("--screenshots", type=Path)
    args = parser.parse_args()
    if args.screenshots and not args.screenshots.is_dir():
        parser.error("Screenshot directory must already exist.")

    with sync_playwright() as playwright:
        browser = playwright.chromium.launch()
        page = browser.new_page(viewport={"width": 1440, "height": 900})
        errors = []
        page.on("pageerror", lambda error: errors.append(str(error)))
        page.goto(args.url, wait_until="networkidle")
        page.evaluate("document.fonts.ready")
        assert page.evaluate("Array.from(document.fonts).some(f => f.family === 'Manrope' && f.status === 'loaded')")
        assert page.locator("header #font-search").count() == 1
        assert not page.get_by_role("button", name="Menu", exact=True).is_visible()
        assert page.locator(".product:visible").count() == 20
        page.get_by_label("Find a font").fill("rough")
        assert page.locator(".product:visible").count() == 1
        assert page.get_by_role("heading", name="Bawden", exact=True).is_visible()
        page.get_by_label("Find a font").fill("handwritten")
        assert page.locator(".product:visible").count() == 3
        page.get_by_label("Find a font").fill("geometric")
        assert page.locator(".product:visible").count() == 1
        assert page.get_by_role("heading", name="Chronoa", exact=True).is_visible()
        page.get_by_label("Find a font").fill("Mango")
        assert page.locator(".product:visible").count() == 2
        assert page.locator("#mango").is_visible()
        page.get_by_role("button", name="Search", exact=True).click()
        result_top = page.locator("#mango").bounding_box()["y"]
        header = page.locator("header").bounding_box()
        assert header["y"] + header["height"] - 1 <= result_top < 900
        page.get_by_label("Find a font").fill("no-such-font")
        assert page.get_by_role("heading", name="No products found").is_visible()
        assert page.locator("#result-count").is_visible()
        assert page.locator("#result-count").inner_text() == "0 items in this preview"
        page.get_by_role("button", name="Show all").click()
        assert page.locator(".product:visible").count() == 20
        for width in (320, 390, 768, 1024, 1440):
            page.set_viewport_size({"width": width, "height": 900})
            assert not page.evaluate("document.documentElement.scrollWidth > innerWidth"), width
        page.get_by_label("Find a font").blur()
        page.mouse.move(0, 0)
        for width, height, label in [(1440, 900, "desktop"), (390, 844, "mobile")]:
            page.set_viewport_size({"width": width, "height": height})
            page.evaluate("window.scrollTo(0, document.body.scrollHeight)")
            assert 0 <= page.get_by_label("Find a font").bounding_box()["y"] < height
            page.wait_for_function("Array.from(document.images).every(i => i.complete && i.naturalWidth > 0)")
            page.evaluate("window.scrollTo(0, 0)")
            if args.screenshots:
                page.screenshot(path=str(args.screenshots / f"rillatype-home-{label}.png"), full_page=True)
        menu = page.get_by_role("button", name="Menu", exact=True)
        menu.click()
        assert menu.get_attribute("aria-expanded") == "true"
        page.keyboard.press("Escape")
        assert menu.get_attribute("aria-expanded") == "false"
        page.emulate_media(reduced_motion="reduce")
        assert page.locator(".product-image img").first.evaluate("e => getComputedStyle(e).transitionDuration") == "0s"
        fallback = browser.new_page(viewport={"width": 390, "height": 844})
        fallback.route("**/manrope.ttf", lambda route: route.abort())
        fallback.goto(args.url, wait_until="networkidle")
        assert fallback.get_by_role("heading", name="Type, with perspective.").is_visible()
        assert not fallback.evaluate("document.documentElement.scrollWidth > innerWidth")
        fallback.close()
        assert page.locator(".product > a").count() == 20
        assert page.locator(".product a a, .product a button").count() == 0
        page.locator(".lead-information").click()
        page.wait_for_url(urljoin(args.url, "product.html?font=bawden"), wait_until="networkidle")
        assert page.url.endswith("product.html?font=bawden")
        assert page.get_by_role("heading", name="Bawden", exact=True).is_visible()
        page.go_back(wait_until="networkidle")
        page.locator(".lead-card-link").focus()
        page.keyboard.press("Enter")
        page.wait_for_url(urljoin(args.url, "product.html?font=bawden"), wait_until="networkidle")
        assert page.url.endswith("product.html?font=bawden")
        page.go_back(wait_until="networkidle")
        page.locator(".collection .product-info").first.click()
        page.wait_for_url(urljoin(args.url, "product.html?font=mango"), wait_until="networkidle")
        assert page.url.endswith("product.html?font=mango")
        page.go_back(wait_until="networkidle")

        detail = browser.new_page(viewport={"width": 1440, "height": 900})
        detail.on("pageerror", lambda error: errors.append(str(error)))
        expected_products = {
            "bawden": "Bawden", "mango": "Mango Letters", "chronoa": "Chronoa",
            "baldock": "Baldock", "daisy": "Daisy Hotline", "crimson": "Crimson Queen",
            "mordial": "Mordial", "moyshire": "Moyshire", "radiant": "Radiant Summertime",
        }
        hrefs = set(page.locator('.product a[href^="product.html"]').evaluate_all("links => links.map(a => a.getAttribute('href'))"))
        assert len(hrefs) == 16
        for slug, name in expected_products.items():
            href = f"product.html?font={slug}"
            assert href in hrefs
            detail.goto(urljoin(args.url, href), wait_until="networkidle")
            assert detail.get_by_role("heading", name=name, exact=True).is_visible()
            assert detail.locator("#detail-image").evaluate("image => image.complete && image.naturalWidth > 0")
            assert detail.get_by_role("button", name="Preview selection").is_disabled()

        # Tester Mango: specimen tunggal.
        mango_url = urljoin(args.url, "product.html?font=mango")
        detail.goto(mango_url, wait_until="networkidle")
        assert "Mango Letters" in detail.locator("#font-status").inner_text()
        detail.get_by_label("Extended License", exact=False).check()
        assert detail.locator("#product-price").inner_text() == "Demo $36"
        detail.get_by_role("button", name="Preview selection").click()
        assert "Extended License selected" in detail.locator("#selection-status").inner_text()
        detail.get_by_role("button", name="Preview 3", exact=True).click()
        assert detail.locator("#detail-image").get_attribute("src").endswith("mango-3.jpg")
        detail.get_by_label("Sample text").fill("<b>Plain text</b>")
        assert detail.locator("#sample-output").inner_text() == "<b>Plain text</b>"
        assert detail.locator("#sample-output b").count() == 0

        # Tester Chronoa: sembilan style dan fitur lengkap.
        chronoa_url = urljoin(args.url, "product.html?font=chronoa")
        detail.goto(chronoa_url, wait_until="networkidle")
        assert "9 styles available" in detail.locator("#font-status").inner_text()
        assert detail.locator("#tester-frame").is_visible()
        assert detail.locator("#style-field").is_visible()
        assert detail.get_by_label("Style").locator("option").count() == 9

        # Slider ukuran mengubah specimen.
        size = detail.locator("#sample-size")
        size.focus()
        for _ in range(5):
            size.press("ArrowRight")
        assert detail.locator("#sample-output").evaluate("e => e.style.fontSize") == "69px"
        assert detail.locator("#size-value").inner_text() == "69 px"

        # Slider leading mengubah line-height.
        leading = detail.locator("#sample-leading")
        leading.focus()
        for _ in range(4):
            leading.press("ArrowRight")
        assert detail.locator("#sample-output").evaluate("e => e.style.lineHeight") == "1.4"
        assert detail.locator("#leading-value").inner_text() == "1.40"

        # Slider tracking mengubah letter-spacing.
        tracking = detail.locator("#sample-tracking")
        tracking.focus()
        for _ in range(10):
            tracking.press("ArrowRight")
        assert detail.locator("#sample-output").evaluate("e => e.style.letterSpacing") == "0.1em"
        assert detail.locator("#tracking-value").inner_text() == "0.10 em"

        # Ganti style mengubah bobot.
        detail.get_by_label("Style").select_option(label="Black")
        assert detail.locator("#sample-output").evaluate("e => e.style.fontWeight") == "900"
        detail.get_by_label("Style").select_option(label="Thin")
        assert detail.locator("#sample-output").evaluate("e => e.style.fontWeight") == "100"
        detail.get_by_label("Style").select_option(label="Regular")

        # Perataan.
        detail.get_by_role("radio", name="Center").check()
        assert detail.locator("#sample-output").get_attribute("data-align") == "center"
        assert detail.locator("#sample-output").evaluate("e => getComputedStyle(e).textAlign") == "center"
        detail.get_by_role("radio", name="Right").check()
        assert detail.locator("#sample-output").evaluate("e => getComputedStyle(e).textAlign") == "right"
        detail.get_by_role("radio", name="Left", exact=True).check()

        # Latar gelap membalik warna. Tunggu transisi selesai sebelum membaca nilai.
        detail.wait_for_function("getComputedStyle(document.querySelector('#tester-stage')).transitionDuration !== '0s'")
        light_bg = detail.locator("#tester-stage").evaluate("e => getComputedStyle(e).backgroundColor")
        detail.get_by_role("radio", name="Dark").check()
        detail.wait_for_function(
            "getComputedStyle(document.querySelector('#tester-stage')).backgroundColor === 'rgb(16, 19, 24)'"
        )
        dark_bg = detail.locator("#tester-stage").evaluate("e => getComputedStyle(e).backgroundColor")
        assert light_bg != dark_bg
        assert dark_bg == "rgb(16, 19, 24)"
        assert detail.locator("#sample-output").evaluate("e => getComputedStyle(e).color") == "rgb(245, 247, 250)"
        detail.get_by_role("radio", name="Light").check()
        detail.wait_for_function(
            "getComputedStyle(document.querySelector('#tester-stage')).backgroundColor === 'rgb(255, 255, 255)'"
        )

        # Fitur OpenType dideteksi dari berkas dan dinyatakan tidak tersedia pada Chronoa.
        assert detail.locator("#liga-switch").get_attribute("title").startswith("Ligatures is not included in Chronoa")
        assert detail.locator("#opentype-liga").is_disabled()
        assert detail.locator("#opentype-salt").is_disabled()
        assert detail.locator("#liga-switch .switch-note").inner_text() == "Not in Chronoa"
        assert detail.locator("#salt-switch .switch-note").inner_text() == "Not in Chronoa"

        # Panel glyph dapat dibuka dan ditutup.
        assert not detail.locator("#glyph-grid").is_visible()
        closed_height = detail.locator(".tester").bounding_box()["height"]
        detail.locator(".tester-glyphs summary").click()
        assert detail.locator("#glyph-grid").is_visible()
        assert detail.locator("#glyph-count").inner_text() == "218 characters"
        assert detail.locator(".glyph-cell").count() == 218
        detail.locator(".tester-glyphs summary").click()
        assert not detail.locator("#glyph-grid").is_visible()
        assert abs(detail.locator(".tester").bounding_box()["height"] - closed_height) < 1

        # Tester berada sebelum pemilih lisensi.
        tester_top = detail.locator(".tester").bounding_box()["y"]
        license_top = detail.locator("#license-form").bounding_box()["y"]
        assert tester_top < license_top

        for width, height, label in [(1440, 900, "desktop"), (390, 844, "mobile")]:
            detail.set_viewport_size({"width": width, "height": height})
            assert not detail.evaluate("document.documentElement.scrollWidth > innerWidth"), f"product {width}"
            detail.evaluate("window.scrollTo(0, 0)")
            detail.wait_for_function("Array.from(document.images).every(i => i.complete && i.naturalWidth > 0)")
            if args.screenshots:
                detail.screenshot(path=str(args.screenshots / f"rillatype-product-{label}.png"), full_page=True)

        # Font tanpa specimen menampilkan keterangan dan tidak menampilkan kontrol palsu.
        detail.goto(urljoin(args.url, "product.html?font=baldock"), wait_until="networkidle")
        assert "No specimen file is available" in detail.locator("#font-status").inner_text()
        assert not detail.locator("#tester-frame").is_visible()

        detail.goto(urljoin(args.url, "product.html?font=__proto__"), wait_until="networkidle")
        assert detail.get_by_role("heading", name="Font not found", exact=True).is_visible()
        assert not detail.locator("#product-content").is_visible()
        detail.get_by_role("button", name="Menu", exact=True).click()
        detail.get_by_role("link", name="Licenses", exact=True).click()
        assert detail.url.endswith("index.html#licenses")

        detail.route("**/Chronoa-Regular.otf", lambda route: route.abort())
        detail.goto(chronoa_url, wait_until="networkidle")
        assert detail.get_by_role("button", name="Retry font", exact=True).is_visible()
        assert not detail.locator("#tester-frame").is_visible()
        detail.unroute("**/Chronoa-Regular.otf")
        detail.get_by_role("button", name="Retry font", exact=True).click()
        detail.wait_for_function("document.querySelector('#font-status').textContent.includes('9 styles available')")
        assert detail.locator("#tester-frame").is_visible()

        # Katalog: halaman semua produk dengan filter dan tag.
        catalog = browser.new_page(viewport={"width": 1440, "height": 900})
        catalog.on("pageerror", lambda error: errors.append(str(error)))
        catalog.goto(urljoin(args.url, "catalog.html"), wait_until="networkidle")
        assert catalog.get_by_role("heading", name="All products", exact=True).is_visible()
        assert catalog.locator(".product:visible").count() == 16
        # Filter kategori.
        catalog.get_by_role("button", name="Fonts", exact=True).click()
        assert catalog.locator(".product:visible").count() == 9
        catalog.get_by_role("button", name="Brushes", exact=True).click()
        assert catalog.locator(".product:visible").count() == 3
        catalog.get_by_role("button", name="Graphics", exact=True).click()
        assert catalog.locator(".product:visible").count() == 2
        catalog.get_by_role("button", name="Bundles", exact=True).click()
        assert catalog.locator(".product:visible").count() == 2
        catalog.get_by_role("button", name="All", exact=True).click()
        assert catalog.locator(".product:visible").count() == 16
        # Filter tag.
        catalog.get_by_role("button", name="Sale", exact=True).click()
        assert catalog.locator(".product:visible").count() == 3
        catalog.get_by_role("button", name="Free", exact=True).click()
        assert catalog.locator(".product:visible").count() == 2
        catalog.get_by_role("button", name="New", exact=True).click()
        assert catalog.locator(".product:visible").count() == 7
        catalog.get_by_role("button", name="All", exact=True).click()
        # Query param ?tag=sale.
        catalog.goto(urljoin(args.url, "catalog.html?tag=sale"), wait_until="networkidle")
        assert catalog.locator(".product:visible").count() == 3
        # Pencarian (halaman segar agar tag reset).
        catalog.goto(urljoin(args.url, "catalog.html"), wait_until="networkidle")
        catalog.get_by_label("Find a product").fill("brush")
        assert catalog.locator(".product:visible").count() == 3
        catalog.get_by_label("Find a product").fill("no-such-item")
        assert catalog.get_by_role("heading", name="No products found").is_visible()
        catalog.get_by_role("button", name="Show all products").click()
        assert catalog.locator(".product:visible").count() == 16
        # Link dari homepage.
        page.goto(args.url, wait_until="networkidle")
        assert page.locator(".section-link").count() == 5
        assert page.locator(".section-link").first.get_attribute("href") == "catalog.html"
        # Responsif.
        for width in (320, 390, 768, 1024, 1440):
            catalog.set_viewport_size({"width": width, "height": 900})
            assert not catalog.evaluate("document.documentElement.scrollWidth > innerWidth"), width
        if args.screenshots:
            catalog.set_viewport_size({"width": 1440, "height": 900})
            catalog.evaluate("window.scrollTo(0, 0)")
            catalog.wait_for_function("Array.from(document.images).every(i => i.complete && i.naturalWidth > 0)")
            catalog.screenshot(path=str(args.screenshots / "rillatype-catalog-desktop.png"), full_page=True)
            catalog.set_viewport_size({"width": 390, "height": 844})
            catalog.evaluate("window.scrollTo(0, 0)")
            catalog.screenshot(path=str(args.screenshots / "rillatype-catalog-mobile.png"), full_page=True)
        catalog.close()
        assert not errors, errors
        browser.close()
    print("PASS: homepage search and layout, 9 product routes, gallery, demo license, Chronoa 9-style tester "
          "(size, leading, tracking, style, align, theme, OpenType detection, glyph panel), Mango tester, "
          "missing-specimen state, unknown route, font failure/retry, catalog page (filters, tags, search, query params), "
          "and browser errors")


if __name__ == "__main__":
    main()
