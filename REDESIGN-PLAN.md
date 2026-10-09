# Rencana redesign Rillatype

Tanggal kesepakatan: 9 Oktober 2026.

## Gunakan rencana ini

Kerjakan tugas di bawah satu per satu. Periksa kriteria selesai sebelum melanjutkan.
Lihat status setiap tugas di `PROGRESS.md`. Ikuti `docs/agents/redesign-rules.md` untuk pencatatan dan GitHub.
Rencana ini menggantikan arah visual dalam `PLAN.md` untuk pekerjaan baru.

## Brief yang disepakati

- Rombak homepage, katalog, halaman produk, cart, checkout, dan akun.
- Layani desainer dan pemilik brand yang ingin menemukan, mencoba, dan membeli font.
- Tetap gunakan WordPress dan WooCommerce.
- Arah visual aktif sejak revisi R05B adalah playful foundry, dengan lettering font Rillatype dan satu aksen coral. Navigasi tetap mudah dipahami.
- Revisi 9 Oktober 2026: user menilai preview awal terlalu sederhana. Pertahankan minimalisme, tetapi perkuat komposisi, skala tipografi, dan dominasi preview unggulan.
- Gunakan latar terang, teks gelap, serta coral khas Rillatype sebagai satu aksen UI. Preview font tetap berwarna.
- Homepage berisi pembukaan singkat, font pilihan, rilisan terbaru, penjelasan lisensi singkat, dan footer.
- Buat pencarian serta akses katalog mudah ditemukan. Sediakan akses freebies melalui navigasi.
- Katalog menampilkan preview, nama font, kategori, dan harga. Tester lengkap berada di halaman produk.
- Pilihan lisensi berada di halaman produk sebelum tombol tambah ke cart.
- Tampilkan harga dan ringkasan penggunaan lisensi dekat tombol beli.
- Sediakan checkout tamu dengan opsi membuat akun untuk riwayat dan unduhan.
- Gunakan animasi ringan untuk feedback dan perubahan state. Konten utama langsung terlihat.
- Setujui homepage dan halaman produk sebagai acuan sebelum mendesain halaman lainnya.

## Keputusan yang masih perlu bukti atau konfirmasi

- Tema kerja yang menjadi sumber resmi. Repo memiliki file tema di root, `wp-content/themes/rillatype-v2/`, dan folder hasil ekstraksi.
- Ketersediaan WordPress staging beserta versi WordPress, WooCommerce, PHP, dan plugin aktif.
- Model lisensi serta sumber harga asli. Jangan membuat jenis lisensi baru berdasarkan asumsi.
- Aset font dan hak pemakaiannya untuk tester web.
- Bahasa UI akhir. Pertahankan bahasa konten yang ada selama belum ada keputusan baru.
- Pengaitan pesanan tamu lama ke akun baru. Jangan menjanjikan pengaitan otomatis sebelum alurnya teruji.
- Metode pembayaran sandbox dan konfigurasi email staging.

## Batas pekerjaan

Prioritasnya adalah redesign dan alur toko yang sudah disepakati.
Migrasi platform, penggantian payment gateway, dark mode, loyalty, wishlist, dan fitur baru lain memerlukan persetujuan terpisah.
Jaga URL, konten faktual, produk, pesanan, akun, dan metadata penting saat mengganti tampilannya.

## Fase 0. Siapkan pekerjaan

### R00. Tulis rencana dan aturan

- Simpan brief, tugas, dependensi, kriteria selesai, dan aturan update progress.
- Hubungkan dokumen aktif dari `AGENTS.md` dan beri penunjuk pada rencana historis.
- Simpan persiapan ke GitHub.
- Selesai jika dokumen konsisten, progress awal tersedia, dan push terverifikasi.

### R01. Audit sumber tema dan perilaku yang ada

Dependensi: R00.

- Bandingkan tiga lokasi tema, riwayat Git, file build, dan panduan pemasangan.
- Tentukan satu lokasi edit dan cara menghasilkan paket tema. Hindari mengedit semua salinan secara terpisah.
- Petakan template, stylesheet, script, WooCommerce hooks, ACF, dan aset produk yang benar-benar digunakan.
- Periksa log checkout terbaru. Identifikasi perbaikan yang harus dipertahankan dan override yang berisiko regresi.
- Selesai jika lokasi resmi, daftar file terkait, dan alur packaging tercatat dalam log R01.

