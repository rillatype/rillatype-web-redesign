<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'larisdigital_wc_breadcrumb' ) ) {
	return;
}

if ( ! apply_filters( 'larisdigital_breadcrumb_is_active', true ) ) {
	return;
}

$alignment = larisdigital_theme_mod( 'larisdigital_breadcrumb_alignment' );
$alignment_class = '';
if ( $alignment == 'left' ) {
	$alignment_class = 'justify-content-start';
}
elseif ( $alignment == 'right' ) {
	$alignment_class = 'justify-content-end';
}
elseif ( $alignment == 'center' ) {
	$alignment_class = 'justify-content-center';
}

larisdigital_wc_breadcrumb( array(
	'home'			=> '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M280.37 148.26L96 300.11V464a16 16 0 0 0 16 16l112.06-.29a16 16 0 0 0 15.92-16V368a16 16 0 0 1 16-16h64a16 16 0 0 1 16 16v95.64a16 16 0 0 0 16 16.05L464 480a16 16 0 0 0 16-16V300L295.67 148.26a12.19 12.19 0 0 0-15.3 0zM571.6 251.47L488 182.56V44.05a12 12 0 0 0-12-12h-56a12 12 0 0 0-12 12v72.61L318.47 43a48 48 0 0 0-61 0L4.34 251.47a12 12 0 0 0-1.6 16.9l25.5 31A12 12 0 0 0 45.15 301l235.22-193.74a12.19 12.19 0 0 1 15.3 0L530.9 301a12 12 0 0 0 16.9-1.6l25.5-31a12 12 0 0 0-1.7-16.93z"/></svg> ' . esc_html__( 'Home', 'larisdigital-wp' ),
	'delimiter'		=> '',
	'wrap_before'	=> '<nav id="breadcrumb" class="site-breadcrumb" aria-label="breadcrumb"><div class="container"><ol class="breadcrumb '.$alignment_class.'">',
	'wrap_after'	=> '</ol></div></nav>'."\n",
	'before'		=> '<li class="breadcrumb-item">',
	'after'			=> '</li>',
	'before_last'	=> '<li class="breadcrumb-item active">',
	'after_last'	=> '</li>',
)); 
