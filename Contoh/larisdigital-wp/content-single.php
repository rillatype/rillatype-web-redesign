<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$post_meta = larisdigital_theme_mod( "larisdigital_{$post->post_type}_meta" );
$post_meta_position = larisdigital_theme_mod( "larisdigital_{$post->post_type}_meta_position" );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( "entry-{$post->post_type}" ); ?>>
<div class="card">

	<?php if ( larisdigital_theme_mod( "larisdigital_{$post->post_type}_image" ) ) : ?>
		<?php if ( has_post_thumbnail() && !post_password_required() && !is_attachment() ) : ?>
			<?php the_post_thumbnail( 'post-thumbnail', array( 'class' => 'card-img-top' ) ); ?>
		<?php endif; ?>
	<?php endif; ?>

	<div class="entry-inner card-body">
		<?php if ( ! larisdigital_theme_mod( "larisdigital_{$post->post_type}_title4header" ) ) : ?>
			<h1 class="entry-title h2 card-title"><?php the_title(); ?></h1>
		<?php endif; ?>

		<?php if ( $post_meta && 'top' == $post_meta_position ) : ?>
			<div class="entry-meta entry-meta-top">
				<?php larisdigital_meta_output( 'post' ); ?>
			</div>
		<?php endif; ?>

		<div class="entry-content card-text">
			<?php the_content(); ?>
			<?php larisdigital_link_pages(); ?>
			<?php if ( ! larisdigital_theme_mod( 'larisdigital_post_tags_hide' ) ) : ?>
				<?php larisdigital_meta_tags( esc_html__( 'Tags:', 'larisdigital-wp' ).' ', '', ', ', '<p>', '</p>' ); ?>
			<?php endif; ?>
			<?php if ( larisdigital_theme_mod( 'larisdigital_post_share' ) ) : ?>
				<?php larisdigital_social_share_output( 'post' ); ?>
			<?php endif; ?>
		</div>
	</div>

	<?php if ( $post_meta && 'top' != $post_meta_position ) : ?>
		<footer class="entry-meta card-footer">
			<?php larisdigital_meta_output( 'post' ); ?>
		</footer>
	<?php endif; ?>

</div>
</article>
