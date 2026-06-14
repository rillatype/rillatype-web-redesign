<?php
/**
 * Theme Recommended & Required Plugins
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_action( 'tgmpa_register', 'larisdigital_tgmpa_register_plugins' );
function larisdigital_tgmpa_register_plugins() {

	$plugins = array();

	$integration = get_option( 'tokopress_integration' );

	if ( $integration == 'woocommerce' ) {
		$plugins[] = array(
			'name'		=> '1. WooCommerce',
			'slug'		=> 'woocommerce',
			'required'	=> true,
		);
		$plugins[] = array(
			'name'		=> '2. Classic Editor (Opsional)',
			'slug'		=> 'classic-editor',
			'required'	=> false,
		);
	}
	elseif ( $integration == 'edd' ) {
		$plugins[] = array(
			'name'		=> '1. Easy Digital Downloads (EDD)',
			'slug'		=> 'easy-digital-downloads',
			'required'	=> true,
		);
		$plugins[] = array(
			'name'		=> '2. Classic Editor (Opsional)',
			'slug'		=> 'classic-editor',
			'required'	=> false,
		);
	}
	else {
		$plugins[] = array(
			'name'		=> '1. Classic Editor (Opsional)',
			'slug'		=> 'classic-editor',
			'required'	=> false,
		);
	}

	$config = array(
		'id'           => 'larisdigital-tgmpa',
		'default_path' => '',
		'menu'         => 'larisdigital-install-plugins',
		'parent_slug'  => 'themes.php',
		'capability'   => 'edit_theme_options',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => true,
		'message'      => '',
	);

	tgmpa( $plugins, $config );

}
