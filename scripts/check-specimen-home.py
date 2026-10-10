"""Verify the Specimen Hall homepage over HTTP.

Covers the live specimen (load, cut switch, weight switch, typing, failure),
the collection search, the mobile menu, keyboard focus, responsive width,
image loading, and console errors.

Usage: python scripts/check-specimen-home.py [base-url]
"""
import asyncio
import sys
from pathlib import Path

from playwright.async_api import async_playwright

BASE = sys.argv[1] if len(sys.argv) > 1 else "http://127.0.0.1:9402/static/redesign/index.html"
SHOTS = Path(".impeccable/review")
SHOTS.mkdir(parents=True, exist_ok=True)

results: list[tuple[bool, str]] = []


def check(ok: bool, label: str) -> bool:
    results.append((bool(ok), label))
    print(f"{'PASS' if ok else 'FAIL'}  {label}", flush=True)
    return bool(ok)


async def new_page(browser, width, height, url=BASE):
    ctx = await browser.new_context(viewport={"width": width, "height": height}, device_scale_factor=1)
    page = await ctx.new_page()
    errors: list[str] = []
    page.on("console", lambda m: errors.append(f"console.{m.type}: {m.text}") if m.type == "error" else None)
    page.on("pageerror", lambda e: errors.append(f"pageerror: {e}"))
    page.on("requestfailed", lambda r: errors.append(f"requestfailed: {r.url}"))
    await page.goto(url, wait_until="load")
    return ctx, page, errors


async def capture(page, name: str) -> None:
    """Scroll the whole page once so lazy images decode, then shoot it.

    Every wait is bounded: an image that never fires load or error must not be
    able to stall the suite.
    """
    print(f"...capturing {name}", flush=True)
    try:
        await page.evaluate("window.scrollTo(0, document.body.scrollHeight)")
        for _ in range(40):
            pending = await page.evaluate(
                "() => [...document.images].filter(i => !i.complete || i.naturalWidth === 0).length"
            )
            if pending == 0:
                break
            await page.wait_for_timeout(250)
        await page.evaluate("window.scrollTo(0, 0)")
        await page.wait_for_timeout(400)
    except Exception as error:  # a capture must never hide the check results
        print(f"...capture warning: {error}", flush=True)
    await page.screenshot(path=str(SHOTS / name), full_page=True)
    print(f"...captured {name}", flush=True)


