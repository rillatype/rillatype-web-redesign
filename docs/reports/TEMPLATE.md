# Laporan <ID-TUGAS>: <judul>

## Kondisi terakhir

- Status: BELUM
- Agent/session: <identitas unik>
- Mulai: <waktu sistem YYYY-MM-DD HH:mm:ss WIB, bukan perkiraan>
- Terakhir diperbarui: <waktu aktual penyimpanan YYYY-MM-DD HH:mm:ss WIB>
- Kartu task: <path dan anchor>
- Dependensi: <ID dan bukti SELESAI di PROGRESS.md>
- Branch/commit awal: <branch dan hash>
- Perubahan yang sudah ada sebelum mulai: <path/pemilik atau tidak ada>
- File yang boleh diubah: <daftar dari kartu>
- Lingkungan pemeriksaan: <base URL, workspace server, runtime/browser, viewport, HEAD dan file lokal yang berbeda>
- Efek samping command: <suite anak, file output/screenshot, jaringan/transaksi; read-only atau menulis>

## Hasil yang wajib dicapai

<Salin acceptance criteria yang relevan. Jangan ubah kriteria agar cocok dengan hasil parsial.>

## Log unit kerja

### <timestamp> | <tindakan>

- Tindakan dan file:
- Alasan/keputusan:
- Pemeriksaan dan command: <command lengkap, argumen, exit code, waktu aktual>
- Hasil aktual: PASS / FAIL / TIDAK DIJALANKAN / BLOCKED / TIDAK BERLAKU, dengan expected dan actual.
- Bukti: <path atau URL tepat, jenis bukti runtime/source/fixture; hindari credential/data pelanggan>
- Pekerjaan tersisa:
- Blocker:
- Next action:

Tambahkan entri baru setelah setiap unit. Pertahankan entri lama.

## Pemetaan acceptance ke bukti

| Acceptance kartu | Kondisi dan tindakan | Expected | Actual | Command/test dan exit code | Bukti | Status |
| --- | --- | --- | --- | --- | --- | --- |
| <satu kriteria nyata> | <cut/file/URL/state yang diuji> | <hasil literal> | <nilai yang dibaca> | <test efektif> | <artefak runtime atau source> | <PASS/FAIL/BLOCKED/TIDAK DIJALANKAN> |

- Assertion baru/pengganti yang menentukan penutupan: <negative control dan bukti test menolak kondisi salah>.
- FAIL sebelum fix: <command, HEAD, kondisi, hasil, output>. Jika tidak berlaku, jelaskan.
- PASS sesudah fix: <test yang sama, hasil aktual, output>.
- Jumlah assertion efektif: <aktual; keluarkan dummy/duplikat/informasi/SKIP dari PASS>.
- Bagian belum terverifikasi: <skenario/aset/runtime yang belum tersedia>.
- Konflik waktu atau laporan lama: <tambahkan koreksi dengan waktu sekarang, jangan ganti sejarah>.

## Handoff

- Posisi terakhir:
- File berubah:
- Pemeriksaan terakhir:
- Temuan/failure yang masih terbuka:
- Data/akses/keputusan yang dibutuhkan:
- Next action konkret:
- Task berikutnya yang siap:
- Commit dan push: <belum/lokal/hash+remote+hasil>

## Daftar selesai

- [ ] Hasil nyata memenuhi seluruh acceptance criteria.
- [ ] Pemeriksaan relevan lulus; yang tidak dijalankan dijelaskan.
- [ ] Review dan perbaikan wajib sudah ditutup.
- [ ] PROGRESS.md sesuai kondisi terakhir dan menautkan laporan ini.
- [ ] Git scope terverifikasi; commit/push sesuai izin dan aturan repo.
- [ ] Setiap acceptance wajib punya bukti, bukan hanya ringkasan total PASS.
- [ ] Kontrol negatif, effects test, exit BLOCKED, dan batas runtime sudah dijelaskan.
- [ ] Timestamp baru diambil dari sistem dan next action aktif konsisten dengan dependensi.
