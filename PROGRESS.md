# Rillatype Web Redesign — Progress Tracker

> 📌 **Satu-satunya source of truth untuk progress.**
> Update file ini SETIAP kali selesai ngerjain sesuatu. Jangan skip.
>
> Format: `Tanggal | Task # | Status ✅❌🔄 | Deskripsi | Notes | Durasi`
> Task lama memakai nomor dari `STATUS.md`. Redesign aktif memakai ID `R00` sampai `R25` beserta revisi `R05A` sampai `R05D` dari `REDESIGN-PLAN.md`.

## Redesign aktif: foundry editorial

Brief dan urutan pekerjaan berada di `REDESIGN-PLAN.md`. Aturan pencatatan berada di `docs/agents/redesign-rules.md`.
Tabel ini adalah sumber status redesign. Kriteria selesai berada pada masing-masing tugas dalam rencana.

| ID | Tugas | Status | Bukti atau pekerjaan tersisa |
| --- | --- | --- | --- |
| R00 | Dokumen persiapan dan GitHub | SELESAI | Pemeriksaan dokumen lulus. Commit 619afe5 berhasil dipush ke origin/master. |
| R01 | Audit sumber tema | SELESAI | docs/redesign-audit.md menetapkan sumber hasil ekstraksi berdasarkan riwayat perbaikan terbaru. |
| R02 | Lingkungan dan baseline | TERBLOKIR | Node tersedia. PHP tidak ada pada PATH. Akses staging dan baseline belum tersedia. |
| R03 | Produk dan alur pengunjung | SELESAI | PRODUCT.md berisi audiens, alur, batasan, bukti, serta keputusan terbuka. |
| R04 | Sistem visual | SELESAI | DESIGN.md mencatat fondasi CSS dan komponen. Browser desktop serta mobile diperiksa. |
| R05 | Preview homepage | SELESAI | Browser check lulus. Review preview berstatus ship. Persetujuan user tetap pada R07. |
| R05A | Revisi karakter homepage | SELESAI | Preview unggulan besar, tipografi tegas, serta koleksi pilihan dua kolom. Browser check dan review perbaikan lulus. Tinjauan user masih diperlukan. |
| R05B | Arah baru playful foundry | SELESAI | Versi dibuat dan diuji. Dua temuan hasil filter diperbaiki. User menolak keseluruhan UI dan UX; lanjut R05C. |
| R05C | Hierarki toko dan pencarian header | SELESAI | Search di header sticky, hasil selalu terlihat, dan navigasi Mango diperbaiki. Browser check dan review handoff lulus. Persetujuan visual user belum ada. |
| R05D | Desain baru foundry editorial | SELESAI | Homepage baru dan browser check tersedia. Review visual terpadu dilakukan setelah route detail R06 tersedia. User belum menyetujui tampilan. |
| R06 | Preview produk | SELESAI | 8 route detail, gallery Mango, lisensi contoh, tester nyata, state error, dan retry diperiksa. Data serta transaksi WooCommerce belum terhubung. |
| R07 | Persetujuan acuan desain | MENUNGGU USER | Homepage pengganti R05D dan detail produk R06 siap ditinjau. Belum ada persetujuan visual. |
| R08 | Fondasi, header, footer | BELUM | Terapkan ke tema resmi setelah persetujuan. |
| R09 | Homepage dinamis | BELUM | Hubungkan data produk asli. |
| R10 | Halaman produk dinamis | BELUM | Hubungkan gallery dan informasi produk. |
| R11 | Lisensi dan cart | BELUM | Periksa harga, validasi, dan item cart. |
| R12 | Font tester nyata | BELUM | Periksa aset, lazy loading, serta kegagalan font. |
| R13 | Katalog dan kategori | BELUM | Periksa grid, query, dan pagination. |
| R14 | Pencarian dan filter | BELUM | Periksa hasil, query, dan state kosong. |
| R15 | Freebies dan lisensi | BELUM | Hubungkan route dan aturan asli. |
| R16 | Cart | BELUM | Periksa perubahan item, coupon, dan total. |
| R17 | Checkout dan opsi akun | BELUM | Periksa tamu, akun baru, serta pelanggan lama. |
| R18 | Pembayaran dan konfirmasi | BELUM | Uji sandbox, status order, email, dan thank-you. |
| R19 | Akun dan unduhan | BELUM | Periksa riwayat, reset password, dan izin unduhan. |
| R20 | Halaman pendukung | BELUM | Periksa konten, legal links, dan 404. |
| R21 | Mobile dan aksesibilitas | BELUM | Periksa seluruh alur di mobile serta keyboard. |
| R22 | Performa | BELUM | Ukur dan bandingkan dengan baseline. |
| R23 | SEO dan regresi | BELUM | Periksa metadata serta alur pembelian penuh. |
| R24 | Persetujuan hasil | BELUM | Tinjau staging bersama user. |
| R25 | Paket dan handoff | BELUM | Siapkan paket, panduan, dan status rilis. |

