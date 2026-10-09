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

const searchForm = document.querySelector('#font-search');
if (searchForm) {
  const query = document.querySelector('#query');
  const filters = [...document.querySelectorAll('[data-category]')];
  const products = [...document.querySelectorAll('.product[data-name]')];
  let category = 'all';
  function updateResults() {
    const text = query.value.trim().toLowerCase();
    let count = 0;
    products.forEach(product => {
      const matches = (category === 'all' || product.dataset.style === category)
        && `${product.dataset.name} ${product.dataset.style} ${product.querySelector('.product-info p').textContent}`.toLowerCase().includes(text);
      product.hidden = !matches;
      if (matches) count++;
    });
    document.querySelectorAll('[data-collection]').forEach(section => {
      section.hidden = ![...section.querySelectorAll('.product')].some(product => !product.hidden);
    });
    document.querySelector('#result-count').textContent = `${count} ${count === 1 ? 'font' : 'fonts'} in this preview`;
    document.querySelector('#empty-results').hidden = count > 0;
    filters.forEach(filter => filter.setAttribute('aria-pressed', String(filter.dataset.category === category)));
  }
  searchForm.addEventListener('submit', event => {
    event.preventDefault();
    updateResults();
    document.querySelector('#fonts').scrollIntoView({ block: 'start' });
  });
  query.addEventListener('input', updateResults);
  filters.forEach(filter => filter.addEventListener('click', () => {
    category = filter.dataset.category;
    updateResults();
  }));
  document.querySelector('#reset-search').addEventListener('click', () => {
    category = 'all';
    query.value = '';
    updateResults();
    query.focus();
  });
}
