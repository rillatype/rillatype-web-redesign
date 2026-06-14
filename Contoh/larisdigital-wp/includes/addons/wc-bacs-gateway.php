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

add_filter( 'larisdigital_customize_controls', 'larisdigital_wc_customize_controls_bacs_gateway' );
function larisdigital_wc_customize_controls_bacs_gateway( $controls ) {

	$thankyou_message = 'Halo %billing_name%,

Terimakasih untuk pemesanan Anda sebagai berikut: 

Order ID: %order_id%
Tanggal: %order_date%
Status: %order_status%
Produk: %order_items%
Total Tagihan: %order_total%

Untuk pembayaran, silahkan transfer ke rekening bank berikut:

%order_bank_details%

Setelah melakukan pembayaran, silahkan konfirmasi pembayaran Anda ke kami supaya pesanan Anda bisa segera kami proses.

%payment_confirmation%

Terimakasih banyak sudah berbelanja di website kami.

Salam,
%site_name%';

	$thankyou_message_processing = 'Halo %billing_name%,

Terimakasih untuk pemesanan Anda sebagai berikut: 

Order ID: %order_id%
Tanggal: %order_date%
Status: %order_status%
Produk: %order_items%
Total Tagihan: %order_total%

Pesanan Anda saat ini sedang kami proses.

%whatsapp_ask%

Terimakasih banyak sudah berbelanja di website kami.

Salam,
%site_name%';

	$thankyou_message_completed = 'Halo %billing_name%,

Terimakasih untuk pemesanan Anda sebagai berikut: 

Order ID: %order_id%
Tanggal: %order_date%
Status: %order_status%
Produk: %order_items%
Total Tagihan: %order_total%

Pesanan Anda saat ini telah selesai kami kirimkan.

%indo_ongkir_resi%

%whatsapp_ask%

Terimakasih banyak sudah berbelanja di website kami.

Salam,
%site_name%';

	$whatsapp_message = 'Halo %site_name%,

Saya ingin melakukan konfirmasi pembayaran untuk pemesanan berikut: 

Order ID: %order_id%
Tanggal: %order_date%
Produk: %order_items%
Total Tagihan: %order_total%

Salam,
%billing_name%';

	$whatsapp_message_ask = 'Halo %site_name%,

Saya ingin bertanya tentang pemesanan berikut: 

Order ID: %order_id%
Tanggal: %order_date%
Produk: %order_items%
Total Tagihan: %order_total%

Salam,
%billing_name%';

	$whatsapp_redirect = 'Halo %site_name%,

Saya ingin melakukan pemesanan berikut: 

Produk: %order_items%
Total: %order_total%
Order ID: %order_id%

Dengan data sebagai berikut,

Nama: %billing_name%
Alamat: %billing_address%
Telp: %billing_phone%

Salam,
%billing_name%';

	$controls['larisdigital_wc_section_bacs'] = array(
		'title'    => esc_html__( 'WC - Bank Transfer Gateway', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_wc_section_bacs',
		'panel'    => 'larisdigital_wc_panel_settings',
		'type'     => 'section',
		'priority' => 110,
	);

	$controls['larisdigital_heading_thankyou_params'] = array(
		'label'				=> '',
		'description'		=> '<p>'.esc_html__( 'Available Parameter:', 'larisdigital-wp' ).' <code>%site_name%</code>, <code>%order_id%</code>, <code>%order_date%</code>, <code>%order_status%</code>, <code>%order_items%</code>, <code>%order_total%</code>, <code>%order_bank_details%</code>, <code>%billing_name%</code>, <code>%billing_email%</code>, <code>%billing_phone%</code>, <code>%billing_address%</code>, <code>%shipping_name%</code>, <code>%shipping_address%</code>, <code>%payment_confirmation%</code>, <code>%payment_confirmation_link%</code>, <code>%whatsapp_confirmation%</code>, <code>%whatsapp_ask%</code>, <code>%indo_ongkir_resi%</code></p>',
		'setting'  			=> 'larisdigital_heading_thankyou_params',
		'section'			=> 'larisdigital_wc_section_bacs',
		'type'   			=> 'heading',
	);

	$controls['larisdigital_heading_thankyou_redirect'] = array(
		'label'				=> esc_html__( 'Order - WhatsApp Redirect', 'larisdigital-wp' ),
		'description'		=> '<p class="larisdigital-alert larisdigital-alert-success larisdigital-alert-with-icon">
								<span class="dashicons dashicons-megaphone"></span> '.esc_html__( 'Anda bisa mengaktifkan fitur redirect whatsapp jika ingin mengarahkan customer ke WhatsApp CS di thankyou page setelah melakukan pemesanan. Bisa dibilang sebagai "WhatsApp Form Rasa WooCommerce"', 'larisdigital-wp' ).'
								</p>',
		'setting'  			=> 'larisdigital_heading_thankyou_redirect',
		'section'			=> 'larisdigital_wc_section_bacs',
		'type'   			=> 'heading',
	);

	$controls['wc_thankyou_redirect_enable'] = array(
		'label'				=> esc_html__( 'Aktifkan WhatsApp Redirect di Thankyou Page', 'larisdigital-wp' ),
		'setting'  			=> 'wc_thankyou_redirect_enable',
		'setting_type'		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section'			=> 'larisdigital_wc_section_bacs',
		'type'				=> 'checkbox',
		'transport'			=> 'postMessage',
	);

	$controls['wc_thankyou_redirect_delay'] = array(
		'label'				=> esc_html__( 'WhatsApp Redirect Delay (Detik)', 'larisdigital-wp' ),
		'description'		=> esc_html__( 'Gunakan delay yang cukup khususnya jika Anda menggunakan Facebook Pixel / Google Ads di thankyou page untuk conversion tracking', 'larisdigital-wp' ),
		'setting'  			=> 'wc_thankyou_redirect_delay',
		'setting_type'		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section'			=> 'larisdigital_wc_section_bacs',
		'type'				=> 'text',
		'input_attrs' 		=> array(
			'placeholder' 	=> '3',
		),
		'transport'			=> 'postMessage',
	);

	$controls['wc_thankyou_redirect_message'] = array(
		'label'				=> esc_html__( 'WhatsApp Redirect Message', 'larisdigital-wp' ),
		'setting'  			=> 'wc_thankyou_redirect_message',
		'setting_type'		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section'			=> 'larisdigital_wc_section_bacs',
		'type'				=> 'textarea',
		'default'			=> $whatsapp_redirect,
		'input_attrs' 		=> array(
			'placeholder' 	=> $whatsapp_redirect,
		),
		'transport'			=> 'postMessage',
	);

	$controls['wc_thankyou_redirect_intro'] = array(
		'label'				=> esc_html__( 'WhatsApp Redirect Intro Teks', 'larisdigital-wp' ),
		'setting'  			=> 'wc_thankyou_redirect_intro',
		'setting_type'		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section'			=> 'larisdigital_wc_section_bacs',
		'type'				=> 'text',
		'input_attrs' 		=> array(
			'placeholder' 	=> esc_html__( 'Klik tombol di bawah ini jika Anda tidak secara otomatis diarahkan ke aplikasi WhatsApp.', 'larisdigital-wp' ),
		),
		'transport'			=> 'postMessage',
	);

	$controls['wc_thankyou_redirect_button'] = array(
		'label'				=> esc_html__( 'WhatsApp Redirect Button Teks', 'larisdigital-wp' ),
		'setting'  			=> 'wc_thankyou_redirect_button',
		'setting_type'		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section'			=> 'larisdigital_wc_section_bacs',
		'type'				=> 'text',
		'input_attrs' 		=> array(
			'placeholder' 	=> esc_html__( 'Chat Kami di WhatsApp', 'larisdigital-wp' ),
		),
		'transport'			=> 'postMessage',
	);

	$controls['larisdigital_heading_thankyou_bacs'] = array(
		'label'				=> esc_html__( 'Order - Thank You Message', 'larisdigital-wp' ),
		'description'		=> '<p class="larisdigital-alert larisdigital-alert-success larisdigital-alert-with-icon">
								<span class="dashicons dashicons-megaphone"></span> '.esc_html__( 'Thank you message akan ditampilkan di thankyou page, email pemesanan, dan detail pesanan di halaman "My Account".', 'larisdigital-wp' ).'
								</p>',
		'setting'  			=> 'larisdigital_heading_thankyou_bacs',
		'section'			=> 'larisdigital_wc_section_bacs',
		'type'   			=> 'heading',
	);

	$controls['wc_thankyou_bacs'] = array(
		'label'				=> esc_html__( 'Thank You Message (Belum Dibayar)', 'larisdigital-wp' ),
		'setting'  			=> 'wc_thankyou_bacs',
		'setting_type'		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section'			=> 'larisdigital_wc_section_bacs',
		'type'				=> 'textarea',
		'default'			=> $thankyou_message,
		'input_attrs' 		=> array(
			'placeholder' 	=> $thankyou_message,
		),
		'transport'			=> 'postMessage',
	);

	$controls['wc_thankyou_bacs_processing'] = array(
		'label'				=> esc_html__( 'Thank You Message (Pesanan Diproses)', 'larisdigital-wp' ),
		'setting'  			=> 'wc_thankyou_bacs_processing',
		'setting_type'		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section'			=> 'larisdigital_wc_section_bacs',
		'type'				=> 'textarea',
		'default'			=> $thankyou_message_processing,
		'input_attrs' 		=> array(
			'placeholder' 	=> $thankyou_message_processing,
		),
		'transport'			=> 'postMessage',
	);

	$controls['wc_thankyou_bacs_completed'] = array(
		'label'				=> esc_html__( 'Thank You Message (Pesanan Selesai)', 'larisdigital-wp' ),
		'setting'  			=> 'wc_thankyou_bacs_completed',
		'setting_type'		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section'			=> 'larisdigital_wc_section_bacs',
		'type'				=> 'textarea',
		'default'			=> $thankyou_message_completed,
		'input_attrs' 		=> array(
			'placeholder' 	=> $thankyou_message_completed,
		),
		'transport'			=> 'postMessage',
	);

	$controls['larisdigital_heading_payment_confirm_link'] = array(
		'label'				=> esc_html__( 'Link Konfirmasi Pembayaran', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_heading_payment_confirm_link',
		'section'			=> 'larisdigital_wc_section_bacs',
		'type'   			=> 'heading',
	);

	$controls['wc_payment_confirm_link_url'] = array(
		'label'				=> esc_html__( 'URL Link Konfirmasi Pembayaran', 'larisdigital-wp' ),
		'description'		=> esc_html__( 'Gunakan opsi ini jika Anda mempunyai halaman khusus yang berisi form konfirmasi pembayaran', 'larisdigital-wp' ),
		'setting'  			=> 'wc_payment_confirm_link_url',
		'setting_type'		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section'			=> 'larisdigital_wc_section_bacs',
		'type'				=> 'text',
		'transport'			=> 'postMessage',
	);

	$controls['wc_payment_confirm_link_text'] = array(
		'label'				=> esc_html__( 'Teks Link Konfirmasi Pembayaran', 'larisdigital-wp' ),
		'setting'  			=> 'wc_payment_confirm_link_text',
		'setting_type'		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section'			=> 'larisdigital_wc_section_bacs',
		'type'				=> 'text',
		'input_attrs' 		=> array(
			'placeholder' 	=> esc_html__( 'Klik di sini untuk konfirmasi pembayaran', 'larisdigital-wp' ),
		),
		'transport'			=> 'postMessage',
	);

	$controls['larisdigital_heading_payment_confirm_whatsapp'] = array(
		'label'				=> esc_html__( 'Tanya / Konfirmasi Via WhatsApp', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_heading_payment_confirm_whatsapp',
		'section'			=> 'larisdigital_wc_section_bacs',
		'type'   			=> 'heading',
	);

	$controls['wc_payment_confirm_whatsapp_enable'] = array(
		'label'				=> esc_html__( 'Gunakan Nomor WhatsApp Utama (dari Theme Settings Integrations) untuk bertanya / konfirmasi pembayaran', 'larisdigital-wp' ),
		'setting'  			=> 'wc_payment_confirm_whatsapp_enable',
		'setting_type'		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section'			=> 'larisdigital_wc_section_bacs',
		'type'				=> 'checkbox',
		'transport'			=> 'postMessage',
	);

	$controls['wc_payment_confirm_whatsapp_phone'] = array(
		'label'				=> esc_html__( 'Nomor WhatsApp KHUSUS Untuk Tanya / Konfirmasi Pembayaran', 'larisdigital-wp' ),
		'description'		=> esc_html__( 'Jika Anda ingin tidak ingin menggunakan nomor WhatsApp utama untuk bertanya / konfirmasi pembayaran', 'larisdigital-wp' ),
		'setting'  			=> 'wc_payment_confirm_whatsapp_phone',
		'setting_type'		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section'			=> 'larisdigital_wc_section_bacs',
		'type'				=> 'text',
		'transport'			=> 'postMessage',
	);

	$controls['wc_payment_confirm_whatsapp_text'] = array(
		'label'				=> esc_html__( 'Teks Konfirmasi Via WhatsApp', 'larisdigital-wp' ),
		'setting'  			=> 'wc_payment_confirm_whatsapp_text',
		'setting_type'		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section'			=> 'larisdigital_wc_section_bacs',
		'type'				=> 'text',
		'input_attrs' 		=> array(
			'placeholder' 	=> esc_html__( 'Konfirmasi Pembayaran via WhatsApp', 'larisdigital-wp' ),
		),
		'transport'			=> 'postMessage',
	);

	$controls['wc_payment_confirm_whatsapp_message'] = array(
		'label'				=> esc_html__( 'Format Pesan Konfirmasi Via WhatsApp', 'larisdigital-wp' ),
		'setting'  			=> 'wc_payment_confirm_whatsapp_message',
		'setting_type'		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section'			=> 'larisdigital_wc_section_bacs',
		'type'				=> 'textarea',
		'default'			=> $whatsapp_message,
		'input_attrs' 		=> array(
			'placeholder' 	=> $whatsapp_message,
		),
		'transport'			=> 'postMessage',
	);

	$controls['wc_payment_confirm_whatsapp_text_ask'] = array(
		'label'				=> esc_html__( 'Teks Tanya Via WhatsApp', 'larisdigital-wp' ),
		'setting'  			=> 'wc_payment_confirm_whatsapp_text_ask',
		'setting_type'		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section'			=> 'larisdigital_wc_section_bacs',
		'type'				=> 'text',
		'input_attrs' 		=> array(
			'placeholder' 	=> esc_html__( 'Tanya via WhatsApp', 'larisdigital-wp' ),
		),
		'transport'			=> 'postMessage',
	);

	$controls['wc_payment_confirm_whatsapp_message_ask'] = array(
		'label'				=> esc_html__( 'Format Pesan Tanya Via WhatsApp', 'larisdigital-wp' ),
		'setting'  			=> 'wc_payment_confirm_whatsapp_message_ask',
		'setting_type'		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section'			=> 'larisdigital_wc_section_bacs',
		'type'				=> 'textarea',
		'default'			=> $whatsapp_message_ask,
		'input_attrs' 		=> array(
			'placeholder' 	=> $whatsapp_message_ask,
		),
		'transport'			=> 'postMessage',
	);

	$controls['larisdigital_whatsapp_menu_bacs'] = array(
		'label'				=> esc_html__( 'Konfirmasi Pembayaran Via WhatsApp', 'larisdigital-wp' ),
		'description' 		=> '<p class="larisdigital-alert larisdigital-alert-with-icon">
								<span class="dashicons dashicons-admin-tools"></span> <a href="javascript:wp.customize.control( \'larisdigital_heading_payment_confirm_whatsapp\' ).focus();">'.esc_html__( 'KLIK DI SINI untuk setup link konfirmasi pembayaran di WhatsApp untuk order di WooCommerce dengan menggunakan Bank Transfer', 'larisdigital-wp' ).'</a>
								</p>',
		'setting'  			=> 'larisdigital_whatsapp_menu_bacs',
		'section'			=> 'larisdigital_section_whatsapp',
		'type'   			=> 'heading',
		'priority'   		=> 50,
	);

	return $controls;
}

add_action( 'init', 'larisdigital_wc_thankyou_bacs_default' );
function larisdigital_wc_thankyou_bacs_default() {
	$gateways = WC()->payment_gateways()->payment_gateways();
	if ( isset( $gateways[ 'bacs' ] ) && $gateways[ 'bacs' ] ) {
		remove_action( 'woocommerce_thankyou_bacs', array( $gateways[ 'bacs' ], 'thankyou_page' ) );
		remove_action( 'woocommerce_email_before_order_table', array( $gateways[ 'bacs' ], 'email_instructions' ), 10, 3 );
	}
}

add_action( 'woocommerce_thankyou_bacs', 'larisdigital_wc_thankyou_bacs_custom', 1 );
function larisdigital_wc_thankyou_bacs_custom( $order_id ) {

	$order = wc_get_order( $order_id );
	if ( is_wp_error( $order ) ) {
		return;
	}

	$payment_method = $order->get_payment_method();
	if ( 'bacs' != $payment_method ) {
		return;
	}

	$order_status = $order->get_status();
	if ( ! in_array( $order_status, array( 'on-hold', 'processing', 'completed' ) ) ) {
		return;
	}

	$redirect = larisdigital_get_integration_wc( 'wc_thankyou_redirect_enable' );

	echo '<style>';
	echo '.woocommerce-order .tp-order-divider-top, .woocommerce-thankyou-order-received, .woocommerce-thankyou-order-details { display: none; }
	.button-block { display: block; width: 100%; font-size: 1rem !important; padding: 0.75rem !important; }';
	if ( $redirect ) {
		echo '.woocommerce-order-details, .woocommerce-customer-details, .woocommerce-order-downloads { display: none; }';
		echo '
		.spinkit-container {
			position:relative;
			height: 80px;
		}
		/* Spinkit https://github.com/tobiasahlin/SpinKit MIT License */
		.spinkit-wave{display:block;position:absolute;top:0;left:50%;width:50px;height:40px;margin:0 0 0 -25px;font-size:10px;text-align:center}
		.spinkit-wave .spinkit-rect{display:block;float:left;width:6px;height:50px;margin:0 2px;background-color:#e91e63;-webkit-animation:spinkit-wave-stretch-delay 1.2s infinite ease-in-out;animation:spinkit-wave-stretch-delay 1.2s infinite ease-in-out}
		.spinkit-wave .spinkit-rect1{-webkit-animation-delay:-1.2s;animation-delay:-1.2s}
		.spinkit-wave .spinkit-rect2{-webkit-animation-delay:-1.1s;animation-delay:-1.1s}
		.spinkit-wave .spinkit-rect3{-webkit-animation-delay:-1s;animation-delay:-1s}
		.spinkit-wave .spinkit-rect4{-webkit-animation-delay:-.9s;animation-delay:-.9s}
		.spinkit-wave .spinkit-rect5{-webkit-animation-delay:-.8s;animation-delay:-.8s}@-webkit-keyframes spinkit-wave-stretch-delay{0%,100%,40%{-webkit-transform:scaleY(.5);transform:scaleY(.5)}20%{-webkit-transform:scaleY(1);transform:scaleY(1)}}@keyframes spinkit-wave-stretch-delay{0%,100%,40%{-webkit-transform:scaleY(.5);transform:scaleY(.5)}20%{-webkit-transform:scaleY(1);transform:scaleY(1)}}
		';
	}
	echo '</style>';

	if ( $redirect ) {
		larisdigital_wc_bacs_payment_instruction( $order, false, 'redirect' );
	}
	else {
		larisdigital_wc_bacs_payment_instruction( $order, false, 'thankyou' );
	}
}

add_action( 'woocommerce_view_order', 'larisdigital_wc_thankyou_bacs_order', 1 );
function larisdigital_wc_thankyou_bacs_order( $order_id ) {

	$order = wc_get_order( $order_id );
	if ( is_wp_error( $order ) ) {
		return;
	}

	$payment_method = $order->get_payment_method();
	if ( 'bacs' != $payment_method ) {
		return;
	}

	$order_status = $order->get_status();
	if ( ! in_array( $order_status, array( 'on-hold', 'processing', 'completed' ) ) ) {
		return;
	}

	echo '<style>
	.woocommerce-thankyou-order-received, .woocommerce-thankyou-order-details { display: none; }
	.button-block { display: block; width: 100%; font-size: 1rem !important; padding: 0.75rem !important; }
	</style>';

	larisdigital_wc_bacs_payment_instruction( $order, false, 'order' );
}

add_action( 'woocommerce_email_before_order_table', 'larisdigital_wc_thankyou_bacs_email', 1, 3 );
function larisdigital_wc_thankyou_bacs_email( $order, $sent_to_admin, $plain_text ) {
	if ( ! $sent_to_admin && 'bacs' === $order->get_payment_method() ) {
		if ( $order->has_status( 'on-hold' ) || $order->has_status( 'processing' ) || $order->has_status( 'completed' ) ) {
			larisdigital_wc_bacs_payment_instruction( $order, $plain_text, 'email' );
		}
	}
}

function larisdigital_wc_bacs_payment_instruction( $order, $plain_text = false, $mode = 'thankyou' ) {
	$order_status = $order->get_status();

	$whatsapp_redirect = '';
	$thankyou_message = '';
	$whatsapp_message = '';
	$whatsapp_message_ask = '';

	if ( $mode == 'redirect' ) {
		$whatsapp_redirect = larisdigital_get_integration_wc( 'wc_thankyou_redirect_message' );
		if ( empty( $whatsapp_redirect ) ) {
			$whatsapp_redirect = 'Halo %site_name%,

Saya ingin melakukan pemesanan berikut: 

Produk: %order_items%
Total: %order_total%
Order ID: %order_id%

Dengan data sebagai berikut,

Nama: %billing_name%
Alamat: %billing_address%
Telp: %billing_phone%

Salam,
%billing_name%';
		}
	}
	else {
		if ( 'on-hold' == $order_status ) {
			$thankyou_message = larisdigital_get_integration_wc( 'wc_thankyou_bacs' );
			if ( empty( $thankyou_message ) ) {
				$thankyou_message = 'Halo %billing_name%,

Terimakasih untuk pemesanan Anda sebagai berikut: 

Order ID: %order_id%
Produk: %order_items%
Total Tagihan: %order_total%

Untuk pembayaran, silahkan transfer ke rekening bank berikut:

%order_bank_details%

Setelah melakukan pembayaran, silahkan konfirmasi pembayaran Anda ke kami supaya pesanan Anda bisa segera kami proses.

%payment_confirmation%

Terimakasih banyak sudah berbelanja di website kami.

Salam,
%site_name%';
			}
		}
		elseif ( 'processing' == $order_status ) {
			$thankyou_message = larisdigital_get_integration_wc( 'wc_thankyou_bacs_processing' );
			if ( empty( $thankyou_message ) ) {
				$thankyou_message = 'Halo %billing_name%,

Terimakasih untuk pemesanan Anda sebagai berikut: 

Order ID: %order_id%
Tanggal: %order_date%
Status: %order_status%
Produk: %order_items%
Total Tagihan: %order_total%

Pesanan Anda saat ini sedang kami proses.

%whatsapp_ask%

Terimakasih banyak sudah berbelanja di website kami.

Salam,
%site_name%';
			}
		}
		elseif ( 'completed' == $order_status ) {
			$thankyou_message = larisdigital_get_integration_wc( 'wc_thankyou_bacs_completed' );
			if ( empty( $thankyou_message ) ) {
				$thankyou_message = 'Halo %billing_name%,

Terimakasih untuk pemesanan Anda sebagai berikut: 

Order ID: %order_id%
Tanggal: %order_date%
Status: %order_status%
Produk: %order_items%
Total Tagihan: %order_total%

Pesanan Anda saat ini telah selesai kami kirimkan.

%indo_ongkir_resi%

%whatsapp_ask%

Terimakasih banyak sudah berbelanja di website kami.

Salam,
%site_name%';
			}
		}

		$whatsapp_message = larisdigital_get_integration_wc( 'wc_payment_confirm_whatsapp_message' );
		if ( empty( $whatsapp_message ) ) {
			$whatsapp_message = 'Halo %site_name%,

Saya ingin melakukan konfirmasi pembayaran untuk pemesanan berikut: 

Order ID: %order_id%
Produk: %order_items%
Total Tagihan: %order_total%

Salam,
%billing_name%';
		}
		if ( $plain_text ) {
			$whatsapp_message = 'Konfirmasi Pembayaran %order_id%';
		}

		$whatsapp_message_ask = larisdigital_get_integration_wc( 'wc_payment_confirm_whatsapp_message_ask' );
		if ( empty( $whatsapp_message_ask ) ) {
			$whatsapp_message_ask = 'Halo %site_name%,

Saya ingin bertanya tentang pemesanan berikut: 

Order ID: %order_id%
Produk: %order_items%
Total Tagihan: %order_total%

Salam,
%billing_name%';
		}
		if ( $plain_text ) {
			$whatsapp_message_ask = 'Tanya Pesanan %order_id%';
		}
	}

	if ( strpos($thankyou_message, '%billing_name%') !== false || strpos($whatsapp_message, '%billing_name%') !== false || strpos($whatsapp_message_ask, '%billing_name%') !== false || strpos($whatsapp_redirect, '%billing_name%') !== false ) {
		$billing_name = $order->get_billing_first_name();
		if ( $mode == 'redirect' ) {
			$whatsapp_redirect = str_replace( '%billing_name%', $billing_name, $whatsapp_redirect );
		}
		else {
			$thankyou_message = str_replace( '%billing_name%', $billing_name, $thankyou_message );
			$whatsapp_message = str_replace( '%billing_name%', $billing_name, $whatsapp_message );
			$whatsapp_message_ask = str_replace( '%billing_name%', $billing_name, $whatsapp_message_ask );
		}
	}
	if ( strpos($thankyou_message, '%billing_email%') !== false || strpos($whatsapp_message, '%billing_email%') !== false || strpos($whatsapp_message_ask, '%billing_email%') !== false || strpos($whatsapp_redirect, '%billing_email%') !== false ) {
		$billing_email = $order->get_billing_email();
		if ( $mode == 'redirect' ) {
			$whatsapp_redirect = str_replace( '%billing_email%', $billing_email, $whatsapp_redirect );
		}
		else {
			$thankyou_message = str_replace( '%billing_email%', $billing_email, $thankyou_message );
			$whatsapp_message = str_replace( '%billing_email%', $billing_email, $whatsapp_message );
			$whatsapp_message_ask = str_replace( '%billing_email%', $billing_email, $whatsapp_message_ask );
		}
	}
	if ( strpos($thankyou_message, '%billing_phone%') !== false || strpos($whatsapp_message, '%billing_phone%') !== false || strpos($whatsapp_message_ask, '%billing_phone%') !== false || strpos($whatsapp_redirect, '%billing_phone%') !== false ) {
		$billing_phone = $order->get_billing_phone();
		if ( $mode == 'redirect' ) {
			$whatsapp_redirect = str_replace( '%billing_phone%', $billing_phone, $whatsapp_redirect );
		}
		else {
			$thankyou_message = str_replace( '%billing_phone%', $billing_phone, $thankyou_message );
			$whatsapp_message = str_replace( '%billing_phone%', $billing_phone, $whatsapp_message );
			$whatsapp_message_ask = str_replace( '%billing_phone%', $billing_phone, $whatsapp_message_ask );
		}
	}
	if ( strpos($thankyou_message, '%billing_address%') !== false || strpos($whatsapp_message, '%billing_address%') !== false || strpos($whatsapp_message_ask, '%billing_address%') !== false || strpos($whatsapp_redirect, '%billing_address%') !== false ) {
		$billing_address = $order->get_formatted_billing_address('');
		$billing_first_name = $order->get_billing_first_name();
		$billing_last_name = $order->get_billing_last_name();
		$billing_address = str_replace( $billing_first_name.' '.$billing_last_name.'<br/>', "", $billing_address );
		$billing_address_whatsapp = str_replace( array( '<br>', '<br/>' ), " \n", $billing_address );
		if ( $mode == 'redirect' ) {
			$whatsapp_redirect = str_replace( '%billing_address%', $billing_address_whatsapp, $whatsapp_redirect );
		}
		else {
			$thankyou_message = str_replace( '%billing_address%', $billing_address, $thankyou_message );
			$whatsapp_message = str_replace( '%billing_address%', $billing_address_whatsapp, $whatsapp_message );
			$whatsapp_message_ask = str_replace( '%billing_address%', $billing_address_whatsapp, $whatsapp_message_ask );
		}
	}
	if ( strpos($thankyou_message, '%billing_first_name%') !== false || strpos($whatsapp_message, '%billing_first_name%') !== false || strpos($whatsapp_message_ask, '%billing_first_name%') !== false || strpos($whatsapp_redirect, '%billing_first_name%') !== false ) {
		$billing_first_name = $order->get_billing_first_name();
		if ( $mode == 'redirect' ) {
			$whatsapp_redirect = str_replace( '%billing_first_name%', $billing_first_name, $whatsapp_redirect );
		}
		else {
			$thankyou_message = str_replace( '%billing_first_name%', $billing_first_name, $thankyou_message );
			$whatsapp_message = str_replace( '%billing_first_name%', $billing_first_name, $whatsapp_message );
			$whatsapp_message_ask = str_replace( '%billing_first_name%', $billing_first_name, $whatsapp_message_ask );
		}
	}
	if ( strpos($thankyou_message, '%billing_last_name%') !== false || strpos($whatsapp_message, '%billing_last_name%') !== false || strpos($whatsapp_message_ask, '%billing_last_name%') !== false || strpos($whatsapp_redirect, '%billing_last_name%') !== false ) {
		$billing_last_name = $order->get_billing_last_name();
		if ( $mode == 'redirect' ) {
			$whatsapp_redirect = str_replace( '%billing_last_name%', $billing_last_name, $whatsapp_redirect );
		}
		else {
			$thankyou_message = str_replace( '%billing_last_name%', $billing_last_name, $thankyou_message );
			$whatsapp_message = str_replace( '%billing_last_name%', $billing_last_name, $whatsapp_message );
			$whatsapp_message_ask = str_replace( '%billing_last_name%', $billing_last_name, $whatsapp_message_ask );
		}
	}
	if ( strpos($thankyou_message, '%shipping_name%') !== false || strpos($whatsapp_message, '%shipping_name%') !== false || strpos($whatsapp_message_ask, '%shipping_name%') !== false || strpos($whatsapp_redirect, '%shipping_name%') !== false ) {
		$shipping_name = $order->get_shipping_first_name();
		if ( $mode == 'redirect' ) {
			$whatsapp_redirect = str_replace( '%shipping_name%', $shipping_name, $whatsapp_redirect );
		}
		else {
			$thankyou_message = str_replace( '%shipping_name%', $shipping_name, $thankyou_message );
			$whatsapp_message = str_replace( '%shipping_name%', $shipping_name, $whatsapp_message );
			$whatsapp_message_ask = str_replace( '%shipping_name%', $shipping_name, $whatsapp_message_ask );
		}
	}
	if ( strpos($thankyou_message, '%shipping_address%') !== false || strpos($whatsapp_message, '%shipping_address%') !== false || strpos($whatsapp_message_ask, '%shipping_address%') !== false || strpos($whatsapp_redirect, '%shipping_address%') !== false ) {
		$shipping_address = $order->get_formatted_shipping_address('');
		$shipping_first_name = $order->get_shipping_first_name();
		$shipping_last_name = $order->get_shipping_last_name();
		$shipping_address = str_replace( $shipping_first_name.' '.$shipping_last_name.'<br/>', "", $shipping_address );
		$shipping_address_whatsapp = str_replace( array( '<br>', '<br/>' ), " \n", $shipping_address );
		if ( $mode == 'redirect' ) {
			$whatsapp_redirect = str_replace( '%shipping_address%', $shipping_address_whatsapp, $whatsapp_redirect );
		}
		else {
			$thankyou_message = str_replace( '%shipping_address%', $shipping_address, $thankyou_message );
			$whatsapp_message = str_replace( '%shipping_address%', $shipping_address_whatsapp, $whatsapp_message );
			$whatsapp_message_ask = str_replace( '%shipping_address%', $shipping_address_whatsapp, $whatsapp_message_ask );
		}
	}
	if ( strpos($thankyou_message, '%order_id%') !== false || strpos($whatsapp_message, '%order_id%') !== false || strpos($whatsapp_message_ask, '%order_id%') !== false || strpos($whatsapp_redirect, '%order_id%') !== false ) {
		$order_number = $order->get_order_number();
		if ( $mode == 'redirect' ) {
			$whatsapp_redirect = str_replace( '%order_id%', '*#'.$order_number.'*', $whatsapp_redirect );
		}
		else {
			$thankyou_message = str_replace( '%order_id%', '<strong>#'.$order_number.'</strong>', $thankyou_message );
			$whatsapp_message = str_replace( '%order_id%', '*#'.$order_number.'*', $whatsapp_message );
			$whatsapp_message_ask = str_replace( '%order_id%', '*#'.$order_number.'*', $whatsapp_message_ask );
		}
	}
	if ( strpos($thankyou_message, '%order_date%') !== false || strpos($whatsapp_message, '%order_date%') !== false || strpos($whatsapp_message_ask, '%order_date%') !== false || strpos($whatsapp_redirect, '%order_date%') !== false ) {
		$order_date = wc_format_datetime( $order->get_date_created() );
		if ( $mode == 'redirect' ) {
			$whatsapp_redirect = str_replace( '%order_date%', '*'.$order_date.'*', $whatsapp_redirect );
		}
		else {
			$thankyou_message = str_replace( '%order_date%', '<strong>'.$order_date.'</strong>', $thankyou_message );
			$whatsapp_message = str_replace( '%order_date%', '*'.$order_date.'*', $whatsapp_message );
			$whatsapp_message_ask = str_replace( '%order_date%', '*'.$order_date.'*', $whatsapp_message_ask );
		}
	}
	if ( strpos($thankyou_message, '%order_status%') !== false || strpos($whatsapp_message, '%order_status%') !== false || strpos($whatsapp_message_ask, '%order_status%') !== false || strpos($whatsapp_redirect, '%order_status%') !== false ) {
		$order_status_label = wc_get_order_status_name( $order->get_status() );
		if ( $mode == 'redirect' ) {
			$whatsapp_redirect = str_replace( '%order_status%', '*'.$order_status_label.'*', $whatsapp_redirect );
		}
		else {
			$thankyou_message = str_replace( '%order_status%', '<strong>'.$order_status_label.'</strong>', $thankyou_message );
			$whatsapp_message = str_replace( '%order_status%', '*'.$order_status_label.'*', $whatsapp_message );
			$whatsapp_message_ask = str_replace( '%order_status%', '*'.$order_status_label.'*', $whatsapp_message_ask );
		}
	}
	if ( strpos($thankyou_message, '%order_items%') !== false || strpos($whatsapp_message, '%order_items%') !== false || strpos($whatsapp_message_ask, '%order_items%') !== false || strpos($whatsapp_redirect, '%order_items%') !== false ) {
		$hidden_order_itemmeta = apply_filters(
			'woocommerce_hidden_order_itemmeta', array(
				'_qty',
				'_tax_class',
				'_product_id',
				'_variation_id',
				'_line_subtotal',
				'_line_subtotal_tax',
				'_line_total',
				'_line_tax',
				'method_id',
				'cost',
				'_reduced_stock',
			)
		);
		$items = $order->get_items();
		$item_names = array();
		foreach ( $items as $item ) {
			$item_name = $item->get_name();
			$meta_data = $item->get_formatted_meta_data( '' );
			if ( ! empty( $meta_data ) ) {
				$item_meta = array();
				foreach ( $meta_data as $meta_id => $meta ) {
					if ( in_array( $meta->key, $hidden_order_itemmeta, true ) ) {
						continue;
					}
					$item_meta[] = $meta->display_key . ':' . wp_strip_all_tags( $meta->display_value, true );
				}
				if ( ! empty( $item_meta ) ) {
					$item_name .= ' (' . implode( ', ', $item_meta ) . ')' ;
				}
			}
			$item_name .= ' x ' . $item->get_quantity();
			$item_names[] = $item_name;
		}
		$order_items = implode( ', ', $item_names );
		if ( $mode == 'redirect' ) {
			$whatsapp_redirect = str_replace( '%order_items%', '*'.$order_items.'*', $whatsapp_redirect );
		}
		else {
			$thankyou_message = str_replace( '%order_items%', '<strong>'.$order_items.'</strong>', $thankyou_message );
			$whatsapp_message = str_replace( '%order_items%', '*'.$order_items.'*', $whatsapp_message );
			$whatsapp_message_ask = str_replace( '%order_items%', '*'.$order_items.'*', $whatsapp_message_ask );
		}
	}
	if ( strpos($thankyou_message, '%order_total%') !== false || strpos($whatsapp_message, '%order_total%') !== false || strpos($whatsapp_message_ask, '%order_total%') !== false || strpos($whatsapp_redirect, '%order_total%') !== false ) {
		$order_total = $order->get_formatted_order_total();
		if ( $mode == 'redirect' ) {
			$whatsapp_redirect = str_replace( '%order_total%', '*'.strip_tags($order_total).'*', $whatsapp_redirect );
		}
		else {
			$thankyou_message = str_replace( '%order_total%', '<strong>'.$order_total.'</strong>', $thankyou_message );
			$whatsapp_message = str_replace( '%order_total%', '*'.strip_tags($order_total).'*', $whatsapp_message );
			$whatsapp_message_ask = str_replace( '%order_total%', '*'.strip_tags($order_total).'*', $whatsapp_message_ask );
		}
	}
	if ( strpos($thankyou_message, '%site_name%') !== false || strpos($whatsapp_message, '%site_name%') !== false || strpos($whatsapp_message_ask, '%site_name%') !== false || strpos($whatsapp_redirect, '%site_name%') !== false ) {
		$site_name = get_bloginfo('name');
		if ( $mode == 'redirect' ) {
			$whatsapp_redirect = str_replace( '%site_name%', $site_name, $whatsapp_redirect );
		}
		else {
			$thankyou_message = str_replace( '%site_name%', $site_name, $thankyou_message );
			$whatsapp_message = str_replace( '%site_name%', $site_name, $whatsapp_message );
			$whatsapp_message_ask = str_replace( '%site_name%', $site_name, $whatsapp_message_ask );
		}
	}
	if ( strpos($thankyou_message, 'nk_details%') !== false || strpos($whatsapp_message, 'nk_details%') !== false || strpos($whatsapp_message_ask, 'nk_details%') !== false || strpos($thankyou_message, '%order_bank_details%') !== false || strpos($whatsapp_message, '%order_bank_details%') !== false || strpos($whatsapp_message_ask, '%order_bank_details%') !== false ) {
		$bank_details = '';
		$bank_details_whatsapp = '';
		if ( $mode == 'redirect' ) {
			$whatsapp_redirect = str_replace( '%order_bank_details%', '', $whatsapp_redirect );
		}
		else {
			if ( $order_status == 'on-hold' ) {
				$gateways = WC()->payment_gateways->get_available_payment_gateways();
				if ( isset( $gateways['bacs']->account_details ) ) {
					foreach ( $gateways['bacs']->account_details as $bank ) {
						if ( $bank['bank_name'] ) {
							$bank_details .= $bank['bank_name']."\n";
							$bank_details_whatsapp .= $bank['bank_name']."\n";
						}
						if ( $bank['account_number'] ) {
							$bank_details .= '<strong>'.$bank['account_number'].'</strong>'."\n";
							$bank_details_whatsapp .= '*'.$bank['account_number'].'*'."\n";
						}
						if ( $bank['account_name'] ) {
							$bank_details .= $bank['account_name']."\n";
							$bank_details_whatsapp .= $bank['account_name']."\n";
						}
						$bank_details .= "\n";
					}
				}
			}
			else {
				$bank_details = "<strong>TERIMAKASIH, Anda sudah melakukan pembayaran.</strong>\n";
			}
			$thankyou_message = str_replace( '%order_bank_details%', $bank_details, $thankyou_message );
			$whatsapp_message = str_replace( '%order_bank_details%', $bank_details_whatsapp, $whatsapp_message );
			$whatsapp_message_ask = str_replace( '%order_bank_details%', $bank_details_whatsapp, $whatsapp_message_ask );
			/* backward compatible */
			$thankyou_message = str_replace( '%bank_details%', $bank_details, $thankyou_message );
			$whatsapp_message = str_replace( '%bank_details%', $bank_details, $whatsapp_message );
			$whatsapp_message_ask = str_replace( '%bank_details%', $bank_details, $whatsapp_message_ask );
			$thankyou_message = str_replace( 'nk_details%', $bank_details, $thankyou_message );
			$whatsapp_message = str_replace( 'nk_details%', $bank_details, $whatsapp_message );
			$whatsapp_message_ask = str_replace( 'nk_details%', $bank_details, $whatsapp_message_ask );
		}
	}
	if ( strpos($thankyou_message, '%indo_ongkir_resi%') !== false || strpos($whatsapp_message, '%indo_ongkir_resi%') !== false || strpos($whatsapp_message_ask, '%indo_ongkir_resi%') !== false ) {
		if ( $mode == 'redirect' ) {
			$whatsapp_redirect = str_replace( '%indo_ongkir_resi%', '', $whatsapp_redirect );
		}
		else {
			$shipping = $order->get_items( 'shipping' );
			$resi_items = array();
			if ( !empty( $shipping ) ) {
				$resi = get_post_meta( $order->get_id(), '_indo_ongkir_resi', true );
				$date = get_post_meta( $order->get_id(), '_indo_ongkir_date', true );
				foreach ( $shipping as $item_id => $item ) {
					if ( isset($resi[$item_id]) && $resi[$item_id] ) {
						$resi_items[$item_id]['name'] = $item->get_name();
						$resi_items[$item_id]['items'] = $item->get_meta( 'Items' );
						$resi_items[$item_id]['resi'] = $resi[$item_id];
						$resi_items[$item_id]['date'] = $date[$item_id];
					}
				}
			}
			$indo_ongkir_resi = '';
			$indo_ongkir_resi_whatsapp = '';
			if ( ! empty( $resi_items ) ) {
				$resi_count = count( $resi_items );
				$indo_ongkir_resi = '<p>Resi Pengiriman:</p>';
				$indo_ongkir_resi_whatsapp = 'Resi Pengiriman:'."\n\n";
				foreach ( $resi_items as $resi_item ) {
					$indo_ongkir_resi .= '<p>'.$resi_item['name'].' ('.$resi_item['date'].')<br/><strong>'.$resi_item['resi'].'</strong></p>';
					$indo_ongkir_resi_whatsapp .= ''.$resi_item['name'].' ('.$resi_item['date'].')'."\n".'*'.$resi_item['resi'].'*'."\n\n";
				}
			}
			$thankyou_message = str_replace( '%indo_ongkir_resi%', $indo_ongkir_resi, $thankyou_message );
			$whatsapp_message = str_replace( '%indo_ongkir_resi%', $indo_ongkir_resi_whatsapp, $whatsapp_message );
			$whatsapp_message_ask = str_replace( '%indo_ongkir_resi%', $indo_ongkir_resi_whatsapp, $whatsapp_message_ask );
		}
	}
	if ( strpos($thankyou_message, '%payment_confirmation%') !== false || strpos($thankyou_message, '%payment_confirmation_link%') !== false || strpos($thankyou_message, '%whatsapp_confirmation%') !== false || strpos($thankyou_message, '%whatsapp_ask%') !== false ) {
		$payment_confirmation = '';
		$payment_confirmation_link = '';
		$whatsapp_confirmation = '';
		$whatsapp_ask = '';
		if ( $order_status == 'on-hold' ) {
			$link_url = larisdigital_get_integration_wc( 'wc_payment_confirm_link_url' );
			if ( ! empty( $link_url ) ) {
				$link_text = larisdigital_get_integration_wc( 'wc_payment_confirm_link_text' );
				if ( empty( $link_text ) ) {
					$link_text = esc_html__( 'Klik di sini untuk konfirmasi pembayaran', 'larisdigital-wp' );
				}
				if ( $plain_text ) {
					$payment_confirmation .= $link_text."\n\n".esc_url( $link_url )."\n\n";
					$payment_confirmation_link = $link_text."\n\n".esc_url( $link_url )."\n\n";
				}
				else {
					$payment_confirmation .= '<a class="button-block button alt" href="'.esc_url( $link_url ).'">'.$link_text.'</a>'."\n\n";
					$payment_confirmation_link = '<a class="button-block button alt" href="'.esc_url( $link_url ).'">'.$link_text.'</a>'."\n\n";
				}
			}
		}
		$whatsapp_phone = '';
		if ( $mode == 'redirect' ) {
			if ( function_exists('larisdigital_get_whatsapp_mod') ) {
				$whatsapp_phone = larisdigital_get_whatsapp_mod( 'wc_whatsapp_number' );
			}
		}
		else {
			if ( larisdigital_get_integration_wc( 'wc_payment_confirm_whatsapp_enable' ) ) {
				if ( function_exists('larisdigital_get_whatsapp_mod') ) {
					$whatsapp_phone = larisdigital_get_whatsapp_mod( 'wc_whatsapp_number' );
				}
			}
			if ( empty( $whatsapp_phone ) ) {
				$whatsapp_phone = larisdigital_get_integration_wc( 'wc_payment_confirm_whatsapp_phone' );
			}
		}
		if ( ! empty( $whatsapp_phone ) ) {
			$whatsapp_text = larisdigital_get_integration_wc( 'wc_payment_confirm_whatsapp_text' );
			if ( empty( $whatsapp_text ) ) {
				$whatsapp_text = esc_html__( 'Konfirmasi Pembayaran via WhatsApp', 'larisdigital-wp' );
			}
			$whatsapp_text_ask = larisdigital_get_integration_wc( 'wc_payment_confirm_whatsapp_text_ask' );
			if ( empty( $whatsapp_text_ask ) ) {
				$whatsapp_text_ask = esc_html__( 'Tanya via WhatsApp', 'larisdigital-wp' );
			}
			$whatsapp_number = trim( $whatsapp_phone );
			if ( function_exists('larisdigital_whatsapp_number_format') ) {
				$whatsapp_number = larisdigital_whatsapp_number_format( $whatsapp_number);
			}
			else {
				$whatsapp_number = preg_replace('/^8/','08', $whatsapp_number);
				$whatsapp_number = preg_replace('/[^0-9]/', '', $whatsapp_number);
				$whatsapp_number = preg_replace('/^620/','62', $whatsapp_number);
				$whatsapp_number = preg_replace('/^0/','62', $whatsapp_number);
			}
			$whatsapp_base = 'https://api.whatsapp.com/send?phone='.$whatsapp_number;
			$whatsapp_message = str_replace( '&nbsp;', ' ', $whatsapp_message );
			$whatsapp_link = $whatsapp_base.'&text='.rawurlencode( $whatsapp_message );
			$whatsapp_message_ask = str_replace( '&nbsp;', ' ', $whatsapp_message_ask );
			$whatsapp_link_ask = $whatsapp_base.'&text='.rawurlencode( $whatsapp_message_ask );
			if ( $mode == 'email' ) {
				$whatsapp_icon = '';
			}
			else {
				$whatsapp_icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg> ';
			}
			if ( $plain_text ) {
				if ( $order_status == 'on-hold' ) {
					$payment_confirmation .= $whatsapp_text."\n\n".esc_url( $whatsapp_link )."\n\n";
					$whatsapp_confirmation = $whatsapp_text."\n\n".esc_url( $whatsapp_link )."\n\n";
				}
				else {
					$payment_confirmation .= $whatsapp_text_ask."\n\n".esc_url( $whatsapp_link_ask )."\n\n";
				}				
				$whatsapp_ask = $whatsapp_text_ask."\n\n".esc_url( $whatsapp_link_ask )."\n\n";
			}
			else {
				if ( $order_status == 'on-hold' ) {
					$payment_confirmation .= '<a class="button-block '.( !$payment_confirmation ? 'button alt' : 'button' ).'" href="'. $whatsapp_link .'">'.$whatsapp_icon.$whatsapp_text.'</a>'."\n\n";
					$whatsapp_confirmation = '<a class="button-block button alt" href="'. $whatsapp_link .'">'.$whatsapp_icon.$whatsapp_text.'</a>'."\n\n";
				}
				else {
					$payment_confirmation .= '<a class="button-block '.( !$payment_confirmation ? 'button alt' : 'button' ).'" href="'. $whatsapp_link_ask .'">'.$whatsapp_icon.$whatsapp_text_ask.'</a>'."\n\n";
				}
				$whatsapp_ask = '<a class="button-block button alt" href="'. $whatsapp_link_ask .'">'.$whatsapp_icon.$whatsapp_text_ask.'</a>'."\n\n";
			}
		}
		$thankyou_message = str_replace( '%payment_confirmation%', $payment_confirmation, $thankyou_message );
		$thankyou_message = str_replace( '%payment_confirmation_link%', $payment_confirmation_link, $thankyou_message );
		$thankyou_message = str_replace( '%whatsapp_confirmation%', $whatsapp_confirmation, $thankyou_message );
		$thankyou_message = str_replace( '%whatsapp_ask%', $whatsapp_ask, $thankyou_message );
	}
	if ( $mode == 'redirect' ) {
		$whatsapp_phone = '';
		if ( larisdigital_get_integration_wc( 'wc_payment_confirm_whatsapp_enable' ) ) {
			if ( function_exists('larisdigital_get_whatsapp_mod') ) {
				$whatsapp_phone = larisdigital_get_whatsapp_mod( 'wc_whatsapp_number' );
			}
		}
		if ( ! empty( $whatsapp_phone ) ) {
			$whatsapp_text = larisdigital_get_integration_wc( 'wc_thankyou_redirect_button' );
			if ( empty( $whatsapp_text ) ) {
				$whatsapp_text = esc_html__( 'Chat Kami di WhatsApp', 'larisdigital-wp' );
			}
			$whatsapp_intro = larisdigital_get_integration_wc( 'wc_thankyou_redirect_intro' );
			if ( empty( $whatsapp_intro ) ) {
				$whatsapp_intro = esc_html__( 'Klik tombol di bawah ini jika Anda tidak secara otomatis diarahkan ke aplikasi WhatsApp.', 'larisdigital-wp' );
			}
			$whatsapp_number = trim( $whatsapp_phone );
			if ( function_exists('larisdigital_whatsapp_number_format') ) {
				$whatsapp_number = larisdigital_whatsapp_number_format( $whatsapp_number);
			}
			else {
				$whatsapp_number = preg_replace('/^8/','08', $whatsapp_number);
				$whatsapp_number = preg_replace('/[^0-9]/', '', $whatsapp_number);
				$whatsapp_number = preg_replace('/^620/','62', $whatsapp_number);
				$whatsapp_number = preg_replace('/^0/','62', $whatsapp_number);
			}
			$whatsapp_base = 'https://api.whatsapp.com/send?phone='.$whatsapp_number;
			$whatsapp_redirect = str_replace( '&nbsp;', ' ', $whatsapp_redirect );
			$whatsapp_link = $whatsapp_base.'&text='.rawurlencode( $whatsapp_redirect );
			$whatsapp_icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg>';
			echo '<p class="text-center" style="font-size:5rem;">'.$whatsapp_icon.'</p>';
			echo '<div class="spinkit-container text-center">
				<div class="spinkit-wave">
					<div class="spinkit-rect spinkit-rect1"></div>
					<div class="spinkit-rect spinkit-rect2"></div>
					<div class="spinkit-rect spinkit-rect3"></div>
					<div class="spinkit-rect spinkit-rect4"></div>
					<div class="spinkit-rect spinkit-rect5"></div>
				</div>
			</div>';
			echo '<p class="text-center">'.$whatsapp_intro.'</p>';
			echo '<p class="text-center"><a class="button alt" href="'. $whatsapp_link .'">'.$whatsapp_icon.' '.$whatsapp_text.'</a></p>'."\n\n";
			$whatsapp_delay = larisdigital_get_integration_wc( 'wc_thankyou_redirect_delay' );
			$whatsapp_delay = trim( $whatsapp_delay );
			if ( $whatsapp_delay === '0' ) {
				$whatsapp_delay = 0;
			}
			else {
				$whatsapp_delay = intval( $whatsapp_delay );
				if ( $whatsapp_delay < 1 ) {
					$whatsapp_delay = 3;
				}
			}
			echo '<meta http-equiv="refresh" content="'.$whatsapp_delay.'; url='.$whatsapp_link.'">';
		}
	}
	else {
		if ( $plain_text ) {
			echo wp_strip_all_tags( $thankyou_message )."\n\n";
			echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";
		}
		else {
			if ( $mode == 'order' ) {
				echo '<hr class="tp-order-divider-top" style="margin: 30px 0;" />';
			}
			echo wpautop( $thankyou_message );
			echo '<hr class="tp-order-divider-bottom" style="margin: 30px 0;" />';
		}
	}
}
