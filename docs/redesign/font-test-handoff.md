# Handoff aset Mondriel dan Brika

User menyediakan lokasi berkas pada 10 Oktober 2026. File dan metadata diperiksa dengan fontTools 4.59.0. Dokumen ini melengkapi kartu P06/P08, bukan izin implementasi atau distribusi production. Status task hanya ada di PROGRESS.md.

## Sumber asli dan fakta terukur

Root workspace: `D:\Project\Web Redesign Rillatype`. Gunakan path relatif di bawah untuk pembacaan. Pertahankan source asli pada `Font Test/`; jangan rename atau overwrite file user.

| Produk/style | File relatif | Glyph font | Codepoint cmap | Feature tag GSUB |
| --- | --- | --- | --- | --- |
| Mondriel Regular | `Font Test/Mondriel-Font-Duo/Fonts/RT Mondriel-Regular.otf` | 195 | 194 | Tidak ada |
| Mondriel Slant | `Font Test/Mondriel-Font-Duo/Fonts/RT Mondriel-Slant.otf` | 195 | 194 | Tidak ada |
| Mondriel Outline | `Font Test/Mondriel-Font-Duo/Fonts/RT Mondriel-Outline.otf` | 195 | 194 | Tidak ada |
| Mondriel Outline Slant | `Font Test/Mondriel-Font-Duo/Fonts/RT Mondriel-Outline Slant.otf` | 195 | 194 | Tidak ada |
| Mondriel Handwritten | `Font Test/Mondriel-Font-Duo/Fonts/RT Mondriel-Handwritten.otf` | 219 | 187 | `liga`, `dlig` |
| Brika Dingbats | `Font Test/RT Brika-Dingbats.otf` | 234 | 233 | Tidak ada |

Kelima Mondriel memakai internal family `RT Mondriel` dan weight 400. OS/2 italic flag semuanya false, termasuk Slant. Slant adalah berkas tersendiri; flag itu bukan alasan memakai CSS italic/skew. Feature tag yang tercatat bukan bukti substitusi visual sudah diuji. Codepoint termasuk karakter kontrol/space dan tidak berarti semua glyph berupa ikon.

## P06 menggunakan Mondriel, bukan menunggu Dockhand

Prasyarat: P05 selesai dan penugasan P06 dari user. Berkas C03 sudah tersedia. Jangan mengambil P06 otomatis hanya karena dokumen ini ditulis.

Scope tambahan yang diizinkan saat P06 ditugaskan: `static/redesign/font-catalog.js`, `product-preview.js`, `static/redesign/fonts/` untuk salinan lokal lima OTF, `scripts/check-tester-mixed-family.py`, test styles/glyph/fact-races yang perlu disesuaikan, `ASSETS.md`, reference-inventory.md untuk bukti aset, laporan P06, dan PROGRESS.md. Markup/CSS hanya jika label atau state tidak terbaca. Tidak mengubah tema WordPress.

1. Claim P06 dan tulis kondisi awal/laporan sebelum edit. Baca source tester aktif dan test mixed-family yang sekarang masih mengacu Dockhand.
2. Periksa ulang keenam path pada tabel dan hash source. Salin hanya lima Mondriel ke lokasi specimen lokal yang dicatat pada data. Verifikasi hash source/salinan sama. Jangan mempublikasikan berkas lewat production; W04/W19 tetap memverifikasi hak dan strategi web specimen.
3. Tambahkan fixture produk Mondriel dengan stable key dan lima stable style ID. Jangan menimpa produk demo bernama mirip `mordial`. URL toko harus diverifikasi atau referensi yang belum terverifikasi ditandai jujur, bukan ditebak. Fixture tester tidak membutuhkan harga/galeri baru; harga tetap Demo dan gambar unavailable bila belum ada.
4. Urutan fixture lokal: Regular, Slant, Outline, Outline Slant, Handwritten. Default Regular. Ini keputusan fixture untuk test, bukan klaim urutan metadata/admin production.
5. Gunakan label style tersebut secara jelas. Outline dan Outline Slant ikut diuji, bukan dihapus karena bukan bagian nama Duo. Tidak ada weight picker 100–900 karena lima style sama-sama 400.
6. Berikan identitas FontFace unik per style ID, atau pemetaan descriptor yang benar-benar membedakan lima face. Menambahkan lima FontFace ke family yang sama dengan descriptor weight/style sama tidak cukup. Sample dan grid glyph harus memakai identitas face aktif yang sama. Hindari hardcode Mondriel dalam loader generik.
7. Baseline test identitas harus menolak kondisi ketika semua style mengarah ke satu file/face. Buktikan setiap pilihan meminta URL OTF miliknya, face loaded, selector/status cocok, dan bentuk Regular versus Handwritten serta Regular versus Outline berbeda pada render nyata. Screenshot harus dibaca, bukan hanya dibuat.
8. Uji round-trip seluruh lima style, khususnya indeks 0. Pertahankan teks literal, size, leading, tracking, align, theme, dan lisensi. Clear/retype tidak mengubah style. Abort Outline Slant, pulihkan, dan retry file itu tanpa reload.
9. Baca glyph/features dari file aktif. Regular/Slant/Outline/Outline Slant memiliki 194 codepoint, Handwritten 187. UI boleh memfilter kontrol yang tidak terlihat, tetapi jumlah terfilter harus diberi label dan dijelaskan. Handwritten memiliki tag liga/dlig, empat style lain tidak. Uji fitur didukung dan disabled dengan hasil nyata, serta race Handwritten lambat setelah Regular terbaru ready. Fakta lama tidak boleh diwariskan.
10. Perluas `check-tester-mixed-family.py` agar C03 memakai Mondriel dan seluruh lima berkas, bukan syarat dua Dockhand. State Dockhand tanpa aset masih boleh diuji sebagai unavailable terpisah. Exit 3 hanya bila prasyarat yang benar-benar diperlukan belum ada.
11. Jalankan test mixed-family, styles, glyph-facts, load-states, fact-races, single-style, homepage-data, dan syntax/diff check. Uji 1440px/390px, buka/tutup glyph, font error, keyboard, serta overflow.
12. Tutup P06 hanya bila lima face dan bentuk berbeda terbukti, fakta aktif benar, kontrol tidak menyimpang, serta laporan/ASSETS/tracker terbarui. Jika parser tidak mendukung, tulis batas dan blocker yang spesifik; jangan mengklaim file user hilang.

