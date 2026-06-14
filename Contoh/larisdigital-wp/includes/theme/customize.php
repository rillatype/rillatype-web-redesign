<?php
/**
 * Theme Customizer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_action( 'customize_register', 'larisdigital_customize_reposition_options', 20 );
function larisdigital_customize_reposition_options( $wp_customize ) {
	$title = $wp_customize->get_section( 'title_tagline' )->title;
	$wp_customize->get_section( 'title_tagline' )->title = $title.' &amp; '.esc_html__( 'Favicon', 'larisdigital-wp' );
	$wp_customize->get_section( 'title_tagline' )->priority = 5;

	$wp_customize->get_section( 'static_front_page' )->priority = 7;

	$site_icon = $wp_customize->get_control( 'site_icon' )->label;
	$wp_customize->get_control( 'site_icon' )->label = $site_icon.' / '.esc_html__( 'Favicon', 'larisdigital-wp' );

	$wp_customize->get_section( 'background_image' )->title = esc_html__( 'Background', 'larisdigital-wp' );
	$wp_customize->get_control( 'background_color' )->section = 'background_image';
 
	$wp_customize->get_section( 'header_image' )->panel = 'larisdigital_panel_settings';
	$wp_customize->get_section( 'header_image' )->priority = 20;
	$wp_customize->remove_control( 'header_textcolor' );
	$wp_customize->remove_control( 'display_header_text' );
	$wp_customize->get_control( 'header_image' )->section = 'larisdigital_section_header';
	$wp_customize->get_control( 'header_image' )->priority = 5;
	$wp_customize->get_control( 'header_image' )->active_callback = 'larisdigital_callback_header_image_is_allowed';
}

add_filter( 'larisdigital_customize_controls', 'larisdigital_customize_controls_browser_color' );
function larisdigital_customize_controls_browser_color( $controls ) {

	$controls['larisdigital_heading_browser_color'] = array(
		'label'    => esc_html__( 'Mobile Browser Tab Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_browser_color',
		'section'  => 'title_tagline',
		'type'     => 'heading',
		'priority' => 51,
	);

	$controls['larisdigital_browser_theme_color'] = array(
		'label'    => esc_html__( 'Mobile Browser Tab Color', 'larisdigital-wp' ),
		'description' => 'Chrome, Firefox OS, Opera, Windows Phone',
		'setting'  => 'larisdigital_browser_theme_color',
		'section'  => 'title_tagline',
		'type'     => 'color',
		'priority' => 51,
	);

	$controls['larisdigital_browser_safari_uic_hide'] = array(
		'label'    => esc_html__( 'Hide Mobile Safari User Interface Components', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_browser_safari_uic_hide',
		'section'  => 'title_tagline',
		'type'     => 'checkbox',
		'priority' => 51,
	);

	return $controls;
}

add_filter( 'larisdigital_customize_controls', 'larisdigital_customize_controls_favicon' );
function larisdigital_customize_controls_favicon( $controls ) {

	$controls['larisdigital_heading_favicon'] = array(
		'label'    => esc_html__( 'Favicon', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_favicon',
		'section'  => 'title_tagline',
		'type'     => 'heading',
		'priority' => 59,
	);

	return $controls;
}

add_filter( 'larisdigital_customize_controls', 'larisdigital_customize_controls_panel_general' );
function larisdigital_customize_controls_panel_general( $controls ) {

	$controls['larisdigital_panel_settings'] = array(
		'title'    => esc_html__( 'Theme Settings - General', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_panel_settings',
		'type'     => 'panel',
		'priority' => 13,
	);

	return $controls;
}

add_filter( 'larisdigital_customize_controls', 'larisdigital_customize_controls_typography' );
function larisdigital_customize_controls_typography( $controls ) {

	$controls['larisdigital_section_typography'] = array(
		'title'    => esc_html__( 'Typography', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_section_typography',
		'panel'    => 'larisdigital_panel_settings',
		'type'     => 'section',
		'priority' => 10,
	);

	$controls['larisdigital_heading_body'] = array(
		'label'    => esc_html__( 'Body Text', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_body',
		'section'  => 'larisdigital_section_typography',
		'type'     => 'heading',
	);

	$controls['larisdigital_body_color'] = array(
		'label'    => esc_html__( 'Text Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_body_color',
		'section'  => 'larisdigital_section_typography',
		'type'     => 'color',
		'style'    => 'body, button, input, select, textarea { color: [value] }',
	);

	$controls['larisdigital_body_font'] = array(
		'label'    => esc_html__( 'Body Font Family', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_body_font',
		'section'  => 'larisdigital_section_typography',
		'type'     => 'font',
		'selector' => 'body,.site-description',
	);

	$controls['larisdigital_body_font_size'] = array(
		'label'    => esc_html__( 'Body Font Size', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_body_font_size',
		'section'  => 'larisdigital_section_typography',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 0.5,
			'max' => 2,
			'step' => 0.1,
			'unit' => 'rem',
		),
		'style'    => 'body { font-size: [value]rem; }',
	);

	$controls['larisdigital_body_font_weight'] = array(
		'label'    => esc_html__( 'Body Font Weight', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_body_font_weight',
		'section'  => 'larisdigital_section_typography',
		'type'     => 'select',
		'choices'  => array(
			''     => esc_html__( 'default', 'larisdigital-wp' ),
			'100'  => '100',
			'200'  => '200',
			'300'  => '300',
			'400'  => '400',
			'500'  => '500',
		),
		'style'    => 'body { font-weight: [value]; }',
		'transport' => 'refresh'
	);

	$controls['larisdigital_heading_link'] = array(
		'label'    => esc_html__( 'Link Text', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_link',
		'section'  => 'larisdigital_section_typography',
		'type'     => 'heading',
	);

	$controls['larisdigital_link_color'] = array(
		'label'    => esc_html__( 'Link Text Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_link_color',
		'section'  => 'larisdigital_section_typography',
		'type'     => 'color',
		'style'    => 'a { color: [value] }',
	);

	$controls['larisdigital_link_color_hover'] = array(
		'label'    => esc_html__( 'Link Text Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_link_color_hover',
		'section'  => 'larisdigital_section_typography',
		'type'     => 'color',
		'style'    => 'a:hover { color: [value] }',
	);

	$controls['larisdigital_heading_heading'] = array(
		'label'    => esc_html__( 'Heading Text', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_heading',
		'section'  => 'larisdigital_section_typography',
		'type'     => 'heading',
	);

	$controls['larisdigital_heading_color'] = array(
		'label'    => esc_html__( 'Heading Text Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_color',
		'section'  => 'larisdigital_section_typography',
		'type'     => 'color',
		'style'    => 'h1,h2,h3,h4,h5 { color: [value] }',
	);

	$controls['larisdigital_heading_font'] = array(
		'label'    => esc_html__( 'Heading Font Family', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_font',
		'section'  => 'larisdigital_section_typography',
		'type'     => 'font',
		'selector' => '.h1,.h2,.h3,.h4,.h5,.h6,h1,h2,h3,h4,h5,h6,.site-title',
	);

	$controls['larisdigital_heading1_font_size'] = array(
		'label'    => esc_html__( 'Heading H1 Font Size', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading1_font_size',
		'section'  => 'larisdigital_section_typography',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 0.5,
			'max' => 4,
			'step' => 0.1,
			'unit' => 'rem',
		),
		'style'    => '.h1, h1 { font-size: [value]rem }',
	);

	$font_weight_options = array(
			''     => esc_html__( 'default', 'larisdigital-wp' ),
			'100'  => '100',
			'200'  => '200',
			'300'  => '300',
			'400'  => '400',
			'500'  => '500',
			'600'  => '600',
			'700'  => '700',
			'800'  => '800',
			'900'  => '900',
			'1000'  => '1000',
		);

	$controls['larisdigital_heading1_font_weight'] = array(
		'label'    => esc_html__( 'Heading H1 Font Weight', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading1_font_weight',
		'section'  => 'larisdigital_section_typography',
		'type'     => 'select',
		'choices'  => $font_weight_options,
		'style'    => '.h1, h1 { font-weight: [value]; }',
		'transport' => 'refresh'
	);

	$controls['larisdigital_heading2_font_size'] = array(
		'label'    => esc_html__( 'Heading H2 Font Size', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading2_font_size',
		'section'  => 'larisdigital_section_typography',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 0.5,
			'max' => 4,
			'step' => 0.1,
			'unit' => 'rem',
		),
		'style'    => '.h2, h2 { font-size: [value]rem }',
	);

	$controls['larisdigital_heading2_font_weight'] = array(
		'label'    => esc_html__( 'Heading H2 Font Weight', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading2_font_weight',
		'section'  => 'larisdigital_section_typography',
		'type'     => 'select',
		'choices'  => $font_weight_options,
		'style'    => '.h2, h2 { font-weight: [value]; }',
		'transport' => 'refresh'
	);

	$controls['larisdigital_heading3_font_size'] = array(
		'label'    => esc_html__( 'Heading H3 Font Size', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading3_font_size',
		'section'  => 'larisdigital_section_typography',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 0.5,
			'max' => 4,
			'step' => 0.1,
			'unit' => 'rem',
		),
		'style'    => '.h3, h3 { font-size: [value]rem }',
	);

	$controls['larisdigital_heading3_font_weight'] = array(
		'label'    => esc_html__( 'Heading H3 Font Weight', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading3_font_weight',
		'section'  => 'larisdigital_section_typography',
		'type'     => 'select',
		'choices'  => $font_weight_options,
		'style'    => '.h3, h3 { font-weight: [value]; }',
		'transport' => 'refresh'
	);

	$controls['larisdigital_heading4_font_size'] = array(
		'label'    => esc_html__( 'Heading H4 Font Size', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading4_font_size',
		'section'  => 'larisdigital_section_typography',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 0.5,
			'max' => 4,
			'step' => 0.1,
			'unit' => 'rem',
		),
		'style'    => '.h4, h4 { font-size: [value]rem }',
	);

	$controls['larisdigital_heading4_font_weight'] = array(
		'label'    => esc_html__( 'Heading H4 Font Weight', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading4_font_weight',
		'section'  => 'larisdigital_section_typography',
		'type'     => 'select',
		'choices'  => $font_weight_options,
		'style'    => '.h4, h4 { font-weight: [value]; }',
		'transport' => 'refresh'
	);

	$controls['larisdigital_heading5_font_size'] = array(
		'label'    => esc_html__( 'Heading H5 Font Size', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading5_font_size',
		'section'  => 'larisdigital_section_typography',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 0.5,
			'max' => 4,
			'step' => 0.1,
			'unit' => 'rem',
		),
		'style'    => '.h5, h5 { font-size: [value]rem }',
	);

	$controls['larisdigital_heading5_font_weight'] = array(
		'label'    => esc_html__( 'Heading H5 Font Weight', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading5_font_weight',
		'section'  => 'larisdigital_section_typography',
		'type'     => 'select',
		'choices'  => $font_weight_options,
		'style'    => '.h5, h5 { font-weight: [value]; }',
		'transport' => 'refresh'
	);

	$controls['larisdigital_heading6_font_size'] = array(
		'label'    => esc_html__( 'Heading H6 Font Size', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading6_font_size',
		'section'  => 'larisdigital_section_typography',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 0.5,
			'max' => 4,
			'step' => 0.1,
			'unit' => 'rem',
		),
		'style'    => '.h6, h6 { font-size: [value]rem }',
	);

	$controls['larisdigital_heading6_font_weight'] = array(
		'label'    => esc_html__( 'Heading H6 Font Weight', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading6_font_weight',
		'section'  => 'larisdigital_section_typography',
		'type'     => 'select',
		'choices'  => $font_weight_options,
		'style'    => '.h6, h6 { font-weight: [value]; }',
		'transport' => 'refresh'
	);

	return $controls;
}

add_filter( 'larisdigital_customize_controls', 'larisdigital_customize_controls_general' );
function larisdigital_customize_controls_general( $controls ) {

	$controls['larisdigital_section_general'] = array(
		'title'    => esc_html__( 'General', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_section_general',
		'panel'    => 'larisdigital_panel_settings',
		'type'     => 'section',
		'priority' => 20,
	);

	$controls['larisdigital_wc_heading_button_basic'] = array(
		'label'    => esc_html__( 'Basic Button Style', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_wc_heading_button_basic',
		'section'  => 'larisdigital_section_general',
		'type'     => 'heading',
	);

	$controls['larisdigital_button_basic_background'] = array(
		'label'    => esc_html__( 'Background Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_button_basic_background',
		'section'  => 'larisdigital_section_general',
		'type'     => 'color',
		'style'    => 'button, input[type="button"], input[type="reset"], input[type="submit"] { background-color: [value] }',
	);

	$controls['larisdigital_button_basic_border'] = array(
		'label'    => esc_html__( 'Border Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_button_basic_border',
		'section'  => 'larisdigital_section_general',
		'type'     => 'color',
		'style'    => 'button, input[type="button"], input[type="reset"], input[type="submit"] { border-color: [value] }',
	);

	$controls['larisdigital_button_basic_color'] = array(
		'label'    => esc_html__( 'Text Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_button_basic_color',
		'section'  => 'larisdigital_section_general',
		'type'     => 'color',
		'style'    => 'button, input[type="button"], input[type="reset"], input[type="submit"] { color: [value] }',
	);

	$controls['larisdigital_button_basic_background_hover'] = array(
		'label'    => esc_html__( 'Background Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_button_basic_background_hover',
		'section'  => 'larisdigital_section_general',
		'type'     => 'color',
		'style'    => 'button:hover, input[type="button"]:hover, input[type="reset"]:hover, input[type="submit"]:hover { background-color: [value] }',
	);

	$controls['larisdigital_button_basic_border_hover'] = array(
		'label'    => esc_html__( 'Border Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_button_basic_border_hover',
		'section'  => 'larisdigital_section_general',
		'type'     => 'color',
		'style'    => 'button:hover, input[type="button"]:hover, input[type="reset"]:hover, input[type="submit"]:hover { border-color: [value] }',
	);

	$controls['larisdigital_button_basic_color_hover'] = array(
		'label'    => esc_html__( 'Text Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_button_basic_color_hover',
		'section'  => 'larisdigital_section_general',
		'type'     => 'color',
		'style'    => 'button:hover, input[type="button"]:hover, input[type="reset"]:hover, input[type="submit"]:hover { color: [value] }',
	);

	$controls['larisdigital_wc_heading_button_primary'] = array(
		'label'    => esc_html__( 'Primary Button (Bootstrap4)', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_wc_heading_button_primary',
		'section'  => 'larisdigital_section_general',
		'type'     => 'heading',
	);

	$controls['larisdigital_button_primary_background'] = array(
		'label'    => esc_html__( 'Background Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_button_primary_background',
		'section'  => 'larisdigital_section_general',
		'type'     => 'color',
		'style'    => '.btn-primary, a.btn-primary { background-color: [value] }',
	);

	$controls['larisdigital_button_primary_border'] = array(
		'label'    => esc_html__( 'Border Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_button_primary_border',
		'section'  => 'larisdigital_section_general',
		'type'     => 'color',
		'style'    => '.btn-primary, a.btn-primary { border-color: [value] }',
	);

	$controls['larisdigital_button_primary_color'] = array(
		'label'    => esc_html__( 'Text Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_button_primary_color',
		'section'  => 'larisdigital_section_general',
		'type'     => 'color',
		'style'    => '.btn-primary, a.btn-primary { color: [value] }',
	);

	$controls['larisdigital_button_primary_background_hover'] = array(
		'label'    => esc_html__( 'Background Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_button_primary_background_hover',
		'section'  => 'larisdigital_section_general',
		'type'     => 'color',
		'style'    => '.btn-primary:hover, a.btn-primary:hover { background-color: [value] }',
	);

	$controls['larisdigital_button_primary_border_hover'] = array(
		'label'    => esc_html__( 'Border Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_button_primary_border_hover',
		'section'  => 'larisdigital_section_general',
		'type'     => 'color',
		'style'    => '.btn-primary:hover, a.btn-primary:hover { border-color: [value] }',
	);

	$controls['larisdigital_button_primary_color_hover'] = array(
		'label'    => esc_html__( 'Text Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_button_primary_color_hover',
		'section'  => 'larisdigital_section_general',
		'type'     => 'color',
		'style'    => '.btn-primary:hover, a.btn-primary:hover { color: [value] }',
	);

	$controls['larisdigital_wc_heading_button_secondary'] = array(
		'label'    => esc_html__( 'Secondary Button (Bootstrap4)', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_wc_heading_button_secondary',
		'section'  => 'larisdigital_section_general',
		'type'     => 'heading',
	);

	$controls['larisdigital_button_secondary_background'] = array(
		'label'    => esc_html__( 'Background Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_button_secondary_background',
		'section'  => 'larisdigital_section_general',
		'type'     => 'color',
		'style'    => '.btn-secondary, a.btn-secondary { background-color: [value] }',
	);

	$controls['larisdigital_button_secondary_border'] = array(
		'label'    => esc_html__( 'Border Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_button_secondary_border',
		'section'  => 'larisdigital_section_general',
		'type'     => 'color',
		'style'    => '.btn-secondary, a.btn-secondary { border-color: [value] }',
	);

	$controls['larisdigital_button_secondary_color'] = array(
		'label'    => esc_html__( 'Text Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_button_secondary_color',
		'section'  => 'larisdigital_section_general',
		'type'     => 'color',
		'style'    => '.btn-secondary, a.btn-secondary { color: [value] }',
	);

	$controls['larisdigital_button_secondary_background_hover'] = array(
		'label'    => esc_html__( 'Background Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_button_secondary_background_hover',
		'section'  => 'larisdigital_section_general',
		'type'     => 'color',
		'style'    => '.btn-secondary:hover, a.btn-secondary:hover { background-color: [value] }',
	);

	$controls['larisdigital_button_secondary_border_hover'] = array(
		'label'    => esc_html__( 'Border Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_button_secondary_border_hover',
		'section'  => 'larisdigital_section_general',
		'type'     => 'color',
		'style'    => '.btn-secondary:hover, a.btn-secondary:hover { border-color: [value] }',
	);

	$controls['larisdigital_button_secondary_color_hover'] = array(
		'label'    => esc_html__( 'Text Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_button_secondary_color_hover',
		'section'  => 'larisdigital_section_general',
		'type'     => 'color',
		'style'    => '.btn-secondary:hover, a.btn-secondary:hover { color: [value] }',
	);

	$controls['larisdigital_heading_searchform'] = array(
		'label'    => esc_html__( 'Search Form', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_searchform',
		'section'  => 'larisdigital_section_general',
		'type'     => 'heading',
	);

	$controls['larisdigital_searchform_background'] = array(
		'label'    => esc_html__( 'Background Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_searchform_background',
		'section'  => 'larisdigital_section_general',
		'type'     => 'color',
		'style'    => '.search-form .search-field { background-color: [value] }',
	);

	$controls['larisdigital_searchform_border'] = array(
		'label'    => esc_html__( 'Border Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_searchform_border',
		'section'  => 'larisdigital_section_general',
		'type'     => 'color',
		'style'    => '.search-form .search-field { border-color: [value] }',
	);

	$controls['larisdigital_searchform_color'] = array(
		'label'    => esc_html__( 'Text Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_searchform_color',
		'section'  => 'larisdigital_section_general',
		'type'     => 'color',
		'style'    => '.search-form .search-field { color: [value] }',
	);

	$controls['larisdigital_searchform_placeholder'] = array(
		'label'    => esc_html__( 'Placeholder Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_searchform_placeholder',
		'section'  => 'larisdigital_section_general',
		'type'     => 'color',
		'style'    => '.search-form .search-field::-webkit-input-placeholder { color: [value] } .search-form .search-field:-ms-input-placeholder { color: [value] } .search-form .search-field::-ms-input-placeholder { color: [value] } .search-form .search-field::placeholder { color: [value] }',
	);

	$controls['larisdigital_searchform_button_background'] = array(
		'label'    => esc_html__( 'Button', 'larisdigital-wp' ).' '.esc_html__( 'Background Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_searchform_button_background',
		'section'  => 'larisdigital_section_general',
		'type'     => 'color',
		'style'    => '.search-form .search-submit, .search-form .search-submit:hover { background-color: [value]; border-color: [value] }',
	);

	$controls['larisdigital_searchform_button_color'] = array(
		'label'    => esc_html__( 'Button', 'larisdigital-wp' ).' '.esc_html__( 'Text Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_searchform_button_color',
		'section'  => 'larisdigital_section_general',
		'type'     => 'color',
		'style'    => '.search-form .search-submit, .search-form .search-submit:hover { color: [value] }',
	);

	$controls['larisdigital_heading_pagination'] = array(
		'label'    => esc_html__( 'Pagination Style', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_pagination',
		'section'  => 'larisdigital_section_general',
		'type'     => 'heading',
	);

	$controls['larisdigital_pagination_alignment'] = array(
		'label'    => esc_html__( 'Alignment', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_pagination_alignment',
		'section'  => 'larisdigital_section_general',
		'type'     => 'radio-iconset',
		'choices'  => array(
			'left' => 'dashicons dashicons-editor-alignleft',
			'center' => 'dashicons dashicons-editor-aligncenter',
			'right' => 'dashicons dashicons-editor-alignright',
		),
	);

	$controls['larisdigital_pagination_link_color'] = array(
		'label'    => esc_html__( 'Link Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_pagination_link_color',
		'section'  => 'larisdigital_section_general',
		'type'     => 'color',
		'style'    => '.pagination .page-link { color: [value] }',
	);

	$controls['larisdigital_pagination_link_background'] = array(
		'label'    => esc_html__( 'Background Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_pagination_link_background',
		'section'  => 'larisdigital_section_general',
		'type'     => 'color',
		'style'    => '.pagination .page-link { background-color: [value] }',
	);

	$controls['larisdigital_pagination_link_border'] = array(
		'label'    => esc_html__( 'Border Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_pagination_link_border',
		'section'  => 'larisdigital_section_general',
		'type'     => 'color',
		'style'    => '.pagination .page-link { border-color: [value] }',
	);

	$controls['larisdigital_pagination_link_color_active'] = array(
		'label'    => esc_html__( 'Link Color', 'larisdigital-wp' ).' '.esc_html__( '(Active)', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_pagination_link_color_active',
		'section'  => 'larisdigital_section_general',
		'type'     => 'color',
		'style'    => '.pagination .page-item.active .page-link { color: [value] }',
	);

	$controls['larisdigital_pagination_link_background_active'] = array(
		'label'    => esc_html__( 'Background Color', 'larisdigital-wp' ).' '.esc_html__( '(Active)', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_pagination_link_background_active',
		'section'  => 'larisdigital_section_general',
		'type'     => 'color',
		'style'    => '.pagination .page-item.active .page-link { background-color: [value] }',
	);

	$controls['larisdigital_pagination_link_border_active'] = array(
		'label'    => esc_html__( 'Border Color', 'larisdigital-wp' ).' '.esc_html__( '(Active)', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_pagination_link_border_active',
		'section'  => 'larisdigital_section_general',
		'type'     => 'color',
		'style'    => '.pagination .page-item.active .page-link { border-color: [value] }',
	);

	$controls['larisdigital_pagination_link_color_disabled'] = array(
		'label'    => esc_html__( 'Link Color', 'larisdigital-wp' ).' '.esc_html__( '(Disabled)', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_pagination_link_color_disabled',
		'section'  => 'larisdigital_section_general',
		'type'     => 'color',
		'style'    => '.pagination .page-item.disabled .page-link { color: [value] }',
	);

	$controls['larisdigital_pagination_link_background_disabled'] = array(
		'label'    => esc_html__( 'Background Color', 'larisdigital-wp' ).' '.esc_html__( '(Disabled)', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_pagination_link_background_disabled',
		'section'  => 'larisdigital_section_general',
		'type'     => 'color',
		'style'    => '.pagination .page-item.disabled .page-link { background-color: [value] }',
	);

	$controls['larisdigital_pagination_link_border_disabled'] = array(
		'label'    => esc_html__( 'Border Color', 'larisdigital-wp' ).' '.esc_html__( '(Disabled)', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_pagination_link_border_disabled',
		'section'  => 'larisdigital_section_general',
		'type'     => 'color',
		'style'    => '.pagination .page-item.disabled .page-link { border-color: [value] }',
	);

	return $controls;
}

add_filter( 'larisdigital_customize_controls', 'larisdigital_customize_controls_topbar' );
function larisdigital_customize_controls_topbar( $controls ) {

	$controls['larisdigital_section_topbar'] = array(
		'title'    => esc_html__( 'Site Top Bar', 'larisdigital-wp' ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-success larisdigital-alert-with-icon">
							<span class="dashicons dashicons-megaphone"></span> '.sprintf( esc_html__( '%s can be disabled on a post/page using "%s" metabox when editing a post/page', 'larisdigital-wp' ), esc_html__( 'Site Top Bar', 'larisdigital-wp' ), esc_html__( 'Page Layout', 'larisdigital-wp' ) ).'
							</p>',
		'setting'  => 'larisdigital_section_topbar',
		'panel'    => 'larisdigital_panel_settings',
		'type'     => 'section',
		'priority' => 110,
	);

	$controls['larisdigital_topbar_hide'] = array(
		'label'    => sprintf( esc_html__( 'HIDE %s Globally', 'larisdigital-wp' ), esc_html__( 'Site Top Bar', 'larisdigital-wp' ) ),
		'setting'  => 'larisdigital_topbar_hide',
		'section'  => 'larisdigital_section_topbar',
		'type'     => 'checkbox',
	);

	$controls['larisdigital_topbar_background'] = array(
		'label'    => esc_html__( 'Background Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_topbar_background',
		'section'  => 'larisdigital_section_topbar',
		'type'     => 'color',
		'style'    => '.site-topbar { background-color: [value] }',
		'active_callback' => 'larisdigital_callback_topbar_is_active',
	);

	$controls['larisdigital_heading_topbar_layout'] = array(
		'label'    => esc_html__( 'Layout', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_topbar_layout',
		'section'  => 'larisdigital_section_topbar',
		'type'     => 'heading',
		'active_callback' => 'larisdigital_callback_topbar_is_active',
	);

	$controls['larisdigital_topbar_layout'] = array(
		'label'    => esc_html__( 'Layout', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_topbar_layout',
		'section'  => 'larisdigital_section_topbar',
		'type'     => 'radio',
		'choices'  => array(
			'right-left' => esc_html__( 'Text (Left) & Menu (Right)', 'larisdigital-wp' ),
			'left-right' => esc_html__( 'Menu (Left) & Text (Right)', 'larisdigital-wp' ),
			'center' => esc_html__( 'Menu & Text (Center)', 'larisdigital-wp' ),
			'center-flip' => esc_html__( 'Text & Menu (Center)', 'larisdigital-wp' ),
		),
		'active_callback' => 'larisdigital_callback_topbar_is_active',
	);

	$controls['larisdigital_topbar_color'] = array(
		'label'    => esc_html__( 'Text Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_topbar_color',
		'section'  => 'larisdigital_section_topbar',
		'type'     => 'color',
		'style'    => '.site-topbar { color: [value] }',
		'active_callback' => 'larisdigital_callback_topbar_is_active',
	);

	$controls['larisdigital_topbar_link'] = array(
		'label'    => esc_html__( 'Link Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_topbar_link',
		'section'  => 'larisdigital_section_topbar',
		'type'     => 'color',
		'style'    => '.site-topbar a { color: [value] }',
		'active_callback' => 'larisdigital_callback_topbar_is_active',
	);

	$controls['larisdigital_topbar_link_hover'] = array(
		'label'    => esc_html__( 'Link Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_topbar_link_hover',
		'section'  => 'larisdigital_section_topbar',
		'type'     => 'color',
		'style'    => '.site-topbar a:hover { color: [value] }',
		'active_callback' => 'larisdigital_callback_topbar_is_active',
	);

	$controls['larisdigital_topbar_font_size'] = array(
		'label'    => esc_html__( 'Font Size', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_topbar_font_size',
		'section'  => 'larisdigital_section_topbar',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 0.5,
			'max' => 2,
			'step' => 0.1,
			'unit' => 'rem',
		),
		'style'    => '.site-topbar { font-size: [value]rem }',
		'active_callback' => 'larisdigital_callback_topbar_is_active',
	);

	$controls['larisdigital_heading_topbar_menu'] = array(
		'label'    => esc_html__( 'Menu', 'larisdigital-wp' ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-with-icon"><span class="dashicons dashicons-admin-appearance"></span> <a href="javascript:wp.customize.section( \'menu_locations\' ).focus();">' . sprintf( esc_html__( 'CLICK HERE to setup %s', 'larisdigital-wp' ), esc_html__( 'Site Top Bar Menu', 'larisdigital-wp' ) ) . '</a></p>',
		'setting'  => 'larisdigital_heading_topbar_menu',
		'section'  => 'larisdigital_section_topbar',
		'type'     => 'heading',
		'active_callback' => 'larisdigital_callback_topbar_is_active',
	);

	$controls['larisdigital_topbar_menu_hide'] = array(
		'label'    => sprintf( esc_html__( 'HIDE %s', 'larisdigital-wp' ), esc_html__( 'Menu', 'larisdigital-wp' ) ),
		'setting'  => 'larisdigital_topbar_menu_hide',
		'section'  => 'larisdigital_section_topbar',
		'type'     => 'checkbox',
		'active_callback' => 'larisdigital_callback_topbar_is_active',
	);

	$controls['larisdigital_heading_topbar_text'] = array(
		'label'    => esc_html__( 'Text', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_topbar_text',
		'section'  => 'larisdigital_section_topbar',
		'type'     => 'heading',
		'active_callback' => 'larisdigital_callback_topbar_is_active',
	);

	$controls['larisdigital_topbar_text'] = array(
		'label'    => esc_html__( 'Text', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_topbar_text',
		'section'  => 'larisdigital_section_topbar',
		'type'     => 'textarea-html',
		'active_callback' => 'larisdigital_callback_topbar_is_active',
	);

	$controls['larisdigital_topbar_text_hide'] = array(
		'label'    => sprintf( esc_html__( 'HIDE %s', 'larisdigital-wp' ), esc_html__( 'Text', 'larisdigital-wp' ) ),
		'setting'  => 'larisdigital_topbar_text_hide',
		'section'  => 'larisdigital_section_topbar',
		'type'     => 'checkbox',
		'active_callback' => 'larisdigital_callback_topbar_is_active',
	);

	$controls['larisdigital_heading_topbar_padding'] = array(
		'label'    => esc_html__( 'Custom Padding', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_topbar_padding',
		'section'  => 'larisdigital_section_topbar',
		'type'     => 'heading',
		'active_callback' => 'larisdigital_callback_topbar_is_active',
	);

	$controls['larisdigital_topbar_padding_top'] = array(
		'label'    => esc_html__( 'Top Padding', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_topbar_padding_top',
		'section'  => 'larisdigital_section_topbar',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 0,
			'max' => 7,
			'step' => 0.1,
			'unit' => 'rem',
		),
		'style'    => '.site-topbar { padding-top: [value]rem; } ',
		'active_callback' => 'larisdigital_callback_topbar_is_active',
	);

	$controls['larisdigital_topbar_padding_bottom'] = array(
		'label'    => esc_html__( 'Bottom Padding', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_topbar_padding_bottom',
		'section'  => 'larisdigital_section_topbar',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 0,
			'max' => 7,
			'step' => 0.1,
			'unit' => 'rem',
		),
		'style'    => '.site-topbar { padding-bottom: [value]rem; } ',
		'active_callback' => 'larisdigital_callback_topbar_is_active',
	);

	return $controls;
}

add_filter( 'larisdigital_customize_controls', 'larisdigital_customize_controls_navigation' );
function larisdigital_customize_controls_navigation( $controls ) {

	$controls['larisdigital_section_navigation'] = array(
		'title'    => esc_html__( 'Site Header Navigation (Menu)', 'larisdigital-wp' ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-success larisdigital-alert-with-icon">
							<span class="dashicons dashicons-megaphone"></span> '.sprintf( esc_html__( '%s can be disabled on a post/page using "%s" metabox when editing a post/page', 'larisdigital-wp' ), esc_html__( 'Site Header Navigation (Menu)', 'larisdigital-wp' ), esc_html__( 'Page Layout', 'larisdigital-wp' ) ).'
							</p>',
		'setting'  => 'larisdigital_section_navigation',
		'panel'    => 'larisdigital_panel_settings',
		'type'     => 'section',
		'priority' => 120,
	);

	$controls['larisdigital_navigation_hide'] = array(
		'label'    => sprintf( esc_html__( 'HIDE %s Globally', 'larisdigital-wp' ), esc_html__( 'Site Header Navigation (Menu)', 'larisdigital-wp' ) ),
		'setting'  => 'larisdigital_navigation_hide',
		'section'  => 'larisdigital_section_navigation',
		'type'     => 'checkbox',
	);

	$controls['larisdigital_navigation_absolute'] = array(
		'label'    => esc_html__( 'Absolute Positioned Navigation', 'larisdigital-wp' ),
		'description' => esc_html__( 'It is useful when you want to blend site navigation to site header (transparent header menu).', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_navigation_absolute',
		'section'  => 'larisdigital_section_navigation',
		'type'     => 'checkbox',
		'active_callback' => 'larisdigital_callback_navigation_is_active',
	);

	$controls['larisdigital_heading_navigation_scheme'] = array(
		'label'    => esc_html__( 'Color Scheme', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_navigation_scheme',
		'section'  => 'larisdigital_section_navigation',
		'type'     => 'heading',
		'active_callback' => 'larisdigital_callback_navigation_is_active',
		'priority' => 20,
	);

	$controls['larisdigital_navigation_scheme'] = array(
		'label'    => esc_html__( 'Color Scheme', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_navigation_scheme',
		'section'  => 'larisdigital_section_navigation',
		'type'     => 'radio-buttonset',
		'choices'  => array(
			'dark' => esc_html__( 'dark', 'larisdigital-wp' ),
			'light' => esc_html__( 'light', 'larisdigital-wp' ),
		),
		'active_callback' =>'larisdigital_callback_navigation_is_active',
		'priority' => 20,
	);

	$controls['larisdigital_navigation_background'] = array(
		'label'    => esc_html__( 'Background Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_navigation_background',
		'section'  => 'larisdigital_section_navigation',
		'type'     => 'color',
		'style'    => '.site-navigation { background-color: [value] !important; }',
		'active_callback' => 'larisdigital_callback_navigation_is_active',
		'priority' => 25,
	);

	$controls['larisdigital_heading_navigation_sticky'] = array(
		'label'    => esc_html__( 'Sticky', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_navigation_sticky',
		'section'  => 'larisdigital_section_navigation',
		'type'     => 'heading',
		'active_callback' => 'larisdigital_callback_navigation_is_active',
		'priority' => 30,
	);

	$controls['larisdigital_navigation_sticky'] = array(
		'label'    => esc_html__( 'Sticky', 'larisdigital-wp' ),
		'description' => esc_html__( 'Stay on top when user is scrolling.', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_navigation_sticky',
		'section'  => 'larisdigital_section_navigation',
		'type'     => 'radio-buttonset',
		'choices'  => array(
			'yes' => esc_html__( 'Yes', 'larisdigital-wp' ),
			'no' => esc_html__( 'No', 'larisdigital-wp' ),
		),
		'active_callback' => 'larisdigital_callback_navigation_is_active',
		'priority' => 30,
	);

	$controls['larisdigital_navigation_background_sticky'] = array(
		'label'    => esc_html__( 'Sticky Background Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_navigation_background_sticky',
		'section'  => 'larisdigital_section_navigation',
		'type'     => 'color',
		'style'    => '.site-navigation.site-navigation-sticky-active { background-color: [value] !important; }',
		'active_callback' => 'larisdigital_callback_navigation_is_active',
		'priority' => 35,
	);

	$controls['larisdigital_navigation_border_sticky'] = array(
		'label'    => esc_html__( 'Sticky Bottom Border Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_navigation_border_sticky',
		'section'  => 'larisdigital_section_navigation',
		'type'     => 'color',
		'style'    => '.site-navigation.site-navigation-sticky-active { border-color: [value] !important; }',
		'active_callback' => 'larisdigital_callback_navigation_is_active',
		'priority' => 35,
	);

	$controls['larisdigital_heading_navigation_padding'] = array(
		'label'    => esc_html__( 'Custom Padding', 'larisdigital-wp' ),
		'description' => esc_html__( 'For desktop only, when device viewport width >= 992px, not in sticky status', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_navigation_padding',
		'section'  => 'larisdigital_section_navigation',
		'type'     => 'heading',
		'active_callback' => 'larisdigital_callback_navigation_is_active',
		'priority' => 40,
	);

	$controls['larisdigital_navigation_padding'] = array(
		'label'    => esc_html__( 'Top and Bottom Padding', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_navigation_padding',
		'section'  => 'larisdigital_section_navigation',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 0.5,
			'max' => 3,
			'step' => 0.1,
			'unit' => 'rem',
		),
		'style'    => '@media (min-width: 992px) { .site-navigation { padding-top: [value]rem; padding-bottom: [value]rem; } }',
		'active_callback' => 'larisdigital_callback_navigation_is_active',
		'transport' => 'refresh',
		'priority' => 40,
	);

	$controls['larisdigital_heading_navigation_brand'] = array(
		'label'    => esc_html__( 'Brand', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_navigation_brand',
		'section'  => 'larisdigital_section_navigation',
		'type'     => 'heading',
		'active_callback' => 'larisdigital_callback_navigation_is_active',
		'priority' => 50,
	);

	$controls['larisdigital_navigation_brand_type'] = array(
		'label'    => esc_html__( 'Brand Type', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_navigation_brand_type',
		'section'  => 'larisdigital_section_navigation',
		'type'     => 'radio',
		'choices'  => array(
			'text' => esc_html__( 'Brand Text', 'larisdigital-wp' ),
			'image' => esc_html__( 'Brand Logo', 'larisdigital-wp' ),
			'image-text' => esc_html__( 'Brand Logo & Text', 'larisdigital-wp' ),
		),
		'active_callback' => 'larisdigital_callback_navigation_is_active',
		'priority' => 50,
	);

	$controls['larisdigital_navigation_brand_image'] = array(
		'label'    => esc_html__( 'Brand Logo', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_navigation_brand_image',
		'section'  => 'larisdigital_section_navigation',
		'type'     => 'image',
		'active_callback' => 'larisdigital_callback_navigation_brand_is_image',
		'priority' => 50,
	);

	$controls['larisdigital_navigation_brand_image_height'] = array(
		'label'    => esc_html__( 'Brand Image Height', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_navigation_brand_image_height',
		'section'  => 'larisdigital_section_navigation',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 30,
			'max' => 80,
			'step' => 5,
			'unit' => 'px',
		),
		'active_callback' => 'larisdigital_callback_navigation_brand_is_image',
		'priority' => 50,
	);

	$controls['larisdigital_navigation_brand_text'] = array(
		'label'    => esc_html__( 'Brand Text', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_navigation_brand_text',
		'section'  => 'larisdigital_section_navigation',
		'type'     => 'text',
		'active_callback' => 'larisdigital_callback_navigation_brand_is_text',
		'priority' => 50,
	);

	$controls['larisdigital_navigation_brand_text_color'] = array(
		'label'    => esc_html__( 'Text Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_navigation_brand_text_color',
		'section'  => 'larisdigital_section_navigation',
		'type'     => 'color',
		'style'    => '.site-navigation .site-navigation-brand { color: [value] }',
		'active_callback' => 'larisdigital_callback_navigation_brand_is_text',
		'priority' => 55,
	);

	$controls['larisdigital_navigation_brand_text_color_hover'] = array(
		'label'    => esc_html__( 'Text Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_navigation_brand_text_color_hover',
		'section'  => 'larisdigital_section_navigation',
		'type'     => 'color',
		'style'    => '.site-navigation .site-navigation-brand:focus, .site-navigation .site-navigation-brand:hover { color: [value] }',
		'active_callback' => 'larisdigital_callback_navigation_brand_is_text',
		'priority' => 55,
	);

	// $controls['larisdigital_navigation_brand_desktop_hide'] = array(
	// 	'label'    => esc_html__( 'HIDE Brand on Desktop Viewport', 'larisdigital-wp' ),
	// 	'setting'  => 'larisdigital_navigation_brand_desktop_hide',
	// 	'section'  => 'larisdigital_section_navigation',
	// 	'type'     => 'checkbox',
	// 	'active_callback' => 'larisdigital_callback_navigation_is_active',
	//	'priority' => 50,
	// );

	$controls['larisdigital_heading_navigation_menu'] = array(
		'label'    => esc_html__( 'Menu', 'larisdigital-wp' ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-with-icon"><span class="dashicons dashicons-admin-appearance"></span> <a href="javascript:wp.customize.section( \'menu_locations\' ).focus();">' . sprintf( esc_html__( 'CLICK HERE to setup %s', 'larisdigital-wp' ), esc_html__( 'Site Navigation Menu', 'larisdigital-wp' ) ) . '</a></p>',
		'setting'  => 'larisdigital_heading_navigation_menu',
		'section'  => 'larisdigital_section_navigation',
		'type'     => 'heading',
		'active_callback' => 'larisdigital_callback_navigation_is_active',
		'priority' => 60,
	);

	$controls['larisdigital_navigation_menu_alignment'] = array(
		'label'    => esc_html__( 'Alignment', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_navigation_menu_alignment',
		'section'  => 'larisdigital_section_navigation',
		'type'     => 'radio-iconset',
		'choices'  => array(
			'left' => 'dashicons dashicons-editor-alignleft',
			'center' => 'dashicons dashicons-editor-aligncenter',
			'right' => 'dashicons dashicons-editor-alignright',
		),
		'active_callback' =>'larisdigital_callback_navigation_is_active',
		'priority' => 60,
	);

	$controls['larisdigital_navigation_menu_font_size'] = array(
		'label'    => esc_html__( 'Font Size', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_navigation_menu_font_size',
		'section'  => 'larisdigital_section_navigation',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 0.5,
			'max' => 2,
			'step' => 0.1,
			'unit' => 'rem',
		),
		'style'    => '.site-navigation-menu, .site-navigation-menu .dropdown-menu, .site-navigation-quicknav, .site-navigation-quicknav .dropdown-menu, .site-navigation-quicknav .form-control { font-size: [value]rem; }',
		'active_callback' => 'larisdigital_callback_navigation_is_active',
		'priority' => 65,
	);

	$controls['larisdigital_navigation_menu_color'] = array(
		'label'    => esc_html__( 'Link Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_navigation_menu_color',
		'section'  => 'larisdigital_section_navigation',
		'type'     => 'color',
		'style'    => '.site-navigation .site-navigation-menu .nav-link { color: [value] }',
		'active_callback' => 'larisdigital_callback_navigation_is_active',
		'priority' => 65,
	);

	$controls['larisdigital_navigation_menu_color_hover'] = array(
		'label'    => esc_html__( 'Link Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_navigation_menu_color_hover',
		'section'  => 'larisdigital_section_navigation',
		'type'     => 'color',
		'style'    => '.site-navigation .site-navigation-menu .nav-link:focus, .site-navigation .site-navigation-menu .nav-link:hover { color: [value] }',
		'active_callback' => 'larisdigital_callback_navigation_is_active',
		'priority' => 65,
	);

	$controls['larisdigital_navigation_menu_color_active'] = array(
		'label'    => esc_html__( 'Link Color', 'larisdigital-wp' ).' '.esc_html__( '(Active)', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_navigation_menu_color_active',
		'section'  => 'larisdigital_section_navigation',
		'type'     => 'color',
		'style'    => '.site-navigation .site-navigation-menu .active>.nav-link, .site-navigation .site-navigation-menu .nav-link.active, .site-navigation .site-navigation-menu .nav-link.show, .site-navigation .site-navigation-menu .show>.nav-link { color: [value] }',
		'active_callback' => 'larisdigital_callback_navigation_is_active',
		'priority' => 65,
	);

	$controls['larisdigital_heading_navigation_quicknav'] = array(
		'label'    => esc_html__( 'Quick Nav', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_navigation_quicknav',
		'section'  => 'larisdigital_section_navigation',
		'type'     => 'heading',
		'active_callback' => 'larisdigital_callback_navigation_is_active',
		'priority' => 70,
	);

	$controls['larisdigital_navigation_quicknav_search'] = array(
		'label'    => esc_html__( 'SHOW Search Form', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_navigation_quicknav_search',
		'section'  => 'larisdigital_section_navigation',
		'type'     => 'checkbox',
		'active_callback' => 'larisdigital_callback_navigation_is_active',
		'priority' => 70,
	);

	$controls['larisdigital_navigation_quicknav_color'] = array(
		'label'    => esc_html__( 'Icon Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_navigation_quicknav_color',
		'section'  => 'larisdigital_section_navigation',
		'type'     => 'color',
		'style'    => '.site-navigation .site-navigation-quicknav .nav-link, .site-navigation .navbar-toggler { color: [value] }',
		'active_callback' => 'larisdigital_callback_navigation_is_active',
		'priority' => 75,
	);

	$controls['larisdigital_navigation_quicknav_color_hover'] = array(
		'label'    => esc_html__( 'Icon Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_navigation_quicknav_color_hover',
		'section'  => 'larisdigital_section_navigation',
		'type'     => 'color',
		'style'    => '.site-navigation .site-navigation-quicknav .nav-link:focus, .site-navigation .site-navigation-quicknav .nav-link:hover, .site-navigation .navbar-toggler:hover { color: [value] }',
		'active_callback' => 'larisdigital_callback_navigation_is_active',
		'priority' => 75,
	);

	$controls['larisdigital_heading_navigation_mobile'] = array(
		'label'    => esc_html__( 'Mobile Menu (Offcanvas Menu)', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_navigation_mobile',
		'section'  => 'larisdigital_section_navigation',
		'type'     => 'heading',
		'active_callback' => 'larisdigital_callback_navigation_is_active',
		'priority' => 80,
	);

	$controls['larisdigital_navigation_mobile_background'] = array(
		'label'    => esc_html__( 'Mobile Menu Background', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_navigation_mobile_background',
		'section'  => 'larisdigital_section_navigation',
		'type'     => 'color',
		'style'    => '.mm-menu.mm-theme-dark { background: [value] }',
		'active_callback' => 'larisdigital_callback_navigation_is_active',
		'priority' => 80,
	);

	$controls['larisdigital_navigation_mobile_color'] = array(
		'label'    => esc_html__( 'Mobile Menu Text Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_navigation_mobile_color',
		'section'  => 'larisdigital_section_navigation',
		'type'     => 'color',
		'style'    => '.mm-menu.mm-theme-dark, .mm-menu.mm-theme-dark .mm-navbar a, .mm-menu.mm-theme-dark .mm-navbar>* { color: [value] } .mm-menu.mm-theme-dark .mm-listview>li .mm-next:after, .mm-menu.mm-theme-dark .mm-btn:after, .mm-menu.mm-theme-dark .mm-btn:before { border-color: [value] }',
		'active_callback' => 'larisdigital_callback_navigation_is_active',
		'priority' => 80,
	);

	$controls['larisdigital_navigation_mobile_line'] = array(
		'label'    => esc_html__( 'Mobile Menu Line Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_navigation_mobile_line',
		'section'  => 'larisdigital_section_navigation',
		'type'     => 'color',
		'style'    => '.mm-menu.mm-theme-dark, .mm-menu.mm-theme-dark .mm-listview { border-color: [value] }',
		'active_callback' => 'larisdigital_callback_navigation_is_active',
		'priority' => 80,
	);

	return $controls;
}

add_filter( 'larisdigital_customize_controls', 'larisdigital_customize_controls_header' );
function larisdigital_customize_controls_header( $controls ) {

	$controls['larisdigital_section_header'] = array(
		'title'    => esc_html__( 'Site Header (Title & Description)', 'larisdigital-wp' ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-success larisdigital-alert-with-icon">
							<span class="dashicons dashicons-megaphone"></span> '.sprintf( esc_html__( '%s can be disabled on a post/page using "%s" metabox when editing a post/page', 'larisdigital-wp' ), esc_html__( 'Site Header (Title & Description)', 'larisdigital-wp' ), esc_html__( 'Page Layout', 'larisdigital-wp' ) ).'<br><br>'.esc_html__( 'It can also be customized using "Site Header" metabox when editing a post/page', 'larisdigital-wp' ).'
							</p>',
		'setting'  => 'larisdigital_section_header',
		'panel'    => 'larisdigital_panel_settings',
		'type'     => 'section',
		'priority' => 130,
	);

	$controls['larisdigital_header_hide'] = array(
		'label'    => sprintf( esc_html__( 'HIDE %s Globally', 'larisdigital-wp' ), esc_html__( 'Site Header (Title & Description)', 'larisdigital-wp' ) ),
		'setting'  => 'larisdigital_header_hide',
		'section'  => 'larisdigital_section_header',
		'type'     => 'checkbox',
		'priority' => 1,
	);

	$controls['larisdigital_header_image'] = array(
		'label'    => esc_html__( 'SHOW Header Image', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_header_image',
		'section'  => 'larisdigital_section_header',
		'type'     => 'checkbox',
		'active_callback' =>'larisdigital_callback_header_is_not_active',
		'priority' => 2,
	);

	$controls['larisdigital_header_alignment'] = array(
		'label'    => esc_html__( 'Alignment', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_header_alignment',
		'section'  => 'larisdigital_section_header',
		'type'     => 'radio-iconset',
		'choices'  => array(
			'left' => 'dashicons dashicons-editor-alignleft',
			'center' => 'dashicons dashicons-editor-aligncenter',
			'right' => 'dashicons dashicons-editor-alignright',
		),
		'style'  => array(
			'left' => '.site-header { text-align: left; }',
			'center' => '.site-header { text-align: center; }',
			'right' => '.site-header { text-align: right; }',
		),
		'active_callback' =>'larisdigital_callback_header_is_active',
		'priority' => 2,
	);

	$controls['larisdigital_header_background'] = array(
		'label'    => esc_html__( 'Background Color', 'larisdigital-wp' ),
		'description' => esc_html__( 'It is fallback color when background image is not available.', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_header_background',
		'section'  => 'larisdigital_section_header',
		'type'     => 'color',
		'style'    => '.site-header { background-color: [value]; }',
		'active_callback' => 'larisdigital_callback_header_is_active',
		'priority' => 3,
	);

	$controls['larisdigital_heading_header_image'] = array(
		'label'    => esc_html__( 'Header Background Image', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_header_image',
		'section'  => 'larisdigital_section_header',
		'type'     => 'heading',
		'active_callback' => 'larisdigital_callback_header_is_active',
		'priority' => 4,
	);

	$controls['larisdigital_header_background_overlay'] = array(
		'label'    => esc_html__( 'Background Overlay Color', 'larisdigital-wp' ),
		'description' => esc_html__( 'Do not forget to use transparancy control to make background overlay transparent', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_header_background_overlay',
		'section'  => 'larisdigital_section_header',
		'type'     => 'color',
		'default'  => 'rgba(255,255,255,0.85)',
		'style'    => '.site-header-overlay { background-color: [value]; }',
		'active_callback' => 'larisdigital_callback_header_image_is_active',
		'priority' => 6,
	);

	$controls['larisdigital_header_background_paralax'] = array(
		'label'    => esc_html__( 'Apply simple CSS Parallax style to header background image', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_header_background_paralax',
		'section'  => 'larisdigital_section_header',
		'type'     => 'checkbox',
		'priority' => 6,
		'active_callback' => 'larisdigital_callback_header_image_is_active',
		'style'  => array(
			'on' => '.site-header { background-attachment: fixed; }',
			'off' => '',
		),
	);

	$controls['larisdigital_heading_header_title'] = array(
		'label'    => esc_html__( 'Title', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_header_title',
		'section'  => 'larisdigital_section_header',
		'type'     => 'heading',
		'active_callback' => 'larisdigital_callback_header_is_active',
	);

	$controls['larisdigital_header_title_text'] = array(
		'label'    => esc_html__( 'Default Text', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_header_title_text',
		'section'  => 'larisdigital_section_header',
		'type'     => 'text',
		'active_callback' => 'larisdigital_callback_header_is_active',
	);

	$controls['larisdigital_header_title_color'] = array(
		'label'    => esc_html__( 'Text Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_header_title_color',
		'section'  => 'larisdigital_section_header',
		'type'     => 'color',
		'style'    => '.site-title { color: [value]; }',
		'active_callback' => 'larisdigital_callback_header_is_active',
	);

	$controls['larisdigital_header_title_font_size'] = array(
		'label'    => esc_html__( 'Font Size', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_header_title_font_size',
		'section'  => 'larisdigital_section_header',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 0.5,
			'max' => 4,
			'step' => 0.1,
			'unit' => 'rem',
		),
		'style'    => '.site-title { font-size: [value]rem }',
		'active_callback' => 'larisdigital_callback_header_is_active',
	);

	$controls['larisdigital_heading_header_description'] = array(
		'label'    => esc_html__( 'Description', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_header_description',
		'section'  => 'larisdigital_section_header',
		'type'     => 'heading',
		'active_callback' => 'larisdigital_callback_header_is_active',
	);

	$controls['larisdigital_header_description_text'] = array(
		'label'    => esc_html__( 'Default Text', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_header_description_text',
		'section'  => 'larisdigital_section_header',
		'type'     => 'text',
		'active_callback' => 'larisdigital_callback_header_is_active',
	);

	$controls['larisdigital_header_description_color'] = array(
		'label'    => esc_html__( 'Text Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_header_description_color',
		'section'  => 'larisdigital_section_header',
		'type'     => 'color',
		'style'    => '.site-description { color: [value]; }',
		'active_callback' => 'larisdigital_callback_header_is_active',
	);

	$controls['larisdigital_header_description_font_size'] = array(
		'label'    => esc_html__( 'Font Size', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_header_description_font_size',
		'section'  => 'larisdigital_section_header',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 0.5,
			'max' => 4,
			'step' => 0.1,
			'unit' => 'rem',
		),
		'style'    => '.site-description { font-size: [value]rem }',
		'active_callback' => 'larisdigital_callback_header_is_active',
	);

	$controls['larisdigital_heading_header_padding'] = array(
		'label'    => esc_html__( 'Custom Padding', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_header_padding',
		'section'  => 'larisdigital_section_header',
		'type'     => 'heading',
		'active_callback' => 'larisdigital_callback_header_is_active',
	);

	$controls['larisdigital_header_padding_top'] = array(
		'label'    => esc_html__( 'Top Padding', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_header_padding_top',
		'section'  => 'larisdigital_section_header',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 0,
			'max' => 10,
			'step' => 0.1,
			'unit' => 'rem',
		),
		'style'    => '.site-header { padding-top: [value]rem; }',
		'active_callback' => 'larisdigital_callback_header_is_active',
	);

	$controls['larisdigital_header_padding_bottom'] = array(
		'label'    => esc_html__( 'Bottom Padding', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_header_padding_bottom',
		'section'  => 'larisdigital_section_header',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 0,
			'max' => 10,
			'step' => 0.1,
			'unit' => 'rem',
		),
		'style'    => '.site-header { padding-bottom: [value]rem; }',
		'active_callback' => 'larisdigital_callback_header_is_active',
	);

	return $controls;
}

add_filter( 'larisdigital_customize_controls', 'larisdigital_customize_controls_breadcrumb' );
function larisdigital_customize_controls_breadcrumb( $controls ) {

	$controls['larisdigital_section_breadcrumb'] = array(
		'title'    => esc_html__( 'Site Breadcrumb', 'larisdigital-wp' ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-success larisdigital-alert-with-icon">
							<span class="dashicons dashicons-megaphone"></span> '.sprintf( esc_html__( '%s can be disabled on a post/page using "%s" metabox when editing a post/page', 'larisdigital-wp' ), esc_html__( 'Site Breadcrumb', 'larisdigital-wp' ), esc_html__( 'Page Layout', 'larisdigital-wp' ) ).'
							</p>',
		'setting'  => 'larisdigital_section_breadcrumb',
		'panel'    => 'larisdigital_panel_settings',
		'type'     => 'section',
		'priority' => 140,
	);

	$controls['larisdigital_breadcrumb_hide'] = array(
		'label'    => sprintf( esc_html__( 'HIDE %s Globally', 'larisdigital-wp' ), esc_html__( 'Site Breadcrumb', 'larisdigital-wp' ) ),
		'setting'  => 'larisdigital_breadcrumb_hide',
		'section'  => 'larisdigital_section_breadcrumb',
		'type'     => 'checkbox',
	);

	$controls['larisdigital_breadcrumb_alignment'] = array(
		'label'    => esc_html__( 'Alignment', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_breadcrumb_alignment',
		'section'  => 'larisdigital_section_breadcrumb',
		'type'     => 'radio-iconset',
		'choices'  => array(
			'left' => 'dashicons dashicons-editor-alignleft',
			'center' => 'dashicons dashicons-editor-aligncenter',
			'right' => 'dashicons dashicons-editor-alignright',
		),
		'active_callback' =>'larisdigital_callback_breadcrumb_is_active',
	);

	$controls['larisdigital_breadcrumb_background'] = array(
		'label'    => esc_html__( 'Background Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_breadcrumb_background',
		'section'  => 'larisdigital_section_breadcrumb',
		'type'     => 'color',
		'style'    => '.site-breadcrumb { background-color: [value]; }',
		'active_callback' => 'larisdigital_callback_breadcrumb_is_active',
	);

	$controls['larisdigital_breadcrumb_color'] = array(
		'label'    => esc_html__( 'Text Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_breadcrumb_color',
		'section'  => 'larisdigital_section_breadcrumb',
		'type'     => 'color',
		'style'    => '.site-breadcrumb, .breadcrumb-item.active { color: [value] }',
		'active_callback' => 'larisdigital_callback_breadcrumb_is_active',
	);

	$controls['larisdigital_breadcrumb_link_color'] = array(
		'label'    => esc_html__( 'Link Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_breadcrumb_link_color',
		'section'  => 'larisdigital_section_breadcrumb',
		'type'     => 'color',
		'style'    => '.site-breadcrumb a { color: [value] }',
		'active_callback' => 'larisdigital_callback_breadcrumb_is_active',
	);

	$controls['larisdigital_breadcrumb_link_color_hover'] = array(
		'label'    => esc_html__( 'Link Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_breadcrumb_link_color_hover',
		'section'  => 'larisdigital_section_breadcrumb',
		'type'     => 'color',
		'style'    => '.site-breadcrumb a:hover { color: [value] }',
		'active_callback' => 'larisdigital_callback_breadcrumb_is_active',
	);

	$controls['larisdigital_breadcrumb_separator_color'] = array(
		'label'    => esc_html__( 'Separator Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_breadcrumb_separator_color',
		'section'  => 'larisdigital_section_breadcrumb',
		'type'     => 'color',
		'style'    => '.breadcrumb-item+.breadcrumb-item::before { color: [value] }',
		'active_callback' => 'larisdigital_callback_breadcrumb_is_active',
	);

	$controls['larisdigital_breadcrumb_font_size'] = array(
		'label'    => esc_html__( 'Font Size', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_breadcrumb_font_size',
		'section'  => 'larisdigital_section_breadcrumb',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 0.5,
			'max' => 2,
			'step' => 0.1,
			'unit' => 'rem',
		),
		'style'    => '.site-breadcrumb .breadcrumb { font-size: [value]rem }',
		'active_callback' => 'larisdigital_callback_breadcrumb_is_active',
	);

	return $controls;
}

add_filter( 'larisdigital_customize_controls', 'larisdigital_customize_controls_sidebar' );
function larisdigital_customize_controls_sidebar( $controls ) {

	$controls['larisdigital_section_sidebar'] = array(
		'title'    => esc_html__( 'Sidebar', 'larisdigital-wp' ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-success larisdigital-alert-with-icon">
							<span class="dashicons dashicons-megaphone"></span> '.esc_html__( 'Sidebar Layout can also be customized on different sections (Blog Page, Single Post, Single Page, Shop Page, Single Product)', 'larisdigital-wp' ).'
							</p>',
		'setting'  => 'larisdigital_section_sidebar',
		'panel'    => 'larisdigital_panel_settings',
		'type'     => 'section',
		'priority' => 210,
	);

	$controls['larisdigital_sidebar_layout'] = array(
		'label'    => esc_html__( 'Sidebar Layout', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_sidebar_layout',
		'section'  => 'larisdigital_section_sidebar',
		'type'     => 'radio',
		'choices'  => array(
			'right' => esc_html__( 'Right Sidebar', 'larisdigital-wp' ),
			'left' => esc_html__( 'Left Sidebar', 'larisdigital-wp' ),
			'none' => esc_html__( 'No Sidebar', 'larisdigital-wp' ),
		),
	);

	$controls['larisdigital_sidebar_width'] = array(
		'label'    => esc_html__( 'Sidebar Width', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_sidebar_width',
		'section'  => 'larisdigital_section_sidebar',
		'type'     => 'select',
		'choices'  => array(
			'' => esc_html__( 'Default', 'larisdigital-wp' ),
			'3' => esc_html__( '3/12 Grid', 'larisdigital-wp' ),
			'4' => esc_html__( '4/12 Grid', 'larisdigital-wp' ),
			'5' => esc_html__( '5/12 Grid', 'larisdigital-wp' ),
			'6' => esc_html__( '6/12 Grid', 'larisdigital-wp' ),
		),
		'active_callback' => 'larisdigital_callback_sidebar_is_active',
	);

	$controls['larisdigital_content_width'] = array(
		'label'    => esc_html__( 'Content Width', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_content_width',
		'section'  => 'larisdigital_section_sidebar',
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
		'active_callback' => 'larisdigital_callback_sidebar_is_not_active',
	);

	$controls['larisdigital_heading_sidebar_widget'] = array(
		'label'    => esc_html__( 'Widget', 'larisdigital-wp' ),
		'description' 		=> '<p class="larisdigital-alert larisdigital-alert-with-icon">
								<span class="dashicons dashicons-admin-tools"></span> <a href="javascript:wp.customize.panel( \'widgets\' ).focus();">'.esc_html__( 'CLICK HERE to setup / manage widgets when sidebar is available', 'larisdigital-wp' ).'</a>
								</p>',
		'setting'  => 'larisdigital_heading_sidebar_widget',
		'section'  => 'larisdigital_section_sidebar',
		'type'     => 'heading',
	);

	$controls['larisdigital_sidebar_widget_background'] = array(
		'label'    => esc_html__( 'Background Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_sidebar_widget_background',
		'section'  => 'larisdigital_section_sidebar',
		'type'     => 'color',
		'style'    => '.sidebar .widget, .sidebar .widget ul li { background-color: [value] }',
	);

	$controls['larisdigital_sidebar_widget_border'] = array(
		'label'    => esc_html__( 'Border Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_sidebar_widget_border',
		'section'  => 'larisdigital_section_sidebar',
		'type'     => 'color',
		'style'    => '.sidebar .widget { border-color: [value] }',
	);

	$controls['larisdigital_sidebar_widget_color'] = array(
		'label'    => esc_html__( 'Text Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_sidebar_widget_color',
		'section'  => 'larisdigital_section_sidebar',
		'type'     => 'color',
		'style'    => '.sidebar .widget, .sidebar .widget caption { color: [value] }',
	);

	$controls['larisdigital_sidebar_widget_link'] = array(
		'label'    => esc_html__( 'Link Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_sidebar_widget_link',
		'section'  => 'larisdigital_section_sidebar',
		'type'     => 'color',
		'style'    => '.sidebar .widget a { color: [value] }',
	);

	$controls['larisdigital_sidebar_widget_link_hover'] = array(
		'label'    => esc_html__( 'Link Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_sidebar_widget_link_hover',
		'section'  => 'larisdigital_section_sidebar',
		'type'     => 'color',
		'style'    => '.sidebar .widget a:hover { color: [value] }',
	);

	$controls['larisdigital_sidebar_widget_font_size'] = array(
		'label'    => esc_html__( 'Font Size', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_sidebar_widget_font_size',
		'section'  => 'larisdigital_section_sidebar',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 0.5,
			'max' => 2,
			'step' => 0.1,
			'unit' => 'rem',
		),
		'style'    => '.sidebar .widget { font-size: [value]rem }',
	);

	$controls['larisdigital_heading_sidebar_widget_title'] = array(
		'label'    => esc_html__( 'Widget Title', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_sidebar_widget_title',
		'section'  => 'larisdigital_section_sidebar',
		'type'     => 'heading',
	);

	$controls['larisdigital_sidebar_widget_title_background'] = array(
		'label'    => esc_html__( 'Background Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_sidebar_widget_title_background',
		'section'  => 'larisdigital_section_sidebar',
		'type'     => 'color',
		'style'    => '.sidebar .widget .widget-title { background-color: [value] }',
	);

	$controls['larisdigital_sidebar_widget_title_border'] = array(
		'label'    => esc_html__( 'Border Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_sidebar_widget_title_border',
		'section'  => 'larisdigital_section_sidebar',
		'type'     => 'color',
		'style'    => '.sidebar .widget .widget-title { border-color: [value] }',
	);

	$controls['larisdigital_sidebar_widget_title_color'] = array(
		'label'    => esc_html__( 'Text Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_sidebar_widget_title_color',
		'section'  => 'larisdigital_section_sidebar',
		'type'     => 'color',
		'style'    => '.sidebar .widget .widget-title, .sidebar .widget .widget-title a { color: [value] }',
	);

	$controls['larisdigital_sidebar_widget_title_font_size'] = array(
		'label'    => esc_html__( 'Font Size', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_sidebar_widget_title_font_size',
		'section'  => 'larisdigital_section_sidebar',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 0.5,
			'max' => 2.5,
			'step' => 0.05,
			'unit' => 'rem',
		),
		'style'    => '.sidebar .widget .widget-title { font-size: [value]rem }',
	);

	$controls['larisdigital_sidebar_widget_title_font_weight'] = array(
		'label'    => esc_html__( 'Font Weight', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_sidebar_widget_title_font_weight',
		'section'  => 'larisdigital_section_sidebar',
		'type'     => 'select',
		'choices'  => array(
			'' => '',
			'normal' => esc_html__( 'Normal', 'larisdigital-wp' ),
			'bold' => esc_html__( 'Bold', 'larisdigital-wp' ),
		),
		'style'  => array(
			'normal' => '',
			'bold' => '.sidebar .widget .widget-title { font-weight: bold; }',
		),
	);

	$controls['larisdigital_sidebar_widget_title_font_style'] = array(
		'label'    => esc_html__( 'Font Style', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_sidebar_widget_title_font_style',
		'section'  => 'larisdigital_section_sidebar',
		'type'     => 'select',
		'choices'  => array(
			'' => '',
			'normal' => esc_html__( 'Normal', 'larisdigital-wp' ),
			'italic' => esc_html__( 'Italic', 'larisdigital-wp' ),
		),
		'style'  => array(
			'normal' => '',
			'italic' => '.sidebar .widget .widget-title { font-style: italic; }',
		),
	);

	$controls['larisdigital_sidebar_widget_title_text_transform'] = array(
		'label'    => esc_html__( 'Text Transform', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_sidebar_widget_title_text_transform',
		'section'  => 'larisdigital_section_sidebar',
		'type'     => 'select',
		'choices'  => array(
			'' => '',
			'none' => esc_html__( 'None', 'larisdigital-wp' ),
			'uppercase' => esc_html__( 'Uppercase', 'larisdigital-wp' ),
			'lowercase' => esc_html__( 'Lowercase', 'larisdigital-wp' ),
			'capitalize' => esc_html__( 'Capitalize', 'larisdigital-wp' ),
		),
		'style'  => array(
			'none' => '.sidebar .widget .widget-title { text-transform: none; }',
			'uppercase' => '.sidebar .widget .widget-title { text-transform: uppercase; }',
			'lowercase' => '.sidebar .widget .widget-title { text-transform: lowercase; }',
			'capitalize' => '.sidebar .widget .widget-title { text-transform: capitalize; }',
		),
	);

	$controls['larisdigital_heading_sidebar_widget_padding'] = array(
		'label'    => esc_html__( 'Custom Widget Padding', 'larisdigital-wp' ),
		'description' => esc_html__( 'For tablet & desktop only, when device viewport width >= 768px', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_sidebar_widget_padding',
		'section'  => 'larisdigital_section_sidebar',
		'type'     => 'heading',
		'active_callback' => 'larisdigital_callback_navigation_is_active',
	);

	$controls['larisdigital_sidebar_widget_padding'] = array(
		'label'    => esc_html__( 'Left & Right Widget Padding', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_sidebar_widget_padding',
		'section'  => 'larisdigital_section_sidebar',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 0.05,
			'max' => 2.5,
			'step' => 0.05,
			'unit' => 'rem',
		),
		'style'    => ' @media (min-width: 768px) { .sidebar .card .card-body, .sidebar .card .card-header { padding-left: [value]rem; padding-right: [value]rem; } .sidebar .card .card-header { margin-left: -[value]rem; margin-right: -[value]rem; } } ',
	);

	return $controls;
}

add_filter( 'larisdigital_customize_controls', 'larisdigital_customize_controls_comments' );
function larisdigital_customize_controls_comments( $controls ) {

	$controls['larisdigital_section_comments'] = array(
		'title'    => esc_html__( 'Comments', 'larisdigital-wp' ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-with-icon">
						<span class="dashicons dashicons-admin-tools"></span> <a href="javascript:wp.customize.control( \'larisdigital_heading_post_comments\' ).focus();">'.esc_html__( 'CLICK HERE to show/hide comments on single post.', 'larisdigital-wp' ).'</a><br><br><a href="javascript:wp.customize.control( \'larisdigital_heading_page_comments\' ).focus();">'.esc_html__( 'CLICK HERE to show/hide comments on single page.', 'larisdigital-wp' ).'</a>
						</p>',
		'setting'  => 'larisdigital_section_comments',
		'panel'    => 'larisdigital_panel_settings',
		'type'     => 'section',
		'priority' => 220,
	);

	$controls['larisdigital_heading_comments_textarea'] = array(
		'label'    => esc_html__( 'Comment Form - Textarea Field', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_comments_textarea',
		'section'  => 'larisdigital_section_comments',
		'type'     => 'heading',
	);

	$controls['larisdigital_comments_textarea_reverse'] = array(
		'label'    => esc_html__( 'Reverse Comment Textarea To The Bottom (Below Name, Email, URL)', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_comments_textarea_reverse',
		'section'  => 'larisdigital_section_comments',
		'type'     => 'checkbox',
	);

	$controls['larisdigital_heading_comments_url'] = array(
		'label'    => esc_html__( 'Comment Form - Web URL Field', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_comments_url',
		'section'  => 'larisdigital_section_comments',
		'type'     => 'heading',
	);

	$controls['larisdigital_comments_url_hide'] = array(
		'label'    => esc_html__( 'Hide Comment URL (Website) Field', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_comments_url_hide',
		'section'  => 'larisdigital_section_comments',
		'type'     => 'checkbox',
	);

	$controls['larisdigital_heading_comments_title'] = array(
		'label'    => esc_html__( 'Comment Title Text', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_comments_title',
		'section'  => 'larisdigital_section_comments',
		'type'     => 'heading',
	);

	$controls['larisdigital_comments_title_single'] = array(
		'label'    => sprintf( esc_html__( 'Change Text: "%s"', 'larisdigital-wp' ), esc_html__( 'One Comment', 'larisdigital-wp' ) ),
		'setting'  => 'larisdigital_comments_title_single',
		'section'  => 'larisdigital_section_comments',
		'type'     => 'text',
	);

	$controls['larisdigital_comments_title_plural'] = array(
		'label'    => sprintf( esc_html__( 'Change Text: "%s"', 'larisdigital-wp' ), esc_html__( '%s Comments', 'larisdigital-wp' ) ),
		'setting'  => 'larisdigital_comments_title_plural',
		'section'  => 'larisdigital_section_comments',
		'type'     => 'text',
	);

	$controls['larisdigital_heading_comments_reply'] = array(
		'label'    => esc_html__( 'Comment Reply Text', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_comments_reply',
		'section'  => 'larisdigital_section_comments',
		'type'     => 'heading',
	);

	$controls['larisdigital_comments_reply_text'] = array(
		'label'    => sprintf( esc_html__( 'Change Text: "%s"', 'larisdigital-wp' ), esc_html__( 'Reply', 'larisdigital-wp' ) ),
		'setting'  => 'larisdigital_comments_reply_text',
		'section'  => 'larisdigital_section_comments',
		'type'     => 'text',
	);

	$controls['larisdigital_comments_login_text'] = array(
		'label'    => sprintf( esc_html__( 'Change Text: "%s"', 'larisdigital-wp' ), esc_html__( 'Log in to Reply', 'larisdigital-wp' ) ),
		'setting'  => 'larisdigital_comments_login_text',
		'section'  => 'larisdigital_section_comments',
		'type'     => 'text',
	);

	$controls['larisdigital_heading_comments_form'] = array(
		'label'    => esc_html__( 'Comment Form Text', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_comments_form',
		'section'  => 'larisdigital_section_comments',
		'type'     => 'heading',
	);

	$controls['larisdigital_comments_form_name'] = array(
		'label'    => sprintf( esc_html__( 'Change Text: "%s"', 'larisdigital-wp' ), esc_html__( 'Your Name', 'larisdigital-wp' ) ),
		'setting'  => 'larisdigital_comments_form_name',
		'section'  => 'larisdigital_section_comments',
		'type'     => 'text',
	);

	$controls['larisdigital_comments_form_email'] = array(
		'label'    => sprintf( esc_html__( 'Change Text: "%s"', 'larisdigital-wp' ), esc_html__( 'Your Email', 'larisdigital-wp' ) ),
		'setting'  => 'larisdigital_comments_form_email',
		'section'  => 'larisdigital_section_comments',
		'type'     => 'text',
	);

	$controls['larisdigital_comments_form_website'] = array(
		'label'    => sprintf( esc_html__( 'Change Text: "%s"', 'larisdigital-wp' ), esc_html__( 'Your Website', 'larisdigital-wp' ) ),
		'setting'  => 'larisdigital_comments_form_website',
		'section'  => 'larisdigital_section_comments',
		'type'     => 'text',
	);

	$controls['larisdigital_comments_form_comment'] = array(
		'label'    => sprintf( esc_html__( 'Change Text: "%s"', 'larisdigital-wp' ), esc_html__( 'Your Comment', 'larisdigital-wp' ) ),
		'setting'  => 'larisdigital_comments_form_comment',
		'section'  => 'larisdigital_section_comments',
		'type'     => 'text',
	);

	$controls['larisdigital_comments_form_notes'] = array(
		'label'    => sprintf( esc_html__( 'Change Text: "%s"', 'larisdigital-wp' ), esc_html__( 'Your email address will not be published.', 'larisdigital-wp' ) ),
		'setting'  => 'larisdigital_comments_form_notes',
		'section'  => 'larisdigital_section_comments',
		'type'     => 'text',
	);

	$controls['larisdigital_comments_form_required'] = array(
		'label'    => sprintf( esc_html__( 'Change Text: "%s"', 'larisdigital-wp' ), esc_html__( 'Required fields are marked %s', 'larisdigital-wp' ) ),
		'setting'  => 'larisdigital_comments_form_required',
		'section'  => 'larisdigital_section_comments',
		'type'     => 'text',
	);

	$controls['larisdigital_comments_form_title_reply'] = array(
		'label'    => sprintf( esc_html__( 'Change Text: "%s"', 'larisdigital-wp' ), esc_html__( 'Leave a Reply', 'larisdigital-wp' ) ),
		'setting'  => 'larisdigital_comments_form_title_reply',
		'section'  => 'larisdigital_section_comments',
		'type'     => 'text',
	);

	$controls['larisdigital_comments_form_title_reply_to'] = array(
		'label'    => sprintf( esc_html__( 'Change Text: "%s"', 'larisdigital-wp' ), esc_html__( 'Leave a Reply to %s', 'larisdigital-wp' ) ),
		'setting'  => 'larisdigital_comments_form_title_reply_to',
		'section'  => 'larisdigital_section_comments',
		'type'     => 'text',
	);

	$controls['larisdigital_comments_form_cancel_reply_link'] = array(
		'label'    => sprintf( esc_html__( 'Change Text: "%s"', 'larisdigital-wp' ), esc_html__( 'Cancel reply', 'larisdigital-wp' ) ),
		'setting'  => 'larisdigital_comments_form_cancel_reply_link',
		'section'  => 'larisdigital_section_comments',
		'type'     => 'text',
	);

	$controls['larisdigital_comments_form_label_submit'] = array(
		'label'    => sprintf( esc_html__( 'Change Text: "%s"', 'larisdigital-wp' ), esc_html__( 'Post Comment', 'larisdigital-wp' ) ),
		'setting'  => 'larisdigital_comments_form_label_submit',
		'section'  => 'larisdigital_section_comments',
		'type'     => 'text',
	);

	return $controls;
}

add_filter( 'larisdigital_customize_controls', 'larisdigital_customize_controls_template_blog' );
function larisdigital_customize_controls_template_blog( $controls ) {

	$controls['larisdigital_section_template_blog'] = array(
		'title'    => sprintf( esc_html__( 'Template - %s', 'larisdigital-wp' ), esc_html__( 'Blog Page', 'larisdigital-wp' ) ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-success larisdigital-alert-with-icon">
							<span class="dashicons dashicons-megaphone"></span>'.sprintf( esc_html__( 'These settings are applied on All %s', 'larisdigital-wp' ), esc_html__( 'Blog Page and Archive ( category / tag / author / date, etc ) pages', 'larisdigital-wp' ) ).
						'</p>',
		'setting'  => 'larisdigital_section_template_blog',
		'panel'    => 'larisdigital_panel_settings',
		'type'     => 'section',
		'priority' => 320,
	);

	$controls['larisdigital_heading_homepage_settings'] = array(
		'label'    => esc_html__( 'Homepage Settings', 'larisdigital-wp' ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-with-icon"><span class="dashicons dashicons-admin-appearance"></span> <a href="javascript:wp.customize.section( \'static_front_page\' ).focus();">' . esc_html__( 'CLICK HERE to go to Homepage Settings to setup a static homepage', 'larisdigital-wp' ) . '</a></p>',
		'setting'  => 'larisdigital_heading_homepage_settings',
		'section'  => 'larisdigital_section_template_blog',
		'type'     => 'heading',
	);

	$controls['larisdigital_homepage_breadcrumb_hide'] = array(
		'label'    => sprintf( esc_html__( 'HIDE Breadcrumb on %s', 'larisdigital-wp' ), esc_html__( 'Homepage', 'larisdigital-wp' ) ),
		'setting'  => 'larisdigital_homepage_breadcrumb_hide',
		'section'  => 'larisdigital_section_template_blog',
		'type'     => 'checkbox',
		'active_callback' => 'larisdigital_callback_breadcrumb_is_active',
	);

	$controls['larisdigital_heading_blog_layout'] = array(
		'label'    => esc_html__( 'Blog Layout', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_blog_layout',
		'section'  => 'larisdigital_section_template_blog',
		'type'     => 'heading',
	);

	$controls['larisdigital_blog_layout'] = array(
		'label'    => esc_html__( 'Blog Layout', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_blog_layout',
		'section'  => 'larisdigital_section_template_blog',
		'type'     => 'radio',
		'choices'  => array(
			'excerpt-image' => esc_html__( 'Featured Image + Excerpt (Summary)', 'larisdigital-wp' ),
			'excerpt' => esc_html__( 'Excerpt (Summary)', 'larisdigital-wp' ),
			'content-image' => esc_html__( 'Featured Image + Full Content', 'larisdigital-wp' ),
			'content' => esc_html__( 'Full Content', 'larisdigital-wp' ),
		),
	);

	$controls['larisdigital_heading_blog_site_header'] = array(
		'label'    => esc_html__( 'Site Header (Title & Description)', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_blog_site_header',
		'section'  => 'larisdigital_section_template_blog',
		'type'     => 'heading',
		'active_callback' =>'larisdigital_callback_header_is_active',
	);

	$controls['larisdigital_blog_title4header'] = array(
		'label'    => esc_html__( 'Use archive title ( category / tag / author / date, etc ) for header title', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_blog_title4header',
		'section'  => 'larisdigital_section_template_blog',
		'type'     => 'checkbox',
		'active_callback' =>'larisdigital_callback_header_is_active',
	);

	$controls['larisdigital_heading_blog_sidebar_layout'] = array(
		'label'    => esc_html__( 'Sidebar Layout', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_blog_sidebar_layout',
		'section'  => 'larisdigital_section_template_blog',
		'type'     => 'heading',
	);

	$controls['larisdigital_blog_sidebar_layout'] = array(
		'label'    => esc_html__( 'Sidebar Layout', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_blog_sidebar_layout',
		'section'  => 'larisdigital_section_template_blog',
		'type'     => 'select',
		'choices'  => array(
			'' => esc_html__( 'Default', 'larisdigital-wp' ),
			'right' => esc_html__( 'Right Sidebar', 'larisdigital-wp' ),
			'left' => esc_html__( 'Left Sidebar', 'larisdigital-wp' ),
			'none' => esc_html__( 'No Sidebar', 'larisdigital-wp' ),
		),
	);

	$controls['larisdigital_blog_sidebar_width'] = array(
		'label'    => esc_html__( 'Sidebar Width', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_blog_sidebar_width',
		'section'  => 'larisdigital_section_template_blog',
		'type'     => 'select',
		'choices'  => array(
			'' => esc_html__( 'Default', 'larisdigital-wp' ),
			'3' => esc_html__( '3/12 Grid', 'larisdigital-wp' ),
			'4' => esc_html__( '4/12 Grid', 'larisdigital-wp' ),
			'5' => esc_html__( '5/12 Grid', 'larisdigital-wp' ),
			'6' => esc_html__( '6/12 Grid', 'larisdigital-wp' ),
		),
		'active_callback' => 'larisdigital_callback_blog_sidebar_is_active',
	);

	$controls['larisdigital_blog_content_width'] = array(
		'label'    => esc_html__( 'Content Width', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_blog_content_width',
		'section'  => 'larisdigital_section_template_blog',
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
		'active_callback' => 'larisdigital_callback_blog_sidebar_is_not_active',
	);

	$controls['larisdigital_heading_blog_content_box'] = array(
		'label'    => esc_html__( 'Content Box Layout', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_blog_content_box',
		'section'  => 'larisdigital_section_template_blog',
		'type'     => 'heading',
	);
	
	$controls['larisdigital_blog_content_background'] = array(
		'label'    => esc_html__( 'Background Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_blog_content_background',
		'section'  => 'larisdigital_section_template_blog',
		'type'     => 'color',
		'style'    => '.entry.entry-blog .card { background-color: [value] }',
	);

	$controls['larisdigital_blog_content_border'] = array(
		'label'    => esc_html__( 'Border Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_blog_content_border',
		'section'  => 'larisdigital_section_template_blog',
		'type'     => 'color',
		'style'    => '.entry.entry-blog .card { border-color: [value] }',
	);

	$controls['larisdigital_blog_content_padding'] = array(
		'label'    => esc_html__( 'Custom Padding', 'larisdigital-wp' ),
		'description' => esc_html__( 'For tablet & desktop only, when device viewport width >= 768px', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_blog_content_padding',
		'section'  => 'larisdigital_section_template_blog',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 0,
			'max' => 5,
			'step' => 0.1,
			'unit' => 'rem',
		),
		'style'    => ' @media (min-width: 768px) { .entry.entry-blog .card-body { padding: [value]rem; } .entry.entry-blog .card-footer { padding-left: [value]rem; padding-right: [value]rem; } } ',
	);

	$controls['larisdigital_heading_blog_title'] = array(
		'label'    => esc_html__( 'Title', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_blog_title',
		'section'  => 'larisdigital_section_template_blog',
		'type'     => 'heading',
	);

	$controls['larisdigital_blog_title_color'] = array(
		'label'    => esc_html__( 'Text Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_blog_title_color',
		'section'  => 'larisdigital_section_template_blog',
		'type'     => 'color',
		'style'    => '.entry.entry-blog .entry-title, .entry.entry-blog .entry-title a { color: [value] }',
	);

	$controls['larisdigital_blog_title_alignment'] = array(
		'label'    => esc_html__( 'Alignment', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_blog_title_alignment',
		'section'  => 'larisdigital_section_template_blog',
		'type'     => 'radio-iconset',
		'choices'  => array(
			'left' => 'dashicons dashicons-editor-alignleft',
			'center' => 'dashicons dashicons-editor-aligncenter',
			'right' => 'dashicons dashicons-editor-alignright',
		),
		'style'  => array(
			'left' => '.entry.entry-blog .entry-title { text-align: left; }',
			'center' => '.entry.entry-blog .entry-title { text-align: center; }',
			'right' => '.entry.entry-blog .entry-title { text-align: right; }',
		),
	);

	$controls['larisdigital_blog_title_font_size'] = array(
		'label'    => esc_html__( 'Font Size', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_blog_title_font_size',
		'section'  => 'larisdigital_section_template_blog',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 0.5,
			'max' => 4,
			'step' => 0.1,
			'unit' => 'rem',
		),
		'style'    => '.entry.entry-blog .entry-title { font-size: [value]rem }',
	);

	$controls['larisdigital_blog_title_font_weight'] = array(
		'label'    => esc_html__( 'Font Weight', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_blog_title_font_weight',
		'section'  => 'larisdigital_section_template_blog',
		'type'     => 'select',
		'choices'  => array(
			'' => '',
			'normal' => esc_html__( 'Normal', 'larisdigital-wp' ),
			'bold' => esc_html__( 'Bold', 'larisdigital-wp' ),
		),
		'style'  => array(
			'normal' => '.entry.entry-blog .entry-title { font-weight: normal; }',
			'bold' => '.entry.entry-blog .entry-title { font-weight: bold; }',
		),
	);

	$controls['larisdigital_blog_title_font_style'] = array(
		'label'    => esc_html__( 'Font Style', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_blog_title_font_style',
		'section'  => 'larisdigital_section_template_blog',
		'type'     => 'select',
		'choices'  => array(
			'' => '',
			'normal' => esc_html__( 'Normal', 'larisdigital-wp' ),
			'italic' => esc_html__( 'Italic', 'larisdigital-wp' ),
		),
		'style'  => array(
			'normal' => '.entry.entry-blog .entry-title { font-style: normal; }',
			'italic' => '.entry.entry-blog .entry-title { font-style: italic; }',
		),
	);

	$controls['larisdigital_blog_title_text_transform'] = array(
		'label'    => esc_html__( 'Text Transform', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_blog_title_text_transform',
		'section'  => 'larisdigital_section_template_blog',
		'type'     => 'select',
		'choices'  => array(
			'' => '',
			'none' => esc_html__( 'None', 'larisdigital-wp' ),
			'uppercase' => esc_html__( 'Uppercase', 'larisdigital-wp' ),
			'lowercase' => esc_html__( 'Lowercase', 'larisdigital-wp' ),
			'capitalize' => esc_html__( 'Capitalize', 'larisdigital-wp' ),
		),
		'style'  => array(
			'none' => '.entry.entry-blog .entry-title { text-transform: none; }',
			'uppercase' => '.entry.entry-blog .entry-title { text-transform: uppercase; }',
			'lowercase' => '.entry.entry-blog .entry-title { text-transform: lowercase; }',
			'capitalize' => '.entry.entry-blog .entry-title { text-transform: capitalize; }',
		),
	);

	$controls['larisdigital_heading_blog_content'] = array(
		'label'    => esc_html__( 'Content / Excerpt', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_blog_content',
		'section'  => 'larisdigital_section_template_blog',
		'type'     => 'heading',
	);

	$controls['larisdigital_blog_content_alignment'] = array(
		'label'    => esc_html__( 'Alignment', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_blog_content_alignment',
		'section'  => 'larisdigital_section_template_blog',
		'type'     => 'radio-iconset',
		'choices'  => array(
			'left' => 'dashicons dashicons-editor-alignleft',
			'center' => 'dashicons dashicons-editor-aligncenter',
			'right' => 'dashicons dashicons-editor-alignright',
		),
		'style'  => array(
			'left' => '.entry.entry-blog .entry-content { text-align: left; }',
			'center' => '.entry.entry-blog .entry-content { text-align: center; }',
			'right' => '.entry.entry-blog .entry-content { text-align: right; }',
		),
	);

	$controls['larisdigital_heading_blog_more_link'] = array(
		'label'    => esc_html__( 'More Link', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_blog_more_link',
		'section'  => 'larisdigital_section_template_blog',
		'type'     => 'heading',
	);

	$controls['larisdigital_blog_more_link'] = array(
		'label'    => esc_html__( 'Show "Continue Reading &rarr;" more link (if available on current layout)', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_blog_more_link',
		'section'  => 'larisdigital_section_template_blog',
		'type'     => 'checkbox',
	);

	$controls['larisdigital_blog_more_link_text'] = array(
		'label'    => sprintf( esc_html__( 'Change Text: "%s"', 'larisdigital-wp' ), esc_html__( 'Continue reading &rarr;', 'larisdigital-wp' ) ),
		'setting'  => 'larisdigital_blog_more_link_text',
		'section'  => 'larisdigital_section_template_blog',
		'type'     => 'text',
		'active_callback' => 'larisdigital_callback_blog_more_link_is_active',
	);

	$controls['larisdigital_blog_more_link_alignment'] = array(
		'label'    => esc_html__( 'Alignment', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_blog_more_link_alignment',
		'section'  => 'larisdigital_section_template_blog',
		'type'     => 'radio-iconset',
		'choices'  => array(
			'left' => 'dashicons dashicons-editor-alignleft',
			'center' => 'dashicons dashicons-editor-aligncenter',
			'right' => 'dashicons dashicons-editor-alignright',
		),
		'style'  => array(
			'left' => '.entry.entry-blog .entry-more-link { text-align: left; }',
			'center' => '.entry.entry-blog .entry-more-link { text-align: center; }',
			'right' => '.entry.entry-blog .entry-more-link { text-align: right; }',
		),
	);

	$controls['larisdigital_blog_more_link_background'] = array(
		'label'    => esc_html__( 'Background Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_blog_more_link_background',
		'section'  => 'larisdigital_section_template_blog',
		'type'     => 'color',
		'style'    => '.entry.entry-blog a.more-link { background-color: [value] }',
		'active_callback' => 'larisdigital_callback_blog_more_link_is_active',
	);

	$controls['larisdigital_blog_more_link_border'] = array(
		'label'    => esc_html__( 'Border Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_blog_more_link_border',
		'section'  => 'larisdigital_section_template_blog',
		'type'     => 'color',
		'style'    => '.entry.entry-blog a.more-link { border-color: [value] }',
		'active_callback' => 'larisdigital_callback_blog_more_link_is_active',
	);

	$controls['larisdigital_blog_more_link_color'] = array(
		'label'    => esc_html__( 'Text Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_blog_more_link_color',
		'section'  => 'larisdigital_section_template_blog',
		'type'     => 'color',
		'style'    => '.entry.entry-blog a.more-link { color: [value] }',
		'active_callback' => 'larisdigital_callback_blog_more_link_is_active',
	);

	$controls['larisdigital_blog_more_link_background_hover'] = array(
		'label'    => esc_html__( 'Background Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_blog_more_link_background_hover',
		'section'  => 'larisdigital_section_template_blog',
		'type'     => 'color',
		'style'    => '.entry.entry-blog a.more-link:hover { background-color: [value] }',
		'active_callback' => 'larisdigital_callback_blog_more_link_is_active',
	);

	$controls['larisdigital_blog_more_link_border_hover'] = array(
		'label'    => esc_html__( 'Border Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_blog_more_link_border_hover',
		'section'  => 'larisdigital_section_template_blog',
		'type'     => 'color',
		'style'    => '.entry.entry-blog a.more-link:hover { border-color: [value] }',
		'active_callback' => 'larisdigital_callback_blog_more_link_is_active',
	);

	$controls['larisdigital_blog_more_link_color_hover'] = array(
		'label'    => esc_html__( 'Text Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_blog_more_link_color_hover',
		'section'  => 'larisdigital_section_template_blog',
		'type'     => 'color',
		'style'    => '.entry.entry-blog a.more-link:hover { color: [value] }',
		'active_callback' => 'larisdigital_callback_blog_more_link_is_active',
	);

	$controls['larisdigital_heading_blog_meta'] = array(
		'label'    => esc_html__( 'Post Meta', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_blog_meta',
		'section'  => 'larisdigital_section_template_blog',
		'type'     => 'heading',
	);

	$controls['larisdigital_blog_meta'] = array(
		'label'    => esc_html__( 'Show post meta', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_blog_meta',
		'section'  => 'larisdigital_section_template_blog',
		'type'     => 'checkbox',
	);

	$controls['larisdigital_blog_meta_position'] = array(
		'label'    => esc_html__( 'Position', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_blog_meta_position',
		'section'  => 'larisdigital_section_template_blog',
		'type'     => 'radio',
		'choices'  => array(
			'top' => esc_html__( 'Top, Before Content', 'larisdigital-wp' ),
			'bottom' => esc_html__( 'Bottom, After Content', 'larisdigital-wp' ),
		),
		'active_callback' => 'larisdigital_callback_blog_meta_is_active',
	);

	$controls['larisdigital_blog_meta_items'] = array(
		'label'    => esc_html__( 'Post Meta Items', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_blog_meta_items',
		'section'  => 'larisdigital_section_template_blog',
		'type'     => 'sortable',
		'choices'  => array(
			'sticky' => esc_html__( 'Stiky Label', 'larisdigital-wp' ),
			'date' => esc_html__( 'Post Date', 'larisdigital-wp' ),
			'categories' => esc_html__( 'Post Categories', 'larisdigital-wp' ),
			'tags' => esc_html__( 'Post Tags', 'larisdigital-wp' ),
			'author' => esc_html__( 'Post Author', 'larisdigital-wp' ),
		),
		'active_callback' => 'larisdigital_callback_blog_meta_is_active',
	);

	$controls['larisdigital_blog_meta_color'] = array(
		'label'    => esc_html__( 'Text Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_blog_meta_color',
		'section'  => 'larisdigital_section_template_blog',
		'type'     => 'color',
		'style'    => '.entry.entry-blog .entry-meta .entry-meta-item, .entry.entry-blog .entry-meta .entry-meta-item a { color: [value] }',
		'active_callback' => 'larisdigital_callback_blog_meta_is_active',
	);

	$controls['larisdigital_blog_meta_alignment'] = array(
		'label'    => esc_html__( 'Alignment', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_blog_meta_alignment',
		'section'  => 'larisdigital_section_template_blog',
		'type'     => 'radio-iconset',
		'choices'  => array(
			'left' => 'dashicons dashicons-editor-alignleft',
			'center' => 'dashicons dashicons-editor-aligncenter',
			'right' => 'dashicons dashicons-editor-alignright',
		),
		'style'  => array(
			'left' => '.entry.entry-blog .entry-meta { text-align: left; } .entry.entry-blog .entry-meta .entry-meta-item { margin-left:0; margin-right: 1rem; }',
			'center' => '.entry.entry-blog .entry-meta { text-align: center; } .entry.entry-blog .entry-meta .entry-meta-item { margin-left:0.5rem; margin-right: 0.5rem; }',
			'right' => '.entry.entry-blog .entry-meta { text-align: right; } .entry.entry-blog .entry-meta .entry-meta-item { margin-left:1rem; margin-right: 0; }',
		),
		'active_callback' => 'larisdigital_callback_blog_meta_is_active',
	);

	$controls['larisdigital_blog_meta_font_size'] = array(
		'label'    => esc_html__( 'Font Size', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_blog_meta_font_size',
		'section'  => 'larisdigital_section_template_blog',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 0.5,
			'max' => 2,
			'step' => 0.1,
			'unit' => 'rem',
		),
		'style'    => '.entry.entry-blog .entry-meta { font-size: [value]rem }',
		'active_callback' => 'larisdigital_callback_blog_meta_is_active',
	);

	$controls['larisdigital_blog_meta_background'] = array(
		'label'    => esc_html__( 'Background Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_blog_meta_background',
		'section'  => 'larisdigital_section_template_blog',
		'type'     => 'color',
		'style'    => '.entry.entry-blog .entry-meta { background-color: [value] }',
		'active_callback' => 'larisdigital_callback_blog_meta_is_active',
	);

	$controls['larisdigital_blog_meta_border'] = array(
		'label'    => esc_html__( 'Border Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_blog_meta_border',
		'section'  => 'larisdigital_section_template_blog',
		'type'     => 'color',
		'style'    => '.entry.entry-blog .entry-meta { border-color: [value] }',
		'active_callback' => 'larisdigital_callback_blog_meta_is_active',
	);

	$controls['larisdigital_blog_meta_border_all'] = array(
		'label'    => esc_html__( 'Apply border & border radius to all sides (top,right,bottom,left)', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_blog_meta_border_all',
		'section'  => 'larisdigital_section_template_blog',
		'type'     => 'checkbox',
		'style'  => array(
			'on' => '.entry.entry-blog .entry-meta { border-bottom-width: 1px; border-left-width: 1px; border-right-width: 1px; border-style: solid; border-radius: calc(.25rem - 1px); }',
			'off' => '',
		),
		'active_callback' => 'larisdigital_callback_blog_meta_is_active',
	);

	$controls['larisdigital_heading_blog_pagination'] = array(
		'label'    => esc_html__( 'Pagination Style', 'larisdigital-wp' ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-with-icon"><span class="dashicons dashicons-admin-appearance"></span> <a href="javascript:wp.customize.control( \'larisdigital_heading_pagination\' ).focus();">' . sprintf( esc_html__( 'CLICK HERE to setup %s', 'larisdigital-wp' ), esc_html__( 'Pagination Style', 'larisdigital-wp' ) ) . '</a></p>',
		'setting'  => 'larisdigital_heading_blog_pagination',
		'section'  => 'larisdigital_section_template_blog',
		'type'     => 'heading',
	);

	return $controls;
}

add_filter( 'larisdigital_customize_controls', 'larisdigital_customize_controls_template_post' );
function larisdigital_customize_controls_template_post( $controls ) {

	$controls['larisdigital_section_template_post'] = array(
		'title'    => sprintf( esc_html__( 'Template - %s', 'larisdigital-wp' ), esc_html__( 'Single Post', 'larisdigital-wp' ) ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-success larisdigital-alert-with-icon">
							<span class="dashicons dashicons-megaphone"></span>'.sprintf( esc_html__( 'These settings are applied on All %s', 'larisdigital-wp' ), esc_html__( 'Single Post', 'larisdigital-wp' ) ).
						'</p>',
		'setting'  => 'larisdigital_section_template_post',
		'panel'    => 'larisdigital_panel_settings',
		'type'     => 'section',
		'priority' => 330,
	);

	$controls['larisdigital_heading_post_site_header'] = array(
		'label'    => esc_html__( 'Site Header (Title & Description)', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_post_site_header',
		'section'  => 'larisdigital_section_template_post',
		'type'     => 'heading',
		'active_callback' =>'larisdigital_callback_header_is_active',
	);

	$controls['larisdigital_post_header_hide'] = array(
		'label'    => esc_html__( 'HIDE Site Header on All Single Posts', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_post_header_hide',
		'section'  => 'larisdigital_section_template_post',
		'type'     => 'checkbox',
		'active_callback' =>'larisdigital_callback_header_is_active',
	);

	$controls['larisdigital_post_featured4header'] = array(
		'label'    => esc_html__( 'Use featured image for header background image', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_post_featured4header',
		'section'  => 'larisdigital_section_template_post',
		'type'     => 'checkbox',
		'active_callback' =>'larisdigital_callback_header_post_is_active',
	);

	$controls['larisdigital_post_title4header'] = array(
		'label'    => esc_html__( 'Use post title for header title', 'larisdigital-wp' ),
		'description' => esc_html__( 'This setting will also hide current post title on content area', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_post_title4header',
		'section'  => 'larisdigital_section_template_post',
		'type'     => 'checkbox',
		'active_callback' =>'larisdigital_callback_header_post_is_active',
	);

	$controls['larisdigital_heading_post_sidebar_layout'] = array(
		'label'    => esc_html__( 'Sidebar Layout', 'larisdigital-wp' ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-with-icon">
								<span class="dashicons dashicons-admin-tools"></span> <a href="javascript:wp.customize.panel( \'widgets\' ).focus();">'.esc_html__( 'CLICK HERE to setup / manage widgets when sidebar is available', 'larisdigital-wp' ).'</a>
								</p>',
		'setting'  => 'larisdigital_heading_post_sidebar_layout',
		'section'  => 'larisdigital_section_template_post',
		'type'     => 'heading',
	);

	$controls['larisdigital_post_sidebar_layout'] = array(
		'label'    => esc_html__( 'Sidebar Layout', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_post_sidebar_layout',
		'section'  => 'larisdigital_section_template_post',
		'type'     => 'select',
		'choices'  => array(
			'' => esc_html__( 'Default', 'larisdigital-wp' ),
			'right' => esc_html__( 'Right Sidebar', 'larisdigital-wp' ),
			'left' => esc_html__( 'Left Sidebar', 'larisdigital-wp' ),
			'none' => esc_html__( 'No Sidebar', 'larisdigital-wp' ),
		),
	);

	$controls['larisdigital_post_sidebar_width'] = array(
		'label'    => esc_html__( 'Sidebar Width', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_post_sidebar_width',
		'section'  => 'larisdigital_section_template_post',
		'type'     => 'select',
		'choices'  => array(
			'' => esc_html__( 'Default', 'larisdigital-wp' ),
			'3' => esc_html__( '3/12 Grid', 'larisdigital-wp' ),
			'4' => esc_html__( '4/12 Grid', 'larisdigital-wp' ),
			'5' => esc_html__( '5/12 Grid', 'larisdigital-wp' ),
			'6' => esc_html__( '6/12 Grid', 'larisdigital-wp' ),
		),
		'active_callback' => 'larisdigital_callback_post_sidebar_is_active',
	);

	$controls['larisdigital_post_content_width'] = array(
		'label'    => esc_html__( 'Content Width', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_post_content_width',
		'section'  => 'larisdigital_section_template_post',
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
		'active_callback' => 'larisdigital_callback_post_sidebar_is_not_active',
	);

	$controls['larisdigital_heading_post_content_box'] = array(
		'label'    => esc_html__( 'Content Box Layout', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_post_content_box',
		'section'  => 'larisdigital_section_template_post',
		'type'     => 'heading',
	);
	
	$controls['larisdigital_post_content_background'] = array(
		'label'    => esc_html__( 'Background Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_post_content_background',
		'section'  => 'larisdigital_section_template_post',
		'type'     => 'color',
		'style'    => '.entry.entry-post .card { background-color: [value] }',
	);

	$controls['larisdigital_post_content_border'] = array(
		'label'    => esc_html__( 'Border Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_post_content_border',
		'section'  => 'larisdigital_section_template_post',
		'type'     => 'color',
		'style'    => '.entry.entry-post .card { border-color: [value] }',
	);

	$controls['larisdigital_post_content_padding'] = array(
		'label'    => esc_html__( 'Custom Padding', 'larisdigital-wp' ),
		'description' => esc_html__( 'For tablet & desktop only, when device viewport width >= 768px', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_post_content_padding',
		'section'  => 'larisdigital_section_template_post',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 0,
			'max' => 5,
			'step' => 0.1,
			'unit' => 'rem',
		),
		'style'    => ' @media (min-width: 768px) { .entry.entry-post .card-body { padding: [value]rem; } .entry.entry-post .card-footer { padding-left: [value]rem; padding-right: [value]rem; } } ',
	);

	$controls['larisdigital_heading_post_image'] = array(
		'label'    => esc_html__( 'Featured Image', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_post_image',
		'section'  => 'larisdigital_section_template_post',
		'type'     => 'heading',
		'active_callback' => 'larisdigital_callback_post_featured4header_is_not_active',
	);

	$controls['larisdigital_post_image'] = array(
		'label'    => esc_html__( 'Show featured image (if available)', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_post_image',
		'section'  => 'larisdigital_section_template_post',
		'type'     => 'checkbox',
		'active_callback' => 'larisdigital_callback_post_featured4header_is_not_active',
	);

	$controls['larisdigital_heading_post_title'] = array(
		'label'    => esc_html__( 'Title', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_post_title',
		'section'  => 'larisdigital_section_template_post',
		'type'     => 'heading',
		'active_callback' => 'larisdigital_callback_post_title4header_is_not_active',
	);

	$controls['larisdigital_post_title_color'] = array(
		'label'    => esc_html__( 'Text Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_post_title_color',
		'section'  => 'larisdigital_section_template_post',
		'type'     => 'color',
		'style'    => '.entry.entry-post .entry-title { color: [value] }',
		'active_callback' => 'larisdigital_callback_post_title4header_is_not_active',
	);

	$controls['larisdigital_post_title_alignment'] = array(
		'label'    => esc_html__( 'Alignment', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_post_title_alignment',
		'section'  => 'larisdigital_section_template_post',
		'type'     => 'radio-iconset',
		'choices'  => array(
			'left' => 'dashicons dashicons-editor-alignleft',
			'center' => 'dashicons dashicons-editor-aligncenter',
			'right' => 'dashicons dashicons-editor-alignright',
		),
		'style'  => array(
			'left' => '.entry.entry-post .entry-title { text-align: left; }',
			'center' => '.entry.entry-post .entry-title { text-align: center; }',
			'right' => '.entry.entry-post .entry-title { text-align: right; }',
		),
		'active_callback' => 'larisdigital_callback_post_title4header_is_not_active',
	);

	$controls['larisdigital_post_title_font_size'] = array(
		'label'    => esc_html__( 'Font Size', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_post_title_font_size',
		'section'  => 'larisdigital_section_template_post',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 0.5,
			'max' => 4,
			'step' => 0.1,
			'unit' => 'rem',
		),
		'style'    => '.entry.entry-post .entry-title { font-size: [value]rem }',
		'active_callback' => 'larisdigital_callback_post_title4header_is_not_active',
	);

	$controls['larisdigital_post_title_font_weight'] = array(
		'label'    => esc_html__( 'Font Weight', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_post_title_font_weight',
		'section'  => 'larisdigital_section_template_post',
		'type'     => 'select',
		'choices'  => array(
			'' => '',
			'normal' => esc_html__( 'Normal', 'larisdigital-wp' ),
			'bold' => esc_html__( 'Bold', 'larisdigital-wp' ),
		),
		'style'  => array(
			'normal' => '.entry.entry-post .entry-title { font-weight: normal; }',
			'bold' => '.entry.entry-post .entry-title { font-weight: bold; }',
		),
		'active_callback' => 'larisdigital_callback_post_title4header_is_not_active',
	);

	$controls['larisdigital_post_title_font_style'] = array(
		'label'    => esc_html__( 'Font Style', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_post_title_font_style',
		'section'  => 'larisdigital_section_template_post',
		'type'     => 'select',
		'choices'  => array(
			'' => '',
			'normal' => esc_html__( 'Normal', 'larisdigital-wp' ),
			'italic' => esc_html__( 'Italic', 'larisdigital-wp' ),
		),
		'style'  => array(
			'normal' => '.entry.entry-post .entry-title { font-style: normal; }',
			'italic' => '.entry.entry-post .entry-title { font-style: italic; }',
		),
		'active_callback' => 'larisdigital_callback_post_title4header_is_not_active',
	);

	$controls['larisdigital_post_title_text_transform'] = array(
		'label'    => esc_html__( 'Text Transform', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_post_title_text_transform',
		'section'  => 'larisdigital_section_template_post',
		'type'     => 'select',
		'choices'  => array(
			'' => '',
			'none' => esc_html__( 'None', 'larisdigital-wp' ),
			'uppercase' => esc_html__( 'Uppercase', 'larisdigital-wp' ),
			'lowercase' => esc_html__( 'Lowercase', 'larisdigital-wp' ),
			'capitalize' => esc_html__( 'Capitalize', 'larisdigital-wp' ),
		),
		'style'  => array(
			'none' => '.entry.entry-post .entry-title { text-transform: none; }',
			'uppercase' => '.entry.entry-post .entry-title { text-transform: uppercase; }',
			'lowercase' => '.entry.entry-post .entry-title { text-transform: lowercase; }',
			'capitalize' => '.entry.entry-post .entry-title { text-transform: capitalize; }',
		),
		'active_callback' => 'larisdigital_callback_post_title4header_is_not_active',
	);

	$controls['larisdigital_heading_post_content'] = array(
		'label'    => esc_html__( 'Content', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_post_content',
		'section'  => 'larisdigital_section_template_post',
		'type'     => 'heading',
	);

	$controls['larisdigital_post_content_alignment'] = array(
		'label'    => esc_html__( 'Alignment', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_post_content_alignment',
		'section'  => 'larisdigital_section_template_post',
		'type'     => 'radio-iconset',
		'choices'  => array(
			'left' => 'dashicons dashicons-editor-alignleft',
			'center' => 'dashicons dashicons-editor-aligncenter',
			'right' => 'dashicons dashicons-editor-alignright',
		),
		'style'  => array(
			'left' => '.entry.entry-post .entry-content { text-align: left; }',
			'center' => '.entry.entry-post .entry-content { text-align: center; }',
			'right' => '.entry.entry-post .entry-content { text-align: right; }',
		),
	);

	$controls['larisdigital_post_tags_hide'] = array(
		'label'    => esc_html__( 'Hide post tags after content', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_post_tags_hide',
		'section'  => 'larisdigital_section_template_post',
		'type'     => 'checkbox',
	);

	$controls['larisdigital_heading_post_meta'] = array(
		'label'    => esc_html__( 'Post Meta', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_post_meta',
		'section'  => 'larisdigital_section_template_post',
		'type'     => 'heading',
	);

	$controls['larisdigital_post_meta'] = array(
		'label'    => esc_html__( 'Show post meta', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_post_meta',
		'section'  => 'larisdigital_section_template_post',
		'type'     => 'checkbox',
	);

	$controls['larisdigital_post_meta_position'] = array(
		'label'    => esc_html__( 'Position', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_post_meta_position',
		'section'  => 'larisdigital_section_template_post',
		'type'     => 'radio',
		'choices'  => array(
			'top' => esc_html__( 'Top, Before Content', 'larisdigital-wp' ),
			'bottom' => esc_html__( 'Bottom, After Content', 'larisdigital-wp' ),
		),
		'active_callback' => 'larisdigital_callback_post_meta_is_active',
	);

	$controls['larisdigital_post_meta_items'] = array(
		'label'    => esc_html__( 'Post Meta Items', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_post_meta_items',
		'section'  => 'larisdigital_section_template_post',
		'type'     => 'sortable',
		'choices'  => array(
			'sticky' => esc_html__( 'Stiky Label', 'larisdigital-wp' ),
			'date' => esc_html__( 'Post Date', 'larisdigital-wp' ),
			'categories' => esc_html__( 'Post Categories', 'larisdigital-wp' ),
			'tags' => esc_html__( 'Post Tags', 'larisdigital-wp' ),
			'author' => esc_html__( 'Post Author', 'larisdigital-wp' ),
		),
		'active_callback' => 'larisdigital_callback_post_meta_is_active',
	);

	$controls['larisdigital_post_meta_color'] = array(
		'label'    => esc_html__( 'Text Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_post_meta_color',
		'section'  => 'larisdigital_section_template_post',
		'type'     => 'color',
		'style'    => '.entry.entry-post .entry-meta .entry-meta-item, .entry.entry-post .entry-meta .entry-meta-item a { color: [value] }',
		'active_callback' => 'larisdigital_callback_post_meta_is_active',
	);

	$controls['larisdigital_post_meta_alignment'] = array(
		'label'    => esc_html__( 'Alignment', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_post_meta_alignment',
		'section'  => 'larisdigital_section_template_post',
		'type'     => 'radio-iconset',
		'choices'  => array(
			'left' => 'dashicons dashicons-editor-alignleft',
			'center' => 'dashicons dashicons-editor-aligncenter',
			'right' => 'dashicons dashicons-editor-alignright',
		),
		'style'  => array(
			'left' => '.entry.entry-post .entry-meta { text-align: left; } .entry.entry-post .entry-meta .entry-meta-item { margin-left:0; margin-right: 1rem; }',
			'center' => '.entry.entry-post .entry-meta { text-align: center; } .entry.entry-post .entry-meta .entry-meta-item { margin-left:0.5rem; margin-right: 0.5rem; }',
			'right' => '.entry.entry-post .entry-meta { text-align: right; } .entry.entry-post .entry-meta .entry-meta-item { margin-left:1rem; margin-right: 0; }',
		),
		'active_callback' => 'larisdigital_callback_post_meta_is_active',
	);

	$controls['larisdigital_post_meta_font_size'] = array(
		'label'    => esc_html__( 'Font Size', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_post_meta_font_size',
		'section'  => 'larisdigital_section_template_post',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 0.5,
			'max' => 2,
			'step' => 0.1,
			'unit' => 'rem',
		),
		'style'    => '.entry.entry-post .entry-meta { font-size: [value]rem }',
		'active_callback' => 'larisdigital_callback_post_meta_is_active',
	);

	$controls['larisdigital_post_meta_background'] = array(
		'label'    => esc_html__( 'Background Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_post_meta_background',
		'section'  => 'larisdigital_section_template_post',
		'type'     => 'color',
		'style'    => '.entry.entry-post .entry-meta { background-color: [value] }',
		'active_callback' => 'larisdigital_callback_post_meta_is_active',
	);

	$controls['larisdigital_post_meta_border'] = array(
		'label'    => esc_html__( 'Border Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_post_meta_border',
		'section'  => 'larisdigital_section_template_post',
		'type'     => 'color',
		'style'    => '.entry.entry-post .entry-meta { border-color: [value] }',
		'active_callback' => 'larisdigital_callback_post_meta_is_active',
	);

	$controls['larisdigital_post_meta_border_all'] = array(
		'label'    => esc_html__( 'Apply border & border radius to all sides (top,right,bottom,left)', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_post_meta_border_all',
		'section'  => 'larisdigital_section_template_post',
		'type'     => 'checkbox',
		'style'  => array(
			'on' => '.entry.entry-post .entry-meta { border-bottom-width: 1px; border-left-width: 1px; border-right-width: 1px; border-style: solid; border-radius: calc(.25rem - 1px); }',
			'off' => '',
		),
		'active_callback' => 'larisdigital_callback_post_meta_is_active',
	);

	$controls['larisdigital_heading_post_share'] = array(
		'label'    => esc_html__( 'Social Share', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_post_share',
		'section'  => 'larisdigital_section_template_post',
		'type'     => 'heading',
	);

	$controls['larisdigital_post_share'] = array(
		'label'    => esc_html__( 'Show social share after post content', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_post_share',
		'section'  => 'larisdigital_section_template_post',
		'type'     => 'checkbox',
	);

	$controls['larisdigital_post_share_items'] = array(
		'label'    => esc_html__( 'Social Share Items', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_post_share_items',
		'section'  => 'larisdigital_section_template_post',
		'type'     => 'sortable',
		'choices'  => array(
			'facebook' => esc_html__( 'Facebook', 'larisdigital-wp' ),
			'twitter' => esc_html__( 'Twitter', 'larisdigital-wp' ),
			// 'google-plus' => esc_html__( 'Google Plus', 'larisdigital-wp' ),
			'linkedin' => esc_html__( 'Linkedin', 'larisdigital-wp' ),
			'pinterest' => esc_html__( 'Pinterest', 'larisdigital-wp' ),
			'whatsapp' => esc_html__( 'WhatsApp', 'larisdigital-wp' ),
			'telegram' => esc_html__( 'Telegram', 'larisdigital-wp' ),
		),
		'active_callback' => 'larisdigital_callback_post_share_is_active',
	);

	$controls['larisdigital_heading_post_comments'] = array(
		'label'    => esc_html__( 'Comments', 'larisdigital-wp' ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-with-icon">
						<span class="dashicons dashicons-admin-tools"></span> <a href="javascript:wp.customize.section( \'larisdigital_section_comments\' ).focus();">'.esc_html__( 'CLICK HERE to change text on comments area.', 'larisdigital-wp' ).'</a>
						</p>',
		'setting'  => 'larisdigital_heading_post_comments',
		'section'  => 'larisdigital_section_template_post',
		'type'     => 'heading',
	);

	$controls['larisdigital_post_comments'] = array(
		'label'    => esc_html__( 'Show comments (if enabled on current page)', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_post_comments',
		'section'  => 'larisdigital_section_template_post',
		'type'     => 'checkbox',
	);

	return $controls;
}

add_filter( 'larisdigital_customize_controls', 'larisdigital_customize_controls_template_page' );
function larisdigital_customize_controls_template_page( $controls ) {

	$controls['larisdigital_section_template_page'] = array(
		'title'    => sprintf( esc_html__( 'Template - %s', 'larisdigital-wp' ), esc_html__( 'Single Page', 'larisdigital-wp' ) ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-success larisdigital-alert-with-icon">
							<span class="dashicons dashicons-megaphone"></span>'.sprintf( esc_html__( 'These settings are applied on All %s', 'larisdigital-wp' ), esc_html__( 'Single Page', 'larisdigital-wp' ) ).
						'</p>',
		'setting'  => 'larisdigital_section_template_page',
		'panel'    => 'larisdigital_panel_settings',
		'type'     => 'section',
		'priority' => 340,
	);

	$controls['larisdigital_heading_page_site_header'] = array(
		'label'    => esc_html__( 'Site Header (Title & Description)', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_page_site_header',
		'section'  => 'larisdigital_section_template_page',
		'type'     => 'heading',
		'active_callback' =>'larisdigital_callback_header_is_active',
	);

	$controls['larisdigital_page_header_hide'] = array(
		'label'    => esc_html__( 'HIDE Site Header on All Single Pages', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_page_header_hide',
		'section'  => 'larisdigital_section_template_page',
		'type'     => 'checkbox',
		'active_callback' =>'larisdigital_callback_header_is_active',
	);

	$controls['larisdigital_page_featured4header'] = array(
		'label'    => esc_html__( 'Use featured image for header background image', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_page_featured4header',
		'section'  => 'larisdigital_section_template_page',
		'type'     => 'checkbox',
		'active_callback' =>'larisdigital_callback_header_page_is_active',
	);

	$controls['larisdigital_page_title4header'] = array(
		'label'    => esc_html__( 'Use page title for header title', 'larisdigital-wp' ),
		'description' => esc_html__( 'This setting will also hide current post title on content area', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_page_title4header',
		'section'  => 'larisdigital_section_template_page',
		'type'     => 'checkbox',
		'active_callback' =>'larisdigital_callback_header_page_is_active',
	);

	$controls['larisdigital_heading_page_sidebar_layout'] = array(
		'label'    => esc_html__( 'Sidebar Layout', 'larisdigital-wp' ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-with-icon">
								<span class="dashicons dashicons-admin-tools"></span> <a href="javascript:wp.customize.panel( \'widgets\' ).focus();">'.esc_html__( 'CLICK HERE to setup / manage widgets when sidebar is available', 'larisdigital-wp' ).'</a>
								</p>',
		'setting'  => 'larisdigital_heading_page_sidebar_layout',
		'section'  => 'larisdigital_section_template_page',
		'type'     => 'heading',
	);

	$controls['larisdigital_page_sidebar_layout'] = array(
		'label'    => esc_html__( 'Sidebar Layout', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_page_sidebar_layout',
		'section'  => 'larisdigital_section_template_page',
		'type'     => 'select',
		'choices'  => array(
			'' => esc_html__( 'Default', 'larisdigital-wp' ),
			'right' => esc_html__( 'Right Sidebar', 'larisdigital-wp' ),
			'left' => esc_html__( 'Left Sidebar', 'larisdigital-wp' ),
			'none' => esc_html__( 'No Sidebar', 'larisdigital-wp' ),
		),
	);

	$controls['larisdigital_page_sidebar_width'] = array(
		'label'    => esc_html__( 'Sidebar Width', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_page_sidebar_width',
		'section'  => 'larisdigital_section_template_page',
		'type'     => 'select',
		'choices'  => array(
			'' => esc_html__( 'Default', 'larisdigital-wp' ),
			'3' => esc_html__( '3/12 Grid', 'larisdigital-wp' ),
			'4' => esc_html__( '4/12 Grid', 'larisdigital-wp' ),
			'5' => esc_html__( '5/12 Grid', 'larisdigital-wp' ),
			'6' => esc_html__( '6/12 Grid', 'larisdigital-wp' ),
		),
		'active_callback' => 'larisdigital_callback_page_sidebar_is_active',
	);

	$controls['larisdigital_page_content_width'] = array(
		'label'    => esc_html__( 'Content Width', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_page_content_width',
		'section'  => 'larisdigital_section_template_page',
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
		'active_callback' => 'larisdigital_callback_page_sidebar_is_not_active',
	);

	$controls['larisdigital_heading_page_content_box'] = array(
		'label'    => esc_html__( 'Content Box Layout', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_page_content_box',
		'section'  => 'larisdigital_section_template_page',
		'type'     => 'heading',
	);
	
	$controls['larisdigital_page_content_background'] = array(
		'label'    => esc_html__( 'Background Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_page_content_background',
		'section'  => 'larisdigital_section_template_page',
		'type'     => 'color',
		'style'    => '.entry.entry-page .card { background-color: [value] }',
	);

	$controls['larisdigital_page_content_border'] = array(
		'label'    => esc_html__( 'Border Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_page_content_border',
		'section'  => 'larisdigital_section_template_page',
		'type'     => 'color',
		'style'    => '.entry.entry-page .card { border-color: [value] }',
	);

	$controls['larisdigital_page_content_padding'] = array(
		'label'    => esc_html__( 'Custom Padding', 'larisdigital-wp' ),
		'description' => esc_html__( 'For tablet & desktop only, when device viewport width >= 768px', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_page_content_padding',
		'section'  => 'larisdigital_section_template_page',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 0,
			'max' => 5,
			'step' => 0.1,
			'unit' => 'rem',
		),
		'style'    => ' @media (min-width: 768px) { .entry.entry-page .card-body { padding: [value]rem; } .entry.entry-page .card-footer { padding-left: [value]rem; padding-right: [value]rem; } } ',
	);

	$controls['larisdigital_heading_page_image'] = array(
		'label'    => esc_html__( 'Featured Image', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_page_image',
		'section'  => 'larisdigital_section_template_page',
		'type'     => 'heading',
		'active_callback' => 'larisdigital_callback_page_featured4header_is_not_active',
	);

	$controls['larisdigital_page_image'] = array(
		'label'    => esc_html__( 'Show featured image (if available)', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_page_image',
		'section'  => 'larisdigital_section_template_page',
		'type'     => 'checkbox',
		'active_callback' => 'larisdigital_callback_page_featured4header_is_not_active',
	);

	$controls['larisdigital_heading_page_title'] = array(
		'label'    => esc_html__( 'Title', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_page_title',
		'section'  => 'larisdigital_section_template_page',
		'type'     => 'heading',
		'active_callback' => 'larisdigital_callback_page_title4header_is_not_active',
	);

	$controls['larisdigital_page_title_color'] = array(
		'label'    => esc_html__( 'Text Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_page_title_color',
		'section'  => 'larisdigital_section_template_page',
		'type'     => 'color',
		'style'    => '.entry.entry-page .entry-title { color: [value] }',
		'active_callback' => 'larisdigital_callback_page_title4header_is_not_active',
	);

	$controls['larisdigital_page_title_alignment'] = array(
		'label'    => esc_html__( 'Alignment', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_page_title_alignment',
		'section'  => 'larisdigital_section_template_page',
		'type'     => 'radio-iconset',
		'choices'  => array(
			'left' => 'dashicons dashicons-editor-alignleft',
			'center' => 'dashicons dashicons-editor-aligncenter',
			'right' => 'dashicons dashicons-editor-alignright',
		),
		'style'  => array(
			'left' => '.entry.entry-page .entry-title { text-align: left; }',
			'center' => '.entry.entry-page .entry-title { text-align: center; }',
			'right' => '.entry.entry-page .entry-title { text-align: right; }',
		),
		'active_callback' => 'larisdigital_callback_page_title4header_is_not_active',
	);

	$controls['larisdigital_page_title_font_size'] = array(
		'label'    => esc_html__( 'Font Size', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_page_title_font_size',
		'section'  => 'larisdigital_section_template_page',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 0.5,
			'max' => 4,
			'step' => 0.1,
			'unit' => 'rem',
		),
		'style'    => '.entry.entry-page .entry-title { font-size: [value]rem }',
		'active_callback' => 'larisdigital_callback_page_title4header_is_not_active',
	);

	$controls['larisdigital_page_title_font_weight'] = array(
		'label'    => esc_html__( 'Font Weight', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_page_title_font_weight',
		'section'  => 'larisdigital_section_template_page',
		'type'     => 'select',
		'choices'  => array(
			'' => '',
			'normal' => esc_html__( 'Normal', 'larisdigital-wp' ),
			'bold' => esc_html__( 'Bold', 'larisdigital-wp' ),
		),
		'style'  => array(
			'normal' => '.entry.entry-page .entry-title { font-weight: normal; }',
			'bold' => '.entry.entry-page .entry-title { font-weight: bold; }',
		),
		'active_callback' => 'larisdigital_callback_page_title4header_is_not_active',
	);

	$controls['larisdigital_page_title_font_style'] = array(
		'label'    => esc_html__( 'Font Style', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_page_title_font_style',
		'section'  => 'larisdigital_section_template_page',
		'type'     => 'select',
		'choices'  => array(
			'' => '',
			'normal' => esc_html__( 'Normal', 'larisdigital-wp' ),
			'italic' => esc_html__( 'Italic', 'larisdigital-wp' ),
		),
		'style'  => array(
			'normal' => '.entry.entry-page .entry-title { font-style: normal; }',
			'italic' => '.entry.entry-page .entry-title { font-style: italic; }',
		),
		'active_callback' => 'larisdigital_callback_page_title4header_is_not_active',
	);

	$controls['larisdigital_page_title_text_transform'] = array(
		'label'    => esc_html__( 'Text Transform', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_page_title_text_transform',
		'section'  => 'larisdigital_section_template_page',
		'type'     => 'select',
		'choices'  => array(
			'' => '',
			'none' => esc_html__( 'None', 'larisdigital-wp' ),
			'uppercase' => esc_html__( 'Uppercase', 'larisdigital-wp' ),
			'lowercase' => esc_html__( 'Lowercase', 'larisdigital-wp' ),
			'capitalize' => esc_html__( 'Capitalize', 'larisdigital-wp' ),
		),
		'style'  => array(
			'none' => '.entry.entry-page .entry-title { text-transform: none; }',
			'uppercase' => '.entry.entry-page .entry-title { text-transform: uppercase; }',
			'lowercase' => '.entry.entry-page .entry-title { text-transform: lowercase; }',
			'capitalize' => '.entry.entry-page .entry-title { text-transform: capitalize; }',
		),
		'active_callback' => 'larisdigital_callback_page_title4header_is_not_active',
	);

	$controls['larisdigital_heading_page_content'] = array(
		'label'    => esc_html__( 'Content', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_page_content',
		'section'  => 'larisdigital_section_template_page',
		'type'     => 'heading',
	);

	$controls['larisdigital_page_content_alignment'] = array(
		'label'    => esc_html__( 'Alignment', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_page_content_alignment',
		'section'  => 'larisdigital_section_template_page',
		'type'     => 'radio-iconset',
		'choices'  => array(
			'left' => 'dashicons dashicons-editor-alignleft',
			'center' => 'dashicons dashicons-editor-aligncenter',
			'right' => 'dashicons dashicons-editor-alignright',
		),
		'style'  => array(
			'left' => '.entry.entry-page .entry-content { text-align: left; }',
			'center' => '.entry.entry-page .entry-content { text-align: center; }',
			'right' => '.entry.entry-page .entry-content { text-align: right; }',
		),
	);

	$controls['larisdigital_heading_page_comments'] = array(
		'label'    => esc_html__( 'Comments', 'larisdigital-wp' ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-with-icon">
						<span class="dashicons dashicons-admin-tools"></span> <a href="javascript:wp.customize.section( \'larisdigital_section_comments\' ).focus();">'.esc_html__( 'CLICK HERE to change text on comments area.', 'larisdigital-wp' ).'</a>
						</p>',
		'setting'  => 'larisdigital_heading_page_comments',
		'section'  => 'larisdigital_section_template_page',
		'type'     => 'heading',
	);

	$controls['larisdigital_page_comments'] = array(
		'label'    => esc_html__( 'Show comments (if enabled on current page)', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_page_comments',
		'section'  => 'larisdigital_section_template_page',
		'type'     => 'checkbox',
	);

	return $controls;
}

add_filter( 'larisdigital_customize_controls', 'larisdigital_customize_controls_template_attachment' );
function larisdigital_customize_controls_template_attachment( $controls ) {

	$controls['larisdigital_section_template_attachment'] = array(
		'title'    => sprintf( esc_html__( 'Template - %s', 'larisdigital-wp' ), esc_html__( 'Attachment / Media', 'larisdigital-wp' ) ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-success larisdigital-alert-with-icon">
							<span class="dashicons dashicons-megaphone"></span>'.sprintf( esc_html__( 'These settings are applied on All %s', 'larisdigital-wp' ), esc_html__( 'Attachment Page', 'larisdigital-wp' ) ).
						'</p>',
		'setting'  => 'larisdigital_section_template_attachment',
		'panel'    => 'larisdigital_panel_settings',
		'type'     => 'section',
		'priority' => 350,
	);

	$controls['larisdigital_heading_attachment_site_header'] = array(
		'label'    => esc_html__( 'Site Header (Title & Description)', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_attachment_site_header',
		'section'  => 'larisdigital_section_template_attachment',
		'type'     => 'heading',
		'active_callback' =>'larisdigital_callback_header_is_active',
	);

	$controls['larisdigital_attachment_header_hide'] = array(
		'label'    => esc_html__( 'HIDE Site Header on All Attachment / Media Pages', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_attachment_header_hide',
		'section'  => 'larisdigital_section_template_attachment',
		'type'     => 'checkbox',
		'active_callback' =>'larisdigital_callback_header_is_active',
	);

	$controls['larisdigital_attachment_title4header'] = array(
		'label'    => esc_html__( 'Use attachment title for header title', 'larisdigital-wp' ),
		'description' => esc_html__( 'This setting will also hide current post title on content area', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_attachment_title4header',
		'section'  => 'larisdigital_section_template_attachment',
		'type'     => 'checkbox',
		'active_callback' =>'larisdigital_callback_header_attachment_is_active',
	);

	$controls['larisdigital_heading_attachment_sidebar_layout'] = array(
		'label'    => esc_html__( 'Sidebar Layout', 'larisdigital-wp' ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-with-icon">
								<span class="dashicons dashicons-admin-tools"></span> <a href="javascript:wp.customize.panel( \'widgets\' ).focus();">'.esc_html__( 'CLICK HERE to setup / manage widgets when sidebar is available', 'larisdigital-wp' ).'</a>
								</p>',
		'setting'  => 'larisdigital_heading_attachment_sidebar_layout',
		'section'  => 'larisdigital_section_template_attachment',
		'type'     => 'heading',
	);

	$controls['larisdigital_attachment_sidebar_layout'] = array(
		'label'    => esc_html__( 'Sidebar Layout', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_attachment_sidebar_layout',
		'section'  => 'larisdigital_section_template_attachment',
		'type'     => 'select',
		'choices'  => array(
			'' => esc_html__( 'Default', 'larisdigital-wp' ),
			'right' => esc_html__( 'Right Sidebar', 'larisdigital-wp' ),
			'left' => esc_html__( 'Left Sidebar', 'larisdigital-wp' ),
			'none' => esc_html__( 'No Sidebar', 'larisdigital-wp' ),
		),
	);

	$controls['larisdigital_attachment_sidebar_width'] = array(
		'label'    => esc_html__( 'Sidebar Width', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_attachment_sidebar_width',
		'section'  => 'larisdigital_section_template_attachment',
		'type'     => 'select',
		'choices'  => array(
			'' => esc_html__( 'Default', 'larisdigital-wp' ),
			'3' => esc_html__( '3/12 Grid', 'larisdigital-wp' ),
			'4' => esc_html__( '4/12 Grid', 'larisdigital-wp' ),
			'5' => esc_html__( '5/12 Grid', 'larisdigital-wp' ),
			'6' => esc_html__( '6/12 Grid', 'larisdigital-wp' ),
		),
		'active_callback' => 'larisdigital_callback_attachment_sidebar_is_active',
	);

	$controls['larisdigital_attachment_content_width'] = array(
		'label'    => esc_html__( 'Content Width', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_attachment_content_width',
		'section'  => 'larisdigital_section_template_attachment',
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
		'active_callback' => 'larisdigital_callback_attachment_sidebar_is_not_active',
	);

	$controls['larisdigital_heading_attachment_content_box'] = array(
		'label'    => esc_html__( 'Content Box Layout', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_attachment_content_box',
		'section'  => 'larisdigital_section_template_attachment',
		'type'     => 'heading',
	);
	
	$controls['larisdigital_attachment_content_background'] = array(
		'label'    => esc_html__( 'Background Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_attachment_content_background',
		'section'  => 'larisdigital_section_template_attachment',
		'type'     => 'color',
		'style'    => '.entry.entry-attachment .card { background-color: [value] }',
	);

	$controls['larisdigital_attachment_content_border'] = array(
		'label'    => esc_html__( 'Border Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_attachment_content_border',
		'section'  => 'larisdigital_section_template_attachment',
		'type'     => 'color',
		'style'    => '.entry.entry-attachment .card { border-color: [value] }',
	);

	$controls['larisdigital_attachment_content_padding'] = array(
		'label'    => esc_html__( 'Custom Padding', 'larisdigital-wp' ),
		'description' => esc_html__( 'For tablet & desktop only, when device viewport width >= 768px', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_attachment_content_padding',
		'section'  => 'larisdigital_section_template_attachment',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 0,
			'max' => 5,
			'step' => 0.1,
			'unit' => 'rem',
		),
		'style'    => ' @media (min-width: 768px) { .entry.entry-attachment .card-body { padding: [value]rem; } .entry.entry-attachment .card-footer { padding-left: [value]rem; padding-right: [value]rem; } } ',
	);

	$controls['larisdigital_heading_attachment_title'] = array(
		'label'    => esc_html__( 'Title', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_attachment_title',
		'section'  => 'larisdigital_section_template_attachment',
		'type'     => 'heading',
		'active_callback' => 'larisdigital_callback_attachment_title4header_is_not_active',
	);

	$controls['larisdigital_attachment_title_color'] = array(
		'label'    => esc_html__( 'Text Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_attachment_title_color',
		'section'  => 'larisdigital_section_template_attachment',
		'type'     => 'color',
		'style'    => '.entry.entry-attachment .entry-title { color: [value] }',
		'active_callback' => 'larisdigital_callback_attachment_title4header_is_not_active',
	);

	$controls['larisdigital_attachment_title_alignment'] = array(
		'label'    => esc_html__( 'Alignment', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_attachment_title_alignment',
		'section'  => 'larisdigital_section_template_attachment',
		'type'     => 'radio-iconset',
		'choices'  => array(
			'left' => 'dashicons dashicons-editor-alignleft',
			'center' => 'dashicons dashicons-editor-aligncenter',
			'right' => 'dashicons dashicons-editor-alignright',
		),
		'style'  => array(
			'left' => '.entry.entry-attachment .entry-title { text-align: left; }',
			'center' => '.entry.entry-attachment .entry-title { text-align: center; }',
			'right' => '.entry.entry-attachment .entry-title { text-align: right; }',
		),
		'active_callback' => 'larisdigital_callback_attachment_title4header_is_not_active',
	);

	$controls['larisdigital_attachment_title_font_size'] = array(
		'label'    => esc_html__( 'Font Size', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_attachment_title_font_size',
		'section'  => 'larisdigital_section_template_attachment',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 0.5,
			'max' => 4,
			'step' => 0.1,
			'unit' => 'rem',
		),
		'style'    => '.entry.entry-attachment .entry-title { font-size: [value]rem }',
		'active_callback' => 'larisdigital_callback_attachment_title4header_is_not_active',
	);

	$controls['larisdigital_attachment_title_font_weight'] = array(
		'label'    => esc_html__( 'Font Weight', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_attachment_title_font_weight',
		'section'  => 'larisdigital_section_template_attachment',
		'type'     => 'select',
		'choices'  => array(
			'' => '',
			'normal' => esc_html__( 'Normal', 'larisdigital-wp' ),
			'bold' => esc_html__( 'Bold', 'larisdigital-wp' ),
		),
		'style'  => array(
			'normal' => '.entry.entry-attachment .entry-title { font-weight: normal; }',
			'bold' => '.entry.entry-attachment .entry-title { font-weight: bold; }',
		),
		'active_callback' => 'larisdigital_callback_attachment_title4header_is_not_active',
	);

	$controls['larisdigital_attachment_title_font_style'] = array(
		'label'    => esc_html__( 'Font Style', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_attachment_title_font_style',
		'section'  => 'larisdigital_section_template_attachment',
		'type'     => 'select',
		'choices'  => array(
			'' => '',
			'normal' => esc_html__( 'Normal', 'larisdigital-wp' ),
			'italic' => esc_html__( 'Italic', 'larisdigital-wp' ),
		),
		'style'  => array(
			'normal' => '.entry.entry-attachment .entry-title { font-style: normal; }',
			'italic' => '.entry.entry-attachment .entry-title { font-style: italic; }',
		),
		'active_callback' => 'larisdigital_callback_attachment_title4header_is_not_active',
	);

	$controls['larisdigital_attachment_title_text_transform'] = array(
		'label'    => esc_html__( 'Text Transform', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_attachment_title_text_transform',
		'section'  => 'larisdigital_section_template_attachment',
		'type'     => 'select',
		'choices'  => array(
			'' => '',
			'none' => esc_html__( 'None', 'larisdigital-wp' ),
			'uppercase' => esc_html__( 'Uppercase', 'larisdigital-wp' ),
			'lowercase' => esc_html__( 'Lowercase', 'larisdigital-wp' ),
			'capitalize' => esc_html__( 'Capitalize', 'larisdigital-wp' ),
		),
		'style'  => array(
			'none' => '.entry.entry-attachment .entry-title { text-transform: none; }',
			'uppercase' => '.entry.entry-attachment .entry-title { text-transform: uppercase; }',
			'lowercase' => '.entry.entry-attachment .entry-title { text-transform: lowercase; }',
			'capitalize' => '.entry.entry-attachment .entry-title { text-transform: capitalize; }',
		),
		'active_callback' => 'larisdigital_callback_attachment_title4header_is_not_active',
	);

	$controls['larisdigital_heading_attachment_content'] = array(
		'label'    => esc_html__( 'Content', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_attachment_content',
		'section'  => 'larisdigital_section_template_attachment',
		'type'     => 'heading',
	);

	$controls['larisdigital_attachment_content_alignment'] = array(
		'label'    => esc_html__( 'Alignment', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_attachment_content_alignment',
		'section'  => 'larisdigital_section_template_attachment',
		'type'     => 'radio-iconset',
		'choices'  => array(
			'left' => 'dashicons dashicons-editor-alignleft',
			'center' => 'dashicons dashicons-editor-aligncenter',
			'right' => 'dashicons dashicons-editor-alignright',
		),
		'style'  => array(
			'left' => '.entry.entry-attachment .entry-content { text-align: left; }',
			'center' => '.entry.entry-attachment .entry-content { text-align: center; }',
			'right' => '.entry.entry-attachment .entry-content { text-align: right; }',
		),
	);

	return $controls;
}

add_filter( 'larisdigital_customize_controls', 'larisdigital_customize_controls_footer_widgets' );
function larisdigital_customize_controls_footer_widgets( $controls ) {

	$controls['larisdigital_section_footer_widgets'] = array(
		'title'    => esc_html__( 'Site Footer Widgets', 'larisdigital-wp' ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-success larisdigital-alert-with-icon">
							<span class="dashicons dashicons-megaphone"></span> '.sprintf( esc_html__( '%s can be disabled on a post/page using "%s" metabox when editing a post/page', 'larisdigital-wp' ), esc_html__( 'Site Footer Widgets', 'larisdigital-wp' ), esc_html__( 'Page Layout', 'larisdigital-wp' ) ).'
							</p>',
		'setting'  => 'larisdigital_section_footer_widgets',
		'panel'    => 'larisdigital_panel_settings',
		'type'     => 'section',
		'priority' => 410,
	);

	$controls['larisdigital_footer_widgets_hide'] = array(
		'label'    => sprintf( esc_html__( 'HIDE %s Globally', 'larisdigital-wp' ), esc_html__( 'Site Footer Widgets', 'larisdigital-wp' ) ),
		'setting'  => 'larisdigital_footer_widgets_hide',
		'section'  => 'larisdigital_section_footer_widgets',
		'type'     => 'checkbox',
	);

	$controls['larisdigital_footer_widgets_background'] = array(
		'label'    => esc_html__( 'Background Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_footer_widgets_background',
		'section'  => 'larisdigital_section_footer_widgets',
		'type'     => 'color',
		'style'    => '.site-footer-widgets, .site-footer-widgets .widget ul li { background-color: [value] }',
		'active_callback' => 'larisdigital_callback_footer_widgets_is_active',
	);

	$controls['larisdigital_heading_footer_widgets'] = array(
		'label'    => esc_html__( 'Widget', 'larisdigital-wp' ),
		'description' 		=> '<p class="larisdigital-alert larisdigital-alert-with-icon">
								<span class="dashicons dashicons-admin-tools"></span> <a href="javascript:wp.customize.panel( \'widgets\' ).focus();">'.esc_html__( 'CLICK HERE to setup / manage widgets on Site Footer Widgets', 'larisdigital-wp' ).'</a>
								</p>',
		'setting'  => 'larisdigital_heading_footer_widgets',
		'section'  => 'larisdigital_section_footer_widgets',
		'type'     => 'heading',
		'active_callback' => 'larisdigital_callback_footer_widgets_is_active',
	);

	$controls['larisdigital_footer_widgets_color'] = array(
		'label'    => esc_html__( 'Text Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_footer_widgets_color',
		'section'  => 'larisdigital_section_footer_widgets',
		'type'     => 'color',
		'style'    => '.site-footer-widgets .widget, .site-footer-widgets .widget caption { color: [value] }',
		'active_callback' => 'larisdigital_callback_footer_widgets_is_active',
	);

	$controls['larisdigital_footer_widgets_link'] = array(
		'label'    => esc_html__( 'Link Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_footer_widgets_link',
		'section'  => 'larisdigital_section_footer_widgets',
		'type'     => 'color',
		'style'    => '.site-footer-widgets .widget a { color: [value] }',
		'active_callback' => 'larisdigital_callback_footer_widgets_is_active',
	);

	$controls['larisdigital_footer_widgets_link_hover'] = array(
		'label'    => esc_html__( 'Link Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_footer_widgets_link_hover',
		'section'  => 'larisdigital_section_footer_widgets',
		'type'     => 'color',
		'style'    => '.site-footer-widgets .widget a:hover { color: [value] }',
		'active_callback' => 'larisdigital_callback_footer_widgets_is_active',
	);

	$controls['larisdigital_footer_widgets_font_size'] = array(
		'label'    => esc_html__( 'Font Size', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_footer_widgets_font_size',
		'section'  => 'larisdigital_section_footer_widgets',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 0.5,
			'max' => 2,
			'step' => 0.1,
			'unit' => 'rem',
		),
		'style'    => '.site-footer-widgets .widget { font-size: [value]rem }',
		'active_callback' => 'larisdigital_callback_footer_widgets_is_active',
	);

	$controls['larisdigital_heading_footer_widgets_title'] = array(
		'label'    => esc_html__( 'Widget Title', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_footer_widgets_title',
		'section'  => 'larisdigital_section_footer_widgets',
		'type'     => 'heading',
		'active_callback' => 'larisdigital_callback_footer_widgets_is_active',
	);

	$controls['larisdigital_footer_widgets_title_color'] = array(
		'label'    => esc_html__( 'Text Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_footer_widgets_title_color',
		'section'  => 'larisdigital_section_footer_widgets',
		'type'     => 'color',
		'style'    => '.site-footer-widgets .widget .widget-title, .site-footer-widgets .widget .widget-title a { color: [value] }',
		'active_callback' => 'larisdigital_callback_footer_widgets_is_active',
	);

	$controls['larisdigital_footer_widgets_title_font_size'] = array(
		'label'    => esc_html__( 'Font Size', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_footer_widgets_title_font_size',
		'section'  => 'larisdigital_section_footer_widgets',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 0.5,
			'max' => 2.5,
			'step' => 0.05,
			'unit' => 'rem',
		),
		'style'    => '.site-footer-widgets .widget .widget-title { font-size: [value]rem }',
		'active_callback' => 'larisdigital_callback_footer_widgets_is_active',
	);

	$controls['larisdigital_footer_widgets_title_font_weight'] = array(
		'label'    => esc_html__( 'Font Weight', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_footer_widgets_title_font_weight',
		'section'  => 'larisdigital_section_footer_widgets',
		'type'     => 'select',
		'choices'  => array(
			'' => '',
			'normal' => esc_html__( 'Normal', 'larisdigital-wp' ),
			'bold' => esc_html__( 'Bold', 'larisdigital-wp' ),
		),
		'style'  => array(
			'normal' => '',
			'bold' => '.site-footer-widgets .widget .widget-title { font-weight: bold; }',
		),
		'active_callback' => 'larisdigital_callback_footer_widgets_is_active',
	);

	$controls['larisdigital_footer_widgets_title_font_style'] = array(
		'label'    => esc_html__( 'Font Style', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_footer_widgets_title_font_style',
		'section'  => 'larisdigital_section_footer_widgets',
		'type'     => 'select',
		'choices'  => array(
			'' => '',
			'normal' => esc_html__( 'Normal', 'larisdigital-wp' ),
			'italic' => esc_html__( 'Italic', 'larisdigital-wp' ),
		),
		'style'  => array(
			'normal' => '',
			'italic' => '.site-footer-widgets .widget .widget-title { font-style: italic; }',
		),
		'active_callback' => 'larisdigital_callback_footer_widgets_is_active',
	);

	$controls['larisdigital_footer_widgets_title_text_transform'] = array(
		'label'    => esc_html__( 'Text Transform', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_footer_widgets_title_text_transform',
		'section'  => 'larisdigital_section_footer_widgets',
		'type'     => 'select',
		'choices'  => array(
			'' => '',
			'none' => esc_html__( 'None', 'larisdigital-wp' ),
			'uppercase' => esc_html__( 'Uppercase', 'larisdigital-wp' ),
			'lowercase' => esc_html__( 'Lowercase', 'larisdigital-wp' ),
			'capitalize' => esc_html__( 'Capitalize', 'larisdigital-wp' ),
		),
		'style'  => array(
			'none' => '.site-footer-widgets .widget .widget-title { text-transform: none; }',
			'uppercase' => '.site-footer-widgets .widget .widget-title { text-transform: uppercase; }',
			'lowercase' => '.site-footer-widgets .widget .widget-title { text-transform: lowercase; }',
			'capitalize' => '.site-footer-widgets .widget .widget-title { text-transform: capitalize; }',
		),
		'active_callback' => 'larisdigital_callback_footer_widgets_is_active',
	);

	$controls['larisdigital_heading_footer_widgets_padding'] = array(
		'label'    => esc_html__( 'Custom Padding', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_footer_widgets_padding',
		'section'  => 'larisdigital_section_footer_widgets',
		'type'     => 'heading',
		'active_callback' => 'larisdigital_callback_footer_widgets_is_active',
	);

	$controls['larisdigital_footer_widgets_padding_top'] = array(
		'label'    => esc_html__( 'Top Padding', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_footer_widgets_padding_top',
		'section'  => 'larisdigital_section_footer_widgets',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 0,
			'max' => 7,
			'step' => 0.1,
			'unit' => 'rem',
		),
		'style'    => '.site-footer-widgets { padding-top: [value]rem; } ',
		'active_callback' => 'larisdigital_callback_footer_widgets_is_active',
	);

	$controls['larisdigital_footer_widgets_padding_bottom'] = array(
		'label'    => esc_html__( 'Bottom Padding', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_footer_widgets_padding_bottom',
		'section'  => 'larisdigital_section_footer_widgets',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 0,
			'max' => 7,
			'step' => 0.1,
			'unit' => 'rem',
		),
		'style'    => '.site-footer-widgets { padding-bottom: [value]rem; } ',
		'active_callback' => 'larisdigital_callback_footer_widgets_is_active',
	);

	return $controls;
}

add_filter( 'larisdigital_customize_controls', 'larisdigital_customize_controls_footer' );
function larisdigital_customize_controls_footer( $controls ) {

	$controls['larisdigital_section_footer'] = array(
		'title'    => esc_html__( 'Site Footer', 'larisdigital-wp' ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-success larisdigital-alert-with-icon">
							<span class="dashicons dashicons-megaphone"></span> '.sprintf( esc_html__( '%s can be disabled on a post/page using "%s" metabox when editing a post/page', 'larisdigital-wp' ), esc_html__( 'Site Footer', 'larisdigital-wp' ), esc_html__( 'Page Layout', 'larisdigital-wp' ) ).'
							</p>',
		'setting'  => 'larisdigital_section_footer',
		'panel'    => 'larisdigital_panel_settings',
		'type'     => 'section',
		'priority' => 420,
	);

	$controls['larisdigital_footer_hide'] = array(
		'label'    => sprintf( esc_html__( 'HIDE %s Globally', 'larisdigital-wp' ), esc_html__( 'Site Footer', 'larisdigital-wp' ) ),
		'setting'  => 'larisdigital_footer_hide',
		'section'  => 'larisdigital_section_footer',
		'type'     => 'checkbox',
	);

	$controls['larisdigital_footer_background'] = array(
		'label'    => esc_html__( 'Background Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_footer_background',
		'section'  => 'larisdigital_section_footer',
		'type'     => 'color',
		'style'    => '.site-footer { background-color: [value] }',
		'active_callback' => 'larisdigital_callback_footer_is_active',
	);

	$controls['larisdigital_heading_footer_layout'] = array(
		'label'    => esc_html__( 'Layout', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_footer_layout',
		'section'  => 'larisdigital_section_footer',
		'type'     => 'heading',
		'active_callback' => 'larisdigital_callback_footer_is_active',
	);

	$controls['larisdigital_footer_layout'] = array(
		'label'    => esc_html__( 'Layout', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_footer_layout',
		'section'  => 'larisdigital_section_footer',
		'type'     => 'radio',
		'choices'  => array(
			'center' => esc_html__( 'Center', 'larisdigital-wp' ),
			'left' => esc_html__( 'Left', 'larisdigital-wp' ),
			'right' => esc_html__( 'Right', 'larisdigital-wp' ),
			'left-right' => esc_html__( 'Menu (Left) & Text (Right)', 'larisdigital-wp' ),
			'right-left' => esc_html__( 'Text (Left) & Menu (Right)', 'larisdigital-wp' ),
		),
		'active_callback' => 'larisdigital_callback_footer_is_active',
	);

	$controls['larisdigital_footer_color'] = array(
		'label'    => esc_html__( 'Text Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_footer_color',
		'section'  => 'larisdigital_section_footer',
		'type'     => 'color',
		'style'    => '.site-footer { color: [value] }',
		'active_callback' => 'larisdigital_callback_footer_is_active',
	);

	$controls['larisdigital_footer_link'] = array(
		'label'    => esc_html__( 'Link Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_footer_link',
		'section'  => 'larisdigital_section_footer',
		'type'     => 'color',
		'style'    => '.site-footer a { color: [value] }',
		'active_callback' => 'larisdigital_callback_footer_is_active',
	);

	$controls['larisdigital_footer_link_hover'] = array(
		'label'    => esc_html__( 'Link Color', 'larisdigital-wp' ).' '.esc_html__( '(Hover)', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_footer_link_hover',
		'section'  => 'larisdigital_section_footer',
		'type'     => 'color',
		'style'    => '.site-footer a:hover { color: [value] }',
		'active_callback' => 'larisdigital_callback_footer_is_active',
	);

	$controls['larisdigital_footer_font_size'] = array(
		'label'    => esc_html__( 'Font Size', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_footer_font_size',
		'section'  => 'larisdigital_section_footer',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 0.5,
			'max' => 2,
			'step' => 0.1,
			'unit' => 'rem',
		),
		'style'    => '.site-footer { font-size: [value]rem }',
		'active_callback' => 'larisdigital_callback_footer_is_active',
	);

	$controls['larisdigital_heading_footer_menu'] = array(
		'label'    => esc_html__( 'Menu', 'larisdigital-wp' ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-with-icon"><span class="dashicons dashicons-admin-appearance"></span> <a href="javascript:wp.customize.section( \'menu_locations\' ).focus();">' . sprintf( esc_html__( 'CLICK HERE to setup %s', 'larisdigital-wp' ), esc_html__( 'Site Footer Menu', 'larisdigital-wp' ) ) . '</a></p>',
		'setting'  => 'larisdigital_heading_footer_menu',
		'section'  => 'larisdigital_section_footer',
		'type'     => 'heading',
		'active_callback' => 'larisdigital_callback_footer_is_active',
	);

	$controls['larisdigital_footer_menu_hide'] = array(
		'label'    => sprintf( esc_html__( 'HIDE %s', 'larisdigital-wp' ), esc_html__( 'Menu', 'larisdigital-wp' ) ),
		'setting'  => 'larisdigital_footer_menu_hide',
		'section'  => 'larisdigital_section_footer',
		'type'     => 'checkbox',
		'active_callback' => 'larisdigital_callback_footer_is_active',
	);

	$controls['larisdigital_heading_footer_text'] = array(
		'label'    => esc_html__( 'Text', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_footer_text',
		'section'  => 'larisdigital_section_footer',
		'type'     => 'heading',
		'active_callback' => 'larisdigital_callback_footer_is_active',
	);

	$controls['larisdigital_footer_text'] = array(
		'label'    => esc_html__( 'Text', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_footer_text',
		'section'  => 'larisdigital_section_footer',
		'type'     => 'textarea-html',
		'active_callback' => 'larisdigital_callback_footer_is_active',
	);

	$controls['larisdigital_footer_text_hide'] = array(
		'label'    => sprintf( esc_html__( 'HIDE %s', 'larisdigital-wp' ), esc_html__( 'Text', 'larisdigital-wp' ) ),
		'setting'  => 'larisdigital_footer_text_hide',
		'section'  => 'larisdigital_section_footer',
		'type'     => 'checkbox',
		'active_callback' => 'larisdigital_callback_footer_is_active',
	);

	$controls['larisdigital_heading_footer_padding'] = array(
		'label'    => esc_html__( 'Custom Padding', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_footer_padding',
		'section'  => 'larisdigital_section_footer',
		'type'     => 'heading',
		'active_callback' => 'larisdigital_callback_footer_is_active',
	);

	$controls['larisdigital_footer_padding_top'] = array(
		'label'    => esc_html__( 'Top Padding', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_footer_padding_top',
		'section'  => 'larisdigital_section_footer',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 0,
			'max' => 7,
			'step' => 0.1,
			'unit' => 'rem',
		),
		'style'    => '.site-footer { padding-top: [value]rem; } ',
		'active_callback' => 'larisdigital_callback_footer_is_active',
	);

	$controls['larisdigital_footer_padding_bottom'] = array(
		'label'    => esc_html__( 'Bottom Padding', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_footer_padding_bottom',
		'section'  => 'larisdigital_section_footer',
		'type'     => 'slider',
		'choices'  => array(
			'min' => 0,
			'max' => 7,
			'step' => 0.1,
			'unit' => 'rem',
		),
		'style'    => '.site-footer { padding-bottom: [value]rem; } ',
		'active_callback' => 'larisdigital_callback_footer_is_active',
	);

	return $controls;
}

add_filter( 'larisdigital_customize_controls', 'larisdigital_customize_controls_backtotop' );
function larisdigital_customize_controls_backtotop( $controls ) {

	$controls['larisdigital_section_backtotop'] = array(
		'title'    => esc_html__( 'Site Back To Top', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_section_backtotop',
		'panel'    => 'larisdigital_panel_settings',
		'type'     => 'section',
		'priority' => 430,
	);

	$controls['larisdigital_backtotop_hide'] = array(
		'label'    => sprintf( esc_html__( 'HIDE %s', 'larisdigital-wp' ), esc_html__( 'Site Back To Top', 'larisdigital-wp' ) ),
		'setting'  => 'larisdigital_backtotop_hide',
		'section'  => 'larisdigital_section_backtotop',
		'type'     => 'checkbox',
	);

	$controls['larisdigital_backtotop_background'] = array(
		'label'    => esc_html__( 'Background Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_backtotop_background',
		'section'  => 'larisdigital_section_backtotop',
		'type'     => 'color',
		'style'    => '.site-backtotop { background-color: [value] }',
		'active_callback' => 'larisdigital_callback_backtotop_is_active',
	);

	$controls['larisdigital_backtotop_color'] = array(
		'label'    => esc_html__( 'Icon Color', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_backtotop_color',
		'section'  => 'larisdigital_section_backtotop',
		'type'     => 'color',
		'style'    => '.site-backtotop { color: [value] }',
		'active_callback' => 'larisdigital_callback_backtotop_is_active',
	);

	return $controls;
}

function larisdigital_callback_topbar_is_active() {
	return larisdigital_theme_mod( 'larisdigital_topbar_hide' ) ? false : true;
}

function larisdigital_callback_navigation_is_active() {
	return larisdigital_theme_mod( 'larisdigital_navigation_hide' ) ? false : true;
}

function larisdigital_callback_navigation_brand_is_text() {
	if ( larisdigital_theme_mod( 'larisdigital_navigation_hide' ) ) {
		return false;
	}
	$brand_type = larisdigital_theme_mod( 'larisdigital_navigation_brand_type' );
	return ( ! $brand_type || 'text' == $brand_type || 'image-text' == $brand_type ) ? true : false;
}

function larisdigital_callback_navigation_brand_is_image() {
	if ( larisdigital_theme_mod( 'larisdigital_navigation_hide' ) ) {
		return false;
	}
	$brand_type = larisdigital_theme_mod( 'larisdigital_navigation_brand_type' );
	return ( ! $brand_type || 'image' == $brand_type || 'image-text' == $brand_type ) ? true : false;
}

function larisdigital_callback_header_is_active() {
	return larisdigital_theme_mod( 'larisdigital_header_hide' ) ? false : true;
}

function larisdigital_callback_header_post_is_active() {
	return ( larisdigital_theme_mod( 'larisdigital_header_hide' ) || larisdigital_theme_mod( 'larisdigital_post_header_hide' ) ) ? false : true;
}

function larisdigital_callback_header_page_is_active() {
	return ( larisdigital_theme_mod( 'larisdigital_header_hide' ) || larisdigital_theme_mod( 'larisdigital_page_header_hide' ) ) ? false : true;
}

function larisdigital_callback_header_attachment_is_active() {
	return ( larisdigital_theme_mod( 'larisdigital_header_hide' ) || larisdigital_theme_mod( 'larisdigital_attachment_header_hide' ) ) ? false : true;
}

function larisdigital_callback_header_is_not_active() {
	return larisdigital_theme_mod( 'larisdigital_header_hide' ) ? true : false;
}

function larisdigital_callback_header_image_is_active() {
	return ! larisdigital_theme_mod( 'larisdigital_header_hide' ) && get_header_image() ? true : false;
}

function larisdigital_callback_header_image_is_allowed() {
	return ! larisdigital_theme_mod( 'larisdigital_header_hide' ) || ( larisdigital_theme_mod( 'larisdigital_header_hide' ) && larisdigital_theme_mod( 'larisdigital_header_image' ) ) ? true : false;
}

function larisdigital_callback_breadcrumb_is_active() {
	return larisdigital_theme_mod( 'larisdigital_breadcrumb_hide' ) ? false : true;
}

function larisdigital_callback_sidebar_is_active() {
	return ( 'none' != larisdigital_theme_mod( 'larisdigital_sidebar_layout' ) ) ? true : false;
}

function larisdigital_callback_sidebar_is_not_active() {
	return ( 'none' == larisdigital_theme_mod( 'larisdigital_sidebar_layout' ) ) ? true : false;
}

function larisdigital_callback_blog_sidebar_is_active() {
	$layout = larisdigital_theme_mod( 'larisdigital_blog_sidebar_layout' );
	return ( $layout && 'none' != $layout ) ? true : false;
}

function larisdigital_callback_blog_sidebar_is_not_active() {
	$layout = larisdigital_theme_mod( 'larisdigital_blog_sidebar_layout' );
	return ( $layout && 'none' == $layout ) ? true : false;
}

function larisdigital_callback_post_sidebar_is_active() {
	$layout = larisdigital_theme_mod( 'larisdigital_post_sidebar_layout' );
	return ( $layout && 'none' != $layout ) ? true : false;
}

function larisdigital_callback_post_sidebar_is_not_active() {
	$layout = larisdigital_theme_mod( 'larisdigital_post_sidebar_layout' );
	return ( $layout && 'none' == $layout ) ? true : false;
}

function larisdigital_callback_page_sidebar_is_active() {
	$layout = larisdigital_theme_mod( 'larisdigital_page_sidebar_layout' );
	return ( $layout && 'none' != $layout ) ? true : false;
}

function larisdigital_callback_page_sidebar_is_not_active() {
	$layout = larisdigital_theme_mod( 'larisdigital_page_sidebar_layout' );
	return ( $layout && 'none' == $layout ) ? true : false;
}

function larisdigital_callback_attachment_sidebar_is_active() {
	$layout = larisdigital_theme_mod( 'larisdigital_attachment_sidebar_layout' );
	return ( $layout && 'none' != $layout ) ? true : false;
}

function larisdigital_callback_attachment_sidebar_is_not_active() {
	$layout = larisdigital_theme_mod( 'larisdigital_attachment_sidebar_layout' );
	return ( $layout && 'none' == $layout ) ? true : false;
}

function larisdigital_callback_footer_widgets_is_active() {
	return larisdigital_theme_mod( 'larisdigital_footer_widgets_hide' ) ? false : true;
}

function larisdigital_callback_footer_is_active() {
	return larisdigital_theme_mod( 'larisdigital_footer_hide' ) ? false : true;
}

function larisdigital_callback_backtotop_is_active() {
	return larisdigital_theme_mod( 'larisdigital_backtotop_hide' ) ? false : true;
}

function larisdigital_callback_blog_more_link_is_active() {
	return larisdigital_theme_mod( 'larisdigital_blog_more_link' ) ? true : false;
}

function larisdigital_callback_blog_meta_is_active() {
	return larisdigital_theme_mod( 'larisdigital_blog_meta' ) ? true : false;
}

function larisdigital_callback_post_featured4header_is_not_active() {
	return ( ! larisdigital_theme_mod( 'larisdigital_header_hide' ) && larisdigital_theme_mod( 'larisdigital_post_header_hide' ) && ! larisdigital_theme_mod( 'larisdigital_post_featured4header' ) ) ? false : true;
}

function larisdigital_callback_post_title4header_is_not_active() {
	return ( ! larisdigital_theme_mod( 'larisdigital_header_hide' ) && ! larisdigital_theme_mod( 'larisdigital_post_header_hide' ) && larisdigital_theme_mod( 'larisdigital_post_title4header' ) ) ? false : true;
}

function larisdigital_callback_post_meta_is_active() {
	return larisdigital_theme_mod( 'larisdigital_post_meta' ) ? true : false;
}

function larisdigital_callback_post_share_is_active() {
	return larisdigital_theme_mod( 'larisdigital_post_share' ) ? true : false;
}

function larisdigital_callback_page_featured4header_is_not_active() {
	return ( ! larisdigital_theme_mod( 'larisdigital_header_hide' ) && larisdigital_theme_mod( 'larisdigital_page_featured4header' ) ) ? false : true;
}

function larisdigital_callback_page_title4header_is_not_active() {
	return ( ! larisdigital_theme_mod( 'larisdigital_header_hide' ) && larisdigital_theme_mod( 'larisdigital_page_title4header' ) ) ? false : true;
}

function larisdigital_callback_attachment_title4header_is_not_active() {
	return ( ! larisdigital_theme_mod( 'larisdigital_header_hide' ) && larisdigital_theme_mod( 'larisdigital_attachment_title4header' ) ) ? false : true;
}

add_action( 'customize_controls_print_scripts', 'larisdigital_customize_scripts_preview_page', 30 );
function larisdigital_customize_scripts_preview_page() {
	$page_ids = get_posts( array(
		'posts_per_page' => 1,
		'post_type' => 'page',
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
	$page_url = !empty( $page_ids ) ? get_permalink( reset( $page_ids ) ) : '';
	$page_section = apply_filters( 'larisdigital_wc_customize_preview_page', array(
		'larisdigital_section_template_page' => 'larisdigital_section_template_page',
	) );
	if ( empty( $page_url ) ) {
		return;
	}
	if ( empty( $page_section ) ) {
		return;
	}
?>
<script type="text/javascript">
jQuery( document ).ready( function( $ ) {
<?php foreach ( $page_section as $section => $value ) : ?>
	wp.customize.section( '<?php echo esc_attr($section); ?>', function( section ) {
		section.expanded.bind( function( isExpanded ) {
			if ( isExpanded ) {
				wp.customize.previewer.previewUrl.set( '<?php echo esc_js( $page_url ); ?>' );
			}
		} );
	} );
<?php endforeach; ?>
} );
</script>
<?php
}

add_action( 'customize_controls_print_scripts', 'larisdigital_customize_scripts_preview_blog', 30 );
function larisdigital_customize_scripts_preview_blog() {
	if ( 'page' == get_option( 'show_on_front' ) ) {
		$page_for_posts = get_option( 'page_for_posts' );
		if ( $page_for_posts ) {
			$blog_url = get_permalink( $page_for_posts );
		}
		else {
			$blog_url = '';
		}
	}
	else {
		$blog_url = home_url('/');
	}
	$blog_section = apply_filters( 'larisdigital_wc_customize_preview_blog', array(
		'larisdigital_section_template_blog' => 'larisdigital_section_template_blog',
	) );
	if ( empty( $blog_url ) ) {
		return;
	}
	if ( empty( $blog_section ) ) {
		return;
	}
?>
<script type="text/javascript">
jQuery( document ).ready( function( $ ) {
<?php foreach ( $blog_section as $section => $value ) : ?>
	wp.customize.section( '<?php echo esc_attr($section); ?>', function( section ) {
		section.expanded.bind( function( isExpanded ) {
			if ( isExpanded ) {
				wp.customize.previewer.previewUrl.set( '<?php echo esc_js( $blog_url ); ?>' );
			}
		} );
	} );
<?php endforeach; ?>
} );
</script>
<?php
}

add_action( 'customize_controls_print_scripts', 'larisdigital_customize_scripts_preview_post', 30 );
function larisdigital_customize_scripts_preview_post() {
	$post_ids = get_posts( array(
		'posts_per_page' => 1,
		'post_type' => 'post',
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
	$post_url = !empty( $post_ids ) ? get_permalink( reset( $post_ids ) ) : '';
	$post_section = apply_filters( 'larisdigital_wc_customize_preview_post', array(
		'larisdigital_section_template_post' => 'larisdigital_section_template_post',
	) );
	if ( empty( $post_url ) ) {
		return;
	}
	if ( empty( $post_section ) ) {
		return;
	}
?>
<script type="text/javascript">
jQuery( document ).ready( function( $ ) {
<?php foreach ( $post_section as $section => $value ) : ?>
	wp.customize.section( '<?php echo esc_attr($section); ?>', function( section ) {
		section.expanded.bind( function( isExpanded ) {
			if ( isExpanded ) {
				wp.customize.previewer.previewUrl.set( '<?php echo esc_js( $post_url ); ?>' );
			}
		} );
	} );
<?php endforeach; ?>
} );
</script>
<?php
}

add_action( 'customize_controls_print_scripts', 'larisdigital_customize_scripts_preview_attachment', 30 );
function larisdigital_customize_scripts_preview_attachment() {
	$attachment_ids = get_posts( array(
		'posts_per_page' => 1,
		'post_type' => 'attachment',
		'post_mime_type' => 'image/jpeg,image/jpg,image/png',
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
	$attachment_url = !empty( $attachment_ids ) ? get_permalink( reset( $attachment_ids ) ) : '';
	$attachment_section = apply_filters( 'larisdigital_wc_customize_preview_attachment', array(
		'larisdigital_section_template_attachment' => 'larisdigital_section_template_attachment',
	) );
	if ( empty( $attachment_url ) ) {
		return;
	}
	if ( empty( $attachment_section ) ) {
		return;
	}
?>
<script type="text/javascript">
jQuery( document ).ready( function( $ ) {
<?php foreach ( $attachment_section as $section => $value ) : ?>
	wp.customize.section( '<?php echo esc_attr($section); ?>', function( section ) {
		section.expanded.bind( function( isExpanded ) {
			if ( isExpanded ) {
				wp.customize.previewer.previewUrl.set( '<?php echo esc_js( $attachment_url ); ?>' );
			}
		} );
	} );
<?php endforeach; ?>
} );
</script>
<?php
}
