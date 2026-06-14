# Rillatype Web Redesign — Status & Handoff

> **Repo**: https://github.com/rillatype/rillatype-web-redesign
> **Direktori**: `D:\Hermes Project\Web Redesign Rillatype\`

---

## ✅ Yang Selesai Dikerjakan

### 1. Master Planning
- [x] `PLAN.md` — Blueprint lengkap (55KB): filosofi, tech stack, SEO checklist, 7 phase implementasi
- [x] `PROMPT.md` — Prompt siap pakai untuk model AI lain

### 2. Static Design Prototypes
- [x] **`static/index.html`** (23KB) — Homepage v2: bright, warm, Notion+Figma taste, 1200×800 landscape previews
- [x] **`static/product.html`** (24KB) — Product page v2: font tester interaktif, 1200×800 preview, FAQ, specs
- [x] `static/index-playful.html` (40KB) — Homepage v1 (playful, timeline progress, different layout)
- [x] `static/product-playful.html` (60KB) — Product page v1 (license picker, font pairing, collapsible glyph grid)
- [x] `static/previews/` — 15+ font preview images + 1 specimen OTF

### 3. WordPress Theme — Framework (40+ files)
- [x] **`wp-content/themes/rillatype-v2/`** — Struktur theme WordPress sudah jadi:

| File | Status | Notes |
|------|--------|-------|
| `style.css` | ✅ | Theme header + identity |
| `functions.php` | ✅ | Theme setup, enqueue, WC hooks |
| `header.php` | ✅ | Head, nav, skip link |
| `footer.php` | ✅ | Footer template |
| `index.php` | ✅ | Fallback template |
| `front-page.php` | ✅ | Homepage template |
| `singular.php` | ✅ | Single post/page |
| `404.php` | ✅ | Custom 404 |
| `woocommerce/` | ✅ | 6 WC template overrides |
| `template-parts/` | ✅ | 6 template parts (termasuk font-tester.php) |
| `assets/` | ✅ | CSS (5 files), JS (2 files), images |
| `inc/` | ✅ | 4 PHP modules (ACF, performance, WC hooks, schema) |
| `page-templates/` | ✅ | 2 custom templates |

### 4. Font Tester Component
- [x] **`template-parts/font-tester.php`** — PHP template untuk font tester
- [x] **`assets/js/font-tester.js`** — Vanilla JS: slider, style toggle, preset, Intersection Observer
- [x] **`assets/css/font-tester.css`** — Font tester styling

### 5. GitHub
- [x] Git repo initialized + 3 commits
- [x] Remote: `github.com/rillatype/rillatype-web-redesign`
- [x] GitHub CLI authenticated (account: `rillatype`)

---

## ❌ Yang Belum Dikerjakan / Butuh Perbaikan

### Priority High

| # | Item | Detail |
|---|------|--------|
| 1 | **Homepage konten statis** | `front-page.php` masih pake placeholder text — harus diganti dengan real product data dari WooCommerce |
| 2 | **Font tester integration** | Font tester udah ada PHP+JS-nya, tapi **specimen WOFF2 belum digenerate**. Font yang dipake di tester masih fallback serif, bukan real font. Butuh `pyftsubset` buat bikin subset WOFF2 tiap font. |
| 3 | **WooCommerce product loop** | `archive-product.php`, `content-product.php` — masih template dasar. Belum di-styling sesuai desain (1200×800 landscape). |
| 4 | **Single product page** | `content-single-product.php` — struktur dasarnya ada tapi belum integrate font tester dengan ACF fields. |
| 5 | **ACF fields setup** | `inc/acf-setup.php` — definisi field udah ada, tapi perlu diaktifkan + diisi datanya buat tiap produk. |

### Priority Medium

| # | Item | Detail |
|---|------|--------|
| 6 | **Blog template** | `singular.php` handle blog post, tapi belum ada `home.php` untuk blog archive |
| 7 | **Category pages** | `archive-product.php` handle ini, tapi styling masih vanilla |
| 8 | **Specimen WOFF2 generation** | Butuh subset font untuk semua products. Script: `pyftsubset font.otf --flavor=woff2 --text="A-Za-z0-9..."` |
| 9 | **SEO metadata** | SEOPress settings: meta descriptions, Open Graph, schema — belum di-set per page |
| 10 | **Performance optimization** | WP Rocket belum dikonfigurasi. Imagify belum dipasang. |

### Priority Low

| # | Item | Detail |
|---|------|--------|
| 11 | **llms.txt** | Template `page-templates/template-llms-txt.php` udah ada tapi konten masih placeholder |
| 12 | **Dark mode** | Belum implement. CSS variables udah siap tapi media query masih kosong. |
| 13 | **Search functionality** | Belum ada. WooCommerce search widget atau custom. |
| 14 | **Cookie / privacy** | Belum di-set. Umami harus dimasukkan kode tracking-nya. |
| 15 | **Migration dari theme lama** | Produk, order, customer data masih di theme lama. Belum ada migrasi staging. |

---

## 📁 File Structure Lengkap

```
D:\Hermes Project\Web Redesign Rillatype\
│
├── PLAN.md                          ← Blueprint
├── PROMPT.md                        ← Prompt AI
├── server.js                        ← Local dev server
│
├── static/                          ← Static prototypes (bisa dibuka langsung di browser)
│   ├── index.html                   ← Homepage v2 (BRIGHT — versi terbaru)
│   ├── product.html                 ← Product page v2 (BRIGHT — versi terbaru)
│   ├── index-playful.html           ← Homepage v1 (playful timeline)
│   ├── product-playful.html         ← Product page v1 (playful, license picker)
│   └── previews/                    ← Font preview images + specimen files
│
└── wp-content/
    └── themes/
        └── rillatype-v2/            ← WordPress theme
            ├── style.css
            ├── functions.php
            ├── header.php
            ├── footer.php
            ├── index.php
            ├── front-page.php
            ├── singular.php
            ├── 404.php
            ├── inc/                 ← PHP modules
            ├── template-parts/      ← Template components
            ├── woocommerce/         ← WC template overrides
            ├── page-templates/      ← Custom page templates
            └── assets/              ← CSS, JS, images
