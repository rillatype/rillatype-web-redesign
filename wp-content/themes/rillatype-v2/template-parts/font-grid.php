<?php
/**
 * Font grid template part.
 *
 * @param array $args {
 *   Optional. Arguments for the grid.
 *   @type array $product_ids Array of WooCommerce product IDs.
 *   @type int   $columns     Number of grid columns (default 3).
 * }
 */

$product_ids = isset($args['product_ids']) && is_array($args['product_ids']) ? $args['product_ids'] : array();
$columns     = isset($args['columns']) ? intval($args['columns']) : 3;

if (empty($product_ids)) {
  // Placeholder product IDs for demo mode
  $product_ids = array(0, 0, 0, 0, 0, 0);
}
?>

<div class="font-grid" style="--font-grid-columns: <?php echo esc_attr($columns); ?>">
  <?php foreach ($product_ids as $pid) : ?>
    <?php get_template_part('template-parts/font-card', null, array('product_id' => $pid)); ?>
  <?php endforeach; ?>
</div>
