/**
 * P08 helper: independent OTF fact reader used as ground truth.
 *
 * Reads maxp.numGlyphs, cmap codepoints, and GSUB feature tags straight from the
 * font files with no dependency on the page code, so the UI can be checked
 * against the files instead of against itself.
 *
 * Usage: node scripts/_p08_font_facts.mjs [font-dir]
 */
import fs from "node:fs";
import path from "node:path";

const dir = process.argv[2] || "static/redesign/fonts";

function tables(buf) {
  const num = buf.readUInt16BE(4);
  const map = {};
  for (let i = 0; i < num; i += 1) {
    const rec = 12 + i * 16;
    const tag = buf.toString("latin1", rec, rec + 4);
    map[tag] = { offset: buf.readUInt32BE(rec + 8), length: buf.readUInt32BE(rec + 12) };
  }
  return map;
}

function numGlyphs(buf, map) {
  return buf.readUInt16BE(map.maxp.offset + 4);
}

function cmapCodepoints(buf, map) {
  if (!map.cmap) return [];
  const base = map.cmap.offset;
  const count = buf.readUInt16BE(base + 2);
  let best = null;
  let bestScore = -1;
  for (let i = 0; i < count; i += 1) {
    const rec = base + 4 + i * 8;
    const platform = buf.readUInt16BE(rec);
    const encoding = buf.readUInt16BE(rec + 2);
    const offset = base + buf.readUInt32BE(rec + 4);
    const fmt = buf.readUInt16BE(offset);
    const score = (platform === 3 && encoding === 10 ? 5 : platform === 3 && encoding === 1 ? 4 : platform === 0 ? 3 : 0) + (fmt === 12 ? 0.5 : 0);
    if (score > bestScore) { best = offset; bestScore = score; }
  }
  if (best === null) return [];
  const fmt = buf.readUInt16BE(best);
  const codes = new Set();
  if (fmt === 4) {
    const segX2 = buf.readUInt16BE(best + 6);
    const seg = segX2 / 2;
    const endBase = best + 14;
    const startBase = endBase + segX2 + 2;
    for (let s = 0; s < seg; s += 1) {
      const start = buf.readUInt16BE(startBase + s * 2);
      const end = buf.readUInt16BE(endBase + s * 2);
      if (start === 0xffff) continue;
      // Seluruh BMP dibaca: batas 0x2FFF yang dulu ada membuang codepoint sah di
      // private use area dan ligature presentation forms (Mondriel Handwritten
      // memetakan U+E92C, U+E93D, dan U+FB00, jadi pembaca ini melaporkan 184
      // padahal berkasnya memetakan 187). Surrogate bukan codepoint, jadi dilewati.
      for (let c = start; c <= end; c += 1) {
        if (c >= 0xd800 && c <= 0xdfff) continue;
        codes.add(c);
      }
    }
  } else if (fmt === 12) {
    const groups = buf.readUInt32BE(best + 12);
    for (let g = 0; g < groups; g += 1) {
      const rec = best + 16 + g * 12;
      const start = buf.readUInt32BE(rec);
      const end = buf.readUInt32BE(rec + 4);
      // Format 12 covers the whole Unicode range, so the cap has to be the real
      // upper bound; 0x10FFFF excludes nothing legitimate.
      for (let c = start; c <= end && c <= 0x10ffff; c += 1) codes.add(c);
    }
  }
  return [...codes].sort((a, b) => a - b);
}

function gsubFeatures(buf, map) {
  if (!map.GSUB) return [];
  const base = map.GSUB.offset;
  const featOffset = buf.readUInt16BE(base + 6);
  if (!featOffset) return [];
  const f = base + featOffset;
  const count = buf.readUInt16BE(f);
  const tags = [];
  for (let i = 0; i < count; i += 1) {
    const rec = f + 2 + i * 6;
    tags.push(buf.toString("latin1", rec, rec + 4));
  }
  return [...new Set(tags)].sort();
}

const out = {};
for (const name of fs.readdirSync(dir).filter((f) => /\.(otf|ttf)$/i.test(f)).sort()) {
  const buf = fs.readFileSync(path.join(dir, name));
  const map = tables(buf);
  const codes = cmapCodepoints(buf, map);
  out[name] = {
    glyphs: numGlyphs(buf, map),
    codepoints: codes.length,
    features: gsubFeatures(buf, map),
    hasLiga: gsubFeatures(buf, map).some((t) => t === "liga" || t === "clig"),
    hasSalt: gsubFeatures(buf, map).includes("salt"),
  };
}
process.stdout.write(JSON.stringify(out, null, 1));
