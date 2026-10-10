# Buku tugas WordPress

Status: rincian rencana disetujui user, 10 Oktober 2026. THEME = rillatype-v2-extracted/rillatype-v2-1/. Baca execution-plan.md/product-spec.md/rules.md dan laporan task. Dependensi dan approval staging/visual tetap wajib.
W01–W04 adalah persiapan staging/data yang dapat dilakukan sebelum approval render. W05–W27 mengubah implementasi setelah P20 selesai; W27 menyiapkan data Graphics sebelum W22.
Setiap task membutuhkan laporan sendiri, update tracker, syntax PHP/JS bila tersedia, serta pemeriksaan nyata pada staging. Jangan menggunakan production sebagai pengganti staging.

## W01. Sediakan staging dan akses pemeriksaan

Dependensi: P01. File: laporan W01, docs/redesign/staging-checks.md baru. Source tema belum diubah.
Langkah: verifikasi URL/akses staging milik user; konfirmasi salinan toko dan data uji; pastikan pembayaran sandbox dan email uji; tentukan cara memulihkan tema/data. Catat alat PHP/WordPress yang tersedia.
Selesai: staging dapat dibuka, akses yang dibutuhkan bekerja, sandbox terkonfirmasi, dan jalur restore jelas. Credential tidak disimpan ke repo. Jika akses belum ada, TERBLOKIR dengan permintaan spesifik, bukan deploy sendiri ke production.

## W02. Catat runtime dan baseline

Dependensi: W01. File: staging-checks.md, laporan; screenshot sementara.
Langkah: catat versi WP/Woo/PHP, tema aktif, plugin checkout/SEO/cache/newsletter; ambil baseline homepage/produk/cart/checkout/account pada desktop/mobile; catat error dan pengukuran awal dengan konfigurasi alat.
Selesai: bukti baseline dapat diulang dan tidak berisi data pelanggan. Catat masalah yang sudah ada sebelum redesign. Pemeriksaan transaksi berikutnya dapat membandingkan perilaku lama dan baru.

## W03. Verifikasi inventory serta model pembelian

Dependensi: W02/P02. File: reference-inventory.md, staging-checks.md, laporan. Source belum diubah.
Langkah: pilih produk staging untuk C01–C11; baca kategori/ancestors, atribut, variasi, prices, gallery, metadata preview, format dan bonus; petakan actual IDs/URLs. Bedakan simple/variable, style tester, dan atribut pembelian selain lisensi bila ditemukan.
Selesai: setiap kasus punya sample nyata atau blocker; harga/variasi bukan nilai dari prototype. Kategori Graphic yang ternyata memuat font ditandai untuk keputusan, tidak diubah otomatis.

## W04. Tetapkan berkas specimen publik yang aman

Dependensi: W03. File: docs/redesign/staging-checks.md; baca THEME/woocommerce/content-single-product.php, functions.php, dan metadata attachment. Perubahan source pada dua file THEME tersebut hanya setelah P20 selesai; sebelum itu tulis daftar resolusi di staging-checks.md.
Langkah: petakan attachment preview web yang boleh dipublikasi; verifikasi format/file/status; tentukan state unavailable; rencanakan penghapusan fallback dari downloadable paid file/ZIP. Jaga mekanisme unduhan pembelian.
Selesai: tidak ada purchased ZIP atau file berbayar lengkap yang dipakai diam-diam sebagai specimen publik. Setiap product style memiliki preview yang disetujui atau unavailable. Bila hak/attachment tidak jelas, hentikan integrasi tester untuk produk itu.

## W05. Tentukan klasifikasi produk dari data nyata

Dependensi: P20/W03. File: THEME/woocommerce/content-single-product.php, front-page.php, woocommerce/archive-product.php, functions.php untuk satu helper klasifikasi yang dipakai caller tersebut.
Langkah: gunakan mapping kategori serta ancestors yang diverifikasi; tentukan font/graphic/mixed/unknown; gunakan isi bonus terverifikasi untuk mixed. Jangan mendeteksi Graphic dari jumlah style nol. Selesaikan daftar produk ambigu dengan user sebelum migrasi data.
Selesai: C01/C06/C07/C08 dibedakan dengan benar, termasuk kategori anak tanpa root Font terpasang langsung. Unknown memakai detail generik. Pemeriksaan fungsi klasifikasi memiliki expected values literal.

## W06. Jaga metadata saat admin menyimpan style

