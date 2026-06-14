<?php
/**
 * WooCommerce Functionality, frontend only
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'woocommerce' ) ) {
	return;
}

/**
 * WooCommerce Shop Page Document Title
 */
add_filter( 'document_title_parts', 'larisdigital_wc_document_title_parts' );
function larisdigital_wc_document_title_parts( $title ) {
	if ( is_shop() ) {
		$title['title'] = get_the_title( wc_get_page_id( 'shop' ) );
	}
	return $title;
}

/**
 * WooCommerce Wrapper Start
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
add_action( 'woocommerce_before_main_content', 'larisdigital_wc_wrapper_start', 10 );
function larisdigital_wc_wrapper_start() {
	get_template_part( 'woocommerce/block-wc-wrapper-start' );
}

/**
 * WooCommerce Wrapper End
 */
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
add_action( 'woocommerce_after_main_content', 'larisdigital_wc_wrapper_end', 10 );
function larisdigital_wc_wrapper_end() {
	get_template_part( 'woocommerce/block-wc-wrapper-end' );
}

/**
 * Load Template - Navigation Quicknav - Product Search
 */
add_filter( 'larisdigital_navigation_quicknav_search_template', 'larisdigital_wc_navigation_quicknav_search_template' );
function larisdigital_wc_navigation_quicknav_search_template( $template ) {
	return 'woocommerce/block-wc-quicknav-search';
}

/**
 * Load Template - Navigation Quicknav - Mini Cart
 */
add_action( 'larisdigital_navigation_quicknav', 'larisdigital_load_template_navigation_quicknav_minicart' );
function larisdigital_load_template_navigation_quicknav_minicart() {
	get_template_part( 'woocommerce/block-wc-quicknav-minicart' );
}

/**
 * Breadcrumb - Bootstrap - WooCommerce Breadcrumb
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
add_filter( 'larisdigital_site_breadcrumbs_template', 'larisdigital_wc_site_breadcrumbs_template' );
function larisdigital_wc_site_breadcrumbs_template( $template ) {
	if ( ! is_woocommerce() ) {
		return $template;
	}
	return 'woocommerce/block-wc-breadcrumb';
}

/**
 * Sidebar - Use Theme Sidebar
 */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

/**
 * Store Notice - Moving
 */
remove_action( 'wp_footer', 'woocommerce_demo_store' );
add_action( 'larisdigital_site_before', 'woocommerce_demo_store', 1 );

/**
 * Shop Catalog - Markup Open
 */
add_action( 'woocommerce_before_shop_loop_item', 'larisdigital_wc_shop_catalog_markup_open', 1 );
function larisdigital_wc_shop_catalog_markup_open() {
	echo '<div class="product-inner card"><div class="product-image-box">';
}

/**
 * Shop Catalog - Markup Middle 1
 */
add_action( 'woocommerce_before_shop_loop_item_title', 'larisdigital_wc_shop_catalog_markup_middle1', 998 );
function larisdigital_wc_shop_catalog_markup_middle1() {
	echo '</a></div><div class="product-detail-box card-body">';
}

/**
 * Shop Catalog - Markup Middle 2
 */
add_action( 'woocommerce_before_shop_loop_item_title', 'larisdigital_wc_shop_catalog_markup_middle2', 999 );
function larisdigital_wc_shop_catalog_markup_middle2() {
	echo '<a href="' . get_permalink() . '" class="product-detail-link">';
}

/**
 * Shop Catalog - Markup Close
 */
add_action( 'woocommerce_after_shop_loop_item', 'larisdigital_wc_shop_catalog_markup_close', 999 );
function larisdigital_wc_shop_catalog_markup_close() {
	echo '</div></div>';
}

/* Shop Page - Products Per Page */
add_filter( 'loop_shop_per_page', 'larisdigital_wc_shop_products_per_page', 20 );
function larisdigital_wc_shop_products_per_page( $per_page ) {
	$per_page = intval( larisdigital_theme_mod( 'larisdigital_wc_shop_per_page' ) );
	if ( $per_page < 1 ) $per_page = 12;
	return $per_page;
}

/* Shop Page - Number of Products Columns Per Row */
add_filter( 'loop_shop_columns', 'larisdigital_wc_shop_columns', 20 );
function larisdigital_wc_shop_columns( $columns ) {
	$columns = intval( larisdigital_theme_mod( 'larisdigital_wc_shop_columns' ) );
	if ( $columns < 1 ) $columns = 3;
	if ( $columns > 6 ) $columns = 6;
	return $columns;
}

/* Shop Page - Number of Products Columns Per Row (Mobile) */
add_filter( 'woocommerce_product_loop_start', 'larisdigital_wc_product_loop_start', 10 );
function larisdigital_wc_product_loop_start( $loop_start ) {
	$columns = intval( larisdigital_theme_mod( 'larisdigital_wc_shop_columns' ) );
	$columns_mobile = intval( larisdigital_theme_mod( 'larisdigital_wc_shop_columns_mobile' ) );
	if ( $columns_mobile < 1 ) $columns_mobile = 2;
	if ( $columns_mobile > 2 ) $columns_mobile = 2;
	if ( $columns == 1 ) $columns_mobile = 1;
	$loop_start = str_replace( 'class="products ', 'class="products columns-mobile-'.$columns_mobile.' ', $loop_start );
	return $loop_start;
}

