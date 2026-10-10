# Inventaris referensi Rillatype

Status: dibuat oleh P02, 10 Oktober 2026. Dokumen ini menyimpan fakta publik yang terverifikasi beserta sumber dan tanggalnya.
Gunakan sebagai acuan contoh C01–C12 dan sebagai pembanding saat data staging tersedia. Dokumen ini bukan pengganti data WooCommerce.

## Cara observasi dan batasnya

- Tanggal observasi: **10 Oktober 2026**, 08:30–08:45 WIB.
- Halaman yang dibaca langsung: `https://rillatype.com/` (homepage, sumber unggulan dan freebies), `https://rillatype.com/license/` (enam ketentuan lisensi font publik), `https://rillatype.com/shop/` beserta `https://rillatype.com/shop/page/2/` sampai `https://rillatype.com/shop/page/9/` (daftar katalog), `https://rillatype.com/product-category/graphic/` (kategori Graphics), dan 12 halaman produk yang tercantum pada tabel di bawah.
- Metode: permintaan HTTP baca-saja ke halaman publik rillatype.com dengan user-agent audit. Tidak ada login, tidak ada penambahan ke cart, tidak ada checkout, tidak ada transaksi, dan tidak ada perubahan data toko.
- Sumber per halaman: JSON-LD `Product` (name, sku, image, `AggregateOffer`, `offerCount`), blok `<p class="price">`, atribut `data-product_variations` (daftar `attribute_pa_license` dan `display_price`), tab Description, dan daftar `<img>` pada `wp-content/uploads`.
- Dimensi gambar diperiksa dengan membaca header berkas (JPEG SOF / PNG IHDR), bukan dari teks halaman.
- Batas: atribut variasi untuk pemilihan **style specimen** tidak dapat dibaca dari HTML publik; yang terlihat hanya `attribute_pa_license` beserta `name`. Daftar berkas font per produk (`_font_data_*`), ukuran, jumlah glyph, dan cakupan fitur **menunggu staging**. Jumlah gambar gallery yang tercatat adalah batas bawah, karena sebagian dimuat lazy oleh tema.
- Semua harga di bawah adalah **observasi**, bukan ketetapan. Harga prototype tetap memakai label Demo sampai data WooCommerce terhubung.

## Konflik dengan catatan audit sebelumnya

Ringkasan audit di `docs/redesign/execution-plan.md` (baris 102–111) dan `docs/redesign/product-spec.md` (baris 92–103) tidak lagi cocok dengan halaman publik pada 10 Oktober 2026. Perbedaan berikut dicatat sebagai fakta, bukan diedit diam-diam:

| Catatan lama | Fakta 10 Oktober 2026 | Tindakan |
| --- | --- | --- |
| Mango Letters `$18` | Mango Letters `$19`, `highPrice 1500` | Pakai `$19`; `$18` adalah harga demo lokal |
| C01 sample "Mango atau Sunday Willow" | Keduanya produk nyata dan terverifikasi | Lanjut, dua-duanya tercatat |
| C04 sample "Chronoa" tanpa URL | Chronoa ada: `/product/chronoa-font-family/` | Pakai URL nyata |
| C05 "Tropivera Dingbats jika berkas tersedia" | Tropivera menyatakan "Dingbats Set"; Wildkins menyatakan "Wildkins Dingbats (adventure icons)" dengan 5 style | Pakai Wildkins sebagai sampel utama, Tropivera pendamping |
| C06 sample "Distressed Overlays atau ilustrasi" | Terverifikasi: `/product/distressed-overlays-vol-01-grunge-texture-pack/`, gratis, tanpa variasi | Pakai sebagai sampel C06 |
| C07 sample "Solaya" | Terverifikasi; bonus ilustrasi disebut di deskripsi | Lanjut |
| C10 "Redline pada staging" | Redline variasi `standard-license` = `0`, berbayar 50–1500 | Lanjut; angka ini bukti kasus, bukan konstanta |
| C11 "Graphic gratis pada staging" | Belum ada Graphic murni gratis yang terverifikasi; yang gratis adalah font (Darkwell, Lucy Carter) dan texture pack | C11 tetap berstatus butuh bukti |
| C03 "Sans + Script" dinyatakan belum tersedia | **Tersedia**: Dockhand dan Highway Patrol adalah duo Sans + Script | Catat sebagai temuan baru P02 |
| CategoryLinks per produk tidak dicatat | HTML produk memuat **seluruh** tautan kategori situs, jadi kategori per produk tidak terbaca dari sana | Kategori per produk menunggu staging |
| Jumlah produk tidak disebut | Shop punya **9 halaman × 12 produk = 108 kartu** | Tercatat sebagai skala katalog |

