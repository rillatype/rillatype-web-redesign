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

add_filter( 'larisdigital_customize_controls', 'larisdigital_wc_customize_controls_cartpopup' );
function larisdigital_wc_customize_controls_cartpopup( $controls ) {

	$controls['larisdigital_wc_section_cartpopup'] = array(
		'title'				=> esc_html__( 'WC - Ajax Add To Cart Popup', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_section_cartpopup',
		'panel'    			=> 'larisdigital_wc_panel_settings',
		'type'     			=> 'section',
		'priority' 			=> 100,
	);

	$controls['wc_cartpopup_disable'] = array(
		'label'    			=> esc_html__( 'Disable Ajax "Add To Cart" Popup', 'larisdigital-wp' ),
		'setting'  			=> 'wc_cartpopup_disable',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section' 			=> 'larisdigital_wc_section_cartpopup',
		'type'     			=> 'checkbox',
	);

	$controls['wc_cartpopup_title'] = array(
		'label'				=> esc_html__( 'Ajax "Add To Cart" Popup Title', 'larisdigital-wp' ),
		'setting'  			=> 'wc_cartpopup_title',
		'setting_type'		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section'			=> 'larisdigital_wc_section_cartpopup',
		'type'				=> 'text',
		'input_attrs' 		=> array(
			'placeholder' 	=> esc_html__( 'Add To Cart', 'larisdigital-wp' ),
		),
	);

	$controls['wc_cartpopup_primary'] = array(
		'label'    			=> esc_html__( 'Primary Button Link To', 'larisdigital-wp' ),
		'setting'  			=> 'wc_cartpopup_primary',
		'setting_type'		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section'			=> 'larisdigital_wc_section_cartpopup',
		'type'     			=> 'radio',
		'choices'  			=> array(
			'cart' 			=> esc_html__( 'Cart Page', 'larisdigital-wp' ),
			'checkout' 		=> esc_html__( 'Checkout Page', 'larisdigital-wp' ),
		),
		'default'			=> 'cart',
	);

	$controls['wc_cartpopup_button_colors'] = array(
		'label'				=> esc_html__( 'Button Colors', 'larisdigital-wp' ),
		'description' 		=> '<p class="larisdigital-alert larisdigital-alert-with-icon">
								<span class="dashicons dashicons-admin-appearance"></span> <a href="javascript:wp.customize.control( \'larisdigital_wc_heading_button_primary\' ).focus();">'.esc_html__( 'CLICK HERE to change colors & background of action buttons (primary & secondary buttons) on cart popup', 'larisdigital-wp' ).'</a>
								</p>',
		'setting'  			=> 'wc_cartpopup_button_colors',
		'setting_type'		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section'			=> 'larisdigital_wc_section_cartpopup',
		'type'   			=> 'heading',
	);

	$controls['wc_cartpopup_button_text'] = array(
		'label'				=> esc_html__( 'Button Text', 'larisdigital-wp' ),
		'setting'  			=> 'wc_cartpopup_button_text',
		'setting_type'		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section'			=> 'larisdigital_wc_section_cartpopup',
		'type'   			=> 'heading',
	);

	$controls['wc_cartpopup_cart_text'] = array(
		'label'				=> esc_html__( 'Cart Button Text', 'larisdigital-wp' ),
		'setting'  			=> 'wc_cartpopup_cart_text',
		'setting_type'		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section'			=> 'larisdigital_wc_section_cartpopup',
		'type'				=> 'text',
		'input_attrs' 		=> array(
			'placeholder' 	=> esc_html__( 'View Cart', 'larisdigital-wp' ),
		),
	);

	$controls['wc_cartpopup_checkout_text'] = array(
		'label'				=> esc_html__( 'Checkout Button Text', 'larisdigital-wp' ),
		'setting'  			=> 'wc_cartpopup_checkout_text',
		'setting_type'		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section'			=> 'larisdigital_wc_section_cartpopup',
		'type'				=> 'text',
		'input_attrs' 		=> array(
			'placeholder' 	=> esc_html__( 'Checkout', 'larisdigital-wp' ),
		),
	);

	$controls['wc_cartpopup_continue_text'] = array(
		'label'				=> esc_html__( 'Continue Button Text', 'larisdigital-wp' ),
		'setting'  			=> 'wc_cartpopup_continue_text',
		'setting_type'		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section'			=> 'larisdigital_wc_section_cartpopup',
		'type'				=> 'text',
		'input_attrs' 		=> array(
			'placeholder' 	=> esc_html__( 'Continue Shopping', 'larisdigital-wp' ),
		),
	);

	return $controls;
}

add_filter( 'body_class', 'larisdigital_wc_cart_popup_body_class' );
function larisdigital_wc_cart_popup_body_class( $classes ) {
	if ( larisdigital_get_integration_wc( 'wc_cartpopup_disable' ) ) {
		return $classes;
	}
	$classes[] = 'tp-cart-popup-active';
	return $classes;
}

add_action( 'woocommerce_before_add_to_cart_form', 'larisdigital_wc_cart_popup_form_before' );
function larisdigital_wc_cart_popup_form_before() {
	if ( larisdigital_get_integration_wc( 'wc_cartpopup_disable' ) ) {
		return;
	}
	global $product;
	if ( empty( $product ) ) {
		$product = wc_get_product( get_the_ID() );
	}
	if ( 'external' == $product->get_type() ) {
		return;
	}
	echo '<div class="tp-cart-popup-form">';
}

add_action( 'woocommerce_after_add_to_cart_form', 'larisdigital_wc_cart_popup_form_after' );
function larisdigital_wc_cart_popup_form_after() {
	if ( larisdigital_get_integration_wc( 'wc_cartpopup_disable' ) ) {
		return;
	}
	global $product;
	if ( empty( $product ) ) {
		$product = wc_get_product( get_the_ID() );
	}
	if ( 'external' == $product->get_type() ) {
		return;
	}
	echo '</div>';
}

add_action( 'wp_footer', 'larisdigital_wc_cart_popup_load_template', 999 );
function larisdigital_wc_cart_popup_load_template() {
	if ( larisdigital_get_integration_wc( 'wc_cartpopup_disable' ) ) {
		return;
	}
	$template = apply_filters( 'larisdigital_cart_popup_template', 'woocommerce/block-wc-cart-popup' );
	get_template_part( $template );
}

add_filter( 'pre_option_woocommerce_cart_redirect_after_add', 'larisdigital_wc_cart_popup_redirect_after_add', 999 );
function larisdigital_wc_cart_popup_redirect_after_add( $value ){
	if ( larisdigital_get_integration_wc( 'wc_cartpopup_disable' ) ) {
		return $value;
	}
	if ( is_admin() ) {
		return $value;
	}
	if ( !is_admin() && isset( $_GET['add-to-cart'] ) && $_GET['add-to-cart'] ) {
		$checkout_url = wc_get_checkout_url();
		$checkout_url = str_replace( array( 'https://', 'http://' ), '', $checkout_url );
		$checkout_url = untrailingslashit( $checkout_url );
		$current_page = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		if ( strpos( $current_page, $checkout_url ) !== false ) {
			return 'no';
		}
		else {
			return 'yes';
		}
	}
	return 'no';
}

add_filter( 'pre_option_woocommerce_enable_ajax_add_to_cart', 'larisdigital_wc_cart_popup_redirect_ajax_shop', 999 );
function larisdigital_wc_cart_popup_redirect_ajax_shop( $value ){
	if ( larisdigital_get_integration_wc( 'wc_cartpopup_disable' ) ) {
		return $value;
	}
	return 'no';
}

add_filter( 'post_class', 'larisdigital_wc_cart_popup_product_class', 999 );
function larisdigital_wc_cart_popup_product_class( $classes ) {
	if ( larisdigital_get_integration_wc( 'wc_cartpopup_disable' ) ) {
		return $classes;
	}
	if ( in_array( 'ajax_add_to_cart', $classes ) && in_array( 'add_to_cart_button', $classes ) ) {
		$classes = array_diff( $classes, array( 'ajax_add_to_cart' ) );
		$classes[] = 'button-shop-addtocart-ajax';
	}
	return $classes;
}

add_filter( 'woocommerce_loop_add_to_cart_args', 'larisdigital_wc_cart_popup_product_class_args', 999 );
function larisdigital_wc_cart_popup_product_class_args( $args ) {
	if ( larisdigital_get_integration_wc( 'wc_cartpopup_disable' ) ) {
		return $args;
	}
	if ( isset( $args['class'] ) && strpos( $args['class'], ' ajax_add_to_cart' ) !== false && strpos( $args['class'], ' add_to_cart_button' ) !== false ) {
		$args['class'] = str_replace( ' ajax_add_to_cart', '', $args['class'] );
		$args['class'] .= ' button-shop-addtocart-ajax';
	}
	return $args;
}

add_action( 'wc_ajax_tp_cart_popup_shop_atc', 'larisdigital_wc_cart_popup_shop_atc' );
add_action( 'wc_ajax_nopriv_tp_cart_popup_shop_atc', 'larisdigital_wc_cart_popup_shop_atc' );
function larisdigital_wc_cart_popup_shop_atc() {
	if ( larisdigital_get_integration_wc( 'wc_cartpopup_disable' ) ) {
		die();
	}
	$data = array(
		'success' => false,
		'notices' => '<ul class="woocommerce-error" role="alert"><li>'.esc_html__( 'Unknown error!', 'larisdigital-wp' ).'</li></ul>',
	);

	$product_id        = apply_filters( 'woocommerce_add_to_cart_product_id', absint( $_POST['product_id'] ) );
	$product           = wc_get_product( $product_id );
	$quantity          = empty( $_POST['quantity'] ) ? 1 : wc_stock_amount( $_POST['quantity'] );
	$passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity );
	$product_status    = get_post_status( $product_id );
	$variation_id      = 0;
	$variation         = array();

	if ( $product && 'variation' === $product->get_type() ) {
		$variation_id = $product_id;
		$product_id   = $product->get_parent_id();
		$variation    = $product->get_variation_attributes();
	}

	if ( $passed_validation && false !== WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variation ) && 'publish' === $product_status ) {

		$data['success'] = true;
		do_action( 'woocommerce_ajax_added_to_cart', $product_id );
		wc_add_to_cart_message( array( $product_id => $quantity ), true );

		ob_start();
		wc_print_notices();
		$data['notices'] = ob_get_clean();
		wc_clear_notices();

		ob_start();
		woocommerce_mini_cart();
		$mini_cart = ob_get_clean();

		$data['fragments'] = apply_filters( 'woocommerce_add_to_cart_fragments', array( 'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>' ) );
		$data['cart_hash'] = apply_filters( 'woocommerce_add_to_cart_hash', WC()->cart->get_cart_for_session() ? md5( json_encode( WC()->cart->get_cart_for_session() ) ) : '', WC()->cart->get_cart_for_session() );

		wp_send_json( $data );
	} 
	else {
		ob_start();
		wc_print_notices();
		$data['notices'] = ob_get_clean();
		wc_clear_notices();

		wp_send_json( $data );
	}
	die();
}

