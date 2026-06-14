<?php 
/**
 * LarisDigital Store - Filters, frontend only
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
 * Filter - Header - is it active?
 */
add_filter( 'larisdigital_header_is_active', 'larisdigital_store_shop_filter_header_is_active', 5 );
function larisdigital_store_shop_filter_header_is_active( $active ) {
	if ( is_singular('product') ) {
		if ( larisdigital_theme_mod( 'larisdigital_store_product_header_hide' ) ) {
			return false;
		}
	}
	return $active;
}

/**
 * Filter - Sidebar Layout
 */
add_filter( 'larisdigital_sidebar_layout', 'larisdigital_store_shop_sidebar_layout', 25 );
function larisdigital_store_shop_sidebar_layout( $layout ) {
	if ( is_singular('product') ) {
		if ( $layout_product = larisdigital_theme_mod( 'larisdigital_store_product_sidebar_layout' ) ) {
			$layout = $layout_product;
		}
	}
	elseif ( is_post_type_archive('product') || is_tax('product_cat') || is_tax('product_tag') ) {
		if ( $layout_shop = larisdigital_theme_mod( 'larisdigital_store_shop_sidebar_layout' ) ) {
			$layout = $layout_shop;
		}
	}
	return $layout;
}

/**
 * Filter - Sidebar Width
 */
add_filter( 'larisdigital_sidebar_width', 'larisdigital_store_shop_sidebar_width', 25 );
function larisdigital_store_shop_sidebar_width( $width ) {
	if ( is_singular('product') ) {
		if ( $width_product = larisdigital_theme_mod( 'larisdigital_store_product_sidebar_width' ) ) {
			$width = $width_product;
		}
	}
	elseif ( is_post_type_archive('product') || is_tax('product_cat') || is_tax('product_tag') ) {
		if ( $width_shop = larisdigital_theme_mod( 'larisdigital_store_shop_sidebar_width' ) ) {
			$width = $width_shop;
		}
	}
	return $width;
}

/**
 * Filter - Content Width
 */
add_filter( 'larisdigital_content_width', 'larisdigital_store_shop_content_width', 25 );
function larisdigital_store_shop_content_width( $width ) {
	if ( is_singular('product') ) {
		if ( $width_product = larisdigital_theme_mod( 'larisdigital_store_product_content_width' ) ) {
			$width = $width_product;
		}
	}
	elseif ( is_post_type_archive('product') || is_tax('product_cat') || is_tax('product_tag') ) {
		if ( $width_shop = larisdigital_theme_mod( 'larisdigital_store_shop_content_width' ) ) {
			$width = $width_shop;
		}
	}
	return $width;
}

/**
 * Filter - Header Title
 */
add_filter( 'larisdigital_header_title', 'larisdigital_store_shop_filter_header_title' );
function larisdigital_store_shop_filter_header_title( $output ) {
	if ( is_singular('product') ) {
		if ( larisdigital_theme_mod( 'larisdigital_store_product_title4header' ) ) {
			$output = get_the_title();
		}
	}
	elseif ( is_post_type_archive('product') ) {
		if ( larisdigital_theme_mod( 'larisdigital_store_shop_title4header' ) ) {
			$output = larisdigital_theme_mod( 'larisdigital_store_shop_title' );
			if ( empty($output) ) {
				$output = esc_html__( 'Shop', 'larisdigital-wp' );
			}
		}
		else {
			$output = get_bloginfo('name');
		}
	}
	elseif( is_tax('product_cat') || is_tax('product_tag') ) {
		if ( larisdigital_theme_mod( 'larisdigital_store_shop_title4header' ) ) {
			$term = get_queried_object();
			if ( $term && ! empty( $term->name ) ) {
				$output = $term->name;
			}
		}
	}
	return $output;
}

/**
 * Filter - Header Description
 */
