<?php 
/**
 * LarisDigital Store - Customizer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( class_exists('woocommerce') ) {
	return;
}

if ( class_exists('Easy_Digital_Shop') ) {
	return;
}

/**
 * Store - Customizer Panel
 */
add_filter( 'larisdigital_customize_controls', 'larisdigital_store_customize_controls' );
function larisdigital_store_customize_controls( $controls ) {
	$controls['larisdigital_store_panel_settings'] = array(
		'title'    => esc_html__( 'Theme Settings - Store', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_store_panel_settings',
		'type'     => 'panel',
		'priority' => 15,
	);

	return $controls;
}

/**
 * Store - General
 */
add_filter( 'larisdigital_customize_controls', 'larisdigital_store_customize_controls_general' );
function larisdigital_store_customize_controls_general( $controls ) {

	$controls['larisdigital_store_section_general'] = array(
		'title'    => esc_html__( 'Store - General', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_store_section_general',
		'panel'    => 'larisdigital_store_panel_settings',
		'type'     => 'section',
		'priority' => 10,
	);

	$controls['larisdigital_store_heading_currency'] = array(
		'label'				=> esc_html__( 'Currency', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_store_heading_currency',
		'section'			=> 'larisdigital_store_section_general',
		'type'   			=> 'heading',
	);

	$controls['larisdigital_store_currency'] = array(
		'label'    => esc_html__( 'Currency', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_store_currency',
		'section'  => 'larisdigital_store_section_general',
		'type'     => 'text',
		'input_attrs' => array(
			'placeholder' => 'Rp',
		),
	);

	$controls['larisdigital_store_currency_pos'] = array(
		'label'    => esc_html__( 'Currency position', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_store_currency_pos',
		'section'  => 'larisdigital_store_section_general',
		'type'     => 'select',
		'default'  => 'left',
		'choices'  => array(
			'left' => esc_html__( 'Left', 'larisdigital-wp' ),
			'right' => esc_html__( 'Right', 'larisdigital-wp' ),
			'left_space' => esc_html__( 'Left with space', 'larisdigital-wp' ),
			'right_space' => esc_html__( 'Right with space', 'larisdigital-wp' ),
		),
	);

	$controls['larisdigital_store_price_thousand_sep'] = array(
		'label'    => esc_html__( 'Thousand separator', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_store_price_thousand_sep',
		'section'  => 'larisdigital_store_section_general',
		'type'     => 'text',
		'input_attrs' => array(
			'placeholder' => ',',
		),
	);

	$controls['larisdigital_store_price_decimal_sep'] = array(
		'label'    => esc_html__( 'Decimal separator', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_store_price_decimal_sep',
		'section'  => 'larisdigital_store_section_general',
		'type'     => 'text',
		'input_attrs' => array(
			'placeholder' => '.',
		),
	);

	$controls['larisdigital_store_price_num_decimals'] = array(
		'label'    => esc_html__( 'Number of decimals', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_store_price_num_decimals',
		'section'  => 'larisdigital_store_section_general',
		'type'     => 'number',
		'default'  => 0,
		'input_attrs' => array(
			'placeholder' => 0,
		),
	);

	$controls['larisdigital_store_heading_free_text'] = array(
		'label'				=> esc_html__( 'Free Price Text', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_store_heading_free_text',
		'section'			=> 'larisdigital_store_section_general',
		'type'   			=> 'heading',
	);

	$controls['larisdigital_store_free_text'] = array(
		'label'    => esc_html__( 'Free Price Text', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_store_free_text',
		'section'  => 'larisdigital_store_section_general',
		'type'     => 'text',
		'input_attrs' => array(
			'placeholder' => esc_html__( 'Free', 'larisdigital-wp' ),
		),
	);

	$controls['larisdigital_store_heading_saleflash'] = array(
		'label'				=> esc_html__( 'Sale Flash Badge', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_store_heading_saleflash',
		'section'			=> 'larisdigital_store_section_general',
		'type'   			=> 'heading',
	);

	$controls['larisdigital_store_saleflash_text'] = array(
		'label'				=> esc_html__( 'Sale Flash Badge Text', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_store_saleflash_text',
		'section'			=> 'larisdigital_store_section_general',
		'type'   			=> 'text',
		'input_attrs' => array(
			'placeholder' => esc_html__( 'Sale', 'larisdigital-wp' ),
		),
	);

	$controls['larisdigital_store_saleflash_background'] = array(
		'label'				=> esc_html__( 'Background Color', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_store_saleflash_background',
		'section'			=> 'larisdigital_store_section_general',
		'type'   			=> 'color',
		'style'    			=> '.ld-shop-onsale, .ld-product-onsale { background-color: [value] }',
	);

	$controls['larisdigital_store_saleflash_color'] = array(
		'label'				=> esc_html__( 'Text Color', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_store_saleflash_color',
		'section'			=> 'larisdigital_store_section_general',
		'type'   			=> 'color',
		'style'    			=> '.ld-shop-onsale, .ld-product-onsale { color: [value] }',
	);

	return $controls;
}

/**
 * Store - Shop Page
 */
add_filter( 'larisdigital_customize_controls', 'larisdigital_store_customize_controls_shop' );
function larisdigital_store_customize_controls_shop( $controls ) {

	$controls['larisdigital_store_section_shop'] = array(
		'title'    => esc_html__( 'Store - Shop Page', 'larisdigital-wp' ),
		'description' => '',
		'setting'  => 'larisdigital_store_section_shop',
		'panel'    => 'larisdigital_store_panel_settings',
		'type'     => 'section',
		'priority' => 20,
	);

	$controls['larisdigital_store_heading_shop_site_header'] = array(
		'label'    => esc_html__( 'Site Header', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_store_heading_shop_site_header',
		'section'  => 'larisdigital_store_section_shop',
		'type'     => 'heading',
		'active_callback' =>'larisdigital_callback_header_is_active',
	);

	$controls['larisdigital_store_shop_title4header'] = array(
		'label'    => esc_html__( 'Use custom title for header title', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_store_shop_title4header',
		'section'  => 'larisdigital_store_section_shop',
		'type'     => 'checkbox',
		'active_callback' =>'larisdigital_callback_header_is_active',
	);

	$controls['larisdigital_store_shop_title'] = array(
		'label'    => esc_html__( 'Shop page title', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_store_shop_title',
		'section'  => 'larisdigital_store_section_shop',
		'type'     => 'text',
		'input_attrs' => array(
			'placeholder' => esc_html__( 'Shop', 'larisdigital-wp' ),
		),
		'active_callback' =>'larisdigital_callback_header_is_active',
	);

	$controls['larisdigital_store_shop_description'] = array(
		'label'    => esc_html__( 'Shop page description', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_store_shop_description',
		'section'  => 'larisdigital_store_section_shop',
		'type'     => 'text',
		'active_callback' =>'larisdigital_callback_header_is_active',
	);

	$controls['larisdigital_store_heading_shop_sidebar_layout'] = array(
		'label'    => esc_html__( 'Sidebar Layout', 'larisdigital-wp' ),
		'description' 		=> '<p class="larisdigital-alert larisdigital-alert-with-icon">
								<span class="dashicons dashicons-admin-tools"></span> <a href="javascript:wp.customize.panel( \'widgets\' ).focus();">'.esc_html__( 'CLICK HERE to setup / manage widgets when sidebar is available', 'larisdigital-wp' ).'</a>
								</p>',
		'setting'  => 'larisdigital_store_heading_shop_sidebar_layout',
		'section'  => 'larisdigital_store_section_shop',
		'type'     => 'heading',
	);

	$controls['larisdigital_store_shop_sidebar_layout'] = array(
		'label'    => esc_html__( 'Sidebar Layout', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_store_shop_sidebar_layout',
		'section'  => 'larisdigital_store_section_shop',
		'type'     => 'select',
		'choices'  => array(
			'none' => esc_html__( 'No Sidebar', 'larisdigital-wp' ),
			'right' => esc_html__( 'Right Sidebar', 'larisdigital-wp' ),
			'left' => esc_html__( 'Left Sidebar', 'larisdigital-wp' ),
		),
	);

	$controls['larisdigital_store_shop_sidebar_width'] = array(
		'label'    => esc_html__( 'Sidebar Width', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_store_shop_sidebar_width',
		'section'  => 'larisdigital_store_section_shop',
		'type'     => 'select',
		'choices'  => array(
			'' => esc_html__( 'Default', 'larisdigital-wp' ),
			'3' => esc_html__( '3/12 Grid', 'larisdigital-wp' ),
			'4' => esc_html__( '4/12 Grid', 'larisdigital-wp' ),
			'5' => esc_html__( '5/12 Grid', 'larisdigital-wp' ),
			'6' => esc_html__( '6/12 Grid', 'larisdigital-wp' ),
		),
		'active_callback' => 'larisdigital_store_callback_shop_sidebar_is_active',
	);

	$controls['larisdigital_store_shop_content_width'] = array(
		'label'    => esc_html__( 'Content Width', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_store_shop_content_width',
		'section'  => 'larisdigital_store_section_shop',
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
		'active_callback' => 'larisdigital_store_callback_shop_sidebar_is_not_active',
	);

	$controls['larisdigital_store_heading_shop_layout'] = array(
		'label'    => esc_html__( 'Shop Page Layout', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_store_heading_shop_layout',
		'section'  => 'larisdigital_store_section_shop',
		'type'     => 'heading',
	);

	$controls['larisdigital_store_shop_columns'] = array(
		'label'				=> esc_html__( 'Number of products per row', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_store_shop_columns',
		'section'			=> 'larisdigital_store_section_shop',
		'type'				=> 'radio-buttonset',
		'choices'			=> array(
			'4' => '4',
			'3' => '3',
			'2' => '2',
			'1' => '1',
		),
	);

	$controls['larisdigital_store_shop_columns_tablet'] = array(
		'label'				=> esc_html__( 'Number of products per row (tablet)', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_store_shop_columns_tablet',
		'description' 		=> esc_html__( 'device viewport width >= 576px and < 992px', 'larisdigital-wp' ),
		'section'			=> 'larisdigital_store_section_shop',
		'type'				=> 'radio-buttonset',
		'choices'			=> array(
			'3' => '3',
			'2' => '2',
			'1' => '1',
		),
	);

	$controls['larisdigital_store_shop_columns_mobile'] = array(
		'label'				=> esc_html__( 'Number of products per row (mobile)', 'larisdigital-wp' ),
		'description' 		=> esc_html__( 'device viewport width < 576px', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_store_shop_columns_mobile',
		'section'			=> 'larisdigital_store_section_shop',
		'type'				=> 'radio-buttonset',
		'choices'			=> array(
			'2' => '2',
			'1' => '1',
		),
	);

	$controls['larisdigital_store_shop_per_page'] = array(
		'label'				=> esc_html__( 'Number of products per page', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_store_shop_per_page',
		'section'			=> 'larisdigital_store_section_shop',
		'type'				=> 'number',
	);


	$controls['larisdigital_store_heading_shop_elements'] = array(
		'label'    => esc_html__( 'Shop Page Elements', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_store_heading_shop_elements',
		'section'  => 'larisdigital_store_section_shop',
		'type'     => 'heading',
	);

	$controls['larisdigital_store_shop_saleflash_disable'] = array(
		'label'				=> esc_html__( 'DISABLE product sale flash badge', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_store_shop_saleflash_disable',
		'section'			=> 'larisdigital_store_section_shop',
		'type'				=> 'checkbox',
	);

	$controls['larisdigital_store_shop_title_disable'] = array(
		'label'				=> esc_html__( 'DISABLE product title', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_store_shop_title_disable',
		'section'			=> 'larisdigital_store_section_shop',
		'type'				=> 'checkbox',
	);

	$controls['larisdigital_store_shop_title_truncate'] = array(
		'label'				=> esc_html__( 'TRUNCATE product title (one line only)', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_store_shop_title_truncate',
		'section'			=> 'larisdigital_store_section_shop',
		'type'				=> 'checkbox',
	);

	$controls['larisdigital_store_shop_price'] = array(
		'label'				=> esc_html__( 'Show product price', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_store_shop_price',
		'section'			=> 'larisdigital_store_section_shop',
		'type'				=> 'radio',
		'choices'			=> array(
			''				=> esc_html__( 'After Product Title', 'larisdigital-wp' ),
			'right' 		=> esc_html__( 'Right of Product Title', 'larisdigital-wp' ),
			'image' 		=> esc_html__( 'Inside Product Image', 'larisdigital-wp' ),
			'disable' 		=> esc_html__( 'Disable Product Price', 'larisdigital-wp' ),
		),
	);

	$controls['larisdigital_store_shop_product_alignment'] = array(
		'label'				=> esc_html__( 'Product Detail Alignment', 'larisdigital-wp' ),
		'setting'			=> 'larisdigital_store_shop_product_alignment',
		'section'			=> 'larisdigital_store_section_shop',
		'type'				=> 'radio-iconset',
		'choices'			=> array(
			'left'			=> 'dashicons dashicons-editor-alignleft',
			'center'		=> 'dashicons dashicons-editor-aligncenter',
			'right'			=> 'dashicons dashicons-editor-alignright',
		),
		'style'				=> array(
			'left'			=> '.ld-shop-item .card { text-align: left; }',
			'center'		=> '.ld-shop-item .card { text-align: center; }',
			'right'			=> '.ld-shop-item .card { text-align: right; }',
		),
	);

	$controls['larisdigital_store_shop_product_box_background'] = array(
		'label'				=> esc_html__( 'Product Box Background', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_store_shop_product_box_background',
		'section'			=> 'larisdigital_store_section_shop',
		'type'   			=> 'color',
		'style'    			=> '.ld-shop-item .card { background: [value] }',
	);

	$controls['larisdigital_store_shop_product_box_border'] = array(
		'label'				=> esc_html__( 'Product Box Border', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_store_shop_product_box_border',
		'section'			=> 'larisdigital_store_section_shop',
		'type'   			=> 'color',
		'style'    			=> '.ld-shop-item .card { border-color: [value] }',
	);

	$controls['larisdigital_store_shop_product_title_color'] = array(
		'label'				=> esc_html__( 'Product Title Color', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_store_shop_product_title_color',
		'section'			=> 'larisdigital_store_section_shop',
		'type'   			=> 'color',
		'style'    			=> '.ld-shop-title, .ld-shop-title a { color: [value] }',
	);

	$controls['larisdigital_store_shop_product_price_color'] = array(
		'label'				=> esc_html__( 'Product Price Color', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_store_shop_product_price_color',
		'section'			=> 'larisdigital_store_section_shop',
		'type'   			=> 'color',
		'style'    			=> '.ld-shop-price, .ld-shop-price-right, .ld-shop-price-image { color: [value] }',
	);

	$controls['larisdigital_store_shop_product_price_bg'] = array(
		'label'				=> esc_html__( 'Product Price Background Color', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_store_shop_product_price_bg',
		'section'			=> 'larisdigital_store_section_shop',
		'type'   			=> 'color',
		'style'    			=> '.ld-shop-price-right, .ld-shop-price-image {background-color: [value] } .ld-shop-price {background-color: [value]; padding: 0.25rem 0.5rem; border-radius: 2px; display: inline-block; }',
	);

	$controls['larisdigital_store_heading_shop_pagination'] = array(
		'label'				=> esc_html__( 'Pagination Style', 'larisdigital-wp' ),
		'description'		=> '<p class="larisdigital-alert larisdigital-alert-with-icon"><span class="dashicons dashicons-admin-appearance"></span> <a href="javascript:wp.customize.control( \'larisdigital_heading_pagination\' ).focus();">' . sprintf( esc_html__( 'CLICK HERE to setup %s', 'larisdigital-wp' ), esc_html__( 'Pagination Style', 'larisdigital-wp' ) ) . '</a></p>',
		'setting'			=> 'larisdigital_store_heading_shop_pagination',
		'section'			=> 'larisdigital_store_section_shop',
		'type'				=> 'heading',
		'priority'			=> 99,
	);

	return $controls;
}

/**
 * Store - Single Product
 */
add_filter( 'larisdigital_customize_controls', 'larisdigital_store_customize_controls_product' );
function larisdigital_store_customize_controls_product( $controls ) {

	$controls['larisdigital_store_section_product'] = array(
		'title'    => esc_html__( 'Store - Single Product', 'larisdigital-wp' ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-success larisdigital-alert-with-icon">
							<span class="dashicons dashicons-megaphone"></span>'.sprintf( esc_html__( 'These settings are applied on All %s', 'larisdigital-wp' ), esc_html__( 'Single Product', 'larisdigital-wp' ) ).
						'</p>',
		'setting'  => 'larisdigital_store_section_product',
		'panel'    => 'larisdigital_store_panel_settings',
		'type'     => 'section',
		'priority' => 30,
	);

	$controls['larisdigital_store_heading_product_site_header'] = array(
		'label'    => esc_html__( 'Site Header', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_store_heading_product_site_header',
		'section'  => 'larisdigital_store_section_product',
		'type'     => 'heading',
		'active_callback' =>'larisdigital_callback_header_is_active',
	);

	$controls['larisdigital_store_product_header_hide'] = array(
		'label'    => esc_html__( 'HIDE Site Header on All Single Product', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_store_product_header_hide',
		'section'  => 'larisdigital_store_section_product',
		'type'     => 'checkbox',
		'active_callback' =>'larisdigital_callback_header_is_active',
	);

	$controls['larisdigital_store_product_title4header'] = array(
		'label'    => esc_html__( 'Use product title for header title', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_store_product_title4header',
		'section'  => 'larisdigital_store_section_product',
		'type'     => 'checkbox',
		'active_callback' =>'larisdigital_store_callback_header_product_is_active',
	);

	$controls['larisdigital_store_heading_product_sidebar_layout'] = array(
		'label'    => esc_html__( 'Sidebar Layout', 'larisdigital-wp' ),
		'description' 		=> '<p class="larisdigital-alert larisdigital-alert-with-icon">
								<span class="dashicons dashicons-admin-tools"></span> <a href="javascript:wp.customize.panel( \'widgets\' ).focus();">'.esc_html__( 'CLICK HERE to setup / manage widgets when sidebar is available', 'larisdigital-wp' ).'</a>
								</p>',
		'setting'  => 'larisdigital_store_heading_product_sidebar_layout',
		'section'  => 'larisdigital_store_section_product',
		'type'     => 'heading',
	);

	$controls['larisdigital_store_product_sidebar_layout'] = array(
		'label'    => esc_html__( 'Sidebar Layout', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_store_product_sidebar_layout',
		'section'  => 'larisdigital_store_section_product',
		'type'     => 'select',
		'choices'  => array(
			'none' => esc_html__( 'No Sidebar', 'larisdigital-wp' ),
			'right' => esc_html__( 'Right Sidebar', 'larisdigital-wp' ),
			'left' => esc_html__( 'Left Sidebar', 'larisdigital-wp' ),
		),
	);

	$controls['larisdigital_store_product_sidebar_width'] = array(
		'label'    => esc_html__( 'Sidebar Width', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_store_product_sidebar_width',
		'section'  => 'larisdigital_store_section_product',
		'type'     => 'select',
		'choices'  => array(
			'' => esc_html__( 'Default', 'larisdigital-wp' ),
			'3' => esc_html__( '3/12 Grid', 'larisdigital-wp' ),
			'4' => esc_html__( '4/12 Grid', 'larisdigital-wp' ),
			'5' => esc_html__( '5/12 Grid', 'larisdigital-wp' ),
			'6' => esc_html__( '6/12 Grid', 'larisdigital-wp' ),
		),
		'active_callback' => 'larisdigital_store_callback_product_sidebar_is_active',
	);

	$controls['larisdigital_store_product_content_width'] = array(
		'label'    => esc_html__( 'Content Width', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_store_product_content_width',
		'section'  => 'larisdigital_store_section_product',
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
		'active_callback' => 'larisdigital_store_callback_product_sidebar_is_not_active',
	);

	$controls['larisdigital_store_heading_product_layout'] = array(
		'label'    => esc_html__( 'Single Product Layout', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_store_heading_product_layout',
		'section'  => 'larisdigital_store_section_product',
		'type'     => 'heading',
	);

	$controls['larisdigital_store_product_layout'] = array(
		'label'				=> esc_html__( 'Single Product Layout', 'larisdigital-wp' ),
		'setting'			=> 'larisdigital_store_product_layout',
		'section'			=> 'larisdigital_store_section_product',
		'type'				=> 'radio',
		'choices'			=> array(
			''				=> esc_html__( 'Content (Left) + CallToAction (Right)', 'larisdigital-wp' ),
			'content-right'	=> esc_html__( 'CallToAction (Left) + Content (Right)', 'larisdigital-wp' ),
			'content-top'	=> esc_html__( 'One Column', 'larisdigital-wp' ),
		),
	);

	$controls['larisdigital_store_product_cta_width'] = array(
		'label'    => esc_html__( 'CallToAction Width', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_store_product_cta_width',
		'section'  => 'larisdigital_store_section_product',
		'type'     => 'select',
		'choices'  => array(
			'' => esc_html__( 'Default', 'larisdigital-wp' ),
			'3' => esc_html__( '3/12 Grid', 'larisdigital-wp' ),
			'4' => esc_html__( '4/12 Grid', 'larisdigital-wp' ),
			'5' => esc_html__( '5/12 Grid', 'larisdigital-wp' ),
			'6' => esc_html__( '6/12 Grid', 'larisdigital-wp' ),
		),
	);

	$controls['larisdigital_store_heading_product_elements'] = array(
		'label'    => esc_html__( 'Single Product Elements', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_store_heading_product_elements',
		'section'  => 'larisdigital_store_section_product',
		'type'     => 'heading',
	);

	$controls['larisdigital_store_product_saleflash_disable'] = array(
		'label'				=> esc_html__( 'DISABLE product sale flash badge', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_store_product_saleflash_disable',
		'section'			=> 'larisdigital_store_section_product',
		'type'				=> 'checkbox',
	);

	$controls['larisdigital_store_product_image_disable'] = array(
		'label'				=> esc_html__( 'DISABLE product image', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_store_product_image_disable',
		'section'			=> 'larisdigital_store_section_product',
		'type'				=> 'checkbox',
	);

	$controls['larisdigital_store_product_excerpt_disable'] = array(
		'label'				=> esc_html__( 'DISABLE product short description', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_store_product_excerpt_disable',
		'section'			=> 'larisdigital_store_section_product',
		'type'				=> 'checkbox',
	);

	$controls['larisdigital_store_product_price_disable'] = array(
		'label'				=> esc_html__( 'DISABLE product price', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_store_product_price_disable',
		'section'			=> 'larisdigital_store_section_product',
		'type'				=> 'checkbox',
	);

	$controls['larisdigital_store_product_button_disable'] = array(
		'label'				=> esc_html__( 'DISABLE product button', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_store_product_button_disable',
		'section'			=> 'larisdigital_store_section_product',
		'type'				=> 'checkbox',
	);

	$controls['larisdigital_store_heading_product_share'] = array(
		'label'    			=> esc_html__( 'Social Share', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_store_heading_product_share',
		'section'			=> 'larisdigital_store_section_product',
		'type'     			=> 'heading',
	);

	$controls['larisdigital_store_product_share'] = array(
		'label'    			=> esc_html__( 'Show social share after call to action', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_store_product_share',
		'section'			=> 'larisdigital_store_section_product',
		'type'     			=> 'checkbox',
	);

	$controls['larisdigital_store_product_share_items'] = array(
		'label'    			=> esc_html__( 'Social Share Items', 'larisdigital-wp' ),
		'setting'  			=> 'larisdigital_store_product_share_items',
		'section'			=> 'larisdigital_store_section_product',
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
		'active_callback' 	=> 'larisdigital_store_callback_product_share_is_active',
	);

	return $controls;
}

function larisdigital_store_callback_header_product_is_active() {
	return ( larisdigital_theme_mod( 'larisdigital_store_header_hide' ) || larisdigital_theme_mod( 'larisdigital_store_product_header_hide' ) ) ? false : true;
}

function larisdigital_store_callback_shop_sidebar_is_active() {
	$layout = larisdigital_theme_mod( 'larisdigital_store_shop_sidebar_layout' );
	return ( 'none' != $layout ) ? true : false;
}

function larisdigital_store_callback_shop_sidebar_is_not_active() {
	$layout = larisdigital_theme_mod( 'larisdigital_store_shop_sidebar_layout' );
	return ( 'none' == $layout ) ? true : false;
}

function larisdigital_store_callback_product_sidebar_is_active() {
	$layout = larisdigital_theme_mod( 'larisdigital_store_product_sidebar_layout' );
	return ( 'none' != $layout ) ? true : false;
}

function larisdigital_store_callback_product_sidebar_is_not_active() {
	$layout = larisdigital_theme_mod( 'larisdigital_store_product_sidebar_layout' );
	return ( 'none' == $layout ) ? true : false;
}

function larisdigital_store_callback_product_share_is_active() {
	return larisdigital_theme_mod( 'larisdigital_store_product_share' ) ? true : false;
}

add_action( 'customize_controls_print_scripts', 'larisdigital_store_customize_print_scripts', 30 );
function larisdigital_store_customize_print_scripts() {
	$shop_page = get_post_type_archive_link( 'product' );

	$shop_section = apply_filters( 'larisdigital_store_customize_preview_shop', array(
		'larisdigital_store_section_general' => 'larisdigital_store_section_general',
		'larisdigital_store_section_shop' => 'larisdigital_store_section_shop',
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
} );
</script>
<?php
}

add_action( 'customize_controls_print_scripts', 'larisdigital_store_customize_scripts_preview_product', 30 );
function larisdigital_store_customize_scripts_preview_product() {
	$product_ids = get_posts( array(
		'posts_per_page' => 1,
		'post_type' => 'product',
		'orderby' => 'date',
		'order' => 'ASC',
		'meta_query' => array(
			// array(
			// 	'key'     => '_layout_custom',
			// 	'value'   => '',
			// 	'compare' => 'NOT EXISTS',
			// ),
			array(
				'key'     => '_elementor_edit_mode',
				'value'   => '',
				'compare' => 'NOT EXISTS',
			),
			// array(
			// 	'key'     => '_wp_page_template',
			// 	'value'   => '',
			// 	'compare' => 'NOT EXISTS',
			// ),
		),
		'fields' => 'ids',
	) );
	$product_url = !empty( $product_ids ) ? get_permalink( reset( $product_ids ) ) : '';
	$product_section = apply_filters( 'larisdigital_store_customize_preview_product', array(
		'larisdigital_store_section_product' => 'larisdigital_store_section_product',
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
