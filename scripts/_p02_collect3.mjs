const UA = { headers: { "user-agent": "Mozilla/5.0 (compatible; RillatypeRedesignAudit/1.0)" } };
const decode = s => s.replace(/&quot;/g,'"').replace(/&#0?39;/g,"'").replace(/&#8217;/g,"\u2019").replace(/&#8211;/g,"\u2013").replace(/&amp;/g,"&").replace(/&nbsp;/g," ").replace(/&#038;/g,"&");
const text = s => decode(s.replace(/<[^>]*>/g," ")).replace(/\s+/g," ").trim();
const CANDIDATES = ["dockhand-font-duo","highway-patrol-font-duo","goodneigbor-vintage-font-duo","be-serious-expanded-sans","mondriel-font-duo","daymore-font-duo","quentin-sonata-font-duo","brika-font-duo-20-coffee-vectors-dingbat-icons","nocturne-black-gothic-horror-font-family","chronoa-font-family"];
for (const slug of CANDIDATES) {
  const url = `https://rillatype.com/product/${slug}/`;
  const res = await fetch(url, UA);
  if (res.status !== 200) { console.log(`===== ${res.status} ${slug}`); continue; }
  const html = await res.text();
  const ld = html.match(/<script type="application\/ld\+json">([\s\S]*?)<\/script>/i);
  const offer = ld ? (JSON.parse(decode(ld[1])).offers || {}) : {};
  const desc = html.match(/id="tab-description"[\s\S]{0,2000}?aria-labelledby="tab-title-description">([\s\S]{0,1400}?)<\/div>/i);
  const inc = desc ? text(desc[1]) : "-";
  const sansScript = [];
  for (const k of ["sans serif","sans-serif","\\bSans\\b","Script","serif"]) if (new RegExp(k, "i").test(inc)) sansScript.push(k);
  console.log(`===== ${slug}`);
  console.log(`  low=${offer.lowPrice} high=${offer.highPrice} count=${offer.offerCount}`);
  console.log(`  desc: ${inc.slice(0, 520)}`);
  console.log(`  keywords: ${sansScript.join(", ") || "-"}`);
}
console.log("\n===== REDLINE freebie details =====");
{
  const html = await (await fetch("https://rillatype.com/product/redline-syndicate-display-font/", UA)).text();
  const raw = decode(html.match(/data-product_variations="([\s\S]*?)"/)?.[1] || "");
  for (const m of raw.matchAll(/"variation_id":(\d+)[\s\S]{0,400}?"attribute_pa_license":"([^"]+)"[\s\S]{0,600}?"display_price":([\d.]+)/g)) {
    console.log(`  variation ${m[1]}  ${m[2]}  display_price=${m[3]}`);
  }
  const ids = [...raw.matchAll(/"variation_id":(\d+)/g)].map(m=>m[1]);
  console.log("  variationIds:", ids.join(", "));
}
