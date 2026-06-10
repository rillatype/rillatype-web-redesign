<?php
/**
 * Breadcrumb template — Minimal
 *
 * @package Rillatype_Theme
 */

defined('ABSPATH') || exit;

if (!empty($breadcrumb)) {
  echo '<nav class="woocommerce-breadcrumb">';

  foreach ($breadcrumb as $key => $crumb) {
    if (!empty($crumb[1]) && sizeof($breadcrumb) !== $key + 1) {
      echo '<a href="' . esc_url($crumb[1]) . '">' . esc_html($crumb[0]) . '</a>';
      echo '<span class="separator"> / </span>';
    } else {
      echo '<span class="current">' . esc_html($crumb[0]) . '</span>';
    }
  }

  echo '</nav>';
}
