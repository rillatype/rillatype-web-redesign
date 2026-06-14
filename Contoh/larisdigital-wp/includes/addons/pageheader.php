<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_action( 'admin_head', 'larisdigital_page_header_admin_head_acf' );
function larisdigital_page_header_admin_head_acf() {
	$shop_page = false;
	$page_id = function_exists( 'get_the_ID' ) ? get_the_ID() : '';
	if ( class_exists( 'woocommerce' ) && function_exists( 'wc_get_page_id' ) ) {
		$shop_page_id = wc_get_page_id( 'shop' );
		if ( $shop_page_id && $shop_page_id == $page_id ) {
			$shop_page = true;
		}
	}
	$header_hide = false;
	if ( larisdigital_theme_mod( 'larisdigital_header_hide' ) ) {
		$header_hide = true;
	}
	else {
		if ( function_exists( 'get_post_type' ) ) {
			$post_type = get_post_type();
			if ( 'post' == $post_type ) {
				if ( larisdigital_theme_mod( 'larisdigital_post_header_hide' ) ) {
					$header_hide = true;
				}
			}
			elseif ( 'page' == $post_type ) {
				if ( larisdigital_theme_mod( 'larisdigital_page_header_hide' ) ) {
					$header_hide = true;
				}
				if ( $shop_page ) {
					$header_hide = false;
				}
			}
			elseif ( 'product' == $post_type ) {
				if ( class_exists( 'woocommerce' ) && larisdigital_theme_mod( 'larisdigital_wc_product_header_hide' ) ) {
					$header_hide = true;
				}
			}
		}
	}
	if ( $header_hide ) {
		echo '<style>#acf-group_5b0e4ca11adf2, .acf-field-5b0794181694b { display: none !important; }</style>'."\n";
	}
	// if ( $shop_page ) {
	// 	echo '<style>.acf-field-5be12d25d1a6a { display: none !important; }</style>'."\n";
	// }
	else {
		$page_header_hide = function_exists( 'get_post_meta') ? get_post_meta( $page_id, '_header_hide', true ) : false;
		if ( $page_header_hide ) {
			$header_hide = true;
		}
		if ( ! $header_hide ) {
			echo '<style>.acf-field-5be12d25d1a6a { display: none !important; }</style>'."\n";
		}
	}
}

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_5b0e4ca11adf2',
	'title' => esc_html__( 'Site Header (Title & Description)', 'larisdigital-wp' ),
	'fields' => array(
		array(
			'key' => 'field_5b0e4cfb4a41a',
			'label' => 'Customize',
			'name' => '_header_custom',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => esc_html__( 'Customize site header on this page', 'larisdigital-wp' ),
			'default_value' => 0,
			'ui' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_5b0e4d514a41b',
			'label' => esc_html__( 'Title', 'larisdigital-wp' ),
			'name' => '_title',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5b0e4cfb4a41a',
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
			'key' => 'field_5b0e4d744a41c',
			'label' => esc_html__( 'Subtitle', 'larisdigital-wp' ),
			'name' => '_subtitle',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5b0e4cfb4a41a',
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
			'key' => 'field_5b0e4dbf2799d',
			'label' => esc_html__( 'Background Color', 'larisdigital-wp' ),
			'name' => '_header_bg_color',
			'type' => 'color_picker',
			'instructions' => esc_html__( 'It is fallback color when background image is not available.', 'larisdigital-wp' ),
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5b0e4cfb4a41a',
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
		),
		array(
			'key' => 'field_5b0e4e252799f',
			'label' => esc_html__( 'Background Image', 'larisdigital-wp' ),
			'name' => '_header_bg_image',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5b0e4cfb4a41a',
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
			'preview_size' => 'thumbnail',
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
			'key' => 'field_5b0e4f2843c36',
			'label' => esc_html__( 'Padding Top', 'larisdigital-wp' ),
			'name' => '_header_padding_top',
			'type' => 'range',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5b0e4cfb4a41a',
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
			'min' => 0,
			'max' => 10,
			'step' => '0.1',
			'prepend' => '',
			'append' => 'rem',
		),
		array(
			'key' => 'field_5b0e4fe98e338',
			'label' => esc_html__( 'Padding Bottom', 'larisdigital-wp' ),
			'name' => '_header_padding_bottom',
			'type' => 'range',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5b0e4cfb4a41a',
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
			'min' => 0,
			'max' => 10,
			'step' => '0.1',
			'prepend' => '',
			'append' => 'rem',
		),
		array(
			'key' => 'field_5b0e50f0bcad9',
			'label' => esc_html__( 'Site Navigation', 'larisdigital-wp' ),
			'name' => '_navigation_absolute',
			'type' => 'true_false',
			'instructions' => esc_html__( 'Use it only when Site Header (Title & Description) is available or when you use any page builder on this page.', 'larisdigital-wp' ),
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5b0e4cfb4a41a',
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
			'message' => esc_html__( 'Absolute Positioned Navigation (Transparent Background Menu)', 'larisdigital-wp' ),
			'default_value' => 0,
			'ui' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
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
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'xlwcty_thankyou',
			),
		),
	),
	'menu_order' => 2,
	'position' => 'advanced',
	'style' => 'default',
	'label_placement' => 'left',
	'instruction_placement' => 'field',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

