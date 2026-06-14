<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Keluar jika diakses langsung
}

if ( ! class_exists( 'woocommerce' ) ) {
	return; // Hentikan jika WooCommerce tidak ada
}

if ( ! is_product() ) {
	return; // Hentikan jika bukan halaman produk
}

if ( ! function_exists( 'larisdigital_wc_buttonsticky_button_text' ) ) {
	function larisdigital_wc_buttonsticky_button_text( $text ) {
		$text_new = larisdigital_get_integration_wc( 'wc_buttonsticky_addtocart_text' );
		return $text_new ? $text_new : $text;
	}
}
add_filter( 'woocommerce_product_single_add_to_cart_text', 'larisdigital_wc_buttonsticky_button_text', 12 );

$sticky_active = false;
$popup_active = false;

global $product;
if ( empty( $product ) ) {
	$product = wc_get_product( get_the_ID() );
}

if ( $product instanceof WC_Product ) {
	$product_type = $product->get_type();
	$button_active = false;

	if ( $product->is_in_stock() ) {
		$button_addtocart = larisdigital_get_integration_wc( 'wc_buttonsticky_addtocart' );
		if ( 'yes' === $button_addtocart ) {
			$sticky_active = true;
			$button_active = true;
		} elseif ( 'no' === $button_addtocart ) {
			$sticky_active = false;
			$button_active = false;
		} else {
			$sticky_active = ! larisdigital_theme_mod( 'larisdigital_wc_product_button_disable' );
			$button_active = $sticky_active;
		}

		if ( $button_active ) {
			$popup_active = ! in_array( $product_type, [ 'simple', 'external' ], true );
			$button_text = larisdigital_get_integration_wc( 'wc_buttonsticky_addtocart_text' ) ?: larisdigital_theme_mod( 'larisdigital_wc_product_button_text' ) ?: esc_html__( 'Add to cart', 'larisdigital-wp' );
		}
	}
}

$sticky_active = apply_filters( 'larisdigital_wc_button_sticky_active', $sticky_active );
if ( ! $sticky_active ) {
	return;
}

$popup_active = apply_filters( 'larisdigital_wc_button_sticky_popup', $popup_active );
?>

<div class="woocommerce tp-wc-button-sticky" id="tp-wc-button-sticky">
	<div class="container">
		<div class="row">
			<?php do_action( 'larisdigital_wc_button_sticky_before' ); ?>
			<?php if ( $button_active && function_exists( 'woocommerce_template_single_add_to_cart' ) ) : ?>
				<div class="col">
					<?php if ( $popup_active ) : ?>
						<button type="button" class="single_add_to_cart_button button alt" data-toggle="modal" data-target="#tp-wc-atc-popup">
							<?php echo esc_html( $button_text ); ?>
						</button>
					<?php else : ?>
						<?php woocommerce_template_single_add_to_cart(); ?>
					<?php endif; ?>
				</div>
			<?php endif; ?>
			<?php do_action( 'larisdigital_wc_button_sticky_after' ); ?>
		</div>
	</div>
</div>

<?php if ( $popup_active && function_exists( 'woocommerce_template_single_add_to_cart' ) ) : ?>
<div class="modal fade tp-wc-atc-popup" id="tp-wc-atc-popup" tabindex="-1" role="dialog" aria-labelledby="tp-wc-atc-popup-title" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="tp-wc-atc-popup-title"><?php the_title(); ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="woocommerce">
					<div class="product">
						<?php woocommerce_template_single_add_to_cart(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>
