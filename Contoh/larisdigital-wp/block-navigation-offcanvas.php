<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$navigation = apply_filters( 'larisdigital_navigation_is_active', true );
$navigation_menu = apply_filters( 'larisdigital_navigation_menu_is_active', false );
$navigation_quicknav = apply_filters( 'larisdigital_navigation_quicknav_is_active', false );

$active =  $navigation && $navigation_menu ? true : false;
if ( ! $active ) {
	return;
}

if ( $navigation_menu && $navigation_quicknav ) {
	$offcanvas_position = 'left';
}
else {
	$offcanvas_position = 'right';
}
?>
<nav id="site-navigation-offcanvas" class="site-navigation-offcanvas-<?php echo esc_attr( $offcanvas_position ); ?> mm-menu mm-offcanvas">
	<?php
	wp_nav_menu( array(
		'theme_location'    => 'site-navigation-menu',
		'container'         => '',
		'container_class'   => '',
		'menu_class'        => 'site-navigation-offcanvas-nav navbar-nav',
		'menu_id'           => 'site-navigation-offcanvas-nav',
		'fallback_cb'       => '',
		'echo'				=> true,
		)
	);
	?>
</nav>
