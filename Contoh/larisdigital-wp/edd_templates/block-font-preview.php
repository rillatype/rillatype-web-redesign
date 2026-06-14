<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$preview = get_post_meta( get_the_ID(), '_font_preview', true );
if ( !$preview ) {
	return;
}

$mode = get_post_meta( get_the_ID(), '_font_mode', true );
if ( !$mode ) {
	$mode = 'image';
}

$fonts = larisdigital_font_preview_data($mode);
if ( empty($fonts) ) {
	return;
}

if ( $mode !== 'text' && !function_exists('imagecreatetruecolor') ) {
	echo '<p>'.esc_html_e( 'Sorry, font preview is not available because GD Library is missing.', 'larisdigital-wp' ).'</p>';
	return;
}

$font_size = array(
	'text' => array(
		24 => 32,
		36 => 48,
		48 => 64,
		72 => 96,
	),
	'image' => array(
		24 => 24,
		36 => 36,
		48 => 48,
		72 => 72,
	),
);
?>

<div class="tp-font-preview">
	<h2 class="tp-font-preview-heading mb-4"><?php esc_html_e( 'Font Preview', 'larisdigital-wp' ); ?></h2>
	<div class="tp-font-preview-input mb-3">
		<div class="row mx-n2">
			<div class="col-6 col-lg-4 px-2 pb-3">
				<select name="tp-font-preview-select" class="tp-font-preview-select form-control" id="tp-font-preview-select">
					<option value="The quick brown fox jumps over the lazy dog" selected="selected">The quick brown fox jumps over the lazy dog</option>
					<option value="When zombies arrive, quickly fax judge Pat" >When zombies arrive, quickly fax judge Pat</option>
					<option value="AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz">AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz</option>
				</select>
			</div>
			<div class="col-6 col-lg-4 px-2 pb-3">
				<input type="text" name="tp-font-preview-text" class="tp-font-preview-text form-control" id="tp-font-preview-text" placeholder="Please type to try it">
			</div>
			<div class="col-lg-4 px-2 pb-3">
				<div class="tp-font-preview-btn btn-group btn-group-toggle" data-toggle="buttons">
					<label class="btn btn-light active">
						<input type="radio" name="tp-font-preview-size" class="tp-font-preview-size" id="tp-font-preview-size-24" autocomplete="off" value="<?php echo esc_attr($font_size[$mode][24]); ?>" checked> <span class="tpfps tpfps1">A</span> 24pt
					</label>
					<label class="btn btn-light">
						<input type="radio" name="tp-font-preview-size" class="tp-font-preview-size" id="tp-font-preview-size-36" autocomplete="off" value="<?php echo esc_attr($font_size[$mode][36]); ?>"> <span class="tpfps tpfps2">A</span> 36pt
					</label>
					<label class="btn btn-light">
						<input type="radio" name="tp-font-preview-size" class="tp-font-preview-size" id="tp-font-preview-size-48" autocomplete="off" value="<?php echo esc_attr($font_size[$mode][48]); ?>"> <span class="tpfps tpfps3">A</span> 48pt
					</label>
					<label class="btn btn-light">
						<input type="radio" name="tp-font-preview-size" class="tp-font-preview-size" id="tp-font-preview-size-72" autocomplete="off" value="<?php echo esc_attr($font_size[$mode][72]); ?>"> <span class="tpfps tpfps4">A</span> 72pt
					</label>
				</div>
			</div>
		</div>
	</div>
	<div class="tp-font-preview-list clearfix" data-tpfpbase="<?php echo esc_attr(home_url('/')); ?>">
		<?php foreach( $fonts as $font ) : ?>
			<div class="tp-font-preview-item mb-4">
				<span class="tp-font-preview-item-title"><?php echo esc_html($font['font_name']); ?></span><br/>
				<?php if ( $mode !== 'text' ) : ?>
					<div class="tp-font-preview-item-img-wrap">
						<img class="tp-font-preview-item-img" src="<?php echo esc_url($font['font_url']); ?>" alt="<?php echo esc_attr($font['font_name']); ?>" width="<?php echo esc_attr($font['width']); ?>" height="<?php echo esc_attr($font['height']); ?>" data-tpfpid="<?php echo esc_attr($font['font_id']); ?>"/>
					</div>
				<?php else : ?>
					<?php $font_css = fread(fopen($font['font_path'], "r"), filesize($font['font_path'])); ?>
					<style type="text/css">
					@font-face {
						font-family: 'TPFontPreview<?php echo esc_attr($font['font_id']); ?>';
						src: url(data:<?php echo esc_attr($font['font_type']); ?>;charset=utf-8;base64,<?php echo base64_encode($font_css); ?>) format('<?php echo esc_attr($font['font_ext']); ?>');
					}
					.tp-font-preview-<?php echo esc_attr($font['font_id']); ?> {
						font-family: 'TPFontPreview<?php echo esc_attr($font['font_id']); ?>';
					}
					</style>
					<span class="tp-font-preview-item-text tp-font-preview-<?php echo esc_attr($font['font_id']); ?>">The quick brown fox jumps over the lazy dog</span>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>
</div>
