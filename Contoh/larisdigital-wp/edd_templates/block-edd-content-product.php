<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;
$description = $post->post_excerpt;
$edd_is_variable = edd_has_variable_prices( get_the_ID() );
$edd_button_hide = get_post_meta( get_the_ID(), '_edd_hide_purchase_link', true );

$image_hide = larisdigital_theme_mod( 'larisdigital_edd_product_image_disable' );
$excerpt_hide = larisdigital_theme_mod( 'larisdigital_edd_product_excerpt_disable' );
$price_hide = larisdigital_theme_mod( 'larisdigital_edd_product_price_disable' );
$button_hide = larisdigital_theme_mod( 'larisdigital_edd_product_button_disable' );
$social_share = larisdigital_theme_mod( 'larisdigital_edd_product_share' );

if ( empty( $description ) ) {
	$excerpt_hide = true;
}
if ( $edd_is_variable ) {
	$price_hide = true;
}
if ( $edd_button_hide ) {
	$button_hide = true;
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( "entry-{$post->post_type} ld-product" ); ?>>
<div class="row <?php echo apply_filters( 'larisdigital_product_row_class', 'justify-content-center' ); ?>">
	<div class="<?php echo apply_filters( 'larisdigital_product_content_class', 'col-lg-8 col-md-12' ); ?>">
		<?php if ( !$image_hide && has_post_thumbnail() && !post_password_required() && !is_attachment() ) : ?>
			<div class="ld-product-image">
				<?php the_post_thumbnail( 'shop_single', array( 'class' => '' ) ); ?>
			</div>
		<?php endif; ?>
		<?php do_action( 'larisdigital_shop_single_after_image' ); ?>
		<div class="entry-content ld-product-content">
			<?php the_content(); ?>
			<?php larisdigital_link_pages(); ?>
		</div>
	</div>
	<div class="<?php echo apply_filters( 'larisdigital_product_cta_class', 'col-lg-4 col-md-6 col-sm-8 mb-4' ); ?>">
		<?php if ( !$excerpt_hide || !$price_hide || !$button_hide ) : ?>
			<div class="card ld-product-cta">
				<div class="card-body">
					<?php if ( !$excerpt_hide ) : ?>
						<div class="ld-product-desc">
							<?php echo wpautop( wptexturize( $description ) ); ?>
						</div>
					<?php endif; ?>
					<?php if ( !$price_hide ) : ?>
						<p class="ld-product-price">
							<?php edd_price(); ?>
						</p>
					<?php endif; ?>
					<?php if ( !$button_hide ) : ?>
						<?php 
						echo edd_get_purchase_link( 
							array( 
								'download_id' => get_the_ID(),
								'price' => false,
								'class' => 'btn btn-primary btn-block btn-lg',
							) 
						); ?>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( $social_share ) larisdigital_social_share_output( 'edd_product' ); ?>
	</div>
</div>
</article>
