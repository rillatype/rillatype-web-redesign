/**
 * P08 helper: does the GSUB table of a font actually define substitutions for a
 * feature tag, or does it only declare the tag?
 *
 * Usage: node scripts/_p08_feature_depth.mjs <font-file> [tag...]
 */
import fs from "node:fs";

const file = process.argv[2];
const tags = process.argv.slice(3);
if (!file || !tags.length) {
  console.error("usage: node _p08_feature_depth.mjs <font> <tag...>");
  process.exit(1);
}

const buf = fs.readFileSync(file);
const numTables = buf.readUInt16BE(4);
const table = {};
for (let i = 0; i < numTables; i += 1) {
  const rec = 12 + i * 16;
  table[buf.toString("latin1", rec, rec + 4)] = {
    offset: buf.readUInt32BE(rec + 8),
    length: buf.readUInt32BE(rec + 12),
  };
}

if (!table.GSUB) {
  console.log(JSON.stringify({ file, gsub: false, features: {} }));
  process.exit(0);
}

const base = table.GSUB.offset;
const featureListOffset = base + buf.readUInt16BE(base + 6);
const featureCount = buf.readUInt16BE(featureListOffset);
const records = [];
for (let i = 0; i < featureCount; i += 1) {
  const rec = featureListOffset + 2 + i * 6;
  records.push({
    tag: buf.toString("latin1", rec, rec + 4),
    // Feature table offset is relative to the FeatureList, per the spec.
    offset: featureListOffset + buf.readUInt16BE(rec + 4),
  });
}

const out = {};
for (const tag of tags) {
  const rec = records.find((r) => r.tag === tag);
  if (!rec) { out[tag] = { declared: false }; continue; }
  const lookupCount = buf.readUInt16BE(rec.offset + 2);
  const lookupIndexes = [];
  for (let i = 0; i < lookupCount; i += 1) {
    lookupIndexes.push(buf.readUInt16BE(rec.offset + 4 + i * 2));
  }
  // A declared feature with a lookup that carries substitutions is real work.
  const lookupListOffset = base + buf.readUInt16BE(base + 8);
  const lookupCountAll = buf.readUInt16BE(lookupListOffset);
  let subtableTypes = [];
  for (const index of lookupIndexes) {
    if (index >= lookupCountAll) continue;
    const lo = lookupListOffset + buf.readUInt16BE(lookupListOffset + 2 + index * 2);
    const type = buf.readUInt16BE(lo);
    const subCount = buf.readUInt16BE(lo + 4);
    const kinds = [];
    for (let s = 0; s < subCount; s += 1) {
      const so = lo + buf.readUInt16BE(lo + 6 + s * 2);
      kinds.push(buf.readUInt16BE(so));
    }
    subtableTypes.push({ lookup: index, type, subtableFormats: kinds });
  }
  out[tag] = { declared: true, lookups: lookupIndexes, subtableTypes };
}

console.log(JSON.stringify({ file, gsub: true, features: out }, null, 1));
