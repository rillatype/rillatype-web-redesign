# Dokumentasi domain

Repo ini memakai layout single-context.

## Sebelum menjelajahi kode

- Baca `GLOSSARY.md` di root jika tersedia.
- Baca ADR dalam `docs/adr/` yang berkaitan dengan area pekerjaan.
- Jika `GLOSSARY-MAP.md` tersedia, ikuti tautannya dan baca glossary
  yang relevan. Periksa juga ADR per-context di `src/<context>/docs/adr/`.

Jika dokumen belum tersedia, lanjutkan tanpa menandai ketidakhadirannya
atau menyarankan pembuatannya terlebih dahulu. Skill `domain-modeling`,
termasuk melalui `grill-with-docs` dan `improve-codebase-architecture`,
membuat dokumen saat istilah atau keputusan sudah disepakati.

## Layout

- `GLOSSARY.md`: istilah domain untuk seluruh repo.
- `docs/adr/`: keputusan arsitektur untuk seluruh repo.

## Gunakan kosakata glossary

Gunakan istilah yang didefinisikan glossary pada judul issue, usulan
refactor, hipotesis, dan nama tes. Hindari sinonim yang ditolak glossary.

Jika konsep belum tercatat, periksa apakah istilah tersebut memang
digunakan proyek. Catat kekurangan yang nyata untuk `domain-modeling`.

## Konflik ADR

Jika usulan bertentangan dengan ADR, nyatakan konflik secara eksplisit
dan jelaskan alasan keputusan tersebut perlu ditinjau ulang.
