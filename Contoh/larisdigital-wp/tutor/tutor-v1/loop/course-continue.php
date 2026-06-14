<?php

/**
 * Course loop continue when enrolled
 *
 * @since v.1.7.4
 * @author themeum
 * @url https://themeum.com
 *
 * @package TutorLMS/Templates
 * @version 1.7.4
 */
?>

<div class="tutor-course-loop-price">
    <?php
    $course_id = get_the_ID();
    $enroll_btn = '<div  class="tutor-loop-cart-btn-wrap"><a href="'. get_the_permalink(). '">'.__('Continue Course', 'larisdigital-wp'). '</a></div>';
    $price_html = '<div class="price"> '.$enroll_btn. '</div>';
    echo $price_html;
    ?>
</div>
