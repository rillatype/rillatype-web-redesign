<?php
/**
 * Theme Setup
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Setup WordPress Features
 */
add_action( 'after_setup_theme', 'larisdigital_setup_theme' );
function larisdigital_setup_theme() {

    // This theme styles the visual editor with editor-style.css to match the theme style.
    add_editor_style();

    if ( function_exists( 'add_theme_support' ) ) {

		/**
		 * Add HTML5 support
		*/
		add_theme_support( 'html5', 
			array( 
				'comment-list', 
				'comment-form', 
				'search-form', 
				'gallery', 
				'caption', 
				'style', 
				'script' 
			) 
		);
		
		/**
		 * Add title tag support
		*/
		add_theme_support( 'title-tag' );
		
		/**
		 * Add default posts and comments RSS feed links to head
		*/
		add_theme_support( 'automatic-feed-links' );
		
		/**
		 * Enable support for Post Thumbnails on posts and pages
		*/
		add_theme_support( 'post-thumbnails' );

		/**
		 * Setup Post Thumbnail image size.
		*/
		$post_thumbnail_width  = apply_filters( 'larisdigital_image_post_thumbnail_width', 728 );
		$post_thumbnail_height = apply_filters( 'larisdigital_image_post_thumbnail_height', 410 );
		set_post_thumbnail_size( $post_thumbnail_width, $post_thumbnail_height, true ); 

		/**
		 * Setup Medium Thumbnail image size.
		*/
		$medium_thumbnail_width  = apply_filters( 'larisdigital_image_medium_thumbnail_width', 348 );
		$medium_thumbnail_height = apply_filters( 'larisdigital_image_medium_thumbnail_height', 196 );
		add_image_size( 'medium-thumbnail', $medium_thumbnail_width, $medium_thumbnail_height, true );
		
		/**
		 * Setup the WordPress core custom background feature.
		*/
		add_theme_support( 'custom-background', apply_filters( 'larisdigital_custom_background_args', array(
		) ) );
	
		/**
		 * Setup the WordPress core custom header feature.
		*/
		$custom_header_width  = apply_filters( 'larisdigital_image_custom_header_width', 1024 );
		$custom_header_height = apply_filters( 'larisdigital_image_custom_header_height', 400 );
		add_image_size( 'custom-header', $custom_header_width,$custom_header_height, true );
		add_theme_support( 'custom-header', apply_filters( 'larisdigital_custom_header_args', array(
			'default-image' => get_template_directory_uri() . '/assets/img/header.jpg',
			'width' => $custom_header_width,
			'height' => $custom_header_height,
			'flex-width' => true,
			'flex-height' => true,
			'header-text' => false,
		) ) );
	
    }

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	*/
	load_theme_textdomain( 'larisdigital-wp', get_template_directory() . '/languages' );

	/**
	 * This theme uses wp_nav_menu() in three location.
	*/ 
    register_nav_menus( array(
        'site-topbar-menu'      => esc_html__( 'Site Top Bar Menu', 'larisdigital-wp' ),
        'site-navigation-menu'  => esc_html__( 'Site Navigation Menu', 'larisdigital-wp' ),
        'site-footer-menu'      => esc_html__( 'Site Footer Menu', 'larisdigital-wp' ),
    ) );

}

/**
 * Register widgetized area and update sidebar with default widgets
 */
