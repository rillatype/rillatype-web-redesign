# Aturan kerja dan pelaporan agent

Status: rencana aktif sejak P01. Revisi audit 10 Oktober 2026 menambah A01–A07. Baca status dan handoff terkini di PROGRESS.md sebelum memilih tugas. Approval production tetap terpisah.

## Sumber yang dibaca

1. Baca AGENTS.md untuk mode kerja saat ini.
2. Baca bagian redesign aktif PROGRESS.md untuk status dan handoff terbaru.
3. Baca REDESIGN-PLAN.md dan docs/redesign/execution-plan.md untuk scope.
4. Baca hanya buku tugas fase yang memuat ID tugasmu, spesifikasi yang dirujuk, dan laporan tugas tersebut.
5. Baca kode nyata, pemanggil, dan aset sebelum mengedit. Laporan lama membantu menemukan bukti; laporan bukan pengganti bukti.

PROGRESS.md adalah sumber status. Laporan tugas menyimpan rincian bukti. Rencana menyimpan spesifikasi, bukan status tugas.

Saat koreksi audit belum selesai, baca `docs/redesign/tasks-audit-corrections.md` sebelum implementasi atau penutupan ulang P05/P07/P09/P11. Kerjakan A01–A07 sesuai urutan kartu. P12–P20 menunggu A07. Laporan P lama tetap bukti historis, bukan status aktif atau izin melewati koreksi.

## Mulai satu tugas

1. Jalankan git status --short. Catat perubahan yang sudah ada dan pemiliknya jika diketahui.
2. Pilih hanya tugas yang ditugaskan user. Verifikasi semua dependensinya SELESAI dan batas koreksi audit di PROGRESS.md sudah terpenuhi. Daftar next action bukan izin mengerjakan task lain otomatis.
3. Jika ada tugas implementasi BERJALAN milik agent lain, jangan mengedit. Baca laporan tersebut dan tunggu handoff.
4. Jika task BERJALAN tampak ditinggalkan, minta penugasan ulang. Jangan mengambil alih hanya berdasarkan umur timestamp.
5. Ubah baris task di PROGRESS.md menjadi BERJALAN dan tulis identitas agent/session.
6. Buat atau lanjutkan docs/reports/<ID-TUGAS>.md memakai docs/reports/TEMPLATE.md.
7. Catat tujuan, dependensi yang diverifikasi, file yang boleh diubah, kondisi awal, dan tindakan berikutnya.
8. Simpan kedua laporan sebelum mengubah implementasi.

Identitas agent harus membedakan pelaksana, misalnya codex/session-123 atau model-X/session-456. Jangan menulis token atau credential.

## Catat setiap unit kerja

Satu unit berarti hasil yang dapat diperiksa: perubahan kecil, satu putaran pemeriksaan, keputusan, kegagalan, atau blocker.
Setelah setiap unit, sebelum unit berikutnya:

1. Tambahkan entri timestamp Asia/Jakarta di laporan tugas. Gunakan waktu sebenarnya.
2. Tulis tindakan dan path file yang benar-benar berubah.
3. Tulis alasan keputusan atau perubahan scope.
4. Tulis command/pemeriksaan, hasil, serta path bukti. Bedakan PASS, FAIL, dan TIDAK DIJALANKAN.
5. Tulis pekerjaan tersisa, blocker, dan satu next action yang konkret.
6. Perbarui ringkasan baris task dan log perubahan PROGRESS.md. Tautkan laporan task; jangan menyalin semua log command ke tracker.

Catat pemeriksaan gagal sebelum memperbaikinya. Simpan riwayat kegagalan dan hasil perbaikannya.
Untuk observasi baca-saja dalam satu penyelidikan, satu entri boleh menggabungkan beberapa pembacaan yang menghasilkan satu kesimpulan.

### Ambil waktu dari sistem

1. Ambil waktu aktual pada awal dan akhir setiap unit. Pada Windows, gunakan `[TimeZoneInfo]::ConvertTimeBySystemTimeZoneId((Get-Date), 'SE Asia Standard Time').ToString('yyyy-MM-dd HH:mm:ss')` dan tulis suffix WIB.
2. Catat timestamp setelah tindakan selesai, bukan estimasi durasi atau urutan waktu buatan. Perbarui `Terakhir diperbarui` saat laporan benar-benar disimpan.
3. Sebelum commit, bandingkan waktu entri baru dengan `git log --format='%h | %aI | %cI | %s'`. Entri pekerjaan yang sudah masuk commit tidak boleh mengaku dilakukan sesudah waktu commit tanpa penjelasan perbedaan jam yang dapat diperiksa.
4. Jika jam atau laporan lama tidak konsisten, tambahkan addendum dengan waktu sekarang dan bukti konfliknya. Jangan menebak timestamp lama, mengganti tanggal commit, atau menyimpulkan kerja paralel hanya dari timestamp yang bermasalah.
5. Saat memperbarui handoff, letakkan keadaan terkini lebih dahulu dan tandai bagian lama sebagai riwayat. Satu next action aktif harus konsisten dengan status dan dependensi.

