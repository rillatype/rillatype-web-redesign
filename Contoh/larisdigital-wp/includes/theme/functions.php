<?php
/**
 * Theme Functions, for both frontend and admin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Entry meta - Sticky
 */
if ( ! function_exists( 'larisdigital_meta_sticky' ) ) :
function larisdigital_meta_sticky( $before = '', $after = '', $wrapper_before = '', $wrapper_after = '' ) {
	if ( is_sticky() && is_home() ) {
		echo $wrapper_before.'<span class="entry-meta-item entry-meta-sticky">'.$before.__( 'Sticky', 'larisdigital-wp' ).$after.'</span>'.$wrapper_after;
	}
}
endif;

/**
 * Entry meta - Post Type
 */
if ( ! function_exists( 'larisdigital_meta_type' ) ) :
function larisdigital_meta_type( $before = '', $after = '', $wrapper_before = '', $wrapper_after = '' ) {
	$object = get_post_type_object( get_post_type() );
	if ( isset( $object->name ) ) $type = $object->name;
	if ( isset( $object->labels->name ) ) $type = $object->labels->name;
	if ( isset( $object->labels->singular_name ) ) $type = $object->labels->singular_name;
	if ( isset( $type ) ) {
		echo $wrapper_before.'<span class="entry-meta-item entry-meta-type">'.$before.$type.$after.'</span>'.$wrapper_after;
	}
}
endif;

/**
 * Entry meta - Post Categories
 */
if ( ! function_exists( 'larisdigital_meta_categories' ) ) :
function larisdigital_meta_categories( $before = '', $after = '', $separator = ', ', $wrapper_before = '', $wrapper_after = '' ) {
	echo get_the_term_list( get_the_ID(), 'category', $wrapper_before.'<span class="entry-meta-item entry-meta-categories">'.$before, $separator, $after.'</span>'.$wrapper_after );
}
endif;

/**
 * Entry meta - Post Tags
 */
if ( ! function_exists( 'larisdigital_meta_tags' ) ) :
function larisdigital_meta_tags( $before = '', $after = '', $separator = ', ', $wrapper_before = '', $wrapper_after = '' ) {
	echo get_the_term_list( get_the_ID(), 'post_tag', $wrapper_before.'<span class="entry-meta-item entry-meta-tags">'.$before, $separator, $after.'</span>'.$wrapper_after );
}
endif;

/**
 * Entry meta - Date
 */
if ( ! function_exists( 'larisdigital_meta_date' ) ) :
function larisdigital_meta_date( $before = '', $after = '', $wrapper_before = '', $wrapper_after = '' ) {
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$meta_time = '<time class="published" datetime="%1$s">%2$s</time>';
		// $meta_time .= '<time class="updated" datetime="%3$s">%4$s</time>';
	}
	else {
		$meta_time = '<time class="published updated" datetime="%1$s">%2$s</time>';
	}
	$meta_time = $wrapper_before.'<span class="entry-meta-item entry-meta-time">'.$before.'<a href="%5$s" rel="bookmark">'.$meta_time.'</a>'.$after.'</span>'.$wrapper_after;
	printf( $meta_time,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() ),
		esc_url( get_permalink() )
	);
}
endif;

/**
 * Entry meta - Author
 */
if ( ! function_exists( 'larisdigital_meta_author' ) ) :
function larisdigital_meta_author( $before = '', $after = '', $wrapper_before = '', $wrapper_after = '' ) {
	echo $wrapper_before.'<span class="entry-meta-item entry-meta-author author vcard">'.$before.'<a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '" class="post-author-link url fn n" rel="author"><span>'.get_the_author().'</span></a>'.$after.'</span>'.$wrapper_after; 
}
endif;

/**
 * Entry meta - Image Size
 */
