<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<article id="post-not-found" class="entry post post-not-found not-found no-results">
<div class="card">

	<div class="entry-inner card-body">

		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<h2 class="entry-title h2 card-title"><?php _e( 'Not Found', 'larisdigital-wp' ); ?></h2>

			<div class="card-text">
				<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'larisdigital-wp' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>
			</div>

		<?php elseif ( is_search() ) : ?>

			<h2 class="entry-title h2 card-title"><?php _e( 'No Results', 'larisdigital-wp' ); ?></h2>

			<div class="card-text">
				<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'larisdigital-wp' ); ?></p>
				<?php get_search_form(); ?>
			</div>

		<?php else : ?>

			<h2 class="entry-title h2 card-title"><?php _e( 'Not Found', 'larisdigital-wp' ); ?></h2>

			<div class="card-text">
				<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'larisdigital-wp' ); ?></p>
				<?php get_search_form(); ?>
			</div>

		<?php endif; ?>

	</div>

</div>
</article>
