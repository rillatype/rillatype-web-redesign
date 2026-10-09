---
name: Rillatype
description: Foundry editorial R05E dan prototype produk R06 dengan Manrope lokal, aksen biru, dan artwork produk asli.
colors:
  accent: "#2454e6"
  accent-hover: "#1c42b5"
  paper: "#fff"
  ink: "#171717"
  muted: "#606060"
  line: "#d8dce3"
  wash: "#f3f5f8"
  transparent: "transparent"
  base-line: "#d9d9d9"
  base-wash: "#f4f4f4"
  base-ink-hover: "#333"
typography:
  body:
    fontFamily: '"Manrope", sans-serif'
    fontSize: "16px"
    fontWeight: 400
    lineHeight: 1.55
  display:
    fontSize: "clamp(56px, 6.8vw, 96px)"
    fontWeight: 750
    lineHeight: 0.99
    letterSpacing: "-.04em"
  display-mobile:
    fontSize: "clamp(42px, 12vw, 62px)"
    fontWeight: 750
    lineHeight: 0.99
    letterSpacing: "-.04em"
  headline:
    fontSize: "32px"
    fontWeight: 650
    lineHeight: 1.15
    letterSpacing: "-.03em"
  headline-mobile:
    fontSize: "26px"
    fontWeight: 650
    lineHeight: 1.15
    letterSpacing: "-.03em"
  title:
    fontSize: "18px"
    fontWeight: 700
    lineHeight: 1.25
    letterSpacing: "-.015em"
  card-price:
    fontSize: "15px"
    fontWeight: 650
    lineHeight: 1.55
  feature-title:
    fontSize: "clamp(32px, 3.3vw, 46px)"
    fontWeight: 650
    lineHeight: 1.1
    letterSpacing: "-.035em"
  feature-title-mobile:
    fontSize: "34px"
    fontWeight: 650
    lineHeight: 1.1
    letterSpacing: "-.035em"
  product-display:
    fontSize: "clamp(34px, 4vw, 50px)"
    fontWeight: 750
    lineHeight: 1.15
    letterSpacing: "-.035em"
  product-display-mobile:
    fontSize: "36px"
    fontWeight: 750
    lineHeight: 1.15
    letterSpacing: "-.035em"
  brand:
    fontSize: "18px"
    fontWeight: 700
    lineHeight: 1.55
    letterSpacing: "-.02em"
  brand-mobile:
    fontSize: "16px"
    fontWeight: 700
    lineHeight: 1.55
    letterSpacing: "-.02em"
  navigation:
    fontSize: "13px"
    fontWeight: 600
    lineHeight: 1.55
  button:
    fontSize: "13px"
    fontWeight: 650
    lineHeight: 1.55
  search:
    fontSize: "13px"
    fontWeight: 400
    lineHeight: 1.55
  filter:
    fontSize: "13px"
    fontWeight: 400
    lineHeight: 1.55
  label:
    fontSize: "14px"
    fontWeight: 400
    lineHeight: 1.55
  text-link:
    fontSize: "14px"
    fontWeight: 600
    lineHeight: 1.55
  small:
    fontSize: "13px"
    fontWeight: 400
    lineHeight: 1.55
  card-action:
    fontSize: "13px"
    fontWeight: 650
    lineHeight: 1.55
  intro-copy:
    fontSize: "16px"
    fontWeight: 400
    lineHeight: 1.65
  intro-copy-mobile:
    fontSize: "14px"
    fontWeight: 400
    lineHeight: 1.65
  feature-copy:
    fontSize: "18px"
    fontWeight: 400
    lineHeight: 1.55
  feature-copy-narrow:
    fontSize: "16px"
    fontWeight: 400
    lineHeight: 1.55
  feature-price:
    fontSize: "22px"
    fontWeight: 650
    lineHeight: 1.55
  product-price:
    fontSize: "24px"
    fontWeight: 400
    lineHeight: 1.55
  legend:
    fontSize: "15px"
    fontWeight: 600
    lineHeight: 1.55
  license-name:
    fontSize: "14px"
    fontWeight: 600
    lineHeight: 1.55
  license-headline:
    fontSize: "36px"
    fontWeight: 650
    lineHeight: 1.2
    letterSpacing: "-.03em"
  license-headline-mobile:
    fontSize: "28px"
    fontWeight: 650
    lineHeight: 1.2
    letterSpacing: "-.03em"
  footer-wordmark:
    fontSize: "clamp(46px, 6vw, 80px)"
    fontWeight: 750
    lineHeight: 1.1
    letterSpacing: "-.04em"
  footer-wordmark-mobile:
    fontSize: "48px"
    fontWeight: 750
    lineHeight: 1.1
    letterSpacing: "-.04em"
  tester:
    fontFamily: '"Mango Product", sans-serif'
    fontSize: "64px"
    fontWeight: 400
    lineHeight: 1.3
  tester-mobile-css:
    fontFamily: '"Mango Product", sans-serif'
    fontSize: "44px"
    fontWeight: 400
    lineHeight: 1.3
  base-body:
    fontFamily: '-apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif'
    fontSize: "16px"
    fontWeight: 400
    lineHeight: 1.55
  base-display:
    fontSize: "clamp(36px, 4vw, 56px)"
    fontWeight: 600
    lineHeight: 1.15
    letterSpacing: "-.035em"
  base-headline:
    fontSize: "clamp(26px, 3vw, 36px)"
    fontWeight: 600
    lineHeight: 1.15
    letterSpacing: "-.025em"
  base-heading-small:
    fontSize: "19px"
    fontWeight: 600
    lineHeight: 1.15
  base-title:
    fontSize: "17px"
    fontWeight: 600
    lineHeight: 1.15
  base-button:
    fontSize: "14px"
    fontWeight: 600
    lineHeight: 1.55