if ( ! function_exists( 'larisdigital_meta_imagesize' ) ) :
function larisdigital_meta_imagesize( $before = '', $after = '', $wrapper_before = '', $wrapper_after = '' ) {
	$metadata = wp_get_attachment_metadata();
	echo $wrapper_before.'<span class="entry-meta-item entry-meta-imagesize">'.$before.'<a href="'.esc_url( wp_get_attachment_url() ).'" title="Link to full-size image">'.$metadata['width'].' &times; '.$metadata['height'].'</a>'.$after.'</span>'.$wrapper_after;
}
endif;

/**
 * Entry meta - Parent
 */
if ( ! function_exists( 'larisdigital_meta_parent' ) ) :
function larisdigital_meta_parent( $before = '', $after = '', $wrapper_before = '', $wrapper_after = '' ) {
	global $post;
	if ( empty( $post->post_parent ) ) {
		return;
	}
	echo $wrapper_before.'<span class="entry-meta-item entry-meta-parent">'.$before.'<a href="'.esc_url( get_permalink( $post->post_parent ) ).'" title="Return to '.esc_attr( strip_tags( get_the_title( $post->post_parent ) ) ).'" rel="gallery">'.get_the_title( $post->post_parent ).'</a>'.$after.'</span>'.$wrapper_after;
}
endif;

/**
 * Entry meta - Edit
 */
if ( ! function_exists( 'larisdigital_meta_edit' ) ) :
function larisdigital_meta_edit( $before = '', $after = '', $wrapper_before = '', $wrapper_after = '' ) {
	edit_post_link( __( 'Edit', 'larisdigital-wp' ), $wrapper_before.'<span class="entry-meta-item entry-meta-edit">'.$before, $after.'</span>'.$wrapper_after );
}
endif;

/**
 * Entry meta - Output
 */
