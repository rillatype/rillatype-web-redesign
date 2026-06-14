<?php
/**
 * Theme Filters, frontend only
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Filter - Top Bar - is it active?
 */
add_filter( 'larisdigital_topbar_is_active', 'larisdigital_filter_topbar_is_active', 5 );
function larisdigital_filter_topbar_is_active( $active ) {
	if ( larisdigital_theme_mod( 'larisdigital_topbar_hide' ) ) {
		$active = false;
	}
	return $active;
}

/**
 * Filter - Navigation - is it active?
 */
add_filter( 'larisdigital_navigation_is_active', 'larisdigital_filter_navigation_is_active', 5 );
function larisdigital_filter_navigation_is_active( $active ) {
	if ( larisdigital_theme_mod( 'larisdigital_navigation_hide' ) ) {
		$active = false;
	}
	return $active;
}

/**
 * Filter - Sticky Navigation - is it active?
 */
add_filter( 'larisdigital_navigation_sticky_is_active', 'larisdigital_filter_navigation_sticky_is_active', 5 );
function larisdigital_filter_navigation_sticky_is_active( $active ) {
	if ( 'no' == larisdigital_theme_mod( 'larisdigital_navigation_sticky' ) ) {
		$active = false;
	}
	return $active;
}

/**
 * Filter - Navigation Menu - is it active?
 */
add_filter( 'larisdigital_navigation_menu_is_active', 'larisdigital_filter_navigation_menu_is_active', 5 );
function larisdigital_filter_navigation_menu_is_active( $active ) {
	if ( has_nav_menu( 'site-navigation-menu' ) ) {
		$active = true;
	}
	return $active;
}

/**
 * Filter - Navigation Quicknav - Search Form - is it active?
 */
add_filter( 'larisdigital_navigation_quicknav_is_active', 'larisdigital_filter_navigation_quicknav_is_active', 5 );
function larisdigital_filter_navigation_quicknav_is_active( $active ) {
	if ( larisdigital_theme_mod( 'larisdigital_navigation_quicknav_search' ) ) {
		$active = true;
	}
	return $active;
}

/**
 * Filter - Header - is it active?
 */
add_filter( 'larisdigital_header_is_active', 'larisdigital_filter_header_is_active', 5 );
function larisdigital_filter_header_is_active( $active ) {
	if ( larisdigital_theme_mod( 'larisdigital_header_hide' ) ) {
		return false;
	}
	if ( is_singular('post') ) {
		if ( larisdigital_theme_mod( 'larisdigital_post_header_hide' ) ) {
			return false;
		}
	}
	elseif ( is_page() ) {
		if ( larisdigital_theme_mod( 'larisdigital_page_header_hide' ) ) {
			return false;
		}
	}
	elseif ( is_attachment() ) {
		if ( larisdigital_theme_mod( 'larisdigital_attachment_header_hide' ) ) {
			return false;
		}
	}
	return $active;
}

/**
 * Filter - Header Title - Default Text
 */
add_filter( 'larisdigital_header_title', 'larisdigital_filter_header_title', 5 );
function larisdigital_filter_header_title( $output ) {
	if ( $text = larisdigital_theme_mod( 'larisdigital_header_title_text' ) ) {
		$output = trim( $text );
	}
	$title_blog = larisdigital_theme_mod( 'larisdigital_blog_title4header' );
	if ( is_category() && $title_blog ) {
		$output = single_cat_title( '', false );
	} 
	elseif ( is_tag() && $title_blog ) {
		$output = single_tag_title( '', false );
	}
	elseif ( is_tax() && $title_blog ) {
		$output = single_term_title( '', false );
	}
	elseif ( is_author() && $title_blog ) {
		$author = get_queried_object();
		$output = $author->display_name;
	}
	elseif ( is_day() && $title_blog ) {
		$output = get_the_time( get_option( 'date_format' ) );
	} 
	elseif ( is_month() && $title_blog ) {
		$output = get_the_time( 'F Y' );
	} 
	elseif ( is_year() && $title_blog ) {
		$output = get_the_time( 'Y' );
	}
	elseif ( is_post_type_archive() && $title_blog ) {
		$post_type = get_post_type_object( get_post_type() );
		if ( $post_type ) {
			$output = $post_type->labels->singular_name;
		}
	} 
	elseif ( is_search() && $title_blog ) {
		$output = sprintf( esc_html__( 'Search results for "%s"', 'larisdigital-wp' ), get_search_query() );
	} 
	elseif ( is_singular() ) {
		$post_type = get_post_type();
		if ( larisdigital_theme_mod( "larisdigital_{$post_type}_title4header" ) ) {
			$output = get_the_title();
		}
	}
	return $output;
}

/**
 * Filter - Header Description - Default Text
 */
