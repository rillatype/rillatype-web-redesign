<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'woocommerce' ) ) {
	return;
}

if ( !defined( 'LARISDIGITAL_INTEGRATIONS_WC_DB' ) ) {
	define( 'LARISDIGITAL_INTEGRATIONS_WC_DB', 'tokopress_integrations_wc' );
}

if ( ! function_exists('larisdigital_get_integration_wc') ) {
	function larisdigital_get_integration_wc( $name, $default = false ) {
		$options = get_option( LARISDIGITAL_INTEGRATIONS_WC_DB );
		if ( isset( $options[$name] ) ) {
			return $options[$name];
		}
		return $default;
	}
}

add_filter( 'larisdigital_customize_controls', 'larisdigital_wc_customize_controls_optimization' );
function larisdigital_wc_customize_controls_optimization( $controls ) {

	$controls['larisdigital_wc_section_optimization'] = array(
		'title'    => esc_html__( 'WC - Optimizations', 'larisdigital-wp' ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-danger larisdigital-alert-with-icon"><span class="dashicons dashicons-warning"></span>'.esc_html__( 'BE CAREFUL! These options are probably not compatible with other plugins.', 'larisdigital-wp' ).'</p>',
		'setting'  => 'larisdigital_wc_section_optimization',
		'panel'    => 'larisdigital_wc_panel_settings',
		'type'     => 'section',
		'priority' => 900,
	);

	$controls['larisdigital_wc_heading_optimization_cart_fragments'] = array(
		'label'		=> esc_html__( 'Cart Fragments', 'larisdigital-wp' ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-warning larisdigital-alert-with-icon"><span class="dashicons dashicons-warning"></span>'.esc_html__( 'You can improve page loading speed by disabling cart fragments. Please understand, shopping cart widget and mini cart do not work when cart fragments is disabled.', 'larisdigital-wp' ).'</p>',
		'setting'  	=> 'larisdigital_wc_heading_optimization_cart_fragments',
		'section'	=> 'larisdigital_wc_section_optimization',
		'type'   	=> 'heading',
	);

	$controls['wc_cart_fragments_disable'] = array(
		'label'    => esc_html__( 'Disable Cart Fragments', 'larisdigital-wp' ),
		'setting'  => 'wc_cart_fragments_disable',
		'setting_type' => 'option_mod',
		'setting_db' => LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section'  => 'larisdigital_wc_section_optimization',
		'type'     => 'checkbox',
	);

	return $controls;
}

add_action( 'wp_enqueue_scripts', 'larisdigital_wc_disable_cart_fragments_enqueue', 15 );
function larisdigital_wc_disable_cart_fragments_enqueue() {
	if ( larisdigital_get_integration_wc( 'wc_cart_fragments_disable' ) ) {
		wp_dequeue_script('wc-cart-fragments');
	}
}
