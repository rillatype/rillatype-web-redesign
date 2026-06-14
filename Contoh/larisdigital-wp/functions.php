<?php
/**
 * Theme functions and definitions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

define( 'LARISDIGITAL_THEME_NAME', 'LarisDigital WooCommerce WordPress Theme' );
define( 'LARISDIGITAL_THEME_VERSION', '1.9.1' );
define( 'LARISDIGITAL_THEME_SLUG', 'larisdigital-wp' );

define( 'LARISDIGITAL_THEME_URL', get_template_directory_uri() );
define( 'LARISDIGITAL_THEME_PATH', get_template_directory() );

define( 'LARISDIGITAL_PHP_VERSION', '7.0' );
define( 'LARISDIGITAL_BOOTSTRAP_VERSION', '4.3.1' );
define( 'LARISDIGITAL_FONTAWESOME_VERSION', '4.7.0' );

define( 'LARISDIGITAL_CUSTOMIZER_DEBUG', false );

define( 'LARISDIGITAL_API_URL', 'https://www.tokopress.id/' );
define( 'LARISDIGITAL_API_ID', '' );

define( 'LARISDIGITAL_SUPPORT_URL', 'https://tokopress.id/support/' );
define( 'LARISDIGITAL_DOCS_URL', 'https://help.tokopress.id/' );

define( 'TOKOPRESSID_WORDPRESS_THEME', true );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
global $content_width;
if ( ! isset( $content_width ) ) {
	$content_width = apply_filters( "larisdigital_content_width", 728 ); /* pixels */
}

/**
 * Set default setting value.
 */
