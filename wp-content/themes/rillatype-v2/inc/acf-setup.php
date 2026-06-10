<?php
/**
 * ACF Options pages and field setup.
 */

if (!class_exists('ACF')) {
  return;
}

if (function_exists('acf_add_options_page')) {
  acf_add_options_page(array(
    'page_title' => __('Hero Options', 'rillatype-v2'),
    'menu_title' => __('Hero Options', 'rillatype-v2'),
    'menu_slug'  => 'hero-options',
    'capability' => 'edit_posts',
    'redirect'   => false,
  ));

  acf_add_options_page(array(
    'page_title' => __('Font Categories', 'rillatype-v2'),
    'menu_title' => __('Font Categories', 'rillatype-v2'),
    'menu_slug'  => 'font-categories',
    'capability' => 'edit_posts',
    'redirect'   => false,
  ));
}

if (function_exists('acf_add_local_field_group')) {

  acf_add_local_field_group(array(
    'key'    => 'group_hero_options',
    'title'  => __('Hero Options', 'rillatype-v2'),
    'fields' => array(
      array(
        'key'   => 'field_hero_title',
        'label' => __('Hero Title', 'rillatype-v2'),
        'name'  => 'hero_title',
        'type'  => 'text',
        'default_value' => __('Discover Premium Typefaces', 'rillatype-v2'),
      ),
      array(
        'key'   => 'field_hero_subtitle',
        'label' => __('Hero Subtitle', 'rillatype-v2'),
        'name'  => 'hero_subtitle',
        'type'  => 'textarea',
        'rows'  => 2,
        'default_value' => __('Crafted for designers who demand the finest letterforms.', 'rillatype-v2'),
      ),
      array(
        'key'   => 'field_hero_image',
        'label' => __('Hero Image', 'rillatype-v2'),
        'name'  => 'hero_image',
        'type'  => 'image',
        'return_format' => 'id',
      ),
      array(
        'key'   => 'field_hero_label',
        'label' => __('Hero Button Label', 'rillatype-v2'),
        'name'  => 'hero_label',
        'type'  => 'text',
        'default_value' => __('Browse Fonts', 'rillatype-v2'),
      ),
    ),
    'location' => array(
      array(
        array(
          'param'    => 'options_page',
          'operator' => '==',
          'value'    => 'hero-options',
        ),
      ),
    ),
    'menu_order' => 0,
  ));

  acf_add_local_field_group(array(
    'key'    => 'group_font_categories',
    'title'  => __('Font Categories', 'rillatype-v2'),
    'fields' => array(
      array(
        'key'      => 'field_font_categories',
        'label'    => __('Font Categories', 'rillatype-v2'),
        'name'     => 'font_categories',
        'type'     => 'repeater',
        'collapsed' => 'field_category_name',
        'min'      => 1,
        'sub_fields' => array(
          array(
            'key'   => 'field_category_name',
            'label' => __('Category Name', 'rillatype-v2'),
            'name'  => 'category_name',
            'type'  => 'text',
          ),
          array(
            'key'   => 'field_category_link',
            'label' => __('Category Link', 'rillatype-v2'),
            'name'  => 'category_link',
            'type'  => 'url',
          ),
        ),
      ),
    ),
    'location' => array(
      array(
        array(
          'param'    => 'options_page',
          'operator' => '==',
          'value'    => 'font-categories',
        ),
      ),
    ),
    'menu_order' => 0,
  ));
}
