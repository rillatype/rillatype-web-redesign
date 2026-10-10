# Rencana eksekusi redesign Rillatype

Tanggal: 10 Oktober 2026. Rencana utama disetujui user dan aktif sejak P01. Revisi setelah audit diminta user pada 10 Oktober 2026.

Rencana memuat 73 task utama dan tujuh koreksi tambahan A01–A07, total 80 kartu. Status terkini ada di PROGRESS.md. Revisi ini hanya perencanaan/dokumentasi; implementasi koreksi membutuhkan penugasan. Persetujuan rencana tidak mencakup production, harga publik, atau penerbitan lisensi draft.

## Baca sesuai tugas

- Semua agent: AGENTS.md, rules.md, bagian aktif PROGRESS.md, lalu dokumen ini.
- Tugas P01–P20: tasks-preview.md dan product-spec.md.
- Koreksi audit A01–A07: tasks-audit-corrections.md. Baca sebelum perubahan tester, penutupan ulang P05/P07/P09/P11, atau melanjutkan P12–P20.
- Tugas W01–W27: tasks-wordpress.md dan product-spec.md.
- Tugas S01–S26: tasks-store-release.md dan spesifikasi yang dirujuk task.
- Ketentuan Graphics: graphics-license-draft.md. Draf ini belum boleh ditampilkan sebagai lisensi resmi.
- Laporan rinci: ../reports/<ID-TUGAS>.md. Format: ../reports/TEMPLATE.md.
- Untuk P06/P08 dan verifikasi C03/C05: baca font-test-handoff.md. Aset Mondriel/Brika sudah tersedia dari user, tetapi integrasi serta bukti runtime belum selesai.

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
| Integrasi serta verifikasi berkas Dingbats C05 | Source Brika sudah tersedia di `Font Test/RT Brika-Dingbats.otf`; rendering/sample belum diuji | P08 lalu P19 mengikuti font-test-handoff.md; bukan lagi blocker file hilang |
| Integrasi Sans + Script dan named styles non-weight | Lima Mondriel tersedia, termasuk Outline dan Outline Slant; face berweight sama perlu dibedakan | P06 lalu P19 mengikuti font-test-handoff.md; named styles lain tetap sesuai bukti masing-masing |
| Staging, akses, runtime, plugin, payment sandbox | Pemeriksaan toko nyata | W01, lalu task transaksi |
| Inventory lengkap, attachment, variasi, taxonomy | Data produksi yang benar | W03 dan dependent task |
| Harga Graphics Extended per produk | Pilihan pembelian Graphics | W22/S23 untuk Graphics |
| Identitas licensor, contact legal, pengguna yang dicakup, wilayah hukum | Kelengkapan lisensi resmi | S17 untuk publikasi lisensi |
| Hak dan mekanisme berkas specimen web | Batas aset publik | W04 dan W19 |
| Provider newsletter serta konfigurasi yang aktif | Subscription nyata | S16 |

Task yang independen boleh dilanjutkan setelah task aktif dibuat TERBLOKIR dan handoff disimpan. Jangan melewati dependensi dengan label SELESAI palsu.

## Koreksi audit sebelum fitur lanjutan

Audit baseline `1e6037e` menemukan empat defect runtime dan satu risiko overwrite fakta dari analisis source. Assertion selalu PASS dan timestamp laporan juga bermasalah. Bukti serta prosedur rinci ada di [buku koreksi audit](tasks-audit-corrections.md).

1. A01 membuang atau mengganti assertion dummy dan membuktikan kontrol negatif.
2. A02 memetakan style indeks nol ke berkas yang benar pada change dan retry.
3. A03 merender sel glyph dengan font serta cut produk aktif.
4. A04 memulihkan cut homepage yang pernah gagal tanpa reload halaman.
5. A05 mereproduksi race parser dan menjaga fakta terbaru sebelum mutasi DOM.
6. A06 menjaga kontrol ketika font default gagal dari context baru.
7. A07 menguji ulang acceptance, menutup ulang P05/P07/P09/P11 jika lulus, dan meluruskan handoff tanpa memalsukan timestamp lama.

Urutan koreksi wajib berantai. P12–P20 menunggu A07 SELESAI. A07 tidak menutup P06/P08 tanpa aset asli. Jangan menjadikan status P yang dibuka ulang sebagai dependensi A karena penutupan ulang P dilakukan di A07. W01–W04 tetap persiapan independen bila ditugaskan dan prasyaratnya selesai; perubahan tema tetap menunggu P20.

## Urutan eksekusi

1. P01–P03: kunci scope, contoh data, dan berkas uji.
2. Untuk kondisi pasca-audit, jalankan A01–A07 sebelum fitur lanjutan. P04–P11 yang dibuka ulang dikoreksi/verifikasi melalui kartu A, kemudian lanjut P12–P18 sesuai dependensi.
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
Untuk koreksi audit, gunakan assertion efektif dan tabel acceptance sesuai rules.md. Test yang mengubah screenshot atau memanggil child suite bukan otomatis read-only. Source analysis yang belum diuji runtime harus diberi label, bukan diklaim FAIL terkonfirmasi.

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

Bukti audit live di atas adalah snapshot historis. Untuk inventaris publik berikutnya gunakan `reference-inventory.md` hasil P02 dan tanggal observasinya. Jika berbeda, catat konflik dan gunakan verifikasi W03 untuk keputusan data toko. Angka harga historis tidak menjadi konstanta atau izin perubahan harga.

## Batas persetujuan

Persetujuan rencana berbeda dari persetujuan acuan visual dan persetujuan rilis.
P01 membutuhkan perintah mulai. P20 membutuhkan review render. S26 membutuhkan approval production dan bukti staging.
User menyukai konsep R05H. Jangan menjalankan ulang pemilihan visual world atau mengganti palette tanpa brief baru.