rounded:
  control: "4px"
  card: "8px"
  imagery: "0"
  base-control: "6px"
spacing:
  compact: "8px"
  thumbnail-gap: "10px"
  tight: "12px"
  metadata: "14px"
  card-padding: "18px"
  feature-padding: "34px"
  row-gap: "16px"
  mobile-gutter: "20px"
  stacked-gap: "22px"
  tablet-gutter: "24px"
  collection-gutter: "26px"
  detail-gap-mobile: "28px"
  narrow-gap: "30px"
  header-gap: "32px"
  panel-padding: "38px"
  desktop-gutter: "40px"
  intro-gap: "50px"
  detail-gap: "52px"
  section-top: "60px"
  license-margin: "74px"
components:
  button-primary:
    backgroundColor: "{colors.accent}"
    textColor: "{colors.paper}"
    typography: "{typography.button}"
    rounded: "{rounded.control}"
    padding: "10px 19px"
  button-primary-hover:
    backgroundColor: "{colors.accent-hover}"
  button-secondary:
    backgroundColor: "{colors.paper}"
    textColor: "{colors.ink}"
    typography: "{typography.button}"
    rounded: "{rounded.control}"
    padding: "10px 19px"
  button-secondary-hover:
    backgroundColor: "{colors.wash}"
  search-input:
    backgroundColor: "{colors.wash}"
    textColor: "{colors.ink}"
    typography: "{typography.search}"
    rounded: "{rounded.control}"
    padding: "10px 12px"
  filter:
    backgroundColor: "{colors.paper}"
    textColor: "{colors.ink}"
    typography: "{typography.filter}"
    rounded: "{rounded.control}"
    padding: "10px 18px"
  filter-selected:
    backgroundColor: "{colors.ink}"
    textColor: "{colors.paper}"
  product-card:
    backgroundColor: "{colors.paper}"
    textColor: "{colors.ink}"
    typography: "{typography.title}"
    rounded: "{rounded.card}"
  card-metadata:
    padding: "18px 18px 16px"
  card-price:
    typography: "{typography.card-price}"
  card-action:
    textColor: "{colors.ink}"
    typography: "{typography.card-action}"
    rounded: "{rounded.control}"
    padding: "10px 12px"
  product-image:
    backgroundColor: "{colors.wash}"
    rounded: "{rounded.imagery}"
  feature-panel:
    backgroundColor: "{colors.paper}"
    textColor: "{colors.ink}"
    typography: "{typography.feature-title}"
    rounded: "{rounded.card}"
    padding: "34px"
  feature-price:
    typography: "{typography.feature-price}"
  navigation:
    textColor: "{colors.ink}"
    typography: "{typography.navigation}"
  license-option:
    textColor: "{colors.ink}"
    rounded: "{rounded.control}"
    padding: "14px"
  license-option-selected:
    backgroundColor: "{colors.wash}"
  tester-input:
    backgroundColor: "{colors.paper}"
    textColor: "{colors.ink}"
    rounded: "{rounded.control}"
    padding: "12px 14px"
  tester-output:
    textColor: "{colors.ink}"
    typography: "{typography.tester}"
    padding: "36px 0"
  base-button-primary:
    backgroundColor: "{colors.ink}"
    textColor: "{colors.paper}"
    typography: "{typography.base-button}"
    rounded: "{rounded.base-control}"
    padding: "10px 19px"
  base-button-primary-hover:
    backgroundColor: "{colors.base-ink-hover}"
