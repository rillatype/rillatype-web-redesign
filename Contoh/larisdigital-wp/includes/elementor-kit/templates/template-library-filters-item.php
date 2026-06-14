<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<script type="text/html" id="tmpl-larisdigitalkit-template-library-filters-item">
<label class="larisdigitalkit-template-library-filter-label">
	<input type="radio" value="{{ slug }}" <# if ( '' === slug ) { #> checked<# } #> name="larisdigitalkit-library-filter">
	<span>{{ title }}</span>
</label>
</script>
