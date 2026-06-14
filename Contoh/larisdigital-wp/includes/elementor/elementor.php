<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'TOKOPRESS_ELEMENTOR_VERSION', '1.0.9' );
define( 'TOKOPRESS_ELEMENTOR__FILE__', __FILE__ );
define( 'TOKOPRESS_ELEMENTOR_PATH', get_template_directory() . '/includes/elementor/' );
define( 'TOKOPRESS_ELEMENTOR_URL', get_template_directory_uri() . '/includes/elementor/' );

if ( did_action( 'elementor/loaded' ) ) {
	require( __DIR__ . '/plugin.php' );
}