endif;

add_action( 'get_header', 'larisdigital_page_header_frontend_output' );
function larisdigital_page_header_frontend_output() {
	$header_hide = false;
	if ( larisdigital_theme_mod( 'larisdigital_header_hide' ) ) {
		$header_hide = true;
	}
	else {
		if ( is_singular('post') ) {
			if ( larisdigital_theme_mod( 'larisdigital_post_header_hide' ) ) {
				$header_hide = true;
			}
		}
		elseif ( is_page() ) {
			if ( larisdigital_theme_mod( 'larisdigital_page_header_hide' ) ) {
				$header_hide = true;
			}
		}
		elseif ( class_exists( 'woocommerce' ) && is_product() ) {
			if ( larisdigital_theme_mod( 'larisdigital_wc_product_header_hide' ) ) {
				$header_hide = true;
			}
		}
	}
	if ( class_exists( 'woocommerce' ) && is_shop() ) {
		$header_hide = false;
	}
	if ( $header_hide ) {
		return;
	}
	$get_mode = larisdigital_get_integration_mode();
	extract( $get_mode );
	if ( in_array( $mode, array( 'page', 'page_home', 'page_blog', 'shop' ) ) ) {
		if ( ! get_post_meta( $page_id, '_header_custom', true ) ) {
			return;
		}
		add_filter( 'larisdigital_header_title', 'larisdigital_page_header_title', 50 );
		add_filter( 'larisdigital_header_description', 'larisdigital_page_header_subtitle', 50 );
		add_filter( 'theme_mod_larisdigital_header_background', 'larisdigital_page_header_background_color', 50 );
		add_filter( 'theme_mod_header_image', 'larisdigital_page_header_background_image', 50 );
		add_filter( 'theme_mod_larisdigital_header_padding_top', 'larisdigital_page_header_padding_top', 50 );
		add_filter( 'theme_mod_larisdigital_header_padding_bottom', 'larisdigital_page_header_padding_bottom', 50 );
		add_filter( 'theme_mod_larisdigital_navigation_absolute', 'larisdigital_page_header_navigation_absolute', 50 );
	}
}

function larisdigital_page_header_title( $output ) {
	$get_mode = larisdigital_get_integration_mode();
	extract( $get_mode );
	if ( $page_id ) {
		$title = get_post_meta( $page_id, '_title', true );
		if ( $title ) {
			$output = $title;
		}
	}
	return $output;
}

function larisdigital_page_header_subtitle( $output ) {
	$get_mode = larisdigital_get_integration_mode();
	extract( $get_mode );
	if ( $page_id ) {
		$subtitle = get_post_meta( $page_id, '_subtitle', true );
		if ( $subtitle ) {
			$output = $subtitle;
		}
	}
	return $output;
}

function larisdigital_page_header_background_color( $mod ) {
	$get_mode = larisdigital_get_integration_mode();
	extract( $get_mode );
	if ( $page_id ) {
		if ( $value = get_post_meta( $page_id, '_header_bg_color', true ) ) {
			return $value;
		}
	}
	return $mod;
}

function larisdigital_page_header_background_image( $mod ) {
	$get_mode = larisdigital_get_integration_mode();
	extract( $get_mode );
	if ( $page_id ) {
		if ( $image_id = get_post_meta( $page_id, '_header_bg_image', true ) ) {
			$image = wp_get_attachment_image_url( $image_id, 'custom-header' );
			if ( $image ) {
				return $image;
			}
		}
	}
	return $mod;
}

function larisdigital_page_header_padding_top( $mod ) {
	$get_mode = larisdigital_get_integration_mode();
	extract( $get_mode );
	if ( $page_id ) {
		if ( $value = get_post_meta( $page_id, '_header_padding_top', true ) ) {
			return $value;
		}
	}
	return $mod;
}

function larisdigital_page_header_padding_bottom( $mod ) {
	$get_mode = larisdigital_get_integration_mode();
	extract( $get_mode );
	if ( $page_id ) {
		if ( $value = get_post_meta( $page_id, '_header_padding_bottom', true ) ) {
			return $value;
		}
	}
	return $mod;
}

function larisdigital_page_header_navigation_absolute( $mod ) {
	$get_mode = larisdigital_get_integration_mode();
	extract( $get_mode );
	if ( $page_id ) {
		if ( $absolute = get_post_meta( $page_id, '_navigation_absolute', true ) ) {
			return true;
		}
	}
	return $mod;
}