```

---

## 🚀 Cara Push ke GitHub

```bash
cd "D:\Hermes Project\Web Redesign Rillatype"

# Stage semua perubahan + file baru
git add -A

# Commit
git commit -m "status: add STATUS.md + latest bright homepage + product page v2"

# Push ke GitHub
git push origin master
```

> **Note**: Remote sudah ter-set ke `https://github.com/rillatype/rillatype-web-redesign.git`
> GitHub CLI login sebagai akun **rillatype** (bukan Bluetypestd).

---

---

## 📋 PROGRESS TRACKER — Wajib Diisi Setiap Selesai Ngerjain

> **📁 File: `PROGRESS.md`** — Ini adalah satu-satunya source of truth untuk progress.
> Setiap kali model AI selesai ngerjain sesuatu, **WAJIB update file ini**.

### Aturan

1. **Selesai suatu task** → update `PROGRESS.md`, commit, push
2. **Ganti ke task lain** → update `PROGRESS.md` dulu
3. **Ada error / blocker** → catat di PROGRESS.md biar AI selanjutnya tau
4. **Formatnya jangan diubah** — append aja ke tabel

### Template entry (copy-paste ke PROGRESS.md)

```markdown
| 2026-06-11 | #1 | ✅ | Generate WOFF2 specimen for Mango Letters | pyftsubset berhasil, file 12KB | 30m |
```

Kolom: `Tanggal | Task # | Status ✅/❌/🔄 | Deskripsi | Notes | Durasi`

Atau kalo prefer ringkas:

```
2026-06-11  #1  ✅  Generate WOFF2 specimen for Mango Letters (12KB) — 30m
```

---

## 📝 Handoff — Untuk AI Selanjutnya

### Prompt yang bisa dipake

```
Kamu melanjutkan project web redesign Rillatype Studio.
Repo: https://github.com/rillatype/rillatype-web-redesign
Lokal: D:\Hermes Project\Web Redesign Rillatype\wp-content\themes\rillatype-v2\

Baca dulu file-file ini sebelum mulai:
1. PLAN.md — blueprint lengkap
2. STATUS.md — status saat ini
3. wp-content/themes/rillatype-v2/functions.php — theme setup

Fokus Priority #1: (isi dengan task yang mau dikerjakan)

Lihat bagian "❌ Yang Belum Dikerjakan" di STATUS.md untuk priority queue.
```

### Priority queue recommendation (urutan kerja):

| Urut | Kerjain | Karena |
|------|---------|--------|
| 1 | **Generate WOFF2 specimen + integrate font tester** | Fitur paling penting. Font tester ga jalan tanpa WOFF2. |
| 2 | **front-page.php → real product data** | Homepage masih placeholder |
| 3 | **Archive-product.php layout** | Grid produk, 1200×800 landscape |
| 4 | **Single-product full styling** | Integrasi font tester + ACF |
| 5 | **ACF fields → isi data tiap produk** | Biar font tester bisa dapet data dari admin |
| 6 | **Performance (WP Rocket, Imagify, WebP)** | Biar cepet di production |
| 7 | **SEO metadata + SEOPress** | Biar terindex Google |
| 8 | **Migration → staging → live** | Launch |

---

## 🎨 Design Reference (Taste)

Desain terbaru (`index.html`, `product.html`) pake taste blend:

| Inspirasi | Elemen yang diadopsi |
|-----------|---------------------|
| **Notion** | Warm neutrals, pure white bg, typography as hierarchy, subtle borders (`1px solid rgba(...)`) |
| **Figma** | Pill buttons (50px), dashed focus outlines, tight letter-spacing, variable-weight typography |
| **Rillatype DNA** | Warm coral accent `#e0553d`, font-first layout, handcrafted feel, Indonesian creative vibe |

**Anti-template rules:**
- ✅ No card containers (no box-shadow, no border-radius on boxes)
- ✅ Asymmetric grids (2fr + 1fr, not 3 equal columns)
- ✅ Typography as hero (no hero images, huge text, tight tracking)
- ✅ Pure white bg (terang), warm accent
- ✅ Labels text-left, not centered
- ✅ Focus outlines dashed (bukan solid)
- ✅ All images 1200×800 (3:2 landscape)
- ❌ NO: 3-column card rows, centered everything, mega menu footer, Gradient hero
