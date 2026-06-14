<?php
/**
 * Font card template part.
 *
 * @param array $args {
 *   Optional. Arguments for the font card.
 *   @type int $product_id WooCommerce product ID.
 * }
 */

$product_id = isset($args['product_id']) ? intval($args['product_id']) : 0;
$product    = null;
$title      = '';
$category   = '';
$price      = '';
$image_html = '';

if ($product_id && function_exists('wc_get_product')) {
  $product = wc_get_product($product_id);
}

if ($product) {
  $title    = $product->get_name();
  $price    = $product->get_price_html();
  $category = '';
  $terms    = get_the_terms($product_id, 'product_cat');
  if ($terms && !is_wp_error($terms)) {
    $cat_names = array();
    foreach ($terms as $term) {
      $cat_names[] = esc_html($term->name);
    }
    $category = implode(', ', $cat_names);
  }
  $image_id  = $product->get_image_id();
  if ($image_id) {
    $image_html = wp_get_attachment_image($image_id, 'medium', false, array('loading' => 'lazy'));
  } else {
    $image_html = '<div class="font-card__image-placeholder"></div>';
  }
} else {
  $title    = __('Sample Font', 'rillatype-v2');
  $price    = '<span class="price">$49</span>';
  $category = __('Serif', 'rillatype-v2');
  $image_html = '<div class="font-card__image-placeholder"></div>';
}
?>

<article class="font-card" data-product-id="<?php echo esc_attr($product_id); ?>">
  <a href="<?php echo $product ? esc_url(get_permalink($product_id)) : '#'; ?>" class="font-card__link">
    <figure class="font-card__image">
      <?php echo $image_html; ?>
    </figure>
    <div class="font-card__body">
      <h2 class="font-card__title"><?php echo esc_html($title); ?></h2>
      <?php if ($category) : ?>
        <p class="font-card__category"><?php echo esc_html($category); ?></p>
      <?php endif; ?>
      <?php if ($price) : ?>
        <div class="font-card__price"><?php echo $price; ?></div>
      <?php endif; ?>
    </div>
  </a>
</article>
