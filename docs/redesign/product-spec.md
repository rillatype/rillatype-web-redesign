# Spesifikasi produk dan tampilan

Status: spesifikasi rencana disetujui user, 10 Oktober 2026. Baca sebelum task yang menyentuh produk, tester, gambar, lisensi, atau harga. Draf lisensi legal dan harga Graphics tetap memerlukan kelengkapan/keputusan yang tercantum.

## Pisahkan tiga konsep

1. Produk WooCommerce adalah barang digital yang dibeli, dengan product ID dan permalink tetap.
2. Style specimen adalah pilihan berkas font untuk mencoba teks. Memilih style tidak mengubah cart atau harga.
3. Variasi lisensi adalah pilihan pembelian WooCommerce, dengan variation ID dan harga dari server.

Rough, Slanted, Sans, Script, Dingbats, dan Regular adalah label style jika produk memang memiliki berkas tersebut. Jangan mengubah label itu menjadi angka weight.
Satu produk dapat berisi beberapa style yang sudah termasuk dalam paketnya. Tampilkan isi sesuai deskripsi dan metadata asli.

## Kontrak data untuk tampilan

Kontrak berikut menjelaskan data yang dibutuhkan frontend; bukan perintah membuat database atau framework baru.

| Data | Sumber | Aturan |
| --- | --- | --- |
| product ID, URL, nama | WC_Product/permalink | Pertahankan identitas yang sudah ada |
| kind: font, graphic, mixed, unknown | Audit kategori beserta ancestors dan isi produk | Jangan mendeteksi hanya dari ketersediaan specimen |
| gambar utama/gallery | Attachment produk | Pertahankan urutan, alt, sumber, dan rasio |
| harga/status sale | WooCommerce | Format memakai currency toko dan tax settings |
| lisensi yang tersedia | Atribut/variasi produk | Jangan hardcode semua produk memiliki enam pilihan |
| styles | Metadata preview yang telah diverifikasi | Setiap entri mempunyai ID stabil pada runtime, nama, dan attachment web preview |
| style default | Urutan style produk/admin | File pertama yang selesai download tidak menentukan default |
| glyph/features | Pembacaan berkas yang berhasil | Dukungan tidak tersedia atau parser tidak mendukung harus dinyatakan jujur |
| format/isi/compatibility | Deskripsi dan atribut produk terverifikasi | Jangan menyimpulkan format pembelian dari file specimen |
| bonus | Isi paket/deskripsi produk | Bonus grafis bukan otomatis produk Woo baru |

Metadata yang sudah ada: _font_data, _font_data_{i}_name, _font_data_{i}_font, dan _font_data_{i}_font_web. Berkas disimpan sebagai attachment ID.
Flag _font_preview dan _font_mode belum mengendalikan frontend tema lama. Jangan memperlakukan label admin secure image mode sebagai bukti renderer gambar.
Gunakan model row bernama yang ada. Tambahkan metadata baru hanya jika audit membuktikan kebutuhan dan preservation saver sudah ditentukan.
Jika kategori tidak cukup untuk klasifikasi, catat produk ambigu dan minta keputusan sebelum mengubah metadata atau kategori.

## Perilaku per jenis produk

| Kasus | Tampilan wajib | Yang tidak boleh diasumsikan |
| --- | --- | --- |
| Font satu style | Specimen langsung siap; nama style bila bermanfaat | Dropdown kosong, weight slider buatan, synthetic bold/italic |
| Font beberapa style | Satu tester; selector nama style asli | Semua variasi adalah weight |
| Sans + Script | Nama yang membedakan bagian font dan style, misalnya Sans Regular dan Script Regular | Kedua berkas memiliki glyph/features atau ukuran visual yang sama |
| Regular/Rough/Slanted | Berkas berbeda dipilih berdasarkan label | Slanted dibuat dengan CSS skew atau Rough dibuat dengan filter |
| Chronoa | Berkas dan label weight nyata | Setiap font membutuhkan 100–900 |
| Dingbats | Berkas dan karakter yang memang tersedia | Alphabet biasa selalu menghasilkan teks yang bermakna |
| Font tanpa specimen | Gallery/deskripsi tetap tersedia; status tester tidak tersedia | Produk tersebut adalah Graphic |
| Graphic murni | Gallery, deskripsi, isi/format/compatibility bila terverifikasi, lisensi dan pembelian | Font tester, glyph grid, FAQ OTF/TTF |
| Font + bonus Graphic | Tester font, gallery utuh, rincian bonus | Bonus dapat dibeli terpisah atau memakai lisensi berbeda tanpa bukti |
| Unknown | Detail produk generik dan pembelian native yang valid | Fakta, tester, atau lisensi font yang dibuat-buat |

## Tester

