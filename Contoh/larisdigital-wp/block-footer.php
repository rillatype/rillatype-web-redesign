<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! apply_filters( 'larisdigital_footer_is_active', true ) ) {
	return;
}

$footer_menu = has_nav_menu( 'site-footer-menu' );
if ( larisdigital_theme_mod( 'larisdigital_footer_menu_hide' ) ) {
	$footer_menu = false;
}

$footer_text = larisdigital_theme_mod( 'larisdigital_footer_text' );
if ( ! $footer_text ) {
	$footer_text = esc_html__( 'Powered by LarisDigital Theme and WordPress', 'larisdigital-wp' );
}
if ( larisdigital_theme_mod( 'larisdigital_footer_text_hide' ) ) {
	$footer_text = false;
}

if ( ! $footer_menu && ! $footer_text ) {
	return;
}

$footer_layout = larisdigital_theme_mod( 'larisdigital_footer_layout' );

if ( 'left' == $footer_layout ) {
	$footer_row_class      = 'row';
	$footer_menu_col_class = 'col-12';
	$footer_menu_nav_class = 'justify-content-start menu-left';
	$footer_text_col_class = 'col-12 text-left';
}
elseif ( 'right' == $footer_layout ) {
	$footer_row_class      = 'row';
	$footer_menu_col_class = 'col-12';
	$footer_menu_nav_class = 'justify-content-end menu-right';
	$footer_text_col_class = 'col-12 text-right';
}
elseif ( 'left-right' == $footer_layout ) {
	$footer_row_class      = 'row';
	$footer_menu_col_class = 'col-12 col-lg';
	$footer_menu_nav_class = 'justify-content-center menu-center justify-content-lg-start menu-lg-left';
	$footer_text_col_class = 'col-12 text-center col-lg text-lg-right';
}
elseif ( 'right-left' == $footer_layout ) {
	$footer_row_class      = 'row';
	$footer_menu_col_class = 'col-12 col-lg';
	$footer_menu_nav_class = 'justify-content-center menu-center justify-content-lg-end menu-lg-right';
	$footer_text_col_class = 'col-12 text-center col-lg text-lg-left order-first';
}
else { /* center */
	$footer_row_class      = 'row';
	$footer_menu_col_class = 'col-12';
	$footer_menu_nav_class = 'justify-content-center menu-center';
	$footer_text_col_class = 'col-12 text-center';
}

?>

<footer id="colophon" class="site-footer">
	<div class="container">
		<div class="<?php echo esc_attr( $footer_row_class ); ?>">

			<?php if ( has_nav_menu( 'site-footer-menu' ) ) : ?>
				<div class="<?php echo esc_attr( $footer_menu_col_class ); ?>">
					<?php
					wp_nav_menu( array(
						'theme_location'    => 'site-footer-menu',
						'depth'             => 1,
						'container'         => '',
						'container_class'   => '',
						'menu_class'        => 'nav site-footer-menu-nav '.$footer_menu_nav_class,
						'fallback_cb'       => '',
						'echo'				=> true
						)
					);
					?>
				</div>
			<?php endif; ?>

			<?php if ( trim( $footer_text ) ) : ?>
				<div class="<?php echo esc_attr( $footer_text_col_class ); ?>">
					<?php echo wp_kses_post( wpautop( $footer_text ) ); ?>
				</div>
			<?php endif; ?>

		</div>
	</div>
</footer>
