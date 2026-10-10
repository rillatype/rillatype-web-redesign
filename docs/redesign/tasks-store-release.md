# Buku tugas toko dan rilis

Status: DRAFT. THEME = rillatype-v2-extracted/rillatype-v2-1/. Baca rules.md, execution-plan.md, product-spec.md, dan laporan task.
Gunakan staging, akun uji, email sandbox, dan gateway sandbox yang terkonfirmasi. HTML statis tidak membuktikan order, email, login, atau unduhan.
Setiap task melaporkan command/langkah, hasil aktual, bukti, pekerjaan tersisa, dan next action di laporan sendiri serta PROGRESS.md.

## S01. Terapkan tampilan cart

Dependensi: W23/W26. File: THEME/woocommerce/cart/cart.php, style.css, hooks aktif bila markup membutuhkan data.
Langkah: ambil line item native Woo; tampilkan nama, gambar utuh, atribut lisensi, quantity, harga, subtotal, total; pertahankan checkout URL runtime; sediakan cart kosong.
Selesai: font dan Graphic terbaca sebagai item yang benar; variasi sama/berbeda tidak tercampur. Total berasal dari Woo, termasuk item nol dan sale. Tidak membuat perhitungan total JS pengganti server.

## S02. Periksa update dan penghapusan cart

Dependensi: S01. File: cart.php, script cart aktif, style.css, handler native yang memang diperlukan.
Langkah: pertahankan nonce dan tombol/form Woo; ubah quantity, hapus satu item, undo bila native tersedia; uji refresh serta request gagal.
Selesai: item/total sesuai setelah setiap operasi; kegagalan tidak menyatakan sukses. Quantity mengikuti batas produk nyata. Tidak menghilangkan lisensi atau cart session ketika layout diperbarui.

## S03. Periksa coupon dan total

Dependensi: S02/W02. File: cart/checkout template aktif dan style.css; konfigurasi coupon hanya pada staging yang diizinkan.
Langkah: uji coupon yang benar-benar aktif beserta limitnya; uji invalid/expired/not applicable; periksa discount/tax/total dari server; jaga input setelah error.
Selesai: perilaku sama dengan aturan toko, bukan angka yang dikarang. WELCOME35 yang terlihat publik tidak otomatis diaktifkan kembali bila runtime menyatakan tidak berlaku. Catat hasil beserta coupon test tanpa data pelanggan.

## S04. Terapkan struktur checkout

Dependensi: S01/S02/S03/W02. File: THEME/woocommerce/checkout/form-checkout.php, style.css; baca functions.php dan catatan regresi audit.
Langkah: susun field yang diperlukan, ringkasan item/lisensi/total, notices, payment area, dan submit; pertahankan required fields Woo/tax/gateway; ubah presentasi sebelum mengubah mekanisme submit.
Selesai: checkout dapat dibaca desktop/mobile, focus order masuk akal, order fields penting tetap dikirim. Jangan menghapus nonce, terms, gateway, atau submit field karena produk digital.

## S05. Periksa checkout tamu dan akun opsional

Dependensi: S04. File: checkout template/style; Woo settings pada staging dengan izin.
Langkah: verifikasi guest checkout; tampilkan pilihan membuat akun dan manfaat riwayat/download; uji tamu tanpa akun serta pelanggan baru dengan akun; jaga field sesuai Woo.
Selesai: keduanya menyelesaikan sandbox order. Pembuatan akun bukan syarat pembelian jika konfigurasi yang disepakati mengizinkan tamu. Jangan menjanjikan order tamu lama otomatis terkait akun baru.

## S06. Periksa pelanggan yang sudah punya akun

Dependensi: S05. File: checkout login section, THEME/woocommerce/myaccount/form-login.php, style.css.
Langkah: uji login sebelum checkout, cart session setelah login, prefilling yang dibenarkan Woo, email yang sudah terdaftar, serta kembali ke checkout.
Selesai: cart/lisensi tetap sama setelah login; error tidak menghapus checkout input. Akun uji lain tidak melihat data pelanggan pertama. Jangan membangun authentication baru.