global $larisdigital_defaults;
$larisdigital_defaults = apply_filters( 'larisdigital_defaults', 
	array( 

	/* Typography */

		'larisdigital_body_font' => 'Open Sans (sans-serif)',
		/* ex: Roboto (sans-serif) */

		'larisdigital_heading_font' => 'Hind Guntur (sans-serif)', 
		/* ex: Roboto (sans-serif) */

	/* General */ 

		'larisdigital_pagination_alignment' => 'center', 
		/* left / center / right */

	/* Site Top Bar */

		'larisdigital_topbar_hide' => '', 
		/* empty value / 1 */

		'larisdigital_topbar_layout' => 'right-left', 
		/* right-left / left-right / center / center-flip */

		'larisdigital_topbar_menu_hide' => '', 
		/* empty value / 1 */

		'larisdigital_topbar_text' => '', 
		/* empty value / default text */

		'larisdigital_topbar_text_hide' => '', 
		/* empty value / 1 */

	/* Site Navigation */

		'larisdigital_navigation_hide' => '', 
		/* empty value / 1 */

		'larisdigital_navigation_absolute' => '1', 
		/* empty value / 1 */

		'larisdigital_navigation_scheme' => 'light', 
		/* dark / light */

		'larisdigital_navigation_sticky' => 'yes', 
		/* yes / no */

		'larisdigital_navigation_brand_type' => 'image-text', 
		/* text / image / image-text */

		'larisdigital_navigation_brand_text' => '', 
		/* empty value / default text */

		'larisdigital_navigation_menu_alignment' => 'center', 
		/* left / center / right */

		'larisdigital_navigation_quicknav_search' => '1',
		/* empty value / 1 */

	/* Site Header */

		'larisdigital_header_hide' => '', 
		/* empty value / 1 */

		'larisdigital_header_alignment' => 'center', 
		/* empty value / left / center / right */

	/* Site Breadcrumb */

		'larisdigital_breadcrumb_hide' => '1', 
		/* empty value / 1 */

		'larisdigital_breadcrumb_alignment' => '', 
		/* empty value / left / center / right */

	/* Sidebar */

		'larisdigital_sidebar_layout' => 'right', 
		/* right / left / none */

		'larisdigital_sidebar_width' => '', 
		/* empty value / 3 - 6 */

		'larisdigital_content_width' => '', 
		/* empty value / 6 - 12, when sidebar is disabled */

	/* Comments */

		'larisdigital_comments_textarea_reverse' => '', 
		/* empty value / 1 */

		'larisdigital_comments_url_hide' => '', 
		/* empty value / 1 */

	/* Template - Blog Page */

		'larisdigital_homepage_breadcrumb_hide' => '',
		/* empty value / 1 */

		'larisdigital_blog_layout' => 'excerpt-image', 
		/* excerpt-image / excerpt / content-image / content */

		'larisdigital_blog_title4header' => '1', 
		/* empty value / 1 */

		'larisdigital_blog_sidebar_layout' => 'none', 
		/* empty value / right / left / none */

		'larisdigital_blog_sidebar_width' => '', 
		/* empty value / 3 - 6 */

		'larisdigital_blog_content_width' => '', 
		/* empty value / 6 - 12, when sidebar is disabled */

		'larisdigital_blog_more_link' => '1', 
		/* empty value / 1 */

		'larisdigital_blog_meta' => '1', 
		/* empty value / 1 */

		'larisdigital_blog_meta_position' => 'bottom', 
		/* top / bottom */

		'larisdigital_blog_meta_items' => array( 'sticky', 'date', 'categories' ), 
		/* array( 'sticky', 'date', 'categories' ) */

	/* Template - Single Post */

		'larisdigital_post_featured4header' => '',
		/* empty value / 1 */

		'larisdigital_post_title4header' => '1', 
		/* empty value / 1 */

		'larisdigital_post_sidebar_layout' => 'none', 
		/* empty value / right / left / none */

		'larisdigital_post_sidebar_width' => '', 
		/* empty value / 3 - 6 */

		'larisdigital_post_content_width' => '', 
		/* empty value / 6 - 12, when sidebar is disabled */

		'larisdigital_post_image' => '1',
		/* empty value / 1 */

		'larisdigital_post_meta' => '1', 
		/* empty value / 1 */

		'larisdigital_post_meta_position' => 'bottom', 
		/* top / bottom */

		'larisdigital_post_meta_items' => array( 'sticky', 'date', 'categories' ), 
		/* array( 'sticky', 'date', 'categories' ) */

		'larisdigital_post_share' => '1', 
		/* empty value / 1 */

		'larisdigital_post_share_items' => array( 'facebook', 'twitter', 'linkedin', 'pinterest', 'whatsapp', 'telegram' ), 
		/* array( 'facebook', 'twitter', 'google-plus', 'linkedin', 'pinterest', 'whatsapp', 'telegram' ) */

		'larisdigital_post_comments' => '1', 
		/* empty value / 1 */

	/* Template - Single Page */

		'larisdigital_page_featured4header' => '',
		/* empty value / 1 */

		'larisdigital_page_title4header' => '1', 
		/* empty value / 1 */

		'larisdigital_page_sidebar_layout' => 'none', 
		/* empty value / right / left / none */

		'larisdigital_page_sidebar_width' => '', 
		/* empty value / 3 - 6 */

		'larisdigital_page_content_width' => '', 
		/* empty value / 6 - 12, when sidebar is disabled */

		'larisdigital_page_image' => '',
		/* empty value / 1 */

		'larisdigital_page_comments' => '', 
		/* empty value / 1 */

	/* Template - Media Page */

		'larisdigital_attachment_title4header' => '1', 
		/* empty value / 1 */

		'larisdigital_attachment_sidebar_layout' => '', 
		/* empty value / right / left / none */

		'larisdigital_attachment_sidebar_width' => '', 
		/* empty value / 3 - 6 */

		'larisdigital_attachment_content_width' => '', 
		/* empty value / 6 - 12, when sidebar is disabled */

	/* Site Footer Widgets */

		'larisdigital_footer_widgets_hide' => '',
		/* empty value / 1 */

	/* Site Footer */

		'larisdigital_footer_hide' => '',
		/* empty value / 1 */

		'larisdigital_footer_layout' => 'center',
		/* center / left / right / left-right / right-left */

		'larisdigital_footer_menu_hide' => '', 
		/* empty value / 1 */

		'larisdigital_footer_text' => '', 
		/* empty value / default text */

		'larisdigital_footer_text_hide' => '', 
		/* empty value / 1 */

	/* Site Back To Top */

		'larisdigital_backtotop_hide' => '',
		/* empty value / 1 */

	/* WooCommerce */

		'larisdigital_navigation_quicknav_minicart' => '1', 
		/* empty value / 1 */

		'larisdigital_navigation_quicknav_minicart_count' => '1',
		/* empty value / 1 */

		'larisdigital_navigation_quicknav_minicart_dropdown' => '1',
		/* empty value / 1 */

		'larisdigital_wc_variable_price' => 'low',
		/* empty value / low */

	/* WooCommerce - Shop Page */

		'larisdigital_wc_shop_title4header' => '1',
		/* empty value / 1 */

		'larisdigital_wc_shop_sidebar_layout' => 'none', 
		/* empty value / right / left / none */

		'larisdigital_wc_shop_sidebar_width' => '', 
		/* empty value / 3 - 6 */

		'larisdigital_wc_shop_content_width' => '12', 
		/* empty value / 6 - 12, when sidebar is disabled */

		'larisdigital_wc_shop_columns' => '3', 
		/* 1 - 4 */

		'larisdigital_wc_shop_per_page' => '12',
		/* number */

		'larisdigital_wc_shop_rating_disable' => '1',
		/* empty value / 1 */

		'larisdigital_wc_shop_button_disable' => '1',
		/* empty value / 1 */

		'larisdigital_wc_shop_product_alignment' => 'left', 
		/* left / center / right */

		'larisdigital_wc_shop_result_count_disable' => '1',
		/* empty value / 1 */

		'larisdigital_wc_shop_catalog_ordering_disable' => '1',
		/* empty value / 1 */

		'larisdigital_wc_shop_image_price' => '1',
		/* empty value / 1 */

		'larisdigital_wc_shop_title_truncate' => '1',
		/* empty value / 1 */

		'larisdigital_wc_shop_price' => 'right',
		/* empty value / image / right / disable */

	/* WooCommerce - Single Product */

		'larisdigital_wc_product_title4header' => '1', 
		/* empty value / 1 */

		'larisdigital_wc_product_sidebar_layout' => 'none', 
		/* empty value / right / left / none */

		'larisdigital_wc_product_sidebar_width' => '3', 
		/* empty value / 3 - 6 */

		'larisdigital_wc_product_content_width' => '12', 
		/* empty value / 6 - 12, when sidebar is disabled */

		'larisdigital_wc_product_share' => '1', 
		/* empty value / 1 */

		'larisdigital_wc_product_share_items' => array( 'facebook', 'twitter', 'linkedin', 'pinterest', 'whatsapp', 'telegram' ), 
		/* array( 'facebook', 'twitter', 'google-plus', 'linkedin', 'pinterest', 'whatsapp', 'telegram' ) */

		'larisdigital_wc_product_quantity_disable' => '1',

		'larisdigital_wc_product_button_style' => 'fullwidth',

		'wc_product_whatsapp_style' => 'fullwidth',

	/* WooCommerce - Checkout */

		'larisdigital_wc_checkout_layout' => 'custom',

	/* LarisDigital - EDD Shop Page */

		'larisdigital_edd_shop_title4header' => '1',
		/* empty value / 1 */

		'larisdigital_edd_shop_sidebar_layout' => 'none', 
		/* empty value / right / left / none */

		'larisdigital_edd_shop_sidebar_width' => '', 
		/* empty value / 3 - 6 */

		'larisdigital_edd_shop_content_width' => '12', 
		/* empty value / 6 - 12, when sidebar is disabled */

		'larisdigital_edd_shop_columns' => '3', 
		/* 1 - 4 */

		'larisdigital_edd_shop_per_page' => '12',
		/* number */

		'larisdigital_edd_shop_rating_disable' => '1',
		/* empty value / 1 */

		'larisdigital_edd_shop_button_disable' => '1',
		/* empty value / 1 */

		'larisdigital_edd_shop_product_alignment' => 'left', 
		/* left / center / right */

		'larisdigital_edd_shop_result_count_disable' => '1',
		/* empty value / 1 */

		'larisdigital_edd_shop_catalog_ordering_disable' => '1',
		/* empty value / 1 */

		'larisdigital_edd_shop_image_price' => '1',
		/* empty value / 1 */

		'larisdigital_edd_shop_title_truncate' => '1',
		/* empty value / 1 */

		'larisdigital_edd_shop_price' => 'right',
		/* empty value / image / right / disable */

	/* LarisDigital - EDD Single Product */

		'larisdigital_edd_product_title4header' => '1', 
		/* empty value / 1 */

		'larisdigital_edd_product_sidebar_layout' => 'none', 
		/* empty value / right / left / none */

		'larisdigital_edd_product_sidebar_width' => '3', 
		/* empty value / 3 - 6 */

		'larisdigital_edd_product_content_width' => '12', 
		/* empty value / 6 - 12, when sidebar is disabled */

		'larisdigital_edd_product_share' => '1', 
		/* empty value / 1 */

		'larisdigital_edd_product_share_items' => array( 'facebook', 'twitter', 'linkedin', 'pinterest', 'whatsapp', 'telegram' ), 
		/* array( 'facebook', 'twitter', 'google-plus', 'linkedin', 'pinterest', 'whatsapp', 'telegram' ) */

		'larisdigital_edd_product_quantity_disable' => '1',

		'larisdigital_edd_product_button_style' => 'fullwidth',

	/* LarisDigital - Shop Page */

		'larisdigital_store_shop_title4header' => '1',
		/* empty value / 1 */

		'larisdigital_store_shop_sidebar_layout' => 'none', 
		/* empty value / right / left / none */

		'larisdigital_store_shop_sidebar_width' => '', 
		/* empty value / 3 - 6 */

		'larisdigital_store_shop_content_width' => '12', 
		/* empty value / 6 - 12, when sidebar is disabled */

		'larisdigital_store_shop_columns' => '3', 
		/* 1 - 4 */

		'larisdigital_store_shop_per_page' => '12',
		/* number */

		'larisdigital_store_shop_rating_disable' => '1',
		/* empty value / 1 */

		'larisdigital_store_shop_button_disable' => '1',
		/* empty value / 1 */

		'larisdigital_store_shop_product_alignment' => 'left', 
		/* left / center / right */

		'larisdigital_store_shop_result_count_disable' => '1',
		/* empty value / 1 */

		'larisdigital_store_shop_catalog_ordering_disable' => '1',
		/* empty value / 1 */

		'larisdigital_store_shop_image_price' => '1',
		/* empty value / 1 */

		'larisdigital_store_shop_title_truncate' => '1',
		/* empty value / 1 */

		'larisdigital_store_shop_price' => '',
		/* empty value / image / right / disable */

	/* LarisDigital - Single Product */

		'larisdigital_store_product_title4header' => '1', 
		/* empty value / 1 */

		'larisdigital_store_product_sidebar_layout' => 'none', 
		/* empty value / right / left / none */

		'larisdigital_store_product_sidebar_width' => '3', 
		/* empty value / 3 - 6 */

		'larisdigital_store_product_content_width' => '12', 
		/* empty value / 6 - 12, when sidebar is disabled */

		'larisdigital_store_product_share' => '1', 
		/* empty value / 1 */

		'larisdigital_store_product_share_items' => array( 'facebook', 'twitter', 'linkedin', 'pinterest', 'whatsapp', 'telegram' ), 
		/* array( 'facebook', 'twitter', 'google-plus', 'linkedin', 'pinterest', 'whatsapp', 'telegram' ) */

		'larisdigital_store_product_quantity_disable' => '1',

		'larisdigital_store_product_button_style' => 'fullwidth',

	/* LarisDigital - Courses Page */

		'larisdigital_tutor_archive_title4header' => '1',
		/* empty value / 1 */

		'larisdigital_tutor_archive_sidebar_layout' => 'none', 
		/* empty value / right / left / none */

		'larisdigital_tutor_archive_sidebar_width' => '', 
		/* empty value / 3 - 6 */

		'larisdigital_tutor_archive_content_width' => '12', 
		/* empty value / 6 - 12, when sidebar is disabled */

	/* LarisDigital - Single Course */

		'larisdigital_tutor_course_title4header' => '1', 
		/* empty value / 1 */

		'larisdigital_tutor_course_sidebar_layout' => 'none', 
		/* empty value / right / left / none */

		'larisdigital_tutor_course_sidebar_width' => '3', 
		/* empty value / 3 - 6 */

		'larisdigital_tutor_course_content_width' => '12', 
		/* empty value / 6 - 12, when sidebar is disabled */

	)
);

