<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! apply_filters( 'larisdigital_sidebar_is_active', true ) ) {
	return;
}

?>

<div id="sidebar" class="sidebar <?php echo apply_filters( 'larisdigital_sidebar_class', 'col-lg-4' ); ?>">
<div class="sidebar-padder" role="complementary">

	<?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>

		<aside class="sidebar-widget widget card">
			<div class="card-body">
				<h4 class="widget-title card-header">
					<?php esc_html_e( 'Sidebar', 'larisdigital-wp' ); ?>
				</h4>
				<p><?php printf( esc_html__( 'This is %s widget area.', 'larisdigital-wp' ), esc_html__( 'Sidebar', 'larisdigital-wp' ) ); ?></p>
				<p><?php printf( esc_html__('Visit your %s Widgets %s page to add new widget to this widget area.', 'larisdigital-wp'), '<a href="' . esc_url( admin_url( 'widgets.php' ) ) . '">', '</a>' ); ?></p>
				<p><?php printf( esc_html__('Visit your %s Customize %s page to change Sidebar layout.', 'larisdigital-wp'), '<a href="' . esc_url( admin_url('customize.php') ) . '">', '</a>' ); ?></p>
			</div>
		</aside>

	<?php endif; ?>
	
</div>
</div>
