<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;
$attachment_type = 'other';
$file = get_attached_file( $post->ID );
if ( $file ) {
	$check = wp_check_filetype( $file );
	if ( isset( $check['ext'] ) && $check['ext'] ) {
		if ( in_array( $check['ext'], wp_get_audio_extensions() ) ) {
			$attachment_type = 'audio';
		}
		elseif ( in_array( $check['ext'], wp_get_video_extensions() ) ) {
			$attachment_type = 'video';
		}
	}
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( "entry-{$post->post_type}" ); ?>>
<div class="card">

	<?php
	if ( 'video' == $attachment_type ) {
		$meta = wp_get_attachment_metadata( get_the_ID() );
		$atts = array( 'src' => wp_get_attachment_url() );
		if ( ! empty( $meta['width'] ) && ! empty( $meta['height'] ) ) {
			$atts['width'] = 728;
			$atts['height'] = 728 * (int) $meta['height'] / (int) $meta['width'];
		}
		if ( has_post_thumbnail() ) {
			$atts['poster'] = wp_get_attachment_url( get_post_thumbnail_id() );
		}
		echo wp_video_shortcode( $atts );
	} 
	elseif ( 'audio' == $attachment_type ) {
		echo wp_audio_shortcode( array( 'src' => wp_get_attachment_url() ) );
	}
	?>

	<div class="entry-inner card-body">
		<?php if ( ! larisdigital_theme_mod( "larisdigital_{$post->post_type}_title4header" ) ) : ?>
			<h1 class="entry-title h2 card-title"><?php the_title(); ?></h1>
		<?php endif; ?>
		<div class="entry-content card-text">
			<?php the_content(); ?>
			<?php if ( 'other' == $attachment_type ) : ?>
				<a href="<?php echo wp_get_attachment_url(); ?>" class="btn btn-primary">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M537.6 226.6c4.1-10.7 6.4-22.4 6.4-34.6 0-53-43-96-96-96-19.7 0-38.1 6-53.3 16.2C367 64.2 315.3 32 256 32c-88.4 0-160 71.6-160 160 0 2.7.1 5.4.2 8.1C40.2 219.8 0 273.2 0 336c0 79.5 64.5 144 144 144h368c70.7 0 128-57.3 128-128 0-61.9-44-113.6-102.4-125.4zm-132.9 88.7L299.3 420.7c-6.2 6.2-16.4 6.2-22.6 0L171.3 315.3c-10.1-10.1-2.9-27.3 11.3-27.3H248V176c0-8.8 7.2-16 16-16h48c8.8 0 16 7.2 16 16v112h65.4c14.2 0 21.4 17.2 11.3 27.3z"/></svg> <?php esc_html_e( 'Download', 'larisdigital-wp' ); ?>
				</a>
			<?php endif; ?>
		</div>
	</div>

	<footer class="entry-meta card-footer">
		<?php larisdigital_meta_date('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 448c-110.5 0-200-89.5-200-200S145.5 56 256 56s200 89.5 200 200-89.5 200-200 200zm61.8-104.4l-84.9-61.7c-3.1-2.3-4.9-5.9-4.9-9.7V116c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v141.7l66.8 48.6c5.4 3.9 6.5 11.4 2.6 16.8L334.6 349c-3.9 5.3-11.4 6.5-16.8 2.6z"/></svg> '); ?>
		<?php larisdigital_meta_parent('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M313.553 119.669L209.587 7.666c-9.485-10.214-25.676-10.229-35.174 0L70.438 119.669C56.232 134.969 67.062 160 88.025 160H152v272H68.024a11.996 11.996 0 0 0-8.485 3.515l-56 56C-4.021 499.074 1.333 512 12.024 512H208c13.255 0 24-10.745 24-24V160h63.966c20.878 0 31.851-24.969 17.587-40.331z"/></svg> '); ?>
		<?php larisdigital_meta_edit('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M402.3 344.9l32-32c5-5 13.7-1.5 13.7 5.7V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V112c0-26.5 21.5-48 48-48h273.5c7.1 0 10.7 8.6 5.7 13.7l-32 32c-1.5 1.5-3.5 2.3-5.7 2.3H48v352h352V350.5c0-2.1.8-4.1 2.3-5.6zm156.6-201.8L296.3 405.7l-90.4 10c-26.2 2.9-48.5-19.2-45.6-45.6l10-90.4L432.9 17.1c22.9-22.9 59.9-22.9 82.7 0l43.2 43.2c22.9 22.9 22.9 60 .1 82.8zM460.1 174L402 115.9 216.2 301.8l-7.3 65.3 65.3-7.3L460.1 174zm64.8-79.7l-43.2-43.2c-4.1-4.1-10.8-4.1-14.8 0L436 82l58.1 58.1 30.9-30.9c4-4.2 4-10.8-.1-14.9z"/></svg> '); ?>
	</footer>

</div>
</article>
