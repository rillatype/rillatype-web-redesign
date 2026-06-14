<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$navigation = apply_filters( 'larisdigital_navigation_is_active', true );
$header = apply_filters( 'larisdigital_header_is_active', true );

if ( ! ( $navigation || $header ) ) {
	return;
}

?>

</div>
