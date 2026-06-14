<?php
/**
 * EDD - Setup
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( !defined( 'TUTOR_VERSION') ) {
	return;
}

/**
 * Register widgetized area
 */
add_action( 'widgets_init', 'larisdigital_courses_widgets_init' );
function larisdigital_courses_widgets_init() {

	register_sidebar( array(
		'name'          => esc_html__( 'Courses Page', 'larisdigital-wp' ),
		'description'   => sprintf( esc_html__( 'This widget area will be displayed on %s when it is available on current layout.', 'larisdigital-wp' ), esc_html__( 'Courses Page', 'larisdigital-wp' ) ),
		'id'            => 'sidebar-courses',
		'before_widget' => '<aside id="%1$s" class="sidebar-widget widget %2$s card"><div class="card-body">',
		'after_widget'  => '</div></aside>',
		'before_title'  => '<h4 class="widget-title card-header">',
		'after_title'   => '</h4>',
	) );

}
