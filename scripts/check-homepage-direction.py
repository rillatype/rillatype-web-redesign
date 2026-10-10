"""G01: pinned blue/lime homepage, literal text, artwork and truthful search.
Run: python scripts/check-homepage-direction.py [--capture]
Captures go to PI_SCRATCH_DIR/G01-final-*.png, never shared evidence names.
Negative controls mutate DOM in memory only. No network transactions.
"""
import asyncio
import os
import sys
from pathlib import Path
from playwright.async_api import async_playwright

URL = 'http://127.0.0.1:9402/static/redesign/index.html'
results = []

def check(ok, label):
    results.append((bool(ok), label))
    print(('PASS ' if ok else 'FAIL ') + label, flush=True)

async def layout(page):
    return await page.evaluate('''() => {
      const line = document.querySelector('#specimen-line');
      const facts = document.querySelector('#specimen-facts').getBoundingClientRect();
      return {width:innerWidth, scroll:document.documentElement.scrollWidth,
        lineWidth:line.clientWidth, lineScroll:line.scrollWidth,
        overflow:getComputedStyle(line).overflow, factsBottom:facts.bottom,
        blue:getComputedStyle(document.querySelector('.header')).backgroundColor,
        selected:getComputedStyle(document.querySelector('#cut-picker input:checked + span')).backgroundColor,
        lower:getComputedStyle(document.querySelector('.home-content')).borderTopLeftRadius};
    }''')

async def prices_valid(page):
    return await page.evaluate('''()=>[...document.querySelectorAll('.graphic-card')].every(c=>{
      const p=window.RillaCatalog.catalog.get(c.dataset.slug);
      return c.querySelector('.graphic-price').textContent ===
        (typeof p.price==='number' && p.price>0 ? `Demo $${p.price}` : 'See license options');
    })''')

