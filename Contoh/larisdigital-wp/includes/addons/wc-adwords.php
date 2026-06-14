<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'woocommerce' ) ) {
	return;
}

if ( !defined( 'LARISDIGITAL_INTEGRATIONS_DB' ) ) {
	define( 'LARISDIGITAL_INTEGRATIONS_DB', 'tokopress_integrations' );
}

add_filter( 'larisdigital_customize_controls', 'larisdigital_customize_controls_adwords_woocommerce' );
function larisdigital_customize_controls_adwords_woocommerce( $controls ) {

	$controls['larisdigital_heading_adwords_woocommerce'] = array(
		'label'		=> esc_html__( 'WooCommerce Conversions', 'larisdigital-wp' ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-warning larisdigital-alert-with-icon">
							<span class="dashicons dashicons-warning"></span> '.esc_html__( 'Go to "Measurement - Conversions" menu on your Google Ads (Adwords) dashboard to create your conversion action for WooCommerce Thank You page.', 'larisdigital-wp' ).'<br><br>'.esc_html__( 'You only need to put "send_to" parameter here. Other parameters (value, currency, transaction_id) will be populated automatically.', 'larisdigital-wp' ).'
							</p>',
		'setting'  	=> 'larisdigital_heading_adwords_woocommerce',
		'section'	=> 'larisdigital_section_google_adwords',
		'type'   	=> 'heading',
	);

	$controls['adwords_woocommerce_send_to_1'] = array(
		'label'		=> esc_html__( 'send_to', 'larisdigital-wp' ),
		'setting'  	=> 'adwords_woocommerce_send_to_1',
		'setting_type' => 'option_mod',
		'setting_db' => LARISDIGITAL_INTEGRATIONS_DB,
		'section'	=> 'larisdigital_section_google_adwords',
		'type'   	=> 'text',
	);

	return $controls;
}

add_action( 'woocommerce_thankyou', 'larisdigital_adwords_woocommerce_purchase_trigger' );
function larisdigital_adwords_woocommerce_purchase_trigger( $order_id = false ) {
	global $larisdigital_woocommerce_purchase_trigger;
	$larisdigital_woocommerce_purchase_trigger = $order_id;
}

add_action( 'larisdigital_gtag_wp_footer', 'larisdigital_adwords_woocommerce_purchase_footer' );
function larisdigital_adwords_woocommerce_purchase_footer() {
	global $larisdigital_woocommerce_purchase_trigger;
	if ( ! $larisdigital_woocommerce_purchase_trigger ) {
		return;
	}

	$send_to = trim( larisdigital_get_integration( 'adwords_woocommerce_send_to_1') );
	if ( empty($send_to) ) {
		return;
	}

	$order_id = $larisdigital_woocommerce_purchase_trigger;
	$order = new WC_Order( $order_id );

	if ( is_wp_error( $order ) ) {
		return;
	}

	$order_status = $order->get_status();
	if ( ! in_array( $order_status, array( 'completed', 'processing', 'on-hold', 'pending' ) ) ) {
		return;
	}

	$value = $order->get_total();
	$value = number_format((float)$value, 2, '.', '');
	$currency = get_woocommerce_currency();

	$event = array(
		'send_to' => $send_to,
		'value' => $value,
		'currency' => $currency,
		'transaction_id' => $order_id,
	);
?>
<!-- Conversion Tracking Events Code -->
<script>
gtag('event', 'conversion', <?php echo json_encode( $event, JSON_UNESCAPED_SLASHES ); ?>);
</script>
<!-- End Conversion Tracking Events Code -->
<?php 
}

add_action( 'admin_head', 'larisdigital_adwords_admin_head_acf_shop' );
function larisdigital_adwords_admin_head_acf_shop() {
	$shop_page_id = wc_get_page_id( 'shop' );
	if ( $shop_page_id && $shop_page_id == get_the_ID() ) {
		echo '<style>#acf-group_5b08a9477f618 { display: none !important; }</style>';
	}
}
