<?php
/**
 * WooCommerce Setup
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'woocommerce' ) ) {
	return;
}

add_action( 'after_setup_theme', 'larisdigital_wc_setup_theme' );
function larisdigital_wc_setup_theme() {

	/**
	 * Declare WooCommerce Support
	 */
	add_theme_support( 'woocommerce' );

	/**
	 * Product Gallery Zoom
	 */
	if ( larisdigital_theme_mod('larisdigital_wc_product_gallery_zoom_disable') || function_exists('wpb_wiz_adding_scripts') ) {
		remove_theme_support( 'wc-product-gallery-zoom' );
	}
	else {
		add_theme_support( 'wc-product-gallery-zoom' );
	}

	/**
	 * Product Gallery LightBox
	 */
	if ( larisdigital_theme_mod('larisdigital_wc_product_gallery_lightbox_disable') ) {
		remove_theme_support( 'wc-product-gallery-lightbox' );
	}
	else {
		add_theme_support( 'wc-product-gallery-lightbox' );
	}

	/**
	 * Product Gallery Slider
	 */
	if ( larisdigital_theme_mod('larisdigital_wc_product_gallery_slider_disable') ) {
		remove_theme_support( 'wc-product-gallery-slider' );
	}
	else {
		add_theme_support( 'wc-product-gallery-slider' );
	}

	/* Product Image - Full Style */
	if ( larisdigital_theme_mod( 'larisdigital_wc_product_image_style' ) == 'full' ) {
		remove_theme_support( 'wc-product-gallery-zoom' );	
		remove_theme_support( 'wc-product-gallery-slider' );
	}

}

/**
 * Register widgetized area
 */
add_action( 'widgets_init', 'larisdigital_wc_widgets_init' );
function larisdigital_wc_widgets_init() {

	register_sidebar( array(
		'name'          => esc_html__( 'Shop Page', 'larisdigital-wp' ),
		'description'   => sprintf( esc_html__( 'This widget area will be displayed on %s when it is available on current layout.', 'larisdigital-wp' ), esc_html__( 'Shop Page', 'larisdigital-wp' ) ),
		'id'            => 'sidebar-shop',
		'before_widget' => '<aside id="%1$s" class="sidebar-widget widget %2$s card"><div class="card-body">',
		'after_widget'  => '</div></aside>',
		'before_title'  => '<h4 class="widget-title card-header">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Single Product', 'larisdigital-wp' ),
		'description'   => sprintf( esc_html__( 'This widget area will be displayed on %s when it is available on current layout.', 'larisdigital-wp' ), esc_html__( 'Single Product', 'larisdigital-wp' ) ),
		'id'            => 'sidebar-product',
		'before_widget' => '<aside id="%1$s" class="sidebar-widget widget %2$s card"><div class="card-body">',
		'after_widget'  => '</div></aside>',
		'before_title'  => '<h4 class="widget-title card-header">',
		'after_title'   => '</h4>',
	) );

}

/**
 * Enqueue styles
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
add_action( 'wp_enqueue_scripts', 'larisdigital_wc_enqueue_styles', 5 );
function larisdigital_wc_enqueue_styles() {
	wp_enqueue_style( 'woocommerce', get_template_directory_uri() . '/assets/css/woocommerce.min.css', array(), LARISDIGITAL_THEME_VERSION );
}
