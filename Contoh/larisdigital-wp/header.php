<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php do_action( 'larisdigital_body_before' ); ?>

<div class="site-wrap">

<?php do_action( 'larisdigital_site_before' ); ?>