## Status dan kriteria selesai

| Status | Gunakan saat | Next action wajib |
| --- | --- | --- |
| BELUM | Pekerjaan belum dimulai | Dependensi atau task pertama yang harus diambil |
| BERJALAN | Satu agent sedang mengerjakan task | Langkah yang akan dikerjakan setelah entri ini |
| TERBLOKIR | Bukti, data, akses, atau prasyarat wajib tidak tersedia | Data/akses yang dibutuhkan dan siapa yang dapat menyediakannya |
| MENUNGGU USER | Hasil reviewable membutuhkan keputusan user | Pertanyaan/keputusan yang spesifik dan tautan hasil |
| SELESAI | Seluruh acceptance criteria memiliki bukti | Task berikutnya yang siap, atau batas pekerjaan |

Kode tertulis, screenshot statis, atau build sukses sendiri tidak cukup untuk menutup task perilaku transaksi.
Task selesai hanya ketika hasil nyata sesuai kartu, pemeriksaan relevan lulus, laporan terbarui, dan scope tidak menyisakan pekerjaan wajib.
Jika belum selesai saat sesi berakhir, tetap BERJALAN atau TERBLOKIR dengan handoff. Jangan membuat task tampak SELESAI karena budget habis.

Jika audit menemukan defect pada task SELESAI, buka ulang menjadi BELUM sampai diambil pelaksana. Tulis alasan, acceptance yang gagal, dan kartu koreksi. Gunakan TERBLOKIR hanya bila bukti, data, akses, atau prasyarat tidak tersedia. Pertahankan log dan laporan sebelumnya. Tutup ulang hanya dengan bukti terbaru, bukan angka PASS lama.

## Buktikan perilaku, bukan angka PASS

### Sebelum menjalankan pemeriksaan

1. Baca entry point test dan command anak yang dipanggil. Cari penulisan screenshot, log, fixture, paket, perubahan Git, akses jaringan, dan transaksi.
2. Catat base URL, HEAD, perubahan working tree, viewport, runtime, dan versi browser. Pastikan server menyajikan workspace yang sedang diperiksa.
3. Untuk tugas audit read-only, pilih command yang tidak menulis workspace atau arahkan output sementara ke scratch jika tool mendukung. Jika command tidak dapat dibuat read-only, gunakan pemeriksaan lain dan nyatakan suite tidak dijalankan. Jangan menyatakan tidak ada file ditulis jika test memperbarui screenshot ignored.
4. Simpan ad-hoc probe, backup, output browser, dan helper mutasi sekali pakai di scratch. Simpan test yang dapat dijalankan ulang sebagai file proyek pada scope kartu. Hindari helper sementara baru di root atau scripts proyek.

### Tulis assertion yang dapat gagal

1. Hubungkan tiap assertion dengan acceptance tertentu. Periksa hasil literal yang dilihat pengguna, bukan hanya teks laporan atau deklarasi CSS.
2. Assertion efektif harus dapat FAIL. Hindari `or True`, `|| true`, exception yang ditelan lalu dianggap sukses, atau kondisi konstan yang selalu lulus.
3. Untuk assertion baru atau pengganti yang menentukan penutupan task, jalankan kontrol negatif. Sajikan data atau respons salah melalui memory, route override, atau salinan scratch. Buktikan test menolak keadaan itu tanpa mengubah source kerja untuk sementara.
4. Hapus pemeriksaan duplikat atau tidak berlaku dari jumlah PASS. Catat SKIP/TIDAK BERLAKU beserta alasan. Catat exit code BLOCKED terpisah dari PASS. Jangan menaikkan total hanya untuk mengembalikan angka lama.
5. Saat test berubah, jelaskan requirement yang tetap diperiksa dan alasan perubahan selector atau serialisasi browser. Normalisasi format setara boleh. Mengganti expected agar bug terlihat benar tidak boleh.
6. Untuk race, buktikan request lama benar-benar ditahan, pilihan baru sudah selesai, lalu respons lama dilepas. Catat urutan request dan state sebelum/sesudah. Timeout tetap atau assertion weight saja tidak membuktikan fakta terbaru aman.

### Bukti khusus tester font

