import asyncio
from playwright.async_api import async_playwright
SLUGS = ["mango","chronoa","tropivera","dockhand","wildkins","solaya","darkwell","redline","distressed-overlays","bawden","brush-set-1","graphic-pack-2","font-bundle-1"]
async def main():
    async with async_playwright() as p:
        b = await p.chromium.launch()
        for slug in SLUGS:
            ctx = await b.new_context(viewport={"width":1280,"height":900})
            pg = await ctx.new_page()
            errs=[]
            pg.on("pageerror", lambda e: errs.append(str(e)))
            pg.on("console", lambda m: errs.append(m.text) if m.type=="error" else None)
            await pg.goto(f"http://127.0.0.1:9402/static/redesign/product.html?font={slug}", wait_until="load")
            await pg.wait_for_timeout(700)
            info = await pg.evaluate("""() => ({
                notFound: !document.querySelector('#not-found').hidden,
                title: document.querySelector('#product-title').textContent,
                status: document.querySelector('#font-status').textContent.slice(0,70),
                styleFieldHidden: document.querySelector('#style-field').hidden,
                styleOptions: [...document.querySelectorAll('#sample-style option')].map(o=>o.textContent),
                price: document.querySelector('#product-price').textContent
            })""")
            print(f"{slug:20s} notFound={str(info['notFound']):5s} title={info['title'][:26]:26s} price={info['price']:9s} stylesHidden={info['styleFieldHidden']} opts={info['styleOptions']} errs={errs[:1]}")
            await ctx.close()
        await b.close()
asyncio.run(main())
