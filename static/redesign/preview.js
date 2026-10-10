// Homepage behaviour: mobile menu, collection search, and the live specimen.
// The specimen font files are fetched only when a visitor asks for them, so the
// page renders without waiting on 265 KB of OTF.

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
// Real cuts, with the glyph and codepoint counts read from the shipped files.
const SPECIMENS = {
  chronoa: {
    label: 'Chronoa',
    family: 'Rilla-Chronoa',
    dir: 'fonts/web/',
    defaultWeight: 600,
    weights: {
      200: { file: 'chronoa-extralight.woff2', name: 'ExtraLight' },
      300: { file: 'chronoa-light.woff2', name: 'Light' },
      400: { file: 'chronoa-regular.woff2', name: 'Regular' },
      500: { file: 'chronoa-medium.woff2', name: 'Medium' },
      600: { file: 'chronoa-semibold.woff2', name: 'SemiBold' },
      800: { file: 'chronoa-extrabold.woff2', name: 'ExtraBold' },
      900: { file: 'chronoa-black.woff2', name: 'Black' }
    },
    glyphs: 219,
    codepoints: 218,
    features: 'no OpenType features'
  },
  mango: {
    label: 'Mango Letters',
    family: 'Rilla-Mango',
    dir: 'fonts/web/',
    defaultWeight: 400,
    weights: { 400: { file: 'mango-letters.woff2', name: 'Regular' } },
    glyphs: 184,
    codepoints: 181,
    features: 'discretionary ligatures'
  }
};

const specimenFrame = document.querySelector('#specimen-frame');
const specimenLine = document.querySelector('#specimen-line');
const specimenError = document.querySelector('#specimen-error');
const specimenStatus = document.querySelector('#specimen-status');
const specimenFacts = document.querySelector('#specimen-facts');
const cutPicker = document.querySelector('#cut-picker');
const weightPicker = document.querySelector('#weight-picker');
const loadedFaces = new Set();
const inFlight = new Map();
let activeCut = 'chronoa';
let activeWeight = SPECIMENS.chronoa.defaultWeight;
let userTyped = false;
let specimenRequest = 0;

function setFrameState(state) {
  if (specimenFrame) specimenFrame.dataset.state = state;
  if (specimenLine) specimenLine.hidden = state === 'error';
  if (specimenError) specimenError.hidden = state !== 'error';
}

// One loader for every cut, so the specimen band and the index can never
// fetch the same face twice.
async function registerFace(cutKey, weight) {
  const cut = SPECIMENS[cutKey];
  const style = cut.weights[weight];
  if (!style) return null;
  const key = `${cutKey}-${weight}`;
  if (loadedFaces.has(key)) return style;
  if (!inFlight.has(key)) {
    const source = new URL(`${cut.dir}${style.file}`, location.href).href;
    inFlight.set(key, (async () => {
      const face = new FontFace(cut.family, `url("${source}") format("woff2")`, { weight: String(weight) });
      await face.load();
      document.fonts.add(face);
      loadedFaces.add(key);
      return style;
    })());
  }
  try {
    return await inFlight.get(key);
  } catch (error) {
    return null;
  }
}

async function showSpecimen(cutKey, weight, fallbackText) {
  const request = ++specimenRequest;
  setFrameState('loading');
  const style = await registerFace(cutKey, weight);
  if (request !== specimenRequest) return;
  const cut = SPECIMENS[cutKey];
  if (!style) {
    setFrameState('error');
    if (specimenFacts) specimenFacts.textContent = '';
    if (specimenStatus) specimenStatus.textContent = `Could not load ${cut.label}. Check your connection, then select another cut to retry.`;
    return;
  }
  // The line belongs to the visitor: only seed it while they have not typed.
  if (!userTyped) specimenLine.textContent = fallbackText;
  specimenLine.style.fontFamily = `"${cut.family}", "Manrope", sans-serif`;
  specimenLine.style.fontWeight = String(weight);
  specimenLine.style.letterSpacing = cutKey === 'mango' ? '0' : '-.04em';
  setFrameState('ready');
  if (specimenFacts) specimenFacts.textContent = `${cut.label} ${style.name} · ${cut.glyphs} glyphs · ${cut.features}`;
  if (specimenStatus) specimenStatus.textContent = `Type your own words. Switch fonts and keep your text.`;
}

