# Buku tugas preview

Status: rencana aktif sejak P01. Revisi audit 10 Oktober 2026 menambah A01–A07 di tasks-audit-corrections.md. Baca execution-plan.md, product-spec.md, rules.md, status terkini, dan laporan task sebelum bekerja.
Setiap task membutuhkan laporan docs/reports/<ID>.md dan update PROGRESS.md sebelum/selama/setelah kerja. Global check source: git diff --check dan syntax/perilaku yang relevan.
P01–P20 adalah satu fase. P20 belum selesai hanya karena task sebelumnya lulus pemeriksaan agent.

Koreksi audit mendahului fitur P12–P20. P05/P07/P09/P11 dibuka ulang dalam PROGRESS.md. Gunakan A02–A06 untuk fix dan A07 untuk penutupan ulang, bukan mengulang seluruh kartu P lama. P06/P08 tetap menunggu aset asli. Hasil PASS historis tidak menutup temuan audit.

## P01. Aktifkan rencana yang disetujui

Dependensi: persetujuan rencana dan perintah mulai dari user. File: AGENTS.md, PROGRESS.md, REDESIGN-PLAN.md, laporan P01.
Langkah: baca semua pointer; verifikasi rencana yang user setujui; catat approval; ubah mode AGENTS.md menjadi IMPLEMENTASI SESUAI TUGAS; buat tabel status P01–P20/W01–W27/S01–S26 di PROGRESS.md dengan link kartu. Ambil ID dan judul dari heading ketiga buku tugas; tidak perlu menjalankan isi fase lain. Pertahankan riwayat R lama.
Selesai: 73 ID unik tersedia, hanya P01 BERJALAN selama aktivasi, dependensi valid, mode dan approval konsisten. Catat blockers dari plan. Tidak ada file website berubah. Setelah laporan lengkap, tutup P01 dan berhenti dengan next action P02.

## P02. Simpan inventaris referensi yang benar

Dependensi: P01. Baca: audit live dalam execution-plan.md, docs/redesign-audit.md, static/redesign/ASSETS.md. Edit: docs/redesign/reference-inventory.md baru dan laporan.
Langkah: catat URL/permalink, nama, kategori, style yang terlihat, bonus, harga/status yang terlihat, serta asal gambar. Pisahkan observasi publik dari data yang menunggu staging. Daftarkan contoh C01–C12. Tandai contoh brush lama sebagai demo, bukan produk nyata yang terkonfirmasi.
Selesai: setiap klaim punya URL/file dan tanggal observasi; C03 Sans + Script boleh TIDAK TERSEDIA dengan kebutuhan file yang jelas. Tidak ada transaksi, harga baru, atau klaim format yang dibuat-buat.

## P03. Siapkan data contoh dan daftar aset uji

Dependensi: P02. Baca: product-spec.md, static/redesign/font-catalog.js, tester-core.js, fonts/, ASSETS.md. Edit: font-catalog.js, ASSETS.md, dan fixture test yang relevan.
Langkah: tambahkan kind dan daftar style bernama pada data prototype; pisahkan field style dari opsi lisensi; petakan gambar yang memang tersedia; tandai harga Demo. Catat berkas kasus C02/C03/C05 yang belum ada, tanpa mengganti fontnya dengan font UI.
Selesai: C01/C04 dan state unavailable memakai aset nyata; minimum fixture punya stable product keys, URL, kind, image, dan styles. Style tidak memiliki harga pembelian tersendiri. Pemeriksaan data mendeteksi URL/gambar/label duplikat yang keliru.

## P04. Rapikan tester font satu style

Dependensi: P03. Baca/edit: static/redesign/product.html, product-preview.js, editorial.css; baca tester-core.js.
Langkah: pilih default dari satu style valid; tampilkan tester tanpa dropdown/weight controls; pertahankan size/leading/tracking/alignment/theme. Pakai nama produk yang benar.
Selesai: C01 memuat berkas asli; input teks literal; tidak ada selector kosong atau synthetic bold/italic. Uji input, clear/retype, dan mobile. Catat source font yang benar-benar dimuat.