if ( ! function_exists( 'larisdigital_meta_output' ) ) :
function larisdigital_meta_output( $view = 'blog' ) {
	if ( ! $view ) {
		return;
	}
	if ( 'blog' == $view ) {
		$meta_items = larisdigital_theme_mod( 'larisdigital_blog_meta_items' );
	}
	elseif ( 'post' == $view ) {
		$meta_items = larisdigital_theme_mod( 'larisdigital_post_meta_items' );
	}
	if ( ! empty( $meta_items ) ) {
		foreach ( $meta_items as $meta_item ) {
			if ( 'sticky' == $meta_item ) {
				larisdigital_meta_sticky('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M298.028 214.267L285.793 96H328c13.255 0 24-10.745 24-24V24c0-13.255-10.745-24-24-24H56C42.745 0 32 10.745 32 24v48c0 13.255 10.745 24 24 24h42.207L85.972 214.267C37.465 236.82 0 277.261 0 328c0 13.255 10.745 24 24 24h136v104.007c0 1.242.289 2.467.845 3.578l24 48c2.941 5.882 11.364 5.893 14.311 0l24-48a8.008 8.008 0 0 0 .845-3.578V352h136c13.255 0 24-10.745 24-24-.001-51.183-37.983-91.42-85.973-113.733z"/></svg> ');
			}
			elseif ( 'date' == $meta_item ) {
				larisdigital_meta_date('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 448c-110.5 0-200-89.5-200-200S145.5 56 256 56s200 89.5 200 200-89.5 200-200 200zm61.8-104.4l-84.9-61.7c-3.1-2.3-4.9-5.9-4.9-9.7V116c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v141.7l66.8 48.6c5.4 3.9 6.5 11.4 2.6 16.8L334.6 349c-3.9 5.3-11.4 6.5-16.8 2.6z"/></svg> ');
			}
			elseif ( 'categories' == $meta_item ) {
				larisdigital_meta_categories('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M464 128H272l-54.63-54.63c-6-6-14.14-9.37-22.63-9.37H48C21.49 64 0 85.49 0 112v288c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V176c0-26.51-21.49-48-48-48zm0 272H48V112h140.12l54.63 54.63c6 6 14.14 9.37 22.63 9.37H464v224z"/></svg> ');
			}
			elseif ( 'tags' == $meta_item ) {
				larisdigital_meta_tags('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M497.941 225.941L286.059 14.059A48 48 0 0 0 252.118 0H48C21.49 0 0 21.49 0 48v204.118a48 48 0 0 0 14.059 33.941l211.882 211.882c18.744 18.745 49.136 18.746 67.882 0l204.118-204.118c18.745-18.745 18.745-49.137 0-67.882zM112 160c-26.51 0-48-21.49-48-48s21.49-48 48-48 48 21.49 48 48-21.49 48-48 48zm513.941 133.823L421.823 497.941c-18.745 18.745-49.137 18.745-67.882 0l-.36-.36L527.64 323.522c16.999-16.999 26.36-39.6 26.36-63.64s-9.362-46.641-26.36-63.64L331.397 0h48.721a48 48 0 0 1 33.941 14.059l211.882 211.882c18.745 18.745 18.745 49.137 0 67.882z"/></svg> ');
			}
			elseif ( 'author' == $meta_item ) {
				larisdigital_meta_author('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path d="M248 104c-53 0-96 43-96 96s43 96 96 96 96-43 96-96-43-96-96-96zm0 144c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm0-240C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm0 448c-49.7 0-95.1-18.3-130.1-48.4 14.9-23 40.4-38.6 69.6-39.5 20.8 6.4 40.6 9.6 60.5 9.6s39.7-3.1 60.5-9.6c29.2 1 54.7 16.5 69.6 39.5-35 30.1-80.4 48.4-130.1 48.4zm162.7-84.1c-24.4-31.4-62.1-51.9-105.1-51.9-10.2 0-26 9.6-57.6 9.6-31.5 0-47.4-9.6-57.6-9.6-42.9 0-80.6 20.5-105.1 51.9C61.9 339.2 48 299.2 48 256c0-110.3 89.7-200 200-200s200 89.7 200 200c0 43.2-13.9 83.2-37.3 115.9z"/></svg> ');
			}
		}
	}
	larisdigital_meta_edit('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M402.3 344.9l32-32c5-5 13.7-1.5 13.7 5.7V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V112c0-26.5 21.5-48 48-48h273.5c7.1 0 10.7 8.6 5.7 13.7l-32 32c-1.5 1.5-3.5 2.3-5.7 2.3H48v352h352V350.5c0-2.1.8-4.1 2.3-5.6zm156.6-201.8L296.3 405.7l-90.4 10c-26.2 2.9-48.5-19.2-45.6-45.6l10-90.4L432.9 17.1c22.9-22.9 59.9-22.9 82.7 0l43.2 43.2c22.9 22.9 22.9 60 .1 82.8zM460.1 174L402 115.9 216.2 301.8l-7.3 65.3 65.3-7.3L460.1 174zm64.8-79.7l-43.2-43.2c-4.1-4.1-10.8-4.1-14.8 0L436 82l58.1 58.1 30.9-30.9c4-4.2 4-10.8-.1-14.9z"/></svg> ');
}
endif;

/**
 * Social Share - Output
 */
