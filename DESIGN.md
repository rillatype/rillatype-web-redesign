---
name: Rillatype
description: Playful foundry R05C dengan pencarian header sticky, lettering Mango lokal, dan satu aksen coral.
colors:
  accent: "#e0553d"
  paper: "#fff"
  ink: "#171717"
  muted: "#606060"
  line: "#d9d9d9"
  wash: "#f4f4f4"
  ink-hover: "#333"
  transparent: "transparent"
typography:
  body:
    fontFamily: '-apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif'
    fontSize: "16px"
    fontWeight: 400
    lineHeight: 1.55
  display:
    fontSize: "clamp(36px, 4vw, 56px)"
    fontWeight: 600
    lineHeight: 1.15
    letterSpacing: "-.035em"
  headline:
    fontSize: "clamp(26px, 3vw, 36px)"
    fontWeight: 600
    lineHeight: 1.15
    letterSpacing: "-.025em"
  heading-small:
    fontSize: "19px"
    fontWeight: 600
    lineHeight: 1.15
  title:
    fontSize: "17px"
    fontWeight: 600
    lineHeight: 1.15
  label:
    fontSize: "14px"
    lineHeight: 1.55
  small:
    fontSize: "13px"
    lineHeight: 1.55
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
    lineHeight: 1.55
  tester:
    fontSize: "64px"
    lineHeight: 1.3
  tester-mobile:
    fontSize: "44px"
    lineHeight: 1.3
  demo:
    fontSize: "12px"
    lineHeight: 1.55
  foundry-display:
    fontFamily: '"Mango Specimen", sans-serif'
    fontSize: "clamp(58px, 6.5vw, 88px)"
    fontWeight: 400
    lineHeight: 1.1
    letterSpacing: "0"
  foundry-display-tablet:
    fontFamily: '"Mango Specimen", sans-serif'
    fontSize: "clamp(50px, 7vw, 70px)"
    fontWeight: 400
    lineHeight: 1.1
    letterSpacing: "0"
  foundry-display-mobile:
    fontFamily: '"Mango Specimen", sans-serif'
    fontSize: "clamp(44px, 12vw, 62px)"
    fontWeight: 400
    lineHeight: 1.1
    letterSpacing: "0"
  sample:
    fontFamily: '"Mango Specimen", sans-serif'
    fontSize: "82px"
    fontWeight: 400
    lineHeight: 1.25
  sample-mobile:
    fontFamily: '"Mango Specimen", sans-serif'
    fontSize: "70px"
    fontWeight: 400
    lineHeight: 1.25
  sample-label:
    fontSize: "13px"
    fontWeight: 400
    lineHeight: 1.55
  sample-label-mobile:
    fontSize: "12px"
    fontWeight: 400
    lineHeight: 1.55
  foundry-headline:
    fontSize: "clamp(26px, 2.6vw, 34px)"
    fontWeight: 600
    lineHeight: 1.15
    letterSpacing: "-.03em"
  foundry-title:
    fontSize: "19px"
    fontWeight: 600
    lineHeight: 1.15
  foundry-title-mobile:
    fontSize: "18px"
    fontWeight: 600
    lineHeight: 1.15
  feature-title:
    fontSize: "24px"
    fontWeight: 600
    lineHeight: 1.15
    letterSpacing: "-.025em"
  feature-title-mobile:
    fontSize: "22px"
    fontWeight: 600
    lineHeight: 1.15
    letterSpacing: "-.025em"
  license-headline:
    fontFamily: '"Mango Specimen", sans-serif'
    fontSize: "42px"
    fontWeight: 400
    lineHeight: 1.2
    letterSpacing: "0"
  license-headline-mobile:
    fontFamily: '"Mango Specimen", sans-serif'
    fontSize: "34px"
    fontWeight: 400
    lineHeight: 1.2
    letterSpacing: "0"
  footer-wordmark:
    fontFamily: '"Mango Specimen", sans-serif'
    fontSize: "48px"
    fontWeight: 400
    lineHeight: 1.2
  footer-wordmark-mobile:
    fontFamily: '"Mango Specimen", sans-serif'
    fontSize: "44px"
    fontWeight: 400
    lineHeight: 1.2
  foundry-brand:
    fontSize: "17px"
    fontWeight: 600
    lineHeight: 1.25
    letterSpacing: "-.02em"
  foundry-brand-mobile:
    fontSize: "15px"
    fontWeight: 600
    lineHeight: 1.25
    letterSpacing: "-.02em"
  foundry-navigation:
    fontSize: "14px"
    fontWeight: 500
    lineHeight: 1.55
  hero-copy:
    fontSize: "16px"
    lineHeight: 1.6
  hero-copy-mobile:
    fontSize: "14px"
    lineHeight: 1.6
  caption:
    fontSize: "12px"
    lineHeight: 1.55
  freebie-headline:
    fontSize: "28px"
    fontWeight: 600
    lineHeight: 1.15
    letterSpacing: "-.03em"
  freebie-headline-mobile:
    fontSize: "26px"
    fontWeight: 600
    lineHeight: 1.15
    letterSpacing: "-.03em"
