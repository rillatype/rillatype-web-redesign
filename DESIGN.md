---
name: Rillatype
description: Katalog studio monokrom terang untuk revisi preview homepage R05A.
colors:
  paper: "#fff"
  ink: "#171717"
  muted: "#606060"
  line: "#d9d9d9"
  wash: "#f4f4f4"
  ink-hover: "#333"
typography:
  display:
    fontFamily: '-apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif'
    fontSize: "clamp(36px, 4vw, 56px)"
    fontWeight: 600
    lineHeight: 1.15
    letterSpacing: "-.035em"
  headline:
    fontFamily: '-apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif'
    fontSize: "clamp(26px, 3vw, 36px)"
    fontWeight: 600
    lineHeight: 1.15
    letterSpacing: "-.025em"
  title:
    fontSize: "17px"
    fontWeight: 600
    lineHeight: 1.15
  body:
    fontFamily: '-apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif'
    fontSize: "16px"
    lineHeight: 1.55
  label:
    fontSize: "14px"
  small:
    fontSize: "13px"
  heading-small:
    fontSize: "19px"
    fontWeight: 600
    lineHeight: 1.15
  brand:
    fontSize: "25px"
    fontWeight: 700
    letterSpacing: "-.04em"
  brand-mobile:
    fontSize: "23px"
    fontWeight: 700
    letterSpacing: "-.04em"
  product-display:
    fontSize: "clamp(32px, 3vw, 44px)"
    fontWeight: 600
    lineHeight: 1.15
    letterSpacing: "-.035em"
  legend:
    fontSize: "15px"
    fontWeight: 600
  tester:
    fontSize: "64px"
    lineHeight: 1.3
  tester-mobile:
    fontSize: "44px"
    lineHeight: 1.3
  demo:
    fontSize: "12px"
  homepage-display:
    fontSize: "clamp(56px, 6.2vw, 84px)"
    fontWeight: 600
    lineHeight: 1
    letterSpacing: "-.04em"
  homepage-display-tablet:
    fontSize: "clamp(48px, 7vw, 64px)"
    fontWeight: 600
    lineHeight: 1
    letterSpacing: "-.04em"
  homepage-display-mobile:
    fontSize: "60px"
    fontWeight: 600
    lineHeight: 1
    letterSpacing: "-.04em"
  intro-copy:
    fontSize: "18px"
    lineHeight: 1.5
  intro-copy-mobile:
    fontSize: "16px"
    lineHeight: 1.5
  feature-title:
    fontSize: "24px"
    fontWeight: 600
    lineHeight: 1.15
    letterSpacing: "-.02em"
  feature-title-mobile:
    fontSize: "20px"
    fontWeight: 600
    lineHeight: 1.15
    letterSpacing: "-.02em"
  selected-title:
    fontSize: "23px"
    fontWeight: 600
    lineHeight: 1.15
    letterSpacing: "-.02em"
  selected-title-mobile:
    fontSize: "20px"
    fontWeight: 600
    lineHeight: 1.15
    letterSpacing: "-.02em"
rounded:
  control: "6px"
spacing:
  compact: "8px"
  mobile-gutter: "20px"
  grid-gutter: "24px"
  desktop-gutter: "40px"
components:
  button-primary:
    backgroundColor: "{colors.ink}"
    textColor: "{colors.paper}"
    rounded: "{rounded.control}"
    padding: "10px 19px"
  button-primary-hover:
    backgroundColor: "{colors.ink-hover}"
  button-secondary:
    backgroundColor: "{colors.paper}"
    textColor: "{colors.ink}"
    rounded: "{rounded.control}"
    padding: "10px 19px"
  search-input:
    backgroundColor: "{colors.paper}"
    textColor: "{colors.ink}"
    rounded: "{rounded.control}"
    padding: "12px 14px"
  filter:
    backgroundColor: "{colors.paper}"
    textColor: "{colors.ink}"
    rounded: "{rounded.control}"
    padding: "9px 15px"
  filter-selected:
    backgroundColor: "{colors.ink}"
    textColor: "{colors.paper}"
  product-card:
    textColor: "{colors.ink}"
    typography: "{typography.title}"
  feature-card:
    textColor: "{colors.ink}"
    typography: "{typography.feature-title}"
  selected-card:
    textColor: "{colors.ink}"
    typography: "{typography.selected-title}"
  navigation:
    textColor: "{colors.ink}"
    typography: "{typography.label}"
---

# Design System: Rillatype

## Overview

**Creative North Star: "Katalog studio"**