### R02. Siapkan lingkungan pemeriksaan

Dependensi: R01.

- Siapkan command preview lokal dan akses WordPress staging.
- Catat versi runtime serta plugin yang memengaruhi toko.
- Pilih produk nyata untuk menguji lisensi, tester, cart, dan unduhan.
- Ambil baseline homepage, produk, dan checkout pada desktop serta mobile.
- Ukur baseline halaman dengan konfigurasi alat yang dicatat. Catat error console dan request gagal.
- Selesai jika preview dapat dibuka dan staging tersedia untuk transaksi sandbox.
- Jika staging belum tersedia, catat blocker. R03 sampai R06 dapat memakai preview lokal, tetapi R02 belum selesai.

## Fase 1. Bentuk acuan desain

### R03. Catat produk dan alur pengunjung

Dependensi: R01.

- Tulis `PRODUCT.md` berisi audiens, tujuan, kemampuan, batasan, dan fakta produk yang terkonfirmasi.
- Petakan alur pencarian, detail produk, pilihan lisensi, cart, checkout, akun, dan unduhan.
- Tentukan isi navigasi serta jalur freebies menggunakan route yang ada.
- Selesai jika alur utama memiliki tujuan dan langkah yang jelas tanpa klaim bisnis baru.

### R04. Tetapkan sistem visual ringan

Dependensi: R03.

- Tulis `DESIGN.md` sesuai alur skill desain.
- Tetapkan token warna, font UI, ukuran teks, spacing, lebar konten, batas radius, fokus, dan state interaksi.
- Gunakan tampilan monokrom terang. Preview produk menjadi sumber warna dan karakter.
- Tetapkan durasi transisi singkat, reduced motion, dan perilaku mobile.
- Pastikan kebutuhan font UI tidak menambah banyak weight atau request eksternal.
- Selesai jika token konsisten dan contoh komponen dasar dapat diperiksa di desktop serta mobile.

### R05. Buat preview homepage baru

Dependensi: R04.

- Buat pembukaan ringkas dengan akses pencarian dan katalog sejak area awal.
- Susun font pilihan, rilisan terbaru, informasi lisensi singkat, serta footer.
- Gunakan gambar produk yang tersedia dan tandai data contoh bila diperlukan.
- Hindari section dekoratif yang tidak membantu pengunjung memilih font.
- Periksa link preview, header mobile, fokus keyboard, dan rasio gambar.
- Selesai jika seluruh homepage terlihat dan dapat digunakan di desktop serta mobile tanpa overflow.

### R06. Buat preview halaman produk baru

Dependensi: R04 dan R05C.

- Susun gallery, nama font, ringkasan, harga, pilihan lisensi, dan tombol tambah ke cart.
- Sediakan tester teks, ukuran, dan style yang memang dimiliki produk.
- Jelaskan format file, informasi font, cakupan lisensi, serta cara mendapatkan bantuan.
- Buat state lisensi belum dipilih, font tidak tersedia, teks panjang, dan font gagal dimuat.
- Selesai jika alur mencoba font dan memilih lisensi dapat diperiksa pada desktop serta mobile.

### R05A. Perkuat karakter homepage setelah feedback

Dependensi: R05.

- Jadikan satu preview font unggulan sebagai fokus visual sejak area awal halaman.
- Beri pembukaan kontras skala dan ritme yang lebih tegas tanpa menambah section pemasaran.
- Bedakan susunan font pilihan dari daftar rilisan terbaru.
- Pertahankan pencarian, filter, konten terlihat langsung, monokrom, dan motion ringan.
- Periksa desktop, tablet, mobile, filter yang menyembunyikan font unggulan, serta reduced motion.
- Selesai jika preview revisi tersedia, pemeriksaan lulus, dan hasil tercatat untuk tinjauan user pada R07.

### R05B. Ganti arah ke playful foundry

Dependensi: R05A.

