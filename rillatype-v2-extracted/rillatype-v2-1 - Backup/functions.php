<?php
/**
 * Rillatype V2 Theme Functions
 */

// Load Customizer
$customizer_file = get_template_directory() . '/inc/customizer.php';
if (file_exists($customizer_file)) {
  require_once $customizer_file;
}

// Theme Setup
add_action('after_setup_theme', 'rillatype_theme_setup');
function rillatype_theme_setup() {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'));
  add_theme_support('custom-logo', array('height' => 60, 'width' => 200, 'flex-height' => true, 'flex-width' => true));
  add_theme_support('align-wide');
  add_theme_support('responsive-embeds');

  register_nav_menus(array(
    'primary' => __('Primary Menu', 'rillatype-v2'),
    'footer'  => __('Footer Menu', 'rillatype-v2'),
  ));

  // Register Sidebar Widget Area
  register_sidebar(array(
    'name'          => __('Sidebar', 'rillatype-v2'),
    'id'            => 'sidebar-1',
    'description'   => __('Add widgets here to appear in the sidebar.', 'rillatype-v2'),
    'before_widget' => '<section id="%1$s" class="widget %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h2 class="widget-title">',
    'after_title'   => '</h2>',
  ));

  register_sidebar(array(
    'name'          => __('Footer Widgets', 'rillatype-v2'),
    'id'            => 'footer-1',
    'description'   => __('Add widgets here to appear in the footer.', 'rillatype-v2'),
    'before_widget' => '<section id="%1$s" class="widget %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h2 class="widget-title">',
    'after_title'   => '</h2>',
  ));
}

// WooCommerce Support
add_action('after_setup_theme', 'rillatype_woocommerce_support');
function rillatype_woocommerce_support() {
  if (class_exists('WooCommerce')) {
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
  }
}

// Remove WooCommerce Styles — disabled until custom WooCommerce CSS is complete
// add_filter('woocommerce_enqueue_styles', 'rillatype_remove_woocommerce_styles');
function rillatype_remove_woocommerce_styles($enqueue_styles) {
  if (class_exists('WooCommerce')) {
    unset($enqueue_styles['woocommerce-general']);
    unset($enqueue_styles['woocommerce-layout']);
    unset($enqueue_styles['woocommerce-smallscreen']);
  }
  return $enqueue_styles;
}

// ACF Options Pages
add_action('acf/init', 'rillatype_acf_options_pages');
function rillatype_acf_options_pages() {
  if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
      'page_title' => __('Hero', 'rillatype-v2'),
      'menu_title' => __('Hero', 'rillatype-v2'),
      'menu_slug'  => 'rillatype-hero',
      'capability' => 'edit_posts',
      'redirect'   => false,
    ));

    acf_add_options_page(array(
      'page_title' => __('Font Categories', 'rillatype-v2'),
      'menu_title' => __('Font Categories', 'rillatype-v2'),
      'menu_slug'  => 'rillatype-font-categories',
      'capability' => 'edit_posts',
      'redirect'   => false,
    ));
  }
}

// Fallback Menu (when no menu is assigned in wp-admin)
function rillatype_fallback_menu($args) {
  $menu_id   = isset($args['menu_id']) ? $args['menu_id'] : 'primary-menu';
  $menu_class = isset($args['menu_class']) ? $args['menu_class'] : 'nav-menu';
  $sign_in_url = function_exists('wc_get_page_id') ? get_permalink(wc_get_page_id('myaccount')) : wp_login_url();
  ?>
  <ul id="<?php echo esc_attr($menu_id); ?>" class="<?php echo esc_attr($menu_class); ?>">
    <li class="current-menu-item"><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'rillatype-v2'); ?></a></li>
    <li><a href="<?php echo esc_url(home_url('/shop/')); ?>"><?php esc_html_e('Shop', 'rillatype-v2'); ?></a></li>
    <li><a href="<?php echo esc_url(home_url('/product-category/freebies/')); ?>"><?php esc_html_e('Freebies', 'rillatype-v2'); ?></a></li>
    <li><a href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('Contact', 'rillatype-v2'); ?></a></li>
    <li><a href="<?php echo esc_url($sign_in_url); ?>"><?php esc_html_e('Sign In', 'rillatype-v2'); ?></a></li>
  </ul>
  <?php
}

// Enqueue Scripts and Styles
add_action('wp_enqueue_scripts', 'rillatype_enqueue_assets');
function rillatype_enqueue_assets() {
  $theme = wp_get_theme();
  $version = $theme->get('Version');

  // Google Fonts: Plus Jakarta Sans + Instrument Serif
  wp_enqueue_style('rillatype-fonts', 'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Instrument+Serif:ital@0;1&display=swap', array(), null);

  // Main stylesheet (contains all CSS)
  wp_enqueue_style('rillatype', get_stylesheet_uri(), array('rillatype-fonts'), $version);

  // Single Product JS
  $product_js = get_template_directory() . '/assets/js/product.js';
  if (class_exists('WooCommerce') && is_product() && file_exists($product_js)) {
    wp_enqueue_script('rillatype-product', get_template_directory_uri() . '/assets/js/product.js', array(), $version, true);
  }

  // Main JS
  $main_js = get_template_directory() . '/assets/js/main.js';
  if (file_exists($main_js)) {
    wp_enqueue_script('rillatype-main', get_template_directory_uri() . '/assets/js/main.js', array(), $version, true);
  }

  // Font Tester JS
  $font_tester_js = get_template_directory() . '/assets/js/font-tester.js';
  if (file_exists($font_tester_js)) {
    wp_enqueue_script('rillatype-font-tester', get_template_directory_uri() . '/assets/js/font-tester.js', array(), $version, true);
  }
}

// Custom Image Sizes
add_action('after_setup_theme', 'rillatype_image_sizes');
function rillatype_image_sizes() {
  add_image_size('rillatype-hero', 1400, 800, true);
  add_image_size('rillatype-font-preview', 600, 400, true);
  add_image_size('rillatype-square', 600, 600, true);
}

// Mini Cart Fragment Refresh
add_filter('woocommerce_add_to_cart_fragments', 'rillatype_cart_fragment');
function rillatype_cart_fragment($fragments) {
  ob_start();
  $count = 0;
  if (function_exists('WC') && WC()->cart) {
    $count = WC()->cart->get_cart_contents_count();
  }
  ?>
  <span class="nav-cart-count"><?php echo esc_html($count); ?></span>
  <?php
  $fragments['.nav-cart-count'] = ob_get_clean();
  return $fragments;
}

// My Account navigation — reorder & customize
add_filter('woocommerce_account_menu_items', 'rillatype_account_menu_items');
function rillatype_account_menu_items($items) {
  $order = array(
    'dashboard'       => __('Dashboard', 'rillatype-v2'),
    'orders'          => __('Orders', 'rillatype-v2'),
    'downloads'       => __('Downloads', 'rillatype-v2'),
    'edit-address'    => __('Addresses', 'rillatype-v2'),
    'edit-account'    => __('Details', 'rillatype-v2'),
    'customer-logout' => __('Log Out', 'rillatype-v2'),
  );
  return $order;
}