rounded:
  base-control: "6px"
  control: "8px"
  filter: "999px"
  imagery: "10px"
spacing:
  filter-gap: "6px"
  compact: "8px"
  tight: "12px"
  row-gap: "16px"
  mobile-gutter: "20px"
  grid-gutter: "24px"
  featured-gap-tablet: "26px"
  sample-margin: "28px"
  featured-gap-mobile: "30px"
  featured-gap: "32px"
  latest-row-gap: "36px"
  desktop-gutter: "40px"
  section-top: "42px"
  base-section-top: "44px"
  license-gap: "50px"
  hero-gap: "60px"
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
  button-secondary-hover:
    backgroundColor: "{colors.wash}"
  specimen-button:
    backgroundColor: "{colors.paper}"
    textColor: "{colors.ink}"
    typography: "{typography.sample-label}"
    rounded: "{rounded.control}"
    padding: "10px 16px"
  specimen-button-hover:
    backgroundColor: "{colors.wash}"
  font-sample:
    textColor: "{colors.accent}"
    typography: "{typography.sample}"
  search-input:
    backgroundColor: "{colors.wash}"
    textColor: "{colors.ink}"
    rounded: "{rounded.control}"
    padding: "12px 14px"
  filter:
    backgroundColor: "{colors.paper}"
    textColor: "{colors.ink}"
    rounded: "{rounded.filter}"
    padding: "9px 15px"
  filter-selected:
    backgroundColor: "{colors.accent}"
    textColor: "{colors.ink}"
  product-card:
    textColor: "{colors.ink}"
    typography: "{typography.foundry-title}"
  product-image:
    backgroundColor: "{colors.wash}"
    rounded: "{rounded.imagery}"
  feature-card:
    textColor: "{colors.ink}"
    typography: "{typography.feature-title}"
  navigation:
    textColor: "{colors.ink}"
    typography: "{typography.foundry-navigation}"
  license-note:
    textColor: "{colors.ink}"
    typography: "{typography.license-headline}"
    padding: "36px 0"
  freebie-note:
    backgroundColor: "{colors.wash}"
    rounded: "{rounded.imagery}"
    padding: "32px"
  footer-wordmark:
    textColor: "{colors.ink}"
    typography: "{typography.footer-wordmark}"
  base-button-primary:
    backgroundColor: "{colors.ink}"
    textColor: "{colors.paper}"
    rounded: "{rounded.base-control}"
    padding: "10px 19px"
  base-search-input:
    backgroundColor: "{colors.paper}"
    textColor: "{colors.ink}"
    rounded: "{rounded.base-control}"
    padding: "12px 14px"
  base-filter:
    backgroundColor: "{colors.paper}"
    textColor: "{colors.ink}"
    rounded: "{rounded.base-control}"
    padding: "9px 15px"
---

# Design System: Rillatype

## Overview

**Creative North Star: "Playful foundry"**

User memilih playful foundry dan satu aksen coral pada R05B, lalu menolak keseluruhan UI dan UX versi tersebut. Feedback posisi Find a font mendasari R05C. R05C mengganti pembukaan seperti poster dengan hero Paper dan pencarian header sticky. Lettering Mango lokal tetap hadir pada judul hero, sample di produk Mango, judul lisensi, dan footer. Logo asli serta warna preview produk tetap dipertahankan.

