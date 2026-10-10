"""G01 open hero regression. Read-only browser assertions, no captures or transactions."""
import asyncio
from playwright.async_api import async_playwright

async def verify(page):
    assert await page.evaluate('document.documentElement.scrollWidth <= innerWidth'), 'page overflow'
    assert not await page.locator('#specimen-line').is_visible(), 'tester must start collapsed'
    assert await page.locator('.header').evaluate("e=>e.getBoundingClientRect().left===0 && e.getBoundingClientRect().width===innerWidth && getComputedStyle(e).borderBottomWidth==='1px'"), 'floating glass must have a visible edge'

async def main():
    async with async_playwright() as p:
        browser = await p.chromium.launch()
        print('Chromium', browser.version)
        for width in [1440, 390, 320, 768]:
            page = await browser.new_page(viewport={'width':width,'height':900})
            errors=[]
            page.on('pageerror', lambda e: errors.append(str(e)))
            await page.goto('http://127.0.0.1:9402/static/redesign/index.html')
            await verify(page)
            assert await page.locator('.explore-button').inner_text()=='Browse fonts'
            assert await page.locator('.foundry-intro p').inner_text()=='Find the right type for your next idea.'
            assert await page.evaluate("document.querySelector('.type-lab').getBoundingClientRect().top>=document.querySelector('.home-content').getBoundingClientRect().bottom")

            faces = await page.evaluate('document.fonts.load(\'400 64px "Selected Mondriel"\') .then(f=>f.map(x=>x.status))')
            assert faces == ['loaded']
            assert 'Selected Mondriel' in await page.locator('.mondriel-word').evaluate('e=>getComputedStyle(e).fontFamily')
            assert await page.locator('.mondriel-word').evaluate('e=>e.scrollWidth<=e.clientWidth')
            assert await page.locator('#featured-stylecount').inner_text()=='1 style'
            assert await page.locator('.selected-side .row').first.locator('a').get_attribute('href')=='product.html?font=mondriel'
            assert "Arial Black" in await page.locator("h1").evaluate("e=>getComputedStyle(e).fontFamily")
            assert await page.locator("#motion-toggle").count()==0
            assert await page.locator(".hero-logo img").evaluate("e=>e.complete && e.naturalWidth>0")
            # Negative control: the same verifier must reject an expanded hero tester.
            await page.locator('.type-lab').evaluate('e=>e.open=true')
            try:
                await verify(page)
            except AssertionError as e:
                assert str(e)=='tester must start collapsed'
            else:
                raise AssertionError('negative control accepted an expanded tester')
            await page.locator('#specimen-line').fill('My next idea')
            await page.locator('.type-lab summary').click()
            await page.locator('.type-lab summary').click()
            assert await page.locator('#specimen-line').inner_text()=='My next idea'
            await page.evaluate('window.scrollTo(0,900)')
            assert abs(await page.locator('.header').evaluate('e=>e.getBoundingClientRect().top'))<1
            assert await page.locator('.type-track').first.evaluate("e=>getComputedStyle(e).animationIterationCount==='infinite'")
            assert await page.locator('.type-track').first.evaluate("e=>{const a=e.getAnimations()[0]; a.pause(); a.currentTime=0; const first=getComputedStyle(e).transform; a.currentTime=53000; return first!==getComputedStyle(e).transform;}")
            await page.emulate_media(reduced_motion='reduce')
            assert await page.locator('.type-track').first.evaluate("e=>getComputedStyle(e).animationName==='none'")
            if not await page.locator('.nav-search summary').is_visible():
                await page.locator('.menu-button').click()
            await page.locator('.nav-search summary').click()
            assert await page.locator('#query').is_visible()
            assert await page.locator('#font-search button').count()==0
            assert await page.locator('.nav-search').evaluate("e=>{const s=e.querySelector('summary').getBoundingClientRect(),q=e.querySelector('input').getBoundingClientRect(); return q.left>=s.right && Math.abs(q.top-s.top)<2;}")
            await page.locator('#query').fill('Mango')
            assert await page.locator('.row:visible').count()>0
            assert not errors, errors
            print('PASS',width,'layout, disclosure, negative control, text, sticky, reduced motion, search')
            await page.close()
        await browser.close()

if __name__=='__main__':
    asyncio.run(main())
