<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_5f8265bf58eb9',
	'title' => 'Product Preview',
	'fields' => array(
		array(
			'key' => 'field_5f8267a226056',
			'label' => 'Font',
			'name' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placement' => 'left',
			'endpoint' => 0,
		),
		array(
			'key' => 'field_5f8266d80fba2',
			'label' => 'Enable Font Preview',
			'name' => '_font_preview',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 1,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_5f82923be2009',
			'label' => 'Font Preview Mode',
			'name' => '_font_mode',
			'type' => 'radio',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5f8266d80fba2',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'image' => 'Secure IMAGE-based font preview (OTF/TTF), one-line preview only and no ligature support',
				'text' => 'Secure TEXT-based font preview (WOFF/WOFF2), multi-line preview with ligature support',
			),
			'allow_null' => 0,
			'other_choice' => 0,
			'default_value' => 'image',
			'layout' => 'vertical',
			'return_format' => 'value',
			'save_other_choice' => 0,
		),
		array(
			'key' => 'field_5f4dee23b11df',
			'label' => 'Add/Select Font',
			'name' => '_font_data',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5f8266d80fba2',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => 'field_5f826a1d09420',
			'min' => 0,
			'max' => 0,
			'layout' => 'table',
			'button_label' => 'Add/Select Font',
			'sub_fields' => array(
				array(
					'key' => 'field_5f826a1d09420',
					'label' => 'Font Name',
					'name' => 'name',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_5f826a2f09421',
					'label' => 'OTF/TTF Font File',
					'name' => 'font',
					'type' => 'file',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_5f82923be2009',
								'operator' => '!=',
								'value' => 'text',
							),
						),
					),
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'id',
					'library' => 'all',
					'min_size' => '',
					'max_size' => '',
					'mime_types' => 'otf,ttf',
				),
				array(
					'key' => 'field_5f826a6709422',
					'label' => 'WOFF/WOFF2 Font File',
					'name' => 'font_web',
					'type' => 'file',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_5f82923be2009',
								'operator' => '==',
								'value' => 'text',
							),
						),
					),
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'id',
					'library' => 'all',
					'min_size' => '',
					'max_size' => '',
					'mime_types' => 'woff,woff2',
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'product',
			),
		),
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'download',
			),
		),
	),
	'menu_order' => 1,
	'position' => 'advanced',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

endif;

add_filter( 'upload_mimes', 'larisdigital_font_preview_upload_mimes' );
function larisdigital_font_preview_upload_mimes($existing_mimes = array()) {
	$existing_mimes['woff'] = 'font/woff';
	$existing_mimes['woff2'] = 'font/woff2';
	$existing_mimes['ttf'] = 'font/truetype';
	$existing_mimes['otf'] = 'font/opentype';
	$existing_mimes['zip'] = 'application/zip, application/octet-stream, application/x-zip-compressed';
	return $existing_mimes;
}

add_filter( 'wp_check_filetype_and_ext', 'larisdigital_font_preview_check_filetype', 10, 4 );
function larisdigital_font_preview_check_filetype($checked, $file, $filename, $mimes) {
	if (false === $checked['ext'] && false === $checked['type'] && false === $checked['proper_filename']) {
		$filetype = wp_check_filetype($filename);
		$wp_mimes = get_allowed_mime_types();
		if (in_array($filetype['ext'], array_keys($wp_mimes))) {
			$checked['ext'] = true;
			$checked['type'] = true;

			return $checked;
		}
	}

	return $checked;
}

add_action( 'woocommerce_before_single_product_summary' , 'larisdigital_font_preview_output', 30);
add_action( 'larisdigital_shop_single_after_image' , 'larisdigital_font_preview_output', 30);
function larisdigital_font_preview_output() {
	get_template_part( 'store/block-font-preview' );
}

