<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! apply_filters( 'larisdigital_navigation_is_active', true ) ) {
	return;
}

$navigation_css_classes = array();
$navigation_menu_css_classes = array();

$navigation_scheme = larisdigital_theme_mod( 'larisdigital_navigation_scheme' );
if ( 'light' == $navigation_scheme ) {
	$navigation_css_classes[] = 'navbar-light';
}
else {
	$navigation_css_classes[] = 'navbar-dark';
}

$navigation_sticky = apply_filters( 'larisdigital_navigation_sticky_is_active', true );
if ( $navigation_sticky ) {
	$navigation_css_classes[] = 'site-navigation-sticky';
}

$navigation_brand_type = larisdigital_theme_mod( 'larisdigital_navigation_brand_type' );

$navigation_brand_text = larisdigital_theme_mod( 'larisdigital_navigation_brand_text' );
if ( !$navigation_brand_text ) {
	$navigation_brand_text = get_bloginfo( 'name' );
}

$navigation_brand_image = larisdigital_theme_mod( 'larisdigital_navigation_brand_image' );
if ( !$navigation_brand_image ) {
	$navigation_brand_image = get_template_directory_uri() . '/assets/img/logo.png';
}

$navigation_menu = apply_filters( 'larisdigital_navigation_menu_is_active', false );

$navigation_menu_alignment = larisdigital_theme_mod( 'larisdigital_navigation_menu_alignment' );
if ( 'left' == $navigation_menu_alignment ) {
	$navigation_menu_css_classes[] = 'justify-content-md-start';
}
elseif ( 'right' == $navigation_menu_alignment ) {
	$navigation_menu_css_classes[] = 'justify-content-md-end';
}
else {
	$navigation_menu_css_classes[] = 'justify-content-md-center';
}

$navigation_quicknav = apply_filters( 'larisdigital_navigation_quicknav_is_active', false );

$navigation_css_classes = implode( ' ', $navigation_css_classes );
$navigation_menu_css_classes = implode( ' ', $navigation_menu_css_classes );

?>
<nav class="site-navigation navbar navbar-expand-lg <?php echo esc_attr( $navigation_css_classes ); ?>">
	<div class="container">

		<?php if ( $navigation_menu && $navigation_quicknav ) : ?>
			<button id="site-navigation-toggler" class="site-navigation-toggler navbar-toggler" type="button">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M16 132h416c8.837 0 16-7.163 16-16V76c0-8.837-7.163-16-16-16H16C7.163 60 0 67.163 0 76v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16z"/></svg>
			</button>
		<?php endif; ?>

		<a class="site-navigation-brand navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php if ( $navigation_brand_type == 'image' ) : ?>
				<img src="<?php echo esc_url( $navigation_brand_image ); ?>" alt="<?php echo esc_attr( $navigation_brand_text ); ?>" />
			<?php elseif ( $navigation_brand_type == 'image-text' ) : ?>
				<img src="<?php echo esc_url( $navigation_brand_image ); ?>" alt="<?php echo esc_attr( $navigation_brand_text ); ?>" class="d-inline-block align-top" /> <?php echo esc_attr( $navigation_brand_text ); ?>
			<?php else : ?>
				<?php echo esc_attr( $navigation_brand_text ); ?>
			<?php endif; ?>
		</a>

		<?php if ( $navigation_menu && ! $navigation_quicknav ) : ?>
			<a href="#site-navigation-offcanvas" class="site-navigation-toggler navbar-toggler">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M16 132h416c8.837 0 16-7.163 16-16V76c0-8.837-7.163-16-16-16H16C7.163 60 0 67.163 0 76v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16z"/></svg>
			</a>
		<?php endif; ?>

		<?php if ( $navigation_menu ) : ?>
			<div class="site-navigation-menu collapse navbar-collapse <?php echo esc_attr( $navigation_menu_css_classes ); ?>">
				<?php
				wp_nav_menu( array(
					'theme_location'    => 'site-navigation-menu',
					'container'         => '',
					'container_class'   => '',
					'menu_class'        => 'site-navigation-menu-nav navbar-nav',
					'menu_id'           => 'site-navigation-menu-nav',
					'fallback_cb'       => '',
					'walker'            => new LarisDigital_Navigation_Menu_Walker(),
					'items_wrap'        => '<ul id="%1$s" class="%2$s">%3$s</ul>',
					'echo'				=> true,
					)
				);
				?>
			</div>
		<?php endif; ?>

		<?php if ( $navigation_quicknav ) : ?>
			<ul class="site-navigation-quicknav navbar-nav flex-row">
				<?php do_action( 'larisdigital_navigation_quicknav' ); ?>
			</ul>
		<?php endif; ?>

	</div>
</nav>