- Pilihan style harus cocok pada selector, label status, URL berkas yang diminta, family yang loaded, weight/style, glyph, dan fitur yang dirender. Indeks `0` adalah pilihan valid, bukan alasan memilih default lain.
- Computed weight atau nama family dalam stack CSS bukan bukti berkas yang benar termuat. Periksa request sukses dan face loaded. Bedakan OTF yang diminta loader produk dari subset WOFF2 yang dapat dimuat stylesheet.
- Panel glyph harus memakai family dan cut produk aktif. Periksa computed style pada sel glyph, count dari file aktif, dan face loaded. Count benar dengan sel Manrope tetap gagal.
- Retry harus mencoba ulang cut yang gagal setelah jaringan dipulihkan dan berhasil tanpa reload halaman. Berpindah ke cut lain yang sudah sehat tidak memenuhi acceptance retry.
- Uji cold-default failure dalam context baru sebelum font default pernah berhasil. Kontrol dan retry tetap tersedia, tetapi sample yang gagal tidak boleh berpura-pura memakai font produk. Produk tanpa berkas dibedakan dari kegagalan jaringan.
- Pemeriksaan request terbaru berlaku sebelum setiap mutasi DOM setelah await, termasuk switch OpenType dan panel glyph. Respons lama boleh selesai untuk cache, tetapi tidak boleh menimpa fakta terbaru.
- Pertahankan input literal, size, leading, tracking, alignment, theme, dan pilihan lisensi ketika font berubah atau gagal. Buat test sesuai skenario di kartu, tanpa menambah kontrol atau data produk baru.

### Simpan bukti yang dapat diperiksa ulang

Untuk setiap skenario wajib, tulis kondisi awal, command lengkap, expected, actual, exit code, versi runtime, HEAD, dan path output. Bedakan runtime terkonfirmasi, analisis source, fixture sintetis, dan bagian yang belum diperiksa. Source analysis bukan klaim reproduksi browser.
Ringkasan total PASS tidak menggantikan tabel acceptance. Simpan FAIL sebelum fix serta hasil test yang sama setelah fix. Jika test belum mampu membuka skenario, laporkan keterbatasannya dan perbaiki probe sebelum menyatakan selesai.

## Bekerja dengan agent berikutnya

1. Satu pelaksana mengedit satu task pada satu waktu. User menyepakati mode bergantian.
2. Reviewer bekerja baca-saja dan mengirim temuan beserta path/line/bukti kepada pelaksana.
3. Pelaksana mencatat review dan memperbaiki temuan. Reviewer tidak ikut mengubah source atau tracker.
4. Sebelum melepas task, lengkapi posisi terakhir, file berubah, pemeriksaan terakhir, kegagalan yang masih terbuka, dan next action.
5. Agent pengganti membaca handoff dan git diff sebelum melanjutkan. Verifikasi kondisi repo masih cocok dengan laporan.
6. Jangan menimpa pekerjaan agent sebelumnya atau mengulang perbaikan yang sudah terbukti hanya karena konteks chat berbeda.

## Batas perubahan

Edit hanya file pada kartu task. Bila caller wajib berada di luar daftar, catat kebutuhan dan perluas scope secara eksplisit sebelum edit.
Sumber tema hanya rillatype-v2-extracted/rillatype-v2-1/. File tema root, wp-content, dan backup tidak disinkronkan manual.
Gunakan native WordPress/WooCommerce serta pola repo. Simpan kontrol keamanan, nonce, escaping, validasi harga, dan izin download.
Pisahkan style tester dari variasi pembelian. Semua harga berasal dari WooCommerce atau diberi label Demo pada prototype.
Jangan menyimpulkan non-font hanya karena berkas specimen tidak tersedia.
Semua artwork 1200x800 tampil utuh dengan rasio 3:2. Ikuti product-spec.md untuk kondisi dimensi lain.
Production, lisensi publik baru, perubahan harga, serta migrasi data memerlukan keputusan user yang relevan. Dokumen draft tidak menjadi izin publikasi.

## Git dan issue

Ikuti docs/agents/issue-tracker.md untuk GitHub Issues dan docs/agents/triage-labels.md untuk label.
Saat task implementasi terverifikasi, periksa status/diff/log; stage hanya source dan laporan terkait, periksa staged diff, kemudian commit dan push sesuai instruksi repo.
Jangan commit pekerjaan agent lain, credential, config lokal, log browser, atau screenshot sementara.
Jika user menahan push, patuhi penahanan tersebut. Jika push gagal, catat commit lokal dan penyebabnya.
Catat bukti push pada handoff atau unit berikutnya. Hindari commit tambahan hanya untuk mencatat hash commit sebelumnya.
Jangan force-push, amend, melewati hook, atau melakukan reset destruktif.
Untuk baseline perbandingan, baca snapshot commit melalui `git show` ke scratch atau pakai worktree terpisah yang diizinkan. Jangan mengganti source working tree dengan `git checkout HEAD -- <file>` lalu memulihkannya sebagai cara mengambil screenshot baseline. Pisahkan baseline dari file yang sedang dikerjakan.
Jangan menjalankan helper mutasi progress lama tanpa membaca dampak dan status terkini. Jangan menghapus file untracked milik pihak lain. Bukti push setelah commit boleh tetap lokal mengikuti aturan di atas, tetapi harus dicatat pada handoff dan dipertahankan agent berikutnya.

## Akhir sesi

Simpan laporan sebelum final response. Sebutkan ID, status, hasil, pemeriksaan yang benar-benar berjalan, blocker, dan next action.
Pastikan laporan dapat digunakan agent lain tanpa membaca chat sebelumnya.
Jika laporan belum tersimpan, jangan menyatakan pekerjaan selesai.
