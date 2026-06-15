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
    wp_enqueue_script('rillatype-product', get_template_directory_uri() . '/assets/js/product.js', array(), filemtime($product_js), true);
  }

  // Main JS
  $main_js = get_template_directory() . '/assets/js/main.js';
  if (file_exists($main_js)) {
    wp_enqueue_script('rillatype-main', get_template_directory_uri() . '/assets/js/main.js', array(), filemtime($main_js), true);
  }

  // Font Tester JS
  $font_tester_js = get_template_directory() . '/assets/js/font-tester.js';
  if (file_exists($font_tester_js)) {
    wp_enqueue_script('rillatype-font-tester', get_template_directory_uri() . '/assets/js/font-tester.js', array(), filemtime($font_tester_js), true);
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

// Reusable: get minimum price for variable products
if (!function_exists('rillatype_min_price')) {
  function rillatype_min_price($product) {
    if (!$product) return '';
    if ($product->is_type('variable')) {
      return wc_price($product->get_variation_price('min'));
    }
    return $product->get_price_html();
  }
}

// Products per page: ensure multiples of 3 for 3-col grid
add_filter('loop_shop_per_page', function($cols) {
  return 15;
});

// Allow font files for the product tester upload field.
add_filter('upload_mimes', 'rillatype_allow_font_uploads');
function rillatype_allow_font_uploads($mimes) {
  $mimes['ttf'] = 'font/ttf';
  $mimes['otf'] = 'font/otf';
  $mimes['woff'] = 'font/woff';
  $mimes['woff2'] = 'font/woff2';
  return $mimes;
}

add_action('add_meta_boxes_product', 'rillatype_add_product_preview_box');
function rillatype_add_product_preview_box() {
  add_meta_box('rillatype-product-preview', 'Product Preview', 'rillatype_render_product_preview_box', 'product', 'normal', 'default');
}

function rillatype_attachment_label($attachment_id) {
  $attachment_id = absint($attachment_id);
  if (!$attachment_id) return __('No font selected', 'rillatype-v2');
  $path = get_attached_file($attachment_id);
  return $path ? basename($path) : get_the_title($attachment_id);
}

function rillatype_render_font_file_field($name, $value) {
  $field_id = 'rillatype_font_field_' . md5($name . wp_rand(1000, 9999));
  ?>
  <input type="hidden" class="rillatype-tester-font-url" id="<?php echo $field_id; ?>" name="<?php echo esc_attr($name); ?>" value="<?php echo esc_attr(absint($value)); ?>">
  <span class="rillatype-tester-font-name"><?php echo esc_html(rillatype_attachment_label($value)); ?></span>
  <button type="button" class="button rillatype-upload-tester-font" data-target="#<?php echo $field_id; ?>" data-value="id"><?php esc_html_e('Upload / Choose Font', 'rillatype-v2'); ?></button>
  <button type="button" class="button rillatype-clear-tester-font" data-target="#<?php echo $field_id; ?>"><?php esc_html_e('Clear', 'rillatype-v2'); ?></button>
  <?php
}

function rillatype_render_product_preview_box($post) {
  wp_nonce_field('rillatype_save_product_preview', 'rillatype_product_preview_nonce');

  $enabled = get_post_meta($post->ID, '_font_preview', true);
  if ($enabled === '') $enabled = '1';
  $mode = get_post_meta($post->ID, '_font_mode', true) ?: 'image';
  $rows = absint(get_post_meta($post->ID, '_font_data', true));
  ?>
  <div class="rillatype-product-preview-box">
    <p>
      <label><strong><?php esc_html_e('Enable Font Preview', 'rillatype-v2'); ?></strong></label><br>
      <label><input type="checkbox" name="_font_preview" value="1" <?php checked($enabled, '1'); ?>> <?php esc_html_e('Yes', 'rillatype-v2'); ?></label>
    </p>

    <p>
      <label><strong><?php esc_html_e('Font Preview Mode', 'rillatype-v2'); ?></strong></label><br>
      <label><input type="radio" name="_font_mode" value="image" <?php checked($mode, 'image'); ?>> <?php esc_html_e('Secure IMAGE-based font preview (OTF/TTF), one-line preview only and no ligature support', 'rillatype-v2'); ?></label><br>
      <label><input type="radio" name="_font_mode" value="text" <?php checked($mode, 'text'); ?>> <?php esc_html_e('Secure TEXT-based font preview (WOFF/WOFF2), multi-line preview with ligature support', 'rillatype-v2'); ?></label>
    </p>

    <h4><?php esc_html_e('Add/Select Font', 'rillatype-v2'); ?></h4>
    <table class="widefat rillatype-font-data-table">
      <thead>
        <tr>
          <th><?php esc_html_e('Font Name', 'rillatype-v2'); ?></th>
          <th><?php esc_html_e('OTF/TTF Font File', 'rillatype-v2'); ?></th>
          <th><?php esc_html_e('WOFF/WOFF2 Font File', 'rillatype-v2'); ?></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php for ($i = 0; $i < max(1, $rows); $i++) : ?>
          <tr>
            <td><input type="text" class="widefat" name="rillatype_font_data[<?php echo esc_attr($i); ?>][name]" value="<?php echo esc_attr(get_post_meta($post->ID, '_font_data_' . $i . '_name', true)); ?>"></td>
            <td><?php rillatype_render_font_file_field('rillatype_font_data[' . $i . '][font]', get_post_meta($post->ID, '_font_data_' . $i . '_font', true)); ?></td>
            <td><?php rillatype_render_font_file_field('rillatype_font_data[' . $i . '][font_web]', get_post_meta($post->ID, '_font_data_' . $i . '_font_web', true)); ?></td>
            <td><button type="button" class="button rillatype-remove-font-row"><?php esc_html_e('Remove', 'rillatype-v2'); ?></button></td>
          </tr>
        <?php endfor; ?>
      </tbody>
    </table>
    <p><button type="button" class="button button-primary rillatype-add-font-row"><?php esc_html_e('Add/Select Font', 'rillatype-v2'); ?></button></p>
  </div>
  <?php
}

add_action('save_post_product', 'rillatype_save_product_preview_box');
function rillatype_save_product_preview_box($post_id) {
  if (!isset($_POST['rillatype_product_preview_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['rillatype_product_preview_nonce'])), 'rillatype_save_product_preview')) return;
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
  if (!current_user_can('edit_post', $post_id)) return;

  update_post_meta($post_id, '_font_preview', isset($_POST['_font_preview']) ? '1' : '0');
  update_post_meta($post_id, '_font_mode', isset($_POST['_font_mode']) && $_POST['_font_mode'] === 'text' ? 'text' : 'image');

  $old_rows = absint(get_post_meta($post_id, '_font_data', true));
  for ($i = 0; $i < $old_rows; $i++) {
    delete_post_meta($post_id, '_font_data_' . $i . '_name');
    delete_post_meta($post_id, '_font_data_' . $i . '_font');
    delete_post_meta($post_id, '_font_data_' . $i . '_font_web');
  }

  $rows = isset($_POST['rillatype_font_data']) && is_array($_POST['rillatype_font_data']) ? wp_unslash($_POST['rillatype_font_data']) : array();
  $saved = 0;
  foreach ($rows as $row) {
    $name = isset($row['name']) ? sanitize_text_field($row['name']) : '';
    $font = isset($row['font']) ? absint($row['font']) : 0;
    $font_web = isset($row['font_web']) ? absint($row['font_web']) : 0;
    if (!$name && !$font && !$font_web) continue;

    update_post_meta($post_id, '_font_data_' . $saved . '_name', $name);
    update_post_meta($post_id, '_font_data_' . $saved . '_font', $font);
    update_post_meta($post_id, '_font_data_' . $saved . '_font_web', $font_web);
    $saved++;
  }
  update_post_meta($post_id, '_font_data', $saved);
}

add_action('admin_enqueue_scripts', 'rillatype_product_admin_assets');
function rillatype_product_admin_assets($hook) {
  $screen = function_exists('get_current_screen') ? get_current_screen() : null;
  if (!in_array($hook, array('post.php', 'post-new.php'), true) || !$screen || $screen->post_type !== 'product') return;

  wp_enqueue_media();
  $admin_js = get_template_directory() . '/assets/js/admin-product.js';
  if (file_exists($admin_js)) {
    wp_enqueue_script('rillatype-admin-product', get_template_directory_uri() . '/assets/js/admin-product.js', array('jquery', 'media-editor', 'media-views'), filemtime($admin_js), true);
  }
}

// Cart is rendered directly in nav-actions--mobile

// Shorten cart product name: "Name - Subtitle - License" → "Name - License"
add_filter('woocommerce_cart_item_name', 'rillatype_cart_item_name', 10, 3);
function rillatype_cart_item_name($name, $cart_item, $cart_item_key) {
  $product = $cart_item['data'];
  $full = $product->get_name();
  $parts = explode(' - ', $full);
  if (count($parts) >= 3) {
    $short = $parts[0] . ' - ' . end($parts);
    $name = preg_replace('/>([^<]+)</u', '>' . esc_html($short) . '<', $name);
  }
  return $name;
}

// Disable shipping for digital products
add_filter('woocommerce_cart_needs_shipping', '__return_false');

// Simplify checkout fields — only name + email for digital downloads
add_filter('woocommerce_checkout_fields', 'rillatype_simplify_checkout_fields', 50);
function rillatype_simplify_checkout_fields($fields) {
  if (isset($fields['billing'])) {
    $keep = array('billing_first_name', 'billing_last_name', 'billing_email');
    foreach ($fields['billing'] as $key => $val) {
      if (!in_array($key, $keep)) {
        unset($fields['billing'][$key]);
      }
    }
  }
  // Shipping hidden
  if (isset($fields['shipping'])) {
    unset($fields['shipping']);
  }
  return $fields;
}

// Also strip address sub-fields (used by WooCommerce internally)
add_filter('woocommerce_default_address_fields', 'rillatype_simplify_address_fields');
function rillatype_simplify_address_fields($fields) {
  $keep = array('first_name', 'last_name');
  foreach ($fields as $key => $val) {
    if (!in_array($key, $keep)) {
      unset($fields[$key]);
    }
  }
  return $fields;
}

// Billing fields priority
add_filter('woocommerce_billing_fields', 'rillatype_billing_fields', 50);
function rillatype_billing_fields($fields) {
  $keep = array('billing_first_name', 'billing_last_name', 'billing_email');
  foreach ($fields as $key => $val) {
    if (!in_array($key, $keep)) {
      unset($fields[$key]);
    }
  }
  return $fields;
}
