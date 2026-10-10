"""P09 check: the tester's loading, failure and race states.

Covers the card's required cases on the product tester:
- a slow file shows a loading state instead of a stale sample
- text typed while loading is never lost
- a failure keeps the visitor's text and offers retry that works
- abort and retry
- rapid switching: the latest choice wins, an older slower response cannot win
- text cleared, retyped, and carried through a style change

Usage: python scripts/check-tester-load-states.py [base-url]
Exit 0 only when every assertion passes. Set EXPECT_FAIL=1 to record the
pre-fix state (the script prints FAIL lines and still exits non-zero).
"""
import asyncio
import sys

from playwright.async_api import async_playwright

BASE = sys.argv[1].rstrip("/") if len(sys.argv) > 1 else "http://127.0.0.1:9402/static/redesign"
results = []


def check(ok, label):
    results.append((bool(ok), label))
    return bool(ok)


async def session(browser, width=1440, height=900):
    ctx = await browser.new_context(viewport={"width": width, "height": height})
    page = await ctx.new_page()
    errors = []
    page.on("pageerror", lambda e: errors.append(str(e)))
    page.on("console", lambda m: errors.append(m.text) if m.type == "error" else None)
    return ctx, page, errors


async def main() -> int:
    async with async_playwright() as p:
        browser = await p.chromium.launch()

        # ------------------------------------------------- 1. slow file => loading
        ctx, page, errors = await session(browser)

        async def slow_first(route):
            await asyncio.sleep(1.2)
            await route.continue_()

        await page.route("**/Chronoa-SemiBold.otf", slow_first)
        await page.goto(f"{BASE}/product.html?font=chronoa", wait_until="load")
        # While the default cut is still loading the sample must not claim to be it.
        await page.wait_for_timeout(300)
        state = await page.eval_on_selector("#tester-frame", "el => el.dataset.state || 'none'")
        frame_hidden = await page.eval_on_selector("#tester-frame", "el => el.hidden")
        status = await page.locator("#font-status").inner_text()
        check(frame_hidden or state == "loading" or "Loading" in status,
              f"a slow cut shows a loading state before the face arrives (state={state} hidden={frame_hidden} status={status[:40]!r})")

        # typing during the load must survive
        await page.wait_for_function("() => !document.querySelector('#tester-frame').hidden", timeout=15000)
        await page.fill("#sample-text", "typed during load")
        await page.wait_for_timeout(1400)
        check(await page.locator("#sample-output").inner_text() == "typed during load",
              "text typed while loading survives the face arriving")
        await ctx.close()

        # --------------------------------------- 2. failure keeps text and retries
        ctx, page, errors = await session(browser)
        await page.route("**/Chronoa-Black.otf", lambda route: route.abort())
        await page.goto(f"{BASE}/product.html?font=chronoa", wait_until="load")
        await page.wait_for_function("() => !document.querySelector('#tester-frame').hidden", timeout=15000)
        await page.fill("#sample-text", "keep this text")
        await page.select_option("#sample-style", "8")
        await page.wait_for_timeout(1500)
        check(await page.locator("#sample-text").input_value() == "keep this text",
              "a failed cut keeps the visitor's text in the input")
        check(not await page.locator("#retry-font").is_hidden(), "a failed cut shows retry")
        # retry must actually work once the file is available
        await page.unroute("**/Chronoa-Black.otf")
        await page.click("#retry-font")
        await page.wait_for_function("() => document.querySelector('#tester-frame').dataset.state !== 'error'", timeout=15000)
        await page.wait_for_timeout(300)
        check(await page.locator("#sample-output").inner_text() == "keep this text",
              "retry restores the visitor's text in the loaded cut")
        check(await page.eval_on_selector("#sample-output", "el => getComputedStyle(el).fontWeight") == "900",
              "retry loads the cut that failed before")
        await ctx.close()

        # ---------------------------------- 3. rapid switching: the latest one wins
        # The race only opens when the OLDER response arrives AFTER the newer one
        # has already finished, so the older request must be the slow one and the
        # newer request must be fast. Routes are registered per file on purpose:
        # a broader pattern registered later would shadow this one and the delay
        # would silently never apply.
        ctx, page, errors = await session(browser)

        async def slow_light(route):
            await asyncio.sleep(4.0)
            await route.continue_()

        await page.route("**/Chronoa-Light.otf", slow_light)
        await page.goto(f"{BASE}/product.html?font=chronoa", wait_until="load")
        await page.wait_for_function("() => !document.querySelector('#tester-frame').hidden", timeout=15000)
        # choose the slow cut first, then immediately a fast one
        await page.select_option("#sample-style", "2")
        await page.select_option("#sample-style", "7")
        # the newer choice must be in place well before the older response lands
        await page.wait_for_function("() => getComputedStyle(document.querySelector('#sample-output')).fontWeight === '800'", timeout=8000)
        # The wait above enforces the timing. This measures the same claim as a value
        # instead of counting a constant: at this instant the newer cut is loaded and
        # the abandoned one has not landed yet.
        faces = await page.evaluate("""() => [...document.fonts]
            .filter(f => f.family === 'Rilla-Chronoa')
            .map(f => `${f.weight}:${f.status}`)""")
        check("800:loaded" in faces,
              f"the newer cut is loaded before the older response lands ({faces})")
        check("300:loaded" not in faces,
              f"the abandoned slow cut has not landed yet ({faces})")
        # Cover the abandoned call's own file, feature and glyph requests too.
        await page.wait_for_timeout(6000)
        weight = await page.eval_on_selector("#sample-output", "el => getComputedStyle(el).fontWeight")
        selected = await page.eval_on_selector("#sample-style", "el => el.options[el.selectedIndex].textContent")
        status = await page.locator("#font-status").inner_text()
        check(selected == "ExtraBold", f"the selector still shows the latest choice ({selected})")
        check(weight == "800", f"the sample still renders the latest choice (weight={weight})")
        check("ExtraBold" in status, f"the status still describes the latest choice ({status[:70]!r})")
        facts = await page.locator("#glyph-count").inner_text()
        check("characters" in facts, f"glyph facts follow the latest cut ({facts!r})")
        check(not errors, f"no page errors after rapid switching ({errors[:2]})")
        await ctx.close()

        # ------------------ 3b. a slow probe for an abandoned cut must not win
        ctx, page, errors = await session(browser)
        seen = {}

        async def slow_light_probe(route):
            seen["light"] = seen.get("light", 0) + 1
            if seen["light"] >= 2:
                await asyncio.sleep(2.0)
            await route.continue_()

        await page.route("**/Chronoa-Light.otf", slow_light_probe)
        await page.goto(f"{BASE}/product.html?font=chronoa", wait_until="load")
        await page.wait_for_function("() => !document.querySelector('#tester-frame').hidden", timeout=15000)
        await page.select_option("#sample-style", "2")
        await page.wait_for_timeout(400)
        await page.select_option("#sample-style", "7")
        await page.wait_for_timeout(3200)
        weight = await page.eval_on_selector("#sample-output", "el => getComputedStyle(el).fontWeight")
        check(weight == "800", f"a late feature probe for an abandoned cut does not win (weight={weight})")
        await ctx.close()

        # ------------------------------- 4. clear, retype, and a style change
        ctx, page, errors = await session(browser)
        await page.goto(f"{BASE}/product.html?font=mango", wait_until="load")
        await page.wait_for_function("() => !document.querySelector('#tester-frame').hidden", timeout=15000)
        await page.fill("#sample-text", "")
        await page.wait_for_timeout(150)
        check("Type something" in await page.locator("#sample-output").inner_text(),
              "an empty sample text shows the prompt instead of a blank")
        await page.keyboard.type("Retyped")
        await page.wait_for_timeout(150)
        check(await page.locator("#sample-output").inner_text() == "Retyped", "retyping after clearing works")
        family = await page.eval_on_selector("#sample-output", "el => getComputedStyle(el).fontFamily")
        check("Rilla-MangoLetters" in family, f"the loaded face is not dropped by clearing ({family})")
        await ctx.close()

        # ------------------- 5. retry repeats the cut the visitor actually chose
        # A02: the retry button went through loadStyles(), which read the selector as
        # `Number(value) || defaultIndex`. Thin is index 0, so a retry after a Thin
        # failure asked for SemiBold instead. The count of real request attempts is
        # what proves the retry, because an aborted request never produces a response.
        ctx, page, errors = await session(browser)
        attempts = []

        async def fail_thin_once(route):
            # The route stays installed so every attempt is counted: the first one is
            # aborted, later ones are served, which is what "the network came back"
            # means for a retry. Unrouting would hide the retry's own request.
            attempts.append(route.request.url.rsplit("/", 1)[-1])
            if len(attempts) == 1:
                await route.abort()
            else:
                await route.continue_()

        await page.route("**/Chronoa-Thin.otf", fail_thin_once)
        await page.goto(f"{BASE}/product.html?font=chronoa", wait_until="load")
        await page.wait_for_function("() => !document.querySelector('#tester-frame').hidden", timeout=15000)
        await page.select_option("#sample-style", "0")
        await page.wait_for_timeout(1200)
        state = await page.eval_on_selector("#tester-frame", "el => el.dataset.state || 'none'")
        status = await page.locator("#font-status").inner_text()
        retry_visible = not await page.locator("#retry-font").is_hidden()
        check(attempts.count("Chronoa-Thin.otf") >= 1,
              f"choosing Thin asks the loader for the Thin file ({attempts})")
        check(state == "error" and retry_visible,
              f"a blocked Thin cut reports the error state and offers retry "
              f"(state {state}, retry visible {retry_visible}, status {status[:50]!r})")

        # A build that never asks for Thin cannot fail on it, so the button is absent:
        # keep the run going and let the comparisons below report the real state.
        if retry_visible:
            await page.click("#retry-font")
            try:
                await page.wait_for_function(
                    "() => document.querySelector('#tester-frame').dataset.state !== 'error'",
                    timeout=15000)
            except Exception:
                pass
        await page.wait_for_timeout(400)
        retried = await page.evaluate("""() => {
            const select = document.querySelector('#sample-style');
            const output = document.querySelector('#sample-output');
            return {
                cut: select.options[select.selectedIndex].textContent,
                status: document.querySelector('#font-status').innerText.trim(),
                weight: getComputedStyle(output).fontWeight,
                faces: [...document.fonts].filter(f => f.family === 'Rilla-Chronoa')
                                            .map(f => `${f.weight}:${f.status}`),
            };
        }""")
        check(attempts.count("Chronoa-Thin.otf") >= 2,
              f"retry asks for the same cut again, not the default ({attempts})")
        check(retried["cut"] == "Thin" and retried["status"].startswith("Showing the actual Chronoa (Thin)"),
              f"retry keeps Thin selected and named ({retried['cut']!r}, {retried['status'][:50]!r})")
        check(retried["weight"] == "100" and "100:loaded" in retried["faces"],
              f"retry loads the Thin face at weight 100 ({retried['weight']}, {retried['faces']})")
        await ctx.close()


        # ------------------------- 6. a cut that fails cold keeps the controls usable
        # A06: the frame was only unhidden on the success path, so a cold failure of the
        # default cut left a status message telling the visitor to pick another cut or
        # retry, with every control invisible. The sample must stay out of sight; the
        # controls must not.
        ctx, page, errors = await session(browser)
        bold_requests = []

        async def count_bold(route):
            bold_requests.append(route.request.url.rsplit("/", 1)[-1])
            await route.continue_()

        await page.route("**/Chronoa-SemiBold.otf", lambda route: route.abort())
        await page.route("**/Chronoa-Bold.otf", count_bold)
        await page.goto(f"{BASE}/product.html?font=chronoa", wait_until="load")
        await page.wait_for_timeout(1200)
        cold = await page.evaluate("""() => {
            const frame = document.querySelector('#tester-frame');
            const output = document.querySelector('#sample-output');
            const select = document.querySelector('#sample-style');
            const retry = document.querySelector('#retry-font');
            return {
                state: frame.dataset.state || 'none',
                frameHidden: frame.hidden,
                framePainted: Boolean(frame.offsetWidth || frame.offsetHeight),
                textPainted: Boolean(document.querySelector('#sample-text').offsetWidth),
                selectPainted: Boolean(select.offsetWidth),
                selectOptions: select.options.length,
                retryPainted: Boolean(retry.offsetWidth),
                samplePainted: Boolean(output.offsetWidth),
                status: document.querySelector('#font-status').innerText.trim(),
                family: getComputedStyle(output).fontFamily,
            };
        }""")
        check(cold["state"] == "error", f"the cold default failure is stated ({cold['state']})")
        check(not cold["frameHidden"] and cold["framePainted"],
              f"the control frame stays visible when the default cut fails ({cold})")
        check(cold["textPainted"] and cold["selectPainted"] and cold["retryPainted"],
              f"input, style selector and retry all stay usable ({cold})")
        check(not cold["samplePainted"],
              f"the untrustworthy sample stays hidden ({cold['samplePainted']})")
        check("could not load" in cold["status"].lower() and "retry" in cold["status"].lower(),
              f"the status explains the failure and names the way out ({cold['status'][:70]!r})")
        focused = True
        try:
            await page.locator("#retry-font").focus()
            focused = await page.evaluate("() => document.activeElement.id") == "retry-font"
        except Exception:
            focused = False
        check(focused, "the retry button can be reached with the keyboard")
        healthy_selected = True
        try:
            await page.select_option("#sample-style", "6")
        except Exception:
            healthy_selected = False
        recovered_healthy = healthy_selected
        try:
            await page.wait_for_function(
                "() => document.querySelector('#tester-frame').dataset.state !== 'error'"
                " && getComputedStyle(document.querySelector('#sample-output')).fontWeight === '700'",
                timeout=8000)
        except Exception:
            recovered_healthy = False
        healthy_status = await page.locator("#font-status").inner_text()
        check(recovered_healthy and "Bold" in healthy_status,
              f"a healthy cut loads while the failed default stays blocked ({healthy_status[:60]!r})")
        check(bold_requests, f"the healthy cut fetched its own file ({bold_requests})")
        await ctx.close()

        # ------------------- 6b. retry without touching the style reloads that style
        ctx, page, errors = await session(browser)
        default_attempts = []

        async def fail_default_once(route):
            default_attempts.append(route.request.url.rsplit("/", 1)[-1])
            if len(default_attempts) == 1:
                await route.abort()
            else:
                await route.continue_()

        await page.route("**/Chronoa-SemiBold.otf", fail_default_once)
        await page.goto(f"{BASE}/product.html?font=chronoa", wait_until="load")
        await page.wait_for_timeout(1200)
        typed = True
        try:
            await page.fill("#sample-text", "Kept while broken")
        except Exception:
            typed = False
        check(typed, "the visitor can still type while the default cut is broken")
        retry_painted = await page.locator("#retry-font").is_visible()
        if retry_painted:
            await page.click("#retry-font")
        retried_default = True
        try:
            await page.wait_for_function(
                "() => document.querySelector('#tester-frame').dataset.state !== 'error'"
                " && getComputedStyle(document.querySelector('#sample-output')).fontWeight === '600'",
                timeout=8000)
        except Exception:
            retried_default = False
        after_retry = await page.evaluate("""() => ({
            status: document.querySelector('#font-status').innerText.trim(),
            weight: getComputedStyle(document.querySelector('#sample-output')).fontWeight,
            text: document.querySelector('#sample-text').value,
        })""")
        check(retried_default and "SemiBold" in after_retry["status"],
              f"retry without changing the style reloads the same cut ({after_retry['status'][:60]!r})")
        check(len(default_attempts) >= 2,
              f"the retry asked the network for the default cut again ({default_attempts})")
        check(after_retry["text"] == "Kept while broken",
              f"the text kept through the failure survives the retry ({after_retry['text']!r})")
        await ctx.close()

        # ------------------------------ 6c. a single-style product, default broken
        ctx, page, errors = await session(browser)
        mango_attempts = []

        async def fail_mango_once(route):
            mango_attempts.append(route.request.url.rsplit("/", 1)[-1])
            if len(mango_attempts) == 1:
                await route.abort()
            else:
                await route.continue_()

        await page.route("**/mango-letter.otf", fail_mango_once)
        await page.goto(f"{BASE}/product.html?font=mango", wait_until="load")
        await page.wait_for_timeout(1200)
        mango = await page.evaluate("""() => {
            const frame = document.querySelector('#tester-frame');
            const select = document.querySelector('#sample-style');
            return {
                state: frame.dataset.state || 'none',
                framePainted: Boolean(frame.offsetWidth || frame.offsetHeight),
                textPainted: Boolean(document.querySelector('#sample-text').offsetWidth),
                retryPainted: Boolean(document.querySelector('#retry-font').offsetWidth),
                selectPainted: Boolean(select.offsetWidth),
                selectOptions: select.options.length,
                status: document.querySelector('#font-status').innerText.trim(),
            };
        }""")
        check(mango["state"] == "error" and mango["framePainted"] and mango["textPainted"] and mango["retryPainted"],
              f"a broken single-style default keeps its controls ({mango})")
        check(not mango["selectPainted"] and mango["selectOptions"] == 0,
              f"a single-style product still offers no style selector ({mango['selectOptions']} options)")
        mango_typed = True
        try:
            await page.fill("#sample-text", "Typed while mango was broken")
        except Exception:
            mango_typed = False
        check(mango_typed, "Mango's input stays usable while its only file is broken")
        if mango["retryPainted"]:
            await page.click("#retry-font")
        mango_recovered = True
        try:
            await page.wait_for_function(
                "() => document.querySelector('#tester-frame').dataset.state !== 'error'", timeout=8000)
        except Exception:
            mango_recovered = False
        mango_after = await page.evaluate("""() => ({
            family: getComputedStyle(document.querySelector('#sample-output')).fontFamily,
            text: document.querySelector('#sample-text').value,
            status: document.querySelector('#font-status').innerText.trim(),
        })""")
        check(mango_recovered and "Rilla-MangoLetters" in mango_after["family"],
              f"the recovered Mango specimen is the real product face ({mango_after['family']})")
        check(mango_after["text"] == "Typed while mango was broken",
              f"the text typed during Mango's failure survives ({mango_after['text']!r})")
        await ctx.close()

        # ---------------- 6d. the same failure at 390px, and a product with no file
        ctx, page, errors = await session(browser, width=390, height=844)
        await page.route("**/Chronoa-SemiBold.otf", lambda route: route.abort())
        await page.goto(f"{BASE}/product.html?font=chronoa", wait_until="load")
        await page.wait_for_timeout(1200)
        small = await page.evaluate("""() => {
            const frame = document.querySelector('#tester-frame');
            return {
                framePainted: Boolean(frame.offsetWidth || frame.offsetHeight),
                textPainted: Boolean(document.querySelector('#sample-text').offsetWidth),
                retryPainted: Boolean(document.querySelector('#retry-font').offsetWidth),
                selectPainted: Boolean(document.querySelector('#sample-style').offsetWidth),
                overflow: document.documentElement.scrollWidth - document.documentElement.clientWidth,
            };
        }""")
        check(small["framePainted"] and small["textPainted"] and small["retryPainted"] and small["selectPainted"],
              f"the controls survive the failure at 390px too ({small})")
        check(small["overflow"] <= 1, f"the failed state causes no horizontal overflow ({small['overflow']}px)")
        await ctx.close()

        ctx, page, errors = await session(browser)
        await page.goto(f"{BASE}/product.html?font=dockhand", wait_until="load")
        await page.wait_for_timeout(600)
        no_file = await page.evaluate("""() => ({
            status: document.querySelector('#font-status').innerText.trim(),
            framePainted: Boolean(document.querySelector('#tester-frame').offsetWidth),
        })""")
        check("no specimen file" in no_file["status"].lower() and "could not load" not in no_file["status"].lower(),
              f"a product with no specimen file is not reported as a network failure ({no_file['status'][:70]!r})")
        await ctx.close()
        await browser.close()

    failed = 0
    for ok, label in results:
        print(f"{'PASS' if ok else 'FAIL'}  {label}")
        failed += 0 if ok else 1
    print(f"\n{len(results) - failed}/{len(results)} checks passed")
    return 1 if failed else 0


if __name__ == "__main__":
    sys.exit(asyncio.run(main()))