async def main() -> int:
    async with async_playwright() as p:
        browser = await p.chromium.launch()
        # ---------------------------------------------------------- desktop
        ctx, page, errors = await new_page(browser, 1440, 900)

        check(await page.locator("h1").inner_text() == "Rillatype.", "masthead identifies the foundry")
        check(await page.locator(".featured-art img").is_visible(), "featured font shows real product artwork")

        # the specimen loads once it is near the viewport
        await page.wait_for_function("() => document.querySelector('#specimen-frame').dataset.state === 'ready'", timeout=15000)
        check(True, "specimen loads its real font file")
        family = await page.eval_on_selector("#specimen-line", "el => getComputedStyle(el).fontFamily")
        check("Rilla-Chronoa" in family, "specimen line is set in the shipped Chronoa face")
        weight = await page.eval_on_selector("#specimen-line", "el => getComputedStyle(el).fontWeight")
        check(weight == "600", f"specimen starts on SemiBold (got {weight})")
        facts = await page.locator("#specimen-facts").inner_text()
        check("219 glyphs" in facts, f"specimen states the real glyph count ({facts})")

        # typing over the line
        await page.click("#specimen-line")
        await page.keyboard.press("Control+A")
        await page.keyboard.type("Bloom Club")
        typed = (await page.locator("#specimen-line").inner_text()).strip()
        check(typed == "Bloom Club", f"typing drives the specimen (got {typed!r})")

        # weight switch loads a different cut
        await page.locator("#weight-picker label", has_text="300").first.click()
        await page.wait_for_function("() => getComputedStyle(document.querySelector('#specimen-line')).fontWeight === '300'", timeout=15000)
        check("Light" in await page.locator("#specimen-facts").inner_text(), "weight switch loads and applies the Light cut")
        check((await page.locator("#specimen-line").inner_text()).strip() == "Bloom Club", "switching a cut never overwrites what the visitor typed")

        # cut switch to Mango
        await page.locator("#cut-picker label", has_text="Mango").first.click()
        await page.wait_for_function("() => document.querySelector('#specimen-facts').textContent.includes('Mango')", timeout=15000)
        check(await page.locator("#weight-picker").is_hidden(), "Mango hides the weight picker because it has one cut")
        check("discretionary ligatures" in await page.locator("#specimen-facts").inner_text(), "Mango reports its real OpenType feature")

        # back to Chronoa default
        await page.locator("#cut-picker label", has_text="Chronoa").first.click()
        await page.wait_for_function("() => document.querySelector('#specimen-facts').textContent.includes('SemiBold')", timeout=15000)
        check(True, "switching back restores the Chronoa default cut")

        # specimen strips load below the fold
        await page.evaluate("window.scrollTo(0, 900)")
        await page.wait_for_timeout(1200)
        # The strips are built from data now, so they are addressed by class
        # rather than by the name of a cut (P11 removed the #strip-<cut> ids).
        strips = await page.eval_on_selector_all(
            ".strip-sample", "els => els.map(el => getComputedStyle(el).fontFamily)")
        check(strips and all("Rilla-Chronoa" in family for family in strips),
              f"specimen strips use the shipped face ({strips[:2]})")
        try:
            await page.wait_for_function(
                "() => getComputedStyle(document.querySelector('.row[data-name=\"Mango Letters\"] .row-name')).fontFamily.includes('Rilla-Mango')",
                timeout=8000,
            )
            check(True, "the index applies the Mango face to its row")
        except Exception:
            check(False, "the index applies the Mango face to its row")
        try:
            await page.wait_for_function(
                "() => [...document.fonts].some(f => f.family === 'Rilla-Mango' && f.status === 'loaded')",
                timeout=8000,
            )
            check(True, "the Mango index row really renders its own font file")
        except Exception:
            check(False, "the Mango index row really renders its own font file")

        # search filters the index
        await page.evaluate("window.scrollTo(0, 0)")
        await page.fill("#query", "script")
        await page.wait_for_timeout(250)
        visible = await page.eval_on_selector_all(".row[data-name]", "els => els.filter(e => !e.hidden).map(e => e.dataset.name)")
        check(visible == ["Moyshire", "Radiant Summertime"], f"search filters the index (got {visible})")
        await page.fill("#query", "")
        await page.wait_for_timeout(250)
        check(len(await page.eval_on_selector_all(".row[data-name]", "els => els.filter(e => !e.hidden)")) == 9, "clearing the search restores every typeface")

        # keyboard focus reaches the first row action
        await page.locator(".row > a").first.focus()
        check(await page.evaluate("() => document.activeElement.closest('.row') !== null"), "collection row is keyboard reachable")

        # the skip link must sit above the sticky header when focused
        await page.evaluate("document.querySelector('.skip').focus()")
        await page.wait_for_timeout(120)
        check(
            await page.evaluate("() => document.elementFromPoint(60, 20)?.closest('.skip') !== null"),
            "skip link is painted above the sticky header when focused",
        )

        # imagery and overflow
        meta = await page.evaluate("""() => ({
            broken: [...document.images].filter(i => !i.naturalWidth).map(i => i.getAttribute('src')),
            overflow: document.documentElement.scrollWidth > window.innerWidth + 1,
            scrollWidth: document.documentElement.scrollWidth
        })""")
        # force every lazy image to decode before judging
        await page.evaluate("window.scrollTo(0, document.body.scrollHeight)")
        await page.wait_for_timeout(1500)
        meta = await page.evaluate("""() => ({
            broken: [...document.images].filter(i => !i.naturalWidth).map(i => i.getAttribute('src')),
            overflow: document.documentElement.scrollWidth > window.innerWidth + 1,
            scrollWidth: document.documentElement.scrollWidth
        })""")
        check(not meta["broken"], f"no broken images ({meta['broken']})")
        check(not meta["overflow"], f"no horizontal overflow (scrollWidth {meta['scrollWidth']})")
        check(not errors, f"no console, page or request errors ({errors[:3]})")

        # entrance motion is harmless: content visible with reduced motion
        await page.emulate_media(reduced_motion="reduce")
        await page.evaluate("window.scrollTo(0, 0)")
        await page.wait_for_timeout(300)
        check(await page.locator(".masthead h1").is_visible(), "masthead stays visible under reduced motion")

        await page.fill("#query", "zz-no-match-zz")
        check(await page.locator("#empty-results").is_visible(), "a search with no match explains the empty result")
        check("0 of 9" in await page.locator("#result-count").inner_text(), "zero-result count stays visible outside the hidden collection")
        check(await page.locator(".gallery").is_visible(), "search does not hide the application gallery")
        await page.click("#reset-search")
        check(await page.locator(".row:not([hidden])").count() == 9, "reset restores all nine typefaces")

        await ctx.close()

        # ----------------------------------------------------------- mobile
        ctx, page, errors = await new_page(browser, 390, 844)
        check(await page.locator(".menu-button").is_visible(), "mobile menu button is shown")
        check(await page.locator("#navigation").is_hidden(), "mobile navigation starts closed")
        await page.click(".menu-button")
        check(await page.locator("#navigation").is_visible(), "mobile menu opens")
        await page.keyboard.press("Escape")
        check(await page.locator("#navigation").is_hidden(), "Escape closes the mobile menu")
        check(await page.locator(".header-search").is_visible(), "header search stays available with the menu closed")

        await page.evaluate("window.scrollTo(0, 300)")
        await page.wait_for_timeout(1400)
        meta = await page.evaluate("""() => ({
            overflow: document.documentElement.scrollWidth > window.innerWidth + 1,
            scrollWidth: document.documentElement.scrollWidth
        })""")
        check(not meta["overflow"], f"mobile has no horizontal overflow (scrollWidth {meta['scrollWidth']})")

        state = await page.evaluate("() => document.querySelector('#specimen-frame').dataset.state")
        check(state == "ready", f"specimen loads on mobile too (state {state})")
        check(not errors, f"mobile has no console, page or request errors ({errors[:3]})")

        await capture(page, "mobile.png")
        await ctx.close()

        # desktop capture
        ctx, page, errors = await new_page(browser, 1440, 900)
        await page.wait_for_function("() => document.querySelector('#specimen-frame').dataset.state === 'ready'", timeout=15000)
        await page.screenshot(path=str(SHOTS / "home-viewport.png"))
        await capture(page, "desktop.png")
        await ctx.close()

        await browser.close()

    width = max(len(label) for _, label in results)
    failed = 0
    for ok, label in results:
        print(f"{'PASS' if ok else 'FAIL'}  {label}")
        failed += 0 if ok else 1
    print(f"\n{len(results) - failed}/{len(results)} checks passed")

    # ------------------------------------------------- specimen failure path
    # Separate context so every specimen request can be aborted from a cold start.
    async with async_playwright() as p:
        browser = await p.chromium.launch()
        ctx = await browser.new_context(viewport={"width": 1440, "height": 900})
        page = await ctx.new_page()
        await page.route("**/fonts/web/*.woff2", lambda route: route.abort())
        await page.goto(BASE, wait_until="load")
        try:
            await page.wait_for_function(
                "() => document.querySelector('#specimen-frame').dataset.state === 'error'",
                timeout=15000,
            )
            check(True, "a failed specimen reaches the error state")
        except Exception:
            check(False, "a failed specimen reaches the error state")
        check(await page.locator("#specimen-line").is_hidden(), "a failed specimen hides the sample, preserving its text")
        check(await page.locator("#specimen-facts").inner_text() == "", "a failed specimen clears the selected cut facts")
        check(await page.locator("#specimen-error").is_visible(), "a failed specimen explains the error in place of the sample")
        status = await page.locator("#specimen-status").inner_text()
        check("Could not load" in status, f"the failure is stated in words ({status!r})")
        await ctx.close()
        await browser.close()

    async with async_playwright() as p:
        browser = await p.chromium.launch()
        catalog = BASE.replace("index.html", "catalog.html")
        ctx, page, errors = await new_page(browser, 1440, 900, url=catalog)
        await page.wait_for_timeout(500)
        before = await page.eval_on_selector_all(".product[data-name]", "els => els.filter(e => !e.hidden).length")
        check(before > 0, f"the catalog grid renders its products (got {before})")
        await page.click('button[data-tag="free"]', timeout=10000)
        await page.wait_for_timeout(500)
        after = await page.eval_on_selector_all(".product[data-name]", "els => els.filter(e => !e.hidden).length")
        hidden_sections = await page.eval_on_selector_all("[data-collection]", "els => els.filter(e => e.hidden).length")
        total_sections = await page.eval_on_selector_all("[data-collection]", "els => els.length")
        check(after > 0, f"a catalog filter keeps matching products visible (got {after})")
        check(hidden_sections < total_sections, f"a catalog filter keeps its section visible ({hidden_sections}/{total_sections} hidden)")
        check(not errors, f"the catalog page has no page errors ({errors[:2]})")
        for category, expected in [("font", 9), ("brush", 3), ("graphic", 2), ("bundle", 2)]:
            await page.goto(f"{catalog}?category={category}", wait_until="load")
            visible = await page.eval_on_selector_all(".product[data-name]", "els => els.filter(e => !e.hidden).map(e => e.dataset.style)")
            check(visible == [category] * expected, f"URL category {category} opens exactly its {expected} products")
        await page.goto(f"{catalog}?tag=free", wait_until="load")
        check(await page.locator('.product:not([hidden])').count() == 2, "Freebies route opens both matching products")
        await browser.close()

    failed = sum(1 for ok, _ in results if not ok)
    print(f"\nfinal: {len(results) - failed}/{len(results)} checks passed")
    return 1 if failed else 0


if __name__ == "__main__":
    sys.exit(asyncio.run(main()))
