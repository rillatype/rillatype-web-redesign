# Spesifikasi revisi font tester

> Dokumen ini mengunci brief revisi tester sebelum implementasi.
> Status pekerjaan tetap berada di `PROGRESS.md`. Aturan kerja berada di `docs/agents/redesign-rules.md`.

## Latar belakang

Preview R06 dinilai belum memadai. User menilai fitur tester terlalu sedikit, UI dan UX kurang baik, serta keseluruhan tampilan terasa murah.

Kondisi tester lama hanya menyediakan textarea, satu slider ukuran, dan satu baris output. Hanya Mango Letters yang memiliki berkas specimen, sehingga tujuh dari delapan produk menampilkan pesan font tidak tersedia.

## Keputusan user

| Nomor | Pertanyaan | Jawaban |
| --- | --- | --- |
| 1 | Penanganan fitur OpenType yang tidak ada pada berkas font | Opsi B. UI dibangun lengkap, kontrol tanpa dukungan tampil nonaktif dengan keterangan jujur. |
| 2 | Chronoa menggantikan atau menambah Mango | Menambah. Katalog menjadi sembilan font. |
| 3 | Nama family pada antarmuka | Chronoa. Sembilan style disatukan menjadi satu family. |
| 4 | Opsi perataan | Kiri, tengah, kanan. Tanpa justify. |
| 5 | Rentang pekerjaan | Static only. Integrasi WordPress setelah acuan desain disetujui. |

Keputusan pendukung sebelumnya: posisi tester menjadi bagian utama halaman produk, sebelum pemilih lisensi. Catatan pekerjaan memakai entri log baru di bawah R06.

## Temuan berkas font

Diperiksa langsung dari berkas di `Font Test/`.

- Sembilan berkas: Thin, ExtraLight, Light, Regular, Medium, SemiBold, Bold, ExtraBold, Black.
- Setiap berkas memiliki 219 glyph, 218 codepoint, hanya Latin dasar ditambah aksen serta tanda baca.
- GSUB tidak ada pada delapan berkas. Berkas Thin memiliki tabel GSUB, tetapi berisi nol feature.
- Tidak ada ligature, stylistic alternate, swash, small caps, atau oldstyle figures.
- GPOS tersedia pada seluruh berkas.
- Nama family pada `name` table tidak konsisten, misalnya `Chronoa Black`, `Chronoa ExtBd`, `Chronoa Light`. Nama perlu dinormalkan saat pemuatan.

Konsekuensi: tombol ligature dan stylistic alternate tidak dapat mengubah apa pun pada Chronoa. Sesuai Opsi B, tombol tetap tampil dan dijelaskan sebagai tidak tersedia.

## Fitur tester yang dibangun

1. Masukan teks contoh yang dapat diedit.
2. Slider ukuran.
3. Dropdown style dalam family. Sembilan style Chronoa, serta style Mango Letters jika berkasnya ada.
4. Slider leading.
5. Slider tracking.
6. Perataan kiri, tengah, kanan.
7. Sakelar latar terang dan gelap. Latar gelap memakai teks terang.
8. Sakelar ligature. Nonaktif dengan keterangan untuk font tanpa dukungan.
9. Sakelar stylistic alternate. Nonaktif dengan keterangan untuk font tanpa dukungan.
10. Panel all glyph yang dapat dibuka dan ditutup, dengan jumlah karakter ditampilkan.

## Urutan halaman produk

```
breadcrumb
judul, nama style, harga
tester sebagai bagian utama
pemilih lisensi
font information
```

Tester tampil sebelum pemilih lisensi agar pengunjung dapat menilai font lebih dahulu.

## Rancangan antarmuka

Tujuan: menghapus kesan murah.

- Seluruh kontrol memakai gaya yang konsisten dengan sistem editorial R05E. Tidak memakai kontrol bawaan browser tanpa gaya.
- Bidang specimen menjadi objek dominan, dengan bidang terkontrol, bingkai tipis, dan sudut membulat 8px.
- Slider memakai track dan thumb yang digayakan, tinggi target sentuh minimal 44px.
- Label spesifik sesuai isi, bukan label umum.
- Nilai kontrol ditampilkan sebagai angka yang terlihat.
- Pada layar sempit, kontrol lanjutan dapat dilipat, namun specimen tetap terlihat.
- Fokus keyboard jelas. Kontras memadai pada latar terang dan gelap.
- `prefers-reduced-motion` dihormati.

## Penanganan font tanpa specimen

Delapan font selain Chronoa dan Mango belum memiliki berkas. Tampilkan state yang jelas: produk tetap dapat dilihat melalui gambar, tester menampilkan keterangan bahwa berkas specimen belum tersedia, dan tombol yang tidak berlaku dinonaktifkan. Jangan menampilkan kontrol yang terlihat berfungsi padahal tidak.

## Definisi selesai

- Seluruh sepuluh fitur dapat diperiksa pada desktop dan mobile.
- Perubahan style Chronoa benar-benar mengubah tampilan specimen.
- Slider leading, tracking, dan ukuran benar-benar mengubah tampilan specimen.
- Sakelar latar gelap benar-benar membalik warna bidang specimen.
- Sakelar ligature dan stylistic alternate menampilkan kondisi tidak tersedia pada Chronoa, dengan keterangan yang terbaca.
- Panel glyph dapat dibuka dan ditutup dan tidak memanjangkan halaman saat tertutup.
- Perataan kiri, tengah, kanan benar-benar mengubah posisi teks.
- Tidak ada kesalahan JavaScript pada pemeriksaan browser.
- Data contoh tetap ditandai. Tidak ada klaim pembelian atau harga yang dibuat-buat.

## Pekerjaan yang belum termasuk

- Integrasi data produk asli.
- Berkas specimen untuk delapan font lain.
- Pemotongan dan pembuatan WOFF2.
- Perilaku transaksi, cart, atau pembayaran.

## Berkas yang diperkirakan berubah

- `static/redesign/fonts/` untuk berkas Chronoa.
- `static/redesign/product.html` untuk struktur tester.
- `static/redesign/product-preview.js` untuk perilaku tester.
- `static/redesign/editorial.css` untuk gaya tester.
- `scripts/check-redesign-preview.py` untuk pemeriksaan baru.
- `DESIGN.md` dan `.impeccable/design.json` untuk sinkronisasi dokumen desain.
- `PROGRESS.md` untuk catatan pekerjaan.