## P08 menggunakan RT Brika Dingbats

Prasyarat: P05/P07 selesai dan penugasan P08. P08 tidak bergantung P06 pada kartu; default pengerjaan bergantian disarankan P06 lalu P08. Jangan mulai keduanya bersamaan.

Scope tambahan saat P08 ditugaskan: data fixture `static/redesign/font-catalog.js`, `static/redesign/fonts/` untuk salinan Brika Dingbats, tester-core.js hanya bila bug parser terbukti, product-preview.js/product.html untuk state/sample yang diperlukan, `scripts/check-glyph-facts.py` atau `scripts/check-tester-dingbats.py` baru, ASSETS.md, reference-inventory.md untuk bukti aset, laporan P08, dan PROGRESS.md.

1. Claim/laporan sebelum edit. Salin Brika ke specimen lokal dan buktikan hash identik. Jangan mengubah source user atau memperlakukan file Dingbats sebagai paket Brika lengkap.
2. Tambahkan fixture dengan style ID Dingbats dan berkas aslinya. Berkas Brika Sans/Script, isi bonus, harga, gallery, dan SKU belum diberikan; jangan mengarangnya. Data lokal harus menjelaskan batas itu.
3. Baca cmap/glyph outlines. Pilih karakter dengan outline berisi dari cmap aktual. Pisahkan space/kontrol/glyph kosong dari ikon yang terlihat. Jangan menyatakan 233 codepoint adalah 233 ikon.
4. Tampilkan grid memakai face Brika loaded. Buka dan baca render glyph aktual pada desktop/mobile. Catat contoh codepoint dan ikon yang terlihat. Sample awal memakai karakter ikon terverifikasi, bukan alphabet default yang diasumsikan bermakna.
5. Periksa raw glyph count 234 dan raw cmap count 233. Jika parser/UI memfilter kontrol, laporkan jumlah yang ditampilkan beserta aturan filternya. Jangan mengubah expected ke 233 hanya untuk membuat PASS.
6. Feature GSUB tidak ada pada file ini. Kontrol liga/dlig/salt harus disabled dengan keterangan; input pengunjung tetap literal. Grid bisa buka/tutup, tanpa overflow atau sel Manrope sebagai pengganti.
7. Uji gagal cold load, input saat error, retry berkas yang sama setelah jaringan pulih, dan preservasi text/size/leading/tracking/theme/alignment. Semua ini tetap satu style tanpa selector/weight palsu.
8. Buat negative control yang mengganti face produk dengan font UI atau menghapus berkas; test harus gagal pada identitas/glyph atau menyatakan error yang benar. Jalankan regresi glyph, styles, load-states, fact-races, single-style, serta syntax/diff check.
9. Tutup bagian C05/P08 hanya dengan bukti glyph asli Brika, fitur unavailable benar, state error/retry lulus, dan laporan terbarui. Berkas tersedia saja bukan status SELESAI.

## Handoff pelaksana

Setelah user menugaskan P06, kerjakan P06 saja dan berhenti dengan laporan. Kandidat selanjutnya P08 atau P13 sesuai penugasan. P19 masih menunggu seluruh acceptance kasus; P20 serta fase WordPress/production tetap membutuhkan approval/prasyarat asli.
