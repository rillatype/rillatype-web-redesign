<?php
/**
 * LarisDigital Store - Setup
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( class_exists('woocommerce') ) {
	return;
}

if ( class_exists('Easy_Digital_Downloads') ) {
	return;
}

/**
 * Setup WordPress Features
 */
add_action( 'after_setup_theme', 'larisdigital_store_setup_theme' );
function larisdigital_store_setup_theme() {
	if ( function_exists( 'add_theme_support' ) ) {
		$shop_thumbnail_width  = apply_filters( 'larisdigital_store_thumbnail_image_width', 350 );
		$shop_thumbnail_height = apply_filters( 'larisdigital_store_thumbnail_image_height', 233 );
		$shop_thumbnail_crop   = apply_filters( 'larisdigital_store_thumbnail_image_crop', true );
		add_image_size( 'shop_thumbnail', $shop_thumbnail_width, $shop_thumbnail_height, $shop_thumbnail_crop );

		$shop_single_width  = apply_filters( 'larisdigital_store_single_image_width', 750 );
		$shop_single_height = apply_filters( 'larisdigital_store_single_image_height', 0 );
		$shop_single_crop   = apply_filters( 'larisdigital_store_single_image_crop', false );
		add_image_size( 'shop_single', $shop_single_width, $shop_single_height, $shop_single_crop );
	}
}

/**
 * Register widgetized area
 */
add_action( 'widgets_init', 'larisdigital_store_widgets_init' );
function larisdigital_store_widgets_init() {

	register_sidebar( array(
		'name'          => esc_html__( 'Shop Page', 'larisdigital-wp' ),
		'description'   => sprintf( esc_html__( 'This widget area will be displayed on %s when it is available on current layout.', 'larisdigital-wp' ), esc_html__( 'Shop Page', 'larisdigital-wp' ) ),
		'id'            => 'sidebar-shop',
		'before_widget' => '<aside id="%1$s" class="sidebar-widget widget %2$s card"><div class="card-body">',
		'after_widget'  => '</div></aside>',
		'before_title'  => '<h4 class="widget-title card-header">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Single Product', 'larisdigital-wp' ),
		'description'   => sprintf( esc_html__( 'This widget area will be displayed on %s when it is available on current layout.', 'larisdigital-wp' ), esc_html__( 'Single Product', 'larisdigital-wp' ) ),
		'id'            => 'sidebar-product',
		'before_widget' => '<aside id="%1$s" class="sidebar-widget widget %2$s card"><div class="card-body">',
		'after_widget'  => '</div></aside>',
		'before_title'  => '<h4 class="widget-title card-header">',
		'after_title'   => '</h4>',
	) );

}

add_action( 'init', 'larisdigital_store_register_post_types', 5 );
function larisdigital_store_register_post_types() {
	register_post_type(
		'product',
		apply_filters(
			'larisdigital_register_post_type_product',
			array(
				'labels'              => array(
					'name'                  => __( 'Shop', 'larisdigital-wp' ),
					'singular_name'         => __( 'Shop', 'larisdigital-wp' ),
					'all_items'             => __( 'All Products', 'larisdigital-wp' ),
					'menu_name'             => _x( 'LarisDigital Store', 'Admin menu name', 'larisdigital-wp' ),
					'add_new'               => __( 'Add New', 'larisdigital-wp' ),
					'add_new_item'          => __( 'Add new product', 'larisdigital-wp' ),
					'edit'                  => __( 'Edit', 'larisdigital-wp' ),
					'edit_item'             => __( 'Edit product', 'larisdigital-wp' ),
					'new_item'              => __( 'New product', 'larisdigital-wp' ),
					'view_item'             => __( 'View product', 'larisdigital-wp' ),
					'view_items'            => __( 'View products', 'larisdigital-wp' ),
					'search_items'          => __( 'Search products', 'larisdigital-wp' ),
					'not_found'             => __( 'No products found', 'larisdigital-wp' ),
					'not_found_in_trash'    => __( 'No products found in trash', 'larisdigital-wp' ),
					'parent'                => __( 'Parent product', 'larisdigital-wp' ),
					'featured_image'        => __( 'Product image', 'larisdigital-wp' ),
					'set_featured_image'    => __( 'Set product image', 'larisdigital-wp' ),
					'remove_featured_image' => __( 'Remove product image', 'larisdigital-wp' ),
					'use_featured_image'    => __( 'Use as product image', 'larisdigital-wp' ),
					'insert_into_item'      => __( 'Insert into product', 'larisdigital-wp' ),
					'uploaded_to_this_item' => __( 'Uploaded to this product', 'larisdigital-wp' ),
					'filter_items_list'     => __( 'Filter products', 'larisdigital-wp' ),
					'items_list_navigation' => __( 'Products navigation', 'larisdigital-wp' ),
					'items_list'            => __( 'Products list', 'larisdigital-wp' ),
				),
				'description'         => '',
				'public'              => true,
				'show_ui'             => true,
				'menu_icon'           => 'dashicons-cart',
				'capability_type'     => 'post',
				'map_meta_cap'        => true,
				'publicly_queryable'  => true,
				'exclude_from_search' => false,
				'hierarchical'        => false, // Hierarchical causes memory issues - WP loads all records!
				'rewrite'             => 'shop' ? array(
					'slug'       => 'shop',
					'with_front' => false,
					'feeds'      => true,
				) : false,
				'query_var'           => true,
				'supports'            => array( 
					'title', 
					'editor', 
					'excerpt', 
					'thumbnail', 
					'custom-fields', 
					'publicize', 
					'wpcom-markdown' 
				),
				'has_archive'         => true,
				'show_in_nav_menus'   => true,
				'show_in_rest'        => true,
			)
		)
	);
}

