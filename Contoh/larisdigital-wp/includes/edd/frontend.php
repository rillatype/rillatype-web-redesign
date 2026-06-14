<?php
/**
 * EDD - Frontend
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists('Easy_Digital_Downloads') ) {
	return;
}

add_filter( 'edd_add_schema_microdata', '__return_false' );
remove_action( 'edd_after_download_content', 'edd_append_purchase_link' );

add_filter( 'edd_format_amount_decimals', 'larisdigital_edd_edd_remove_decimals' );
function larisdigital_edd_edd_remove_decimals( $decimals ) {
	return 0;
}

add_filter( 'single_template_hierarchy', 'larisdigital_edd_shop_single_template_hierarchy' );
function larisdigital_edd_shop_single_template_hierarchy( $templates ) {
	if ( is_singular('download') ) {
		array_unshift( $templates, 'edd_templates/template-edd-product.php' );
	}
	return $templates;
}

add_filter( 'archive_template_hierarchy', 'larisdigital_edd_shop_archive_template_hierarchy' );
function larisdigital_edd_shop_archive_template_hierarchy( $templates ) {
	if ( is_post_type_archive('download') ) {
		array_unshift( $templates, 'edd_templates/template-edd-shop.php' );
	}
	return $templates;
}

add_filter( 'taxonomy_template_hierarchy', 'larisdigital_edd_shop_taxonomy_template_hierarchy' );
function larisdigital_edd_shop_taxonomy_template_hierarchy( $templates ) {
	if( is_tax('download_category') || is_tax('download_tag') ) {
		array_unshift( $templates, 'edd_templates/template-edd-shop.php' );
	}
	return $templates;
}

add_action( 'pre_get_posts', 'larisdigital_edd_shop_pre_get_posts' );
function larisdigital_edd_shop_pre_get_posts( $query ) {
	if ( !is_admin() && $query->is_main_query() ) {
		if ( is_post_type_archive( 'download' ) || is_tax('download_category') || is_tax('download_tag') ) {
			$per_page = larisdigital_theme_mod('larisdigital_edd_shop_per_page');
			if ( $per_page < 1 ) {
				$per_page = 12;
			}
			$query->set( 'posts_per_page', $per_page );
		}
	}
}