/* Shop Catalog - Sale Flash */
add_filter( 'woocommerce_sale_flash', 'larisdigital_wc_sale_flash', 10, 3 );
function larisdigital_wc_sale_flash( $sale_flash, $post, $product ) {
	$sale_flash_new = larisdigital_theme_mod( 'larisdigital_wc_saleflash_text' );
	if ( ! empty( $sale_flash_new ) ) {
		return '<span class="onsale">' . esc_html( $sale_flash_new ) . '</span>';
	}
	return $sale_flash;
}

/**
 * Shop Catalog - Soldout Flash
 */
add_action( 'woocommerce_before_shop_loop_item_title', 'larisdigital_wc_show_product_soldout_flash', 10 );
// add_action( 'woocommerce_before_single_product_summary', 'larisdigital_wc_show_product_soldout_flash', 10 );
add_action( 'woocommerce_product_thumbnails', 'larisdigital_wc_show_product_soldout_flash', 9999 );
function larisdigital_wc_show_product_soldout_flash() {
	global $product;
	if ( ! is_callable( array( $product, 'get_id' ) ) ) {
		return;
	} 
	if ( ! $product->is_in_stock() ) {
		$soldout_text = larisdigital_theme_mod( 'larisdigital_wc_soldout_text' );
		if ( empty( $soldout_text ) ) {
			$soldout_text = esc_html__( 'Sold out!', 'larisdigital-wp' );
		}
		$soldout_text = apply_filters( 'larisdigital_wc_soldout_text', $soldout_text );
		echo '<span class="onsale soldout">'.esc_html( $soldout_text ).'</span>';
	}
}

/**
 * Shop Catalog - Remove Sale Flash When Soldout
 */
add_filter( 'woocommerce_sale_flash', 'larisdigital_wc_hide_sale_flash_soldout', 999 );
function larisdigital_wc_hide_sale_flash_soldout( $output ) {
	global $product;
	if ( ! is_callable( array( $product, 'get_id' ) ) ) {
		return $output;
	} 
	if ( ! $product->is_in_stock() ) {
		return false;
	}
	return $output;
}

/**
 * Shop Page - Product Title
 */
if ( ! function_exists( 'woocommerce_template_loop_product_title' ) ) {
	function woocommerce_template_loop_product_title() {
		if ( larisdigital_theme_mod( 'larisdigital_wc_shop_title_truncate' ) ) {
			echo '<h2 class="woocommerce-loop-product__title text-truncate">' . get_the_title() . '</h2>';
		}
		else {
			echo '<h2 class="woocommerce-loop-product__title">' . get_the_title() . '</h2>';
		}
	}
}

/**
 * Shop Page - Pagination
 */
remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
add_action( 'woocommerce_after_shop_loop', 'larisdigital_wc_pagination', 10 );
function larisdigital_wc_pagination() {
	global $wp_query;
	if ( $wp_query->max_num_pages <= 1 ) {
		return;
	}
	$alignment = larisdigital_theme_mod( 'larisdigital_pagination_alignment' );
	echo '<nav class="paging-navigation" aria-label="'.esc_html__( 'Paging navigation', 'larisdigital-wp' ).'">';
	echo larisdigital_paginate_links( array(
		'base' 			=> esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) ),
		'format' 		=> '',
		'current' 		=> max( 1, get_query_var('paged') ),
		'total' 		=> $wp_query->max_num_pages,
		'type'			=> 'list',
		'prev_text' 	=> '&laquo;',
		'next_text' 	=> '&raquo;',
		'alignment'		=> $alignment,
	) );
	echo '</nav>';
}

/**
 * Shop Page - Price
 */
function larisdigital_wc_shop_price_image() {
	echo '<div class="tp-shop-price-image">';
	woocommerce_template_loop_price();
	echo '</div>';
}
function larisdigital_wc_shop_price_right() {
	echo '<div class="tp-shop-price-right">';
	woocommerce_template_loop_price();
	echo '</div>';
}
function larisdigital_wc_shop_price_default() {
	echo '<div class="tp-shop-price-default">';
	woocommerce_template_loop_price();
	echo '</div>';
}

/**
 * Shop Page Setup
 */
