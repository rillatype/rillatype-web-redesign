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

add_filter( 'larisdigital_customize_controls', 'larisdigital_customize_controls_fbpixel_woocommerce' );
function larisdigital_customize_controls_fbpixel_woocommerce( $controls ) {

	$controls['larisdigital_heading_fbpixel_woocommerce'] = array(
		'label'		=> esc_html__( 'WooCommerce', 'larisdigital-wp' ),
		'setting'  	=> 'larisdigital_heading_fbpixel_woocommerce',
		'section'	=> 'larisdigital_section_fbpixel',
		'type'   	=> 'heading',
		'priority'	=> 20,
	);

	$controls['larisdigital_warning_fbpixel_facebookcommerce'] = array(
		'label'		=> esc_html__( 'Facebook WooCommerce Plugin is Active!', 'larisdigital-wp' ),
		'description' => esc_html__( 'Facebook Pixel events on WooCommerce page is from this plugin, not from the theme.', 'larisdigital-wp' ),
		'setting'  	=> 'larisdigital_warning_fbpixel_facebookcommerce',
		'section'	=> 'larisdigital_section_fbpixel',
		'type'   	=> 'warning',
		'active_callback' => 'larisdigital_callback_fbpixel_facebookcommerce',
		'priority'	=> 20,
	);

	$controls['larisdigital_warning_fbpixel_pixelcaffeine'] = array(
		'label'		=> esc_html__( 'Pixel Caffeine Plugin is Active!', 'larisdigital-wp' ),
		'description' => esc_html__( 'Facebook Pixel events on WooCommerce page is from this plugin, not from the theme.', 'larisdigital-wp' ),
		'setting'  	=> 'larisdigital_warning_fbpixel_pixelcaffeine',
		'section'	=> 'larisdigital_section_fbpixel',
		'type'   	=> 'warning',
		'active_callback' => 'larisdigital_callback_fbpixel_pixelcaffeine',
		'priority'	=> 20,
	);

	$controls['larisdigital_warning_fbpixel_pixelyoursite'] = array(
		'label'		=> esc_html__( 'PixelYourSite Plugin is Active!', 'larisdigital-wp' ),
		'description' => esc_html__( 'Facebook Pixel events on WooCommerce page is from this plugin, not from the theme.', 'larisdigital-wp' ),
		'setting'  	=> 'larisdigital_warning_fbpixel_pixelyoursite',
		'section'	=> 'larisdigital_section_fbpixel',
		'type'   	=> 'warning',
		'active_callback' => 'larisdigital_callback_fbpixel_pixelyoursite',
		'priority'	=> 20,
	);

	$controls['fbpixel_woocommerce_disable'] = array(
		'label'    => esc_html__( 'Disable Facebook Pixel Events from this theme on WooCommerce Pages', 'larisdigital-wp' ),
		'description' => esc_html__( 'Use this option if you want to use other plugin to handle Facebook Pixel on WooCommerce Pages.', 'larisdigital-wp' ),
		'setting'  => 'fbpixel_woocommerce_disable',
		'setting_type' => 'option_mod',
		'setting_db' => LARISDIGITAL_INTEGRATIONS_DB,
		'section'  => 'larisdigital_section_fbpixel',
		'type'     => 'checkbox',
		'active_callback' => 'larisdigital_callback_fbpixel_woocommerce_default',
		'priority'	=> 20,
	);

	$controls['fbpixel_woocommerce_event_search'] = array(
		'label'    => sprintf( esc_html__( 'FB Pixel Event on %s', 'larisdigital-wp' ), esc_html__( 'Product Search', 'larisdigital-wp' ) ),
		'setting'  => 'fbpixel_woocommerce_event_search',
		'setting_type' => 'option_mod',
		'setting_db' => LARISDIGITAL_INTEGRATIONS_DB,
		'section'  => 'larisdigital_section_fbpixel',
		'type'     => 'text',
		'input_attrs' => array(
			'placeholder' => 'Search',
		),
		'active_callback' => 'larisdigital_callback_fbpixel_woocommerce_active',
		'priority'	=> 20,
	);

	$controls['fbpixel_woocommerce_event_shop'] = array(
		'label'    => sprintf( esc_html__( 'FB Pixel Event on %s', 'larisdigital-wp' ), esc_html__( 'Shop Page', 'larisdigital-wp' ) ),
		'setting'  => 'fbpixel_woocommerce_event_shop',
		'setting_type' => 'option_mod',
		'setting_db' => LARISDIGITAL_INTEGRATIONS_DB,
		'section'  => 'larisdigital_section_fbpixel',
		'type'     => 'text',
		'input_attrs' => array(
			'placeholder' => 'ViewCategory',
		),
		'active_callback' => 'larisdigital_callback_fbpixel_woocommerce_active',
		'priority'	=> 20,
	);

	$controls['fbpixel_woocommerce_event_product'] = array(
		'label'    => sprintf( esc_html__( 'FB Pixel Event on %s', 'larisdigital-wp' ), esc_html__( 'Single Product Page', 'larisdigital-wp' ) ),
		'setting'  => 'fbpixel_woocommerce_event_product',
		'setting_type' => 'option_mod',
		'setting_db' => LARISDIGITAL_INTEGRATIONS_DB,
		'section'  => 'larisdigital_section_fbpixel',
		'type'     => 'text',
		'input_attrs' => array(
			'placeholder' => 'ViewContent',
		),
		'active_callback' => 'larisdigital_callback_fbpixel_woocommerce_active',
		'priority'	=> 20,
	);

	$controls['fbpixel_woocommerce_event_cart'] = array(
		'label'    => sprintf( esc_html__( 'FB Pixel Event on %s', 'larisdigital-wp' ), esc_html__( 'Cart Page', 'larisdigital-wp' ) ),
		'setting'  => 'fbpixel_woocommerce_event_cart',
		'setting_type' => 'option_mod',
		'setting_db' => LARISDIGITAL_INTEGRATIONS_DB,
		'section'  => 'larisdigital_section_fbpixel',
		'type'     => 'text',
		'input_attrs' => array(
			'placeholder' => 'AddToCart',
		),
		'active_callback' => 'larisdigital_callback_fbpixel_woocommerce_active',
		'priority'	=> 20,
	);

	$controls['fbpixel_woocommerce_event_checkout'] = array(
		'label'    => sprintf( esc_html__( 'FB Pixel Event on %s', 'larisdigital-wp' ), esc_html__( 'Checkout Page', 'larisdigital-wp' ) ),
		'setting'  => 'fbpixel_woocommerce_event_checkout',
		'setting_type' => 'option_mod',
		'setting_db' => LARISDIGITAL_INTEGRATIONS_DB,
		'section'  => 'larisdigital_section_fbpixel',
		'type'     => 'text',
		'input_attrs' => array(
			'placeholder' => 'InitiateCheckout',
		),
		'active_callback' => 'larisdigital_callback_fbpixel_woocommerce_active',
		'priority'	=> 20,
	);

	$controls['fbpixel_woocommerce_event_purchase_pending'] = array(
		'label'    => sprintf( esc_html__( 'FB Pixel Event on %s', 'larisdigital-wp' ), esc_html__( 'Thank You Page For On-hold Purchases', 'larisdigital-wp' ) ),
		'setting'  => 'fbpixel_woocommerce_event_purchase_pending',
		'setting_type' => 'option_mod',
		'setting_db' => LARISDIGITAL_INTEGRATIONS_DB,
		'section'  => 'larisdigital_section_fbpixel',
		'type'     => 'text',
		'input_attrs' => array(
			'placeholder' => 'AddPaymentInfo',
		),
		'active_callback' => 'larisdigital_callback_fbpixel_woocommerce_active',
		'priority'	=> 20,
	);

	$controls['fbpixel_woocommerce_event_purchase'] = array(
		'label'    => sprintf( esc_html__( 'FB Pixel Event on %s', 'larisdigital-wp' ), esc_html__( 'Thank You Page For Processing/Completed Purchases', 'larisdigital-wp' ) ),
		'setting'  => 'fbpixel_woocommerce_event_purchase',
		'setting_type' => 'option_mod',
		'setting_db' => LARISDIGITAL_INTEGRATIONS_DB,
		'section'  => 'larisdigital_section_fbpixel',
		'type'     => 'text',
		'input_attrs' => array(
			'placeholder' => 'Purchase',
		),
		'active_callback' => 'larisdigital_callback_fbpixel_woocommerce_active',
		'priority'	=> 20,
	);

	$controls['larisdigital_heading_fbpixel_woocommerce_catalog'] = array(
		'label'		=> esc_html__( 'Facebook Product Catalog', 'larisdigital-wp' ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-danger larisdigital-alert-with-icon">
								<span class="dashicons dashicons-warning"></span>'.esc_html__( 'We do not generate product catalog file for your online store. You can use any product feed plugin to generate product catalog file for all products on this website.', 'larisdigital-wp' ).'</p>',
		'setting'  	=> 'larisdigital_heading_fbpixel_woocommerce_catalog',
		'section'	=> 'larisdigital_section_fbpixel',
		'type'   	=> 'heading',
		'active_callback' => 'larisdigital_callback_fbpixel_woocommerce_default',
		'priority'	=> 30,
	);

	$controls['fbpixel_woocommerce_content_ids'] = array(
		'label'    => esc_html__( 'Enable "content_ids" parameter', 'larisdigital-wp' ),
		'description' => esc_html__( 'Use this option if you want to setup Facebook Product Catalog manually. If you do not have active product catalog, you will get "Can not match product" warning on Facebook Pixel Helper.', 'larisdigital-wp' ),
		'setting'  => 'fbpixel_woocommerce_content_ids',
		'setting_type' => 'option_mod',
		'setting_db' => LARISDIGITAL_INTEGRATIONS_DB,
		'section'  => 'larisdigital_section_fbpixel',
		'type'     => 'checkbox',
		'active_callback' => 'larisdigital_callback_fbpixel_woocommerce_default',
		'priority'	=> 30,
	);

	$controls['fbpixel_woocommerce_content_ids_format'] = array(
		'label'    => esc_html__( 'Specific "content_ids" format', 'larisdigital-wp' ),
		'setting'  => 'fbpixel_woocommerce_content_ids_format',
		'setting_type' => 'option_mod',
		'setting_db' => LARISDIGITAL_INTEGRATIONS_DB,
		'section'  => 'larisdigital_section_fbpixel',
		'type'     => 'radio',
		'choices'  => array(
			'' => esc_html__( 'follow Facebook WooCommerce plugin', 'larisdigital-wp' ),
			'sku' => esc_html__( 'Product SKU, with fallback to Product ID', 'larisdigital-wp' ),
			'id' => esc_html__( 'Product ID', 'larisdigital-wp' ),
		),
		'active_callback' => 'larisdigital_callback_fbpixel_woocommerce_content_ids',
		'priority'	=> 30,
	);

	return $controls;
}

function larisdigital_callback_fbpixel_woocommerce_default() {
	$plugin_active = larisdigital_fbpixel_woocommerce_check_plugin_active();
	return $plugin_active ? false : true;
}

function larisdigital_callback_fbpixel_woocommerce_active() {
	$active = true;
	$plugin_active = larisdigital_fbpixel_woocommerce_check_plugin_active();
	if ( $plugin_active ) {
		$active = false;
	}
	else {
		if ( larisdigital_get_integration( 'fbpixel_woocommerce_disable' ) ) {
			$active = false;
		}
	}
	return $active;
}

function larisdigital_callback_fbpixel_woocommerce_content_ids() {
	$show = larisdigital_get_integration( 'fbpixel_woocommerce_content_ids' ) ? true : false;
	$plugin_active = larisdigital_fbpixel_woocommerce_check_plugin_active();
	$show = $plugin_active ? false : $show;
	return $show;
}

function larisdigital_callback_fbpixel_facebookcommerce() {
	$plugin_active = false;
	if ( class_exists( 'WC_Facebookcommerce' ) ) {
		$facebookcommerce = get_option('woocommerce_facebookcommerce_settings');
		if ( isset($facebookcommerce['fb_api_key']) && $facebookcommerce['fb_api_key'] && isset($facebookcommerce['fb_product_catalog_id']) && $facebookcommerce['fb_product_catalog_id'] ) {
			$plugin_active = true;
		}
	}
	return $plugin_active;
}

function larisdigital_callback_fbpixel_pixelcaffeine() {
	$plugin_active = false;
	if ( class_exists( 'PixelCaffeine' ) ) {
		if ( 'yes' == get_option('aepc_enable_pixel') && get_option( 'aepc_pixel_id' ) && 'yes' == get_option('aepc_enable_dpa') ) {
			$plugin_active = true;
		}
	}
	return $plugin_active;
}

function larisdigital_callback_fbpixel_pixelyoursite() {
	$plugin_active = false;
	if ( function_exists( 'pys_get_woo_code' ) && function_exists( 'pys_get_option' ) ) {
		if ( pys_get_option( 'woo', 'on_view_content' ) || pys_get_option( 'woo', 'on_add_to_cart_page' ) || pys_get_option( 'woo', 'on_add_to_cart_checkout' ) || pys_get_option( 'woo', 'on_checkout_page' ) || pys_get_option( 'woo', 'on_thank_you_page' ) ) {
			$plugin_active = true;
		}
	}
	return $plugin_active;
}

add_action( 'woocommerce_add_to_cart', 'larisdigital_fbpixel_woocommerce_add_to_cart_trigger' );
function larisdigital_fbpixel_woocommerce_add_to_cart_trigger() {
	global $larisdigital_woocommerce_cart_trigger;
	$larisdigital_woocommerce_cart_trigger = true;
}

add_action( 'woocommerce_after_cart', 'larisdigital_fbpixel_woocommerce_cart_trigger' );
function larisdigital_fbpixel_woocommerce_cart_trigger() {
	global $larisdigital_woocommerce_cart_trigger;
	$larisdigital_woocommerce_cart_trigger = true;
}

add_action( 'woocommerce_after_checkout_form', 'larisdigital_fbpixel_woocommerce_checkout_trigger' );
function larisdigital_fbpixel_woocommerce_checkout_trigger() {
	global $larisdigital_woocommerce_checkout_trigger;
	$larisdigital_woocommerce_checkout_trigger = true;
}

add_action( 'woocommerce_thankyou', 'larisdigital_fbpixel_woocommerce_purchase_trigger' );
function larisdigital_fbpixel_woocommerce_purchase_trigger( $order_id = false ) {
	global $larisdigital_woocommerce_purchase_trigger;
	$larisdigital_woocommerce_purchase_trigger = $order_id;
}

add_filter( 'larisdigital_fbpixel_woocommerce_active', 'larisdigital_fbpixel_woocommerce_is_active' );
function larisdigital_fbpixel_woocommerce_is_active( $active ) {
	$plugin_active = larisdigital_fbpixel_woocommerce_check_plugin_active();
	if ( $plugin_active ) {
		$active = false;
	}
	else {
		if ( larisdigital_get_integration( 'fbpixel_woocommerce_disable' ) ) {
			$active = false;
		}
	}
	return $active;
}

add_filter( 'larisdigital_fbpixel_active', 'larisdigital_fbpixel_active_plugin_checker' );
function larisdigital_fbpixel_active_plugin_checker( $active ) {
	$plugin_active = larisdigital_fbpixel_woocommerce_check_plugin_active();
	if ( $plugin_active ) {
		return true;
	}
	return $active;
}

add_filter( 'larisdigital_fbpixel_ids', 'larisdigital_fbpixel_ids_plugin_checker');
function larisdigital_fbpixel_ids_plugin_checker( $fbpixel_ids ) {
	if ( class_exists( 'WC_Facebookcommerce' ) ) {
		$facebookcommerce = get_option('woocommerce_facebookcommerce_settings');
		if ( isset($facebookcommerce['fb_pixel_id']) && $facebookcommerce['fb_pixel_id'] && isset($facebookcommerce['fb_api_key']) && $facebookcommerce['fb_api_key'] && isset($facebookcommerce['fb_product_catalog_id']) && $facebookcommerce['fb_product_catalog_id'] ) {
			$fbpixel_id = $facebookcommerce['fb_pixel_id'];
			if ( isset( $fbpixel_ids[$fbpixel_id] ) ) {
				unset( $fbpixel_ids[$fbpixel_id] );
			}
		}
	}
	if ( class_exists( 'PixelCaffeine' ) ) {
		if ( 'yes' == get_option('aepc_enable_pixel') ) {
			$fbpixel_id = get_option( 'aepc_pixel_id' );
			if ( $fbpixel_id && isset( $fbpixel_ids[$fbpixel_id] ) ) {
				unset( $fbpixel_ids[$fbpixel_id] );
			}
		}
	}
	return $fbpixel_ids;
}

add_action( 'larisdigital_fbpixel_wp_footer', 'larisdigital_fbpixel_woocommerce_product_footer' );
function larisdigital_fbpixel_woocommerce_product_footer() {
	if ( ! apply_filters( 'larisdigital_fbpixel_woocommerce_active', true ) ) {
		return;
	}

	if ( ! is_product() ) {
		return;
	}

	$custom_event = larisdigital_get_integration( 'fbpixel_woocommerce_event_product' );
	$event = $custom_event ? trim( $custom_event ) : 'ViewContent';
	if ( 'PageView' == $event || empty( $event ) ) {
		return;
	}

	if ( in_array( $event, array( 'PageView', 'ViewContent', 'AddToCart', 'InitiateCheckout', 'AddPaymentInfo', 'Purchase', 'Lead', 'Search' ) ) ) {
		$track = 'track';
	}
	else {
		$track = 'trackCustom';
	}

	global $product;
	if ( empty( $product ) ) {
		$product = wc_get_product( get_the_ID() );
	}
	$value = $product->get_price();
	$params = array();
	$params['value'] = number_format((float)$value, 2, '.', '');
	$params['currency'] = get_woocommerce_currency();

	$content_ids_active = larisdigital_get_integration('fbpixel_woocommerce_content_ids');
	$content_ids_format = larisdigital_get_integration('fbpixel_woocommerce_content_ids_format');
	if ( $content_ids_active ) {
		$content_ids = array();
		if ( 'id' == $content_ids_format ) {
			$content_ids[] = strval( $product->get_id() );
		}
		elseif ( 'sku' == $content_ids_format ) {
			$content_sku = $product->get_sku();
			if ( $content_sku ) {
				$content_ids[] = trim( $content_sku );
			}
			else {
				$content_ids[] = strval( $product->get_id() );
			}
		}
		else {
			$content_sku = $product->get_sku();
			if ( $content_sku ) {
				$content_ids[] = trim( $content_sku ).'_'.strval( $product->get_id() );
			}
			else {
				$content_ids[] = 'wc_post_id_'.strval( $product->get_id() );
			}
		}
		$params['content_ids'] = json_encode($content_ids);
		if ( in_array( $product->get_type(), array( 'variable', 'variable-subscription' ) ) ) {
			$params['content_type'] = 'product_group';
		}
		else {
			$params['content_type'] = 'product';
		}
	}

	$params['source'] = LARISDIGITAL_THEME_SLUG;
	$params['source_action'] = 'page-load';
	$params['source_position'] = 'footer';
	$params['version'] = LARISDIGITAL_THEME_VERSION;
	$params['domain'] = str_replace( array('https://www.','http://www.','https://','http://'), '', home_url('/') );
	$params['campaign_url'] = get_queried_object()->post_name;
	$params['content_name'] = get_the_title();
	$params['post_type'] = get_post_type();
?>
<!-- Facebook Pixel Events Code -->
<script>
fbq('<?php echo $track; ?>', "<?php echo $event; ?>", <?php echo json_encode( $params ); ?> );
</script>
<!-- End Facebook Pixel Events Code -->
<?php 
}

add_action( 'larisdigital_fbpixel_wp_footer', 'larisdigital_fbpixel_woocommerce_cart_footer' );
function larisdigital_fbpixel_woocommerce_cart_footer() {
	global $larisdigital_woocommerce_cart_trigger;
	if ( ! $larisdigital_woocommerce_cart_trigger ) {
		return;
	}

	if ( ! apply_filters( 'larisdigital_fbpixel_woocommerce_active', true ) ) {
		return;
	}

	larisdigital_fbpixel_woocommerce_cart_output();
}

add_action( 'wc_ajax_tp_fbpixel_woocommerce_cart', 'larisdigital_fbpixel_woocommerce_cart_ajax' );
function larisdigital_fbpixel_woocommerce_cart_ajax() {
	ob_start();
	larisdigital_fbpixel_woocommerce_cart_output();
	$fbpixel = ob_get_clean();
	wp_send_json( $fbpixel );
}

function larisdigital_fbpixel_woocommerce_cart_output() {
	$custom_event = larisdigital_get_integration( 'fbpixel_woocommerce_event_cart' );
	$event = $custom_event ? trim( $custom_event ) : 'AddToCart';
	if ( 'PageView' == $event || empty( $event ) ) {
		return;
	}

	if ( in_array( $event, array( 'PageView', 'ViewContent', 'AddToCart', 'InitiateCheckout', 'AddPaymentInfo', 'Purchase', 'Lead', 'Search' ) ) ) {
		$track = 'track';
	}
	else {
		$track = 'trackCustom';
	}

	$cart = WC()->cart->get_cart();
	$num_items = WC()->cart->get_cart_contents_count();

	if ( $num_items < 1 ) {
		return;
	}

	$value = WC()->cart->total;
	$params = array();
	$params['value'] = number_format((float)$value, 2, '.', '');
	$params['currency'] = get_woocommerce_currency();
	$params['num_items'] = $num_items;

	$content_ids_active = larisdigital_get_integration('fbpixel_woocommerce_content_ids');
	$content_ids_format = larisdigital_get_integration('fbpixel_woocommerce_content_ids_format');
	if ( $content_ids_active ) {
		$content_ids = array();
		foreach ($cart as $item) {
			if ( 'id' == $content_ids_format ) {
				$content_ids[] = strval( $item['data']->get_id() );
			}
			elseif ( 'sku' == $content_ids_format ) {
				$content_sku = $item['data']->get_sku();
				if ( $content_sku ) {
					$content_ids[] = trim( $content_sku );
				}
				else {
					$content_ids[] = strval( $item['data']->get_id() );
				}
			}
			else {
				$content_sku = $item['data']->get_sku();
				if ( $content_sku ) {
					$content_ids[] = trim( $content_sku ).'_'.strval( $item['data']->get_id() );
				}
				else {
					$content_ids[] = 'wc_post_id_'.strval( $item['data']->get_id() );
				}
			}
		}
		$params['content_ids'] = json_encode($content_ids);
		$params['content_type'] = 'product';
	}

	$params['source'] = LARISDIGITAL_THEME_SLUG;
	$params['source_action'] = 'page-load';
	$params['source_position'] = 'footer';
	$params['version'] = LARISDIGITAL_THEME_VERSION;
	$params['domain'] = str_replace( array('https://www.','http://www.','https://','http://'), '', home_url('/') );
?>
<!-- Facebook Pixel Events Code -->
<script>
fbq('<?php echo $track; ?>', "<?php echo $event; ?>", <?php echo json_encode( $params ); ?> );
</script>
<!-- End Facebook Pixel Events Code -->
<?php 
}

add_action( 'larisdigital_fbpixel_wp_footer', 'larisdigital_fbpixel_woocommerce_checkout_footer' );
function larisdigital_fbpixel_woocommerce_checkout_footer() {
	global $larisdigital_woocommerce_checkout_trigger;
	if ( ! $larisdigital_woocommerce_checkout_trigger ) {
		return;
	}

	if ( ! apply_filters( 'larisdigital_fbpixel_woocommerce_active', true ) ) {
		return;
	}

	$custom_event = larisdigital_get_integration( 'fbpixel_woocommerce_event_checkout' );
	$event = $custom_event ? trim( $custom_event ) : 'InitiateCheckout';
	if ( 'PageView' == $event || empty( $event ) ) {
		return;
	}

	if ( in_array( $event, array( 'PageView', 'ViewContent', 'AddToCart', 'InitiateCheckout', 'AddPaymentInfo', 'Purchase', 'Lead', 'Search' ) ) ) {
		$track = 'track';
	}
	else {
		$track = 'trackCustom';
	}

	$cart = WC()->cart->get_cart();
	$num_items = WC()->cart->get_cart_contents_count();

	if ( $num_items < 1 ) {
		return;
	}

	$value = WC()->cart->total;
	$params = array();
	$params['value'] = number_format((float)$value, 2, '.', '');
	$params['currency'] = get_woocommerce_currency();
	$params['num_items'] = $num_items;

	$content_ids_active = larisdigital_get_integration('fbpixel_woocommerce_content_ids');
	$content_ids_format = larisdigital_get_integration('fbpixel_woocommerce_content_ids_format');
	if ( $content_ids_active ) {
		$content_ids = array();
		foreach ($cart as $item) {
			if ( 'id' == $content_ids_format ) {
				$content_ids[] = strval( $item['data']->get_id() );
			}
			elseif ( 'sku' == $content_ids_format ) {
				$content_sku = $item['data']->get_sku();
				if ( $content_sku ) {
					$content_ids[] = trim( $content_sku );
				}
				else {
					$content_ids[] = strval( $item['data']->get_id() );
				}
			}
			else {
				$content_sku = $item['data']->get_sku();
				if ( $content_sku ) {
					$content_ids[] = trim( $content_sku ).'_'.strval( $item['data']->get_id() );
				}
				else {
					$content_ids[] = 'wc_post_id_'.strval( $item['data']->get_id() );
				}
			}
		}
		$params['content_ids'] = json_encode($content_ids);
		$params['content_type'] = 'product';
	}

	$params['source'] = LARISDIGITAL_THEME_SLUG;
	$params['source_action'] = 'page-load';
	$params['source_position'] = 'footer';
	$params['version'] = LARISDIGITAL_THEME_VERSION;
	$params['domain'] = str_replace( array('https://www.','http://www.','https://','http://'), '', home_url('/') );
?>
<!-- Facebook Pixel Events Code -->
<script>
fbq('<?php echo $track; ?>', "<?php echo $event; ?>", <?php echo json_encode( $params ); ?> );
</script>
<!-- End Facebook Pixel Events Code -->
<?php 
}

add_action( 'larisdigital_fbpixel_wp_footer', 'larisdigital_fbpixel_woocommerce_purchase_footer' );
function larisdigital_fbpixel_woocommerce_purchase_footer() {
	global $larisdigital_woocommerce_purchase_trigger;
	if ( ! $larisdigital_woocommerce_purchase_trigger ) {
		return;
	}

	if ( ! apply_filters( 'larisdigital_fbpixel_woocommerce_active', true ) ) {
		return;
	}

	$order_id = $larisdigital_woocommerce_purchase_trigger;
	$order = new WC_Order( $order_id );

	if ( is_wp_error( $order ) ) {
		return;
	}

	$order_status = $order->get_status();
	$event = '';
	if ( 'completed' == $order_status || 'processing' == $order_status ) {
		$custom_event = larisdigital_get_integration( 'fbpixel_woocommerce_event_purchase' );
		$event = $custom_event ? trim( $custom_event ) : 'Purchase';
	}
	elseif ( 'on-hold' == $order_status || 'pending' == $order_status ) {
		$custom_event = larisdigital_get_integration( 'fbpixel_woocommerce_event_purchase_pending' );
		$event = $custom_event ? trim( $custom_event ) : 'AddPaymentInfo';
	}

	if ( 'PageView' == $event || empty( $event ) ) {
		return;
	}

	if ( in_array( $event, array( 'PageView', 'ViewContent', 'AddToCart', 'InitiateCheckout', 'AddPaymentInfo', 'Purchase', 'Lead', 'Search' ) ) ) {
		$track = 'track';
	}
	else {
		$track = 'trackCustom';
	}

	$value = $order->get_total();
	$payment_method = $order->get_payment_method();
	$params = array();
	$params['value'] = number_format((float)$value, 2, '.', '');
	$params['currency'] = get_woocommerce_currency();
	$params['payment_method'] = $payment_method;
	$params['order_status'] = $order_status;

	$content_ids_active = larisdigital_get_integration('fbpixel_woocommerce_content_ids');
	$content_ids_format = larisdigital_get_integration('fbpixel_woocommerce_content_ids_format');
	if ( $content_ids_active ) {
		$content_ids = array();
		foreach ( $order->get_items() as $item ) {
			$product_id = $item['variation_id'] ? $item['variation_id'] : $item['product_id'];
			if ( 'id' == $content_ids_format ) {
				$content_ids[] = strval( $product_id );
			}
			elseif ( 'sku' == $content_ids_format ) {
				$product = wc_get_product( $product_id );
				$content_sku = $product->get_sku();
				if ( $content_sku ) {
					$content_ids[] = trim( $content_sku );
				}
				else {
					$content_ids[] = strval( $product->get_id() );
				}
			}
			else {
				$product = wc_get_product( $product_id );
				$content_sku = $product->get_sku();
				if ( $content_sku ) {
					$content_ids[] = trim( $content_sku ).'_'.strval( $product->get_id() );
				}
				else {
					$content_ids[] = 'wc_post_id_'.strval( $product->get_id() );
				}
			}
		}
		$params['content_ids'] = json_encode($content_ids);
		$params['content_type'] = 'product';
	}

	$params['source'] = LARISDIGITAL_THEME_SLUG;
	$params['source_action'] = 'page-load';
	$params['source_position'] = 'footer';
	$params['version'] = LARISDIGITAL_THEME_VERSION;
	$params['domain'] = str_replace( array('https://www.','http://www.','https://','http://'), '', home_url('/') );
?>
<!-- Facebook Pixel Events Code -->
<script>
fbq('<?php echo $track; ?>', "<?php echo $event; ?>", <?php echo json_encode( $params ); ?> );
</script>
<!-- End Facebook Pixel Events Code -->
<?php 
}

add_action( 'larisdigital_fbpixel_wp_footer', 'larisdigital_fbpixel_woocommerce_shop_footer' );
function larisdigital_fbpixel_woocommerce_shop_footer() {
	if ( ! apply_filters( 'larisdigital_fbpixel_woocommerce_active', true ) ) {
		return;
	}

	if ( is_shop() && is_search() ) {
		$custom_event = larisdigital_get_integration( 'fbpixel_woocommerce_event_search' );
		$event = $custom_event ? trim( $custom_event ) : 'Search';
	}
	else {
		$custom_event = larisdigital_get_integration( 'fbpixel_woocommerce_event_shop' );
		$event = $custom_event ? trim( $custom_event ) : 'ViewCategory';
	}

	if ( 'PageView' == $event || empty( $event ) ) {
		return;
	}

	if ( in_array( $event, array( 'PageView', 'ViewContent', 'AddToCart', 'InitiateCheckout', 'AddPaymentInfo', 'Purchase', 'Lead', 'Search' ) ) ) {
		$track = 'track';
	}
	else {
		$track = 'trackCustom';
	}

	$params = array();
	if ( is_shop() ) {
		if ( is_search() ) {
			$params['content_category'] = 'product_search';
			$params['search_string'] = get_search_query();
			$params['content_name'] = 'Search';
		}
		else {
			$params['content_category'] = 'product_shop';
			$params['content_name'] = 'Shop';
		}
	}
	elseif ( is_product_category() ) {
		$params['content_category'] = 'product_category';
		$params['content_name'] = single_term_title( '', false );
	}
	elseif ( is_product_tag() ) {
		$params['content_category'] = 'product_tag';
		$params['content_name'] = single_term_title( '', false );
	}
	else {
		return;
	}

	$content_ids_active = larisdigital_get_integration('fbpixel_woocommerce_content_ids');
	$content_ids_format = larisdigital_get_integration('fbpixel_woocommerce_content_ids_format');
	if ( $content_ids_active ) {
		$content_ids = array();
		$content_type = 'product';
		// $post_ids = wp_list_pluck( $GLOBALS['wp_query']->posts, 'ID' );
		rewind_posts();
		while (have_posts()) : the_post();
			global $product;
			if ( empty( $product ) ) {
				$product = wc_get_product( get_the_ID() );
			}
			if ( 'id' == $content_ids_format ) {
				$content_ids[] = strval( $product->get_id() );
			}
			elseif ( 'sku' == $content_ids_format ) {
				$content_sku = $product->get_sku();
				if ( $content_sku ) {
					$content_ids[] = trim( $content_sku );
				}
				else {
					$content_ids[] = strval( $product->get_id() );
				}
			}
			else {
				$content_sku = $product->get_sku();
				if ( $content_sku ) {
					$content_ids[] = trim( $content_sku ).'_'.strval( $product->get_id() );
				}
				else {
					$content_ids[] = 'wc_post_id_'.strval( $product->get_id() );
				}
			}
			if ( in_array( $product->get_type(), array( 'variable', 'variable-subscription' ) ) ) {
				$content_type = 'product_group';
			}
		endwhile;
		if ( ! empty( $content_ids ) ) {
			$params['content_ids'] = json_encode($content_ids);
			$params['content_type'] = $content_type;
		}
	}
	$params['source'] = LARISDIGITAL_THEME_SLUG;
	$params['source_action'] = 'page-load';
	$params['source_position'] = 'footer';
	$params['version'] = LARISDIGITAL_THEME_VERSION;
	$params['domain'] = str_replace( array('https://www.','http://www.','https://','http://'), '', home_url('/') );
?>
<!-- Facebook Pixel Events Code -->
<script>
fbq('<?php echo $track; ?>', "<?php echo $event; ?>", <?php echo json_encode( $params ); ?> );
</script>
<!-- End Facebook Pixel Events Code -->
<?php 
}

add_filter( 'body_class', 'larisdigital_fbpixel_woocommerce_body_class' );
function larisdigital_fbpixel_woocommerce_body_class( $classes ) {
	if ( apply_filters( 'larisdigital_fbpixel_woocommerce_active', true ) ) {
		$classes[] = 'tp-fbpixel-woocommerce-active';
	}
	return $classes;
}

function larisdigital_fbpixel_woocommerce_check_plugin_active() {
	$plugin_active = false;
	if ( class_exists( 'WC_Facebookcommerce' ) ) {
		$facebookcommerce = get_option('woocommerce_facebookcommerce_settings');
		if ( isset($facebookcommerce['fb_api_key']) && $facebookcommerce['fb_api_key'] && isset($facebookcommerce['fb_product_catalog_id']) && $facebookcommerce['fb_product_catalog_id'] ) {
			$plugin_active = true;
		}
	}
	if ( class_exists( 'PixelCaffeine' ) ) {
		if ( 'yes' == get_option('aepc_enable_pixel') && get_option( 'aepc_pixel_id' ) && 'yes' == get_option('aepc_enable_dpa') ) {
			$plugin_active = true;
		}
	}
	if ( function_exists( 'pys_get_woo_code' ) && function_exists( 'pys_get_option' ) ) {
		if ( pys_get_option( 'woo', 'on_view_content' ) || pys_get_option( 'woo', 'on_add_to_cart_page' ) || pys_get_option( 'woo', 'on_add_to_cart_checkout' ) || pys_get_option( 'woo', 'on_checkout_page' ) || pys_get_option( 'woo', 'on_thank_you_page' ) ) {
			$plugin_active = true;
		}
	}
	return $plugin_active;
}

function larisdigital_fbpixel_woocommerce_content_ids_status() {
	global $larisdigital_woocommerce_content_ids;
	if ( ! empty ( $larisdigital_woocommerce_content_ids ) ) {
		return $larisdigital_woocommerce_content_ids;
	}
	$content_ids_active = false;
	$content_ids_format = '';
	if ( class_exists( 'WC_Facebookcommerce' ) ) {
		$facebookcommerce = get_option('woocommerce_facebookcommerce_settings');
		if ( isset($facebookcommerce['fb_api_key']) && $facebookcommerce['fb_api_key'] && isset($facebookcommerce['fb_product_catalog_id']) && $facebookcommerce['fb_product_catalog_id'] ) {
			$content_ids_active = true;
			$content_ids_format = '';
		}
	}
	elseif ( class_exists( 'PixelCaffeine' ) ) {
		if ( 'yes' == get_option('aepc_enable_pixel') && get_option( 'aepc_pixel_id' ) && 'yes' == get_option('aepc_enable_dpa') ) {
			$content_ids_active = true;
			if ( 'yes' == get_option('aepc_force_ids') ) {
				$content_ids_format = 'id';
			}
			else {
				$content_ids_format = 'sku';
			}
		}
	}
	elseif ( function_exists( 'pys_get_woo_code' ) && function_exists( 'pys_get_option' ) ) {
		if ( pys_get_option( 'woo', 'on_view_content' ) || pys_get_option( 'woo', 'on_add_to_cart_page' ) || pys_get_option( 'woo', 'on_add_to_cart_checkout' ) || pys_get_option( 'woo', 'on_checkout_page' ) || pys_get_option( 'woo', 'on_thank_you_page' ) ) {
			$content_ids_pys = pys_get_option( 'woo', 'content_id' );
			$content_ids_active = true;
			$content_ids_format = $content_ids_pys ? $content_ids_pys : 'id';
		}
	}
	else {
		$content_ids_active = larisdigital_get_integration('fbpixel_woocommerce_content_ids');
		$content_ids_format = larisdigital_get_integration('fbpixel_woocommerce_content_ids_format');
	}
	$larisdigital_woocommerce_content_ids = array(
		'content_ids_active' => $content_ids_active,
		'content_ids_format' => $content_ids_format,
	);
	return $larisdigital_woocommerce_content_ids;
}

add_action( 'admin_head', 'larisdigital_fbpixel_admin_head_acf_shop' );
function larisdigital_fbpixel_admin_head_acf_shop() {
	$shop_page_id = wc_get_page_id( 'shop' );
	if ( $shop_page_id && $shop_page_id == get_the_ID() ) {
		echo '<style>#acf-group_5b07e0b7c057d { display: none !important; }</style>';
	}
}
