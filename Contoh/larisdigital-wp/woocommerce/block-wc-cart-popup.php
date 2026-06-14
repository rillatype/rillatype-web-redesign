<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists('woocommerce') ) {
	return;
}

$title = larisdigital_get_integration_wc( 'wc_cartpopup_title' );
if ( empty( $title ) ) {
	$title = esc_html__( 'Add To Cart', 'larisdigital-wp' );
}

$cart_text = larisdigital_get_integration_wc( 'wc_cartpopup_cart_text' );
if ( empty( $cart_text ) ) {
	$cart_text = esc_html__( 'View Cart', 'larisdigital-wp' );
}

$checkout_text = larisdigital_get_integration_wc( 'wc_cartpopup_checkout_text' );
if ( empty( $checkout_text ) ) {
	$checkout_text = esc_html__( 'Checkout', 'larisdigital-wp' );
}

$continue_text = larisdigital_get_integration_wc( 'wc_cartpopup_continue_text' );
if ( empty( $continue_text ) ) {
	$continue_text = esc_html__( 'Continue Shopping', 'larisdigital-wp' );
}

$primary_linkto = larisdigital_get_integration_wc( 'wc_cartpopup_primary' );

if ( 'checkout' != $primary_linkto ) {
	$primary_link = wc_get_cart_url();
	$primary_text = $cart_text;
}
else {
	$primary_link = wc_get_checkout_url();
	$primary_text = $checkout_text;
}
$secondary_text = $continue_text;

if ( is_cart() ) {
	$primary_link = wc_get_page_permalink( 'checkout' );
	$primary_text = $checkout_text;
	$secondary_text = $cart_text;
}
?>

<div class="modal fade tp-cart-popup" id="tp-cart-popup" tabindex="-1" role="dialog" aria-labelledby="tp-cart-popup-title" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="tp-cart-popup-title"><?php echo esc_html( $title ); ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="tp-cart-popup-loading" class="tp-cart-popup-loading">
					<div class="spinkit-wave">
						<div class="spinkit-rect spinkit-rect1"></div>
						<div class="spinkit-rect spinkit-rect2"></div>
						<div class="spinkit-rect spinkit-rect3"></div>
						<div class="spinkit-rect spinkit-rect4"></div>
						<div class="spinkit-rect spinkit-rect5"></div>
					</div>
				</div>
				<div id="tp-cart-popup-notices" class="tp-cart-popup-notices">
				</div>
				<div id="tp-cart-popup-content" class="tp-cart-popup-content">
				</div>
			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-secondary flex-fill align-self-center" data-dismiss="modal">
					<?php echo esc_html( $secondary_text ); ?>
				</button>
				<a class="btn btn-primary flex-fill align-self-center" href="<?php echo esc_url( $primary_link ); ?>">
					<?php echo esc_html( $primary_text ); ?>
				</a>
			</div>
		</div>
	</div>
</div>
