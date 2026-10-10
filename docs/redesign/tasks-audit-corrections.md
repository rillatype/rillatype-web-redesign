# Buku koreksi audit preview

Revisi rencana atas permintaan user, 10 Oktober 2026. Dokumen ini menambah A01–A07 pada 73 task utama, tanpa mengganti atau menomori ulang P/W/S. Status setiap task hanya ada di `PROGRESS.md`. Penulisan kartu tidak berarti bug sudah diperbaiki atau agent sudah ditugaskan mengimplementasikannya.

## Baca dan kerjakan satu kartu

1. Baca `AGENTS.md`, `rules.md`, bagian koreksi audit dan handoff terkini di `PROGRESS.md`, serta `execution-plan.md`.
2. Baca kartu yang ditugaskan dan laporan `docs/reports/<ID>.md` jika sudah ada.
3. Periksa kondisi Git dan dependensi. Catat mulai dengan waktu sistem Asia/Jakarta, lalu simpan status BERJALAN dan laporan sebelum mengubah source.
4. Ambil baseline dari source yang benar-benar dilayani server. Catat base URL, HEAD, file lokal berubah, viewport, dan versi browser.
5. Tulis atau perluas test pada perilaku yang disebut kartu. Jalankan test pada kode lama sebelum fix.
6. Catat kegagalan nyata. Jika probe memakai selector salah atau route delay tidak berlaku, perbaiki probe terlebih dahulu dan ulangi baseline.
7. Buat perubahan terkecil pada file yang diizinkan. Jalankan test yang sama dan regresi kartu.
8. Lengkapi laporan, status, pemeriksaan diff, dan handoff. Berhenti setelah satu kartu. Task berikutnya membutuhkan penugasan sesuai AGENTS.md.

Urutan wajib adalah A01, A02, A03, A04, A05, A06, lalu A07. Jangan mulai fitur P12–P20 sebelum A07 SELESAI. W01–W04 tetap boleh dipersiapkan jika ditugaskan user dan dependensinya selesai, tanpa mengedit tema sebelum P20.

P05, P07, P09, dan P11 dibuka ulang. Implementasi koreksinya dilakukan lewat A02–A06, bukan dengan mengulang seluruh pekerjaan P lama. A07 memverifikasi acceptance P lama dan menutup ulang satu per satu jika bukti cukup. Dependensi A tidak memakai status P yang dibuka ulang, sehingga tidak ada siklus.

## Bukti audit yang harus dipertahankan

Audit dilakukan pada HEAD `1e6037e` dan preview lokal `http://127.0.0.1:9402/static/redesign`. Lokasi baris di bawah adalah petunjuk pada baseline itu. Cari simbol aktual sebelum mengedit.

| Kasus | Bukti audit | Kartu |
| --- | --- | --- |
| Assertion selalu PASS | Lima `or True` pada baseline: `check-homepage-data.py` baris 77 dan 235, `_p03_verify.py` baris 51, `check-weight-controls.py` baris 49, dan `check-tester-single-style.py` baris 68 | A01 |
| Thin salah diproses | Runtime: selector `0`, status SemiBold, tidak ada OTF Thin baru. Handler memakai `Number(value) || defaultIndex` | A02 |
| Glyph memakai font UI | Runtime: sample memakai Rilla-Chronoa, sel `.glyph-cell` memakai Manrope | A03 |
| Retry homepage gagal | Runtime: sesudah koneksi pulih dan cut gagal dipilih lagi, state tetap error dan request tidak bertambah | A04 |
| Fakta lama dapat menimpa fakta baru | Analisis source: `refreshFacts()` mengubah DOM sebelum pemeriksaan request setelah await. Belum direproduksi runtime saat audit | A05 |
| Font default gagal menghilangkan kontrol | Runtime: abort SemiBold pada halaman baru membuat frame dan selector tidak terlihat, meski pesan meminta memilih cut lain | A06 |
| Timestamp dan handoff tidak konsisten | P10 mengaku diperbarui 11:20, commit 10:14. P11 mengaku diperbarui 10:58, commit 10:36. Urutan commit berantai, bukan bukti agent bekerja bersamaan | A07 |