function larisdigital_font_preview_data( $mode = '', $font_text = '', $font_size = '' ) {
	if ( ! function_exists('have_rows') ) {
		return;
	}
	// if ( ! is_product() ) {
	// 	return;
	// }
	if ( empty( $font_size ) ) {
		$font_size = 24;
	}
	if ( !in_array( $font_size, array(16,24,36,48,72) ) ) {
		$font_size = 24;
	}
    $width = 1110;
    $height = intval( $font_size * 2.7 );
	$fonts = array();
	if( have_rows('_font_data') ) :
		while ( have_rows('_font_data') ) : the_row();
			$font_name = get_sub_field('name');
			$font_id = $mode !== 'text' ? get_sub_field('font') : get_sub_field('font_web');
			$font_file = get_attached_file( $font_id );
			if ( !empty($font_name) && !empty($font_file) && file_exists($font_file) ) {
				if ( $mode === 'text' ) {
					$font_filetype = wp_check_filetype( $font_file );
					$fonts[] = array(
						'font_name' => $font_name,
						'font_id' => $font_id,
						'font_path' => $font_file,
						'font_ext' => $font_filetype['ext'],
						'font_type' => $font_filetype['type'],
					);
				}
				else {
					$font_url = home_url('/');
					$font_url = add_query_arg( 'tp_font_preview', 1, $font_url );
					$font_url = add_query_arg( 'tp_font_id', $font_id, $font_url );
					if ( !empty($font_text) ) {
						$font_url = add_query_arg( 'tp_font_text', $font_text, $font_url );
					}
					if ( !empty($font_size) ) {
						$font_url = add_query_arg( 'tp_font_size', $font_size, $font_url );
					}
					$fonts[] = array(
						'font_name' => $font_name,
						'font_id' => $font_id,
						'font_url' => $font_url,
						'width' => $width,
						'height' => $height,
					);
				}
			}
		endwhile;
	endif;
	return $fonts;
}

add_action( 'wp', 'larisdigital_font_preview_setup' );
function larisdigital_font_preview_setup() {
	if ( isset( $_GET['tp_font_preview'] ) ) {
		$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
		if ( ! $referer ) {
			return;
		}
		if ( !function_exists('imagecreatetruecolor') ) {
			return;
		}

		$font_preview = intval( sanitize_key( $_GET['tp_font_preview'] ) );
		if ( $font_preview !== 1 ) {
			return;
		}

		if ( !isset( $_GET['tp_font_id'] ) ) {
			return;
		}
		$font_id = intval( sanitize_key( $_GET['tp_font_id'] ) );
		if ( empty( $font_id ) ) {
			return;
		}

		$font = get_attached_file( $font_id );
		if ( empty( $font ) ) {
			return;
		}

		$text = '';
		if ( isset( $_GET['tp_font_text'] ) ) {
			$text = sanitize_text_field( $_GET['tp_font_text'] );
		}
		if ( empty( $text ) ) {
			$text = 'The quick brown fox jumps over the lazy dog';
		}

		$font_size = intval( sanitize_key( $_GET['tp_font_size'] ) );
		if ( empty( $font_size ) ) {
			$font_size = 24;
		}
		if ( !in_array( $font_size, array(16,24,36,48,72) ) ) {
			$font_size = 24;
		}

		$color = '#222222';
		$background = '#FFFFFF';

		header('Content-type: image/png');
		larisdigital_font_preview_image( $font, $text, $font_size, $color, $background );
		exit;

	}
}

function larisdigital_font_preview_image( $font, $text = 'The quick brown fox jumps over the lazy dog', $font_size = 24, $color = '#FF0000', $background = '#FFFFFF' ) {
	$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
	if ( ! $referer ) {
		return;
	}
	if ( !function_exists('imagecreatetruecolor') ) {
		return;
	}

	$text = $text;
    $width = 1110;
    $height = intval( $font_size * 3 );
    $offset_y = intval( $font_size * 2 );
    
    $color_rgb = larisdigital_font_preview_hex2rgb( $color );
    $background_rgb = larisdigital_font_preview_hex2rgb( $background );
    
    $image = imagecreatetruecolor( $width, $height );
    
    $image_color = imagecolorallocate( $image, $color_rgb[0], $color_rgb[1], $color_rgb[2] );
    $image_background = imagecolorallocate( $image, $background_rgb[0], $background_rgb[1], $background_rgb[2] );
    
    imagefilledrectangle( $image, 0, 0, $width, $height, $image_background );
    
    imagettftext( $image, $font_size, 0, 10, $offset_y, $image_color, $font, $text );
    
    imagepng( $image );
    
    imagedestroy( $image );
}

function larisdigital_font_preview_hex2rgb($hex, $default = array(0, 0, 0)) {
    if (empty($hex)) {
        return $default;
    }
    $hex = str_replace(array('#',' '), '', $hex);
    if (strlen(trim($hex)) !== 6) {
        return $default;
    }
    return array(
        hexdec(substr($hex, 0, 2)), // R
        hexdec(substr($hex, 2, 2)), // G
        hexdec(substr($hex, 4, 2)), // B
    );
}