---

# Design System: Rillatype

## Overview

**Creative North Star: "Foundry editorial"**

User menolak keseluruhan UI sebelumnya dan meminta pengganti. R05D memakai Manrope lokal, satu aksen biru, judul tegas, dan artwork produk asli. R05E menerapkan keputusan card yang disetujui melalui grilling: bidang putih, border tipis, radius 8px, dan satu link untuk seluruh card. Panel Bawden memisahkan pilihan unggulan dari tujuh kartu koleksi. R06 menerapkan bahasa visual yang sama pada detail produk, gallery, pilihan lisensi contoh, tester Mango, dan bagian Font information.

Dokumen ini merekam `static/redesign/index.html`, `product.html`, `style.css`, `editorial.css`, `preview.js`, dan `product-preview.js`. Halaman aktif memuat base stylesheet sebelum override editorial. Sistem component lab berbasis system sans tetap terpisah. Dokumentasi merekam implementasi, bukan persetujuan user, hasil review, verdict ship, atau hasil pengukuran performa.

**Key Characteristics:**
- Manrope untuk UI, headline, metadata, dan footer.
- Biru untuk tindakan utama, fokus, bagian headline, dan tanda pilihan produk.
- Artwork mempertahankan warna asli dan radius gambar 0; card homepage memotong artwork dalam bingkai radius 8px.
- Pencarian header sticky tetap tersedia saat menu mobile tertutup.
- Gallery dan lisensi memakai tombol serta radio native.
- Mango Product hanya dimuat dinamis untuk tester produk Mango; tujuh produk lain menyatakan specimen tidak tersedia.

## Colors

### Primary
- **Collection blue** (`accent`) memberi warna pada tombol utama, kata perspective., hover card action, fokus keyboard, selection teks, radio, slider, dan border thumbnail aktif.
- **Collection blue hover** (`accent-hover`) mengganti background serta border tombol utama saat hover.

### Neutral
- **Paper** (`paper`) adalah halaman, header, tombol sekunder, dan semua card homepage termasuk Bawden.
- **Ink** (`ink`) adalah teks utama, border tombol sekunder, dan filter aktif dengan teks Paper.
- **Muted** (`muted`) membedakan kategori, copy pendamping, placeholder, serta catatan demo.
- **Line** (`line`) memisahkan header, bar filter, lisensi, tester, dan catatan preview serta membingkai card homepage dan tindakan koleksi.
- **Wash** (`wash`) adalah field pencarian, hover tindakan koleksi, freebies, banner demo, dan opsi lisensi terpilih.
- **Transparent** (`transparent`) dipakai pada border pencarian, filter default, dan thumbnail tidak aktif.
- Token `base-line`, `base-wash`, dan `base-ink-hover` mencatat base component lab saja. Override editorial tidak memakai palette base tersebut.