- User menolak dua versi katalog karena terlalu umum. Ganti komposisi, bukan memperbesar grid lama lagi.
- Gunakan font Mango asli sebagai specimen lettering, logo asli, serta satu aksen coral dari brand yang sudah ada.
- Tampilkan halaman seperti ruang specimen studio dengan sample huruf, karya penggunaan font, dan koleksi yang berbeda skala.
- Pertahankan fungsi pencarian dan filter. Jangan mengarang harga, kebijakan lisensi, atau customer proof.
- Periksa font nyata, pergantian sample, keyboard, layout sempit, serta fallback tanpa font.
- Selesai jika preview arah baru tersedia dan hasil pemeriksaan dicatat. Persetujuan visual tetap milik user.

### R05C. Rapikan hierarki toko dan pencarian setelah feedback keseluruhan

Dependensi: R05B.

- User menilai keseluruhan UI dan UX belum bagus, terutama posisi Find a font.
- Jadikan pencarian bagian header yang terlihat sebelum hero pada desktop dan mobile.
- Susun pembukaan agar membantu memilih font, bukan terasa seperti poster dekoratif.
- Pertahankan lettering Mango dan aksen coral yang disepakati, dengan informasi produk lebih mudah dipindai.
- Letakkan jumlah hasil di area yang tetap terlihat untuk semua filter, termasuk hasil kosong.
- Pastikan tautan ke Mango menampilkan hasil tersebut meski filter sebelumnya menyembunyikannya.
- Periksa pencarian header, menu mobile, filter, jumlah hasil, dan navigasi ke font.
- Selesai jika preview revisi dan bukti pemeriksaan tersedia. Penilaian visual tetap memerlukan feedback user.

### R07. Minta persetujuan acuan desain

Dependensi: R05 dan R06.

- Tampilkan kedua preview kepada user dengan link atau screenshot.
- Minta feedback tentang hierarki, kepadatan, navigasi, tester, dan pilihan lisensi.
- Catat revisi sebagai unit perubahan dan periksa ulang bagian yang berubah.
- Selesai hanya setelah user menyetujui homepage dan halaman produk sebagai acuan.

## Fase 2. Terapkan ke WordPress

### R08. Terapkan fondasi, header, dan footer

Dependensi: R02 dan R07.

- Terapkan token dan komponen bersama pada lokasi tema resmi.
- Hubungkan logo, navigasi, pencarian, freebies, akun, dan cart ke route WordPress yang benar.
- Pastikan menu mobile dapat dibuka, ditutup, dan digunakan dengan keyboard.
- Muat stylesheet serta script sesuai kebutuhan halaman. Hapus aturan visual lama yang sudah digantikan.
- Selesai jika shell toko bekerja pada staging dan tidak memuat dua sistem styling yang saling bertentangan.

### R09. Hubungkan homepage ke data asli

Dependensi: R08.

- Gunakan query atau konfigurasi homepage yang sudah tersedia setelah audit R01.
- Tampilkan produk pilihan, rilisan terbaru, harga, gambar, dan permalink asli.
- Beri state yang jelas jika produk tidak tersedia. Pertahankan urutan yang bisa dikelola pemilik toko.
- Selesai jika perubahan data di admin tercermin di homepage tanpa mengedit HTML.

### R10. Terapkan layout dan data halaman produk

Dependensi: R08.

- Terapkan gallery dan informasi produk sesuai preview yang disetujui.
- Gunakan data WooCommerce serta field yang sudah tersedia.
- Periksa produk sederhana dan tipe produk lain yang benar-benar digunakan toko.
- Selesai jika informasi, gambar, harga, dan permalink berasal dari produk yang sedang dibuka.

### R11. Hubungkan lisensi dan cart

Dependensi: R10.

- Petakan lisensi ke model produk, variasi, atau mekanisme yang terkonfirmasi pada R01.
- Tampilkan ringkasan lisensi dan harga berdasarkan pilihan pembeli.
- Validasi pilihan di server. Pastikan cart menyimpan produk, lisensi, dan harga yang benar.
- Beri error yang dapat dipahami untuk pilihan tidak valid atau add-to-cart gagal.
- Selesai jika setiap lisensi nyata yang diuji menghasilkan item cart dan total yang sesuai.

