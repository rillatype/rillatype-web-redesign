<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_filter( 'larisdigital_customize_controls', 'larisdigital_customize_controls_optimization' );
function larisdigital_customize_controls_optimization( $controls ) {

	$controls['larisdigital_section_optimization'] = array(
		'title'    => esc_html__( 'Optimizations', 'larisdigital-wp' ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-danger larisdigital-alert-with-icon"><span class="dashicons dashicons-warning"></span>'.esc_html__( 'BE CAREFUL! These options are probably not compatible with other plugins.', 'larisdigital-wp' ).'</p>',
		'setting'  => 'larisdigital_section_optimization',
		'panel'    => 'larisdigital_panel_settings',
		'type'     => 'section',
		'priority' => 900,
	);

	$controls['larisdigital_heading_optimization_responsive_images'] = array(
		'label'		=> esc_html__( 'WP Responsive Images', 'larisdigital-wp' ),
		'setting'  	=> 'larisdigital_heading_optimization_responsive_images',
		'section'	=> 'larisdigital_section_optimization',
		'type'   	=> 'heading',
	);

	$controls['larisdigital_optimization_disable_responsive_images'] = array(
		'label'    => esc_html__( 'Disable WordPress Responsive Images', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_optimization_disable_responsive_images',
		'section'  => 'larisdigital_section_optimization',
		'type'     => 'checkbox',
		'default'  => '1',
		'transport' => 'postMessage',
	);

	$controls['larisdigital_heading_optimization_emojis'] = array(
		'label'		=> esc_html__( 'WP Emojis', 'larisdigital-wp' ),
		'setting'  	=> 'larisdigital_heading_optimization_emojis',
		'section'	=> 'larisdigital_section_optimization',
		'type'   	=> 'heading',
	);

	$controls['larisdigital_optimization_disable_emojis'] = array(
		'label'    => esc_html__( 'Disable WordPress Emojis', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_optimization_disable_emojis',
		'section'  => 'larisdigital_section_optimization',
		'type'     => 'checkbox',
		'default'  => '1',
	);

	$controls['larisdigital_heading_optimization_header_cleanup'] = array(
		'label'		=> esc_html__( 'WP Header Cleanup', 'larisdigital-wp' ),
		'setting'  	=> 'larisdigital_heading_optimization_header_cleanup',
		'section'	=> 'larisdigital_section_optimization',
		'type'   	=> 'heading',
	);

	$controls['larisdigital_optimization_disable_wp_generator'] = array(
		'label'    => esc_html__( 'Disable WordPress generator on document header', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_optimization_disable_wp_generator',
		'section'  => 'larisdigital_section_optimization',
		'type'     => 'checkbox',
		'default'  => '1',
		'transport' => 'postMessage',
	);

	$controls['larisdigital_optimization_disable_wlwmanifest'] = array(
		'label'    => esc_html__( 'Disable Windows Live Writer link on document header', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_optimization_disable_wlwmanifest',
		'section'  => 'larisdigital_section_optimization',
		'type'     => 'checkbox',
		'default'  => '1',
		'transport' => 'postMessage',
	);

	$controls['larisdigital_optimization_disable_rsd'] = array(
		'label'    => esc_html__( 'Disable Really Simple Discovery link on document header', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_optimization_disable_rsd',
		'section'  => 'larisdigital_section_optimization',
		'type'     => 'checkbox',
		'default'  => '1',
		'transport' => 'postMessage',
	);

	$controls['larisdigital_optimization_disable_shortlink'] = array(
		'label'    => esc_html__( 'Disable Shortlink on document header', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_optimization_disable_shortlink',
		'section'  => 'larisdigital_section_optimization',
		'type'     => 'checkbox',
		'default'  => '1',
		'transport' => 'postMessage',
	);

	$controls['larisdigital_optimization_disable_relational'] = array(
		'label'    => esc_html__( 'Disable Relational Links on document header', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_optimization_disable_relational',
		'section'  => 'larisdigital_section_optimization',
		'type'     => 'checkbox',
		'default'  => '1',
		'transport' => 'postMessage',
	);

	$controls['larisdigital_optimization_disable_feed'] = array(
		'label'    => esc_html__( 'Disable Automatic Feed Links on document header', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_optimization_disable_feed',
		'section'  => 'larisdigital_section_optimization',
		'type'     => 'checkbox',
		'default'  => '1',
		'transport' => 'postMessage',
	);

	$controls['larisdigital_optimization_disable_rest'] = array(
		'label'    => esc_html__( 'Disable REST API Links on document header', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_optimization_disable_rest',
		'section'  => 'larisdigital_section_optimization',
		'type'     => 'checkbox',
		'default'  => '1',
		'transport' => 'postMessage',
	);

	$controls['larisdigital_optimization_disable_oembed'] = array(
		'label'    => esc_html__( 'Disable oEmbed discovery links on document header', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_optimization_disable_oembed',
		'section'  => 'larisdigital_section_optimization',
		'type'     => 'checkbox',
		'default'  => '1',
		'transport' => 'postMessage',
	);

	// $controls['larisdigital_optimization_disable_wpembedjs'] = array(
	// 	'label'    => esc_html__( 'Disable wp-embed javascript output', 'larisdigital-wp' ),
	// 	'setting'  => 'larisdigital_optimization_disable_wpembedjs',
	// 	'section'  => 'larisdigital_section_optimization',
	// 	'type'     => 'checkbox',
	// 	'default'  => '1',
	// 	'transport' => 'postMessage',
	// );

	$controls['larisdigital_heading_optimization_defer_parsing'] = array(
		'label'		=> esc_html__( 'WP Defer Parsing Javascript', 'larisdigital-wp' ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-danger larisdigital-alert-with-icon"><span class="dashicons dashicons-warning"></span>'.esc_html__( 'BE CAREFUL! This option is probably not compatible with other plugins. Use it only when you know how to do it properly.', 'larisdigital-wp' ).'</p>',
		'setting'  	=> 'larisdigital_heading_optimization_defer_parsing',
		'section'	=> 'larisdigital_section_optimization',
		'type'   	=> 'heading',
	);

	$controls['larisdigital_optimization_enable_defer_parsing_javascript'] = array(
		'label'    => esc_html__( 'Enable Defer Parsing Javascript.', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_optimization_enable_defer_parsing_javascript',
		'section'  => 'larisdigital_section_optimization',
		'type'     => 'checkbox',
		'default'  => '',
	);

	return $controls;
}

add_action('after_setup_theme', 'larisdigital_optimization_cleanup_header');
function larisdigital_optimization_cleanup_header() {

	if ( get_theme_mod( 'larisdigital_optimization_disable_wlwmanifest', '1' ) ) {
		remove_action( 'wp_head', 'wlwmanifest_link' );
	}

	if ( get_theme_mod( 'larisdigital_optimization_disable_wp_generator', '1' ) ) {
		remove_action( 'wp_head', 'wp_generator' );
	}

	if ( get_theme_mod( 'larisdigital_optimization_disable_rsd', '1' ) ) {
		remove_action( 'wp_head', 'rsd_link' );
	}

	if ( get_theme_mod( 'larisdigital_optimization_disable_shortlink', '1' ) ) {
		remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
	}

	if ( get_theme_mod( 'larisdigital_optimization_disable_relational', '1' ) ) {
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' );
	}

	if ( get_theme_mod( 'larisdigital_optimization_disable_feed', '1' ) ) {
		remove_action( 'wp_head', 'feed_links', 2 );
		remove_action( 'wp_head', 'feed_links_extra', 3 );
	}

	if ( get_theme_mod( 'larisdigital_optimization_disable_rest', '1' ) ) {
		remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
	}

	if ( get_theme_mod( 'larisdigital_optimization_disable_oembed', '1' ) ) {
		remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
	}

	if ( get_theme_mod( 'larisdigital_optimization_disable_emojis', '1' ) ) {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		add_filter( 'emoji_svg_url', '__return_false' );
	}

}

add_filter( 'wp_calculate_image_srcset_meta', 'larisdigital_optimization_disable_responsive_images' );
function larisdigital_optimization_disable_responsive_images( $option ) {
	if ( get_theme_mod( 'larisdigital_optimization_disable_responsive_images', '1' ) ) {
		return false;
	}
	return $option;
}

add_filter( 'intermediate_image_sizes_advanced', 'larisdigital_optimization_disable_medium_large_images' );
function larisdigital_optimization_disable_medium_large_images( $sizes ) {
	if ( get_theme_mod( 'larisdigital_optimization_disable_responsive_images', '1' ) ) {
		unset($sizes['medium_large']);
	}
	return $sizes;
}

// add_action('init', 'larisdigital_optimization_disable_wpembedjs');
// function larisdigital_optimization_disable_wpembedjs() {
// 	if ( get_theme_mod( 'larisdigital_optimization_disable_wpembedjs', '1' ) ) {
// 		if (!is_admin()) {
// 			wp_deregister_script('wp-embed');
// 		}
// 	}
// }

add_filter( 'clean_url', 'larisdigital_optimization_defer_parsing_javascript', 11, 1 );
function larisdigital_optimization_defer_parsing_javascript ( $url ) {
	if ( is_customize_preview() ) {
		return $url;
	}
	if ( is_admin() ) {
		return $url;
	}
	if ( get_theme_mod( 'larisdigital_optimization_enable_defer_parsing_javascript' ) ) {
		if ( false === strpos( $url, '.js' ) ) {
			return $url;
		}
		if ( strpos( $url, 'jquery.js' ) ) {
			return $url;
		}
		elseif ( strpos( $url, 'dtree.js' ) ) {
			return $url;
		}
		return "$url' defer='defer";
	}
	else {
		return $url;

	}
}
