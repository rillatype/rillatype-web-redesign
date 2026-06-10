# Rillatype.com Web Redesign — Master Plan v2

> **Tujuan**: Bikin ulang rillatype.com dengan custom WordPress theme dari nol (bukan tema beli). 
> **SEO-friendly, bagus, simpel, cepat, dan tidak terlihat seperti template**.
>
> **Target**: Model AI lain yang akan ngerjain implementasi. Setiap instruksi harus actionable.
>
> **Bisnis**: Font foundry. Jual font & digital assets. Target $500/bulan (USD).

---

## Daftar Isi

1. [Filosofi Desain — NOT Template](#1-filosofi-desain--not-template)
2. [Tech Stack — WordPress Custom Theme](#2-tech-stack--wordpress-custom-theme)
3. [Font Tester — The Killer Feature](#3-font-tester--the-killer-feature) ⭐
4. [Site Architecture & Pages](#4-site-architecture--pages)
5. [Homepage Design](#5-homepage-design)
6. [Product Page Design](#6-product-page-design)
7. [Color, Typography & Design System](#7-color-typography--design-system)
8. [SEO — Full Specification Checklist](#8-seo--full-specification-checklist)
9. [Performance — WordPress Optimized](#9-performance--wordpress-optimized)
10. [WordPress Plugins: Keep vs Kill](#10-wordpress-plugins-keep-vs-kill)
11. [Accessibility](#11-accessibility)
12. [Security](#12-security)
13. [Agent Readiness](#13-agent-readiness)
14. [Do's & Don'ts](#14-dos--donts)
15. [Implementation Phases](#15-implementation-phases)
16. [Theme File Structure](#16-theme-file-structure)
17. [Checkout & Ecommerce Flow](#17-checkout--ecommerce-flow)

---

## 1. Filosofi Desain — NOT Template

### Masalah dengan template WordPress

Template komersial (ThemeForest, Envato, dll) punya pola yang sama:

```
❌ Hero section dengan stock layout (teks kiri, gambar kanan)  
❌ 3-column "features" cards di bawah hero  
❌ Section bergantian bg putih/abu-abu — predictable  
❌ Card product dengan border-radius 8px + shadow — cookie cutter  
❌ Footer mega-menu 4 kolom  
❌ Semua section punya padding yang sama — monoton  
❌ Scroll animasi fade-in yang generic  
❌ Hamburger menu di desktop (kenapa?)  
```

Itu semua **template smell**. Harus dihindari.

### Anti-Template Principles

| Prinsip | Artinya |
|---------|---------|
| **Typography as hero** | Teks gede (5vw–10vw) sebagai elemen visual utama. Tanpa image hero. |
| **One-weird-layout** | Setiap halaman punya 1 layout choice yang "nggak biasa". Bukan column-grid-column semua. |
| **Asimetri intentional** | Grid yang nggak rata. Satu font card lebih gede. Whitespace yang "salah tempat". |
| **Typography rhythm** | Variasi ukuran, weight, tracking, dan color — bukan cuma bold/normal. |
| **Break the box** | Elemen yang overflow dari containernya, teks yang nembus grid, overlapping subtle. |
| **No cards** | Font display tanpa card container — gambar + nama aja, tanpa box. |
| **Whitespace as weapon** | Bukan padding yang rata. Ada ruang kosong besar yang "nggak nyaman" — intentional tension. |

### Contoh konkret "bukan template"

**Homepage (bukan kayak ini):**
```
[LOGO]                    [SHOP] [ABOUT] [BLOG]
─────────────────────────────────────────────
                                    
  HANDCRAFTED      ← teks gede banget (8vw), rata kiri
      FONTS         ← turun dikit, lebih kecil
                    ← kosong, tension
  [→ EXPLORE]       ← CTA kecil di bawah, nggak centered

┌────────────────┐
│                │     ┌──────────┐
│  FONT PREVIEW  │     │ PREVIEW  │  ← 3 grid: 1 gede + 2 kecil. Asimetris.
│   (BESAR)      │     │ (kecil)  │
│                │     └──────────┘
└────────────────┘     ┌──────────┐
                       │ PREVIEW  │
                       │ (kecil)  │
                       └──────────┘
─────────────────────────────────────────────
  Display / Script / Handwritten / Free      ← kategori: 1 baris teks doang, bukan card
─────────────────────────────────────────────
```

**Yang dihindari:**
- Grid simetris 2x2 atau 3x3
- Card dengan border-radius + shadow
- Section header centered ("Our Featured Fonts ⭐")
- Padding-top: 80px; padding-bottom: 80px di setiap section
- Background abu-abu bergantian

---

## 2. Tech Stack — WordPress Custom Theme

### Kenapa tetap WordPress

| Alasan | Detail |
|--------|--------|
| **Data existing** | Produk, order, customer udah ada di WooCommerce. Migrasi = risiko data loss. |
| **WooCommerce** | Fitur lengkap: product variations, digital downloads, license management |
| **Blog** | WP native blogging. SEO-friendly URLs. |
| **Ekosistem** | Caching, SEO, security plugins mature |
| **User familiarity** | Kamu udah biasa — ga ada learning curve admin panel |

### Approach: Custom Theme from Scratch

```
BUKAN:  Beli tema → custom CSS child theme → override dengan !important → bloated
TAPI:   Theme kosong → tulis semua HTML/CSS/JS sendiri → ringan, full kontrol
```

### Theme Architecture

```
wp-content/themes/rillatype-v2/
├── style.css                     ← Theme header only
├── functions.php                 ← Enqueue scripts, register menus, WooCommerce hooks
├── index.php                     ← Fallback
├── front-page.php                ← Homepage
├── header.php                    ← <head> + nav
├── footer.php                    ← Minimal footer
├── singular.php                  ← Single post/page generic
│
├── woocommerce/                  ← WooCommerce template overrides
│   ├── single-product.php
│   ├── content-single-product.php
│   ├── archive-product.php
│   └── content-product.php       ← Product card in loops
│
├── template-parts/
│   ├── font-tester.php           ← ⭐ The font tester component
│   ├── font-grid.php             ← Grid of font previews
│   └── category-links.php        ← Category nav
│
├── assets/
│   ├── css/
│   │   ├── main.css              ← All styles (minimal, one file)
│   │   └── font-tester.css       ← Font tester styles
│   ├── js/
│   │   ├── main.js               ← Global JS (minimal)
│   │   └── font-tester.js        ← ⭐ Font tester logic
│   └── fonts/
│       └── (self-hosted WOFF2 untuk website UI)
│
└── screenshot.png                ← Theme preview
```

### Plugin Strategy: Minimal

**KEEP — esensial (maksimal 5 plugin):**

| Plugin | Kenapa |
|--------|--------|
| **WooCommerce** | Ecommerce backbone (produk, cart, checkout, digital downloads) |
| **SEOPress** (atau **Rank Math**) | Ganti Yoast. Lebih ringan, fitur lebih lengkap. |
| **WP Rocket** (atau **Flying Press**) | Caching + CSS/JS optimization |
| **Imagify** (atau **Converter for Media**) | Auto WebP conversion |
| **Umami Analytics** (custom integration) | Privacy-friendly analytics — via code snippet, bukan plugin |

**REMOVE — semua yang lain, terutama:**
- ❌ Page builder (Elementor, WPBakery, Gutenberg full-site editing) → pure code
- ❌ Slider/revolution slider → CSS-only atau zero
- ❌ Social share plugin → manual HTML
- ❌ Contact form plugin → custom lightweight atau formspree
- ❌ Security plugin bloated → server-level security (Cloudflare)
- ❌ Performance plugin redundant → WP Rocket handles all
- ❌ "All-in-one" optimization plugins → biasanya konflik

### Hosting

Tetap di hosting yang sekarang? Atau pindah?

| Opsi | Pros | 
|------|------|
| **Cloudways** (DigitalOcean VPS) | $14/bulan. Managed. Cepat. |
| **Kinsta** | Lebih mahal ($30+). Premium WP hosting. |
| **Rocket.net** | Edge caching. Cepat banget. $30/bulan. |
| **Hosting sekarang** + Cloudflare APO | Gratis. Kalau hosting sekarang cukup. |

**Rekomendasi**: Evaluasi hosting sekarang dulu. Kalau shared hosting biasa → pertimbangkan Cloudways + Cloudflare.

---

## 3. Font Tester — The Killer Feature ⭐

Ini fitur paling penting buat font foundry. Calon pembeli HARUS bisa nyoba font sebelum beli. Bukan cuma lihat gambar statis.

### Behavior

```
┌─────────────────────────────────────────────────────────┐
│  TRY THIS FONT                                          │
│                                                         │
│  ┌─────────────────────────────────────────────────────┐│
│  │                                                     ││
│  │     The quick brown fox jumps over the lazy dog     ││  ← Editable text
│  │                                                     ││  ← Rendered live with the font
│  └─────────────────────────────────────────────────────┘│
│                                                         │
│  ──────────────────────●──────────────────  Size: 48px  │  ← Slider
│                                                         │
│  [Regular] [Bold] [Italic] [Thin]                       │  ← Weight/style toggle
│                                                         │
│  Presets: [Aa Bb Cc] [The quick...] [HELLO WORLD]       │  ← Quick text presets
└─────────────────────────────────────────────────────────┘
```

### Spesifikasi Teknis

#### Requirements

1. **Live WOFF2 loading** — font specimen harus diload on-demand (WOFF2 subset untuk tester doang)
2. **No-reload preview** — ganti tekst/size/style harus instant, tanpa reload halaman
3. **Zero-framework JS** — Vanilla JS. Tidak boleh jQuery. Tidak boleh React.
4. **Accessible** — keyboard-operable slider, focus visible, aria labels
5. **Mobile-friendly** — di HP, ukuran teks auto-adjust ke viewport
6. **Performance** — WOFF2 specimen cuma diload saat user scroll ke tester section (Intersection Observer)

#### HTML Structure

```html
<section class="font-tester"
         data-font-name="Mango Letters"
         data-font-url="/wp-content/themes/rillatype-v2/assets/fonts/specimens/mango-letters.woff2"
         data-font-display-regular="/wp-content/themes/rillatype-v2/assets/fonts/specimens/mango-letters-regular.woff2"
         data-font-display-bold="/wp-content/themes/rillatype-v2/assets/fonts/specimens/mango-letters-bold.woff2"
         aria-label="Font tester for Mango Letters"
         role="region">

  <div class="font-tester__preview" aria-live="polite">
    <textarea 
      class="font-tester__input"
      id="tester-input"
      maxlength="200"
      aria-label="Type to preview this font"
      placeholder="Type here to try this font..."
    >The quick brown fox jumps over the lazy dog</textarea>
    
    <output 
      class="font-tester__display"
      id="tester-display"
      style="font-family: 'TesterFont'; font-size: 48px;"
      aria-live="off"
    >The quick brown fox jumps over the lazy dog</output>
  </div>

  <div class="font-tester__controls">
    <div class="font-tester__slider">
      <label for="tester-size">Size</label>
      <input 
        type="range" 
        id="tester-size" 
        min="16" 
        max="200" 
        value="48" 
        step="1"
        aria-label="Adjust font size"
      />
      <output id="tester-size-value">48px</output>
    </div>

    <div class="font-tester__styles" role="radiogroup" aria-label="Font style">
      <button class="font-tester__style active" data-weight="400" role="radio" aria-checked="true">
        Regular
      </button>
      <button class="font-tester__style" data-weight="700" role="radio" aria-checked="false">
        Bold
      </button>
      <!-- Dynamic — hanya muncul kalau font punya style ini -->
    </div>

    <div class="font-tester__presets">
      <button data-preset="The quick brown fox jumps over the lazy dog">Aa Bb Cc</button>
      <button data-preset="HELLO WORLD">All Caps</button>
      <button data-preset="Handcrafted with love">Short Phrase</button>
    </div>
  </div>
</section>
```

#### JavaScript Logic (Vanilla)

```javascript
// font-tester.js — NO jQuery, NO framework

class FontTester {
  constructor(section) {
    this.section = section;
    this.textarea = section.querySelector('.font-tester__input');
    this.display = section.querySelector('.font-tester__display');
    this.slider = section.querySelector('#tester-size');
    this.sizeOutput = section.querySelector('#tester-size-value');
    this.styleButtons = section.querySelectorAll('.font-tester__style');
    this.presetButtons = section.querySelectorAll('[data-preset]');
    
    this.fontLoaded = false;
    this.fontUrl = section.dataset.fontUrl;
    
    this.init();
  }

  init() {
    // 1. Load font only when scrolled into view
    const observer = new IntersectionObserver((entries) => {
      if (entries[0].isIntersecting && !this.fontLoaded) {
        this.loadFont();
        observer.disconnect();
      }
    }, { rootMargin: '200px' });
    observer.observe(this.section);

    // 2. Sync textarea → display
    this.textarea.addEventListener('input', () => {
      this.display.textContent = this.textarea.value || this.textarea.placeholder;
    });

    // 3. Size slider
    this.slider.addEventListener('input', () => {
      const size = this.slider.value;
      this.display.style.fontSize = `${size}px`;
      this.sizeOutput.textContent = `${size}px`;
    });

    // 4. Style buttons
    this.styleButtons.forEach(btn => {
      btn.addEventListener('click', () => {
        this.styleButtons.forEach(b => {
          b.classList.remove('active');
          b.setAttribute('aria-checked', 'false');
        });
        btn.classList.add('active');
        btn.setAttribute('aria-checked', 'true');
        this.display.style.fontWeight = btn.dataset.weight;
      });
    });

    // 5. Preset buttons
    this.presetButtons.forEach(btn => {
      btn.addEventListener('click', () => {
        const text = btn.dataset.preset;
        this.textarea.value = text;
        this.display.textContent = text;
      });
    });

    // Initial render
    this.display.textContent = this.textarea.value;
  }

  loadFont() {
    const font = new FontFace(
      'TesterFont',
      `url(${this.fontUrl}) format('woff2')`,
      { style: 'normal', weight: '400' }
    );
    
    font.load().then(loadedFont => {
      document.fonts.add(loadedFont);
      this.fontLoaded = true;
      this.section.classList.add('font-tester--loaded');
    }).catch(err => {
      console.warn('Font specimen failed to load:', err);
    });
  }
}

// Initialize
document.querySelectorAll('.font-tester').forEach(el => new FontTester(el));
```

#### CSS

```css
/* Specimen font — isolated, doesn't affect main site typography */
@font-face {
  font-family: 'TesterFont';
  src: url('/wp-content/themes/rillatype-v2/assets/fonts/specimens/mango-letters-regular.woff2') format('woff2');
  font-weight: 400;
  font-style: normal;
  font-display: optional; /* Don't block render */
}

.font-tester {
  background: var(--color-bg-alt);
  padding: var(--space-2xl) 0;
}

.font-tester__display {
  font-family: 'TesterFont', var(--font-body);
  font-size: 48px;
  font-weight: 400;
  line-height: 1.2;
  word-break: break-word;
  min-height: 2em;
  transition: font-size 0.1s ease;
  padding: var(--space-md);
  background: var(--color-bg);
}

.font-tester__input {
  position: absolute;
  opacity: 0;
  width: 1px;
  height: 1px;
  /* Visually hidden — user types here, 
     but the visual output is .font-tester__display */
}

.font-tester__slider input[type="range"] {
  width: 100%;
  accent-color: var(--color-accent);
  /* Custom styling: minimal, no box */
}

.font-tester__style {
  background: none;
  border: 1px solid var(--color-border);
  padding: var(--space-xs) var(--space-md);
  cursor: pointer;
  font-family: 'TesterFont', var(--font-body);
  font-size: var(--font-size-lg);
}

.font-tester__style.active {
  background: var(--color-text);
  color: var(--color-bg);
  border-color: var(--color-text);
}

.font-tester__presets button {
  background: none;
  border: none;
  color: var(--color-text-muted);
  cursor: pointer;
  font-size: var(--font-size-sm);
  text-decoration: underline;
  text-underline-offset: 3px;
}

/* Mobile */
@media (max-width: 768px) {
  .font-tester__display {
    font-size: clamp(24px, 8vw, 48px);
  }
}
```

### Font Specimen File Strategy

Jangan load WOFF2 full — itu file gede (bisa 100KB+ per weight). Bikin specimen subset:

```
Font full (jual):        MangoLetters-Bold.otf (120KB) → untuk buyer
Font specimen (tester):  mango-letters-bold-specimen.woff2 (15KB) → hanya charset A-Za-z0-9.,!?'"-
```

Caranya: pake `pyftsubset` (dari fontTools) buat bikin subset WOFF2:

```bash
pip install fonttools brotli

pyftsubset MangoLetters-Bold.otf \
  --output-file=mango-letters-bold-specimen.woff2 \
  --flavor=woff2 \
  --text="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789.,!?'\"-:;@#$%&*()+=/ " \
  --no-hinting \
  --layout-features=''
```

---

## 4. Site Architecture & Pages

### URL Structure

```
rillatype.com/
├── /                              ← Homepage
├── /shop/                         ← WooCommerce shop (all fonts)
├── /product-category/display/      ← Display fonts
├── /product-category/script/       ← Script fonts
├── /product-category/handwritten/  ← Handwritten fonts
├── /product-category/sans-serif/   ← Sans-serif
├── /product-category/serif/        ← Serif
├── /product-category/freebies/     ← Free fonts
├── /product/mango-letters/         ← Individual product page
├── /blog/                          ← Blog listing
├── /blog/post-slug/                ← Blog single
├── /about/                         ← About page
├── /font-license/                  ← Licensing page
├── /contact/                       ← Contact page
├── /faq/                           ← FAQ
└── /privacy/                       ← Privacy policy
```

URLs are shallow (max 2 levels). WP permalink settings: **Post name** (`/%postname%/`).

### WooCommerce Product Data Fields

Setiap font product HARUS diisi field berikut:

| Field | Example | Notes |
|-------|---------|-------|
| **Product name** | Mango Letters | Jangan pake "RT" prefix. Bersih. |
| **Price** | $18.00 | Regular price |
| **Categories** | Display, Handwritten | Bisa multiple |
| **Tags** | playful, retro, bold, poster, branding | Untuk filter + related products |
| **Description** | Full marketing copy | Bukan technical spec |
| **Short Description** | 1-2 sentences | Muncul di product card/archive |
| **Product Image** | Font specimen image (1200×800 WebP) | Main preview |
| **Product Gallery** | 3-5 in-use examples | PNG WebP optimized |
| **Downloadable Files** | .otf, .ttf, .woff2, license.pdf | WooCommerce Digital Downloads |
| **Attributes** | Formats (OTF, TTF, WOFF2), Glyphs count, Style | Variable products |
| **Custom Fields** | Font tester: specimen WOFF2 URL and available styles/weights | Muncul di single product page |

### Custom Fields untuk Font Tester (ACF atau native)

```
Field Group: Font Specimen Data

  specimen_regular_url    (file)    ← Path ke WOFF2 specimen Regular
  specimen_bold_url       (file)    ← Path ke WOFF2 specimen Bold  
  specimen_italic_url     (file)    ← Optional
  specimen_thin_url       (file)    ← Optional
  available_weights       (text)    ← "400,700" → comma-separated
  specimen_charset        (text)    ← "A-Z, a-z, 0-9, basic punctuation"
  preview_image_1         (image)   ← In-use example
  preview_image_2         (image)
  preview_image_3         (image)
  glyphs_count            (number)  ← "350"
  font_formats            (text)    ← "OTF, TTF, WOFF2"
```

---

## 5. Homepage Design

### Layout (bukan template)

```
═══════════════════════════════════════════════════════════════
  [LOGO]                                  [SHOP] [ABOUT] [BLOG]
───────────────────────────────────────────────────────────────
                                               ← empty space

  HANDCRAFTED                                    ← 7vw, bold, tight
      FONTS                                     ← 6vw, lighter
        FOR EVERY                                ← 5vw, serif/italic
          PROJECT                               ← weight contrast

  [Explore the Collection →]                    ← inline, not button

───────────────────────────────────────────────────────────────

┌──────────────────────┐
│  FEATURED FONT #1    │
│  (LARGE PREVIEW)     │
│                      │     ┌─────────────┐
│  Mango Letters       │     │  Font #2    │    ← Asimetris: 1 gede + 2 kecil
│  Display · Playful   │     │  Name       │
│  $18 · [View →]      │     └─────────────┘
│                      │     ┌─────────────┐
│                      │     │  Font #3    │
└──────────────────────┘     │  Name       │
                             └─────────────┘

═══════════════════════════════════════════════════════════════

  Display / Script / Handwritten / Sans Serif / Serif / Free    ← Text row, no boxes

═══════════════════════════════════════════════════════════════

  LATEST RELEASES                                              ← Section label, small

  [Font Preview — no card container]  Name · $price
  [Font Preview — no card container]  Name · $price
  [Font Preview — no card container]  Name · $price
  [Font Preview — no card container]  Name · $price

═══════════════════════════════════════════════════════════════

  ┌─ FROM THE BLOG ─────────────────────────────┐
  │                                             │
  │  Post title 1                    [Date]     │    ← Clean list format
  │  Post title 2                    [Date]     │
  │  Post title 3                    [Date]     │
  │                                             │
  └─────────────────────────────────────────────┘

═══════════════════════════════════════════════════════════════

  Instagram · Email                                        ← Footer: 1 line center
  © 2026 Rillatype Studio
```

### Anti-template notes

- **Tidak ada hero image.** Hero-nya cuma teks gede.
- **Tidak ada 3 icon cards** "Fast Delivery, Easy Download, bla bla". Itu template cliché.
- **Featured grid asimetris** — bukan 2×2, 3×3. Satu item dominan.
- **Kategori sebagai teks** — bukan card dengan icon.
- **Font list tanpa card** — gambar + nama, background transparan.
- **Blog sebagai list teks** — bukan card grid.
- **Whitespace intentional** — ada area kosong yang "nggak nyaman" sebelum teks gede.

---

## 6. Product Page Design

### Layout

```
═══════════════════════════════════════════════════════════════
  ← Back to Shop
───────────────────────────────────────────────────────────────
  
  Display > Mango Letters                    ← Breadcrumbs, small

                           MANGO LETTERS                       ← H1, gede, pake font specimen
                           $18.00 · In Stock
                           Formats: OTF, TTF, WOFF2 · 350 Glyphs

  ┌─────────────────────────────────┐
  │                                 │
  │   FONT PREVIEW (BESAR)          │    ← Gambar statis. WebP. 1200px width.
  │   Mango Letters in use          │
  │                                 │
  └─────────────────────────────────┘

  [Add to Cart — $18] · [Buy Now]                            ← Primary CTA, bold accent color

───────────────────────────────────────────────────────────────
  ⭐ TRY THIS FONT                                               ← Font Tester section
  ┌─────────────────────────────────────────────────────────────┐
  │   [font tester component seperti di Section 3]              │
  └─────────────────────────────────────────────────────────────┘
───────────────────────────────────────────────────────────────

  We created Mango Letters to bring warmth and playfulness       ← Description
  to your designs. Inspired by hand-painted signage...           ← No "lorem ipsum" vibe

  ───────────────────────────────────────────────────────────

  In-Use Examples                                               ← Gallery

  [Image 1]  [Image 2]  [Image 3]                              ← Clean, no carousel
                                                               ← Lightbox on click
  ───────────────────────────────────────────────────────────

  Similar Fonts                                                 ← Related products
  
  [Font Preview]  [Font Preview]  [Font Preview]               ← No card container
    Name · Price    Name · Price    Name · Price

  ───────────────────────────────────────────────────────────

  FAQ                                                          ← Relevant FAQ

  Q: What formats are included?
  A: You'll receive OTF, TTF, and WOFF2 files.

  Q: Can I use this for my logo?
  A: Yes, with the Commercial License.
```

### Product Page Anti-Template Notes

- **Judul font pake font specimen** — heading pakai @font-face font itu sendiri. Bukan system font.
- **Preview bukan carousel** — gambar statis. Static itu lebih reliable daripada carousel JS.
- **Tidak ada countdown timer** ("Only 3 left!") — itu trik murahan.
- **Tidak ada "social proof" fake** — kalau belum ada review, jangan pasang review.
- **Font tester adalah prioritas visual kedua** — setelah preview image.
- **Info teknis (formats, glyphs) clean** — bukan bullet list panjang.

---

## 7. Color, Typography & Design System

### Color Palette (Refined)

```css
:root {
  /* Warm off-white — bukan putih RS */
  --color-bg:           #F7F6F3;
  --color-bg-alt:       #EDEBE6;
  
  /* Near-black — bukan pure black */
  --color-text:         #1A1817;
  --color-text-muted:   #787671;
  --color-text-subtle:  #B0ADA8;
  
  /* Accent — red terracotta (hangat, bukan merah agresif) */
  --color-accent:       #C1493A;
  --color-accent-hover: #A33A2C;
  
  /* Surfaces */
  --color-border:       #DEDBD5;
  --color-focus:        #2B5EA7;       /* Blue — untuk focus ring */
  
  /* States */
  --color-success:      #3B7A56;
  --color-error:        #C1493A;
  --color-warning:      #C48B2E;
}

/* Dark mode — later phase */
@media (prefers-color-scheme: dark) {
  :root {
    --color-bg:         #171615;
    --color-bg-alt:     #22201E;
    --color-text:       #EDEBE6;
    --color-text-muted: #8A8780;
    --color-border:     #33302D;
  }
}
```

### Typography

```css
:root {
  /* Body: System font — zero load time. Clean, netral. */
  --font-body:           -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
  
  /* Secondary: Untuk label, caption, small UI text */
  --font-mono:           'SF Mono', 'Fira Code', monospace;
  
  /* Ukuran — fluid dengan clamp() */
  --font-size-caption:   0.75rem;      /* 12px */
  --font-size-body:      1rem;         /* 16px */
  --font-size-lead:      1.125rem;     /* 18px — untuk paragraph intro */
  --font-size-h3:        clamp(1.125rem, 2vw, 1.375rem);
  --font-size-h2:        clamp(1.5rem, 3vw, 2rem);
  --font-size-h1:        clamp(2rem, 5vw, 3.5rem);
  --font-size-hero:      clamp(3rem, 8vw, 7rem);
  
  --font-weight-normal:  400;
  --font-weight-medium:  500;
  --font-weight-bold:    700;
  
  --line-height-tight:   1.1;
  --line-height-base:    1.6;
  --line-height-loose:   1.8;
}
```

### Spacing (8px base)

```css
:root {
  --space-3xs:  0.125rem;  /*  2px */
  --space-2xs:  0.25rem;   /*  4px */
  --space-xs:   0.5rem;    /*  8px */
  --space-sm:   0.75rem;   /* 12px */
  --space-md:   1rem;      /* 16px */
  --space-lg:   1.5rem;    /* 24px */
  --space-xl:   2rem;      /* 32px */
  --space-2xl:  3rem;      /* 48px */
  --space-3xl:  5rem;      /* 80px */
  --space-4xl:  8rem;      /* 128px */
}
```

### Layout

```css
:root {
  --container-narrow:  min(720px, 100% - 2rem);
  --container:         min(1200px, 100% - 2rem);
  --container-wide:    min(1400px, 100% - 2rem);
}
```

### Typography Scale untuk Font Tester

Font specimen di tester = skala khusus. Range 16px–200px dengan slider.

### Font Preview Display Strategy

Ada 3 cara menampilkan font di website. BEDAKAN:

| Metode | Kapan | Load |
|--------|-------|------|
| **Static image** (WebP) | Product grid, featured section, OG | Eager / Lazy |
| **Live WOFF2 specimen** | Font tester on product page | On-demand (Intersection Observer) |
| **CSS @font-face** | UI headings (pake font Rillatype keren) | Preload critical |

---

## 8. SEO — Full Specification Checklist

### Required (36) — Wajib

#### WP-specific implementation

```php
// functions.php — essential SEO hooks

// 1. Title tag support
add_theme_support('title-tag');

// 2. HTML5 semantic markup
add_theme_support('html5', [
    'search-form',
    'comment-form',
    'comment-list',
    'gallery',
    'caption',
    'style',
    'script',
    'navigation-widgets',
]);

// 3. Language attribute
function rilla_html_lang() {
    return 'en'; // Default English
}
add_filter('language_attributes', function($output) {
    $lang = get_bloginfo('language');
    return 'lang="' . esc_attr($lang) . '"';
});

// 4. Meta viewport — must be in header.php
// <meta name="viewport" content="width=device-width, initial-scale=1">
```

#### Header.php checklist

```html
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <!-- WP outputs title-tag automatically -->
  
  <!-- Robots: handled by SEOPress/Rank Math -->
  
  <!-- Color scheme -->
  <meta name="color-scheme" content="light dark">
  
  <!-- Theme color -->
  <meta name="theme-color" content="#F7F6F3" media="(prefers-color-scheme: light)">
  <meta name="theme-color" content="#171615" media="(prefers-color-scheme: dark)">
  
  <!-- Open Graph: SEOPress handles this -->
  
  <!-- Preconnect -->
  <link rel="preconnect" href="<?php echo site_url(); ?>">
  
  <!-- Preload critical font (headings) -->
  <link rel="preload" 
        href="<?php echo get_template_directory_uri(); ?>/assets/fonts/rillatype-heading.woff2" 
        as="font" 
        type="font/woff2" 
        crossorigin>
  
  <!-- Loading CSS -->
  <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>">
  
  <!-- Favicons -->
  <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/favicon.svg" type="image/svg+xml">
  <link rel="icon" href="/favicon.ico" sizes="any">
  <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/assets/apple-touch-icon.png">
  
  <?php wp_head(); ?>
</head>
```

#### WooCommerce Product Page SEO

```
Title template:    {Product Name} — {Category} Font | Rillatype Studio
Meta description:  {Short description} (155 chars or less)
OG type:           product (NOT article — ini penting buat Pinterest Rich Pins!)
Schema:            Product + Offer + BreadcrumbList (via SEOPress/Rank Math)
Canonical:         Self-referencing
```

#### Checklist Required Items — WP tracker

- [x] `doctype html` — theme header.php 
- [x] `lang` attribute — WP `language_attributes()`
- [x] `meta charset` — WP `bloginfo('charset')`
- [x] `meta viewport` — header.php
- [x] `title` — add_theme_support('title-tag') + SEOPress
- [ ] Redirects — SEOPress redirection manager
- [ ] Meta robots — SEOPress per-page settings
- [ ] Heading hierarchy — custom theme = full control
- [ ] Color contrast — custom CSS = full control
- [ ] Image alt text — product images via WP media library
- [ ] Form labels — WooCommerce forms (override if needed)
- [ ] Keyboard navigation — custom theme = full control
- [ ] Focus indicators — custom CSS
- [ ] Skip links — add to header.php
- [ ] Semantic HTML — custom theme
- [ ] Descriptive links — custom theme
- [ ] HTTPS — hosting/Cloudflare
- [ ] HSTS — Cloudflare
- [ ] X-Content-Type-Options — hosting/.htaccess
- [ ] Clickjacking protection — hosting/.htaccess
- [ ] Cookie attributes — WooCommerce/WP native
- [ ] Stable URLs — maintain existing URL structure
- [ ] Core Web Vitals — custom theme (lightweight)
- [ ] Image optimization — Imagify / Converter for Media
- [ ] Cache-Control — WP Rocket
- [ ] Compression — hosting/Cloudflare
- [ ] Privacy policy — WP page
- [ ] Cookie consent — only if using non-essential cookies
- [ ] Custom 404 — 404.php in theme
- [ ] lang on inline content — manual

---

## 9. Performance — WordPress Optimized

### WP-specific critical path

```html
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <!-- No external fonts — everything self-hosted -->
  <!-- Style inline critical CSS, defer main CSS via WP Rocket -->
  <?php wp_head(); ?>
</head>
```

### WP Rocket settings (optimal for font foundry)

```
Cache:
  ✅ Mobile cache
  ✅ User cache (if logged-in users)
  Cache lifespan: 24 hours
  
File Optimization:
  CSS:
    ✅ Minify CSS
    ✅ Combine CSS (test first — combine bisa break CSS)
    ✅ Optimize CSS delivery (Remove Unused CSS)
  JS:
    ✅ Minify JS
    ✅ Combine JS (test first)
    ✅ Defer JS
    ❌ Delay JS — jangan, bisa break WooCommerce
  HTML:
    ✅ Minify HTML
    
Media:
  ✅ LazyLoad for images
  ✅ LazyLoad for iframes/videos
  ✅ Add missing image dimensions
  ❌ LazyLoad CSS background images
  
Preload:
  ✅ Activate Preloading
  ✅ Preload Links (instant page)
  
Advanced:
  ✅ Remove query strings from static resources
  ✅ Disable WordPress emojis (replace with system emoji)
  ✅ Disable WordPress embeds
```

### Image Pipeline

```
Upload (source PNG/JPEG) 
  → Imagify auto-convert to WebP 
  → WP Rocket serve WebP 
  → Cloudflare cache WebP
```

### WooCommerce Performance Tips

1. **Product image size**: Upload 1200px width. WP auto-generates smaller sizes.
2. **Disable WooCommerce scripts on non-shop pages** (via `functions.php`):
   ```php
   add_filter('woocommerce_enqueue_styles', '__return_empty_array'); // Block default CSS
   // Then include only what you need in your theme
   ```
3. **Cart fragments**: Disable or defer via WP Rocket
4. **Database**: Clean transients and orphaned data regularly

### Performance Targets

| Metric | Target |
|--------|--------|
| LCP | ≤ 2s |
| INP | ≤ 150ms |
| CLS | ≤ 0.05 |
| TTFB | ≤ 500ms (WP realistic) |
| Lighthouse | ≥ 90 |
| Page weight | < 800KB |

---

## 10. WordPress Plugins: Keep vs Kill

### KEEP (wajib)

| Plugin | Role |
|--------|------|
| **WooCommerce** | Toko, product management, digital downloads, orders |
| **SEOPress** (free/pro) | SEO: title/meta, schema, sitemap, OG, redirects |
| **WP Rocket** (premium, $59/yr) | Caching, CSS/JS optimization, lazy load, preload |
| **Imagify** (atau **Converter for Media**) | Auto WebP, compression |
| **ACF (Advanced Custom Fields)** | Custom fields untuk font tester URLs, weights, dll |

### MAYBE (kalau perlu)

| Plugin | Kapan |
|--------|-------|
| **WooCommerce Subscriptions** | Kalau nanti pake model subscription/font club |
| **WooCommerce Product Add-ons** | Kalau perlu extended license options |

### KILL (jangan install)

| Plugin | Kenapa |
|--------|--------|
| Yoast SEO | SEOPress lebih ringan |
| Elementor / WPBakery / Beaver Builder | No page builders |
| Jetpack | Bloat |
| Wordfence / Sucuri (heavy) | Cloudflare WAF handles security |
| Smush / EWWW (kalau pake Imagify) | Redundant |
| Autoptimize (kalau pake WP Rocket) | Redundant + konflik |
| WPML / Polylang (kalau single language) | Belum perlu |
| Any slider plugin | CSS-only atau tidak sama sekali |
| Social share plugins | Manual HTML di template |
| Contact Form 7 (kalau bisa formspree/Netlify) | Lebih ringan tanpa plugin |

---

## 11. Accessibility

Semua dari Section 8, plus WP-specific:

```php
// functions.php — a11y enhancements

// 1. Skip to main content link (added in header.php)
function rilla_skip_link() {
    echo '<a class="skip-link screen-reader-text" href="#main-content">Skip to main content</a>';
}

// 2. Add aria attributes to WooCommerce elements
add_filter('woocommerce_product_add_to_cart_text', function($text) {
    return '<span aria-hidden="true">' . $text . '</span><span class="screen-reader-text">Add to cart</span>';
});

// 3. Ensure all images have alt text fallback
add_filter('wp_get_attachment_image_attributes', function($attr) {
    if (empty($attr['alt'])) {
        $attr['alt'] = get_the_title();
    }
    return $attr;
});
```

---

## 12. Security

### .htaccess additions

```apache
# Security headers
<IfModule mod_headers.c>
  Header always set X-Content-Type-Options "nosniff"
  Header always set X-Frame-Options "DENY"
  Header always set Referrer-Policy "strict-origin-when-cross-origin"
  Header always set Permissions-Policy "camera=(), microphone=(), geolocation=()"
  Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains; preload"
</IfModule>

# Block wp-config.php access
<Files wp-config.php>
  Require all denied
</Files>

# Block XML-RPC (kalau tidak dipake)
<Files xmlrpc.php>
  Require all denied
</Files>
```

### Cloudflare (ideal)

- Full (strict) SSL
- WAF rules: block wp-login brute force, block xmlrpc.php
- Cache: standard caching + APO if available
- Bot Fight Mode: ON

---

## 13. Agent Readiness

### /llms.txt

Bikin via WP page template atau static file:

```markdown
# Rillatype Studio — Handcrafted Fonts

Rillatype Studio creates display fonts, script fonts, and digital design assets. 
Founded by Gustian, based in Indonesia.

## Shop

- All fonts: https://rillatype.com/shop/
- Free fonts: https://rillatype.com/product-category/freebies/

## Important pages

- Font license: https://rillatype.com/font-license/
- FAQ: https://rillatype.com/faq/
- Blog: https://rillatype.com/blog/

## Featured fonts

- Mango Letters: https://rillatype.com/product/mango-letters/
- (Add 4-5 top fonts)

## Contact

- Instagram: https://instagram.com/rillatype
```

### robots.txt (via SEOPress)

```
User-agent: *
Allow: /
Sitemap: https://rillatype.com/sitemap.xml

User-agent: GPTBot
Allow: /

User-agent: Claude-Web
Allow: /

User-agent: Google-Extended
Allow: /

User-agent: CCBot
Disallow: /

Disallow: /wp-admin/
Disallow: /wp-login.php
Disallow: /cart/
Disallow: /checkout/
Disallow: /my-account/
```

### JSON-LD Schema

SEOPress handles: Organization, Product, BreadcrumbList, Article, FAQ.

WooCommerce native schema → disable (konflik dengan SEOPress):

```php
// functions.php
add_action('wp', function() {
    remove_action('wp_head', [WC()->structured_data, 'generate_product_data']);
    remove_action('wp_head', [WC()->structured_data, 'generate_website_data']);
});
```

---

## 14. Do's & Don'ts

### ✅ DO

| # | Do | Detail |
|---|-----|--------|
| 1 | **DO** pake custom WP theme dari nol | File kosong. Tulis semua HTML/CSS/JS sendiri. |
| 2 | **DO** bikin font tester interaktif | Vanilla JS + WOFF2 specimen on-demand. Fitur pembeda utama. |
| 3 | **DO** self-host semua font | Specimen WOFF2 di theme folder. Jangan Google Fonts. |
| 4 | **DO** subset specimen font | pyftsubset buat tester — 15KB, bukan 120KB. |
| 5 | **DO** asimetris layout | 1 item gede + 2 kecil. Bukan grid rata. |
| 6 | **DO** typography sebagai visual utama | Hero tanpa gambar. Heading pake font specimen. |
| 7 | **DO** pake WP Rocket + Imagify | Minimum caching setup yang power. |
| 8 | **DO** SEOPress bukan Yoast | Lebih ringan, UI lebih clean. |
| 9 | **DO** minimal plugin | ≤7 plugin. Termasuk WooCommerce. |
| 10 | **DO** system font untuk body | Zero load time. Netral. Biar font specimen yang standout. |
| 11 | **DO** cache strategy agresif | Font preview gede. Harus di-cache di Cloudflare + browser. |
| 12 | **DO** alt text di semua preview | "Mango Letters font specimen — playful display typeface for branding" |
| 13 | **DO** custom 404 yang berguna | "Font not found. Browse our collection →" |
| 14 | **DO** Cloudflare protection | WAF, rate limiting, bot fight. Free tier udah bagus. |
| 15 | **DO** disable WooCommerce default CSS | Load custom CSS sendiri yang ringan. |

### ❌ DON'T

| # | Don't | Kenapa |
|---|-------|--------|
| 1 | **DON'T** beli tema lagi | Sama aja balik ke masalah awal. Bloat, susah custom. |
| 2 | **DON'T** pake page builder | HTML output kotor. Susah debug. Lambat. |
| 3 | **DON'T** install >10 plugin | Setiap plugin = potensi security hole + performance hit. |
| 4 | **DON'T** pake jQuery | 2026. Vanilla JS udah bisa semuanya. |
| 5 | **DON'T** pake Google Fonts / Adobe Fonts | External request = slow + privacy concern. |
| 6 | **DON'T** bikin card product khas template | No box shadow. No border-radius. No card container. |
| 7 | **DON'T** pake hero section generic | No "teks kiri, gambar kanan". No teks centered. |
| 8 | **DON'T** simetri kaku di grid | Bikin 1-2 item beda ukuran. Break the grid. |
| 9 | **DON'T** auto-play apapun | No video. No audio. No animation loop. |
| 10 | **DON'T** popup newsletter / exit intent | Paling annoying. Let email signup di footer aja. |
| 11 | **DON'T** pake slider / carousel | User jarang klik slide 3. Static grid lebih baik. |
| 12 | **DON'T** fake scarcity / social proof | "Only 3 left", "47 people viewing" — jangan. |
| 13 | **DON'T** konflik plugin caching | 1 plugin caching doang. Jangan tumpuk 3. |
| 14 | **DON'T** lupa disable WP emoji/embed | Script ga guna yang nambahin HTTP request. |
| 15 | **DON'T** hard-code font specimen path | Pake ACF/custom fields biar bisa diganti dari WP admin. |
| 16 | **DON'T** pake WooCommerce default CSS | Bikin style sendiri. Clean, minimal. |
| 17 | **DON'T** abaikan mobile test | Banyak user cari font dari HP. |
| 18 | **DON'T** redirect chain | Kalo pindah URL, langsung 301 ke destinasi final. |
| 19 | **DON'T** hide focus ring tanpa ganti | WCAG violation. Keyboard user butuh tau posisi fokus. |
| 20 | **DON'T** publish tanpa XML sitemap di Google Search Console | Submit + monitor indexing. |

---

## 15. Implementation Phases

### Phase 1: Setup & Foundation (Day 1-3)

- [ ] Setup local dev environment (Local by Flywheel / XAMPP / Docker)
- [ ] Install fresh WordPress
- [ ] Setup 5 core plugins: WooCommerce, SEOPress, WP Rocket, Imagify, ACF
- [ ] Create `rillatype-v2` theme folder
- [ ] Setup: `style.css`, `functions.php`, `header.php`, `footer.php`, `index.php`, `404.php`, `front-page.php`
- [ ] Design system: CSS custom properties, typography, spacing in `main.css`
- [ ] Setup Cloudflare (jika belum)
- [ ] Setup Umami analytics tracking code in footer
- [ ] Deploy stage 1 ke staging (test that WP + theme works)

### Phase 2: Shop & Product Pages (Day 4-7)

- [ ] WooCommerce template overrides: `archive-product.php`, `content-product.php`
- [ ] `single-product.php` with custom layout
- [ ] ACF fields: font specimen URLs, weights, preview images
- [ ] Font grid component (asimetris layout)
- [ ] Category pages (override default WC category template)
- [ ] Breadcrumbs (SEOPress handles, style custom)
- [ ] Product cards — tanpa card container

### Phase 3: Font Tester ⭐ (Day 8-10)

- [ ] Build font tester HTML/CSS
- [ ] Build `font-tester.js` (Vanilla JS — textarea sync, slider, style switch, preset buttons)
- [ ] Intersection Observer — load WOFF2 only when visible
- [ ] Generate specimen WOFF2 files (`pyftsubset` untuk font-font existing)
- [ ] Integrate font tester ke single product template via ACF fields
- [ ] Test on multiple fonts — pastikan works untuk semua style

### Phase 4: Homepage & Content (Day 11-13)

- [ ] `front-page.php` — asymmetric layout, typography-driven hero
- [ ] Featured fonts section (manual selection via ACF options page)
- [ ] Category text row
- [ ] Latest releases section
- [ ] Blog section (recent posts list)
- [ ] `singular.php` — generic page/post template
- [ ] Blog archive (`home.php`)

### Phase 5: Polish & Optimization (Day 14-16)

- [ ] WP Rocket configuration (full optimization)
- [ ] Imagify bulk convert to WebP
- [ ] Disable WooCommerce cart fragments where not needed
- [ ] Disable WP emoji, embeds, dashicons on frontend
- [ ] Lighthouse audit → fix issues → re-test
- [ ] Accessibility audit (axe DevTools, keyboard walkthrough)
- [ ] Mobile testing (real device: iPhone + Android)
- [ ] Validasi 404 & 500 pages
- [ ] Sitemap submission to Google Search Console
- [ ] Pinterest Rich Pins validation
- [ ] Open Graph / Twitter Card validation

### Phase 6: Content Migration (Day 17-18)

- [ ] Migrate products from current WP to new theme
- [ ] Set ACF fields untuk setiap font
- [ ] Generate specimen WOFF2 untuk semua font
- [ ] Update meta descriptions (via SEOPress)
- [ ] Create `/llms.txt` (via WP page template)

### Phase 7: Launch (Day 19-20)

- [ ] Final review on staging
- [ ] Backup everything
- [ ] Switch theme to rillatype-v2
- [ ] Flush permalinks
- [ ] Flush WP Rocket cache
- [ ] Flush Cloudflare cache
- [ ] Monitor via Umami
- [ ] Submit sitemap to Google Search Console

---

## 16. Theme File Structure

```
wp-content/themes/rillatype-v2/
│
├── style.css                          ← Theme header: Theme Name, Description, Version
├── screenshot.png                     ← 1200x900 preview
├── functions.php                      ← All hooks, enqueues, theme support
│
├── header.php                         ← <head> + opening body + nav
├── footer.php                         ← closing tags + footer content
├── index.php                          ← Fallback template
├── front-page.php                     ← Homepage
├── singular.php                       ← Single post / page (generic)
├── 404.php                            ← Custom 404
│
├── woocommerce/
│   ├── archive-product.php            ← Shop / category pages
│   ├── single-product.php             ← Individual product page
│   ├── content-product.php            ← Product card in loops
│   ├── content-single-product.php     ← Single product content
│   ├── global/
│   │   └── breadcrumb.php             ← Override WC breadcrumbs
│   └── loop/
│       └── orderby.php                ← Custom sort UI
│
├── template-parts/
│   ├── font-tester.php                ← ⭐ Font tester component
│   ├── font-grid.php                  ← Grid of products (asymmetric)
│   ├── font-card.php                  ← Single product card (no container)
│   ├── category-links.php             ← Category text row
│   ├── skip-link.php                  ← Skip to main content
│   └── latest-posts.php               ← Blog preview list
│
├── assets/
│   ├── css/
│   │   ├── main.css                   ← Global styles (design system + components)
│   │   ├── woocommerce.css            ← WC override styles
│   │   └── font-tester.css            ← Font tester specific
│   │
│   ├── js/
│   │   ├── main.js                    ← Global JS: nav, skip link, etc.
│   │   └── font-tester.js             ← ⭐ Font tester logic
│   │
│   ├── fonts/
│   │   ├── rillatype-heading.woff2    ← UI font for headings (lightweight)
│   │   └── specimens/                 ← Subset specimen fonts for tester
│   │       ├── mango-letters-regular.woff2
│   │       ├── mango-letters-bold.woff2
│   │       └── (one per font, per weight)
│   │
│   └── images/
│       ├── favicon.svg
│       ├── apple-touch-icon.png
│       └── og-default.jpg
│
├── inc/
│   ├── acf-setup.php                  ← ACF field definitions (programmatic)
│   ├── performance.php                ← Disable emoji, embeds, etc.
│   ├── woocommerce-hooks.php          ← WC-specific PHP hooks
│   └── schema-functions.php           ← Helper untuk JSON-LD output
│
└── page-templates/                    ← Optional custom page templates
    ├── template-llms-txt.php          ← /llms.txt output
    └── template-full-width.php        ← Full-width tanpa sidebar
```

---

## 17. Checkout & Ecommerce Flow

### Flow

1. User lihat font → klik product
2. Preview static image + coba di font tester
3. Klik **Add to Cart** → WooCommerce AJAX (atau redirect ke cart)
4. Cart page → review, apply coupon (kalau ada) → **Proceed to Checkout**
5. Checkout → input billing → pilih payment → **Place Order**
6. WooCommerce auto-generate download links
7. User dapet email dengan link download

### WooCommerce Settings yang Harus Di-Update

```
WooCommerce > Settings:

  Products:
    ✅ Enable reviews: OFF (kecuali kamu siap moderasi)
    ✅ Product ratings: OFF (kalau belum ada)
    ✅ Downloadable products: Grant access after payment
  
  Accounts & Privacy:
    ✅ Allow guest checkout: ON                    ← WAJIB. Jangan paksa register.
    ✅ Account creation during checkout: optional
  
  Emails:
    ✅ Processing order: ON (ke customer)
    ✅ Completed order: ON (ke customer — include download links)
    ✅ New order: ON (ke admin — to: email kamu)
```

### Product Setup Checklist (per font)

- [ ] Title: nama font (tanpa prefix RT/Demo)
- [ ] Price: USD. Regular price field. NO sale price (kecuali emang diskon).
- [ ] Categories: primary + secondary
- [ ] Tags: 5-10 deskriptif tags
- [ ] Product Image: 1200px specimen preview (WebP)
- [ ] Gallery: 3-5 in-use images
- [ ] Description: marketing copy
- [ ] Short Description: 1-2 sentences
- [ ] **Downloadable**: ✅
- [ ] Files: OTF, TTF, WOFF2, License.txt
- [ ] Download limit: unlimited / atau 5 kali
- [ ] Download expiry: never / atau 30 hari
- [ ] **ACF Font Specimen Data**: specimen WOFF2 URLs, weights, glyph count

---

## Lampiran: Tools

### Development

| Tool | Use |
|------|-----|
| **Local by Flywheel** | Local WP dev environment |
| **WP CLI** | Command-line WP management |
| **VS Code** + PHP Intelephense | Code editor |
| **Git** | Version control theme |

### Font Specimen Tools

| Tool | Use |
|------|-----|
| **fontTools (pyftsubset)** | Subset font ke WOFF2 untuk tester |
| **woff2_compress** (Google) | Convert TTF/OTF ke WOFF2 |

### Verification

| Tool | Check |
|------|-------|
| **Lighthouse** | Performance, a11y, SEO, best practices |
| **axe DevTools** | Accessibility |
| **WAVE** | Accessibility visual |
| **PageSpeed Insights** | Core Web Vitals from real data |
| **Schema Validator** | search.google.com/structured-data |
| **Pinterest Rich Pins Validator** | developers.pinterest.com/tools/url-debugger |
| **Open Graph Debugger** | opengraph.dev |
| **GTmetrix / WebPageTest** | Detailed performance |

---

## Referensi Inspirasi Desain

Font foundry yang desainnya "bukan template" (cari inspo, jangan copy):

| Site | Pelajari |
|------|----------|
| **displaay.net** | Clean, typography-driven hero. Whitespace intentional. |
| **pangrampangram.com** | Bold teks, layout asimetris, color blocking. |
| **ohnotype.co** | Playful personality, unique product page layouts. |
| **futurefonts.xyz** | Community/marketplace feel. Filtering UI. |
| **grillitype.com** | Swiss precision. Type tester terbaik. |
| **abcdinamo.com** | Experimental, bold, unapologetic. Type tester iconic. |
| **cotypefoundry.com** | Warm, approachable. Good grid system tanpa terlihat template. |

---

> **Untuk model AI yang ngerjain:**
> 
> 1. Ini blueprint. Jalan urut dari Phase 1.
> 2. Setiap phase harus **selesai + berfungsi** sebelum lanjut.
> 3. **FONT TESTER itu prioritas** — itu fitur paling penting di website ini.
> 4. Kalau ragu, pilih opsi yang: **paling ringan, paling minimal, paling custom (bukan library/framework generic)**.
> 5. WooCommerce dibiarin jalan — fokus ke **theme custom** di atasnya.
> 6. JANGAN nambah fitur yang nggak diminta di plan ini.
> 7. PENTING: semua perubahan dilakukan di staging dulu. Theme aktif sekarang tetep jalan. Jangan overwrite.
