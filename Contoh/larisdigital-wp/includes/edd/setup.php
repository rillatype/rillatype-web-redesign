<?php
/**
 * EDD - Setup
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists('Easy_Digital_Downloads') ) {
	return;
}

/**
 * Setup WordPress Features
 */
add_action( 'after_setup_theme', 'larisdigital_edd_shop_setup_theme' );
function larisdigital_edd_shop_setup_theme() {
	if ( function_exists( 'add_theme_support' ) ) {
		$shop_thumbnail_width  = apply_filters( 'larisdigital_shop_thumbnail_image_width', 350 );
		$shop_thumbnail_height = apply_filters( 'larisdigital_shop_thumbnail_image_height', 233 );
		$shop_thumbnail_crop   = apply_filters( 'larisdigital_shop_thumbnail_image_crop', true );
		add_image_size( 'shop_thumbnail', $shop_thumbnail_width, $shop_thumbnail_height, $shop_thumbnail_crop );

		$shop_single_width  = apply_filters( 'larisdigital_shop_single_image_width', 750 );
		$shop_single_height = apply_filters( 'larisdigital_shop_single_image_height', 0 );
		$shop_single_crop   = apply_filters( 'larisdigital_shop_single_image_crop', false );
		add_image_size( 'shop_single', $shop_single_width, $shop_single_height, $shop_single_crop );
	}
}

/**
 * Register widgetized area
 */
add_action( 'widgets_init', 'larisdigital_edd_widgets_init' );
function larisdigital_edd_widgets_init() {

	register_sidebar( array(
		'name'          => esc_html__( 'Downloads Page', 'larisdigital-wp' ),
		'description'   => sprintf( esc_html__( 'This widget area will be displayed on %s when it is available on current layout.', 'larisdigital-wp' ), esc_html__( 'Downloads Page', 'larisdigital-wp' ) ),
		'id'            => 'sidebar-shop',
		'before_widget' => '<aside id="%1$s" class="sidebar-widget widget %2$s card"><div class="card-body">',
		'after_widget'  => '</div></aside>',
		'before_title'  => '<h4 class="widget-title card-header">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Single Download', 'larisdigital-wp' ),
		'description'   => sprintf( esc_html__( 'This widget area will be displayed on %s when it is available on current layout.', 'larisdigital-wp' ), esc_html__( 'Single Download', 'larisdigital-wp' ) ),
		'id'            => 'sidebar-product',
		'before_widget' => '<aside id="%1$s" class="sidebar-widget widget %2$s card"><div class="card-body">',
		'after_widget'  => '</div></aside>',
		'before_title'  => '<h4 class="widget-title card-header">',
		'after_title'   => '</h4>',
	) );

}
