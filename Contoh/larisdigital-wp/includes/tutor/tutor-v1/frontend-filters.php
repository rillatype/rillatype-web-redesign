<?php 
/**
 * Shop Filters, frontend only
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( !defined( 'TUTOR_VERSION') ) {
	return;
}

/**
 * Filter - Header - is it active?
 */
add_filter( 'larisdigital_header_is_active', 'larisdigital_tutor_filter_header_is_active', 5 );
function larisdigital_tutor_filter_header_is_active( $active ) {
	if ( is_singular('courses') ) {
		if ( larisdigital_theme_mod( 'larisdigital_tutor_course_header_hide' ) ) {
			return false;
		}
	}
	return $active;
}

/**
 * Filter - Sidebar Layout
 */
add_filter( 'larisdigital_sidebar_layout', 'larisdigital_tutor_archive_sidebar_layout', 25 );
function larisdigital_tutor_archive_sidebar_layout( $layout ) {
	if ( is_singular('courses') ) {
		if ( $layout_product = larisdigital_theme_mod( 'larisdigital_tutor_course_sidebar_layout' ) ) {
			$layout = $layout_product;
		}
	}
	elseif ( is_post_type_archive('courses') || is_tax('course-category') || is_tax('course-tag') ) {
		if ( $layout_shop = larisdigital_theme_mod( 'larisdigital_tutor_archive_sidebar_layout' ) ) {
			$layout = $layout_shop;
		}
	}
	return $layout;
}

/**
 * Filter - Sidebar Width
 */
add_filter( 'larisdigital_sidebar_width', 'larisdigital_tutor_archive_sidebar_width', 25 );
function larisdigital_tutor_archive_sidebar_width( $width ) {
	if ( is_singular('courses') ) {
		if ( $width_product = larisdigital_theme_mod( 'larisdigital_tutor_course_sidebar_width' ) ) {
			$width = $width_product;
		}
	}
	elseif ( is_post_type_archive('courses') || is_tax('course-category') || is_tax('course-tag') ) {
		if ( $width_shop = larisdigital_theme_mod( 'larisdigital_tutor_archive_sidebar_width' ) ) {
			$width = $width_shop;
		}
	}
	return $width;
}

/**
 * Filter - Content Width
 */
add_filter( 'larisdigital_content_width', 'larisdigital_tutor_archive_content_width', 25 );
function larisdigital_tutor_archive_content_width( $width ) {
	if ( is_singular('courses') ) {
		if ( $width_product = larisdigital_theme_mod( 'larisdigital_tutor_course_content_width' ) ) {
			$width = $width_product;
		}
	}
	elseif ( is_post_type_archive('courses') || is_tax('course-category') || is_tax('course-tag') ) {
		if ( $width_shop = larisdigital_theme_mod( 'larisdigital_tutor_archive_content_width' ) ) {
			$width = $width_shop;
		}
	}
	return $width;
}

/**
 * Filter - Header Title
 */
add_filter( 'larisdigital_header_title', 'larisdigital_tutor_filter_header_title' );
function larisdigital_tutor_filter_header_title( $output ) {
	if ( is_singular('courses') ) {
		if ( larisdigital_theme_mod( 'larisdigital_tutor_course_title4header' ) ) {
			$output = get_the_title();
		}
	}
	elseif ( is_singular('lesson') ) {
		if ( larisdigital_theme_mod( 'larisdigital_tutor_course_title4header' ) ) {
			$course_id = get_post_meta(get_the_ID(), '_tutor_course_id_for_lesson', true);
			$output = get_the_title($course_id);
		}
	}
	elseif ( is_singular('tutor_quiz') ) {
		if ( larisdigital_theme_mod( 'larisdigital_tutor_course_title4header' ) ) {
			$course = tutor_utils()->get_course_by_quiz(get_the_ID());
			$course_id = $course->ID;
			$output = get_the_title($course_id);
		}
	}
	elseif ( is_post_type_archive('courses') ) {
		if ( larisdigital_theme_mod( 'larisdigital_tutor_archive_title4header' ) ) {
			$output = larisdigital_theme_mod( 'larisdigital_tutor_archive_title' );
			if ( empty($output) ) {
				$output = esc_html__( 'Courses', 'larisdigital-wp' );
			}
		}
		else {
			$output = get_bloginfo('name');
		}
	}
	elseif( is_tax('course-category') || is_tax('course-tag') ) {
		if ( larisdigital_theme_mod( 'larisdigital_tutor_archive_title4header' ) ) {
			$term = get_queried_object();
			if ( $term && ! empty( $term->name ) ) {
				$output = $term->name;
			}
		}
	}
	return $output;
}