add_action( 'wp', 'larisdigital_wc_setup_shop_page' );
function larisdigital_wc_setup_shop_page() {

	/* Shop Page - Results Count */
	if ( larisdigital_theme_mod( 'larisdigital_wc_shop_result_count_disable' ) ) {
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
	}

	/* Shop Page - Catalog Ordering */
	if ( larisdigital_theme_mod( 'larisdigital_wc_shop_catalog_ordering_disable' ) ) {
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
	}

	/* Shop Page - Sale Flash */
	if ( larisdigital_theme_mod( 'larisdigital_wc_shop_saleflash_disable' ) ) {
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
	}

	/* Shop Page - Product Title */
	if ( larisdigital_theme_mod( 'larisdigital_wc_shop_title_disable' ) ) {
		remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
	}

	/* Shop Page - Product Rating */
	if ( larisdigital_theme_mod( 'larisdigital_wc_shop_rating_disable' ) ) {
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
	}

	/* Shop Page - Product Price */
	$price_style = larisdigital_theme_mod( 'larisdigital_wc_shop_price' );
	if ( $price_style == 'disable' ) {
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
		remove_action( 'woocommerce_before_shop_loop_item_title', 'larisdigital_wc_shop_price_image', 10 );
		remove_action( 'woocommerce_shop_loop_item_title', 'larisdigital_wc_shop_price_right', 5 );
		remove_action( 'woocommerce_after_shop_loop_item_title', 'larisdigital_wc_shop_price_default', 10 );
	}
	elseif ( $price_style == 'image' ) {
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
		add_action( 'woocommerce_before_shop_loop_item_title', 'larisdigital_wc_shop_price_image', 10 );
		remove_action( 'woocommerce_shop_loop_item_title', 'larisdigital_wc_shop_price_right', 5 );
		remove_action( 'woocommerce_after_shop_loop_item_title', 'larisdigital_wc_shop_price_default', 10 );
	}
	elseif ( $price_style == 'right' ) {
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
		remove_action( 'woocommerce_before_shop_loop_item_title', 'larisdigital_wc_shop_price_image', 10 );
		add_action( 'woocommerce_shop_loop_item_title', 'larisdigital_wc_shop_price_right', 5 );
		remove_action( 'woocommerce_after_shop_loop_item_title', 'larisdigital_wc_shop_price_default', 10 );
	}
	else {
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
		remove_action( 'woocommerce_before_shop_loop_item_title', 'larisdigital_wc_shop_price_image', 10 );
		remove_action( 'woocommerce_shop_loop_item_title', 'larisdigital_wc_shop_price_right', 5 );
		add_action( 'woocommerce_after_shop_loop_item_title', 'larisdigital_wc_shop_price_default', 10 );
	}

	/* Shop Page - Product "Add To Cart" Button */
	if ( larisdigital_theme_mod( 'larisdigital_wc_shop_button_disable' ) ) {
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
	}
	else {
		if ( larisdigital_theme_mod( 'larisdigital_wc_shop_button_type' ) !== 'addtocart' ) {
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
			add_action( 'woocommerce_after_shop_loop_item', 'larisdigital_wc_loop_add_to_cart_detail', 10 );
		}
		add_filter ( 'woocommerce_loop_add_to_cart_args', 'larisdigital_wc_loop_add_to_cart_args' );
	}

	/* Shop Page - Hide Product Detail Link When All Hidden  */
	if ( larisdigital_theme_mod( 'larisdigital_wc_shop_title_disable' ) && larisdigital_theme_mod( 'larisdigital_wc_shop_rating_disable' ) && ( larisdigital_theme_mod( 'larisdigital_wc_shop_price_disable' ) || larisdigital_theme_mod( 'larisdigital_wc_shop_price' ) == 'disable' ) ) {
		remove_action( 'woocommerce_before_shop_loop_item_title', 'larisdigital_wc_shop_catalog_markup_middle2', 999 );
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
	}

	/* Shop Page - Use Shop Title & Description For Site Header */
	if ( function_exists( 'larisdigital_blog_title4header_title' ) ) {
		remove_filter( 'larisdigital_header_title', 'larisdigital_blog_title4header_title' );
	}
	if ( function_exists( 'larisdigital_blog_title4header_description' ) ) {
		remove_filter( 'larisdigital_header_description', 'larisdigital_blog_title4header_description' );
	}
	if ( ! larisdigital_theme_mod( 'larisdigital_header_hide' ) && larisdigital_theme_mod( 'larisdigital_wc_shop_title4header' ) ) {
		remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
	}

	do_action( 'larisdigital_wc_setup_shop_page' );
}

/**
 * Single Product - Markup Open
 */
add_action( 'woocommerce_before_single_product_summary', 'larisdigital_wc_product_markup_open', 1 );
function larisdigital_wc_product_markup_open() {
	echo '<div class="single-product-inner clearfix">';
}

/**
 * Single Product - Markup Close
 */
add_action( 'woocommerce_after_single_product_summary', 'larisdigital_wc_product_markup_close', 14 );
function larisdigital_wc_product_markup_close() {
	echo '</div>';
}

/**
 * Single Product Setup
 */
add_action( 'wp', 'larisdigital_wc_setup_product_page' );
function larisdigital_wc_setup_product_page() {

	/* Single Product - Sale Flash */
	if ( larisdigital_theme_mod( 'larisdigital_wc_product_saleflash_disable' ) ) {
		remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
	}
	else {
		remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
		add_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_sale_flash', 9999 );
	}

	/* Single Product - Rating */
	if ( larisdigital_theme_mod( 'larisdigital_wc_product_rating_disable' ) ){
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
	}

	/* Single Product - Price */
	if ( larisdigital_theme_mod( 'larisdigital_wc_product_price_disable' ) ) {
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
	}

	/* Single Product - Short Description */
	if ( larisdigital_theme_mod( 'larisdigital_wc_product_excerpt_disable' ) ){
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
	}

	/* Single Product - Add To Cart */
	add_action( 'woocommerce_single_product_summary', 'larisdigital_wc_product_button_group_markup_open', 28 );
	if ( larisdigital_theme_mod( 'larisdigital_wc_product_button_disable' ) ) {
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
	}
	else {
		add_action( 'woocommerce_after_add_to_cart_quantity', 'larisdigital_wc_product_button_markup_open_qty', 98 );
		add_action( 'woocommerce_before_add_to_cart_button', 'larisdigital_wc_product_button_markup_open_noqty', 98 );
		add_action( 'woocommerce_after_add_to_cart_button', 'larisdigital_wc_product_button_markup_close', 2 );
	}
	add_action( 'woocommerce_single_product_summary', 'larisdigital_wc_product_button_group_markup_close', 32 );

	/* Single Product - Meta */
	if ( larisdigital_theme_mod( 'larisdigital_wc_product_meta_disable' ) ) {
		remove_action( 'tp_item_details', 'larisdigital_wc_product_item_meta', 5 );
	}

	/* Single Product - Social Share */
	remove_action( 'woocommerce_single_product_summary', 'larisdigital_wc_product_social_share_output', 45 );
	if ( larisdigital_theme_mod( 'larisdigital_wc_product_share' ) ) {
		add_action( 'woocommerce_single_product_summary', 'larisdigital_wc_product_social_share_output', 45 );
	}

	if ( is_product() ) {
		/* Single Product - Upsells */
		if ( larisdigital_theme_mod( 'larisdigital_wc_product_upsells_disable' ) ) {
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
		}

		/* Single Product - Related */
		if ( larisdigital_theme_mod( 'larisdigital_wc_product_related_disable' ) ) {
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
		}
	}

	/* Single Product - Use Product Title For Site Header */
	if ( ! larisdigital_theme_mod( 'larisdigital_header_hide' ) && ! larisdigital_theme_mod( 'larisdigital_wc_product_header_hide' ) && larisdigital_theme_mod( 'larisdigital_wc_product_title4header' ) ) {
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
	}

	do_action( 'larisdigital_wc_setup_product_page' );
}