### R12. Hubungkan font tester nyata

Dependensi: R10.

- Gunakan file specimen web yang tersedia atau buat subset sesuai izin penggunaan font.
- Muat font produk saat tester dibutuhkan. Jangan mengunduh semua font katalog di awal.
- Hubungkan input teks, ukuran, dan style tanpa request jaringan pada setiap ketikan.
- Periksa teks panjang, karakter yang didukung, style kosong, serta kegagalan font.
- Selesai jika tester benar-benar menampilkan font produk dan tetap dapat digunakan saat salah satu aset gagal.

## Fase 3. Selesaikan penemuan font

### R13. Terapkan katalog dan kategori

Dependensi: R09, R10, dan R11.

- Tampilkan preview, nama, kategori, serta harga dari query WooCommerce.
- Pertahankan pagination dan navigasi kategori. Hindari memuat semua produk sekaligus.
- Pastikan tindakan pembelian tidak melewati pilihan lisensi yang wajib.
- Selesai jika kategori dan halaman berikutnya menghasilkan produk yang benar serta tidak menduplikasi item.

### R14. Terapkan pencarian dan filter

Dependensi: R13.

- Gunakan kemampuan WordPress dan WooCommerce yang ada untuk pencarian font.
- Sediakan filter kategori dan urutan yang membantu menemukan produk.
- Pertahankan query pada navigasi hasil dan tampilkan jumlah hasil yang benar.
- Sediakan state tanpa hasil dengan cara menghapus filter atau mencari ulang.
- Selesai jika pencarian, filter, pagination, dan tombol kembali browser memberikan hasil yang konsisten.

### R15. Hubungkan freebies dan informasi lisensi

Dependensi: R14.

- Hubungkan akses freebies ke kategori atau halaman yang benar.
- Gunakan aturan lisensi asli dan tautkan bantuan atau custom license yang tersedia.
- Periksa jalur memperoleh produk gratis sesuai mekanisme toko yang terkonfirmasi.
- Selesai jika pengunjung dapat menemukan freebies dan memahami batas penggunaannya.

## Fase 4. Selesaikan pembelian dan akun

### R16. Rombak cart

Dependensi: R11 dan R13.

- Tampilkan produk, lisensi, harga, subtotal, total, dan tindakan lanjut checkout.
- Pertahankan update item, penghapusan, coupon, serta perhitungan WooCommerce yang memang digunakan.
- Periksa cart kosong dan kegagalan pembaruan.
- Selesai jika UI dan total tetap sesuai setelah item ditambah, diubah, atau dihapus.

### R17. Rombak checkout dan opsi akun

Dependensi: R16.

- Tampilkan form yang dibutuhkan untuk produk digital tanpa menghapus field wajib pajak atau gateway.
- Aktifkan checkout tamu serta opsi membuat akun sesuai kemampuan WooCommerce.
- Jelaskan manfaat akun tanpa memaksa registrasi.
- Periksa login pelanggan lama, email terdaftar, validasi field, dan preservasi input setelah error.
- Selesai jika tamu, pelanggan baru dengan akun, serta pelanggan lama bisa menyelesaikan alur sandbox.

### R18. Periksa pembayaran, konfirmasi, dan email

Dependensi: R17.

- Gunakan gateway sandbox yang tersedia. Jangan mengganti gateway produksi tanpa persetujuan.
- Periksa pembayaran berhasil, gagal, dan dibatalkan serta cegah submit berulang saat pemrosesan.
- Pastikan thank-you, status order, email, dan akses unduhan sesuai status pembayaran.
- Periksa ulang regresi checkout dan thank-you yang ditemukan pada R01.
- Selesai jika bukti order sandbox, konfirmasi, dan email tercatat tanpa transaksi produksi.

### R19. Rombak akun dan unduhan

Dependensi: R18.

