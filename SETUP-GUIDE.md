# 🚀 Rillatype V2 — Panduan Setup Lengkap (Pemula)

Dari awal banget sampe siap dipake. Urut, jangan dilompatin.

---

## 🎯 Sebelum Mulai

**Yang lo butuhin:**
1. Website WordPress udah terinstall (udah punya domain + hosting)
2. File tema udah ada di folder `wp-content/themes/rillatype-v2/`
3. Koneksi internet

**Yang bakal lo lakuin:**
- Aktifin tema
- Install plugin wajib (WooCommerce + ACF)
- Isi data produk font
- Setup halaman

**Estimasi waktu:** 30-60 menit

---

## 📥 Langkah 1 — Aktifin Tema

1. Buka **WordPress Admin** (biasanya `namasite.com/wp-admin`)
2. Login pake username & password
3. Di menu kiri, hover **Appearance** → klik **Themes**
4. Cari tema **Rillatype V2**
5. Arahin mouse ke atasnya → klik **Activate**

> 🟢 Selesai? Tandain checklist di bawah.

---

## 🔌 Langkah 2 — Install Plugin Wajib

Tema ini butuh 2 plugin biar jalan normal.

### A. Install WooCommerce

1. Di menu kiri, klik **Plugins → Add New**
2. Di kolom pencarian, ketik: **WooCommerce**
3. Cari yang bikin **Automattic** (logo burung)
4. Klik **Install Now**
5. Tunggu bentar → abis itu klik **Activate**
6. Nanti muncul wizard setup — **jangan diisi dulu**, tinggalin aja

### B. Install ACF (Advanced Custom Fields)

1. Balik ke **Plugins → Add New**
2. Cari: **Advanced Custom Fields**
3. Yang bikin **WP Engine** — klik **Install Now** → **Activate**

### C. Buat Halaman WooCommerce

1. Buka **WooCommerce → Status → Tools**
2. Di bagian **Create default WooCommerce pages**, klik tombol **Create pages**
3. Nanti otomatis terbuat: Shop, Cart, Checkout, My Account

> 🔍 Cek: Buka **Pages → All Pages** — harusnya ada 4 halaman baru.

---

## 🖼️ Langkah 3 — Upload Logo

1. Buka **Appearance → Customize**
2. Klik **Site Identity**
3. Klik **Select Logo**
4. Upload file logo (PNG, background transparan)
5. Klik **Publish** (di atas)

---

## 📋 Langkah 4 — Setup Menu Navigasi

### Cara 1: Edit menu yang udah ada
1. Buka **Appearance → Menus**
2. Di tab **Edit Menus**, pilih menu yang terdeteksi
3. Pastikan **Primary Menu** tercentang di **Display Location**
4. Klik **Save**

### Cara 2: Bikin menu baru (kalo belum ada)
1. Buka **Appearance → Menus**
2. Klik **Create a new menu**
3. Isi **Menu Name:** "Primary"
4. Klik **Create Menu**
5. Di kolom kiri (**Add menu items**), centang halaman:
   - Home (kalo ada)
   - Shop
   - Freebies (buat dulu kalo belum ada)
   - License
   - Contact
6. Klik **Add to Menu**
7. Di **Menu Settings** (bawah), centang **Primary Menu**
8. Klik **Save Menu**

> Hasilnya di website lo bakal keliatan navbar: Home | Shop | Font | Freebies | License | Contact | Account | 🔍 | 🛒

---

## 🏪 Langkah 5 — Setup Homepage

### 5a — Bikin halaman "Home" (kalo belum ada)

1. Buka **Pages → Add New**
2. **Title:** "Home"
3. **Template** (kolom kanan): pilih **Default Template**
4. Klik **Publish**

### 5b — Set sebagai homepage

1. Buka **Settings → Reading**
2. **Your homepage displays** → pilih **A static page**
3. **Homepage:** pilih **Home**
4. **Posts page:** pilih **Blog** (buat halaman "Blog" kalo belum ada)
5. Klik **Save Changes**