Katalog studio adalah arah yang dipilih user pada 9 Oktober 2026. UI monokrom terang memberi ruang bagi preview font berwarna asli. System sans menjaga kontrol mudah dibaca tanpa unduhan font UI tambahan. Gambar produk membawa karakter, sementara kontrol memakai batas yang jelas dan feedback ringan.

Dokumen ini mencatat revisi homepage R05A berdasarkan `static/redesign/index.html` dan `static/redesign/style.css`. Feedback user meminta tampilan sederhana tetapi lebih berkarakter. Revisi menempatkan preview Mango di pembukaan, memperbesar judul hingga 84px pada desktop, dan membedakan grid Selected fonts dari Latest fonts. Dokumentasi ini tidak menetapkan verdict review, persetujuan user pada R07, atau status production.

Ukuran dasar bersama tetap tercatat untuk component lab. Ukuran produk, legend, tester, dan label demo berasal dari CSS bersama yang sudah tersedia untuk halaman produk mendatang. Keberadaan aturan tersebut bukan bukti bahwa preview R06 atau alur WooCommerce sudah selesai. Stylesheet tema di root bukan sumber token preview ini.

Pencarian, filter, serta menu memakai elemen HTML native dan JavaScript lokal. Konten utama langsung terlihat. Motion ringan memakai CSS dan hanya aktif ketika pengguna tidak meminta reduced motion.

**Key Characteristics:**
- UI monokrom terang; preview produk mempertahankan warna asli.
- System sans untuk teks dan kontrol homepage.
- Grid produk datar dengan preview berasio 3:2.
- Preview Mango di hero, dua kolom Selected fonts, dan tiga kolom Latest fonts pada desktop/tablet.
- Pencarian lokal, filter kategori, dan menu mobile dengan state eksplisit.
- Motion CSS singkat tanpa menyembunyikan konten.

## Colors

Palette UI netral terang tidak mengambil warna dari cover produk.

### Primary
- **Ink** (`ink`): teks utama, tombol utama, filter terpilih, dan fokus keyboard.
- **Ink hover** (`ink-hover`): latar tombol utama saat hover; mencatat literal CSS yang sudah ada.

### Neutral
- **Paper** (`paper`): latar halaman, field, dan kontrol sekunder.
- **Muted** (`muted`): deskripsi, kategori, placeholder, footer, dan catatan preview.
- **Line** (`line`): batas field, header, pemisah, dan informasi lisensi.
- **Wash** (`wash`): hover kontrol dan latar penampung gambar.

Lima warna dasar mengikuti custom properties di stylesheet preview. Token dokumentasi `ink-hover` mencatat nilai lokal `#333`; stylesheet belum memiliki custom property khusus untuk nilai ini. Tonal ramp di sidecar adalah metadata panel sintetis, bukan warna UI tambahan.

**The Original Preview Rule.** Pertahankan warna asli preview produk; jangan menerapkan filter monokrom pada gambar.

## Typography

Homepage memakai stack system sans pada frontmatter untuk display, body, serta kontrol. Ini mencatat implementasi preview yang ada, bukan keputusan font display untuk semua halaman mendatang. Font UI tidak menggantikan font produk pada specimen.

- Display dasar adalah H1 bersama dengan clamp(36px, 4vw, 56px), weight 600, line-height 1.15, dan tracking -.035em. Component lab tetap memakai fondasi ini.
- H1 homepage memakai clamp(56px, 6.2vw, 84px) di desktop, clamp(48px, 7vw, 64px) pada lebar paling banyak 900px, dan 60px pada lebar paling banyak 640px. Weight 600, line-height 1, tracking -.04em. Aturan mobile menggantikan clamp tablet; ukuran mobile bukan 48px.
- Headline H2 bersama memakai clamp(26px, 3vw, 36px), weight 600, line-height 1.15, dan tracking -.025em untuk judul koleksi dan informasi lisensi.
- Heading-small mencatat H3 dasar 19px; title mencatat nama kartu Latest fonts 17px. Keduanya memakai weight 600 dan line-height 1.15.
- Judul H2 Mango memakai 24px, turun ke 20px pada mobile. H3 Selected fonts memakai 23px, turun ke 20px pada mobile. Keduanya memakai weight 600, line-height 1.15, dan tracking -.02em.
- Body memakai 16px dan line-height 1.55. Intro-copy memakai 18px dengan line-height 1.5, turun ke 16px pada mobile. Teks pembukaan dibatasi 42ch; penjelasan lisensi 50ch.
- Brand memakai 25px, turun ke 23px pada mobile, dengan weight 700 dan tracking -.04em. Titik wordmark memakai weight 400.
- Product-display mencatat `.summary h1` dengan clamp(32px, 3vw, 44px), weight 600, line-height 1.15, dan tracking -.035em. Legend memakai 15px dengan weight 600. Tester memakai 64px, turun ke 44px pada mobile, dengan line-height 1.3. Demo-label memakai 12px. Ini aturan CSS bersama yang tersedia, bukan komponen homepage atau klaim implementasi halaman produk.
- Label dan harga memakai 14px. Tombol memakai weight 600; label input memakai weight bawaan.
- Small memakai 13px untuk kategori, jumlah hasil, catatan, dan footer.
- Harga memakai tabular numerals dan tidak membungkus baris.

