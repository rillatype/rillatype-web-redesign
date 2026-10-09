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
  const categoryFilters = [...document.querySelectorAll('.filter[data-category]')];
  const tagFilters = [...document.querySelectorAll('.filter[data-tag]')];
  const products = [...document.querySelectorAll('.product[data-name]')];
  const resultCount = document.querySelector('#result-count');
  let category = 'all';
  let tag = 'none';
  const params = new URLSearchParams(location.search);
  if (params.get('tag')) tag = params.get('tag');
  if (params.get('q')) query.value = params.get('q');
  function updateResults() {
    const text = query.value.trim().toLowerCase();
    let count = 0;
    products.forEach(product => {
      const description = product.querySelector('.lead-description')?.textContent || '';
      const tags = (product.dataset.tags || '').split(' ').filter(Boolean);
      const matches = (category === 'all' || product.dataset.style === category)
        && (tag === 'none' || tags.includes(tag))
        && `${product.dataset.name} ${product.dataset.style} ${product.querySelector('.product-info p').textContent} ${description}`.toLowerCase().includes(text);
      product.hidden = !matches;
      if (matches) count++;
    });
    document.querySelectorAll('[data-collection]').forEach(section => {
      section.hidden = ![...section.querySelectorAll('.product')].some(product => !product.hidden);
    });
    resultCount.textContent = `${count} ${count === 1 ? 'item' : 'items'} in this preview`;
    document.querySelector('#empty-results').hidden = count > 0;
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
  function resetResults() {
    category = 'all';
    tag = 'none';
    query.value = '';
    history.replaceState(null, '', location.pathname);
    updateResults();
  }
  const resetBtn = document.querySelector('#reset-search');
  if (resetBtn) resetBtn.addEventListener('click', () => {
    resetResults();
    query.focus();
  });
  if (tag !== 'none') updateResults();
}
