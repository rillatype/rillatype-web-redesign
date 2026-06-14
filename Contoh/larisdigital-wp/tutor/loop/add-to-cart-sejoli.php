<?php
/**
 * A single course loop add to cart
 *
 * @since v.1.0.0
 * @author themeum
 * @url https://themeum.com
 *
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$product_id = tutor_utils()->get_course_product_id();

if (! $product_id){
	return;
}

if ( !larisdigital_tutor_sejoli_is_product($product_id) ) {
	return;
}

$button_text = larisdigital_theme_mod( 'larisdigital_tutor_sejoli_button_text' );
if ( empty($button_text) ) {
    $button_text = esc_html__( 'Join Now', 'larisdigital-wp' );
}
?>

<div class="tutor-loop-cart-btn-wrap">
	<a href="<?php echo esc_url( get_permalink($product_id) ); ?>" class="tutor-btn tutor-btn-icon tutor-btn-disable-outline tutor-btn-ghost tutor-no-hover tutor-btn-md add_to_cart_button">
		<?php echo esc_html( $button_text ); ?>
	</a>
</div>