## Layout

Konten maksimum 1240px dengan gutter desktop 40px per sisi. Pada lebar paling banyak 900px, gutter menjadi 24px. Pada lebar paling banyak 640px, gutter menjadi 20px.

Header desktop memiliki tinggi minimum 80px. Homepage memakai body dengan class `homepage`. Pembukaan R05A memakai dua kolom .8fr:1.2fr, align-items center, gap 64px, dan padding vertikal 48px/32px. Judul serta pencarian berada di kiri; preview Mango berada di kanan. Pencarian berjarak 32px dari copy dan memiliki lebar maksimum 420px. Gap hero turun menjadi 32px pada breakpoint tablet. Intro dasar bersama tetap memakai 1.15fr:1fr, gap 60px, padding 58px/38px, dan align-items end.

Selected fonts memakai dua kolom dengan gap 32px. Latest fonts mempertahankan tiga kolom dengan gap baris 30px dan gap kolom 24px. Kedua grid mempertahankan jumlah kolom pada tablet. Setiap gambar berasio 3:2 dengan object-fit cover. Informasi produk berada 14px di bawah gambar, atau 18px pada Mango, dengan nama dan kategori di kiri serta harga contoh di kanan. Section homepage memakai padding atas 48px dan bawah 24px; jarak heading 24px. Section dasar bersama tetap memakai padding 44px/24px. Bar kategori homepage memiliki batas atas/bawah Line dan padding vertikal 14px.

Pada mobile, header membungkus, memiliki tinggi minimum 68px dan padding vertikal 12px, serta menampilkan tombol Menu. Navigasi tertutup secara default. Hero menjadi satu kolom dengan gap 30px dan padding 32px/24px. Search memiliki margin-top 24px tanpa lebar maksimum. Kedua grid produk menjadi satu kolom dengan gap 28px. Section homepage memakai padding atas 36px; section dasar 32px. Filter membungkus; jumlah hasil berpindah ke bawah dengan gap 10px. Informasi lisensi menjadi satu kolom dengan gap 16px dan margin-top 40px; desktop memakai dua kolom, gap 60px, dan margin-top 60px. Footer menjadi vertikal.

Saat filter menyembunyikan Mango, selector `:has(.intro-feature[hidden])` membuat hero menjadi satu kolom. Intro-copy membentuk dua kolom dengan gap 60px; H1 membentang dua baris dan margin-top search menjadi 20px. Pada mobile, intro-copy kembali display block. Selector state tersembunyi tetap lebih spesifik, sehingga margin-top search tetap 20px dalam state ini.

Urutan homepage R05A adalah pembukaan/pencarian dan Mango, filter, Selected fonts, Latest fonts, hasil kosong bila perlu, informasi lisensi, placeholder freebies, catatan preview, dan footer. Delapan produk terbagi menjadi satu hero, dua pilihan, dan lima rilisan contoh. Komposisi ini berlaku pada homepage yang dibangun, bukan aturan wajib untuk semua halaman. Override H1 dan layout homepage tidak mengganti fondasi component lab.

## Elevation & Depth

Implementasi tidak memakai box-shadow. Batas tipis, whitespace, dan perbedaan Paper/Wash memisahkan kontrol serta kelompok konten. Gambar produk tidak memakai frame berat atau efek mengangkat kartu.

## Shapes

Kontrol memiliki sudut lembut mengikuti token `control`. Tombol memakai batas Ink setebal 1px; field memakai Line setebal 1px. Filter memiliki batas transparan setebal 1px. Preview produk berbentuk persegi panjang tanpa radius atau batas kartu tambahan.

Fokus keyboard memakai outline Ink 2px dengan offset 4px. Tombol dan filter memiliki tinggi minimum 44px. Link navigasi mobile juga memiliki tinggi minimum 44px.