Dokumen ini merekam `static/redesign/index.html`, `style.css`, `foundry.css`, dan `preview.js`. Override foundry adalah sistem aktif homepage; base 6px hanya menjadi acuan component lab, bukan radius homepage. Aturan CSS produk yang tersedia tidak membuktikan R06 atau transaksi selesai. Review R05C masih pending. Arah playful foundry dipilih user, tetapi revisi R05C belum memiliki verdict ship atau persetujuan user.

**Key Characteristics:**
- Mango lokal untuk lettering; system sans untuk informasi dan kontrol.
- Hero Paper, satu aksen coral pada filter terpilih dan sample Mango.
- Pencarian header sticky tetap terlihat ketika navigasi mobile tertutup.
- Kontrol 8px, filter pill, gambar dan callout 10px, kartu tanpa bayangan.
- Sample berada di produk Mango; jumlah hasil tetap tersedia untuk setiap filter.
- Konten langsung terlihat dengan feedback CSS yang menghormati reduced motion.

## Colors

### Primary
- **Coral** (`accent`): filter terpilih dan pasangan huruf Mango. Custom property berada pada override foundry.

### Neutral
- **Paper** (`paper`): halaman, header sticky, hero, tombol sekunder, dan tombol sample.
- **Ink** (`ink`): teks, tombol utama, border fokus field, dan outline keyboard.
- **Muted** (`muted`): copy pembukaan, kategori, placeholder, catatan, dan informasi sekunder.
- **Line** (`line`): border header, bar filter, sample, lisensi, dan catatan preview.
- **Wash** (`wash`): field pencarian header, penampung gambar, hover sekunder, dan callout freebies.
- **Ink hover** (`ink-hover`): literal hover tombol utama dalam base CSS.
- **Transparent** (`transparent`): border field header saat tidak fokus dan border filter default.

Frontmatter memuat nilai CSS aktual. Tonal ramp sidecar adalah metadata panel sintetis, bukan warna UI tambahan.

**The One Accent Rule.** Gunakan coral pada pilihan aktif dan sample; pertahankan warna asli gambar produk.

## Typography

Mango Specimen memakai file existing `static/previews/mango-letter.otf`, weight 400, style normal, dan `font-display: swap`. Homepage melakukan preload OTF dengan `crossorigin`. Stack aktual adalah `"Mango Specimen", sans-serif`. Fallback menangani kegagalan font, bukan pengganti permanen Mango.

System sans pada `body` melayani copy, judul koleksi, nama produk, harga, navigasi, dan kontrol. Role tanpa `fontFamily` mewarisi stack body. Harga memakai tabular numerals dan white-space nowrap.

### Hierarchy
- H1 Mango memakai `foundry-display`, line-height 1.1, tracking 0. Clamp aktual adalah 58px sampai 88px desktop, 50px sampai 70px pada max-width 1000px, lalu 44px sampai 62px pada max-width 640px.
- Sample Mango memakai `sample` 82px/1.25, min-height 104px; mobile memakai 70px/1.25, min-height 90px. Tidak ada ukuran tablet terpisah. Caption memakai 12px. Label Change sample memakai 13px, turun menjadi 12px mobile.
- H2 koleksi memakai `foundry-headline`, clamp 26px sampai 34px, weight 600, line-height 1.15, tracking -.03em.
- Nama produk biasa memakai 19px, turun menjadi 18px mobile. Judul Mango tetap system sans, 24px atau 22px mobile, tracking -.025em.
- Judul lisensi Mango memakai 42px/1.2 atau 34px mobile. Wordmark footer Mango memakai 48px/1.2 atau 44px mobile.
- Teks pendamping logo memakai 17px/1.25 weight 600, turun menjadi 15px mobile. Font studio dan label search memakai 12px; link header memakai 14px weight 500.
- Copy hero memakai 16px/1.6, turun menjadi 14px mobile. Kredit font memakai 12px. Judul freebies memakai 28px atau 26px mobile; copy freebies memakai 14px.

