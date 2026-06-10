<?php
/**
 * The template for displaying single product content
 *
 * @package Rillatype_Theme
 */

defined('ABSPATH') || exit;

global $product;
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class('', $product); ?>>
  <div class="product-content">
    <?php
    do_action('woocommerce_before_single_product_summary');
    ?>

    <div class="summary entry-summary">
      <?php
      do_action('woocommerce_single_product_summary');
      ?>
    </div>
  </div>

  <?php
  do_action('woocommerce_after_single_product_summary');
  ?>
</div>
