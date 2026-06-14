<?php
/**
 * WooCommerce Functions, for both frontend and admin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'woocommerce' ) ) {
	return;
}

function larisdigital_wc_breadcrumb( $args = array() ) {
	echo larisdigital_wc_get_breadcrumb( $args );
}

function larisdigital_wc_get_breadcrumb( $args = array() ) {
	if ( ! class_exists( 'WC_Breadcrumb' ) ) {
		return;
	}

	$defaults = apply_filters( 'larisdigital_wc_breadcrumb_defaults', array(
		'delimiter'		=> '',
		'wrap_before'	=> '<ol class="breadcrumbs">',
		'wrap_after'	=> '</ol>',
		'before'		=> '<li>',
		'after'			=> '</li>',
		'before_last'	=> '<li class="active">',
		'after_last'	=> '</li>',
		'home'			=> __( 'Home', 'larisdigital-wp' ),
	) );

	$args = wp_parse_args( $args, $defaults );

	$breadcrumbs = new WC_Breadcrumb();
	$args['breadcrumb'] = $breadcrumbs->generate();

	/**
	 * WooCommerce Breadcrumb hook
	 *
	 * @hooked WC_Structured_Data::generate_breadcrumblist_data() - 10
	 */
	do_action( 'woocommerce_breadcrumb', $breadcrumbs, $args );

	extract( $args );

	$crumbs = array();
	if ( ! empty( $home ) ) {
		$crumbs[] = $before . '<a class="home" href="' . apply_filters( 'woocommerce_breadcrumb_home_url', home_url('/') ) . '">' . $home . '</a>' . $after . $delimiter;
	}
	if ( ! empty( $breadcrumb ) ) {
		foreach ( $breadcrumb as $key => $crumb ) {
			if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) {
				$crumbs[] = $before . '<a href="' . esc_url( $crumb[1] ) . '">' . esc_html( $crumb[0] ) . '</a>' . $after . $delimiter;
			} 
			else {
				$crumbs[] = $before_last . esc_html( $crumb[0] ) . $after_last;
			}
		}
	}

	return $wrap_before.implode( '', $crumbs ).$wrap_after;

}
