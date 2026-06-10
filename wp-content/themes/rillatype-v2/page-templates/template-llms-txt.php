<?php
/**
 * Template Name: LLMs.txt
 * Description: Outputs plain text structured content for LLMs.txt consumption.
 */

// Prevent HTML output
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// Clear all buffers and output plain text
while (ob_get_level()) {
  ob_end_clean();
}

header('Content-Type: text/plain; charset=' . get_option('blog_charset'));

echo "================================\n";
echo "Rillatype - Font Foundry\n";
echo "================================\n";
echo "URL: " . home_url('/') . "\n";
echo "Description: Premium minimalist font foundry\n";
echo "================================\n\n";

echo "NAVIGATION\n";
echo "--------------------------------\n";
echo "- Home: " . home_url('/') . "\n";
echo "- Shop: " . home_url('/shop') . "\n";
echo "- About: " . home_url('/about') . "\n";
echo "- Blog: " . home_url('/blog') . "\n";
echo "- Contact: " . home_url('/contact') . "\n\n";

echo "SITE INFORMATION\n";
echo "--------------------------------\n";
echo "Name: " . get_bloginfo('name') . "\n";
echo "Description: " . get_bloginfo('description') . "\n";
echo "Language: " . get_bloginfo('language') . "\n\n";

// Content
if (have_posts()) {
  while (have_posts()) {
    the_post();

    echo "PAGE: " . get_the_title() . "\n";
    echo "--------------------------------\n";
    $content = strip_tags(get_the_content());
    $content = preg_replace('/\n\s*\n\s*\n/', "\n\n", $content);
    echo $content . "\n\n";
  }
}

// Recent posts
$recent = new WP_Query(array(
  'post_type'      => 'post',
  'posts_per_page' => 5,
  'ignore_sticky_posts' => true,
));

if ($recent->have_posts()) {
  echo "RECENT JOURNAL POSTS\n";
  echo "--------------------------------\n";
  while ($recent->have_posts()) {
    $recent->the_post();
    echo "- " . get_the_title() . " (" . get_the_date('Y-m-d') . "): ";
    echo strip_tags(get_the_excerpt() ?: wp_trim_words(get_the_content(), 30));
    echo "\n  URL: " . get_permalink() . "\n\n";
  }
  wp_reset_postdata();
}

// WooCommerce products
if (class_exists('WooCommerce')) {
  $products = new WP_Query(array(
    'post_type'      => 'product',
    'posts_per_page' => 10,
  ));

  if ($products->have_posts()) {
    echo "FONT PRODUCTS\n";
    echo "--------------------------------\n";
    while ($products->have_posts()) {
      $products->the_post();
      $product = wc_get_product(get_the_ID());
      echo "- " . get_the_title();
      if ($product) {
        echo " (" . wp_strip_all_tags($product->get_price_html()) . ")";
      }
      echo "\n  URL: " . get_permalink() . "\n\n";
    }
    wp_reset_postdata();
  }
}

echo "================================\n";
echo "Generated: " . current_time('Y-m-d H:i:s') . "\n";
echo "================================\n";

exit;
