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

  acf_add_options_page(array(
    'page_title' => __('Homepage Sections', 'rillatype-v2'),
    'menu_title' => __('Homepage Sections', 'rillatype-v2'),
    'menu_slug'  => 'homepage-sections',
    'capability' => 'edit_posts',
    'redirect'   => false,
    'position'   => 61,
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
        'default_value' => __('Where type meets craft.', 'rillatype-v2'),
      ),
      array(
        'key'   => 'field_hero_text',
        'label' => __('Hero Text', 'rillatype-v2'),
        'name'  => 'hero_text',
        'type'  => 'textarea',
        'rows'  => 2,
        'default_value' => __('Premium display & text fonts for designers who refuse to compromise.', 'rillatype-v2'),
      ),
      array(
        'key'   => 'field_hero_image',
        'label' => __('Hero Image', 'rillatype-v2'),
        'name'  => 'hero_image',
        'type'  => 'image',
        'return_format' => 'array',
      ),
      array(
        'key'   => 'field_hero_cta_text',
        'label' => __('Button Label', 'rillatype-v2'),
        'name'  => 'hero_cta_text',
        'type'  => 'text',
        'default_value' => __('Browse Fonts', 'rillatype-v2'),
      ),
      array(
        'key'   => 'field_hero_cta_url',
        'label' => __('Button URL', 'rillatype-v2'),
        'name'  => 'hero_cta_url',
        'type'  => 'url',
        'default_value' => home_url('/shop'),
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

  // ── Featured Fonts ──
  acf_add_local_field_group(array(
    'key'    => 'group_home_featured',
    'title'  => __('Featured Fonts', 'rillatype-v2'),
    'fields' => array(
      array(
        'key'   => 'field_home_featured_enable',
        'label' => __('Show Featured Section', 'rillatype-v2'),
        'name'  => 'home_featured_enable',
        'type'  => 'true_false',
        'ui'    => true,
        'default_value' => 1,
      ),
      array(
        'key'   => 'field_home_featured_title',
        'label' => __('Section Title', 'rillatype-v2'),
        'name'  => 'home_featured_title',
        'type'  => 'text',
        'default_value' => __('Featured Specimens', 'rillatype-v2'),
      ),
      array(
        'key'      => 'field_home_featured_products',
        'label'    => __('Pick Products', 'rillatype-v2'),
        'name'     => 'home_featured_products',
        'type'     => 'repeater',
        'min'      => 1,
        'max'      => 12,
        'button_label' => __('Add Product', 'rillatype-v2'),
        'sub_fields' => array(
          array(
            'key'   => 'field_featured_product',
            'label' => __('Product', 'rillatype-v2'),
            'name'  => 'product',
            'type'  => 'post_object',
            'post_type' => array('product'),
            'return_format' => 'object',
          ),
        ),
      ),
    ),
    'location' => array(
      array(
        array(
          'param'    => 'options_page',
          'operator' => '==',
          'value'    => 'homepage-sections',
        ),
      ),
    ),
    'menu_order' => 1,
  ));

  // ── Free Stuff ──
  acf_add_local_field_group(array(
    'key'    => 'group_home_free',
    'title'  => __('Free Stuff', 'rillatype-v2'),
    'fields' => array(
      array(
        'key'   => 'field_home_free_enable',
        'label' => __('Show Free Section', 'rillatype-v2'),
        'name'  => 'home_free_enable',
        'type'  => 'true_false',
        'ui'    => true,
        'default_value' => 1,
      ),
      array(
        'key'   => 'field_home_free_title',
        'label' => __('Section Title', 'rillatype-v2'),
        'name'  => 'home_free_title',
        'type'  => 'text',
        'default_value' => __('Free Stuff', 'rillatype-v2'),
      ),
      array(
        'key'   => 'field_home_free_count',
        'label' => __('Number of Items', 'rillatype-v2'),
        'name'  => 'home_free_count',
        'type'  => 'number',
        'default_value' => 6,
        'min'   => 1,
        'max'   => 30,
      ),
      array(
        'key'   => 'field_home_free_sort',
        'label' => __('Sort Order', 'rillatype-v2'),
        'name'  => 'home_free_sort',
        'type'  => 'select',
        'choices' => array(
          'random' => __('Random', 'rillatype-v2'),
          'date'   => __('Newest First', 'rillatype-v2'),
        ),
        'default_value' => 'random',
      ),
    ),
    'location' => array(
      array(
        array(
          'param'    => 'options_page',
          'operator' => '==',
          'value'    => 'homepage-sections',
        ),
      ),
    ),
    'menu_order' => 2,
  ));

  // ── Fresh Drops ──
  acf_add_local_field_group(array(
    'key'    => 'group_home_fresh',
    'title'  => __('Fresh Drops', 'rillatype-v2'),
    'fields' => array(
      array(
        'key'   => 'field_home_fresh_enable',
        'label' => __('Show Fresh Drops Section', 'rillatype-v2'),
        'name'  => 'home_fresh_enable',
        'type'  => 'true_false',
        'ui'    => true,
        'default_value' => 1,
      ),
      array(
        'key'   => 'field_home_fresh_title',
        'label' => __('Section Title', 'rillatype-v2'),
        'name'  => 'home_fresh_title',
        'type'  => 'text',
        'default_value' => __('Fresh Drops', 'rillatype-v2'),
      ),
      array(
        'key'   => 'field_home_fresh_cols',
        'label' => __('Columns', 'rillatype-v2'),
        'name'  => 'home_fresh_cols',
        'type'  => 'number',
        'default_value' => 4,
        'min'   => 2,
        'max'   => 6,
      ),
      array(
        'key'   => 'field_home_fresh_rows',
        'label' => __('Rows', 'rillatype-v2'),
        'name'  => 'home_fresh_rows',
        'type'  => 'number',
        'default_value' => 1,
        'min'   => 1,
        'max'   => 6,
      ),
    ),
    'location' => array(
      array(
        array(
          'param'    => 'options_page',
          'operator' => '==',
          'value'    => 'homepage-sections',
        ),
      ),
    ),
    'menu_order' => 3,
  ));

  // ── Sale Section ──
  acf_add_local_field_group(array(
    'key'    => 'group_home_sale',
    'title'  => __('Sale Section', 'rillatype-v2'),
    'fields' => array(
      array(
        'key'   => 'field_home_sale_enable',
        'label' => __('Show Sale Section', 'rillatype-v2'),
        'name'  => 'home_sale_enable',
        'type'  => 'true_false',
        'ui'    => true,
        'default_value' => 0,
      ),
      array(
        'key'   => 'field_home_sale_title',
        'label' => __('Section Title', 'rillatype-v2'),
        'name'  => 'home_sale_title',
        'type'  => 'text',
        'default_value' => __('On Sale', 'rillatype-v2'),
      ),
      array(
        'key'   => 'field_home_sale_count',
        'label' => __('Number of Items', 'rillatype-v2'),
        'name'  => 'home_sale_count',
        'type'  => 'number',
        'default_value' => 4,
        'min'   => 1,
        'max'   => 30,
      ),
      array(
        'key'   => 'field_home_sale_cols',
        'label' => __('Columns', 'rillatype-v2'),
        'name'  => 'home_sale_cols',
        'type'  => 'number',
        'default_value' => 4,
        'min'   => 2,
        'max'   => 6,
      ),
    ),
    'location' => array(
      array(
        array(
          'param'    => 'options_page',
          'operator' => '==',
          'value'    => 'homepage-sections',
        ),
      ),
    ),
    'menu_order' => 4,
  ));
  // ── Product Font Data ──
  acf_add_local_field_group(array(
    'key'    => 'group_product_font',
    'title'  => __('Font Data', 'rillatype-v2'),
    'fields' => array(
      array(
        'key'   => 'field_specimen_regular_url',
        'label' => __('Specimen Regular URL', 'rillatype-v2'),
        'name'  => 'specimen_regular_url',
        'type'  => 'text',
        'instructions' => __('URL to the TTF/OTF file for the font tester.', 'rillatype-v2'),
        'placeholder' => 'https://...',
      ),
      array(
        'key'   => 'field_specimen_bold_url',
        'label' => __('Specimen Bold URL', 'rillatype-v2'),
        'name'  => 'specimen_bold_url',
        'type'  => 'text',
        'instructions' => __('URL to the Bold TTF/OTF file (optional).', 'rillatype-v2'),
        'placeholder' => 'https://...',
      ),
      array(
        'key'   => 'field_font_formats',
        'label' => __('Formats', 'rillatype-v2'),
        'name'  => 'font_formats',
        'type'  => 'text',
        'default_value' => 'OTF, TTF',
      ),
      array(
        'key'   => 'field_glyphs_count',
        'label' => __('Glyphs Count', 'rillatype-v2'),
        'name'  => 'glyphs_count',
        'type'  => 'text',
        'default_value' => '350+',
      ),
      array(
        'key'   => 'field_available_weights',
        'label' => __('Available Weights', 'rillatype-v2'),
        'name'  => 'available_weights',
        'type'  => 'text',
        'default_value' => 'Regular',
      ),
    ),
    'location' => array(
      array(
        array(
          'param'    => 'post_type',
          'operator' => '==',
          'value'    => 'product',
        ),
      ),
    ),
    'menu_order' => 5,
  ));
}
