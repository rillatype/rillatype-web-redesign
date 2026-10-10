/**
 * P03 helper: print the font catalog as JSON so checks read the real data
 * instead of pattern-matching the source.
 *
 * Usage: node scripts/_p03_catalog_json.mjs
 */
import fs from "node:fs";
import vm from "node:vm";

const code = fs.readFileSync("static/redesign/font-catalog.js", "utf8");
const sandbox = { window: {}, document: undefined };
vm.createContext(sandbox);
try {
  // `const` is lexically scoped inside the script, so read the Map as the
  // completion value instead of as a sandbox property.
  const catalog = vm.runInContext(`${code}\n;catalog`, sandbox);
  const out = {};
  for (const [key, value] of catalog) out[key] = value;
  process.stdout.write(JSON.stringify(out));
} catch (error) {
  process.stdout.write(JSON.stringify({ __error: String(error) }));
  process.exitCode = 1;
}