if ( ! function_exists( 'larisdigital_social_share_output' ) ) :
function larisdigital_social_share_output( $view = 'post' ) {
	if ( ! is_singular() ) {
		return;
	}
	if ( ! $view ) {
		return;
	}
	$social_items = larisdigital_theme_mod( 'larisdigital_'.$view.'_share_items' );
	if ( ! empty( $social_items ) ) {
		$share_url = get_permalink();
		$share_title = get_the_title();
		$share_image = '';
		if ( in_array( 'pinterest', $social_items ) ) {
			if ( get_post_type() == 'attachment' ) {
				$share_image = wp_get_attachment_image_url( get_the_ID(), 'full' );
			}
			else {
				$share_image = get_the_post_thumbnail_url( null, 'full' );
				if ( !$share_image ) {
					$image_ids = array_keys(
						get_children(
							array(
								'post_parent'    => get_the_ID(),
								'post_type'	     => 'attachment',
								'post_mime_type' => 'image',
								'orderby'        => 'menu_order',
								'order'	         => 'ASC',
							)
						)
					);
					if ( isset( $image_ids[0] ) ) {
						$share_image = wp_get_attachment_image_url( $image_ids[0], 'full' );
					}
				}
			}
		}
		echo '<div class="tp-social-share"><div class="btn-group w-100" role="group" aria-label="'.esc_html__( 'Social Share', 'larisdigital-wp' ).'">';
		foreach ( $social_items as $social_item ) {
			if ( 'facebook' == $social_item ) {
				echo '<a href="https://www.facebook.com/sharer/sharer.php?u='.rawurlencode($share_url).'" class="btn btn-light tp-share-popup" rel="nofollow" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M504 256C504 119 393 8 256 8S8 119 8 256c0 123.78 90.69 226.38 209.25 245V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.28c-30.8 0-40.41 19.12-40.41 38.73V256h68.78l-11 71.69h-57.78V501C413.31 482.38 504 379.78 504 256z"/></svg></a>';
			}
			elseif ( 'twitter' == $social_item ) {
				echo '<a href="https://twitter.com/intent/tweet?text='.rawurlencode($share_title).'&amp;url='.rawurlencode($share_url).'" class="btn btn-light tp-share-popup" rel="nofollow" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"/></svg></a>';
			}
			elseif ( 'google-plus' == $social_item ) {
			}
			elseif ( 'linkedin' == $social_item ) {
				echo '<a href="https://www.linkedin.com/shareArticle?mini=true&amp;url='.rawurlencode($share_url).'&amp;title='.rawurlencode($share_title).'" class="btn btn-light tp-share-popup" rel="nofollow" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M416 32H31.9C14.3 32 0 46.5 0 64.3v383.4C0 465.5 14.3 480 31.9 480H416c17.6 0 32-14.5 32-32.3V64.3c0-17.8-14.4-32.3-32-32.3zM135.4 416H69V202.2h66.5V416zm-33.2-243c-21.3 0-38.5-17.3-38.5-38.5S80.9 96 102.2 96c21.2 0 38.5 17.3 38.5 38.5 0 21.3-17.2 38.5-38.5 38.5zm282.1 243h-66.4V312c0-24.8-.5-56.7-34.5-56.7-34.6 0-39.9 27-39.9 54.9V416h-66.4V202.2h63.7v29.2h.9c8.9-16.8 30.6-34.5 62.9-34.5 67.2 0 79.7 44.3 79.7 101.9V416z"/></svg></a>';
			}
			elseif ( 'pinterest' == $social_item ) {
				echo '<a href="https://pinterest.com/pin/create/button/?url='.rawurlencode($share_url).'&amp;media='.rawurlencode($share_image).'&amp;description='.rawurlencode($share_title).'" class="btn btn-light tp-share-popup" rel="nofollow" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path d="M496 256c0 137-111 248-248 248-25.6 0-50.2-3.9-73.4-11.1 10.1-16.5 25.2-43.5 30.8-65 3-11.6 15.4-59 15.4-59 8.1 15.4 31.7 28.5 56.8 28.5 74.8 0 128.7-68.8 128.7-154.3 0-81.9-66.9-143.2-152.9-143.2-107 0-163.9 71.8-163.9 150.1 0 36.4 19.4 81.7 50.3 96.1 4.7 2.2 7.2 1.2 8.3-3.3.8-3.4 5-20.3 6.9-28.1.6-2.5.3-4.7-1.7-7.1-10.1-12.5-18.3-35.3-18.3-56.6 0-54.7 41.4-107.6 112-107.6 60.9 0 103.6 41.5 103.6 100.9 0 67.1-33.9 113.6-78 113.6-24.3 0-42.6-20.1-36.7-44.8 7-29.5 20.5-61.3 20.5-82.6 0-19-10.2-34.9-31.4-34.9-24.9 0-44.9 25.7-44.9 60.2 0 22 7.4 36.8 7.4 36.8s-24.5 103.8-29 123.2c-5 21.4-3 51.6-.9 71.2C65.4 450.9 0 361.1 0 256 0 119 111 8 248 8s248 111 248 248z"/></svg></a>';
			}
			elseif ( 'whatsapp' == $social_item ) {
				echo '<a href="whatsapp://send?text='.rawurlencode($share_title.' '.$share_url).'" class="btn btn-light" rel="nofollow" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg></a>';
			}
			elseif ( 'telegram' == $social_item ) {
				echo '<a href="https://telegram.me/share/url?url='.rawurlencode($share_url).'&amp;text='.rawurlencode($share_title).'" class="btn btn-light tp-share-popup" rel="nofollow" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path d="M248 8C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm121.8 169.9l-40.7 191.8c-3 13.6-11.1 16.9-22.4 10.5l-62-45.7-29.9 28.8c-3.3 3.3-6.1 6.1-12.5 6.1l4.4-63.1 114.9-103.8c5-4.4-1.1-6.9-7.7-2.5l-142 89.4-61.2-19.1c-13.3-4.2-13.6-13.3 2.8-19.7l239.1-92.2c11.1-4 20.8 2.7 17.2 19.5z"/></svg></a>';
			}
		}
		echo '</div></div>';
	}
}
endif;

