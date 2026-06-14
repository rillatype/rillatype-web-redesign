<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<script type="text/html" id="tmpl-larisdigitalkit-template-library-categories">
<#
	if ( ! _.isEmpty( categories ) ) {
#>
<select class="larisdigitalkit-library-categories">
	<option value=""><?php esc_html_e( 'Show All', 'larisdigital-wp' ); ?></option>
	<# _.each( categories, function( title, slug ) { #>
	<option value="{{ title }}">{{ title }}</option>
	<# } ); #>
</select>
<#
	}
#>
</script>
