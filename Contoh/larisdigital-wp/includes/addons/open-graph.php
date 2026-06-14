<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_filter( 'larisdigital_customize_controls', 'larisdigital_customize_controls_opengraph' );
function larisdigital_customize_controls_opengraph( $controls ) {

	$controls['larisdigital_section_opengraph'] = array(
		'title'    => esc_html__( 'Open Graph (Facebook Sharing)', 'larisdigital-wp' ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-success larisdigital-alert-with-icon">
							<span class="dashicons dashicons-megaphone"></span> '.esc_html__( 'Open Graph (Facebook Sharing) setting is useful to control the image, title, and description when your website is shared on Facebook.', 'larisdigital-wp' ).'<br><br>'.esc_html__( 'Open Graph setting for a post/page can be edited using "Open Graph (Facebook Sharing)" metabox when editing a post/page.', 'larisdigital-wp' ).'
							</p>',
		'setting'  => 'larisdigital_section_opengraph',
		'panel'    => 'larisdigital_panel_integrations',
		'type'     => 'section',
		'priority' => 100,
	);

	$controls['larisdigital_warning_opengraph_yoastseo'] = array(
		'label'		=> esc_html__( 'Yoast WordPress SEO Plugin is Active!', 'larisdigital-wp' ),
		'description' => esc_html__( 'Open Graph (Facebook Sharing) setting is from this plugin, not from the theme.', 'larisdigital-wp' ),
		'setting'  	=> 'larisdigital_warning_opengraph_yoastseo',
		'section'	=> 'larisdigital_section_opengraph',
		'type'   	=> 'warning',
		'active_callback' => 'larisdigital_callback_opengraph_yoastseo',
	);

	$controls['opengraph_disable'] = array(
		'label'    => esc_html__( 'Disable Open Graph from this theme', 'larisdigital-wp' ),
		'description' => esc_html__( 'Use this option if you want to use other plugin to handle Open Graph.', 'larisdigital-wp' ),
		'setting'  => 'opengraph_disable',
		'setting_type' => 'option_mod',
		'setting_db' => LARISDIGITAL_INTEGRATIONS_DB,
		'section'  => 'larisdigital_section_opengraph',
		'type'     => 'checkbox',
		'active_callback' => 'larisdigital_callback_opengraph_default',
	);

	$controls['opengraph_fb_app_id'] = array(
		'label'    => esc_html__( 'Facebook App ID (optional)', 'larisdigital-wp' ),
		'setting'  => 'opengraph_fb_app_id',
		'setting_type' => 'option_mod',
		'setting_db' => LARISDIGITAL_INTEGRATIONS_DB,
		'section'  => 'larisdigital_section_opengraph',
		'type'     => 'text',
		'active_callback' => 'larisdigital_callback_opengraph_default',
	);

	$controls['opengraph_image_default'] = array(
		'label'    => esc_html__( 'Default Open Graph Image', 'larisdigital-wp' ),
		'setting'  => 'opengraph_image_default',
		'setting_type' => 'option_mod',
		'setting_db' => LARISDIGITAL_INTEGRATIONS_DB,
		'section'  => 'larisdigital_section_opengraph',
		'type'     => 'image',
		'active_callback' => 'larisdigital_callback_opengraph_default',
	);

	$controls['larisdigital_heading_opengraph_frontpage_active'] = array(
		'label'		=> esc_html__( 'Homepage Open Graph Setting', 'larisdigital-wp' ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-danger larisdigital-alert-with-icon">
							<span class="dashicons dashicons-warning"></span> '.esc_html__( 'This website use static page for Homepage / Frontpage.', 'larisdigital-wp' ).'<br><br>'.esc_html__( 'Please edit Open Graph setting for homepage using "Open Graph (Facebook Sharing)" metabox when editing this Homepage page.', 'larisdigital-wp' ).'
							</p>',
		'setting'  	=> 'larisdigital_heading_opengraph_frontpage_active',
		'section'	=> 'larisdigital_section_opengraph',
		'type'   	=> 'heading',
		'active_callback' => 'larisdigital_callback_opengraph_frontpage_active',
	);

	$controls['larisdigital_heading_opengraph_frontpage'] = array(
		'label'		=> esc_html__( 'Homepage Open Graph Setting', 'larisdigital-wp' ),
		'setting'  	=> 'larisdigital_heading_opengraph_frontpage',
		'section'	=> 'larisdigital_section_opengraph',
		'type'   	=> 'heading',
		'active_callback' => 'larisdigital_callback_opengraph_frontpage_inactive',
	);

	$controls['opengraph_frontpage_image'] = array(
		'label'    => esc_html__( 'Homepage Image', 'larisdigital-wp' ),
		'setting'  => 'opengraph_frontpage_image',
		'setting_type' => 'option_mod',
		'setting_db' => LARISDIGITAL_INTEGRATIONS_DB,
		'section'  => 'larisdigital_section_opengraph',
		'type'     => 'image',
		'active_callback' => 'larisdigital_callback_opengraph_frontpage_inactive',
	);

	$controls['opengraph_frontpage_title'] = array(
		'label'    => esc_html__( 'Homepage Title', 'larisdigital-wp' ),
		'setting'  => 'opengraph_frontpage_title',
		'setting_type' => 'option_mod',
		'setting_db' => LARISDIGITAL_INTEGRATIONS_DB,
		'section'  => 'larisdigital_section_opengraph',
		'type'     => 'text',
		'active_callback' => 'larisdigital_callback_opengraph_frontpage_inactive',
	);

	$controls['opengraph_frontpage_description'] = array(
		'label'    => esc_html__( 'Homepage Description', 'larisdigital-wp' ),
		'setting'  => 'opengraph_frontpage_description',
		'setting_type' => 'option_mod',
		'setting_db' => LARISDIGITAL_INTEGRATIONS_DB,
		'section'  => 'larisdigital_section_opengraph',
		'type'     => 'textarea',
		'active_callback' => 'larisdigital_callback_opengraph_frontpage_inactive',
	);

	return $controls;
}

function larisdigital_callback_opengraph_default() {
	$plugin_active = larisdigital_opengraph_check_plugin_active();
	return $plugin_active ? false : true;
}

function larisdigital_callback_opengraph_yoastseo() {
	$plugin_active = false;
	if ( defined('WPSEO_VERSION') ) {
		$plugin_active = true;
	}
	return $plugin_active;
}

function larisdigital_callback_opengraph_frontpage_active() {
	$show = ( 'page' == get_option( 'show_on_front' ) && get_option( 'page_on_front' ) ) ? true : false;
	$plugin_active = larisdigital_opengraph_check_plugin_active();
	$show = $plugin_active ? false : $show;
	return $show;
}

function larisdigital_callback_opengraph_frontpage_inactive() {
	$show = ( 'page' == get_option( 'show_on_front' ) && get_option( 'page_on_front' ) ) ? false : true;
	$plugin_active = larisdigital_opengraph_check_plugin_active();
	$show = $plugin_active ? false : $show;
	return $show;
}

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_5b0d3b06d96fa',
	'title' => esc_html__( 'Open Graph (Facebook Sharing)', 'larisdigital-wp' ),
	'fields' => array(
		array(
			'key' => 'field_5b0e42174c44e',
			'label' => esc_html__( 'Customize', 'larisdigital-wp' ),
			'name' => '_og_custom',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => esc_html__( 'Use custom Open Graph setting for this page', 'larisdigital-wp' ),
			'default_value' => 0,
			'ui' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_5b0d3bd43ddcd',
			'label' => esc_html__( 'Image', 'larisdigital-wp' ),
			'name' => '_og_image',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5b0e42174c44e',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'id',
			'preview_size' => 'medium-thumbnail',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => 1,
			'mime_types' => 'jpg,png',
		),
		array(
			'key' => 'field_5b0d3c2d3ddce',
			'label' => esc_html__( 'Title', 'larisdigital-wp' ),
			'name' => '_og_title',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5b0e42174c44e',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5b0d3c3f3ddcf',
			'label' => esc_html__( 'Description', 'larisdigital-wp' ),
			'name' => '_og_description',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5b0e42174c44e',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => 2,
			'new_lines' => '',
		),
		array(
			'key' => 'field_5b0d3e32a063b',
			'label' => esc_html__( 'Debug', 'larisdigital-wp' ),
			'name' => '',
			'type' => 'message',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5b0e42174c44e',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => sprintf( esc_html__( 'Please use %sFacebook Sharing Debug%s if you want to preview the result and also to force Facebook to use the latest changes of Open Graph settings on this page.', 'larisdigital-wp' ), '<a href="https://developers.facebook.com/tools/debug/sharing/" target="_blank">', '</a>' ),
			'new_lines' => '',
			'esc_html' => 0,
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'post',
			),
		),
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'page',
			),
		),
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'product',
			),
		),
	),
	'menu_order' => 6,
	'position' => 'advanced',
	'style' => 'default',
	'label_placement' => 'left',
	'instruction_placement' => 'field',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