/**
 * Get theme mod with default setting value support.
 */
function larisdigital_theme_mod( $option ) {
	global $larisdigital_defaults;
	$default = isset( $larisdigital_defaults[ $option ] ) ? $larisdigital_defaults[ $option ] : '';
	return get_theme_mod( $option, $default );
}

add_action( 'admin_notices', 'larisdigital_fail_php_version', 1 );
function larisdigital_fail_php_version() {
	if ( version_compare( PHP_VERSION, LARISDIGITAL_PHP_VERSION, '>=' ) ) {
		return;
	}
	$message = esc_html__( 'PENTING! LarisDigital dan WooCommerce membutuhkan PHP dengan minimum versi 7.0 ke atas. Silahkan naikkan versi PHP di server/hosting Anda untuk dapat menggunakan LarisDigital dan WooCommerce dengan baik.', 'larisdigital-wp' );
	$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
	echo wp_kses_post( $html_message );
}

add_action( 'admin_notices', 'larisdigital_theme_activation_notices', 1 );
function larisdigital_theme_activation_notices() {
	if ( ! version_compare( PHP_VERSION, LARISDIGITAL_PHP_VERSION, '>=' ) ) {
		return;
	}
	$screen = get_current_screen();
	if ( 'appearance_page_larisdigital-wp-license' == $screen->id ) {
		return;
	}
	if ( 'valid' != get_option( LARISDIGITAL_THEME_SLUG . '_license_key_status', false) ) {
		echo '<style>';
		echo '.larisdigital-message {padding: 20px !important;}';
		echo '.larisdigital-message-inner {overflow:hidden;}';
		echo '.larisdigital-message-icon {float:left;width:35px;height:35px;padding-right:20px;}';
		echo '.larisdigital-message-button {float:right;padding:3px 0 0 20px;}';
		echo '</style>';
		echo '<div class="error larisdigital-message"><div class="larisdigital-message-inner">';
		echo '<div class="larisdigital-message-icon">';
		echo '<img src="'.get_template_directory_uri().'/assets/img/tokopress.png" width="35" height="35" alt=""/>';
		echo '</div>';
		echo '<div class="larisdigital-message-button">';
		echo '<a href="'.admin_url('themes.php?page=larisdigital-wp-license').'" class="button button-primary">'.esc_html__( 'Aktivasi Theme', 'larisdigital-wp' ).'</a>';
		echo '</div>';
		echo '<strong>'.sprintf( esc_html__( 'Selamat Datang di %s.', 'larisdigital-wp' ), LARISDIGITAL_THEME_NAME ).'</strong> <br/>'.esc_html__( 'Silahkan aktifkan theme ini untuk mendapatkan semua fitur theme dan update otomatis.', 'larisdigital-wp' );
		echo '</div></div>';
	}
}