/**
 * Single Product Data Tabs
 */
remove_action( 'woocommerce_after_single_product_summary' , 'woocommerce_output_product_data_tabs');
add_action( 'woocommerce_before_single_product_summary' , 'woocommerce_output_product_data_tabs', 50);

/**
 * Product Social Share
 */
function larisdigital_wc_product_social_share_output() {
	larisdigital_social_share_output( 'wc_product' );
}

/**
 * Product Tabs Filter
 */
add_filter( 'woocommerce_product_tabs', 'larisdigital_wc_product_tabs', 99 );
function larisdigital_wc_product_tabs( $tabs ) {

	/* Single Product - Tabs - Description */
	$title = larisdigital_theme_mod( 'larisdigital_wc_product_tab_description_title' );
	if ( ! empty( $title ) && isset( $tabs['description'] ) ) {
		$tabs['description']['title'] = $title;
	}

	if ( larisdigital_theme_mod( 'larisdigital_wc_product_tab_description_disable' ) ) {
		unset( $tabs['description'] );
	}

	/* Single Product - Tabs - Attributes */
	/**
	 * Move to summary section
	 */
	unset( $tabs['additional_information'] );

	/* Single Product - Tabs - Reviews */
	$title = larisdigital_theme_mod( 'larisdigital_wc_product_tab_reviews_title' );
	if ( ! empty( $title ) && isset( $tabs['reviews'] ) ) {
		$tabs['reviews']['title'] = $title;
	}

	if ( larisdigital_theme_mod( 'larisdigital_wc_product_tab_reviews_disable' ) ) {
		unset( $tabs['reviews'] );
	}

	return $tabs;
}

/**
 * Upsell Products Filter
 */
add_filter( 'woocommerce_upsell_display_args', 'larisdigital_wc_upsell_display_args', 99 );
function larisdigital_wc_upsell_display_args( $args ) {
	$columns = intval( larisdigital_theme_mod( 'larisdigital_wc_product_upsells_columns' ) );
	if ( $columns > 6 ) $columns = 6;
	if ( $columns ) {
		$args['posts_per_page'] = $columns;
		$args['columns'] = $columns;
	}
	return $args;
}

/**
 * Related Products Filter
 */
add_filter( 'woocommerce_output_related_products_args', 'larisdigital_wc_related_products_args', 99 );
function larisdigital_wc_related_products_args( $args ) {
	$columns = intval( larisdigital_theme_mod( 'larisdigital_wc_product_related_columns' ) );
	if ( $columns > 6 ) $columns = 6;
	if ( $columns ) {
		$args['posts_per_page'] = $columns;
		$args['columns'] = $columns;
	}
	return $args;
}

/**
 * Remove Product Description Heading
 */
add_filter( 'woocommerce_product_description_heading', 'larisdigital_wc_product_description_heading' );
function larisdigital_wc_product_description_heading( $heading ) {
	return false;
}

/**
 * Cart Page Setup
 */
add_action( 'wp', 'larisdigital_wc_setup_cart_page' );
function larisdigital_wc_setup_cart_page() {
	/* Hide Coupon Form on Cart */
	if ( is_cart() && larisdigital_theme_mod( 'larisdigital_wc_cart_coupon_disable' ) ) {
		add_filter( 'woocommerce_coupons_enabled', '__return_false' );
	}
	/* Remove Cross Sells in Cart Page */
	if ( larisdigital_theme_mod( 'larisdigital_wc_cart_cross_sells_disable' ) ) {
		remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
	}
}

/**
 * Cross Sells Products Filter
 */
add_filter( 'woocommerce_cross_sells_total', 'larisdigital_wc_cross_sells_total', 99 );
function larisdigital_wc_cross_sells_total( $limit ) {
	$limit_new = intval( larisdigital_theme_mod( 'larisdigital_wc_cart_cross_sells_limit' ) );
	if ( $limit_new > 0 ) {
		return $limit_new;
	}
	return $limit;
}

