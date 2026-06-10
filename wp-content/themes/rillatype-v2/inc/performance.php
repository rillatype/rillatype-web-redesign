<?php
/**
 * Performance optimizations.
 */

// Remove emoji scripts
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');
remove_filter('the_content_feed', 'wp_staticize_emoji');
remove_filter('comment_text_rss', 'wp_staticize_emoji');
remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

// Remove wp-embed
add_action('wp_footer', function () {
  wp_dequeue_script('wp-embed');
});

// Remove generator tags
remove_action('wp_head', 'wp_generator');

// Remove WLW manifest
remove_action('wp_head', 'wlwmanifest_link');

// Remove RSD link
remove_action('wp_head', 'rsd_link');

// Remove shortlink
remove_action('wp_head', 'wp_shortlink_wp_head');

// Disable self-pingbacks
add_action('pre_ping', function (&$links) {
  foreach ($links as $l => $link) {
    if (0 === strpos($link, home_url())) {
      unset($links[$l]);
    }
  }
});

// Add missing image attributes on upload
add_filter('wp_get_attachment_image_attributes', function ($attr, $attachment, $size) {
  if (!isset($attr['alt'])) {
    $attr['alt'] = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
    if (empty($attr['alt'])) {
      $attr['alt'] = get_the_title($attachment->ID);
    }
  }
  return $attr;
}, 10, 3);

// Remove dashicons on frontend for non-admins
add_action('wp_enqueue_scripts', function () {
  if (!is_user_logged_in() || !current_user_can('manage_options')) {
    wp_dequeue_style('dashicons');
    wp_deregister_style('dashicons');
  }
});

// Defer JS (exclude jQuery and critical inline scripts)
add_filter('script_loader_tag', function ($tag, $handle) {
  if (is_admin()) {
    return $tag;
  }
  $skip = array('jquery', 'jquery-core', 'jquery-migrate');
  if (in_array($handle, $skip, true)) {
    return $tag;
  }
  if (strpos($tag, 'defer') !== false) {
    return $tag;
  }
  $ext = pathinfo(parse_url($tag, PHP_URL_URL), PATHINFO_EXTENSION);
  if ($ext === 'js') {
    return str_replace(' src', ' defer src', $tag);
  }
  return $tag;
}, 10, 2);

// Preload hero image from ACF if available
add_action('wp_head', function () {
  if (!class_exists('ACF')) {
    return;
  }
  $hero_image_id = get_field('hero_image', 'option');
  if (!$hero_image_id) {
    return;
  }
  $src = wp_get_attachment_image_url($hero_image_id, 'full');
  if ($src) {
    echo '<link rel="preload" href="' . esc_url($src) . '" as="image">' . "\n";
  }
});
