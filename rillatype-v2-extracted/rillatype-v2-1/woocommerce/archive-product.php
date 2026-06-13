<?php get_header(); ?>

<main id="main" class="site-main shop-page">
  <div class="container">

    <div class="shop-page__header">
      <?php woocommerce_breadcrumb(); ?>
      <?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
        <h1 class="shop-page__title"><?php woocommerce_page_title(); ?></h1>
      <?php endif; ?>
      <?php do_action('woocommerce_archive_description'); ?>
    </div>

    <?php if (woocommerce_product_loop()) : ?>

      <?php do_action('woocommerce_before_shop_loop'); ?>

      <?php woocommerce_product_loop_start(); ?>
      <?php if (wc_get_loop_prop('total')) : ?>
        <?php while (have_posts()) : the_post(); ?>
          <?php wc_get_template_part('content', 'product'); ?>
        <?php endwhile; ?>
      <?php endif; ?>
      <?php woocommerce_product_loop_end(); ?>

      <?php do_action('woocommerce_after_shop_loop'); ?>

    <?php else : ?>
      <div class="shop-page__empty">
        <p><?php esc_html_e('No products found.', 'rillatype-v2'); ?></p>
      </div>
    <?php endif; ?>

  </div>
</main>

<?php get_footer(); ?>