function buildWeightPicker(cutKey) {
  if (!weightPicker) return;
  const cut = SPECIMENS[cutKey];
  weightPicker.textContent = '';
  const weights = Object.keys(cut.weights).map(Number).sort((a, b) => a - b);
  weights.forEach(weight => {
    const label = document.createElement('label');
    const input = document.createElement('input');
    input.type = 'radio';
    input.name = 'specimen-weight';
    input.value = String(weight);
    input.checked = weight === cut.defaultWeight;
    const span = document.createElement('span');
    span.textContent = String(weight);
    label.append(input, span);
    weightPicker.append(label);
  });
  weightPicker.hidden = weights.length < 2;
}

function currentText() {
  const text = (specimenLine.textContent || '').trim();
  return text || 'Your brand name';
}

if (specimenLine) {
  buildWeightPicker(activeCut);
  let armed = false;
  const arm = () => {
    if (armed) return;
    armed = true;
    showSpecimen(activeCut, activeWeight, 'Chronoa');
  };
  // Load only when the specimen is near the viewport, so the first paint is free.
  if ('IntersectionObserver' in window) {
    const watcher = new IntersectionObserver(entries => {
      if (entries.some(entry => entry.isIntersecting)) {
        watcher.disconnect();
        arm();
      }
    }, { rootMargin: '200px' });
    watcher.observe(specimenLine);
  } else {
    arm();
  }
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
}

if (cutPicker) {
  cutPicker.addEventListener('change', event => {
    if (!event.target.matches('input[name="specimen-cut"]')) return;
    activeCut = event.target.value;
    activeWeight = SPECIMENS[activeCut].defaultWeight;
    buildWeightPicker(activeCut);
    showSpecimen(activeCut, activeWeight, SPECIMENS[activeCut].label);
  });
}
if (weightPicker) {
  weightPicker.addEventListener('change', event => {
    if (!event.target.matches('input[name="specimen-weight"]')) return;
    activeWeight = Number(event.target.value);
    showSpecimen(activeCut, activeWeight, currentText());
  });
}

// Strip cuts beyond the specimen band load as they scroll into view.
const stripCuts = [
  { id: '#strip-light', weight: 300 },
  { id: '#strip-medium', weight: 500 },
  { id: '#strip-semibold', weight: 600 }
];
const stripNodes = stripCuts.map(item => document.querySelector(item.id)).filter(Boolean);
if (stripNodes.length && 'IntersectionObserver' in window) {
  const stripWatcher = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;
      stripWatcher.unobserve(entry.target);
      const cut = stripCuts.find(item => item.id === `#${entry.target.id}`);
      registerFace('chronoa', cut.weight);
    });
  }, { rootMargin: '150px' });
  stripNodes.forEach(node => stripWatcher.observe(node));
}

// Warm the Mango face before the index row scrolls in, so its letterforms
// render on first paint instead of swapping in later. The @font-face for
// Mango lives in the stylesheet; this only asks for the file.
const mangoRowName = document.querySelector('.row[data-name="Mango Letters"] .row-name');
if (mangoRowName) {
  if ('IntersectionObserver' in window) {
    const rowWatcher = new IntersectionObserver(entries => {
      if (!entries.some(entry => entry.isIntersecting)) return;
      rowWatcher.disconnect();
      registerFace('mango', 400);
    }, { rootMargin: '400px' });
    rowWatcher.observe(mangoRowName);
  } else {
    registerFace('mango', 400);
  }
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
