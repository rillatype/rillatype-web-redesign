<?php

/**
 * Course loop price
 *
 * @since v.1.0.0
 * @author themeum
 * @url https://themeum.com
 *
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

$button_text = larisdigital_theme_mod( 'larisdigital_tutor_sejoli_button_text' );
if ( empty($button_text) ) {
    $button_text = esc_html__( 'Join Now', 'larisdigital-wp' );
}
?>

<div class="tutor-course-loop-price">
    <?php
    $course_id = get_the_ID();
    $enroll_btn = '<div  class="tutor-loop-cart-btn-wrap"><a href="'. get_the_permalink(). '">'.esc_html( $button_text ).'</a></div>';
    $price_html = '<div class="price"> '.__('Free', 'larisdigital-wp').$enroll_btn. '</div>';
    if (tutor_utils()->is_course_purchasable()) {
	    $enroll_btn = tutor_course_loop_add_to_cart(false);

	    $product_id = tutor_utils()->get_course_product_id($course_id);
        $price = get_post_meta( $product_id, '_price', true );
        if ($price) {
            $price_html = '<div class="price">'.sejolisa_price_format($price).$enroll_btn.' </div>';
        }
    }

    echo $price_html;
    ?>
</div>