Tonal ramp di sidecar adalah metadata panel sintetis. Ramp tidak menambah warna runtime.

**The One Accent Rule.** Gunakan biru sebagai satu aksen UI; pertahankan warna asli artwork dan filter aktif Ink/Paper.

## Typography

Manrope adalah font body dan seluruh informasi toko. Role editorial tanpa `fontFamily` mewarisi `body`. Font variable normal mendukung weight 200..800, termasuk 650 dan 750. Kedua halaman melakukan preload `manrope.ttf` dengan `crossorigin`; `@font-face` memakai `font-display: swap` dan fallback sans-serif.

File lokal `static/redesign/manrope.ttf` berasal dari repo resmi Google Fonts, `https://raw.githubusercontent.com/google/fonts/main/ofl/manrope/Manrope%5Bwght%5D.ttf`. Lisensi asli tersimpan di `static/redesign/OFL-Manrope.txt`, dari `https://raw.githubusercontent.com/google/fonts/main/ofl/manrope/OFL.txt`. Runtime tidak memuat stylesheet font pihak ketiga.

### Hierarchy
- `display` dan `display-mobile` mencatat H1 homepage. Mobile berlaku pada max-width 640px; tidak ada role tablet terpisah.
- `headline` dan `headline-mobile` mencatat H2 koleksi, freebies, dan tester. `license-headline` memakai ukuran serta line-height berbeda.
- `feature-title` mencatat judul Bawden di panel unggulan. Mobile memakai `feature-title-mobile` yang tetap lebih besar daripada H2 biasa.
- `product-display` mencatat H1 detail produk, termasuk weight 750 yang diwarisi dari H1 editorial. Mobile detail memakai 36px, bukan clamp H1 homepage.
- `title` mencatat nama kartu koleksi 18px, weight 700, line-height 1.25 pada semua lebar. `card-price` memakai 15px/650, tabular numerals, dan nowrap. Kategori tetap `small` 13px dengan warna Muted; `label` tetap untuk field.
- `feature-price` memakai 22px/650 dekat judul Bawden; `product-price` tetap mencatat harga summary detail 24px/400. `card-action` memakai 13px/650.
- `button`, `navigation`, `search`, dan `filter` memakai 13px dengan weight sesuai fungsi. Label textarea/range 14px; legend 15px; nama lisensi 14px weight 600.
- `intro-copy` memakai line-height 1.65; copy panel memakai 1.55 dan turun menjadi 16px pada max-width 1000px.
- `footer-wordmark` tetap Manrope, weight 750. Mobile memakai 48px.

### Product specimen

`product-preview.js` membuat `FontFace('Mango Product', ...)` hanya untuk route Mango. Sumbernya `static/previews/mango-letter.otf`. Tidak ada preload Mango di homepage atau pemakaian Mango pada headline, lisensi, maupun footer. Kontrol dan output baru terlihat setelah `face.load()` berhasil.

Tester mulai pada 64px dengan line-height 1.3. CSS mobile menyediakan 44px, tetapi `updateSample()` menetapkan ukuran inline dari slider. Setelah font berhasil dimuat, nilai slider awal 64px mengalahkan CSS mobile. Range aktual adalah 24..120px. Token `tester-mobile-css` mencatat deklarasi CSS, bukan ukuran runtime awal mobile.

**The Product Font Rule.** Tampilkan font produk hanya setelah specimen berhasil dimuat; jangan tampilkan font UI sebagai specimen pengganti.

### Shared base

Token `base-*` mencatat sistem `style.css` tanpa override editorial. Component lab memakai system sans, H1 clamp 36..56px, H2 clamp 26..36px, H3 19px, nama kartu 17px, dan tombol 14px weight 600. Radius base 6px tidak menjadi radius halaman editorial. Role editorial dan base tidak saling menggantikan.

## Layout

Wrapper maksimum 1240px memakai gutter 40px per sisi. Base breakpoint max-width 900px mengubah gutter menjadi 24px. Max-width 640px memakai gutter 20px. Breakpoint editorial 1000px mengubah komposisi tanpa mengubah gutter.

