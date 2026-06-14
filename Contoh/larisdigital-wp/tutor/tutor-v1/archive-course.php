<?php

/**
 * Template for displaying courses
 *
 * @since v.1.0.0
 *
 * @author Themeum
 * @url https://themeum.com
 *
 * @package TutorLMS/Templates
 * @version 1.5.8
 */

$course_filter = (bool) tutor_utils()->get_option('course_archive_filter');
$supported_filters = tutor_utils()->get_option('supported_course_filters', array());

get_header();
?>

<div class="<?php tutor_container_classes() ?>">
	<div class="container">
		<div class="row <?php echo apply_filters( 'larisdigital_row_class', '' ); ?>">

		<div id="content" class="main-content-inner <?php echo apply_filters( 'larisdigital_content_class', 'col-lg-8' ); ?>" role="main">
		
			<div class="row">

				<?php if ($course_filter && count($supported_filters)) : ?>

					<div class="<?php echo apply_filters( 'larisdigital_tutor_archive_filter_class', 'col-lg-3' ); ?>">
						<div class="tutor-course-filter-container">
							<?php tutor_load_template('course-filter.filters'); ?>
						</div>
					</div>

					<div class="<?php echo apply_filters( 'larisdigital_tutor_archive_content_class', 'col-lg-9' ); ?>">
						<div class="tutor-course-filter-loop-container">
							<?php tutor_load_template('archive-course-init'); ?>
						</div>
					</div>

				<?php else : ?>

					<div class="col-lg-12">
						<?php tutor_load_template('archive-course-init'); ?>
					</div>

				<?php endif; ?>

			</div>

		</div>
		
		<?php get_template_part( 'tutor/block-courses-sidebar' ); ?>
				
		</div>
	</div>
</div>

<?php 
get_footer();
