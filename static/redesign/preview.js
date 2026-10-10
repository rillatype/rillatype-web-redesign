// Homepage behaviour: mobile menu, collection search, and the live specimen.
// The specimen font files are fetched only when a visitor asks for them, so the
// page renders without waiting on 265 KB of OTF.
//
// This file names no font, no font file, and no cut count. Every font fact comes
// from font-catalog.js and every content choice from home-fixture.js, so the
// featured font can be swapped -- including to a single-style font -- without
// editing behaviour (P11).

const menuButton = document.querySelector('.menu-button');
const navigation = document.querySelector('#navigation');
function closeMenu() {
  if (!menuButton || !navigation) return;
  menuButton.setAttribute('aria-expanded', 'false');
  navigation.classList.remove('is-open');
}
if (menuButton && navigation) {
  menuButton.addEventListener('click', () => {
    const open = menuButton.getAttribute('aria-expanded') !== 'true';
    menuButton.setAttribute('aria-expanded', String(open));
    navigation.classList.toggle('is-open', open);
  });
  navigation.addEventListener('click', event => {
    if (event.target.closest('a')) closeMenu();
  });
  document.addEventListener('keydown', event => {
    if (event.key === 'Escape' && menuButton.getAttribute('aria-expanded') === 'true') {
      closeMenu();
      menuButton.focus();
    }
  });
}

// ---------------------------------------------------------------- specimen
const fontData = (window.RillaCatalog && window.RillaCatalog.catalog) || new Map();
const homeData = window.RillaHome || {};

// A product can be tried live only when the catalog gives it a family and its
// styles a web subset. Both are facts about the font, so both live in the
// catalog; nothing here knows how many cuts a family has.
function specimenStyles(product) {
  if (!product || !product.specimenFamily) return [];
  return (product.styles || [])
    .filter(style => style && style.web)
    .sort((a, b) => (a.weight || 0) - (b.weight || 0));
}

function defaultStyle(product) {
  const styles = specimenStyles(product);
  return styles.find(style => style.label === product.defaultStyle) || styles[0] || null;
}

const specimenProducts = (homeData.specimen || [])
  .map(slug => ({ slug, product: fontData.get(slug) }))
  .filter(entry => entry.product && specimenStyles(entry.product).length);

const featuredEntry = (() => {
  const slug = homeData.featured && homeData.featured.slug;
  const product = slug ? fontData.get(slug) : null;
  if (product) return { slug, product };
  return specimenProducts[0] || null;
})();

const specimenFrame = document.querySelector('#specimen-frame');
const specimenLine = document.querySelector('#specimen-line');
const specimenError = document.querySelector('#specimen-error');
const specimenStatus = document.querySelector('#specimen-status');
const specimenFacts = document.querySelector('#specimen-facts');
const cutPicker = document.querySelector('#cut-picker');
const weightPicker = document.querySelector('#weight-picker');
const stripsRow = document.querySelector('#specimen-strips');
const loadedFaces = new Set();
const inFlight = new Map();
let activeSlug = specimenProducts.length ? specimenProducts[0].slug : null;
let activeWeight = activeSlug ? (defaultStyle(fontData.get(activeSlug)) || {}).weight : null;
let userTyped = false;
let specimenRequest = 0;

function setFrameState(state) {
  if (specimenFrame) specimenFrame.dataset.state = state;
  if (specimenLine) specimenLine.hidden = state === 'error';
  if (specimenError) specimenError.hidden = state !== 'error';
}

function faceStack(product) {
  return `"${product.specimenFamily}", "Manrope", sans-serif`;
}

// One loader for every cut, so the specimen band, the strips, and the index can
// never fetch the same face twice.
async function registerFace(slug, weight) {
  const product = fontData.get(slug);
  const style = specimenStyles(product).find(item => item.weight === weight);
  if (!style) return null;
  const key = `${slug}-${weight}`;
  if (loadedFaces.has(key)) return style;
  let pending = inFlight.get(key);
  if (!pending) {
    const dir = product.specimenDir || 'fonts/web/';
    const source = new URL(`${dir}${style.web}`, location.href).href;
    pending = (async () => {
      const face = new FontFace(product.specimenFamily, `url("${source}") format("woff2")`, { weight: String(style.weight) });
      await face.load();
      document.fonts.add(face);
      loadedFaces.add(key);
      return style;
    })();
    inFlight.set(key, pending);
    // Kegagalan tidak boleh di-cache: kalau tidak, cut yang pernah gagal tidak akan
    // pernah bisa diambil ulang tanpa reload halaman. Hanya entry milik percobaan ini
    // yang dilepas, jadi cleanup percobaan lama tidak menghapus promise milik
    // percobaan baru, dan request yang benar-benar sedang berjalan tetap dideduplikasi.
    const release = () => {
      if (inFlight.get(key) === pending) inFlight.delete(key);
    };
    pending.then(release, release);
  }
  try {
    return await pending;
  } catch (error) {
    return null;
  }
}

