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
        await browser.close()
    for label, ok in results:
        print(f"{'PASS' if ok else 'FAIL'} {label}")
    assert all(ok for _, ok in results), 'Specimen state regressions found'


asyncio.run(main())