## Katalog publik: navigasi dan taksonomi

Dari https://rillatype.com/ dan https://rillatype.com/shop/ (10 Oktober 2026):

- Navigasi utama: Home, Shop, Font, Freebies, License, Contact, Account, Cart.
- Shop memiliki submenu **Font** dan **Graphic**.
- Font memiliki delapan subkategori: Display, Script, Handwritten, Retro & Vintage, Modern, Signature, Sans Serif, Serif.
- Graphic memiliki halaman kategori sendiri: https://rillatype.com/product-category/graphic/
- Freebies adalah kategori tersendiri: https://rillatype.com/product-category/freebies/
- Halaman lisensi: https://rillatype.com/license/
- Skala katalog: 9 halaman shop, 12 kartu per halaman.

Catatan kategori: satu produk dapat muncul di beberapa subkategori sekaligus (contoh: Tropivera terlihat pada Display, Handwritten, Retro & Vintage, Signature). Karena itu `kind: font` tidak boleh disimpulkan dari satu subkategori; klasifikasi harus memakai kategori beserta ancestors dan isi produk seperti tertulis di `product-spec.md`.

## Tabel lisensi font yang dipublikasikan

Dari https://rillatype.com/license/ (10 Oktober 2026). Enam lisensi font, dipakai sebagai label contoh pada prototype:

| Lisensi | Ringkasan publik yang terlihat |
| --- | --- |
| Standard License | Satu pengguna, 2 komputer, 5 proyek komersial, blog tanpa batas, logo non-trademark, sampai 10.000 cetak |
| Extended License | Sampai 10 pengguna, 10 komputer, termasuk logo dan logotype, proyek tanpa batas, `@font-face` diizinkan |
| Webfont/E-Pub License | Satu website, 100.000 page view per bulan, termasuk e-book dan publikasi digital |
| App/Game License | Satu app atau game, tampilan tanpa batas, satu website |
| Broadcast License | Video, film, TV, motion graphics, proyek komersial tanpa batas |
| Corporate License | Satu brand korporat, pengguna, instalasi, web view, broadcast, dan produk akhir tanpa batas |

Ketentuan ini **ketentuan yang dipublikasikan pemilik toko**, bukan draf baru. Enam nama di atas dipakai sebagai label; harga per produk tetap berasal dari WooCommerce.

Draf Graphics Standard/Extended berada di `graphics-license-draft.md` dan **belum boleh ditampilkan sebagai ketentuan resmi**.

## Produk nyata yang terverifikasi

Semua baris di bawah berasal dari halaman produk publik pada 10 Oktober 2026. `low` dan `high` adalah `AggregateOffer` pada JSON-LD, yaitu rentang variasi lisensi produk tersebut. `offerCount` adalah jumlah variasi lisensi yang benar-benar ada.

### Font

