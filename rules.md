# Aturan kerja dan pelaporan agent

Status: aturan pelaporan dan rencana disepakati 10 Oktober 2026. Agent berikutnya yang ditugaskan mulai menjalankan P01 untuk aktivasi dan status. Approval production tetap terpisah.

## Sumber yang dibaca

1. Baca AGENTS.md untuk mode kerja saat ini.
2. Baca bagian redesign aktif PROGRESS.md untuk status dan handoff terbaru.
3. Baca REDESIGN-PLAN.md dan docs/redesign/execution-plan.md untuk scope.
4. Baca hanya buku tugas fase yang memuat ID tugasmu, spesifikasi yang dirujuk, dan laporan tugas tersebut.
5. Baca kode nyata, pemanggil, dan aset sebelum mengedit. Laporan lama membantu menemukan bukti; laporan bukan pengganti bukti.

PROGRESS.md adalah sumber status. Laporan tugas menyimpan rincian bukti. Rencana menyimpan spesifikasi, bukan status tugas.

## Mulai satu tugas

1. Jalankan git status --short. Catat perubahan yang sudah ada dan pemiliknya jika diketahui.
2. Temukan satu tugas BELUM yang semua dependensinya SELESAI.
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

## Akhir sesi

Simpan laporan sebelum final response. Sebutkan ID, status, hasil, pemeriksaan yang benar-benar berjalan, blocker, dan next action.
Pastikan laporan dapat digunakan agent lain tanpa membaca chat sebelumnya.
Jika laporan belum tersimpan, jangan menyatakan pekerjaan selesai.
