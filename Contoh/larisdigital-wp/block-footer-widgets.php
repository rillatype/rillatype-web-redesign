<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! apply_filters( 'larisdigital_footer_widgets_is_active', true ) ) {
	return;
}

?>

<div id="site-footer-widgets" class="site-footer-widgets">
	<div class="container">
		<div class="row justify-content-center">
			<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
				<div class="col-lg site-footer-widget-1">
					<?php dynamic_sidebar( 'footer-1' ); ?>
				</div>
			<?php endif; ?>
			<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
				<div class="col-lg site-footer-widget-2">
					<?php dynamic_sidebar( 'footer-2' ); ?>
				</div>	
			<?php endif; ?>
			<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
				<div class="col-lg site-footer-widget-3">
					<?php dynamic_sidebar( 'footer-3' ); ?>
				</div>	
			<?php endif; ?>
			<?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
				<div class="col-lg site-footer-widget-4">
					<?php dynamic_sidebar( 'footer-4' ); ?>
				</div>	
			<?php endif; ?>
		</div>
	</div>
</div>
