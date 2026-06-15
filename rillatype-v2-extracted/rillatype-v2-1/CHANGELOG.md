# Changelog

## Hero
- Shuffle button repositioned inside `hero__actions` column layout, left-aligned
- Tagline color changed to coral (#e0553d)
- Hero background: gradient (coral-soft → cream) + dot pattern overlay
- Search overlay with centered input, auto-focus, Escape/X/outside close
- Headline auto-rotate: 5 headlines, random order on load, 5s interval, crossfade
- Shuffle button removed (replaced by auto-rotate)
- Tagline fade+blur reveal + slow glow pulse animation

## Featured Specimens
- Customizer: product count (1-12) via Appearance → Customize
- Query: `tax_query` on `product_visibility` → featured
- Fallback: 3 latest products if none starred
- Card: border #f0ece8, radius 12px, hover lift 6px + shadow, active scale(.97)
- Title/sub-title: splits at " — / – / - ", sub-title below title, ucwords case
- Responsive: 3-column at tablet (640-1023px), 1-column mobile

## Fresh Drops
- Customizer: count (1-24), sort by (newest/alphabetical/updated/random/price)
- 4-col grid, 8 products default, same card styling as featured
- Free badge via WC price check
- "View more" link: "What dropped →" (arrow diagonal hover effect)

## Freebies
- Query: simple products, _price = 0, max 3
- Card hover matches featured (lift 6px + shadow), body padding 12px 16px 16px
- Subtitle: "100% free. Commercial too."
- "View more" link: "No catch. →" (bounce + rotate hover effect)

## Category Pills
- Browse by style section with clickable category pills, centered
- Shop page pills below description (dynamic from WC categories)

## Navbar
- Dropdown position fixed: `position: relative` on `li.menu-item-has-children`
- Desktop: search icon (overlay toggle) + cart icon
- Mobile/Tablet (≤899px): hamburger toggle, floating dropdown panel (max-height 80vh, scrollable)
- Mobile: accordion sub-menus (parent → toggle is-open), coral bottom-border indicator
- Mobile: inline search form in nav-actions--mobile (input + magnifying glass icon)
- Mobile: cart link with count
- Body scroll locked when mobile menu open
- Glass effect: backdrop-filter blur 24px + saturate, .65 transparent bg, .82 on scroll

## Logo
- Custom logo via WP Customizer, max-height 38px, `.custom-logo-link` direct usage
- Removed nested `<a>` wrapper to fix oversized click area

## License & Perks
- 3-column section (Commercial License, OTF/TTF, Bonus Extras)
- Emoji replaced with inline SVG icons (document, typeface, sparkle)

## Blog
- From the Studio section: editorial divider-list style, coral border-bottom hover
- Title link to blog archive page
- "View more" link: "More words →" (slide-to-right hover effect)

## CTA
- Need Something Custom section: coral background, white text, charcoal outline button

## Newsletter
- New section below CTA: dark charcoal bg, form input + subscribe button

## Section Labels
- Coral left-border decoration (2px solid var(--coral)), removed stale transform animation
- All section labels changed from `<p>` to `<h2>` for SEO

## Process
- Behind the Scenes section: 3-column, icon + heading + description

## Graphic Assets
- Removed from homepage (commented out)

## Search
- Overlay toggle with centered input (font-size 20px bold), auto-focus on open
- Enter submits search, Escape/X/outside close
- Navbar search icon uses `<button>` not `<a>`

## SEO
- Hero headline changed from `<div>` to `<h1>` (critical SEO fix)
- All section labels changed from `<p>` to `<h2>` (proper heading hierarchy)
- Open Graph tags: og:title, og:description, og:image, og:url, og:type, og:site_name
- Twitter Cards: summary_large_image
- Meta description: explicit from bloginfo('description')
- Google Fonts preconnect added for faster loading

## Shop Page
- Full WooCommerce archive template: header → section label → description → category pills → toolbar → 3-col grid → pagination
- Grid: 3 columns (`.font-showcase` base)
- Product cards: same .font-card styling as homepage (border, hover lift, title/sub-title split, min price)
- Sort dropdown: pill style (50px radius, coral hover)
- Category pills: dynamic from WC categories with count (superscript format)
- Toolbar: sort select only (result count hidden)
- Description: "Every font, every pack, every extra we make." — Plus Jakarta Sans bold 800, center
- Section label: "All products" (left-aligned coral left-border)
- Products per page: 15 (multiple of 3 for grid balance)
- Breadcrumb removed
- WooCommerce archive description removed
- Mobile: category pills hidden entirely, sort compact + center (12px, max-width 200px)

## Pagination
- Custom template: clean flat HTML (no `ul > li`), matches reference style
- CSS: white bg, 1.5px border, 8px radius, hover charcoal, active coral

## Single Product Page
- Rebuilt toward `static/product-playful-v2.html` reference while keeping existing site navbar/footer.
- Product hero: larger preview/gallery area on the left, product summary on the right.
- Product title styling adjusted back to Plus Jakarta Sans 800 (not serif), matching the reference feel.
- Product title/sub-title split from product name.
- Product badge changed from `Best Seller` to `New`.
- `New` badge only displays when product publish date is within the last 30 days.
- License labels normalized so WooCommerce slugs become readable names:
  - `standard-license` → `Standard License`
  - `extended-license` → `Extended License`
  - `webfont-license` → `Webfont License`
- Fixed duplicated license text such as `standard-license License`.
- License selector supports variable products.
- Add to cart button keeps charcoal → coral hover treatment.
- `Full license details →` link now points to `/font-license/`.
- Added playground/font tester section based on `product-playful-v2.html`:
  - editable tester text
  - size slider
  - leading slider
  - tracking slider
  - font dropdown
  - text alignment controls
  - background swatches
  - preset text buttons
- Added product gallery slider/lightbox/sticky cart JS structure from the new single product page build.
- Added source indicator for admins in the tester hint: `Font source: filename.otf` or `not found`.

## Product Font Tester / Preview Font Source
- Goal: make the new playground use the actual uploaded product font.
- First approach: read a custom `Tester Font URL` field from the product.
- Changed to upload field instead of manual URL because user wants upload, not paste link.
- Tried adding tester font upload under WooCommerce variable product variations.
- Variation-row upload was removed because it was confusing and could affect variable product workflow.
- Moved upload UI back toward the old-theme style: `Product Preview` metabox on edit product.
- Implemented a native WordPress `Product Preview` metabox so it does not depend on paid plugins/ACF.
- Native metabox fields:
  - Enable Font Preview
  - Font Preview Mode
  - Font Name
  - OTF/TTF Font File
  - WOFF/WOFF2 Font File
  - Add/Select Font row
- Fixed admin upload button issues:
  - ensured product admin JS loads on `post.php` / `post-new.php`
  - added WordPress media dependencies
  - changed generated field IDs so selectors do not break from `[]` characters
  - fixed cloned rows so new upload rows do not reuse duplicate IDs
- Added support for legacy theme font data so existing products do not need full re-upload:
  - reads `_font_data`
  - prioritizes `_font_data_0_font_web` (WOFF/WOFF2)
  - falls back to `_font_data_0_font` (OTF/TTF)
- Added fallback sources in this order:
  - legacy `_font_data` attachment fields
  - variation tester font meta
  - parent product tester font meta
  - ACF `specimen_regular_url` if available
  - WooCommerce downloadable font file if direct `.otf/.ttf/.woff/.woff2`
- Font source now shows on the front-end, confirming the product font file is being detected.
- Several loading strategies were tested:
  - PHP inline `@font-face`
  - base64 embedded font source
  - direct uploaded file URL source
  - `FontFace` API in JS
  - forced `font-family` with `!important`
  - MIME mapping for `.otf`, `.ttf`, `.woff`, `.woff2`
  - browser load detection via `document.fonts.load()`

## Session 2 — June 14, 2026
### Font Tester Fix (finally working)
- Root cause: CSS `!important` on `#tester-display` blocked JS inline style, and `document.fonts.load()` unreliable for OTF (false negative). Browser also rejects OTF via CSS `@font-face` due to MIME.
- Fix: `fetch()` → ArrayBuffer → `FontFace` API. Removed `!important` + inline style.

### Multi-font Support
- PHP reads ALL `_font_data` metabox rows (not just first). Each font gets unique `@font-face` family.
- Dropdown populated with all font names. JS loads all fonts in parallel.

### Tracking Slider Sensitivity
- Range `-50..200 step 1`, divided by 500 → step 0.002em (-0.1em to 0.4em).

### BG Swatch Colors
- Added `background` CSS to each `.tester__bgs` button. Fourth swatch: `#6b4c3a` warm brown (was `#ede8e0`).

### Tester Box Padding
- Removed `min-height: 2em` — was causing uneven vertical padding.

### Tester Layout Restructure
- Controls + presets above display. Reset button (↺) next to bg swatches.

### Short Description Removed
- Removed `product-short-desc` from hero section (redundant).

### Character Set Section
- Collapsible section below Playground. Font selector, size slider (12-72px), glyph grid (A-Z, a-z, 0-9, punctuation).

### License Descriptions
- One-liner per license matched via `strpos` on variation name.
- Link `/font-license/` → `/license/` (product page + footer).

## Session 3 — June 14, 2026
### About Section (Product Description)
- Editorial typography: first paragraph 20px darker, body 18px/1.8, max-width 680px
- Subheadings styled (Instrument Serif italic h3, coral uppercase h4)
- Subtle cream gradient background
- Fixed bullet list: custom coral `::before` (bypassed global `list-style:none`), flex alignment

### FAQ Section
- Removed WOFF2 references (only TTF/OTF offered)
- Q3 rewritten: "Can I use these fonts on my website?"
- Visual reverted back to original (coral-soft gradient, white cards)

### Related Products
- Card styling: border `#f0ece8`, radius 12px, hover lift 6px + shadow
- Price: minimum only via `rillatype_min_price()` instead of range
- Price color: coral + weight 600 agar terlihat (was `--text-muted`)

## Footer
- Mobile: stack vertikal, link center wrap, copyright di bawah

## Session 4 — June 15, 2026
### Add-to-Cart Fix (iframe + optimistic timeout)
- Root cause: fetch/AJAX add-to-cart didn't reliably trigger WooCommerce cart refresh.
- Fix: hidden iframe + native `form.submit()` + optimistic 1.5s timeout → button resets and shows toast even without callback.
- Button text no longer stuck on "Adding…".

### Cart/Checkout Template Recursion
- Root cause: `woocommerce/cart/cart.php` and `woocommerce/checkout/form-checkout.php` called `the_content()` inside `[woocommerce_cart]` shortcode → infinite recursion.
- Fix: deleted both template overrides. `page.php` handles cart/checkout via `the_content()` → shortcode without loop.

### Sticky Bar (Single Product)
- Enlarged: padding 14px → 22px, thumbnail 52×35 → 64×44, name 15px → 17px, price 16px → 18px, button 12px28 → 14px36, font 14px → 15px.

### License & Perks (Homepage)
- Added section between Journal and Custom License CTA: 3 cards (Commercial License, OTF & TTF, Bonus Extras).
- Grid stays 3 columns on tablet (removed `1fr` collapse at 768px).

### Free Stuff (Homepage)
- Added section below License & Perks: random 3 free products from WooCommerce.
- `orderby => rand` + `shuffle()` after query → beneran random tiap reload.

### Style
- Fixed typo `;m` → `;` on `.freebie__badge` animation rule.

## Known Issues (not yet fixed)
- Mobile dropdown toggle: clicking parent link to close sub-menu doesn't work on touch devices. Parent href overridden to `javascript:void(0)` + `e.preventDefault()` — still no closure. Root cause likely mobile browser fast-click optimization bypassing click handler.
- Cart/checkout pages need styling — currently render via page.php with basic `.page-content` styling only.

## Files
- `front-page.php` — all homepage markup
- `style.css` — all theme CSS (~2,900 lines)
- `inc/customizer.php` — Featured Products & Fresh Drops settings
- `assets/js/main.js` — search overlay, mobile menu toggle, sub-menu accordion
- `header.php` — logo, nav, search overlay, mobile nav-actions
- `footer.php` — footer markup
- `functions.php` — theme setup, WooCommerce, assets enqueue, cart fragment, min price helper
- `woocommerce/archive-product.php` — shop archive template
- `woocommerce/content-product.php` — product card in grid
- `woocommerce/content-single-product.php` — single product page
- `assets/js/product.js` — single product gallery, lightbox, font tester controls, sticky bar, font-load diagnostics
- `assets/js/admin-product.js` — native product preview upload controls in WP admin
- `woocommerce/loop/orderby.php` — sort dropdown
- `woocommerce/loop/pagination.php` — clean pagination
- `woocommerce/cart/` — cart templates
- `woocommerce/checkout/` — checkout templates
- `woocommerce/myaccount/` — my account templates
- `CHANGELOG.md` — this file