add_action( 'admin_init', 'larisdigital_activate_existing_child_theme', 30 );
function larisdigital_activate_existing_child_theme() {
	if ( is_child_theme() ) {
		return;
	}
	$slug = LARISDIGITAL_THEME_SLUG . '-child';
	$path = get_theme_root() . '/' . $slug;
	if ( file_exists( $path ) ) {
		switch_theme( $slug );
	}
}

add_action( 'admin_notices', 'larisdigital_theme_child_notices', 2 );
function larisdigital_theme_child_notices() {
	if ( ! version_compare( PHP_VERSION, LARISDIGITAL_PHP_VERSION, '>=' ) ) {
		return;
	}
	if ( is_child_theme() ) {
		return;
	}
	$slug = LARISDIGITAL_THEME_SLUG . '-child';
	$path = get_theme_root() . '/' . $slug;
	if ( file_exists( $path ) ) {
		return;
	}
	echo '<style>';
	echo '.larisdigital-message {padding: 20px !important;}';
	echo '.larisdigital-message-inner {overflow:hidden;}';
	echo '.larisdigital-message-icon {float:left;width:35px;height:35px;padding-right:20px;}';
	echo '.larisdigital-message-button {float:right;padding:3px 0 0 20px;}';
	echo '</style>';
	echo '<div class="error larisdigital-message"><div class="larisdigital-message-inner">';
	echo '<div class="larisdigital-message-icon">';
	echo '<img src="'.get_template_directory_uri().'/assets/img/tokopress.png" width="35" height="35" alt=""/>';
	echo '</div>';
	echo '<div class="larisdigital-message-button">';
	echo '<a href="'.admin_url('themes.php?page=theme-setup').'" class="button button-primary">'.esc_html__( 'Install Child Theme', 'larisdigital-wp' ).'</a>';
	echo '</div>';
	echo '<strong>'.esc_html__( 'Anda belum menggunakan Child Theme!', 'larisdigital-wp' ).'</strong> <br/>'.esc_html__( 'Silahkan install dan aktifkan Child Theme untuk mempermudah update theme otomatis ke depannya.', 'larisdigital-wp' );
	echo '</div></div>';
}

