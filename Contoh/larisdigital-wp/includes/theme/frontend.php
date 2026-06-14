<?php
/**
 * Theme Functionality, frontend only
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Meta Responsive
 */
add_action( 'wp_head', 'larisdigital_wp_head_responsive', 1);
function larisdigital_wp_head_responsive() {
?>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<?php
}

/**
 * Browser Theme Color
 */
add_action( 'wp_head', 'larisdigital_wp_head_browser_theme_color', 5 );
function larisdigital_wp_head_browser_theme_color() {
	$theme_color = larisdigital_theme_mod('larisdigital_browser_theme_color');
	if ( ! empty( $theme_color ) ) {
?>
<meta name="theme-color" content="<?php echo esc_attr($theme_color); ?>">
<meta name="msapplication-navbutton-color" content="<?php echo esc_attr($theme_color); ?>">
<?php
	}
	$safari_uic_hide = larisdigital_theme_mod('larisdigital_browser_safari_uic_hide');
	if ( ! empty( $safari_uic_hide ) ) {
?>
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<?php
	}
}

/**
 * Style Output - SVG
 */
add_filter( 'larisdigital_style', 'larisdigital_style_svg_css', 5 );
function larisdigital_style_svg_css( $style ) {
	$style .= 'svg { width: 1em; height: 1em; fill: currentColor; display: inline-block; vertical-align: middle; margin-top: -2px; }'."\n";
	return $style;
}

/**
 * Body class - LTR
 */
add_filter( 'body_class', 'larisdigital_body_class' );
function larisdigital_body_class( $classes ) {
	if ( !is_rtl() ) {
		$classes[] = 'ltr';
	}
	return $classes;
}

/**
 * Post class - Entry
 */
add_filter( 'post_class', 'larisdigital_post_class' );
function larisdigital_post_class( $classes ) {
	if ( in_array( 'hentry', $classes ) ) {
		$classes = array_diff( $classes, array( 'hentry' ) );
		$classes[] = 'entry';
	}
	return $classes;
}

/**
 * BootStrap - Table on Content
 */
add_filter( 'the_content', 'larisdigital_filter_the_content' );
function larisdigital_filter_the_content( $content ) {
	$content = str_replace( '<table>', '<table class="table table-bordered table-responsive-md">', $content );
	return $content;
}

/**
 * Bootstrap - Table on Comment
 */
add_filter( 'comment_text', 'larisdigital_filter_comment_text' );
function larisdigital_filter_comment_text( $content ) {
	$content = str_replace( '<table>', '<table class="table table-bordered table-responsive-md">', $content );
	return $content;
}

/**
 * Bootstrap - More Link Button
 */
add_filter( 'the_content_more_link', 'larisdigital_filter_content_more_link' );
function larisdigital_filter_content_more_link( $content ) {
	$content = '<p class="entry-more-link">'.str_replace( 'more-link', 'more-link btn btn-primary', $content ).'</p>';
	return $content;
}

/**
 * Bootstrap - Password Form on Content
 */
add_filter( 'the_password_form', 'larisdigital_the_password_form' );
function larisdigital_the_password_form( $output ) {
	preg_match_all('/\d+/', $output, $matches);
	$id = $matches[0][0];
	$label = 'pwbox-' . $id;
	$output = '<p>' . __( 'This content is password protected. To view it please enter your password below:', 'larisdigital-wp' ) . '</p>' .
		'<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" class="form-inline post-password-form" method="post">' . 
		'<div class="input-group mb-3">' . 
		'<input name="post_password" id="' . $label . '" type="password" size="20" class="form-control" placeholder="'.esc_html__( 'Password', 'larisdigital-wp'  ).'" aria-label="'.esc_html__( 'Password', 'larisdigital-wp'  ).'"/>' . 
		'<span class="input-group-append"><button class="btn btn-secondary" type="submit">' . esc_attr__( 'Submit', 'larisdigital-wp' ) . '</button></span>' . 
		'</div>' . 
		'</form>';
	return $output;
}

/**
 * Bootstrap - Calendar Widget
 */
add_filter( 'get_calendar', 'larisdigital_filter_get_calendar' );
function larisdigital_filter_get_calendar( $content ) {
	$content = str_replace( '<table ', '<table class="table table-striped table-bordered" ', $content );
	return $content;
}

/**
 * Bootstrap - Text Widget
 */
add_filter( 'widget_text', 'larisdigital_filter_widget_text' );
function larisdigital_filter_widget_text( $content ) {
	$content = str_replace( '<select', '<select class="form-control" ', $content );
	return $content;
}

/**
 * Bootstrap - Categories Dropdown Widget
 */
add_filter( 'widget_categories_dropdown_args', 'larisdigital_filter_widget_categories_dropdown_args' );
function larisdigital_filter_widget_categories_dropdown_args( $args ) {
	$args['class'] = 'postform form-control';
	return $args;
}

