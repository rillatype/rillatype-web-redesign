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

add_filter( 'larisdigital_customize_controls', 'larisdigital_wc_customize_controls_button_sticky' );
function larisdigital_wc_customize_controls_button_sticky( $controls ) {

	$controls['larisdigital_wc_section_buttonsticky'] = array(
		'title'				=> esc_html__( 'WC - Sticky Add To Cart Button', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_section_buttonsticky',
		'panel'    			=> 'larisdigital_wc_panel_settings',
		'type'     			=> 'section',
		'priority' 			=> 95,
	);

	$controls['wc_buttonsticky_disable'] = array(
		'label'    			=> esc_html__( 'Disable (MOBILE) Sticky Add To Cart Button', 'larisdigital-wp' ),
		'setting'  			=> 'wc_buttonsticky_disable',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section' 			=> 'larisdigital_wc_section_buttonsticky',
		'type'     			=> 'checkbox',
	);

	$controls['wc_buttonsticky_productatc_disable'] = array(
		'label'    			=> esc_html__( 'Disable Single Product Add To Cart Buttons when Sticky Buttons is displayed', 'larisdigital-wp' ),
		'setting'  			=> 'wc_buttonsticky_productatc_disable',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section' 			=> 'larisdigital_wc_section_buttonsticky',
		'type'     			=> 'checkbox',
	);

	$controls['wc_buttonsticky_breakpoint'] = array(
		'label'    			=> esc_html__( 'Responsive Mobile Breakpoint', 'larisdigital-wp' ),
		'description'		=> esc_html__( 'Sets the breakpoint for mobile sticky add to cart button. Below this breakpoint sticky button will appear (Default: 767px)', 'larisdigital-wp' ),
		'setting'  			=> 'wc_buttonsticky_breakpoint',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section' 			=> 'larisdigital_wc_section_buttonsticky',
		'type'     			=> 'number',
		'choices' 			=> array(
			'placeholder' 	=> '767',
		),
	);

	$controls['wc_buttonsticky_font_size'] = array(
		'label'    			=> esc_html__( 'Font Size', 'larisdigital-wp' ),
		'setting'  			=> 'wc_buttonsticky_font_size',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section' 			=> 'larisdigital_wc_section_buttonsticky',
		'type'     			=> 'slider',
		'choices'  			=> array(
			'min' 			=> 0.5,
			'max' 			=> 2,
			'step' 			=> 0.1,
			'unit' 			=> 'rem',
		),
		'style'    			=> '.tp-wc-button-sticky.woocommerce a.button, .tp-wc-button-sticky.woocommerce button.button, .tp-wc-button-sticky.woocommerce input.button, .tp-wc-button-sticky.woocommerce a.button.alt.single_add_to_cart_button, .tp-wc-button-sticky.woocommerce button.button.alt.single_add_to_cart_button, .tp-wc-button-sticky.woocommerce input.button.alt.single_add_to_cart_button, .tp-wc-button-sticky.woocommerce a.button.single_whatsapp_button { font-size: [value]rem }',
	);

	$controls['larisdigital_wc_heading_buttonsticky_addtocart'] = array(
		'label'				=> esc_html__( 'Sticky "Add to cart" Button', 'larisdigital-wp' ),
		'description' 		=> '<p class="larisdigital-alert larisdigital-alert-with-icon">
								<span class="dashicons dashicons-admin-appearance"></span> <a href="javascript:wp.customize.control( \'larisdigital_wc_heading_product_button\' ).focus();">'.esc_html__( 'CLICK HERE to change background & colors of Sticky "Add to cart" Button from Single Product Settings', 'larisdigital-wp' ).'</a>
								</p>',
		'setting'  			=> 'larisdigital_wc_heading_buttonsticky_addtocart',
		'section'			=> 'larisdigital_wc_section_buttonsticky',
		'type'   			=> 'heading',
		'priority'   		=> 20,
	);

	$controls['wc_buttonsticky_addtocart'] = array(
		'label'    			=> esc_html__( 'Show Sticky "Add to cart" Button', 'larisdigital-wp' ),
		'setting'  			=> 'wc_buttonsticky_addtocart',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section' 			=> 'larisdigital_wc_section_buttonsticky',
		'type'     			=> 'select',
		'default'			=> 'default',
		'choices' 			=> array(
			'default' 		=> esc_html__( 'Default (Single Product Settings)', 'larisdigital-wp' ),
			'yes' 			=> esc_html__( 'Yes / Show', 'larisdigital-wp' ),
			'no' 			=> esc_html__( 'No / Hide', 'larisdigital-wp' ),
		),
		'priority'   		=> 20,
	);

	$controls['wc_buttonsticky_addtocart_text'] = array(
		'label'    			=> esc_html__( 'Sticky "Add to cart" Button Text', 'larisdigital-wp' ),
		'setting'  			=> 'wc_buttonsticky_addtocart_text',
		'setting_type' 		=> 'option_mod',
		'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
		'section' 			=> 'larisdigital_wc_section_buttonsticky',
		'type'     			=> 'text',
		'priority'   		=> 20,
	);

	if ( function_exists( 'larisdigital_get_whatsapp_mod' ) ) {
		$controls['larisdigital_wc_heading_buttonsticky_whatsapp'] = array(
			'label'				=> esc_html__( 'Sticky WhatsApp Button', 'larisdigital-wp' ),
			'description' 		=> '<p class="larisdigital-alert larisdigital-alert-with-icon">
									<span class="dashicons dashicons-admin-appearance"></span> <a href="javascript:wp.customize.control( \'larisdigital_wc_heading_product_whatsapp\' ).focus();">'.esc_html__( 'CLICK HERE to change background & colors of Sticky Whatsapp Button from Single Product Settings', 'larisdigital-wp' ).'</a>
									</p>',
			'setting'  			=> 'larisdigital_wc_heading_buttonsticky_whatsapp',
			'section'			=> 'larisdigital_wc_section_buttonsticky',
			'type'   			=> 'heading',
			'priority'   		=> 30,
		);

		$controls['wc_buttonsticky_whatsapp'] = array(
			'label'    			=> esc_html__( 'Show Sticky WhatsApp Button', 'larisdigital-wp' ),
			'setting'  			=> 'wc_buttonsticky_whatsapp',
			'setting_type' 		=> 'option_mod',
			'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
			'section' 			=> 'larisdigital_wc_section_buttonsticky',
			'type'     			=> 'select',
			'default'			=> 'default',
			'choices' 			=> array(
				'default' 		=> esc_html__( 'Default (Single Product Settings)', 'larisdigital-wp' ),
				'yes' 			=> esc_html__( 'Yes / Show', 'larisdigital-wp' ),
				'no' 			=> esc_html__( 'No / Hide', 'larisdigital-wp' ),
			),
			'priority'   		=> 30,
		);

		$controls['wc_buttonsticky_whatsapp_text'] = array(
			'label'    			=> esc_html__( 'Sticky WhatsApp Button Text', 'larisdigital-wp' ),
			'setting'  			=> 'wc_buttonsticky_whatsapp_text',
			'setting_type' 		=> 'option_mod',
			'setting_db' 		=> LARISDIGITAL_INTEGRATIONS_WC_DB,
			'section' 			=> 'larisdigital_wc_section_buttonsticky',
			'type'     			=> 'text',
			'priority'   		=> 30,
		);
	}

	if ( isset( $controls['larisdigital_wc_heading_product_button'] ) ) {
		$controls['larisdigital_wc_heading_product_button']['description'] = '<p class="larisdigital-alert larisdigital-alert-with-icon">
								<span class="dashicons dashicons-admin-appearance"></span> <a href="javascript:wp.customize.control( \'larisdigital_wc_heading_buttonsticky_addtocart\' ).focus();">'.esc_html__( 'CLICK HERE to show/hide "add to cart" button on Mobile Sticky Buttons area', 'larisdigital-wp' ).'</a>
								</p>';
	}

	if ( isset( $controls['larisdigital_wc_heading_product_whatsapp'] ) ) {
		$controls['larisdigital_wc_heading_product_whatsapp']['description'] = '<p class="larisdigital-alert larisdigital-alert-with-icon">
								<span class="dashicons dashicons-admin-appearance"></span> <a href="javascript:wp.customize.control( \'larisdigital_wc_heading_buttonsticky_whatsapp\' ).focus();">'.esc_html__( 'CLICK HERE to show/hide WhatsApp button on Mobile Sticky Buttons area', 'larisdigital-wp' ).'</a>
								</p>';
	}

	return $controls;
}

add_action( 'wp_footer', 'larisdigital_wc_button_sticky_load_template', 995 );
function larisdigital_wc_button_sticky_load_template() {
	if ( larisdigital_get_integration_wc( 'wc_buttonsticky_disable' ) ) {
		return;
	}
	$template = apply_filters( 'larisdigital_wc_button_sticky_template', 'woocommerce/block-wc-button-sticky' );
	get_template_part( $template );
}

add_filter( 'larisdigital_wc_button_sticky_active', 'larisdigital_wc_button_sticky_whatsapp_active' );
function larisdigital_wc_button_sticky_whatsapp_active( $active ) {
	if ( ! function_exists( 'larisdigital_get_whatsapp_mod' ) ) {
		return $active;
	}
	$button_active = false;
	$button_whatsapp = larisdigital_get_integration_wc( 'wc_buttonsticky_whatsapp' );
	if ( 'yes' == $button_whatsapp ) {
		$button_active = true;
	}
	elseif ( 'no' == $button_whatsapp ) {
		$button_active = false;
	}
	else {
		if ( larisdigital_get_whatsapp_mod( 'wc_product_whatsapp_enable' ) ) {
			$button_active = true;
		}
		else {
			$button_active = false;
		}
	}
	if ( $button_active ) {
		return true;
	}
	return $active;
}

add_action( 'larisdigital_wc_button_sticky_after', 'larisdigital_wc_button_sticky_whatsapp' );
function larisdigital_wc_button_sticky_whatsapp() {
	if ( ! function_exists( 'larisdigital_get_whatsapp_mod' ) ) {
		return;
	}
	$button_active = false;
	$button_whatsapp = larisdigital_get_integration_wc( 'wc_buttonsticky_whatsapp' );
	if ( 'yes' == $button_whatsapp ) {
		$button_active = true;
	}
	elseif ( 'no' == $button_whatsapp ) {
		$button_active = false;
	}
	else {
		if ( larisdigital_get_whatsapp_mod( 'wc_product_whatsapp_enable' ) ) {
			$button_active = true;
		}
		else {
			$button_active = false;
		}
	}
	if ( ! $button_active ) {
		return;
	}
	$button_text = larisdigital_get_integration_wc( 'wc_buttonsticky_whatsapp_text' );
	if ( empty( $button_text ) ) {
		$button_text = larisdigital_get_whatsapp_mod( 'wc_product_whatsapp_text' );
	}
	echo larisdigital_wc_button_whatsapp_output(
		array(
			'text'			=> $button_text,
			'button_class'	=> 'single_whatsapp_button',
			'button_pos'	=> 'product',
			'before'		=> '<div class="col"><div class="woocommerce-product-whatsapp clearfix">',
			'after'			=> '</div></div>',
		)
	);
}

add_filter( 'larisdigital_style', 'larisdigital_wc_button_sticky_style' );
function larisdigital_wc_button_sticky_style( $style ) {
	$breakpoint = intval( larisdigital_get_integration_wc( 'wc_buttonsticky_breakpoint' ) );
	if ( ! $breakpoint ) {
		$breakpoint = 767;
	}
	$style = $style.'@media (min-width: '.$breakpoint.'px) { .tp-wc-button-sticky { display: none !important; } }';
	if ( larisdigital_get_integration_wc( 'wc_buttonsticky_productatc_disable' ) ) {
		$style = $style.'@media (max-width: '.($breakpoint-1).'px) { .woocommerce-product-button-group { display: none !important; } }';
	}
	return $style;
}

add_filter( 'larisdigital_wc_customize_preview_product', 'larisdigital_wc_customize_preview_button_sticky' );
function larisdigital_wc_customize_preview_button_sticky( $section ) {
	$section['larisdigital_wc_section_buttonsticky'] = 'larisdigital_wc_section_buttonsticky';
	return $section;
}
