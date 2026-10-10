# Prompt pertama untuk agent pelaksana

Gunakan setelah kamu menerima rencana draft. Teks di bawah adalah prompt untuk dikirim sebagai pesan user kepada agent berikutnya. Menyimpan file ini tidak mengaktifkan implementasi.

```text
Saya menyetujui rencana dalam docs/redesign/execution-plan.md dan mengizinkan mulai implementasi secara bertahap sesuai rencana. Jangan mengubah production, harga publik, ketentuan pesanan lama, atau menerbitkan draf lisensi.

Kerjakan P01 saja pada docs/redesign/tasks-preview.md. Agent bekerja bergantian; hanya satu task implementasi aktif.

Urutan wajib:
1. Baca AGENTS.md, rules.md, REDESIGN-PLAN.md, bagian redesign aktif PROGRESS.md, docs/redesign/execution-plan.md, dan kartu P01.
2. Jalankan git status --short. Catat perubahan yang sudah ada. Jangan memasukkan perubahan milik agent lain.
3. Periksa apakah ada task BERJALAN milik agent lain. Jika ada, jangan mengambil alih; laporkan dan tunggu handoff/penugasan ulang.
4. Catat bahwa pesan user ini menyetujui rencana dan meminta mulai. Ubah mode sesuai kartu P01, lalu siapkan tabel microtask dan laporan docs/reports/P01.md memakai template.
5. Tulis agent/session, timestamp WIB, kondisi awal, dependensi, scope file, tindakan, dan next action sebelum bekerja.
6. Kerjakan hanya langkah P01. Jangan mengubah source website atau mulai P02.
7. Setelah setiap unit kerja atau pemeriksaan, simpan laporan P01 dan ringkasan PROGRESS.md. Catat PASS, FAIL, atau TIDAK DIJALANKAN dengan bukti aktual.
8. Periksa kelengkapan 73 ID, dependensi, pointer, dan mode. Kode website harus tetap sama.
9. Tutup P01 hanya jika seluruh kriteria selesai terpenuhi. Simpan handoff berisi posisi terakhir, file berubah, pemeriksaan, blockers, dan next action P02.
10. Ikuti aturan Git pada rules.md. Stage hanya file task dan laporan yang sudah diperiksa. Jangan force-push atau melewati hook.

Jika informasi wajib tidak tersedia, catat TERBLOKIR dan kebutuhan persisnya. Jangan menebak atau menganggap test yang tidak dijalankan sebagai PASS.

Akhiri dengan ID/status task, hasil, bukti pemeriksaan, commit/push bila ada, pekerjaan tersisa, dan satu next action. Berhenti setelah P01.
```

## Prompt lanjutan untuk berganti agent

```text
Lanjutkan task [ID-TUGAS] dalam rencana redesign Rillatype. Baca AGENTS.md, rules.md, PROGRESS.md, kartu task, dan laporan task/hand-off sebelumnya terlebih dahulu. Verifikasi dependensi SELESAI dan tidak ada task implementasi lain BERJALAN.

Kerjakan satu task itu saja. Catat mulai kerja, setiap unit perubahan/pemeriksaan, blocker, hasil, dan next action dalam docs/reports/[ID-TUGAS].md serta PROGRESS.md. Pertahankan scope file dan data asli. Jangan melewati approval, inventaris yang belum diverifikasi, atau kriteria selesai.

Berhenti setelah hasil diperiksa dan handoff tersimpan. Jika meneruskan pekerjaan parsial, verifikasi git diff sebelum edit dan pertahankan riwayat laporan agent sebelumnya.
```
