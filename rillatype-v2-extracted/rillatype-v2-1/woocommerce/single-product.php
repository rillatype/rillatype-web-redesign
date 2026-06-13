<?php get_header(); ?>

<main id="main" class="site-main single-product-page">
  <div class="container">
    <?php while (have_posts()) : the_post(); ?>
      <?php wc_get_template_part('content', 'single-product'); ?>
    <?php endwhile; ?>
  </div>
</main>

<?php get_footer(); ?>
