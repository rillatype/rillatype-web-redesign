<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( is_singular('download') ) {
	if ( is_active_sidebar( 'sidebar-product' ) ) {
		$sidebar_id = 'sidebar-product';
	}
	else {
		if ( is_active_sidebar( 'sidebar-1' ) ) {
			$sidebar_id = 'sidebar-1';
		}
		else {
			$sidebar_id = false;
			$sidebar_title = esc_html__( 'Single Download', 'larisdigital-wp' );
		}
	}
}
else {
	if ( is_active_sidebar( 'sidebar-shop' ) ) {
		$sidebar_id = 'sidebar-shop';
	}
	else {
		if ( is_active_sidebar( 'sidebar-1' ) ) {
			$sidebar_id = 'sidebar-1';
		}
		else {
			$sidebar_id = false;
			$sidebar_title = esc_html__( 'Downloads Page', 'larisdigital-wp' );
		}
	}
}

?>

<div id="sidebar" class="sidebar <?php echo apply_filters( 'larisdigital_sidebar_class', 'col-lg-4' ); ?>">
<div class="sidebar-padder" role="complementary">

	<?php if ( $sidebar_id ) : ?>

		<?php dynamic_sidebar( $sidebar_id ); ?>

	<?php else : ?>

		<aside class="sidebar-widget widget card">
			<div class="card-body">
				<h4 class="widget-title card-header">
					<?php echo esc_html( $sidebar_title ); ?>
				</h4>
				<p><?php printf( esc_html__( 'This is %s widget area.', 'larisdigital-wp' ), $sidebar_title ); ?></p>
				<p><?php printf( esc_html__('Visit your %s Widgets %s page to add new widget to this widget area.', 'larisdigital-wp'), '<a href="' . esc_url( admin_url( 'widgets.php' ) ) . '">', '</a>' ); ?></p>
				<p><?php printf( esc_html__('Visit your %s Customize %s page to change Sidebar layout.', 'larisdigital-wp'), '<a href="' . esc_url( admin_url('customize.php') ) . '">', '</a>' ); ?></p>
			</div>
		</aside>

	<?php endif; ?>
	
</div>
</div>
