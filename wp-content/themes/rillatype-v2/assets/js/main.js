/**
 * Rillatype v2 — Main Script
 */

document.addEventListener('DOMContentLoaded', function () {

  /* === Mobile Menu Toggle === */
  const toggle = document.querySelector('.menu-toggle');
  const navLinks = document.querySelector('.nav-links');

  if (toggle && navLinks) {
    toggle.addEventListener('click', function () {
      navLinks.classList.toggle('open');
      const expanded = navLinks.classList.contains('open');
      toggle.setAttribute('aria-expanded', expanded);
    });
  }

  /* === Intersection Observer for Fade-in Animations === */
  const fadeElements = document.querySelectorAll('.fade-in');

  if (fadeElements.length > 0 && 'IntersectionObserver' in window) {
    const observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          observer.unobserve(entry.target);
        }
      });
    }, {
      threshold: 0.15,
      rootMargin: '0px 0px -40px 0px'
    });

    fadeElements.forEach(function (el) {
      observer.observe(el);
    });
  } else {
    fadeElements.forEach(function (el) {
      el.classList.add('visible');
    });
  }

  /* === Smooth Scroll for Anchor Links === */
  document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
    anchor.addEventListener('click', function (e) {
      const href = anchor.getAttribute('href');
      if (href === '#') return;
      const target = document.querySelector(href);
      if (target) {
        e.preventDefault();
        target.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }
    });
  });

  /* === Sticky Header Scroll Effect === */
  const header = document.querySelector('.site-header');
  if (header) {
    const headerObs = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        header.classList.toggle('scrolled', !entry.isIntersecting);
      });
    }, { threshold: 0, rootMargin: '-1px 0px 0px 0px' });
    headerObs.observe(document.body);
  }
  
  /* === Staggered Card Entrance (Shop) === */
  const animCards = document.querySelectorAll('.anim-card');
  if (animCards.length > 0 && 'IntersectionObserver' in window) {
    const cardObs = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry, i) {
        if (entry.isIntersecting) {
          var idx = Array.from(entry.target.parentNode.children).indexOf(entry.target);
          entry.target.style.transitionDelay = (idx * 60) + 'ms';
          entry.target.classList.add('is-visible');
          cardObs.unobserve(entry.target);
        }
      });
    }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });
    
    animCards.forEach(function (el) { cardObs.observe(el); });
  } else if (animCards.length > 0) {
    animCards.forEach(function (el) { el.classList.add('is-visible'); });
  }

  /* === Image Lazy Loading === */
  const lazyImages = document.querySelectorAll('img[loading="lazy"]');

  if ('loading' in HTMLImageElement.prototype) {
    lazyImages.forEach(function (img) {
      img.setAttribute('loading', 'lazy');
    });
  } else {
    const lazyObserver = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          const img = entry.target;
          const src = img.getAttribute('data-src');
          if (src) {
            img.src = src;
            img.removeAttribute('data-src');
          }
          lazyObserver.unobserve(img);
        }
      });
    });

    lazyImages.forEach(function (img) {
      var src = img.getAttribute('src');
      if (src) {
        img.setAttribute('data-src', src);
        img.removeAttribute('src');
      }
      lazyObserver.observe(img);
    });
  }

});
