import asyncio
from playwright.async_api import async_playwright
async def main():
    async with async_playwright() as p:
        b = await p.chromium.launch()
        # Chronoa default cut must actually render at SemiBold
        pg = await (await b.new_context(viewport={"width":1280,"height":900})).new_page()
        await pg.goto("http://127.0.0.1:9402/static/redesign/product.html?font=chronoa", wait_until="load")
        await pg.wait_for_function("() => !document.querySelector('#tester-frame').hidden", timeout=15000)
        info = await pg.evaluate("""() => ({
            selected: document.querySelector('#sample-style').options[document.querySelector('#sample-style').selectedIndex].textContent,
            weight: getComputedStyle(document.querySelector('#sample-output')).fontWeight,
            loaded: [...document.fonts].filter(f=>f.family==='Rilla-Chronoa' && f.status==='loaded').map(f=>f.weight)
        })""")
        print("chronoa default:", info)
        await pg.locator('#sample-style').select_option('0')
        await pg.wait_for_timeout(200)
        print("after choosing Thin:", await pg.eval_on_selector('#sample-output','el=>getComputedStyle(el).fontWeight'))
        await pg.context.close()

        # a product without a specimen keeps its honest unavailable state
        pg = await (await b.new_context(viewport={"width":1280,"height":900})).new_page()
        await pg.goto("http://127.0.0.1:9402/static/redesign/product.html?font=tropivera", wait_until="load")
        await pg.wait_for_timeout(600)
        info = await pg.evaluate("""() => ({
            status: document.querySelector('#font-status').textContent,
            frameHidden: document.querySelector('#tester-frame').hidden,
            retryHidden: document.querySelector('#retry-font').hidden,
            styleFieldHidden: document.querySelector('#style-field').hidden
        })""")
        print("tropivera:", info)
        await pg.context.close()

        # legacy demo entry with a single style
        pg = await (await b.new_context(viewport={"width":1280,"height":900})).new_page()
        await pg.goto("http://127.0.0.1:9402/static/redesign/product.html?font=bawden", wait_until="load")
        await pg.wait_for_timeout(600)
        print("bawden:", await pg.evaluate("() => ({status: document.querySelector('#font-status').textContent, frameHidden: document.querySelector('#tester-frame').hidden})"))
        await b.close()
asyncio.run(main())
