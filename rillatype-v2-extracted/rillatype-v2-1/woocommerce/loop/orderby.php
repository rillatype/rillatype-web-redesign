<?php
if (!$catalog_orderby_options) $catalog_orderby_options = apply_filters('woocommerce_catalog_orderby', array(
  'menu_order' => __('Default', 'rillatype-v2'),
  'popularity' => __('Popular', 'rillatype-v2'),
  'rating'     => __('Best rated', 'rillatype-v2'),
  'date'       => __('Newest', 'rillatype-v2'),
  'price'      => __('Price: low to high', 'rillatype-v2'),
  'price-desc' => __('Price: high to low', 'rillatype-v2'),
));
$orderby = isset($orderby) ? $orderby : apply_filters('woocommerce_default_catalog_orderby', get_option('woocommerce_default_catalog_orderby', 'menu_order'));
?>
<form class="shop-sort" method="get">
  <select name="orderby" class="shop-sort__select" aria-label="<?php esc_attr_e('Sort by', 'rillatype-v2'); ?>" onchange="this.form.submit()">
    <?php foreach ($catalog_orderby_options as $key => $label) : ?>
      <option value="<?php echo esc_attr($key); ?>" <?php selected($orderby, $key); ?>><?php echo esc_html($label); ?></option>
    <?php endforeach; ?>
  </select>
  <?php wc_query_string_form_fields(null, array('orderby', 'submit', 'paged', 'product-page')); ?>
</form>
