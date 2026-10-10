const UA = { headers: { "user-agent": "Mozilla/5.0 (compatible; RillatypeRedesignAudit/1.0)" } };
const imgs = [
  "https://rillatype.com/wp-content/uploads/2026/05/Artboard1-1.jpg",
  "https://rillatype.com/wp-content/uploads/2026/06/Artboard1.jpg",
  "https://rillatype.com/wp-content/uploads/2026/05/Artboard1-2.jpg",
  "https://rillatype.com/wp-content/uploads/2024/11/Preview-3.jpg",
  "https://rillatype.com/wp-content/uploads/2025/09/Artboard-1.jpg",
  "https://rillatype.com/wp-content/uploads/2024/12/Artboard-1.png",
  "https://rillatype.com/wp-content/uploads/2025/04/1-1.jpg",
  "https://rillatype.com/wp-content/uploads/2026/05/Artboard1-3.jpg",
];
function size(buf) {
  if (buf[0] === 0xFF && buf[1] === 0xD8) {
    let i = 2;
    while (i < buf.length) {
      if (buf[i] !== 0xFF) { i++; continue; }
      const marker = buf[i + 1];
      const len = buf.readUInt16BE(i + 2);
      if (marker >= 0xC0 && marker <= 0xCF && ![0xC4, 0xC8, 0xCC].includes(marker)) {
        return { h: buf.readUInt16BE(i + 5), w: buf.readUInt16BE(i + 7) };
      }
      i += 2 + len;
    }
  }
  if (buf.slice(0, 8).toString("hex") === "89504e470d0a1a0a") {
    return { w: buf.readUInt32BE(16), h: buf.readUInt32BE(20) };
  }
  return null;
}
for (const url of imgs) {
  try {
    const res = await fetch(url, UA);
    const buf = Buffer.from(await res.arrayBuffer());
    const d = size(buf);
    const ratio = d ? (d.w / d.h).toFixed(3) : "?";
    console.log(`${res.status} ${(buf.length/1024).toFixed(0)}KB ${d ? d.w + "x" + d.h : "dims-unknown"} ratio=${ratio}  ${url.split("/uploads/")[1]}`);
  } catch (e) { console.log("FAIL", url, e.message); }
}
