// Logika halaman detail produk dan font tester.
// Katalog berada di font-catalog.js. Parser OpenType berada di tester-core.js.

const slug = new URLSearchParams(location.search).get('font') || 'bawden';
const product = catalog.get(slug);

function setupTester(product) {
  const testerFrame = document.querySelector('#tester-frame');
  const fontStatus = document.querySelector('#font-status');
  const retry = document.querySelector('#retry-font');
  const stage = document.querySelector('#tester-stage');
  const output = document.querySelector('#sample-output');
  const text = document.querySelector('#sample-text');
  const size = document.querySelector('#sample-size');
  const leading = document.querySelector('#sample-leading');
  const tracking = document.querySelector('#sample-tracking');
  const styleField = document.querySelector('#style-field');
  const styleSelect = document.querySelector('#sample-style');
  const glyphGrid = document.querySelector('#glyph-grid');
  const glyphCount = document.querySelector('#glyph-count');
  const ligaSwitch = document.querySelector('#liga-switch');
  const saltSwitch = document.querySelector('#salt-switch');
  const ligaInput = document.querySelector('#opentype-liga');
  const saltInput = document.querySelector('#opentype-salt');

  if (!product.specimen) {
    fontStatus.textContent = 'No specimen file is available for this font yet. You can still review the product images above.';
    return;
  }

  const styles = product.styles || [{ label: 'Regular', file: null, weight: 400 }];
  let fontFamilies = new Map();

  function currentStyle() {
    return styles[Number(styleSelect.value) || 0];
  }

  function applySample() {
    output.textContent = text.value || 'Type something to preview this font.';
    output.style.fontSize = `${size.value}px`;
    output.style.lineHeight = String(Number(leading.value) / 100);
    output.style.letterSpacing = `${Number(tracking.value) / 100}em`;
    document.querySelector('#size-value').textContent = `${size.value} px`;
    document.querySelector('#leading-value').textContent = (Number(leading.value) / 100).toFixed(2);
    document.querySelector('#tracking-value').textContent = `${(Number(tracking.value) / 100).toFixed(2)} em`;
    const style = currentStyle();
    output.style.fontWeight = style.weight;
  }

  // Sakelar OpenType hanya aktif jika fitur benar-benar ada pada berkas font.
  function configureFeature(input, switchEl, supported, label) {
    input.disabled = !supported;
    input.checked = false;
    switchEl.classList.toggle('is-unavailable', !supported);
    switchEl.title = supported
      ? `${label} is available in this font.`
      : `${label} is not included in ${product.name}. The control is shown but disabled.`;
    const note = switchEl.querySelector('.switch-note');
    if (!supported) {
      if (!note) {
        const span = document.createElement('small');
        span.className = 'switch-note';
        span.textContent = `Not in ${product.name}`;
        switchEl.appendChild(span);
      }
    } else if (note) {
      note.remove();
    }
  }

  function applyFeatures() {
    const parts = [];
    if (ligaInput.checked && !ligaInput.disabled) parts.push('"liga" 1', '"clig" 1');
    else parts.push('"liga" 0', '"clig" 0');
    if (saltInput.checked && !saltInput.disabled) parts.push('"salt" 1');
    else parts.push('"salt" 0');
    output.style.fontFeatureSettings = parts.join(', ');
  }

  async function loadStyles() {
    retry.hidden = true;
    fontStatus.textContent = 'Loading the product specimen…';
    fontFamilies = new Map();
    const familyName = `Rilla-${product.name.replace(/\s+/g, '')}`;
    try {
      const faces = await Promise.all(styles.map(async (style, index) => {
        if (!style.file) return null;
        const source = new URL(`${window.RillaTester.FONT_DIR}${style.file}`, location.href).href;
        const face = new FontFace(familyName, `url("${source}") format("opentype")`, { weight: String(style.weight) });
        await face.load();
        document.fonts.add(face);
        return { index, face };
      }));
      faces.filter(Boolean).forEach(entry => fontFamilies.set(entry.index, entry.face));
      output.style.fontFamily = `"${familyName}", sans-serif`;
      testerFrame.hidden = false;
      fontStatus.textContent = `Showing the actual ${product.name} font, ${styles.length} style${styles.length > 1 ? 's' : ''} available.`;

      // Deteksi OpenType dari berkas style pertama yang punya file.
      const probe = styles.find(s => s.file);
      let features = null;
      if (probe) {
        const url = new URL(`${window.RillaTester.FONT_DIR}${probe.file}`, location.href).href;
        features = await window.RillaTester.readOtFeatures(url);
      }
      const hasLiga = Boolean(features && (features.has('liga') || features.has('clig')));
      const hasSalt = Boolean(features && features.has('salt'));
      configureFeature(ligaInput, ligaSwitch, hasLiga, 'Ligatures');
      configureFeature(saltInput, saltSwitch, hasSalt, 'Stylistic alternates');

      // Panel glyph.
      if (probe) {
        const url = new URL(`${window.RillaTester.FONT_DIR}${probe.file}`, location.href).href;
        const codepoints = await window.RillaTester.readGlyphCodepoints(url);
        if (codepoints.length) {
          const fragment = document.createDocumentFragment();
          codepoints.forEach(cp => {
            const cell = document.createElement('span');
            cell.className = 'glyph-cell';
            cell.textContent = String.fromCodePoint(cp);
            cell.title = `U+${cp.toString(16).toUpperCase().padStart(4, '0')}`;
            fragment.appendChild(cell);
          });
          glyphGrid.appendChild(fragment);
          glyphCount.textContent = `${codepoints.length} characters`;
        } else {
          glyphCount.textContent = 'Character list unavailable';
        }
      }
      applySample();
      applyFeatures();
    } catch {
      testerFrame.hidden = true;
      fontStatus.textContent = 'The font specimen could not load. You can still view the product images.';
      retry.hidden = false;
    }
  }

  // Isi dropdown style.
  styles.forEach((style, index) => {
    const option = document.createElement('option');
    option.value = String(index);
    option.textContent = style.label;
    styleSelect.appendChild(option);
  });
  if (styles.length > 1) {
    styleField.hidden = false;
  }

  text.addEventListener('input', applySample);
  size.addEventListener('input', applySample);
  leading.addEventListener('input', applySample);
  tracking.addEventListener('input', applySample);
  styleSelect.addEventListener('change', applySample);
  ligaInput.addEventListener('change', applyFeatures);
  saltInput.addEventListener('change', applyFeatures);
  document.querySelectorAll('input[name="align"]').forEach(radio => {
    radio.addEventListener('change', () => {
      if (radio.checked) output.dataset.align = radio.value;
    });
  });
  document.querySelectorAll('input[name="theme"]').forEach(radio => {
    radio.addEventListener('change', () => {
      if (radio.checked) stage.dataset.theme = radio.value;
    });
  });

  retry.addEventListener('click', loadStyles);
  loadStyles();
}