/**
 * Prints the attached image with a link to the next attached image.
 */
if ( ! function_exists( 'larisdigital_the_attached_image' ) ) :
function larisdigital_the_attached_image( $img_class = 'thumbnail' ) {
	$post                = get_post();
	$attachment_size     = apply_filters( 'larisdigital_attachment_size', array( 1200, 1200 ) );
	$next_attachment_url = wp_get_attachment_url();

	/**
	 * Grab the IDs of all the image attachments in a gallery so we can get the
	 * URL of the next adjacent image in a gallery, or the first image (if
	 * we're looking at the last image in a gallery), or, in a gallery of one,
	 * just the link to that image file.
	 */
	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID'
	) );

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id )
			$next_attachment_url = get_attachment_link( $next_id );

		// or get the URL of the first image attachment.
		else
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
	}

	printf( '<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',
		esc_url( $next_attachment_url ),
		the_title_attribute( array( 'echo' => false ) ),
		wp_get_attachment_image( $post->ID, $attachment_size, false, array( 'class' => $img_class ) )
	);
}
endif;

/**
 * Link Pages filter - BootStrap-ed
 */
if ( ! function_exists( 'larisdigital_link_pages' ) ) :
function larisdigital_link_pages() {
	add_filter( 'wp_link_pages_link', 'larisdigital_filter_link_pages_link' );
	wp_link_pages( array(
		'before' => '<nav class="page-links" aria-label="' . esc_html__( 'Page Navigation', 'larisdigital-wp' ) . '">' . esc_html__( 'Pages:', 'larisdigital-wp' ) . '',
		'after'  => '</nav>',
	) );
	remove_filter( 'wp_link_pages_link', 'larisdigital_filter_link_pages_link' );
}
endif;

/**
 * Link Pages link - BootStrap-ed
 */
if ( ! function_exists( 'larisdigital_filter_link_pages_link' ) ) :
function larisdigital_filter_link_pages_link( $link ) {
	if ( strpos($link, '</a>') === false ) {
		$link = '<span class="card-link">' . $link . '</span>';
	}
	else {
		$link = str_replace( '<a ', '<a class="card-link" ', $link );
	}
	return $link;
}
endif;

/**
 * Pagination - BootStrap-ed
 */
