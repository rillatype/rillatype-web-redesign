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

  // Produk tanpa style bernama yang terverifikasi tidak pernah menampilkan selector kosong.
  const hasStyles = styles.length > 1 && styles.some(style => style.label);
  const defaultIndex = Math.max(0, styles.findIndex(style => style.label === product.defaultStyle));

  function currentStyle() {
    if (!hasStyles) return styles[defaultIndex] || styles[0];
    return styles[Number(styleSelect.value)] || styles[0];
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
    // Weight hanya ditulis bila berkasnya benar-benar memilikinya, supaya tidak
    // ada bold sintetis untuk style yang belum terverifikasi.
    if (style && typeof style.weight === 'number') output.style.fontWeight = String(style.weight);
    else output.style.removeProperty('font-weight');
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
        // Direktori berkas berasal dari data style, bukan ditebak dari satu lokasi bersama.
        const dir = style.dir || window.RillaTester.FONT_DIR;
        const source = new URL(`${dir}${style.file}`, location.href).href;
        const face = new FontFace(familyName, `url("${source}") format("opentype")`, { weight: String(style.weight) });
        await face.load();
        document.fonts.add(face);
        return { index, face };
      }));
      faces.filter(Boolean).forEach(entry => fontFamilies.set(entry.index, entry.face));
      output.style.fontFamily = `"${familyName}", sans-serif`;
      testerFrame.hidden = false;
      fontStatus.textContent = `Showing the actual ${product.name} font, ${styles.length} style${styles.length > 1 ? 's' : ''} available.`;

      // Deteksi OpenType dan daftar glyph membaca berkas yang sama dengan yang dimuat
      // tester, memakai direktori dari data style.
      const probe = styles.find(s => s.file);
      const probeUrl = probe ? new URL(`${probe.dir || window.RillaTester.FONT_DIR}${probe.file}`, location.href).href : null;
      let features = null;
      if (probeUrl) {
        features = await window.RillaTester.readOtFeatures(probeUrl);
      }
      const hasLiga = Boolean(features && (features.has('liga') || features.has('clig')));
      const hasSalt = Boolean(features && features.has('salt'));
      configureFeature(ligaInput, ligaSwitch, hasLiga, 'Ligatures');
      configureFeature(saltInput, saltSwitch, hasSalt, 'Stylistic alternates');

      // Panel glyph.
      if (probeUrl) {
        const codepoints = await window.RillaTester.readGlyphCodepoints(probeUrl);
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

  // Selector style hanya dibangun bila memang ada lebih dari satu style bernama.
  // Satu style tidak menghasilkan dropdown berisi satu opsi yang tidak berguna.
  if (hasStyles) {
    styles.forEach((style, index) => {
      const option = document.createElement('option');
      option.value = String(index);
      option.textContent = style.label;
      styleSelect.appendChild(option);
    });
    styleSelect.value = String(defaultIndex);
    styleField.hidden = false;
  } else {
    styleSelect.hidden = true;
    styleField.hidden = true;
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
    // Data already carries the full path; this function never builds one from a default.
    image.src = product.images[index];
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
      thumbnail.src = file;
      thumbnail.alt = '';
      thumbnail.width = 1200;
      thumbnail.height = 800;
      button.appendChild(thumbnail);
      button.addEventListener('click', () => showImage(index));
      thumbnails.appendChild(button);
    });
  }
  // Produk yang gambarnya belum dipetakan tidak boleh meminta berkas kosong;
  // biarkan elemen tersembunyi dan sebutkan keadaannya di bawah.
  if (product.images.length) {
    showImage(0);
    document.querySelector('#gallery-status').hidden = true;
  } else {
    image.hidden = true;
    const galleryStatus = document.querySelector('#gallery-status');
    galleryStatus.hidden = false;
    galleryStatus.textContent = `Product images for ${product.name} are not mapped in this preview yet.`;
  }

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