add_filter( 'larisdigital_header_description', 'larisdigital_filter_header_description', 5 );
function larisdigital_filter_header_description( $output ) {
	if ( $description = larisdigital_theme_mod( 'larisdigital_header_description_text' ) ) {
		$output = trim( $description );
	}
	$title_blog = larisdigital_theme_mod( 'larisdigital_blog_title4header' );
	if ( is_category() && $title_blog ) {
		$term = get_queried_object();
		$output = $term->description;
	} 
	elseif ( is_tag() && $title_blog ) {
		$term = get_queried_object();
		$output = $term->description;
	}
	elseif ( is_tax() && $title_blog ) {
		$term = get_queried_object();
		$output = $term->description;
	}
	elseif ( is_author() && $title_blog ) {
		$author = get_queried_object();
		$output = $author->description;
	}
	elseif ( is_day() && $title_blog ) {
		$output = '';
	} 
	elseif ( is_month() && $title_blog ) {
		$output = '';
	} 
	elseif ( is_year() && $title_blog ) {
		$output = '';
	}
	elseif ( is_post_type_archive() && $title_blog ) {
		$post_type = get_post_type_object( get_post_type() );
		if ( $post_type ) {
			$output = '';
		}
	} 
	elseif ( is_search() && $title_blog ) {
		$output = '';
	} 
	elseif ( is_singular() ) {
		$post_type = get_post_type();
		if ( larisdigital_theme_mod( "larisdigital_{$post_type}_title4header" ) ) {
			$output = '';
		}
	}
	return $output;
}

/**
 * Filter - Header Image - is it active?
 */
add_filter( 'larisdigital_header_image_is_active', 'larisdigital_filter_header_image_is_active', 5 );
function larisdigital_filter_header_image_is_active( $active ) {
	if ( larisdigital_theme_mod( 'larisdigital_header_hide' ) && larisdigital_theme_mod( 'larisdigital_header_image' ) ) {
		$active = true;
	}
	return $active;
}

/**
 * Filter - Breadcrumb - is it active?
 */
add_filter( 'larisdigital_breadcrumb_is_active', 'larisdigital_filter_breadcrumb_is_active', 5 );
function larisdigital_filter_breadcrumb_is_active( $active ) {
	if ( larisdigital_theme_mod( 'larisdigital_breadcrumb_hide' ) ) {
		$active = false;
	}
	else {
		if ( larisdigital_theme_mod( 'larisdigital_homepage_breadcrumb_hide' ) ) {
			if ( is_front_page() ) {
				$active = false;
			}
		}
	}
	return $active;
}

/**
 * Filter - Sidebar - is it active?
 */
add_filter( 'larisdigital_sidebar_is_active', 'larisdigital_filter_sidebar_is_active', 5 );
function larisdigital_filter_sidebar_is_active( $active ) {
	$layout = larisdigital_get_sidebar_layout();
	if ( 'none' == $layout ) {
		$active = false;
	}
	elseif ( 'left' == $layout || 'right' == $layout ) {
		$active = true;
	}
	return $active;
}

/**
 * Filter - Sidebar - Content Class
 */
add_filter( 'larisdigital_content_class', 'larisdigital_filter_content_class', 5 );
function larisdigital_filter_content_class( $class ) {
	$layout = larisdigital_get_sidebar_layout();
	if ( 'none' != $layout ) {
		$content_width = 12 - larisdigital_get_sidebar_width();
	}
	else {
		$content_width = larisdigital_get_content_width();
	}
	if ( 'left' == $layout ) {
		$class = 'col-lg-'.$content_width.' order-1 order-lg-2';
	}
	elseif ( 'none' == $layout ) {
		$class = 'col-lg-'.$content_width;
	}
	else {
		$class = 'col-lg-'.$content_width;
	}
	return $class;
}

/**
 * Filter - Sidebar - Sidebar Class
 */
add_filter( 'larisdigital_sidebar_class', 'larisdigital_filter_sidebar_class', 5 );
function larisdigital_filter_sidebar_class( $class ) {
	$layout = larisdigital_get_sidebar_layout();
	if ( 'none' != $layout ) {
		$sidebar_width = larisdigital_get_sidebar_width();
	}
	if ( 'left' == $layout ) {
		$class = 'col-lg-'.$sidebar_width.' order-2 order-lg-1';
	}
	elseif ( 'none' == $layout ) {
		$class = 'col-lg-12 sr-only';
	}
	else {
		$class = 'col-lg-'.$sidebar_width;
	}
	return $class;
}

/**
 * Filter - Sidebar - Row Class
 */
add_filter( 'larisdigital_row_class', 'larisdigital_filter_row_class', 5 );
function larisdigital_filter_row_class( $class ) {
	$layout = larisdigital_get_sidebar_layout();
	if ( 'none' == $layout ) {
		$class = 'justify-content-center';
	}
	elseif ( 'left' == $layout ) {
		$class = 'justify-content-end';
	}
	elseif ( 'right' == $layout ) {
		$class = 'justify-content-start';
	}
	return $class;
}

/**
 * Filter - Footer Widgets - is it active?
 */
add_filter( 'larisdigital_footer_widgets_is_active', 'larisdigital_filter_footer_widgets_is_active', 5 );
function larisdigital_filter_footer_widgets_is_active( $active ) {
	if ( larisdigital_theme_mod( 'larisdigital_footer_widgets_hide' ) ) {
		$active = false;
	}
	if ( ! ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' ) ) ) {
		$active = false;
	}
	return $active;
}