### Shared base

Component lab memakai role base `display`, `headline`, `heading-small`, `title`, `brand`, dan `brand-mobile`. H1 base memakai clamp 36px sampai 56px, H2 clamp 26px sampai 36px, H3 19px, nama kartu 17px. Brand base memakai 25px atau 23px. Body 16px/1.55 dan small 13px tetap dipakai homepage.

Aturan produk base mencakup `product-display` clamp 32px sampai 44px, `legend` 15px weight 600, `tester` 64px/1.3 atau 44px mobile, dan `demo` 12px. Ukuran ini bukan sample homepage dan bukan bukti preview produk selesai.

**The Real Lettering Rule.** Gunakan Mango lokal pada judul hero, sample Mango, judul lisensi, dan footer; gunakan system sans untuk informasi dan kontrol.

## Layout

Wrapper maksimum 1240px dengan gutter 40px per sisi. Base max-width 900px mengubah gutter menjadi 24px; max-width 640px menjadi 20px. Breakpoint foundry 1000px tidak mengubah gutter. `style.css` dimuat sebelum `foundry.css`.

Header memakai position sticky, top 0, z-index 2, latar Paper, dan border bawah Line 1px. Grid desktop adalah auto minmax(260px, 440px) auto, gap 32px, min-height 104px. Logo tampil 58px persegi. Search berada antara logo dan navigasi, width 100%, dengan label terlihat di atas field serta tombol Search di kanan. Gap baris field 8px dan jarak label 6px.

Pada max-width 1000px, grid header menjadi auto 1fr, gap 12px/32px, padding vertikal 14px. Search tetap pada baris pertama di kolom kedua. Navigasi memakai satu baris penuh di bawahnya. Pada max-width 640px, logo menjadi 46px, Menu di kanan logo, dan search memakai baris kedua penuh. Gap 12px, padding atas 10px dan bawah 16px. Navigasi biasa berada pada baris ketiga dan tertutup secara default; pencarian tidak masuk area collapse.

Produk serta target Fonts, Licenses, Freebies, dan catatan preview memakai scroll-margin-top 136px desktop, berubah menjadi 190px pada max-width 1000px, termasuk mobile. Offset ini membantu menempatkan target di bawah header sticky. Min-height header bukan tinggi tetap ketika menu terbuka.

Pembukaan Paper memakai padding atas 44px dan bawah 38px. Hero dua kolom 1.6fr:1fr, align center, gap 60px. H1 di kiri; copy, Browse fonts, dan kredit Mango di kanan. Gap turun menjadi 36px pada max-width 1000px. Mobile memakai satu kolom, gap 20px, padding vertikal 28px, dan copy rata kiri. CTA berjarak 22px dari copy atau 16px mobile; kredit berjarak 18px atau 12px mobile.

Bar filter dan count mendahului koleksi, border-block Line 1px, gap 24px, padding vertikal 16px. Mobile menjadi vertikal dengan gap 12px dan padding 14px. Bar ini berada di luar koleksi yang bisa disembunyikan. Section memakai padding atas 42px dan bawah 24px; mobile atas 30px. Jarak heading 24px.

Koleksi pilihan memakai kolom 1.22fr:1fr, gap 32px, align start. Mango membentang dua baris dan memuat sample di dalam article yang sama. Gap tablet 26px. Mobile satu kolom, gap 30px, tanpa span Mango. Latest memakai tiga kolom dan gap 36px/24px, margin atas 14px. Mobile satu kolom dengan gap 36px/24px tetap berlaku karena specificity foundry, margin atas 10px.

Sample memakai flex sejajar, justify-between, gap 24px, margin atas 28px, padding 20px/0/16px, dan border-block Line. Mobile gap 16px, margin atas 22px. Lisensi memakai dua kolom 1fr:1fr, gap 50px, margin atas 60px, padding 36px/0; mobile satu kolom, gap 20px, margin atas 44px, padding 28px/0. Freebies memakai flex horizontal, gap 32px, margin atas 28px, padding 32px; mobile vertikal, gap 20px, padding 24px. Footer memakai padding vertikal 36px dan menjadi vertikal pada mobile.

