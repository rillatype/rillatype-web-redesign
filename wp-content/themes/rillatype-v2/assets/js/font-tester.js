/**
 * Rillatype v2 — Font Tester
 * Interactive font preview using event delegation
 */

document.addEventListener('DOMContentLoaded', function () {

  const testerEl = document.querySelector('.font-tester');
  if (!testerEl) return;

  const preview = testerEl.querySelector('.font-tester-preview-box');
  const textInput = testerEl.querySelector('.font-tester-input');
  const slider = testerEl.querySelector('.font-tester-slider');
  const styleBtns = testerEl.querySelectorAll('.font-tester-style-btn');
  const presetBtns = testerEl.querySelectorAll('.font-tester-preset-btn');

  var currentWeight = 'normal';
  var currentStyle = 'normal';

  /* --- Update preview text --- */
  function updatePreviewText(value) {
    if (preview) {
      preview.textContent = value || 'Type your text here...';
    }
  }

  /* --- Update preview size --- */
  function updatePreviewSize(value) {
    if (preview) {
      preview.style.fontSize = value + 'px';
    }
  }

  /* --- Update preview style --- */
  function updatePreviewStyle() {
    if (preview) {
      preview.style.fontWeight = currentWeight;
      preview.style.fontStyle = currentStyle;
    }
  }

  /* --- Handle text input --- */
  if (textInput) {
    textInput.addEventListener('input', function () {
      updatePreviewText(this.value);
    });
  }

  /* --- Handle range slider --- */
  if (slider) {
    slider.addEventListener('input', function () {
      updatePreviewSize(this.value);
    });
  }

  /* --- Handle style button clicks (event delegation) --- */
  testerEl.addEventListener('click', function (e) {
    var btn = e.target.closest('.font-tester-style-btn');
    if (btn) {
      var weight = btn.getAttribute('data-weight');
      var style = btn.getAttribute('data-style');

      styleBtns.forEach(function (b) {
        b.classList.remove('is-active');
      });
      btn.classList.add('is-active');

      if (weight) currentWeight = weight;
      if (style) currentStyle = style;
      updatePreviewStyle();
      return;
    }

    var presetBtn = e.target.closest('.font-tester-preset-btn');
    if (presetBtn) {
      var text = presetBtn.getAttribute('data-text');
      if (text && textInput) {
        textInput.value = text;
        updatePreviewText(text);
      }
      return;
    }
  });

  /* --- Set initial state --- */
  if (slider) {
    updatePreviewSize(slider.value);
  }
  if (textInput && textInput.value) {
    updatePreviewText(textInput.value);
  }

});