Dependensi: P20/W03/W04. File: THEME/functions.php, assets/js/admin-product.js, laporan/data fixture uji.
Langkah: reuse row nama/attachment ID yang ada; pertahankan nonce/autosave/capability; bedakan form tidak dikirim dari user sengaja menghapus row; validasi attachment; periksa rename/reorder/delete dan save produk tanpa mengedit preview.
Selesai: save unrelated fields tidak menghilangkan style; row yang dipertahankan tidak kehilangan desktop/web attachment; perubahan sengaja tersimpan. Harga, variasi, downloadable files, dan pesanan tidak berubah karena menyimpan preview.

## W07. Hubungkan pilihan unggulan admin

Dependensi: P20/W03/W05. File: THEME/inc/customizer.php, functions.php bila perlu, front-page.php.
Langkah: baca kontrol homepage yang aktif; reuse native customizer/config yang ada; sediakan daftar product IDs font dan Graphics yang berurutan serta font specimen default; validasi ID/kind/visibility. Gunakan label admin English yang jelas.
Selesai: user dapat mengganti/urutkan unggulan tanpa edit HTML. Produk terhapus/unpublished dilewati dengan state wajar. Penyimpanan konfigurasi tidak mengubah tanggal, harga, SKU, kategori, atau variasi produk.

## W08. Terapkan token dan komposisi dasar

Dependensi: P20/W02. File: THEME/style.css; baca static/redesign/style.css, editorial.css, home.css, DESIGN.md.
Langkah: petakan selector aktif; terapkan token R05H dengan scope yang jelas; hapus aturan visual yang benar-benar diganti; jaga checkout/account sebelum task masing-masing. Pertahankan comments/header tema yang diperlukan WordPress.
Selesai: komponen acuan cocok dengan preview dan tidak menjalankan dua tema visual bertentangan. Compare halaman baseline. Jangan menambahkan framework atau library untuk menyalin CSS native.

## W09. Muat Manrope lokal

Dependensi: W08. File: THEME/functions.php, header.php, style.css, assets/fonts/ untuk font UI dan lisensi.
Langkah: salin font berlisensi lokal yang dipakai preview; enqueue lokal; hapus Google-font request yang sudah diganti dan preconnect yang tak dipakai; pertahankan loading font produk terpisah.
Selesai: Manrope yang benar dimuat di UI, tidak ada download font eksternal lama, dan halaman tetap terbaca ketika font UI gagal. Berkas OFL disertakan di distribusi yang relevan.

## W10. Terapkan header desktop

Dependensi: W08/W09/W05. File: THEME/header.php, functions.php untuk fallback menu, style.css; JS aktif jika perlu.
Langkah: hubungkan menu WordPress, pencarian product, Fonts/Graphics/Freebies/License/Contact, akun, dan cart; gunakan URL runtime Woo dan halaman yang terdaftar; pertahankan logo asli.
Selesai: link benar untuk /contact-us/, /cart-2/, /checkout-2/ atau permalink runtime sebenarnya. Tidak menebak /contact/ atau /cart/. Search tetap terlihat dan label/fokus ada.

## W11. Terapkan header mobile

Dependensi: W10. File: THEME/header.php, style.css, script menu aktif yang dibaca dari footer/enqueue.
Langkah: pertahankan search di luar menu tertutup; toggle aria-expanded; tutup dengan Escape dan kembalikan fokus; pastikan link bisa dijalankan dengan keyboard. Gunakan event handler satu kali.
Selesai: buka/tutup/link/search bekerja pada 320/390px, tidak overflow, skip link tidak tertutup sticky header, dan tanpa JS navigasi penting tetap tersedia melalui fallback yang ditetapkan.

## W12. Terapkan footer dan route blog

Dependensi: W10/W11. File: THEME/footer.php, style.css, functions.php bila widget diperlukan.
Langkah: terapkan wordmark/footer R05H; hubungkan link asli Shop/Fonts/Graphics/Freebies/License/Blog/Contact; sediakan lokasi newsletter ringkas yang memakai provider existing setelah S16.
Selesai: link bukan anchor kosong dan dapat dipakai keyboard. Newsletter belum diklaim aktif sebelum S16. Tidak menyalin credential/form action palsu ke HTML.

## W13. Ambil font unggulan dari Woo

Dependensi: W07/W08/W10/W12. File: THEME/front-page.php, style.css.
Langkah: query IDs font terpilih sesuai urutan admin; ambil nama, harga, kategori, gambar, dan permalink asli; pertahankan indeks editorial; batasi jumlah sesuai konfigurasi yang sudah diputuskan.
Selesai: perubahan urutan/produk admin terlihat tanpa edit source, produk Graphic tidak masuk indeks font, item unpublished tidak muncul, dan harga minimum tidak menghapus perbedaan lisensi gratis/berbayar.

