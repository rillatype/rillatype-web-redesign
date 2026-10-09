# Aturan pengerjaan redesign

## Mulai dari dokumen aktif

1. Baca `REDESIGN-PLAN.md` untuk brief, urutan tugas, dependensi, dan kriteria selesai.
2. Baca bagian redesign aktif di `PROGRESS.md` untuk status dan langkah berikutnya.
3. Periksa `git status` dan diff sebelum mengedit. Pisahkan perubahan yang sudah ada dari pekerjaan sesi ini.
4. Baca kode, pemanggil, dan aset yang terkait dengan tugas. Catatan lama adalah petunjuk, bukan bukti implementasi.

`REDESIGN-PLAN.md` menyimpan spesifikasi pekerjaan. `PROGRESS.md` menjadi satu-satunya sumber status pekerjaan.
`PLAN.md`, `STATUS.md`, dan log lama tetap menjadi referensi historis.

## Kerjakan satu tugas

1. Pilih satu tugas yang semua dependensinya sudah selesai.
2. Ubah status tugas menjadi `BERJALAN` sebelum mengerjakannya.
3. Batasi perubahan pada hasil yang disebut dalam tugas tersebut.
4. Setelah satu unit perubahan selesai, jalankan pemeriksaan yang relevan.
5. Perbarui `PROGRESS.md` sebelum berpindah tugas, membuat commit, atau mengakhiri sesi.

Satu unit perubahan berarti satu perubahan yang bisa diperiksa, misalnya perbaikan header atau integrasi pilihan lisensi.
Perubahan lanjutan dalam tugas yang sama tetap memerlukan entri log baru. Jangan menunggu satu fase selesai.
Tugas tidak boleh berstatus `SELESAI` hanya karena kode sudah ditulis atau halaman statis terlihat benar.

## Catat setiap hasil

Gunakan status `BELUM`, `BERJALAN`, `TERBLOKIR`, `MENUNGGU USER`, atau `SELESAI` pada tabel tugas.
Hanya satu tugas implementasi yang berstatus `BERJALAN` pada satu waktu.

Setiap entri log mencatat:

- Tanggal sebenarnya dan ID tugas.
- Perubahan beserta file yang terkait.
- Pemeriksaan yang benar-benar dijalankan dan hasilnya.
- Pekerjaan yang belum selesai atau blocker.
- Langkah berikutnya.

Jika pemeriksaan gagal, catat kegagalan dan pertahankan tugas sebagai `BERJALAN` atau `TERBLOKIR`.
Jika user mengubah brief, perbarui spesifikasi, tabel tugas, dan log perubahan sebelum mengerjakan brief baru.
Pertahankan log lama. Koreksi klaim lama melalui entri baru yang menyebut bukti terkini.

## Ikuti brief, bukan default skill

- Gunakan `impeccable` untuk desain dan UX, serta `design-taste-frontend` untuk menghindari pola desain generik.
- Brief user mengalahkan default skill. Tetap gunakan WordPress, WooCommerce, arah visual terbaru yang disepakati dalam REDESIGN-PLAN.md, dan animasi ringan.
- Utamakan CSS native dan JavaScript yang memang diperlukan. Gunakan kode atau dependensi yang sudah tersedia.
- Ajukan alasan sebelum menambah framework, plugin, atau library yang memperbesar beban halaman.
- Pertahankan warna preview produk. Hindari klaim pemasaran, harga, lisensi, dan ulasan yang dibuat-buat.
- Pertahankan konten faktual, logo, data produk, URL penting, dan perilaku transaksi kecuali user menyetujui perubahan.
- Muat konten utama tanpa menunggu animasi. Hormati `prefers-reduced-motion`.
- Sediakan label form, fokus keyboard, kontras yang cukup, dan target sentuh yang mudah digunakan.

## Bedakan preview dan toko nyata

- Tandai data contoh pada preview dan catat bahwa preview tidak memproses pembayaran.
- Jangan menyatakan login, checkout, unduhan, atau email berfungsi hanya berdasarkan HTML statis.
- Periksa alur transaksi di WordPress staging dengan WooCommerce dan metode pembayaran sandbox.
- Pertahankan validasi server, nonce, escaping, izin akses unduhan, dan perhitungan harga WooCommerce.
- Baca pemanggil dan catatan regresi sebelum mengubah override cart, checkout, atau thank-you.

## Minta keputusan pada batas yang jelas

Tanyakan kepada user untuk persetujuan homepage dan halaman produk, perubahan cakupan, serta keputusan bisnis yang belum ada.
Tanyakan jika akses staging, file font, data lisensi, atau konfigurasi pembayaran belum tersedia.
Kerjakan tugas independen yang masih memungkinkan dan catat blocker. Jangan mengarang hasil verifikasi.
Aktivasi tema di production dan perubahan data produksi memerlukan persetujuan user.

## Simpan pekerjaan ke GitHub

User mengizinkan commit dan push dokumen persiapan ini ke `origin` pada branch aktif.
Untuk implementasi berikutnya, simpan unit tugas yang sudah diperiksa bersama pembaruan progress melalui commit dan push.
Jika user meminta menunda push atau muncul perubahan di luar scope, tanyakan sebelum menyertakan perubahan tersebut.

Sebelum commit, periksa `git status`, `git diff`, dan `git log --oneline -10`.
Stage hanya file terkait. Periksa staged diff dan kemungkinan rahasia sebelum membuat commit.
Gunakan pesan commit yang sesuai gaya repo. Jangan melakukan force-push, amend, atau melewati hook.
Jika push gagal, catat bahwa commit hanya tersimpan lokal. Periksa penyebabnya sebelum mencoba kembali.
Catat bukti push di log tugas berikutnya atau entri handoff. Jangan membuat commit berulang hanya untuk mencatat hash commit itu sendiri.

## Akhiri sesi dengan handoff

Perbarui tabel tugas dan log sebelum berhenti. Tuliskan tugas berikutnya, blocker, dan pemeriksaan yang belum dijalankan.
Laporkan file penting, hasil pemeriksaan, dan status push. Jangan menyebut seluruh redesign selesai jika masih ada tugas terbuka.