endif;

add_action( 'wp_head', 'larisdigital_opengraph_wp_head', 5 );
function larisdigital_opengraph_wp_head() {
	$plugin_active = larisdigital_opengraph_check_plugin_active();
	if ( $plugin_active ) {
		return;
	}
	$get_mode = larisdigital_get_integration_mode();
	extract( $get_mode );
	if ( in_array( $mode, array( 'page', 'page_home', 'page_blog', 'shop' ) ) ) {
		$og_custom = get_post_meta( $page_id, '_og_custom', true );
		if ( ! $og_custom ) {
			return;
		}
		echo '<!-- Open Graph (Facebook Sharing) -->'."\n";
		echo '<meta property="og:site_name" content="'.esc_attr( get_bloginfo( 'name' ) ).'"/>'."\n";
		echo '<meta property="og:type" content="website"/>'."\n";
		$og_title = get_post_meta( $page_id, '_og_title', true );
		if ( empty( $og_title ) ) {
			$og_title = get_the_title( $page_id );
		}
		echo '<meta property="og:title" content="'.esc_attr($og_title).'"/>'."\n";
		$og_description = get_post_meta( $page_id, '_og_description', true );
		echo '<meta property="og:description" content="'.esc_attr($og_description).'"/>'."\n";
		$og_image = '';
		$og_image_id = get_post_meta( $page_id, '_og_image', true );
		if ( empty( $og_image_id ) ) {
			$og_image_id = get_post_thumbnail_id( $page_id );
		}
		if ( $og_image_id ) {
			$og_image = wp_get_attachment_url( $og_image_id );
		}
		if ( empty( $og_image ) ) {
			$og_image_default = larisdigital_get_integration( 'opengraph_image_default' );
			if ( $og_image_default ) {
				$og_image = $og_image_default;
			}
		}
		if ( $og_image ) {
			echo '<meta property="og:image" content="'.$og_image.'"/>'."\n";
		}
		echo '<meta property="og:url" content="'.esc_url( get_permalink( $page_id ) ).'"/>'."\n";
		echo '<!-- End Open Graph (Facebook Sharing) -->'."\n";
	}
	elseif ( 'frontpage' == $mode ) {
		echo '<!-- Open Graph (Facebook Sharing) -->'."\n";
		echo '<meta property="og:site_name" content="'.esc_attr( get_bloginfo( 'name' ) ).'"/>'."\n";
		echo '<meta property="og:type" content="website"/>'."\n";
		$og_title = larisdigital_get_integration('opengraph_frontpage_title');
		if ( empty( $og_title ) ) {
			$og_title = get_bloginfo( 'name' );
		}
		echo '<meta property="og:title" content="'.esc_attr($og_title).'"/>'."\n";
		$og_description = larisdigital_get_integration('opengraph_frontpage_description');
		if ( empty( $og_description ) ) {
			$og_description = get_bloginfo( 'description' );
		}
		echo '<meta property="og:description" content="'.esc_attr($og_description).'"/>'."\n";
		$og_image = larisdigital_get_integration('opengraph_frontpage_image');
		if ( empty( $og_image ) ) {
			$og_image_default = larisdigital_get_integration( 'opengraph_image_default' );
			if ( $og_image_default ) {
				$og_image = $og_image_default;
			}
		}
		if ( $og_image ) {
			echo '<meta property="og:image" content="'.$og_image.'"/>'."\n";
		}
		echo '<meta property="og:url" content="'.esc_url( home_url( '/' ) ).'"/>'."\n";
		echo '<!-- End Open Graph (Facebook Sharing) -->'."\n";
	}
}

function larisdigital_opengraph_check_plugin_active() {
	$plugin_active = false;
	if ( defined('WPSEO_VERSION') ) {
		$plugin_active = true;
	}
	return $plugin_active;
}

add_action( 'admin_head', 'larisdigital_opengraph_admin_head_acf' );
function larisdigital_opengraph_admin_head_acf() {
	$plugin_active = larisdigital_opengraph_check_plugin_active();
	if ( $plugin_active ) {
		echo '<style>#acf-group_5b0d3b06d96fa { display: none !important; }</style>';
	}
}
