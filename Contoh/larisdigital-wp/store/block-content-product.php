<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;
$description = $post->post_excerpt;

$regular_price = get_post_meta( get_the_ID(), '_regular_price', true );

$button_text = get_post_meta( get_the_ID(), '_button_text', true );
if ( empty( $button_text ) ) {
	$button_text = esc_html__( 'Buy Now', 'larisdigital-wp' );
}

$button_url = '';
$button_type = get_post_meta( get_the_ID(), '_button_type', true );
if ( $button_type == 'sejoli' ) {
	$button_product = get_post_meta( get_the_ID(), '_product_sejoli', true );
	if ( $button_product ) {
		$button_url = get_permalink( $button_product );
	}
}
elseif ( $button_type == 'gumroad' ) {
	$button_url = get_post_meta( get_the_ID(), '_gumroad_url', true );
	$gumroad_wanted = get_post_meta( get_the_ID(), '_gumroad_wanted', true );
	$gumroad_single = get_post_meta( get_the_ID(), '_gumroad_single', true );
}
else {
	$button_url = get_post_meta( get_the_ID(), '_product_url', true );
}

$image_hide = larisdigital_theme_mod( 'larisdigital_store_product_image_disable' );
$excerpt_hide = larisdigital_theme_mod( 'larisdigital_store_product_excerpt_disable' );
$price_hide = larisdigital_theme_mod( 'larisdigital_store_product_price_disable' );
$button_hide = larisdigital_theme_mod( 'larisdigital_store_product_button_disable' );
$social_share = larisdigital_theme_mod( 'larisdigital_store_product_share' );

if ( empty( $description ) ) {
	$excerpt_hide = true;
}
if ( (string) $regular_price === '' ) {
	$price_hide = true;
}
if ( !$button_url ) {
	$button_hide = true;
}

$saleflash_disable = larisdigital_theme_mod('larisdigital_store_product_saleflash_disable');
$saleflash_text = larisdigital_theme_mod('larisdigital_store_saleflash_text');
if ( empty($saleflash_text) ) {
	$saleflash_text = esc_html__( 'Sale', 'larisdigital-wp' );
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( "entry-{$post->post_type} ld-product" ); ?>>
<div class="row <?php echo apply_filters( 'larisdigital_product_row_class', 'justify-content-center' ); ?>">
	<div class="<?php echo apply_filters( 'larisdigital_product_content_class', 'col-lg-8 col-md-12' ); ?>">
		<?php if ( !$image_hide && has_post_thumbnail() && !post_password_required() && !is_attachment() ) : ?>
			<div class="ld-product-image">
				<?php the_post_thumbnail( 'shop_single', array( 'class' => '' ) ); ?>
			</div>
			<?php if ( !$saleflash_disable && larisdigital_store_product_is_on_sale() ) : ?>
				<span class="ld-product-onsale"><?php echo esc_html($saleflash_text); ?></span>
			<?php endif; ?>
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
						<?php larisdigital_store_product_price(); ?>
					</p>
				<?php endif; ?>
				<?php if ( !$button_hide && $button_url ) : ?>
					<p class="ld-product-button">
						<?php if ( $button_type == 'gumroad' ) : ?>
							<a href="<?php echo esc_url( $button_url ); ?><?php if ( $gumroad_wanted ) { ?>?wanted=true<?php } ?>" class="gumroad-button btn btn-primary btn-block btn-lg" <?php if ( $gumroad_single ) { ?> data-gumroad-single-product="true" <?php } ?> >
								<?php echo esc_html( $button_text ); ?>
							</a>
							<script src="https://gumroad.com/js/gumroad.js"></script>
						<?php else : ?>
							<a href="<?php echo esc_url( $button_url ); ?>" class="btn btn-primary btn-block btn-lg">
								<?php echo esc_html( $button_text ); ?>
							</a>
						<?php endif; ?>
					</p>
				<?php endif; ?>
			</div>
		</div>
		<?php endif; ?>

		<?php if ( $social_share ) larisdigital_social_share_output( 'store_product' ); ?>
	</div>
</div>
</article>