Header sticky memakai top 0, z-index 2, Paper, dan border bawah Line 1px. Desktop homepage memakai grid `auto auto minmax(260px, 350px)`, gap 32px, dan min-height 86px. Urutannya logo, navigasi, lalu pencarian. Logo tampil 50px persegi meskipun atribut HTML 56px. Label Find a font disembunyikan secara visual, tetapi tetap memberi nama aksesibel pada search.

Pada max-width 1000px, header homepage memakai dua kolom `auto 1fr`, gap 12px/28px, dan padding vertikal 14px. Search berada pada baris pertama di kanan logo; navigasi berada pada baris penuh berikutnya. Pada max-width 640px, logo menjadi 44px, Menu berada di kanan, search memakai baris kedua penuh, dan navigasi memakai baris ketiga. Padding atas 10px dan bawah 14px; gap 10px. Header sempit dapat lebih tinggi daripada 86px. Angka itu minimum desktop, bukan tinggi tetap.

Header detail produk tidak memuat search. Desktop dan tablet memakai flex. Mobile memakai grid dua kolom untuk logo/Menu dan baris kedua untuk navigasi. Menu tertutup secara default; navigasi terbuka menambah tinggi header.

Target produk, Fonts, Licenses, Freebies, catatan preview, dan `#license-form` memakai scroll-margin-top 110px. Pada max-width 1000px, termasuk mobile, offset menjadi 160px. Nilai ini adalah offset CSS aktual, bukan jaminan untuk setiap tinggi menu terbuka.

Homepage membuka dengan grid 1.7fr:1fr, gap 50px, padding 60px/0/40px. Gap menjadi 30px pada max-width 1000px. Mobile memakai satu kolom, gap 22px, dan padding vertikal 30px. Filter/count langsung mengikuti intro, tetap di luar section koleksi yang dapat disembunyikan.

Bawden memakai card Paper dua kolom 1.6fr:1fr tanpa gap di dalam satu anchor, artwork di kiri, informasi flex di kanan dengan padding 34px. Harga berada dekat judul dan kategori dengan margin atas 18px. Catatan preview mengikuti deskripsi. Panel tindakan memakai margin-top auto dan padding atas 26px; CTA biru memenuhi lebar panel informasi dengan min-height 46px. Pada max-width 1000px, kolom menjadi 1.35fr:1fr, padding informasi 26px, dan padding atas tindakan 20px. Mobile menumpuk artwork dan informasi dengan padding 24px serta padding atas tindakan 22px. Card mulai 32px di bawah filter atau 24px mobile.

Tujuh kartu koleksi memakai tiga kolom dengan gap 40px/26px. Grid tetap tiga kolom pada tablet; mobile memakai satu kolom dengan gap 30px. Section mulai dengan padding atas 60px atau 36px mobile, bawah 24px. Anchor memakai flex column dan height 100%. Metadata memakai padding 18px 18px 16px, gap 12px, nama dan harga satu baris, serta kategori di bawah nama dengan margin atas 5px. Harga memiliki padding atas 2px. Tindakan memakai margin auto 18px 18px agar sejajar di bawah card, padding 10px 12px, dan min-height 44px. Bar heading berjarak 26px dari grid dan menumpuk pada mobile.

Lisensi homepage memakai dua kolom, gap 60px, margin atas 74px, dan padding vertikal 38px. Mobile memakai satu kolom, gap 22px, margin atas 46px, dan padding vertikal 28px. Freebies memakai Wash, dua kolom, gap 50px, padding 36px, dan margin atas 30px. Mobile memakai satu kolom, gap 20px, dan padding 24px. Footer memakai padding vertikal 40px dan menumpuk pada mobile.

Detail produk memakai gallery dan summary dalam grid 1.4fr:1fr, gap 52px. Gap turun menjadi 30px pada max-width 1000px. Mobile memakai satu kolom dengan gap 28px. Thumbnail memakai empat kolom, gap 10px, dan margin atas 12px. Tester memakai margin atas 52px, padding atas 36px, serta border Line. Kontrol tester memakai `1fr 240px`, gap 36px, lalu satu kolom dengan gap 20px mobile. Output memakai min-height 170px, padding vertikal 36px, pre-wrap, dan overflow-wrap anywhere.

