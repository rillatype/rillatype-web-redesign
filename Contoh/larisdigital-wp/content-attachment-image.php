<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-attachment entry-image' ); ?>>
<div class="card">

	<?php larisdigital_the_attached_image('card-img-top'); ?>
	
	<?php global $post; if ( has_excerpt() || get_the_content() || ! empty( $post->post_parent ) ) : ?>
	<div class="entry-inner card-body">

		<?php if ( ! larisdigital_theme_mod( "larisdigital_{$post->post_type}_title4header" ) ) : ?>
			<h1 class="entry-title h2 card-title"><?php the_title(); ?></h1>
		<?php endif; ?>

		<div class="entry-content card-text">
			<div class="entry-attachment">
				
				<?php if ( has_excerpt() ) : ?>
					<div class="entry-caption">
						<?php the_excerpt(); ?>
					</div>
				<?php endif; ?>

			</div>

			<?php the_content(); ?>

			<?php global $post; if ( ! empty( $post->post_parent ) ) : ?>
			<nav id="image-navigation" class="clearfix image-navigation">
				<div class="thumbnail float-left nav-previous"><?php previous_image_link( 'thumbnail' ); ?></div>
				<div class="thumbnail float-right nav-next"><?php next_image_link( 'thumbnail' ); ?></div>
			</nav>
			<?php endif; ?>

		</div>

	</div>
	<?php endif; ?>

	<footer class="entry-meta card-footer">
		<?php larisdigital_meta_date('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 448c-110.5 0-200-89.5-200-200S145.5 56 256 56s200 89.5 200 200-89.5 200-200 200zm61.8-104.4l-84.9-61.7c-3.1-2.3-4.9-5.9-4.9-9.7V116c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v141.7l66.8 48.6c5.4 3.9 6.5 11.4 2.6 16.8L334.6 349c-3.9 5.3-11.4 6.5-16.8 2.6z"/></svg> '); ?>
		<?php larisdigital_meta_imagesize('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M48 32C21.5 32 0 53.5 0 80v352c0 26.5 21.5 48 48 48h416c26.5 0 48-21.5 48-48V80c0-26.5-21.5-48-48-48H48zm0 32h106c3.3 0 6 2.7 6 6v20c0 3.3-2.7 6-6 6H38c-3.3 0-6-2.7-6-6V80c0-8.8 7.2-16 16-16zm426 96H38c-3.3 0-6-2.7-6-6v-36c0-3.3 2.7-6 6-6h138l30.2-45.3c1.1-1.7 3-2.7 5-2.7H464c8.8 0 16 7.2 16 16v74c0 3.3-2.7 6-6 6zM256 424c-66.2 0-120-53.8-120-120s53.8-120 120-120 120 53.8 120 120-53.8 120-120 120zm0-208c-48.5 0-88 39.5-88 88s39.5 88 88 88 88-39.5 88-88-39.5-88-88-88zm-48 104c-8.8 0-16-7.2-16-16 0-35.3 28.7-64 64-64 8.8 0 16 7.2 16 16s-7.2 16-16 16c-17.6 0-32 14.4-32 32 0 8.8-7.2 16-16 16z"/></svg> '); ?>
		<?php larisdigital_meta_parent('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M313.553 119.669L209.587 7.666c-9.485-10.214-25.676-10.229-35.174 0L70.438 119.669C56.232 134.969 67.062 160 88.025 160H152v272H68.024a11.996 11.996 0 0 0-8.485 3.515l-56 56C-4.021 499.074 1.333 512 12.024 512H208c13.255 0 24-10.745 24-24V160h63.966c20.878 0 31.851-24.969 17.587-40.331z"/></svg> '); ?>
		<?php larisdigital_meta_edit('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M402.3 344.9l32-32c5-5 13.7-1.5 13.7 5.7V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V112c0-26.5 21.5-48 48-48h273.5c7.1 0 10.7 8.6 5.7 13.7l-32 32c-1.5 1.5-3.5 2.3-5.7 2.3H48v352h352V350.5c0-2.1.8-4.1 2.3-5.6zm156.6-201.8L296.3 405.7l-90.4 10c-26.2 2.9-48.5-19.2-45.6-45.6l10-90.4L432.9 17.1c22.9-22.9 59.9-22.9 82.7 0l43.2 43.2c22.9 22.9 22.9 60 .1 82.8zM460.1 174L402 115.9 216.2 301.8l-7.3 65.3 65.3-7.3L460.1 174zm64.8-79.7l-43.2-43.2c-4.1-4.1-10.8-4.1-14.8 0L436 82l58.1 58.1 30.9-30.9c4-4.2 4-10.8-.1-14.9z"/></svg> '); ?>
	</footer>

</div>
</article>