add_filter( 'larisdigital_header_description', 'larisdigital_store_shop_filter_header_description' );
function larisdigital_store_shop_filter_header_description( $output ) {
	if ( is_singular('product') ) {
		if ( larisdigital_theme_mod( 'larisdigital_store_product_title4header' ) ) {
			$output = '';
		}
	}
	elseif ( is_post_type_archive('product') ) {
		if ( larisdigital_theme_mod( 'larisdigital_store_shop_title4header' ) ) {
			$output = larisdigital_theme_mod( 'larisdigital_store_shop_description' );
		}
		else {
			$output = get_bloginfo('description');
		}
	}
	elseif( is_tax('product_cat') || is_tax('product_tag') ) {
		if ( larisdigital_theme_mod( 'larisdigital_store_shop_title4header' ) ) {
			$term = get_queried_object();
			if ( $term && ! empty( $term->description ) ) {
				$output = wpautop( wptexturize( $term->description ) );
			}
		}
	}
	return $output;
}

/**
 * Filter - Shop - Column Class
 */
add_filter( 'larisdigital_shop_column_class', 'larisdigital_store_shop_column_class' );
function larisdigital_store_shop_column_class( $classes ) {
	$columns = larisdigital_theme_mod( 'larisdigital_store_shop_columns' );
	if ( $columns > 4 ) {
		$columns = 4;
	}
	elseif ( $columns < 1 ) {
		$columns = 3;
	}
	$classes = 'col-lg-'.intval(12/$columns);
	$columns_tablet = larisdigital_theme_mod( 'larisdigital_store_shop_columns_tablet' );
	if ( $columns_tablet > 3 ) {
		$columns_tablet = 3;
	}
	elseif ( $columns_tablet < 1 ) {
		$columns_tablet = 2;
	}
	$classes .= ' col-sm-'.intval(12/$columns_tablet);
	$columns_mobile = larisdigital_theme_mod( 'larisdigital_store_shop_columns_mobile' );
	if ( $columns_mobile == 2 ) {
		$classes .= ' col-'.intval(12/$columns_mobile);
	}
	return $classes;
}

/**
 * Filter - Product - Row Class
 */
add_filter( 'larisdigital_product_row_class', 'larisdigital_store_product_row_class' );
function larisdigital_store_product_row_class( $classes ) {
	$layout = larisdigital_theme_mod( 'larisdigital_store_product_layout' );
	if ( $layout == 'content-right' ) {
		$classes = 'justify-content-center justify-content-lg-end';
	}
	elseif ( $layout == 'content-top' ) {
		$classes = 'justify-content-center';
	}
	else {
		$classes = 'justify-content-center';
	}
	return $classes;
}

/**
 * Filter - Product - Content Class
 */
add_filter( 'larisdigital_product_content_class', 'larisdigital_store_product_content_class' );
function larisdigital_store_product_content_class( $classes ) {
	$layout = larisdigital_theme_mod( 'larisdigital_store_product_layout' );
	$cta_width = larisdigital_theme_mod( 'larisdigital_store_product_cta_width' );
	if ( $cta_width > 6 ) {
		$cta_width = 6;
	}
	elseif ( $cta_width < 3 ) {
		$cta_width = 4;
	}
	$content_width = 12 - $cta_width;
	if ( $layout == 'content-right' ) {
		$classes = 'col-lg-'.$content_width.' col-md-12 order-1 order-lg-2';
	}
	elseif ( $layout == 'content-top' ) {
		$classes = 'col-lg-12 col-md-12';
	}
	else {
		$classes = 'col-lg-'.$content_width.' col-md-12';
	}
	return $classes;
}

/**
 * Filter - Product - CTA Class
 */
add_filter( 'larisdigital_product_cta_class', 'larisdigital_store_product_cta_class' );
function larisdigital_store_product_cta_class( $classes ) {
	$layout = larisdigital_theme_mod( 'larisdigital_store_product_layout' );
	$cta_width = larisdigital_theme_mod( 'larisdigital_store_product_cta_width' );
	if ( $cta_width > 6 ) {
		$cta_width = 6;
	}
	elseif ( $cta_width < 3 ) {
		$cta_width = 4;
	}
	if ( $layout == 'content-right' ) {
		$classes = 'col-lg-'.$cta_width.' col-md-6 col-sm-8 order-2 order-lg-1 mb-4';
	}
	elseif ( $layout == 'content-top' ) {
		$classes = 'col-lg-'.$cta_width.' col-md-6 col-sm-8';
	}
	else {
		$classes = 'col-lg-'.$cta_width.' col-md-6 col-sm-8';
	}
	return $classes;
}
