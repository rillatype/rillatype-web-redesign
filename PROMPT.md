You are building a custom WordPress theme for Rillatype Studio (rillatype.com), a font foundry that sells handcrafted display fonts and digital assets via WooCommerce.

---

## YOUR TASK

Build a complete custom WordPress theme called `rillatype-v2` from scratch. No page builders. No bought themes. Pure code.

---

## CONTEXT

- **Site**: rillatype.com — font foundry by Gustian (Rillatype Studio)
- **Current state**: WordPress + WooCommerce, running a bought theme (bloated, template-like)
- **Goal**: Replace with custom theme that is SEO-friendly, fast, minimal, beautiful — and does NOT look like a template
- **Target**: $500/month from font sales (USD)
- **Language**: English (site content), casual Indonesian (internal notes are fine)

---

## MASTER PLAN

The full detailed plan is at: `PLAN.md` in this same folder.

**READ PLAN.md IN FULL BEFORE STARTING.** It contains:
- Anti-template design philosophy (Section 1)
- Tech stack decisions (Section 2)
- Font tester spec — complete HTML/CSS/JS (Section 3) ⭐
- Site architecture (Section 4)
- Homepage & product page layouts (Sections 5-6)
- Design system: colors, typography, spacing (Section 7)
- SEO checklist — 36 required + 69 recommended items (Section 8)
- WordPress performance optimization (Section 9)
- Plugin strategy: keep vs kill (Section 10)
- Accessibility checklist (Section 11)
- Security config (Section 12)
- Agent readiness / llms.txt (Section 13)
- 15 Do's + 20 Don'ts (Section 14)
- 7 implementation phases (Section 15)
- Theme file structure (Section 16)
- Ecommerce flow (Section 17)

---

## CRITICAL RULES

### MUST DO

1. **Build on staging first** — NEVER touch the live site until Phase 7. The current theme must keep running.
2. **Follow the 7 phases in order** — each phase must be COMPLETE before moving to the next.
3. **Font tester is priority #1** — this is THE feature that sells fonts. Build it exactly as specified in Section 3.
4. **Specimen WOFF2 must be SUBSET** — use `pyftsubset` via fontTools. Max 15KB per file. NOT the full font file.
5. **Vanilla JavaScript only** — NO jQuery. NO React. NO Vue. NO framework.
6. **Minimal plugins** — max 6: WooCommerce, SEOPress, WP Rocket, Imagify, ACF, Umami (custom).
7. **Self-host ALL fonts** — no Google Fonts, no Adobe Fonts. WOFF2 in theme folder.
8. **Test on real mobile devices** — not just Chrome DevTools responsive mode.
9. **Meet ALL 36 required SEO items** from the specification.website checklist (Section 8).
10. **Lighthouse ≥ 90** — performance, accessibility, best practices, SEO.

### MUST NOT DO

1. **DO NOT buy or use any theme** — write every line yourself.
2. **DO NOT use page builders** — no Elementor, WPBakery, Gutenberg full-site-editing. Pure PHP/HTML/CSS.
3. **DO NOT use jQuery or any JS framework** — Vanilla JS only.
4. **DO NOT install more than 7 plugins** (including WooCommerce).
5. **DO NOT use external font services** — self-host everything.
6. **DO NOT make symmetric grid layouts** — asymmetry is intentional.
7. **DO NOT add card containers with box-shadow and border-radius** — font previews should float without containers.
8. **DO NOT add auto-play, sliders, carousels, popups, exit-intent** — none of these.
9. **DO NOT add fake scarcity** ("Only 3 left", "47 people viewing").
10. **DO NOT center section headings** — left-align them. Centered text = template smell.
11. **DO NOT use hero images** — typography IS the hero.
12. **DO NOT add features not in the plan** — scope creep is the enemy.

---

## DESIGN PHILOSOPHY

The primary directive: **"The font is the star, not the website."**

The website is just a frame. Every design decision must create space for font previews to dominate.

Anti-template means:
- Asymmetric grids (1 big + 2 small, not 2x2)
- Typography as the main visual element (huge text, no hero images)
- No card containers — font previews float without boxes
- Left-aligned section headings (NOT centered)
- Intentional whitespace that creates tension
- One "weird" layout choice per page
- Varying section sizes (not uniform padding everywhere)

---

## FONT TESTER (Section 3 in PLAN.md)

This is the single most important feature. It lets users type their own text and see it rendered live with the font they're about to buy.

Key requirements:
- Textarea → live display sync (Vanilla JS)
- Size slider (16px–200px)
- Style/weight toggle buttons
- Preset text buttons
- WOFF2 loaded on-demand via Intersection Observer (NOT on page load)
- Subset specimens (15KB max, via `pyftsubset`)
- Accessible: keyboard-operable, aria labels, live regions

The full HTML/CSS/JS is in Section 3 of PLAN.md. Build it EXACTLY as specified.

---

## TECH STACK

