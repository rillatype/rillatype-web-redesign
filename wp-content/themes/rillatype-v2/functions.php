<?php
/**
 * Rillatype V2 Theme Functions
 */

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

// Remove WooCommerce Styles
add_filter('woocommerce_enqueue_styles', 'rillatype_remove_woocommerce_styles');
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

// Enqueue Scripts and Styles
add_action('wp_enqueue_scripts', 'rillatype_enqueue_assets');
function rillatype_enqueue_assets() {
  $theme = wp_get_theme();
  $version = $theme->get('Version');

  // Styles
  wp_enqueue_style('rillatype-main', get_template_directory_uri() . '/assets/css/main.css', array(), $version);
  wp_enqueue_style('rillatype-home', get_template_directory_uri() . '/assets/css/home.css', array(), $version);
  wp_enqueue_style('rillatype-font-tester', get_template_directory_uri() . '/assets/css/font-tester.css', array(), $version);
  wp_enqueue_style('rillatype-category-links', get_template_directory_uri() . '/assets/css/category-links.css', array(), $version);

  if (class_exists('WooCommerce')) {
    wp_enqueue_style('rillatype-woocommerce', get_template_directory_uri() . '/assets/css/woocommerce.css', array(), $version);
  }

  // Scripts
  wp_enqueue_script('rillatype-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), $version, true);
  wp_enqueue_script('rillatype-font-tester', get_template_directory_uri() . '/assets/js/font-tester.js', array('jquery'), $version, true);
}

// Custom Image Sizes
add_action('after_setup_theme', 'rillatype_image_sizes');
function rillatype_image_sizes() {
  add_image_size('rillatype-hero', 1400, 800, true);
  add_image_size('rillatype-font-preview', 600, 400, true);
  add_image_size('rillatype-square', 600, 600, true);
}