### Log perubahan redesign

| Tanggal | ID | Perubahan dan file | Pemeriksaan dan hasil | Tersisa atau blocker | Langkah berikutnya |
| --- | --- | --- | --- | --- | --- |
| 2026-10-09 | R00 | Tulis REDESIGN-PLAN.md dan docs/agents/redesign-rules.md. Hubungkan AGENTS.md, PLAN.md, STATUS.md, serta tracker ini. | Periksa remote, branch master, status Git, rencana historis, dan lokasi tema. Temukan beberapa salinan tema yang perlu diaudit. | Belum memeriksa dokumen akhir atau push. UI belum diubah. | Periksa konsistensi tugas dan simpan dokumen ke GitHub. |
| 2026-10-09 | R00 | Periksa dokumen persiapan. User meminta langsung mulai setelah persiapan selesai. | git diff --check lulus. Rencana memiliki 26 ID R00 sampai R25 yang cocok dengan tabel status. Periksa aturan progress dan dependensi. | Commit dan push belum dijalankan. | Simpan persiapan, lalu mulai R01 tanpa meminta persetujuan ulang. |
| 2026-10-09 | R00 | Commit 619afe5 menyimpan dokumen persiapan dan konfigurasi skill. | Push awal gagal karena Git tidak mendapat credential. gh auth status menunjukkan akun rillatype aktif. Push dengan credential helper gh per-command berhasil ke origin/master tanpa mengubah git config. | Audit tema belum selesai. | Mulai R01. |
| 2026-10-09 | R01 | Tulis docs/redesign-audit.md. Pilih rillatype-v2-extracted/rillatype-v2-1 sebagai sumber kerja repo. | Bandingkan functions.php tiga lokasi, changelog, template, aset, script packaging, dan commit terbaru. Versi ekstraksi memiliki perbaikan checkout terakhir. | Packaging lama memakai path tidak berlaku dan operasi teks pada aset biner. Perbaikannya dijadwalkan R25. | Lanjut R02 untuk lingkungan dan R03 untuk fakta produk. |
| 2026-10-09 | R02 | Periksa runtime dan konfigurasi WordPress lokal. | node --version menghasilkan v24.19.0. php --version gagal. Tidak menemukan wp-config.php, compose, atau .wp-env.json pada pencarian repo. | URL staging, plugin aktif, baseline visual, dan transaksi sandbox belum tersedia. | Minta akses staging. R03 dapat berjalan tanpa staging. |
| 2026-10-09 | R03 | Tulis PRODUCT.md dari keputusan user dan audit repo. Petakan pencarian sampai unduhan. | Cocokkan audiens, WordPress, lisensi sebelum cart, akun opsional, warna preview, dan alur utama dengan jawaban user. Tandai fakta staging yang belum terverifikasi. | Harga dan ketentuan lisensi asli belum tersedia. | Lanjut R04 sesuai workflow desain. |
| 2026-10-09 | R04 | Catat docs/redesign-direction.md. User memilih katalog studio. | Jalankan concept-seed, baca craft-floor, dan konfirmasi komposisi melalui question tool. | User belum mengenal staging. Jelaskan sebagai website percobaan dan lanjut preview lokal dahulu. Fondasi UI belum dibuat. | Buat fondasi CSS serta preview homepage. |
| 2026-10-09 | R04 | Buat static/redesign/style.css dan components.html untuk memeriksa fondasi monokrom. | CSS native, system font untuk kontrol toko, focus ring, layout mobile, dan reduced motion tersedia. | Pemeriksaan browser belum dijalankan. | Periksa komponen pada desktop serta mobile sebelum R05. |
| 2026-10-09 | R04 | Catat fondasi yang dibangun dalam DESIGN.md. | Buka komponen di browser, periksa accessibility snapshot, overflow dan gambar pada 1262px serta 390px. Screenshot 1440px dan 390px dibaca. Tidak menemukan overflow atau gambar gagal. | Halaman penuh belum dibuat. Evaluasi pertama gagal karena quoting shell, kemudian pemeriksaan tanpa selector string berhasil. | Mulai R05. |
| 2026-10-09 | R05 | Buat static/redesign/index.html dan preview.js. Homepage memakai aset asli, pencarian lokal, filter kategori, hasil kosong, serta menu mobile. | Data harga, kategori, dan urutan ditandai sebagai contoh. Tidak menambah dependency frontend. | Pemeriksaan perilaku dan screenshot homepage belum dilakukan. Produk belum terhubung. | Jalankan pemeriksaan browser dan simpan hasil. |
| 2026-10-09 | R05 | Tambahkan scripts/check-redesign-preview.py dan perbaiki specificity tombol menu desktop. | Pemeriksaan browser pertama lulus untuk pencarian, filter, reset, gambar, overflow, reduced motion, dan error JS. Screenshot menemukan tombol Menu masih tampil di desktop; selector diperbaiki. Detector impeccable tidak melaporkan temuan. | Periksa ulang perbaikan menu desktop. | Jalankan satu konfirmasi browser, lalu review hasil. |
| 2026-10-09 | R05 | Selesaikan homepage dan dokumentasi sistem di DESIGN.md serta .impeccable/design.json. Perbaiki pencarian agar mencakup deskripsi style yang terlihat. | Browser check konfirmasi lulus termasuk menu desktop tersembunyi dan pencarian handwritten. Review agent terpisah memberi ship untuk R05; satu temuan pencarian dinilai resolved. Screenshot desktop dan mobile diperiksa. JSON serta token dokumen diperiksa oleh documenter. | Validasi schema resmi tidak tersedia pada CLI terpasang. Data contoh belum terhubung WooCommerce. R06 belum dibuat, R07 belum disetujui user. | Simpan hasil ke GitHub dan lanjut preview produk R06. |
| 2026-10-09 | R05A | Catat feedback user: minimal tetapi tetap wah. Tambahkan unit revisi sebelum R06. | Tinjau homepage, CSS, status Git, dan playbook bolder. Preview awal memakai grid seragam tanpa fokus visual produk pada pembukaan. | Revisi visual belum dibuat. | Letakkan font unggulan pada pembukaan dan bedakan skala koleksi pilihan. |
| 2026-10-09 | R05A | Ubah index.html dan CSS homepage. Mango menjadi preview besar di pembukaan; judul diperbesar; koleksi pilihan menjadi dua kolom besar. | Search tetap memakai DOM dan script yang sama. Data produk tidak diduplikasi. Tambahkan layout khusus saat filter menyembunyikan Mango. Tidak menambah library, font UI, atau aset. | Pemeriksaan browser revisi belum dijalankan. | Uji perilaku, viewport, dan screenshot. |
| 2026-10-09 | R05A | Periksa revisi serta perbaiki heading produk unggulan menjadi h2. | Browser check lulus termasuk state filter tanpa Mango pada 320px, 768px, 1024px, dan 1440px. Screenshot desktop/mobile diperiksa. Detector menemukan heading skip yang diperbaiki dan dokumentasi ukuran yang perlu diperbarui. | Konfirmasi setelah heading fix, review baru, dan sinkronisasi dokumen desain belum selesai. | Konfirmasi browser lalu catat sistem desain hasil revisi. |
| 2026-10-09 | R05A | Sinkronkan DESIGN.md dan sidecar dengan komposisi serta ukuran baru. Perbaiki submit pencarian agar menuju hasil pertama yang terlihat. | Review baru menilai komposisi lebih kuat dan menemukan scroll yang melewati Mango. Perbaikan berada pada handler submit bersama. Documenter memeriksa JSON, token, dan ukuran CSS. | Regression check submit dan verdict perbaikan belum selesai. | Periksa posisi hasil pencarian setelah submit, lalu simpan revisi. |
| 2026-10-09 | R05A | Selesaikan revisi homepage dan regression check submit. | Browser check lulus termasuk posisi Mango setelah Search. git diff --check lulus. Reviewer menilai temuan scroll resolved dan preview siap ditinjau user. | Penilaian apakah sudah cukup wah tetap keputusan user. Integrasi WordPress dan R06 belum selesai. | Commit dan push revisi, kemudian tampilkan link preview yang sama. |
| 2026-10-09 | R05B | Catat premis yang gagal: grid katalog netral dianggap cukup mewakili identitas brand. User memilih playful foundry dan satu aksen warna. | Audit struktur menunjukkan font Rillatype hanya hadir dalam gambar katalog, sementara headline dan brand tampil dengan font UI umum. Baca aset logo asli dan mockup Mango. | Implementasi baru belum dibuat. | Gunakan font asli, specimen yang dapat diganti, dan komposisi studio. |
| 2026-10-09 | R05B | Bangun ulang index.html dan tambah foundry.css. Pakai logo asli, lettering Mango lokal, bidang coral, specimen berganti, mockup, dan komposisi koleksi berbeda skala. Tambahkan MIME OTF pada server.js. | Reuse pencarian dan filter yang sudah ada. Harga serta mockup tetap diberi penjelasan. Tidak menambah dependency frontend. | Browser check dan pemeriksaan font nyata belum dijalankan. | Periksa preview arah baru dan fallback. |
| 2026-10-09 | R05B | Hapus aturan homepage lama yang sudah tidak digunakan. Perluas browser check untuk font dan pergantian sample. | Pemeriksaan awal menemukan perbandingan posisi scroll terlalu ketat pada nilai subpixel. Gunakan toleransi 1px. Pemeriksaan berikutnya lulus termasuk fallback font, siklus sample, viewport 320 sampai 1440px, pencarian, dan menu. Screenshot desktop/mobile diperiksa. | Detector menandai inset bidang full-width meski wrapper memberi jarak; perlu penilaian reviewer. Advisory token akan disinkronkan dengan arah baru. | Review hasil dan perbarui dokumentasi desain. |
| 2026-10-09 | R05B | Review arah playful foundry dan sinkronkan dokumen desain. User menjelaskan pertanyaan soal latar bukan permintaan tekstur. | Reviewer menyatakan inset hero cukup. Temukan jumlah hasil ikut tersembunyi pada filter tertentu dan anchor Mango menuju item tersembunyi. | Dua temuan fungsi perlu diperbaiki. User tetap tidak menyukai keseluruhan UI dan UX. | Perbaiki dua temuan tersebut, lalu jalankan revisi R05C dengan pencarian di header. |
| 2026-10-09 | R05B | Pindahkan jumlah hasil ke area tetap terlihat. Anchor Mango mereset filter melalui fungsi reset yang sama. | Regression check lulus termasuk count Script dan nol hasil, serta Mango kembali terlihat setelah diklik dari filter Script. Dua patch awal gagal karena konteks test tidak cocok; tidak mengubah file sampai patch benar. | User menolak versi secara visual. | Mulai R05C. |
| 2026-10-09 | R05C | Tetapkan revisi berdasarkan feedback keseluruhan dan posisi Find a font. | Pencarian perlu menjadi bagian header, bukan blok terpisah di bawah hero. | Layout baru belum dibuat. | Rapikan header, pembukaan, dan informasi koleksi. |
| 2026-10-09 | R05C | Pindahkan search ke header. Ganti pembukaan menjadi arahan memilih font. Pindahkan sample huruf ke produk Mango, hilangkan collage hero, dan rapikan bentuk kontrol serta metadata. | Search terlihat sebelum h1. Counter hasil berada di area filter yang selalu terlihat. Typeface Mango tetap menjadi identitas, coral digunakan untuk state dan specimen. | Pemeriksaan browser dan dokumen desain revisi belum selesai. | Periksa header desktop/mobile, filter, dan hasil pencarian. |
| 2026-10-09 | R05C | Jadikan header sticky dan beri jarak anchor agar hasil tidak tertutup header. Sinkronkan DESIGN.md serta sidecar dengan UI terbaru. | Browser check lulus termasuk search tetap terlihat saat scroll, target hasil berada di bawah header, count Script dan nol hasil, serta anchor Mango setelah filter. Review terpisah memberi PASS untuk handoff preview, bukan persetujuan visual. JSON, token, dan git diff --check lulus. | R06 dan integrasi WordPress belum dikerjakan. User belum menyetujui tampilan. | Commit dan push perubahan R05B/R05C, kemudian tampilkan preview terbaru. |
| 2026-10-09 | R05D | Catat penolakan user terhadap keseluruhan desain R05C. Tetapkan pengganti foundry editorial, aksen biru, dan font Manrope lokal. | Download Manrope variable dan OFL dari repo resmi Google Fonts berhasil. | Homepage pengganti belum dibuat. | Ganti visual world, lalu bangun jalur detail produk R06. |
| 2026-10-09 | R05D | Ganti index.html, hapus foundry.css, dan tambah editorial.css. Bawden menjadi font unggulan dengan artwork serta panel informasi. Kartu diarahkan ke route detail. | Pertahankan pencarian header dan filter. Hapus interaksi sample dari homepage. Manrope, lisensi, dan sumber aset tercatat. | Browser check baru belum dijalankan. Route detail akan dibuat pada R06 setelah pemeriksaan homepage. | Periksa layout pengganti, lalu kerjakan R06. |
| 2026-10-09 | R05D | Periksa homepage pengganti. | Browser check lulus untuk Manrope nyata dan fallback, pencarian, filter, count, menu, aset, reduced motion, dan viewport 320 sampai 1440px. Screenshot desktop/mobile dibaca. Lisensi OFL asli diperiksa. | Route detail belum tersedia. Review terpadu akan memeriksa homepage dan detail setelah R06. | Mulai R06 agar klik kartu membuka halaman produk. |
| 2026-10-09 | R06 | Tambahkan product.html dan product-preview.js. Semua kartu menuju detail berdasarkan slug yang diizinkan. Sediakan gallery, pilihan lisensi contoh, dan font tester nyata untuk Mango. | Gunakan textContent untuk input serta konten produk. Tidak ada transaksi, cart, atau pembayaran nyata. Produk tanpa specimen menampilkan state yang jelas. | Pemeriksaan browser detail belum dijalankan. | Uji link seluruh kartu, harga pilihan contoh, gallery, tester, unknown slug, dan font gagal. |
| 2026-10-09 | R06 | Periksa seluruh jalur detail dan rapikan harga opsi serta clearance anchor lisensi. | Browser check lulus untuk 8 route, gallery, harga contoh Mango extended $36, output teks literal, slider keyboard, unknown slug, font gagal, dan retry. Screenshot produk desktop/mobile dibaca. Detector meminta deklarasi token baru dan image src awal yang kini tersedia. | Konfirmasi setelah perapian, review, serta dokumentasi arah baru belum selesai. | Jalankan konfirmasi dan review terpadu. |
| 2026-10-09 | R06 | Tambahkan state informasi font tanpa mengarang format pembelian, weights, atau glyph. Perbaiki link lisensi pada unknown-product agar kembali ke informasi lisensi homepage. | Review terpadu menyatakan layout siap untuk tinjauan user dan menemukan satu link menuju area tersembunyi pada unknown slug. Dokumentasi baru mencatat Manrope, biru, komposisi, serta prototype detail. | Regression unknown-product setelah perbaikan belum dijalankan. Data produk asli tetap belum terhubung. | Periksa error navigation dan simpan hasil. |
| 2026-10-09 | R06 | Selesaikan preview detail dan dokumen desain. Koreksi atribusi bukti agar jelas bahwa agent, bukan user, menjalankan test. | Full browser check PASS, termasuk unknown slug yang kembali ke homepage Licenses. Reviewer menilai temuan resolved dan memberikan PASS untuk handoff preview. JSON dan token diperiksa; git diff --check lulus. | Spesifikasi produk serta aturan lisensi asli masih menunggu data toko. Tidak ada transaksi nyata. User belum menyetujui tampilan. | Simpan R05D/R06 ke GitHub dan minta tinjauan R07. |
| 2026-10-09 | R05D | Rapikan satu trailing space pada salinan OFL Manrope tanpa mengubah teks lisensi. | Pemeriksaan staged diff menemukan whitespace pada file lisensi unduhan. Baris tersebut diperbaiki sebelum commit. | Push hasil menunggu commit. | Simpan homepage dan detail produk bersama progress. |

