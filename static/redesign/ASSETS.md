# Aset preview editorial

Status: inventaris P03/P12 dilengkapi 10 Oktober 2026 dengan aset user Mondriel dan Brika. Lokasi sumber tidak berarti sudah terintegrasi atau boleh dipublikasikan production. Sumber produk: `docs/redesign/reference-inventory.md`; prosedur P06/P08: `docs/redesign/font-test-handoff.md`.

## Font UI dan logo

- `manrope.ttf` berasal dari https://raw.githubusercontent.com/google/fonts/main/ofl/manrope/Manrope%5Bwght%5D.ttf.
- Lisensi font asli disimpan sebagai `OFL-Manrope.txt`, dari https://raw.githubusercontent.com/google/fonts/main/ofl/manrope/OFL.txt.
- Font UI dimuat lokal. Tidak ada stylesheet font pihak ketiga pada runtime.
- Logo memakai `../../logo.png`, aset yang sudah tersedia di repo.

## Specimen font yang tersedia di repo

Berkas berikut ada dan dipakai tester. Hak distribusi final tetap perlu diperiksa sebelum production (W04/W19).

| Produk | Berkas | Lokasi | Catatan |
| --- | --- | --- | --- |
| Mango Letters | `mango-letter.otf` | `../previews/` | Satu specimen. 184 glyph, 181 codepoint, fitur `dlig`. Dipakai kasus C01 |
| Chronoa | `Chronoa-{Thin,ExtraLight,Light,Regular,Medium,SemiBold,Bold,ExtraBold,Black}.otf` | `fonts/` | Sembilan cut dari folder kerja pengguna `Font Test`. 219 glyph dan 218 codepoint per berkas, tanpa feature GSUB. Dipakai kasus C04 |
| Chronoa (web) | `fonts/web/chronoa-*.woff2` | `fonts/web/` | Subset untuk specimen homepage, dibangun `scripts/build-font-subsets.py` |
| Mango (web) | `fonts/web/mango-letters.woff2` | `fonts/web/` | Subset untuk specimen homepage |

Setiap entri style pada `font-catalog.js` membawa direktori berkasnya sendiri. Kode tidak menebak satu direktori bersama, supaya berkas dari produk berbeda tidak saling tertukar.

## Berkas specimen yang belum tersedia

Entri berikut sudah ada di `font-catalog.js` dengan nama style asli dari deskripsi toko, tetapi **tanpa berkas**. Tester harus menunjukkan state tidak tersedia; jangan menggantinya dengan font UI dan jangan menghapus entrinya.

| Kasus | Produk | Berkas yang dibutuhkan | Permalink toko |
| --- | --- | --- | --- |
| C02 | Tropivera | Decorative, Regular, Dingbats | https://rillatype.com/product/tropivera/ |
| C03 | Dockhand | Script Regular, Sans Regular | https://rillatype.com/product/dockhand-font-duo/ |
| C05 | Wildkins Hiker's Bundle | Regular, Slant, Stamp, Stamp Slant, Dingbats | https://rillatype.com/product/wildkins-hikers-bundle-hand-inked-font-extras/ |
| C07 | Solaya | Raw, Neat | https://rillatype.com/product/solaya-a-dual-style-tropical-font-bonus-illustrations/ |
| C08 | Darkwell Family | Dua font, masing-masing Regular, Bold, Italic | https://rillatype.com/product/darkwell-family/ |
| C10 | Redline Syndicate | Satu specimen | https://rillatype.com/product/redline-syndicate-display-font/ |

C03 dapat memakai Mondriel yang sudah tersedia dari user, meskipun berkas Dockhand tetap belum ada. C05 dapat memakai Brika Dingbats meskipun Wildkins/Tropivera belum ada. Jangan lagi menyebut seluruh kasus C03/C05 kekurangan berkas.

## Sumber user: C03 sudah terintegrasi, C05 menunggu

| Kasus | Sumber relatif root workspace | Bukti dan status integrasi |
| --- | --- | --- |
| C03 | `Font Test/Mondriel-Font-Duo/Fonts/RT Mondriel-{Regular,Slant,Outline,Outline Slant,Handwritten}.otf` | **Terintegrasi P06.** Lima berkas disalin byte-identik (SHA256 sama) ke `static/redesign/fonts/Mondriel-*.otf` dan dipakai fixture `mondriel` di katalog. Fakta terukur: Regular/Slant/Outline/Outline Slant 195 glyph dan 194 codepoint cmap (termasuk 0x00 dan 0x0D) tanpa tabel GSUB; Handwritten 219/187 dengan tag `liga` dan `dlig`. Kelima berkas memakai typographic family `RT Mondriel` dan weight 400, jadi identitas face dibawa per style (`faceFamily`). |
| C05 | `Font Test/RT Brika-Dingbats.otf` | Source asli terbaca, 234 glyph/233 raw codepoint, tanpa feature tag GSUB. **Belum diintegrasikan**; jumlah ikon terlihat dan render glyph belum diverifikasi. Pekerjaan P08. |

Tabel salinan dan hash C03:

| Style | Berkas specimen lokal | Baca dari source | SHA256 (12 pertama) |
| --- | --- | --- | --- |
| Regular | `static/redesign/fonts/Mondriel-Regular.otf` | `RT Mondriel-Regular.otf` | `f6f8af320bda` |
| Slant | `static/redesign/fonts/Mondriel-Slant.otf` | `RT Mondriel-Slant.otf` | `b8673a22fe3b` |
| Outline | `static/redesign/fonts/Mondriel-Outline.otf` | `RT Mondriel-Outline.otf` | `3c0c75bebc75` |
| Outline Slant | `static/redesign/fonts/Mondriel-OutlineSlant.otf` | `RT Mondriel-Outline Slant.otf` | `da969c373b8c` |
| Handwritten | `static/redesign/fonts/Mondriel-Handwritten.otf` | `RT Mondriel-Handwritten.otf` | `3b389eed13d2` |

