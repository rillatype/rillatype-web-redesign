<?php
/**
 * WooCommerce overrides.
 */

if (!class_exists('WooCommerce')) {
  return;
}

// Wrap product content in custom divs
add_action('woocommerce_before_shop_loop_item', function () {
  echo '<div class="woo-product-inner">';
}, 5);

add_action('woocommerce_after_shop_loop_item', function () {
  echo '</div>';
}, 15);

// Wrap product thumbnail
add_action('woocommerce_before_shop_loop_item_title', function () {
  echo '<div class="woo-product-thumb">';
}, 5);

add_action('woocommerce_before_shop_loop_item_title', function () {
  echo '</div>';
}, 15);

// Move sale flash inside thumbnail wrapper
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 6);

// Customize add to cart text
add_filter('woocommerce_product_add_to_cart_text', function ($text, $product) {
  if ($product->get_type() === 'simple') {
    return __('Purchase', 'rillatype-v2');
  }
  return $text;
}, 10, 2);

add_filter('woocommerce_product_single_add_to_cart_text', function () {
  return __('Add to Cart', 'rillatype-v2');
});

// Remove sidebar on shop pages
add_action('wp', function () {
  if (is_shop() || is_product_category() || is_product_tag() || is_product()) {
    remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
  }
});

// Set products per page
add_filter('loop_shop_per_page', function () {
  return 12;
}, 20);

// Customize breadcrumb
add_filter('woocommerce_breadcrumb_defaults', function ($defaults) {
  return array(
    'delimiter'   => ' &nbsp;/&nbsp; ',
    'wrap_before' => '<nav class="woocommerce-breadcrumb" itemprop="breadcrumb">',
    'wrap_after'  => '</nav>',
    'before'      => '',
    'after'       => '',
    'home'        => _x('Home', 'breadcrumb', 'rillatype-v2'),
  );
});

// Custom breadcrumb home URL
add_filter('woocommerce_breadcrumb_home_url', function () {
  return home_url('/');
});
