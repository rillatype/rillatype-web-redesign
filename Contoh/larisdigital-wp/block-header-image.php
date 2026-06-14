<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! apply_filters( 'larisdigital_header_image_is_active', false ) ) {
	return;
}

$header_image = get_header_image();
if ( ! $header_image ) {
	return;
}
?>
<div class="site-header-image">
	<img class="d-block w-100" src="<?php echo esc_url( $header_image ); ?>" alt="<?php echo( get_bloginfo( 'title' ) ); ?>" />
</div>
