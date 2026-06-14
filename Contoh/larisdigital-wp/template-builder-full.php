<?php
/**
 * Template Name: Page Builder (Full Width)
 * Template Post Type: post, page, product
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Body class - Remove Post/Page Body Class 
 * to prevent styling conflict with standard post/page
 */
add_filter( 'body_class', 'larisdigital_body_class_template_builder_full' );
function larisdigital_body_class_template_builder_full( $classes ) {
	if ( in_array( 'post', $classes ) ) {
		$classes = array_diff( $classes, array( 'post' ) );
	}
	if ( in_array( 'page', $classes ) ) {
		$classes = array_diff( $classes, array( 'page' ) );
	}
	$classes[] = 'template-builder-full';
	return $classes;
}

get_header(); 

?>

<div class="main-content-builder clearfix">	

<?php if ( have_posts() ) : ?>

	<?php while ( have_posts() ) : the_post(); global $post; ?>

		<?php the_content(); ?>

	<?php endwhile; ?>

<?php endif; ?>

</div>

<?php get_footer(); ?>
