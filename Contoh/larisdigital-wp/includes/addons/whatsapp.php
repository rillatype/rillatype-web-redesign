<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'woocommerce' ) ) {
	return;
}

if ( !defined( 'LARISDIGITAL_WC_WHATSAPP_DB' ) ) {
	define( 'LARISDIGITAL_WC_WHATSAPP_DB', 'tokopress_whatsapp' );
}

function larisdigital_get_whatsapp_mod( $name, $default = false ) {
	$options = get_option( LARISDIGITAL_WC_WHATSAPP_DB );
	if ( isset( $options[$name] ) ) {
		return $options[$name];
	}
	return $default;
}

function larisdigital_check_whatsapp_upgrade() {
	$options = get_option( LARISDIGITAL_WC_WHATSAPP_DB );
	$need_upgrade = false;
	if ( isset( $options['wc_product_whatsapp_number'] ) ) {
		$options['wc_whatsapp_number'] = $options['wc_product_whatsapp_number'];
		unset( $options['wc_product_whatsapp_number'] );
		$need_upgrade = true;
	}
	if ( isset( $options['wc_product_whatsapp_message'] ) ) {
		$options['wc_whatsapp_message'] = $options['wc_product_whatsapp_message'];
		unset( $options['wc_product_whatsapp_message'] );
		$need_upgrade = true;
	}
	if ( isset( $options['wc_shop_whatsapp_number'] ) ) {
		unset( $options['wc_shop_whatsapp_number'] );
		$need_upgrade = true;
	}
	if ( isset( $options['wc_shop_whatsapp_message'] ) ) {
		unset( $options['wc_shop_whatsapp_message'] );
		$need_upgrade = true;
	}
	if ( $need_upgrade ) {
		update_option( LARISDIGITAL_WC_WHATSAPP_DB, $options );
	}
}