/* Checkout Page - Checkout Layout Class */
add_filter( 'body_class', 'larisdigital_wc_body_class_checkout' );
function larisdigital_wc_body_class_checkout( $classes ) {
	$checkout_layout = larisdigital_theme_mod( 'larisdigital_wc_checkout_layout' );
	if ( empty( $checkout_layout ) ) {
		$checkout_layout = 'default';
	}
	$classes[] = 'tp-checkout-' . trim( $checkout_layout );
	return $classes;
}

/**
 * Checkout Page Setup
 */
add_action( 'wp', 'larisdigital_wc_setup_checkout_page' );
function larisdigital_wc_setup_checkout_page() {
	/* Hide Login Form on Checkout */
	if ( larisdigital_theme_mod( 'larisdigital_wc_checkout_login_disable' ) ) {
		remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );
	}
	/* Hide Coupon Form on Checkout */
	if ( larisdigital_theme_mod( 'larisdigital_wc_checkout_coupon_disable' ) ) {
		remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
	}
	/* Auto Hide Coupon Form */
	if ( is_cart() && is_checkout() ) {
		remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
	}
}

/**
 * My Account - Login Redirect
 */
add_filter( 'woocommerce_login_redirect', 'larisdigital_wc_login_redirect' );
function larisdigital_wc_login_redirect( $redirect_to ) {
	if ( $page_id = larisdigital_theme_mod( 'larisdigital_wc_myaccount_redirect_page' ) ) {
		$redirect_to = get_permalink( $page_id );
	}
	return $redirect_to;
}

/**
 * Cart Fragments - MiniCart 
 */
add_filter('woocommerce_add_to_cart_fragments', 'larisdigital_wc_add_to_cart_fragment_minicart');
function larisdigital_wc_add_to_cart_fragment_minicart( $fragments ) {
	$cart_count = WC()->cart->get_cart_contents_count();
	if ( $cart_count > 0 ) {
		$fragments['.quicknav-minicart-count'] = '<span class="quicknav-minicart-count"><span class="badge badge-primary">'.esc_attr($cart_count).'</span></span>';
	}
	else {
		$fragments['.quicknav-minicart-count'] = '<span class="quicknav-minicart-count"></span>';
	}
	return $fragments;
}

/**
 * Shop Catalog - AddToCart Button Text
 */
add_filter( 'woocommerce_product_add_to_cart_text' , 'larisdigital_wc_shop_button_text' );
function larisdigital_wc_shop_button_text( $text ) {
	global $product;
	if ( ! is_callable( array( $product, 'get_id' ) ) ) {
		return $text;
	} 
	if ( ! $product->is_in_stock() ) {
		if ( $text_new = larisdigital_theme_mod('larisdigital_wc_shop_button_text_outofstock') ) {
			return $text_new;
		}
		return $text;
	}
	$product_type = $product->get_type();
	switch ( $product_type ) {
		case 'external':
			return $text;
		break;
		case 'grouped':
			return $text;
		break;
		case 'simple':
			if ( $text_new = larisdigital_theme_mod('larisdigital_wc_shop_button_text_simple') ) {
				return $text_new;
			}
			return $text;
		break;
		case 'variable':
			if ( $text_new = larisdigital_theme_mod('larisdigital_wc_shop_button_text_variable') ) {
				return $text_new;
			}
			return $text;
		break;
		default:
			return $text;
	}
}

add_filter( 'woocommerce_product_single_add_to_cart_text', 'larisdigital_wc_product_button_text' ); 
function larisdigital_wc_product_button_text( $text ) {
	if ( $text_new = larisdigital_theme_mod('larisdigital_wc_product_button_text') ) {
		return $text_new;
	}
	return $text;
}

add_filter( 'woocommerce_product_single_add_to_cart_text', 'larisdigital_wc_product_button_text_external', 25 ); 
function larisdigital_wc_product_button_text_external( $text ) {
	global $product;
	if ( ! is_callable( array( $product, 'get_id' ) ) ) {
		return $text;
	} 
	if ( 'external' == $product->get_type() ) {
		if ( $text_new = $product->get_button_text() ) {
			return $text_new;
		}
	}
	return $text;
}

function woocommerce_button_proceed_to_checkout() {
	if ( $text_new = larisdigital_theme_mod('larisdigital_wc_cart_button_text') ) {
		echo '<a href="'.esc_url( wc_get_checkout_url() ).'" class="checkout-button button alt wc-forward">'.$text_new.'</a>';
	}
	else {
		wc_get_template( 'cart/proceed-to-checkout-button.php' );
	}
}

add_filter( 'woocommerce_order_button_text', 'larisdigital_wc_checkout_button_text' ); 
function larisdigital_wc_checkout_button_text( $text ) {
	if ( $text_new = larisdigital_theme_mod('larisdigital_wc_checkout_button_text') ) {
		return $text_new;
	}
	return $text;
}

function larisdigital_wc_product_button_group_markup_open() {
	$class = 'woocommerce-product-button-group';
	// if ( larisdigital_theme_mod('larisdigital_wc_product_button_sticky') ) {
	// 	$class .= ' woocommerce-product-button-sticky';
	// }
	$class = apply_filters( 'larisdigital_wc_product_button_group_class', $class );
	echo '<div class="'.esc_attr($class).' clearfix">';
}

function larisdigital_wc_product_button_group_markup_close() {
	echo '</div>';
}