async def main():
    async with async_playwright() as p:
        browser = await p.chromium.launch()
        print('Chromium ' + browser.version)
        for width,height in [(1440,900),(390,844),(320,844),(768,1024)]:
            page = await browser.new_page(viewport={'width':width,'height':height})
            errors=[]
            page.on('pageerror', lambda e: errors.append(str(e)))
            await page.goto(URL)
            await page.wait_for_function('document.querySelector("#specimen-frame").dataset.state === "ready"')
            await page.wait_for_timeout(400)
            data=await layout(page)
            check(data['scroll']==width, f'{width}px: no page overflow')
            check(data['factsBottom']<height, f'{width}px: active facts in first viewport ({data["factsBottom"]:.1f}px)')
            check(data['blue']=='rgb(6, 68, 223)' and data['selected']=='rgb(196, 255, 0)', f'{width}px: pinned blue and lime selected state')
            check(data['lower'] in ('40px','24px'), f'{width}px: rounded light lower field')
            if '--capture' in sys.argv:
                path=Path(os.environ['PI_SCRATCH_DIR'])/f'G01-final-{width}.png'
                await page.screenshot(path=str(path))
                print('CAPTURE '+str(path))
            literal='  LongUnbrokenSpecimenTextWithEveryCharacterStillVisibleAndNoCropping  '
            await page.locator('#specimen-line').fill(literal)
            data=await layout(page)
            check(data['lineScroll']<=data['lineWidth']+1 and data['overflow']=='visible' and data['scroll']==width, f'{width}px: long literal text wraps without clipping')
            await page.locator('#cut-picker label',has_text='Mango').click()
            await page.wait_for_function('document.querySelector("#specimen-facts").textContent.includes("Mango")')
            check(await page.locator('#specimen-line').text_content()==literal, f'{width}px: font switch preserves literal whitespace/text')
            await page.locator('#specimen-line').focus()
            check(await page.locator('#specimen-line').evaluate('e=>getComputedStyle(e).outlineStyle')=='dashed', f'{width}px: visible editable focus')
            await page.emulate_media(reduced_motion='reduce')
            check(await page.locator('#specimen-line').evaluate('e=>getComputedStyle(e).animationName')=='none', f'{width}px: reduced motion disables entrance')
            # Decode each original, including lazy artwork, by visiting its actual position.
            for image in await page.locator('.home-content img').all():
                await image.scroll_into_view_if_needed()
                await image.evaluate('e=>e.decode()')
            artwork=await page.locator('.row-thumb img, .featured-art img, .gallery img, .graphic-art img').evaluate_all('''els=>els.every(e=>{
              const r=e.getBoundingClientRect();return e.naturalWidth>0 && Math.abs(r.width/r.height-1.5)<.01 && getComputedStyle(e).objectFit==='contain';})''')
            check(artwork, f'{width}px: all collection/Graphics/gallery artwork loaded and whole 3:2')
            check(not errors,f'{width}px: no runtime page errors')
            await page.close()
        page=await browser.new_page(viewport={'width':1440,'height':900})
        await page.goto(URL)
        await page.wait_for_function('document.querySelector("#specimen-frame").dataset.state === "ready"')
        await page.locator('#query').fill('palm')
        check(await page.locator('.graphic-card:not([hidden])').count()==1 and await page.locator('.row:not([hidden])').count()==0, 'Graphics search finds only Palm Tree')
        check(await page.locator('#result-count').inner_text()=='Showing 0 of 9 typefaces and 1 of 4 graphics in this preview.', 'search counts both kinds accurately')
        await page.locator('#query').fill('no-matching-product')
        check(await page.locator('#empty-results').is_visible() and await page.locator('#graphics').is_hidden(), 'empty result explains no matches and hides empty Graphics')
        await page.locator('#reset-search').click()
        check(await page.locator('.graphic-card:not([hidden])').count()==4 and await page.locator('.row:not([hidden])').count()==9, 'reset restores both kinds')
        check(await prices_valid(page), 'zero Graphics base prices do not claim a free download')
        await page.locator('.graphic-price').first.evaluate("e=>e.textContent='Demo $0'")
        check(not await prices_valid(page), 'negative control: validator rejects misleading zero price')
        await page.reload()
        await page.wait_for_function('document.querySelector("#specimen-frame").dataset.state === "ready"')
        await page.locator('#specimen-line').evaluate("e=>{e.style.whiteSpace='nowrap';e.style.overflow='hidden';e.textContent='X'.repeat(100)}")
        data=await layout(page)
        check(data['lineScroll']>data['lineWidth'] or data['overflow']!='visible', 'negative control: geometry validator detects old clipped long text')
        await page.close()
        # Hold an actual old request; finish a newer one, then release the old response.
        page=await browser.new_page(viewport={'width':1440,'height':900})
        held=asyncio.Event(); release=asyncio.Event(); finished=asyncio.Event()
        async def hold_light(route):
            held.set(); await release.wait(); await route.continue_(); finished.set()
        await page.route('**/chronoa-light.woff2',hold_light)
        await page.goto(URL, wait_until='domcontentloaded')
        await page.wait_for_function('document.querySelector("#specimen-frame").dataset.state === "ready"')
        await page.locator('#weight-picker input[value="300"]').check()
        await asyncio.wait_for(held.wait(),5)
        await page.locator('#weight-picker input[value="600"]').check()
        await page.wait_for_function('document.querySelector("#specimen-frame").dataset.state === "ready"')
        before=await page.locator('#specimen-facts').inner_text()
        release.set(); await asyncio.wait_for(finished.wait(),5)
        await page.wait_for_function('[...document.fonts].some(f=>f.family==="Rilla-Chronoa"&&f.weight==="300"&&f.status==="loaded")')
        check(await page.locator('#specimen-facts').inner_text()==before and 'SemiBold' in before, 'held old cut cannot overwrite newer ready facts')
        await page.close()
        page=await browser.new_page(viewport={'width':390,'height':844})
        network={'down':True}; attempts=[]
        async def fail_default(route):
            attempts.append(route.request.url)
            if network['down']: await route.abort()
            else: await route.continue_()
        await page.route('**/chronoa-semibold.woff2',fail_default)
        await page.goto(URL)
        await page.wait_for_function('document.querySelector("#specimen-frame").dataset.state === "error"')
        check(await page.locator('#specimen-line').is_hidden() and await page.locator('#specimen-retry').is_visible(), 'cold default failure hides fallback specimen and exposes retry')
        network['down']=False
        await page.locator('#specimen-retry').click()
        await page.wait_for_function('document.querySelector("#specimen-frame").dataset.state === "ready"')
        check(len(attempts)>=2 and 'SemiBold' in await page.locator('#specimen-facts').inner_text(), 'same-cut retry really refetches and recovers without reload')
        await browser.close()
    failed=sum(not ok for ok,_ in results)
    print(f'{len(results)-failed}/{len(results)} PASS')
    return int(failed>0)

if __name__=='__main__':
    sys.exit(asyncio.run(main()))
