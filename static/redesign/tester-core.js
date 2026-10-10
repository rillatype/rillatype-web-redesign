// Font tester: memuat specimen asli, menyediakan kontrol visual, dan mendeteksi
// dukungan OpenType langsung dari berkas font sehingga font baru otomatis terbaca.

const FONT_DIR = '../redesign/fonts/';

// Parser minimal untuk membaca feature tags pada tabel GSUB sebuah berkas OTF/TTF.
// Dipakai agar tombol ligature dan stylistic alternate hanya aktif saat font benar-benar mendukung.
async function readOtFeatures(url) {
  try {
    const response = await fetch(url);
    if (!response.ok) return null;
    const buffer = await response.arrayBuffer();
    const view = new DataView(buffer);
    if (view.byteLength < 12) return null;
    const numTables = view.getUint16(4);
    let gsubOffset = null;
    for (let i = 0; i < numTables; i += 1) {
      const record = 12 + i * 16;
      if (record + 16 > view.byteLength) break;
      const tag = String.fromCharCode(
        view.getUint8(record),
        view.getUint8(record + 1),
        view.getUint8(record + 2),
        view.getUint8(record + 3),
      );
      if (tag === 'GSUB') {
        gsubOffset = view.getUint32(record + 8);
        break;
      }
    }
    if (gsubOffset === null || gsubOffset + 10 > view.byteLength) return new Set();
    // FeatureList berada pada offset 6 dari awal tabel GSUB.
    const featureListOffset = gsubOffset + view.getUint16(gsubOffset + 6);
    if (featureListOffset + 2 > view.byteLength) return new Set();
    const featureCount = view.getUint16(featureListOffset);
    const tags = new Set();
    for (let i = 0; i < featureCount; i += 1) {
      const record = featureListOffset + 2 + i * 6;
      if (record + 4 > view.byteLength) break;
      tags.add(String.fromCharCode(
        view.getUint8(record),
        view.getUint8(record + 1),
        view.getUint8(record + 2),
        view.getUint8(record + 3),
      ));
    }
    return tags;
  } catch {
    return null;
  }
}

// Baca daftar codepoint yang dipetakan font, untuk panel glyph.
async function readGlyphCodepoints(url) {
  try {
    const response = await fetch(url);
    if (!response.ok) return [];
    const buffer = await response.arrayBuffer();
    const view = new DataView(buffer);
    if (view.byteLength < 12) return [];
    const numTables = view.getUint16(4);
    let cmapOffset = null;
    for (let i = 0; i < numTables; i += 1) {
      const record = 12 + i * 16;
      const tag = String.fromCharCode(
        view.getUint8(record), view.getUint8(record + 1),
        view.getUint8(record + 2), view.getUint8(record + 3),
      );
      if (tag === 'cmap') { cmapOffset = view.getUint32(record + 8); break; }
    }
    if (cmapOffset === null) return [];
    const subtableCount = view.getUint16(cmapOffset + 2);
    // Pilih subtable format 4 dengan platform Windows atau Unicode.
    for (let i = 0; i < subtableCount; i += 1) {
      const record = cmapOffset + 4 + i * 8;
      const platform = view.getUint16(record);
      const subtableOffset = cmapOffset + view.getUint32(record + 4);
      if (view.getUint16(subtableOffset) !== 4) continue;
      if (platform !== 0 && platform !== 3) continue;
      const segCountX2 = view.getUint16(subtableOffset + 6);
      const segCount = segCountX2 / 2;
      const endBase = subtableOffset + 14;
      const startBase = endBase + segCountX2 + 2;
      const codepoints = [];
      for (let s = 0; s < segCount; s += 1) {
        const start = view.getUint16(startBase + s * 2);
        const end = view.getUint16(endBase + s * 2);
        if (start === 0xffff) continue;
        // Seluruh rentang BMP dibaca. Batas 0x2FFF yang dulu dipakai di sini
        // membuang codepoint yang sah di private use area dan ligature
        // presentation forms: Mondriel Handwritten memetakan U+E92C, U+E93D, dan
        // U+FB00, sehingga panel melaporkan 184 padahal berkasnya memetakan 187.
        // Surrogate dilewati karena bukan codepoint; format 4 hanya memuat BMP,
        // jadi tidak ada batas atas lain yang diperlukan.
        for (let c = start; c <= end; c += 1) {
          if (c >= 0xd800 && c <= 0xdfff) continue;
          codepoints.push(c);
        }
      }
      if (codepoints.length) return codepoints;
    }
    return [];
  } catch {
    return [];
  }
}

window.RillaTester = { readOtFeatures, readGlyphCodepoints, FONT_DIR };
