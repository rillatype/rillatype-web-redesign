# Rillatype Web Redesign — Progress Tracker

> 📌 **Satu-satunya source of truth untuk progress.**
> Update file ini SETIAP kali selesai ngerjain sesuatu. Jangan skip.
>
> Format: `Tanggal | Task # | Status ✅❌🔄 | Deskripsi | Notes | Durasi`
> Task # dari priority di `STATUS.md` bagian "Priority Queue Recommendation"

---

## Progress Log

| Tanggal | Task | Status | Deskripsi | Notes | Durasi |
|---------|------|--------|-----------|-------|--------|
| 2026-06-10 | — | ✅ | PLAN.md + PROMPT.md selesai | Blueprint awal | — |
| 2026-06-10 | — | ✅ | Homepage + Product page prototype v1 (playful) | — | — |
| 2026-06-10 | — | ✅ | Homepage + Product page prototype v2 (bright, anti-template) | Notion+Figma taste | — |
| 2026-06-10 | — | ✅ | WordPress theme framework (40+ files) | struktur dasar | — |
| 2026-06-10 | — | ✅ | STATUS.md + PROGRESS.md + GitHub push | handoff siap | — |
| 2026-06-11 | — | ✅ | Hero tag → "The un-curated type foundry" + Opsi C headlines | index-playful.html + v2 | — |
| 2026-06-11 | — | ✅ | Remove "Meet the maker" CTA + ghost CSS | both files | — |
| 2026-06-11 | — | ✅ | "Behind the type" → "License & perks" section | both files | — |
| 2026-06-11 | — | ✅ | Featured cards: white bg, border, shadow, prominent name/price | both files | — |
| 2026-06-11 | — | ✅ | Freebies card → no frame (image+text stacked) + better name | both files | — |
| 2026-06-11 | — | ✅ | Fresh Drops: card frame + name left / price right | both files | — |
| 2026-06-11 | — | ✅ | Blog section redesigned (lighter, hover bg, blog-box container) | both files | — |
| 2026-06-11 | — | ✅ | Custom License CTA section added | both files | — |
| 2026-06-11 | — | ✅ | Categories: auto from WooCommerce categories | front-page.php | — |
| 2026-06-11 | — | ✅ | ACF: Homepage Sections options page (Featured, Free, Fresh, Sale) | inc/acf-setup.php | — |
| 2026-06-11 | — | ✅ | front-page.php: dynamic queries for Free/Fresh/Sale | front-page.php | — |
| 2026-06-11 | — | ✅ | home.css: product card system, blog, license CTA styles | assets/css/home.css | — |
| 2026-06-11 | — | ✅ | Micro-animations (6): staggered entrance, category hover, badge pulse, CTA arrow, label line, header blur | index-playful.html + v2 | — |
| 2026-06-11 | #3 | ✅ | Shop page: archive-product.php, content-product.php, loop overrides, woocommerce.css, static/shop-playful.html | Playful grid + category pills + pagination | — |
| 2026-06-11 | #3 | ✅ | Shop: woocommerce.css rewrite — proper variables, product cards (white bg, border, shadow, hover lift), category pills, staggered animation, responsive grid | — | 30m |
| 2026-06-11 | #3 | ✅ | Shop: main.js — sticky header scroll effect + staggered card IntersectionObserver | — | 5m |
| 2026-06-11 | — | ✅ | header.php — fix nav structure cocok sama CSS (nav, nav-logo, nav-links, menu-toggle) | sebelumnya pake .header-inner yang ga match CSS | 10m |
| 2026-06-11 | — | ✅ | static/index-premium.html — Ethereal Glass dark mode, floating glass nav, asymmetrical bento grid, scroll reveal, double-bezel cards | high-end-visual-design skill | 20m |
| 2026-06-11 | — | ✅ | static/index-premium-light.html — Editorial Luxury light, Instrument Serif, bento grid, soft shadow | high-end-visual-design skill | 15m |
| 2026-06-11 | #3 | ✅ | Shop: image zoom on hover (transform scale 1.06) | woocommerce.css, preview.html | 5m |
| 2026-06-11 | #3 | ✅ | Shop: quick add-to-cart — icon circle bottom-right, fade in on hover | content-product.php, woocommerce.css, preview.html | 15m |
| 2026-06-11 | — | ✅ | preview.html — full shop demo page with real preview images, live nav, sticky header | standalone static, gak nimpa file WordPress | 20m |
| 2026-06-11 | #5 | ✅ | Register product ACF fields (specimen_regular_url, specimen_bold_url, formats, glyphs, weights) | inc/acf-setup.php — muncul di admin edit produk | 10m |
| 2026-06-11 | #6 | ✅ | Cart page override (cart.php, mini-cart.php) | woocommerce/cart/ | 25m |
| 2026-06-11 | #7 | ✅ | Checkout page override (form-checkout.php, thankyou.php) | woocommerce/checkout/ | 20m |
| 2026-06-11 | #8 | ✅ | My Account pages (login, dashboard, orders, downloads, addresses, view-order) | woocommerce/myaccount/ — 6 templates | 30m |
| 2026-06-11 | — | ✅ | woocommerce-forms.css — 350+ lines: cart, checkout, account, tables, notices, form fields, responsive | assets/css/woocommerce-forms.css | 20m |
| 2026-06-11 | — | ✅ | functions.php — enqueue forms CSS, mini-cart fragment refresh, account nav reorder | WooCommerce hooks | 10m |
| 2026-06-11 | #3 | ✅ | front-page.php — enhanced font tester section (slider, style buttons, presets) | matches existing JS capabilities | 10m |
| 2026-06-11 | — | ✅ | Navbar Sign In pill button — 11 static files + WordPress header + main.css | coral/charcoal pill, replaces "Account" text | 20m |
| 2026-06-11 | — | ✅ | page.php — static pages template | container + article + content | 5m |
| 2026-06-11 | — | ✅ | search.php — search results with empty state | pagination, post type label | 5m |
| 2026-06-11 | — | ✅ | archive.php — category/tag/author archives | title, excerpt, meta, pagination | 5m |
| 2026-06-11 | — | ✅ | footer.php — redesigned with footer-links matching static design | License, Privacy, Contact | 5m |
| 2026-06-11 | — | ✅ | main.css — footer, page/search/archive/pagination styles | 140+ lines new CSS | 10m |
| 2026-06-11 | — | ✅ | woocommerce-hooks.php — suppress default breadcrumb | biar ga dobel sama custom breadcrumb | 2m |
| 2026-06-11 | — | ✅ | style.css — hapus dead `:root` variables (--color-*) | redundant, gak dipake CSS lain | 2m |
| 2026-06-11 | — | ✅ | home.css — hapus `:root`, standardisasi variabel ke main.css | --coral→--accent, --charcoal→--text, --cream→--bg-alt, --sand→--bg, --border-light→--border, --bg-page→--bg, --coral-soft→--accent-soft | 5m |
| 2026-06-11 | — | ✅ | home.css — rename .category-link → .category-pill | konflik nama sama category-links.css, pill button pecah | 2m |
| 2026-06-11 | — | ✅ | front-page.php — update .category-link → .category-pill | 2 replacement | 1m |
| 2026-06-11 | — | ✅ | main.css — tambah --accent-soft: #FEF2EF | dipake product.css, gak didefinisikan | 1m |
| 2026-06-11 | — | ✅ | product.css — fix fallback --accent: #e0553d → #C1493A | 11 replacement, old hex dari home.css lama | 2m |
| 2026-06-11 | — | ✅ | functions.php — hapus jQuery dependency main.js & font-tester.js | vanilla JS, gak pake jQuery | 1m |
| 2026-06-11 | — | ✅ | home.css — hapus .container override | udah didefinisikan di main.css | 1m |
| 2026-06-11 | — | ✅ | woocommerce.css — standardisasi fallback values | hapus inconsistent fallback hex | 3m |
| 2026-06-11 | — | ✅ | woocommerce-forms.css — standardisasi fallback values | hapus inconsistent fallback hex, --border-light→--border | 5m |
| 2026-06-11 | — | ✅ | Full CSS audit — single source of truth variabel | main.css = satu-satunya `:root`, semua file pake var() dari sana | 25m |

