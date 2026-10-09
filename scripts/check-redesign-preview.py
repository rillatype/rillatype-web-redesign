"""Check the static redesign preview through a real browser.

Run the preview server first: node server.js
Then run: python scripts/check-redesign-preview.py
Requires the locally installed Playwright package and Chromium.
"""

import argparse
from pathlib import Path

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
        assert not page.get_by_role("button", name="Menu", exact=True).is_visible()
        assert page.locator(".product:visible").count() == 8
        assert page.get_by_label("Find a font").bounding_box()["y"] < 900
        assert page.locator(".intro-feature .product-image").bounding_box()["y"] < 900
        page.get_by_role("button", name="Serif", exact=True).click()
        assert page.locator(".product:visible").count() == 3
        assert not page.locator(".intro-feature").is_visible()
        for width in (320, 768, 1024, 1440):
            page.set_viewport_size({"width": width, "height": 900})
            assert not page.evaluate("document.documentElement.scrollWidth > innerWidth"), f"filtered {width}px"
        page.set_viewport_size({"width": 1440, "height": 900})
        page.get_by_role("button", name="All fonts", exact=True).click()
        page.get_by_label("Find a font").fill("Mango")
        assert page.locator(".product:visible").count() == 1
        assert page.get_by_role("heading", name="Mango Letters", exact=True).is_visible()
        page.get_by_label("Find a font").fill("handwritten")
        assert page.locator(".product:visible").count() == 1
        assert page.get_by_role("heading", name="Mango Letters", exact=True).is_visible()
        page.get_by_role("button", name="Search", exact=True).click()
        assert 0 <= page.locator(".intro-feature").bounding_box()["y"] < 900
        page.get_by_label("Find a font").fill("no-such-font")
        assert page.get_by_role("heading", name="No fonts found").is_visible()
        page.get_by_role("button", name="Show all fonts").click()
        assert page.locator(".product:visible").count() == 8

        page.get_by_label("Find a font").blur()
        page.mouse.move(0, 0)
        for width, height, label in [(1440, 900, "desktop"), (390, 844, "mobile")]:
            page.set_viewport_size({"width": width, "height": height})
            page.evaluate("window.scrollTo(0, document.body.scrollHeight)")
            page.wait_for_function("Array.from(document.images).every(i => i.complete && i.naturalWidth > 0)")
            page.evaluate("window.scrollTo(0, 0)")
            assert not page.evaluate("document.documentElement.scrollWidth > innerWidth"), label
            if args.screenshots:
                page.screenshot(path=str(args.screenshots / f"rillatype-home-{label}.png"), full_page=True)

        menu = page.get_by_role("button", name="Menu", exact=True)
        menu.click()
        assert menu.get_attribute("aria-expanded") == "true"
        page.keyboard.press("Escape")
        assert menu.get_attribute("aria-expanded") == "false"
        page.emulate_media(reduced_motion="reduce")
        assert page.locator(".product-image img").first.evaluate("e => getComputedStyle(e).transitionDuration") == "0s"
        assert not errors, errors
        browser.close()
    print("PASS: search, filters, empty state, mobile menu, images, overflow, reduced motion, and browser errors")


if __name__ == "__main__":
    main()