## S07. Periksa validasi checkout dan retry

Dependensi: S04/S05/S06. File: checkout template, functions.php/handler aktif bila bug direproduksi, style.css.
Langkah: uji required field kosong, email invalid, lisensi/variation tidak valid, dan request gagal; reproduksi sebelum edit; perbaiki di batas yang bertanggung jawab.
Selesai: server menolak data invalid, error menjelaskan pemulihan, input tetap tersedia, dan retry tidak membuat duplicate order yang tidak terkendali. Catat failure sebelum fix dan bukti setelah fix.

## S08. Periksa gateway sandbox

Dependensi: S07/W01/W02. File: source checkout yang benar-benar relevan; baca functions.php dequeue dan form.submit lama sebelum edit.
Langkah: gunakan metode sandbox yang aktif; uji success, decline/cancel, pending jika gateway mendukung; cocokkan status order dan payment result. Bila baseline gagal, catat diagnosis terpisah sebelum perubahan mekanisme.
Selesai: order states sesuai gateway; tombol/redirect tidak dianggap bukti pembayaran. Jangan blanket-enable semua checkout JS atau mengganti gateway untuk melewati bug. Tidak ada pembayaran nyata.

## S09. Periksa thank-you dan status order

Dependensi: S08. File: THEME/woocommerce/checkout/thankyou.php, style.css, caller checkout aktif bila diperlukan.
Langkah: tampilkan order reference, status, item/lisensi/total, dan next action yang benar; jaga partial sebagai partial; uji link order dengan key/user yang valid dan invalid.
Selesai: tidak ada rekursi header/footer/the_content; pending tidak disebut paid; order milik akun lain tidak terekspos. Download hanya tersedia sesuai permission/status Woo.

## S10. Periksa email konfirmasi sandbox

Dependensi: S08/S09/W01. File: config email staging dan override email yang sudah ada bila ternyata relevan; jangan membuat template baru tanpa kebutuhan.
Langkah: tangkap email customer/admin uji; cocokkan order/lisensi/total/link; uji link konfirmasi dan download sesuai flow toko.
Selesai: email benar-benar tertangkap dan link yang diperlukan bekerja. Halaman thank-you bukan bukti email terkirim. Credential/provider tetap di runtime, bukan repo.

## S11. Terapkan akun dan riwayat order

Dependensi: S06/S09. File: THEME/woocommerce/myaccount/dashboard.php, orders.php, view-order.php, style.css.
Langkah: gunakan endpoints Woo; tampilkan riwayat/status/detail sesuai akun; periksa order kosong dan akun dengan beberapa lisensi; jaga URL runtime.
Selesai: user hanya melihat order sendiri, pagination riwayat benar, dan layout bukan data dummy. Admin bypass tidak dianggap bukti pelanggan biasa.

## S12. Periksa izin unduhan

Dependensi: S09/S10/S11/W04/W27. File: THEME/woocommerce/myaccount/my-downloads.php atau endpoint override aktif; hook download bila memang dibutuhkan.
Langkah: uji akun A, akun B, tamu dengan link yang sah, key invalid/expired, order pending/refunded sesuai settings, dan order uji lama sebelum setup Graphics. Pertahankan Woo permission handler.
Selesai: pemilik berhak mendapat file yang benar dan pengguna lain ditolak. Font preview publik tidak membuka ZIP produk. Perubahan model Graphics tidak memutus unduhan pembelian lama.

## S13. Periksa reset password

Dependensi: S11/S10. File: form-login.php dan template reset yang tersedia/aktif, style.css.
Langkah: gunakan native Woo/WP; uji request, email sandbox, valid token, invalid token, dan sukses login setelah reset pada akun uji.
Selesai: tidak ada reset mechanism custom, token tidak dicatat ke laporan publik, serta error dan success dapat dibaca desktop/mobile.

## S14. Terapkan index blog

