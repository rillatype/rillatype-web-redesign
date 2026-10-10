# Rencana eksekusi redesign Rillatype

Tanggal: 10 Oktober 2026. Status: DISETUJUI USER, 10 Oktober 2026. Mode proyek: menunggu pelaksana menjalankan P01.

Dokumen ini menerjemahkan keputusan user menjadi 73 tugas kecil. User sudah menyetujui rencana dan dapat menugaskan agent berikutnya menjalankan P01. Persetujuan rencana tidak mencakup perubahan production, harga publik, atau penerbitan lisensi draft. Approval pada kartu tugas tetap berlaku.

## Baca sesuai tugas

- Semua agent: AGENTS.md, rules.md, bagian aktif PROGRESS.md, lalu dokumen ini.
- Tugas P01–P20: tasks-preview.md dan product-spec.md.
- Tugas W01–W27: tasks-wordpress.md dan product-spec.md.
- Tugas S01–S26: tasks-store-release.md dan spesifikasi yang dirujuk task.
- Ketentuan Graphics: graphics-license-draft.md. Draf ini belum boleh ditampilkan sebagai lisensi resmi.
- Laporan rinci: ../reports/<ID-TUGAS>.md. Format: ../reports/TEMPLATE.md.

Path tanpa root di buku task bersifat relatif terhadap root repo, kecuali dinyatakan sebagai THEME.
THEME selalu berarti rillatype-v2-extracted/rillatype-v2-1/. Jangan mengedit tema root, wp-content, atau backup.

## Keputusan yang sudah disepakati

| Area | Keputusan |
| --- | --- |
| Platform | Tetap WordPress dan WooCommerce |
| Visual | Pertahankan editorial R05H: Manrope, latar terang, tinta gelap, satu aksen biru, artwork asli |
| Homepage | Font utama; Graphics memiliki bagian khusus yang jelas |
| Unggulan | User memilih dan mengurutkan font serta Graphics melalui admin |
| Rilisan terbaru | Gunakan data tanggal produk; daftar unggulan tetap terpisah |
| Font satu style | Tester langsung memakai berkas tersebut; tidak ada dropdown style atau weight yang tidak berguna |
| Font beberapa style | Satu bidang tester dengan nama style asli |
| Family campuran | Sans/Script dan variasi masing-masing tetap dapat dipilih dengan nama yang jelas |
| Weight | Chronoa bukan bentuk standar semua produk; weight hanya untuk cut yang benar-benar tersedia |
| Gambar | Preview font 1200x800 selalu utuh, rasio 3:2, pada semua penempatan dan viewport |
| Graphics | Aset buatan user sendiri; tidak menampilkan tester font pada produk grafis murni |
| Graphics Standard | Branding, promosi, kemasan, dan pekerjaan klien |
| Graphics Extended | Standard ditambah merchandise fisik serta print-on-demand tanpa batas cetak |
| Graphics gratis | Standard gratis; Extended berbayar, harga belum disepakati |
| Klien | Boleh menerima hasil desain akhir; penerimaan aset asli atau penggunaan untuk proyek lain memerlukan lisensi sendiri |
| Blog/newsletter | Blog dapat diakses; newsletter ringkas di footer |
| Bahasa | UI English, nama produk/style asli dipertahankan |
| Agent | Bergantian; satu task implementasi aktif; review baca-saja boleh bersamaan |
| Pelaporan | Setiap mulai, unit perubahan, pemeriksaan, blocker, dan handoff dicatat sesuai rules.md |

## Scope yang dipertahankan

Pertahankan data produk, pesanan, akun, URL, pembayaran, coupon, pajak, dan hak unduhan yang sudah berlaku.
Enam lisensi font yang tersedia tidak diganti dengan dua lisensi Graphics. Style specimen tidak menjadi variasi harga baru.
Freebies tidak berarti semua variasi produk gratis. Harga mengikuti variasi WooCommerce.
Produk gratis tetap melalui alur WooCommerce yang diverifikasi, tanpa tombol download publik buatan baru.
Rencana ini tidak menambah wishlist, membership, loyalty, perubahan platform, payment gateway baru, atau API toko baru.

## Data yang belum boleh ditebak

| Belum tersedia | Pengaruh | Task yang berhenti sampai tersedia |
| --- | --- | --- |
| Persetujuan rencana dan perintah mulai | Aktivasi implementasi | P01 |
| Sampel file Sans + Script dan Regular/Rough/Slanted | Bukti perilaku berkas asli | P03, P06, P19 jika kasus belum tersedia |
| Staging, akses, runtime, plugin, payment sandbox | Pemeriksaan toko nyata | W01, lalu task transaksi |
| Inventory lengkap, attachment, variasi, taxonomy | Data produksi yang benar | W03 dan dependent task |
| Harga Graphics Extended per produk | Pilihan pembelian Graphics | W22/S23 untuk Graphics |
| Identitas licensor, contact legal, pengguna yang dicakup, wilayah hukum | Kelengkapan lisensi resmi | S17 untuk publikasi lisensi |
| Hak dan mekanisme berkas specimen web | Batas aset publik | W04 dan W19 |
| Provider newsletter serta konfigurasi yang aktif | Subscription nyata | S16 |