- Terapkan login, registrasi, reset password, riwayat, detail pesanan, serta unduhan.
- Periksa dashboard tanpa pesanan, tautan kedaluwarsa, dan akun yang tidak memiliki akses ke file.
- Jelaskan bahwa checkout tamu tetap mengirim email. Periksa pengaitan pesanan lama sebelum menawarkan fitur tersebut.
- Selesai jika pelanggan dapat mengakses pesanan dan unduhan miliknya tanpa mengakses milik akun lain.

## Fase 5. Periksa kualitas dan siapkan rilis

### R20. Periksa halaman pendukung

Dependensi: R15 dan R19.

- Terapkan fondasi visual pada halaman konten, pencarian kosong, dan 404 yang ada.
- Pertahankan tautan contact, privacy, terms, serta konten legal asli.
- Selesai jika halaman pendukung konsisten dan navigasi tidak menghasilkan link mati.

### R21. Periksa mobile dan aksesibilitas

Dependensi: R20.

- Periksa homepage, katalog, produk, cart, checkout, dan akun pada mobile serta desktop.
- Periksa viewport sempit, zoom teks, fokus, label, error form, dan penggunaan keyboard.
- Periksa menu, gallery, filter, tester, serta reduced motion.
- Selesai jika tidak ada overflow, kontrol terpotong, atau hambatan pada alur utama yang ditemukan dalam pemeriksaan.

### R22. Ukur dan perbaiki performa

Dependensi: R21.

- Bandingkan staging dengan baseline R02 memakai konfigurasi alat yang sama.
- Periksa ukuran gambar, font UI, script per halaman, font tester, dan request pihak ketiga.
- Gunakan dimensi gambar tetap, lazy loading di bawah area awal, serta caching sesuai perilaku toko.
- Targetkan LCP paling lama 2,5 detik, CLS paling tinggi 0,1, dan INP paling lama 200 milidetik pada data yang tersedia.
- Bedakan hasil lab dan data pengguna nyata. Gunakan TBT sebagai diagnosis lab, bukan bukti INP lapangan.
- Catat URL, kondisi jaringan, perangkat, versi alat, dan hasil. Angka target bukan klaim hasil yang sudah dicapai.
- Selesai jika tidak ada masalah performa yang belum ditangani atau dijelaskan sebagai blocker terukur.

### R23. Periksa SEO dan regresi toko

Dependensi: R22.

- Periksa title, description, canonical, heading, alt, metadata sosial, dan schema yang sudah digunakan.
- Pertahankan URL penting. Buat redirect hanya jika perubahan route telah disetujui.
- Ulangi alur menemukan font sampai mengunduh setelah pembayaran sandbox.
- Periksa error PHP, console, request aset gagal, dan perilaku saat JavaScript tidak tersedia.
- Selesai jika alur utama lulus dan tidak ada error penghambat yang diketahui.

### R24. Tinjau hasil bersama user

Dependensi: R23.

- Berikan preview staging dan ringkasan perubahan yang terlihat oleh pengunjung.
- Sajikan hasil pemeriksaan serta batasan yang masih nyata.
- Catat revisi user sebagai tugas teridentifikasi sebelum mengerjakannya.
- Selesai jika user menerima hasil atau daftar revisi yang disepakati telah selesai dan diperiksa.

### R25. Siapkan paket dan handoff

Dependensi: R24.

- Buat paket tema dari lokasi resmi dan pastikan asetnya lengkap.
- Dokumentasikan cara memasang, pengaturan wajib, lokasi backup, serta cara kembali ke versi sebelumnya.
- Perbarui progress dengan hasil pemeriksaan, status GitHub, dan pekerjaan yang masih membutuhkan akses produksi.
- Minta persetujuan sebelum aktivasi production. Penyelesaian paket tidak berarti website live telah diperbarui.
- Selesai jika paket dan panduan tersedia di GitHub serta user memahami status staging dan production.

## Titik persetujuan

1. R07 menyetujui homepage dan halaman produk sebelum integrasi visual ke seluruh toko.
2. R24 menyetujui hasil staging setelah pemeriksaan.
3. Aktivasi production memerlukan persetujuan terpisah setelah R25.

## Langkah berikutnya

Mulai R01 setelah dokumen persiapan tersimpan ke GitHub. Jangan mulai mengganti UI sebelum audit sumber tema selesai.
