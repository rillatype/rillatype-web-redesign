<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$navigation = apply_filters( 'larisdigital_navigation_is_active', true );
$header = apply_filters( 'larisdigital_header_is_active', true );

if ( ! ( $navigation || $header ) ) {
	return;
}

$wrapper_class = larisdigital_theme_mod( 'larisdigital_navigation_absolute' ) ? 'site-navigation-absolute' : 'site-navigation-relative';
?>

<div class="site-header-wrapper <?php echo esc_attr( $wrapper_class ); ?>">
