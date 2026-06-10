<?php
/**
 * Category links bar template part.
 * Gets categories from ACF 'font_categories' repeater if available,
 * otherwise uses defaults.
 */

$categories = array();

if (class_exists('ACF')) {
  $repeater = get_field('font_categories', 'option');
  if (!empty($repeater) && is_array($repeater)) {
    foreach ($repeater as $item) {
      $categories[] = array(
        'name' => isset($item['category_name']) ? $item['category_name'] : '',
        'link' => isset($item['category_link']) ? $item['category_link'] : '#',
      );
    }
  }
}

if (empty($categories)) {
  $defaults = array(
    __('Display', 'rillatype-v2'),
    __('Script', 'rillatype-v2'),
    __('Handwritten', 'rillatype-v2'),
    __('Retro & Vintage', 'rillatype-v2'),
    __('Sans Serif', 'rillatype-v2'),
    __('Serif', 'rillatype-v2'),
    __('Freebies', 'rillatype-v2'),
  );
  foreach ($defaults as $name) {
    $categories[] = array(
      'name' => $name,
      'link' => '#',
    );
  }
}
?>

<nav class="category-links" aria-label="<?php esc_attr_e('Font categories', 'rillatype-v2'); ?>">
  <?php foreach ($categories as $cat) : ?>
    <?php if (!empty($cat['name'])) : ?>
      <a href="<?php echo esc_url($cat['link']); ?>" class="category-links__item">
        <?php echo esc_html($cat['name']); ?>
      </a>
    <?php endif; ?>
  <?php endforeach; ?>
</nav>

<style>
.category-links {
  display: flex;
  flex-wrap: wrap;
  gap: 0.25rem;
  padding: var(--spacing-sm, 1rem) 0;
  border-top: 1px solid var(--color-gray-200, #E2DFD7);
  border-bottom: 1px solid var(--color-gray-200, #E2DFD7);
}

.category-links__item {
  font-family: var(--font-ui, sans-serif);
  font-size: 0.8125rem;
  font-weight: 500;
  color: var(--color-gray-400, #8C887D);
  text-decoration: none;
  padding: 0.4rem 0.9rem;
  border-radius: 3px;
  transition: color var(--transition, 0.2s ease), background var(--transition, 0.2s ease);
}

.category-links__item:hover {
  color: var(--color-accent, #C1493A);
  background: var(--color-gray-100, #F0EFEA);
}

.category-links__item:focus-visible {
  outline: 2px solid var(--color-accent, #C1493A);
  outline-offset: 2px;
}
</style>
