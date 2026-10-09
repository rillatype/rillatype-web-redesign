# Audit awal tema Rillatype

Tanggal: 9 Oktober 2026. Tugas: R01.

## Sumber kerja

Gunakan `rillatype-v2-extracted/rillatype-v2-1/` sebagai sumber tema untuk redesign.
Folder ini memiliki changelog terperinci dan perbaikan checkout terakhir dalam riwayat Git.
Commit `d16ee3c` mengubah `functions.php` dan menambahkan partial `woocommerce/checkout/thankyou.php` di folder ini.
Commit `4c15b32` mencatat hasil sesi checkout dalam changelog folder yang sama.

`wp-content/themes/rillatype-v2/` adalah salinan berbeda, bukan mirror yang selalu tersinkron.
Salinan ini memiliki checkout dequeue awal, tetapi tidak memiliki semua perubahan pada commit `d16ee3c`.
Salinan ini juga memiliki homepage yang berbeda dari hasil ekstraksi.
File PHP di root adalah salinan lama. `functions.php` root hanya memiliki 175 baris dan belum memiliki metabox tester terbaru.

Keputusan ini memilih sumber pengembangan repo. Tema aktif di hosting tetap perlu diverifikasi melalui staging.
Jangan menghapus salinan lama atau menyinkronkannya selama membuat preview.

## Peta file yang terkait

Path berikut relatif terhadap sumber kerja.

| Area | File atau direktori | Fakta yang diperiksa |
| --- | --- | --- |
| Fondasi | `style.css`, `functions.php` | CSS gabungan. Assets dimuat melalui functions.php. |
| Header dan footer | `header.php`, `footer.php` | Navigasi, search, cart, akun, dan link `/license/`. |
| Homepage | `front-page.php`, `inc/customizer.php` | Versi hasil ekstraksi berbeda dari salinan wp-content. |
| Katalog | `woocommerce/archive-product.php`, `woocommerce/content-product.php`, `woocommerce/loop/` | Override arsip, kartu, sort, dan pagination. |
| Produk | `woocommerce/content-single-product.php`, `assets/js/product.js` | Gallery, pilihan variasi sebagai lisensi, tester, dan sticky bar. |
| Tester admin | `functions.php`, `assets/js/admin-product.js` | Metabox Product Preview memakai metadata `_font_data_*` dan attachment WordPress. |
| Checkout | `functions.php`, `woocommerce/checkout/thankyou.php` | Dequeue checkout script dan partial thank-you terbaru. |
| Akun | `woocommerce/myaccount/` | Template login, dashboard, pesanan, alamat, dan detail order. |

Dalam salinan wp-content, `functions.php` hanya memuat `inc/customizer.php` secara eksplisit.
File `inc/acf-setup.php`, `inc/performance.php`, dan `inc/schema-functions.php` yang tersedia di salinan tersebut tidak membuktikan modul aktif.
Tester terbaru sudah memakai metabox WordPress native. ACF tidak boleh dianggap syarat utama tanpa pemeriksaan runtime.

## Regresi yang harus diuji

- Changelog mencatat rekursi akibat `the_content()` atau header/footer di override yang dipanggil dari shortcode WooCommerce.
- Partial thank-you harus tetap berupa partial. Jangan memanggil halaman checkout kembali dari partial.
- Checkout AJAX dinonaktifkan untuk mengatasi proses yang hang. Kompatibilitas gateway perlu diuji sebelum merombak mekanismenya.
- Script hasil ekstraksi menghapus class checkout dan memakai `form.submit()`. Periksa validasi serta field submit saat R17 dan R18.
- `assets/js/product.js` memakai iframe dan timeout 1,5 detik untuk menampilkan pesan sukses add-to-cart.
  Timeout tersebut bukan bukti server menerima cart. R11 harus memeriksa hasil server, bukan hanya toast.
- Pemilihan lisensi berasal dari variasi WooCommerce. Deskripsi lisensi hardcoded dalam template perlu dicocokkan dengan ketentuan asli.
- Fallback tester bisa memakai file produk downloadable. R12 harus memastikan hanya specimen yang boleh tersedia publik dipakai untuk preview.
- Filter checkout menghapus alamat dan shipping. R17 perlu memeriksa kebutuhan pajak serta gateway yang benar-benar aktif.
- Klaim lifetime updates dan batas penggunaan dalam UI lama belum diverifikasi sebagai kebijakan bisnis.

## Aset preview yang tersedia

`static/previews/` memiliki gambar Baldock, Bawden, Crimson Queen, Daisy Hotline, Mango, Mordial, Moyshire, dan Radiant Summertime.
Mango memiliki sembilan gambar preview dan `mango-letter.otf`.
Gunakan aset yang ada untuk acuan visual. Harga serta aturan lisensi di preview tetap data contoh sampai diverifikasi.

## Packaging

`create-zip.ps1` masih menunjuk `D:\Hermes Project\Web Redesign Rillatype`, bukan lokasi workspace sekarang.
Script membaca seluruh file memakai StreamReader dan menulis memakai StreamWriter. Proses ini tidak aman untuk gambar atau font biner.
Script juga belum membuat folder tema sebagai root arsip.

Pada R25, ubah packaging agar memakai sumber resmi relatif terhadap lokasi script dan menyalin byte asli.
ZIP harus memiliki satu folder tema dengan `style.css`, `functions.php`, template, dan assets lengkap.
Kecualikan konfigurasi editor, konfigurasi agent, dependency lokal, dan `.vscode/sftp.json` dari paket tema.
Bandingkan hash aset sumber dengan hasil ekstraksi ZIP sebelum menyatakan paket siap.
Audit ini tidak menjalankan script ZIP lama dan tidak mengganti paket lama.

## Lingkungan yang ditemukan

- Node tersedia, versi `v24.19.0`.
- `server.js` menyediakan preview statis pada port `9402`.
- Perintah `php --version` gagal karena PHP tidak tersedia pada PATH.
- Pencarian konfigurasi WordPress lokal tidak menemukan `wp-config.php`, compose, atau `.wp-env.json`.
- URL dan akses staging belum diberikan. Pemeriksaan transaksi, email, dan data produk belum dilakukan.

## Hasil pemeriksaan

Audit membaca functions.php pada tiga lokasi, riwayat lima commit terbaru, changelog, script packaging, dan template terkait.
Perbandingan direktori juga menemukan dependency tooling dalam folder ekstraksi, sehingga diff rekursif seluruh folder menghasilkan banyak noise.
Gunakan perbandingan file tema spesifik untuk pekerjaan berikutnya.
R01 selesai sebagai audit sumber repo. R02 tetap memerlukan staging dan baseline yang valid.
