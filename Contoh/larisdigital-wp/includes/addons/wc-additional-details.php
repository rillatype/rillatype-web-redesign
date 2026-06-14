<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'woocommerce' ) ) {
	return;
}

if ( is_admin() && function_exists('acf_add_local_field_group') ):

$tpad_locations = array();
$tpad_taxs = wc_get_attribute_taxonomies();
if ( !empty($tpad_taxs) ) {
	foreach ($tpad_taxs as $tpad_tax) {
		$tpad_locations[] = array(
			array(
				'param' => 'taxonomy',
				'operator' => '==',
				'value' => 'pa_'.$tpad_tax->attribute_name,
			),
		);
	}
}

if ( !empty($tpad_locations) ) :

acf_add_local_field_group(array(
	'key' => 'group_5f500a33a0ee1',
	'title' => 'Additional Details',
	'fields' => array(
		array(
			'key' => 'field_5f500a60e9650',
			'label' => 'Additional Details',
			'name' => '_additional_details',
			'type' => 'wysiwyg',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'tabs' => 'visual',
			'toolbar' => 'basic',
			'media_upload' => 0,
			'delay' => 0,
		),
	),
	'location' => $tpad_locations,
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

endif;

endif;

add_action( 'woocommerce_before_single_variation', 'larisdigital_wc_additional_details_output' );
function larisdigital_wc_additional_details_output() {
	global $product;
	if ( empty( $product ) ) {
		$product = wc_get_product( get_the_ID() );
	}
	// var_dump($attributes);
	$additional_details = array();
	$attributes = $product->get_variation_attributes();
	foreach ( $attributes as $attribute => $variations ) {
		$terms = get_terms( $attribute, array(
			'hide_empty' => false,
		) );
		$term_ids = array();
		foreach ( $terms as $term) {
			if ( isset($term->slug) && isset($term->term_id) ) {
				$term_ids[$term->slug] = $term->term_id;
			}
		}
		foreach ($variations as $variation_slug) {
			if (isset($term_ids[$variation_slug])) {
				$variation_id = $term_ids[$variation_slug];
				$detail = get_term_meta( $variation_id, '_additional_details', true );
				if ( !empty($detail) ) {
					echo '<div class="tpad-'.esc_attr($attribute).' tpad-'.esc_attr($attribute).'-'.esc_attr($variation_slug).'" style="display:none;">';
					echo wp_kses_post(wpautop($detail));
					echo '</div>';
				}
			}
		}
	}
}

add_action( 'woocommerce_after_cart_item_name', 'larisdigital_wc_after_cart_item_name', 20, 2);
function larisdigital_wc_after_cart_item_name( $cart_item, $cart_item_key ) {
	if (!empty($cart_item['variation']) && is_array($cart_item['variation'])) {
		foreach ($cart_item['variation'] as $key => $value) {
			$meta_key   = rawurldecode( (string) $key );
			$meta_value = rawurldecode( (string) $value );
			$attribute_key = str_replace( 'attribute_', '', $meta_key );
			if ( taxonomy_exists( $attribute_key ) ) {
				$term = get_term_by( 'slug', $meta_value, $attribute_key );
				if ( ! is_wp_error( $term ) && is_object( $term ) && $term->name ) {
			        if ( !empty( $term->description ) ) {
				        echo wpautop( $term->description );
			        }
					$detail = get_term_meta( $term->term_id, '_additional_details', true );
			        if ( !empty( $detail ) ) {
				        echo wpautop( $detail );
			        }
				}
			}
		}
	}
}

add_action( 'woocommerce_order_item_meta_end', 'larisdigital_wc_order_item_meta_end', 10, 3 );
function larisdigital_wc_order_item_meta_end( $item_id, $item, $order ) {
	if ( ! is_callable( array( $item, 'get_meta_data' ) ) ) {
		return;
	}
	$meta_data = $item->get_meta_data();
	foreach ( $meta_data as $meta ) {
		$meta->key     = rawurldecode( (string) $meta->key );
		$meta->value   = rawurldecode( (string) $meta->value );
		$attribute_key = str_replace( 'attribute_', '', $meta->key );
		if ( taxonomy_exists( $attribute_key ) ) {
			$term = get_term_by( 'slug', $meta->value, $attribute_key );
			if ( ! is_wp_error( $term ) && is_object( $term ) && $term->name ) {
		        if ( !empty( $term->description ) ) {
			        echo wpautop( $term->description );
		        }
				$detail = get_term_meta( $term->term_id, '_additional_details', true );
		        if ( !empty( $detail ) ) {
			        echo wpautop( $detail );
		        }
			}
		}
	}
}

add_action( 'wpo_wcpdf_after_item_meta', 'larisdigital_wc_pdf_after_item_meta', 10, 3 );
function larisdigital_wc_pdf_after_item_meta( $type, $item, $order ) {
	if ( !isset($item['item']) || empty($item['item']) ) {
		return;
	}
	$item_data = $item['item'];
	if ( ! is_callable( array( $item_data, 'get_meta_data' ) ) ) {
		return;
	}
	$meta_data = $item_data->get_meta_data();
	foreach ( $meta_data as $meta ) {
		$meta->key     = rawurldecode( (string) $meta->key );
		$meta->value   = rawurldecode( (string) $meta->value );
		$attribute_key = str_replace( 'attribute_', '', $meta->key );
		if ( taxonomy_exists( $attribute_key ) ) {
			$term = get_term_by( 'slug', $meta->value, $attribute_key );
			if ( ! is_wp_error( $term ) && is_object( $term ) && $term->name ) {
		        if ( !empty( $term->description ) ) {
			        echo wpautop( $term->description );
		        }
				$detail = get_term_meta( $term->term_id, '_additional_details', true );
		        if ( !empty( $detail ) ) {
			        echo wpautop( $detail );
		        }
			}
		}
	}
}
