<?php
/**
 * LarisDigital Store - Functions
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

function larisdigital_shop_price( $price ) {
	$currency = get_post_meta( get_the_ID(), '_currency', true );
	if ( empty($currency) ) {
		$currency = 'Rp';
	}
	return $currency.' '.number_format( $price, 0, ',', '.' );
}

function larisdigital_store_product_is_on_sale() {
	$regular_price = get_post_meta( get_the_ID(), '_regular_price', true );
	$sale_price = get_post_meta( get_the_ID(), '_sale_price', true );
	if ( '' !== (string) $sale_price && $regular_price && $regular_price > $sale_price ) {
		$on_sale = true;
	}
	else {
		$on_sale = false;
	}
	return $on_sale;
}

function larisdigital_store_format_price( $price ) {
	$currency = get_post_meta( get_the_ID(), '_currency', true );
	if ( empty($currency) ) {
		$currency = larisdigital_theme_mod('larisdigital_store_currency');
	}
	if ( empty($currency) ) {
		$currency = 'Rp';
	}
	$currency_pos = larisdigital_theme_mod('larisdigital_store_currency_pos');
	if ( empty($currency_pos) ) {
		$currency_pos = 'left';
	}
	$thousand_sep = larisdigital_theme_mod('larisdigital_store_price_thousand_sep');
	if ( empty($thousand_sep) ) {
		$thousand_sep = ',';
	}
	$decimal_sep = larisdigital_theme_mod('larisdigital_store_price_decimal_sep');
	if ( empty($decimal_sep) ) {
		$decimal_sep = '.';
	}
	$num_decimals = larisdigital_theme_mod('larisdigital_store_price_num_decimals');
	if ( (string) $num_decimals === '' ) {
		$num_decimals = 0;
	}
	$free_text = larisdigital_theme_mod('larisdigital_store_heading_free_text');
	if ( empty($free_text) ) {
		$free_text = esc_html__( 'Free', 'larisdigital-wp' );
	}
	if ( !$price ) {
		$price = $free_text;
	}
	else {
		$price = number_format( $price, $num_decimals, $decimal_sep, $thousand_sep );
		if ( $thousand_sep == 'right' ) {
			$price = $price.$currency;
		}
		elseif ( $thousand_sep == 'right_space' ) {
			$price = $price.' '.$currency;
		}
		elseif ( $thousand_sep == 'left_space' ) {
			$price = $currency.' '.$price;
		}
		else {
			$price = $currency.$price;
		}
	}
	return $price;
}

function larisdigital_store_product_price() {
	$regular_price = get_post_meta( get_the_ID(), '_regular_price', true );
	if ( (string) $regular_price === '' ) {
		return;
	}
	$sale_price = get_post_meta( get_the_ID(), '_sale_price', true );
	if ( '' !== (string) $sale_price && $regular_price && $regular_price > $sale_price ) {
		echo '<del>'.larisdigital_store_format_price( $regular_price ).'</del> '.larisdigital_store_format_price( $sale_price );
	}
	else {
		echo larisdigital_store_format_price( $regular_price );
	}
}