function larisdigital_wc_product_button_markup_open_qty() {
	global $product;
	if ( empty( $product ) ) {
		$product = wc_get_product( get_the_ID() );
	}
	if ( in_array( $product->get_type(), array( 'simple', 'variable' ) ) ) {
		echo '<div class="woocommerce-product-button clearfix">';
	}
}

function larisdigital_wc_product_button_markup_open_noqty() {
	global $product;
	if ( empty( $product ) ) {
		$product = wc_get_product( get_the_ID() );
	}
	if ( ! in_array( $product->get_type(), array( 'simple', 'variable' ) ) ) {
		echo '<div class="woocommerce-product-button clearfix">';
	}
}

function larisdigital_wc_product_button_markup_close() {
	echo '</div>';
}

function larisdigital_wc_loop_add_to_cart_detail() {
	$detail_text = larisdigital_theme_mod( 'larisdigital_wc_shop_button_text_detail' );
	if ( empty( $detail_text ) ) {
		$detail_text = esc_html__( 'Detail', 'larisdigital-wp' );
	}
	echo '<a href="'.get_permalink().'" class="button button-shop-addtocart">'.esc_html( $detail_text ).'</a>';
}

function larisdigital_wc_loop_add_to_cart_args( $args ) {
	if ( isset( $args['class'] ) ) {
		$args['class'] .= ' button-shop-addtocart';
	}
	return $args;
}

add_filter( 'larisdigital_style', 'larisdigital_wc_inline_css' );
function larisdigital_wc_inline_css( $style ) {
	if ( true === wc_string_to_bool( get_option( 'woocommerce_checkout_highlight_required_fields', 'yes' ) ) ) {
		$style = $style.' .woocommerce form .form-row .required { visibility: visible; } ';
	} 
	else {
		$style = $style.' .woocommerce form .form-row .required { visibility: hidden; } ';
	}
	if ( larisdigital_theme_mod( 'larisdigital_wc_checkout_product_disable' ) ) {
		$style = $style.'.woocommerce-checkout-review-order thead, .woocommerce-checkout-review-order tbody { display: none !important; } .woocommerce table.shop_table tfoot .cart-subtotal th, .woocommerce table.shop_table tfoot .cart-subtotal td { border-top: none !important; } ';
	}
	if ( larisdigital_theme_mod( 'larisdigital_wc_checkout_review_disable' ) ) {
		$style = $style.'#order_review_heading, .woocommerce-checkout-review-order-table { display: none !important; } ';
	}
	if ( larisdigital_theme_mod( 'larisdigital_wc_checkout_gateway_disable' ) ) {
		$style = $style.'#add_payment_method #payment ul.payment_methods, .woocommerce-cart #payment ul.payment_methods, .woocommerce-checkout #payment ul.payment_methods { display: none !important; } ';
	}
	if ( ! is_customize_preview() ) {
		if ( larisdigital_theme_mod( 'larisdigital_wc_shop_button_style' ) == 'fullwidth' ) {
			$style = $style.'.woocommerce ul.products li.product .button-shop-addtocart { display: block; } ';
		}
		if ( larisdigital_theme_mod( 'wc_shop_whatsapp_style' ) == 'fullwidth' ) {
			$style = $style.'.woocommerce ul.products li.product .button-shop-whatsapp, .woocommerce-shop-whatsapp { clear: both; display:block; width: 100%; } .woocommerce-shop-whatsapp { padding: 0; } ';
		}
		if ( larisdigital_theme_mod( 'larisdigital_wc_product_button_style' ) == 'fullwidth' ) {
			$style = $style.'.woocommerce a.button.alt.single_add_to_cart_button, .woocommerce button.button.alt.single_add_to_cart_button, .woocommerce input.button.alt.single_add_to_cart_button, .woocommerce-product-button { clear: both; display:block; width: 100%; } .woocommerce-product-button { padding: 0; } ';
		}
		if ( larisdigital_theme_mod( 'wc_product_whatsapp_style' ) == 'fullwidth' ) {
			$style = $style.'.woocommerce a.button.single_whatsapp_button, .woocommerce-product-whatsapp { clear: both; display:block; width: 100%; } .woocommerce-product-whatsapp { padding: 0; } ';
		}
		if ( larisdigital_theme_mod( 'larisdigital_wc_product_quantity_disable' ) ) {
			$style = $style.'.woocommerce div.product form.cart .quantity { display:none !important; } ';
		}
	}
	return $style;
}

add_filter( 'the_content', 'larisdigital_wc_product_description_buttons_show' );
function larisdigital_wc_product_description_buttons_show( $content ) {
	if ( ! is_product() ) {
		return $content;
	}
	$button_atc = larisdigital_theme_mod( 'larisdigital_wc_product_desc_button_atc' );
	$buttons_active = apply_filters( 'larisdigital_wc_product_description_buttons_active', ( 'yes' == $button_atc ? true : false ) );
	if ( ! $buttons_active ) {
		return $content;
	}
	ob_start();
	larisdigital_wc_product_button_group_markup_open();
	do_action( 'larisdigital_wc_product_description_buttons_before' );
	if ( 'yes' == $button_atc ) {
		add_action( 'woocommerce_after_add_to_cart_quantity', 'larisdigital_wc_product_button_markup_open_qty', 98 );
		add_action( 'woocommerce_before_add_to_cart_button', 'larisdigital_wc_product_button_markup_open_noqty', 98 );
		add_action( 'woocommerce_after_add_to_cart_button', 'larisdigital_wc_product_button_markup_close', 2 );
		woocommerce_template_single_add_to_cart();
	}
	do_action( 'larisdigital_wc_product_description_buttons_after' );
	larisdigital_wc_product_button_group_markup_close();
	$buttons = ob_get_clean();
	return $content.$buttons;
}