- **Platform**: WordPress (latest)
- **Ecommerce**: WooCommerce (keep existing — DO NOT migrate products unless Phase 6)
- **SEO**: SEOPress (or Rank Math — NOT Yoast)
- **Caching**: WP Rocket
- **Images**: Imagify or Converter for Media (auto WebP)
- **Custom fields**: ACF (for font specimen data)
- **Analytics**: Umami (custom integration, cookieless)
- **CDN/Security**: Cloudflare (if available)

---

## THEME STRUCTURE

```
wp-content/themes/rillatype-v2/
├── style.css
├── functions.php
├── header.php
├── footer.php
├── index.php
├── front-page.php
├── singular.php
├── 404.php
├── woocommerce/
│   ├── archive-product.php
│   ├── single-product.php
│   ├── content-product.php
│   └── content-single-product.php
├── template-parts/
│   ├── font-tester.php
│   ├── font-grid.php
│   ├── font-card.php
│   ├── category-links.php
│   └── skip-link.php
├── assets/
│   ├── css/
│   │   ├── main.css
│   │   ├── woocommerce.css
│   │   └── font-tester.css
│   ├── js/
│   │   ├── main.js
│   │   └── font-tester.js
│   ├── fonts/
│   │   └── specimens/ (subset WOFF2 files)
│   └── images/ (favicon, OG default)
└── inc/
    ├── acf-setup.php
    ├── performance.php
    └── woocommerce-hooks.php
```

---

## IMPLEMENTATION ORDER

### Phase 1: Setup & Foundation
- Fresh WP install on staging/local
- Install 5-6 core plugins
- Create theme folder structure
- `style.css`, `functions.php`, `header.php`, `footer.php`, `index.php`, `404.php`, `front-page.php`
- CSS design system: custom properties, typography, spacing
- Cloudflare/security headers
- Umami tracking code

### Phase 2: Shop & Product Pages
- WooCommerce template overrides
- Custom product card (no container, asymmetric grid)
- Single product page layout
- ACF fields for font specimen data
- Breadcrumbs

### Phase 3: Font Tester
- Build complete font tester component
- Vanilla JS: text sync, slider, style buttons, presets
- Intersection Observer lazy loading
- Generate specimen WOFF2 files with pyftsubset
- Integrate into single product template

### Phase 4: Homepage & Content Pages
- Typography-driven hero (huge text, NO image)
- Asymmetric featured font grid
- Category text row
- Latest releases
- Blog templates

### Phase 5: Polish & Optimization
- WP Rocket full configuration
- WebP bulk conversion
- Disable WP bloat (emoji, embeds, dashicons on frontend)
- Lighthouse → fix → re-test → fix → re-test
- Accessibility audit (axe DevTools, keyboard, screen reader)
- Mobile testing (real devices)
- 404/500 validation

### Phase 6: Content Migration
- Migrate products to new theme
- Set ACF fields for each font
- Generate all specimen WOFF2 files
- Update meta descriptions
- Create `/llms.txt`

### Phase 7: Launch
- Final staging review
- Full backup
- Switch theme
- Flush all caches
- Submit sitemap to Google Search Console
- Monitor Umami

---

## COLORS

```css
--color-bg:          #F7F6F3;   /* Warm off-white */
--color-bg-alt:      #EDEBE6;   /* Slightly darker */
--color-text:        #1A1817;   /* Near-black */
--color-text-muted:  #787671;   /* Gray */
--color-accent:      #C1493A;   /* Terracotta red */
--color-accent-hover:#A33A2C;
--color-focus:       #2B5EA7;   /* Blue focus ring */
```

## TYPOGRAPHY

- **Body**: System font stack (`-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif`)
- **Headings**: One Rillatype font (self-hosted WOFF2, subset)
- **Font tester**: Specimen fonts loaded on-demand per product

## SPACING

8px base scale: 4, 8, 12, 16, 24, 32, 48, 80, 128px

## BREAKPOINTS

Mobile-first: `640px` / `768px` / `1024px` / `1280px`

---

## VERIFICATION

Before Phase 7 (launch), confirm:

- [ ] 36/36 SEO required items met
- [ ] Lighthouse: Performance ≥ 90, Accessibility ≥ 95, SEO = 100
- [ ] Font tester works on: Chrome, Firefox, Safari, iOS Safari, Android Chrome
- [ ] Keyboard navigation complete (Tab through all interactive elements)
- [ ] All images have alt text
- [ ] Custom 404 page returns HTTP 404 (not 200)
- [ ] HTTPS enforced
- [ ] No external font requests (all self-hosted)
- [ ] Sitemap accessible at /sitemap.xml
- [ ] robots.txt accessible at /robots.txt
- [ ] llms.txt accessible at /llms.txt
- [ ] Pinterest Rich Pins: og:type=product on product pages
- [ ] Umami tracking active
- [ ] WP Rocket cache working
- [ ] WebP serving correctly

---

## FINAL RULES

1. Plan first, then execute. Start each phase by reviewing the relevant section of PLAN.md.
2. If PLAN.md has the exact answer, use it. Don't improvise.
3. If you encounter something not covered in PLAN.md, default to: **simplest, lightest, most SEO-friendly option.**
4. Do NOT add features. Do NOT over-engineer. This is a font foundry, not a SaaS.
5. Test after every significant change. Don't build 5 things then test — build 1, test.
