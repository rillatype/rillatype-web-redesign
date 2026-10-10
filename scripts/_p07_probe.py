import asyncio
from playwright.async_api import async_playwright
async def main():
    async with async_playwright() as p:
        b = await p.chromium.launch()
        pg = await (await b.new_context(viewport={"width":1440,"height":900})).new_page()
        reqs = []
        pg.on("response", lambda r: reqs.append((r.status, r.url.rsplit("/",1)[-1])) if ".woff2" in r.url else None)
        pg.goto
        await pg.goto("http://127.0.0.1:9402/static/redesign/index.html", wait_until="load")
        await pg.wait_for_function("() => document.querySelector('#specimen-frame').dataset.state === 'ready'", timeout=15000)
        for label in ("100","700"):
            await pg.locator("#weight-picker label", has_text=label).first.click()
            await pg.wait_for_timeout(900)
            info = await pg.evaluate("""() => ({
                weight: getComputedStyle(document.querySelector('#specimen-line')).fontWeight,
                facts: document.querySelector('#specimen-facts').textContent
            })""")
            print(f"weight {label}: rendered={info['weight']} facts={info['facts']}")
        bad = [r for r in reqs if r[0] >= 400]
        print("woff2 requests:", len(reqs), "| failures:", bad)
        await b.close()
asyncio.run(main())