## W14. Ambil Graphics unggulan dari Woo

Dependensi: W07/W13. File: THEME/front-page.php, style.css.
Langkah: query IDs Graphics terpilih; tampilkan artwork asli/kind/nama/harga/link; susun section yang jelas setelah fokus font; tangani daftar kosong tanpa gambar produk lain.
Selesai: section memakai isi nyata dan perubahan admin tercermin. Unknown/misclassified product ditandai di laporan. Tidak ada placeholder brush lama menjadi data produksi.

## W15. Hubungkan rilisan terbaru

Dependensi: W13/W14. File: THEME/front-page.php, style.css.
Langkah: query Woo berdasarkan tanggal publikasi/urut latest yang valid; pertahankan pilihan unggulan manual; batasi hasil; jelaskan jenis produk lewat data. Hindari memuat seluruh inventory pada homepage.
Selesai: produk baru muncul sesuai runtime tanpa mengganti pilihan unggulan. Empty state tidak mengarang tanggal, jumlah penjualan, atau label trending.

## W16. Hubungkan specimen homepage ke produk pilihan

Dependensi: W04/W06/W07/W09/W13. File: THEME/front-page.php, style.css, functions.php, assets/js/home.js baru untuk perilaku homepage. Enqueue home.js hanya pada homepage.
Langkah: kirim data preview yang aman dan sudah di-escape; reuse perilaku P11; default berdasarkan urutan admin; load style sesuai kebutuhan; bedakan unavailable dan error.
Selesai: ganti unggulan ke font satu style atau named-style tetap bekerja; tidak ada hardcoded Chronoa/9 weight atau paid-download fallback. Tidak memuat semua font katalog. Cold-load, clear/retype, retry, serta late request diuji.

## W17. Jaga gambar WordPress utuh

Dependensi: W13/W14/W15. File: THEME/style.css, front-page.php, gallery/card template yang aktif, functions.php hanya jika ukuran image turunan perlu disesuaikan.
Langkah: pilih image sizes tanpa crop; cek sumber turunan/srcset/currentSrc; terapkan dimensi asli dan contain/height auto; jangan regenerate semua media produksi. Jika perlu turunan baru, lakukan pada staging dan catat source preservation.
Selesai: C12 lulus untuk semua penempatan yang disentuh. Thumbnail sudah ter-crop diganti sumber utuh, bukan hanya CSS. Format Graphics lain tidak diregangkan menjadi 3:2.

## W18. Terapkan summary dan gallery produk

Dependensi: W05/W08/W17. File: THEME/woocommerce/content-single-product.php, assets/js/product.js, style.css.
Langkah: ambil data current product; terapkan gallery/summary P13; pertahankan permalink/nama/deskripsi asli; scoped keyboard gallery agar arrow key pada input tester tidak mengubah slide.
Selesai: C01/C04 gallery utuh, satu gambar tidak mendapat kontrol palsu, long title tidak overflow, dan product ID berubah benar di setiap route. Slide/lightbox utuh pada mobile.

## W19. Integrasikan tester nyata

Dependensi: W04/W06/W16/W18. File: THEME/woocommerce/content-single-product.php, assets/js/product.js, functions.php, style.css; assets/js/tester-core.js baru boleh berasal dari core prototype yang diuji.
Langkah: port perilaku P04–P09 ke caller aktif; kirim styles bernama/attachment preview; load default deterministik dan style lain on demand; baca features/glyph jika didukung; pertahankan typed state/retry/latest-request.
Selesai: C01–C05/C08/C09 lulus dengan file staging. Font tanpa preview tetap font unavailable. Jangan mengimplementasikan stub kosong font-tester.php/font-tester.js atau mengklaim image mode aman tanpa renderer.

## W20. Terapkan detail Graphic

Dependensi: W05/W18. File: THEME/woocommerce/content-single-product.php, assets/js/product.js, style.css.
Langkah: gunakan kind Graphic untuk gallery/isi/format/compatibility/deskripsi terverifikasi; hilangkan tester/glyph/FAQ font dari render Graphic; pertahankan purchase form native.
Selesai: C06 terlihat lengkap dan tidak mendownload font tidak relevan. Format PNG/ZIP berasal dari produk, bukan nilai default OTF/TTF. C08 tidak ikut kehilangan state tester font.

## W21. Terapkan detail font + bonus

