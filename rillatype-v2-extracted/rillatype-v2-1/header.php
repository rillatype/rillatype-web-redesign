<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="profile" href="https://gmpg.org/xfn/11">

  <?php
  // Open Graph / Social Meta
  $og_title       = is_front_page() || is_home() ? get_bloginfo('name') : wp_get_document_title();
  $og_description = get_bloginfo('description');
  $og_url         = is_front_page() || is_home() ? home_url('/') : get_permalink();
  $og_image       = '';
  $logo_id        = get_theme_mod('custom_logo');
  if ($logo_id) $og_image = wp_get_attachment_image_url($logo_id, 'full');
  if (!$og_image) $og_image = get_template_directory_uri() . '/assets/images/logo.png';
  ?>
  <meta name="description" content="<?php echo esc_attr($og_description); ?>">
  <meta property="og:title" content="<?php echo esc_attr($og_title); ?>">
  <meta property="og:description" content="<?php echo esc_attr($og_description); ?>">
  <meta property="og:url" content="<?php echo esc_url($og_url); ?>">
  <meta property="og:image" content="<?php echo esc_url($og_image); ?>">
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="<?php echo esc_attr(get_bloginfo('name')); ?>">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?php echo esc_attr($og_title); ?>">
  <meta name="twitter:description" content="<?php echo esc_attr($og_description); ?>">
  <meta name="twitter:image" content="<?php echo esc_url($og_image); ?>">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php
if (function_exists('wp_body_open')) {
  wp_body_open();
}
?>

<a href="#main" class="skip-link"><?php esc_html_e('Skip to content', 'rillatype-v2'); ?></a>

<div id="page" class="site">

  <header class="site-header">
    <nav class="header-inner container" aria-label="Main">
      <?php if (has_custom_logo()) : ?>
        <?php the_custom_logo(); ?>
      <?php else : ?>
        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="site-logo">
          <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/logo.png" alt="<?php bloginfo('name'); ?>" class="site-logo__img" onerror="this.style.display='none';this.parentNode.textContent='<?php bloginfo('name'); ?>'">
        </a>
      <?php endif; ?>
      <div class="nav-main">
        <?php
        wp_nav_menu(array(
          'theme_location' => 'primary',
          'container'      => false,
          'menu_id'        => 'primary-menu',
          'menu_class'     => 'nav-menu',
          'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
          'fallback_cb'    => 'rillatype_fallback_menu',
        ));
        ?>
        <div class="nav-actions--mobile">
          <form class="nav-search-form" action="<?php echo esc_url(home_url('/')); ?>" method="get">
            <svg class="nav-search-form__icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input class="nav-search-form__input" type="text" name="s" placeholder="<?php esc_attr_e('Search fonts…', 'rillatype-v2'); ?>" autocomplete="off" required>
          </form>
          <?php if (function_exists('WC') && WC()->cart) : ?>
            <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="nav-icon nav-cart-wrap">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
              <?php esc_html_e('Cart', 'rillatype-v2'); ?>
              <span class="nav-cart-count"><?php echo esc_html(function_exists('WC') && WC()->cart ? WC()->cart->get_cart_contents_count() : 0); ?></span>
            </a>
          <?php endif; ?>
        </div>
      </div>
      <div class="nav-actions">
        <button type="button" class="nav-icon search-toggle" aria-label="<?php esc_attr_e('Search', 'rillatype-v2'); ?>">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        </button>
        <?php if (function_exists('WC') && WC()->cart) : ?>
          <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="nav-icon nav-cart-wrap" aria-label="<?php esc_attr_e('Cart', 'rillatype-v2'); ?>">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
            <span class="nav-cart-count"><?php echo esc_html(function_exists('WC') && WC()->cart ? WC()->cart->get_cart_contents_count() : 0); ?></span>
          </a>
        <?php endif; ?>
      </div>
      <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
        <span class="screen-reader-text"><?php esc_html_e('Menu', 'rillatype-v2'); ?></span>
        <span></span>
        <span></span>
        <span></span>
      </button>
    </nav>
    <div class="search-overlay" id="search-overlay" role="search">
      <form class="search-overlay__form container" action="<?php echo esc_url(home_url('/')); ?>" method="get">
        <input class="search-overlay__input" id="search-input" type="text" name="s" placeholder="<?php esc_attr_e('Type to search…', 'rillatype-v2'); ?>" autocomplete="off" required>
        <button class="search-overlay__close" type="button" aria-label="<?php esc_attr_e('Close search', 'rillatype-v2'); ?>">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
      </form>
    </div>
  </header>