| Slug | Nama terlihat | SKU | Harga low–high | Variasi lisensi | Gambar utama | Gambar terdaftar |
| --- | --- | --- | --- | --- | --- | --- |
| `mango-letters-handwritten-font` | Mango Letters – Natural Organic Handwritten Font | 4070 | 19–1500 | 6 | `2026/06/Artboard1.jpg` | 12 |
| `tropivera` | Tropivera – Tropical Display Font Family | 3917 | 25–1500 | 6 | `2026/05/Artboard1-2.jpg` | 4 |
| `solaya-a-dual-style-tropical-font-bonus-illustrations` | Solaya – A Dual-Style Tropical Font + Bonus Illustrations | 3783 | 25–2000 | 6 | `2025/09/Artboard-1.jpg` | 21 |
| `darkwell-family` | Darkwell Family | 3366 | gratis | 0 (simple) | `2024/12/Artboard-1.png` | 15 |
| `redline-syndicate-display-font` | Redline Syndicate – Urgent Handwritten Display Font | 3976 | 0–1500 | 6 | `2026/05/Artboard1-4.jpg` | 12 |
| `sunday-willow-handwritten-script` | Sunday Willow – Handwritten Script Font | 3946 | 25–1500 | 6 | `2026/05/Artboard1-3.jpg` | 12 |
| `wildkins-hikers-bundle-hand-inked-font-extras` | Wildkins Hiker's Bundle – Hand-Inked Font with Icons, Badges & Textures | 3628 | 25–2000 | 6 | `2025/04/1-1.jpg` | 13 |
| `nutmeg-league` | Nutmeg League | 3897 | 19–1500 | 6 | `2026/05/Artboard1-1.jpg` | 13 |
| `magical-charm-dreamy-handwritten-font` | Magical Charm – Handwritten Font | 4114 | 19–1500 | **5** | `2026/08/2.jpg` | 4 |
| `the-matcha-club-bold-retro-brush-font` | The Matcha Club – Bold Retro Brush Font | 4021 | 19–1500 | 6 | `2026/05/Artboard1-7.jpg` | 12 |
| `chronoa-font-family` | Chronoa Font Family | belum dibaca | belum dibaca | belum dibaca | belum dibaca | belum dibaca |
| `bawden-slab-serif` | Bawden Slab Serif | belum dibaca | belum dibaca | belum dibaca | belum dibaca | belum dibaca |
| `daisy-hotline-cute-retro-display-font` | Daisy Hotline – Cute Retro Display Font | belum dibaca | belum dibaca | belum dibaca | belum dibaca | belum dibaca |
| `crimson-queen-modern-serif` | Crimson Queen – Modern Serif | belum dibaca | belum dibaca | belum dibaca | belum dibaca | belum dibaca |
| `mordial-modern-serif-font` | Mordial – Modern Serif Font | belum dibaca | belum dibaca | belum dibaca | belum dibaca | belum dibaca |
| `moyshire-vintage-script` | Moyshire – Vintage Script | belum dibaca | belum dibaca | belum dibaca | belum dibaca | belum dibaca |
| `baldock-retro-font` | Baldock Retro Font | belum dibaca | belum dibaca | belum dibaca | belum dibaca | belum dibaca |
| `dockhand-font-duo` | Dockhand Font Duo | belum dibaca | belum dibaca | belum dibaca | belum dibaca | belum dibaca |
| `highway-patrol-font-duo` | Highway Patrol Font Duo | belum dibaca | belum dibaca | belum dibaca | belum dibaca | belum dibaca |
| `goodneigbor-vintage-font-duo` | Goodneigbor – Vintage Font Duo | belum dibaca | belum dibaca | belum dibaca | belum dibaca | belum dibaca |
| `brika-font-duo-20-coffee-vectors-dingbat-icons` | Brika – Font Duo + 20 Coffee Vectors + Dingbat Icons | belum dibaca | belum dibaca | belum dibaca | belum dibaca | belum dibaca |
| `nocturne-black-gothic-horror-font-family` | Nocturne Black — Gothic Horror Font Family | belum dibaca | belum dibaca | belum dibaca | belum dibaca | belum dibaca |

"belum dibaca" berarti halaman itu belum diambil pada P02; barisnya dicatat dari daftar katalog supaya tidak hilang, dan **bukan** klaim.

### Graphic dan aset non-font