Component lab tetap memakai layout base, termasuk header minimum 80px/68px mobile dan grid gap 30px/24px. Detail legacy `.product-detail` bukan grid R06 `.detail-grid`.

## Elevation & Depth

Tidak ada box-shadow, blur header, atau overlay dekoratif. Paper, Wash, whitespace, dan border memisahkan konten. Header sticky memakai z-index 2; skip link memakai z-index 10. Artwork tetap menjadi bagian paling berwarna dari halaman.

## Shapes

Tombol, search, filter, textarea, opsi lisensi, dan tindakan koleksi memakai radius 4px. Semua card homepage termasuk Bawden memakai Paper, border Line 1px, radius `card` 8px, dan overflow hidden. Gambar tetap radius 0; bingkai card memotong sudut luar artwork. Thumbnail, gambar detail produk, dan freebies tetap bersudut siku. Gambar memakai rasio 3:2 dan object-fit cover. Base component lab tetap memakai radius kontrol 6px.

Fokus card memakai `:focus-within` pada parent dengan outline biru 2px dan offset 4px. Outline `:focus-visible` pada anchor langsung dinonaktifkan agar overflow hidden tidak memotong ring fokus internal.

Tombol sekunder memakai border Ink 1px; tombol utama memakai border biru 1px. Search header memakai border transparan 1px. Tidak ada perubahan border search khusus saat fokus; fokus keyboard memakai outline biru 2px dengan offset 4px. Thumbnail memakai border 2px transparan yang menjadi biru saat aktif. Opsi lisensi memakai border Line 1px, berubah biru saat radio terpilih.

Tombol, filter, search header, dan link navigasi header memiliki min-height 44px. Thumbnail memakai ukuran grid gambar; stylesheet tidak menetapkan min-height sentuh terpisah.

## Components

### Buttons

Tombol utama memakai Collection blue/Paper, padding 10px/19px, weight 650, dan hover Collection blue hover. Tombol sekunder memakai Paper/Ink dan hover Wash. Disabled memakai opacity .55 serta cursor not-allowed. Preview selection memenuhi lebar summary dan tetap disabled sebelum pilihan lisensi valid.

### Inputs / Fields

Search memakai input native type search dengan placeholder Search the collection. Label aksesibelnya Find a font. Query langsung memfilter nama, kategori `data-style`, dan deskripsi style, case-insensitive. Submit menggulir ke produk pertama yang terlihat; jika kosong, ke bar Fonts. Show all fonts menghapus query dan kategori, lalu memfokuskan search.

Textarea tester berlabel Your sample text, maxlength 300, min-height 90px, dan resize vertical. Range berlabel Size, menampilkan nilai px, dan mengubah ukuran output tanpa request baru. Input kosong menghasilkan Type something to preview this font. Output memakai `textContent`, sehingga markup yang diketik tetap teks biasa.

### Chips

All fonts, Display, Serif, dan Script memakai tombol native dengan `aria-pressed`, radius kontrol, serta gap 8px. Padding 10px/18px turun menjadi horizontal 12px mobile. Filter aktif memakai Ink/Paper. Query dan kategori bekerja bersama. Count memakai polite live region dan tetap terlihat ketika panel Bawden, koleksi, atau seluruh hasil disembunyikan.

### Cards / Containers

Homepage memuat Bawden sebagai satu panel unggulan dan tujuh kartu koleksi. Bawden memakai fetchpriority high; tujuh cover koleksi memakai lazy loading. Cover memiliki atribut dimensi 1200x800. Kartu dan tindakan View font menuju detail produk lokal, bukan catatan preview.

