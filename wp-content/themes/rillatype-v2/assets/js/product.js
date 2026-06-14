(function(){
  'use strict';

  /* ── Font Playground ───────────────────────── */
  var display = document.getElementById('tester-display');
  if (display) {
    var sizeSlider = document.getElementById('tester-size');
    var sizeVal   = document.getElementById('tester-size-value');
    var leadSlider = document.getElementById('tester-leading');
    var leadVal   = document.getElementById('tester-leading-value');
    var trackSlider = document.getElementById('tester-tracking');
    var trackVal   = document.getElementById('tester-tracking-value');
    var defText    = display.textContent.trim();

    // Size
    if (sizeSlider) {
      sizeSlider.addEventListener('input', function(){
        display.style.fontSize = this.value + 'px';
        sizeVal.textContent = this.value + 'px';
      });
    }

    // Leading
    if (leadSlider) {
      leadSlider.addEventListener('input', function(){
        var v = this.value / 100;
        display.style.lineHeight = v;
        leadVal.textContent = v.toFixed(1);
      });
    }

    // Tracking
    if (trackSlider) {
      trackSlider.addEventListener('input', function(){
        var v = this.value / 100;
        display.style.letterSpacing = v + 'em';
        trackVal.textContent = (v * 100).toFixed(0);
      });
    }

    // Alignment
    document.querySelectorAll('.tester__align button').forEach(function(b){
      b.addEventListener('click', function(){
        document.querySelectorAll('.tester__align button').forEach(function(x){
          x.classList.remove('active'); x.setAttribute('aria-checked', 'false');
        });
        this.classList.add('active'); this.setAttribute('aria-checked', 'true');
        display.style.textAlign = this.dataset.align;
      });
    });

    // Font select
    var fontSelect = document.getElementById('tester-font');
    if (fontSelect) {
      fontSelect.addEventListener('change', function(){
        display.style.fontFamily = "'" + this.value + "', Georgia, serif";
      });
    }

    // Background swatches
    document.querySelectorAll('.tester__bgs button').forEach(function(b){
      b.addEventListener('click', function(){
        document.querySelectorAll('.tester__bgs button').forEach(function(x){
          x.classList.remove('active'); x.setAttribute('aria-checked', 'false');
        });
        this.classList.add('active'); this.setAttribute('aria-checked', 'true');
        display.style.background = this.dataset.bg;
        display.style.color = this.dataset.text;
      });
    });

    // Presets with cycling
    document.querySelectorAll('.tester__presets button').forEach(function(b){
      var presets = [];
      try { presets = JSON.parse(b.getAttribute('data-presets') || '[]'); } catch(e) {}
      var idx = 0;
      b.addEventListener('click', function(){
        var text = presets[idx];
        if (text) { display.textContent = text; display.focus(); }
        idx = (idx + 1) % presets.length;
      });
    });

    // Restore default on blur if empty
    display.addEventListener('blur', function(){
      if (!this.textContent.trim()) this.textContent = defText;
    });
  }

  /* ── Slider ────────────────────────────────── */
  var track = document.getElementById('slider-track');
  if (track) {
    var slides = track.querySelectorAll('img');
    var total  = slides.length;
    var idx    = 0;
    var dotsEl = document.getElementById('slider-dots');

    // Build dots
    if (dotsEl) {
      for (var i = 0; i < total; i++) {
        var dot = document.createElement('button');
        dot.setAttribute('aria-label', 'Go to preview ' + (i + 1));
        if (i === 0) dot.className = 'active';
        (function(n){ dot.addEventListener('click', function(){ goTo(n); }); })(i);
        dotsEl.appendChild(dot);
      }
    }

    function goTo(n) {
      idx = Math.max(0, Math.min(n, total - 1));
      if (track) track.style.transform = 'translateX(-' + (idx * 100) + '%)';

      if (dotsEl) {
        var dots = dotsEl.querySelectorAll('button');
        dots.forEach(function(d, i){ d.className = i === idx ? 'active' : ''; });
      }

      var prevBtn = document.getElementById('slider-prev');
      var nextBtn = document.getElementById('slider-next');
      if (prevBtn) prevBtn.disabled = idx === 0;
      if (nextBtn) nextBtn.disabled = idx === total - 1;
    }

    var prevBtn = document.getElementById('slider-prev');
    var nextBtn = document.getElementById('slider-next');
    if (prevBtn) prevBtn.addEventListener('click', function(){ goTo(idx - 1); });
    if (nextBtn) nextBtn.addEventListener('click', function(){ goTo(idx + 1); });

    // Keyboard
    var sliderWrap = document.getElementById('slider');
    if (sliderWrap) {
      sliderWrap.addEventListener('keydown', function(e){
        if (e.key === 'ArrowLeft') { goTo(idx - 1); e.preventDefault(); }
        if (e.key === 'ArrowRight') { goTo(idx + 1); e.preventDefault(); }
      });
      sliderWrap.setAttribute('tabindex', '0');
    }

    goTo(0);

    /* ── Lightbox ─────────────────────────────── */
    var lb      = document.getElementById('lightbox');
    var lbImg   = document.getElementById('lb-img');
    var lbCount = document.getElementById('lb-counter');
    var lbIdx   = 0;
    var srcMap  = [];

    slides.forEach(function(s){ srcMap.push(s.src); });

    // Click slide to open lightbox
    slides.forEach(function(img, i){
      img.style.cursor = 'pointer';
      img.addEventListener('click', function(){ openLightbox(i); });
    });

    function openLightbox(n) {
      if (!lb || !lbImg) return;
      lbIdx = n;
      lb.classList.add('open');
      updateLightboxImg();
      document.body.style.overflow = 'hidden';
    }

    function updateLightboxImg() {
      if (!lbImg || !lbCount || !srcMap[lbIdx]) return;
      lbImg.src = srcMap[lbIdx];
      lbCount.textContent = (lbIdx + 1) + ' / ' + total;
    }

    function closeLightbox() {
      if (!lb) return;
      lb.classList.remove('open');
      document.body.style.overflow = '';
    }

    var lbClose = document.getElementById('lb-close');
    var lbPrev  = document.getElementById('lb-prev');
    var lbNext  = document.getElementById('lb-next');

    if (lbClose) lbClose.addEventListener('click', closeLightbox);
    if (lbPrev) lbPrev.addEventListener('click', function(e){ e.stopPropagation(); lbIdx = Math.max(0, lbIdx - 1); updateLightboxImg(); });
    if (lbNext) lbNext.addEventListener('click', function(e){ e.stopPropagation(); lbIdx = Math.min(total - 1, lbIdx + 1); updateLightboxImg(); });

    if (lb) {
      lb.addEventListener('click', function(e){ if (e.target === lb) closeLightbox(); });

      document.addEventListener('keydown', function(e){
        if (!lb.classList.contains('open')) return;
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowLeft') { lbIdx = Math.max(0, lbIdx - 1); updateLightboxImg(); }
        if (e.key === 'ArrowRight') { lbIdx = Math.min(total - 1, lbIdx + 1); updateLightboxImg(); }
      });
    }
  }

  /* ── Header Scroll ─────────────────────────── */
  var header = document.querySelector('.site-header');
  if (header) {
    window.addEventListener('scroll', function(){
      header.style.borderBottomColor = scrollY > 10 ? '#e8e4e0' : 'transparent';
    }, {passive: true});
  }

  /* ── Glyph Toggle ──────────────────────────── */
  var glyphBtn = document.getElementById('glyph-toggle');
  if (glyphBtn) {
    var glyphGrid  = document.getElementById('glyph-grid');
    var glyphCtrl  = document.getElementById('glyph-controls');
    var glyphCount = document.getElementById('glyph-count');

    glyphBtn.addEventListener('click', function(){
      var open = this.getAttribute('aria-expanded') === 'true';
      this.setAttribute('aria-expanded', !open);
      if (glyphCtrl) glyphCtrl.style.display = open ? 'none' : 'block';
      if (glyphCount) glyphCount.style.display = open ? 'none' : 'block';
    });

    // Glyph size
    var gs = document.getElementById('glyph-size');
    var gv = document.getElementById('glyph-size-value');
    if (gs && gv && glyphGrid) {
      gs.addEventListener('input', function(){
        var fs = this.value + 'px';
        glyphGrid.style.setProperty('--glyph-size', fs);
        gv.textContent = fs;
      });
    }
  }

  /* ── Sticky Cart Bar ───────────────────────── */
  var stickyBar = document.getElementById('sticky-bar');
  var hero = document.querySelector('.product-hero');
  if (stickyBar && hero) {
    function checkScroll() {
      var heroBottom = hero.offsetTop + hero.offsetHeight;
      stickyBar.classList.toggle('visible', window.scrollY > heroBottom - 100);
    }
    window.addEventListener('scroll', checkScroll, {passive: true});
    checkScroll();
  }

})();