/**
 * Bootstrap - Search Form
 */
add_filter( 'get_search_form', 'larisdigital_get_search_form' );
function larisdigital_get_search_form( $form ) {
	$form = '<form role="search" method="get" class="search-form" action="' . esc_url( home_url( '/' ) ) . '">
		<div class="input-group">
			<input type="search" class="form-control search-field" placeholder="' . esc_attr__( 'Search &hellip;', 'larisdigital-wp' ) . '" value="' . get_search_query() . '" name="s" aria-label="' . esc_attr__( 'Search for:', 'larisdigital-wp' ) . '" />
			<span class="input-group-append">
				<button type="submit" class="btn btn-secondary search-submit"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"/></svg></button>
			</span>
		</div>
	</form>';
	return $form;
}

/**
 * Content - Remove prepend_attachment, switch to content-attachment.php 
 */
remove_filter( 'the_content', 'prepend_attachment' );

/**
 * Excerpt - Simple Excerpt More
 */
add_action( 'excerpt_more', 'larisdigital_excerpt_more' );
function larisdigital_excerpt_more( $html ) {
	return ' &hellip;';
}

/**
 * Style Output - Custom Header Image on Site Header
 */
add_filter( 'larisdigital_style', 'larisdigital_style_custom_header_css' );
function larisdigital_style_custom_header_css( $style ) {
	if ( ! apply_filters( 'larisdigital_header_is_active', true ) ) {
		return $style;
	}
	$image = get_header_image();
	if ( $image ) {
		$style = $style.'.site-header{ background-image:url('.esc_url($image).'); background-size: cover; background-position: center; background-repeat: no-repeat; }';
	}
	return $style;
}

/**
 * Style Output - Custom Navigation Brand Image Height
 */
add_filter( 'larisdigital_style', 'larisdigital_style_navigation_brand_image_css' );
function larisdigital_style_navigation_brand_image_css( $style ) {
	if ( ! apply_filters( 'larisdigital_navigation_is_active', true ) ) {
		return $style;
	}
	$height = larisdigital_theme_mod('larisdigital_navigation_brand_image_height');
	$height = absint( $height );
	if ( $height > 30 ) {
		$margin = ( $height - 30 ) / 2;
		$style = $style.'@media (min-width: 992px) { .site-navigation-brand{ height:40px; } .site-navigation-brand img { height: '.$height.'px; margin-top: -'.$margin.'px; } .site-navigation-small .site-navigation-brand img { height: 30px; margin-top: 0; } }';
	}
	return $style;
}

/**
 * Comment Forms Field - Hide URL or Reverse Textarea Position
 */
add_filter( 'comment_form_fields', 'larisdigital_comments_form_fields', 99 );
function larisdigital_comments_form_fields( $fields ) {
	if ( larisdigital_theme_mod('larisdigital_comments_url_hide') && isset( $fields['url'] ) ) {
		unset( $fields['url'] );
	}
	if ( larisdigital_theme_mod('larisdigital_comments_textarea_reverse') && isset( $fields['comment'] ) ) {
		$comment_field = $fields['comment'];
		unset( $fields['comment'] );
		$fields['comment'] = $comment_field;
	}
	return $fields;
}

/**
 * Admin Bar - Remove Default Admin Bar Styling
 */
add_action('get_header', 'larisdigital_remove_admin_bar_bump_cb');
function larisdigital_remove_admin_bar_bump_cb() {
	remove_action( 'wp_head', '_admin_bar_bump_cb' );
}
add_theme_support( 'admin-bar', array( 'callback' => '__return_false' ) );

/**
 * Style Output - Admin Bar Styling
 */
add_filter( 'larisdigital_style', 'larisdigital_style_admin_bar_css', 5 );
function larisdigital_style_admin_bar_css( $style ) {
	if ( is_admin_bar_showing() ) {
		$style .= 'body.admin-bar{margin-top:32px!important}@media (max-width:782px){html #wpadminbar #wp-admin-bar-wp-logo>.ab-item .ab-icon,html #wpadminbar .quicklinks .ab-empty-item,html #wpadminbar .quicklinks>ul>li>a{height:32px!important;line-height:32px!important}html #wpadminbar{height:32px!important}html #wpadminbar .ab-icon{font-size:20px!important}html #wpadminbar #wp-admin-bar-wp-logo>.ab-item .ab-icon:before{top:0;font-size:20px!important}html #wpadminbar #wp-admin-bar-customize>.ab-item:before,html #wpadminbar #wp-admin-bar-edit>.ab-item:before,html #wpadminbar #wp-admin-bar-my-account>.ab-item:before,html #wpadminbar #wp-admin-bar-my-sites>.ab-item:before,html #wpadminbar #wp-admin-bar-site-name>.ab-item:before,#wpadminbar #wp-admin-bar-new_draft > .ab-item::before{font-size:20px!important}html #wpadminbar #wp-admin-bar-comments .ab-icon:before,html #wpadminbar #wp-admin-bar-new-content .ab-icon:before{height:32px!important;font-size:20px!important;line-height:32px!important}html #wpadminbar .quicklinks li#wp-admin-bar-my-account.with-avatar>a img{position:absolute!important;top:10px!important;right:10px!important;width:16px!important;height:16px!important}}@media (max-width:600px){html #wpadminbar{position:fixed}}'."\n";
	}
	return $style;
}

