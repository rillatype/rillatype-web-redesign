(function () {
  'use strict';

  /* ── Image Slider ── */
  var track = document.getElementById('slider-track');
  var prevBtn = document.getElementById('slider-prev');
  var nextBtn = document.getElementById('slider-next');
  var dotsContainer = document.getElementById('slider-dots');
  var slideIndex = 0;
  var totalSlides = 0;

  function initSlider() {
    if (!track) return;
    var slides = track.querySelectorAll('img');
    totalSlides = slides.length;
    if (totalSlides < 2) return;

    // Create dots
    if (dotsContainer) {
      dotsContainer.innerHTML = '';
      for (var i = 0; i < totalSlides; i++) {
        var dot = document.createElement('button');
        dot.setAttribute('aria-label', 'Go to slide ' + (i + 1));
        if (i === 0) dot.classList.add('active');
        dot.addEventListener('click', function (idx) {
          return function () { goToSlide(idx); };
        }(i));
        dotsContainer.appendChild(dot);
      }
    }

    // Attach events
    if (prevBtn) prevBtn.addEventListener('click', prevSlide);
    if (nextBtn) nextBtn.addEventListener('click', nextSlide);

    // Keyboard
    document.addEventListener('keydown', function (e) {
      if (e.key === 'ArrowLeft') prevSlide();
      if (e.key === 'ArrowRight') nextSlide();
    });
  }

  function goToSlide(idx) {
    if (!track) return;
    slideIndex = idx;
    track.style.transform = 'translateX(-' + (idx * 100) + '%)';
    // Update dots
    if (dotsContainer) {
      var dots = dotsContainer.querySelectorAll('button');
      dots.forEach(function (d, i) { d.classList.toggle('active', i === idx); });
    }
    // Update buttons
    if (prevBtn) prevBtn.disabled = idx === 0;
    if (nextBtn) nextBtn.disabled = idx === totalSlides - 1;

    // Click to open lightbox
    track.querySelectorAll('img').forEach(function (img, i) {
      img.style.cursor = 'pointer';
      img.onclick = function () { openLightbox(idx); };
    });
  }

  function prevSlide() { if (slideIndex > 0) goToSlide(slideIndex - 1); }
  function nextSlide() { if (slideIndex < totalSlides - 1) goToSlide(slideIndex + 1); }

  /* ── Lightbox ── */
  var lb = document.getElementById('lightbox');
  var lbImg = document.getElementById('lb-img');
  var lbClose = document.getElementById('lb-close');
  var lbPrev = document.getElementById('lb-prev');
  var lbNext = document.getElementById('lb-next');
  var lbCounter = document.getElementById('lb-counter');
  var lbIndex = 0;
  var lbImages = [];

  function openLightbox(idx) {
    if (!lb || !track) return;
    var imgs = track.querySelectorAll('img');
    lbImages = [];
    imgs.forEach(function (img) { lbImages.push(img.src); });
    if (lbImages.length < 1) return;
    lbIndex = idx;
    updateLightbox();
    lb.classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  function updateLightbox() {
    if (!lbImg || !lbCounter) return;
    lbImg.src = lbImages[lbIndex];
    lbCounter.textContent = (lbIndex + 1) + ' / ' + lbImages.length;
    if (lbPrev) lbPrev.style.display = lbIndex > 0 ? 'flex' : 'none';
    if (lbNext) lbNext.style.display = lbIndex < lbImages.length - 1 ? 'flex' : 'none';
  }

  function closeLightbox() {
    if (!lb) return;
    lb.classList.remove('open');
    document.body.style.overflow = '';
  }

  function lbPrevFn() { if (lbIndex > 0) { lbIndex--; updateLightbox(); } }
  function lbNextFn() { if (lbIndex < lbImages.length - 1) { lbIndex++; updateLightbox(); } }

  if (lbClose) lbClose.addEventListener('click', closeLightbox);
  if (lbPrev) lbPrev.addEventListener('click', lbPrevFn);
  if (lbNext) lbNext.addEventListener('click', lbNextFn);
  if (lb) {
    lb.addEventListener('click', function (e) {
      if (e.target === lb) closeLightbox();
    });
    document.addEventListener('keydown', function (e) {
      if (!lb.classList.contains('open')) return;
      if (e.key === 'Escape') closeLightbox();
      if (e.key === 'ArrowLeft') lbPrevFn();
      if (e.key === 'ArrowRight') lbNextFn();
    });
  }

  /* ── License Tier Selection ── */
  var licenseTiers = document.querySelectorAll('.license-tier');
  var addToCartBtn = document.getElementById('add-to-cart-btn');

  licenseTiers.forEach(function (tier) {
    tier.addEventListener('click', function () {
      licenseTiers.forEach(function (t) { t.classList.remove('selected'); });
      tier.classList.add('selected');
      var radio = tier.querySelector('input[type="radio"]');
      if (radio) radio.checked = true;
      // Update button price
      var price = tier.getAttribute('data-price');
      if (addToCartBtn && price) {
        addToCartBtn.textContent = 'Add to Cart — $' + parseFloat(price).toFixed(2);
      }
    });
  });

  /* ── Font Tester ── */
  var tester = document.querySelector('.tester');
  var display = document.getElementById('tester-display');
  var fontSelect = document.getElementById('tester-font');
  var sizeSlider = document.getElementById('tester-size');
  var sizeOutput = document.getElementById('tester-size-value');
  var leadingSlider = document.getElementById('tester-leading');
  var leadingOutput = document.getElementById('tester-leading-value');
  var trackingSlider = document.getElementById('tester-tracking');
  var trackingOutput = document.getElementById('tester-tracking-value');

  if (tester && display) {
    var fonts = [];
    try { fonts = JSON.parse(tester.getAttribute('data-fonts') || '[]'); } catch (e) {}

    if (fonts.length > 0) {
      tester.setAttribute('data-font-loaded', 'loading');

      var loadedCount = 0;
      var total = fonts.length;

      for (var i = 0; i < total; i++) {
        (function (fontData) {
          fetch(fontData.url)
            .then(function (r) { return r.arrayBuffer(); })
            .then(function (buf) {
              var font = new FontFace(fontData.family, buf);
              return font.load();
            })
            .then(function (loaded) {
              document.fonts.add(loaded);
              loadedCount++;
              if (loadedCount === 1) {
                display.style.fontFamily = 'serif';
                display.offsetHeight;
                display.style.fontFamily = fontData.family;
              }
              if (loadedCount === total) {
                tester.setAttribute('data-font-loaded', 'loaded');
              }
            })
            .catch(function () {
              loadedCount++;
              if (loadedCount === total) {
                tester.setAttribute('data-font-loaded', 'failed');
              }
            });
        })(fonts[i]);
      }
    }
  }

  if (fontSelect && display) {
    fontSelect.addEventListener('change', function () {
      display.style.fontFamily = 'serif';
      display.offsetHeight;
      display.style.fontFamily = this.value;
    });
  }

  if (sizeSlider && display) {
    sizeSlider.addEventListener('input', function () {
      var v = this.value + 'px';
      display.style.fontSize = v;
      if (sizeOutput) sizeOutput.textContent = v;
    });
  }

  if (leadingSlider && display) {
    leadingSlider.addEventListener('input', function () {
      var v = (parseInt(this.value, 10) / 100).toFixed(1);
      display.style.lineHeight = v;
      if (leadingOutput) leadingOutput.textContent = v;
    });
  }

  if (trackingSlider && display) {
    trackingSlider.addEventListener('input', function () {
      var v = parseFloat(this.value) / 100;
      display.style.letterSpacing = v + 'em';
      if (trackingOutput) trackingOutput.textContent = v.toFixed(2);
    });
  }

  /* Alignment */
  var alignBtns = document.querySelectorAll('.tester__align button');
  alignBtns.forEach(function (btn) {
    btn.addEventListener('click', function () {
      alignBtns.forEach(function (b) { b.classList.remove('active'); b.setAttribute('aria-checked', 'false'); });
      btn.classList.add('active');
      btn.setAttribute('aria-checked', 'true');
      if (display) display.style.textAlign = btn.getAttribute('data-align');
    });
  });

  /* Background */
  var bgBtns = document.querySelectorAll('.tester__bgs button');
  bgBtns.forEach(function (btn) {
    btn.addEventListener('click', function () {
      bgBtns.forEach(function (b) { b.classList.remove('active'); b.setAttribute('aria-checked', 'false'); });
      btn.classList.add('active');
      btn.setAttribute('aria-checked', 'true');
      if (display) {
        display.style.background = btn.getAttribute('data-bg');
        display.style.color = btn.getAttribute('data-text');
      }
    });
  });

  /* Presets */
  var presetBtns = document.querySelectorAll('.tester__presets button');
  presetBtns.forEach(function (btn) {
    btn.addEventListener('click', function () {
      if (!display) return;
      var presets;
      try { presets = JSON.parse(btn.getAttribute('data-presets')); } catch (e) { return; }
      if (presets && presets.length > 0) {
        display.textContent = presets[Math.floor(Math.random() * presets.length)];
      }
    });
  });

  /* ── Sticky Bar ── */
  var stickyBar = document.getElementById('sticky-bar');
  var addBtn = document.getElementById('add-to-cart-btn');
  if (stickyBar && addBtn) {
    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        stickyBar.classList.toggle('visible', !entry.isIntersecting);
      });
    }, { threshold: 0 });
    observer.observe(addBtn);
  }

  /* ── Init ── */
  goToSlide(0);
  initSlider();
})();