## Command pemeriksaan yang dirujuk kartu

Jalankan dari root workspace menggunakan PowerShell. Periksa base URL dan efek samping setiap suite terlebih dahulu sesuai rules.md. Tabel ini memetakan nama singkat ke entry point, bukan perintah menjalankan semua suite pada setiap task.

| Nama pada kartu | Command |
| --- | --- |
| homepage-data | `python scripts/check-homepage-data.py` |
| data P03 | `python scripts/_p03_verify.py` |
| specimen-home | `python scripts/check-specimen-home.py` |
| specimen-states | `python scripts/check-specimen-states.py` |
| single-style | `python scripts/check-tester-single-style.py` |
| styles | `python scripts/check-tester-styles.py` |
| weight-controls | `python scripts/check-weight-controls.py` |
| glyph-facts | `python scripts/check-glyph-facts.py` |
| load-states | `python scripts/check-tester-load-states.py` |
| artwork-integrity | `python scripts/check-artwork-integrity.py` |
| mixed-family | `python scripts/check-tester-mixed-family.py` |
| smoke route | `python scripts/_p03_smoke.py` |

Setelah setiap command native, simpan `$LASTEXITCODE` sebelum command lain menimpanya. Contoh: `python scripts/check-tester-styles.py; $code = $LASTEXITCODE; Write-Output "styles exit=$code"`. Jika exit nonzero, baca output dan catat FAIL atau BLOCKED sesuai kontrak suite. Jangan membungkus semua command sehingga exit terakhir menyembunyikan kegagalan sebelumnya.

Port 9402 adalah baseline audit, bukan jaminan server tersedia. Jika listener belum ada, verifikasi server workspace sesuai task sebelum memakai URL. Jangan menguji server proyek lain yang kebetulan memakai port itu.
Jika pemeriksaan scope melihat perubahan dokumen yang sudah ada sebelum task, catat baseline dan bedakan delta task. Jangan memperluas allowlist secara menyeluruh hanya agar PASS. Source tema berubah tanpa izin tetap FAIL.
Suite saat audit tetap melaporkan homepage 68/68, data P03 166/166, single-style 27/27, styles 29/29, dan load-states 16/16 PASS. Angka ini baseline historis, bukan target jumlah assertion baru. Setelah assertion dummy dibuang, total `check-homepage-data.py`, `_p03_verify.py`, `check-tester-single-style.py`, dan `check-weight-controls.py` memang turun; angka lama tidak boleh dikejar. `_p03_verify.py` memanggil suite lain yang menulis screenshot di `.impeccable/review/`. Periksa efek samping sebelum menjalankan command.

## A01. Perbaiki kejujuran assertion dan bukti test

Dependensi: P01/P02/P03/P04/P10.

Baca: `scripts/check-homepage-data.py`, `scripts/_p03_verify.py`, `scripts/check-specimen-home.py`, `scripts/check-specimen-states.py`, `scripts/check-tester-single-style.py`, `scripts/check-weight-controls.py`, serta laporan P03/P04/P07/P11.

File yang boleh diubah: `scripts/check-homepage-data.py`, `scripts/_p03_verify.py`, `scripts/check-tester-single-style.py`, `scripts/check-weight-controls.py`, `docs/reports/A01.md`, `PROGRESS.md`. Tambahkan test kontrol negatif yang dapat dijalankan ulang pada `scripts/check-audit-assertions.py` jika pemeriksaan tidak dapat ditaruh di suite tersebut. Source preview tidak boleh diubah pada A01. Menyentuh suite P07 hanya untuk kebersihan bukti; penutupan ulang P07 tetap terjadi di A07.

Langkah:

1. Tunjukkan kelima assertion `or True` pada baseline, termasuk `check-weight-controls.py` baris 49 yang memakai `replace("extralight", "extralight")` tanpa efek dan `check-tester-single-style.py` baris 68 yang menguji `page.url` untuk properti CSS. Jelaskan kondisi apa yang seharusnya membuat tiap assertion gagal.
2. Bedakan pemeriksaan katalog homepage dari katalog statis. `catalog.html` tidak wajib memuat `font-catalog.js` hanya untuk memenuhi assertion historis.
3. Jika pemeriksaan tidak mewakili requirement, hapus dari penghitung dan catat alasan. Jika requirement nyata ada, ganti dengan assertion yang mengukur hasilnya. Informasi atau SKIP bukan PASS.
4. Pertahankan pemeriksaan runtime yang menghapus Thin dari data dan menuntut picker kehilangan 100. Hapus assertion dummy tambahan atau ganti dengan pemeriksaan yang benar-benar berbeda.
5. Pada permalink, periksa keunikan produk live dengan data literal. Entri demo boleh berbagi URL referensi jika jelas ditandai demo. Jangan menuntut uniqueness demo yang tidak diminta.
6. Gunakan data rusak hanya di memory, proses anak, route override, atau salinan scratch. Duplikasi permalink live atau hilangkan cut dari data tanpa memperbarui hasil halaman. Buktikan assertion yang dipertahankan menolak keadaan salah itu dengan exit nonzero.
7. Jalankan ulang dua suite pada data benar. Catat total aktual yang berubah setelah assertion dummy dibuang. Jangan mengubah label supaya jumlah kembali 68 atau 166.
8. Catat lokasi output sementara dan suite anak. A01 tidak membuat semua suite menjadi read-only dan tidak perlu merombak toolchain.

Bukti selesai:

- Kelima assertion dummy sudah tidak dihitung sebagai PASS. Total `check-tester-single-style.py` dan `check-weight-controls.py` ikut turun; angka lama 27/27 dan 22/22 tidak boleh dipulihkan dengan label.
- Setiap penggantinya gagal terhadap kontrol negatif yang sesuai, atau penghapusannya dijelaskan sebagai pemeriksaan tidak berlaku atau duplikat.
- `check-homepage-data.py` dan `_p03_verify.py` lulus terhadap fixture benar.
- Output negatif dan positif menyebut command, exit code, HEAD, kondisi data, dan label assertion.
- `git diff --check` lulus. Tidak ada source, aset, atau harga berubah.

Next action: simpan handoff A01. A02 adalah kandidat berikutnya, bukan otomatis dikerjakan.

## A02. Pilih berkas benar untuk style indeks nol

Dependensi: A01.

Baca: `product-preview.js` khusus `loadStyles`, handler `change`, `activeStyle`, `selectStyle`, dan `styleUrl`; data Chronoa pada `font-catalog.js`; `check-tester-styles.py` dan `check-tester-load-states.py`.

File yang boleh diubah: `static/redesign/product-preview.js`, `scripts/check-tester-styles.py`, `scripts/check-tester-load-states.py`, `docs/reports/A02.md`, `PROGRESS.md`.

Langkah:

1. Buka context browser baru pada `product.html?font=chronoa`. Tunggu default SemiBold siap. Catat request font default.
2. Pilih `#sample-style` dengan value `0`, yaitu Thin. Kode lama harus terbukti gagal karena status menyebut SemiBold dan tidak memuat OTF Thin melalui loader produk.
3. Tulis assertion yang memeriksa sekaligus selector Thin, URL `Chronoa-Thin.otf`, status Thin, weight 100, dan family produk yang sudah loaded.
4. Ingat CSS dapat memuat subset WOFF2 Thin meskipun handler salah. Computed weight 100 atau adanya WOFF2 bukan pengganti bukti request OTF yang dipilih `styleUrl`.
5. Perbaiki pemetaan nilai selector sehingga indeks valid `0` tetap `0`. Cari jalur awal, change, dan retry yang memakai pola yang sama. Validasi nilai di batas input bila diperlukan, bukan menambah dua sumber active style.
6. Uji urutan SemiBold, Thin, Bold, Thin. Pertahankan teks literal, size, leading, tracking, alignment, theme, dan pilihan lisensi.
7. Dalam context baru, abort OTF Thin, pilih Thin sampai error, pulihkan route, lalu retry. Retry harus meminta Thin, bukan SemiBold.
8. Jalankan single-style, styles, weight-controls, dan load-states. Jalankan `node --check static/redesign/product-preview.js` serta `git diff --check`.