## P05. Hubungkan style bernama

Dependensi: P04. File: product-preview.js, product.html, editorial.css, data fixture P03.
Langkah: tampilkan selector hanya bila style valid lebih dari satu; label memakai nama asli; setiap pilihan menunjuk file sendiri. Pertahankan seluruh state input ketika pilihan berubah.
Selesai: Regular/Rough/Slanted atau contoh bernama lain memilih file yang benar, bukan CSS filter/skew. Uji round-trip style dan input kosong. Jika berkas asli belum ada, hasil UI fixture dicatat terpisah dari verifikasi font nyata.
Tambahan acceptance audit: style value `0` tetap memilih cut pertama yang valid. Buktikan URL berkas loader, face loaded, selector, status, dan weight sesuai cut itu pada change serta retry. Uji font default gagal sebelum pernah sukses; kontrol tetap tersedia untuk memilih cut sehat. Prosedur rinci A02/A06, penutupan ulang di A07.

## P06. Periksa family Sans + Script

Dependensi: P05 dan berkas C03 user yang terverifikasi. File: font-catalog.js, product-preview.js, test fixture; markup/CSS hanya jika label tidak terbaca.
Langkah: petakan pilihan seperti Sans Regular dan Script Regular dengan file masing-masing; pilih urutan default sesuai data; uji seluruh pilihan.
Selesai: typeface yang berbeda benar-benar tampil, input tidak tertimpa, metadata tidak diwariskan dari style sebelumnya. Jika C03 belum ada, status TERBLOKIR dan tulis nama/file yang dibutuhkan; jangan menutup dengan font pengganti.

## P07. Batasi kontrol weight pada produk yang relevan

Dependensi: P05. File: font-catalog.js, preview.js, product-preview.js, product.html dan style yang relevan.
Langkah: gunakan label/file Chronoa yang tersedia; beri satu mekanisme pemilihan yang konsisten; tampilkan kontrol weight hanya pada daftar weight nyata. Font biasa tetap memakai nama style.
Selesai: Chronoa dapat mencoba cut asli; Mango tidak mendapat kontrol weight; Rough/Script tidak diberi angka weight buatan. Default sesuai data, bukan respons download tercepat.
Tambahan acceptance audit: memilih Thin harus memuat cut Thin, bukan memakai status/fakta SemiBold sambil hanya mengubah CSS weight 100. Gunakan bukti A02 dan verifikasi ulang A07. Mango tetap tanpa weight controls.

## P08. Periksa glyph, OpenType, dan Dingbats

Dependensi: P05/P07; bukti Dingbats nyata diperlukan untuk menutup C05. File: tester-core.js, product-preview.js, product.html; data yang relevan.
Langkah: baca glyph/feature dari file aktif; refresh saat style berubah; tampilkan unavailable jika parser atau file tidak mendukung; untuk Dingbats gunakan karakter yang benar-benar tersedia.
Selesai: glyph count dan switch sesuai file, glyph panel dapat dibuka/ditutup, fitur unsupported tidak bisa diaktifkan. Jangan menambah parser kompleks hanya untuk menyembunyikan unsupported state; catat batas parser dan kebutuhan nyata.
Tambahan acceptance audit: ukur family/weight/style pada sel glyph dan face loaded, bukan hanya count. Respons parser style lama tidak boleh mengubah glyph atau switch pilihan terbaru. Prosedur A03/A05. Klaim parsial glyph/OpenType untuk Chronoa/Mango baru diperbarui setelah verifikasi; C05 tetap TERBLOKIR tanpa berkas.

## P09. Buktikan state pemuatan tester

