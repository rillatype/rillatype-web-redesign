<?php 
/**
 * WooCommerce Filters, frontend only
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'woocommerce' ) ) {
	return;
}

/**
 * Filter - Navigation Quicknav - Mini Cart - is it active?
 */
add_filter( 'larisdigital_navigation_quicknav_is_active', 'larisdigital_navigation_quicknav_minicart_filter' );
function larisdigital_navigation_quicknav_minicart_filter( $active ) {
	if ( larisdigital_theme_mod( 'larisdigital_navigation_quicknav_minicart' ) ) {
		$active = true;
	}
	return $active;
}

/**
 * Filter - Header - is it active?
 */
add_filter( 'larisdigital_header_is_active', 'larisdigital_wc_filter_header_is_active', 5 );
function larisdigital_wc_filter_header_is_active( $active ) {
	if ( is_product() ) {
		if ( larisdigital_theme_mod( 'larisdigital_wc_product_header_hide' ) ) {
			return false;
		}
	}
	return $active;
}

/**
 * Filter - Sidebar Layout
 */
add_filter( 'larisdigital_sidebar_layout', 'larisdigital_wc_sidebar_layout', 25 );
function larisdigital_wc_sidebar_layout( $layout ) {
	if ( is_woocommerce() ) {
		if ( is_product() ) {
			if ( $layout_product = larisdigital_theme_mod( 'larisdigital_wc_product_sidebar_layout' ) ) {
				$layout = $layout_product;
			}
		}
		else {
			if ( $layout_shop = larisdigital_theme_mod( 'larisdigital_wc_shop_sidebar_layout' ) ) {
				$layout = $layout_shop;
			}
		}
	}
	elseif ( is_cart() || is_checkout() || is_account_page() ) {
		$layout = 'none';
	}
	return $layout;
}

/**
 * Filter - Sidebar Width
 */
add_filter( 'larisdigital_sidebar_width', 'larisdigital_wc_sidebar_width', 25 );
function larisdigital_wc_sidebar_width( $width ) {
	if ( is_woocommerce() ) {
		if ( is_product() ) {
			if ( $width_product = larisdigital_theme_mod( 'larisdigital_wc_product_sidebar_width' ) ) {
				$width = $width_product;
			}
		}
		else {
			if ( $width_shop = larisdigital_theme_mod( 'larisdigital_wc_shop_sidebar_width' ) ) {
				$width = $width_shop;
			}
		}
	}
	elseif ( is_cart() || is_checkout() || is_account_page() ) {
		$width = 12;
	}
	return $width;
}

/**
 * Filter - Content Width
 */
add_filter( 'larisdigital_content_width', 'larisdigital_wc_content_width', 25 );
function larisdigital_wc_content_width( $width ) {
	if ( is_woocommerce() ) {
		if ( is_product() ) {
			if ( $width_product = larisdigital_theme_mod( 'larisdigital_wc_product_content_width' ) ) {
				$width = $width_product;
			}
		}
		else {
			if ( $width_shop = larisdigital_theme_mod( 'larisdigital_wc_shop_content_width' ) ) {
				$width = $width_shop;
			}
		}
	}
	elseif ( is_cart() || is_checkout() || is_account_page() ) {
		$width = 12;
	}
	return $width;
}

/**
 * Filter - Header Title
 */
add_filter( 'larisdigital_header_title', 'larisdigital_wc_filter_header_title' );
function larisdigital_wc_filter_header_title( $output ) {
	if ( is_woocommerce() ) {
		if ( is_product() ) {
			if ( larisdigital_theme_mod( 'larisdigital_wc_product_title4header' ) ) {
				$output = get_the_title();
			}
		}
		else {
			if ( larisdigital_theme_mod( 'larisdigital_wc_shop_title4header' ) ) {
				$output = woocommerce_page_title( false );
			}
		}
	}
	return $output;
}

/**
 * Filter - Header Description
 */
add_filter( 'larisdigital_header_description', 'larisdigital_wc_filter_header_description' );
function larisdigital_wc_filter_header_description( $output ) {
	if ( is_woocommerce() ) {
		if ( is_product() ) {
			if ( larisdigital_theme_mod( 'larisdigital_wc_product_title4header' ) ) {
				$output = '';
			}
		}
		else {
			if ( larisdigital_theme_mod( 'larisdigital_wc_shop_title4header' ) ) {
				if ( is_tax() ) {
					$term = get_queried_object();
					if ( $term && ! empty( $term->description ) ) {
						$output = wc_format_content( $term->description );
					}
				}
			}
		}
	}
	return $output;
}

/**
 * Filter - Shop - Hide Shop Title
 */
add_filter( 'woocommerce_show_page_title', 'larisdigital_wc_show_page_title' );
function larisdigital_wc_show_page_title( $show ) {
	if ( ! larisdigital_theme_mod( 'larisdigital_header_hide' ) && larisdigital_theme_mod( 'larisdigital_wc_shop_title4header' ) ) {
		return false;
	}
	return $show;
}
