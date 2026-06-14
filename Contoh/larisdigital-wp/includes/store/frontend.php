<?php
/**
 * LarisDigital Store - Frontend
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

add_filter( 'single_template_hierarchy', 'larisdigital_store_single_template_hierarchy' );
function larisdigital_store_single_template_hierarchy( $templates ) {
	if ( is_singular('product') ) {
		array_unshift( $templates, 'store/template-product.php' );
	}
	return $templates;
}

add_filter( 'archive_template_hierarchy', 'larisdigital_store_archive_template_hierarchy' );
function larisdigital_store_archive_template_hierarchy( $templates ) {
	if ( is_post_type_archive('product') ) {
		array_unshift( $templates, 'store/template-shop.php' );
	}
	return $templates;
}

add_filter( 'taxonomy_template_hierarchy', 'larisdigital_store_taxonomy_template_hierarchy' );
function larisdigital_store_taxonomy_template_hierarchy( $templates ) {
	if( is_tax('product_cat') || is_tax('product_tag') ) {
		array_unshift( $templates, 'store/template-shop.php' );
	}
	return $templates;
}

add_action( 'pre_get_posts', 'larisdigital_store_pre_get_posts' );
function larisdigital_store_pre_get_posts( $query ) {
	if ( !is_admin() && $query->is_main_query() ) {
		if ( is_post_type_archive( 'product' ) || is_tax('product_cat') || is_tax('product_tag') ) {
			$per_page = larisdigital_theme_mod('larisdigital_store_shop_per_page');
			if ( $per_page < 1 ) {
				$per_page = 12;
			}
			$query->set( 'posts_per_page', $per_page );
		}
	}
}