---

## ✏️ Langkah 6 — Buat Produk Pertama

Ini yang paling penting. Font lo dijual sebagai **WooCommerce product**.

### Buat produk baru

1. Buka **Products → Add New**
2. Isi kolom-kolom ini:

| Kolom | Contoh Isi | Keterangan |
|-------|-----------|------------|
| **Title** | Mango Letters | Nama font |
| **Description** | Mango Letters is a... | Paragraf panjang, penjelasan detail |
| **Short Description** | A bold display font... | 1-2 kalimat pendek |

### Upload gambar

1. Di kolom kanan, cari **Product Image** → klik **Set product image**
2. Upload/ Pilih gambar preview font
3. Di bawahnya **Product Gallery** → klik **Add product gallery images**
4. Upload beberapa gambar (slideshow di halaman produk)

### Atur kategori & harga

1. Kolom kanan → **Product Categories**
2. Centang kategori (Display, Script, dll) — atau buat baru klik **Add New Category**
3. Di **Product Data** box (atas editor), isi:
   - **Regular Price:** misal `29`
   - **Sale Price:** (kosongin kalo gak diskon)

### Upload file font + isi ACF

1. **Publish dulu** produknya (biar id tersimpan)
2. Scroll ke bawah — cari box **Font Data**
3. Sekarang isi ACF fields:

| Field | Cara Isi |
|-------|----------|
| Specimen Regular URL | Buka tab baru → **Media → Add New** → upload file .ttf atau .otf → klik file → copy **File URL** → paste ke sini |
| Specimen Bold URL | Upload file bold (kalo ada) → copy URL → paste |
| Formats | `OTF, TTF` |
| Glyphs Count | `350+` |
| Available Weights | `Regular, Bold` |

4. Klik **Update**

### Upload file font (step by step visual)

Bingung? Ini detailnya:

1. Buka tab browser baru
2. Buka `namasite.com/wp-admin`
3. Klik **Media → Add New**
4. **Drag & drop** file font (.ttf atau .otf) dari folder komputer lo
5. Tunggu upload selesai
6. Klik salah satu file yang baru diupload
7. Di kolom kanan, cari **File URL**
8. **COPY** URL-nya (Ctrl+C / klik kanan → copy)
9. Balik ke tab edit produk
10. Paste URL ke field **Specimen Regular URL**
11. Klik **Update**

> 💡 Ulangi langkah 6 buat tiap font yang mau dijual.

---

## 🏠 Langkah 7 — Isi Homepage (AFC)

### Hero

1. Di menu admin, cari **Hero Options** (menu baru)
2. Isi:
   - **Hero Title:** "Where type meets craft."
   - **Hero Text:** "Premium display & text fonts for designers who refuse to compromise."
   - **Hero Image:** upload gambar background hero
   - **Button Label:** "Browse Fonts"
   - **Button URL:** biarin default
3. **Save**

### Homepage Sections

1. Cari menu **Homepage Sections**
2. Atur:
   - **Featured Specimens:** Aktifin → pilih produk-produk favorit lo
   - **Free Stuff:** Aktifin → atur jumlah
   - **Fresh Drops:** Aktifin → atur kolom & baris
   - **Sale:** Aktifin kalo ada diskon
3. **Save**

---

## 💳 Langkah 8 — Setup Pembayaran (Untuk Live)

Lewatin dulu kalo masih testing.

1. Buka **WooCommerce → Settings → Payments**
2. Aktifin **Stripe** atau **PayPal**
3. Ikutin petunjuk dari Stripe/PayPal buat masukin API key
4. **Save**

---

## ✅ Langkah 9 — Tes Situs

Buka website lo di browser. Cek satu-satu:

### Yang harus dicek:
- [ ] Logo keliatan di navbar
- [ ] Navbar: Home, Shop, Font, Freebies, License, Contact, Sign In
- [ ] **Shop page** — produk muncul, hover ada efek zoom + add to cart
- [ ] **Single product** — gambar slider, playground, spesifikasi, FAQ
- [ ] **Cart** — klik add to cart → buka cart page
- [ ] **Checkout** — isi form checkout
- [ ] **My Account / Sign In** — bisa login & register
- [ ] **Homepage** — hero, featured, categories, free, fresh, sale, tester, journal
- [ ] **404 page** — buka url salah (contoh: `namasite.com/asdf`)
- [ ] **Search** — cari sesuatu di navbar
- [ ] **Mobile** — buka dari HP, navbar & grid responsive
- [ ] **Font Tester** — ketik teks, ganti size, weight, alignment
- [ ] **Animasi** — card muncul satu-satu pas discroll

> ❌ Kalo ada yang error/layout berantakan, screenshoot & kirim ke gue.

---

## ❗ Ada Masalah?

### 🔴 White screen / Error

1. Buka file `wp-config.php` (pake File Manager hosting / FTP / cPanel)
2. Cari baris: `define('WP_DEBUG', false);`
3. Ganti jadi: `define('WP_DEBUG', true);`
4. Refresh halaman — bakal keluar pesan error merah
5. Screenshoot & kirim ke gue

### 🟡 Tampilan berantakan

1. Pastiin **WooCommerce** sama **ACF** udah aktif
2. Cek **Permalinks** → Settings → Permalinks → pilih **Post name** → Save
3. Refresh website

### 🟠 Produk gak muncul di shop

1. Buka **Products → All Products**
2. Pastiin statusnya **Published** (bukan Draft)
3. Pastiin ada **Regular Price** yang diisi
4. Pastiin **Catalog visibility** (di kolom kanan) = **Shop and search results**

### 🟣 Font tester gak jalan (tulisan miring/standar)

1. Pastiin **Specimen Regular URL** diisi URL file TTF/OTF yang bener
2. Coba buka URL file font langsung di browser — harusnya download / render di browser

---

## 📁 Struktur File (Buat Tau Aja)

```
rillatype-v2/
├── style.css              # Info tema (nama, versi, dll)
├── functions.php          # Otak tema — enqueue CSS/JS, fitur
├── header.php             # Navbar (atas)
├── footer.php             # Footer (bawah)
├── front-page.php         # Halaman depan (homepage)
├── page.php               # Halaman statis (About, Contact)
├── single.php             # Blog post
├── archive.php            # Blog category/tag
├── search.php             # Hasil pencarian
├── 404.php                # Halaman not found
├── assets/
│   ├── css/
│   │   ├── main.css           # Styling utama
│   │   ├── home.css           # Styling homepage
│   │   ├── woocommerce.css    # Styling shop grid
│   │   ├── woocommerce-forms.css # Cart, checkout, account
│   │   ├── product.css        # Single product page
│   │   ├── font-tester.css    # Font playground
│   │   └── category-links.css # Category pills
│   ├── js/
│   │   ├── main.js            # Animasi, scroll, sticky header
│   │   ├── product.js         # Slider, lightbox, tester
│   │   └── font-tester.js     # Font tester interaktif
├── inc/
│   ├── acf-setup.php          # ACF fields (hero, homepage, font data)
│   ├── woocommerce-hooks.php  # WooCommerce custom hook
│   ├── performance.php        # Optimasi kecepatan
│   └── schema-functions.php   # JSON-LD (SEO)
├── woocommerce/               # Template override WooCommerce
│   ├── archive-product.php
│   ├── single-product.php
│   ├── content-product.php
│   ├── content-single-product.php
│   ├── cart/
│   ├── checkout/
│   └── myaccount/
```

---

## 🆘 Butuh Bantuan?

Kirim pesan ke gue, kasih tau:
- Lagi di langkah ke berapa
- Ada error apa (screenshoot kalo bisa)
- Apa yang udah lo coba

Gue bantu step selanjutnya 👍