/**
 * Core Customizer
 */
add_action( 'customize_register', 'larisdigital_customize_controls_register', 5 );
function larisdigital_customize_controls_register( $wp_customize ){
	require_once( get_template_directory() . '/includes/core/customize-controls.php' );
}
include_once( get_template_directory() . '/includes/core/customize.php' );

/**
 * Core Metabox
 */
include_once( get_template_directory() . '/includes/core/metabox.php' );

/**
 * Core Nav Walker, frontend only.
 */
include_once( get_template_directory() . '/includes/core/navwalker.php' );

/**
 * Core Breadcrumb, frontend only.
 */
include_once( get_template_directory() . '/includes/core/breadcrumb.php' );

if ( version_compare( PHP_VERSION, LARISDIGITAL_PHP_VERSION, '>=' ) ) {
	/**
	 * Core TGM Plugin Activation
	 */
	include_once( get_template_directory() . '/includes/core/class-tgm-plugin-activation.php' );

	/**
	 * Merlin Setup Wizard
	 */
	require_once get_parent_theme_file_path( '/includes/merlin/vendor/autoload.php' );
	require_once get_parent_theme_file_path( '/includes/merlin/class-merlin.php' );
	require_once get_parent_theme_file_path( '/includes/merlin/merlin-config.php' );

	/**
	 * Theme Updater
	 */
	include_once( get_template_directory() . '/includes/updater/theme-updater.php' );
}

