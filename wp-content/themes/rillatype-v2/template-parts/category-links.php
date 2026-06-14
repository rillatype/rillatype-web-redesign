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