Pemeriksaan yang mengulang bukti ini: `python scripts/check-tester-mixed-family.py` (bagian A membandingkan hash salinan dengan source bila folder `Font Test/` ada). Langkah lengkap, identitas face per style, raw metadata, filtering codepoint, test FAIL/PASS, dan scope pelaksana berada di `docs/redesign/font-test-handoff.md`. Instruksi lama memasukkan dua Dockhand tanpa perubahan loader tidak berlaku bagi lima Mondriel berdescriptor sama; Dockhand tetap dicatat sebagai produk duo yang berkasnya belum ada.
Hak/strategi web specimen production tetap W04/W19. Outline/Slant memakai berkas nyata, bukan efek CSS. Metadata GSUB adalah hasil parsing, bukan bukti fitur terlihat sudah diuji.

## Gambar preview

- `../previews/` memuat gambar font yang sudah ada di repo. Tidak ada gambar AI atau gambar stock baru.
- Setiap entri `images` pada `font-catalog.js` memuat path lengkap `../previews/<berkas>`. Tidak ada nama berkas tanpa path dan tidak ada path yang dibentuk dari nilai default.
- Gambar yang sudah dipetakan: `bawden-1`, `chronoa-1`, `mango-1..4`, `baldock-1`, `daisy-hotline-1`, `crimson-queen-1`, `mordial-1`, `moyshire-1`, `radiant-summertime-1`, `brush-set-1..3`, `font-bundle-1..2`, `graphic-pack-1..2`, dan sejak P12 `distressed-overlays-1`, `palm-tree-1`, `cowboy-horseback-1`, `cowboy-bear-1`.
- `../previews/chronoa-1.jpg` dirender dari berkas Chronoa asli dengan Pillow, bukan artwork hasil generasi.
- Belum dipetakan: gambar produk toko nyata (Tropivera, Dockhand, Wildkins, Solaya, Darkwell, Redline). Produk itu sengaja dibiarkan tanpa gambar alih-alih memakai artwork produk lain. Halaman detail menampilkan keterangan bahwa gambar belum dipetakan. Distressed Overlays sudah dipetakan sejak P12 (lihat bagian di bawah).
- Belum dipakai (tersedia bila galeri diperluas): `mango-5.jpg` sampai `mango-9.jpg`.
- Sumber gambar toko 1200x800 dengan rasio 3:2, terukur pada delapan produk (lihat inventory P02). Aturan tampil utuh ada di `product-spec.md`.

## Gambar produk Graphics yang dipakai homepage (P12)

Empat artwork di bawah ini adalah gambar produk toko yang nyata, diunduh read-only dari `wp-content/uploads` toko pada 10 Oktober 2026 dan disimpan sebagai salinan byte-identik (SHA256 dibandingkan sesudah salin). Semuanya 1200x800 rasio 1.500, jadi ditampilkan utuh dengan `object-fit: contain` pada bingkai 3:2.

| Berkas | Produk | Sumber toko | Dimensi | Ukuran |
| --- | --- | --- | --- | --- |
| `distressed-overlays-1.jpg` | Distressed Overlays Vol.01 | `https://rillatype.com/wp-content/uploads/2024/11/Preview-3.jpg` | 1200x800 | 289.658 B |
| `palm-tree-1.jpg` | Palm Tree Illustration Set | `https://rillatype.com/wp-content/uploads/2024/11/Preview.jpg` | 1200x800 | 419.519 B |
| `cowboy-horseback-1.jpg` | Wild West Cowboy on Horseback | `https://rillatype.com/wp-content/uploads/2024/11/Preview-1.jpg` | 1200x800 | 1.004.371 B |
| `cowboy-bear-1.jpg` | Stay Wild - Vintage Cowboy and Bear | `https://rillatype.com/wp-content/uploads/2024/11/preview-2.jpg` | 1200x800 | 1.019.241 B |

Produknya terverifikasi sebagai kategori `graphic` + `freebies`, tipe `simple`, dengan post ID 3252, 3214, 3241, dan 3245; harganya `$15` dicoret menjadi `$0` saat dibaca. Entri katalognya `storeStatus: 'live'`, dan `permalink` menunjuk halaman produk masing-masing.

**Yang sengaja tidak dipakai sebagai artwork.** `brush-set-1..3.jpg` dan `graphic-pack-1..2.jpg` adalah mockup yang digambar `generate-sections.py` (elips dan kotak warna di atas latar polos), bukan artwork produk. Sejak P12 keduanya tidak lagi dipakai homepage sebagai artwork; entri demo-nya tetap ada di katalog untuk `catalog.html` dan tetap tidak boleh dianggap produk toko.

## Aset demo dan mockup

Aset berikut **bukan** produk toko terkonfirmasi dan gambar-gambarnya adalah mockup placeholder. Entri datanya ditandai `storeStatus: 'demo'`.

| Slug | Nama entri | Kind |
| --- | --- | --- |
| `brush-set-1` | Ink Brush Set | graphic |
| `brush-set-2` | Marker Toolkit | graphic |
| `brush-set-3` | Watercolor Wash | graphic |
| `font-bundle-1` | Foundry Bundle Vol. 1 | font |
| `font-bundle-2` | Display Duo | font |
| `graphic-pack-1` | Stamp and Badge Pack | graphic |
| `graphic-pack-2` | Label and Tag Pack | graphic |

Entri demo dipakai `catalog.html` dan halaman detail selama belum ada padanan produk nyata. Jangan diperlakukan sebagai produk, harga, atau aset yang terverifikasi.