/**
 * Filter - Footer - is it active?
 */
add_filter( 'larisdigital_footer_is_active', 'larisdigital_filter_footer_is_active', 5 );
function larisdigital_filter_footer_is_active( $active ) {
	if ( larisdigital_theme_mod( 'larisdigital_footer_hide' ) ) {
		$active = false;
	}
	return $active;
}

/**
 * Filter - Post Type (Any) - Featured Image On Site Header
 */
add_filter( 'theme_mod_header_image', 'larisdigital_filter_post_type_featured4header_image', 25 );
function larisdigital_filter_post_type_featured4header_image( $url ) {
	if ( is_singular() ) {
		$post_type = get_post_type();
		if ( larisdigital_theme_mod( "larisdigital_{$post_type}_featured4header" ) ) {
			if ( function_exists( 'get_the_post_thumbnail_url' ) ) {
				if ( $img = get_the_post_thumbnail_url( null, 'custom-header' ) ) {
					return $img;
				}
			}
		}
	}
	return $url;
}

/**
 * Filter - Post Type (Any) - Featured Image
 */
add_filter( 'theme_mod_larisdigital_post_image', 'larisdigital_filter_post_type_image', 25 );
add_filter( 'theme_mod_larisdigital_page_image', 'larisdigital_filter_post_type_image', 25 );
function larisdigital_filter_post_type_image( $mod ) {
	$post_type = get_post_type();
	$header_hide = larisdigital_theme_mod( 'larisdigital_header_hide' );
	$featured4header = larisdigital_theme_mod( "larisdigital_{$post_type}_featured4header" );
	if ( ! $header_hide && $featured4header ) {
		return false;
	}
	return $mod;
}

/**
 * Filter - Post Type (Post) - Title4Header
 */
add_filter( 'theme_mod_larisdigital_post_title4header', 'larisdigital_filter_post_type_title4header', 25 );
function larisdigital_filter_post_type_title4header( $mod ) {
	if ( larisdigital_theme_mod( 'larisdigital_header_hide' ) ) {
		return false;
	}
	if ( larisdigital_theme_mod( 'larisdigital_post_header_hide' ) ) {
		return false;
	}
	return $mod;
}

/**
 * Filter - Post Type (Page) - Title4Header
 */
add_filter( 'theme_mod_larisdigital_page_title4header', 'larisdigital_filter_page_type_title4header', 25 );
function larisdigital_filter_page_type_title4header( $mod ) {
	if ( larisdigital_theme_mod( 'larisdigital_header_hide' ) ) {
		return false;
	}
	if ( larisdigital_theme_mod( 'larisdigital_page_header_hide' ) ) {
		return false;
	}
	return $mod;
}

/**
 * Filter - Post Type (Attachment) - Title4Header
 */
add_filter( 'theme_mod_larisdigital_attachment_title4header', 'larisdigital_filter_attachment_type_title4header', 25 );
function larisdigital_filter_attachment_type_title4header( $mod ) {
	if ( larisdigital_theme_mod( 'larisdigital_header_hide' ) ) {
		return false;
	}
	if ( larisdigital_theme_mod( 'larisdigital_attachment_header_hide' ) ) {
		return false;
	}
	return $mod;
}

/**
 * Filter - Font Weight
 */
add_filter( 'larisdigital_customize_font_weights', 'larisdigital_filter_customize_font_weights', 9 );
function larisdigital_filter_customize_font_weights( $value ) {
	$options = array();
	if ( $weight = larisdigital_theme_mod( 'larisdigital_body_font_weight' ) ) {
		$options[ $weight ] = $weight;
	}
	if ( $weight = larisdigital_theme_mod( 'larisdigital_heading1_font_weight' ) ) {
		$options[ $weight ] = $weight;
	}
	if ( $weight = larisdigital_theme_mod( 'larisdigital_heading2_font_weight' ) ) {
		$options[ $weight ] = $weight;
	}
	if ( $weight = larisdigital_theme_mod( 'larisdigital_heading3_font_weight' ) ) {
		$options[ $weight ] = $weight;
	}
	if ( $weight = larisdigital_theme_mod( 'larisdigital_heading4_font_weight' ) ) {
		$options[ $weight ] = $weight;
	}
	if ( $weight = larisdigital_theme_mod( 'larisdigital_heading5_font_weight' ) ) {
		$options[ $weight ] = $weight;
	}
	if ( $weight = larisdigital_theme_mod( 'larisdigital_heading6_font_weight' ) ) {
		$options[ $weight ] = $weight;
	}
	if ( !empty( $options ) ) {
		$value = array_values( $options );
	}
	return $value;
}

add_filter( 'theme_mod_larisdigital_navigation_absolute', 'larisdigital_filter_navigation_absolute', 25 );
function larisdigital_filter_navigation_absolute( $active ) {
	if ( ! apply_filters( 'larisdigital_header_is_active', true ) ) {
		return false;
	}
	return $active;
}
