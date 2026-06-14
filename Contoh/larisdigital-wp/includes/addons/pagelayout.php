<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_action( 'admin_head', 'larisdigital_page_layout_admin_head_acf' );
function larisdigital_page_layout_admin_head_acf() {
	$layout_hide = array();
	if ( larisdigital_theme_mod( 'larisdigital_topbar_hide' ) ) {
		$layout_hide[] = '.acf-field-5b0793372effc'; 
	}
	if ( larisdigital_theme_mod( 'larisdigital_navigation_hide' ) ) {
		$layout_hide[] = '.acf-field-5b0793e81694a'; 
	}
	if ( larisdigital_theme_mod( 'larisdigital_breadcrumb_hide' ) ) {
		$layout_hide[] = '.acf-field-5b07a7f974236'; 
	}
	if ( larisdigital_theme_mod( 'larisdigital_footer_widgets_hide' ) ) {
		$layout_hide[] = '.acf-field-5b07a81574237'; 
	}
	if ( larisdigital_theme_mod( 'larisdigital_footer_hide' ) ) {
		$layout_hide[] = '.acf-field-5b07a88c74238'; 
	}
	if ( ! empty( $layout_hide ) ) {
		echo '<style>'.implode( ', ', $layout_hide ).' { display: none !important; }</style>'."\n";
	}
}

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_5b0792dc74645',
	'title' => esc_html__( 'Page Layout', 'larisdigital-wp' ),
	'fields' => array(
		array(
			'key' => 'field_5b0e49734f4ec',
			'label' => esc_html__( 'Customize', 'larisdigital-wp' ),
			'name' => '_layout_custom',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => esc_html__( 'Use custom page layout for this page', 'larisdigital-wp' ),
			'default_value' => 0,
			'ui' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_5b0793372effc',
			'label' => esc_html__( 'Site Top Bar', 'larisdigital-wp' ),
			'name' => '_topbar_hide',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5b0e49734f4ec',
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
			'message' => sprintf( esc_html__( 'HIDE %s', 'larisdigital-wp' ), esc_html__( 'Site Top Bar', 'larisdigital-wp' ) ),
			'default_value' => 0,
			'ui' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_5b0793e81694a',
			'label' => esc_html__( 'Site Navigation', 'larisdigital-wp' ),
			'name' => '_navigation_hide',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5b0e49734f4ec',
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
			'message' => sprintf( esc_html__( 'HIDE %s', 'larisdigital-wp' ), esc_html__( 'Site Navigation (Menu)', 'larisdigital-wp' ) ),
			'default_value' => 0,
			'ui' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_5b0794181694b',
			'label' => esc_html__( 'Site Header', 'larisdigital-wp' ),
			'name' => '_header_hide',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5b0e49734f4ec',
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
			'message' => sprintf( esc_html__( 'HIDE %s', 'larisdigital-wp' ), esc_html__( 'Site Header (Title & Description)', 'larisdigital-wp' ) ),
			'default_value' => 0,
			'ui' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_5b07a7f974236',
			'label' => esc_html__( 'Site Breadcrumb', 'larisdigital-wp' ),
			'name' => '_breadcrumb_hide',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5b0e49734f4ec',
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
			'message' => sprintf( esc_html__( 'HIDE %s', 'larisdigital-wp' ), esc_html__( 'Site Breadcrumb', 'larisdigital-wp' ) ),
			'default_value' => 0,
			'ui' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_5b07a81574237',
			'label' => esc_html__( 'Site Footer Widgets', 'larisdigital-wp' ),
			'name' => '_footer_widgets_hide',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5b0e49734f4ec',
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
			'message' => sprintf( esc_html__( 'HIDE %s', 'larisdigital-wp' ), esc_html__( 'Site Footer Widgets', 'larisdigital-wp' ) ),
			'default_value' => 0,
			'ui' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_5b07a88c74238',
			'label' => esc_html__( 'Site Footer', 'larisdigital-wp' ),
			'name' => '_footer_hide',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5b0e49734f4ec',
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
			'message' => sprintf( esc_html__( 'HIDE %s', 'larisdigital-wp' ), esc_html__( 'Site Footer', 'larisdigital-wp' ) ),
			'default_value' => 0,
			'ui' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_5b0f531ddcaa5',
			'label' => 'Sidebar Layout',
			'name' => '_sidebar_layout',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5b0e49734f4ec',
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
				'default' => 'Default',
				'right' => 'Right Sidebar',
				'left' => 'Left Sidebar',
				'none' => 'No Sidebar',
			),
			'default_value' => array(
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'ajax' => 0,
			'return_format' => 'value',
			'placeholder' => '',
		),
		array(
			'key' => 'field_5b0f534ddcaa6',
			'label' => 'Sidebar Width',
			'name' => '_sidebar_width',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5b0e49734f4ec',
						'operator' => '==',
						'value' => '1',
					),
					array(
						'field' => 'field_5b0f531ddcaa5',
						'operator' => '!=',
						'value' => 'none',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'default' => 'Default',
				3 => '3/12 Grid',
				4 => '4/12 Grid',
				5 => '5/12 Grid',
				6 => '6/12 Grid',
			),
			'default_value' => array(
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'ajax' => 0,
			'return_format' => 'value',
			'placeholder' => '',
		),
		array(
			'key' => 'field_5b0f53e5dcaa8',
			'label' => 'Content Width',
			'name' => '_content_width',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5b0e49734f4ec',
						'operator' => '==',
						'value' => '1',
					),
					array(
						'field' => 'field_5b0f531ddcaa5',
						'operator' => '==',
						'value' => 'none',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'default' => 'Default',
				12 => '12/12 Grid',
				11 => '11/12 Grid',
				10 => '10/12 Grid',
				9 => '9/12 Grid',
				8 => '8/12 Grid',
				7 => '7/12 Grid',
				6 => '6/12 Grid',
			),
			'default_value' => array(
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'ajax' => 0,
			'return_format' => 'value',
			'placeholder' => '',
		),
		array(
			'key' => 'field_5be12d25d1a6a',
			'label' => 'Page Title',
			'name' => '_title_hide',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5b0e49734f4ec',
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
			'message' => 'HIDE Post / Page / Product Title',
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
	'menu_order' => 3,
	'position' => 'advanced',
	'style' => 'default',
	'label_placement' => 'left',
	'instruction_placement' => 'field',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

else : 

new LarisDigital_Metabox( array(
	'id' => 'larisdigital_page_layout', 
	'title' => esc_html__( 'Page Layout', 'larisdigital-wp' ), 
	'screen' => array( 'post', 'page' ), 
	'context' => 'advanced',
	'priority' => 'high',
	'fields' => array( 
		array(
			'id' => '_topbar_hide',
			'label' => esc_html__( 'Site Top Bar', 'larisdigital-wp' ),
			'label2' => sprintf( esc_html__( 'HIDE %s', 'larisdigital-wp' ), esc_html__( 'Site Top Bar', 'larisdigital-wp' ) ),
			'type' => 'checkbox',
		),
		array(
			'id' => '_navigation_hide',
			'label' => esc_html__( 'Site Navigation', 'larisdigital-wp' ),
			'label2' => sprintf( esc_html__( 'HIDE %s', 'larisdigital-wp' ), esc_html__( 'Site Navigation', 'larisdigital-wp' ) ),
			'type' => 'checkbox',
		),
		array(
			'id' => '_navigation_absolute',
			'label' => esc_html__( 'Site Navigation Position', 'larisdigital-wp' ),
			'label2' => esc_html__( 'Absolute Positioned Navigation (Transparent Header)', 'larisdigital-wp' ),
			'type' => 'checkbox',
		),
		array(
			'id' => '_header_hide',
			'label' => esc_html__( 'Site Header', 'larisdigital-wp' ),
			'label2' => sprintf( esc_html__( 'HIDE %s', 'larisdigital-wp' ), esc_html__( 'Site Header (Title & Description)', 'larisdigital-wp' ) ),
			'type' => 'checkbox',
		),
		array(
			'id' => '_breadcrumb_hide',
			'label' => esc_html__( 'Site Breadcrumb', 'larisdigital-wp' ),
			'label2' => sprintf( esc_html__( 'HIDE %s', 'larisdigital-wp' ), esc_html__( 'Site Breadcrumb', 'larisdigital-wp' ) ),
			'type' => 'checkbox',
		),
		array(
			'id' => '_footer_widgets_hide',
			'label' => esc_html__( 'Site Footer Widgets', 'larisdigital-wp' ),
			'label2' => sprintf( esc_html__( 'HIDE %s', 'larisdigital-wp' ), esc_html__( 'Site Footer Widgets', 'larisdigital-wp' ) ),
			'type' => 'checkbox',
		),
		array(
			'id' => '_footer_hide',
			'label' => esc_html__( 'Site Footer', 'larisdigital-wp' ),
			'label2' => sprintf( esc_html__( 'HIDE %s', 'larisdigital-wp' ), esc_html__( 'Site Footer', 'larisdigital-wp' ) ),
			'type' => 'checkbox',
		),
	),
) );

endif;

add_action( 'get_header', 'larisdigital_page_layout_frontend_output' );
function larisdigital_page_layout_frontend_output() {
	$get_mode = larisdigital_get_integration_mode();
	extract( $get_mode );
	if ( in_array( $mode, array( 'page', 'page_home', 'page_blog', 'shop', 'product_category', 'product_tag' ) ) ) {
		if ( ! get_post_meta( $page_id, '_layout_custom', true ) ) {
			return;
		}
		add_filter( 'larisdigital_topbar_is_active', 'larisdigital_page_layout_topbar_is_active', 25 );
		add_filter( 'larisdigital_navigation_is_active', 'larisdigital_page_layout_navigation_is_active', 25 );
		add_filter( 'larisdigital_header_is_active', 'larisdigital_page_layout_header_is_active', 25 );
		add_filter( 'larisdigital_breadcrumb_is_active', 'larisdigital_page_layout_breadcrumb_is_active', 25 );
		add_filter( 'larisdigital_footer_widgets_is_active', 'larisdigital_page_layout_footer_widgets_is_active', 25 );
		add_filter( 'larisdigital_footer_is_active', 'larisdigital_page_layout_footer_is_active', 25 );
		if ( in_array( $mode, array( 'page', 'page_home', 'page_blog' ) ) ) {
			add_filter( 'larisdigital_sidebar_layout', 'larisdigital_page_layout_sidebar_layout', 25 );
			add_filter( 'larisdigital_sidebar_width', 'larisdigital_page_layout_sidebar_width', 25 );
			add_filter( 'larisdigital_content_width', 'larisdigital_page_layout_content_width', 25 );
			add_filter( 'theme_mod_larisdigital_post_title4header', 'larisdigital_page_layout_title', 30 );
			add_filter( 'theme_mod_larisdigital_page_title4header', 'larisdigital_page_layout_title', 30 );
			add_filter( 'theme_mod_larisdigital_attachment_title4header', 'larisdigital_page_layout_title', 30 );
		}
		if ( in_array( $mode, array( 'shop', 'product_category', 'product_tag' ) ) ) {
			add_filter( 'woocommerce_show_page_title', 'larisdigital_page_layout_wc_show_page_title', 30 );
		}
	}
}

function larisdigital_page_layout_topbar_is_active( $active ) {
	$get_mode = larisdigital_get_integration_mode();
	extract( $get_mode );
	if ( $page_id && $hide = get_post_meta( $page_id, '_topbar_hide', true ) ) {
		return false;
	}
	return $active;
}

function larisdigital_page_layout_navigation_is_active( $active ) {
	$get_mode = larisdigital_get_integration_mode();
	extract( $get_mode );
	if ( $page_id && $hide = get_post_meta( $page_id, '_navigation_hide', true ) ) {
		return false;
	}
	return $active;
}

function larisdigital_page_layout_header_is_active( $active ) {
	$get_mode = larisdigital_get_integration_mode();
	extract( $get_mode );
	if ( $page_id && $hide = get_post_meta( $page_id, '_header_hide', true ) ) {
		return false;
	}
	return $active;
}

function larisdigital_page_layout_breadcrumb_is_active( $active ) {
	$get_mode = larisdigital_get_integration_mode();
	extract( $get_mode );
	if ( $page_id && $hide = get_post_meta( $page_id, '_breadcrumb_hide', true ) ) {
		return false;
	}
	return $active;
}

function larisdigital_page_layout_footer_widgets_is_active( $active ) {
	$get_mode = larisdigital_get_integration_mode();
	extract( $get_mode );
	if ( $page_id && $hide = get_post_meta( $page_id, '_footer_widgets_hide', true ) ) {
		return false;
	}
	return $active;
}

function larisdigital_page_layout_footer_is_active( $active ) {
	$get_mode = larisdigital_get_integration_mode();
	extract( $get_mode );
	if ( $page_id && $hide = get_post_meta( $page_id, '_footer_hide', true ) ) {
		return false;
	}
	return $active;
}

function larisdigital_page_layout_title( $active ) {
	$get_mode = larisdigital_get_integration_mode();
	extract( $get_mode );
	if ( $page_id ) {
		if ( larisdigital_theme_mod( 'larisdigital_header_hide' ) ) {
			$title_hide = get_post_meta( $page_id, '_title_hide', true );
			if ( $title_hide ) {
				return true;
			}
		}
		else {
			$header_hide = get_post_meta( $page_id, '_header_hide', true );
			if ( $header_hide ) {
				$title_hide = get_post_meta( $page_id, '_title_hide', true );
				if ( $title_hide ) {
					return true;
				}
				else {
					return false;
				}
			}
		}
	}
	return $active;
}

function larisdigital_page_layout_wc_show_page_title( $active ) {
	$get_mode = larisdigital_get_integration_mode();
	extract( $get_mode );
	if ( $page_id ) {
		if ( larisdigital_theme_mod( 'larisdigital_header_hide' ) ) {
			if ( in_array( $mode, array( 'product_category', 'product_tag' ) ) ) {
				return true;
			}
			else {
				$title_hide = get_post_meta( $page_id, '_title_hide', true );
				if ( $title_hide ) {
					return false;
				}
			}
		}
		else {
			$header_hide = get_post_meta( $page_id, '_header_hide', true );
			if ( $header_hide ) {
				if ( in_array( $mode, array( 'product_category', 'product_tag' ) ) ) {
					return true;
				}
				else {
					$title_hide = get_post_meta( $page_id, '_title_hide', true );
					if ( $title_hide ) {
						return false;
					}
					else {
						return true;
					}
				}
			}
		}
	}
	return $active;
}

function larisdigital_page_layout_sidebar_layout( $layout ) {
	$get_mode = larisdigital_get_integration_mode();
	extract( $get_mode );
	if ( $page_id ) {
		$value = get_post_meta( $page_id, '_sidebar_layout', true );
		if ( $value && 'default' != $value ) {
			return $value;
		}
	}
	return $layout;
}

function larisdigital_page_layout_sidebar_width( $width ) {
	$get_mode = larisdigital_get_integration_mode();
	extract( $get_mode );
	if ( $page_id ) {
		$value = get_post_meta( $page_id, '_sidebar_width', true );
		if ( $value && 'default' != $value ) {
			return $value;
		}
	}
	return $width;
}

function larisdigital_page_layout_content_width( $width ) {
	$get_mode = larisdigital_get_integration_mode();
	extract( $get_mode );
	if ( $page_id ) {
		$value = get_post_meta( $page_id, '_content_width', true );
		if ( $value && 'default' != $value ) {
			return $value;
		}
	}
	return $width;
}

add_action( 'admin_head', 'larisdigital_page_layout_admin_head_acf_shop' );
function larisdigital_page_layout_admin_head_acf_shop() {
	if ( class_exists( 'woocommerce') ) {
		$shop_page_id = wc_get_page_id( 'shop' );
		if ( $shop_page_id && $shop_page_id == get_the_ID() ) {
			echo '<style>.acf-field-5b0f531ddcaa5, .acf-field-5b0f534ddcaa6, .acf-field-5b0f53e5dcaa8 { display: none !important; }</style>'."\n";
		}
	}
}
