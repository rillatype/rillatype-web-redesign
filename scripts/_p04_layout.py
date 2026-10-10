import asyncio
from playwright.async_api import async_playwright
async def main():
    async with async_playwright() as p:
        b = await p.chromium.launch()
        for w,h,tag in ((1440,900,"desktop"),(390,844,"mobile")):
            pg = await (await b.new_context(viewport={"width":w,"height":h})).new_page()
            await pg.goto("http://127.0.0.1:9402/static/redesign/product.html?font=mango", wait_until="load")
            await pg.wait_for_function("() => !document.querySelector('#tester-frame').hidden", timeout=15000)
            await pg.evaluate("document.fonts.ready")
            await pg.wait_for_timeout(400)
            info = await pg.evaluate("""() => {
                const field = document.querySelector('#style-field');
                const panel = document.querySelector('.tester-panel');
                const rows = [...panel.children].filter(e => getComputedStyle(e).display !== 'none').length;
                return { styleFieldHidden: field.hidden, visiblePanelChildren: rows,
                         panelHeight: Math.round(panel.getBoundingClientRect().height),
                         overflow: document.documentElement.scrollWidth > window.innerWidth + 1,
                         scrollWidth: document.documentElement.scrollWidth };
            }""")
            print(f"{tag:8s} {w}px", info)
            await pg.screenshot(path=f".impeccable/review/tester-{tag}.png", full_page=False)
            await pg.context.close()
        await b.close()
asyncio.run(main())