| Slug | Nama terlihat | SKU | Harga | Variasi | Gambar utama |
| --- | --- | --- | --- | --- | --- |
| `distressed-overlays-vol-01-grunge-texture-pack` | Distressed Overlays Vol.01 – Grunge Texture Pack | 3252 | gratis | 0 (simple) | `2024/11/Preview-3.jpg` |
| `palm-tree-illustration-set` | Palm Tree Illustration Set | belum dibaca | terlihat gratis pada kartu | belum dibaca | belum dibaca |
| `cowboy-illustration-template` | Wild West Cowboy on Horseback – Vintage Western Illustration | belum dibaca | terlihat gratis pada kartu | belum dibaca | belum dibaca |
| `cowboy-illustration-template-copy` | Stay Wild – Vintage Cowboy and Bear Adventure Illustration | belum dibaca | terlihat gratis pada kartu | belum dibaca | belum dibaca |

Deskripsi Distressed Overlays menyebut **PNG dalam ZIP**. Itu format paket yang terlihat pada deskripsi produk, bukan kesimpulan dari berkas specimen. Tidak ada selector lisensi font pada produk ini.

## Detail style yang terdokumentasi publik

Nama style di bawah berasal dari tab Description atau metadata produk. Daftar ini **nama style yang dipublikasikan**, bukan bukti isi berkas.

| Produk | Style yang disebut deskripsi | Catatan |
| --- | --- | --- |
| Mango Letters | tidak menyebut style bernama | Kandidat font satu style |
| Tropivera | "Decorative Style", "Regular Style", "Dingbats Set" | Tiga bagian; cocok untuk C02 dan pendamping C05 |
| Solaya | "Solaya Raw", "Solaya Neat" | Dua style dalam satu produk, plus bonus ilustrasi |
| Darkwell Family | "two fonts which both come in three weights; regular, bold, and italic" | Dua font, tiga weight masing-masing |
| Redline Syndicate | tidak menyebut style bernama pada deskripsi | Enam variasi lisensi, `standard` = 0 |
| Sunday Willow | tidak menyebut style bernama | — |
| Wildkins Hiker's Bundle | "5 Font Styles": Wildkins Regular, Wildkins Slant, Wildkins Stamp, Wildkins Stamp Slant, Wildkins Dingbats; 30+ adventure icons; 8 badge templates; bonus 3 texture PNG | Kandidat terkuat untuk C05 dan C07 |
| Nutmeg League | tidak dibaca | — |
| Magical Charm | tidak dibaca; hanya **5** variasi lisensi | Bukti bahwa jumlah lisensi tidak seragam |
| The Matcha Club | tidak dibaca | — |
| Dockhand | "script & sans font duo" | Kandidat C03 |
| Highway Patrol | "bold, commanding all-caps sans serif and a dynamic script" | Kandidat C03 alternatif |
| Goodneigbor | "script font paired with a classic sans serif, along with an elegant sans serif outline version" | Kandidat C03 ketiga |
| Mondriel | "condensed sans-serif with ... a handwritten font" | Kandidat C03 keempat |
| Brika | "bold, chunky sans with a handwritten script"; bonus 20 ilustrasi kopi dalam AI, EPS, SVG | Kandidat C03/C07 |
| Nocturne Black | "Regular, Slanted, Inked, and Inked Slant" | Kandidat C02 dengan slanted nyata, bukan CSS skew |
| Chronoa Font Family | Thin, Extra Light, Light, Regular, Medium, Semibold, Bold, Extra Bold, Black | Sembilan style disebut deskripsi produk |

## Harga variasi Redline Syndicate (bukti kasus freebie)

Dari `data-product_variations` halaman Redline Syndicate, 10 Oktober 2026. `standard-license` tidak memiliki entri harga berbayar; variasi berbayarnya:

| Variasi | ID | `display_price` |
| --- | --- | --- |
| standard-license | 3982 | 0 |
| extended-license | 3977 | 150 |
| webfont-e-pub-license | 3978 | 50 |
| app-game-license | 3979 | 100 |
| broadcast-license | 3980 | 1000 |
| corporate-license | 3981 | 1500 |

Angka ini **bukti kasus**, bukan konstanta aplikasi dan bukan harga yang boleh di-hardcode. Kartu C10 meminta perilaku: label katalog harus menjelaskan variasi gratis atau harga awal, dan pilihan berbayar menghitung harga sebenarnya.

