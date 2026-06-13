<?php get_header(); ?>

<main id="main" class="site-main shop-page">
  <div class="container">

    <p class="section-label">All products</p>
    <p class="shop-page__desc">Every font, every pack, every extra we make.</p>

    <!-- Category pills -->
    <?php
    $terms = get_terms(array('taxonomy' => 'product_cat', 'hide_empty' => true));
    if (!empty($terms) && !is_wp_error($terms)) : ?>
      <nav class="categories__cloud" aria-label="Font categories">
        <?php foreach ($terms as $term) : ?>
          <a href="<?php echo esc_url(get_term_link($term)); ?>" class="categories__pill anim-card">
            <?php echo esc_html($term->name); ?> <span class="cat-count">(<?php echo esc_html($term->count); ?>)</span>
          </a>
        <?php endforeach; ?>
      </nav>
    <?php endif; ?>

    <?php if (woocommerce_product_loop()) : ?>

      <div class="archive-toolbar">
        <?php do_action('woocommerce_before_shop_loop'); ?>
      </div>

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
