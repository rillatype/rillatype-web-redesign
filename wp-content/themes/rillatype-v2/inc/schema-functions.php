<?php
/**
 * JSON-LD Schema functions.
 */

/**
 * Output Organization schema.
 */
function rillatype_organization_schema() {
  $org = array(
    '@context'        => 'https://schema.org',
    '@type'           => 'Organization',
    'name'            => 'Rillatype Studio',
    'description'     => __('Premium font foundry crafting distinctive typefaces for designers, brands, and creatives.', 'rillatype-v2'),
    'url'             => home_url('/'),
    'foundingDate'    => '2022',
    'foundingLocation' => array(
      '@type' => 'Place',
      'name'  => 'Stockholm, Sweden',
    ),
    'sameAs'          => array(
      'https://twitter.com/rillatype',
      'https://www.instagram.com/rillatype/',
    ),
  );

  if (function_exists('get_field') && class_exists('ACF')) {
    $logo_id = get_field('hero_image', 'option');
    if ($logo_id) {
      $logo_src = wp_get_attachment_image_url($logo_id, 'full');
      if ($logo_src) {
        $org['logo'] = esc_url($logo_src);
      }
    }
  }

  return $org;
}

/**
 * Output WebSite schema with search action.
 */
function rillatype_website_schema() {
  return array(
    '@context'        => 'https://schema.org',
    '@type'           => 'WebSite',
    'name'            => get_bloginfo('name'),
    'url'             => home_url('/'),
    'potentialAction' => array(
      '@type'       => 'SearchAction',
      'target'      => array(
        '@type'       => 'EntryPoint',
        'urlTemplate' => home_url('/?s={search_term_string}'),
      ),
      'query-input' => 'required name=search_term_string',
    ),
  );
}

/**
 * Output Product schema for a font product.
 *
 * @param int $product_id WooCommerce product ID.
 */
function rillatype_product_schema($product_id) {
  if (!$product_id || !function_exists('wc_get_product')) {
    return null;
  }

  $product = wc_get_product($product_id);
  if (!$product) {
    return null;
  }

  $schema = array(
    '@context'    => 'https://schema.org',
    '@type'       => 'Product',
    '@id'         => esc_url(get_permalink($product_id)) . '#product',
    'name'        => esc_html($product->get_name()),
    'description' => esc_html(wp_strip_all_tags($product->get_short_description())),
    'url'         => esc_url(get_permalink($product_id)),
    'offers'      => array(
      '@type'         => 'Offer',
      'price'         => $product->get_price(),
      'priceCurrency' => get_woocommerce_currency(),
      'availability'  => $product->is_in_stock() ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
      'url'           => esc_url(get_permalink($product_id)),
    ),
  );

  $image_id = $product->get_image_id();
  if ($image_id) {
    $image_src = wp_get_attachment_image_url($image_id, 'full');
    if ($image_src) {
      $schema['image'] = esc_url($image_src);
    }
  }

  return $schema;
}

/**
 * Output all schemas in wp_head.
 */
add_action('wp_head', function () {
  $schemas = array();

  $schemas[] = rillatype_organization_schema();
  $schemas[] = rillatype_website_schema();

  if (is_product() && function_exists('wc_get_product')) {
    global $product;
    if ($product) {
      $product_schema = rillatype_product_schema($product->get_id());
      if ($product_schema) {
        $schemas[] = $product_schema;
      }
    }
  }

  echo '<script type="application/ld+json">' . "\n";
  foreach ($schemas as $schema) {
    echo wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n";
  }
  echo '</script>' . "\n";
});
