<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$blog_layout = larisdigital_theme_mod( 'larisdigital_blog_layout' );
if ( !$blog_layout ) {
	$blog_layout = 'excerpt-image';
}

if ( in_array( $blog_layout, array( 'content-image', 'excerpt-image' ) ) ) {
	$blog_image = true;
}
else {
	$blog_image = false;
}

if ( in_array( $blog_layout, array( 'content-image', 'content' ) ) ) {
	$blog_content = 'full';
}
else {
	$blog_content = 'excerpt';
}

$more_link_text = larisdigital_theme_mod( 'larisdigital_blog_more_link_text' );
if ( ! $more_link_text ) {
	$more_link_text = esc_html__( 'Continue reading &rarr;', 'larisdigital-wp' );
}

$more_link = larisdigital_theme_mod( 'larisdigital_blog_more_link' );
if ( ! $more_link ) {
	$more_link_text = '';
}

$blog_meta = larisdigital_theme_mod( 'larisdigital_blog_meta' );
$blog_meta_position = larisdigital_theme_mod( 'larisdigital_blog_meta_position' );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('entry-blog'); ?>>
<div class="card">

	<?php if ( $blog_image && has_post_thumbnail() && !post_password_required() && !is_attachment() ) : ?>
		<?php the_post_thumbnail( 'post-thumbnail', array( 'class' => 'card-img-top' ) ); ?>
	<?php endif; ?>

	<div class="entry-inner card-body">
		<?php if ( is_singular() ) : ?>
			<h1 class="entry-title h2 card-title">
				<?php the_title(); ?>
			</h1>
		<?php else : ?>
			<h2 class="entry-title h2 card-title">
				<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h2>
		<?php endif; ?>

		<?php if ( $blog_meta && 'top' == $blog_meta_position ) : ?>
			<div class="entry-meta entry-meta-top">
				<?php larisdigital_meta_output( 'blog' ); ?>
			</div>
		<?php endif; ?>

		<div class="entry-content card-text">
			<?php if ( is_singular() ) : ?>
				<?php the_content( $more_link_text ); ?>
				<?php larisdigital_link_pages(); ?>
			<?php else : ?>
				<?php if ( 'full' == $blog_content ) : ?>
					<?php the_content( $more_link_text ); ?>
					<?php larisdigital_link_pages(); ?>
				<?php else : ?>
					<?php the_excerpt(); ?>
					<?php if ( $more_link ) : ?>
						<p class="entry-more-link">
							<a href="<?php the_permalink(); ?>" class="more-link btn btn-primary">
								<?php echo esc_html( $more_link_text ); ?>
							</a>
						</p>
					<?php endif; ?>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	</div>

	<?php if ( $blog_meta && 'top' != $blog_meta_position ) : ?>
		<footer class="entry-meta card-footer">
			<?php larisdigital_meta_output( 'blog' ); ?>
		</footer>
	<?php endif; ?>

</div>
</article>
