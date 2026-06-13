<?php
/**
 * Rillatype V2 Customizer Settings
 */

add_action('customize_register', 'rillatype_customize_register');
function rillatype_customize_register($wp_customize) {

  // ── Featured Products ──────────────────────────

  $wp_customize->add_section('rillatype_featured', array(
    'title'       => __('Featured Products', 'rillatype-v2'),
    'priority'    => 130,
    'description' => __('Set featured products via Products → click the star ★ on any product.', 'rillatype-v2'),
  ));

  $wp_customize->add_setting('rillatype_featured_count', array(
    'default'           => 3,
    'sanitize_callback' => 'absint',
    'capability'        => 'edit_theme_options',
  ));

  $wp_customize->add_control('rillatype_featured_count', array(
    'label'       => __('Number of featured products', 'rillatype-v2'),
    'section'     => 'rillatype_featured',
    'type'        => 'number',
    'input_attrs' => array(
      'min'  => 1,
      'max'  => 12,
      'step' => 1,
    ),
  ));

  // ── Fresh Drops ────────────────────────────────

  $wp_customize->add_section('rillatype_latest', array(
    'title'       => __('Fresh Drops', 'rillatype-v2'),
    'priority'    => 131,
  ));

  $wp_customize->add_setting('rillatype_latest_count', array(
    'default'           => 8,
    'sanitize_callback' => 'absint',
    'capability'        => 'edit_theme_options',
  ));

  $wp_customize->add_control('rillatype_latest_count', array(
    'label'       => __('Number of products', 'rillatype-v2'),
    'section'     => 'rillatype_latest',
    'type'        => 'number',
    'input_attrs' => array(
      'min'  => 1,
      'max'  => 24,
      'step' => 1,
    ),
  ));

  $wp_customize->add_setting('rillatype_latest_orderby', array(
    'default'           => 'date',
    'sanitize_callback' => 'sanitize_text_field',
    'capability'        => 'edit_theme_options',
  ));

  $wp_customize->add_control('rillatype_latest_orderby', array(
    'label'       => __('Sort by', 'rillatype-v2'),
    'section'     => 'rillatype_latest',
    'type'        => 'select',
    'choices'     => array(
      'date'      => __('Newest first', 'rillatype-v2'),
      'title'     => __('Alphabetical (A-Z)', 'rillatype-v2'),
      'modified'  => __('Recently updated', 'rillatype-v2'),
      'rand'      => __('Random', 'rillatype-v2'),
      'price'     => __('Price (low to high)', 'rillatype-v2'),
      'price-desc' => __('Price (high to low)', 'rillatype-v2'),
    ),
  ));
}
