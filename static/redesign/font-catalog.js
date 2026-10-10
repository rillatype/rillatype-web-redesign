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
    styles: [{ label: 'Regular', file: 'mango-letter.otf', dir: '../previews/', weight: 400 }],
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
      { label: 'Thin', file: 'Chronoa-Thin.otf', weight: 100, available: true },
      { label: 'ExtraLight', file: 'Chronoa-ExtraLight.otf', weight: 200, available: true },
      { label: 'Light', file: 'Chronoa-Light.otf', weight: 300, available: true },
      { label: 'Regular', file: 'Chronoa-Regular.otf', weight: 400, available: true },
      { label: 'Medium', file: 'Chronoa-Medium.otf', weight: 500, available: true },
      { label: 'SemiBold', file: 'Chronoa-SemiBold.otf', weight: 600, available: true },
      { label: 'Bold', file: 'Chronoa-Bold.otf', weight: 700, available: true },
      { label: 'ExtraBold', file: 'Chronoa-ExtraBold.otf', weight: 800, available: true },
      { label: 'Black', file: 'Chronoa-Black.otf', weight: 900, available: true }
    ],
    defaultStyle: 'SemiBold',
    features: { liga: false, salt: false },
    evidence: 'C04: sembilan cut OTF asli. Deskripsi toko menyebut Thin sampai Black.',
  }],

  // ------------------------------------------- kasus C02, C03, C05: berkas belum ada
  // Nama style berasal dari deskripsi toko. Berkas specimen belum tersedia, jadi
  // `specimen: false` dan setiap style membawa `file: null` serta `available: false`.
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
    evidence: 'C03: deskripsi toko menyebut "script & sans font duo". Entri ini menandai keluarga campuran.',
    needs: 'Berkas script dan sans Dockhand yang terverifikasi user.',
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
    images: [],
    specimen: false,
    styles: [],
    evidence: 'C06: produk non-font tanpa selector lisensi font. Deskripsi menyebut PNG dalam ZIP.',
    needs: 'Gambar gallery produk dari staging.',
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