## Dimensi gambar produk

Delapan gambar utama produk diukur langsung dari header berkasnya:

| Gambar | Dimensi | Rasio |
| --- | --- | --- |
| `2026/05/Artboard1-1.jpg` (Nutmeg League) | 1200x800 | 1.500 |
| `2026/06/Artboard1.jpg` (Mango Letters) | 1200x800 | 1.500 |
| `2026/05/Artboard1-2.jpg` (Tropivera) | 1200x800 | 1.500 |
| `2024/11/Preview-3.jpg` (Distressed Overlays) | 1200x800 | 1.500 |
| `2025/09/Artboard-1.jpg` (Solaya) | 1200x800 | 1.500 |
| `2024/12/Artboard-1.png` (Darkwell) | 1200x800 | 1.500 |
| `2025/04/1-1.jpg` (Wildkins) | 1200x800 | 1.500 |
| `2026/05/Artboard1-3.jpg` (Sunday Willow) | 1200x800 | 1.500 |

Kesimpulan: sumber gambar font memang 1200x800 dengan rasio 3:2, termasuk paket Graphic Distressed Overlays. Aturan "artwork utuh, rasio 3:2, `object-fit: contain`" di `product-spec.md` berlaku pada aset nyata, bukan asumsi.

## Pemetaan contoh wajib C01–C12

| ID | Kasus | Sampel yang dipilih | Sumber | Status bukti |
| --- | --- | --- | --- | --- |
| C01 | Satu style | Mango Letters; alternatif Sunday Willow | https://rillatype.com/product/mango-letters-handwritten-font/ | Produk, harga, 6 lisensi, 12 gambar terverifikasi. Isi berkas menunggu staging |
| C02 | Named styles | Tropivera (Decorative, Regular, Dingbats); alternatif Nocturne Black (Regular, Slanted, Inked, Inked Slant) | https://rillatype.com/product/tropivera/ | Nama style terverifikasi dari deskripsi. Berkas per style menunggu staging |
| C03 | Campuran Sans + Script | Dockhand Font Duo; alternatif Highway Patrol, Goodneigbor, Mondriel, Brika | https://rillatype.com/product/dockhand-font-duo/ | **TERSEDIA**, berbeda dari catatan rencana. Deskripsi menyebut duo script dan sans |
| C04 | Family beberapa weight | Chronoa Font Family, sembilan style | https://rillatype.com/product/chronoa-font-family/ | Nama sembilan style terverifikasi dari deskripsi; halaman produk belum dibaca detail |
| C05 | Dingbats | Wildkins Hiker's Bundle (Wildkins Dingbats, 5 style, 30+ ikon) | https://rillatype.com/product/wildkins-hikers-bundle-hand-inked-font-extras/ | Nama style dan ikon terverifikasi. Glyph nyata menunggu berkas staging |
| C06 | Graphic murni | Distressed Overlays Vol.01 | https://rillatype.com/product/distressed-overlays-vol-01-grunge-texture-pack/ | Produk, SKU, harga gratis, tanpa variasi, PNG dalam ZIP dari deskripsi |
| C07 | Font + bonus Graphic | Solaya (dua style + bonus ilustrasi); alternatif Wildkins (ikon, badge, texture) dan Brika (20 vektor kopi) | https://rillatype.com/product/solaya-a-dual-style-tropical-font-bonus-illustrations/ | Deskripsi bonus dan format terverifikasi |
| C08 | Font tanpa specimen | Darkwell Family | https://rillatype.com/product/darkwell-family/ | Produk nyata, gratis, dua font tiga weight. Berlaku sebagai font, bukan Graphic |
| C09 | Gagal/late load | Mango Letters di fixture lokal | `static/redesign/` dan `scripts/check-specimen-states.py` | Fixture lokal sudah ada dari R05H; perilaku diuji di P09 |
| C10 | Freebie variable | Redline Syndicate | https://rillatype.com/product/redline-syndicate-display-font/ | Enam variasi dan harga `standard` = 0 terverifikasi |
| C11 | Freebie simple | Belum ada Graphic murni gratis yang terverifikasi | — | **BUTUH BUKTI.** Yang gratis adalah font (Darkwell) dan texture pack yang deskripsinya tidak menyatakan dirinya Graphic sederhana |
| C12 | Artwork | Delapan gambar produk 1200x800 rasio 1.500 | `wp-content/uploads` | Dimensi terukur dari header berkas |