add_filter( 'woocommerce_get_image_size_gallery_thumbnail', 'larisdigital_wc_gallery_thumbnail_size' );
function larisdigital_wc_gallery_thumbnail_size( $size ) {
	$size = wc_get_image_size( 'thumbnail' );
	if ( larisdigital_theme_mod( 'larisdigital_wc_product_image_style' ) == 'full' ) {
		$size = wc_get_image_size( 'single' );
	}
	return array(
		'width' => (int) $size['width'],
		'height' => (int) $size['height'],
		'crop' => (int) $size['crop'],
	);
}


add_action( 'woocommerce_single_product_summary', 'larisdigital_wc_product_summary_cta_start', 0 );
function larisdigital_wc_product_summary_cta_start() {
	echo '<div class="single-product-summary-cta">';
}

add_action( 'woocommerce_single_product_summary', 'larisdigital_wc_product_summary_cta_end', 29 );
function larisdigital_wc_product_summary_cta_end() {
	echo '</div>';
}

add_action( 'woocommerce_single_product_summary', 'larisdigital_wc_product_item_details', 40 );
function larisdigital_wc_product_item_details() {

	if ( larisdigital_theme_mod( 'larisdigital_wc_product_item_details_disable' ) ) {
		return;
	}

	echo '<div class="tp-item-details">';

		do_action( 'larisdigital_wc_item_details_start' );

		do_action( 'larisdigital_wc_item_details' );
		
		do_action( 'larisdigital_wc_item_details_end' );

	echo '</div>';
}

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action('larisdigital_wc_item_details' , 'larisdigital_wc_product_attribute_block', 10);
function larisdigital_wc_product_attribute_block(){
	if ( larisdigital_theme_mod( 'larisdigital_wc_product_item_details_disable' ) ) {
		return;
	}
	wc_get_template_part( 'woocommerce/block-wc-item-details' );
}

add_action( 'woocommerce_single_product_summary', 'larisdigital_wc_product_include_sidebar', 99 );
function larisdigital_wc_product_include_sidebar() {
	$disable_product_widget = apply_filters( 'larisdigital_wc_product_widget_is_active', true );

	if ( $disable_product_widget ) {
		return;
	}

	get_template_part( 'woocommerce/block-wc-sidebar' );
}

add_filter( 'body_class', 'larisdigital_wc_body_class_product' );
function larisdigital_wc_body_class_product( $classes ) {
	$image_style = larisdigital_theme_mod( 'larisdigital_wc_product_image_style');
	$checkout_layout = larisdigital_theme_mod( 'larisdigital_wc_checkout_layout' );
	if ( $image_style ) {
		$classes[] = 'tp-product-image-'.$image_style;		
	}
	return $classes;
}

add_action( 'woocommerce_before_single_product_summary', 'larisdigital_wc_product_image_wrap_start', 1 );
function larisdigital_wc_product_image_wrap_start() {
	echo '<div class="single-product-image-wrap">';
}

add_action( 'woocommerce_before_single_product_summary', 'larisdigital_wc_product_image_wrap_end', 99 );
function larisdigital_wc_product_image_wrap_end() {
	echo '</div>';
}

