<?php
/**
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

$product_id = tutor_utils()->get_course_product_id();
$product_sejoli = larisdigital_tutor_sejoli_is_product($product_id);
$button_text = larisdigital_theme_mod( 'larisdigital_tutor_sejoli_button_text' );
if ( empty($button_text) ) {
    $button_text = esc_html__( 'Join Now', 'larisdigital-wp' );
}

if ($product_sejoli) {
    $price = get_post_meta( $product_id, '_price', true );
    ?>
    <?php if (!empty($price)) : ?>
    <div class="tutor-course-sidebar-card-pricing tutor-d-flex tutor-align-end tutor-justify-between">
        <div>
            <span class="tutor-fs-4 tutor-fw-bold tutor-color-black">
                <?php echo sejolisa_price_format($price); ?>
            </span>
        </div>
    </div>
    <?php endif; ?>
    <a href="<?php echo esc_url( get_permalink($product_id) ); ?>" class="tutor-btn tutor-btn-primary tutor-btn-lg tutor-btn-block tutor-mt-24 tutor-add-to-cart-button <?php echo esc_attr( $required_loggedin_class ); ?>">
        <span class="btn-icon tutor-icon-cart-filled"></span>
        <span><?php echo esc_html( $button_text ); ?></span>
    </a>
    <?php
}
else{
    ?>
    <p class="tutor-alert-warning">
        <?php _e('Please make sure that your Sejoli product exists and valid for this course', 'larisdigital-wp'); ?>
    </p>
    <?php
}