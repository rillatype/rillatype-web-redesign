<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<script type="text/html" id="tmpl-larisdigitalkit-template-library-item">
<# var activeTab = window.LarisDigitalKitData.tabs[ type ]; #>
<div class="elementor-template-library-template-body">
	<div class="elementor-template-library-template-screenshot" style="background-image: url('{{ thumbnail }}');"></div>
	<div class="elementor-template-library-template-preview">
		<i class="eicon-zoom-in" aria-hidden="true"></i>
	</div>
</div>
<div class="elementor-template-library-template-controls">
	<button class="elementor-template-library-template-action larisdigitalkit-template-library-template-insert elementor-button elementor-button-success">
		<i class="eicon-file-download"></i>
		<span class="elementor-button-title"><?php esc_html_e( 'Insert', 'larisdigital-wp' ); ?></span>
	</button>
</div>
<# if ( true == activeTab.settings.show_title ) { #>
<div class="elementor-template-library-template-name">{{{ title }}}</div>
<# } else { #>
<div class="elementor-template-library-template-name-holder"></div>
<# } #>
</script>
