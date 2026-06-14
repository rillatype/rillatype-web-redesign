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

add_filter( 'larisdigital_customize_controls', 'larisdigital_wc_customize_controls_orders' );
function larisdigital_wc_customize_controls_orders( $controls ) {

	$controls['larisdigital_wc_section_orders'] = array(
		'title'    			=> esc_html__( 'WC - Orders & Reports', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_section_orders',
		'panel'    			=> 'larisdigital_wc_panel_settings',
		'type'     			=> 'section',
		'priority' 			=> 120,
	);

	$controls['larisdigital_wc_heading_orderreports'] = array(
		'label'				=> esc_html__( 'Order Reports', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_heading_orderreports',
		'section'			=> 'larisdigital_wc_section_orders',
		'type'   			=> 'heading',
	);

	$controls['wc_orderreports_onhold_exclude'] = array(
		'label'    			=> esc_html__( 'Exclude "On-Hold" Orders In WooCommerce Reports', 'larisdigital-wp' ),
		'setting'  			=> 'wc_orderreports_onhold_exclude',
		'setting_type'		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section'			=> 'larisdigital_wc_section_orders',
		'type'     			=> 'checkbox',
		'default'			=> '1',
	);

	$controls['larisdigital_wc_heading_orderstatus'] = array(
		'label'				=> esc_html__( 'Order Status Label', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_heading_orderstatus',
		'section'			=> 'larisdigital_wc_section_orders',
		'type'   			=> 'heading',
	);

	$controls['wc_orderstatus_onhold'] = array(
		'label'				=> esc_html__( 'Order Status - On-hold', 'larisdigital-wp' ),
		'setting'  			=> 'wc_orderstatus_onhold',
		'setting_type'		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section'			=> 'larisdigital_wc_section_orders',
		'type'				=> 'text',
		'input_attrs' 		=> array(
			'placeholder' 	=> esc_html_x( 'Belum Dibayar', 'Order status', 'larisdigital-wp' ),
		),
		'transport'			=> 'postMessage',
	);

	$controls['wc_orderstatus_processing'] = array(
		'label'				=> esc_html__( 'Order Status - Processing', 'larisdigital-wp' ),
		'setting'  			=> 'wc_orderstatus_processing',
		'setting_type'		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section'			=> 'larisdigital_wc_section_orders',
		'type'				=> 'text',
		'input_attrs' 		=> array(
			'placeholder' 	=> esc_html_x( 'Pesanan Diproses', 'Order status', 'larisdigital-wp' ),
		),
		'transport'			=> 'postMessage',
	);

	$controls['wc_orderstatus_completed'] = array(
		'label'				=> esc_html__( 'Order Status - Completed', 'larisdigital-wp' ),
		'setting'  			=> 'wc_orderstatus_completed',
		'setting_type'		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section'			=> 'larisdigital_wc_section_orders',
		'type'				=> 'text',
		'input_attrs' 		=> array(
			'placeholder' 	=> esc_html_x( 'Pesanan Selesai', 'Order status', 'larisdigital-wp' ),
		),
		'transport'			=> 'postMessage',
	);

	$controls['wc_orderstatus_refunded'] = array(
		'label'				=> esc_html__( 'Order Status - Refunded', 'larisdigital-wp' ),
		'setting'  			=> 'wc_orderstatus_refunded',
		'setting_type'		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section'			=> 'larisdigital_wc_section_orders',
		'type'				=> 'text',
		'input_attrs' 		=> array(
			'placeholder' 	=> esc_html_x( 'Refund', 'Order status', 'larisdigital-wp' ),
		),
	);

	$controls['wc_orderstatus_cancelled'] = array(
		'label'				=> esc_html__( 'Order Status - Cancelled', 'larisdigital-wp' ),
		'setting'  			=> 'wc_orderstatus_cancelled',
		'setting_type'		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section'			=> 'larisdigital_wc_section_orders',
		'type'				=> 'text',
		'input_attrs' 		=> array(
			'placeholder' 	=> esc_html_x( 'Batal', 'Order status', 'larisdigital-wp' ),
		),
		'transport'			=> 'postMessage',
	);

	$controls['wc_orderstatus_failed'] = array(
		'label'				=> esc_html__( 'Order Status - Failed', 'larisdigital-wp' ),
		'setting'  			=> 'wc_orderstatus_pending',
		'setting_type'		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section'			=> 'larisdigital_wc_section_orders',
		'type'				=> 'text',
		'input_attrs' 		=> array(
			'placeholder' 	=> esc_html_x( 'Gagal', 'Order status', 'larisdigital-wp' ),
		),
	);

	$controls['wc_orderstatus_pending'] = array(
		'label'				=> esc_html__( 'Order Status - Pending', 'larisdigital-wp' ),
		'setting'  			=> 'wc_orderstatus_pending',
		'setting_type'		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section'			=> 'larisdigital_wc_section_orders',
		'type'				=> 'text',
		'input_attrs' 		=> array(
			'placeholder' 	=> esc_html_x( 'Pending', 'Order status', 'larisdigital-wp' ),
		),
	);

	return $controls;
}

add_filter( 'woocommerce_reports_order_statuses', 'larisdigital_wc_order_reports_onhold', 10, 1 );
function larisdigital_wc_order_reports_onhold( $order_statuses ) {
	if ( larisdigital_get_integration_wc( 'wc_orderreports_onhold_exclude', '1' ) ) {
		if ( ! empty( $order_statuses ) && in_array( 'on-hold', $order_statuses ) ) {
			$order_statuses = array_diff( $order_statuses, array( 'on-hold' ) );
		}
	}
    return $order_statuses;
}

add_filter( 'wc_order_statuses', 'larisdigital_wc_order_statuses_custom', 30 );
function larisdigital_wc_order_statuses_custom( $order_statuses ) {

	// Reference: Standard Order Statuses
	// $order_statuses = array(
	// 	'wc-pending'    => _x( 'Pending payment', 'Order status', 'larisdigital-wp' ),
	// 	'wc-processing' => _x( 'Processing', 'Order status', 'larisdigital-wp' ),
	// 	'wc-on-hold'    => _x( 'On hold', 'Order status', 'larisdigital-wp' ),
	// 	'wc-completed'  => _x( 'Completed', 'Order status', 'larisdigital-wp' ),
	// 	'wc-cancelled'  => _x( 'Cancelled', 'Order status', 'larisdigital-wp' ),
	// 	'wc-refunded'   => _x( 'Refunded', 'Order status', 'larisdigital-wp' ),
	// 	'wc-failed'     => _x( 'Failed', 'Order status', 'larisdigital-wp' ),
	// );

	$options = get_option( LARISDIGITAL_INTEGRATIONS_WC_DB );
	if ( isset( $order_statuses['wc-on-hold'] ) ) {
		$order_statuses['wc-on-hold'] = esc_html_x( 'Belum Dibayar', 'Order status', 'larisdigital-wp' );
		if ( isset( $options['wc_orderstatus_onhold'] ) && ! empty( $options['wc_orderstatus_onhold'] ) ) {
			$order_statuses['wc-on-hold'] = $options['wc_orderstatus_onhold'];
		}
	}
	if ( isset( $order_statuses['wc-processing'] ) ) {
		$order_statuses['wc-processing'] = esc_html_x( 'Pesanan Diproses', 'Order status', 'larisdigital-wp' );
		if ( isset( $options['wc_orderstatus_processing'] ) && ! empty( $options['wc_orderstatus_processing'] ) ) {
			$order_statuses['wc-processing'] = $options['wc_orderstatus_processing'];
		}
	}
	if ( isset( $order_statuses['wc-completed'] ) ) {
		$order_statuses['wc-completed'] = esc_html_x( 'Pesanan Selesai', 'Order status', 'larisdigital-wp' );
		if ( isset( $options['wc_orderstatus_completed'] ) && ! empty( $options['wc_orderstatus_completed'] ) ) {
			$order_statuses['wc-completed'] = $options['wc_orderstatus_completed'];
		}
	}
	if ( isset( $order_statuses['wc-refunded'] ) ) {
		$order_statuses['wc-refunded'] = esc_html_x( 'Refund', 'Order status', 'larisdigital-wp' );
		if ( isset( $options['wc_orderstatus_refunded'] ) && ! empty( $options['wc_orderstatus_refunded'] ) ) {
			$order_statuses['wc-refunded'] = $options['wc_orderstatus_refunded'];
		}
	}
	if ( isset( $order_statuses['wc-cancelled'] ) ) {
		$order_statuses['wc-cancelled'] = esc_html_x( 'Batal', 'Order status', 'larisdigital-wp' );
		if ( isset( $options['wc_orderstatus_cancelled'] ) && ! empty( $options['wc_orderstatus_cancelled'] ) ) {
			$order_statuses['wc-cancelled'] = $options['wc_orderstatus_cancelled'];
		}
	}
	if ( isset( $order_statuses['wc-failed'] ) ) {
		$order_statuses['wc-failed'] = esc_html_x( 'Gagal', 'Order status', 'larisdigital-wp' );
		if ( isset( $options['wc_orderstatus_failed'] ) && ! empty( $options['wc_orderstatus_failed'] ) ) {
			$order_statuses['wc-failed'] = $options['wc_orderstatus_failed'];
		}
	}
	if ( isset( $order_statuses['wc-pending'] ) ) {
		$order_statuses['wc-pending'] = esc_html_x( 'Pending', 'Order status', 'larisdigital-wp' );
		if ( isset( $options['wc_orderstatus_pending'] ) && ! empty( $options['wc_orderstatus_refunded'] ) ) {
			$order_statuses['wc-pending'] = $options['wc_orderstatus_pending'];
		}
	}

	$order_statuses_new = array();
	$order_statuses_order = array(
		'wc-on-hold',
		'wc-processing',
		'wc-completed',
		'wc-refunded',
		'wc-cancelled',
		'wc-failed',
		'wc-pending',
	);
	foreach ( $order_statuses_order as $order_status ) {
		if ( isset($order_statuses[$order_status]) ) {
			$order_statuses_new[$order_status] = $order_statuses[$order_status];
			unset( $order_statuses[$order_status] );
		}
	}
	if ( ! empty( $order_statuses ) ) {
		foreach ( $order_statuses as $key => $value ) {
			$order_statuses_new[$key] = $value;
		}
	}

	return $order_statuses_new;
}

add_filter( 'views_edit-shop_order', 'larisdigital_wc_followup_order_views', 99 );
function larisdigital_wc_followup_order_views( $views ) {
	$views_new = array();
	$order_statuses = array(
		'all' => esc_html__( 'All', 'larisdigital-wp' ),
		'wc-on-hold' => esc_html__( 'On hold', 'larisdigital-wp' ),
		'wc-processing' => esc_html__( 'Processing', 'larisdigital-wp' ),
		'wc-completed' => esc_html__( 'Completed', 'larisdigital-wp' ),
		'wc-refunded' => esc_html__( 'Refunded', 'larisdigital-wp' ),
		'wc-cancelled' => esc_html__( 'Cancelled', 'larisdigital-wp' ),
		'wc-failed' => esc_html__( 'Failed', 'larisdigital-wp' ),
		'wc-pending' => esc_html__( 'Pending', 'larisdigital-wp' ),
		'mine' => esc_html__( 'Mine', 'larisdigital-wp' ),
	);
	$order_statuses_id = array(
		'all' => esc_html__( 'Semua Pesanan', 'larisdigital-wp' ),
		'wc-on-hold' => esc_html__( 'Belum Dibayar', 'larisdigital-wp' ),
		'wc-processing' => esc_html__( 'Pesanan Diproses', 'larisdigital-wp' ),
		'wc-completed' => esc_html__( 'Pesanan Selesai', 'larisdigital-wp' ),
		'wc-refunded' => esc_html__( 'Refund', 'larisdigital-wp' ),
		'wc-cancelled' => esc_html__( 'Batal', 'larisdigital-wp' ),
		'wc-failed' => esc_html__( 'Gagal', 'larisdigital-wp' ),
		'wc-pending' => esc_html__( 'Pending', 'larisdigital-wp' ),
		'mine' => esc_html__( 'Pesanan Saya', 'larisdigital-wp' ),
	);
	foreach ( $order_statuses as $order_status => $order_name ) {
		if ( isset($views[$order_status]) ) {
			$view = $views[$order_status];
			$view = str_replace( $order_name, $order_statuses_id[$order_status], $view );
			$views_new[$order_status] = $view;
			unset( $views[$order_status] );
		}
	}
	if ( ! empty( $views ) ) {
		foreach ( $views as $key => $value ) {
			$views_new[$key] = $value;
		}
	}
	return $views_new;
}
