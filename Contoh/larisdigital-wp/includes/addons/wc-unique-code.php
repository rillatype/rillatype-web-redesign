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

add_filter( 'larisdigital_customize_controls', 'larisdigital_wc_customize_controls_unique_code' );
function larisdigital_wc_customize_controls_unique_code( $controls ) {

	$controls['larisdigital_wc_section_uniquecode'] = array(
		'title'    => esc_html__( 'WC - Kode Unik Checkout', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_wc_section_uniquecode',
		'panel'    => 'larisdigital_wc_panel_settings',
		'type'     => 'section',
		'priority' => 105,
	);

	$controls['wc_uniquecode'] = array(
		'label'    			=> esc_html__( 'Aktifkan Fitur Kode Unik di Checkout', 'larisdigital-wp' ),
		'setting'  			=> 'wc_uniquecode',
		'setting_type'		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section'			=> 'larisdigital_wc_section_uniquecode',
		'type'     			=> 'checkbox',
		'transport'			=> 'postMessage',
	);

	$controls['wc_uniquecode_label'] = array(
		'label'				=> esc_html__( 'Tulisan Label Kode Unik', 'larisdigital-wp' ),
		'setting'  			=> 'wc_uniquecode_label',
		'setting_type'		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section'			=> 'larisdigital_wc_section_uniquecode',
		'type'				=> 'text',
		'input_attrs' 		=> array(
			'placeholder' 	=> esc_html__( 'Kode Unik', 'larisdigital-wp' ),
		),
		'transport'			=> 'postMessage',
	);

	$controls['wc_uniquecode_mode'] = array(
		'label'				=> esc_html__( 'Mode Kode Unik', 'larisdigital-wp' ),
		'setting'  			=> 'wc_uniquecode_mode',
		'setting_type'		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section'			=> 'larisdigital_wc_section_uniquecode',
		'type'				=> 'select',
		'choices' 			=> array(
			'minus' 		=> esc_html__( 'Pengurangan', 'larisdigital-wp' ),
			'plus' 			=> esc_html__( 'Penambahan', 'larisdigital-wp' ),
		),
		'default'			=> 'minus',
		'transport'			=> 'postMessage',
	);

	$controls['wc_uniquecode_min'] = array(
		'label'				=> esc_html__( 'Kode Unik Minimum', 'larisdigital-wp' ),
		'setting'  			=> 'wc_uniquecode_min',
		'setting_type'		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section'			=> 'larisdigital_wc_section_uniquecode',
		'type'				=> 'text',
		'input_attrs' 		=> array(
			'placeholder' 	=> '1',
		),
		'transport'			=> 'postMessage',
	);

	$controls['wc_uniquecode_max'] = array(
		'label'				=> esc_html__( 'Kode Unik Maksimum', 'larisdigital-wp' ),
		'setting'  			=> 'wc_uniquecode_max',
		'setting_type'		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section'			=> 'larisdigital_wc_section_uniquecode',
		'type'				=> 'text',
		'input_attrs' 		=> array(
			'placeholder' 	=> '999',
		),
		'transport'			=> 'postMessage',
	);

	return $controls;
}

add_action( 'woocommerce_cart_calculate_fees', 'larisdigital_wc_uniquecode_fee' );
function larisdigital_wc_uniquecode_fee() {
	if ( ! larisdigital_get_integration_wc( 'wc_uniquecode' ) ) {
		return;
	}
	$label = larisdigital_get_integration_wc( 'wc_uniquecode_label' );
	$mode = larisdigital_get_integration_wc( 'wc_uniquecode_mode' );
	$min = larisdigital_get_integration_wc( 'wc_uniquecode_min' );
	$max = larisdigital_get_integration_wc( 'wc_uniquecode_max' );
	if ( empty( $label ) ) {
		$label = esc_html__( 'Kode Unik', 'larisdigital-wp' );
	}
	if ( 'plus' != $mode ) {
		$mode = 'minus';
	}
	if ( empty( $min ) ) {
		$min = 1;
	}
	if ( empty( $max ) ) {
		$max = 999;
	}
	if ( WC()->cart->subtotal != 0 ){
		$cost = WC()->session->get( 'tokopress_wc_uniquecode' );
		if ( ! $cost ) {
			$cost = get_option( 'tokopress_wc_uniquecode' );
			$cost = $cost + 1;
			if ( ( $cost < $min ) || ( $cost > $max ) ) {
				$cost = $min;
			}
			update_option( 'tokopress_wc_uniquecode', $cost );
			WC()->session->set( 'tokopress_wc_uniquecode', $cost );
		}
		if( $cost ) {
			if ( $mode != 'plus' ) {
				$cost = -1*$cost;
			}
			WC()->cart->add_fee( $label, $cost);
		}
	}
}

add_action( 'wp_head', 'larisdigital_wc_uniquecode_thankyou' );
function larisdigital_wc_uniquecode_thankyou() {
	if ( is_wc_endpoint_url( 'order-received' ) ) {
		WC()->session->set( 'tokopress_wc_uniquecode', 0 );
	}
}
