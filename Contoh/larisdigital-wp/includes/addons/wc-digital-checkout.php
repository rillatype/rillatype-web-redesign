<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'woocommerce' ) ) {
	return;
}


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

add_filter( 'larisdigital_customize_controls', 'larisdigital_wc_customize_controls_digital_checkout' );
function larisdigital_wc_customize_controls_digital_checkout( $controls ) {

	$controls['larisdigital_wc_section_digitalcheckout'] = array(
		'title'				=> esc_html__( 'WC - Digital Checkout Fields', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_section_digitalcheckout',
		'panel'    			=> 'larisdigital_wc_panel_settings',
		'type'     			=> 'section',
		'priority' 			=> 55,
	);

	$controls['wc_digitalcheckout_address'] = array(
		'label'    			=> esc_html__( 'Digital Checkout Address Fields', 'larisdigital-wp' ),
		'setting'  			=> 'wc_digitalcheckout_address',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section' 			=> 'larisdigital_wc_section_digitalcheckout',
		'type'				=> 'radio',
		'choices'			=> array(
			''				=> esc_html__( 'Default', 'larisdigital-wp' ),
			'virtual-address' => esc_html__( 'Disable Address (Except Country) on Virtual Product Only', 'larisdigital-wp' ),
			'virtual-address-country' => esc_html__( 'Disable Address (And Country) on Virtual Product Only', 'larisdigital-wp' ),
			'all-address' => esc_html__( 'Disable Address (Except Country) on All Products', 'larisdigital-wp' ),
			'all-address-country' => esc_html__( 'Disable Address (And Country) on All Products', 'larisdigital-wp' ),
		),
	);

	$controls['wc_digitalcheckout_company_disable'] = array(
		'label'    			=> esc_html__( 'Disable Company Fields', 'larisdigital-wp' ),
		'setting'  			=> 'wc_digitalcheckout_company_disable',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section' 			=> 'larisdigital_wc_section_digitalcheckout',
		'type'     			=> 'checkbox',
	);

	$controls['wc_digitalcheckout_phone_disable'] = array(
		'label'    			=> esc_html__( 'Disable Phone Fields', 'larisdigital-wp' ),
		'setting'  			=> 'wc_digitalcheckout_phone_disable',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section' 			=> 'larisdigital_wc_section_digitalcheckout',
		'type'     			=> 'checkbox',
	);

	$controls['wc_digitalcheckout_additional_disable'] = array(
		'label'    			=> esc_html__( 'Disable Additional Fields', 'larisdigital-wp' ),
		'setting'  			=> 'wc_digitalcheckout_additional_disable',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section' 			=> 'larisdigital_wc_section_digitalcheckout',
		'type'     			=> 'checkbox',
	);

	return $controls;
}

add_filter( 'larisdigital_wc_customize_preview_checkout', 'larisdigital_wc_customize_preview_digital_checkout' );
function larisdigital_wc_customize_preview_digital_checkout( $preview ) {
	$preview['larisdigital_wc_section_digitalcheckout'] = 'larisdigital_wc_section_digitalcheckout';
	return $preview;
}

add_filter( 'woocommerce_checkout_fields', 'larisdigital_wc_digital_checkout_fields', 999 );
function larisdigital_wc_digital_checkout_fields( $fields ) {
	$address = larisdigital_get_integration_wc( 'wc_digitalcheckout_address' );
	if ( ! empty( $address ) ) {
		$hide_address = false;
		$hide_country = false;
		if ( $address == 'virtual-address' || $address == 'virtual-address-country' ) {
			$virtual_only = true;
			foreach( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				if ( ! $cart_item['data']->is_virtual() ) {
					$virtual_only = false;
				}
			}
			if ( $virtual_only ) {
				if ( $address == 'virtual-address' ) {
					$hide_address = true;
				}
				elseif ( $address == 'virtual-address-country' ) {
					$hide_address = true;
					$hide_country = true;
				}
			}
		}
		elseif ( $address == 'all-address' ) {
			$hide_address = true;
		}
		elseif ( $address == 'all-address-country' ) {
			$hide_address = true;
			$hide_country = true;
		}
		if( $hide_address ) {
			unset($fields['billing']['billing_company']);
			unset($fields['billing']['billing_address_1']);
			unset($fields['billing']['billing_address_2']);
			unset($fields['billing']['billing_city']);
			unset($fields['billing']['billing_postcode']);
			unset($fields['billing']['billing_state']);
			unset($fields['billing']['billing_indo_ongkir_kota']);
			unset($fields['billing']['billing_indo_ongkir_kecamatan']);
			unset($fields['billing']['billing_shipper_kota']);
			unset($fields['billing']['billing_shipper_kecamatan']);
			unset($fields['billing']['billing_shipper_kelurahan']);
			unset($fields['shipping']['shipping_company']);
			unset($fields['shipping']['shipping_address_1']);
			unset($fields['shipping']['shipping_address_2']);
			unset($fields['shipping']['shipping_city']);
			unset($fields['shipping']['shipping_postcode']);
			unset($fields['shipping']['shipping_state']);
			unset($fields['shipping']['shipping_indo_ongkir_kota']);
			unset($fields['shipping']['shipping_indo_ongkir_kecamatan']);
			unset($fields['shipping']['shipping_shipper_kota']);
			unset($fields['shipping']['shipping_shipper_kecamatan']);
			unset($fields['shipping']['shipping_shipper_kelurahan']);
		}
		if( $hide_country ) {
			unset($fields['billing']['billing_country']);
			unset($fields['shipping']['shipping_country']);
		}
	}
	if ( larisdigital_get_integration_wc( 'wc_digitalcheckout_company_disable' ) ) {
		unset($fields['billing']['billing_company']);
	}
	if ( larisdigital_get_integration_wc( 'wc_digitalcheckout_phone_disable' ) ) {
		unset($fields['billing']['billing_phone']);
	}
	return $fields;
}

add_filter( 'larisdigital_style', 'larisdigital_wc_digital_checkout_style', 999 );
function larisdigital_wc_digital_checkout_style( $style ) {
	if ( larisdigital_get_integration_wc( 'wc_digitalcheckout_additional_disable' ) ) {
		$style .= '.woocommerce-additional-fields { display: none; }';
	}
	return $style;
}
