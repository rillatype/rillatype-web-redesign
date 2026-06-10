<?php
/**
 * The template for displaying product content within loops
 *
 * @package Rillatype_Theme
 */

defined('ABSPATH') || exit;

global $product;

if (empty($product)) {
  return;
}
?>

<li <?php wc_product_class('product-card', $product); ?>>
  <?php
  $thumbnail_id = $product->get_image_id();
  $thumbnail    = $thumbnail_id ? wp_get_attachment_image_url($thumbnail_id, 'medium_large') : wc_placeholder_img_src('medium_large');
  $categories   = wc_get_product_category_list($product->get_id(), ', ');
  ?>

  <a href="<?php echo esc_url($product->get_permalink()); ?>" class="product-card-link">
    <div class="product-card-image">
      <img
        src="<?php echo esc_url($thumbnail); ?>"
        alt="<?php echo esc_attr($product->get_name()); ?>"
        loading="lazy"
      >
    </div>

    <div class="product-card-body">
      <h2><?php echo esc_html($product->get_name()); ?></h2>

      <?php if ($categories) : ?>
        <span class="card-category"><?php echo wp_kses_post($categories); ?></span>
      <?php endif; ?>

      <span class="price"><?php echo $product->get_price_html(); ?></span>
    </div>
  </a>

  <?php woocommerce_template_loop_add_to_cart(); ?>
</li>
