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

add_filter( 'larisdigital_customize_controls', 'larisdigital_wc_customize_controls_followup' );
function larisdigital_wc_customize_controls_followup( $controls ) {

	$controls['larisdigital_wc_section_followup'] = array(
		'title'    => esc_html__( 'WC - Orders Followup Buttons', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_wc_section_followup',
		'panel'    => 'larisdigital_wc_panel_settings',
		'type'     => 'section',
		'priority' => 130,
	);

	$controls['larisdigital_wc_heading_followup_params'] = array(
		'label'				=> '',
		'description'		=> '<p>'.esc_html__( 'Available Parameter:', 'larisdigital-wp' ).' <code>%site_name%</code>, <code>%order_id%</code>, <code>%order_date%</code>, <code>%order_status%</code>, <code>%order_items%</code>, <code>%order_total%</code>, <code>%billing_name%</code>, <code>%billing_email%</code>, <code>%billing_phone%</code>, <code>%billing_address%</code>, <code>%shipping_name%</code>, <code>%shipping_address%</code>, <code>%indo_ongkir_resi%</code>, <code>%order_bank_details%</code></p>',
		'setting'  			=> 'larisdigital_wc_heading_followup_params',
		'section'			=> 'larisdigital_wc_section_followup',
		'type'   			=> 'heading',
	);

	$controls['larisdigital_wc_heading_followup_whatsapp'] = array(
		'label'				=> esc_html__( 'WhatsApp Followup Buttons', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_heading_followup_whatsapp',
		'section'			=> 'larisdigital_wc_section_followup',
		'type'   			=> 'heading',
	);

	$controls['wc_followup_whatsapp_enable'] = array(
		'label'    			=> esc_html__( 'Enable Whatsapp Followup Buttons', 'larisdigital-wp' ),
		'setting'  			=> 'wc_followup_whatsapp_enable',
		'setting_type'		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section'			=> 'larisdigital_wc_section_followup',
		'type'     			=> 'checkbox',
		'default'			=> '1',
		'transport'			=> 'postMessage',
	);

	for ( $i=0; $i < 7 ; $i++ ) { 
		if ( $i == 0 ) {
			$id = 'wc_followup_whatsapp';
			$input_attrs = array(
				'placeholder' 	=> 'Halo %billing_name%,

Terimakasih untuk pemesanan Anda sebagai berikut: 

Order ID: %order_id%
Produk: %order_items%
Total Tagihan: %order_total%

Harap segera lakukan pembayaran supaya pesanan Anda bisa segera kami proses ya.

%order_bank_details%

Terimakasih banyak sudah berbelanja di website kami.

Salam,
%site_name%'
			);
		}
		else {
			$id = 'wc_followup_whatsapp_'.$i;
			$input_attrs = array();			
		}
		$controls[$id] = array(
			'label'				=> sprintf( esc_html__( 'WhatsApp Followup "Belum Dibayar" untuk hari ke-%s', 'larisdigital-wp' ), $i ),
			'setting'  			=> $id,
			'setting_type'		=> 'option_mod',
			'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
			'section'			=> 'larisdigital_wc_section_followup',
			'type'				=> 'textarea',
			'input_attrs' 		=> $input_attrs,
			'transport'			=> 'postMessage',
		);
	}

	$controls['wc_followup_whatsapp_processing'] = array(
		'label'				=> esc_html__( 'WhatsApp Followup "Pesanan Diproses"', 'larisdigital-wp' ),
		'setting'  			=> 'wc_followup_whatsapp_processing',
		'setting_type'		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section'			=> 'larisdigital_wc_section_followup',
		'type'				=> 'textarea',
		'input_attrs' 		=> array(
			'placeholder' 	=> 'Halo %billing_name%,

Terimakasih untuk pemesanan Anda sebagai berikut: 

Order ID: %order_id%
Tanggal: %order_date%
Status: %order_status%
Produk: %order_items%
Total Tagihan: %order_total%

Pesanan Anda saat ini sedang kami proses.

Terimakasih banyak sudah berbelanja di website kami.

Salam,
%site_name%',
		),
		'transport'			=> 'postMessage',
	);

	$controls['wc_followup_whatsapp_completed'] = array(
		'label'				=> esc_html__( 'WhatsApp Followup "Pesanan Selesai"', 'larisdigital-wp' ),
		'setting'  			=> 'wc_followup_whatsapp_completed',
		'setting_type'		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section'			=> 'larisdigital_wc_section_followup',
		'type'				=> 'textarea',
		'input_attrs' 		=> array(
			'placeholder' 	=> 'Halo %billing_name%,

Terimakasih untuk pemesanan Anda sebagai berikut: 

Order ID: %order_id%
Tanggal: %order_date%
Status: %order_status%
Produk: %order_items%
Total Tagihan: %order_total%

Pesanan Anda saat ini telah selesai kami kirimkan.

%indo_ongkir_resi%

Terimakasih banyak sudah berbelanja di website kami.

Salam,
%site_name%',
		),
		'transport'			=> 'postMessage',
	);

	$controls['larisdigital_wc_heading_followup_sms'] = array(
		'label'				=> esc_html__( 'SMS Followup Buttons', 'larisdigital-wp' ),
		'description'		=> '<p class="larisdigital-alert larisdigital-alert-danger larisdigital-alert-with-icon">
								<span class="dashicons dashicons-megaphone"></span> '.esc_html__( 'Hanya tampil jika dikunjungi via perangkat mobile, tidak akan terlihat di desktop!', 'larisdigital-wp' ).'
								</p>',
		'setting'  			=> 'larisdigital_wc_heading_followup_sms',
		'section'			=> 'larisdigital_wc_section_followup',
		'type'   			=> 'heading',
	);

	$controls['wc_followup_sms_enable'] = array(
		'label'    			=> esc_html__( 'Enable SMS Followup Buttons', 'larisdigital-wp' ),
		'setting'  			=> 'wc_followup_sms_enable',
		'setting_type'		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section'			=> 'larisdigital_wc_section_followup',
		'type'     			=> 'checkbox',
		'transport'			=> 'postMessage',
	);

	for ( $i=0; $i < 7 ; $i++ ) { 
		if ( $i == 0 ) {
			$id = 'wc_followup_sms';
			$input_attrs = array(
				'placeholder' 	=> 'Halo %billing_name%, terimakasih untuk pesanan #%order_id% di %site_name%. Harap segera lakukan pembayaran.',
			);
		}
		else {
			$id = 'wc_followup_sms_'.$i;
			$input_attrs = array();			
		}
		$controls[$id] = array(
			'label'				=> sprintf( esc_html__( 'SMS Followup "Belum Dibayar" untuk hari ke-%s', 'larisdigital-wp' ), $i ),
			'setting'  			=> $id,
			'setting_type'		=> 'option_mod',
			'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
			'section'			=> 'larisdigital_wc_section_followup',
			'type'				=> 'textarea',
			'input_attrs' 		=> $input_attrs,
			'transport'			=> 'postMessage',
		);
	}

	$controls['wc_followup_sms_processing'] = array(
		'label'				=> esc_html__( 'SMS Followup "Pesanan Diproses"', 'larisdigital-wp' ),
		'setting'  			=> 'wc_followup_sms_processing',
		'setting_type'		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section'			=> 'larisdigital_wc_section_followup',
		'type'				=> 'textarea',
		'input_attrs' 		=> array(
			'placeholder' 	=> 'Halo %billing_name%, pesanan #%order_id% di %site_name% sedang diproses.',
		),
		'transport'			=> 'postMessage',
	);

	$controls['wc_followup_sms_completed'] = array(
		'label'				=> esc_html__( 'SMS Followup "Pesanan Selesai"', 'larisdigital-wp' ),
		'setting'  			=> 'wc_followup_sms_completed',
		'setting_type'		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section'			=> 'larisdigital_wc_section_followup',
		'type'				=> 'textarea',
		'input_attrs' 		=> array(
			'placeholder' 	=> 'Halo %billing_name%, pesanan #%order_id% di %site_name% telah dikirimkan. %indo_ongkir_resi%',
		),
		'transport'			=> 'postMessage',
	);

	$controls['larisdigital_whatsapp_menu_followup'] = array(
		'label'				=> esc_html__( 'Manual WhatsApp Order Follow-up', 'larisdigital-wp' ),
		'description' 		=> '<p class="larisdigital-alert larisdigital-alert-with-icon">
								<span class="dashicons dashicons-admin-tools"></span> <a href="javascript:wp.customize.control( \'larisdigital_wc_heading_followup_whatsapp\' ).focus();">'.esc_html__( 'CLICK HERE to go to Manual WhatsApp Order Follow-up settings', 'larisdigital-wp' ).'</a>
								</p>',
		'setting'  			=> 'larisdigital_whatsapp_menu_followup',
		'section'			=> 'larisdigital_section_whatsapp',
		'type'   			=> 'heading',
		'priority'   		=> 40,
	);

	return $controls;
}

add_filter( 'manage_edit-shop_order_columns', 'larisdigital_wc_followup_column_register' );
function larisdigital_wc_followup_column_register( $columns ) {
	if ( isset( $columns['wc_actions'] ) ) {
		if ( larisdigital_get_integration_wc('wc_followup_whatsapp_enable', '1') ) {
			$columns = larisdigital_wc_followup_array_insert_before( 'wc_actions', $columns, 'wc-followup-whatsapp', esc_html__( 'WhatsApp', 'larisdigital-wp' ) );
		}
		if ( larisdigital_get_integration_wc('wc_followup_sms_enable') ) {
			if ( wp_is_mobile() ) {
				$columns = larisdigital_wc_followup_array_insert_before( 'wc_actions', $columns, 'wc-followup-sms', esc_html__( 'SMS', 'larisdigital-wp' ) );
			}
		}
	}
	else {
		if ( larisdigital_get_integration_wc('wc_followup_whatsapp_enable', '1') ) {
			$columns['wc-followup-whatsapp'] = esc_html__( 'WhatsApp', 'larisdigital-wp' );
		}
		if ( larisdigital_get_integration_wc('wc_followup_sms_enable') ) {
			if ( wp_is_mobile() ) {
				$columns['wc-followup-sms'] = esc_html__( 'SMS', 'larisdigital-wp' );
			}
		}
	}
	return $columns;
}

add_action( 'manage_posts_custom_column', 'larisdigital_wc_followup_column_content' );
function larisdigital_wc_followup_column_content( $column ) {
	if ( 'wc-followup-whatsapp' == $column ) {
		larisdigital_wc_followup_buttons_output( 'whatsapp' );
	}
	elseif ( 'wc-followup-sms' == $column ) {
		larisdigital_wc_followup_buttons_output( 'sms' );
	}
}

add_action( 'add_meta_boxes', 'larisdigital_wc_followup_meta_boxes' );
function larisdigital_wc_followup_meta_boxes() {
	$followup_buttons = false;
	if ( larisdigital_get_integration_wc('wc_followup_whatsapp_enable', '1') ) {
		$followup_buttons = true;
	}
	if ( larisdigital_get_integration_wc('wc_followup_sms_enable') ) {
		if ( wp_is_mobile() ) {
			$followup_buttons = true;
		}
	}
	if ( ! $followup_buttons ) {
		return;
	}
	add_meta_box(
		'larisdigital_wc_followup',
		esc_html__( 'TP - Followup Buttons', 'larisdigital-wp' ),
		'larisdigital_wc_followup_meta_box',
		array( 'shop_order' ),
		'side',
		'low'
	);
}

function larisdigital_wc_followup_meta_box( $post ) {
	if ( larisdigital_get_integration_wc('wc_followup_whatsapp_enable', '1') ) {
		echo '<p>';
		larisdigital_wc_followup_buttons_output( 'whatsapp' );
		echo '</p>';
	}
	if ( larisdigital_get_integration_wc('wc_followup_sms_enable') ) {
		if ( wp_is_mobile() ) {
			echo '<p>';
			larisdigital_wc_followup_buttons_output( 'sms' );
			echo '</p>';
		}
	}
}

function larisdigital_wc_followup_buttons_output( $mode = 'whatsapp' ) {
	global $post;
	$post_id = $post->ID;
	$order = new WC_Order( $post_id );
	if ( is_wp_error( $order ) ) {
		return;
	}

	$order_status = $order->get_status();

	$site_name = '';
	$order_id = '';
	$order_date = '';
	$order_status_label = '';
	$order_items = '';
	$order_total = '';
	$billing_name = '';
	$billing_email = '';
	$billing_phone = '';
	$billing_address = '';
	$shipping_name = '';
	$shipping_address = '';
	$order_bank_details = '';
	$indo_ongkir_resi = '';
	$order_bank_details = '';

	$billing_phone = $order->get_billing_phone();
	if ( empty( $billing_phone ) ) {
		echo esc_html__( 'No phone number', 'larisdigital-wp' );
		return;
	}

	$date_highlight = '';
	if ( 'on-hold' == $order_status ) {
		$date_order = wc_format_datetime( $order->get_date_created(), 'Y-m-d' );
		$today = date_i18n('Y-m-d H:i:s');
		for ( $i=0; $i < 7; $i++ ) { 
			$time_check = strtotime( $today ) - $i*24*60*60;;
			$date_check = date( 'Y-m-d', $time_check );
			if ( $date_check == $date_order ) {
				$date_highlight = $i;
			}
		}
	}

	$whatsapp_number = $billing_phone;
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

	$sms_base = 'sms:+'.$whatsapp_number;

	if ( 'whatsapp' == $mode ) {

		$whatsapp_buttons = array();
		if ( 'on-hold' == $order_status ) {
			for ( $i=0; $i < 7; $i++ ) { 
				$whatsapp_message = '';
				if ( $i == 0 ) {
					$whatsapp_message = larisdigital_get_integration_wc( 'wc_followup_whatsapp' );
					if ( ! $whatsapp_message ) {
						$whatsapp_message = 'Halo %billing_name%,

Terimakasih untuk pemesanan Anda sebagai berikut: 

Order ID: %order_id%
Produk: %order_items%
Total Tagihan: %order_total%

Harap segera lakukan pembayaran supaya pesanan Anda bisa segera kami proses ya.

%order_bank_details%

Terimakasih banyak sudah berbelanja di website kami.

Salam,
%site_name%';
					}
				}
				else {
					$whatsapp_message = larisdigital_get_integration_wc( 'wc_followup_whatsapp_'.$i );
				}
				if ( $whatsapp_message ) {
					$whatsapp_buttons[$i] = $whatsapp_message;
				}
			}
		}
		elseif ( 'processing' == $order_status ) {
			$whatsapp_message = larisdigital_get_integration_wc( 'wc_followup_whatsapp_processing' );
			if ( ! $whatsapp_message ) {
				$whatsapp_message = 'Halo %billing_name%,

Terimakasih untuk pemesanan Anda sebagai berikut: 

Order ID: %order_id%
Tanggal: %order_date%
Status: %order_status%
Produk: %order_items%
Total Tagihan: %order_total%

Pesanan Anda saat ini sedang kami proses.

Terimakasih banyak sudah berbelanja di website kami.

Salam,
%site_name%';
			}
			if ( $whatsapp_message ) {
				$whatsapp_buttons['processing'] = $whatsapp_message;
			}
		}
		elseif ( 'completed' == $order_status ) {
			$whatsapp_message = larisdigital_get_integration_wc( 'wc_followup_whatsapp_completed' );
			if ( ! $whatsapp_message ) {
				$whatsapp_message = 'Halo %billing_name%,

Terimakasih untuk pemesanan Anda sebagai berikut: 

Order ID: %order_id%
Tanggal: %order_date%
Status: %order_status%
Produk: %order_items%
Total Tagihan: %order_total%

Pesanan Anda saat ini telah selesai kami kirimkan.

%indo_ongkir_resi%

Terimakasih banyak sudah berbelanja di website kami.

Salam,
%site_name%';
			}
			if ( $whatsapp_message ) {
				$whatsapp_buttons['completed'] = $whatsapp_message;
			}
		}
		if ( !empty( $whatsapp_buttons ) ) {
			foreach ( $whatsapp_buttons as $whatsapp_button_id => $whatsapp_message ) {
				if ( $whatsapp_message ) {
					if ( strpos( $whatsapp_message, '%site_name%') !== false ) {
						if ( ! $site_name ) {
							$site_name = get_bloginfo('name');
						}
						$whatsapp_message = str_replace( '%site_name%', $site_name, $whatsapp_message );
					}
					if ( strpos( $whatsapp_message, '%order_id%') !== false ) {
						if ( ! $order_id ) {
							$order_id = $order->get_order_number();
						}
						$whatsapp_message = str_replace( '%order_id%', $order_id, $whatsapp_message );
					}
					if ( strpos( $whatsapp_message, '%order_date%') !== false ) {
						if ( ! $order_date ) {
							$order_date = wc_format_datetime( $order->get_date_created() );
						}
						$whatsapp_message = str_replace( '%order_date%', $order_date, $whatsapp_message );
					}
					if ( strpos( $whatsapp_message, '%order_status%') !== false ) {
						if ( ! $order_status_label ) {
							$order_status_label = wc_get_order_status_name( $order->get_status() );
						}
						$whatsapp_message = str_replace( '%order_status%', $order_status_label, $whatsapp_message );
					}
					if ( strpos( $whatsapp_message, '%order_items%') !== false ) {
						if ( ! $order_items ) {
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
						}
						$whatsapp_message = str_replace( '%order_items%', $order_items, $whatsapp_message );
					}
					if ( strpos( $whatsapp_message, '%order_total%') !== false ) {
						if ( ! $order_total ) {
							$order_total = $order->get_formatted_order_total();
							$order_total = strip_tags( $order_total );
						}
						$whatsapp_message = str_replace( '%order_total%', $order_total, $whatsapp_message );
					}
					if ( strpos( $whatsapp_message, '%billing_name%') !== false ) {
						if ( ! $billing_name ) {
							$billing_name = $order->get_billing_first_name();
						}
						$whatsapp_message = str_replace( '%billing_name%', $billing_name, $whatsapp_message );
					}
					if ( strpos( $whatsapp_message, '%billing_email%') !== false ) {
						if ( ! $billing_email ) {
							$billing_email = $order->get_billing_email();
						}
						$whatsapp_message = str_replace( '%billing_email%', $billing_email, $whatsapp_message );
					}
					if ( strpos( $whatsapp_message, '%billing_phone%') !== false ) {
						if ( ! $billing_phone ) {
							$billing_phone = $order->get_billing_phone();
						}
						$whatsapp_message = str_replace( '%billing_phone%', $billing_phone, $whatsapp_message );
					}
					if ( strpos( $whatsapp_message, '%billing_address%') !== false ) {
						if ( ! $billing_address ) {
							$billing_address = $order->get_formatted_billing_address('');
							$billing_first_name = $order->get_billing_first_name();
							$billing_last_name = $order->get_billing_last_name();
							$billing_address = str_replace( $billing_first_name.' '.$billing_last_name.'<br/>', "", $billing_address );
							$billing_address = str_replace( array( '<br>', '<br/>' ), " \n", $billing_address );
						}
						$whatsapp_message = str_replace( '%billing_address%', $billing_address, $whatsapp_message );
					}
					if ( strpos( $whatsapp_message, '%shipping_name%') !== false ) {
						if ( ! $shipping_name ) {
							$shipping_name = $order->get_shipping_first_name();
						}
						$whatsapp_message = str_replace( '%shipping_name%', $shipping_name, $whatsapp_message );
					}
					if ( strpos( $whatsapp_message, '%shipping_address%') !== false ) {
						if ( ! $shipping_address ) {
							$shipping_address = $order->get_formatted_shipping_address('');
							$shipping_first_name = $order->get_shipping_first_name();
							$shipping_last_name = $order->get_shipping_last_name();
							$shipping_address = str_replace( $shipping_first_name.' '.$shipping_last_name.'<br/>', "", $shipping_address );
							$shipping_address = str_replace( array( '<br>', '<br/>' ), " \n", $shipping_address );
						}
						$whatsapp_message = str_replace( '%shipping_address%', $shipping_address, $whatsapp_message );
					}
					if ( strpos( $whatsapp_message, '%indo_ongkir_resi%') !== false ) {
						if ( ! $indo_ongkir_resi ) {
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
							if ( ! empty( $resi_items ) ) {
								$resi_count = count( $resi_items );
								$indo_ongkir_resi .= 'Resi Pengiriman:'."\n\n";
								foreach ( $resi_items as $resi_item ) {
									$indo_ongkir_resi .= ''.$resi_item['name'].' ('.$resi_item['date'].')'."\n".'*'.$resi_item['resi'].'*'."\n\n";
								}
							}
						}
						$whatsapp_message = str_replace( '%indo_ongkir_resi%', $indo_ongkir_resi, $whatsapp_message );
					}
					if ( strpos( $whatsapp_message, '%order_bank_details%') !== false ) {
						if ( ! $order_bank_details ) {
							if ( $order_status == 'on-hold' && $order->get_payment_method() == 'bacs' ) {
								$gateways = WC()->payment_gateways->get_available_payment_gateways();
								if ( isset( $gateways['bacs']->account_details ) ) {
									foreach ( $gateways['bacs']->account_details as $bank ) {
										if ( $bank['bank_name'] ) {
											$order_bank_details .= $bank['bank_name']."\n";
										}
										if ( $bank['account_number'] ) {
											$order_bank_details .= '*'.$bank['account_number'].'*'."\n";
										}
										if ( $bank['account_name'] ) {
											$order_bank_details .= $bank['account_name']."\n";
										}
										$order_bank_details .= "\n";
									}
								}
							}
						}
						$whatsapp_message = str_replace( '%order_bank_details%', $order_bank_details, $whatsapp_message );
					}

					$whatsapp_message = str_replace( '&nbsp;', ' ', $whatsapp_message );
					$whatsapp_link = $whatsapp_base.'&text='.rawurlencode($whatsapp_message);
					$whatsapp_class = 'button-secondary';
					if ( $date_highlight !== '' && $date_highlight == $whatsapp_button_id ) {
						$whatsapp_class = 'button-primary';
					}
					echo '<a class="button '.$whatsapp_class.' button-followup-whatsapp" href="'.$whatsapp_link.'" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg></a> ';
				}
			}
		}
		else {
			echo '<a class="button button-secondary button-followup-whatsapp" href="'.$whatsapp_base.'" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg></a> ';
		}
	}
	elseif ( 'sms' == $mode ) {

		$sms_buttons = array();
		if ( 'on-hold' == $order_status ) {
			for ( $i=0; $i < 7; $i++ ) { 
				$sms_message = '';
				if ( $i == 0 ) {
					$sms_message = larisdigital_get_integration_wc( 'wc_followup_sms' );
					if ( ! $sms_message ) {
						$sms_message = 'Halo %billing_name%, terimakasih untuk pesanan #%order_id% di %site_name%. Harap segera lakukan pembayaran.';
					}
				}
				else {
					$sms_message = larisdigital_get_integration_wc( 'wc_followup_sms_'.$i );
				}
				if ( $sms_message ) {
					$sms_buttons[$i] = $sms_message;
				}
			}
		}
		elseif ( 'processing' == $order_status ) {
			$sms_message = larisdigital_get_integration_wc( 'wc_followup_sms_processing' );
			if ( ! $sms_message ) {
				$sms_message = 'Halo %billing_name%, pesanan #%order_id% di %site_name% sedang diproses.';
			}
			if ( $sms_message ) {
				$sms_buttons['processing'] = $sms_message;
			}
		}
		elseif ( 'completed' == $order_status ) {
			$sms_message = larisdigital_get_integration_wc( 'wc_followup_sms_completed' );
			if ( ! $sms_message ) {
				$sms_message = 'Halo %billing_name%, pesanan #%order_id% di %site_name% telah dikirimkan. %indo_ongkir_resi%';
			}
			if ( $sms_message ) {
				$sms_buttons['completed'] = $sms_message;
			}
		}
		if ( !empty( $sms_buttons ) ) {
			foreach ( $sms_buttons as $sms_button_id => $sms_message ) {
				if ( $sms_message ) {
					if ( strpos( $sms_message, '%site_name%') !== false ) {
						if ( ! $site_name ) {
							$site_name = get_bloginfo('name');
						}
						$sms_message = str_replace( '%site_name%', $site_name, $sms_message );
					}
					if ( strpos( $sms_message, '%order_id%') !== false ) {
						if ( ! $order_id ) {
							$order_id = $order->get_order_number();
						}
						$sms_message = str_replace( '%order_id%', $order_id, $sms_message );
					}
					if ( strpos( $sms_message, '%order_date%') !== false ) {
						if ( ! $order_date ) {
							$order_date = wc_format_datetime( $order->get_date_created() );
						}
						$sms_message = str_replace( '%order_date%', $order_date, $sms_message );
					}
					if ( strpos( $sms_message, '%order_status%') !== false ) {
						if ( ! $order_status_label ) {
							$order_status_label = wc_get_order_status_name( $order->get_status() );
						}
						$sms_message = str_replace( '%order_status%', $order_status_label, $sms_message );
					}
					if ( strpos( $sms_message, '%order_items%') !== false ) {
						if ( ! $order_items ) {
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
						}
						$sms_message = str_replace( '%order_items%', $order_items, $sms_message );
					}
					if ( strpos( $sms_message, '%order_total%') !== false ) {
						if ( ! $order_total ) {
							$order_total = $order->get_formatted_order_total();
							$order_total = strip_tags( $order_total );
						}
						$sms_message = str_replace( '%order_total%', $order_total, $sms_message );
					}
					if ( strpos( $sms_message, '%billing_name%') !== false ) {
						if ( ! $billing_name ) {
							$billing_name = $order->get_billing_first_name();
						}
						$sms_message = str_replace( '%billing_name%', $billing_name, $sms_message );
					}
					if ( strpos( $sms_message, '%billing_email%') !== false ) {
						if ( ! $billing_email ) {
							$billing_email = $order->get_billing_email();
						}
						$sms_message = str_replace( '%billing_email%', $billing_email, $sms_message );
					}
					if ( strpos( $sms_message, '%billing_phone%') !== false ) {
						if ( ! $billing_phone ) {
							$billing_phone = $order->get_billing_phone();
						}
						$sms_message = str_replace( '%billing_phone%', $billing_phone, $sms_message );
					}
					if ( strpos( $sms_message, '%billing_address%') !== false ) {
						if ( ! $billing_address ) {
							$billing_address = $order->get_formatted_billing_address('');
							$billing_first_name = $order->get_billing_first_name();
							$billing_last_name = $order->get_billing_last_name();
							$billing_address = str_replace( $billing_first_name.' '.$billing_last_name.'<br/>', "", $billing_address );
							$billing_address = str_replace( array( '<br>', '<br/>' ), " \n", $billing_address );
						}
						$sms_message = str_replace( '%billing_address%', $billing_address, $sms_message );
					}
					if ( strpos( $sms_message, '%shipping_name%') !== false ) {
						if ( ! $shipping_name ) {
							$shipping_name = $order->get_shipping_first_name();
						}
						$sms_message = str_replace( '%shipping_name%', $shipping_name, $sms_message );
					}
					if ( strpos( $sms_message, '%shipping_address%') !== false ) {
						if ( ! $shipping_address ) {
							$shipping_address = $order->get_formatted_shipping_address('');
							$shipping_first_name = $order->get_shipping_first_name();
							$shipping_last_name = $order->get_shipping_last_name();
							$shipping_address = str_replace( $shipping_first_name.' '.$shipping_last_name.'<br/>', "", $shipping_address );
							$shipping_address = str_replace( array( '<br>', '<br/>' ), " \n", $shipping_address );
						}
						$sms_message = str_replace( '%shipping_address%', $shipping_address, $sms_message );
					}
					if ( strpos( $sms_message, '%indo_ongkir_resi%') !== false ) {
						if ( ! $indo_ongkir_resi ) {
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
							if ( ! empty( $resi_items ) ) {
								$resi_count = count( $resi_items );
								$indo_ongkir_resi .= ' Resi Pengiriman:';
								foreach ( $resi_items as $resi_item ) {
									$indo_ongkir_resi .= ' '.$resi_item['name'].' ('.$resi_item['date'].') '.$resi_item['resi'].' ';
								}
							}
						}
						$sms_message = str_replace( '%indo_ongkir_resi%', $indo_ongkir_resi, $sms_message );
					}
					if ( strpos( $sms_message, '%order_bank_details%') !== false ) {
						if ( ! $order_bank_details ) {
							if ( $order_status == 'on-hold' && $order->get_payment_method() == 'bacs' ) {
								$gateways = WC()->payment_gateways->get_available_payment_gateways();
								if ( isset( $gateways['bacs']->account_details ) ) {
									foreach ( $gateways['bacs']->account_details as $bank ) {
										if ( $bank['bank_name'] ) {
											$order_bank_details .= ' '.$bank['bank_name'];
										}
										if ( $bank['account_number'] ) {
											$order_bank_details .= ' '.$bank['account_number'];
										}
										if ( $bank['account_name'] ) {
											$order_bank_details .= ' '.$bank['account_name'];
										}
										$order_bank_details .= ' ';
									}
								}
							}
						}
						$sms_message = str_replace( '%order_bank_details%', $order_bank_details, $sms_message );
					}

					$sms_message = str_replace( '&nbsp;', ' ', $sms_message );
					$sms_separator = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone") ? '&' : '?';
					$sms_link = $sms_base . $sms_separator . 'body=' . rawurlencode($sms_message);

					$sms_class = 'button-secondary';
					if ( $date_highlight !== '' && $date_highlight == $sms_button_id ) {
						$sms_class = 'button-primary';
					}

					echo '<a class="button '.$sms_class.' button-followup-sms" href="'.$sms_link.'" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M144 208c-17.7 0-32 14.3-32 32s14.3 32 32 32 32-14.3 32-32-14.3-32-32-32zm112 0c-17.7 0-32 14.3-32 32s14.3 32 32 32 32-14.3 32-32-14.3-32-32-32zm112 0c-17.7 0-32 14.3-32 32s14.3 32 32 32 32-14.3 32-32-14.3-32-32-32zM256 32C114.6 32 0 125.1 0 240c0 47.6 19.9 91.2 52.9 126.3C38 405.7 7 439.1 6.5 439.5c-6.6 7-8.4 17.2-4.6 26S14.4 480 24 480c61.5 0 110-25.7 139.1-46.3C192 442.8 223.2 448 256 448c141.4 0 256-93.1 256-208S397.4 32 256 32zm0 368c-26.7 0-53.1-4.1-78.4-12.1l-22.7-7.2-19.5 13.8c-14.3 10.1-33.9 21.4-57.5 29 7.3-12.1 14.4-25.7 19.9-40.2l10.6-28.1-20.6-21.8C69.7 314.1 48 282.2 48 240c0-88.2 93.3-160 208-160s208 71.8 208 160-93.3 160-208 160z"/></svg></a> ';
				}
			}
		}
		else {
			echo '<a class="button button-secondary button-followup-sms" href="'.$sms_base.'" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M144 208c-17.7 0-32 14.3-32 32s14.3 32 32 32 32-14.3 32-32-14.3-32-32-32zm112 0c-17.7 0-32 14.3-32 32s14.3 32 32 32 32-14.3 32-32-14.3-32-32-32zm112 0c-17.7 0-32 14.3-32 32s14.3 32 32 32 32-14.3 32-32-14.3-32-32-32zM256 32C114.6 32 0 125.1 0 240c0 47.6 19.9 91.2 52.9 126.3C38 405.7 7 439.1 6.5 439.5c-6.6 7-8.4 17.2-4.6 26S14.4 480 24 480c61.5 0 110-25.7 139.1-46.3C192 442.8 223.2 448 256 448c141.4 0 256-93.1 256-208S397.4 32 256 32zm0 368c-26.7 0-53.1-4.1-78.4-12.1l-22.7-7.2-19.5 13.8c-14.3 10.1-33.9 21.4-57.5 29 7.3-12.1 14.4-25.7 19.9-40.2l10.6-28.1-20.6-21.8C69.7 314.1 48 282.2 48 240c0-88.2 93.3-160 208-160s208 71.8 208 160-93.3 160-208 160z"/></svg></a> ';
		}
	}
}

add_action( 'admin_head', 'larisdigital_wc_followup_admin_style' );
function larisdigital_wc_followup_admin_style() {
	echo '<style>
	svg { width: 1em; height: 1em; fill: currentColor; display: inline-block; vertical-align: middle; margin-top: -2px; }
	.button-followup-whatsapp, .button-followup-sms { padding: 0 7px 1px !important; margin: 0 2px 7px 0 !important; }
	@media screen and (max-width: 782px) {
		.post-type-shop_order .wp-list-table td.column-order_status, 
		.post-type-shop_order .wp-list-table td.column-wc-followup-whatsapp,
		.post-type-shop_order .wp-list-table td.column-wc-followup-sms {
			float: none !important;
			padding-left: 0 !important;
			display: block !important;
		}
		.post-type-shop_order .wp-list-table td.column-wc-followup-whatsapp:before,
		.post-type-shop_order .wp-list-table td.column-wc-followup-sms:before {
			display: none !important;
		}
	}
	</style>';
}

// credits http://eosrei.net/articles/2011/11/php-arrayinsertafter-arrayinsertbefore
function larisdigital_wc_followup_array_insert_before($key, array &$array, $new_key, $new_value) {
	if (array_key_exists($key, $array)) {
		$new = array();
		foreach ($array as $k => $value) {
			if ($k === $key) {
				$new[$new_key] = $new_value;
			}
			$new[$k] = $value;
		}
		return $new;
	}
	return false;
}

// credits http://eosrei.net/articles/2011/11/php-arrayinsertafter-arrayinsertbefore
function larisdigital_wc_followup_array_insert_after($key, array &$array, $new_key, $new_value) {
	if (array_key_exists($key, $array)) {
		$new = array();
		foreach ($array as $k => $value) {
			$new[$k] = $value;
			if ($k === $key) {
				$new[$new_key] = $new_value;
			}
		}
		return $new;
	}
	return false;
}