if ( ! function_exists( 'larisdigital_pagination' ) ) :
function larisdigital_pagination( $query = '', $alignment = 'center' ) {
	global $wp_query;
	if ( ! $query ) {
		$query = $wp_query;
	}
	if( $query->max_num_pages <= 1 ) 
		return;
	echo '<nav class="paging-navigation" aria-label="'.esc_html__( 'Paging navigation', 'larisdigital-wp' ).'">';
	echo larisdigital_paginate_links( array(
		'base' 			=> str_replace( 999999999, '%#%', get_pagenum_link( 999999999 ) ),
		'format' 		=> '',
		'current' 		=> max( 1, get_query_var('paged') ),
		'total' 		=> $query->max_num_pages,
		'type'			=> 'list',
		'prev_text' 	=> '&laquo;',
		'next_text' 	=> '&raquo;',
		'alignment'		=> $alignment,
	) );
	echo '</nav>';
}
endif;

/**
 * Paginate links - BootStrap-ed
 */
if ( ! function_exists( 'larisdigital_paginate_links' ) ) :
function larisdigital_paginate_links( $args = '' ) {
	$defaults = array(
		'base' => '%_%', // http://example.com/all_posts.php%_% : %_% is replaced by format (below)
		'format' => '?page=%#%', // ?page=%#% : %#% is replaced by the page number
		'total' => 1,
		'current' => 0,
		'show_all' => false,
		'prev_next' => true,
		'prev_text' => '&laquo;',
		'next_text' => '&raquo;',
		'end_size' => 1,
		'mid_size' => 2,
		'type' => 'list',
		'add_args' => false, // array of query args to add
		'add_fragment' => '',
		'alignment' => 'center',
	);

	$args = wp_parse_args( $args, $defaults );
	extract($args, EXTR_SKIP);

	// Who knows what else people pass in $args
	$total = (int) $total;
	if ( $total < 2 )
		return;
	$current  = (int) $current;
	$end_size = 0  < (int) $end_size ? (int) $end_size : 1; // Out of bounds?  Make it the default.
	$mid_size = 0 <= (int) $mid_size ? (int) $mid_size : 2;
	$add_args = is_array($add_args) ? $add_args : false;
	$r = '';
	$page_links = array();
	$n = 0;
	$dots = false;

	if ( $prev_next && $current && 1 < $current ) :
		$link = str_replace('%_%', 2 == $current ? '' : $format, $base);
		$link = str_replace('%#%', $current - 1, $link);
		if ( $add_args )
			$link = add_query_arg( $add_args, $link );
		$link .= $add_fragment;
		$page_links[] = '<li class="page-item"><a class="page-link prev" href="' . esc_url( apply_filters( 'paginate_links', $link ) ) . '">' . $prev_text . '</a></li>';
	endif;
	for ( $n = 1; $n <= $total; $n++ ) :
		$n_display = number_format_i18n($n);
		if ( $n == $current ) :
			$page_links[] = '<li class="page-item active"><span class="page-link current">' . $n_display . '</span></li>';
			$dots = true;
		else :
			if ( $show_all || ( $n <= $end_size || ( $current && $n >= $current - $mid_size && $n <= $current + $mid_size ) || $n > $total - $end_size ) ) :
				$link = str_replace('%_%', 1 == $n ? '' : $format, $base);
				$link = str_replace('%#%', $n, $link);
				if ( $add_args )
					$link = add_query_arg( $add_args, $link );
				$link .= $add_fragment;
				$page_links[] = '<li class="page-item"><a class="page-link" href="' . esc_url( apply_filters( 'paginate_links', $link ) ) . '">' . $n_display . '</a></li>';
				$dots = true;
			elseif ( $dots && !$show_all ) :
				$page_links[] = '<li class="page-item disabled"><span class="page-link dots">' . __( '&hellip;', 'larisdigital-wp' ) . '</span></li>';
				$dots = false;
			endif;
		endif;
	endfor;
	if ( $prev_next && $current && ( $current < $total || -1 == $total ) ) :
		$link = str_replace('%_%', $format, $base);
		$link = str_replace('%#%', $current + 1, $link);
		if ( $add_args )
			$link = add_query_arg( $add_args, $link );
		$link .= $add_fragment;
		$page_links[] = '<li class="page-item"><a class="page-link next" href="' . esc_url( apply_filters( 'paginate_links', $link ) ) . '">' . $next_text . '</a></li>';
	endif;
	if ( $alignment == 'left' ) {
		$alignment_class = 'justify-content-start';
	}	
	else if ( $alignment == 'right' ) {
		$alignment_class = 'justify-content-end';
	}	
	else {
		$alignment_class = 'justify-content-center';
	}	
	/* always return list */
	$r .= '<ul class="pagination '.$alignment_class.'">';
	$r .= join('', $page_links);
	$r .= '</ul>';
	return $r;
}
endif;