Task yang independen boleh dilanjutkan setelah task aktif dibuat TERBLOKIR dan handoff disimpan. Jangan melewati dependensi dengan label SELESAI palsu.

## Urutan eksekusi

1. P01–P03: kunci scope, contoh data, dan berkas uji.
2. P04–P18: sesuaikan prototype dengan semua jenis produk dan aturan gambar.
3. P19: buktikan prototype pada seluruh kasus yang diwajibkan.
4. P20: user meninjau homepage, produk font, produk Graphics, dan family campuran.
5. W01–W07: staging, inventory, metadata, serta kontrol admin.
6. W08–W17: fondasi visual dan homepage dari data asli.
7. W18–W21: detail produk dan tester. W27 menyiapkan data Graphics pada staging sebelum W22–W23 menghubungkan lisensi serta native add-to-cart.
8. W24–W26: katalog, pencarian, Freebies, serta navigasi lisensi.
9. S01–S13: cart, checkout, pembayaran sandbox, akun, email, serta unduhan.
10. S14–S18: blog, newsletter, halaman pendukung, dan 404.
11. S19–S23: responsive, accessibility, performance, SEO, serta regresi toko.
12. S24–S26: paket, verifikasi instalasi, persetujuan rilis, serta rollback.

Urutan kartu memberi default pengerjaan. Dependensi tertulis menentukan kesiapan task, termasuk W27 yang sengaja dikerjakan sebelum W22. W01–W04 adalah persiapan staging/data; perubahan tema menunggu approval P20. Satu task dikerjakan sampai hasil dan laporannya bisa diperiksa sebelum memilih task berikutnya.

## Hubungan dengan tracker lama

R05H tetap tercatat sebagai prototype yang sudah diperiksa, bukan implementasi WordPress selesai.
P02–P19 adalah tindak lanjut R03/R05/R06 untuk model produk yang lebih beragam. P20 memenuhi review acuan R07.
W01–W04 melengkapi blocker R02 dan audit data. W05–W17 mencakup fondasi R08/R09. W18–W23 mencakup R10/R11/R12. W24–W26 mencakup R13/R14/R15.
S01–S13 mencakup R16–R19. S14–S18 mencakup R20. S19–S23 mencakup R21–R23. S24–S26 mencakup R24/R25.
Setelah rencana disetujui, buat tabel 73 microtask P/W/S pada PROGRESS.md. W27 adalah task data Graphics tambahan untuk R11. Jangan menutup task R lama sampai semua microtask yang terkait dan kriteria R tersebut selesai.

## Format kartu dan pelaksanaan

Setiap kartu mencantumkan dependensi, file yang dibaca/diubah, langkah, dan bukti selesai.
Global check untuk perubahan source: git diff --check; syntax check sesuai bahasa jika runtime tersedia; pemeriksaan perilaku spesifik pada kartu.
Tulis command yang benar-benar dijalankan dan hasil aktual di laporan. Tidak tersedia runtime bukan PASS.
Untuk bug, reproduksi sebelum memperbaiki. Tambahkan pemeriksaan perilaku kecil yang gagal sebelum perbaikan dan lulus setelahnya.
Untuk perubahan layout kecil, gunakan render nyata dan ukuran computed; tidak perlu unit test yang menyalin deklarasi CSS.
Gunakan test suite repo yang masih sesuai UI. Jika selector sudah historis, sesuaikan test dengan requirement, bukan agar hasil terlihat lulus.

## Bukti audit yang menjadi dasar

Audit live 10 Oktober 2026 membaca halaman publik berikut tanpa transaksi:

- https://rillatype.com/ : navigasi, unggulan, Freebies, recent products, blog, newsletter.
- https://rillatype.com/product/mango-letters-handwritten-font/ : satu specimen dan enam pilihan lisensi.
- https://rillatype.com/product/tropivera/ : Decorative, Regular, Dingbats.
- https://rillatype.com/product/solaya-a-dual-style-tropical-font-bonus-illustrations/ : Raw, Neat, bonus AI/EPS/SVG.
- https://rillatype.com/product/darkwell-family/ : dua font dengan Regular/Italic/Bold masing-masing.
- https://rillatype.com/product/distressed-overlays-vol-01-grunge-texture-pack/ : PNG dalam ZIP; tanpa selector lisensi, tetapi tabel metadata memuat enam label lisensi font.
- https://rillatype.com/product/redline-syndicate-display-font/ : data variasi saat audit Standard 0, Extended 150, Webfont/E-Pub 50, App/Game 100, Broadcast 1000, Corporate 1500. Harga ini bukti kasus, bukan konstanta aplikasi.
- https://rillatype.com/license/ : ketentuan enam lisensi font yang dipublikasikan.

Audit repo menetapkan enqueues nyata di THEME/functions.php, tester di THEME/assets/js/product.js, dan markup di THEME/woocommerce/content-single-product.php. Stub font-tester.js/font-tester.php kosong dan bukan tempat implementasi yang aktif.

## Batas persetujuan

Persetujuan rencana berbeda dari persetujuan acuan visual dan persetujuan rilis.
P01 membutuhkan perintah mulai. P20 membutuhkan review render. S26 membutuhkan approval production dan bukti staging.
User menyukai konsep R05H. Jangan menjalankan ulang pemilihan visual world atau mengganti palette tanpa brief baru.