Bukti selesai:

- Test indeks nol gagal sebelum fix dan lulus sesudahnya dengan request `Chronoa-Thin.otf` yang berhasil.
- Status, selector, file, family, dan weight menunjuk cut yang sama. Round-trip serta retry mempertahankan Thin.
- Mango tetap satu style tanpa selector yang tidak berguna.
- State input dan lisensi tidak berubah saat memilih style.

Next action: handoff A02, kemudian A03 jika ditugaskan. P05/P07 belum ditutup ulang sampai A07.

## A03. Render glyph dengan font dan cut aktif

Dependensi: A02.

Baca: `product-preview.js` khusus `renderGlyphs`/`refreshFacts`, `tester-core.js`, `product.html`, `editorial.css`, dan `scripts/check-glyph-facts.py`.

File yang boleh diubah: `static/redesign/product-preview.js`, `static/redesign/editorial.css` hanya untuk styling glyph yang diperlukan, `scripts/check-glyph-facts.py`, `docs/reports/A03.md`, `PROGRESS.md`.

Langkah:

1. Buka Chronoa lalu panel All glyphs. Ukur computed `font-family`, `font-weight`, dan `font-style` pada `.glyph-cell`, bukan hanya pada sample.
2. Catat FAIL baseline ketika sel memakai Manrope, meskipun jumlahnya 218. Ulangi untuk Mango dengan 181 karakter.
3. Terapkan family dan cut aktif pada grid atau sel. Gunakan konfigurasi font yang sama dengan sample, bukan nama hardcoded untuk Chronoa/Mango.
4. Pilih Thin lalu Black. Pastikan computed weight grid berpindah 100 lalu 900 dan face terkait sudah loaded. Mango memakai family Mango dan weight 400.
5. Pertahankan jumlah codepoint dari berkas aktif. Bedakan jumlah glyph font, misalnya 219 Chronoa, dari 218 codepoint yang ditampilkan sebagai karakter.
6. Saat font belum berhasil dimuat atau gagal, tampilkan unavailable/loading atau sembunyikan sel yang tidak dapat dipercaya. Jangan menampilkan Manrope seolah itu glyph produk.
7. Uji panel buka/tutup pada 1440px dan 390px. Periksa glyph yang terlihat, count, tinggi panel, overflow, dan perpindahan style.
8. Jalankan glyph-facts, single-style, styles, `node --check`, dan `git diff --check`.

Bukti selesai:

- Test family glyph gagal sebelum fix dan lulus sesudahnya untuk Chronoa dan Mango.
- Sel benar-benar menggunakan face yang loaded, dengan cut aktif. Tidak cukup hanya menaruh family pada stack CSS.
- Count tetap sesuai berkas. Panel buka/tutup dan mobile tidak regresi.
- Bagian glyph/OpenType P08 hanya dapat diklaim untuk font yang berkasnya tersedia. Dingbats C05 tetap TERBLOKIR.

Next action: handoff A03, kemudian A04 jika ditugaskan.

## A04. Coba ulang cut homepage yang pernah gagal

Dependensi: A03.

Baca: `preview.js` khusus `registerFace`, `inFlight`, `loadedFaces`, `showSpecimen`, dan handlers picker; `check-specimen-states.py`; data web cut.

File yang boleh diubah: `static/redesign/preview.js`, `scripts/check-specimen-states.py`, `docs/reports/A04.md`, `PROGRESS.md`.

Langkah:

1. Pakai context baru. Abort `chronoa-semibold.woff2` sebelum membuka homepage. Tunggu frame error dan catat jumlah request URL itu.
2. Pulihkan jaringan dengan melepas route abort. Pilih weight 400 hingga ready, lalu kembali ke 600. Test menuntut request baru untuk SemiBold dan akhirnya state ready.
3. Catat FAIL kode lama ketika jumlah request tidak bertambah dan state tetap error. Kembali ke cut 400 yang sudah sehat bukan bukti retry cut 600.
4. Perbaiki lifecycle cache agar Promise rejected tidak dipakai permanen. Tetap deduplikasi request yang benar-benar sedang berjalan dan cache face yang sudah berhasil.
5. Hindari menghapus entry milik request baru dari cleanup request lama. Jika ada shared Promise, cleanup harus berlaku untuk entry yang sama.
6. Ulangi cold abort cut Black 900. Pulihkan, pilih 600, kembali 900. Keduanya harus dapat memuat ulang tanpa reload halaman.
7. Ketik teks sebelum kegagalan. Pastikan teks tetap utuh setelah error dan retry. Pilih cut cepat saat cut lama tertunda. Respons lama tidak boleh mengganti cut terbaru.
8. Jalankan specimen-states, specimen-home, homepage-data yang sudah diperbaiki A01, weight-controls, `node --check`, dan `git diff --check`.

Bukti selesai:

- Dua cut yang pernah gagal membuat request baru sesudah route dipulihkan dan kembali ready.
- Browser tidak perlu reload untuk pemulihan. Family, weight, fakta, dan teks sesuai cut yang dicoba ulang.
- Request sukses tidak dimuat ulang tanpa alasan. Respons lama tidak menimpa pilihan terbaru.
- Baseline FAIL dan hasil PASS memakai skenario cut gagal yang sama.

Next action: handoff A04, kemudian A05 jika ditugaskan.

## A05. Cegah fakta style lama menimpa pilihan terbaru

Dependensi: A04.

Baca: `product-preview.js` khusus `selectStyle`, `refreshFacts`, `configureFeature`, `renderGlyphs`; `tester-core.js`; `check-tester-load-states.py` dan `check-glyph-facts.py`.

File yang boleh diubah: `static/redesign/product-preview.js`, `scripts/check-tester-load-states.py`, `docs/reports/A05.md`, `PROGRESS.md`. Jika test perlu helper terpisah, gunakan `scripts/check-tester-fact-races.py`. Jangan mengubah parser hanya untuk membuat race terlihat.

Langkah:

1. Perlakukan temuan ini sebagai hipotesis source yang belum direproduksi runtime. Jangan menulis bahwa FAIL sudah diamati sebelum menjalankan probe.
2. Pasang delay terkontrol pada request parser Light, tetapi biarkan FontFace Light selesai. Bedakan jenis request lewat instrumentation atau urutan request yang dibuktikan, bukan asumsi delay 1 detik.
3. Pilih Light, lalu ExtraBold. Pastikan ExtraBold sudah ready dengan 218 karakter sebelum respons parser Light dilepas.
4. Lepas respons lama sebagai kegagalan pembacaan glyph. Baseline harus menunjukkan fakta berubah menjadi unavailable meskipun ExtraBold aktif. Simpan urutan request beserta waktu dan snapshot state.
5. Untuk feature, pakai route override hasil parser test-only yang membedakan dua pilihan, atau berkas nyata dengan fitur berbeda. Label fixture parser sintetis secara jelas. Jangan mengklaim Chronoa punya fitur yang tidak ada.
6. Periksa selector, family, weight, status, jumlah dan font glyph, disabled state feature, serta pilihan toggle sesudah respons lama tiba. Assertion weight 800 saja tidak cukup.
7. Perbaiki penjaga request sebelum setiap mutasi DOM yang bergantung pada await. Pembacaan fakta boleh di-cache, tetapi hanya request aktif yang boleh merendernya. Jangan menambah arsitektur baru untuk perbaikan ini.
8. Jika probe tidak dapat membuka race, periksa handler route dan logging. Jika source nyata ternyata sudah aman, simpan test yang membuktikan itu dan tutup sebagai TIDAK TERREPRODUKSI dengan bukti, tanpa fix spekulatif. Jika bukti tetap belum cukup, status TERBLOKIR dan A07 tidak boleh dibuka.
9. Jalankan race berkali-kali pada success-late dan failure-late. Jalankan load-states, glyph-facts, styles, `node --check`, dan `git diff --check`.

