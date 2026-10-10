// Data produk untuk prototype detail dan tester.
//
// Aturan yang dipegang berkas ini:
// 1. Tidak ada harga pembelian pada entri style. Style hanya memilih berkas specimen.
// 2. `specimen: true` berarti berkas specimen web BENAR-BENAR ada di repo ini.
// 3. `permalink` adalah URL toko sebenarnya dan unik. `storeStatus` membedakan produk
//    nyata dari entri demo, supaya entri demo tidak pernah dianggap produk terkonfirmasi.
// 4. Style yang belum punya berkas tetap dicatat namanya dengan `file: null`, bukan
//    diganti dengan font UI dan bukan dihapus. Tester menunjukkan state tidak tersedia.
//
// Sumber URL, SKU, style, dan status demo: docs/redesign/reference-inventory.md (P02).

const catalog = new Map([
  // ------------------------------------------------------------------ kasus C01
  // Satu style, specimen asli tersedia.
  ['mango', {
    name: 'Mango Letters',
    kind: 'font',
    storeStatus: 'live',
    permalink: 'https://rillatype.com/product/mango-letters-handwritten-font/',
    sku: '4070',
    style: 'Handwritten display',
    price: 18,
    licenseCount: 6,
    images: ['../previews/mango-1.jpg', '../previews/mango-2.jpg', '../previews/mango-3.jpg', '../previews/mango-4.jpg'],
    specimen: true,
    styles: [{ label: 'Regular', file: 'mango-letter.otf', dir: '../previews/', weight: 400, web: 'mango-letters.woff2' }],
    // Fakta specimen web. Dipakai tester homepage, jadi ditulis di sini sekali
    // saja: sebelumnya daftar cut hidup di dua tempat (berkas ini dan preview.js)
    // dan kesamaannya hanya dijaga pemeriksaan (catatan P07).
    specimenFamily: 'Rilla-Mango',
    specimenDir: 'fonts/web/',
    // Huruf tulis tangan tidak boleh dirapatkan; nilainya dibaca tester, bukan
    // ditebak dari nama font.
    specimenTracking: '0',
    specimenFacts: { glyphs: 184, codepoints: 181, features: 'discretionary ligatures' },
    features: { liga: false, salt: false },
    evidence: 'C01: satu specimen OTF asli. Deskripsi toko tidak menyebut style bernama lain.',
  }],

  // ------------------------------------------------------------------ kasus C04
  // Family beberapa weight, sembilan cut asli tersedia.
  ['chronoa', {
    name: 'Chronoa',
    kind: 'font',
    storeStatus: 'live',
    permalink: 'https://rillatype.com/product/chronoa-font-family/',
    style: 'Geometric sans',
    price: 24,
    licenseCount: 6,
    images: ['../previews/chronoa-1.jpg'],
    specimen: true,
    styles: [
      { label: 'Thin', file: 'Chronoa-Thin.otf', weight: 100, available: true, web: 'chronoa-thin.woff2' },
      { label: 'ExtraLight', file: 'Chronoa-ExtraLight.otf', weight: 200, available: true, web: 'chronoa-extralight.woff2' },
      { label: 'Light', file: 'Chronoa-Light.otf', weight: 300, available: true, web: 'chronoa-light.woff2' },
      { label: 'Regular', file: 'Chronoa-Regular.otf', weight: 400, available: true, web: 'chronoa-regular.woff2' },
      { label: 'Medium', file: 'Chronoa-Medium.otf', weight: 500, available: true, web: 'chronoa-medium.woff2' },
      { label: 'SemiBold', file: 'Chronoa-SemiBold.otf', weight: 600, available: true, web: 'chronoa-semibold.woff2' },
      { label: 'Bold', file: 'Chronoa-Bold.otf', weight: 700, available: true, web: 'chronoa-bold.woff2' },
      { label: 'ExtraBold', file: 'Chronoa-ExtraBold.otf', weight: 800, available: true, web: 'chronoa-extrabold.woff2' },
      { label: 'Black', file: 'Chronoa-Black.otf', weight: 900, available: true, web: 'chronoa-black.woff2' }
    ],
    defaultStyle: 'SemiBold',
    specimenFamily: 'Rilla-Chronoa',
    specimenDir: 'fonts/web/',
    specimenTracking: '-.04em',
    specimenFacts: { glyphs: 219, codepoints: 218, features: 'no OpenType features' },
    features: { liga: false, salt: false },
    evidence: 'C04: sembilan cut OTF asli. Deskripsi toko menyebut Thin sampai Black.',
  }],

  // --------------------------- kasus C02, C05, dan C03 versi Dockhand: berkas belum ada
  // Nama style berasal dari deskripsi toko. Berkas specimen belum tersedia, jadi
  // `specimen: false` dan setiap style membawa `file: null` serta `available: false`.
  // C03 sendiri sudah terpenuhi oleh entri `mondriel` di bawah; Dockhand tetap
  // dicatat sebagai produk duo yang berkasnya belum ada, bukan dihapus.
  ['tropivera', {
    name: 'Tropivera',
    kind: 'font',
    storeStatus: 'live',
    permalink: 'https://rillatype.com/product/tropivera/',
    sku: '3917',
    style: 'Tropical display family',
    price: 25,
    licenseCount: 6,
    images: [],
    specimen: false,
    styles: [
      { label: 'Decorative', file: null, available: false },
      { label: 'Regular', file: null, available: false },
      { label: 'Dingbats', file: null, available: false }
    ],
    evidence: 'C02 dan C05: deskripsi toko menyebut Decorative, Regular, dan Dingbats Set. Berkas belum ada.',
    needs: 'Tiga berkas style Tropivera (decorative, regular, dingbats) dari staging atau user.',
  }],
  // ------------------------------------------------------------------ kasus C03
  // Duo Sans + Handwritten dengan berkas asli dari user (10 Oktober 2026). Kelima
  // berkas memakai weight 400 dan typographic family `RT Mondriel` yang sama, jadi
  // descriptor FontFace tidak dapat membedakan face-nya. Identitas face karena itu
  // dibawa per style sebagai `faceFamily`, diambil dari nama legacy berkas itu
  // sendiri, dan loader-nya tetap generik (tidak menyebut nama produk).
  // Sumber acuan tetap di `Font Test/`; yang disalin ke repo hanya lima specimen ini
  // dengan hash identik (dicatat di ASSETS.md).
  ['mondriel', {
    name: 'Mondriel Font Duo',
    kind: 'mixed',
    storeStatus: 'live',
    permalink: 'https://rillatype.com/product/mondriel-font-duo/',
    style: 'Condensed sans with a handwritten cut',
    price: 17,
    images: [],
    specimen: true,
    styles: [
      { id: 'mondriel-regular', label: 'Regular', file: 'Mondriel-Regular.otf', dir: 'fonts/', faceFamily: 'RT Mondriel', weight: 400, available: true },
      { id: 'mondriel-slant', label: 'Slant', file: 'Mondriel-Slant.otf', dir: 'fonts/', faceFamily: 'RT Mondriel Slant', weight: 400, available: true },
      { id: 'mondriel-outline', label: 'Outline', file: 'Mondriel-Outline.otf', dir: 'fonts/', faceFamily: 'RT Mondriel Outline', weight: 400, available: true },
      { id: 'mondriel-outline-slant', label: 'Outline Slant', file: 'Mondriel-OutlineSlant.otf', dir: 'fonts/', faceFamily: 'RT Mondriel Outline Slant', weight: 400, available: true },
      { id: 'mondriel-handwritten', label: 'Handwritten', file: 'Mondriel-Handwritten.otf', dir: 'fonts/', faceFamily: 'RT Mondriel handwritten', weight: 400, available: true }
    ],
    // Keputusan fixture untuk test, bukan klaim urutan admin atau metadata toko.
    defaultStyle: 'Regular',
    evidence: 'C03: lima OTF dari user, hash dicatat di ASSETS.md. Regular/Slant/Outline/Outline Slant masing-masing 195 glyph dan 194 codepoint cmap (termasuk 0x00 dan 0x0D) tanpa tabel GSUB; Handwritten 219 glyph/187 codepoint dengan tag liga dan dlig. Harga toko terlihat $17 pada 10 Oktober 2026 (product-type-variable); label Demo tetap dipakai di prototype.',
    needs: 'Jumlah dan urutan opsi lisensi toko, SKU, serta gambar galeri belum diverifikasi. Hash specimen lokal harus diperiksa ulang bila berkas user berubah, dan hak distribusi web specimen menunggu W04/W19.',
  }],
  ['dockhand', {
    name: 'Dockhand',
    kind: 'mixed',
    storeStatus: 'live',
    permalink: 'https://rillatype.com/product/dockhand-font-duo/',
    style: 'Script and sans duo',
    price: 25,
    licenseCount: 6,
    images: [],
    specimen: false,
    styles: [
      { label: 'Script Regular', file: null, available: false },
      { label: 'Sans Regular', file: null, available: false }
    ],
    // Urutan default diambil dari deskripsi toko, yang menyebut script lebih dulu.
    // Nilai ini belum dapat diverifikasi sampai kedua berkasnya ada.
    defaultStyle: 'Script Regular',
    evidence: 'C03: deskripsi toko menyebut "script & sans font duo". Entri ini menandai keluarga campuran.',
    needs: 'Dua berkas: script dan sans Dockhand. Nama yang diharapkan dan cara verifikasinya ada di static/redesign/ASSETS.md.',
  }],
  ['wildkins', {
    name: "Wildkins Hiker's Bundle",
    kind: 'mixed',
    storeStatus: 'live',
    permalink: 'https://rillatype.com/product/wildkins-hikers-bundle-hand-inked-font-extras/',
    sku: '3628',
    style: 'Hand-inked font with extras',
    price: 25,
    licenseCount: 6,
    images: [],
    specimen: false,
    styles: [
      { label: 'Regular', file: null, available: false },
      { label: 'Slant', file: null, available: false },
      { label: 'Stamp', file: null, available: false },
      { label: 'Stamp Slant', file: null, available: false },
      { label: 'Dingbats', file: null, available: false }
    ],
    bonus: '30+ adventure icons, 8 badge templates, 3 texture PNG overlays (dari deskripsi toko).',
    evidence: 'C05 dan C07: deskripsi toko menyebut lima style termasuk Wildkins Dingbats dan bonus tekstur.',
    needs: 'Berkas lima style Wildkins untuk memeriksa glyph dingbats yang benar-benar tersedia.',
  }],
  ['solaya', {
    name: 'Solaya',
    kind: 'mixed',
    storeStatus: 'live',
    permalink: 'https://rillatype.com/product/solaya-a-dual-style-tropical-font-bonus-illustrations/',
    sku: '3783',
    style: 'Dual-style tropical font',
    price: 25,
    licenseCount: 6,
    images: [],
    specimen: false,
    styles: [
      { label: 'Raw', file: null, available: false },
      { label: 'Neat', file: null, available: false }
    ],
    bonus: 'Bonus illustrations (dari deskripsi toko).',
    evidence: 'C07: deskripsi toko menyebut dua style dan bonus ilustrasi.',
    needs: 'Berkas Solaya Raw dan Neat.',
  }],

  // ------------------------------- font nyata tanpa specimen: kasus C08
  ['darkwell', {
    name: 'Darkwell Family',
    kind: 'font',
    storeStatus: 'live',
    permalink: 'https://rillatype.com/product/darkwell-family/',
    sku: '3366',
    style: 'Signature family',
    price: 0,
    licenseCount: 0,
    free: true,
    images: [],
    specimen: false,
    styles: [
      { label: 'Darkwell One Regular', file: null, available: false },
      { label: 'Darkwell One Bold', file: null, available: false },
      { label: 'Darkwell One Italic', file: null, available: false },
      { label: 'Darkwell Two Regular', file: null, available: false },
      { label: 'Darkwell Two Bold', file: null, available: false },
      { label: 'Darkwell Two Italic', file: null, available: false }
    ],
    evidence: 'C08: deskripsi toko menyebut dua font dengan regular, bold, italic. Produk tetap font, bukan Graphic.',
    needs: 'Berkas Darkwell untuk memastikan nama dua font yang benar.',
  }],

  // ------------------------------- produk toko lain yang sudah terverifikasi P02
  ['redline', {
    name: 'Redline Syndicate',
    kind: 'font',
    storeStatus: 'live',
    permalink: 'https://rillatype.com/product/redline-syndicate-display-font/',
    sku: '3976',
    style: 'Urgent handwritten display',
    price: 0,
    licenseCount: 6,
    free: true,
    images: [],
    specimen: false,
    styles: [{ label: 'Regular', file: null, available: false }],
    evidence: 'C10: enam variasi lisensi dengan standard 0 dan berbayar 50 sampai 1500 (lihat inventory P02).',
    needs: 'Berkas specimen Redline.',
  }],
  ['distressed-overlays', {
    name: 'Distressed Overlays Vol.01',
    kind: 'graphic',
    storeStatus: 'live',
    permalink: 'https://rillatype.com/product/distressed-overlays-vol-01-grunge-texture-pack/',
    sku: '3252',
    style: 'Grunge texture pack',
    price: 0,
    licenseCount: 0,
    free: true,
    images: ['../previews/distressed-overlays-1.jpg'],
    specimen: false,
    styles: [],
    evidence: 'C06: produk non-font tanpa selector lisensi font. Deskripsi menyebut PNG dalam ZIP. Kategori toko graphic + freebies, simple; harga 15 dicoret menjadi 0 (dibaca 10 Oktober 2026).',
  }],
  ['palm-tree', {
    name: 'Palm Tree Illustration Set',
    kind: 'graphic',
    storeStatus: 'live',
    permalink: 'https://rillatype.com/product/palm-tree-illustration-set/',
    sku: '3214',
    style: 'Illustration set',
    price: 0,
    licenseCount: 0,
    free: true,
    images: ['../previews/palm-tree-1.jpg'],
    specimen: false,
    styles: [],
    evidence: 'Kategori toko graphic + freebies, simple; harga 15 dicoret menjadi 0 (dibaca 10 Oktober 2026). Produk ilustrasi, bukan font, jadi tanpa tester.',
  }],
  ['cowboy-horseback', {
    name: 'Wild West Cowboy on Horseback',
    kind: 'graphic',
    storeStatus: 'live',
    permalink: 'https://rillatype.com/product/cowboy-illustration-template/',
    sku: '3241',
    style: 'Vintage illustration',
    price: 0,
    licenseCount: 0,
    free: true,
    images: ['../previews/cowboy-horseback-1.jpg'],
    specimen: false,
    styles: [],
    evidence: 'Judul toko lengkap: "Wild West Cowboy on Horseback - Vintage Western Illustration". Kategori graphic + freebies, simple; harga 15 dicoret menjadi 0 (dibaca 10 Oktober 2026).',
  }],
  ['cowboy-bear', {
    name: 'Stay Wild - Vintage Cowboy and Bear',
    kind: 'graphic',
    storeStatus: 'live',
    permalink: 'https://rillatype.com/product/cowboy-illustration-template-copy/',
    sku: '3245',
    style: 'Vintage illustration',
    price: 0,
    licenseCount: 0,
    free: true,
    images: ['../previews/cowboy-bear-1.jpg'],
    specimen: false,
    styles: [],
    evidence: 'Judul toko lengkap: "Stay Wild - Vintage Cowboy and Bear Adventure Illustration". Kategori graphic + freebies, simple; harga 15 dicoret menjadi 0 (dibaca 10 Oktober 2026).',
  }],

  // ------------------------------------------- entri demo, bukan produk terkonfirmasi
  // Dipakai catalog.html dan product.html selama belum ada padanan produk nyata.
  // Jangan diperlakukan sebagai produk toko. `storeStatus: 'demo'` adalah penandanya.
  ['bawden', { name: 'Bawden', kind: 'font', storeStatus: 'demo', permalink: 'https://rillatype.com/product/bawden-slab-serif/', style: 'Slab serif display', price: 24, images: ['../previews/bawden-1.jpg'], specimen: false, styles: [{ label: 'Regular', file: null, available: false }], evidence: 'Entri demo. Produk toko nyata ada di permalink, tetapi gambar dan harga masih contoh.' }],
  ['baldock', { name: 'Baldock', kind: 'font', storeStatus: 'demo', permalink: 'https://rillatype.com/product/baldock-retro-font/', style: 'Retro display', price: 24, images: ['../previews/baldock-1.jpg'], specimen: false, styles: [{ label: 'Regular', file: null, available: false }], evidence: 'Entri demo. Produk toko nyata ada di permalink, tetapi gambar dan harga masih contoh.' }],
  ['daisy', { name: 'Daisy Hotline', kind: 'font', storeStatus: 'demo', permalink: 'https://rillatype.com/product/daisy-hotline-cute-retro-display-font/', style: 'Display', price: 20, images: ['../previews/daisy-hotline-1.jpg'], specimen: false, styles: [{ label: 'Regular', file: null, available: false }], evidence: 'Entri demo. Produk toko nyata ada di permalink.' }],
  ['crimson', { name: 'Crimson Queen', kind: 'font', storeStatus: 'demo', permalink: 'https://rillatype.com/product/crimson-queen-modern-serif/', style: 'Serif display', price: 22, images: ['../previews/crimson-queen-1.jpg'], specimen: false, styles: [{ label: 'Regular', file: null, available: false }], evidence: 'Entri demo. Produk toko nyata ada di permalink.' }],
  ['mordial', { name: 'Mordial', kind: 'font', storeStatus: 'demo', permalink: 'https://rillatype.com/product/mordial-modern-serif-font/', style: 'Modern serif', price: 24, images: ['../previews/mordial-1.jpg'], specimen: false, styles: [{ label: 'Regular', file: null, available: false }], evidence: 'Entri demo. Produk toko nyata ada di permalink.' }],
  ['moyshire', { name: 'Moyshire', kind: 'font', storeStatus: 'demo', permalink: 'https://rillatype.com/product/moyshire-vintage-script/', style: 'Vintage script', price: 20, images: ['../previews/moyshire-1.jpg'], specimen: false, styles: [{ label: 'Regular', file: null, available: false }], evidence: 'Entri demo. Produk toko nyata ada di permalink.' }],
  ['radiant', { name: 'Radiant Summertime', kind: 'font', storeStatus: 'demo', permalink: 'https://rillatype.com/product/radiant-summertime/', style: 'Handwritten script', price: 20, images: ['../previews/radiant-summertime-1.jpg'], specimen: false, styles: [{ label: 'Regular', file: null, available: false }], evidence: 'Entri demo. Padanan produk toko belum diverifikasi.' }],
  ['brush-set-1', { name: 'Ink Brush Set', kind: 'graphic', storeStatus: 'demo', permalink: 'https://rillatype.com/product-category/graphic/', style: 'Procreate brushes', price: 12, images: ['../previews/brush-set-1.jpg'], specimen: false, styles: [], evidence: 'Entri demo tanpa padanan produk toko. Gambar adalah mockup placeholder.' }],
  ['brush-set-2', { name: 'Marker Toolkit', kind: 'graphic', storeStatus: 'demo', permalink: 'https://rillatype.com/product-category/graphic/', style: 'Procreate brushes', price: 14, images: ['../previews/brush-set-2.jpg'], specimen: false, styles: [], evidence: 'Entri demo tanpa padanan produk toko. Gambar adalah mockup placeholder.' }],
  ['brush-set-3', { name: 'Watercolor Wash', kind: 'graphic', storeStatus: 'demo', permalink: 'https://rillatype.com/product-category/freebies/', style: 'Procreate brushes', price: 0, free: true, images: ['../previews/brush-set-3.jpg'], specimen: false, styles: [], evidence: 'Entri demo tanpa padanan produk toko. Gambar adalah mockup placeholder.' }],
  ['font-bundle-1', { name: 'Foundry Bundle Vol. 1', kind: 'font', storeStatus: 'demo', permalink: 'https://rillatype.com/product-category/font/', style: 'Font bundle', price: 49, images: ['../previews/font-bundle-1.jpg'], specimen: false, styles: [], evidence: 'Entri demo tanpa padanan produk toko. Gambar adalah mockup placeholder.' }],
  ['font-bundle-2', { name: 'Display Duo', kind: 'font', storeStatus: 'demo', permalink: 'https://rillatype.com/product-category/font/', style: 'Font bundle', price: 34, images: ['../previews/font-bundle-2.jpg'], specimen: false, styles: [], evidence: 'Entri demo tanpa padanan produk toko. Gambar adalah mockup placeholder.' }],
  ['graphic-pack-1', { name: 'Stamp and Badge Pack', kind: 'graphic', storeStatus: 'demo', permalink: 'https://rillatype.com/product-category/graphic/', style: 'Graphic elements', price: 9, images: ['../previews/graphic-pack-1.jpg'], specimen: false, styles: [], evidence: 'Entri demo tanpa padanan produk toko. Gambar adalah mockup placeholder.' }],
  ['graphic-pack-2', { name: 'Label and Tag Pack', kind: 'graphic', storeStatus: 'demo', permalink: 'https://rillatype.com/product-category/graphic/', style: 'Graphic elements', price: 8, images: ['../previews/graphic-pack-2.jpg'], specimen: false, styles: [], evidence: 'Entri demo tanpa padanan produk toko. Gambar adalah mockup placeholder.' }],
]);

window.RillaCatalog = { catalog };
