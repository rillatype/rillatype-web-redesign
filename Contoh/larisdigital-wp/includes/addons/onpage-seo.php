<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_filter( 'larisdigital_customize_controls', 'larisdigital_customize_controls_onpageseo' );
function larisdigital_customize_controls_onpageseo( $controls ) {

	$controls['larisdigital_section_onpageseo'] = array(
		'title'    => esc_html__( 'OnPage SEO', 'larisdigital-wp' ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-success larisdigital-alert-with-icon">
							<span class="dashicons dashicons-megaphone"></span> '.esc_html__( 'OnPage setting is useful to control the title and description of your website on search engine results.', 'larisdigital-wp' ).'<br><br>'.esc_html__( 'OnPage SEO setting for a post/page can be edited using "OnPage SEO" metabox when editing a post/page.', 'larisdigital-wp' ).'
							</p>',
		'setting'  => 'larisdigital_section_onpageseo',
		'panel'    => 'larisdigital_panel_integrations',
		'type'     => 'section',
		'priority' => 100,
	);

	$controls['larisdigital_warning_onpageseo_notpublic'] = array(
		'label'		=> esc_html__( 'OnPage SEO setting is disabled!', 'larisdigital-wp' ),
		'description' => esc_html__( 'Go to Settings - Reading page to change "Search Engine Visibility" option.', 'larisdigital-wp' ),
		'setting'  	=> 'larisdigital_warning_onpageseo_notpublic',
		'section'	=> 'larisdigital_section_onpageseo',
		'type'   	=> 'warning',
		'active_callback' => 'larisdigital_callback_onpageseo_notpublic',
	);

	$controls['larisdigital_warning_onpageseo_yoastseo'] = array(
		'label'		=> esc_html__( 'Yoast WordPress SEO Plugin is Active!', 'larisdigital-wp' ),
		'description' => esc_html__( 'OnPage SEO setting is from this plugin, not from the theme.', 'larisdigital-wp' ),
		'setting'  	=> 'larisdigital_warning_onpageseo_yoastseo',
		'section'	=> 'larisdigital_section_onpageseo',
		'type'   	=> 'warning',
		'active_callback' => 'larisdigital_callback_onpageseo_yoastseo',
	);

	$controls['larisdigital_warning_onpageseo_aioseo'] = array(
		'label'		=> esc_html__( 'All In One SEO Plugin is Active!', 'larisdigital-wp' ),
		'description' => esc_html__( 'OnPage SEO setting is from this plugin, not from the theme.', 'larisdigital-wp' ),
		'setting'  	=> 'larisdigital_warning_onpageseo_aioseo',
		'section'	=> 'larisdigital_section_onpageseo',
		'type'   	=> 'warning',
		'active_callback' => 'larisdigital_callback_onpageseo_aioseo',
	);

	$controls['onpageseo_disable'] = array(
		'label'    => esc_html__( 'Disable OnPage SEO from this theme', 'larisdigital-wp' ),
		'description' => esc_html__( 'Use this option if you want to use other plugin to handle OnPage SEO.', 'larisdigital-wp' ),
		'setting'  => 'onpageseo_disable',
		'setting_type' => 'option_mod',
		'setting_db' => LARISDIGITAL_INTEGRATIONS_DB,
		'section'  => 'larisdigital_section_onpageseo',
		'type'     => 'checkbox',
		'active_callback' => 'larisdigital_callback_onpageseo_default',
	);

	$controls['larisdigital_heading_onpageseo_frontpage_active'] = array(
		'label'		=> esc_html__( 'Homepage OnPage SEO Setting', 'larisdigital-wp' ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-danger larisdigital-alert-with-icon">
							<span class="dashicons dashicons-warning"></span> '.esc_html__( 'This website use static page for Homepage / Frontpage.', 'larisdigital-wp' ).'<br><br>'.esc_html__( 'Please edit OnPage setting for homepage using "OnPage SEO" metabox when editing this Homepage page.', 'larisdigital-wp' ).'
							</p>',
		'setting'  	=> 'larisdigital_heading_onpageseo_frontpage_active',
		'section'	=> 'larisdigital_section_onpageseo',
		'type'   	=> 'heading',
		'active_callback' => 'larisdigital_callback_onpageseo_frontpage_active',
	);

	$controls['larisdigital_heading_onpageseo_frontpage'] = array(
		'label'		=> esc_html__( 'Homepage OnPage SEO Setting', 'larisdigital-wp' ),
		'setting'  	=> 'larisdigital_heading_onpageseo_frontpage',
		'section'	=> 'larisdigital_section_onpageseo',
		'type'   	=> 'heading',
		'active_callback' => 'larisdigital_callback_onpageseo_frontpage_inactive',
	);

	$controls['onpageseo_frontpage_title'] = array(
		'label'    => esc_html__( 'Homepage SEO Title', 'larisdigital-wp' ),
		'setting'  => 'onpageseo_frontpage_title',
		'setting_type' => 'option_mod',
		'setting_db' => LARISDIGITAL_INTEGRATIONS_DB,
		'section'  => 'larisdigital_section_onpageseo',
		'type'     => 'text',
		'active_callback' => 'larisdigital_callback_onpageseo_frontpage_inactive',
	);

	$controls['onpageseo_frontpage_description'] = array(
		'label'    => esc_html__( 'Homepage SEO Description', 'larisdigital-wp' ),
		'setting'  => 'onpageseo_frontpage_description',
		'setting_type' => 'option_mod',
		'setting_db' => LARISDIGITAL_INTEGRATIONS_DB,
		'section'  => 'larisdigital_section_onpageseo',
		'type'     => 'textarea',
		'active_callback' => 'larisdigital_callback_onpageseo_frontpage_inactive',
	);

	$controls['onpageseo_frontpage_keywords'] = array(
		'label'    => esc_html__( 'Homepage SEO Keywords', 'larisdigital-wp' ),
		'setting'  => 'onpageseo_frontpage_keywords',
		'setting_type' => 'option_mod',
		'setting_db' => LARISDIGITAL_INTEGRATIONS_DB,
		'section'  => 'larisdigital_section_onpageseo',
		'type'     => 'text',
		'active_callback' => 'larisdigital_callback_onpageseo_frontpage_inactive',
	);

	return $controls;
}

function larisdigital_callback_onpageseo_default() {
	$plugin_active = larisdigital_onpageseo_check_plugin_active();
	return $plugin_active ? false : true;
}

function larisdigital_callback_onpageseo_notpublic() {
	$plugin_active = false;
	if ( '0' === (string) get_option( 'blog_public' ) ) {
		$plugin_active = true;
	}
	return $plugin_active;
}

function larisdigital_callback_onpageseo_yoastseo() {
	$plugin_active = false;
	if ( defined('WPSEO_VERSION') ) {
		$plugin_active = true;
	}
	return $plugin_active;
}

function larisdigital_callback_onpageseo_aioseo() {
	$plugin_active = false;
	if ( class_exists('All_in_One_SEO_Pack') || class_exists('All_in_One_SEO_Pack_p') ) {
		$plugin_active = true;
	}
	return $plugin_active;
}

function larisdigital_callback_onpageseo_frontpage_active() {
	$show = ( 'page' == get_option( 'show_on_front' ) && get_option( 'page_on_front' ) ) ? true : false;
	$plugin_active = larisdigital_onpageseo_check_plugin_active();
	$show = $plugin_active ? false : $show;
	return $show;
}

function larisdigital_callback_onpageseo_frontpage_inactive() {
	$show = ( 'page' == get_option( 'show_on_front' ) && get_option( 'page_on_front' ) ) ? false : true;
	$plugin_active = larisdigital_onpageseo_check_plugin_active();
	$show = $plugin_active ? false : $show;
	return $show;
}

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_5b0e0339e8ea5',
	'title' => esc_html__( 'OnPage SEO', 'larisdigital-wp' ),
	'fields' => array(
		array(
			'key' => 'field_5b0e469ec57f0',
			'label' => 'Customize',
			'name' => '_seo_custom',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => 'Use custom OnPage SEO setting for this page',
			'default_value' => 0,
			'ui' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_5b0e0339f3f8e',
			'label' => esc_html__( 'Title', 'larisdigital-wp' ),
			'name' => '_seo_title',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5b0e469ec57f0',
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
			'key' => 'field_5b0e0339f3fea',
			'label' => esc_html__( 'Description', 'larisdigital-wp' ),
			'name' => '_seo_description',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5b0e469ec57f0',
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
			'key' => 'field_5b0e04b23b130',
			'label' => esc_html__( 'Keywords', 'larisdigital-wp' ),
			'name' => '_seo_keywords',
			'type' => 'text',
			'instructions' => esc_html__( 'Separated by comma. Note: Google ignore meta keywords.', 'larisdigital-wp' ),
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5b0e469ec57f0',
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
			'key' => 'field_5b0e05273b131',
			'label' => esc_html__( 'Robots', 'larisdigital-wp' ),
			'name' => '_seo_robots',
			'type' => 'radio',
			'instructions' => esc_html__( 'Use "noindex" if you want to block search engine from indexing this page.', 'larisdigital-wp' ),
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5b0e469ec57f0',
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
			'choices' => array(
				'index,follow' => 'index,follow',
				'noindex,follow' => 'noindex,follow',
			),
			'allow_null' => 0,
			'other_choice' => 0,
			'save_other_choice' => 0,
			'default_value' => '',
			'layout' => 'vertical',
			'return_format' => 'value',
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
	'menu_order' => 7,
	'position' => 'advanced',
	'style' => 'default',
	'label_placement' => 'left',
	'instruction_placement' => 'field',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

endif;

add_action( 'wp_head', 'larisdigital_onpageseo_wp_head', 4 );
function larisdigital_onpageseo_wp_head() {
	$plugin_active = false;
	$plugin_active = larisdigital_onpageseo_check_plugin_active();
	if ( $plugin_active ) {
		return;
	}
	$get_mode = larisdigital_get_integration_mode();
	extract( $get_mode );
	if ( in_array( $mode, array( 'page', 'page_home', 'page_blog', 'shop' ) ) ) {
		$seo_custom = get_post_meta( $page_id, '_seo_custom', true );
		if ( ! $seo_custom ) {
			return;
		}
		$seo_description = get_post_meta( $page_id, '_seo_description', true );
		if ( $seo_description ) {
			echo '<meta name="description" content="'.esc_attr($seo_description).'"/>'."\n";
		}
		$seo_keywords = get_post_meta( $page_id, '_seo_keywords', true );
		if ( $seo_keywords ) {
			echo '<meta name="keywords" content="'.esc_attr($seo_keywords).'"/>'."\n";
		}
		$seo_robots = get_post_meta( $page_id, '_seo_robots', true );
		if ( empty( $seo_robots ) ) {
			$seo_robots = 'index,follow';
		}
		if ( $seo_robots ) {
			echo '<meta name="robots" content="'.esc_attr($seo_robots).'"/>'."\n";
		}
	}
	elseif ( 'frontpage' == $mode ) {
		$seo_description = larisdigital_get_integration('onpageseo_frontpage_description');
		if ( empty( $seo_description ) ) {
			$seo_description = get_bloginfo( 'description' );
		}
		if ( $seo_description ) {
			echo '<meta name="description" content="'.esc_attr($seo_description).'"/>'."\n";
		}
		$seo_keywords = larisdigital_get_integration('onpageseo_frontpage_keywords');
		if ( $seo_keywords ) {
			echo '<meta name="keywords" content="'.esc_attr($seo_keywords).'"/>'."\n";
		}
		$seo_robots = 'index,follow';
		if ( $seo_robots ) {
			echo '<meta name="robots" content="'.esc_attr($seo_robots).'"/>'."\n";
		}
	}
}

add_filter( 'pre_get_document_title', 'larisdigital_onpageseo_document_title' );
function larisdigital_onpageseo_document_title( $title ) {
	$plugin_active = false;
	$plugin_active = larisdigital_onpageseo_check_plugin_active();
	if ( $plugin_active ) {
		return $title;
	}
	$get_mode = larisdigital_get_integration_mode();
	extract( $get_mode );
	if ( in_array( $mode, array( 'page', 'page_home', 'page_blog', 'shop' ) ) ) {
		$seo_custom = get_post_meta( $page_id, '_seo_custom', true );
		if ( ! $seo_custom ) {
			return $title;
		}
		$seo_title = get_post_meta( $page_id, '_seo_title', true );
		if ( $seo_title ) {
			$title = $seo_title;
		}
	}
	elseif ( 'frontpage' == $mode ) {
		$seo_title = larisdigital_get_integration('onpageseo_frontpage_title');
		if ( $seo_title ) {
			$title = $seo_title;
		}
	}
	return $title;
}

function larisdigital_onpageseo_check_plugin_active() {
	$plugin_active = false;
	if ( '0' === (string) get_option( 'blog_public' ) ) {
		$plugin_active = true;
	}
	elseif ( defined('WPSEO_VERSION') ) {
		$plugin_active = true;
	}
	elseif ( class_exists('All_in_One_SEO_Pack') || class_exists('All_in_One_SEO_Pack_p') ) {
		$plugin_active = true;
	}
	return $plugin_active;
}

add_action( 'admin_head', 'larisdigital_onpageseo_admin_head_acf' );
function larisdigital_onpageseo_admin_head_acf() {
	$plugin_active = larisdigital_onpageseo_check_plugin_active();
	if ( $plugin_active ) {
		echo '<style>#acf-group_5b0e0339e8ea5 { display: none !important; }</style>';
	}
}