### Handoff aktif

- Tugas berikutnya: R07, tinjauan user atas homepage pengganti dan detail produk.
- Preview tersedia di http://localhost:9402/static/redesign/index.html.
- Sumber tema: rillatype-v2-extracted/rillatype-v2-1/. Lihat docs/redesign-audit.md.
- Preview detail: http://localhost:9402/static/redesign/product.html?font=mango. Semua kartu memiliki route detail.
- Staging, sumber lisensi, aset font, dan konfigurasi pembayaran belum diverifikasi.
- Server preview lokal sebelumnya sudah dihentikan atas permintaan user.
- Server preview dijalankan kembali untuk memeriksa fondasi dan homepage redesign. Port 9402 aktif selama sesi ini.
- Konfigurasi skill sebelumnya di AGENTS.md dan docs/agents/ ikut disimpan bersama dokumen persiapan.

Bagian berikut menyimpan riwayat pekerjaan sebelum brief redesign ini.

---

## Progress Log

| Tanggal | Task | Status | Deskripsi | Notes | Durasi |
|---------|------|--------|-----------|-------|--------|
| 2026-06-10 | — | ✅ | PLAN.md + PROMPT.md selesai | Blueprint awal | — |
| 2026-06-10 | — | ✅ | Homepage + Product page prototype v1 (playful) | — | — |
| 2026-06-10 | — | ✅ | Homepage + Product page prototype v2 (bright, anti-template) | Notion+Figma taste | — |
| 2026-06-10 | — | ✅ | WordPress theme framework (40+ files) | struktur dasar | — |
| 2026-06-10 | — | ✅ | STATUS.md + PROGRESS.md + GitHub push | handoff siap | — |
| 2026-06-11 | — | ✅ | Hero tag → "The un-curated type foundry" + Opsi C headlines | index-playful.html + v2 | — |
| 2026-06-11 | — | ✅ | Remove "Meet the maker" CTA + ghost CSS | both files | — |
| 2026-06-11 | — | ✅ | "Behind the type" → "License & perks" section | both files | — |
| 2026-06-11 | — | ✅ | Featured cards: white bg, border, shadow, prominent name/price | both files | — |
| 2026-06-11 | — | ✅ | Freebies card → no frame (image+text stacked) + better name | both files | — |
| 2026-06-11 | — | ✅ | Fresh Drops: card frame + name left / price right | both files | — |
| 2026-06-11 | — | ✅ | Blog section redesigned (lighter, hover bg, blog-box container) | both files | — |
| 2026-06-11 | — | ✅ | Custom License CTA section added | both files | — |
| 2026-06-11 | — | ✅ | Categories: auto from WooCommerce categories | front-page.php | — |
| 2026-06-11 | — | ✅ | ACF: Homepage Sections options page (Featured, Free, Fresh, Sale) | inc/acf-setup.php | — |
| 2026-06-11 | — | ✅ | front-page.php: dynamic queries for Free/Fresh/Sale | front-page.php | — |
| 2026-06-11 | — | ✅ | home.css: product card system, blog, license CTA styles | assets/css/home.css | — |
| 2026-06-11 | — | ✅ | Micro-animations (6): staggered entrance, category hover, badge pulse, CTA arrow, label line, header blur | index-playful.html + v2 | — |
| 2026-06-11 | #3 | ✅ | Shop page: archive-product.php, content-product.php, loop overrides, woocommerce.css, static/shop-playful.html | Playful grid + category pills + pagination | — |
| 2026-06-11 | #3 | ✅ | Shop: woocommerce.css rewrite — proper variables, product cards (white bg, border, shadow, hover lift), category pills, staggered animation, responsive grid | — | 30m |
| 2026-06-11 | #3 | ✅ | Shop: main.js — sticky header scroll effect + staggered card IntersectionObserver | — | 5m |
| 2026-06-11 | — | ✅ | header.php — fix nav structure cocok sama CSS (nav, nav-logo, nav-links, menu-toggle) | sebelumnya pake .header-inner yang ga match CSS | 10m |
| 2026-06-11 | — | ✅ | static/index-premium.html — Ethereal Glass dark mode, floating glass nav, asymmetrical bento grid, scroll reveal, double-bezel cards | high-end-visual-design skill | 20m |
| 2026-06-11 | — | ✅ | static/index-premium-light.html — Editorial Luxury light, Instrument Serif, bento grid, soft shadow | high-end-visual-design skill | 15m |
| 2026-06-11 | #3 | ✅ | Shop: image zoom on hover (transform scale 1.06) | woocommerce.css, preview.html | 5m |
| 2026-06-11 | #3 | ✅ | Shop: quick add-to-cart — icon circle bottom-right, fade in on hover | content-product.php, woocommerce.css, preview.html | 15m |
| 2026-06-11 | — | ✅ | preview.html — full shop demo page with real preview images, live nav, sticky header | standalone static, gak nimpa file WordPress | 20m |
| 2026-06-11 | #5 | ✅ | Register product ACF fields (specimen_regular_url, specimen_bold_url, formats, glyphs, weights) | inc/acf-setup.php — muncul di admin edit produk | 10m |
| 2026-06-11 | #6 | ✅ | Cart page override (cart.php, mini-cart.php) | woocommerce/cart/ | 25m |
| 2026-06-11 | #7 | ✅ | Checkout page override (form-checkout.php, thankyou.php) | woocommerce/checkout/ | 20m |
| 2026-06-11 | #8 | ✅ | My Account pages (login, dashboard, orders, downloads, addresses, view-order) | woocommerce/myaccount/ — 6 templates | 30m |
| 2026-06-11 | — | ✅ | woocommerce-forms.css — 350+ lines: cart, checkout, account, tables, notices, form fields, responsive | assets/css/woocommerce-forms.css | 20m |
| 2026-06-11 | — | ✅ | functions.php — enqueue forms CSS, mini-cart fragment refresh, account nav reorder | WooCommerce hooks | 10m |
| 2026-06-11 | #3 | ✅ | front-page.php — enhanced font tester section (slider, style buttons, presets) | matches existing JS capabilities | 10m |
| 2026-06-11 | — | ✅ | Navbar Sign In pill button — 11 static files + WordPress header + main.css | coral/charcoal pill, replaces "Account" text | 20m |
| 2026-06-11 | — | ✅ | page.php — static pages template | container + article + content | 5m |
| 2026-06-11 | — | ✅ | search.php — search results with empty state | pagination, post type label | 5m |
| 2026-06-11 | — | ✅ | archive.php — category/tag/author archives | title, excerpt, meta, pagination | 5m |
| 2026-06-11 | — | ✅ | footer.php — redesigned with footer-links matching static design | License, Privacy, Contact | 5m |
| 2026-06-11 | — | ✅ | main.css — footer, page/search/archive/pagination styles | 140+ lines new CSS | 10m |
| 2026-06-11 | — | ✅ | woocommerce-hooks.php — suppress default breadcrumb | biar ga dobel sama custom breadcrumb | 2m |
| 2026-06-11 | — | ✅ | style.css — hapus dead `:root` variables (--color-*) | redundant, gak dipake CSS lain | 2m |
| 2026-06-11 | — | ✅ | home.css — hapus `:root`, standardisasi variabel ke main.css | --coral→--accent, --charcoal→--text, --cream→--bg-alt, --sand→--bg, --border-light→--border, --bg-page→--bg, --coral-soft→--accent-soft | 5m |
| 2026-06-11 | — | ✅ | home.css — rename .category-link → .category-pill | konflik nama sama category-links.css, pill button pecah | 2m |
| 2026-06-11 | — | ✅ | front-page.php — update .category-link → .category-pill | 2 replacement | 1m |
| 2026-06-11 | — | ✅ | main.css — tambah --accent-soft: #FEF2EF | dipake product.css, gak didefinisikan | 1m |
| 2026-06-11 | — | ✅ | product.css — fix fallback --accent: #e0553d → #C1493A | 11 replacement, old hex dari home.css lama | 2m |
| 2026-06-11 | — | ✅ | functions.php — hapus jQuery dependency main.js & font-tester.js | vanilla JS, gak pake jQuery | 1m |
| 2026-06-11 | — | ✅ | home.css — hapus .container override | udah didefinisikan di main.css | 1m |
| 2026-06-11 | — | ✅ | woocommerce.css — standardisasi fallback values | hapus inconsistent fallback hex | 3m |
| 2026-06-11 | — | ✅ | woocommerce-forms.css — standardisasi fallback values | hapus inconsistent fallback hex, --border-light→--border | 5m |
| 2026-06-11 | — | ✅ | Full CSS audit — single source of truth variabel | main.css = satu-satunya `:root`, semua file pake var() dari sana | 25m |