if (!product) {
  document.querySelector('#not-found').hidden = false;
  document.querySelector('#nav-license').href = 'index.html#licenses';
  document.querySelector('#nav-license').textContent = 'Licenses';
  document.title = 'Font not found | Rillatype';
} else {
  document.querySelector('#product-content').hidden = false;
  document.title = `${product.name} | Rillatype`;
  document.querySelector('#product-title').textContent = product.name;
  document.querySelector('#breadcrumb-name').textContent = product.name;
  document.querySelector('#product-style').textContent = product.style;
  document.querySelector('#specimen-information').textContent = product.specimen
    ? `This design preview includes ${product.styles ? product.styles.length + ' style files' : 'one specimen file'} for ${product.name}. It is not a list of purchased files.`
    : 'Product images are available in this design preview. A specimen file is not included for this font.';
  const money = value => `Demo $${value}`;
  const price = document.querySelector('#product-price');
  price.textContent = money(product.price);
  document.querySelector('#standard-price').textContent = money(product.price);
  document.querySelector('#extended-price').textContent = money(product.price * 2);

  const image = document.querySelector('#detail-image');
  const thumbnails = document.querySelector('#preview-thumbnails');
  function showImage(index) {
    image.src = `../previews/${product.images[index]}`;
    image.alt = `${product.name} preview ${index + 1}`;
    image.hidden = false;
    [...thumbnails.children].forEach((button, i) => button.setAttribute('aria-pressed', String(i === index)));
  }
  if (product.images.length > 1) {
    product.images.forEach((file, index) => {
      const button = document.createElement('button');
      button.type = 'button';
      button.className = 'thumbnail';
      button.setAttribute('aria-label', `Preview ${index + 1}`);
      const thumbnail = document.createElement('img');
      thumbnail.src = `../previews/${file}`;
      thumbnail.alt = '';
      thumbnail.width = 1200;
      thumbnail.height = 800;
      button.appendChild(thumbnail);
      button.addEventListener('click', () => showImage(index));
      thumbnails.appendChild(button);
    });
  }
  showImage(0);

  const form = document.querySelector('#license-form');
  const selectionButton = document.querySelector('#preview-selection');
  const selectionStatus = document.querySelector('#selection-status');
  form.addEventListener('change', () => {
    const license = form.elements.license.value;
    selectionButton.disabled = !['standard', 'extended'].includes(license);
    price.textContent = money(license === 'extended' ? product.price * 2 : product.price);
    selectionStatus.textContent = '';
  });
  form.addEventListener('submit', event => {
    event.preventDefault();
    const license = form.elements.license.value;
    if (!['standard', 'extended'].includes(license)) return;
    const name = license === 'extended' ? 'Extended License' : 'Standard License';
    selectionStatus.textContent = `${product.name} · ${name} selected. Design demo only; no order or payment.`;
  });

  setupTester(product);
}