Setiap card memakai satu anchor native luar yang mencakup artwork, metadata, harga, dan tindakan visual. View font adalah span, bukan link kedua atau button bersarang. Klik panel informasi Bawden atau metadata Mango dan aktivasi Enter membuka detail masing-masing. Bawden memakai harga 22px/650 dekat nama serta CTA biru selebar panel di bawah; koleksi memakai nama 18px/700, harga 15px/650, kategori tenang 13px, dan tindakan outlined radius 4px yang sejajar otomatis di bawah. Label Demo tetap dipertahankan sesuai permintaan eksplisit user yang sudah memahami data contoh. Persetujuan ini berlaku pada perubahan card R05E, bukan persetujuan render keseluruhan.

Logo berasal dari `logo.png`. Cover berasal dari `static/previews/`: `bawden-1.jpg`, `mango-1.jpg`, `baldock-1.jpg`, `daisy-hotline-1.jpg`, `crimson-queen-1.jpg`, `mordial-1.jpg`, `moyshire-1.jpg`, dan `radiant-summertime-1.jpg`. Gallery Mango menambah `mango-2.jpg`, `mango-3.jpg`, dan `mango-4.jpg`, semuanya file existing. `static/redesign/ASSETS.md` mencatat sumber. R05D/R06 tidak menambah raster hasil generasi atau foto baru. OFL Manrope tidak menjadi klaim hak distribusi artwork atau specimen Mango.

### Navigation

Homepage memiliki Fonts, Freebies, dan Licenses; detail produk valid memiliki All fonts, License preview, dan Contact. Pada slug tidak dikenal, `#nav-license` berubah menjadi Licenses dan menuju `index.html#licenses`, bukan form produk yang tersembunyi. Footer memakai link koleksi dan email contact yang tersedia. Menu mengubah `aria-expanded` serta `is-open`. Klik link menutup menu. Escape menutup menu dan mengembalikan fokus ke Menu. Skip to content tampil saat fokus. Search homepage berada di luar navigasi yang dapat disembunyikan.

### Product routes and gallery

Delapan route aktual adalah `product.html?font=bawden`, `product.html?font=mango`, `product.html?font=baldock`, `product.html?font=daisy`, `product.html?font=crimson`, `product.html?font=mordial`, `product.html?font=moyshire`, dan `product.html?font=radiant`. `product-preview.js` memakai `Map` sebagai daftar produk yang diizinkan. Parameter tanpa nilai atau tanpa parameter memakai Bawden. Slug lain, termasuk `__proto__`, menampilkan Font not found; konten produk tetap tersembunyi. Nilai URL tidak membentuk path aset bebas.

Mango memiliki empat gambar dan tombol native Preview 1..4 dengan `aria-pressed`. Klik mengganti gambar utama dan alt sesuai nomor preview. Tujuh produk lain memiliki satu gambar tanpa tombol thumbnail. Snippet sidecar adalah contoh render statis; perubahan gallery, filter, menu, dan tester tetap dimiliki script halaman.

### License selection and tester states

Standard License dan Extended License adalah nama contoh. Radio native memakai nama grup `license`; pilihan standard bersifat required. Extended menggandakan harga demo. Perubahan pilihan memperbarui harga summary dan menghapus status lama. Submit mencegah navigasi dan hanya menampilkan konfirmasi pilihan di polite live region. Tidak ada cart, pesanan, atau pembayaran dari form ini.

Mango memiliki state loading, loaded, failure, dan retry. Loading menyembunyikan retry; loaded memperlihatkan kontrol serta output. Failure menyembunyikan kontrol serta output, memberi pesan, dan memperlihatkan Retry font. Tujuh produk lain menampilkan pesan specimen tidak tersedia, dengan gallery tetap dapat dilihat. UI tidak membuat style atau format font yang datanya belum tersedia.

### Font information

Bagian Font information mengikuti tester pada detail produk valid. Mango menyatakan preview memuat satu specimen OTF, bukan daftar file yang dibeli. Tujuh produk lain menyatakan gambar produk tersedia tanpa specimen. Format file final, weight yang tersedia, dan cakupan glyph menunggu data toko. Link Contact Rillatype menuju email bantuan lisensi. Bagian ini memakai H2 dan pola `.details` yang sudah ada; tidak menambah token visual. Slug tidak dikenal tetap menyembunyikan seluruh konten produk, termasuk bagian ini.