---

## Priority Queue

| Urut | Task | Priority | Notes |
|------|------|----------|-------|
| #1 | Generate WOFF2 specimen + integrate font tester | 🔴 HIGH | Font tester ga jalan tanpa real font URL |
| #2 | front-page.php → real product data | 🔴 HIGH | Homepage masih placeholder |
| #3 | Isi ACF fields → data tiap produk | 🟡 MED | specimen_regular_url, formats, dll — per produk |
| #4 | Checkout: setup payment gateway (Stripe/ lainnya) | 🟢 LOW | Biar bisa transaksi beneran |
| #5 | Performance (WP Rocket, Imagify, WebP) | 🟢 LOW | Optional |
| #6 | SEO metadata + SEOPress | 🟢 LOW | Biar terindex Google |
| #7 | Migration → staging → live | 🟢 LOW | Launch |

---

## Template Entry

Copy-paste ini ke tabel di atas:

```markdown
| 2026-06-11 | #1 | ✅ | Generate WOFF2 specimen for Mango Letters | pyftsubset berhasil, file 12KB | 30m |
| 2026-06-11 | #2 | 🔄 | front-page.php — fetching real products | masih error di WP_Query | 45m |
```

Atau format ringkas (kalau males tabel):

```markdown
2026-06-11  #1  ✅  Generate WOFF2 specimen for Mango Letters (12KB) — 30m
2026-06-11  #2  ❌  front-page.php — WP_Query returns empty. Harus debug dulu.
```