Bukti selesai:

- Ada FAIL/PASS untuk overwrite fakta yang direproduksi, atau kesimpulan TIDAK TERREPRODUKSI yang membuktikan skenario dan source sudah aman.
- Kegagalan lama tidak mengosongkan glyph pilihan terbaru. Feature lama tidak mengubah supported state terbaru.
- Skenario benar-benar menunda parser yang dimaksud. Tidak ada false PASS akibat route override lain atau callback yang belum pernah berjalan.
- Metadata sintetis tetap test-only, tidak masuk katalog atau klaim produk.

Next action: handoff A05, kemudian A06 jika ditugaskan.

## A06. Pertahankan kontrol saat font default gagal

Dependensi: A05.

Baca: `product-preview.js` khusus initial load/catch/retry, markup `#tester-frame` dan `#sample-style` di `product.html`, aturan error pada `editorial.css`, serta test styles/load-states.

File yang boleh diubah: `static/redesign/product-preview.js`, `static/redesign/product.html` atau `editorial.css` hanya jika state kontrol membutuhkannya, `scripts/check-tester-load-states.py`, `docs/reports/A06.md`, `PROGRESS.md`.

Langkah:

1. Context baru, abort `Chronoa-SemiBold.otf` sebelum navigasi ke `product.html?font=chronoa`. Jangan memuat default sehat terlebih dahulu.
2. Tunggu status gagal. Ukur visibility frame, input teks, selector, retry, dan sample. Kode lama harus FAIL karena frame dan selector tidak terlihat.
3. Tuntut kontrol tetap tersedia, sample tidak dipercaya tersembunyi, pesan error jelas, dan retry dapat dicapai keyboard.
4. Tetap block SemiBold, lalu pilih Bold. Bold harus meminta berkas sendiri dan siap. Tidak perlu pulihkan jaringan untuk cut lain yang sehat.
5. Dalam context baru, gagalkan default lalu pulihkan route dan retry tanpa mengganti style. Hasil harus SemiBold, bukan cut pertama lain.
6. Untuk Mango satu style, gagalkan `mango-letter.otf`. Input dan retry tetap dapat digunakan tanpa membuat selector satu opsi. Setelah pulih, teks yang diketik saat error tetap ada.
7. Perbaiki state kontrol pada batas yang bertanggung jawab. Font gagal tidak boleh menampilkan font UI sebagai specimen. Frame kontrol yang terlihat tidak berarti sample error harus terlihat.
8. Uji 1440px dan 390px, input literal, clear/retype, theme, focus keyboard, dan kondisi produk tanpa berkas sama sekali. Unavailable asset tetap dibedakan dari kegagalan jaringan.
9. Jalankan load-states, styles, single-style, glyph-facts, `node --check`, dan `git diff --check`.

Bukti selesai:

- Test cold-default failure gagal sebelum fix dan lulus sesudahnya untuk Chronoa dan Mango.
- Cut lain yang sehat bisa dipilih saat default gagal. Retry default memuat cut yang benar.
- Teks pengguna bertahan, kontrol dapat digunakan, dan sample gagal tidak berpura-pura menjadi produk.
- Tidak ada dropdown style baru untuk Mango atau produk tanpa specimen.

Next action: handoff A06. A07 melakukan verifikasi akhir, bukan penambahan fitur.

## A07. Verifikasi ulang acceptance dan luruskan handoff

Dependensi: A01/A02/A03/A04/A05/A06.

Baca: seluruh laporan A01–A06, laporan P03/P05/P07/P08/P09/P10/P11, tabel status dan handoff PROGRESS.md, serta kartu P yang dibuka ulang.