## Aset demo lokal dan statusnya

`static/previews/` dan `static/redesign/` memuat aset yang **bukan produk toko terkonfirmasi**:

| Aset | Sumber | Status |
| --- | --- | --- |
| `static/previews/mango-letter.otf`, `mango-1..9.jpg` | Berkas kerja pengguna dan turunannya | Mango ada di toko; berkas specimen tetap menunggu hak distribusi (W04/W19) |
| `static/redesign/fonts/chronoa-*.otf` (9 berkas) | Folder kerja pengguna `Font Test` | Chronoa ada di toko; berkas specimen menunggu hak distribusi |
| `static/previews/bawden-1.jpg`, `crimson-queen-1.jpg`, `mordial-1.jpg`, `moyshire-1.jpg`, `baldock-1.jpg`, `daisy-hotline-1.jpg` | Aset repo | Produknya nyata di toko dengan permalink berbeda |
| `static/previews/brush-set-1..3.jpg`, `font-bundle-1..2.jpg`, `graphic-pack-1..2.jpg` | Aset repo, **mockup placeholder** | **DEMO, bukan produk nyata terkonfirmasi.** Tidak ada padanannya di katalog publik. Jangan dipakai sebagai bukti produk |
| `static/previews/chronoa-1.jpg` | Dirender dari berkas Chronoa asli dengan Pillow | Turunan aset pengguna, bukan artwork toko |

Slug prototype `brush-set-1`, `brush-set-2`, `brush-set-3`, `font-bundle-1`, `font-bundle-2`, `graphic-pack-1`, `graphic-pack-2` adalah **entri demo**. P02 menandainya supaya tidak ada task lanjutan yang memperlakukannya sebagai produk nyata.

## Yang belum terverifikasi dan pemiliknya

| Data yang hilang | Mengapa penting | Task yang menunggu |
| --- | --- | --- |
| Daftar berkas specimen per produk dan hak distribusinya | Batas aset publik untuk tester | W04, W19 |
| Daftar style per produk beserta berkasnya (`_font_data_*`) | Selector style, default, dan weight nyata | P03, P05, P07, W03 |
| Kategori per produk beserta ancestors | Klasifikasi `kind` yang sah | W03, P14 |
| Atribut variasi selain lisensi | Memisahkan style dari variasi pembelian | W03, P16 |
| Harga Graphics Extended per produk | Pilihan pembelian Graphics | W22/S23 |
| Graphic murni gratis (C11) | Kasus freebie simple | Sesudah W03 |
| Jumlah gambar gallery penuh per produk | Urutan gallery asli | W03, P13 |
| Provider newsletter dan konfigurasi aktif | Subscription nyata | S16 |

## Daftar contoh yang masih menyimpan risiko

1. **C11 belum punya sampel terverifikasi.** Jangan menutup C11 dengan produk font gratis; kasusnya khusus Graphic sederhana.
2. **Nama style belum tentu berarti berkas terpisah.** Tropivera menyebut tiga bagian, tetapi apakah itu tiga berkas atau satu berkas dengan beberapa set glyph belum terbukti sampai berkasnya diperiksa.
3. **Klasifikasi Graphic belum bisa dipastikan dari subkategori.** Distressed Overlays muncul pada kategori `graphic`, tetapi juga pada `font`, `handwritten`, `script`, dan `signature`. `kind` harus ditentukan dari data staging, bukan dari daftar kategori yang terlihat di HTML.
4. **Harga berubah tanpa pemberitahuan.** Angka di dokumen ini adalah observasi satu tanggal; jangan dijadikan konstanta.
