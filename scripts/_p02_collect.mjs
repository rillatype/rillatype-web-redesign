/**
 * P02 evidence collector. Read-only public page fetch that prints only the
 * facts the reference inventory needs: canonical name, permalink, categories,
 * price range, variation count and option values, gallery image URLs with
 * their rendered width/height, and the product's own category links.
 *
 * Usage: node scripts/_p02_collect.mjs
 */
const URLS = [
  "https://rillatype.com/",
  "https://rillatype.com/product/mango-letters-handwritten-font/",
  "https://rillatype.com/product/tropivera/",
  "https://rillatype.com/product/solaya-a-dual-style-tropical-font-bonus-illustrations/",
  "https://rillatype.com/product/darkwell-family/",
  "https://rillatype.com/product/distressed-overlays-vol-01-grunge-texture-pack/",
  "https://rillatype.com/product/redline-syndicate-display-font/",
  "https://rillatype.com/product/sunday-willow-handwritten-script/",
  "https://rillatype.com/product/wildkins-hikers-bundle-hand-inked-font-extras/",
  "https://rillatype.com/product/nutmeg-league/",
  "https://rillatype.com/product/magical-charm-dreamy-handwritten-font/",
  "https://rillatype.com/product/the-matcha-club-bold-retro-brush-font/",
];

const decode = (s) =>
  s.replace(/&quot;/g, '"').replace(/&#0?39;/g, "'").replace(/&#8217;/g, "\u2019")
    .replace(/&#8211;/g, "\u2013").replace(/&amp;/g, "&").replace(/&nbsp;/g, " ")
    .replace(/&#038;/g, "&").replace(/\\\//g, "/");

const text = (s) => decode(s.replace(/<[^>]*>/g, " ")).replace(/\s+/g, " ").trim();

for (const url of URLS) {
  let html;
  try {
    const res = await fetch(url, { headers: { "user-agent": "Mozilla/5.0 (compatible; RillatypeRedesignAudit/1.0)" } });
    if (res.status !== 200) { console.log(`===== ${res.status} ${url}`); continue; }
    html = await res.text();
  } catch (error) {
    console.log(`===== FETCH-FAIL ${url} :: ${error.message}`);
    continue;
  }

  console.log(`===== ${url}`);
  const ld = html.match(/<script type="application\/ld\+json">([\s\S]*?)<\/script>/i);
  if (ld) {
    try {
      const data = JSON.parse(decode(ld[1]));
      const node = Array.isArray(data) ? data.find((d) => d["@type"] === "Product") : (data["@type"] === "Product" ? data : null);
      const graph = !node && data["@graph"] ? data["@graph"].find((d) => d["@type"] === "Product") : null;
      const product = node || graph;
      if (product) {
        const offer = Array.isArray(product.offers) ? product.offers.find((o) => /Offer/.test(o["@type"])) : product.offers;
        console.log(`  ld.name: ${product.name}`);
        console.log(`  ld.sku: ${product.sku}`);
        console.log(`  ld.image: ${product.image}`);
        console.log(`  ld.offers: type=${offer?.["@type"]} low=${offer?.lowPrice ?? offer?.price} high=${offer?.highPrice} count=${offer?.offerCount} currency=${offer?.priceCurrency}`);
      }
    } catch (error) {
      console.log(`  ld.parse.error: ${error.message}`);
    }
  }

  const price = html.match(/<p class="price">([\s\S]{0,400}?)<\/p>/i);
  console.log(`  priceBlock: ${price ? text(price[1]) : "-"}`);

  const catLinks = [...new Set([...html.matchAll(/href="https:\/\/rillatype\.com\/product-category\/([a-z0-9-]+)\/"/g)].map((m) => m[1]))];
  console.log(`  categoryLinks: ${catLinks.join(", ") || "-"}`);

  const varAttr = html.match(/data-product_variations='?\[([\s\S]*?)\]'?\s/);
  const raw = decode(html.match(/data-product_variations="([\s\S]*?)"/)?.[1] || html.match(/data-product_variations='([\s\S]*?)'/)?.[1] || "");
  const optionSets = {};
  for (const m of raw.matchAll(/"attribute_([a-z_]+)":"([^"]*)"/g)) {
    optionSets[m[1]] = optionSets[m[1]] || new Set();
    optionSets[m[1]].add(m[2]);
  }
  for (const [key, set] of Object.entries(optionSets)) {
    console.log(`  variation.${key}: ${[...set].join(" | ")}`);
  }
  const variationCount = (raw.match(/"variation_id"/g) || []).length;
  console.log(`  variation.distinct: ${variationCount}`);

  // style selector markup (non-license attributes are rendered as selects or radios)
  const styleSelects = [...html.matchAll(/<(select|fieldset)[^>]*(?:id|class)="[^"]*(?:style|font)[^"]*"[^>]*>([\s\S]{0,600}?)<\/\1>/gi)];
  for (const m of styleSelects.slice(0, 3)) console.log(`  styleMarkup: ${text(m[0]).slice(0, 220)}`);

  const gallery = [...new Set([...html.matchAll(/<img[^>]+src="(https:\/\/rillatype\.com\/wp-content\/uploads\/[^"]+?)"[^>]*?(?:width="(\d+)"[^>]*?height="(\d+)")?/gi)]
    .filter((m) => !/logo|cropped|Profile|icon/i.test(m[1]))
    .map((m) => `${m[1].split("/uploads/")[1]}${m[2] ? ` [${m[2]}x${m[3]}]` : ""}`))];
  console.log(`  images(${gallery.length}):`);
  gallery.slice(0, 8).forEach((i) => console.log(`     ${i}`));
}
