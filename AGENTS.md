## Redesign aktif

Mode saat ini: PERENCANAAN, menunggu pelaksana P01. User menyetujui rencana pada 10 Oktober 2026. Agent yang menerima perintah mulai menjalankan P01 untuk mencatat aktivasi dan status tugas. Jangan mengubah source website sebelum task terkait ditugaskan dan dependensinya selesai; approval production tetap terpisah.

Sebelum bekerja, baca `rules.md`, `REDESIGN-PLAN.md`, dan bagian redesign aktif di `PROGRESS.md`.
Untuk rencana rinci yang sudah disetujui, baca `docs/redesign/execution-plan.md`.
Kemudian baca kartu tugas yang dipilih dan `docs/reports/<ID-TUGAS>.md` jika tersedia.

Agent implementasi bekerja bergantian. Hanya satu tugas implementasi yang boleh BERJALAN. Reviewer boleh membaca bersamaan, tetapi tidak mengedit file.
Setiap agent wajib mencatat mulai kerja, perubahan, pemeriksaan, blocker, hasil, dan next action. Ikuti urutan laporan dalam `rules.md`; pekerjaan tanpa laporan belum selesai.

Sumber tema resmi: `rillatype-v2-extracted/rillatype-v2-1/`. Preview: `static/redesign/`. Jangan mengedit salinan tema lain.
Pertahankan arah editorial R05H. Semua preview font 1200x800 harus tampil utuh pada rasio 3:2.

## Agent skills

### Issue tracker

Issue dan spesifikasi dilacak melalui GitHub Issues di `rillatype/rillatype-web-redesign`. Lihat `docs/agents/issue-tracker.md`.

### Triage labels

Gunakan lima label triage bawaan. Lihat `docs/agents/triage-labels.md`.

### Domain docs

Gunakan layout single-context: `GLOSSARY.md` di root dan `docs/adr/`. Lihat `docs/agents/domain.md`.
