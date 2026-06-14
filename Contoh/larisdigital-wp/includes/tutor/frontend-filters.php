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
