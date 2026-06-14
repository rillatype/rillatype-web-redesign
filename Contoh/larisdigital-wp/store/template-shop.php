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
		
			<div class="row">

			<?php while ( have_posts() ) : the_post(); ?>

				<div class="<?php echo apply_filters( 'larisdigital_shop_column_class', 'col-sm-6 col-lg-4' ); ?> mb-2">
					<?php get_template_part( 'store/block-content-shop' ); ?>
				</div>

			<?php endwhile; ?>

			</div>

			<?php larisdigital_pagination( '', larisdigital_theme_mod( 'larisdigital_pagination_alignment' ) ); ?>

		</div>
		
		<?php get_template_part( 'store/block-shop-sidebar' ); ?>
				
	</div>

<?php else : ?>

	<?php get_template_part( 'content-404' ); ?>

<?php endif; ?>

</div>
</div>

<?php get_footer(); ?>
