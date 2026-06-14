<?php
/**
 * Shop Post Type
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( !defined( 'TUTOR_VERSION') ) {
	return;
}

add_filter( 'body_class', 'larisdigital_tutor_body_class' );
function larisdigital_tutor_body_class( $classes ) {
	$classes[] = 'ld-tutor-v2';
	return $classes;
}

if ( larisdigital_theme_mod('larisdigital_tutor_archive_rating_disable') ) {
	remove_action('tutor_course/loop/rating', 'tutor_course_loop_rating');
}
if ( larisdigital_theme_mod('larisdigital_tutor_archive_title_disable') ) {
	remove_action('tutor_course/loop/title', 'tutor_course_loop_title');
}
if ( larisdigital_theme_mod('larisdigital_tutor_archive_meta_disable') ) {
	remove_action('tutor_course/loop/meta', 'tutor_course_loop_meta');
}
if ( larisdigital_theme_mod('larisdigital_tutor_archive_footer_disable') ) {
	remove_action('tutor_course/loop/footer', 'tutor_course_loop_footer');
}

add_action( 'wp', 'larisdigital_tutor_setup_archive_page' );
function larisdigital_tutor_setup_archive_page() {
	if ( larisdigital_theme_mod('larisdigital_tutor_archive_filter_bar_disable') ) {
		remove_action('tutor_course/archive/before_loop', 'tutor_course_archive_filter_bar');
	}
	if ( larisdigital_theme_mod('larisdigital_tutor_archive_rating_disable') ) {
		remove_action('tutor_course/loop/rating', 'tutor_course_loop_rating');
	}
	if ( larisdigital_theme_mod('larisdigital_tutor_archive_title_disable') ) {
		remove_action('tutor_course/loop/title', 'tutor_course_loop_title');
	}
	if ( larisdigital_theme_mod('larisdigital_tutor_archive_meta_disable') ) {
		remove_action('tutor_course/loop/meta', 'tutor_course_loop_meta');
	}
	if ( larisdigital_theme_mod('larisdigital_tutor_archive_footer_disable') ) {
		remove_action('tutor_course/loop/footer', 'tutor_course_loop_footer');
	}
}

add_filter( 'larisdigital_style', 'larisdigital_tutor_custom_style' );
function larisdigital_tutor_custom_style( $style ) {
	if ( 
		larisdigital_theme_mod('larisdigital_tutor_archive_rating_disable') && 
		larisdigital_theme_mod('larisdigital_tutor_archive_title_disable') && 
		larisdigital_theme_mod('larisdigital_tutor_archive_meta_disable') 
	) {
		$style = $style.'.tutor-loop-course-container, .tutor-course-card .tutor-card-body { padding-top:0; padding-bottom: 0; }';
	}
	$header_is_active = apply_filters( 'larisdigital_header_is_active', true );
	if ( $header_is_active ) {
		if ( larisdigital_theme_mod( 'larisdigital_tutor_course_title4header' ) ) {
			$style = $style.'.single-courses .tutor-course-header-h1 { display: none; }';
		}
	}
	return $style;
}
