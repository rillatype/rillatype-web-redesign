<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! apply_filters( 'larisdigital_header_is_active', true ) ) {
	return;
}

$header_title = apply_filters( 'larisdigital_header_title', get_bloginfo('name') );
$header_description = apply_filters( 'larisdigital_header_description', get_bloginfo('description') );
$header_image = get_header_image();
?>
<div class="site-header">
	<?php if ( $header_image ) : ?>
		<div class="site-header-overlay"></div>
	<?php endif; ?>
	<div class="container">

		<?php do_action( 'larisdigital_header_before' ); ?>

		<?php if ( $header_title ) : ?>
			<div class="site-title h1">
				<?php echo wp_kses_post( $header_title ); ?>
			</div>
		<?php endif; ?>

		<?php if ( $header_description ) : ?>
			<p class="site-description">
				<?php echo wp_kses_post( $header_description ); ?>
			</p>
		<?php endif; ?>

		<?php do_action( 'larisdigital_header_after' ); ?>

	</div>
</div>