## Components

### Buttons

Tombol utama memakai Ink/Paper; tombol sekunder memakai Paper/Ink. Padding mengikuti frontmatter. Hover sekunder memakai Wash; hover utama memakai Ink hover. State disabled pada fondasi memakai opacity .55 dan cursor not-allowed; homepage tidak menampilkan tombol disabled.

### Inputs / Fields

Pencarian memakai `input type="search"` dengan label terlihat di atas field. Placeholder tidak menggantikan label. Form memiliki tombol Search native. Input memfilter langsung; submit memfilter dan menggulir ke area koleksi.

### Chips

Filter All fonts, Display, Serif, dan Script adalah tombol native. `aria-pressed` mencatat pilihan. Filter aktif memakai Ink/Paper; filter lain memakai Paper/Ink dan Wash saat hover. Padding horizontal turun menjadi 12px pada mobile.

### Cards / Containers

Kartu produk adalah tautan yang memuat gambar, nama, kategori, dan harga bertanda Demo. Hover menggarisbawahi H3; judul Mango memakai H2 sehingga tidak mendapat underline H3. Ketiga jenis kartu tetap mendapat feedback gambar pada hover. Delapan cover berasal dari `static/previews/`: `mango-1.jpg`, `baldock-1.jpg`, `daisy-hotline-1.jpg`, `bawden-1.jpg`, `crimson-queen-1.jpg`, `mordial-1.jpg`, `moyshire-1.jpg`, dan `radiant-summertime-1.jpg`.

Tidak ada raster baru atau perubahan cover dalam pekerjaan dokumentasi ini. Asal yang diketahui adalah file existing di repo; sumber asli serta hak penggunaannya belum diaudit. Gambar memiliki dimensi HTML 1200×800. Cover Mango memakai fetchpriority high; gambar Latest fonts memakai lazy loading.

### Navigation

Header memakai wordmark teks Rillatype dan link Fonts, Freebies, Licenses, serta Contact. Link aktif dan hover memakai underline. Pada mobile, tombol Menu mengubah `aria-expanded` dan visibilitas navigasi. Klik link menutup menu; Escape menutup menu dan mengembalikan fokus ke tombol. Skip link terlihat ketika mendapat fokus.

### Results and preview boundaries

Homepage menyediakan pencarian lokal, filter kategori, polite live region untuk jumlah hasil, dan state kosong dengan Show all fonts. Mango termasuk produk yang dapat disembunyikan melalui state filter. Detail perilaku JavaScript dan hasil pemeriksaan runtime tidak diverifikasi ulang dalam tugas dokumentasi ini.

Harga, kategori, pilihan, dan urutan rilis adalah data contoh. Link produk menuju catatan preview, bukan detail produk atau pembelian. Freebies masih berupa placeholder. Ringkasan lisensi bukan kebijakan penjualan terverifikasi. Contact memakai mailto yang ada; akun dan cart belum menjadi kontrol homepage ini.

### Motion

Transisi kontrol berlangsung 140ms; transisi transform gambar berlangsung 180ms. Keduanya memakai easing `cubic-bezier(.2, .8, .2, 1)`. Hover gambar memakai scale 1.025; active tombol/filter bergeser 1px ke bawah. Seluruh transisi dan transform feedback ini berada dalam media query `prefers-reduced-motion: no-preference`. Tidak ada library animasi, intro, scroll hijack, atau loop dekoratif.

Tugas dokumentasi ini memeriksa sintaks JSON, kecocokan token frontmatter dengan metadata sidecar, referensi komponen, dan kesamaan narrative. Pemeriksaan tersebut bukan review visual, pemeriksaan runtime, validasi schema resmi, angka performa, atau bukti transaksi WooCommerce.

## Do's and Don'ts

### Do:
- Do pertahankan monokrom terang pada UI dan warna asli preview produk.
- Do gunakan kontrol native, label terlihat, fokus keyboard, dan state filter eksplisit.
- Do tampilkan konten utama tanpa menunggu motion dan hormati reduced motion.
- Do tandai data contoh dan jelaskan batas preview pada tindakan terkait.

### Don't:
- Don't tambahkan bayangan besar atau frame berat pada preview produk.
- Don't jadikan font UI pengganti font produk pada specimen.
- Don't klaim harga, lisensi, urutan rilis, metrik, atau hak aset sebagai fakta terverifikasi.
- Don't artikan dokumentasi R05A sebagai verdict review, persetujuan R07, status production, atau bukti checkout, akun, email, dan unduhan berfungsi.
