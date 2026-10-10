// Data contoh untuk homepage. Nanti diisi dari admin (fase W), bukan dari berkas
// ini; berkas ini hanya prototype supaya homepage tidak lagi menulis nama font
// di dalam kode.
//
// Pembagian tugas:
// - font-catalog.js memegang FAKTA font: keluarga, berkas, weight, jumlah glyph,
//   feature, dan harga. Daftar cut hanya hidup di sana (catatan P07).
// - berkas ini memegang PILIHAN KONTEN: produk mana yang tampil dan teks
//   editorialnya. Tidak ada nama berkas font di sini.
//
// Setiap slug di `specimen` harus ada di font-catalog.js dan punya subset web
// (`specimenFamily` + `web` pada style-nya). Kalau tidak, picker hanya akan
// menawarkan pilihan yang gagal dimuat.
window.RillaHome = {
  // Ditawarkan di specimen band, urut. Yang pertama dipilih saat halaman muat.
  // Satu slug berarti kontrol pemilih font disembunyikan.
  specimen: ['chronoa', 'mango'],

  // Blok unggulan di bawah specimen band. Judul, route, artwork, alt, tabel spec,
  // dan label tautan diturunkan dari data katalog; hanya prosa dan alt yang
  // ditulis di sini karena keduanya teks editorial.
  featured: {
    slug: 'chronoa',
    copy: 'One family. Nine weights.<br>A different voice in every cut.',
    artAlt: 'Chronoa specimen sheet showing nine weights and the alphabet'
  },

  // Contoh cut di bawah blok unggulan, dipilih per label style produk unggulan.
  // Label yang tidak ada di produk itu dilewati. Kalau tersisa kurang dari dua,
  // barisnya disembunyikan: satu cut tidak bisa menjadi "tiga cut berdampingan".
  strips: [
    { style: 'Light', text: 'Aa Bb Cc', caption: '219 glyphs · latin' },
    { style: 'Medium', text: '0123456789', caption: 'numerals' },
    { style: 'SemiBold', text: 'Aa Bb Cc', caption: 'the cut used above' }
  ]
};