/**
 * Filter - Header Description
 */
add_filter( 'larisdigital_header_description', 'larisdigital_tutor_filter_header_description' );
function larisdigital_tutor_filter_header_description( $output ) {
	if ( is_singular('courses') ) {
		if ( larisdigital_theme_mod( 'larisdigital_tutor_course_title4header' ) ) {
			$output = '';
		}
	}
	elseif ( is_singular('lesson') || is_singular('tutor_quiz') ) {
		if ( larisdigital_theme_mod( 'larisdigital_tutor_course_title4header' ) ) {
			$output = '';
		}
	}
	elseif ( is_post_type_archive('courses') ) {
		if ( larisdigital_theme_mod( 'larisdigital_tutor_archive_title4header' ) ) {
			$output = larisdigital_theme_mod( 'larisdigital_tutor_archive_description' );
		}
		else {
			$output = get_bloginfo('description');
		}
	}
	elseif( is_tax('course-category') || is_tax('course-tag') ) {
		if ( larisdigital_theme_mod( 'larisdigital_tutor_archive_title4header' ) ) {
			$term = get_queried_object();
			if ( $term && ! empty( $term->description ) ) {
				$output = wpautop( wptexturize( $term->description ) );
			}
		}
	}
	return $output;
}

/**
 * Filter - Breadcrumb
 */
add_filter( 'larisdigital_breadcrumb_single_lesson_archive', '__return_false' );
add_filter( 'larisdigital_breadcrumb_single_tutor_quiz_archive', '__return_false' );

/**
 * Filter - Breadcrumb Lesson
 */
add_filter( 'larisdigital_breadcrumb_single_lesson_start', 'larisdigital_tutor_breadcrumb_single_lesson_start', 10, 4 );
function larisdigital_tutor_breadcrumb_single_lesson_start( $crumbs, $before, $after, $delimiter ) {
	$course_id = get_post_meta(get_the_ID(), '_tutor_course_id_for_lesson', true);
	if ( $course_id ) {
		$crumbs[] = $before . '<a href="' . get_permalink( $course_id ) . '"><span>' . get_the_title( $course_id) . '</span></a>' . $after . $delimiter;
	}
	return $crumbs;
}

/**
 * Filter - Breadcrumb Quiz
 */
add_filter( 'larisdigital_breadcrumb_single_tutor_quiz_start', 'larisdigital_tutor_breadcrumb_single_tutor_quiz_start', 10, 4 );
function larisdigital_tutor_breadcrumb_single_tutor_quiz_start( $crumbs, $before, $after, $delimiter ) {
	$course = tutor_utils()->get_course_by_quiz(get_the_ID());
	if ( isset($course->ID) && $course->ID ) {
		$course_id = $course->ID;
		$crumbs[] = $before . '<a href="' . get_permalink( $course_id ) . '"><span>' . get_the_title( $course_id) . '</span></a>' . $after . $delimiter;
	}
	return $crumbs;
}

/**
 * Filter - Course - Content Class
 */
add_filter( 'larisdigital_tutor_archive_content_class', 'larisdigital_tutor_archive_content_class' );
function larisdigital_tutor_archive_content_class( $classes ) {
	$layout = larisdigital_theme_mod( 'larisdigital_tutor_course_filter_layout' );
	$filter_width = larisdigital_theme_mod( 'larisdigital_tutor_course_filter_width' );
	if ( $filter_width > 6 ) {
		$filter_width = 6;
	}
	elseif ( $filter_width < 3 ) {
		$filter_width = 3;
	}
	$content_width = 12 - $filter_width;
	if ( $layout == 'right' ) {
		$classes = 'col-lg-'.$content_width.' order-2 order-lg-1';
	}
	else {
		$classes = 'col-lg-'.$content_width;
	}
	return $classes;
}

/**
 * Filter - Course - CTA Class
 */
add_filter( 'larisdigital_tutor_archive_filter_class', 'larisdigital_tutor_archive_filter_class' );
function larisdigital_tutor_archive_filter_class( $classes ) {
	$layout = larisdigital_theme_mod( 'larisdigital_tutor_course_filter_layout' );
	$filter_width = larisdigital_theme_mod( 'larisdigital_tutor_course_filter_width' );
	if ( $filter_width > 6 ) {
		$filter_width = 6;
	}
	elseif ( $filter_width < 3 ) {
		$filter_width = 3;
	}
	if ( $layout == 'right' ) {
		$classes = 'col-lg-'.$filter_width.' order-1 order-lg-2 mb-4';
	}
	else {
		$classes = 'col-lg-'.$filter_width;
	}
	return $classes;
}

