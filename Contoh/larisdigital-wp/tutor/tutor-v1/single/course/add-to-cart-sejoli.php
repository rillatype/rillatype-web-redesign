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
    ?>
    <div class="tutor-course-purchase-box">
        <a href="<?php echo esc_url( get_permalink($product_id) ); ?>" class="tutor-button">
            <?php echo esc_html( $button_text ); ?>
        </a>
    </div>
    <?php
}
else{
    ?>
    <p class="tutor-alert-warning">
        <?php _e('Please make sure that your Sejoli product exists and valid for this course', 'larisdigital-wp'); ?>
    </p>
    <?php
}