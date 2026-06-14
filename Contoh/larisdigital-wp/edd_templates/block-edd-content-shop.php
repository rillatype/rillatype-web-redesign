<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$title_disable = larisdigital_theme_mod('larisdigital_edd_shop_title_disable');
$title_truncate = larisdigital_theme_mod('larisdigital_edd_shop_title_truncate');
$price_pos = larisdigital_theme_mod('larisdigital_edd_shop_price');

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('entry-shop ld-shop-item'); ?>>
	<div class="card">
		<?php if ( has_post_thumbnail() && !post_password_required() && !is_attachment() ) : ?>
			<a class="ld-shop-image-link" href="<?php the_permalink(); ?>" rel="bookmark">
				<?php the_post_thumbnail( 'shop_thumbnail', array( 'class' => 'card-img-top' ) ); ?>
				<?php if ( $price_pos == 'image' ) : ?>
				<span class="ld-shop-price-image">
					<?php edd_price(); ?>
				</span>
				<?php endif; ?>
			</a>
		<?php endif; ?>

		<?php if ( !$title_disable || $price_pos == 'right' || empty( $price_pos ) ) : ?>
			<div class="card-body">
				<?php if ( $price_pos == 'right' ) : ?>
				<p class="ld-shop-price-right">
					<?php edd_price(); ?>
				</p>
				<?php endif; ?>
				<?php if ( !$title_disable ) : ?>
				<h3 class="card-title <?php if ($title_truncate) echo 'text-truncate'; ?> ld-shop-title">
					<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
				</h3>
				<?php endif; ?>
				<?php if ( empty( $price_pos ) ) : ?>
				<p class="ld-shop-price">
					<?php edd_price(); ?>
				</p>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</article>