Dependensi: P04/P05/P07. File: preview.js, product-preview.js, scripts/check-specimen-states.py dan test produk relevan.
Langkah: reproduksi clear/retype, abort file, retry, pergantian cepat, dan respons lama; pertahankan teks; pastikan hasil request terbaru menang.
Selesai: test kasus tersebut lulus pada tester homepage dan produk yang memakai perilaku itu. Berkas gagal tidak menampilkan font UI sebagai specimen produk. Catat FAIL sebelum fix jika menemukan regresi.
Tambahan acceptance audit: coba ulang cut homepage yang benar-benar gagal setelah jaringan pulih, dengan request baru dan state ready tanpa reload. Uji cold-default failure produk dan race parser terhadap jumlah/family glyph serta supported state fitur. Prosedur A04/A05/A06, penutupan ulang di A07. Beralih ke cut sehat atau mengassert weight saja tidak cukup.

## P10. Terapkan artwork utuh pada seluruh preview

Dependensi: P03. File: static/redesign/home.css, editorial.css, style.css, index.html, catalog.html, product.html; JS gallery hanya jika diperlukan.
Langkah: inventaris semua penempatan gambar; terapkan 3:2 untuk font 1200x800; gunakan contain/height auto; hilangkan crop/zoom pemotong; pastikan lightbox utuh.
Selesai: C12 lulus pada 320/390/768/1280/1440/1600px. Keempat tepi dan lettering terlihat. Grafik dengan dimensi lain mempertahankan rasio asli. Catat actual image URL dan ukuran render.

## P11. Generalisasi specimen homepage

Dependensi: P04/P05/P07/P09/P10. File: index.html, home.css, preview.js, data fixture.
Langkah: pertahankan masthead/field biru R05H; pilih font unggulan dari data contoh yang nanti berasal dari admin; bangun pilihan style sesuai produk; sembunyikan weight saat tidak relevan.
Selesai: homepage tidak bergantung pada Chronoa atau jumlah 9 weight. Penggantian featured ke font satu style tetap bekerja. Desain tidak berubah menjadi visual world baru.
Tambahan acceptance audit: gunakan suite homepage-data yang sudah dibersihkan A01. Verifikasi ulang featured default, font satu style, data sintetis, state error, dan retry setelah dependensi tester pulih. Ini revalidasi di A07, bukan izin mengganti visual world.

## P12. Tambahkan bagian Graphics yang layak

Dependensi: A07/P02/P03/P10/P11. File: index.html, home.css, fixture catalog, ASSETS.md.
Langkah: pilih ilustrasi/texture pack nyata sesuai referensi; tampilkan artwork utuh, nama, kind, harga Demo, dan route detail yang tepat; letakkan setelah fokus font; sediakan View graphics.
Selesai: bagian dapat ditemukan di desktop/mobile, tidak memakai lingkaran placeholder sebagai artwork asli, tidak menuju font lain, dan tidak menampilkan type tester pada entri Graphic. Tidak perlu memuat semua produk grafis pada homepage.

## P13. Rapikan detail font dan gallery

Dependensi: P04/P05/P07/P10. File: product.html, product-preview.js, editorial.css.
Langkah: susun nama, gambar utuh, deskripsi, informasi style/format yang terbukti, tester, kemudian pembelian. Gallery mengikuti urutan asli.
Selesai: font satu/multi-style memiliki hierarki sama tetapi kontrol berbeda sesuai data. Informasi format pembelian tidak disimpulkan dari WOFF2 specimen. Tidak ada headline menutupi lettering artwork.

## P14. Buat detail Graphic murni

Dependensi: P03/P10/P13. File: product.html, product-preview.js, editorial.css, font-catalog.js yang kini memuat produk campuran.
Langkah: tampilkan gallery, isi/format/compatibility yang terverifikasi, instruksi penggunaan bila ada, dan area pembelian. Gunakan kind eksplisit untuk tidak merender tester/glyph/FAQ font.
Selesai: C06 mempunyai detail benar dan route sendiri. Font C08 tanpa specimen tetap diperlakukan sebagai font, bukan Graphic. Unknown slug mempunyai error yang jelas, tidak fallback diam-diam ke Bawden.

## P15. Tampilkan font dengan bonus Graphic

