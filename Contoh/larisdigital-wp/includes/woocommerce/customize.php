<?php
/**
 * WooCommerce Customizer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'woocommerce' ) ) {
	return;
}

add_action( 'customize_register', 'larisdigital_wc_customize_reposition_options', 20 );
function larisdigital_wc_customize_reposition_options( $wp_customize ) {
	$description = '<p class="larisdigital-alert larisdigital-alert-with-icon">
					<span class="dashicons dashicons-admin-tools"></span> <a href="javascript:wp.customize.panel( \'larisdigital_wc_panel_settings\' ).focus();">'.esc_html__( 'CLICK HERE to go to "Theme Settings - WooCommerce" panel.', 'larisdigital-wp' ).'</a>
					</p>';

	$wp_customize->get_panel( 'woocommerce' )->title = esc_html__( 'WooCommerce Settings', 'larisdigital-wp' );
	$wp_customize->get_panel( 'woocommerce' )->description = $description;
	$wp_customize->get_panel( 'woocommerce' )->priority = 17;

	$wp_customize->get_section( 'woocommerce_store_notice' )->description = $description;
	$wp_customize->get_section( 'woocommerce_product_catalog' )->description = $description;
	$wp_customize->get_section( 'woocommerce_product_images' )->description = $description;
	$wp_customize->get_section( 'woocommerce_checkout' )->description = $description;
}

/**
 * WooCommerce Customizer Panel
 */
