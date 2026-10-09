# Issue tracker: GitHub

Issue dan spesifikasi repo ini berada di GitHub Issues:
`rillatype/rillatype-web-redesign`.

Gunakan CLI `gh` untuk semua operasi. Jalankan dari repo ini agar `gh`
mengenali remote. Gunakan `--repo rillatype/rillatype-web-redesign` jika
dijalankan dari lokasi lain.

## Konvensi

- Buat issue: `gh issue create --title "..." --body "..."`
- Untuk isi multiline di PowerShell, gunakan `--body-file <path>`.
- Baca issue: `gh issue view <number> --comments`; periksa label juga.
- Daftar issue:
  `gh issue list --state open --json number,title,body,labels,comments`
  Tambahkan filter `--label` dan `--state` sesuai kebutuhan.
- Tambahkan komentar: `gh issue comment <number> --body "..."`
- Tambahkan label: `gh issue edit <number> --add-label "..."`
- Hapus label: `gh issue edit <number> --remove-label "..."`
- Tutup issue: `gh issue close <number> --comment "..."`

## Sub-issue

Gunakan sub-issue native jika tersedia pada versi `gh` yang terpasang.
Alternatif API:

`gh api --method POST repos/rillatype/rillatype-web-redesign/issues/<parent>/sub_issues -F sub_issue_id=<child-db-id>`

Jika sub-issue tidak tersedia, tulis `Part of #<parent>` di bagian atas
issue anak dan tambahkan anak ke task list issue induk.

## Pull requests as a triage surface

**PRs as a request surface: no.**

Jika diubah menjadi `yes`, gunakan operasi `gh pr` untuk membaca,
mengomentari, memberi label, dan menutup PR. Baca diff dengan
`gh pr diff <number>`.

GitHub memakai nomor bersama untuk issue dan PR. Untuk referensi ambigu,
coba `gh pr view <number>`, lalu `gh issue view <number>` jika bukan PR.

## Instruksi skill

- "Publish to the issue tracker": buat GitHub issue.
- "Fetch the relevant ticket": jalankan `gh issue view <number> --comments`.

## Operasi wayfinder

- Map: satu issue berlabel `wayfinder:map`, berisi Notes,
  Decisions-so-far, dan Fog.
- Tiket anak: hubungkan sebagai sub-issue map. Gunakan label
  `wayfinder:research`, `wayfinder:prototype`, `wayfinder:grilling`,
  atau `wayfinder:task`.
- Blocking: gunakan dependency native GitHub:

  `gh api --method POST repos/rillatype/rillatype-web-redesign/issues/<child>/dependencies/blocked_by -F issue_id=<blocker-db-id>`

  Ambil database ID blocker dengan:

  `gh api repos/rillatype/rillatype-web-redesign/issues/<number> --jq .id`

  Gunakan database ID, bukan nomor issue atau `node_id`.
  Jika dependency native tidak tersedia, tulis
  `Blocked by: #<number>, #<number>` di bagian atas tiket anak.
- Frontier: pilih anak terbuka pertama sesuai urutan map yang tidak
  memiliki blocker terbuka atau assignee. Untuk dependency native,
  periksa `issue_dependencies_summary.blocked_by`.
- Claim: `gh issue edit <number> --add-assignee "@me"`.
- Resolve: komentari hasil, tutup tiket, lalu tambahkan ringkasan dan
  tautan ke Decisions-so-far pada map.
