<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_5b0d262324772',
	'title' => 'Custom Header & Footer Script',
	'fields' => array(
		array(
			'key' => 'field_5b0e47e4bc0da',
			'label' => '',
			'name' => '_script_custom',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => esc_html__( 'Use custom header or footer script for this page', 'larisdigital-wp' ),
			'default_value' => 0,
			'ui' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_5b0d267387d8c',
			'label' => esc_html__( 'Custom Header Script', 'larisdigital-wp' ),
			'name' => '_script_header',
			'type' => 'textarea',
			'instructions' => esc_html__( 'You can add custom style / script for this page only. It will be applied on <code>wp_head</code> location.', 'larisdigital-wp' ),
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5b0e47e4bc0da',
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
			'placeholder' => '<style> /* some style for this page only */ </style>',
			'maxlength' => '',
			'rows' => 4,
			'new_lines' => '',
		),
		array(
			'key' => 'field_5b0d269f87d8d',
			'label' => esc_html__( 'Custom Footer Script', 'larisdigital-wp' ),
			'name' => '_script_footer',
			'type' => 'textarea',
			'instructions' => esc_html__( 'You can add custom script / style for this page only. It will be applied on <code>wp_footer</code> location.', 'larisdigital-wp' ),
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5b0e47e4bc0da',
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
			'placeholder' => '<script> /* some script for this page only */ </script>',
			'maxlength' => '',
			'rows' => 4,
			'new_lines' => '',
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
	'menu_order' => 8,
	'position' => 'advanced',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'field',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

endif;

add_action( 'larisdigital_custom_script_wp_head', 'larisdigital_custom_script_wp_head' );
function larisdigital_custom_script_wp_head() {
	if ( ! is_singular() ) {
		return;
	}
	$script_custom = get_post_meta( get_the_ID(), '_script_custom', true );
	if ( ! $script_custom ) {
		return;
	}
	$script_header = get_post_meta( get_the_ID(), '_script_header', true );
	if ( ! empty( $script_header ) ) {
		echo $script_header."\n";
	}
}

add_action( 'larisdigital_custom_script_wp_footer', 'larisdigital_custom_script_wp_footer' );
function larisdigital_custom_script_wp_footer() {
	if ( ! is_singular() ) {
		return;
	}
	$script_custom = get_post_meta( get_the_ID(), '_script_custom', true );
	if ( ! $script_custom ) {
		return;
	}
	$script_footer = get_post_meta( get_the_ID(), '_script_footer', true );
	if ( ! empty( $script_footer ) ) {
		echo $script_footer."\n";
	}
}

add_action( 'admin_head', 'larisdigital_custom_script_admin_head_acf_shop' );
function larisdigital_custom_script_admin_head_acf_shop() {
	if ( class_exists( 'woocommerce') ) {
		$shop_page_id = wc_get_page_id( 'shop' );
		if ( $shop_page_id && $shop_page_id == get_the_ID() ) {
			echo '<style>#acf-group_5b0d262324772 { display: none !important; }</style>';
		}
	}
}
