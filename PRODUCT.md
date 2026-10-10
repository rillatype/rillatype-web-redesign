# Produk Rillatype

<!-- impeccable:product-schema 1 -->

## Platform

web

## Pengguna

Pengguna utama adalah desainer dan pemilik brand yang mencari font untuk proyek desain.
Pengunjung perlu menemukan font yang sesuai, mencoba teks, memahami lisensi, dan membeli file digital.

## Tujuan produk

Rillatype menjual font melalui toko WordPress dan WooCommerce.
Prioritas redesign adalah memudahkan penemuan font dan pengujian font sebelum pembelian.
Keberhasilan alur berarti pembeli bisa memilih lisensi, membayar, dan mengakses unduhan yang sesuai dengan pesanan.

## Konteks penggunaan

Pengunjung dapat membuka toko melalui desktop atau browser mobile.
Admin mengelola produk serta pesanan melalui WordPress dan WooCommerce.
Repo berisi tema PHP dan beberapa prototype HTML statis. Prototype tidak menjalankan transaksi WooCommerce.
Sumber pengembangan tema ditetapkan dalam `docs/redesign-audit.md`.

## Kemampuan dan batasan

Revisi perencanaan 10 Oktober 2026: font tetap menjadi fokus utama dan Graphics memiliki bagian jelas. Produk dapat mempunyai satu style, style bernama, Sans + Script, beberapa weight, bonus grafis, atau berupa Graphic murni. Style tester terpisah dari variasi lisensi pembelian. Semua preview font 1200x800 tampil utuh pada rasio 3:2. UI English, unggulan dipilih/diurutkan admin, blog tetap diakses, newsletter ringkas di footer. User menyetujui rencana rinci; pelaksana berikutnya mulai dari P01. Graphics license draft masih membutuhkan kelengkapan legal/harga sebelum publikasi.

- Pertahankan WordPress dan WooCommerce sebagai platform akhir.
- Sediakan homepage, katalog, pencarian, halaman produk, cart, checkout, serta akun.
- Katalog memuat preview, nama, kategori, dan harga. Tester lengkap berada di halaman produk.
- Pembeli memilih lisensi sebelum menambahkan produk ke cart.
- Sediakan checkout tamu dan opsi membuat akun saat checkout.
- Akun memberi akses ke riwayat pembelian serta unduhan milik pelanggan.
- Checkout tamu tetap memerlukan konfirmasi email dan tautan unduhan sesuai status pesanan.
- Pengaitan pembelian tamu lama ke akun baru belum disepakati atau diuji.
- Model produk nyata, harga, ketentuan lisensi, serta gateway aktif perlu diverifikasi pada staging.
- Pertahankan bahasa konten yang tersedia. Bahasa UI akhir masih terbuka.

## Komitmen brand

Pertahankan nama Rillatype, aset logo, serta warna asli gambar preview produk.
User mengizinkan satu warna aksen. Setelah kembali menolak keseluruhan R05C, user meminta desain baru.
Arah R05H memakai editorial berani, identitas Manrope besar, specimen produk asli pada bidang biru, serta indeks font asimetris. User memilih arah editorial berani pada 10 Oktober 2026; hasil visual masih perlu ditinjau pada R07.
Animasi tetap ringan. Kemudahan penggunaan dan beban halaman tetap menjadi prioritas.
Jangan menambahkan klaim tentang pelanggan, ulasan, penjualan, lisensi, atau manfaat yang belum terbukti.

## Bukti yang tersedia

- `static/previews/` berisi gambar produk dan satu file OTF Mango.
- Sumber tema memiliki pemilihan variasi produk sebagai lisensi dan metabox font preview native.
- Changelog mencatat perbaikan checkout dan thank-you yang perlu diuji kembali setelah redesign.
- `REDESIGN-PLAN.md` menyimpan brief dan tugas yang disetujui user.
- Data produk staging, email sandbox, dan bukti pembayaran belum tersedia.

## Prinsip produk

- Bantu pengunjung menemukan dan mencoba font sebelum menampilkan promosi.
- Beri harga serta ringkasan lisensi di dekat tindakan pembelian.
- Jadikan akun pilihan yang bermanfaat, bukan hambatan awal pembelian.
- Buat konten dan kontrol dapat digunakan segera tanpa menunggu animasi.
- Jaga beban halaman dengan aset yang sesuai ukuran dan script yang diperlukan saja.

## Alur pengunjung

1. Pengunjung membuka homepage dan memakai pencarian atau masuk ke katalog.
2. Pengunjung memilih kategori atau urutan produk, kemudian membuka detail font.
3. Pengunjung melihat preview dan mencoba teks pada font tester.
4. Pengunjung memilih lisensi serta memeriksa harga dan ringkasan penggunaan.
5. Pengunjung menambahkan produk ke cart dan memeriksa pesanan.
6. Pengunjung checkout sebagai tamu, membuat akun, atau login ke akun yang sudah ada.
7. WooCommerce memproses pembayaran melalui gateway yang dikonfigurasi.
8. Pengunjung menerima konfirmasi dan akses unduhan sesuai status pembayaran.
9. Pelanggan berakun dapat kembali ke halaman riwayat dan unduhan.

Navigasi utama memberi akses ke katalog, freebies, pencarian, akun, dan cart.
Route asli yang ditemukan meliputi `/shop/`, `/product-category/freebies/`, `/license/`, dan `/contact/`.
Gunakan URL halaman WooCommerce dari konfigurasi runtime untuk akun, cart, dan checkout, bukan asumsi slug tetap.