---

## Priority Queue

| Urut | Task | Priority | Notes |
|------|------|----------|-------|
| #1 | Generate WOFF2 specimen + integrate font tester | 🔴 HIGH | Font tester ga jalan tanpa real font URL |
| #2 | front-page.php → real product data | 🔴 HIGH | Homepage masih placeholder |
| #3 | Isi ACF fields → data tiap produk | 🟡 MED | specimen_regular_url, formats, dll — per produk |
| #4 | Checkout: setup payment gateway (Stripe/ lainnya) | 🟢 LOW | Biar bisa transaksi beneran |
| #5 | Performance (WP Rocket, Imagify, WebP) | 🟢 LOW | Optional |
| #6 | SEO metadata + SEOPress | 🟢 LOW | Biar terindex Google |
| #7 | Migration → staging → live | 🟢 LOW | Launch |

---

## Template Entry

Copy-paste ini ke tabel di atas:

```markdown
| 2026-06-11 | #1 | ✅ | Generate WOFF2 specimen for Mango Letters | pyftsubset berhasil, file 12KB | 30m |
| 2026-06-11 | #2 | 🔄 | front-page.php — fetching real products | masih error di WP_Query | 45m |
```

Atau format ringkas (kalau males tabel):

```markdown
2026-06-11  #1  ✅  Generate WOFF2 specimen for Mango Letters (12KB) — 30m
2026-06-11  #2  ❌  front-page.php — WP_Query returns empty. Harus debug dulu.
```
