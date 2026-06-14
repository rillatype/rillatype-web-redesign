<?php 
/**
 * Shop Filters, frontend only
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( !defined( 'SEJOLISA_VERSION') ) {
	return;
}

add_action( 'wp', 'larisdigital_sejoli_wp' );
function larisdigital_sejoli_wp() {
	if ( !sejoli_is_a_member_page() && !is_page_template('sejoli-member-page.php') ) {
		return;
	}
	remove_action( 'wp_enqueue_scripts', 'larisdigital_enqueue_styles', 5 );
	remove_action( 'wp_enqueue_scripts', 'larisdigital_enqueue_style_parent_theme', 15 );
	remove_action( 'wp_enqueue_scripts', 'larisdigital_enqueue_style_child_theme', 17 );
	remove_action( 'wp_enqueue_scripts', 'larisdigital_enqueue_scripts' );
	remove_action( 'wp_head', 'larisdigital_output_style', 25 );
	remove_action( 'wp_footer', 'larisdigital_output_script', 99 );
	remove_action( 'wp_footer', 'larisdigital_load_template_backtotop', 99 );

	add_filter( 'larisdigital_topbar_is_active', '__return_false', 999 );
	add_filter( 'larisdigital_navigation_is_active', '__return_false', 999 );
	add_filter( 'larisdigital_navigation_menu_is_active', '__return_false', 999 );
	add_filter( 'larisdigital_header_is_active', '__return_false', 999 );
	add_filter( 'larisdigital_footer_widgets_is_active', '__return_false', 999 );
	add_filter( 'larisdigital_footer_is_active', '__return_false', 999 );

	if ( function_exists('_admin_bar_bump_cb') ) {
		add_action( 'wp_head', '_admin_bar_bump_cb' );
	}
}

add_action( 'wp_head', 'larisdigital_sejoli_member_area_header', 999 );
function larisdigital_sejoli_member_area_header() {
	echo '<style>#wp-admin-bar-sejoli-member-area { display: block !important; } #wp-admin-bar-sejoli-member-area a { padding-left: 15px !important; padding-right: 15px !important; }</style>';
	// echo '<style>.admin-bar.sejoli-member-page { margin-top: 32px; }</style>';
}