add_action( 'wc_ajax_tp_cart_popup_product_atc', 'larisdigital_wc_cart_popup_product_atc' );
add_action( 'wc_ajax_nopriv_tp_cart_popup_product_atc', 'larisdigital_wc_cart_popup_product_atc' );
function larisdigital_wc_cart_popup_product_atc() {
	if ( larisdigital_get_integration_wc( 'wc_cartpopup_disable' ) ) {
		die();
	}
	$data = array(
		'success' => false,
		'notices' => '<ul class="woocommerce-error" role="alert"><li>'.esc_html__( 'Unknown error!', 'larisdigital-wp' ).'</li></ul>',
	);

	if( !isset($_POST['action'] ) || $_POST['action'] != 'tp_cart_popup_product_atc' || !isset($_POST['add-to-cart'])){
		// $data['notices'] = json_encode( $_POST );
		wp_send_json( $data );
		die();
	}

	$notices_error = wc_get_notices( 'error' );
	if ( ! empty( $notices_error ) ){
		ob_start();
		wc_print_notices();
		$data['notices'] = ob_get_clean();
		wc_clear_notices();

		wp_send_json( $data );
	}
	else {
		$data['success'] = true;
		do_action( 'woocommerce_ajax_added_to_cart', intval( $_POST['add-to-cart'] ) );

		ob_start();
		wc_print_notices();
		$data['notices'] = ob_get_clean();
		wc_clear_notices();

		ob_start();
		woocommerce_mini_cart();
		$mini_cart = ob_get_clean();

		$data['fragments'] = apply_filters( 'woocommerce_add_to_cart_fragments', array( 'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>' ) );
		$data['cart_hash'] = apply_filters( 'woocommerce_add_to_cart_hash', WC()->cart->get_cart_for_session() ? md5( json_encode( WC()->cart->get_cart_for_session() ) ) : '', WC()->cart->get_cart_for_session() );

		wp_send_json( $data );
	}
	die();
}

