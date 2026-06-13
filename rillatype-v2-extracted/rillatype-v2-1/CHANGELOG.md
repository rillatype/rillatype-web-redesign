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
- 2-column layout: gallery left, summary right
- Title + subtitle split from product name
- Add to cart button (charcoal → coral hover)
- Variable product support (dropdown weight/size)
- Tabs + related products

## Cart/Checkout/My Account
- Basic wrapper (header + container + footer) — functional, not yet styled

## Footer
- Mobile: stack vertikal, link center wrap, copyright di bawah

## Known Issues (not yet fixed)
- Mobile dropdown toggle: clicking parent link to close sub-menu doesn't work on touch devices. Parent href overridden to `javascript:void(0)` + `e.preventDefault()` — still no closure. Root cause likely mobile browser fast-click optimization bypassing click handler.

## Files
- `front-page.php` — all homepage markup
- `style.css` — all theme CSS (~2,800 lines)
- `inc/customizer.php` — Featured Products & Fresh Drops settings
- `assets/js/main.js` — search overlay, mobile menu toggle, sub-menu accordion
- `header.php` — logo, nav, search overlay, mobile nav-actions
- `footer.php` — footer markup
- `functions.php` — theme setup, WooCommerce, assets enqueue, cart fragment, min price helper
- `woocommerce/archive-product.php` — shop archive template
- `woocommerce/content-product.php` — product card in grid
- `woocommerce/content-single-product.php` — single product page
- `woocommerce/loop/orderby.php` — sort dropdown
- `woocommerce/loop/pagination.php` — clean pagination
- `woocommerce/cart/` — cart templates
- `woocommerce/checkout/` — checkout templates
- `woocommerce/myaccount/` — my account templates
- `CHANGELOG.md` — this file
