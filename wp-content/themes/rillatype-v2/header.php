<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php
if (function_exists('wp_body_open')) {
  wp_body_open();
}
?>

<div id="page" class="site">
  <header id="masthead" class="site-header">
    <div class="header-inner container">
      <div class="site-branding">
        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="site-logo">Rillatype</a>
      </div>

      <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e('Primary Menu', 'rillatype-v2'); ?>">
        <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
          <span class="screen-reader-text"><?php esc_html_e('Menu', 'rillatype-v2'); ?></span>
          <span class="menu-icon"></span>
        </button>

        <?php
        if (has_nav_menu('primary')) {
          wp_nav_menu(array(
            'theme_location' => 'primary',
            'menu_id'        => 'primary-menu',
            'container'      => false,
            'fallback_cb'    => false,
          ));
        } else {
          ?>
          <ul id="primary-menu" class="menu">
            <li><a href="<?php echo esc_url(home_url('/shop')); ?>"><?php esc_html_e('Shop', 'rillatype-v2'); ?></a></li>
            <li><a href="<?php echo esc_url(home_url('/about')); ?>"><?php esc_html_e('About', 'rillatype-v2'); ?></a></li>
            <li><a href="<?php echo esc_url(home_url('/blog')); ?>"><?php esc_html_e('Blog', 'rillatype-v2'); ?></a></li>
          </ul>
          <?php
        }
        ?>
      </nav>
    </div>
  </header>
