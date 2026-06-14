<?php

/**
 * Single Product Attribute
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

$title = larisdigital_theme_mod( 'larisdigital_wc_product_item_details_title' );
if ( ! empty( $title ) ) {
	$title = $title;
}
else {
	$title = esc_html__( 'Product Information' , 'larisdigital-wp');
}

$attributes = $product->get_attributes();

$cat_terms = get_the_terms( $product->get_ID(), 'product_cat' );
$tag_terms = get_the_terms( $product->get_ID(), 'product_tag' );

$cat_count = !empty( $cat_terms ) && is_array( $cat_terms ) ? count( $cat_terms ) : 0;
$tag_count = !empty( $tag_terms ) && is_array( $tag_terms ) ? count( $tag_terms ) : 0;

?>

<h3><?php echo esc_html( $title); ?></h3>

<table class="table list-item-details">

	<?php if ( version_compare( WC_VERSION, '3.0.0', '>=' ) ) : ?>

		<?php if ( apply_filters( 'wc_product_enable_dimensions_display', $product->has_weight() || $product->has_dimensions() ) ) : ?>

			<?php if ( $product->has_weight() ) : ?>
				<?php printf( '<tr><td class="item-label">%s</td><td class="item-value">%s</td></tr>', __( 'Weight', 'larisdigital-wp' ), esc_html( wc_format_weight( $product->get_weight() ) ) ); ?>
			<?php endif; ?>

			<?php if ( $product->has_dimensions() ) : ?>
				<?php printf( '<tr><td class="item-label">%s</td><td class="item-value">%s</td></tr>', __( 'Dimensions', 'larisdigital-wp' ), esc_html( wc_format_dimensions( $product->get_dimensions( false ) ) ) ); ?>
			<?php endif; ?>

		<?php endif; ?>

		<?php foreach ( $attributes as $attribute ) : ?>
			<?php if( !$attribute->get_visible() ) continue; ?>
			<tr>
				<td class="item-label"><?php echo wc_attribute_label( $attribute->get_name() ); ?></td>
				<td class="item-value"><?php

					$values = array();

					if ( $attribute->is_taxonomy() ) {
						$attribute_taxonomy = $attribute->get_taxonomy_object();
						$attribute_values = wc_get_product_terms( $product->get_id(), $attribute->get_name(), array( 'fields' => 'all' ) );

						foreach ( $attribute_values as $attribute_value ) {
							$value_name = esc_html( $attribute_value->name );

							if ( $attribute_taxonomy->attribute_public ) {
								$values[] = '<a href="' . esc_url( get_term_link( $attribute_value->term_id, $attribute->get_name() ) ) . '" rel="tag">' . $value_name . '</a>';
							} else {
								$values[] = $value_name;
							}
						}
					} else {
						$values = $attribute->get_options();

						foreach ( $values as &$value ) {
							$value = esc_html( $value );
						}
					}

					echo apply_filters( 'woocommerce_attribute', wptexturize( implode( ', ', $values ) ), $attribute, $values );
				?></td>
			</tr>
		<?php endforeach; ?>

	<?php else : ?>

		<?php if ( $product->enable_dimensions_display() ) : ?>

			<?php if ( $product->has_weight() ) : $has_row = true; ?>
				<?php printf( '<tr><td class="item-label">%s</td><td class="item-value">%s</td></tr>', __( 'Weight', 'larisdigital-wp' ), $product->get_weight() . ' ' . esc_attr( get_option( 'woocommerce_weight_unit' ) ) ); ?>
			<?php endif; ?>

			<?php if ( $product->has_dimensions() ) : $has_row = true; ?>
				<?php printf( '<tr><td class="item-label">%s</td><td class="item-value">%s</td></tr>', __( 'Dimensions', 'larisdigital-wp' ), $product->get_dimensions() ); ?>
			<?php endif; ?>

		<?php endif; ?>

		<?php foreach ( $attributes as $attribute ) :
			if ( empty( $attribute['is_visible'] ) || ( $attribute['is_taxonomy'] && ! taxonomy_exists( $attribute['name'] ) ) ) {
				continue;
			}
			?>
			<tr>
				<td class="item-label"> <?php echo wc_attribute_label( $attribute['name'] ); ?> </td>
				<td class="item-value">

					<?php
					if ( $attribute['is_taxonomy'] ) {
						$values = wc_get_product_terms( $product->id, $attribute['name'], array( 'fields' => 'names' ) );
						echo apply_filters( 'woocommerce_attribute', implode( ', ', $values ), $attribute, $values );
					}
					else {
						// Convert pipes to commas and display values
						$values = array_map( 'trim', explode( WC_DELIMITER, $attribute['value'] ) );
						echo apply_filters( 'woocommerce_attribute', implode( ', ', $values ), $attribute, $values );
					}
					?>
				</td>
			</tr>
		<?php endforeach; ?>

	<?php endif; ?>

	<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

		<tr><td class="item-label"><?php esc_html_e( 'SKU', 'larisdigital-wp' ); ?></td><td class="item-value"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'larisdigital-wp' ); ?></td></tr>

	<?php endif; ?>

	<?php if ( version_compare( WC_VERSION, '3.0.0', '>=' ) ) : ?>
		<?php echo wc_get_product_category_list( $product->get_id(), ', ', '<tr><td class="item-label">' . _n( 'Category', 'Categories', $cat_count, 'larisdigital-wp' ) . '</td><td class="item-value">', '</td></tr>' ); ?>
		<?php echo wc_get_product_tag_list( $product->get_id(), ', ', '<tr><td class="item-label">' . _n( 'Tag', 'Tags', $tag_count, 'larisdigital-wp' ) . '</td><td class="item-value">', '</td></tr>' ); ?>
	<?php else : ?>
		<?php printf( '%s', $product->get_categories( ', ', '<tr><td class="item-label">' . _n( 'Category', 'Categories', $cat_count, 'larisdigital-wp' ) . '</td><td class="item-value">', '</td></tr>' ) ); ?>
		<?php printf( '%s', $product->get_tags( ', ', '<tr><td class="item-label">' . _n( 'Tag', 'Tags', $tag_count, 'larisdigital-wp' ) . '</td><td class="item-value">', '</td></tr>' ) ); ?>
	<?php endif; ?>

</table>
