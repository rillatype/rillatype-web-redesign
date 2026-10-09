# Arah desain playful foundry

User memilih arah ini pada 9 Oktober 2026 setelah menolak dua preview katalog yang terlalu umum.
User mengizinkan satu warna khas pada UI. Coral berasal dari identitas Rillatype yang sudah ada di repo.

## Premis yang diganti

Dua versi awal mengandalkan grid netral, font UI system, dan pembesaran preview.
Keduanya membatasi identitas font Rillatype di dalam gambar kartu. Memperbesar kartu tidak mengganti premis tersebut.
Versi baru menjadikan font Rillatype bagian nyata dari lettering dan interaksi halaman.

## Direction contract

THESIS: Pengunjung masuk ke ruang specimen foundry, bukan katalog netral yang bisa memakai nama brand apa pun.

OWN-WORLD: Latar terang, tinta gelap, coral untuk pilihan aktif dan specimen, lettering Mango asli, sample huruf, logo asli, dan gambar font.

STORY: Lihat karakter font langsung pada headline dan specimen. Bandingkan font pilihan, cari berdasarkan nama atau style, dan lanjut ke produk.

FIRST VIEWPORT: Pada R05C, logo, pencarian, dan navigasi menjadi satu header. Lettering Mango memperkenalkan koleksi pada bidang terang. Filter dan jumlah hasil mendahului preview, sementara sample huruf berada bersama produk Mango. Header tetap terlihat saat scroll.

FORM: Playful foundry dikunci user melalui question tool. Pilihan user menggantikan arah katalog studio dari seed sebelumnya.

FINISH: unreviewed and undocumented is unfinished; this build ends with the finish review, the verdict, DESIGN.md, and every shipping raster carrying its provenance

## Batas visual dan teknis

- Gunakan font lokal `static/previews/mango-letter.otf`. System sans hanya untuk informasi dan kontrol.
- Interaksi specimen mengganti pasangan huruf, bukan tester teks lengkap. Tester tetap berada pada tugas halaman produk.
- Tidak memakai animasi loop, WebGL, atau library tambahan.
- Harga, kategori, urutan rilis, dan pilihan homepage tetap data contoh yang diberi label.
- Logo berasal dari `logo.png`. Gambar dan font demo berasal dari `static/previews/`.
- R05C memakai gambar cover produk tanpa collage mockup pada pembukaan. R05B sebelumnya memakai mockup, bukan testimoni pelanggan.