/**
 * Theme Setup
 */
include_once( get_template_directory() . '/includes/theme/setup.php' );

/**
 * Theme Customizer
 */
if ( 'valid' == get_option( LARISDIGITAL_THEME_SLUG . '_license_key_status', false) ) {
	include_once( get_template_directory() . '/includes/theme/customize.php' );
}

/**
 * Theme Functions
 */
include_once( get_template_directory() . '/includes/theme/functions.php' );

/**
 * Theme Admin Features
 */
include_once( get_template_directory() . '/includes/theme/admin.php' );

/**
 * Theme Frontend Features
 */
include_once( get_template_directory() . '/includes/theme/frontend.php' );

/**
 * Theme Frontend Filters
 */
include_once( get_template_directory() . '/includes/theme/frontend-filters.php' );

/**
 * Theme Plugins
 */
include_once( get_template_directory() . '/includes/theme/plugins.php' );

/**
 * WooCommerce
 */
if ( class_exists( 'woocommerce' ) ) {

	/**
	 * WooCommerce Setup
	 */
	include_once( get_template_directory() . '/includes/woocommerce/setup.php' );

	/**
	 * WooCommerce Customizer
	 */
	if ( 'valid' == get_option( LARISDIGITAL_THEME_SLUG . '_license_key_status', false) ) {
		include_once( get_template_directory() . '/includes/woocommerce/customize.php' );
	}

	/**
	 * WooCommerce Functions
	 */
	include_once( get_template_directory() . '/includes/woocommerce/functions.php' );

	/**
	 * WooCommerce Admin Features
	 */
	include_once( get_template_directory() . '/includes/woocommerce/admin.php' );

	/**
	 * WooCommerce Frontend Features
	 */
	include_once( get_template_directory() . '/includes/woocommerce/frontend.php' );

	/**
	 * WooCommerce Frontend Filters
	 */
	include_once( get_template_directory() . '/includes/woocommerce/frontend-filters.php' );

}