/**
 * Filter - Course - Row Class
 */
add_filter( 'larisdigital_tutor_course_row_class', 'larisdigital_tutor_course_row_class' );
function larisdigital_tutor_course_row_class( $classes ) {
	$layout = larisdigital_theme_mod( 'larisdigital_tutor_course_layout' );
	if ( $layout == 'content-right' ) {
		$classes = 'justify-content-center justify-content-lg-end';
	}
	elseif ( $layout == 'content-top' ) {
		$classes = 'justify-content-center';
	}
	else {
		$classes = 'justify-content-center';
	}
	return $classes;
}

/**
 * Filter - Course - Content Class
 */
add_filter( 'larisdigital_tutor_course_content_class', 'larisdigital_tutor_course_content_class' );
function larisdigital_tutor_course_content_class( $classes ) {
	$layout = larisdigital_theme_mod( 'larisdigital_tutor_course_layout' );
	$cta_width = larisdigital_theme_mod( 'larisdigital_tutor_course_cta_width' );
	if ( $cta_width > 6 ) {
		$cta_width = 6;
	}
	elseif ( $cta_width < 3 ) {
		$cta_width = 4;
	}
	$content_width = 12 - $cta_width;
	if ( $layout == 'content-right' ) {
		$classes = 'col-lg-'.$content_width.' col-md-12 order-1 order-lg-2';
	}
	elseif ( $layout == 'content-top' ) {
		$classes = 'col-lg-12 col-md-12';
	}
	else {
		$classes = 'col-lg-'.$content_width.' col-md-12';
	}
	return $classes;
}

/**
 * Filter - Course - CTA Class
 */
add_filter( 'larisdigital_tutor_course_cta_class', 'larisdigital_tutor_course_cta_class' );
function larisdigital_tutor_course_cta_class( $classes ) {
	$layout = larisdigital_theme_mod( 'larisdigital_tutor_course_layout' );
	$cta_width = larisdigital_theme_mod( 'larisdigital_tutor_course_cta_width' );
	if ( $cta_width > 6 ) {
		$cta_width = 6;
	}
	elseif ( $cta_width < 3 ) {
		$cta_width = 4;
	}
	if ( $layout == 'content-right' ) {
		$classes = 'col-lg-'.$cta_width.' col-md-6 col-sm-8 order-2 order-lg-1 mb-4';
	}
	elseif ( $layout == 'content-top' ) {
		$classes = 'col-lg-'.$cta_width.' col-md-6 col-sm-8';
	}
	else {
		$classes = 'col-lg-'.$cta_width.' col-md-6 col-sm-8';
	}
	return $classes;
}

add_filter( 'supported_course_filters', 'larisdigital_tutor_supported_course_filters' );
function larisdigital_tutor_supported_course_filters( $course_filters ) {
	if ( !empty($course_filters) ) {
		foreach ( $course_filters as $key => $value ) {
			if ( ! $value ) {
				unset( $course_filters[$key] );
			}
		}
	}
	return $course_filters;
}

// add_action( 'tutor_course/archive/before_loop', 'larisdigital_tutor_archive_heading', 5 );
// function larisdigital_tutor_archive_heading() {
// 	$heading = false;
// 	$header_is_active = apply_filters( 'larisdigital_header_is_active', true );
// 	if ( $header_is_active ) {
// 		if ( !larisdigital_theme_mod( 'larisdigital_tutor_archive_title4header' ) ) {
// 			$heading = true;
// 		}
// 	}
// 	else {
// 		$heading = true;
// 	}
// 	if ( !$heading ) {
// 		return;
// 	}
// 	if ( is_tax() ) {
// 		$header_title = apply_filters( 'larisdigital_header_title', '' );
// 		$header_description = apply_filters( 'larisdigital_header_description', '' );
// 	}
// 	else {
// 		$header_title = larisdigital_theme_mod( 'larisdigital_tutor_archive_title' );
// 		if ( empty($header_title) ) {
// 			$header_title = esc_html__( 'Courses', 'larisdigital-wp' );
// 		}
// 		$header_description = larisdigital_theme_mod( 'larisdigital_tutor_archive_description' );
// 	}
// 	if ( $header_title ) {
// 		echo '<h1 class="page-title h2">';
// 		echo wp_kses_post( $header_title );
// 		echo '</h1>';
// 	}
// 	if ( $header_description ) {
// 		echo '<p class="page-description">';
// 		echo wp_kses_post( $header_description );
// 		echo '</p>';
// 	}
// }
