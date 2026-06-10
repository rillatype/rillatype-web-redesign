<?php
/**
 * The Template for displaying product archives
 *
 * @package Rillatype_Theme
 */

get_header();

$shop_title = woocommerce_page_title(false);
?>

<section class="container archive-shop">
  <header class="archive-shop-header">
    <h1 class="archive-shop-title"><?php echo esc_html($shop_title ?: __('Shop', 'rillatype')); ?></h1>
  </header>

  <?php
  if (woocommerce_product_loop()) {
    do_action('woocommerce_before_shop_loop');

    woocommerce_product_loop_start();

    if (wc_get_loop_prop('total')) {
      while (have_posts()) {
        the_post();
        wc_get_template_part('content', 'product');
      }
    }

    woocommerce_product_loop_end();

    do_action('woocommerce_after_shop_loop');
  } else {
    do_action('woocommerce_no_products_found');
  }
  ?>
</section>

<?php
get_footer();
