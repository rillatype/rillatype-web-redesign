<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_action( 'admin_head', 'larisdigital_page_header_image_admin_head_acf' );
function larisdigital_page_header_image_admin_head_acf() {
	if ( ! ( larisdigital_theme_mod( 'larisdigital_header_hide' ) && larisdigital_theme_mod( 'larisdigital_header_image' ) ) ) {
		echo '<style>#acf-group_5b889c54a770b { display: none !important; }</style>'."\n";
	}
}

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_5b889c54a770b',
	'title' => 'Site Header Image',
	'fields' => array(
		array(
			'key' => 'field_5b88a10961fbb',
			'label' => esc_html__( 'Show / Hide', 'larisdigital-wp' ),
			'name' => '_header_image_hide',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => esc_html__( 'Hide header image on this page', 'larisdigital-wp' ),
			'default_value' => 0,
			'ui' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_5b889c54b53a8',
			'label' => esc_html__( 'Header Image', 'larisdigital-wp' ),
			'name' => '_header_image',
			'type' => 'image',
			'instructions' => esc_html__( 'This custom header image will be loaded in full size. Please optimize and crop the image (if needed) before upload the image here.', 'larisdigital-wp' ),
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5b88a10961fbb',
						'operator' => '!=',
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
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'left',
	'instruction_placement' => 'field',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

endif;

add_action( 'get_header', 'larisdigital_page_header_image_frontend_output' );
function larisdigital_page_header_image_frontend_output() {
	if ( ! ( larisdigital_theme_mod( 'larisdigital_header_hide' ) && larisdigital_theme_mod( 'larisdigital_header_image' ) ) ) {
		return;
	}
	$get_mode = larisdigital_get_integration_mode();
	extract( $get_mode );
	if ( in_array( $mode, array( 'page', 'page_home', 'page_blog', 'shop' ) ) ) {
		if ( get_post_meta( $page_id, '_header_image_hide', true ) ) {
			add_filter( 'larisdigital_header_image_is_active', '__return_false', 25 );
		}
		add_filter( 'theme_mod_header_image', 'larisdigital_page_header_image_filter', 25 );
	}
}

function larisdigital_page_header_image_filter( $mod ) {
	$get_mode = larisdigital_get_integration_mode();
	extract( $get_mode );
	if ( $page_id ) {
		if ( $image_id = get_post_meta( $page_id, '_header_image', true ) ) {
			$image = wp_get_attachment_image_url( $image_id, 'full' );
			if ( $image ) {
				return $image;
			}
		}
	}
	return $mod;
}