add_filter( 'larisdigital_customize_controls', 'larisdigital_customize_controls_whatsapp' );
function larisdigital_customize_controls_whatsapp( $controls ) {

	larisdigital_check_whatsapp_upgrade();

	$controls['larisdigital_section_whatsapp'] = array(
		'title'    => esc_html__( 'WhatsApp', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_section_whatsapp',
		'panel'    => 'larisdigital_panel_integrations',
		'type'     => 'section',
		'priority' => 50,
	);

	$controls['wc_whatsapp_number'] = array(
		'label'				=> esc_html__( 'WhatsApp Number', 'larisdigital-wp' ),
		'setting'  			=> 'wc_whatsapp_number',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_WC_WHATSAPP_DB,
		'section'			=> 'larisdigital_section_whatsapp',
		'type'				=> 'text',
		'priority'   		=> 10,
	);

	$controls['wc_whatsapp_message'] = array(
		'label'				=> esc_html__( 'WhatsApp Message / Greeting Text', 'larisdigital-wp' ),
		'description'		=> esc_html__( 'Available Parameters:', 'larisdigital-wp' ).' <code>%site_name%</code>, <code>%product_title%</code>, <code>%product_price%</code>, <code>%product_id%</code>, <code>%product_sku%</code>, <code>%product_url%</code>, <code>%product_categories%</code>, <code>%product_tags%</code>',
		'setting'  			=> 'wc_whatsapp_message',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_WC_WHATSAPP_DB,
		'section'			=> 'larisdigital_section_whatsapp',
		'type'				=> 'textarea',
		'input_attrs' => array(
			'placeholder' => apply_filters( 'larisdigital_whatsapp_message_default', esc_html__( 'Hi %site_name%, I am interested in %product_title%, thank you.', 'larisdigital-wp' ) ),
		),
		'priority'   		=> 10,
	);

	$controls['larisdigital_heading_whatsapp_rotator'] = array(
		'label'				=> esc_html__( 'WhatsApp Rotator', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_heading_whatsapp_rotator',
		'section'			=> 'larisdigital_section_whatsapp',
		'type'   			=> 'heading',
		'priority'   		=> 20,
	);

	$controls['wc_whatsapp_rotator_enable'] = array(
		'label'				=> esc_html__( 'ENABLE WhatsApp Rotator', 'larisdigital-wp' ),
		'setting'  			=> 'wc_whatsapp_rotator_enable',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_WC_WHATSAPP_DB,
		'section'			=> 'larisdigital_section_whatsapp',
		'type'				=> 'checkbox',
		'priority'   		=> 20,
	);

	$controls['wc_whatsapp_loading_text'] = array(
		'label'				=> esc_html__( 'WhatsApp Rotator Loading Page Text (Available)', 'larisdigital-wp' ),
		'setting'  			=> 'wc_whatsapp_loading_text',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_WC_WHATSAPP_DB,
		'section'			=> 'larisdigital_section_whatsapp',
		'type'				=> 'text',
		'input_attrs' => array(
			'placeholder' => apply_filters( 'larisdigital_whatsapp_loading_text_default', esc_html__( 'Please wait, you will be connected with our customer service...', 'larisdigital-wp' ) ),
		),
		'active_callback'	=> 'larisdigital_wc_callback_whatsapp_rotator_is_active',
		'priority'   		=> 20,
	);

	$controls['wc_whatsapp_unavailable_text'] = array(
		'label'				=> esc_html__( 'WhatsApp Rotator Loading Page Text (Unavailable)', 'larisdigital-wp' ),
		'setting'  			=> 'wc_whatsapp_unavailable_text',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_WC_WHATSAPP_DB,
		'section'			=> 'larisdigital_section_whatsapp',
		'type'				=> 'text',
		'input_attrs' => array(
			'placeholder' => apply_filters( 'larisdigital_whatsapp_unavailable_text_default', esc_html__( 'Sorry, our customer service is not available right now, please try again later...', 'larisdigital-wp' ) ),
		),
		'active_callback'	=> 'larisdigital_wc_callback_whatsapp_rotator_is_active',
		'priority'   		=> 20,
	);

	$wa_numbers = apply_filters( 'tokopressid_whatsapp_rotator_numbers', 10 );
	for ( $i=2; $i <= $wa_numbers ; $i++) { 
		$controls['wc_whatsapp_number_'.$i] = array(
			'label'				=> sprintf( esc_html__( 'WhatsApp Number #%s', 'larisdigital-wp' ), $i ),
			'setting'  			=> 'wc_whatsapp_number_'.$i,
			'setting_type' 		=> 'option_mod',
			'setting_db' 		=> LARISDIGITAL_WC_WHATSAPP_DB,
			'section'			=> 'larisdigital_section_whatsapp',
			'type'				=> 'text',
			'active_callback'	=> 'larisdigital_wc_callback_whatsapp_rotator_is_active',
			'priority'   		=> 20,
		);
	}

	$controls['larisdigital_whatsapp_menu_product'] = array(
		'label'				=> esc_html__( 'WhatsApp Button On Single Product', 'larisdigital-wp' ),
		'description' 		=> '<p class="larisdigital-alert larisdigital-alert-with-icon">
								<span class="dashicons dashicons-admin-tools"></span> <a href="javascript:wp.customize.control( \'larisdigital_wc_heading_product_whatsapp\' ).focus();">'.esc_html__( 'CLICK HERE to show/hide WhatsApp Button on Single Product from Single Product Settings', 'larisdigital-wp' ).'</a>
								</p>',
		'setting'  			=> 'larisdigital_whatsapp_menu_product',
		'section'			=> 'larisdigital_section_whatsapp',
		'type'   			=> 'heading',
		'priority'   		=> 30,
	);

	$controls['larisdigital_whatsapp_menu_shop'] = array(
		'label'				=> esc_html__( 'WhatsApp Button On Shop Page', 'larisdigital-wp' ),
		'description' 		=> '<p class="larisdigital-alert larisdigital-alert-with-icon">
								<span class="dashicons dashicons-admin-tools"></span> <a href="javascript:wp.customize.control( \'larisdigital_wc_heading_shop_whatsapp\' ).focus();">'.esc_html__( 'CLICK HERE to show/hide WhatsApp Button on Shop Page from Shop Page Settings', 'larisdigital-wp' ).'</a>
								</p>',
		'setting'  			=> 'larisdigital_whatsapp_menu_shop',
		'section'			=> 'larisdigital_section_whatsapp',
		'type'   			=> 'heading',
		'priority'   		=> 32,
	);

	$controls['larisdigital_whatsapp_menu_fbpixel'] = array(
		'label'				=> esc_html__( 'Button Click Facebook Pixel on WhatsApp Button', 'larisdigital-wp' ),
		'description' 		=> '<p class="larisdigital-alert larisdigital-alert-with-icon">
								<span class="dashicons dashicons-admin-tools"></span> <a href="javascript:wp.customize.control( \'larisdigital_heading_fbpixel_whatsapp\' ).focus();">'.esc_html__( 'CLICK HERE to setup Button Click Facebook Pixel on WhatsApp Button from Facebook Pixel Settings', 'larisdigital-wp' ).'</a>
								</p>',
		'setting'  			=> 'larisdigital_whatsapp_menu_fbpixel',
		'section'			=> 'larisdigital_section_whatsapp',
		'type'   			=> 'heading',
		'priority'   		=> 34,
	);

	$controls['larisdigital_whatsapp_menu_adwords'] = array(
		'label'				=> esc_html__( 'Button Click AdWords Conversion on WhatsApp Button', 'larisdigital-wp' ),
		'description' 		=> '<p class="larisdigital-alert larisdigital-alert-with-icon">
								<span class="dashicons dashicons-admin-tools"></span> <a href="javascript:wp.customize.control( \'larisdigital_heading_adwords_whatsapp\' ).focus();">'.esc_html__( 'CLICK HERE to setup Button Click AdWords Conversion on WhatsApp Button from Google AdWords Settings', 'larisdigital-wp' ).'</a>
								</p>',
		'setting'  			=> 'larisdigital_whatsapp_menu_adwords',
		'section'			=> 'larisdigital_section_whatsapp',
		'type'   			=> 'heading',
		'priority'   		=> 36,
	);

	$controls['larisdigital_wc_heading_product_whatsapp'] = array(
		'label'				=> esc_html__( 'WhatsApp Chat Button', 'larisdigital-wp' ),
		'description' 		=> '<p class="larisdigital-alert larisdigital-alert-with-icon"><span class="dashicons dashicons-admin-tools"></span> <a href="javascript:wp.customize.section( \'larisdigital_section_whatsapp\' ).focus();">'.esc_html__( 'CLICK HERE to setup WhatsApp number', 'larisdigital-wp' ).'</a></p>',
		'setting'  			=> 'larisdigital_wc_heading_product_whatsapp',
		'section'			=> 'larisdigital_wc_section_product',
		'type'   			=> 'heading',
		'priority'   		=> 22,
	);

	$controls['wc_product_whatsapp_enable'] = array(
		'label'				=> esc_html__( 'ENABLE WhatsApp Chat Button', 'larisdigital-wp' ),
		'setting'  			=> 'wc_product_whatsapp_enable',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_WC_WHATSAPP_DB,
		'section'			=> 'larisdigital_wc_section_product',
		'type'				=> 'checkbox',
		'priority'   		=> 22,
	);

	$controls['wc_product_whatsapp_style'] = array(
		'label'				=> esc_html__( 'Button Style', 'larisdigital-wp' ),
		'setting'			=> 'wc_product_whatsapp_style',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_WC_WHATSAPP_DB,
		'section'			=> 'larisdigital_wc_section_product',
		'type'				=> 'radio',
		'choices'			=> array(
			''				=> esc_html__( 'Inline', 'larisdigital-wp' ),
			'fullwidth'		=> esc_html__( 'Full Width', 'larisdigital-wp' ),
		),
		'style'				=> array(
			''				=> '',
			'fullwidth'		=> '.woocommerce a.button.single_whatsapp_button, .woocommerce-product-whatsapp { clear: both; display:block; width: 100%; } .woocommerce-product-whatsapp { padding: 0; }',
		),
		'active_callback'	=> 'larisdigital_wc_callback_product_whatsapp_is_active',
		'priority'   		=> 22,
	);

	$controls['wc_product_whatsapp_text'] = array(
		'label'				=> esc_html__( 'Button Text', 'larisdigital-wp' ),
		'setting'  			=> 'wc_product_whatsapp_text',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_WC_WHATSAPP_DB,
		'section'			=> 'larisdigital_wc_section_product',
		'type'				=> 'text',
		'input_attrs' => array(
			'placeholder' => esc_html__( 'Chat Seller', 'larisdigital-wp' ),
		),
		'active_callback'	=> 'larisdigital_wc_callback_product_whatsapp_is_active',
		'priority'   		=> 22,
	);

	$controls['wc_product_whatsapp_font_size'] = array(
		'label'    			=> esc_html__( 'Font Size', 'larisdigital-wp' ),
		'setting'  			=> 'wc_product_whatsapp_font_size',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_WC_WHATSAPP_DB,
		'section'			=> 'larisdigital_wc_section_product',
		'type'     			=> 'slider',
		'choices'  			=> array(
			'min' 			=> 0.5,
			'max' 			=> 2,
			'step' 			=> 0.1,
			'unit' 			=> 'rem',
		),
		'style'    			=> '.woocommerce a.button.single_whatsapp_button { font-size: [value]rem }',
		'active_callback'	=> 'larisdigital_wc_callback_product_whatsapp_is_active',
		'priority'   		=> 22,
	);

	$controls['wc_product_whatsapp_background'] = array(
		'label'				=> esc_html__( 'Background Color', 'larisdigital-wp' ),
		'setting'  			=> 'wc_product_whatsapp_background',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_WC_WHATSAPP_DB,
		'section'			=> 'larisdigital_wc_section_product',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce a.button.single_whatsapp_button { background-color: [value] }',
		'active_callback'	=> 'larisdigital_wc_callback_product_whatsapp_is_active',
		'priority'   		=> 22,
	);

	$controls['wc_product_whatsapp_border'] = array(
		'label'				=> esc_html__( 'Border Color', 'larisdigital-wp' ),
		'setting'  			=> 'wc_product_whatsapp_border',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_WC_WHATSAPP_DB,
		'section'			=> 'larisdigital_wc_section_product',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce a.button.single_whatsapp_button { border-color: [value] }',
		'active_callback'	=> 'larisdigital_wc_callback_product_whatsapp_is_active',
		'priority'   		=> 22,
	);

	$controls['wc_product_whatsapp_color'] = array(
		'label'				=> esc_html__( 'Text Color', 'larisdigital-wp' ),
		'setting'  			=> 'wc_product_whatsapp_color',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_WC_WHATSAPP_DB,
		'section'			=> 'larisdigital_wc_section_product',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce a.button.single_whatsapp_button { color: [value] }',
		'active_callback'	=> 'larisdigital_wc_callback_product_whatsapp_is_active',
		'priority'   		=> 22,
	);

	$controls['wc_product_whatsapp_background_hover'] = array(
		'label'				=> esc_html__( 'Background Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  			=> 'wc_product_whatsapp_background_hover',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_WC_WHATSAPP_DB,
		'section'			=> 'larisdigital_wc_section_product',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce a.button.single_whatsapp_button:hover { background-color: [value] }',
		'active_callback'	=> 'larisdigital_wc_callback_product_whatsapp_is_active',
		'priority'   		=> 22,
	);

	$controls['wc_product_whatsapp_border_hover'] = array(
		'label'				=> esc_html__( 'Border Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  			=> 'wc_product_whatsapp_border_hover',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_WC_WHATSAPP_DB,
		'section'			=> 'larisdigital_wc_section_product',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce a.button.single_whatsapp_button:hover { border-color: [value] }',
		'active_callback'	=> 'larisdigital_wc_callback_product_whatsapp_is_active',
		'priority'   		=> 22,
	);

	$controls['wc_product_whatsapp_color_hover'] = array(
		'label'				=> esc_html__( 'Text Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  			=> 'wc_product_whatsapp_color_hover',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_WC_WHATSAPP_DB,
		'section'			=> 'larisdigital_wc_section_product',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce a.button.single_whatsapp_button:hover { color: [value] }',
		'active_callback'	=> 'larisdigital_wc_callback_product_whatsapp_is_active',
		'priority'   		=> 22,
	);

	$controls['larisdigital_wc_heading_shop_whatsapp'] = array(
		'label'				=> esc_html__( 'WhatsApp Chat Button', 'larisdigital-wp' ),
		'description' 		=> '<p class="larisdigital-alert larisdigital-alert-with-icon"><span class="dashicons dashicons-admin-tools"></span> <a href="javascript:wp.customize.section( \'larisdigital_section_whatsapp\' ).focus();">'.esc_html__( 'CLICK HERE to setup WhatsApp number', 'larisdigital-wp' ).'</a></p>',
		'setting'  			=> 'larisdigital_wc_heading_shop_whatsapp',
		'section'			=> 'larisdigital_wc_section_shop',
		'type'   			=> 'heading',
		'priority'   		=> 22,
	);

	$controls['wc_shop_whatsapp_enable'] = array(
		'label'				=> esc_html__( 'ENABLE WhatsApp Chat Button', 'larisdigital-wp' ),
		'setting'  			=> 'wc_shop_whatsapp_enable',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_WC_WHATSAPP_DB,
		'section'			=> 'larisdigital_wc_section_shop',
		'type'				=> 'checkbox',
		'priority'   		=> 22,
	);

	$controls['wc_shop_whatsapp_style'] = array(
		'label'				=> esc_html__( 'Button Style', 'larisdigital-wp' ),
		'setting'			=> 'wc_shop_whatsapp_style',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_WC_WHATSAPP_DB,
		'section'			=> 'larisdigital_wc_section_shop',
		'type'				=> 'radio',
		'choices'			=> array(
			''				=> esc_html__( 'Inline', 'larisdigital-wp' ),
			'fullwidth'		=> esc_html__( 'Full Width', 'larisdigital-wp' ),
		),
		'style'				=> array(
			''				=> '',
			'fullwidth'		=> '.woocommerce ul.products li.product .button-shop-whatsapp, .woocommerce-shop-whatsapp { clear: both; display:block; width: 100%; } .woocommerce-shop-whatsapp { padding: 0; }',
		),
		'active_callback'	=> 'larisdigital_wc_callback_shop_whatsapp_is_active',
		'priority'   		=> 22,
	);

	$controls['wc_shop_whatsapp_text'] = array(
		'label'				=> esc_html__( 'Button Text', 'larisdigital-wp' ),
		'setting'  			=> 'wc_shop_whatsapp_text',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_WC_WHATSAPP_DB,
		'section'			=> 'larisdigital_wc_section_shop',
		'type'				=> 'text',
		'input_attrs' => array(
			'placeholder' => esc_html__( 'Chat Seller', 'larisdigital-wp' ),
		),
		'active_callback'	=> 'larisdigital_wc_callback_shop_whatsapp_is_active',
		'priority'   		=> 22,
	);

	$controls['wc_shop_whatsapp_font_size'] = array(
		'label'    			=> esc_html__( 'Font Size', 'larisdigital-wp' ),
		'setting'  			=> 'wc_shop_whatsapp_font_size',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_WC_WHATSAPP_DB,
		'section'			=> 'larisdigital_wc_section_shop',
		'type'     			=> 'slider',
		'choices'  			=> array(
			'min' 			=> 0.5,
			'max' 			=> 2,
			'step' 			=> 0.1,
			'unit' 			=> 'rem',
		),
		'style'    			=> '.woocommerce ul.products li.product .button-shop-whatsapp { font-size: [value]rem }',
		'active_callback'	=> 'larisdigital_wc_callback_shop_whatsapp_is_active',
		'priority'   		=> 22,
	);

	$controls['wc_shop_whatsapp_background'] = array(
		'label'				=> esc_html__( 'Background Color', 'larisdigital-wp' ),
		'setting'  			=> 'wc_shop_whatsapp_background',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_WC_WHATSAPP_DB,
		'section'			=> 'larisdigital_wc_section_shop',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce ul.products li.product .button-shop-whatsapp { background-color: [value] }',
		'active_callback'	=> 'larisdigital_wc_callback_shop_whatsapp_is_active',
		'priority'   		=> 22,
	);

	$controls['wc_shop_whatsapp_border'] = array(
		'label'				=> esc_html__( 'Border Color', 'larisdigital-wp' ),
		'setting'  			=> 'wc_shop_whatsapp_border',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_WC_WHATSAPP_DB,
		'section'			=> 'larisdigital_wc_section_shop',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce ul.products li.product .button-shop-whatsapp { border-color: [value] }',
		'active_callback'	=> 'larisdigital_wc_callback_shop_whatsapp_is_active',
		'priority'   		=> 22,
	);

	$controls['wc_shop_whatsapp_color'] = array(
		'label'				=> esc_html__( 'Text Color', 'larisdigital-wp' ),
		'setting'  			=> 'wc_shop_whatsapp_color',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_WC_WHATSAPP_DB,
		'section'			=> 'larisdigital_wc_section_shop',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce ul.products li.product .button-shop-whatsapp { color: [value] }',
		'active_callback'	=> 'larisdigital_wc_callback_shop_whatsapp_is_active',
		'priority'   		=> 22,
	);

	$controls['wc_shop_whatsapp_background_hover'] = array(
		'label'				=> esc_html__( 'Background Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  			=> 'wc_shop_whatsapp_background_hover',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_WC_WHATSAPP_DB,
		'section'			=> 'larisdigital_wc_section_shop',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce ul.products li.product .button-shop-whatsapp:hover { background-color: [value] }',
		'active_callback'	=> 'larisdigital_wc_callback_shop_whatsapp_is_active',
		'priority'   		=> 22,
	);

	$controls['wc_shop_whatsapp_border_hover'] = array(
		'label'				=> esc_html__( 'Border Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  			=> 'wc_shop_whatsapp_border_hover',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_WC_WHATSAPP_DB,
		'section'			=> 'larisdigital_wc_section_shop',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce ul.products li.product .button-shop-whatsapp:hover { border-color: [value] }',
		'active_callback'	=> 'larisdigital_wc_callback_shop_whatsapp_is_active',
		'priority'   		=> 22,
	);

	$controls['wc_shop_whatsapp_color_hover'] = array(
		'label'				=> esc_html__( 'Text Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  			=> 'wc_shop_whatsapp_color_hover',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_WC_WHATSAPP_DB,
		'section'			=> 'larisdigital_wc_section_shop',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce ul.products li.product .button-shop-whatsapp:hover { color: [value] }',
		'active_callback'	=> 'larisdigital_wc_callback_shop_whatsapp_is_active',
		'priority'   		=> 22,
	);

	$controls['larisdigital_heading_fbpixel_whatsapp'] = array(
		'label'				=> esc_html__( 'WhatsApp Button Click', 'larisdigital-wp' ),
		'description' 		=> '<p class="larisdigital-alert larisdigital-alert-with-icon"><span class="dashicons dashicons-admin-tools"></span> <a href="javascript:wp.customize.section( \'larisdigital_section_whatsapp\' ).focus();">'.esc_html__( 'CLICK HERE to setup WhatsApp number', 'larisdigital-wp' ).'</a></p>',
		'setting'  			=> 'larisdigital_heading_fbpixel_whatsapp',
		'section'  			=> 'larisdigital_section_fbpixel',
		'type'   			=> 'heading',
		'priority'			=> 21,
	);

	$controls['wc_whatsapp_fbpixel_disable'] = array(
		'label'				=> esc_html__( 'DISABLE FB Pixel Event on WhatsApp Button Click', 'larisdigital-wp' ),
		'setting'  			=> 'wc_whatsapp_fbpixel_disable',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_WC_WHATSAPP_DB,
		'section'  			=> 'larisdigital_section_fbpixel',
		'type'				=> 'checkbox',
		'priority'   		=> 21,
	);

	$controls['wc_product_whatsapp_fbpixel'] = array(
		'label'    			=> sprintf( esc_html__( 'FB Pixel Event on %s', 'larisdigital-wp' ), esc_html__( 'WhatsApp Button', 'larisdigital-wp' ) ),
		'setting'  			=> 'wc_product_whatsapp_fbpixel',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_WC_WHATSAPP_DB,
		'section'  			=> 'larisdigital_section_fbpixel',
		'type'     			=> 'text',
		'input_attrs' 		=> array(
			'placeholder' 	=> 'Lead',
		),
		'active_callback'	=> 'larisdigital_wc_callback_whatsapp_fbpixel_is_active',
		'priority'			=> 21,
	);

	$controls['larisdigital_heading_adwords_whatsapp'] = array(
		'label'				=> esc_html__( 'WhatsApp Button', 'larisdigital-wp' ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-warning larisdigital-alert-with-icon">
							<span class="dashicons dashicons-warning"></span> '.esc_html__( 'Go to "Measurement - Conversions" menu on your Google AdWords dashboard to create your conversion action for WhatsApp Button.', 'larisdigital-wp' ).'<br><br>'.esc_html__( 'You only need to put "send_to" parameter here. Other parameters (value, currency, transaction_id) will be populated automatically.', 'larisdigital-wp' ).'
							</p>',
		'setting'  			=> 'larisdigital_heading_adwords_whatsapp',
		'section'			=> 'larisdigital_section_google_adwords',
		'type'   			=> 'heading',
	);

	$controls['wc_whatsapp_adwords_send_to_1'] = array(
		'label'				=> esc_html__( 'send_to', 'larisdigital-wp' ),
		'setting'  			=> 'wc_whatsapp_adwords_send_to_1',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_WC_WHATSAPP_DB,
		'section'			=> 'larisdigital_section_google_adwords',
		'type'   			=> 'text',
	);

	$controls['larisdigital_menu_adwords_whatsapp'] = array(
		'description' 		=> '<p class="larisdigital-alert larisdigital-alert-with-icon"><span class="dashicons dashicons-admin-tools"></span> <a href="javascript:wp.customize.section( \'larisdigital_section_whatsapp\' ).focus();">'.esc_html__( 'CLICK HERE to setup WhatsApp number', 'larisdigital-wp' ).'</a></p>',
		'setting'  			=> 'larisdigital_menu_adwords_whatsapp',
		'section'			=> 'larisdigital_section_google_adwords',
		'type'   			=> 'heading',
	);

	$controls['wc_whatsapp_product_desc'] = array(
		'label'    			=> esc_html__( 'Show WhatsApp Button Below Product Description', 'larisdigital-wp' ),
		'setting'  			=> 'wc_whatsapp_product_desc',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_WC_WHATSAPP_DB,
		'section'  			=> 'larisdigital_wc_section_product',
		'type'     			=> 'select',
		'default'			=> 'no',
		'choices' 			=> array(
			'no' 			=> esc_html__( 'No / Hide', 'larisdigital-wp' ),
			'yes' 			=> esc_html__( 'Yes / Show', 'larisdigital-wp' ),
		),
		'priority'   		=> 35,
	);

	return $controls;
}

function larisdigital_wc_callback_product_whatsapp_is_active() {
	return larisdigital_get_whatsapp_mod( 'wc_product_whatsapp_enable' ) ? true : false;
}

function larisdigital_wc_callback_shop_whatsapp_is_active() {
	return larisdigital_get_whatsapp_mod( 'wc_shop_whatsapp_enable' ) ? true : false;
}

function larisdigital_wc_callback_whatsapp_rotator_is_active() {
	return larisdigital_get_whatsapp_mod( 'wc_whatsapp_rotator_enable' ) ? true : false;
}

function larisdigital_wc_callback_whatsapp_fbpixel_is_active() {
	return larisdigital_get_whatsapp_mod( 'wc_whatsapp_fbpixel_disable' ) ? false : true;
}

add_action( 'wp', 'larisdigital_wc_setup_whatsapp_rotator' );
function larisdigital_wc_setup_whatsapp_rotator() {
	if ( isset( $_GET['tp_wa_rotator'] ) ) {
		$rotator = intval( sanitize_key( $_GET['tp_wa_rotator'] ) );
		if ( $rotator !== 1 ) {
			return;
		}

		if ( ! defined( 'DONOTCACHEPAGE' ) ) {
			define( 'DONOTCACHEPAGE', true );
		}
		if ( ! defined( 'DONOTCACHEOBJECT' ) ) {
			define( 'DONOTCACHEOBJECT', true );
		}
		if ( ! defined( 'DONOTCACHEDB' ) ) {
			define( 'DONOTCACHEDB', true );
		}

		header('Expires: Tue, 20 Oct 1981 05:00:00 GMT'); 
		header('Cache-Control: no-store, no-cache, must-revalidate'); 
		header('Pragma: no-cache');

		$wa_numbers = apply_filters( 'tokopressid_whatsapp_rotator_numbers', 10 );
		$numbers = array();
		$j = 0;
		for ( $i=1; $i <= $wa_numbers ; $i++ ) { 
			$number = $i == 1 ? larisdigital_get_whatsapp_mod( 'wc_whatsapp_number' ) : larisdigital_get_whatsapp_mod( 'wc_whatsapp_number_'.$i );
			if ( !empty( $number ) ) {
				$j = $j + 1;
				$numbers[ $j ] = $number;
			}
		}
		$number = '';
		$link = '';
		$deeplink = '';
		if ( ! empty( $numbers ) ) {
			$rotator_id = intval( get_option( LARISDIGITAL_WC_WHATSAPP_DB.'_rotator' ) );
			$rotator_id = $rotator_id + 1;
			if ( ! isset( $numbers[ $rotator_id ] ) ) {
				$rotator_id = 1;
			}
			update_option( LARISDIGITAL_WC_WHATSAPP_DB.'_rotator', $rotator_id );
			$number = $numbers[ $rotator_id ];
			$number = larisdigital_whatsapp_number_format( $number );
			$link = 'https://api.whatsapp.com/send?phone='.$number;
			$deeplink = 'whatsapp://send?phone='.$number;
			$message = larisdigital_get_whatsapp_mod( 'wc_whatsapp_message' );
			if ( empty( $message ) ) {
				$message = apply_filters( 'larisdigital_whatsapp_message_default', esc_html__( 'Hi %site_name%, I am interested in %product_title%, thank you.', 'larisdigital-wp' ) );
			}
			if ( ! empty( $message ) ) {
				if ( isset( $_GET['tp_product_id'] ) ) {
					$product_id = intval( sanitize_key( $_GET['tp_product_id'] ) );
					if ( $product_id > 0 ) {
						$product = wc_get_product( $product_id );
						if ( !empty( $product ) ) {
							$product_id = $product->get_ID();
							$product_title = $product->get_title();
							$product_price = $product->get_price();
							$price = wc_price( $product_price );
							$price = strip_tags( $price );
							if (strpos($message, '%site_name%') !== false) {
								$message = str_replace( '%site_name%', get_bloginfo('name'), $message );
							}
							if (strpos($message, '%product_title%') !== false) {
								$message = str_replace( '%product_title%', $product_title, $message );
							}
							if (strpos($message, '%product_price%') !== false) {
								$message = str_replace( '%product_price%', $price, $message );
							}
							if (strpos($message, '%product_id%') !== false) {
								$message = str_replace( '%product_id%', $product_id, $message );
							}
							if (strpos($message, '%product_sku%') !== false) {
								$sku = get_post_meta( $product_id, '_sku', true );
								$message = str_replace( '%product_sku%', $sku, $message );
							}
							if (strpos( $message, '%product_url%' ) !== false ) {
								$url = get_permalink( $product_id );
								$message = str_replace( '%product_url%', $url, $message );
							}
							if (strpos( $message, '%product_categories%' ) !== false) {
								$cats_array = array();
								$cats = '';
								$terms = wp_get_post_terms( $product_id, 'product_cat' );
								foreach ($terms as $term) {
									$cats_array[] = $term->name;
								}
								$cats = implode(', ', $cats_array);
								$message = str_replace( '%product_categories%', $cats, $message );
							}
							if (strpos( $message, '%product_tags%' ) !== false) {
								$tags_array = array();
								$tags = '';
								$terms = wp_get_post_terms( $product_id, 'product_tag' );
								foreach ($terms as $term) {
									$tags_array[] = $term->name;
								}
								$tags = implode(', ', $tags_array);
								$message = str_replace( '%product_tags%', $tags, $message );
							}
						}
					}
				}
				$message = html_entity_decode( $message );
				$link .= '&text='.rawurlencode($message);
				$deeplink .= '&text='.rawurlencode($message);
			}
		}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0">
<title>Chat WhatsApp</title>
<meta name="robots" content="noindex,nofollow">
<style type="text/css">
html, body { background: #f5f5f5; color: #333; margin:0; padding: 0 }
.larisdigital-text {display:block;position:absolute;top:50%;left:0;width:100%;margin:0 0;font-size:14px;font-family:sans-serif;text-align:center}
.larisdigital-loading-text {padding:0 20px;}
.larisdigital-phone {padding:10px 0; vertical-align: middle;font-size:20px; line-height: 23px; }
.larisdigital-phone a {text-decoration: none; color: #333; }
.larisdigital-phone img {width: 23px; height: 23px; vertical-align: middle;}
.larisdigital-button { padding:10px 0; }
.larisdigital-button a { border-radius: 5px; padding: 10px 17px; font-size: 13px; line-height: 19px; display: inline-block; background-color: #25d366; color: #fff !important; text-decoration: none; letter-spacing: 1px; }
/* Spinkit https://github.com/tobiasahlin/SpinKit MIT License */
.spinkit-wave{display:block;position:absolute;top:50%;left:50%;width:50px;height:40px;margin:-65px 0 0 -25px;font-size:10px;text-align:center}
.spinkit-wave .spinkit-rect{display:block;float:left;width:6px;height:50px;margin:0 2px;background-color:#e91e63;-webkit-animation:spinkit-wave-stretch-delay 1.2s infinite ease-in-out;animation:spinkit-wave-stretch-delay 1.2s infinite ease-in-out}
.spinkit-wave .spinkit-rect1{-webkit-animation-delay:-1.2s;animation-delay:-1.2s}
.spinkit-wave .spinkit-rect2{-webkit-animation-delay:-1.1s;animation-delay:-1.1s}
.spinkit-wave .spinkit-rect3{-webkit-animation-delay:-1s;animation-delay:-1s}
.spinkit-wave .spinkit-rect4{-webkit-animation-delay:-.9s;animation-delay:-.9s}
.spinkit-wave .spinkit-rect5{-webkit-animation-delay:-.8s;animation-delay:-.8s}@-webkit-keyframes spinkit-wave-stretch-delay{0%,100%,40%{-webkit-transform:scaleY(.5);transform:scaleY(.5)}20%{-webkit-transform:scaleY(1);transform:scaleY(1)}}@keyframes spinkit-wave-stretch-delay{0%,100%,40%{-webkit-transform:scaleY(.5);transform:scaleY(.5)}20%{-webkit-transform:scaleY(1);transform:scaleY(1)}}
</style>
</head>
<body>
<!– [wpfcNOT] –>
	<div class="spinkit-wave">
		<div class="spinkit-rect spinkit-rect1"></div>
		<div class="spinkit-rect spinkit-rect2"></div>
		<div class="spinkit-rect spinkit-rect3"></div>
		<div class="spinkit-rect spinkit-rect4"></div>
		<div class="spinkit-rect spinkit-rect5"></div>
	</div>
	<div class="larisdigital-text">
	<?php if ( $number ) : ?>
		<div class="larisdigital-message">
			<div class="larisdigital-loading-text">
				<?php
				$loading_text = larisdigital_get_whatsapp_mod( 'wc_whatsapp_loading_text' );
				if ( empty( $loading_text ) ) {
					$loading_text = apply_filters( 'larisdigital_whatsapp_loading_text_default', esc_html__( 'Please wait, you will be connected with our customer service...', 'larisdigital-wp' ) );
				}
				echo esc_html( $loading_text );
				?>
			</div>
		</div>
		<div class="larisdigital-phone">
			<a rel="nofollow" href="<?php echo $deeplink;?>">
				<img src="data:image/png;base64,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" alt=""/> +<?php echo esc_html($number); ?>
			</a>
		</div>
		<div class="larisdigital-button">
			<a rel="nofollow" href="<?php echo $deeplink;?>">
				<?php echo esc_html__( 'Chat WhatsApp', 'larisdigital-wp' ); ?>
			</a>
		</div>
	<?php else : ?>
		<div class="larisdigital-message">
			<div class="larisdigital-loading-text">
				<?php
				$unavailable_text = larisdigital_get_whatsapp_mod( 'wc_whatsapp_unavailable_text' );
				if ( empty( $unavailable_text ) ) {
					$unavailable_text = apply_filters( 'larisdigital_whatsapp_unavailable_text_default', esc_html__( 'Sorry, our customer service is not available right now, please try again later...', 'larisdigital-wp' ) );
				}
				echo esc_html( $unavailable_text );
				?>
			</div>
		</div>
	<?php endif; ?>
	</div>
<?php if ( $number ) : ?>
<script type="text/javascript">
window.location = "<?php echo $link; ?>";
</script>
<?php endif; ?>
</body>
</html>
<?php 
		exit;
	}
}

add_action( 'larisdigital_wc_setup_product_page', 'larisdigital_wc_setup_product_whatsapp' );
function larisdigital_wc_setup_product_whatsapp() {

	larisdigital_check_whatsapp_upgrade();

	if ( ! larisdigital_get_whatsapp_mod( 'wc_product_whatsapp_enable' ) ) {
		return;
	}
	add_action( 'woocommerce_after_add_to_cart_button', 'larisdigital_wc_product_whatsapp_output', 5 );
	add_action( 'woocommerce_single_product_summary', 'larisdigital_wc_product_whatsapp_output', 31 );
}

function larisdigital_wc_product_whatsapp_output() {
	global $larisdigital_wc_product_whatsapp_output;
	if ( $larisdigital_wc_product_whatsapp_output ) {
		return;
	}
	echo larisdigital_wc_button_whatsapp_output(
		array(
			'text'			=> larisdigital_get_whatsapp_mod( 'wc_product_whatsapp_text' ),
			'button_class'	=> 'single_whatsapp_button',
			'button_pos'	=> 'product',
			'before'		=> '<div class="woocommerce-product-whatsapp clearfix">',
			'after'			=> '</div>',
		)
	);
	$larisdigital_wc_product_whatsapp_output = true;
}

add_filter( 'larisdigital_wc_product_button_group_class', 'larisdigital_wc_product_button_group_class_whatsapp' );
function larisdigital_wc_product_button_group_class_whatsapp( $class ) {
	global $product;
	if ( empty( $product ) ) {
		$product = wc_get_product( get_the_ID() );
	}
	if ( ! $product->is_purchasable() ) {
		return $class;
	}
	if ( ! $product->is_in_stock() ) {
		return $class;
	}
	if ( larisdigital_theme_mod( 'larisdigital_wc_product_button_disable' ) ) {
		return $class;
	}
	if ( ! larisdigital_get_whatsapp_mod( 'wc_product_whatsapp_enable' ) ) {
		return $class;
	}
	$class .= ' woocommerce-product-button-double';
	return $class;
}

add_action( 'larisdigital_wc_setup_shop_page', 'larisdigital_wc_setup_shop_whatsapp' );
function larisdigital_wc_setup_shop_whatsapp() {
	if ( ! larisdigital_get_whatsapp_mod( 'wc_shop_whatsapp_enable' ) ) {
		return;
	}
	add_action( 'woocommerce_after_shop_loop_item', 'larisdigital_wc_shop_whatsapp_output', 11 );
}

function larisdigital_wc_shop_whatsapp_output() {
	echo larisdigital_wc_button_whatsapp_output(
		array(
			'text'			=> larisdigital_get_whatsapp_mod( 'wc_shop_whatsapp_text' ),
			'button_class'	=> 'button-shop-whatsapp',
			'button_pos'	=> 'shop',
			'before'		=> '',
			'after'			=> '',
		)
	);
}

function larisdigital_wc_button_whatsapp_output( $args = array() ) {
	$defaults = apply_filters( 'larisdigital_wc_button_whatsapp_defaults', array(
		'text'			=> esc_html__( 'Chat Seller', 'larisdigital-wp' ),
		'button_class'	=> '',
		'button_pos'	=> 'shop',
		'before'		=> '',
		'after'			=> '',
	) );

	$args = wp_parse_args( $args, $defaults );
	extract( $args );
	if ( ! $text ) {
		$text = esc_html__( 'Chat Seller', 'larisdigital-wp' );
	}

	$output = '';
	global $product;
	if ( empty( $product ) ) {
		$product = wc_get_product( get_the_ID() );
	}
	$product_id = $product->get_ID();
	$product_title = $product->get_title();
	$product_price = $product->get_price();
	$price = wc_price( $product_price );
	$price = strip_tags( $price );
	$link = apply_filters( 'pre_tokopressid_wc_'.$button_pos.'_whatsapp_link', '' );
	if ( empty( $link ) || '#' == $link ) {
		$rotator = larisdigital_get_whatsapp_mod( 'wc_whatsapp_rotator_enable' );
		if ( $rotator ) {
			$link = home_url('/?tp_wa_rotator=1&amp;tp_product_id='.$product_id);
		}
		else {
			$number = larisdigital_get_whatsapp_mod( 'wc_whatsapp_number' );
			if ( ! $number ) {
				$link = '#';
			}
			else {
				$number = larisdigital_whatsapp_number_format( $number );
				$link = 'https://api.whatsapp.com/send?phone='.$number;
				$message = larisdigital_get_whatsapp_mod( 'wc_whatsapp_message' );
				if ( empty( $message ) ) {
					$message = apply_filters( 'larisdigital_whatsapp_message_default', esc_html__( 'Hi %site_name%, I am interested in %product_title%, thank you.', 'larisdigital-wp' ) );
				}
				if ( ! empty( $message ) ) {
					if (strpos($message, '%site_name%') !== false) {
						$message = str_replace( '%site_name%', get_bloginfo('name'), $message );
					}
					if (strpos($message, '%product_title%') !== false) {
						$message = str_replace( '%product_title%', $product_title, $message );
					}
					if (strpos($message, '%product_price%') !== false) {
						$message = str_replace( '%product_price%', $price, $message );
					}
					if (strpos($message, '%product_id%') !== false) {
						$message = str_replace( '%product_id%', $product_id, $message );
					}
					if (strpos($message, '%product_sku%') !== false) {
						$sku = get_post_meta( $product_id, '_sku', true );
						$message = str_replace( '%product_sku%', $sku, $message );
					}
					if (strpos( $message, '%product_url%' ) !== false ) {
						$url = get_permalink( $product_id );
						$message = str_replace( '%product_url%', $url, $message );
					}
					if (strpos( $message, '%product_categories%' ) !== false) {
						$cats_array = array();
						$cats = '';
						$terms = wp_get_post_terms( $product_id, 'product_cat' );
						foreach ($terms as $term) {
							$cats_array[] = $term->name;
						}
						$cats = implode(', ', $cats_array);
						$message = str_replace( '%product_categories%', $cats, $message );
					}
					if (strpos( $message, '%product_tags%' ) !== false) {
						$tags_array = array();
						$tags = '';
						$terms = wp_get_post_terms( $product_id, 'product_tag' );
						foreach ($terms as $term) {
							$tags_array[] = $term->name;
						}
						$tags = implode(', ', $tags_array);
						$message = str_replace( '%product_tags%', $tags, $message );
					}
					$message = html_entity_decode( $message );
					$link .= '&text='.rawurlencode($message);
				}
			}
		}
		$link = apply_filters( 'tokopressid_wc_'.$button_pos.'_whatsapp_link', $link );
	}
	$output .= $before;
	if ( empty( $link ) || '#' == $link ) {
		$output .= '<a rel="nofollow" href="javascript:void(0);"';
	}
	else {
		$output .= '<a rel="nofollow" href="'.$link.'"';
	}
	global $larisdigital_fbpixel_active, $larisdigital_gtag_active;
	$fbevent_disable = larisdigital_get_whatsapp_mod('wc_whatsapp_fbpixel_disable');
	if ( ( $larisdigital_fbpixel_active && ! $fbevent_disable ) || $larisdigital_gtag_active ) {
		$output .= ' class="button '.$button_class.' button-track-event"';
	}
	else {
		$output .= ' class="button '.$button_class.'"';
	}
	if ( $larisdigital_fbpixel_active && ! $fbevent_disable ) {
		$fbevent = larisdigital_get_whatsapp_mod('wc_product_whatsapp_fbpixel');
		if ( ! $fbevent ) {
			$fbevent = 'Lead';
		}
		if ( in_array( $fbevent, array( 'PageView', 'ViewContent', 'AddToCart', 'InitiateCheckout', 'AddPaymentInfo', 'Purchase', 'Lead', 'Search' ) ) ) {
			$fbtrack = 'track';
		}
		else {
			$fbtrack = 'trackCustom';
		}
		$fbparams = array();
		$fbparams['content_name'] = $product_title;
		$fbparams['value'] = number_format((float)$product_price, 2, '.', '');
		$fbparams['currency'] = get_woocommerce_currency();
		$fbparams['source'] = LARISDIGITAL_THEME_SLUG;
		$fbparams['source_action'] = 'button-click';
		$fbparams['source_position'] = 'single-product';
		$fbparams['version'] = LARISDIGITAL_THEME_VERSION;
		$fbparams['domain'] = str_replace( array('https://www.','http://www.','https://','http://'), '', home_url('/') );
		$content_ids_status = larisdigital_fbpixel_woocommerce_content_ids_status();
		extract( $content_ids_status );
		if ( $content_ids_active ) {
			$content_ids = array();
			if ( 'id' == $content_ids_format ) {
				$content_ids[] = strval( $product_id );
			}
			elseif ( 'sku' == $content_ids_format ) {
				$content_sku = $product->get_sku();
				if ( $content_sku ) {
					$content_ids[] = trim( $content_sku );
				}
				else {
					$content_ids[] = strval( $product_id );
				}
			}
			else {
				$content_sku = $product->get_sku();
				if ( $content_sku ) {
					$content_ids[] = trim( $content_sku ).'_'.strval( $product_id );
				}
				else {
					$content_ids[] = 'wc_post_id_'.strval( $product_id );
				}
			}
			$fbparams['content_ids'] = json_encode($content_ids);
			if ( in_array( $product->get_type(), array( 'variable', 'variable-subscription' ) ) ) {
				$fbparams['content_type'] = 'product_group';
			}
			else {
				$fbparams['content_type'] = 'product';
			}
		}
		$output .= ' data-fbevent="'.esc_attr($fbevent).'" data-fbtrack="'.esc_attr($fbtrack).'" data-fbparams=\''.json_encode($fbparams).'\'';
	}
	if ( $larisdigital_gtag_active ) {
		$send_to = larisdigital_get_whatsapp_mod('wc_whatsapp_adwords_send_to_1');
		if ( $send_to ) {
			$gttrack = 'event';
			$gtevent = 'conversion';
			$gtparams = array();
			$gtparams['send_to'] = $send_to;
			$gtparams['value'] = number_format((float)$product_price, 2, '.', '');
			$gtparams['currency'] = get_woocommerce_currency();
			$output .= ' data-gttrack="'.esc_attr($gttrack).'" data-gtevent="'.esc_attr($gtevent).'" data-gtparams=\''.json_encode($gtparams, JSON_UNESCAPED_SLASHES).'\'';
		}
	}
	$output .= '><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg> '.esc_attr($text).'</a>';
	$output .= $after;
	return $output;
}

add_filter( 'larisdigital_wc_product_description_buttons_active', 'larisdigital_wc_product_description_buttons_whatsapp_active' );
function larisdigital_wc_product_description_buttons_whatsapp_active( $active ) {
	if ( 'yes' == larisdigital_get_whatsapp_mod( 'wc_whatsapp_product_desc' ) ) {
		return true;
	}
	return $active;
}

add_action( 'larisdigital_wc_product_description_buttons_before', 'larisdigital_wc_product_description_buttons_whatsapp' );
function larisdigital_wc_product_description_buttons_whatsapp() {
	if ( 'yes' != larisdigital_get_whatsapp_mod( 'wc_whatsapp_product_desc' ) ) {
		return;
	}
	global $larisdigital_wc_product_whatsapp_output;
	$larisdigital_wc_product_whatsapp_output = false;
	add_action( 'woocommerce_after_add_to_cart_button', 'larisdigital_wc_product_whatsapp_output', 5 );
	add_action( 'larisdigital_wc_product_description_buttons_after', 'larisdigital_wc_product_whatsapp_output', 31 );
}

function larisdigital_whatsapp_number_format( $number ) {
	// credits https://gist.github.com/josephilipraja/8341837
	$country_data = array(
		'AD'=>array('name'=>'ANDORRA','code'=>'376'),
		'AE'=>array('name'=>'UNITED ARAB EMIRATES','code'=>'971'),
		'AF'=>array('name'=>'AFGHANISTAN','code'=>'93'),
		'AG'=>array('name'=>'ANTIGUA AND BARBUDA','code'=>'1268'),
		'AI'=>array('name'=>'ANGUILLA','code'=>'1264'),
		'AL'=>array('name'=>'ALBANIA','code'=>'355'),
		'AM'=>array('name'=>'ARMENIA','code'=>'374'),
		'AN'=>array('name'=>'NETHERLANDS ANTILLES','code'=>'599'),
		'AO'=>array('name'=>'ANGOLA','code'=>'244'),
		'AQ'=>array('name'=>'ANTARCTICA','code'=>'672'),
		'AR'=>array('name'=>'ARGENTINA','code'=>'54'),
		'AS'=>array('name'=>'AMERICAN SAMOA','code'=>'1684'),
		'AT'=>array('name'=>'AUSTRIA','code'=>'43'),
		'AU'=>array('name'=>'AUSTRALIA','code'=>'61'),
		'AW'=>array('name'=>'ARUBA','code'=>'297'),
		'AZ'=>array('name'=>'AZERBAIJAN','code'=>'994'),
		'BA'=>array('name'=>'BOSNIA AND HERZEGOVINA','code'=>'387'),
		'BB'=>array('name'=>'BARBADOS','code'=>'1246'),
		'BD'=>array('name'=>'BANGLADESH','code'=>'880'),
		'BE'=>array('name'=>'BELGIUM','code'=>'32'),
		'BF'=>array('name'=>'BURKINA FASO','code'=>'226'),
		'BG'=>array('name'=>'BULGARIA','code'=>'359'),
		'BH'=>array('name'=>'BAHRAIN','code'=>'973'),
		'BI'=>array('name'=>'BURUNDI','code'=>'257'),
		'BJ'=>array('name'=>'BENIN','code'=>'229'),
		'BL'=>array('name'=>'SAINT BARTHELEMY','code'=>'590'),
		'BM'=>array('name'=>'BERMUDA','code'=>'1441'),
		'BN'=>array('name'=>'BRUNEI DARUSSALAM','code'=>'673'),
		'BO'=>array('name'=>'BOLIVIA','code'=>'591'),
		'BR'=>array('name'=>'BRAZIL','code'=>'55'),
		'BS'=>array('name'=>'BAHAMAS','code'=>'1242'),
		'BT'=>array('name'=>'BHUTAN','code'=>'975'),
		'BW'=>array('name'=>'BOTSWANA','code'=>'267'),
		'BY'=>array('name'=>'BELARUS','code'=>'375'),
		'BZ'=>array('name'=>'BELIZE','code'=>'501'),
		'CA'=>array('name'=>'CANADA','code'=>'1'),
		'CC'=>array('name'=>'COCOS (KEELING) ISLANDS','code'=>'61'),
		'CD'=>array('name'=>'CONGO, THE DEMOCRATIC REPUBLIC OF THE','code'=>'243'),
		'CF'=>array('name'=>'CENTRAL AFRICAN REPUBLIC','code'=>'236'),
		'CG'=>array('name'=>'CONGO','code'=>'242'),
		'CH'=>array('name'=>'SWITZERLAND','code'=>'41'),
		'CI'=>array('name'=>'COTE D IVOIRE','code'=>'225'),
		'CK'=>array('name'=>'COOK ISLANDS','code'=>'682'),
		'CL'=>array('name'=>'CHILE','code'=>'56'),
		'CM'=>array('name'=>'CAMEROON','code'=>'237'),
		'CN'=>array('name'=>'CHINA','code'=>'86'),
		'CO'=>array('name'=>'COLOMBIA','code'=>'57'),
		'CR'=>array('name'=>'COSTA RICA','code'=>'506'),
		'CU'=>array('name'=>'CUBA','code'=>'53'),
		'CV'=>array('name'=>'CAPE VERDE','code'=>'238'),
		'CX'=>array('name'=>'CHRISTMAS ISLAND','code'=>'61'),
		'CY'=>array('name'=>'CYPRUS','code'=>'357'),
		'CZ'=>array('name'=>'CZECH REPUBLIC','code'=>'420'),
		'DE'=>array('name'=>'GERMANY','code'=>'49'),
		'DJ'=>array('name'=>'DJIBOUTI','code'=>'253'),
		'DK'=>array('name'=>'DENMARK','code'=>'45'),
		'DM'=>array('name'=>'DOMINICA','code'=>'1767'),
		'DO'=>array('name'=>'DOMINICAN REPUBLIC','code'=>'1809'),
		'DZ'=>array('name'=>'ALGERIA','code'=>'213'),
		'EC'=>array('name'=>'ECUADOR','code'=>'593'),
		'EE'=>array('name'=>'ESTONIA','code'=>'372'),
		'EG'=>array('name'=>'EGYPT','code'=>'20'),
		'ER'=>array('name'=>'ERITREA','code'=>'291'),
		'ES'=>array('name'=>'SPAIN','code'=>'34'),
		'ET'=>array('name'=>'ETHIOPIA','code'=>'251'),
		'FI'=>array('name'=>'FINLAND','code'=>'358'),
		'FJ'=>array('name'=>'FIJI','code'=>'679'),
		'FK'=>array('name'=>'FALKLAND ISLANDS (MALVINAS)','code'=>'500'),
		'FM'=>array('name'=>'MICRONESIA, FEDERATED STATES OF','code'=>'691'),
		'FO'=>array('name'=>'FAROE ISLANDS','code'=>'298'),
		'FR'=>array('name'=>'FRANCE','code'=>'33'),
		'GA'=>array('name'=>'GABON','code'=>'241'),
		'GB'=>array('name'=>'UNITED KINGDOM','code'=>'44'),
		'GD'=>array('name'=>'GRENADA','code'=>'1473'),
		'GE'=>array('name'=>'GEORGIA','code'=>'995'),
		'GH'=>array('name'=>'GHANA','code'=>'233'),
		'GI'=>array('name'=>'GIBRALTAR','code'=>'350'),
		'GL'=>array('name'=>'GREENLAND','code'=>'299'),
		'GM'=>array('name'=>'GAMBIA','code'=>'220'),
		'GN'=>array('name'=>'GUINEA','code'=>'224'),
		'GQ'=>array('name'=>'EQUATORIAL GUINEA','code'=>'240'),
		'GR'=>array('name'=>'GREECE','code'=>'30'),
		'GT'=>array('name'=>'GUATEMALA','code'=>'502'),
		'GU'=>array('name'=>'GUAM','code'=>'1671'),
		'GW'=>array('name'=>'GUINEA-BISSAU','code'=>'245'),
		'GY'=>array('name'=>'GUYANA','code'=>'592'),
		'HK'=>array('name'=>'HONG KONG','code'=>'852'),
		'HN'=>array('name'=>'HONDURAS','code'=>'504'),
		'HR'=>array('name'=>'CROATIA','code'=>'385'),
		'HT'=>array('name'=>'HAITI','code'=>'509'),
		'HU'=>array('name'=>'HUNGARY','code'=>'36'),
		'ID'=>array('name'=>'INDONESIA','code'=>'62'),
		'IE'=>array('name'=>'IRELAND','code'=>'353'),
		'IL'=>array('name'=>'ISRAEL','code'=>'972'),
		'IM'=>array('name'=>'ISLE OF MAN','code'=>'44'),
		'IN'=>array('name'=>'INDIA','code'=>'91'),
		'IQ'=>array('name'=>'IRAQ','code'=>'964'),
		'IR'=>array('name'=>'IRAN, ISLAMIC REPUBLIC OF','code'=>'98'),
		'IS'=>array('name'=>'ICELAND','code'=>'354'),
		'IT'=>array('name'=>'ITALY','code'=>'39'),
		'JM'=>array('name'=>'JAMAICA','code'=>'1876'),
		'JO'=>array('name'=>'JORDAN','code'=>'962'),
		'JP'=>array('name'=>'JAPAN','code'=>'81'),
		'KE'=>array('name'=>'KENYA','code'=>'254'),
		'KG'=>array('name'=>'KYRGYZSTAN','code'=>'996'),
		'KH'=>array('name'=>'CAMBODIA','code'=>'855'),
		'KI'=>array('name'=>'KIRIBATI','code'=>'686'),
		'KM'=>array('name'=>'COMOROS','code'=>'269'),
		'KN'=>array('name'=>'SAINT KITTS AND NEVIS','code'=>'1869'),
		'KP'=>array('name'=>'KOREA DEMOCRATIC PEOPLES REPUBLIC OF','code'=>'850'),
		'KR'=>array('name'=>'KOREA REPUBLIC OF','code'=>'82'),
		'KW'=>array('name'=>'KUWAIT','code'=>'965'),
		'KY'=>array('name'=>'CAYMAN ISLANDS','code'=>'1345'),
		'KZ'=>array('name'=>'KAZAKSTAN','code'=>'7'),
		'LA'=>array('name'=>'LAO PEOPLES DEMOCRATIC REPUBLIC','code'=>'856'),
		'LB'=>array('name'=>'LEBANON','code'=>'961'),
		'LC'=>array('name'=>'SAINT LUCIA','code'=>'1758'),
		'LI'=>array('name'=>'LIECHTENSTEIN','code'=>'423'),
		'LK'=>array('name'=>'SRI LANKA','code'=>'94'),
		'LR'=>array('name'=>'LIBERIA','code'=>'231'),
		'LS'=>array('name'=>'LESOTHO','code'=>'266'),
		'LT'=>array('name'=>'LITHUANIA','code'=>'370'),
		'LU'=>array('name'=>'LUXEMBOURG','code'=>'352'),
		'LV'=>array('name'=>'LATVIA','code'=>'371'),
		'LY'=>array('name'=>'LIBYAN ARAB JAMAHIRIYA','code'=>'218'),
		'MA'=>array('name'=>'MOROCCO','code'=>'212'),
		'MC'=>array('name'=>'MONACO','code'=>'377'),
		'MD'=>array('name'=>'MOLDOVA, REPUBLIC OF','code'=>'373'),
		'ME'=>array('name'=>'MONTENEGRO','code'=>'382'),
		'MF'=>array('name'=>'SAINT MARTIN','code'=>'1599'),
		'MG'=>array('name'=>'MADAGASCAR','code'=>'261'),
		'MH'=>array('name'=>'MARSHALL ISLANDS','code'=>'692'),
		'MK'=>array('name'=>'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF','code'=>'389'),
		'ML'=>array('name'=>'MALI','code'=>'223'),
		'MM'=>array('name'=>'MYANMAR','code'=>'95'),
		'MN'=>array('name'=>'MONGOLIA','code'=>'976'),
		'MO'=>array('name'=>'MACAU','code'=>'853'),
		'MP'=>array('name'=>'NORTHERN MARIANA ISLANDS','code'=>'1670'),
		'MR'=>array('name'=>'MAURITANIA','code'=>'222'),
		'MS'=>array('name'=>'MONTSERRAT','code'=>'1664'),
		'MT'=>array('name'=>'MALTA','code'=>'356'),
		'MU'=>array('name'=>'MAURITIUS','code'=>'230'),
		'MV'=>array('name'=>'MALDIVES','code'=>'960'),
		'MW'=>array('name'=>'MALAWI','code'=>'265'),
		'MX'=>array('name'=>'MEXICO','code'=>'52'),
		'MY'=>array('name'=>'MALAYSIA','code'=>'60'),
		'MZ'=>array('name'=>'MOZAMBIQUE','code'=>'258'),
		'NA'=>array('name'=>'NAMIBIA','code'=>'264'),
		'NC'=>array('name'=>'NEW CALEDONIA','code'=>'687'),
		'NE'=>array('name'=>'NIGER','code'=>'227'),
		'NG'=>array('name'=>'NIGERIA','code'=>'234'),
		'NI'=>array('name'=>'NICARAGUA','code'=>'505'),
		'NL'=>array('name'=>'NETHERLANDS','code'=>'31'),
		'NO'=>array('name'=>'NORWAY','code'=>'47'),
		'NP'=>array('name'=>'NEPAL','code'=>'977'),
		'NR'=>array('name'=>'NAURU','code'=>'674'),
		'NU'=>array('name'=>'NIUE','code'=>'683'),
		'NZ'=>array('name'=>'NEW ZEALAND','code'=>'64'),
		'OM'=>array('name'=>'OMAN','code'=>'968'),
		'PA'=>array('name'=>'PANAMA','code'=>'507'),
		'PE'=>array('name'=>'PERU','code'=>'51'),
		'PF'=>array('name'=>'FRENCH POLYNESIA','code'=>'689'),
		'PG'=>array('name'=>'PAPUA NEW GUINEA','code'=>'675'),
		'PH'=>array('name'=>'PHILIPPINES','code'=>'63'),
		'PK'=>array('name'=>'PAKISTAN','code'=>'92'),
		'PL'=>array('name'=>'POLAND','code'=>'48'),
		'PM'=>array('name'=>'SAINT PIERRE AND MIQUELON','code'=>'508'),
		'PN'=>array('name'=>'PITCAIRN','code'=>'870'),
		'PR'=>array('name'=>'PUERTO RICO','code'=>'1'),
		'PT'=>array('name'=>'PORTUGAL','code'=>'351'),
		'PW'=>array('name'=>'PALAU','code'=>'680'),
		'PY'=>array('name'=>'PARAGUAY','code'=>'595'),
		'QA'=>array('name'=>'QATAR','code'=>'974'),
		'RO'=>array('name'=>'ROMANIA','code'=>'40'),
		'RS'=>array('name'=>'SERBIA','code'=>'381'),
		'RU'=>array('name'=>'RUSSIAN FEDERATION','code'=>'7'),
		'RW'=>array('name'=>'RWANDA','code'=>'250'),
		'SA'=>array('name'=>'SAUDI ARABIA','code'=>'966'),
		'SB'=>array('name'=>'SOLOMON ISLANDS','code'=>'677'),
		'SC'=>array('name'=>'SEYCHELLES','code'=>'248'),
		'SD'=>array('name'=>'SUDAN','code'=>'249'),
		'SE'=>array('name'=>'SWEDEN','code'=>'46'),
		'SG'=>array('name'=>'SINGAPORE','code'=>'65'),
		'SH'=>array('name'=>'SAINT HELENA','code'=>'290'),
		'SI'=>array('name'=>'SLOVENIA','code'=>'386'),
		'SK'=>array('name'=>'SLOVAKIA','code'=>'421'),
		'SL'=>array('name'=>'SIERRA LEONE','code'=>'232'),
		'SM'=>array('name'=>'SAN MARINO','code'=>'378'),
		'SN'=>array('name'=>'SENEGAL','code'=>'221'),
		'SO'=>array('name'=>'SOMALIA','code'=>'252'),
		'SR'=>array('name'=>'SURINAME','code'=>'597'),
		'ST'=>array('name'=>'SAO TOME AND PRINCIPE','code'=>'239'),
		'SV'=>array('name'=>'EL SALVADOR','code'=>'503'),
		'SY'=>array('name'=>'SYRIAN ARAB REPUBLIC','code'=>'963'),
		'SZ'=>array('name'=>'SWAZILAND','code'=>'268'),
		'TC'=>array('name'=>'TURKS AND CAICOS ISLANDS','code'=>'1649'),
		'TD'=>array('name'=>'CHAD','code'=>'235'),
		'TG'=>array('name'=>'TOGO','code'=>'228'),
		'TH'=>array('name'=>'THAILAND','code'=>'66'),
		'TJ'=>array('name'=>'TAJIKISTAN','code'=>'992'),
		'TK'=>array('name'=>'TOKELAU','code'=>'690'),
		'TL'=>array('name'=>'TIMOR-LESTE','code'=>'670'),
		'TM'=>array('name'=>'TURKMENISTAN','code'=>'993'),
		'TN'=>array('name'=>'TUNISIA','code'=>'216'),
		'TO'=>array('name'=>'TONGA','code'=>'676'),
		'TR'=>array('name'=>'TURKEY','code'=>'90'),
		'TT'=>array('name'=>'TRINIDAD AND TOBAGO','code'=>'1868'),
		'TV'=>array('name'=>'TUVALU','code'=>'688'),
		'TW'=>array('name'=>'TAIWAN, PROVINCE OF CHINA','code'=>'886'),
		'TZ'=>array('name'=>'TANZANIA, UNITED REPUBLIC OF','code'=>'255'),
		'UA'=>array('name'=>'UKRAINE','code'=>'380'),
		'UG'=>array('name'=>'UGANDA','code'=>'256'),
		'US'=>array('name'=>'UNITED STATES','code'=>'1'),
		'UY'=>array('name'=>'URUGUAY','code'=>'598'),
		'UZ'=>array('name'=>'UZBEKISTAN','code'=>'998'),
		'VA'=>array('name'=>'HOLY SEE (VATICAN CITY STATE)','code'=>'39'),
		'VC'=>array('name'=>'SAINT VINCENT AND THE GRENADINES','code'=>'1784'),
		'VE'=>array('name'=>'VENEZUELA','code'=>'58'),
		'VG'=>array('name'=>'VIRGIN ISLANDS, BRITISH','code'=>'1284'),
		'VI'=>array('name'=>'VIRGIN ISLANDS, U.S.','code'=>'1340'),
		'VN'=>array('name'=>'VIET NAM','code'=>'84'),
		'VU'=>array('name'=>'VANUATU','code'=>'678'),
		'WF'=>array('name'=>'WALLIS AND FUTUNA','code'=>'681'),
		'WS'=>array('name'=>'SAMOA','code'=>'685'),
		'XK'=>array('name'=>'KOSOVO','code'=>'381'),
		'YE'=>array('name'=>'YEMEN','code'=>'967'),
		'YT'=>array('name'=>'MAYOTTE','code'=>'262'),
		'ZA'=>array('name'=>'SOUTH AFRICA','code'=>'27'),
		'ZM'=>array('name'=>'ZAMBIA','code'=>'260'),
		'ZW'=>array('name'=>'ZIMBABWE','code'=>'263')
	);
	$country = 'ID';
	if ( function_exists( 'wc_get_base_location' ) ) {
		$location = wc_get_base_location();
		if ( isset( $location['country'] ) && $location['country'] ) {
			$country = $location['country'];
		}
	}
	$phonecode = isset( $country_data[$country]['code'] ) ? $country_data[$country]['code'] : '62';
	$number = preg_replace( '/[^0-9]/', '', $number );
	if ( $phonecode == '62' ) {
		$number = preg_replace( '/^8/','08', $number );
	}
	$number = preg_replace( '/^'.$phonecode.'0/', $phonecode, $number) ;
	$number = preg_replace( '/^0/', $phonecode, $number );
	return $number;
}