Urutan aktif adalah header search, hero Paper, filter/count, tiga font pilihan dengan sample Mango, lima rilisan contoh, hasil kosong bila diperlukan, lisensi, freebies, catatan preview, dan footer. Hero tetap terlihat ketika Mango disembunyikan oleh filter. Susunan ini mencatat homepage, bukan template wajib setiap halaman.

### Shared base

Component lab tetap memakai header minimum 80px atau 68px mobile, intro 1.15fr:1fr dengan gap 60px, section 44px/24px, dan grid tiga kolom gap 30px/24px. Aturan detail produk base memakai 1.4fr:1fr gap 56px, lalu 1.1fr:1fr gap 28px pada max-width 900px, dan satu kolom gap 32px mobile. Thumbnail empat kolom gap 12px; tester-controls 1fr:240px gap 36px atau satu kolom gap 20px mobile. Ini aturan CSS yang tersedia, bukan alur toko terverifikasi.

## Elevation & Depth

Tidak ada box-shadow. Paper, Wash, whitespace, dan border 1px memisahkan kelompok konten. Header sticky berada di atas konten melalui z-index 2 tanpa blur atau bayangan. R05C tidak menampilkan mockup hero; rotasi mockup dan sample R05B bukan bagian sistem aktif.

## Shapes

Kontrol foundry memakai radius 8px, termasuk tombol, search, dan Change sample. Filter memakai radius 999px. Gambar dan callout freebies memakai radius 10px. Base radius 6px hanya acuan component lab; override homepage memakai 8px. Gambar berasio 3:2 dan object-fit cover.

Tombol biasa memakai border Ink 1px; Change sample memakai Line 1px dan berubah menjadi Ink saat hover. Field header memiliki border transparan 1px, menjadi Ink saat fokus. Outline focus-visible memakai Ink 2px dan offset 4px. Tombol, filter, Change sample, dan link header memiliki min-height 44px.

## Components

### Buttons

Tombol utama memakai Ink/Paper; sekunder memakai Paper/Ink. Padding 10px/19px, weight 600, radius 8px. Hover utama memakai Ink hover; hover sekunder memakai Wash. Browse fonts memakai aturan tombol utama yang sama. Disabled base memakai opacity .55 dan cursor not-allowed; homepage tidak menampilkan state disabled.

### Inputs / Fields

Find a font adalah label terlihat untuk input native type search dalam header. Placeholder adalah Search fonts by name or style. Field memakai Wash, padding 12px/14px, dan radius 8px. Query memfilter langsung, case-insensitive, terhadap nama, style, dan kategori tertulis. Submit menuju hasil pertama yang terlihat; jika kosong, menuju bar Fonts. Header sticky mempertahankan query terlihat setelah scroll.

### Chips

All fonts, Display, Serif, dan Script memakai tombol native dengan aria-pressed. State terpilih memakai Coral/Ink; default Paper/Ink, hover Wash. Padding 9px/15px atau horizontal 12px mobile; gap 6px. Filter dan query bekerja bersama. Count dengan polite live region selalu tersedia pada bar filter, termasuk Script dan nol hasil; empty state hanya muncul ketika count nol. Show all fonts menghapus query dan kategori, lalu fokus ke field header.

### Cards / Containers

Kartu flat memuat cover, nama system sans, kategori, dan harga Demo. Informasi berjarak 16px dari gambar; kategori berjarak 3px dari nama. Hover menggarisbawahi H3 dan memberi feedback gambar. Semua cover memiliki dimensi HTML 1200x800. Mango memakai fetchpriority high; tujuh cover lainnya lazy loading.

Aset yang diketahui adalah `logo.png`, delapan cover existing dalam `static/previews/` (`mango-1.jpg`, `baldock-1.jpg`, `daisy-hotline-1.jpg`, `bawden-1.jpg`, `crimson-queen-1.jpg`, `mordial-1.jpg`, `moyshire-1.jpg`, `radiant-summertime-1.jpg`), dan `mango-letter.otf`. R05C tidak menambah raster atau font baru. Asal file diketahui dari repo; hak penggunaan belum diaudit. Tidak ada klaim hak aset.

