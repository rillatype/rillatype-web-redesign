---
name: Rillatype
description: Katalog studio monokrom terang untuk preview homepage R05.
colors:
  paper: "#fff"
  ink: "#171717"
  muted: "#606060"
  line: "#d9d9d9"
  wash: "#f4f4f4"
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
    backgroundColor: "#333"
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
  navigation:
    textColor: "{colors.ink}"
    typography: "{typography.label}"
---

# Design System: Rillatype

## Overview

**Creative North Star: "Katalog studio"**

Katalog studio adalah arah yang dipilih user pada 9 Oktober 2026. UI monokrom terang memberi ruang bagi preview font berwarna asli. System sans menjaga kontrol mudah dibaca tanpa unduhan font UI tambahan. Gambar produk membawa karakter, sementara kontrol memakai batas yang jelas dan feedback ringan.

Dokumen ini memperbarui fondasi R04 berdasarkan homepage R05 yang selesai dibangun di `static/redesign/index.html`, `style.css`, dan `preview.js`. Disposisi review **ship** berlaku hanya untuk preview homepage R05, berdasarkan review agent terpisah. Ini bukan persetujuan R07, integrasi WordPress, atau rilis production. Preview produk R06 dan alur WooCommerce belum tercakup. Status tugas berada di `PROGRESS.md`.

Pencarian, filter, serta menu memakai elemen HTML native dan JavaScript lokal. Konten utama langsung terlihat. Motion ringan memakai CSS dan hanya aktif ketika pengguna tidak meminta reduced motion.

**Key Characteristics:**
- UI monokrom terang; preview produk mempertahankan warna asli.
- System sans untuk teks dan kontrol homepage.
- Grid produk datar dengan preview berasio 3:2.
- Pencarian lokal, filter kategori, dan menu mobile dengan state eksplisit.
- Motion CSS singkat tanpa menyembunyikan konten.

## Colors

Palette UI netral terang tidak mengambil warna dari cover produk.

### Primary
- **Ink** (`ink`): teks utama, tombol utama, filter terpilih, dan fokus keyboard.

### Neutral
- **Paper** (`paper`): latar halaman, field, dan kontrol sekunder.
- **Muted** (`muted`): deskripsi, kategori, placeholder, footer, dan catatan preview.
- **Line** (`line`): batas field, header, pemisah, dan informasi lisensi.
- **Wash** (`wash`): hover kontrol dan latar penampung gambar.

Nilai frontmatter mengikuti custom properties di stylesheet. Hover tombol utama memakai nilai lokal `#333`.

**The Original Preview Rule.** Pertahankan warna asli preview produk; jangan menerapkan filter monokrom pada gambar.

## Typography

Homepage memakai stack system sans pada frontmatter untuk display, body, serta kontrol. Ini mencatat implementasi preview yang ada, bukan keputusan font display untuk semua halaman mendatang. Font UI tidak menggantikan font produk pada specimen.

- Display memakai ukuran fluid dan tracking rapat untuk pembukaan singkat.
- Headline memakai ukuran fluid yang lebih kecil untuk judul koleksi dan informasi lisensi.
- Title mencatat nama produk. Judul lain memakai ukuran dasar 19px.
- Body memakai line-height 1.55. Teks pembukaan dibatasi 42ch; penjelasan lisensi 50ch.
- Label dan harga memakai 14px. Tombol memakai weight 600; label input memakai weight bawaan.
- Small memakai 13px untuk kategori, jumlah hasil, catatan, dan footer.
- Harga memakai tabular numerals dan tidak membungkus baris.

## Layout

Konten maksimum 1240px dengan gutter desktop 40px per sisi. Pada lebar paling banyak 900px, gutter menjadi 24px. Pada lebar paling banyak 640px, gutter menjadi 20px.

Header desktop memiliki tinggi minimum 80px. Pembukaan memakai dua kolom dengan perbandingan 1.15fr:1fr, gap 60px, dan padding vertikal 58px/38px. Judul berada di kiri dan pencarian di kanan. Gap turun menjadi 32px pada breakpoint tablet.

Grid produk memakai tiga kolom dengan gap baris 30px dan gap kolom 24px. Setiap gambar berasio 3:2 dengan object-fit cover. Informasi produk berada 14px di bawah gambar, nama dan kategori di kiri, harga contoh di kanan. Section memakai padding 44px/24px dan jarak heading 24px.

Pada mobile, header membungkus dan menampilkan tombol Menu. Navigasi tertutup secara default. Pembukaan, grid produk, serta informasi lisensi menjadi satu kolom. Gap produk menjadi 28px. Filter membungkus; jumlah hasil berpindah ke bawah. Footer menjadi vertikal. Tidak ada breakpoint dua kolom produk.

