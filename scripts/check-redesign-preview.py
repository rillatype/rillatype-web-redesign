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
        assert page.locator(".product:visible").count() == 8
        page.get_by_role("button", name="Script", exact=True).click()
        assert page.locator(".product:visible").count() == 2
        assert page.locator("#result-count").is_visible()
        assert page.locator("#result-count").inner_text() == "2 fonts in this preview"
        assert not page.locator(".lead-collection").is_visible()
        page.get_by_role("button", name="Serif", exact=True).click()
        assert page.locator(".product:visible").count() == 3
        assert page.get_by_role("heading", name="Bawden", exact=True).is_visible()
        page.get_by_role("button", name="All fonts", exact=True).click()
        page.get_by_label("Find a font").fill("rough")
        assert page.locator(".product:visible").count() == 1
        assert page.get_by_role("heading", name="Bawden", exact=True).is_visible()
        page.get_by_label("Find a font").fill("handwritten")
        assert page.locator(".product:visible").count() == 2
        page.get_by_label("Find a font").fill("Mango")
        assert page.locator(".product:visible").count() == 1
        assert page.get_by_role("heading", name="Mango Letters", exact=True).is_visible()
        page.get_by_role("button", name="Search", exact=True).click()
        result_top = page.locator("#mango").bounding_box()["y"]
        header = page.locator("header").bounding_box()
        assert header["y"] + header["height"] - 1 <= result_top < 900
        page.get_by_label("Find a font").fill("no-such-font")
        assert page.get_by_role("heading", name="No fonts found").is_visible()
        assert page.locator("#result-count").is_visible()
        assert page.locator("#result-count").inner_text() == "0 fonts in this preview"
        page.get_by_role("button", name="Show all fonts").click()
        assert page.locator(".product:visible").count() == 8
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
        assert page.locator(".product > a").count() == 8
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
            "bawden": "Bawden", "mango": "Mango Letters", "baldock": "Baldock",
            "daisy": "Daisy Hotline", "crimson": "Crimson Queen", "mordial": "Mordial",
            "moyshire": "Moyshire", "radiant": "Radiant Summertime",
        }
        hrefs = set(page.locator('.product a[href^="product.html"]').evaluate_all("links => links.map(a => a.getAttribute('href'))"))
        assert len(hrefs) == 8
        for slug, name in expected_products.items():
            href = f"product.html?font={slug}"
            assert href in hrefs
            detail.goto(urljoin(args.url, href), wait_until="networkidle")
            assert detail.get_by_role("heading", name=name, exact=True).is_visible()
            assert detail.locator("#detail-image").evaluate("image => image.complete && image.naturalWidth > 0")
            assert detail.get_by_role("button", name="Preview selection").is_disabled()
        mango_url = urljoin(args.url, "product.html?font=mango")
        detail.goto(mango_url, wait_until="networkidle")
        assert detail.locator("#font-status").inner_text() == "Showing the actual Mango Letters font."
        detail.get_by_label("Extended License", exact=False).check()
        assert detail.locator("#product-price").inner_text() == "Demo $36"
        detail.get_by_role("button", name="Preview selection").click()
        assert "Extended License selected" in detail.locator("#selection-status").inner_text()
        detail.get_by_role("button", name="Preview 3", exact=True).click()
        assert detail.locator("#detail-image").get_attribute("src").endswith("mango-3.jpg")
        detail.get_by_label("Your sample text").fill("<b>Plain text</b>")
        assert detail.locator("#sample-output").inner_text() == "<b>Plain text</b>"
        assert detail.locator("#sample-output b").count() == 0
        detail.get_by_role("slider").focus()
        detail.get_by_role("slider").press("ArrowRight")
        assert detail.locator("#sample-output").evaluate("e => e.style.fontSize") == "65px"
        detail.get_by_role("link", name="Choose a license", exact=True).click()
        license_top = detail.locator("#license-form").bounding_box()["y"]
        detail_header = detail.locator("header").bounding_box()
        assert detail_header["y"] + detail_header["height"] - 1 <= license_top < 900
        detail.get_by_label("Your sample text").fill("Your next big idea.")
        detail.get_by_role("button", name="Preview 1", exact=True).click()
        detail.get_by_label("Standard License", exact=False).check()
        for width, height, label in [(1440, 900, "desktop"), (390, 844, "mobile")]:
            detail.set_viewport_size({"width": width, "height": height})
            assert not detail.evaluate("document.documentElement.scrollWidth > innerWidth"), f"product {width}"
            detail.evaluate("window.scrollTo(0, 0)")
            detail.wait_for_function("Array.from(document.images).every(i => i.complete && i.naturalWidth > 0)")
            if args.screenshots:
                detail.screenshot(path=str(args.screenshots / f"rillatype-product-{label}.png"), full_page=True)
        detail.goto(urljoin(args.url, "product.html?font=__proto__"), wait_until="networkidle")
        assert detail.get_by_role("heading", name="Font not found", exact=True).is_visible()
        assert not detail.locator("#product-content").is_visible()
        detail.get_by_role("button", name="Menu", exact=True).click()
        detail.get_by_role("link", name="Licenses", exact=True).click()
        assert detail.url.endswith("index.html#licenses")
        detail.route("**/mango-letter.otf", lambda route: route.abort())
        detail.goto(mango_url, wait_until="networkidle")
        assert detail.get_by_role("button", name="Retry font", exact=True).is_visible()
        assert not detail.locator("#sample-output").is_visible()
        detail.unroute("**/mango-letter.otf")
        detail.get_by_role("button", name="Retry font", exact=True).click()
        detail.wait_for_function("document.querySelector('#font-status').textContent === 'Showing the actual Mango Letters font.'")
        assert detail.locator("#sample-output").is_visible()
        assert not errors, errors
        browser.close()
    print("PASS: homepage search and layout, 8 product routes, gallery, demo license selection, actual font tester, unknown route, font failure/retry, and browser errors")


if __name__ == "__main__":
    main()