add_action( 'woocommerce_add_to_cart', 'larisdigital_wc_cart_popup_ajax_cart', 10, 6 );
function larisdigital_wc_cart_popup_ajax_cart( $cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data ) {
	if ( larisdigital_get_integration_wc( 'wc_cartpopup_disable' ) ) {
		return;
	}
	update_option( 'tokopress_wc_cart_popup_key', $cart_item_key );
}

add_filter( 'woocommerce_add_to_cart_fragments', 'larisdigital_wc_cart_popup_fragments', 90 );
function larisdigital_wc_cart_popup_fragments( $fragments ) {
	if ( larisdigital_get_integration_wc( 'wc_cartpopup_disable' ) ) {
		return $fragments;
	}
	$cart_item_key = get_option( 'tokopress_wc_cart_popup_key' );
	if ( empty( $cart_item_key ) ) {
		return $fragments;
	}
	$cart = WC()->cart->get_cart();
	if ( ! isset( $cart[$cart_item_key] ) ) {
		return $fragments;
	}
	$cart_item = $cart[$cart_item_key];
	delete_option( 'tokopress_wc_cart_popup_key' );
	ob_start();
	?>
	<div class="woocommerce widget_shopping_cart">
		<ul class="woocommerce-mini-cart cart_list">
			<?php
			$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
				$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
				$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
				?>
				<li class="woocommerce-mini-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
					<?php
					echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
						'<a href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">&times;</a>',
						esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
						__( 'Remove this item', 'larisdigital-wp' ),
						esc_attr( $product_id ),
						esc_attr( $cart_item_key ),
						esc_attr( $_product->get_sku() )
					), $cart_item_key );
					?>
					<?php if ( empty( $product_permalink ) ) : ?>
						<?php echo $thumbnail . $product_name . '&nbsp;'; ?>
					<?php else : ?>
						<a href="<?php echo esc_url( $product_permalink ); ?>">
							<?php echo $thumbnail . $product_name . '&nbsp;'; ?>
						</a>
					<?php endif; ?>
					<?php echo wc_get_formatted_cart_item_data( $cart_item ); ?>

					<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); ?>
				</li>
				<?php
			}
			?>
		</ul>
	</div>
	<?php 
	$cart_fragment = ob_get_clean();
	$fragments['#tp-cart-popup-content'] = '<div id="tp-cart-popup-content">'.$cart_fragment.'</div>';
	return $fragments;
}