add_filter( 'larisdigital_customize_controls', 'larisdigital_wc_customize_controls' );
function larisdigital_wc_customize_controls( $controls ) {
	$controls['larisdigital_wc_panel_settings'] = array(
		'title'    => esc_html__( 'Theme Settings - WooCommerce', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_wc_panel_settings',
		'type'     => 'panel',
		'priority' => 15,
	);

	return $controls;
}

/**
 * WooCommerce - General
 */
add_filter( 'larisdigital_customize_controls', 'larisdigital_wc_customize_controls_general' );
function larisdigital_wc_customize_controls_general( $controls ) {

	$controls['larisdigital_navigation_quicknav_minicart'] = array(
		'label'    => esc_html__( 'SHOW Mini Cart', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_navigation_quicknav_minicart',
		'section'  => 'larisdigital_section_navigation',
		'type'     => 'checkbox',
		'default'  => '1',
		'active_callback' => 'larisdigital_callback_navigation_is_active',
		'priority' => 70,
	);

	$controls['larisdigital_navigation_quicknav_minicart_count'] = array(
		'label'    => esc_html__( 'SHOW Mini Cart Count', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_navigation_quicknav_minicart_count',
		'section'  => 'larisdigital_section_navigation',
		'type'     => 'checkbox',
		'default'  => '1',
		'active_callback' => 'larisdigital_callback_navigation_is_active',
		'priority' => 70,
	);

	$controls['larisdigital_navigation_quicknav_minicart_dropdown'] = array(
		'label'    => esc_html__( 'SHOW Mini Cart Dropdown', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_navigation_quicknav_minicart_dropdown',
		'section'  => 'larisdigital_section_navigation',
		'type'     => 'checkbox',
		'default'  => '1',
		'active_callback' => '',
		'priority' => 70,
	);

	$controls['larisdigital_navigation_quicknav_minicart_count_color'] = array(
		'label'    => esc_html__( 'Minicart Count Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_navigation_quicknav_minicart_count_color',
		'section'  => 'larisdigital_section_navigation',
		'type'     => 'color',
		'style'    => '.quicknav-minicart .nav-link .quicknav-minicart-count .badge { background: [value] !important }',
		'active_callback' => 'larisdigital_callback_navigation_is_active',
		'priority' => 77,
	);

	$controls['larisdigital_wc_heading_minicart_button_colors'] = array(
		'label'				=> '',
		'description' 		=> '<p class="larisdigital-alert larisdigital-alert-with-icon">
								<span class="dashicons dashicons-admin-appearance"></span> <a href="javascript:wp.customize.control( \'larisdigital_wc_heading_button\' ).focus();">'.esc_html__( 'CLICK HERE to go to WC General settings to change Minicart Dropdown button colors (WooCommerce default button colors).', 'larisdigital-wp' ).'</a>
								</p>',
		'setting'  			=> 'larisdigital_wc_heading_minicart_button_colors',
		'section'  			=> 'larisdigital_section_navigation',
		'type'   			=> 'heading',
		'active_callback' 	=> 'larisdigital_callback_navigation_is_active',
		'priority' 			=> 77,
	);

	$controls['larisdigital_wc_section_general'] = array(
		'title'    => esc_html__( 'WC - General', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_wc_section_general',
		'panel'    => 'larisdigital_wc_panel_settings',
		'type'     => 'section',
		'priority' => 10,
	);

	$controls['larisdigital_wc_heading_storenotice'] = array(
		'label'				=> esc_html__( 'WC Store Notice', 'larisdigital-wp' ),
		'description' 		=> '<p class="larisdigital-alert larisdigital-alert-with-icon">
								<span class="dashicons dashicons-admin-tools"></span> <a href="javascript:wp.customize.section( \'woocommerce_store_notice\' ).focus();">'.esc_html__( 'CLICK HERE to setup WooCommerce Store Notice', 'larisdigital-wp' ).'</a>
								</p>',
		'setting'  			=> 'larisdigital_wc_heading_storenotice',
		'section'			=> 'larisdigital_wc_section_general',
		'type'   			=> 'heading',
	);

	$controls['larisdigital_wc_heading_variable_price'] = array(
		'label'				=> esc_html__( 'WC Variable Price Display', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_heading_variable_price',
		'section'			=> 'larisdigital_wc_section_general',
		'type'   			=> 'heading',
	);

	$controls['larisdigital_wc_variable_price'] = array(
		'label'				=> esc_html__( 'Show variable product price', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_variable_price',
		'section'			=> 'larisdigital_wc_section_general',
		'type'				=> 'radio',
		'choices'			=> array(
			''				=> esc_html__( 'Default', 'larisdigital-wp' ),
			'low' 			=> esc_html__( 'Lowest variable price', 'larisdigital-wp' ),
		),
	);

	$controls['larisdigital_wc_heading_saleflash'] = array(
		'label'				=> esc_html__( 'WC Sale Flash Badge', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_heading_saleflash',
		'section'			=> 'larisdigital_wc_section_general',
		'type'   			=> 'heading',
	);

	$controls['larisdigital_wc_saleflash_text'] = array(
		'label'				=> esc_html__( 'Sale Flash Badge Text', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_saleflash_text',
		'section'			=> 'larisdigital_wc_section_general',
		'type'   			=> 'text',
	);

	$controls['larisdigital_wc_saleflash_background'] = array(
		'label'				=> esc_html__( 'Background Color', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_saleflash_background',
		'section'			=> 'larisdigital_wc_section_general',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce span.onsale { background-color: [value] } .woocommerce span.onsale:after { border-color: transparent transparent transparent [value] }',
	);

	$controls['larisdigital_wc_saleflash_color'] = array(
		'label'				=> esc_html__( 'Text Color', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_saleflash_color',
		'section'			=> 'larisdigital_wc_section_general',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce span.onsale { color: [value] }',
	);

	$controls['larisdigital_wc_heading_soldout'] = array(
		'label'				=> esc_html__( 'WC Sold Out Badge', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_heading_soldout',
		'section'			=> 'larisdigital_wc_section_general',
		'type'   			=> 'heading',
	);

	$controls['larisdigital_wc_soldout_text'] = array(
		'label'				=> esc_html__( 'Sold Out Badge Text', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_soldout_text',
		'section'			=> 'larisdigital_wc_section_general',
		'type'   			=> 'text',
	);

	$controls['larisdigital_wc_soldout_background'] = array(
		'label'				=> esc_html__( 'Background Color', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_soldout_background',
		'section'			=> 'larisdigital_wc_section_general',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce span.onsale.soldout { background-color: [value] } .woocommerce span.onsale.soldout:after { border-color: transparent transparent transparent [value] }',
	);

	$controls['larisdigital_wc_soldout_color'] = array(
		'label'				=> esc_html__( 'Text Color', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_soldout_color',
		'section'			=> 'larisdigital_wc_section_general',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce span.onsale.soldout { color: [value] }',
	);

	$controls['larisdigital_wc_heading_rating'] = array(
		'label'				=> esc_html__( 'WC Rating', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_heading_rating',
		'section'			=> 'larisdigital_wc_section_general',
		'type'   			=> 'heading',
	);

	$controls['larisdigital_wc_rating_color'] = array(
		'label'				=> esc_html__( 'Rating Color', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_rating_color',
		'section'			=> 'larisdigital_wc_section_general',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce .star-rating, .woocommerce p.stars a, .woocommerce p.stars a:hover { color: [value] }',
	);

	$controls['larisdigital_wc_heading_button'] = array(
		'label'				=> esc_html__( 'WC Button (Default)', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_heading_button',
		'section'			=> 'larisdigital_wc_section_general',
		'type'   			=> 'heading',
	);

	$controls['larisdigital_wc_button_background'] = array(
		'label'				=> esc_html__( 'Background Color', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_button_background',
		'section'			=> 'larisdigital_wc_section_general',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button { background-color: [value] }',
	);

	$controls['larisdigital_wc_button_border'] = array(
		'label'				=> esc_html__( 'Border Color', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_button_border',
		'section'			=> 'larisdigital_wc_section_general',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button { border-color: [value] }',
	);

	$controls['larisdigital_wc_button_color'] = array(
		'label'				=> esc_html__( 'Text Color', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_button_color',
		'section'			=> 'larisdigital_wc_section_general',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button { color: [value] }',
	);

	$controls['larisdigital_wc_button_background_hover'] = array(
		'label'				=> esc_html__( 'Background Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_button_background_hover',
		'section'			=> 'larisdigital_wc_section_general',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover { background-color: [value] }',
	);

	$controls['larisdigital_wc_button_border_hover'] = array(
		'label'				=> esc_html__( 'Border Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_button_border_hover',
		'section'			=> 'larisdigital_wc_section_general',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover { border-color: [value] }',
	);

	$controls['larisdigital_wc_button_color_hover'] = array(
		'label'				=> esc_html__( 'Text Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_button_color_hover',
		'section'			=> 'larisdigital_wc_section_general',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover { color: [value] }',
	);

	$controls['larisdigital_wc_heading_button_alt'] = array(
		'label'				=> esc_html__( 'WC Button Alt (Primary)', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_heading_button_alt',
		'section'			=> 'larisdigital_wc_section_general',
		'type'   			=> 'heading',
	);

	$controls['larisdigital_wc_button_alt_background'] = array(
		'label'				=> esc_html__( 'Background Color', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_button_alt_background',
		'section'			=> 'larisdigital_wc_section_general',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce #respond input#submit.alt.disabled, .woocommerce a.button.alt.disabled, .woocommerce button.button.alt.disabled, .woocommerce input.button.alt.disabled { background-color: [value] }',
	);

	$controls['larisdigital_wc_button_alt_border'] = array(
		'label'				=> esc_html__( 'Border Color', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_button_alt_border',
		'section'			=> 'larisdigital_wc_section_general',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce #respond input#submit.alt.disabled, .woocommerce a.button.alt.disabled, .woocommerce button.button.alt.disabled, .woocommerce input.button.alt.disabled { border-color: [value] }',
	);

	$controls['larisdigital_wc_button_alt_color'] = array(
		'label'				=> esc_html__( 'Text Color', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_button_alt_color',
		'section'			=> 'larisdigital_wc_section_general',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce #respond input#submit.alt.disabled, .woocommerce a.button.alt.disabled, .woocommerce button.button.alt.disabled, .woocommerce input.button.alt.disabled { color: [value] }',
	);

	$controls['larisdigital_wc_button_alt_background_hover'] = array(
		'label'				=> esc_html__( 'Background Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_button_alt_background_hover',
		'section'			=> 'larisdigital_wc_section_general',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, .woocommerce #respond input#submit.alt.disabled:hover, .woocommerce a.button.alt.disabled:hover, .woocommerce button.button.alt.disabled:hover, .woocommerce input.button.alt.disabled:hover { background-color: [value] }',
	);

	$controls['larisdigital_wc_button_alt_border_hover'] = array(
		'label'				=> esc_html__( 'Border Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_button_alt_border_hover',
		'section'			=> 'larisdigital_wc_section_general',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, .woocommerce #respond input#submit.alt.disabled:hover, .woocommerce a.button.alt.disabled:hover, .woocommerce button.button.alt.disabled:hover, .woocommerce input.button.alt.disabled:hover { border-color: [value] }',
	);

	$controls['larisdigital_wc_button_alt_color_hover'] = array(
		'label'				=> esc_html__( 'Text Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_button_alt_color_hover',
		'section'			=> 'larisdigital_wc_section_general',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, .woocommerce #respond input#submit.alt.disabled:hover, .woocommerce a.button.alt.disabled:hover, .woocommerce button.button.alt.disabled:hover, .woocommerce input.button.alt.disabled:hover { color: [value] }',
	);

	return $controls;
}

/**
 * WooCommerce - Shop Page
 */
add_filter( 'larisdigital_customize_controls', 'larisdigital_wc_customize_controls_shop' );
function larisdigital_wc_customize_controls_shop( $controls ) {

	$controls['larisdigital_wc_section_shop'] = array(
		'title'    => esc_html__( 'WC - Shop Page', 'larisdigital-wp' ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-success larisdigital-alert-with-icon">
							<span class="dashicons dashicons-megaphone"></span> '.sprintf( esc_html__( 'Please edit "%s" page from WordPress Dashboard to customize the layout details using "%s" and "%s" metabox', 'larisdigital-wp' ), esc_html__( 'Shop', 'larisdigital-wp' ), esc_html__( 'Page Layout', 'larisdigital-wp' ), esc_html__( 'Site Header', 'larisdigital-wp' ) ).'
							</p>',
		'setting'  => 'larisdigital_wc_section_shop',
		'panel'    => 'larisdigital_wc_panel_settings',
		'type'     => 'section',
		'priority' => 20,
	);

	$controls['larisdigital_wc_heading_shop_site_header'] = array(
		'label'    => esc_html__( 'Site Header', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_wc_heading_shop_site_header',
		'section'  => 'larisdigital_wc_section_shop',
		'type'     => 'heading',
		'active_callback' =>'larisdigital_callback_header_is_active',
	);

	$controls['larisdigital_wc_shop_title4header'] = array(
		'label'    => esc_html__( 'Use shop title for header title', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_wc_shop_title4header',
		'section'  => 'larisdigital_wc_section_shop',
		'type'     => 'checkbox',
		'active_callback' =>'larisdigital_callback_header_is_active',
	);

	$controls['larisdigital_wc_heading_shop_sidebar_layout'] = array(
		'label'    => esc_html__( 'Sidebar Layout', 'larisdigital-wp' ),
		'description' 		=> '<p class="larisdigital-alert larisdigital-alert-with-icon">
								<span class="dashicons dashicons-admin-tools"></span> <a href="javascript:wp.customize.panel( \'widgets\' ).focus();">'.esc_html__( 'CLICK HERE to setup / manage widgets when sidebar is available', 'larisdigital-wp' ).'</a>
								</p>',
		'setting'  => 'larisdigital_wc_heading_shop_sidebar_layout',
		'section'  => 'larisdigital_wc_section_shop',
		'type'     => 'heading',
	);

	$controls['larisdigital_wc_shop_sidebar_layout'] = array(
		'label'    => esc_html__( 'Sidebar Layout', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_wc_shop_sidebar_layout',
		'section'  => 'larisdigital_wc_section_shop',
		'type'     => 'select',
		'choices'  => array(
			'none' => esc_html__( 'No Sidebar', 'larisdigital-wp' ),
			'right' => esc_html__( 'Right Sidebar', 'larisdigital-wp' ),
			'left' => esc_html__( 'Left Sidebar', 'larisdigital-wp' ),
		),
	);

	$controls['larisdigital_wc_shop_sidebar_width'] = array(
		'label'    => esc_html__( 'Sidebar Width', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_wc_shop_sidebar_width',
		'section'  => 'larisdigital_wc_section_shop',
		'type'     => 'select',
		'choices'  => array(
			'' => esc_html__( 'Default', 'larisdigital-wp' ),
			'3' => esc_html__( '3/12 Grid', 'larisdigital-wp' ),
			'4' => esc_html__( '4/12 Grid', 'larisdigital-wp' ),
			'5' => esc_html__( '5/12 Grid', 'larisdigital-wp' ),
			'6' => esc_html__( '6/12 Grid', 'larisdigital-wp' ),
		),
		'active_callback' => 'larisdigital_wc_callback_shop_sidebar_is_active',
	);

	$controls['larisdigital_wc_shop_content_width'] = array(
		'label'    => esc_html__( 'Content Width', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_wc_shop_content_width',
		'section'  => 'larisdigital_wc_section_shop',
		'type'     => 'select',
		'choices'  => array(
			'' => esc_html__( 'Default', 'larisdigital-wp' ),
			'12' => esc_html__( '12/12 Grid', 'larisdigital-wp' ),
			'11' => esc_html__( '11/12 Grid', 'larisdigital-wp' ),
			'10' => esc_html__( '10/12 Grid', 'larisdigital-wp' ),
			'9' => esc_html__( '9/12 Grid', 'larisdigital-wp' ),
			'8' => esc_html__( '8/12 Grid', 'larisdigital-wp' ),
			'7' => esc_html__( '7/12 Grid', 'larisdigital-wp' ),
			'6' => esc_html__( '6/12 Grid', 'larisdigital-wp' ),
		),
		'active_callback' => 'larisdigital_wc_callback_shop_sidebar_is_not_active',
	);

	$controls['larisdigital_wc_heading_shop_layout'] = array(
		'label'    => esc_html__( 'Shop Page Layout', 'larisdigital-wp' ),
		'description' 		=> '<p class="larisdigital-alert larisdigital-alert-with-icon">
								<span class="dashicons dashicons-admin-tools"></span> <a href="javascript:wp.customize.section( \'woocommerce_product_catalog\' ).focus();">'.esc_html__( 'CLICK HERE to setup Shop page display, Category display, and Default product sorting on Product Catalog settings', 'larisdigital-wp' ).'</a>
								</p>',
		'setting'  => 'larisdigital_wc_heading_shop_layout',
		'section'  => 'larisdigital_wc_section_shop',
		'type'     => 'heading',
	);

	$controls['larisdigital_wc_shop_result_count_disable'] = array(
		'label'				=> esc_html__( 'DISABLE result count', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_shop_result_count_disable',
		'section'			=> 'larisdigital_wc_section_shop',
		'type'				=> 'checkbox',
	);

	$controls['larisdigital_wc_shop_catalog_ordering_disable'] = array(
		'label'				=> esc_html__( 'DISABLE catalog ordering', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_shop_catalog_ordering_disable',
		'section'			=> 'larisdigital_wc_section_shop',
		'type'				=> 'checkbox',
	);

	$controls['larisdigital_wc_shop_columns'] = array(
		'label'				=> esc_html__( 'Number of products per row', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_shop_columns',
		'section'			=> 'larisdigital_wc_section_shop',
		'type'				=> 'radio-buttonset',
		'choices'			=> array(
			'6' => '6',
			'5' => '5',
			'4' => '4',
			'3' => '3',
			'2' => '2',
			'1' => '1',
		),
	);

	$controls['larisdigital_wc_shop_columns_mobile'] = array(
		'label'				=> esc_html__( 'Number of products per row (mobile)', 'larisdigital-wp' ),
		'description' 		=> esc_html__( 'For mobile only, when device viewport width <= 480px', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_shop_columns_mobile',
		'section'			=> 'larisdigital_wc_section_shop',
		'type'				=> 'radio-buttonset',
		'choices'			=> array(
			'1' => '1',
			'2' => '2',
		),
		// 'style'				=> array(
		// 	'1'		=> '',
		// 	'2'		=> '@media (max-width: 480px) { .woocommerce ul.products, .woocommerce-page ul.products { margin: 0 -8px; } .woocommerce ul.products li.product, .woocommerce-page ul.products li.product, .woocommerce[class*="columns-"] ul.products li.product, .woocommerce-page[class*="columns-"] ul.products li.product, .woocommerce ul.products[class*="columns-"] li.product, .woocommerce-page ul.products[class*="columns-"] li.product, .woocommerce .cart-collaterals .cross-sells ul.products li, .woocommerce-page .cart-collaterals .cross-sells ul.products li { width: 50%; padding: 0 8px; margin: 0 0 15px; } .woocommerce ul.products li.product .product-detail-box, .woocommerce-page ul.products li.product .product-detail-box { padding: 12px 12px 12px; font-size: 13px; } }',
		// ),
		'active_callback'	=> 'larisdigital_wc_callback_shop_columns_mobile_is_active',
	);

	$controls['larisdigital_wc_shop_per_page'] = array(
		'label'				=> esc_html__( 'Number of products per page', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_shop_per_page',
		'section'			=> 'larisdigital_wc_section_shop',
		'type'				=> 'number',
	);

	$controls['larisdigital_wc_heading_shop_thumbnail'] = array(
		'label'    => esc_html__( 'Shop Page Product Image', 'larisdigital-wp' ),
		'description' 		=> '<p class="larisdigital-alert larisdigital-alert-with-icon">
								<span class="dashicons dashicons-admin-tools"></span> <a href="javascript:wp.customize.section( \'woocommerce_product_images\' ).focus();">'.esc_html__( 'CLICK HERE to setup Thumbnail Width for products in the catalog (shop page)', 'larisdigital-wp' ).'</a>
								</p>',
		'setting'  => 'larisdigital_wc_heading_shop_thumbnail',
		'section'  => 'larisdigital_wc_section_shop',
		'type'     => 'heading',
	);

	$controls['larisdigital_wc_heading_shop_elements'] = array(
		'label'    => esc_html__( 'Shop Page Elements', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_wc_heading_shop_elements',
		'section'  => 'larisdigital_wc_section_shop',
		'type'     => 'heading',
	);

	$controls['larisdigital_wc_shop_saleflash_disable'] = array(
		'label'				=> esc_html__( 'DISABLE product sale flash', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_shop_saleflash_disable',
		'section'			=> 'larisdigital_wc_section_shop',
		'type'				=> 'checkbox',
	);

	$controls['larisdigital_wc_shop_title_disable'] = array(
		'label'				=> esc_html__( 'DISABLE product title', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_shop_title_disable',
		'section'			=> 'larisdigital_wc_section_shop',
		'type'				=> 'checkbox',
	);

	$controls['larisdigital_wc_shop_title_truncate'] = array(
		'label'				=> esc_html__( 'TRUNCATE product title (one line only)', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_shop_title_truncate',
		'section'			=> 'larisdigital_wc_section_shop',
		'type'				=> 'checkbox',
	);

	$controls['larisdigital_wc_shop_price'] = array(
		'label'				=> esc_html__( 'Show product price', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_shop_price',
		'section'			=> 'larisdigital_wc_section_shop',
		'type'				=> 'radio',
		'choices'			=> array(
			''				=> esc_html__( 'Default (After Title)', 'larisdigital-wp' ),
			'right' 		=> esc_html__( 'Right of Product Title', 'larisdigital-wp' ),
			'image' 		=> esc_html__( 'Inside Product Image', 'larisdigital-wp' ),
			'disable' 		=> esc_html__( 'Disable Product Price', 'larisdigital-wp' ),
		),
	);

	$controls['larisdigital_wc_shop_rating_disable'] = array(
		'label'				=> esc_html__( 'DISABLE product rating', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_shop_rating_disable',
		'section'			=> 'larisdigital_wc_section_shop',
		'type'				=> 'checkbox',
	);

	$controls['larisdigital_wc_shop_product_alignment'] = array(
		'label'				=> esc_html__( 'Product Detail Alignment', 'larisdigital-wp' ),
		'setting'			=> 'larisdigital_wc_shop_product_alignment',
		'section'			=> 'larisdigital_wc_section_shop',
		'type'				=> 'radio-iconset',
		'choices'			=> array(
			'left'			=> 'dashicons dashicons-editor-alignleft',
			'center'		=> 'dashicons dashicons-editor-aligncenter',
			'right'			=> 'dashicons dashicons-editor-alignright',
		),
		'style'				=> array(
			'left'			=> '.woocommerce ul.products li.product .product-detail-box, .woocommerce-page ul.products li.product .product-detail-box { text-align: left; }',
			'center'		=> '.woocommerce ul.products li.product .product-detail-box, .woocommerce-page ul.products li.product .product-detail-box { text-align: center; }',
			'right'			=> '.woocommerce ul.products li.product .product-detail-box, .woocommerce-page ul.products li.product .product-detail-box { text-align: right; }',
		),
	);

	$controls['larisdigital_wc_shop_product_box_background'] = array(
		'label'				=> esc_html__( 'Product Box Background', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_shop_product_box_background',
		'section'			=> 'larisdigital_wc_section_shop',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce ul.products li.product .product-inner, .woocommerce-page ul.products li.product .product-inner { background: [value] }',
	);

	$controls['larisdigital_wc_shop_product_box_border'] = array(
		'label'				=> esc_html__( 'Product Box Border', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_shop_product_box_border',
		'section'			=> 'larisdigital_wc_section_shop',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce ul.products li.product .product-inner, .woocommerce-page ul.products li.product .product-inner { border-color: [value] }',
	);

	$controls['larisdigital_wc_shop_product_title_color'] = array(
		'label'				=> esc_html__( 'Product Title Color', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_shop_product_title_color',
		'section'			=> 'larisdigital_wc_section_shop',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce ul.products li.product h2, .woocommerce ul.products li.product h3 { color: [value] }',
	);

	$controls['larisdigital_wc_shop_product_price_color'] = array(
		'label'				=> esc_html__( 'Product Price Color', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_shop_product_price_color',
		'section'			=> 'larisdigital_wc_section_shop',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce ul.products li.product .price, .woocommerce ul.products li.product .tp-shop-price-image .price, .woocommerce-page ul.products li.product .tp-shop-price-image .price, .woocommerce ul.products li.product .tp-shop-price-right .price, .woocommerce-page ul.products li.product .tp-shop-price-right .price { color: [value] }',
	);

	$controls['larisdigital_wc_shop_product_price_bg'] = array(
		'label'				=> esc_html__( 'Product Price Background Color', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_shop_product_price_bg',
		'section'			=> 'larisdigital_wc_section_shop',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce ul.products li.product .tp-shop-price-image .price, .woocommerce-page ul.products li.product .tp-shop-price-image .price, .woocommerce ul.products li.product .tp-shop-price-right .price, .woocommerce-page ul.products li.product .tp-shop-price-right .price {background-color: [value] } .woocommerce ul.products li.product .tp-shop-price-default .price, .woocommerce-page ul.products li.product .tp-shop-price-default .price {background-color: [value]; padding: 0.25rem 0.5rem; border-radius: 2px; }',
	);

	$controls['larisdigital_wc_heading_shop_button'] = array(
		'label'    			=> esc_html__( '"Add to cart" Button', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_heading_shop_button',
		'section'  			=> 'larisdigital_wc_section_shop',
		'type'     			=> 'heading',
		'priority'			=> 20,
	);

	$controls['larisdigital_wc_shop_button_disable'] = array(
		'label'				=> esc_html__( 'DISABLE "add to cart" button', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_shop_button_disable',
		'section'			=> 'larisdigital_wc_section_shop',
		'type'				=> 'checkbox',
		'priority'			=> 20,
	);

	$controls['larisdigital_wc_shop_button_type'] = array(
		'label'				=> esc_html__( 'Button Type', 'larisdigital-wp' ),
		'setting'			=> 'larisdigital_wc_shop_button_type',
		'section'			=> 'larisdigital_wc_section_shop',
		'type'				=> 'radio',
		'choices'			=> array(
			''				=> esc_html__( 'Link To Product Page', 'larisdigital-wp' ),
			'addtocart'		=> esc_html__( 'Click To AddToCart', 'larisdigital-wp' ),
		),
		'active_callback'	=> 'larisdigital_wc_callback_shop_button_is_active',
		'priority'			=> 20,
	);

	$controls['larisdigital_wc_shop_button_style'] = array(
		'label'				=> esc_html__( 'Button Style', 'larisdigital-wp' ),
		'setting'			=> 'larisdigital_wc_shop_button_style',
		'section'			=> 'larisdigital_wc_section_shop',
		'type'				=> 'radio',
		'choices'			=> array(
			''				=> esc_html__( 'Inline', 'larisdigital-wp' ),
			'fullwidth'		=> esc_html__( 'Full Width', 'larisdigital-wp' ),
		),
		'style'				=> array(
			''				=> '',
			'fullwidth'		=> '.woocommerce ul.products li.product .button-shop-addtocart { display: block; }',
		),
		'active_callback'	=> 'larisdigital_wc_callback_shop_button_is_active',
		'priority'			=> 20,
	);

	$controls['larisdigital_wc_shop_button_text_simple'] = array(
		'label'				=> esc_html__( 'Button Text: Simple Product', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_shop_button_text_simple',
		'section'			=> 'larisdigital_wc_section_shop',
		'type'				=> 'text',
		'active_callback'	=> 'larisdigital_wc_callback_shop_button_is_addtocart',
		'priority'			=> 20,
	);

	$controls['larisdigital_wc_shop_button_text_variable'] = array(
		'label'				=> esc_html__( 'Button Text: Variable Product', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_shop_button_text_variable',
		'section'			=> 'larisdigital_wc_section_shop',
		'type'				=> 'text',
		'active_callback'	=> 'larisdigital_wc_callback_shop_button_is_addtocart',
		'priority'			=> 20,
	);

	$controls['larisdigital_wc_shop_button_text_outofstock'] = array(
		'label'				=> esc_html__( 'Button Text: OutOfStock Product', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_shop_button_text_outofstock',
		'section'			=> 'larisdigital_wc_section_shop',
		'type'				=> 'text',
		'active_callback'	=> 'larisdigital_wc_callback_shop_button_is_addtocart',
		'priority'			=> 20,
	);

	$controls['larisdigital_wc_shop_button_text_detail'] = array(
		'label'				=> esc_html__( 'Button Text: Detail', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_shop_button_text_detail',
		'section'			=> 'larisdigital_wc_section_shop',
		'type'				=> 'text',
		'active_callback'	=> 'larisdigital_wc_callback_shop_button_is_detail',
		'priority'			=> 20,
	);

	$controls['larisdigital_wc_shop_button_font_size'] = array(
		'label'    			=> esc_html__( 'Font Size', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_shop_button_font_size',
		'section'			=> 'larisdigital_wc_section_shop',
		'type'     			=> 'slider',
		'choices'  			=> array(
			'min' 			=> 0.5,
			'max' 			=> 2,
			'step' 			=> 0.1,
			'unit' 			=> 'rem',
		),
		'style'    			=> '.woocommerce ul.products li.product .button-shop-addtocart { font-size: [value]rem }',
		'active_callback'	=> 'larisdigital_wc_callback_shop_button_is_active',
		'priority'			=> 20,
	);

	$controls['larisdigital_wc_shop_button_background'] = array(
		'label'				=> esc_html__( 'Background Color', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_shop_button_background',
		'section'			=> 'larisdigital_wc_section_shop',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce ul.products li.product .button-shop-addtocart { background-color: [value] }',
		'active_callback'	=> 'larisdigital_wc_callback_shop_button_is_active',
		'priority'			=> 20,
	);

	$controls['larisdigital_wc_shop_button_border'] = array(
		'label'				=> esc_html__( 'Border Color', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_shop_button_border',
		'section'			=> 'larisdigital_wc_section_shop',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce ul.products li.product .button-shop-addtocart { border-color: [value] }',
		'active_callback'	=> 'larisdigital_wc_callback_shop_button_is_active',
		'priority'			=> 20,
	);

	$controls['larisdigital_wc_shop_button_color'] = array(
		'label'				=> esc_html__( 'Text Color', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_shop_button_color',
		'section'			=> 'larisdigital_wc_section_shop',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce ul.products li.product .button-shop-addtocart { color: [value] }',
		'active_callback'	=> 'larisdigital_wc_callback_shop_button_is_active',
		'priority'			=> 20,
	);

	$controls['larisdigital_wc_shop_button_background_hover'] = array(
		'label'				=> esc_html__( 'Background Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_shop_button_background_hover',
		'section'			=> 'larisdigital_wc_section_shop',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce ul.products li.product .button-shop-addtocart:hover { background-color: [value] }',
		'active_callback'	=> 'larisdigital_wc_callback_shop_button_is_active',
		'priority'			=> 20,
	);

	$controls['larisdigital_wc_shop_button_border_hover'] = array(
		'label'				=> esc_html__( 'Border Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_shop_button_border_hover',
		'section'			=> 'larisdigital_wc_section_shop',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce ul.products li.product .button-shop-addtocart:hover { border-color: [value] }',
		'active_callback'	=> 'larisdigital_wc_callback_shop_button_is_active',
		'priority'			=> 20,
	);

	$controls['larisdigital_wc_shop_button_color_hover'] = array(
		'label'				=> esc_html__( 'Text Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_shop_button_color_hover',
		'section'			=> 'larisdigital_wc_section_shop',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce ul.products li.product .button-shop-addtocart:hover { color: [value] }',
		'active_callback'	=> 'larisdigital_wc_callback_shop_button_is_active',
		'priority'			=> 20,
	);

	$controls['larisdigital_wc_heading_shop_pagination'] = array(
		'label'				=> esc_html__( 'Pagination Style', 'larisdigital-wp' ),
		'description'		=> '<p class="larisdigital-alert larisdigital-alert-with-icon"><span class="dashicons dashicons-admin-appearance"></span> <a href="javascript:wp.customize.control( \'larisdigital_heading_pagination\' ).focus();">' . sprintf( esc_html__( 'CLICK HERE to setup %s', 'larisdigital-wp' ), esc_html__( 'Pagination Style', 'larisdigital-wp' ) ) . '</a></p>',
		'setting'			=> 'larisdigital_wc_heading_shop_pagination',
		'section'			=> 'larisdigital_wc_section_shop',
		'type'				=> 'heading',
		'priority'			=> 99,
	);

	return $controls;
}

/**
 * WooCommerce - Single Product
 */
add_filter( 'larisdigital_customize_controls', 'larisdigital_wc_customize_controls_product' );
function larisdigital_wc_customize_controls_product( $controls ) {

	$controls['larisdigital_wc_section_product'] = array(
		'title'    => esc_html__( 'WC - Single Product', 'larisdigital-wp' ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-success larisdigital-alert-with-icon">
							<span class="dashicons dashicons-megaphone"></span>'.sprintf( esc_html__( 'These settings are applied on All %s', 'larisdigital-wp' ), esc_html__( 'Single Product', 'larisdigital-wp' ) ).
						'</p>',
		'setting'  => 'larisdigital_wc_section_product',
		'panel'    => 'larisdigital_wc_panel_settings',
		'type'     => 'section',
		'priority' => 30,
	);

	$controls['larisdigital_wc_heading_product_site_header'] = array(
		'label'    => esc_html__( 'Site Header', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_wc_heading_product_site_header',
		'section'  => 'larisdigital_wc_section_product',
		'type'     => 'heading',
		'active_callback' =>'larisdigital_callback_header_is_active',
	);

	$controls['larisdigital_wc_product_header_hide'] = array(
		'label'    => esc_html__( 'HIDE Site Header on All Single Products', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_wc_product_header_hide',
		'section'  => 'larisdigital_wc_section_product',
		'type'     => 'checkbox',
		'active_callback' =>'larisdigital_callback_header_is_active',
	);

	$controls['larisdigital_wc_product_title4header'] = array(
		'label'    => esc_html__( 'Use product title for header title', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_wc_product_title4header',
		'section'  => 'larisdigital_wc_section_product',
		'type'     => 'checkbox',
		'active_callback' =>'larisdigital_wc_callback_header_product_is_active',
	);

	$controls['larisdigital_wc_heading_product_sidebar_layout'] = array(
		'label'    => esc_html__( 'Sidebar Layout', 'larisdigital-wp' ),
		'description' 		=> '<p class="larisdigital-alert larisdigital-alert-with-icon">
								<span class="dashicons dashicons-admin-tools"></span> <a href="javascript:wp.customize.panel( \'widgets\' ).focus();">'.esc_html__( 'CLICK HERE to setup / manage widgets when sidebar is available', 'larisdigital-wp' ).'</a>
								</p>',
		'setting'  => 'larisdigital_wc_heading_product_sidebar_layout',
		'section'  => 'larisdigital_wc_section_product',
		'type'     => 'heading',
	);

	$controls['larisdigital_wc_product_sidebar_layout'] = array(
		'label'    => esc_html__( 'Sidebar Layout', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_wc_product_sidebar_layout',
		'section'  => 'larisdigital_wc_section_product',
		'type'     => 'select',
		'choices'  => array(
			'none' => esc_html__( 'No Sidebar', 'larisdigital-wp' ),
			'right' => esc_html__( 'Right Sidebar', 'larisdigital-wp' ),
			'left' => esc_html__( 'Left Sidebar', 'larisdigital-wp' ),
		),
	);

	$controls['larisdigital_wc_product_sidebar_width'] = array(
		'label'    => esc_html__( 'Sidebar Width', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_wc_product_sidebar_width',
		'section'  => 'larisdigital_wc_section_product',
		'type'     => 'select',
		'choices'  => array(
			'' => esc_html__( 'Default', 'larisdigital-wp' ),
			'3' => esc_html__( '3/12 Grid', 'larisdigital-wp' ),
			'4' => esc_html__( '4/12 Grid', 'larisdigital-wp' ),
			'5' => esc_html__( '5/12 Grid', 'larisdigital-wp' ),
			'6' => esc_html__( '6/12 Grid', 'larisdigital-wp' ),
		),
		'active_callback' => 'larisdigital_wc_callback_product_sidebar_is_active',
	);

	$controls['larisdigital_wc_product_content_width'] = array(
		'label'    => esc_html__( 'Content Width', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_wc_product_content_width',
		'section'  => 'larisdigital_wc_section_product',
		'type'     => 'select',
		'choices'  => array(
			'' => esc_html__( 'Default', 'larisdigital-wp' ),
			'12' => esc_html__( '12/12 Grid', 'larisdigital-wp' ),
			'11' => esc_html__( '11/12 Grid', 'larisdigital-wp' ),
			'10' => esc_html__( '10/12 Grid', 'larisdigital-wp' ),
			'9' => esc_html__( '9/12 Grid', 'larisdigital-wp' ),
			'8' => esc_html__( '8/12 Grid', 'larisdigital-wp' ),
			'7' => esc_html__( '7/12 Grid', 'larisdigital-wp' ),
			'6' => esc_html__( '6/12 Grid', 'larisdigital-wp' ),
		),
		'active_callback' => 'larisdigital_wc_callback_product_sidebar_is_not_active',
	);

	$controls['larisdigital_wc_heading_product_layout'] = array(
		'label'    => esc_html__( 'Single Product Layout', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_wc_heading_product_layout',
		'section'  => 'larisdigital_wc_section_product',
		'type'     => 'heading',
	);

	$controls['larisdigital_wc_product_layout'] = array(
		'label'				=> esc_html__( 'Single Product Layout', 'larisdigital-wp' ),
		'setting'			=> 'larisdigital_wc_product_layout',
		'section'			=> 'larisdigital_wc_section_product',
		'type'				=> 'radio',
		'choices'			=> array(
			''				=> esc_html__( 'Image (Left) + Summary (Right)', 'larisdigital-wp' ),
			'image-right'	=> esc_html__( 'Summary (Left) + Image (Right)', 'larisdigital-wp' ),
			'image-top'		=> esc_html__( 'One Column', 'larisdigital-wp' ),
		),
		'style'				=> array(
			''				=> '',
			'image-right'	=> '@media (min-width: 769px) { .woocommerce #content div.product div.single-product-image-wrap, .woocommerce div.product div.single-product-image-wrap, .woocommerce-page #content div.product div.single-product-image-wrap, .woocommerce-page div.product div.single-product-image-wrap { float: right; } .woocommerce #content div.product div.summary, .woocommerce div.product div.summary, .woocommerce-page #content div.product div.summary, .woocommerce-page div.product div.summary { float: left } } ',
			'image-top'		=> '@media (min-width: 769px) { .woocommerce #content div.product div.single-product-image-wrap, .woocommerce div.product div.single-product-image-wrap, .woocommerce-page #content div.product div.single-product-image-wrap, .woocommerce-page div.product div.single-product-image-wrap { float: none; margin-left: auto; margin-right: auto; } .woocommerce #content div.product div.summary, .woocommerce div.product div.summary, .woocommerce-page #content div.product div.summary, .woocommerce-page div.product div.summary { float: none; margin-left: auto; margin-right: auto; clear: both; } } ',
		),
	);

	$controls['larisdigital_wc_product_layout_image'] = array(
		'label'    			=> esc_html__( 'Single Product Image Width', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_product_layout_image',
		'section'			=> 'larisdigital_wc_section_product',
		'type'     			=> 'slider',
		'choices'  			=> array(
			'min' 			=> 25,
			'max' 			=> 100,
			'step' 			=> 1,
			'unit' 			=> '%',
		),
		'style'    			=> '@media (min-width: 769px) { .woocommerce #content div.product div.single-product-image-wrap, .woocommerce div.product div.single-product-image-wrap, .woocommerce-page #content div.product div.single-product-image-wrap, .woocommerce-page div.product div.single-product-image-wrap { width: [value]%; } } ',
	);

	$controls['larisdigital_wc_product_layout_summary'] = array(
		'label'    			=> esc_html__( 'Single Product Image Summary', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_product_layout_summary',
		'section'			=> 'larisdigital_wc_section_product',
		'type'     			=> 'slider',
		'choices'  			=> array(
			'min' 			=> 25,
			'max' 			=> 100,
			'step' 			=> 1,
			'unit' 			=> '%',
		),
		'style'    			=> '@media (min-width: 769px) { .woocommerce #content div.product div.summary, .woocommerce div.product div.summary, .woocommerce-page #content div.product div.summary, .woocommerce-page div.product div.summary { width: [value]%; } } ',
	);

	$controls['larisdigital_wc_heading_product_elements'] = array(
		'label'    => esc_html__( 'Single Product Elements', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_wc_heading_product_elements',
		'section'  => 'larisdigital_wc_section_product',
		'type'     => 'heading',
	);

	$controls['larisdigital_wc_product_saleflash_disable'] = array(
		'label'				=> esc_html__( 'DISABLE product sale flash', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_product_saleflash_disable',
		'section'			=> 'larisdigital_wc_section_product',
		'type'				=> 'checkbox',
	);

	$controls['larisdigital_wc_product_rating_disable'] = array(
		'label'				=> esc_html__( 'DISABLE product rating', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_product_rating_disable',
		'section'			=> 'larisdigital_wc_section_product',
		'type'				=> 'checkbox',
	);

	$controls['larisdigital_wc_product_price_disable'] = array(
		'label'				=> esc_html__( 'DISABLE product price', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_product_price_disable',
		'section'			=> 'larisdigital_wc_section_product',
		'type'				=> 'checkbox',
	);

	$controls['larisdigital_wc_product_excerpt_disable'] = array(
		'label'				=> esc_html__( 'DISABLE product short description', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_product_excerpt_disable',
		'section'			=> 'larisdigital_wc_section_product',
		'type'				=> 'checkbox',
	);

	// $controls['larisdigital_wc_product_meta_disable'] = array(
	// 	'label'				=> esc_html__( 'DISABLE product meta (sku, category, tag)', 'larisdigital-wp' ),
	// 	'setting'  			=> 'larisdigital_wc_product_meta_disable',
	// 	'section'			=> 'larisdigital_wc_section_product',
	// 	'type'				=> 'checkbox',
	// );

	$controls['larisdigital_wc_product_item_details_disable'] = array(
		'label'				=> esc_html__( 'DISABLE product item details (product information)', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_product_item_details_disable',
		'section'			=> 'larisdigital_wc_section_product',
		'type'				=> 'checkbox',
	);

	$controls['larisdigital_wc_product_item_details_title'] = array(
		'label'				=> esc_html__( 'Product Item Details title', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_product_item_details_title',
		'section'			=> 'larisdigital_wc_section_product',
		'type'				=> 'text',
	);

	$controls['larisdigital_wc_product_title_color'] = array(
		'label'				=> esc_html__( 'Product Title Color', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_product_title_color',
		'section'			=> 'larisdigital_wc_section_product',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce div.product .product_title { color: [value] }',
	);

	$controls['larisdigital_wc_product_price_color'] = array(
		'label'				=> esc_html__( 'Product Price Color', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_product_price_color',
		'section'			=> 'larisdigital_wc_section_product',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce div.product p.price, .woocommerce div.product span.price { color: [value] }',
	);

	$controls['larisdigital_wc_heading_product_image'] = array(
		'label'   	 		=> esc_html__( 'Single Product Image', 'larisdigital-wp' ),
		'description' 		=> '<p class="larisdigital-alert larisdigital-alert-with-icon">
								<span class="dashicons dashicons-admin-tools"></span> <a href="javascript:wp.customize.section( \'woocommerce_product_images\' ).focus();">'.esc_html__( 'CLICK HERE to setup Main Image Width for products in the single product page', 'larisdigital-wp' ).'</a>
								</p>',
		'setting'  			=> 'larisdigital_wc_heading_product_image',
		'section'  			=> 'larisdigital_wc_section_product',
		'type'     			=> 'heading',
	);

	$controls['larisdigital_wc_product_image_style'] = array(
		'label'    => esc_html__( 'Gallery Image Style', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_wc_product_image_style',
		'section'  => 'larisdigital_wc_section_product',
		'type'     => 'select',
		'choices'  => array(
			'' => esc_html__( 'Default', 'larisdigital-wp' ),
			'full' => esc_html__( 'Full Images (Landing Page Style)', 'larisdigital-wp' ),
		),
	);

	$controls['larisdigital_wc_product_gallery_zoom_disable'] = array(
		'label'				=> esc_html__( 'DISABLE product gallery zoom', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_product_gallery_zoom_disable',
		'section'			=> 'larisdigital_wc_section_product',
		'type'				=> 'checkbox',
		'transport'         => 'postMessage',
		'active_callback' 	=> 'larisdigital_wc_callback_product_image_style_is_not_active',
	);

	$controls['larisdigital_wc_product_gallery_lightbox_disable'] = array(
		'label'				=> esc_html__( 'DISABLE product gallery lightbox', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_product_gallery_lightbox_disable',
		'section'			=> 'larisdigital_wc_section_product',
		'type'				=> 'checkbox',
		'transport'         => 'postMessage',
	);

	$controls['larisdigital_wc_product_gallery_slider_disable'] = array(
		'label'				=> esc_html__( 'DISABLE product gallery slider', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_product_gallery_slider_disable',
		'section'			=> 'larisdigital_wc_section_product',
		'type'				=> 'checkbox',
		'transport'         => 'postMessage',
		'active_callback' 	=> 'larisdigital_wc_callback_product_image_style_is_not_active',
	);

	$controls['larisdigital_wc_heading_product_image_warning'] = array(
		'description' 		=> '<p class="larisdigital-alert larisdigital-alert-danger larisdigital-alert-with-icon">
								<span class="dashicons dashicons-warning"></span> <a href="javascript:wp.customize.section( \'woocommerce_product_images\' ).focus();">'.esc_html__( 'IMPORTANT: Live preview does not work for these options above. Please publish your changes and refresh to see the result', 'larisdigital-wp' ).'</a>
								</p>',
		'setting'  			=> 'larisdigital_wc_heading_product_image_warning',
		'section'  			=> 'larisdigital_wc_section_product',
		'type'     			=> 'heading',
	);

	$controls['larisdigital_wc_heading_product_button'] = array(
		'label'				=> esc_html__( '"Add to cart" Button', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_heading_product_button',
		'section'			=> 'larisdigital_wc_section_product',
		'type'   			=> 'heading',
		'priority'   		=> 20,
	);

	$controls['larisdigital_wc_product_button_disable'] = array(
		'label'				=> esc_html__( 'DISABLE "add to cart" button', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_product_button_disable',
		'section'			=> 'larisdigital_wc_section_product',
		'type'				=> 'checkbox',
		'priority'   		=> 20,
	);

	$controls['larisdigital_wc_product_quantity_disable'] = array(
		'label'				=> esc_html__( 'DISABLE quantity input box', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_product_quantity_disable',
		'section'			=> 'larisdigital_wc_section_product',
		'type'				=> 'checkbox',
		'style'    			=> array( 
			'on'   			=> '.woocommerce div.product form.cart .quantity { display:none !important; }',
			'off'  			=> '',
		),
		'active_callback'	=> 'larisdigital_wc_callback_product_button_is_active',
		'priority'   		=> 20,
	);

	$controls['larisdigital_wc_product_button_style'] = array(
		'label'				=> esc_html__( 'Button Style', 'larisdigital-wp' ),
		'setting'			=> 'larisdigital_wc_product_button_style',
		'section'			=> 'larisdigital_wc_section_product',
		'type'				=> 'radio',
		'choices'			=> array(
			''				=> esc_html__( 'Inline', 'larisdigital-wp' ),
			'fullwidth'		=> esc_html__( 'Full Width', 'larisdigital-wp' ),
		),
		'style'				=> array(
			''				=> '',
			'fullwidth'		=> '.woocommerce a.button.alt.single_add_to_cart_button, .woocommerce button.button.alt.single_add_to_cart_button, .woocommerce input.button.alt.single_add_to_cart_button, .woocommerce-product-button { clear: both; display:block; width: 100%; } .woocommerce-product-button { padding: 0; }',
		),
		'active_callback'	=> 'larisdigital_wc_callback_product_button_is_active',
		'priority'   		=> 20,
	);

	$controls['larisdigital_wc_product_button_text'] = array(
		'label'				=> esc_html__( 'Button Text', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_product_button_text',
		'section'			=> 'larisdigital_wc_section_product',
		'type'				=> 'text',
		'active_callback'	=> 'larisdigital_wc_callback_product_button_is_active',
		'priority'   		=> 20,
	);

	$controls['larisdigital_wc_product_button_font_size'] = array(
		'label'    			=> esc_html__( 'Font Size', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_product_button_font_size',
		'section'			=> 'larisdigital_wc_section_product',
		'type'     			=> 'slider',
		'choices'  			=> array(
			'min' 			=> 0.5,
			'max' 			=> 2,
			'step' 			=> 0.1,
			'unit' 			=> 'rem',
		),
		'style'    			=> '.woocommerce a.button.alt.single_add_to_cart_button, .woocommerce button.button.alt.single_add_to_cart_button, .woocommerce input.button.alt.single_add_to_cart_button, .woocommerce div.product form.cart div.quantity .qty { font-size: [value]rem }',
		'active_callback'	=> 'larisdigital_wc_callback_product_button_is_active',
		'priority'   		=> 20,
	);

	$controls['larisdigital_wc_product_button_background'] = array(
		'label'				=> esc_html__( 'Background Color', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_product_button_background',
		'section'			=> 'larisdigital_wc_section_product',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce a.button.alt.single_add_to_cart_button, .woocommerce button.button.alt.single_add_to_cart_button, .woocommerce input.button.alt.single_add_to_cart_button { background-color: [value] }',
		'active_callback'	=> 'larisdigital_wc_callback_product_button_is_active',
		'priority'   		=> 20,
	);

	$controls['larisdigital_wc_product_button_border'] = array(
		'label'				=> esc_html__( 'Border Color', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_product_button_border',
		'section'			=> 'larisdigital_wc_section_product',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce a.button.alt.single_add_to_cart_button, .woocommerce button.button.alt.single_add_to_cart_button, .woocommerce input.button.alt.single_add_to_cart_button { border-color: [value] }',
		'active_callback'	=> 'larisdigital_wc_callback_product_button_is_active',
		'priority'   		=> 20,
	);

	$controls['larisdigital_wc_product_button_color'] = array(
		'label'				=> esc_html__( 'Text Color', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_product_button_color',
		'section'			=> 'larisdigital_wc_section_product',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce a.button.alt.single_add_to_cart_button, .woocommerce button.button.alt.single_add_to_cart_button, .woocommerce input.button.alt.single_add_to_cart_button { color: [value] }',
		'active_callback'	=> 'larisdigital_wc_callback_product_button_is_active',
		'priority'   		=> 20,
	);

	$controls['larisdigital_wc_product_button_background_hover'] = array(
		'label'				=> esc_html__( 'Background Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_product_button_background_hover',
		'section'			=> 'larisdigital_wc_section_product',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce a.button.alt.single_add_to_cart_button:hover, .woocommerce button.button.alt.single_add_to_cart_button:hover, .woocommerce input.button.alt.single_add_to_cart_button:hover { background-color: [value] }',
		'active_callback'	=> 'larisdigital_wc_callback_product_button_is_active',
		'priority'   		=> 20,
	);

	$controls['larisdigital_wc_product_button_border_hover'] = array(
		'label'				=> esc_html__( 'Border Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_product_button_border_hover',
		'section'			=> 'larisdigital_wc_section_product',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce a.button.alt.single_add_to_cart_button:hover, .woocommerce button.button.alt.single_add_to_cart_button:hover, .woocommerce input.button.alt.single_add_to_cart_button:hover { border-color: [value] }',
		'active_callback'	=> 'larisdigital_wc_callback_product_button_is_active',
		'priority'   		=> 20,
	);

	$controls['larisdigital_wc_product_button_color_hover'] = array(
		'label'				=> esc_html__( 'Text Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_product_button_color_hover',
		'section'			=> 'larisdigital_wc_section_product',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce a.button.alt.single_add_to_cart_button:hover, .woocommerce button.button.alt.single_add_to_cart_button:hover, .woocommerce input.button.alt.single_add_to_cart_button:hover { color: [value] }',
		'active_callback'	=> 'larisdigital_wc_callback_product_button_is_active',
		'priority'   		=> 20,
	);

	$controls['larisdigital_wc_heading_product_share'] = array(
		'label'    			=> esc_html__( 'Social Share', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_heading_product_share',
		'section'			=> 'larisdigital_wc_section_product',
		'type'     			=> 'heading',
	);

	$controls['larisdigital_wc_product_share'] = array(
		'label'    			=> esc_html__( 'Show social share after product meta', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_product_share',
		'section'			=> 'larisdigital_wc_section_product',
		'type'     			=> 'checkbox',
	);

	$controls['larisdigital_wc_product_share_items'] = array(
		'label'    			=> esc_html__( 'Social Share Items', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_product_share_items',
		'section'			=> 'larisdigital_wc_section_product',
		'type'     			=> 'sortable',
		'choices'  			=> array(
			'facebook' 		=> esc_html__( 'Facebook', 'larisdigital-wp' ),
			'twitter' 		=> esc_html__( 'Twitter', 'larisdigital-wp' ),
			// 'google-plus' 	=> esc_html__( 'Google Plus', 'larisdigital-wp' ),
			'linkedin' 		=> esc_html__( 'Linkedin', 'larisdigital-wp' ),
			'pinterest' 	=> esc_html__( 'Pinterest', 'larisdigital-wp' ),
			'whatsapp' 		=> esc_html__( 'WhatsApp', 'larisdigital-wp' ),
			'telegram' 		=> esc_html__( 'Telegram', 'larisdigital-wp' ),
		),
		'active_callback' 	=> 'larisdigital_wc_callback_product_share_is_active',
	);

	$controls['larisdigital_wc_heading_product_tabs'] = array(
		'label'    			=> esc_html__( 'Product Tabs', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_heading_product_tabs',
		'section'  			=> 'larisdigital_wc_section_product',
		'type'     			=> 'heading',
		'priority'   		=> 30,
	);

	$controls['larisdigital_wc_product_tab_description_title'] = array(
		'label'				=> esc_html__( 'Product description tab title', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_product_tab_description_title',
		'section'			=> 'larisdigital_wc_section_product',
		'type'				=> 'text',
		'priority'   		=> 30,
	);

	$controls['larisdigital_wc_product_tab_description_disable'] = array(
		'label'				=> esc_html__( 'DISABLE product description tab', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_product_tab_description_disable',
		'section'			=> 'larisdigital_wc_section_product',
		'type'				=> 'checkbox',
		'priority'   		=> 30,
	);

	$controls['larisdigital_wc_product_tab_reviews_title'] = array(
		'label'				=> esc_html__( 'Product review tab title', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_product_tab_reviews_title',
		'section'			=> 'larisdigital_wc_section_product',
		'type'				=> 'text',
		'priority'   		=> 30,
	);

	$controls['larisdigital_wc_product_tab_reviews_disable'] = array(
		'label'				=> esc_html__( 'DISABLE product review tab', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_product_tab_reviews_disable',
		'section'			=> 'larisdigital_wc_section_product',
		'type'				=> 'checkbox',
		'priority'   		=> 30,
	);

	$controls['larisdigital_wc_product_tab_color'] = array(
		'label'				=> esc_html__( 'Tab Title Color', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_product_tab_color',
		'section'			=> 'larisdigital_wc_section_product',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce div.product .woocommerce-tabs ul.tabs li a, .woocommerce div.product .woocommerce-tabs ul.tabs .description_tab a { color: [value] }',
		'priority'   		=> 30,
	);

	$controls['larisdigital_wc_product_tab_color_active'] = array(
		'label'				=> esc_html__( 'Tab Title Color (Active)', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_product_tab_color_active',
		'section'			=> 'larisdigital_wc_section_product',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce div.product .woocommerce-tabs ul.tabs li.active a, .woocommerce div.product .woocommerce-tabs ul.tabs .description_tab.active a { color: [value] }',
		'priority'   		=> 30,
	);

	$controls['larisdigital_wc_heading_product_desc_buttons'] = array(
		'label'    			=> esc_html__( 'Product Description CTA Buttons', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_heading_product_desc_buttons',
		'section'  			=> 'larisdigital_wc_section_product',
		'type'     			=> 'heading',
		'priority'   		=> 35,
	);

	$controls['larisdigital_wc_product_desc_button_atc'] = array(
		'label'    			=> esc_html__( 'Show "Add to cart" Button Below Product Description', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_product_desc_button_atc',
		'section'  			=> 'larisdigital_wc_section_product',
		'type'     			=> 'select',
		'default'			=> 'no',
		'choices' 			=> array(
			'no' 			=> esc_html__( 'No / Hide', 'larisdigital-wp' ),
			'yes' 			=> esc_html__( 'Yes / Show', 'larisdigital-wp' ),
		),
		'priority'   		=> 35,
	);

	$controls['larisdigital_wc_heading_product_upsells'] = array(
		'label'				=> esc_html__( 'Up-Sells Products', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_heading_product_upsells',
		'section'			=> 'larisdigital_wc_section_product',
		'type'   			=> 'heading',
		'priority'   		=> 40,
	);

	$controls['larisdigital_wc_product_upsells_disable'] = array(
		'label'				=> esc_html__( 'DISABLE upsells products (if any)', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_product_upsells_disable',
		'section'			=> 'larisdigital_wc_section_product',
		'type'				=> 'checkbox',
		'priority'   		=> 40,
	);

	$controls['larisdigital_wc_product_upsells_title_color'] = array(
		'label'				=> esc_html__( 'Title Color', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_product_upsells_title_color',
		'section'			=> 'larisdigital_wc_section_product',
		'type'   			=> 'color',
		'style'    			=> '.upsells.products > h2 { color: [value] }',
		'active_callback'	=> 'larisdigital_wc_callback_product_upsells_is_active',
		'priority'   		=> 40,
	);

	$controls['larisdigital_wc_product_upsells_columns'] = array(
		'label'				=> esc_html__( '(Max) Number of products to show', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_product_upsells_columns',
		'section'			=> 'larisdigital_wc_section_product',
		'type'				=> 'radio-buttonset',
		'choices'			=> array(
			'6' => '6',
			'5' => '5',
			'4' => '4',
			'3' => '3',
			'2' => '2',
			'1' => '1',
		),
		'active_callback'	=> 'larisdigital_wc_callback_product_upsells_is_active',
		'priority'   		=> 40,
	);

	$controls['larisdigital_wc_heading_product_related'] = array(
		'label'				=> esc_html__( 'Related Products', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_heading_product_related',
		'section'			=> 'larisdigital_wc_section_product',
		'type'   			=> 'heading',
		'priority'   		=> 50,
	);

	$controls['larisdigital_wc_product_related_disable'] = array(
		'label'				=> esc_html__( 'DISABLE related products (if any)', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_product_related_disable',
		'section'			=> 'larisdigital_wc_section_product',
		'type'				=> 'checkbox',
		'priority'   		=> 50,
	);

	$controls['larisdigital_wc_product_related_title_color'] = array(
		'label'				=> esc_html__( 'Title Color', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_product_related_title_color',
		'section'			=> 'larisdigital_wc_section_product',
		'type'   			=> 'color',
		'style'    			=> '.related.products > h2 { color: [value] }',
		'active_callback'	=> 'larisdigital_wc_callback_product_related_is_active',
		'priority'   		=> 50,
	);

	$controls['larisdigital_wc_product_related_columns'] = array(
		'label'				=> esc_html__( '(Max) Number of products to show', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_product_related_columns',
		'section'			=> 'larisdigital_wc_section_product',
		'type'				=> 'radio-buttonset',
		'choices'			=> array(
			'6' => '6',
			'5' => '5',
			'4' => '4',
			'3' => '3',
			'2' => '2',
			'1' => '1',
		),
		'active_callback'	=> 'larisdigital_wc_callback_product_related_is_active',
		'priority'   		=> 50,
	);

	return $controls;
}

/**
 * WooCommerce - Cart Page
 */
add_filter( 'larisdigital_customize_controls', 'larisdigital_wc_customize_controls_cart' );
function larisdigital_wc_customize_controls_cart( $controls ) {

	$controls['larisdigital_wc_section_cart'] = array(
		'title'    => esc_html__( 'WC - Cart Page', 'larisdigital-wp' ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-success larisdigital-alert-with-icon">
							<span class="dashicons dashicons-megaphone"></span> '.sprintf( esc_html__( 'Please edit "%s" page from WordPress Dashboard to customize the layout details using "%s" and "%s" metabox', 'larisdigital-wp' ), esc_html__( 'Cart', 'larisdigital-wp' ), esc_html__( 'Page Layout', 'larisdigital-wp' ), esc_html__( 'Site Header', 'larisdigital-wp' ) ).'
							</p>',
		'setting'  => 'larisdigital_wc_section_cart',
		'panel'    => 'larisdigital_wc_panel_settings',
		'type'     => 'section',
		'priority' => 40,
	);

	$controls['larisdigital_wc_heading_cart_coupon'] = array(
		'label'				=> esc_html__( 'Coupon Form', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_heading_cart_coupon',
		'section'			=> 'larisdigital_wc_section_cart',
		'type'   			=> 'heading',
	);

	$controls['larisdigital_wc_cart_coupon_disable'] = array(
		'label'				=> esc_html__( 'DISABLE coupon form on Cart page', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_cart_coupon_disable',
		'section'			=> 'larisdigital_wc_section_cart',
		'type'				=> 'checkbox',
	);

	$controls['larisdigital_wc_heading_cart_button'] = array(
		'label'				=> esc_html__( '"Proceed to checkout" Button', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_heading_cart_button',
		'section'			=> 'larisdigital_wc_section_cart',
		'type'   			=> 'heading',
	);

	$controls['larisdigital_wc_cart_button_text'] = array(
		'label'				=> esc_html__( 'Button Text', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_cart_button_text',
		'section'			=> 'larisdigital_wc_section_cart',
		'type'				=> 'text',
	);

	$controls['larisdigital_wc_cart_button_font_size'] = array(
		'label'    			=> esc_html__( 'Font Size', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_cart_button_font_size',
		'section'			=> 'larisdigital_wc_section_cart',
		'type'     			=> 'slider',
		'choices'  			=> array(
			'min' 			=> 0.5,
			'max' 			=> 2,
			'step' 			=> 0.1,
			'unit' 			=> 'rem',
		),
		'style'    			=> '#add_payment_method .wc-proceed-to-checkout a.checkout-button, .woocommerce-cart .wc-proceed-to-checkout a.checkout-button, .woocommerce-checkout .wc-proceed-to-checkout a.checkout-button { font-size: [value]rem }',
	);

	$controls['larisdigital_wc_cart_button_background'] = array(
		'label'				=> esc_html__( 'Background Color', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_cart_button_background',
		'section'			=> 'larisdigital_wc_section_cart',
		'type'   			=> 'color',
		'style'    			=> '#add_payment_method .wc-proceed-to-checkout a.checkout-button, .woocommerce-cart .wc-proceed-to-checkout a.checkout-button, .woocommerce-checkout .wc-proceed-to-checkout a.checkout-button { background-color: [value] }',
	);

	$controls['larisdigital_wc_cart_button_border'] = array(
		'label'				=> esc_html__( 'Border Color', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_cart_button_border',
		'section'			=> 'larisdigital_wc_section_cart',
		'type'   			=> 'color',
		'style'    			=> '#add_payment_method .wc-proceed-to-checkout a.checkout-button, .woocommerce-cart .wc-proceed-to-checkout a.checkout-button, .woocommerce-checkout .wc-proceed-to-checkout a.checkout-button { border-color: [value] }',
	);

	$controls['larisdigital_wc_cart_button_color'] = array(
		'label'				=> esc_html__( 'Text Color', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_cart_button_color',
		'section'			=> 'larisdigital_wc_section_cart',
		'type'   			=> 'color',
		'style'    			=> '#add_payment_method .wc-proceed-to-checkout a.checkout-button, .woocommerce-cart .wc-proceed-to-checkout a.checkout-button, .woocommerce-checkout .wc-proceed-to-checkout a.checkout-button { color: [value] }',
	);

	$controls['larisdigital_wc_cart_button_background_hover'] = array(
		'label'				=> esc_html__( 'Background Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_cart_button_background_hover',
		'section'			=> 'larisdigital_wc_section_cart',
		'type'   			=> 'color',
		'style'    			=> '#add_payment_method .wc-proceed-to-checkout a.checkout-button:hover, .woocommerce-cart .wc-proceed-to-checkout a.checkout-button:hover, .woocommerce-checkout .wc-proceed-to-checkout a.checkout-button:hover { background-color: [value] }',
	);

	$controls['larisdigital_wc_cart_button_border_hover'] = array(
		'label'				=> esc_html__( 'Border Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_cart_button_border_hover',
		'section'			=> 'larisdigital_wc_section_cart',
		'type'   			=> 'color',
		'style'    			=> '#add_payment_method .wc-proceed-to-checkout a.checkout-button:hover, .woocommerce-cart .wc-proceed-to-checkout a.checkout-button:hover, .woocommerce-checkout .wc-proceed-to-checkout a.checkout-button:hover { border-color: [value] }',
	);

	$controls['larisdigital_wc_cart_button_color_hover'] = array(
		'label'				=> esc_html__( 'Text Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_cart_button_color_hover',
		'section'			=> 'larisdigital_wc_section_cart',
		'type'   			=> 'color',
		'style'    			=> '#add_payment_method .wc-proceed-to-checkout a.checkout-button:hover, .woocommerce-cart .wc-proceed-to-checkout a.checkout-button:hover, .woocommerce-checkout .wc-proceed-to-checkout a.checkout-button:hover { color: [value] }',
	);

	$controls['larisdigital_wc_heading_cart_button_colors'] = array(
		'label'				=> esc_html__( 'Button Colors', 'larisdigital-wp' ),
		'description' 		=> '<p class="larisdigital-alert larisdigital-alert-with-icon">
								<span class="dashicons dashicons-admin-appearance"></span> <a href="javascript:wp.customize.control( \'larisdigital_wc_heading_button\' ).focus();">'.esc_html__( 'CLICK HERE to go to WC General settings to change WooCommerce default & primary (alt) button colors.', 'larisdigital-wp' ).'</a>
								</p>',
		'setting'  			=> 'larisdigital_wc_heading_cart_button_colors',
		'section'			=> 'larisdigital_wc_section_cart',
		'type'   			=> 'heading',
	);

	$controls['larisdigital_wc_heading_cart_cross_sells'] = array(
		'label'				=> esc_html__( 'Cross-sells Products', 'larisdigital-wp' ),
		'description' 		=> '<p class="larisdigital-alert larisdigital-alert-warning larisdigital-alert-with-icon">
								<span class="dashicons dashicons-warning"></span> '.esc_html__( 'Cross-sells products will be automatically disabled when [woocommerce_checkout] shortcode is detected on cart page', 'larisdigital-wp' ).'
								</p>',
		'setting'  			=> 'larisdigital_wc_heading_cart_cross_sells',
		'section'			=> 'larisdigital_wc_section_cart',
		'type'   			=> 'heading',
	);

	$controls['larisdigital_wc_cart_cross_sells_disable'] = array(
		'label'				=> esc_html__( 'DISABLE cross-sells products (if any)', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_cart_cross_sells_disable',
		'section'			=> 'larisdigital_wc_section_cart',
		'type'				=> 'checkbox',
	);

	$controls['larisdigital_wc_cart_cross_sells_title_color'] = array(
		'label'				=> esc_html__( 'Title Color', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_cart_cross_sells_title_color',
		'section'			=> 'larisdigital_wc_section_cart',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce .cart-collaterals .cross-sells > h2, .woocommerce-page .cart-collaterals .cross-sells > h2 { color: [value] }',
		'active_callback'	=> 'larisdigital_wc_callback_cart_cross_sells_is_active',
	);

	$controls['larisdigital_wc_cart_cross_sells_limit'] = array(
		'label'				=> esc_html__( '(Max) Number of products to show', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_cart_cross_sells_limit',
		'section'			=> 'larisdigital_wc_section_cart',
		'type'				=> 'radio-buttonset',
		'choices'			=> array(
			'2' => '2',
			'4' => '4',
			'6' => '6',
			'all' => esc_html__( 'all', 'larisdigital-wp' ),
		),
		'active_callback'	=> 'larisdigital_wc_callback_cart_cross_sells_is_active',
	);

	return $controls;
}

/**
 * WooCommerce - Checkout Page
 */
add_filter( 'larisdigital_customize_controls', 'larisdigital_wc_customize_controls_checkout' );
function larisdigital_wc_customize_controls_checkout( $controls ) {

	$controls['larisdigital_wc_section_checkout'] = array(
		'title'    => esc_html__( 'WC - Checkout Page', 'larisdigital-wp' ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-success larisdigital-alert-with-icon">
							<span class="dashicons dashicons-megaphone"></span> '.sprintf( esc_html__( 'Please edit "%s" page from WordPress Dashboard to customize the layout details using "%s" and "%s" metabox', 'larisdigital-wp' ), esc_html__( 'Checkout', 'larisdigital-wp' ), esc_html__( 'Page Layout', 'larisdigital-wp' ), esc_html__( 'Site Header', 'larisdigital-wp' ) ).'
							</p>',
		'setting'  => 'larisdigital_wc_section_checkout',
		'panel'    => 'larisdigital_wc_panel_settings',
		'type'     => 'section',
		'priority' => 50,
	);

	$controls['larisdigital_wc_heading_checkout_layout'] = array(
		'label'				=> esc_html__( 'Checkout Layout', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_heading_checkout_layout',
		'section'			=> 'larisdigital_wc_section_checkout',
		'type'   			=> 'heading',
	);

	$controls['larisdigital_wc_checkout_layout'] = array(
		'label'				=> esc_html__( 'Checkout Layout', 'larisdigital-wp' ),
		'setting'			=> 'larisdigital_wc_checkout_layout',
		'section'			=> 'larisdigital_wc_section_checkout',
		'type'				=> 'radio',
		'choices'			=> array(
			''				=> esc_html__( 'Default WooCommerce Checkout Layout', 'larisdigital-wp' ),
			'custom'		=> esc_html__( 'Billing & Shipping (Left) + Order Review (Right)', 'larisdigital-wp' ),
			'wide'			=> esc_html__( 'One Column (Wide)', 'larisdigital-wp' ),
			'slim'			=> esc_html__( 'One Column (Slim)', 'larisdigital-wp' ),
		),
	);

	$controls['larisdigital_wc_heading_checkout_elements'] = array(
		'label'				=> esc_html__( 'Checkout Page Elements', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_heading_checkout_elements',
		'section'			=> 'larisdigital_wc_section_checkout',
		'type'   			=> 'heading',
	);

	$controls['larisdigital_wc_checkout_login_disable'] = array(
		'label'				=> esc_html__( 'DISABLE login form on Checkout page', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_checkout_login_disable',
		'section'			=> 'larisdigital_wc_section_checkout',
		'type'				=> 'checkbox',
	);

	$controls['larisdigital_wc_checkout_coupon_disable'] = array(
		'label'				=> esc_html__( 'DISABLE coupon form on Checkout page', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_checkout_coupon_disable',
		'section'			=> 'larisdigital_wc_section_checkout',
		'type'				=> 'checkbox',
	);

	$controls['larisdigital_wc_checkout_product_disable'] = array(
		'label'				=> esc_html__( 'DISABLE product list on Checkout order review', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_checkout_product_disable',
		'section'			=> 'larisdigital_wc_section_checkout',
		'type'				=> 'checkbox',
	);

	$controls['larisdigital_wc_checkout_review_disable'] = array(
		'label'				=> esc_html__( 'DISABLE Checkout order review completely', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_checkout_review_disable',
		'section'			=> 'larisdigital_wc_section_checkout',
		'type'				=> 'checkbox',
	);

	$controls['larisdigital_wc_checkout_gateway_disable'] = array(
		'label'				=> esc_html__( 'DISABLE payment gateway list on Checkout page', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_checkout_gateway_disable',
		'section'			=> 'larisdigital_wc_section_checkout',
		'type'				=> 'checkbox',
	);

	$controls['larisdigital_wc_heading_checkout_privacypolicy'] = array(
		'label'    			=> esc_html__( 'Privacy Policy', 'larisdigital-wp' ),
		'description' 		=> '<p class="larisdigital-alert larisdigital-alert-with-icon">
								<span class="dashicons dashicons-admin-tools"></span> <a href="javascript:wp.customize.section( \'woocommerce_checkout\' ).focus();">'.esc_html__( 'CLICK HERE to setup/disable Privacy Policy on checkout page', 'larisdigital-wp' ).'</a>
								</p>',
		'setting' 			=> 'larisdigital_wc_heading_checkout_privacypolicy',
		'section'			=> 'larisdigital_wc_section_checkout',
		'type'     			=> 'heading',
	);

	$controls['larisdigital_wc_heading_checkout_terms'] = array(
		'label'    			=> esc_html__( 'Terms And Conditions', 'larisdigital-wp' ),
		'description' 		=> '<p class="larisdigital-alert larisdigital-alert-with-icon">
								<span class="dashicons dashicons-admin-tools"></span> <a href="javascript:wp.customize.section( \'woocommerce_checkout\' ).focus();">'.esc_html__( 'CLICK HERE to setup/disable Terms And Conditions on checkout page', 'larisdigital-wp' ).'</a>
								</p>',
		'setting' 			=> 'larisdigital_wc_heading_checkout_terms',
		'section'			=> 'larisdigital_wc_section_checkout',
		'type'     			=> 'heading',
	);

	$controls['larisdigital_wc_heading_checkout_payment'] = array(
		'label'				=> esc_html__( 'Checkout Payment', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_heading_checkout_payment',
		'section'			=> 'larisdigital_wc_section_checkout',
		'type'   			=> 'heading',
	);

	$controls['larisdigital_wc_checkout_payment_background'] = array(
		'label'				=> esc_html__( 'Background Color', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_checkout_payment_background',
		'section'			=> 'larisdigital_wc_section_checkout',
		'type'   			=> 'color',
		'style'    			=> '#add_payment_method #payment, .woocommerce-cart #payment, .woocommerce-checkout #payment { background-color: [value] }',
	);

	$controls['larisdigital_wc_checkout_payment_color'] = array(
		'label'				=> esc_html__( 'Text Color', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_checkout_payment_color',
		'section'			=> 'larisdigital_wc_section_checkout',
		'type'   			=> 'color',
		'style'    			=> '#add_payment_method #payment, .woocommerce-cart #payment, .woocommerce-checkout #payment { color: [value] }',
	);

	$controls['larisdigital_wc_checkout_payment_divider'] = array(
		'label'				=> esc_html__( 'Divider Color', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_checkout_divider_color',
		'section'			=> 'larisdigital_wc_section_checkout',
		'type'   			=> 'color',
		'style'    			=> '#add_payment_method #payment ul.payment_methods, .woocommerce-cart #payment ul.payment_methods, .woocommerce-checkout #payment ul.payment_methods { border-color: [value] }',
	);

	$controls['larisdigital_wc_checkout_payment_detail_bg'] = array(
		'label'				=> esc_html__( 'Payment Detail Background Color', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_checkout_payment_detail_bg',
		'section'			=> 'larisdigital_wc_section_checkout',
		'type'   			=> 'color',
		'style'    			=> '#add_payment_method #payment div.payment_box, .woocommerce-cart #payment div.payment_box, .woocommerce-checkout #payment div.payment_box { background-color: [value] } #add_payment_method #payment div.payment_box::before, .woocommerce-cart #payment div.payment_box::before, .woocommerce-checkout #payment div.payment_box::before { border-bottom-color: [value] }',
	);

	$controls['larisdigital_wc_checkout_payment_detail_color'] = array(
		'label'				=> esc_html__( 'Payment Detail Text Color', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_checkout_payment_detail_color',
		'section'			=> 'larisdigital_wc_section_checkout',
		'type'   			=> 'color',
		'style'    			=> '#add_payment_method #payment div.payment_box, .woocommerce-cart #payment div.payment_box, .woocommerce-checkout #payment div.payment_box { color: [value] }',
	);

	$controls['larisdigital_wc_heading_checkout_button'] = array(
		'label'				=> esc_html__( '"Place order" Button', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_heading_checkout_button',
		'section'			=> 'larisdigital_wc_section_checkout',
		'type'   			=> 'heading',
	);

	$controls['larisdigital_wc_checkout_button_style'] = array(
		'label'				=> esc_html__( 'Button Style', 'larisdigital-wp' ),
		'setting'			=> 'larisdigital_wc_checkout_button_style',
		'section'			=> 'larisdigital_wc_section_checkout',
		'type'				=> 'radio',
		'choices'			=> array(
			''				=> esc_html__( 'Inline', 'larisdigital-wp' ),
			'fullwidth'		=> esc_html__( 'Full Width', 'larisdigital-wp' ),
		),
		'style'				=> array(
			''				=> '',
			'fullwidth'		=> '.woocommerce #payment #place_order, .woocommerce-page #payment #place_order { display: block; width: 100%; }',
		),
	);

	$controls['larisdigital_wc_checkout_button_text'] = array(
		'label'				=> esc_html__( 'Button Text', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_checkout_button_text',
		'section'			=> 'larisdigital_wc_section_checkout',
		'type'				=> 'text',
	);

	$controls['larisdigital_wc_checkout_button_font_size'] = array(
		'label'    			=> esc_html__( 'Font Size', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_checkout_button_font_size',
		'section'			=> 'larisdigital_wc_section_checkout',
		'type'     			=> 'slider',
		'choices'  			=> array(
			'min' 			=> 0.5,
			'max' 			=> 2,
			'step' 			=> 0.1,
			'unit' 			=> 'rem',
		),
		'style'    			=> '.woocommerce #payment #place_order, .woocommerce-page #payment #place_order { font-size: [value]rem }',
	);

	$controls['larisdigital_wc_checkout_button_background'] = array(
		'label'				=> esc_html__( 'Background Color', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_checkout_button_background',
		'section'			=> 'larisdigital_wc_section_checkout',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce #payment #place_order, .woocommerce-page #payment #place_order { background-color: [value] }',
	);

	$controls['larisdigital_wc_checkout_button_border'] = array(
		'label'				=> esc_html__( 'Border Color', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_checkout_button_border',
		'section'			=> 'larisdigital_wc_section_checkout',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce #payment #place_order, .woocommerce-page #payment #place_order { border-color: [value] }',
	);

	$controls['larisdigital_wc_checkout_button_color'] = array(
		'label'				=> esc_html__( 'Text Color', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_checkout_button_color',
		'section'			=> 'larisdigital_wc_section_checkout',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce #payment #place_order, .woocommerce-page #payment #place_order { color: [value] }',
	);

	$controls['larisdigital_wc_checkout_button_background_hover'] = array(
		'label'				=> esc_html__( 'Background Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_checkout_button_background_hover',
		'section'			=> 'larisdigital_wc_section_checkout',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce #payment #place_order:hover, .woocommerce-page #payment #place_order:hover { background-color: [value] }',
	);

	$controls['larisdigital_wc_checkout_button_border_hover'] = array(
		'label'				=> esc_html__( 'Border Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_checkout_button_border_hover',
		'section'			=> 'larisdigital_wc_section_checkout',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce #payment #place_order:hover, .woocommerce-page #payment #place_order:hover { border-color: [value] }',
	);

	$controls['larisdigital_wc_checkout_button_color_hover'] = array(
		'label'				=> esc_html__( 'Text Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_checkout_button_color_hover',
		'section'			=> 'larisdigital_wc_section_checkout',
		'type'   			=> 'color',
		'style'    			=> '.woocommerce #payment #place_order:hover, .woocommerce-page #payment #place_order:hover { color: [value] }',
	);

	$controls['larisdigital_wc_heading_checkout_button_colors'] = array(
		'label'				=> esc_html__( 'Button Colors', 'larisdigital-wp' ),
		'description' 		=> '<p class="larisdigital-alert larisdigital-alert-with-icon">
								<span class="dashicons dashicons-admin-appearance"></span> <a href="javascript:wp.customize.control( \'larisdigital_wc_heading_button\' ).focus();">'.esc_html__( 'CLICK HERE to go to WC General settings to change WooCommerce default & primary (alt) button colors.', 'larisdigital-wp' ).'</a>
								</p>',
		'setting'  			=> 'larisdigital_wc_heading_checkout_button_colors',
		'section'			=> 'larisdigital_wc_section_checkout',
		'type'   			=> 'heading',
	);

	return $controls;
}

/**
 * WooCommerce - My Account Page
 */
add_filter( 'larisdigital_customize_controls', 'larisdigital_wc_customize_controls_myaccount' );
function larisdigital_wc_customize_controls_myaccount( $controls ) {

	$controls['larisdigital_wc_section_myaccount'] = array(
		'title'    => esc_html__( 'WC - My Account / Member Area', 'larisdigital-wp' ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-success larisdigital-alert-with-icon">
							<span class="dashicons dashicons-megaphone"></span> '.sprintf( esc_html__( 'Please edit "%s" page from WordPress Dashboard to customize the layout details using "%s" and "%s" metabox', 'larisdigital-wp' ), esc_html__( 'My Account', 'larisdigital-wp' ), esc_html__( 'Page Layout', 'larisdigital-wp' ), esc_html__( 'Site Header', 'larisdigital-wp' ) ).'
							</p>',
		'setting'  => 'larisdigital_wc_section_myaccount',
		'panel'    => 'larisdigital_wc_panel_settings',
		'type'     => 'section',
		'priority' => 60,
	);

	$controls['larisdigital_wc_heading_myaccount_redirect_page'] = array(
		'label'				=> esc_html__( 'Page Redirect After Login', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_heading_myaccount_redirect_page',
		'section'			=> 'larisdigital_wc_section_myaccount',
		'type'   			=> 'heading',
	);

	$controls['larisdigital_wc_myaccount_redirect_page'] = array(
		'label'				=> esc_html__( 'Redirect to a page after customer login', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_myaccount_redirect_page',
		'section'			=> 'larisdigital_wc_section_myaccount',
		'type'				=> 'dropdown-pages',
	);

	$controls['larisdigital_wc_heading_myaccount_dashboard_page'] = array(
		'label'				=> esc_html__( 'Dashboard Page', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_wc_heading_myaccount_dashboard_page',
		'section'			=> 'larisdigital_wc_section_myaccount',
		'type'   			=> 'heading',
	);

	$controls['larisdigital_wc_myaccount_dashboard_enable'] = array(
		'label'    => esc_html__( 'Enable Account Dashboard Content', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_wc_myaccount_dashboard_enable',
		'section'  => 'larisdigital_wc_section_myaccount',
		'type'     => 'checkbox',
	);

	$controls['larisdigital_wc_myaccount_dashboard_content'] = array(
		'label'    => esc_html__( 'Account Dashboard Content', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_wc_myaccount_dashboard_content',
		'section'  => 'larisdigital_wc_section_myaccount',
		'type'     => 'textarea-html',
	);

	return $controls;
}

function larisdigital_wc_callback_header_product_is_active() {
	return ( larisdigital_theme_mod( 'larisdigital_header_hide' ) || larisdigital_theme_mod( 'larisdigital_wc_product_header_hide' ) ) ? false : true;
}

function larisdigital_wc_callback_shop_sidebar_is_active() {
	$layout = larisdigital_theme_mod( 'larisdigital_wc_shop_sidebar_layout' );
	return ( 'none' != $layout ) ? true : false;
}

function larisdigital_wc_callback_shop_sidebar_is_not_active() {
	$layout = larisdigital_theme_mod( 'larisdigital_wc_shop_sidebar_layout' );
	return ( 'none' == $layout ) ? true : false;
}

function larisdigital_wc_callback_product_sidebar_is_active() {
	$layout = larisdigital_theme_mod( 'larisdigital_wc_product_sidebar_layout' );
	return ( 'none' != $layout ) ? true : false;
}

function larisdigital_wc_callback_product_sidebar_is_not_active() {
	$layout = larisdigital_theme_mod( 'larisdigital_wc_product_sidebar_layout' );
	return ( 'none' == $layout ) ? true : false;
}

function larisdigital_wc_callback_shop_button_is_active() {
	return larisdigital_theme_mod( 'larisdigital_wc_shop_button_disable' ) ? false : true;
}

function larisdigital_wc_callback_shop_button_is_addtocart() {
	if ( larisdigital_theme_mod( 'larisdigital_wc_shop_button_disable' ) ) {
		return false;
	}
	else {
		if ( larisdigital_theme_mod( 'larisdigital_wc_shop_button_type' ) == 'addtocart' ) {
			return true;
		}
		else {
			return false;
		}
	}
}

function larisdigital_wc_callback_shop_button_is_detail() {
	if ( larisdigital_theme_mod( 'larisdigital_wc_shop_button_disable' ) ) {
		return false;
	}
	else {
		if ( larisdigital_theme_mod( 'larisdigital_wc_shop_button_type' ) != 'addtocart' ) {
			return true;
		}
		else {
			return false;
		}
	}
}

function larisdigital_wc_callback_shop_columns_mobile_is_active() {
	return larisdigital_theme_mod( 'larisdigital_wc_shop_columns' ) != 1 ? true : false;
}

function larisdigital_wc_callback_product_button_is_active() {
	return larisdigital_theme_mod( 'larisdigital_wc_product_button_disable' ) ? false : true;
}

function larisdigital_wc_callback_product_share_is_active() {
	return larisdigital_theme_mod( 'larisdigital_wc_product_share' ) ? true : false;
}

function larisdigital_wc_callback_product_upsells_is_active() {
	return larisdigital_theme_mod( 'larisdigital_wc_product_upsells_disable' ) ? false : true;
}

function larisdigital_wc_callback_product_related_is_active() {
	return larisdigital_theme_mod( 'larisdigital_wc_product_related_disable' ) ? false : true;
}

function larisdigital_wc_callback_cart_cross_sells_is_active() {
	return larisdigital_theme_mod( 'larisdigital_wc_cart_cross_sells_disable' ) ? false : true;
}
function larisdigital_wc_callback_product_image_style_is_not_active() {
	return larisdigital_theme_mod( 'larisdigital_wc_product_image_style' ) ? false : true;
}

add_action( 'customize_controls_print_scripts', 'larisdigital_wc_customize_print_scripts', 30 );
function larisdigital_wc_customize_print_scripts() {
	$shop_page = wc_get_page_permalink( 'shop' );
	$cart_page = wc_get_page_permalink( 'cart' );
	$checkout_page = wc_get_page_permalink( 'checkout' );
	$myaccount_page = wc_get_page_permalink( 'myaccount' );

	$shop_section = apply_filters( 'larisdigital_wc_customize_preview_shop', array(
		'larisdigital_wc_section_general' => 'larisdigital_wc_section_general',
		'larisdigital_wc_section_shop' => 'larisdigital_wc_section_shop',
	) );
	$cart_section = apply_filters( 'larisdigital_wc_customize_preview_cart', array(
		'larisdigital_wc_section_cart' => 'larisdigital_wc_section_cart',
	) );
	$checkout_section = apply_filters( 'larisdigital_wc_customize_preview_checkout', array(
		'larisdigital_wc_section_checkout' => 'larisdigital_wc_section_checkout',
	) );
	$myaccount_section = apply_filters( 'larisdigital_wc_customize_preview_myaccount', array(
		'larisdigital_wc_section_myaccount' => 'larisdigital_wc_section_myaccount',
	) );
?>
<script type="text/javascript">
jQuery( document ).ready( function( $ ) {
<?php if ( $shop_page && ! empty( $shop_section ) ) : foreach ( $shop_section as $section => $value ) : ?>
	wp.customize.section( '<?php echo esc_attr($section); ?>', function( section ) {
		section.expanded.bind( function( isExpanded ) {
			if ( isExpanded ) {
				wp.customize.previewer.previewUrl.set( '<?php echo esc_js( $shop_page ); ?>' );
			}
		} );
	} );
<?php endforeach; endif; ?>
<?php if ( $cart_page && ! empty( $cart_section )  ) : foreach ( $cart_section as $section => $value ) : ?>
	wp.customize.section( '<?php echo esc_attr($section); ?>', function( section ) {
		section.expanded.bind( function( isExpanded ) {
			if ( isExpanded ) {
				wp.customize.previewer.previewUrl.set( '<?php echo esc_js( $cart_page ); ?>' );
			}
		} );
	} );
<?php endforeach; endif; ?>
<?php if ( $checkout_page && ! empty( $checkout_section ) ) : foreach ( $checkout_section as $section => $value ) : ?>
	wp.customize.section( '<?php echo esc_attr($section); ?>', function( section ) {
		section.expanded.bind( function( isExpanded ) {
			if ( isExpanded ) {
				wp.customize.previewer.previewUrl.set( '<?php echo esc_js( $checkout_page ); ?>' );
			}
		} );
	} );
<?php endforeach; endif; ?>
<?php if ( $myaccount_page && ! empty( $myaccount_section ) ) : foreach ( $myaccount_section as $section => $value ) : ?>
	wp.customize.section( '<?php echo esc_attr($section); ?>', function( section ) {
		section.expanded.bind( function( isExpanded ) {
			if ( isExpanded ) {
				wp.customize.previewer.previewUrl.set( '<?php echo esc_js( $myaccount_page ); ?>' );
			}
		} );
	} );
<?php endforeach; endif; ?>
} );
</script>
<?php
}

add_action( 'customize_controls_print_scripts', 'larisdigital_wc_customize_scripts_preview_product', 30 );
function larisdigital_wc_customize_scripts_preview_product() {
	$product_ids = get_posts( array(
		'posts_per_page' => 1,
		'post_type' => 'product',
		'orderby' => 'date',
		'order' => 'ASC',
		'meta_query' => array(
			array(
				'key'     => '_layout_custom',
				'value'   => '',
				'compare' => 'NOT EXISTS',
			),
			array(
				'key'     => '_elementor_edit_mode',
				'value'   => '',
				'compare' => 'NOT EXISTS',
			),
			array(
				'key'     => '_wp_page_template',
				'value'   => '',
				'compare' => 'NOT EXISTS',
			),
		),
		'fields' => 'ids',
	) );
	$product_url = !empty( $product_ids ) ? get_permalink( reset( $product_ids ) ) : '';
	$product_section = apply_filters( 'larisdigital_wc_customize_preview_product', array(
		'larisdigital_wc_section_product' => 'larisdigital_wc_section_product',
	) );
	if ( empty( $product_url ) ) {
		return;
	}
	if ( empty( $product_section ) ) {
		return;
	}
?>
<script type="text/javascript">
jQuery( document ).ready( function( $ ) {
<?php foreach ( $product_section as $section => $value ) : ?>
	wp.customize.section( '<?php echo esc_attr($section); ?>', function( section ) {
		section.expanded.bind( function( isExpanded ) {
			if ( isExpanded ) {
				wp.customize.previewer.previewUrl.set( '<?php echo esc_js( $product_url ); ?>' );
			}
		} );
	} );
<?php endforeach; ?>
} );
</script>
<?php
}
