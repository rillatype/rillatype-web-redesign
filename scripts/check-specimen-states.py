"""Check visitor text and selected font through editing, errors and late loads."""
import asyncio
from playwright.async_api import async_playwright

URL = 'http://127.0.0.1:9402/static/redesign/index.html'


async def main():
    results = []
    async with async_playwright() as p:
        browser = await p.chromium.launch()
        page = await browser.new_page(viewport={'width': 1440, 'height': 900})
        await page.goto(URL)
        await page.wait_for_function("document.querySelector('#specimen-frame').dataset.state === 'ready'")
        await page.locator('#weight-picker label', has_text='300').click()
        await page.wait_for_function("getComputedStyle(document.querySelector('#specimen-line')).fontWeight === '300'")
        await page.locator('#specimen-line').fill('')
        await page.keyboard.type('Retyped')
        results.append(('Light remains selected after clearing and typing', await page.locator('#specimen-line').evaluate("el => getComputedStyle(el).fontWeight") == '300'))
        await page.locator('#cut-picker label', has_text='Mango').click()
        await page.wait_for_function("document.querySelector('#specimen-facts').textContent.includes('Mango')")
        await page.locator('#specimen-line').fill('')
        await page.keyboard.type('Mango again')
        results.append(('Mango remains selected after clearing and typing', 'Rilla-Mango' in await page.locator('#specimen-line').evaluate("el => getComputedStyle(el).fontFamily")))

        await page.locator('#cut-picker label', has_text='Chronoa').click()
        await page.wait_for_function("document.querySelector('#specimen-facts').textContent.includes('SemiBold')")
        await page.locator('#specimen-line').fill('Keep these words')
        await page.route('**/chronoa-black.woff2', lambda route: route.abort())
        await page.locator('#weight-picker label', has_text='900').click()
        await page.wait_for_function("document.querySelector('#specimen-frame').dataset.state === 'error'")
        results.append(('Failed cut preserves visitor text', await page.locator('#specimen-line').text_content() == 'Keep these words'))
        results.append(('Failed cut hides the sample rather than showing fallback lettering', await page.locator('#specimen-line').is_hidden()))
        await page.locator('#weight-picker label', has_text='600').click()
        await page.wait_for_function("document.querySelector('#specimen-frame').dataset.state === 'ready'")
        results.append(('Retry restores the visitor text in the loaded font', await page.locator('#specimen-line').inner_text() == 'Keep these words'))
        await page.close()

        page = await browser.new_page(viewport={'width': 1440, 'height': 900})
        async def slow_light(route):
            await asyncio.sleep(0.6)
            await route.continue_()
        await page.route('**/chronoa-light.woff2', slow_light)
        await page.goto(URL)
        await page.wait_for_function("document.querySelector('#specimen-frame').dataset.state === 'ready'")
        await page.locator('#weight-picker label', has_text='300').click()
        await page.locator('#weight-picker label', has_text='600').click()
        await page.wait_for_timeout(1200)
        weight = await page.locator('#specimen-line').evaluate("el => getComputedStyle(el).fontWeight")
        facts = await page.locator('#specimen-facts').inner_text()
        results.append(('Late load cannot replace the latest selected cut', weight == '600' and 'SemiBold' in facts))

        # ------------------------- A04: a cut that failed cold must be fetchable again
        # The abort is installed before the page loads on purpose, and it stays installed
        # until the network is "restored": a warm failure is not proof of a retry, because
        # the working cut is already cached. Only one request per cut is ever in flight in
        # the page, so the route also counts the real attempts -- an aborted request never
        # produces a response, and a browser-side retry of the same font would show up here.
        page = await browser.new_page(viewport={'width': 1440, 'height': 900})
        attempts = []
        network = {'down': True}

        async def fail_semibold_while_cold(route):
            attempts.append(route.request.url.rsplit('/', 1)[-1])
            if network['down']:
                await route.abort()
            else:
                await route.continue_()

        await page.route('**/chronoa-semibold.woff2', fail_semibold_while_cold)
        await page.goto(URL)
        await page.wait_for_function("document.querySelector('#specimen-frame').dataset.state === 'error'")
        first_attempts = len(attempts)
        network['down'] = False
        await page.locator('#weight-picker label', has_text='400').click()
        await page.wait_for_function("document.querySelector('#specimen-frame').dataset.state === 'ready'")
        await page.locator('#weight-picker label', has_text='600').click()
        recovered = True
        try:
            await page.wait_for_function(
                "document.querySelector('#specimen-frame').dataset.state === 'ready'"
                " && getComputedStyle(document.querySelector('#specimen-line')).fontWeight === '600'",
                timeout=8000)
        except Exception:
            recovered = False
        facts = await page.locator('#specimen-facts').inner_text()
        results.append((f'The SemiBold cut that failed cold is fetched again and recovers ({len(attempts)} attempts)',
                        recovered and len(attempts) > first_attempts))
        results.append((f'The recovered cut reports its own facts ({facts!r})',
                        'SemiBold' in facts and 'Chronoa' in facts))
        results.append(('The recovered cut is visible again instead of staying in the error state',
                        await page.locator('#specimen-line').is_visible()))
        await page.close()

        # ------------------- A04: the same for a cut that fails before the page loads
        page = await browser.new_page(viewport={'width': 1440, 'height': 900})
        black_attempts = []
        black_network = {'down': True}

        async def fail_black_while_cold(route):
            black_attempts.append(route.request.url.rsplit('/', 1)[-1])
            if black_network['down']:
                await route.abort()
            else:
                await route.continue_()

        await page.route('**/chronoa-black.woff2', fail_black_while_cold)
        await page.goto(URL)
        await page.wait_for_function("document.querySelector('#specimen-frame').dataset.state === 'ready'")
        await page.locator('#specimen-line').fill('Black retry text')
        await page.locator('#weight-picker label', has_text='900').click()
        await page.wait_for_function("document.querySelector('#specimen-frame').dataset.state === 'error'")
        after_failure = len(black_attempts)
        black_network['down'] = False
        await page.locator('#weight-picker label', has_text='600').click()
        await page.wait_for_function("document.querySelector('#specimen-frame').dataset.state === 'ready'")
        await page.locator('#weight-picker label', has_text='900').click()
        black_recovered = True
        try:
            await page.wait_for_function(
                "document.querySelector('#specimen-frame').dataset.state === 'ready'"
                " && getComputedStyle(document.querySelector('#specimen-line')).fontWeight === '900'",
                timeout=8000)
        except Exception:
            black_recovered = False
        black_facts = await page.locator('#specimen-facts').inner_text()
        results.append((f'The Black cut that failed cold is fetched again and recovers ({len(black_attempts)} attempts)',
                        black_recovered and len(black_attempts) > after_failure))
        results.append((f'The Black retry keeps the visitor text and its own facts ({black_facts!r})',
                        await page.locator('#specimen-line').inner_text() == 'Black retry text' and 'Black' in black_facts))
        await page.close()

        # ------- A04: a cut that already loaded must not be fetched again when re-picked
        # This guards the other half of the cache lifecycle: dropping a failed promise is
        # only safe while a face that did load stays cached.
        bold_page = await browser.new_page(viewport={'width': 1440, 'height': 900})
        bold_hits = []

        async def count_bold(route):
            bold_hits.append(route.request.url.rsplit('/', 1)[-1])
            await route.continue_()

        await bold_page.route('**/chronoa-bold.woff2', count_bold)
        await bold_page.goto(URL)
        await bold_page.wait_for_function("document.querySelector('#specimen-frame').dataset.state === 'ready'")
        await bold_page.locator('#weight-picker label', has_text='700').click()
        await bold_page.wait_for_function("getComputedStyle(document.querySelector('#specimen-line')).fontWeight === '700'")
        first_load = len(bold_hits)
        await bold_page.locator('#weight-picker label', has_text='600').click()
        await bold_page.wait_for_function("getComputedStyle(document.querySelector('#specimen-line')).fontWeight === '600'")
        await bold_page.locator('#weight-picker label', has_text='700').click()
        await bold_page.wait_for_function("getComputedStyle(document.querySelector('#specimen-line')).fontWeight === '700'")
        await bold_page.wait_for_timeout(400)
        results.append((f'A cut that already loaded is not fetched again ({first_load} then {len(bold_hits)} requests)',
                        first_load >= 1 and len(bold_hits) == first_load))
        await bold_page.close()
        await browser.close()
    for label, ok in results:
        print(f"{'PASS' if ok else 'FAIL'} {label}")
    assert all(ok for _, ok in results), 'Specimen state regressions found'


asyncio.run(main())