Urutan homepage R05 adalah pembukaan/pencarian, filter, Selected fonts, Latest fonts, hasil kosong bila perlu, informasi lisensi, placeholder freebies, catatan preview, dan footer. Urutan ini mendokumentasikan homepage, bukan aturan wajib untuk setiap halaman.

## Elevation & Depth

Implementasi tidak memakai box-shadow. Batas tipis, whitespace, dan perbedaan Paper/Wash memisahkan kontrol serta kelompok konten. Gambar produk tidak memakai frame berat atau efek mengangkat kartu.

## Shapes

Kontrol memiliki sudut lembut mengikuti token `control`. Tombol memakai batas Ink setebal 1px; field memakai Line setebal 1px. Filter memiliki batas transparan setebal 1px. Preview produk berbentuk persegi panjang tanpa radius atau batas kartu tambahan.

Fokus keyboard memakai outline Ink 2px dengan offset 4px. Tombol dan filter memiliki tinggi minimum 44px. Link navigasi mobile juga memiliki tinggi minimum 44px.

## Components

### Buttons

Tombol utama memakai Ink/Paper; tombol sekunder memakai Paper/Ink. Padding mengikuti frontmatter. Hover sekunder memakai Wash; hover utama memakai warna lokal yang tercatat di Colors. State disabled pada fondasi memakai opacity .55 dan cursor not-allowed; homepage tidak menampilkan tombol disabled.

### Inputs / Fields

Pencarian memakai `input type="search"` dengan label terlihat di atas field. Placeholder tidak menggantikan label. Form memiliki tombol Search native. Input memfilter langsung; submit memfilter dan menggulir ke area koleksi.

### Chips

Filter All fonts, Display, Serif, dan Script adalah tombol native. `aria-pressed` mencatat pilihan. Filter aktif memakai Ink/Paper; filter lain memakai Paper/Ink dan Wash saat hover. Padding horizontal turun menjadi 12px pada mobile.

### Cards / Containers

Kartu produk adalah tautan yang memuat gambar, nama, kategori, dan harga bertanda Demo. Hover menggarisbawahi nama. Delapan cover berasal dari `static/previews/`: `mango-1.jpg`, `baldock-1.jpg`, `daisy-hotline-1.jpg`, `bawden-1.jpg`, `crimson-queen-1.jpg`, `mordial-1.jpg`, `moyshire-1.jpg`, dan `radiant-summertime-1.jpg`.

Tidak ada raster baru atau perubahan cover dalam pekerjaan dokumentasi ini. Asal yang diketahui adalah file existing di repo; sumber asli serta hak penggunaannya belum diaudit. Gambar memiliki dimensi HTML 1200×800. Cover Mango memakai fetchpriority high; gambar Latest fonts memakai lazy loading.

### Navigation

Header memakai wordmark teks Rillatype dan link Fonts, Freebies, Licenses, serta Contact. Link aktif dan hover memakai underline. Pada mobile, tombol Menu mengubah `aria-expanded` dan visibilitas navigasi. Klik link menutup menu; Escape menutup menu dan mengembalikan fokus ke tombol. Skip link terlihat ketika mendapat fokus.

### Results and preview boundaries

Pencarian mencocokkan nama, kategori data, dan deskripsi style yang terlihat, tanpa membedakan kapitalisasi. Query dan kategori digabungkan. Koleksi tanpa hasil disembunyikan; jumlah hasil diumumkan melalui polite live region. State kosong menyediakan Show all fonts yang menghapus query/filter dan mengembalikan fokus ke input. Mismatch reviewer untuk descriptor pencarian sudah diperbaiki dan memiliki regresi `handwritten` pada script pemeriksaan.

Harga, kategori, pilihan, dan urutan rilis adalah data contoh. Link produk menuju catatan preview, bukan detail produk atau pembelian. Freebies masih berupa placeholder. Ringkasan lisensi bukan kebijakan penjualan terverifikasi. Contact memakai mailto yang ada; akun dan cart belum menjadi kontrol homepage ini.

### Motion

Transisi kontrol berlangsung 140ms; transisi transform gambar berlangsung 180ms. Keduanya memakai easing `cubic-bezier(.2, .8, .2, 1)`. Hover gambar memakai scale 1.025; active tombol/filter bergeser 1px ke bawah. Seluruh transisi dan transform feedback ini berada dalam media query `prefers-reduced-motion: no-preference`. Tidak ada library animasi, intro, scroll hijack, atau loop dekoratif.

Pemeriksaan perilaku tersedia melalui `python scripts/check-redesign-preview.py` setelah `node server.js`. Script memeriksa pencarian nama/descriptor, filter, reset, menu mobile, gambar, overflow desktop/mobile, reduced motion, dan error JavaScript. Hasil lulus bukan angka performa atau bukti transaksi WooCommerce.

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
- Don't artikan disposisi ship R05 sebagai persetujuan R07 atau bukti checkout, akun, email, dan unduhan berfungsi.
