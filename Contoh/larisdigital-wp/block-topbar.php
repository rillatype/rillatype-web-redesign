<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! apply_filters( 'larisdigital_topbar_is_active', true ) ) {
	return;
}

$topbar_menu = has_nav_menu( 'site-topbar-menu' );
if ( larisdigital_theme_mod( 'larisdigital_topbar_menu_hide' ) ) {
	$topbar_menu = false;
}

$topbar_text = larisdigital_theme_mod( 'larisdigital_topbar_text' );
if ( larisdigital_theme_mod( 'larisdigital_topbar_text_hide' ) ) {
	$topbar_text = false;
}

if ( ! $topbar_menu && ! $topbar_text ) {
	return;
}

$topbar_layout = larisdigital_theme_mod( 'larisdigital_topbar_layout' );

if ( 'center-flip' == $topbar_layout ) {
	$topbar_row_class      = 'row justify-content-center';
	$topbar_menu_col_class = 'col-12';
	$topbar_menu_nav_class = 'justify-content-center menu-center';
	$topbar_text_col_class = 'col-12 order-first text-center';
}
elseif ( 'center' == $topbar_layout ) {
	$topbar_row_class      = 'row';
	$topbar_menu_col_class = 'col-12';
	$topbar_menu_nav_class = 'justify-content-center menu-center';
	$topbar_text_col_class = 'col-12 text-center';
}
elseif ( 'left-right' == $topbar_layout ) {
	$topbar_row_class      = 'row';
	$topbar_menu_col_class = 'col-12 col-md';
	$topbar_menu_nav_class = 'justify-content-center menu-center justify-content-md-start menu-md-left';
	$topbar_text_col_class = 'col-12 text-center col-md text-md-right';
}
else /* right-left */ {
	$topbar_row_class      = 'row';
	$topbar_menu_col_class = 'col-12 col-md';
	$topbar_menu_nav_class = 'justify-content-center menu-center justify-content-md-end menu-md-right';
	$topbar_text_col_class = 'col-12 text-center col-md text-md-left order-first';
}

?>

<div class="site-topbar">
	<div class="container">
		<div class="<?php echo esc_attr( $topbar_row_class ); ?>">

			<?php if ( $topbar_menu ) : ?>
				<div class="<?php echo esc_attr( $topbar_menu_col_class ); ?>">
					<?php
					wp_nav_menu( array(
						'theme_location'    => 'site-topbar-menu',
						'depth'             => 1,
						'container'         => '',
						'container_class'   => '',
						'menu_class'        => 'nav site-topbar-menu-nav '.$topbar_menu_nav_class,
						'fallback_cb'       => '',
						'echo'				=> true
						)
					);
					?>
				</div>
			<?php endif; ?>

			<?php if ( trim( $topbar_text ) ) : ?>
				<div class="<?php echo esc_attr( $topbar_text_col_class ); ?>">
					<?php echo wp_kses_post( wpautop( $topbar_text ) ); ?>
				</div>
			<?php endif; ?>

		</div>
	</div>
</div>
