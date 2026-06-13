document.addEventListener('DOMContentLoaded', function() {
  // Search overlay (desktop)
  var desktopToggle = document.querySelector('.search-toggle');
  var overlay = document.getElementById('search-overlay');
  var input = document.getElementById('search-input');
  var close = document.querySelector('.search-overlay__close');

  if (overlay && input) {
    function openSearch(e) {
      if (e) e.preventDefault();
      overlay.classList.add('is-open');
      input.focus();
    }

    function closeSearch() {
      overlay.classList.remove('is-open');
    }

    if (desktopToggle) {
      desktopToggle.addEventListener('click', openSearch);
    }

    if (close) {
      close.addEventListener('click', closeSearch);
    }

    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape' && overlay.classList.contains('is-open')) {
        closeSearch();
        if (desktopToggle) desktopToggle.focus();
      }
    });

    overlay.addEventListener('click', function(e) {
      if (e.target === overlay) {
        closeSearch();
      }
    });
  }

  // Mobile menu toggle
  var menuToggle = document.querySelector('.menu-toggle');
  var navMain = document.querySelector('.nav-main');

  if (!menuToggle || !navMain) return;

  function toggleSubMenu(link) {
    var li = link.closest('.menu-item-has-children');
    if (!li) return;
    var sub = li.querySelector('.sub-menu');
    if (!sub) return;
    if (sub.classList.contains('is-open')) {
      sub.classList.remove('is-open');
    } else {
      sub.classList.add('is-open');
    }
  }

  function setParentHrefs(disable) {
    if (window.innerWidth > 899) return;
    navMain.querySelectorAll('.menu-item-has-children > a').forEach(function(link) {
      if (disable) {
        link.dataset.originalHref = link.href;
        link.setAttribute('href', 'javascript:void(0)');
      } else if (link.dataset.originalHref) {
        link.href = link.dataset.originalHref;
      }
    });
  }

  menuToggle.addEventListener('click', function() {
    var isOpen = navMain.classList.toggle('nav--open');
    menuToggle.classList.toggle('active');
    menuToggle.setAttribute('aria-expanded', isOpen);
    document.body.style.overflow = isOpen ? 'hidden' : '';
    setParentHrefs(isOpen);
  });

  navMain.addEventListener('click', function(e) {
    var link = e.target.closest('a');
    if (!link) return;
    if (window.innerWidth > 899) return;

    var li = link.closest('.menu-item-has-children');
    if (!li) {
      // Non-menu item: navigate and close
      navMain.classList.remove('nav--open');
      menuToggle.classList.remove('active');
      menuToggle.setAttribute('aria-expanded', 'false');
      document.body.style.overflow = '';
      setParentHrefs(false);
      return;
    }

    var sub = li.querySelector('.sub-menu');
    if (!sub) return;

    if (link.closest('.sub-menu')) {
      // Sub-menu link: let navigation happen, close menu
      navMain.classList.remove('nav--open');
      menuToggle.classList.remove('active');
      menuToggle.setAttribute('aria-expanded', 'false');
      document.body.style.overflow = '';
      setParentHrefs(false);
      return;
    }

    // Parent link: toggle sub-menu
    e.preventDefault();
    toggleSubMenu(link);
  });
});
