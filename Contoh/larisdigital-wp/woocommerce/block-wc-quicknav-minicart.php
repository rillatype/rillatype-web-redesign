<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! larisdigital_theme_mod( 'larisdigital_navigation_quicknav_minicart' ) ) {
	return;
}

if ( larisdigital_theme_mod( 'larisdigital_navigation_quicknav_minicart_dropdown' ) ) :
?>
<li class="nav-item dropdown quicknav-minicart">
	<a class="nav-link dropdown-toggle" href="#" id="quicknav-minicart" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M528.12 301.319l47.273-208C578.806 78.301 567.391 64 551.99 64H159.208l-9.166-44.81C147.758 8.021 137.93 0 126.529 0H24C10.745 0 0 10.745 0 24v16c0 13.255 10.745 24 24 24h69.883l70.248 343.435C147.325 417.1 136 435.222 136 456c0 30.928 25.072 56 56 56s56-25.072 56-56c0-15.674-6.447-29.835-16.824-40h209.647C430.447 426.165 424 440.326 424 456c0 30.928 25.072 56 56 56s56-25.072 56-56c0-22.172-12.888-41.332-31.579-50.405l5.517-24.276c3.413-15.018-8.002-29.319-23.403-29.319H218.117l-6.545-32h293.145c11.206 0 20.92-7.754 23.403-18.681z"/></svg>
		<span class="sr-only"><?php esc_html_e( 'Cart', 'larisdigital-wp' ); ?></span>
		<?php if ( larisdigital_theme_mod( 'larisdigital_navigation_quicknav_minicart_count' ) ) : ?>
			<?php $cart_count = WC()->cart->get_cart_contents_count(); ?>
			<span class="quicknav-minicart-count"><?php if ( $cart_count > 0 ) echo '<span class="badge badge-primary">'.esc_attr($cart_count).'</span>'; ?></span>
		<?php endif; ?>
	</a>
	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="quicknav-minicart">
		<div class="px-3 py-2">
			<?php if ( is_cart() ) : ?>
				<div class="widget woocommerce widget_shopping_cart">
					<p class="buttons">
						<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="button wc-forward"><?php esc_html_e( 'Visit Shop', 'larisdigital-wp' ); ?></a>
						<a href="<?php echo esc_url( wc_get_page_permalink( 'checkout' ) ); ?>" class="button checkout wc-forward"><?php esc_html_e( 'Checkout', 'larisdigital-wp' ); ?></a>
					</p>
				</div>
			<?php elseif ( is_checkout() ) : ?>
				<div class="widget woocommerce widget_shopping_cart">
					<p class="buttons">
						<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="button wc-forward"><?php esc_html_e( 'Visit Shop', 'larisdigital-wp' ); ?></a>
						<a href="<?php echo esc_url( wc_get_page_permalink( 'cart' ) ); ?>" class="button checkout wc-forward"><?php esc_html_e( 'View Cart', 'larisdigital-wp' ); ?></a>
					</p>
				</div>
			<?php else : ?>
				<div class="widget woocommerce widget_shopping_cart">
					<div class="widget_shopping_cart_content">
						<p class="buttons">
							<a href="<?php echo esc_url( wc_get_page_permalink( 'cart' ) ); ?>" class="button wc-forward"><?php esc_html_e( 'View Cart', 'larisdigital-wp' ); ?></a>
							<a href="<?php echo esc_url( wc_get_page_permalink( 'checkout' ) ); ?>" class="button checkout wc-forward"><?php esc_html_e( 'Checkout', 'larisdigital-wp' ); ?></a>
						</p>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</li>
<?php
else :
?>
<li class="nav-item quicknav-minicart">
	<a class="nav-link " href="<?php echo esc_url( wc_get_page_permalink( 'cart' ) ); ?>" id="quicknav-minicart" aria-expanded="false">
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M528.12 301.319l47.273-208C578.806 78.301 567.391 64 551.99 64H159.208l-9.166-44.81C147.758 8.021 137.93 0 126.529 0H24C10.745 0 0 10.745 0 24v16c0 13.255 10.745 24 24 24h69.883l70.248 343.435C147.325 417.1 136 435.222 136 456c0 30.928 25.072 56 56 56s56-25.072 56-56c0-15.674-6.447-29.835-16.824-40h209.647C430.447 426.165 424 440.326 424 456c0 30.928 25.072 56 56 56s56-25.072 56-56c0-22.172-12.888-41.332-31.579-50.405l5.517-24.276c3.413-15.018-8.002-29.319-23.403-29.319H218.117l-6.545-32h293.145c11.206 0 20.92-7.754 23.403-18.681z"/></svg>
		<span class="sr-only"><?php esc_html_e( 'Cart', 'larisdigital-wp' ); ?></span>
		<?php if ( larisdigital_theme_mod( 'larisdigital_navigation_quicknav_minicart_count' ) ) : ?>
			<?php $cart_count = WC()->cart->get_cart_contents_count(); ?>
			<span class="quicknav-minicart-count"><?php if ( $cart_count > 0 ) echo '<span class="badge badge-primary">'.esc_attr($cart_count).'</span>'; ?></span>
		<?php endif; ?>
	</a>
</li>
<?php
endif;