Dependensi: P13/P14. File: data fixture, product.html, product-preview.js, editorial.css.
Langkah: representasikan contoh Solaya sebagai satu produk dengan styles dan bonus; tampilkan bonus dari data/deskripsi; pertahankan satu pilihan lisensi dan satu purchase action sesuai model produk.
Selesai: C07 tidak membuat SKU atau harga terpisah untuk bonus. Tester hanya mencoba file font. Artwork bonus dan informasi isi tetap utuh dan sesuai bukti.

## P16. Sesuaikan preview lisensi font

Dependensi: P13/P15. File: product.html, product-preview.js, font-catalog.js.
Langkah: gunakan enam label font yang terverifikasi bila tersedia pada contoh; pisahkan pilihan dari style tester; tampilkan harga Demo dan ringkasan yang sesuai; state belum dipilih harus jelas.
Selesai: ganti style tidak mengubah lisensi/harga. Ganti lisensi mengubah harga contoh, bukan font aktif. Tidak memakai ringkasan Standard/Extended lama yang mengarang cakupan.

## P17. Preview pilihan Graphics Standard/Extended

Dependensi: P14/P15 dan user menerima arah draf Graphics. File: product.html, product-preview.js, fixture; baca graphics-license-draft.md.
Langkah: Graphic murni memakai dua pilihan yang dibedakan dari font; tunjukkan Standard free pada contoh gratis; Extended belum dihargai secara nyata jika user belum mengisi harga.
Selesai: prototype jelas berlabel Demo/not purchasable. Tidak menebak harga Extended, tidak menerbitkan lisensi draft sebagai terms resmi, dan tidak mengganti enam opsi font.

## P18. Periksa katalog dan harga Freebies

Dependensi: P12/P14/P16/P17. File: catalog.html, preview.js, style.css/editorial.css dan data fixture.
Langkah: sediakan jalur Fonts, Graphics, dan Freebies; pertahankan search/reset/count; tampilkan label harga awal atau lisensi gratis pada variable freebie; seluruh item mempunyai route benar.
Selesai: C10 tidak dipromosikan sebagai gratis untuk seluruh lisensi; C06 tidak membuka Bawden. Filter tanpa hasil menjelaskan nol hasil dan bisa direset. Browser back mempertahankan state yang didukung.

## P19. Jalankan pemeriksaan acuan lengkap

Dependensi: A07/P06/P08/P09/P10/P11/P12/P13/P14/P15/P16/P17/P18. File: scripts/check-specimen-home.py, check-specimen-states.py, check-redesign-preview.py atau suite penggantinya; bukti sementara mengikuti rules.md.
Langkah: petakan C01–C12 ke pemeriksaan; jalankan desktop/mobile dan ukuran gambar wajib; inspect screenshot yang benar-benar dimuat; perbaiki temuan material satu batch lalu konfirmasi.
Selesai: semua kasus wajib mempunyai hasil PASS atau task tetap TERBLOKIR. Tidak menganggap transaksi nyata diuji lewat HTML statis. Console/error/fokus/long text/cold font error dan gambar utuh diperiksa. Tulis batas pemeriksaan.
Petakan juga skenario koreksi A02–A06 ke test dan artefak runtime. Catat assertion efektif, negative control, exit BLOCKED, source yang disajikan, dan batas pemeriksaan. Suite yang selalu PASS atau test yang hanya mengukur computed weight tidak cukup untuk menutup bukti font/fakta.

## P20. Dapatkan persetujuan acuan

Dependensi: P19. File: laporan P20, PROGRESS.md, DESIGN.md dan sidecar bila ada perubahan sistem yang harus dicatat.
Langkah: tampilkan homepage, font satu style, named/mixed styles, Graphic, serta font+bonus; minta user menilai hasil; catat persetujuan atau revisi spesifik; sinkronkan dokumen dari hasil yang dibangun.
Selesai: user menyetujui render acuan, bukan hanya ide. Jika revisi dibutuhkan, task MENUNGGU USER/BERJALAN dan langkah perbaikan jelas. WordPress baru dimulai setelah P20 dan prasyarat staging siap.
