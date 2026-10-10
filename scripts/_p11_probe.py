"""Scratch: inspect the homepage specimen wiring without the check harness."""
import asyncio
import sys

from playwright.async_api import async_playwright

URL = sys.argv[1] if len(sys.argv) > 1 else "http://127.0.0.1:9402/static/redesign/index.html"


async def main():
    async with async_playwright() as p:
        browser = await p.chromium.launch()
        page = await (await browser.new_context(viewport={"width": 1440, "height": 900})).new_page()
        logs = []
        page.on("pageerror", lambda e: logs.append("PAGEERROR: " + str(e)))
        page.on("console", lambda m: logs.append(f"{m.type}: {m.text}"))
        page.on("requestfailed", lambda r: logs.append("REQFAIL: " + r.url))
        await page.goto(URL, wait_until="load")
        await page.wait_for_timeout(1800)
        probe = await page.evaluate("""() => ({
          state: document.querySelector('#specimen-frame')?.dataset.state ?? null,
          cuts: [...document.querySelectorAll('#cut-picker label span')].map(s => s.textContent),
          cutHidden: document.querySelector('#cut-picker')?.hidden ?? null,
          weights: [...document.querySelectorAll('#weight-picker input')].map(i => i.value),
          weightHidden: document.querySelector('#weight-picker')?.hidden ?? null,
          line: document.querySelector('#specimen-line')?.textContent ?? null,
          family: getComputedStyle(document.querySelector('#specimen-line')).fontFamily,
          weight: getComputedStyle(document.querySelector('#specimen-line')).fontWeight,
          track: getComputedStyle(document.querySelector('#specimen-line')).letterSpacing,
          facts: document.querySelector('#specimen-facts')?.textContent ?? null,
          strips: [...document.querySelectorAll('.strip')].map(s => s.textContent.trim()),
          stripsHidden: document.querySelector('#specimen-strips')?.hidden ?? null,
          featured: document.querySelector('#featured-title')?.textContent ?? null,
          specs: [...document.querySelectorAll('#featured-specs div')].map(d => d.textContent),
          rowFaces: [...document.querySelectorAll('.row[data-slug]')].map(r => [
            r.dataset.slug, getComputedStyle(r.querySelector('.row-name')).fontFamily,
            getComputedStyle(r.querySelector('.row-name')).fontWeight,
            getComputedStyle(r.querySelector('.row-name')).letterSpacing]),
        })""")
        for key, value in probe.items():
            print(f"{key}: {value}")
        for line in logs[:15]:
            print("LOG", line)
        await browser.close()


if __name__ == "__main__":
    asyncio.run(main())
