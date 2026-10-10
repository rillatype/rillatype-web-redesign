const UA = { headers: { "user-agent": "Mozilla/5.0 (compatible; RillatypeRedesignAudit/1.0)" } };
const decode = s => s.replace(/&quot;/g,'"').replace(/&#0?39;/g,"'").replace(/&#8217;/g,"\u2019").replace(/&#8211;/g,"\u2013").replace(/&amp;/g,"&").replace(/&nbsp;/g," ").replace(/&#038;/g,"&");
const text = s => decode(s.replace(/<[^>]*>/g," ")).replace(/\s+/g," ").trim();
const pages = ["https://rillatype.com/product/tropivera/","https://rillatype.com/product/solaya-a-dual-style-tropical-font-bonus-illustrations/","https://rillatype.com/product/darkwell-family/","https://rillatype.com/product/wildkins-hikers-bundle-hand-inked-font-extras/"];
const keywords = ["Regular","Rough","Slanted","Italic","Sans","Script","Dingbat","Raw","Neat","Bold","Light","Illustration","Bonus","PNG","EPS","SVG","OTF","TTF","WOFF","ZIP","Included"];
for (const url of pages) {
  const html = await (await fetch(url, UA)).text();
  const short = html.match(/woocommerce-product-details__short-description">([\s\S]{0,700}?)<\/div>/i);
  const desc = html.match(/id="tab-description"[\s\S]{0,2600}?<\/div>\s*<\/div>/i) || html.match(/woocommerce-Tabs-panel--description[^>]*>([\s\S]{0,2600}?)<\/div>/i);
  console.log("=====", url);
  console.log("  shortDesc:", short ? text(short[1]).slice(0,400) : "-");
  console.log("  longDesc :", desc ? text(desc[0]).slice(0,700) : "-");
  const found = keywords.filter(k => new RegExp("\\b" + k, "i").test(decode(html).replace(/<script[\s\S]*?<\/script>/g," ")));
  console.log("  keywordHits:", found.join(", ") || "-");
  const styleAttr = [...new Set([...html.matchAll(/(?:attribute|pa)_([a-z_]+)/g)].map(m=>m[1]))];
  console.log("  attrTokens:", styleAttr.join(", "));
}
console.log("\n===== SHOP LISTING (product cards) =====");
for (const page of [1,2,3,4,5,6,7,8,9]) {
  const url = page === 1 ? "https://rillatype.com/shop/" : `https://rillatype.com/shop/page/${page}/`;
  const res = await fetch(url, UA);
  if (res.status !== 200) { console.log(`page ${page}: HTTP ${res.status}`); break; }
  const html = await res.text();
  const cards = [...html.matchAll(/<a href="https:\/\/rillatype\.com\/product\/([a-z0-9-]+)\/"[^>]*class="[^"]*woocommerce-LoopProduct-link[^"]*"[\s\S]{0,900}?<\/a>/gi)];
  const names = [...html.matchAll(/<h2 class="woocommerce-loop-product__title">([\s\S]*?)<\/h2>/gi)].map(m=>text(m[1]));
  const prices = [...html.matchAll(/<span class="woocommerce-Price-amount amount"><bdi>([\s\S]*?)<\/bdi>/gi)].map(m=>text(m[1]));
  const slugs = [...html.matchAll(/href="https:\/\/rillatype\.com\/product\/([a-z0-9-]+)\/"/g)].map(m=>m[1]);
  const unique = [...new Set(slugs)];
  console.log(`page ${page}: cards=${cards.length} names=${names.length} prices=${prices.length} uniqueSlugs=${unique.length}`);
  console.log(`  names: ${names.join(" ~ ").slice(0,600)}`);
  console.log(`  prices: ${prices.join(", ")}`);
  console.log(`  slugs: ${unique.join(", ").slice(0,700)}`);
}