/**
 * Change Comment Reply Text
 */
add_filter( 'comment_reply_link_args', 'larisdigital_comment_reply_link_args' );
function larisdigital_comment_reply_link_args( $args ) {
	if ( $reply_text = larisdigital_theme_mod( 'larisdigital_comments_reply_text' ) ) {
		$args['reply_text'] = $reply_text;
	}
	if ( $login_text = larisdigital_theme_mod( 'larisdigital_comments_login_text' ) ) {
		$args['login_text'] = $login_text;
	}
	return $args;
}

/**
 * Load Template - Top Bar
 */
add_action( 'larisdigital_site_before', 'larisdigital_load_template_topbar', 3 );
function larisdigital_load_template_topbar() {
	$template = apply_filters( 'larisdigital_topbar_template', 'block-topbar' );
	get_template_part( $template );
}

/**
 * Load Template - Header Wrapper Start
 */
add_action( 'larisdigital_site_before', 'larisdigital_load_template_header_wrapper_start', 4 );
function larisdigital_load_template_header_wrapper_start() {
	get_template_part( 'block-header-wrapper-start' );
}

/**
 * Load Template - Navigation
 */
add_action( 'larisdigital_site_before', 'larisdigital_load_template_navigation', 5 );
function larisdigital_load_template_navigation() {
	$template = apply_filters( 'larisdigital_navigation_template', 'block-navigation' );
	get_template_part( $template );
}

/**
 * Load Template - Header
 */
add_action( 'larisdigital_site_before', 'larisdigital_load_template_header', 7 );
function larisdigital_load_template_header() {
	$template = apply_filters( 'larisdigital_header_template', 'block-header' );
	get_template_part( $template );
}

/**
 * Load Template - Header Image
 */
add_action( 'larisdigital_site_before', 'larisdigital_load_template_header_image', 7 );
function larisdigital_load_template_header_image() {
	$template = apply_filters( 'larisdigital_header_image_template', 'block-header-image' );
	get_template_part( $template );
}

/**
 * Load Template - Header Wrapper End
 */
add_action( 'larisdigital_site_before', 'larisdigital_load_template_header_wrapper_end', 8 );
function larisdigital_load_template_header_wrapper_end() {
	get_template_part( 'block-header-wrapper-end' );
}

/**
 * Load Template - Navigation Quicknav - Search Form
 */
add_action( 'larisdigital_navigation_quicknav', 'larisdigital_load_template_navigation_quicknav_search' );
function larisdigital_load_template_navigation_quicknav_search() {
	$template = apply_filters( 'larisdigital_navigation_quicknav_search_template', 'block-quicknav-search' );
	get_template_part( $template );
}

/**
 * Load Template - Offcanvas Navigation
 */
add_action( 'wp_footer', 'larisdigital_load_template_navigation_offcanvas', 99 );
function larisdigital_load_template_navigation_offcanvas() {
	$template = apply_filters( 'larisdigital_navigation_offcanvas_template', 'block-navigation-offcanvas' );
	get_template_part( $template );
}

/**
 * Load Template - Breadcrumb
 */
add_action( 'larisdigital_site_before', 'larisdigital_load_template_breadcrumb', 15 );
function larisdigital_load_template_breadcrumb() {
	$template = apply_filters( 'larisdigital_site_breadcrumbs_template', 'block-breadcrumb' );
	get_template_part( $template );
}

/**
 * Load Template - Footer Widgets
 */
add_action( 'larisdigital_site_after', 'larisdigital_load_template_footer_widgets', 7 );
function larisdigital_load_template_footer_widgets() {
	$template = apply_filters( 'larisdigital_site_footer_widgets_template', 'block-footer-widgets' );
	get_template_part( $template );
}

/**
 * Load Template - Footer
 */
add_action( 'larisdigital_site_after', 'larisdigital_load_template_footer', 10 );
function larisdigital_load_template_footer() {
	$template = apply_filters( 'larisdigital_site_footer_template', 'block-footer' );
	get_template_part( $template );
}

/**
 * Load Template - Back To Top
 */
add_action( 'wp_footer', 'larisdigital_load_template_backtotop', 99 );
function larisdigital_load_template_backtotop() {
	get_template_part( 'block-backtotop' );
}
