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
    <div class="nav">
      <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="nav-logo">Rillatype</a>

      <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
        <span class="screen-reader-text"><?php esc_html_e('Menu', 'rillatype-v2'); ?></span>
        <span></span>
        <span></span>
        <span></span>
      </button>

      <div class="nav-links">
        <?php
        if (has_nav_menu('primary')) {
          wp_nav_menu(array(
            'theme_location' => 'primary',
            'container'      => false,
            'menu_id'        => 'primary-menu',
            'menu_class'     => 'nav-menu',
            'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
            'fallback_cb'    => false,
          ));
        } else {
          ?>
          <a href="<?php echo esc_url(home_url('/shop')); ?>"><?php esc_html_e('Shop', 'rillatype-v2'); ?></a>
          <a href="<?php echo esc_url(home_url('/about')); ?>"><?php esc_html_e('About', 'rillatype-v2'); ?></a>
          <a href="<?php echo esc_url(home_url('/blog')); ?>"><?php esc_html_e('Blog', 'rillatype-v2'); ?></a>
          <?php
        }
        ?>
      </div>
    </div>
  </header>