Dependensi: W08/W10/W12. File: THEME/index.php, archive.php, style.css; verifikasi hierarchy active sebelum edit.
Langkah: tampilkan post data/permalink/date/pagination asli; tambah akses blog melalui footer; homepage tetap fokus produk sesuai keputusan user.
Selesai: halaman berikutnya benar dan post lama tetap dapat diakses. Judul duplikat atau copy draft seperti Judul:/Meta Description ditandai untuk review konten, tidak dihapus massal oleh redesign.

## S15. Terapkan artikel blog

Dependensi: S14. File: THEME/singular.php/single.php bila benar-benar ada, comments.php, style.css; baca hierarchy runtime.
Langkah: gunakan content asli dengan measure/hierarchy yang mudah dibaca; gambar utuh; pertahankan links/comments yang aktif; periksa long title/list/table.
Selesai: article tidak terpotong, heading/content semantik benar, dan URL/post content tidak ditulis ulang tanpa scope konten tersendiri. Tidak membuat single.php hanya karena namanya umum jika caller aktif sudah mencukupi.

## S16. Hubungkan newsletter footer

Dependensi: W12/W02 dan provider/form existing yang terverifikasi. File: THEME/footer.php, style.css, integration existing atau form konfigurasi staging.
Langkah: reuse provider/shortcode/form saat ini; label email, submit feedback, error, serta privacy link yang memang berlaku; kirim hanya alamat email uji yang diizinkan.
Selesai: subscription terkonfirmasi oleh provider atau sandbox. Form HTML yang menampilkan success palsu tidak lulus. Jika provider belum tersedia, TERBLOKIR dan jangan membuat integration/API baru.

## S17. Terapkan halaman lisensi dan kontak

Dependensi: W26/W22/W27; approval terms Graphics, identitas legal, effective/version, dan authorized-user scope diperlukan untuk publikasi. File: THEME/page.php/page template aktif, style.css, halaman staging yang terkait dengan izin.
Langkah: pertahankan font terms yang masih berlaku; tampilkan Graphics terms final yang disetujui, terpisah dari font; hilangkan placeholders; hubungkan contact-us asli; periksa version evidence untuk pembelian baru melalui mekanisme yang disepakati.
Selesai: tidak ada placeholder/draf sebagai terms resmi; ringkasan produk sesuai terms penuh; ketentuan order lama tidak diganti diam-diam. Jika perlu metadata order version baru, scope/test preservation ditulis sebelum hook dibuat.

## S18. Terapkan 404 dan route tidak valid

Dependensi: W25/W12. File: THEME/404.php, style.css; route/query handling aktif bila ada bug yang direproduksi.
Langkah: sediakan penjelasan, search, dan link katalog/home; uji URL produk yang tidak ada, filter invalid, serta page out of range; pastikan HTTP status yang semestinya.
Selesai: URL salah tidak menampilkan produk lain atau blank page. Back/navigation bekerja. Tidak mengubah slug produk yang sah untuk menghindari 404.

## S19. Periksa responsive seluruh toko

Dependensi: W26/S01–S18 selesai atau blocker yang disetujui user tidak menyentuh halaman yang diuji. File: style.css dan template yang menunjukkan defect; bukti screenshot sementara.
Langkah: periksa homepage, catalog, font/Graphic/mixed product, cart, checkout, account, blog, dan support pada 320/390/768/1280/1440/1600px; gunakan konten panjang; audit semua currentSrc dan rasio artwork.
Selesai: tidak ada horizontal overflow, konten/tombol penting tidak tersembunyi, dan preview 1200x800 utuh. Setiap defect dicatat, diperbaiki pada file terkait, lalu dikonfirmasi tanpa membuka polish tanpa batas.

## S20. Periksa keyboard dan accessibility

Dependensi: S19. File: template/script/style dengan temuan nyata.
Langkah: jalankan alur dengan keyboard; periksa skip/menu/focus/error labels/live status/radio/select/gallery/lightbox; uji reduced motion dan kontras actual colors.
Selesai: task utama selesai tanpa mouse, focus terlihat/tidak tertutup, modal mengembalikan fokus, field required/error dikaitkan benar. Defect nyata diperbaiki. False positive detector diberi evidence dan pengecualian paling sempit menurut skill, bukan ignore global.

