<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_action( 'admin_notices', 'larisdigital_acf_pro_notices', 2 );
function larisdigital_acf_pro_notices() {
	if ( class_exists( 'ACF' ) && ! ( defined('ACF_PRO') && ACF_PRO ) ) {
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
		echo '<a href="'.admin_url('plugins.php?s=advanced-custom-fields&plugin_status=active').'" class="button button-primary">'.esc_html__( 'Deactivate ACF', 'larisdigital-wp' ).'</a>';
		echo '</div>';
		echo '<strong>'.esc_html__( 'Anda sedang menggunakan plugin Advanced Custom Fields', 'larisdigital-wp' ).'</strong> <br/>'.esc_html__( 'Silahkan deactivate plugin Advanced Custom Fields karena theme ini sudah menggunakan Advance Custom Fields Pro.', 'larisdigital-wp' );
		echo '</div></div>';
	}
}

if ( class_exists( 'ACF' ) ) {
	return;
}

add_filter('acf/settings/path', 'larisdigital_acf_pro_settings_path');
function larisdigital_acf_pro_settings_path( $path ) {
	$path = get_template_directory() . '/includes/acf-pro/';
	return $path;
}

add_filter('acf/settings/dir', 'larisdigital_acf_pro_settings_dir');
function larisdigital_acf_pro_settings_dir( $dir ) {
	$dir = get_template_directory_uri() . '/includes/acf-pro/';
	return $dir;
}

// add_filter('acf/settings/show_admin', '__return_false');

include_once( get_template_directory() . '/includes/acf-pro/acf.php' );
