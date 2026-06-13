<?php
global $product;
if (!$product) return;

$name = $product->get_name();
if (preg_match('/^(.+?)\s*[—–]\s*(.+)$/', $name, $m) || preg_match('/^(.+?)\s*-\s*(.+)$/', $name, $m)) {
  $title = trim($m[1]);
  $sub   = ucwords(strtolower(trim($m[2])));
} else {
  $title = $name;
  $sub   = '';
}
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class('single-product', $product); ?>>
  <div class="single-product__gallery">
    <?php do_action('woocommerce_before_single_product_summary'); ?>
  </div>

  <div class="single-product__summary">
    <?php woocommerce_template_single_title(); ?>
    <?php if ($sub) : ?>
      <p class="single-product__subtitle"><?php echo esc_html($sub); ?></p>
    <?php endif; ?>
    <?php woocommerce_template_single_price(); ?>
    <?php woocommerce_template_single_excerpt(); ?>
    <?php woocommerce_template_single_add_to_cart(); ?>
    <?php woocommerce_template_single_meta(); ?>
    <?php woocommerce_template_single_sharing(); ?>
  </div>

  <div class="single-product__tabs">
    <?php woocommerce_output_product_data_tabs(); ?>
  </div>

  <?php woocommerce_output_related_products(); ?>
</div>