## S21. Bandingkan performance terhadap baseline

Dependensi: S19/S20/W02. File: enqueue/assets/templates yang terbukti menyebabkan masalah; dokumentasi pengukuran.
Langkah: pakai alat, viewport, kondisi cache/network yang sama; catat image sizes/fonts/requests/layout shift; perbaiki sumber biaya nyata seperti semua cut dimuat sekaligus atau original image terlalu besar pada thumbnail.
Selesai: angka dapat diulang dan dijelaskan; asset sizing tetap tanpa crop. Jangan menjanjikan skor 100 atau mengklaim speedup dari run yang kondisinya berbeda. Tidak menambah cache plugin tanpa kebutuhan/izin.

## S22. Periksa SEO dan route preservation

Dependensi: W25/S14/S15/S17/S18/W02. File: THEME/header.php, template metadata aktif, plugin settings staging bila relevan.
Langkah: audit titles/canonical/description/structured product data/pagination; pertahankan URLs/cats; periksa sumber metadata agar theme tidak menduplikasi plugin SEO; cocokkan prices/availability/schema dengan Woo.
Selesai: metadata tidak mengarang review/stock/price, category canonical tepat, dan produk/blog lama tetap menuju halaman benar. Redirect baru hanya untuk perubahan URL yang memang disetujui.

## S23. Jalankan regresi transaksi lengkap

Dependensi: S01–S13/S17/S19/S20/S21/S22. File: test/checklist aktual, laporan, bukti staging.
Langkah: jalankan C01–C11 yang relevan melalui product → license → cart → checkout → order → email → download; cover tamu/akun baru/akun lama, free/paid/sale, invalid data, dan pending/failed gateway yang tersedia.
Selesai: order item/variation/license/total/download permission benar untuk setiap case. Laporkan case satu per satu. Missing access/file/price adalah blocker, bukan PASS dari prototype.

## S24. Perbaiki packaging biner

Dependensi: S23 dan source final yang diverifikasi. File: create-zip.ps1 serta manifest exclude yang benar-benar diperlukan.
Langkah: ganti path lama dengan source THEME relatif script; buat satu folder tema di root ZIP; salin stream/byte biner asli; exclude agent/editor/config/tooling/dependencies/secrets. Jangan menjalankan script lama yang diketahui memakai text reader pada biner.
Selesai: ZIP berisi tema yang benar dan tidak menyertakan repo/tooling. Assert-based check membuktikan font/gambar tidak diubah saat packaging. Tidak melakukan recursive move/delete tanpa verifikasi resolved workspace paths.

## S25. Verifikasi ZIP pada staging bersih

Dependensi: S24. File: laporan/test artifact temporary; paket yang dihasilkan.
Langkah: ekstrak ke lokasi uji terpisah; bandingkan SHA256 font/gambar/source; cek root folder/required files; install/activate pada staging uji yang diizinkan; ulang smoke pada halaman kritis.
Selesai: package hash/asset hash sesuai, tidak missing JS/font/template, dan smoke memakai ZIP tersebut. Source folder yang bekerja bukan bukti paket dapat dipasang.

## S26. Siapkan approval rilis dan rollback

Dependensi: P20/S23/S25 dan semua task wajib SELESAI; user menyetujui hasil staging dan production action.
File: panduan rilis/handoff, laporan, PROGRESS.md; perubahan production hanya setelah approval spesifik.
Langkah: sajikan hasil/data blockers; siapkan backup dan rollback tema/config yang sudah diuji; buat daftar perubahan data yang diizinkan; aktifkan hanya dengan approval; periksa order/customer/download setelah rilis. Jangan menyalin database staging menimpa order production.
Selesai: hasil production terverifikasi, rollback dapat dijalankan, source/paket/dokumen tersimpan, dan pemilik toko mendapat handoff. Jika approval belum ada, MENUNGGU USER dengan tautan staging dan tindakan spesifik; jangan menyebut redesign dirilis.
