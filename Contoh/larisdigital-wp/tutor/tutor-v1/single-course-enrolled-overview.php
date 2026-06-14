<?php
/**
 * Template for displaying single course
 *
 * @since v.1.0.0
 *
 * @author Themeum
 * @url https://themeum.com
 *
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

get_header();
?>

<?php do_action('tutor_course/single/enrolled/before/wrap'); ?>

<div <?php tutor_post_class('tutor-single-overview-wrap tutor-page-wrap'); ?>>
    <div class="container">
        <div class="row <?php echo apply_filters( 'larisdigital_tutor_course_row_class', 'justify-content-center' ); ?>">
            <div class="<?php echo apply_filters( 'larisdigital_tutor_course_content_class', 'col-lg-8 col-md-12' ); ?>">
                <?php do_action('tutor_course/single/enrolled/before/inner-wrap'); ?>
                <?php tutor_course_enrolled_lead_info(); ?>
                <?php tutor_course_enrolled_nav(); ?>
                <?php get_tutor_posts_attachments(); ?>
                <?php do_action('tutor_course/single/enrolled/after/inner-wrap'); ?>
            </div>
            <div class="<?php echo apply_filters( 'larisdigital_tutor_course_cta_class', 'col-lg-4 col-md-6 col-sm-8 mb-4' ); ?>">
                <div class="tutor-single-course-sidebar">
                    <?php do_action('tutor_course/single/enrolled/before/sidebar'); ?>
                    <?php tutor_course_enroll_box(); ?>
                    <?php tutor_course_requirements_html(); ?>
                    <?php tutor_course_tags_html(); ?>
                    <?php tutor_course_target_audience_html(); ?>
                    <?php do_action('tutor_course/single/enrolled/after/sidebar'); ?>
                </div>
            </div>
        </div>
    </div>
</div><!-- .wrap -->

<?php do_action('tutor_course/single/enrolled/after/wrap'); ?>

<?php 
get_footer();
