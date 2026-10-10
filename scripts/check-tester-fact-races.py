"""A05 check: a late response from an abandoned cut must not rewrite the tester.

The audit recorded this as a source hypothesis, never reproduced in a browser. The
source has two awaits inside refreshFacts() (feature parse, glyph parse) and the
"latest request wins" guard in selectStyle() only runs *after* refreshFacts returns,
so mutations inside it are unguarded. This suite tries to open that window:

  1. Hold the *parser* fetches of one cut, but let its FontFace finish. The two are
     told apart by the request's resource type: the browser loads the face as `font`
     and the parsers use `fetch`, which Playwright reports separately.
  2. Choose the held cut, then a fast one, and wait for the fast one to be fully
     ready with its own glyph count.
  3. Release the stale response, once as a failure and once as a different font, and
     require that the newest cut is still the one described on screen.

The second release serves a different file's bytes (Mango) under the Chronoa cut's
URL, purely to make a stale parse produce *different* facts. It is a test-only
fixture: Chronoa has no dlig and the page is never told that it does. Nothing is
written to the repository.
"""
import asyncio
import sys
from pathlib import Path

from playwright.async_api import async_playwright

ROOT = Path(__file__).resolve().parent.parent
BASE = sys.argv[1] if len(sys.argv) > 1 else "http://127.0.0.1:9402/static/redesign/product.html"
MANGO = (ROOT / "static" / "previews" / "mango-letter.otf").read_bytes()

results = []


def check(ok, label):
    results.append((bool(ok), label))
    return bool(ok)


STATE = """() => {
    const select = document.querySelector('#sample-style');
    const output = document.querySelector('#sample-output');
    const cell = document.querySelector('.glyph-cell');
    const switches = {};
    for (const id of ['#liga-switch', '#dlig-switch', '#salt-switch']) {
        const input = document.querySelector(`${id} input`);
        const label = document.querySelector(id);
        switches[id] = input
            ? { disabled: input.disabled, checked: input.checked,
                note: label && label.querySelector('.switch-note') ? label.querySelector('.switch-note').textContent.trim() : '' }
            : null;
    }
    return {
        cut: select.options[select.selectedIndex].textContent,
        family: getComputedStyle(output).fontFamily.split(',')[0].trim().replace(/"/g, ''),
        weight: getComputedStyle(output).fontWeight,
        status: document.querySelector('#font-status').innerText.trim(),
        count: document.querySelector('#glyph-count').textContent.trim(),
        cells: document.querySelectorAll('.glyph-cell').length,
        frameState: document.querySelector('#tester-frame').dataset.state || 'none',
        switches,
    };
}"""


async def hold_parser_once(browser, mode):
    """Open the Chronoa page with the Light cut's parser fetches held."""
    ctx = await browser.new_context(viewport={"width": 1440, "height": 900})
    page = await ctx.new_page()
    errors = []
    page.on("pageerror", lambda e: errors.append(str(e)))
    held = []
    release = asyncio.Event()

    async def hold_light_parser(route):
        if route.request.resource_type == "font":
            await route.continue_()
            return
        held.append(route.request.url.rsplit("/", 1)[-1])
        await release.wait()
        if mode == "fail":
            await route.abort()
        else:
            await route.fulfill(status=200, content_type="font/otf", body=MANGO)
    await page.route("**/Chronoa-Light.otf", hold_light_parser)
    await page.goto(f"{BASE}?font=chronoa", wait_until="load")
    await page.wait_for_function("() => !document.querySelector('#tester-frame').hidden", timeout=15000)
    return ctx, page, errors, held, release


async def main() -> int:
    async with async_playwright() as p:
        browser = await p.chromium.launch()

        # ---------------------------------------------------- the fast newer cut wins
        ctx, page, errors, held, release = await hold_parser_once(browser, "mango")
        await page.select_option("#sample-style", "2")
        await page.wait_for_timeout(700)
        during = await page.evaluate(STATE)
        faces = await page.evaluate("""() => [...document.fonts]
            .filter(f => f.family === 'Rilla-Chronoa')
            .map(f => `${f.weight}:${f.status}`)""")
        check(during["weight"] == "300" and "300:loaded" in faces,
              f"the held cut's own face still loads, so only its parser is delayed "
              f"({during['weight']}, {faces})")
        check(bool(held), f"the parser fetch of the held cut was really intercepted ({held})")

        await page.select_option("#sample-style", "7")
        await page.wait_for_function("() => getComputedStyle(document.querySelector('#sample-output')).fontWeight === '800'", timeout=15000)
        await page.wait_for_function("() => document.querySelector('#glyph-count').textContent.includes('218')", timeout=15000)
        newest = await page.evaluate(STATE)
        check(newest["cut"] == "ExtraBold" and newest["count"].startswith("218") and newest["cells"] == 218,
              f"the newer cut is fully ready before the stale response lands ({newest['cut']}, {newest['count']})")

        release.set()
        await page.wait_for_timeout(1200)
        after = await page.evaluate(STATE)
        check(after["count"].startswith("218") and after["cells"] == 218,
              f"a late successful response does not replace the newest glyph set ({after['count']})")
        check(after["switches"]["#dlig-switch"]["disabled"] and not after["switches"]["#dlig-switch"]["checked"],
              f"a late response cannot switch on a feature the newest cut does not have ({after['switches']['#dlig-switch']})")
        check(after["weight"] == "800" and after["cut"] == "ExtraBold" and "ExtraBold" in after["status"],
              f"selector, weight and status still describe the newest cut ({after['cut']}, {after['weight']})")
        check(after["family"] == "Rilla-Chronoa",
              f"the product family is still the one applied ({after['family']})")
        check(not errors, f"no page errors during the late success ({errors[:2]})")
        await ctx.close()

        # -------------------------------------- and a stale failure must not clear it
        ctx, page, errors, held, release = await hold_parser_once(browser, "fail")
        await page.select_option("#sample-style", "2")
        await page.wait_for_timeout(700)
        await page.select_option("#sample-style", "7")
        await page.wait_for_function("() => getComputedStyle(document.querySelector('#sample-output')).fontWeight === '800'", timeout=15000)
        await page.wait_for_function("() => document.querySelector('#glyph-count').textContent.includes('218')", timeout=15000)
        release.set()
        await page.wait_for_timeout(1200)
        failed_late = await page.evaluate(STATE)
        check(failed_late["count"].startswith("218") and failed_late["cells"] == 218,
              f"a late failure does not empty the newest glyph panel ({failed_late['count']}, "
              f"{failed_late['cells']} cells)")
        check(failed_late["frameState"] != "error",
              f"a late failure does not put the newest ready cut into the error state ({failed_late['frameState']})")
        check(failed_late["weight"] == "800" and "ExtraBold" in failed_late["status"],
              f"the newest cut is still described after a stale failure ({failed_late['weight']})")
        check(not errors, f"no page errors during the late failure ({errors[:2]})")
        await ctx.close()

        await browser.close()

    passed = sum(1 for ok, _ in results if ok)
    print(f"=== tester fact races: {passed}/{len(results)} PASS ===\n")
    for ok, label in results:
        print(f"{'PASS' if ok else 'FAIL'}  {label}")
    return 0 if passed == len(results) else 1


if __name__ == "__main__":
    sys.exit(asyncio.run(main()))