Lisensi memakai border-block Line dan judul Mango; penjelasan system sans maksimum 50ch. Freebies memakai Wash, radius 10px, dan tombol sekunder. Footer memakai wordmark Mango bersama Fonts, Licenses, dan Contact.

### Mango sample

Sample berada di dalam produk Mango, di bawah metadata kartu. Caption adalah Letter preview · Mango Letters. Pasangan awal Aa memakai tinta Coral. Change sample mengganti Aa, Bb, Gg, Rr, lalu Aa. Tombol aria-controls menunjuk polite live region. Sample ikut tersembunyi ketika Mango tidak cocok dengan filter. Kredit Mango pada hero mereset query dan kategori sebelum anchor menuju produk. Sample ini bukan tester teks lengkap.

### Navigation

Header memakai gambar logo asli dengan teks Rillatype dan Font studio. Link utama adalah Fonts, Freebies, dan Licenses; Contact berada di footer. Gap link header 24px. Hover dan aria-current memakai underline. Menu mobile mengubah aria-expanded dan class is-open. Klik link menutup menu; Escape menutup menu dan mengembalikan fokus ke Menu. Skip link tampil ketika fokus. Search tetap terlihat dalam state menu tertutup.

### Motion and evidence

Easing bersama adalah cubic-bezier(.2, .8, .2, 1). No-preference mengaktifkan transisi kontrol 140ms, sample background/border 150ms, dan gambar 180ms. Active tombol/filter bergeser 1px; hover gambar scale 1.025. Tidak ada loop, rotasi sample, intro tertunda, WebGL, atau library animasi tambahan.

Menurut hasil pemeriksaan yang diberikan untuk R05C, PASS mencakup Mango nyata loaded, siklus sample, fallback font, pencarian dalam header, query sticky terlihat setelah scroll, target di bawah header, count tetap terlihat pada Script dan hasil kosong, reset anchor Mango, overflow, dan keyboard. `scripts/check-redesign-preview.py` adalah sumber pemeriksaan perilaku yang tersedia. Tugas dokumentasi ini tidak menjalankan browser ulang; PASS perilaku tidak menjadi verdict visual atau persetujuan user.

Harga, kategori, pilihan, dan urutan rilis tetap data contoh. Kartu menuju catatan preview; produk dan pembelian belum terhubung. Freebies masih placeholder. Ringkasan lisensi bukan kebijakan terverifikasi. Akun dan cart belum menjadi kontrol homepage ini. Review R05C tetap pending; tidak ada klaim performa, hak aset, atau transaksi selesai.

## Do's and Don'ts

### Do:
- Do gunakan Mango lokal pada judul hero, sample Mango, judul lisensi, dan footer.
- Do pertahankan satu aksen coral, logo asli, dan warna asli preview produk.
- Do letakkan pencarian di header sticky dan tetap terlihat ketika menu mobile tertutup.
- Do gunakan radius kontrol 8px, filter 999px, dan gambar serta callout 10px pada homepage.
- Do pertahankan count di luar koleksi tersembunyi dan reset query serta kategori pada anchor Mango.
- Do gunakan label terlihat, fokus keyboard, state native, dan reduced motion.
- Do tandai data contoh dan pisahkan base component lab dari override foundry.

### Don't:
- Don't kembali ke komposisi poster R05B dengan bidang coral, mockup berotasi, atau Aa di hero.
- Don't pindahkan search ke bawah hero atau ke dalam navigasi mobile yang dapat disembunyikan.
- Don't gunakan radius base 6px sebagai radius homepage atau pill untuk semua kontrol.
- Don't jadikan sample homepage sebagai tester teks lengkap atau bukti R06 selesai.
- Don't tambahkan raster, font, bayangan besar, atau frame berat tanpa kebutuhan yang disepakati.
- Don't klaim hak aset, performa, harga, lisensi, customer proof, atau transaksi tanpa bukti.
- Don't artikan dokumentasi R05C sebagai verdict ship, persetujuan user, atau status siap rilis.
