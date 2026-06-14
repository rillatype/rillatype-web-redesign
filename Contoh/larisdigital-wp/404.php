<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header(); ?>

<div class="main-content">	
<div class="container">

	<div id="content" class="main-content-inner">
	
		<?php get_template_part( 'content-404' ); ?>

	</div>
			
</div>
</div>

<?php get_footer(); ?>
