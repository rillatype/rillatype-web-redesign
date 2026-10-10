# Aset preview editorial

Status: diperbarui P03, 10 Oktober 2026. Daftar ini memisahkan aset yang benar-benar ada di repo dari yang masih ditunggu. Sumber produk, URL, dan status demo: `docs/redesign/reference-inventory.md`.

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

C03 Sans + Script dinyatakan tersedia sebagai produk toko oleh P02. Yang belum ada adalah berkasnya, bukan produknya.

## Gambar preview

- `../previews/` memuat gambar font yang sudah ada di repo. Tidak ada gambar AI atau gambar stock baru.
- Setiap entri `images` pada `font-catalog.js` memuat path lengkap `../previews/<berkas>`. Tidak ada nama berkas tanpa path dan tidak ada path yang dibentuk dari nilai default.
- Gambar yang sudah dipetakan: `bawden-1`, `chronoa-1`, `mango-1..4`, `baldock-1`, `daisy-hotline-1`, `crimson-queen-1`, `mordial-1`, `moyshire-1`, `radiant-summertime-1`, `brush-set-1..3`, `font-bundle-1..2`, `graphic-pack-1..2`.
- `../previews/chronoa-1.jpg` dirender dari berkas Chronoa asli dengan Pillow, bukan artwork hasil generasi.
- Belum dipetakan: gambar produk toko nyata (Tropivera, Dockhand, Wildkins, Solaya, Darkwell, Redline, Distressed Overlays). Produk itu sengaja dibiarkan tanpa gambar alih-alih memakai artwork produk lain. Halaman detail menampilkan keterangan bahwa gambar belum dipetakan.
- Belum dipakai (tersedia bila galeri diperluas): `mango-5.jpg` sampai `mango-9.jpg`.
- Sumber gambar toko 1200x800 dengan rasio 3:2, terukur pada delapan produk (lihat inventory P02). Aturan tampil utuh ada di `product-spec.md`.

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
