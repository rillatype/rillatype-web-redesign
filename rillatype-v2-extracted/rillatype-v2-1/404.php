<?php
/**
 * The template for displaying 404 pages (not found)
 */
get_header();
?>

<main id="main" class="site-main error-page">
  <div class="error-content">
    <p class="error-code">404</p>
    <h1 class="error-title"><?php esc_html_e('Page not found', 'rillatype-v2'); ?></h1>
    <p class="error-desc"><?php esc_html_e('The page you\'re looking for doesn\'t exist or has been moved.', 'rillatype-v2'); ?></p>
    <div class="error-actions">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn--primary"><?php esc_html_e('Go home', 'rillatype-v2'); ?></a>
      <a href="<?php echo esc_url(function_exists('wc_get_page_id') ? get_permalink(wc_get_page_id('shop')) : home_url('/shop/')); ?>" class="btn btn--ghost"><?php esc_html_e('Browse fonts', 'rillatype-v2'); ?></a>
    </div>
  </div>
</main>

<?php get_footer(); ?>