add_filter( 'use_block_editor_for_post_type', 'larisdigital_store_gutenberg_can_edit_post_type', 10, 2 );
function larisdigital_store_gutenberg_can_edit_post_type( $can_edit, $post_type ) {
	return 'product' === $post_type ? false : $can_edit;
}

add_action( 'init', 'larisdigital_store_register_taxonomies', 5 );
function larisdigital_store_register_taxonomies() {
	register_taxonomy(
		'product_cat',
		apply_filters( 'larisdigital_taxonomy_objects_product_cat', array( 'product' ) ),
		apply_filters(
			'larisdigital_taxonomy_args_product_cat',
			array(
				'hierarchical'          => true,
				'label'                 => __( 'Categories', 'larisdigital-wp' ),
				'labels'                => array(
					'name'              => __( 'Product categories', 'larisdigital-wp' ),
					'singular_name'     => __( 'Category', 'larisdigital-wp' ),
					'menu_name'         => _x( 'Categories', 'Admin menu name', 'larisdigital-wp' ),
					'search_items'      => __( 'Search categories', 'larisdigital-wp' ),
					'all_items'         => __( 'All categories', 'larisdigital-wp' ),
					'parent_item'       => __( 'Parent category', 'larisdigital-wp' ),
					'parent_item_colon' => __( 'Parent category:', 'larisdigital-wp' ),
					'edit_item'         => __( 'Edit category', 'larisdigital-wp' ),
					'update_item'       => __( 'Update category', 'larisdigital-wp' ),
					'add_new_item'      => __( 'Add new category', 'larisdigital-wp' ),
					'new_item_name'     => __( 'New category name', 'larisdigital-wp' ),
					'not_found'         => __( 'No categories found', 'larisdigital-wp' ),
				),
				'show_ui'               => true,
				'query_var'             => true,
				'capabilities'          => array(
					'manage_terms' => 'manage_product_terms',
					'edit_terms'   => 'edit_product_terms',
					'delete_terms' => 'delete_product_terms',
					'assign_terms' => 'assign_product_terms',
				),
				'rewrite'               => array(
					'slug'         => 'shop-category',
					'with_front'   => false,
					'hierarchical' => true,
				),
			)
		)
	);

	register_taxonomy(
		'product_tag',
		apply_filters( 'larisdigital_taxonomy_objects_product_tag', array( 'product' ) ),
		apply_filters(
			'larisdigital_taxonomy_args_product_tag',
			array(
				'hierarchical'          => false,
				'label'                 => __( 'Product tags', 'larisdigital-wp' ),
				'labels'                => array(
					'name'                       => __( 'Product tags', 'larisdigital-wp' ),
					'singular_name'              => __( 'Tag', 'larisdigital-wp' ),
					'menu_name'                  => _x( 'Tags', 'Admin menu name', 'larisdigital-wp' ),
					'search_items'               => __( 'Search tags', 'larisdigital-wp' ),
					'all_items'                  => __( 'All tags', 'larisdigital-wp' ),
					'edit_item'                  => __( 'Edit tag', 'larisdigital-wp' ),
					'update_item'                => __( 'Update tag', 'larisdigital-wp' ),
					'add_new_item'               => __( 'Add new tag', 'larisdigital-wp' ),
					'new_item_name'              => __( 'New tag name', 'larisdigital-wp' ),
					'popular_items'              => __( 'Popular tags', 'larisdigital-wp' ),
					'separate_items_with_commas' => __( 'Separate tags with commas', 'larisdigital-wp' ),
					'add_or_remove_items'        => __( 'Add or remove tags', 'larisdigital-wp' ),
					'choose_from_most_used'      => __( 'Choose from the most used tags', 'larisdigital-wp' ),
					'not_found'                  => __( 'No tags found', 'larisdigital-wp' ),
				),
				'show_ui'               => true,
				'query_var'             => true,
				'capabilities'          => array(
					'manage_terms' => 'manage_product_terms',
					'edit_terms'   => 'edit_product_terms',
					'delete_terms' => 'delete_product_terms',
					'assign_terms' => 'assign_product_terms',
				),
				'rewrite'               => array(
					'slug'       => 'shop-tag',
					'with_front' => false,
				),
			)
		)
	);
}

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_5f89225c13466',
	'title' => 'Product Data',
	'fields' => array(
		array(
			'key' => 'field_5f8932055c369',
			'label' => 'Buy Button',
			'name' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placement' => 'left',
			'endpoint' => 0,
		),
		array(
			'key' => 'field_5f8931d723ffb',
			'label' => 'Buy Button Text',
			'name' => '_button_text',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => 'Buy Now',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5f893254970b0',
			'label' => 'Buy Button Type',
			'name' => '_button_type',
			'type' => 'radio',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'custom' => 'Custom URL',
				'sejoli' => 'Sejoli Product',
				'gumroad' => 'Gumroad Product',
			),
			'allow_null' => 0,
			'other_choice' => 0,
			'default_value' => 'custom',
			'layout' => 'vertical',
			'return_format' => 'value',
			'save_other_choice' => 0,
		),
		array(
			'key' => 'field_5f89314823ffa',
			'label' => 'Buy Button URL',
			'name' => '_product_url',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5f893254970b0',
						'operator' => '==',
						'value' => 'custom',
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
			'key' => 'field_5f8932c1970b1',
			'label' => 'Select Sejoli Product',
			'name' => '_product_sejoli',
			'type' => 'post_object',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5f893254970b0',
						'operator' => '==',
						'value' => 'sejoli',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'post_type' => array(
				0 => 'sejoli-product',
			),
			'taxonomy' => '',
			'allow_null' => 1,
			'multiple' => 0,
			'return_format' => 'id',
			'ui' => 1,
		),
		array(
			'key' => 'field_5f90dcf5824ad',
			'label' => 'Gumroad Product URL',
			'name' => '_gumroad_url',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5f893254970b0',
						'operator' => '==',
						'value' => 'gumroad',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => 'https://gum.co/mAkNn',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5f9100c2b0be0',
			'label' => 'Auto-trigger the payment form',
			'name' => '_gumroad_wanted',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5f893254970b0',
						'operator' => '==',
						'value' => 'gumroad',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 1,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_5f9100fdb0be1',
			'label' => 'Allow single-product purchases only',
			'name' => '_gumroad_single',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5f893254970b0',
						'operator' => '==',
						'value' => 'gumroad',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 1,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_5f89225c1640d',
			'label' => 'Price',
			'name' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placement' => 'left',
			'endpoint' => 0,
		),
		array(
			'key' => 'field_5f8922a2724f3',
			'label' => 'Regular Price',
			'name' => '_regular_price',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => 'Rp',
			'append' => '',
			'min' => '',
			'max' => '',
			'step' => '',
		),
		array(
			'key' => 'field_5f8922bd724f4',
			'label' => 'Sale Price',
			'name' => '_sale_price',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => 'Rp',
			'append' => '',
			'min' => '',
			'max' => '',
			'step' => '',
		),
		array(
			'key' => 'field_5f910052ab751',
			'label' => 'Currency',
			'name' => '_currency',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => 'Rp',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'product',
			),
		),
	),
	'menu_order' => 1,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

endif;