### Motion and evidence

CSS hanya mengaktifkan feedback pada `prefers-reduced-motion: no-preference`. Tombol/filter memakai 140ms dan easing `cubic-bezier(.2, .8, .2, 1)`. Active bergeser 1px. Gambar kartu memakai 180ms dan hover scale 1.025; perangkat hover none menonaktifkan transform gambar. Tindakan koleksi mentransisikan border, background, dan warna selama 140ms. Tidak ada siklus sample homepage, animasi intro tertunda, atau library animasi tambahan.

Agent utama menjalankan `scripts/check-redesign-preview.py` dan memperoleh PASS untuk R05D/R06, termasuk menu mobile pada slug tidak dikenal yang menuju Licenses homepage. Cakupan meliputi pencarian/filter/count, layout dan sticky search, delapan route produk, gallery Mango, pilihan lisensi demo, tester Mango nyata, unknown route, failure/retry font, reduced motion, fallback Manrope, dan error browser. Agent utama juga memperbarui screenshot. Tugas dokumentasi memeriksa konsistensi source dan dokumen, bukan menjalankan browser ulang. Cakupan skrip tidak membuktikan semua kombinasi produk, viewport, atau alur WooCommerce.

Log R05E di `PROGRESS.md` mencatat PASS yang dijalankan agent utama, bukan user. Pemeriksaan meliputi klik panel Bawden, aktivasi Enter, klik metadata Mango, semua route, pencarian/filter, gallery, lisensi demo, tester, serta regresi yang dicakup skrip. Tugas dokumentasi ini mengatribusikan hasil tersebut tanpa menjalankan browser atau meminta persetujuan render.

Pemeriksaan tugas dokumentasi dibatasi pada JSON, YAML, schema lokal, referensi token, metadata, narrative parity, serta konsistensi dengan kode. CLI resmi belum mendukung validasi schema ini; validasi lokal tidak boleh disebut validasi resmi. Harga, kategori, nama lisensi, dan pilihan unggulan tetap contoh. Freebies menunggu integrasi WordPress. Dokumen ini tidak menetapkan hasil review, persetujuan user, verdict ship, performa, atau kesiapan transaksi.

## Do's and Don'ts

### Do:
- Do gunakan Manrope lokal untuk UI dan headline, dengan biru sebagai satu aksen UI.
- Do pertahankan logo serta warna asli artwork produk dan radius gambar 0 di dalam bingkai card homepage 8px.
- Do gunakan radius kontrol 4px dan pisahkan token component lab dari override editorial.
- Do pertahankan search homepage di header sticky, di luar menu mobile, dengan label aksesibel.
- Do pertahankan count di luar koleksi tersembunyi dan offset anchor untuk license-form.
- Do gunakan tombol gallery, radio lisensi, textarea, range, fokus keyboard, dan reduced motion native.
- Do tampilkan Mango Product hanya pada tester Mango yang berhasil dimuat dan jelaskan specimen lain tidak tersedia.
- Do pertahankan label Demo sesuai permintaan eksplisit user dan atribusikan PASS perilaku kepada agent utama.

### Don't:
- Don't kembali ke UI yang ditolak atau memakai Mango untuk headline, kontrol, lisensi, dan footer.
- Don't ubah artwork menjadi palette UI atau gunakan filter aktif biru ketika kode memakai Ink/Paper.
- Don't samakan CSS tester mobile 44px dengan ukuran runtime awal setelah slider menetapkan 64px.
- Don't bentuk route atau path aset dari slug di luar Map produk.
- Don't tampilkan fallback Manrope sebagai font produk ketika specimen gagal dimuat.
- Don't menyebut Preview selection sebagai add-to-cart, pesanan, atau pembayaran.
- Don't tambahkan raster generatif, foto baru, atau klaim hak aset dari lisensi Manrope.
- Don't artikan dokumentasi atau PASS perilaku sebagai persetujuan user, hasil review, verdict ship, atau bukti performa.
