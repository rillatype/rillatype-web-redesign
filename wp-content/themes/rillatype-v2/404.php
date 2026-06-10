<?php
get_header();
?>

<main id="main" class="site-main error-404-main">
  <div class="container container-narrow" style="text-align:center;padding:6rem 0;">
    <h1 class="page-title"><?php esc_html_e('404', 'rillatype-v2'); ?></h1>
    <p><?php esc_html_e('This page could not be found.', 'rillatype-v2'); ?></p>
    <a href="<?php echo esc_url(home_url('/')); ?>" class="button button-primary"><?php esc_html_e('Back to Home', 'rillatype-v2'); ?></a>
  </div>
</main>

<?php
get_footer();
