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

<style>
.font-tester {
  background: var(--color-white, #FFFFFF);
  border: 1px solid var(--color-gray-200, #E2DFD7);
  border-radius: 4px;
  padding: var(--spacing-md, 2rem);
}

.font-tester__toolbar {
  display: flex;
  flex-wrap: wrap;
  gap: var(--spacing-sm, 1rem);
  margin-bottom: var(--spacing-sm, 1rem);
}

.font-tester__field {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.font-tester__label {
  font-family: var(--font-ui, sans-serif);
  font-size: 0.75rem;
  text-transform: uppercase;
  letter-spacing: 0.06em;
  color: var(--color-gray-400, #8C887D);
  white-space: nowrap;
}

.font-tester__input {
  font-family: var(--font-ui, sans-serif);
  font-size: 0.875rem;
  padding: 0.5rem 0.75rem;
  border: 1px solid var(--color-gray-200, #E2DFD7);
  border-radius: 3px;
  background: var(--color-bg, #F4F2ED);
  color: var(--color-text, #1A1814);
  min-width: 280px;
}

.font-tester__range {
  width: 120px;
  accent-color: var(--color-accent, #C1493A);
}

.font-tester__value {
  font-family: var(--font-ui, sans-serif);
  font-size: 0.75rem;
  color: var(--color-gray-400, #8C887D);
  min-width: 3em;
}

.font-tester__styles,
.font-tester__presets {
  display: flex;
  flex-wrap: wrap;
  gap: 0.5rem;
  margin-bottom: var(--spacing-sm, 1rem);
}

.font-tester__style,
.font-tester__preset {
  font-family: var(--font-ui, sans-serif);
  font-size: 0.8125rem;
  padding: 0.4rem 0.9rem;
  border: 1px solid var(--color-gray-200, #E2DFD7);
  border-radius: 3px;
  background: var(--color-white, #FFFFFF);
  color: var(--color-text, #1A1814);
  cursor: pointer;
  transition: background var(--transition, 0.2s ease), border-color var(--transition, 0.2s ease);
}

.font-tester__style:hover,
.font-tester__preset:hover {
  border-color: var(--color-accent, #C1493A);
}

.font-tester__style.is-active {
  background: var(--color-accent, #C1493A);
  border-color: var(--color-accent, #C1493A);
  color: var(--color-white, #FFFFFF);
}

.font-tester__preview {
  border-top: 1px solid var(--color-gray-200, #E2DFD7);
  padding-top: var(--spacing-md, 2rem);
  min-height: 120px;
  display: flex;
  align-items: center;
}

.font-tester__display {
  font-family: var(--font-heading, Georgia, serif);
  font-size: 3rem;
  line-height: 1.3;
  color: var(--color-text, #1A1814);
  margin: 0;
  word-break: break-word;
  width: 100%;
}
</style>
