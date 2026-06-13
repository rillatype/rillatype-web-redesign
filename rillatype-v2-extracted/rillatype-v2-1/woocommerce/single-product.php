<?php get_header(); ?>

<main id="main" class="site-main single-product-page">
  <?php while (have_posts()) : the_post(); ?>
    <?php wc_get_template_part('content', 'single-product'); ?>
  <?php endwhile; ?>
</main>

<?php get_footer(); ?>