function factsLine(product, style) {
  const facts = product.specimenFacts || {};
  return [
    `${product.name} ${style.label}`,
    facts.glyphs ? `${facts.glyphs} glyphs` : null,
    facts.features || null
  ].filter(Boolean).join(' · ');
}

async function showSpecimen(slug, weight, fallbackText) {
  const product = fontData.get(slug);
  if (!product) return;
  const request = ++specimenRequest;
  setFrameState('loading');
  const style = await registerFace(slug, weight);
  if (request !== specimenRequest) return;
  if (!style) {
    setFrameState('error');
    if (specimenFacts) specimenFacts.textContent = '';
    if (specimenStatus) specimenStatus.textContent = `Could not load ${product.name}. Check your connection, then select another cut to retry.`;
    return;
  }
  // The line belongs to the visitor: only seed it while they have not typed.
  if (!userTyped) specimenLine.textContent = fallbackText || product.name;
  specimenLine.style.fontFamily = faceStack(product);
  specimenLine.style.fontWeight = String(style.weight);
  // Tracking is a property of the face: handwriting wants none, a geometric sans
  // wants it tight. Read from the catalog instead of guessing from the name.
  specimenLine.style.letterSpacing = product.specimenTracking || '0';
  setFrameState('ready');
  if (specimenFacts) specimenFacts.textContent = factsLine(product, style);
  if (specimenStatus) specimenStatus.textContent = `Type your own words. Switch fonts and keep your text.`;
}

function buildCutPicker() {
  if (!cutPicker) return;
  cutPicker.textContent = '';
  specimenProducts.forEach(({ slug, product }) => {
    const label = document.createElement('label');
    const input = document.createElement('input');
    input.type = 'radio';
    input.name = 'specimen-cut';
    input.value = slug;
    input.checked = slug === activeSlug;
    const span = document.createElement('span');
    span.textContent = product.name;
    label.append(input, span);
    cutPicker.append(label);
  });
  cutPicker.hidden = specimenProducts.length < 2;
}

function buildWeightPicker(slug) {
  if (!weightPicker) return;
  weightPicker.textContent = '';
  const styles = specimenStyles(fontData.get(slug));
  styles.forEach(style => {
    const label = document.createElement('label');
    const input = document.createElement('input');
    input.type = 'radio';
    input.name = 'specimen-weight';
    input.value = String(style.weight);
    input.checked = style.weight === activeWeight;
    const span = document.createElement('span');
    span.textContent = String(style.weight);
    label.append(input, span);
    weightPicker.append(label);
  });
  // A single cut has no weight to choose.
  weightPicker.hidden = styles.length < 2;
}

function observeOnce(nodes, callback) {
  if (!nodes.length) return;
  if (!('IntersectionObserver' in window)) {
    nodes.forEach(callback);
    return;
  }
  const watcher = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;
      watcher.unobserve(entry.target);
      callback(entry.target);
    });
  }, { rootMargin: '150px' });
  nodes.forEach(node => watcher.observe(node));
}

// The strips sample named cuts of the featured family. Fewer than two resolved
// cuts cannot be "three real cuts side by side", so the row hides instead of
// stretching one cut across the grid.
function buildStrips(slug) {
  if (!stripsRow) return;
  const product = fontData.get(slug);
  const styles = specimenStyles(product);
  const resolved = (homeData.strips || [])
    .map(item => ({ item, style: styles.find(style => style.label === item.style) }))
    .filter(entry => entry.style);
  stripsRow.textContent = '';
  stripsRow.hidden = resolved.length < 2;
  if (stripsRow.hidden) return;
  resolved.forEach(({ item, style }) => {
    const strip = document.createElement('div');
    strip.className = 'strip';
    const sample = document.createElement('p');
    sample.className = 'strip-sample';
    sample.textContent = item.text;
    sample.style.fontFamily = faceStack(product);
    sample.style.fontWeight = String(style.weight);
    const caption = document.createElement('p');
    caption.className = 'strip-cap';
    const name = document.createElement('b');
    name.textContent = `${product.name} ${style.weight} ${style.label}`;
    const note = document.createElement('span');
    note.textContent = item.caption;
    caption.append(name, note);
    strip.append(sample, caption);
    stripsRow.append(strip);
  });
  observeOnce([...stripsRow.querySelectorAll('.strip-sample')],
    node => registerFace(slug, Number(node.style.fontWeight)));
}