add_filter( 'woocommerce_product_review_comment_form_args', 'larisdigital_wc_product_comment_form_field' );
function larisdigital_wc_product_comment_form_field( $comment_form ) {
	$commenter    = wp_get_current_commenter();
	$name_email_required = (bool) get_option( 'require_name_email', 1 );
	$fields              = array(
		'author' => array(
			'label'    => __( 'Name', 'larisdigital-wp' ),
			'type'     => 'text',
			'value'    => $commenter['comment_author'],
			'required' => $name_email_required,
		),
		'email' => array(
			'label'    => __( 'Email', 'larisdigital-wp' ),
			'type'     => 'email',
			'value'    => $commenter['comment_author_email'],
			'required' => $name_email_required,
		),
	);

	$comment_form['fields'] = array();

	foreach ( $fields as $key => $field ) {
		$aria_req = ( $field['required'] ? " aria-required='true'" : '' );

		if ( 'email' == $key ) {
			$wrap_star = '';
			$wrap_end = '</div>';
			$svg_icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M464 64H48C21.49 64 0 85.49 0 112v288c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V112c0-26.51-21.49-48-48-48zm0 48v40.805c-22.422 18.259-58.168 46.651-134.587 106.49-16.841 13.247-50.201 45.072-73.413 44.701-23.208.375-56.579-31.459-73.413-44.701C106.18 199.465 70.425 171.067 48 152.805V112h416zM48 400V214.398c22.914 18.251 55.409 43.862 104.938 82.646 21.857 17.205 60.134 55.186 103.062 54.955 42.717.231 80.509-37.199 103.053-54.947 49.528-38.783 82.032-64.401 104.947-82.653V400H48z"/></svg>';
		}
		else if ( 'author' == $key ) {
			$wrap_star = '<div class="row">';
			$wrap_end = '';
			$svg_icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path d="M248 104c-53 0-96 43-96 96s43 96 96 96 96-43 96-96-43-96-96-96zm0 144c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm0-240C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm0 448c-49.7 0-95.1-18.3-130.1-48.4 14.9-23 40.4-38.6 69.6-39.5 20.8 6.4 40.6 9.6 60.5 9.6s39.7-3.1 60.5-9.6c29.2 1 54.7 16.5 69.6 39.5-35 30.1-80.4 48.4-130.1 48.4zm162.7-84.1c-24.4-31.4-62.1-51.9-105.1-51.9-10.2 0-26 9.6-57.6 9.6-31.5 0-47.4-9.6-57.6-9.6-42.9 0-80.6 20.5-105.1 51.9C61.9 339.2 48 299.2 48 256c0-110.3 89.7-200 200-200s200 89.7 200 200c0 43.2-13.9 83.2-37.3 115.9z"/></svg>';
		}
		else {
			$wrap_star = '';
			$wrap_end = '';
			$svg_icon = '';
		}

		$field_html = $wrap_star . '<div class="col-md-6"><div class="input-group mb-3 comment-form-' . esc_attr( $key ) . '">' . '<div class="input-group-prepend"><span class="input-group-text">' . $svg_icon . '</span></div>' . '<input class="form-control" id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" type="text" placeholder="' . esc_attr( $field['label'] ) . ( $field['required'] ? ' *' : '' ) . '" value="' . esc_attr( $field['value'] ) . '" size="30"' . $aria_req . ' /></div></div>' . $wrap_end;

		$comment_form['fields'][ $key ] = $field_html;
	}

	if ( wc_review_ratings_enabled() ) {
		$comment_form['comment_field'] = '<div class="comment-form-rating"><label for="rating">' . esc_html__( 'Your rating', 'larisdigital-wp' ) . '</label><select name="rating" id="rating" required>
			<option value="">' . esc_html__( 'Rate&hellip;', 'larisdigital-wp' ) . '</option>
			<option value="5">' . esc_html__( 'Perfect', 'larisdigital-wp' ) . '</option>
			<option value="4">' . esc_html__( 'Good', 'larisdigital-wp' ) . '</option>
			<option value="3">' . esc_html__( 'Average', 'larisdigital-wp' ) . '</option>
			<option value="2">' . esc_html__( 'Not that bad', 'larisdigital-wp' ) . '</option>
			<option value="1">' . esc_html__( 'Very poor', 'larisdigital-wp' ) . '</option>
		</select></div>';
	}

	$comment_form['comment_field'] .= '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" placeholder="' . esc_attr__( 'Your review *', 'larisdigital-wp' ) . '" required></textarea></p>';

	return $comment_form;
}

add_action( 'woocommerce_account_dashboard', 'larisdigital_wc_account_dashboard', 10, 0 ); 
function larisdigital_wc_account_dashboard(  ) { 
	$account_dashboard = larisdigital_theme_mod( 'larisdigital_wc_myaccount_dashboard_enable');
	if ( $account_dashboard ) {
		$dashboard_content = larisdigital_theme_mod( 'larisdigital_wc_myaccount_dashboard_content' );
		echo wp_kses_post( wpautop( $dashboard_content ) );
	}
};
 
add_filter( 'woocommerce_variable_sale_price_html', 'larisdigital_wc_variable_price_html', 10, 2 );
add_filter( 'woocommerce_variable_price_html', 'larisdigital_wc_variable_price_html', 10, 2 );
function larisdigital_wc_variable_price_html( $price, $product ) {
	$setting = larisdigital_theme_mod('larisdigital_wc_variable_price');
	if ( $setting != 'low' ) {
		return $price;
	}

	$min_reg_price = $product->get_variation_regular_price( 'min', true );
	$min_sale_price = $product->get_variation_sale_price( 'min', true );
	$max_price = $product->get_variation_price( 'max', true );
	$min_price = $product->get_variation_price( 'min', true );

	if ( $min_price == $max_price ) {
		return wc_price( $min_price );
	}
	else {
		return ( $min_sale_price == $min_reg_price ) ? wc_price( $min_reg_price ) : '<del>' . wc_price( $min_reg_price ) . '</del> <ins>' . wc_price( $min_sale_price ) . '</ins>';
	}
}

add_action( 'woocommerce_thankyou', 'larisdigital_wc_thankyou_digital', 1, 1 );
function larisdigital_wc_thankyou_digital( $order_id ) {
	if ( ! $order_id ) {
		return;
	}

	$order = wc_get_order( $order_id );

	$payment_method = $order->get_payment_method();
	$order_status = $order->get_status();

	if ( in_array( $payment_method, array( 'bacs', 'cod', 'cheque', '' ) ) ) {
		return;
	}

	if ( $order_status == 'processing' || ( $order_status == 'on-hold' && $payment_method == 'paypal' ) ) {
		$virtual_only = true;
		$downloadable_only = true;
		$items = $order->get_items();
		if ( count($items ) > 0 ) {
			foreach ($items  as $item) {
				if ( is_callable([$item, 'get_product']) ) {
					$product = $item->get_product();
				}
				elseif ( is_callable([$order, 'get_product_from_item']) ) {
					$product = $order->get_product_from_item($item);
				}
				else {
					$product = null;
				}
				if ( !empty($product) ) {
					if ( !$product->is_virtual() ) {
						$virtual_only = false;
					}
					if ( !$product->is_downloadable() ) {
						$downloadable_only = false;
					}
				} 
			}
		}
		if ( $virtual_only && $downloadable_only ) {
			$order->update_status( 'completed' );
		}
	}
}