if ( 'valid' == get_option( LARISDIGITAL_THEME_SLUG . '_license_key_status', false) ) {
	/**
	 * Addon - Optimizations
	 */
	include_once( get_template_directory() . '/includes/addons/optimizations.php' );

	/**
	 * Addon - Optimizations For WooCommerce
	 */
	include_once( get_template_directory() . '/includes/addons/wc-optimizations.php' );

	/**
	 * Addon - Optimizations - CSS&JS Combine
	 */
	include_once( get_template_directory() . '/includes/addons/enqueue-combine.php' );

	/**
	 * Addon - Image Sizes
	 */
	include_once( get_template_directory() . '/includes/addons/image-sizes.php' );

	/**
	 * Addon - ACF Pro
	 */
	include_once( get_template_directory() . '/includes/addons/acf-pro.php' );

	/**
	 * Addon - Page Header
	 */
	include_once( get_template_directory() . '/includes/addons/pageheader.php' );

	/**
	 * Addon - Page Header Image
	 */
	include_once( get_template_directory() . '/includes/addons/pageheader-image.php' );

	/**
	 * Addon - Page Layout
	 */
	include_once( get_template_directory() . '/includes/addons/pagelayout.php' );

	/**
	 * Addon - Integrations
	 */
	include_once( get_template_directory() . '/includes/addons/integrations.php' );

	/**
	 * Addon - FB Pixels
	 */
	include_once( get_template_directory() . '/includes/addons/fbpixel.php' );

	if ( class_exists( 'woocommerce' ) ) {
		/**
		 * Addon - FB Pixels For WooCommerce
		 */
		include_once( get_template_directory() . '/includes/addons/wc-fbpixel.php' );
	}

	/**
	 * Addon - Google Adwords
	 */
	include_once( get_template_directory() . '/includes/addons/adwords.php' );

	if ( class_exists( 'woocommerce' ) ) {
		/**
		 * Addon - Google Adwords For WooCommerce
		 */
		include_once( get_template_directory() . '/includes/addons/wc-adwords.php' );
	}

	/**
	 * Addon - Open Graph (Facebook Sharing)
	 */
	include_once( get_template_directory() . '/includes/addons/open-graph.php' );

	/**
	 * Addon - OnPage SEO
	 */
	include_once( get_template_directory() . '/includes/addons/onpage-seo.php' );

	/**
	 * Addon - Custom Script
	 */
	include_once( get_template_directory() . '/includes/addons/custom-script.php' );

	/**
	 * Addon - Font Preview 
	 */
	include_once( get_template_directory() . '/includes/addons/font-preview.php' );

	if ( class_exists( 'woocommerce' ) ) {
		/**
		 * Addon - WooCommerce Additional Details 
		 */
		include_once( get_template_directory() . '/includes/addons/wc-additional-details.php' );

		/**
		 * Addon - WooCommerce Additional Details 
		 */
		include_once( get_template_directory() . '/includes/addons/wc-digital-checkout.php' );

		/**
		 * Addon - WooCommerce Sticky Button 
		 */
		include_once( get_template_directory() . '/includes/addons/wc-button-sticky.php' );

		/**
		 * Addon - WooCommerce - Cart Popup
		 */
		include_once( get_template_directory() . '/includes/addons/wc-cart-popup.php' );

		$currency = get_woocommerce_currency();
		if ( $currency === 'IDR' ) {

			/**
			 * Addon - WhatsApp Button
			 */
			include_once( get_template_directory() . '/includes/addons/whatsapp.php' );

			/**
			 * Addon - WooCommerce - BACS Gateway
			 */
			include_once( get_template_directory() . '/includes/addons/wc-bacs-gateway.php' );

			/**
			 * Addon - WooCommerce - Unique Code
			 */
			include_once( get_template_directory() . '/includes/addons/wc-unique-code.php' );

			/**
			 * Addon - WooCommerce - Orders
			 */
			include_once( get_template_directory() . '/includes/addons/wc-orders.php' );

			/**
			 * Addon - WooCommerce - Order Followup
			 */
			include_once( get_template_directory() . '/includes/addons/wc-orders-followup.php' );

			/**
			 * Addons - Indonesia
			 */
			include_once( get_template_directory() . '/includes/addons/indonesia.php' );

		}
	}

	if ( class_exists( 'Easy_Digital_Downloads' ) ) {
		/**
		 * EDD - Setup
		 */
		include_once( get_template_directory() . '/includes/edd/setup.php' );

		/**
		 * EDD - Customizer
		 */
		if ( 'valid' == get_option( LARISDIGITAL_THEME_SLUG . '_license_key_status', false) ) {
			include_once( get_template_directory() . '/includes/edd/customize.php' );
		}

		/**
		 * EDD - Functions
		 */
		include_once( get_template_directory() . '/includes/edd/functions.php' );

		/**
		 * EDD - Frontend Filters
		 */
		include_once( get_template_directory() . '/includes/edd/frontend-filters.php' );

		/**
		 * EDD - Frontend
		 */
		include_once( get_template_directory() . '/includes/edd/frontend.php' );
	}

	if ( defined( 'SEJOLISA_VERSION') ) {
		/**
		 * Sejoli - Frontend
		 */
		include_once( get_template_directory() . '/includes/sejoli/frontend.php' );
	}

	if ( defined( 'TUTOR_VERSION') ) {
		/**
		 * EDD - Customizer
		 */
		if ( 'valid' == get_option( LARISDIGITAL_THEME_SLUG . '_license_key_status', false) ) {
			if ( version_compare( TUTOR_VERSION, '2.0.0', '>=' ) )  {
				include_once( get_template_directory() . '/includes/tutor/customize.php' );
			}
			else {
				include_once( get_template_directory() . '/includes/tutor/tutor-v1/customize.php' );
			}
		}

		/**
		 * TutorLMS - Frontend Filters
		 */
		if ( version_compare( TUTOR_VERSION, '2.0.0', '>=' ) )  {
			include_once( get_template_directory() . '/includes/tutor/frontend-filters.php' );
		}
		else {
			include_once( get_template_directory() . '/includes/tutor/tutor-v1/frontend-filters.php' );
		}

		/**
		 * TutorLMS - Frontend
		 */
		if ( version_compare( TUTOR_VERSION, '2.0.0', '>=' ) )  {
			include_once( get_template_directory() . '/includes/tutor/frontend.php' );
		}
		else {
			include_once( get_template_directory() . '/includes/tutor/tutor-v1/frontend.php' );
		}

		if ( defined( 'SEJOLISA_VERSION') ) {
			/**
			 * TutorLMS - Sejoli
			 */
			if ( version_compare( TUTOR_VERSION, '2.0.0', '>=' ) )  {
				include_once( get_template_directory() . '/includes/tutor/sejoli.php' );
			}
			else {
				include_once( get_template_directory() . '/includes/tutor/tutor-v1/sejoli.php' );
			}
		}
	}

	if ( ! ( class_exists( 'woocommerce' ) || class_exists( 'Easy_Digital_Downloads' ) ) ) {
		/**
		 * LarisDigital Store - Setup
		 */
		include_once( get_template_directory() . '/includes/store/setup.php' );

		/**
		 * LarisDigital Store - Customizer
		 */
		if ( 'valid' == get_option( LARISDIGITAL_THEME_SLUG . '_license_key_status', false) ) {
			include_once( get_template_directory() . '/includes/store/customize.php' );
		}

		/**
		 * LarisDigital Store - Functions
		 */
		include_once( get_template_directory() . '/includes/store/functions.php' );

		/**
		 * LarisDigital Store - Frontend Filters
		 */
		include_once( get_template_directory() . '/includes/store/frontend-filters.php' );

		/**
		 * LarisDigital Store - Frontend
		 */
		include_once( get_template_directory() . '/includes/store/frontend.php' );
	}

	/**
	 * Elementor
	 */
	include_once( get_template_directory() . '/includes/elementor/elementor.php' );

	/**
	 * Elementor Kit
	 */
	include_once( get_template_directory() . '/includes/elementor-kit/elementor-kit.php' );
}