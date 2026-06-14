<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header(); 

?>

<div class="main-content">	
<div class="container">

<?php if ( have_posts() ) : ?>

	<div class="row <?php echo apply_filters( 'larisdigital_row_class', '' ); ?>">

		<div id="content" class="main-content-inner <?php echo apply_filters( 'larisdigital_content_class', 'col-lg-8' ); ?>" role="main">
		
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'search' ); ?>

			<?php endwhile; ?>

			<?php larisdigital_pagination( '', larisdigital_theme_mod( 'larisdigital_pagination_alignment' ) ); ?>

		</div>
		
		<?php get_sidebar(); ?>
		
	</div>

<?php else : ?>

	<?php get_template_part( 'content-404' ); ?>

<?php endif; ?>

</div>
</div>

<?php get_footer(); ?>