- Pertahankan input teks, ukuran, leading, tracking, alignment, tema specimen, fitur OpenType yang didukung, dan panel glyph yang sudah diminta.
- Style selector tampil hanya ketika ada lebih dari satu style valid. Weight controls tampil hanya untuk berkas weight yang tersedia.
- Teks input adalah teks literal. Jangan memasukkan input pengunjung lewat HTML.
- Pemilihan style mempertahankan teks, size, leading, tracking, alignment, dan theme pengguna.
- Menghapus lalu mengetik ulang mempertahankan style terpilih.
- Pemuatan terakhir yang dipilih menang; respons lama tidak boleh menimpa family, fakta, atau error state terbaru.
- File gagal: sembunyikan sample yang tidak dapat dipercaya, pertahankan teks, tampilkan penyebab yang dapat dipahami dan cara retry.
- Muat berkas default ketika tester mendekati viewport. Muat style lain saat dipilih. Hindari memuat semua font katalog atau semua style sekaligus.
- Fitur yang tidak didukung tampil tidak tersedia dengan keterangan. Jangan menebak fitur dari nama style.
- Font web specimen berbeda dari unduhan pembelian. Jangan fallback ke ZIP, downloadable file berbayar, atau font desktop lengkap sebagai aset publik.

## Artwork selalu utuh

Untuk preview font 1200x800, tampilkan rasio 3:2. Ini berlaku pada unggulan, card/row thumbnail, gallery, slideshow, dan lightbox.
Gunakan image width 100% dengan height auto. Jika bingkai mempunyai ukuran, gunakan aspect-ratio 3/2 dan object-fit contain.
Pertahankan width/height attributes yang sesuai sumber untuk mengurangi layout shift.
Pilih thumbnail WordPress yang dibuat tanpa crop, atau sumber asli bila ukuran turunan tidak aman. object-fit contain tidak dapat memulihkan gambar yang sudah dipotong server.
Periksa srcset dan currentSrc: semua kandidat harus mempertahankan isi gambar, bukan hanya rasio CSS.
Gambar Graphics yang mempunyai rasio asli lain ditampilkan utuh menurut dimensinya. Jangan menarik gambar menjadi 3:2.
Tidak memakai zoom hover atau object-fit cover yang memotong artwork. Lightbox menyesuaikan viewport dengan contain.
Jika gambar rusak, pertahankan ruang layout dan tampilkan state yang jelas; jangan mengganti produk dengan artwork produk lain.

Acceptance: empat tepi dan semua lettering pada sumber 1200x800 terlihat. Rasio render 1.5 dengan toleransi 1px pembulatan. Verifikasi pada 320, 390, 768, 1280, 1440, dan 1600px.

## Lisensi dan harga

Lisensi font tetap mengikuti produk asli: Standard, Extended, Webfont/E-Pub, App/Game, Broadcast, Corporate bila tersedia.
Graphics mengikuti draft Graphics Standard/Extended setelah user menyetujui ketentuan dan harga. Jangan memberi Graphics enam opsi font secara otomatis.
Simple product memakai form simple native. Variable product membutuhkan variation valid. Jangan memilih variasi berdasarkan index atau nama saja; kirim variation ID dan atribut yang sesuai.
Gunakan placeholder Choose a license bila lisensi wajib. Tampilkan harga dan ringkasan tepat untuk pilihan tersebut.
Jika salah satu variasi gratis dan yang lain berbayar, label katalog menjelaskan variasi gratis atau harga awal. Jangan menyatakan semua penggunaan gratis.
Pada prototype, semua harga yang belum diverifikasi diberi label Demo. Pada toko nyata, hapus label Demo hanya setelah data Woo terhubung dan diuji.
Harga Graphics Extended diisi user per produk. Jangan membuat multiplier, angka default, atau diskon baru.
Jangan mengubah hak pesanan lama ketika ketentuan baru diterapkan. Aturan publikasi/versioning dikonfirmasi sebelum rilis.

## Matriks kasus wajib

| ID | Kasus | Sampel | Bukti selesai |
| --- | --- | --- | --- |
| C01 | Satu style | Mango atau Sunday Willow dengan berkas asli | Tidak ada selector tak berguna; font asli tampil |
| C02 | Named styles | Tropivera atau produk Regular/Rough/Slanted asli | Semua pilihan memakai berkas dan nama benar |
| C03 | Campuran Sans + Script | Produk/file user yang diverifikasi | Tidak disederhanakan menjadi weight; pilihan dibedakan |
| C04 | Family beberapa weight | Chronoa | Semua cut yang tersedia dipilih; tidak menjadi default seluruh toko |
| C05 | Dingbats | Tropivera Dingbats jika berkas tersedia | Glyph yang tersedia dapat diperiksa |
| C06 | Graphic murni | Distressed Overlays atau ilustrasi | Tidak ada tester/FAQ font; gallery dan isi benar |
| C07 | Font + bonus Graphic | Solaya | Tester font dan rincian bonus benar |
| C08 | Font tanpa specimen | Font nyata dengan specimen disembunyikan pada fixture | State unavailable; produk tetap font |
| C09 | Gagal/late load | Abort dan delay request font pada test | Teks/style konsisten dan retry berhasil |
| C10 | Freebie variable | Redline pada staging | Standard 0; pilihan berbayar menghitung harga sebenarnya |
| C11 | Freebie simple | Graphic gratis pada staging | Order 0 mengikuti Woo; unduhan sesuai izin |
| C12 | Artwork | Sumber 1200x800 dengan lettering sampai tepi | Semua tepi utuh dan currentSrc tidak cropped |

Fixture demonstrasi yang meniru struktur boleh digunakan untuk UI, tetapi tidak menutup pengujian berkas asli, format paket, atau transaksi nyata.