add_action( 'widgets_init', 'larisdigital_widgets_init' );
function larisdigital_widgets_init() {

	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'larisdigital-wp' ),
		'description'   => sprintf( esc_html__( 'This widget area will be displayed on %s when it is available on current layout.', 'larisdigital-wp' ), esc_html__( 'Blog Page', 'larisdigital-wp' ) ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="sidebar-widget widget %2$s card"><div class="card-body">',
		'after_widget'  => '</div></aside>',
		'before_title'  => '<h4 class="widget-title card-header">',
		'after_title'   => '</h4>',
	) );

	for ( $i = 1; $i <= 4 ; $i++ ) { 
		register_sidebar( array(
			'name'          => sprintf( esc_html__( 'Footer #%s', 'larisdigital-wp' ), $i ),
			'description'   => sprintf( esc_html__( 'This widget area will be displayed on %s when it is available on current layout.', 'larisdigital-wp' ), esc_html__( 'Site Footer Widgets', 'larisdigital-wp' ) ),
			'id'            => 'footer-'.$i,
			'before_widget' => '<aside id="%1$s" class="footer-widget widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		) );
	}

}

/**
 * Enqueue styles
 */
add_action( 'wp_enqueue_scripts', 'larisdigital_enqueue_styles', 5 );
function larisdigital_enqueue_styles() {

	wp_enqueue_style( 'bootstrap4', get_template_directory_uri() . '/assets/lib/bootstrap4/css/bootstrap.min.css', array(), LARISDIGITAL_BOOTSTRAP_VERSION );
	
	$navigation = apply_filters( 'larisdigital_navigation_is_active', true );
	$navigation_menu = apply_filters( 'larisdigital_navigation_menu_is_active', false );

	if ( $navigation && $navigation_menu ) {
		wp_enqueue_style( 'mmenu', get_template_directory_uri() . '/assets/lib/mmenu/jquery.mmenu.tp.css', array(), '6.1.8' );
	}

}

/**
 * Enqueue parent theme style, priority 15, late init
 */
add_action( 'wp_enqueue_scripts', 'larisdigital_enqueue_style_parent_theme', 15 );
function larisdigital_enqueue_style_parent_theme() {

	/* Load parent stylesheet. */
	wp_enqueue_style( 'larisdigital', trailingslashit( get_template_directory_uri() ) . 'style.css', array(), LARISDIGITAL_THEME_VERSION );

}

/**
 * Enqueue child theme style, priority 15, late init
 */
add_action( 'wp_enqueue_scripts', 'larisdigital_enqueue_style_child_theme', 17 );
function larisdigital_enqueue_style_child_theme() {

	/* Load child stylesheet if child theme is active. */
	if ( is_child_theme() ) {
		wp_enqueue_style( 'larisdigital-child', get_stylesheet_uri(), array(), wp_get_theme()->get('Version') );
	}

}

if ( function_exists('larisdigitalwp_child_enqueue_styles') ) {
	remove_action(  'wp_enqueue_scripts', 'larisdigitalwp_child_enqueue_styles' );
}

/**
 * Enqueue scripts 
 */
add_action( 'wp_enqueue_scripts', 'larisdigital_enqueue_scripts' );
function larisdigital_enqueue_scripts() {

	wp_enqueue_script( 'bootstrap4', get_template_directory_uri().'/assets/lib/bootstrap4/js/bootstrap.min.js', array('jquery'), LARISDIGITAL_BOOTSTRAP_VERSION, true );

	$navigation = apply_filters( 'larisdigital_navigation_is_active', true );
	$navigation_sticky = apply_filters( 'larisdigital_navigation_sticky_is_active', true );
	$navigation_menu = apply_filters( 'larisdigital_navigation_menu_is_active', false );

	if ( $navigation && $navigation_sticky ) {
		wp_enqueue_script( 'sticky', get_template_directory_uri().'/assets/lib/sticky/jquery.sticky.min.js', array('jquery'), '1.0.4', true );
	}

	if ( $navigation && $navigation_menu ) {
		wp_enqueue_script( 'mmenu', get_template_directory_uri().'/assets/lib/mmenu/jquery.mmenu.min.js', array('jquery'), '6.1.8', true );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'larisdigital', get_template_directory_uri() . '/assets/js/script.min.js', array('jquery'), LARISDIGITAL_THEME_VERSION, true );

}

/**
 * Output Custom CSS
 */
add_action( 'wp_head', 'larisdigital_output_style', 25 );
function larisdigital_output_style() {
	$style = apply_filters( 'larisdigital_style', '' );
	if ( $style ) {
		echo '<style type="text/css">'."\n".$style."\n".'</style>'."\n";
	}
}

/**
 * Output Custom Javascript
 */
add_action( 'wp_footer', 'larisdigital_output_script', 99 );
function larisdigital_output_script() {
	$script = apply_filters( 'larisdigital_script', '' );
	if ( $script ) {
		echo '<script type="text/javascript">'."\n".$script."\n".'</script>'."\n";
	}
}
