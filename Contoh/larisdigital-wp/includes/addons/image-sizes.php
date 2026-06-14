<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_filter( 'larisdigital_customize_controls', 'larisdigital_customize_controls_image_sizes' );
function larisdigital_customize_controls_image_sizes( $controls ) {

	$controls['larisdigital_section_image_sizes'] = array(
		'title'    => esc_html__( 'Image Sizes', 'larisdigital-wp' ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-danger larisdigital-alert-with-icon"><span class="dashicons dashicons-warning"></span>'.esc_html__( 'Do not forget to regenerate existing thumbnail images using Force Regenerate Thumbnails plugin after you change the image sizes below.', 'larisdigital-wp' ).'</p>',
		'setting'  => 'larisdigital_section_image_sizes',
		'panel'    => 'larisdigital_panel_settings',
		'type'     => 'section',
		'priority' => 800,
	);

	$controls['larisdigital_heading_image_custom_header'] = array(
		'label'    => esc_html__( 'Header Image', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_image_custom_header',
		'section'  => 'larisdigital_section_image_sizes',
		'type'     => 'heading',
	);

	$controls['larisdigital_image_custom_header_width'] = array(
		'label'    => sprintf( esc_html__( '%s Width (px)', 'larisdigital-wp' ), esc_html__( 'Header Image', 'larisdigital-wp' ) ),
		'description' => sprintf( esc_html__( 'default: %s', 'larisdigital-wp' ), 1024 ),
		'setting'  => 'larisdigital_image_custom_header_width',
		'section'  => 'larisdigital_section_image_sizes',		
		'type'     => 'text',
		'transport' => 'postMessage',
	);

	$controls['larisdigital_image_custom_header_height'] = array(
		'label'    => sprintf( esc_html__( '%s Height (px)', 'larisdigital-wp' ), esc_html__( 'Header Image', 'larisdigital-wp' ) ),
		'description' => sprintf( esc_html__( 'default: %s', 'larisdigital-wp' ), 192 ),
		'setting'  => 'larisdigital_image_custom_header_height',
		'section'  => 'larisdigital_section_image_sizes',
		'type'     => 'text',
		'transport' => 'postMessage',
	);

	$controls['larisdigital_heading_image_post_thumbnail'] = array(
		'label'    => esc_html__( 'Featured Image', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_image_post_thumbnail',
		'section'  => 'larisdigital_section_image_sizes',
		'type'     => 'heading',
	);

	$controls['larisdigital_image_post_thumbnail_width'] = array(
		'label'    => sprintf( esc_html__( '%s Width (px)', 'larisdigital-wp' ), esc_html__( 'Featured Image', 'larisdigital-wp' ) ),
		'description' => sprintf( esc_html__( 'default: %s', 'larisdigital-wp' ), 728 ),
		'setting'  => 'larisdigital_image_post_thumbnail_width',
		'section'  => 'larisdigital_section_image_sizes',		
		'type'     => 'text',
		'transport' => 'postMessage',
	);

	$controls['larisdigital_image_post_thumbnail_height'] = array(
		'label'    => sprintf( esc_html__( '%s Height (px)', 'larisdigital-wp' ), esc_html__( 'Featured Image', 'larisdigital-wp' ) ),
		'label'    => esc_html__( 'Featured Image Height (px)', 'larisdigital-wp' ),
		'description' => sprintf( esc_html__( 'default: %s', 'larisdigital-wp' ), 410 ),
		'setting'  => 'larisdigital_image_post_thumbnail_height',
		'section'  => 'larisdigital_section_image_sizes',
		'type'     => 'text',
		'transport' => 'postMessage',
	);

	$controls['larisdigital_heading_image_medium_thumbnail'] = array(
		'label'    => esc_html__( 'Medium Thumbnail', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_heading_image_medium_thumbnail',
		'section'  => 'larisdigital_section_image_sizes',
		'type'     => 'heading',
	);

	$controls['larisdigital_image_medium_thumbnail_width'] = array(
		'label'    => sprintf( esc_html__( '%s Width (px)', 'larisdigital-wp' ), esc_html__( 'Medium Thumbnail', 'larisdigital-wp' ) ),
		'description' => sprintf( esc_html__( 'default: %s', 'larisdigital-wp' ), 348 ),
		'setting'  => 'larisdigital_image_medium_thumbnail_width',
		'section'  => 'larisdigital_section_image_sizes',
		'type'     => 'text',
		'transport' => 'postMessage',
	);

	$controls['larisdigital_image_medium_thumbnail_height'] = array(
		'label'    => sprintf( esc_html__( '%s Height (px)', 'larisdigital-wp' ), esc_html__( 'Medium Thumbnail', 'larisdigital-wp' ) ),
		'description' => sprintf( esc_html__( 'default: %s', 'larisdigital-wp' ), 196 ),
		'setting'  => 'larisdigital_image_medium_thumbnail_height',
		'section'  => 'larisdigital_section_image_sizes',
		'type'     => 'text',
		'transport' => 'postMessage',
	);

	return $controls;
}

add_filter( 'larisdigital_image_custom_header_width', 'larisdigital_image_custom_header_width_filter', 5 );
function larisdigital_image_custom_header_width_filter( $size ) {
	$custom_size = get_theme_mod( 'larisdigital_image_custom_header_width' );
	if ( is_numeric( $custom_size ) ) {
		$size = $custom_size;
	}
	return $size;
}

add_filter( 'larisdigital_image_custom_header_height', 'larisdigital_image_custom_header_height_filter', 5 );
function larisdigital_image_custom_header_height_filter( $size ) {
	$custom_size = get_theme_mod( 'larisdigital_image_custom_header_height' );
	if ( is_numeric( $custom_size ) ) {
		$size = $custom_size;
	}
	return $size;
}

add_filter( 'larisdigital_image_post_thumbnail_width', 'larisdigital_image_post_thumbnail_width_filter', 5 );
function larisdigital_image_post_thumbnail_width_filter( $size ) {
	$custom_size = get_theme_mod( 'larisdigital_image_post_thumbnail_width' );
	if ( is_numeric( $custom_size ) ) {
		$size = $custom_size;
	}
	return $size;
}

add_filter( 'larisdigital_image_post_thumbnail_height', 'larisdigital_image_post_thumbnail_height_filter', 5 );
function larisdigital_image_post_thumbnail_height_filter( $size ) {
	$custom_size = get_theme_mod( 'larisdigital_image_post_thumbnail_height' );
	if ( is_numeric( $custom_size ) ) {
		$size = $custom_size;
	}
	return $size;
}

add_filter( 'larisdigital_image_medium_thumbnail_width', 'larisdigital_image_medium_thumbnail_width_filter', 5 );
function larisdigital_image_medium_thumbnail_width_filter( $size ) {
	$custom_size = get_theme_mod( 'larisdigital_image_medium_thumbnail_width' );
	if ( is_numeric( $custom_size ) ) {
		$size = $custom_size;
	}
	return $size;
}

add_filter( 'larisdigital_image_medium_thumbnail_height', 'larisdigital_image_medium_thumbnail_height_filter', 5 );
function larisdigital_image_medium_thumbnail_height_filter( $size ) {
	$custom_size = get_theme_mod( 'larisdigital_image_medium_thumbnail_height' );
	if ( is_numeric( $custom_size ) ) {
		$size = $custom_size;
	}
	return $size;
}