function buildSpecSheet(list, product) {
  if (!list) return;
  const styles = specimenStyles(product);
  const facts = product.specimenFacts || {};
  const rows = [];
  if (styles.length) rows.push(['Family', styles.length === 1 ? '1 style' : `${styles.length} weights`]);
  if (facts.glyphs) rows.push(['Glyphs per cut', String(facts.glyphs)]);
  if (typeof product.price === 'number') rows.push(['Preview price', `Demo $${product.price}`]);
  list.textContent = '';
  rows.forEach(([term, value]) => {
    const row = document.createElement('div');
    const dt = document.createElement('dt');
    dt.textContent = term;
    const dd = document.createElement('dd');
    dd.textContent = value;
    row.append(dt, dd);
    list.append(row);
  });
}

// The featured block is editorial content about one product. Everything that is
// a fact about the font -- name, route, artwork, family, weight, cut count,
// glyph count, price -- is derived; only the prose and the alt text are authored.
function renderFeatured() {
  if (!featuredEntry) return;
  const { slug, product } = featuredEntry;
  const style = defaultStyle(product);
  const route = `product.html?font=${slug}`;
  const art = document.querySelector('#featured-art');
  const image = art && art.querySelector('img');
  if (image) {
    if (product.images && product.images.length) {
      image.src = product.images[0];
      image.alt = (homeData.featured && homeData.featured.artAlt) || `${product.name} specimen sheet`;
      image.hidden = false;
    } else {
      image.hidden = true;
    }
  }
  if (art) art.setAttribute('href', route);
  const title = document.querySelector('#featured-title');
  if (title) {
    title.textContent = product.name;
    if (product.specimenFamily) title.style.fontFamily = faceStack(product);
    if (style) title.style.fontWeight = String(style.weight);
    if (product.specimenTracking === '0') title.style.letterSpacing = '0';
  }
  const copy = document.querySelector('#featured-copy');
  if (copy && homeData.featured) copy.innerHTML = homeData.featured.copy;
  const link = document.querySelector('#featured-link');
  if (link) {
    link.setAttribute('href', route);
    link.innerHTML = `Explore ${product.name} <span aria-hidden="true">↗</span>`;
  }
  buildSpecSheet(document.querySelector('#featured-specs'), product);
}

// An index row that has a specimen is set in that product's own typeface. Rows
// without one keep the UI face, because there is no font file to show.
function renderRowFaces() {
  document.querySelectorAll('.row[data-slug]').forEach(row => {
    const product = fontData.get(row.dataset.slug);
    const style = defaultStyle(product);
    const name = row.querySelector('.row-name');
    if (!style || !name) return;
    name.style.fontFamily = faceStack(product);
    name.style.fontWeight = String(style.weight);
    name.dataset.face = '';
    if (product.specimenTracking === '0') name.dataset.tracking = 'open';
    observeOnce([name], node => registerFace(row.dataset.slug, Number(node.style.fontWeight)));
  });
}

renderFeatured();
renderRowFaces();

if (specimenLine && activeSlug) {
  buildCutPicker();
  buildWeightPicker(activeSlug);
  buildStrips(featuredEntry ? featuredEntry.slug : activeSlug);
  let armed = false;
  const arm = () => {
    if (armed) return;
    armed = true;
    showSpecimen(activeSlug, activeWeight, fontData.get(activeSlug).name);
  };
  // Load only when the specimen is near the viewport, so the first paint is free.
  observeOnce([specimenLine], arm);
  specimenLine.addEventListener('focus', () => {
    const range = document.createRange();
    range.selectNodeContents(specimenLine);
    const selection = getSelection();
    selection.removeAllRanges();
    selection.addRange(range);
  });
  specimenLine.addEventListener('input', () => {
    userTyped = true;
  });
  specimenLine.addEventListener('keydown', event => {
    if (event.key === 'Enter') {
      event.preventDefault();
      specimenLine.blur();
    }
  });
} else if (specimenFrame) {
  // No product has a web specimen: there is nothing to try, so the band says so
  // by leaving rather than showing controls that cannot load anything.
  const band = specimenFrame.closest('.specimen-band');
  if (band) band.hidden = true;
}