File yang boleh diubah: `PROGRESS.md`, `docs/reports/A07.md`, laporan P03/P05/P07/P08/P09/P10/P11 hanya untuk addendum bertimestamp baru, dan `DESIGN.md` hanya bila penjelasan tester sudah tidak sesuai source. Source, test, aset, rencana bisnis, serta data toko tidak boleh diubah pada A07. Jika pemeriksaan menunjukkan defect, berhenti, catat, dan kembalikan ke kartu A yang bertanggung jawab.

Langkah:

1. Jalankan suite relevan yang masih cocok UI. Minimal: homepage-data, specimen-home, specimen-states, single-style, styles, weight-controls, glyph-facts, load-states, artwork-integrity, data P03, dan smoke route.
2. Jalankan mixed-family. Exit 3 berarti BLOCKED untuk C03, bukan PASS font nyata. Simpan hasil dan tetap pertahankan P06 TERBLOKIR.
3. Periksa setiap skenario A02–A06 pada 1440px dan 390px. Baca hasil runtime dan screenshot aktual untuk glyph/control/error. Catat URL, cut, berkas diminta, family loaded, status, dan input yang bertahan.
4. Buat tabel acceptance P05, P07, P09, dan P11 yang menautkan test serta laporan A terkait. P11 perlu diuji ulang fixture default, single-style, dan data sintetis, bukan didesain ulang.
5. Jika acceptance seluruhnya punya bukti, tutup ulang P05, lalu P07, P09, dan P11 sesuai dependensi. Tambahkan addendum ke laporan lama tanpa menghapus FAIL, timestamp lama, atau klaim historis.
6. Pada P08, tandai glyph/OpenType Chronoa dan Mango terverifikasi ulang jika A03/A05 lulus. Tetap TERBLOKIR untuk Dingbats. A07 tidak memerlukan aset C03/C05 untuk menutup koreksi pada font yang sudah tersedia.
7. Catat timestamp lama sebagai tidak konsisten. Gunakan `git log --format='%h | %aI | %cI | %s'` untuk tanggal commit. Jangan menebak atau menulis ulang waktu mulai/selesai lama dari tanggal commit.
8. Pastikan handoff terkini menjadi bagian pertama yang dibaca. Handoff lama tetap riwayat. Ganti next action aktif menjadi P12 hanya setelah A07 dan P11 SELESAI. Perintah lama untuk langsung P12 sudah tidak berlaku selama koreksi.
9. Inventaris perubahan lokal P11, `debug.log`, dan helper untracked. Bedakan deliverable, bukti rerunnable, dan helper mutasi sekali pakai. Jangan menjalankan helper mutasi lama atau menghapus file pemilik lain. Pindahkan file sementara hanya jika kepemilikan dan izin jelas.
10. Periksa `git diff --check`, status Git, batas file task, dan bukti commit/push bila penugasan mencakup penyimpanan. Source yang disajikan browser harus cocok dengan kondisi yang dilaporkan.

Bukti selesai:

- Semua acceptance A01–A06 memiliki hasil dan artefak yang dapat ditelusuri. Tidak ada defect koreksi terbuka.
- P05/P07/P09/P11 ditutup ulang hanya setelah acceptance masing-masing lulus. Jika satu gagal, A07 tetap BERJALAN atau TERBLOKIR dan P12 belum siap.
- P06/P08 tetap TERBLOKIR untuk aset asli yang belum ada. Tidak ada klaim transaksi WooCommerce diuji lewat preview.
- Laporan menyebut jumlah assertion efektif yang aktual, kontrol negatif, command, exit code, runtime, dan output sementara.
- Timestamp baru berasal dari waktu sistem. Inkonsistensi lama dicatat tanpa memalsukan sejarah.
- Handoff menyebut satu next action konkret dan tidak menyisakan instruksi aktif yang berlawanan.

Next action: P12 jika user menugaskannya. P19/P20, staging, harga Graphics, lisensi legal, dan approval production tetap mengikuti prasyarat asli.
