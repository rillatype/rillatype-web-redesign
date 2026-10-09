const catalog = new Map([
  ['bawden', { name: 'Bawden', style: 'Slab serif display', price: 24, images: ['bawden-1.jpg'] }],
  ['mango', { name: 'Mango Letters', style: 'Handwritten display', price: 18, images: ['mango-1.jpg', 'mango-2.jpg', 'mango-3.jpg', 'mango-4.jpg'], specimen: true }],
  ['baldock', { name: 'Baldock', style: 'Retro display', price: 24, images: ['baldock-1.jpg'] }],
  ['daisy', { name: 'Daisy Hotline', style: 'Display', price: 20, images: ['daisy-hotline-1.jpg'] }],
  ['crimson', { name: 'Crimson Queen', style: 'Serif display', price: 22, images: ['crimson-queen-1.jpg'] }],
  ['mordial', { name: 'Mordial', style: 'Modern serif', price: 24, images: ['mordial-1.jpg'] }],
  ['moyshire', { name: 'Moyshire', style: 'Vintage script', price: 20, images: ['moyshire-1.jpg'] }],
  ['radiant', { name: 'Radiant Summertime', style: 'Handwritten script', price: 20, images: ['radiant-summertime-1.jpg'] }],
]);
const slug = new URLSearchParams(location.search).get('font') || 'bawden';
const product = catalog.get(slug);
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
    ? 'This design preview includes one OTF specimen for Mango Letters. It is not a list of purchased files.'
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

  const fontStatus = document.querySelector('#font-status');
  const controls = document.querySelector('#tester-controls');
  const output = document.querySelector('#sample-output');
  const retry = document.querySelector('#retry-font');
  if (!product.specimen) {
    fontStatus.textContent = 'A specimen file is not included for this font in the design preview. You can still explore its product image.';
  } else {
    const text = document.querySelector('#sample-text');
    const size = document.querySelector('#sample-size');
    function updateSample() {
      output.textContent = text.value || 'Type something to preview this font.';
      output.style.fontSize = `${size.value}px`;
      document.querySelector('#size-value').textContent = `${size.value} px`;
    }
    text.addEventListener('input', updateSample);
    size.addEventListener('input', updateSample);
    async function loadSpecimen() {
      retry.hidden = true;
      fontStatus.textContent = 'Loading the product specimen…';
      try {
        const source = new URL('../previews/mango-letter.otf', location.href).href;
        const face = new FontFace('Mango Product', `url("${source}") format("opentype")`);
        await face.load();
        document.fonts.add(face);
        controls.hidden = false;
        output.hidden = false;
        fontStatus.textContent = 'Showing the actual Mango Letters font.';
        updateSample();
      } catch {
        controls.hidden = true;
        output.hidden = true;
        fontStatus.textContent = 'The font specimen could not load. You can still view the product images.';
        retry.hidden = false;
      }
    }
    retry.addEventListener('click', loadSpecimen);
    loadSpecimen();
  }
}
