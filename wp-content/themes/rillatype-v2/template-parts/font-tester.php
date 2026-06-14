<?php
/**
 * Font tester UI template part.
 * No JavaScript required — structure uses data attributes for JS enhancement.
 */
?>

<div class="font-tester" data-font-tester>
  <div class="font-tester__toolbar">
    <div class="font-tester__field">
      <label for="font-tester-input" class="font-tester__label"><?php esc_html_e('Text', 'rillatype-v2'); ?></label>
      <input
        type="text"
        id="font-tester-input"
        class="font-tester__input"
        data-font-tester-input
        value="<?php esc_attr_e('The quick brown fox jumps over the lazy dog', 'rillatype-v2'); ?>"
        placeholder="<?php esc_attr_e('Type something…', 'rillatype-v2'); ?>"
      >
    </div>

    <div class="font-tester__field">
      <label for="font-tester-size" class="font-tester__label"><?php esc_html_e('Size', 'rillatype-v2'); ?></label>
      <input
        type="range"
        id="font-tester-size"
        class="font-tester__range"
        data-font-tester-size
        min="16"
        max="200"
        value="48"
        step="1"
      >
      <span class="font-tester__value" data-font-tester-value>48px</span>
    </div>
  </div>

  <div class="font-tester__styles" data-font-tester-styles>
    <button type="button" class="font-tester__style is-active" data-font-tester-style="regular">
      <?php esc_html_e('Regular', 'rillatype-v2'); ?>
    </button>
    <button type="button" class="font-tester__style" data-font-tester-style="bold">
      <?php esc_html_e('Bold', 'rillatype-v2'); ?>
    </button>
    <button type="button" class="font-tester__style" data-font-tester-style="italic">
      <?php esc_html_e('Italic', 'rillatype-v2'); ?>
    </button>
  </div>

  <div class="font-tester__presets" data-font-tester-presets>
    <button type="button" class="font-tester__preset" data-font-tester-text="Aa Bb Cc">
      Aa Bb Cc
    </button>
    <button type="button" class="font-tester__preset" data-font-tester-text="ALL CAPS">
      ALL CAPS
    </button>
    <button type="button" class="font-tester__preset" data-font-tester-text="Short phrase">
      Short phrase
    </button>
  </div>

  <div class="font-tester__preview" data-font-tester-preview>
    <p class="font-tester__display" data-font-tester-display>
      <?php esc_html_e('The quick brown fox jumps over the lazy dog', 'rillatype-v2'); ?>
    </p>
  </div>
</div>
