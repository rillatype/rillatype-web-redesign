<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_filter( 'larisdigital_customize_controls', 'larisdigital_customize_controls_optimization_combine' );
function larisdigital_customize_controls_optimization_combine( $controls ) {

	$controls['larisdigital_section_optimization'] = array(
		'title'    => esc_html__( 'Optimizations', 'larisdigital-wp' ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-danger larisdigital-alert-with-icon"><span class="dashicons dashicons-warning"></span>'.esc_html__( 'BE CAREFUL! These options are probably not compatible with other plugins.', 'larisdigital-wp' ).'</p>',
		'setting'  => 'larisdigital_section_optimization',
		'panel'    => 'larisdigital_panel_settings',
		'type'     => 'section',
		'priority' => 900,
	);

	$controls['larisdigital_heading_optimization_combine'] = array(
		'label'		=> esc_html__( 'Theme CSS & JS Optimizations', 'larisdigital-wp' ),
		'setting'  	=> 'larisdigital_heading_optimization_combine',
		'section'	=> 'larisdigital_section_optimization',
		'type'   	=> 'heading',
		'priority' => 5,
	);

	// $controls['larisdigital_optimization_combine_style'] = array(
	// 	'label'    => esc_html__( 'Load combined theme CSS file', 'larisdigital-wp' ),
	// 	'setting'  => 'larisdigital_optimization_combine_style',
	// 	'section'  => 'larisdigital_section_optimization',
	// 	'type'     => 'checkbox',
	// 	'default'  => '1',
	// 	'priority' => 5,
	// );

	// $controls['larisdigital_optimization_combine_script'] = array(
	// 	'label'    => esc_html__( 'Load combined theme JS file', 'larisdigital-wp' ),
	// 	'setting'  => 'larisdigital_optimization_combine_script',
	// 	'section'  => 'larisdigital_section_optimization',
	// 	'type'     => 'checkbox',
	// 	'default'  => '1',
	// 	'priority' => 5,
	// );

	$controls['larisdigital_optimization_child_css_disable'] = array(
		'label'    => esc_html__( 'Disable child theme CSS file', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_optimization_child_css_disable',
		'section'  => 'larisdigital_section_optimization',
		'type'     => 'checkbox',
		'priority' => 5,
	);

	$controls['larisdigital_optimization_jquery_bottom'] = array(
		'label'    => esc_html__( 'Try to move jQuery to bottom/footer', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_optimization_jquery_bottom',
		'section'  => 'larisdigital_section_optimization',
		'type'     => 'checkbox',
		'priority' => 5,
	);

	return $controls;
}

// add_action( 'wp_enqueue_scripts', 'larisdigital_optimization_combine_style', 15 );
function larisdigital_optimization_combine_style() {

	if ( ! get_theme_mod( 'larisdigital_optimization_combine_style', '1' ) ) {
		return;
	}

	wp_dequeue_style( 'bootstrap4' );
	wp_dequeue_style( 'mmenu' );
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wc-block-style' );
	wp_dequeue_style( 'woocommerce' );
	wp_dequeue_style( 'larisdigital' );

	wp_enqueue_style( 'larisdigital-combine', trailingslashit( get_template_directory_uri() ) . 'style.bundle.min.css', array(), LARISDIGITAL_THEME_VERSION );

}

add_action( 'wp_enqueue_scripts', 'larisdigital_optimization_child_style', 17 );
function larisdigital_optimization_child_style() {

	if ( ! get_theme_mod( 'larisdigital_optimization_child_css_disable' ) ) {
		return;
	}

	wp_dequeue_style( 'larisdigital-child' );

}

// add_action( 'wp_enqueue_scripts', 'larisdigital_optimization_combine_script', 15 );
function larisdigital_optimization_combine_script() {

	if ( ! get_theme_mod( 'larisdigital_optimization_combine_script', '1' ) ) {
		return;
	}

	wp_dequeue_script( 'bootstrap4' );
	wp_dequeue_script( 'sticky' );
	wp_dequeue_script( 'mmenu' );
	wp_dequeue_script( 'larisdigital' );

	wp_enqueue_script( 'larisdigital-combine', get_template_directory_uri() . '/assets/js/script.bundle.min.js', array('jquery'), LARISDIGITAL_THEME_VERSION, true );

}

add_action( 'wp_enqueue_scripts', 'larisdigital_optimization_jquery_bottom', 5 );
function larisdigital_optimization_jquery_bottom() {

	if ( ! get_theme_mod( 'larisdigital_optimization_jquery_bottom' ) ) {
		return;
	}

	wp_scripts()->add_data( 'jquery', 'group', 1 );
	wp_scripts()->add_data( 'jquery-core', 'group', 1 );
	wp_scripts()->add_data( 'jquery-migrate', 'group', 1 );

}