Dependensi: W19/W20. File: THEME/woocommerce/content-single-product.php, style.css.
Langkah: pertahankan satu SKU/purchase flow; tampilkan tester font dan bonus yang terbukti dari deskripsi/atribut; bedakan preview glyph dari preview artwork bonus.
Selesai: C07 tidak menambah variation/SKU/harga baru untuk bonus. Isi dan format sesuai produk; tidak menjanjikan hak bonus berbeda tanpa keputusan lisensi yang relevan.

## W22. Hubungkan pilihan lisensi serta harga

Dependensi: W18/W20/W21/W03/W27; harga/terms Graphics harus dikonfirmasi untuk Graphics. File: THEME/woocommerce/content-single-product.php, assets/js/product.js, style.css.
Langkah: baca atribut/variasi yang nyata; pilih license options yang tersedia; gunakan resolver Woo untuk variation, availability, sale price; tampilkan ringkasan tepat. Style tester tidak menyentuh variation selection.
Selesai: invalid/unselected variation jelas, perubahan harga sesuai server, font enam lisensi tetap tersedia bila product memilikinya. Graphics memakai dua lisensi yang disetujui dengan harga user. Task Graphics belum selesai bila harga belum ada.

## W23. Perbaiki add-to-cart pada batas yang benar

Dependensi: W22. File: THEME/woocommerce/content-single-product.php, assets/js/product.js, functions.php/hook aktif yang memang dipanggil.
Langkah: baca pemanggil dan alur lama; gunakan native Woo form/handler; kirim product/variation/attribute/quantity yang benar; pertahankan nonce/server validation. Jangan menganggap timeout iframe sebagai sukses cart.
Selesai: C01/C06/C10/C11 masuk cart dengan produk, license, harga, dan total benar. Manipulasi atribut/harga dari client ditolak server. Error yang nyata terlihat dan input pembeli tetap ada.

## W24. Terapkan katalog dan pagination

Dependensi: W13/W14/W18/W22/W23. File: THEME/woocommerce/archive-product.php, content-product.php, loop overrides aktif, style.css.
Langkah: gunakan query/taxonomy Woo; tampilkan nama/kind/preview utuh/harga awal/permalink; pertahankan native pagination/order. Bedakan Font dan Graphics tanpa memuat semua inventory client-side.
Selesai: kategori anak dan halaman berikutnya benar, tidak menduplikasi/menghilangkan item; card variable tetap menuju detail lisensi. Page 2 dapat dibuka langsung dan lewat link.

## W25. Hubungkan pencarian serta filter

Dependensi: W24/W10. File: THEME/search.php, searchform.php, archive template aktif, header.php, style.css; query hooks hanya jika diperlukan.
Langkah: gunakan s/post_type/product_cat/orderby yang tervalidasi; pertahankan query di pagination dan back; count/empty/reset selalu terlihat; filter tidak menyembunyikan konten yang bukan hasil.
Selesai: pencarian font dan Graphic bekerja; no result/reset/keyboard/mobile lulus; produk private tidak bocor. Jangan membuat backend pencarian baru untuk menggantikan native WordPress tanpa kebutuhan terbukti.

## W26. Hubungkan Freebies dan halaman lisensi

Dependensi: W22/W24/W25. File: THEME/woocommerce/archive-product.php, woocommerce/content-product.php, header/footer/page template yang relevan; konfigurasi halaman staging dengan izin.
Langkah: gunakan kategori Freebies asli beserta aturan yang diaudit; periksa simple/variable minimum zero; tautkan halaman lisensi; tampilkan harga gratis dengan scope lisensi yang jelas.
Selesai: Redline Standard 0 dan paid licenses tetap dapat dibeli sesuai data; free Graphic tidak berarti Extended gratis. Slug lama terjaga. Halaman Graphics draft belum menjadi terms publik sebelum S17.

## W27. Siapkan data pembelian Graphics pada staging

Dependensi: W03/W20/P17 dan user mengisi harga/menyetujui opsi Graphics. File: data produk staging melalui admin Woo; laporan perubahan dan preservation. Jangan mengubah production pada task ini.
Langkah: catat product ID/type/attributes/download IDs sebelum perubahan; buat order uji lama bila perlu; gunakan Woo admin untuk menyiapkan Graphics Standard/Extended beserta harga dan file yang tepat; jaga product ID, permalink, kategori, serta data/izin order lama. Jika simple perlu menjadi variable, lakukan satu produk uji dahulu.
Selesai: hanya dua opsi Graphics yang benar tersedia, Standard free pada freebie, Extended mempunyai harga user. Order uji lama masih dapat mengunduh file semula setelah perubahan. Jangan menghapus global terms/font licenses atau menulis migrasi massal sebelum contoh ini terbukti. W22 baru menghubungkan UI setelah data ini siap.