/**
 * Post Navigation - BootStrap-ed
 */
if ( ! function_exists( 'larisdigital_post_navigation_link' ) ) :
function larisdigital_post_navigation_link() {
	global $wp_query, $post;

	if ( ! is_single() )
		return;
		
	// Don't print empty markup on single pages if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous )
		return;

	echo '<nav class="post-navigation">';
	echo '<h4 class="sr-only">'.__( 'Post navigation', 'larisdigital-wp' ).'</h4>';
	echo '<ul class="pager">';
	previous_post_link( '<li class="previous">%link</li>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'larisdigital-wp' ) . '</span> %title' );
	next_post_link( '<li class="next">%link</li>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'larisdigital-wp' ) . '</span>' );
	echo '</ul>';
	echo '</nav>';
}
endif;

/**
 * Sidebar Layout
 */
if ( ! function_exists( 'larisdigital_get_sidebar_layout' ) ) :
function larisdigital_get_sidebar_layout() {
	$layout = larisdigital_theme_mod( 'larisdigital_sidebar_layout' );
	if ( is_home() || is_archive() ) {
		if ( $layout_blog = larisdigital_theme_mod( 'larisdigital_blog_sidebar_layout' ) ) {
			$layout = $layout_blog;
		}
	}
	elseif ( is_singular() ) {
		$post_type = get_post_type();
		if ( $layout_post = larisdigital_theme_mod( "larisdigital_{$post_type}_sidebar_layout" ) ) {
			$layout = $layout_post;
		}
	}
	if ( !$layout ) {
		$layout = 'none';
	}
	return apply_filters( 'larisdigital_sidebar_layout', $layout );
}
endif;

/**
 * Sidebar Width
 */
if ( ! function_exists( 'larisdigital_get_sidebar_width' ) ) :
function larisdigital_get_sidebar_width() {
	$width = larisdigital_theme_mod( 'larisdigital_sidebar_width' );
	if ( is_home() || is_archive() ) {
		if ( $width_blog = larisdigital_theme_mod( 'larisdigital_blog_sidebar_width' ) ) {
			$width = $width_blog;
		}
	}
	elseif ( is_singular() ) {
		$post_type = get_post_type();
		if ( $width_post = larisdigital_theme_mod( "larisdigital_{$post_type}_sidebar_width" ) ) {
			$width = $width_post;
		}
	}
	if ( !$width ) {
		$width = 4;
	}
	return apply_filters( 'larisdigital_sidebar_width', $width );
}
endif;

/**
 * Content Width
 */
if ( ! function_exists( 'larisdigital_get_content_width' ) ) :
function larisdigital_get_content_width() {
	$width = larisdigital_theme_mod( 'larisdigital_content_width' );
	if ( is_home() || is_archive() ) {
		if ( $width_blog = larisdigital_theme_mod( 'larisdigital_blog_content_width' ) ) {
			$width = $width_blog;
		}
	}
	elseif ( is_singular() ) {
		$post_type = get_post_type();
		if ( $width_post = larisdigital_theme_mod( "larisdigital_{$post_type}_content_width" ) ) {
			$width = $width_post;
		}
	}
	if ( !$width ) {
		$width = 8;
	}
	return apply_filters( 'larisdigital_content_width', $width );
}
endif;