if (cutPicker) {
  cutPicker.addEventListener('change', event => {
    if (!event.target.matches('input[name="specimen-cut"]')) return;
    activeSlug = event.target.value;
    const product = fontData.get(activeSlug);
    activeWeight = (defaultStyle(product) || {}).weight;
    buildWeightPicker(activeSlug);
    showSpecimen(activeSlug, activeWeight, product.name);
  });
}
if (weightPicker) {
  weightPicker.addEventListener('change', event => {
    if (!event.target.matches('input[name="specimen-weight"]')) return;
    activeWeight = Number(event.target.value);
    showSpecimen(activeSlug, activeWeight, currentText());
  });
}

function currentText() {
  const text = (specimenLine.textContent || '').trim();
  return text || 'Your brand name';
}

/* eslint-disable no-unused-vars */
// Everything below the menu belongs to the pages that carry a search form or a
// live specimen; the product page loads this file for the shared menu only.
if (document.querySelector('#specimen-frame') || document.querySelector('#font-search')) {
  // ---------------------------------------------------------------- search
  // One filter serves both surfaces: the homepage collection is an index of
  // .row entries, the catalog page is a grid of .product cards.
  const SEARCHABLE = '.row[data-name], .product[data-name]';
  const searchForm = document.querySelector('#font-search');
if (searchForm) {
  const query = document.querySelector('#query');
  const categoryFilters = [...document.querySelectorAll('.filter[data-category]')];
  const tagFilters = [...document.querySelectorAll('.filter[data-tag]')];
  const products = [...document.querySelectorAll(SEARCHABLE)];
  const resultCount = document.querySelector('#result-count');
  const collectionCount = document.querySelector('#collection-count');
  const totalProducts = products.length;
  let category = 'all';
  let tag = 'none';
  const params = new URLSearchParams(location.search);
  if (params.get('category')) category = params.get('category');
  if (params.get('tag')) tag = params.get('tag');
  if (params.get('q')) query.value = params.get('q');

  function updateResults() {
    const text = query.value.trim().toLowerCase();
    let count = 0;
    products.forEach(product => {
      const tags = (product.dataset.tags || '').split(' ').filter(Boolean);
      const haystack = `${product.dataset.name} ${product.dataset.style} ${product.textContent}`.toLowerCase();
      const matches = (category === 'all' || product.dataset.style === category)
        && (tag === 'none' || tags.includes(tag))
        && haystack.includes(text);
      product.hidden = !matches;
      if (matches) count++;
    });
    document.querySelectorAll('[data-collection]').forEach(section => {
      section.hidden = ![...section.querySelectorAll(SEARCHABLE)].some(item => !item.hidden);
    });
    if (resultCount) {
      resultCount.textContent = text || category !== 'all' || tag !== 'none'
        ? `Showing ${count} of ${totalProducts} products in this preview.`
        : '';
    }
    if (collectionCount) collectionCount.textContent = `${count} of ${totalProducts} products`;
    const empty = document.querySelector('#empty-results');
    if (empty) empty.hidden = count > 0;
    categoryFilters.forEach(filter => filter.setAttribute('aria-pressed', String(filter.dataset.category === category)));
    tagFilters.forEach(filter => filter.setAttribute('aria-pressed', String(filter.dataset.tag === tag)));
  }

  searchForm.addEventListener('submit', event => {
    event.preventDefault();
    updateResults();
    const firstResult = products.find(product => !product.hidden);
    (firstResult || document.querySelector('#fonts')).scrollIntoView({ block: 'start' });
  });
  query.addEventListener('input', updateResults);
  categoryFilters.forEach(filter => filter.addEventListener('click', () => {
    category = filter.dataset.category;
    updateResults();
  }));
  tagFilters.forEach(filter => filter.addEventListener('click', () => {
    tag = filter.dataset.tag;
    updateResults();
  }));
  const resetBtn = document.querySelector('#reset-search');
  if (resetBtn) resetBtn.addEventListener('click', () => {
    category = 'all';
    tag = 'none';
    query.value = '';
    history.replaceState(null, '', location.pathname);
    updateResults();
    query.focus();
  });
  if (category !== 'all' || tag !== 'none' || query.value) updateResults();
}
}
