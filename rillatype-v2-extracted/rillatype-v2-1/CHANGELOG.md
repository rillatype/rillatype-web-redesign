# Changelog

## Hero
- Shuffle button repositioned inside `hero__actions` column layout, left-aligned
- Tagline color changed to coral (#e0553d)
- Hero background: gradient (coral-soft → cream) + dot pattern overlay
- Search overlay with centered input, auto-focus, Escape/X/outside close
- Headline auto-rotate: 5 headlines, random order on load, 5s interval, crossfade
- Shuffle button removed (replaced by auto-rotate)

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

## Freebies
- Query: simple products, _price = 0, max 3
- Card hover matches featured (lift 6px + shadow), body padding 12px 16px 16px
- Subtitle: "100% free. Commercial too."

## Category Pills
- Browse by style section with clickable category pills, centered

## Navbar
- Dropdown position fixed: `position: relative` on `li.menu-item-has-children`
- Desktop: search icon (overlay toggle) + cart icon
- Mobile/Tablet (≤899px): hamburger toggle, floating dropdown panel (max-height 80vh, scrollable)
- Mobile: accordion sub-menus (parent → toggle is-open), coral bottom-border indicator
- Mobile: inline search form in nav-actions--mobile (input + magnifying glass icon)
- Mobile: cart link with count
- Body scroll locked when mobile menu open

## Logo
- Custom logo via WP Customizer, max-height 38px, `.custom-logo-link` direct usage
- Removed nested `<a>` wrapper to fix oversized click area

## License & Perks
- 3-column section (Commercial License, OTF/TTF, Bonus Extras)

## Blog
- From the Studio section: editorial divider-list style, coral border-bottom hover
- Title link to blog archive page

## CTA
- Need Something Custom section: coral background, white text, charcoal outline button

## Section Labels
- Coral left-border decoration (2px solid var(--coral)), removed stale transform animation

## Process
- Behind the Scenes section: 3-column, icon + heading + description

## Graphic Assets
- Removed from homepage (commented out)

## Search
- Overlay toggle with centered input (font-size 20px bold), auto-focus on open
- Enter submits search, Escape/X/outside close
- Navbar search icon uses `<button>` not `<a>`

## Known Issues (not yet fixed)
- Mobile dropdown toggle: clicking parent link to close sub-menu doesn't work on touch devices. Parent href overridden to `javascript:void(0)` + `e.preventDefault()` — still no closure. Root cause likely mobile browser fast-click optimization bypassing click handler. Needs `touchstart` `preventDefault` approach but conflicts with scroll.

## Files
- `front-page.php` — all homepage markup
- `style.css` — all theme CSS (~2,600 lines)
- `inc/customizer.php` — Featured Products & Fresh Drops settings
- `assets/js/main.js` — search overlay, mobile menu toggle, sub-menu accordion
- `header.php` — logo, nav, search overlay, mobile nav-actions
- `functions.php` — theme setup, WooCommerce, assets enqueue, cart fragment
- `CHANGELOG.md` — this file