add_filter( 'larisdigital_style', 'larisdigital_wc_cart_popup_style' );
function larisdigital_wc_cart_popup_style( $style ) {
	if ( larisdigital_get_integration_wc( 'wc_cartpopup_disable' ) ) {
		return $style;
	}
	$style = $style.'.tp-cart-popup .modal-body { padding-bottom:0; }';
	$style = $style.'.tp-cart-popup button.close { background: none; border: none; }';
	$style = $style.'.tp-cart-popup .woocommerce ul.cart_list { margin: 0; }';
	$style = $style.'.tp-cart-popup .woocommerce ul.cart_list li { padding-left: 0; }';
	$style = $style.'.tp-cart-popup .woocommerce ul.cart_list li .remove { display: none; }';
	$style = $style.'.woocommerce ul.products li.product .added_to_cart.wc-forward, .woocommerce form.cart .added_to_cart.wc-forward, .tp-cart-popup-notices .button { display: none !important; }';
	$style = $style.'.tp-cart-popup .woocommerce.widget_shopping_cart .cart_list li { padding: 0 0 1em; }';
	$style = $style.'.tp-cart-popup-notices .woocommerce-error, .tp-cart-popup-notices .woocommerce-info, .tp-cart-popup-notices .woocommerce-message { margin-bottom: 1em; }';
	$style = $style.'.woocommerce a.button.alt.single_add_to_cart_button.loading, .woocommerce button.button.alt.single_add_to_cart_button.loading, .woocommerce input.button.alt.single_add_to_cart_button.loading { padding-right: 3rem; }';
	$style = $style.'.tp-cart-popup-loading { padding: 0 0 1.5rem; } .tp-cart-popup-loading .spinkit-wave{display:block;position:relative;top:50%;left:50%;width:50px;height:40px;margin:0 0 0 -25px;font-size:10px;text-align:center}.spinkit-wave .spinkit-rect{display:block;float:left;width:6px;height:50px;margin:0 2px;background-color:#e91e63;-webkit-animation:spinkit-wave-stretch-delay 1.2s infinite ease-in-out;animation:spinkit-wave-stretch-delay 1.2s infinite ease-in-out}.spinkit-wave .spinkit-rect1{-webkit-animation-delay:-1.2s;animation-delay:-1.2s}.spinkit-wave .spinkit-rect2{-webkit-animation-delay:-1.1s;animation-delay:-1.1s}.spinkit-wave .spinkit-rect3{-webkit-animation-delay:-1s;animation-delay:-1s}.spinkit-wave .spinkit-rect4{-webkit-animation-delay:-.9s;animation-delay:-.9s}.spinkit-wave .spinkit-rect5{-webkit-animation-delay:-.8s;animation-delay:-.8s}@-webkit-keyframes spinkit-wave-stretch-delay{0%,100%,40%{-webkit-transform:scaleY(.5);transform:scaleY(.5)}20%{-webkit-transform:scaleY(1);transform:scaleY(1)}}@keyframes spinkit-wave-stretch-delay{0%,100%,40%{-webkit-transform:scaleY(.5);transform:scaleY(.5)}20%{-webkit-transform:scaleY(1);transform:scaleY(1)}}';
	return $style;
}
