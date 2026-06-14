<?php
/**
 * Rillatype V2 — WordPress Customizer Settings
 * Edit semua dari Appearance > Customize tanpa buka HTML/CSS
 */

if (!defined('ABSPATH')) exit;

// Register Customizer settings
add_action('customize_register', 'rillatype_customizer_register');
function rillatype_customizer_register($wp_customize) {

  // ══════ PANEL: Rillatype Settings ══════
  $wp_customize->add_panel('rillatype_panel', array(
    'title'    => __('Rillatype Settings', 'rillatype-v2'),
    'priority' => 30,
  ));

  // ══════ SECTION: Colors ══════
  $wp_customize->add_section('rillatype_colors', array(
    'title' => __('Colors', 'rillatype-v2'),
    'panel' => 'rillatype_panel',
  ));

  // Accent Color
  $wp_customize->add_setting('rillatype_accent_color', array(
    'default'           => '#C1493A',
    'sanitize_callback' => 'sanitize_hex_color',
    'transport'         => 'postMessage',
  ));
  $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'rillatype_accent_color', array(
    'label'   => __('Accent Color', 'rillatype-v2'),
    'section' => 'rillatype_colors',
  )));

  // Background Color
  $wp_customize->add_setting('rillatype_bg_color', array(
    'default'           => '#F4F2ED',
    'sanitize_callback' => 'sanitize_hex_color',
    'transport'         => 'postMessage',
  ));
  $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'rillatype_bg_color', array(
    'label'   => __('Background Color', 'rillatype-v2'),
    'section' => 'rillatype_colors',
  )));

  // Text Color
  $wp_customize->add_setting('rillatype_text_color', array(
    'default'           => '#1A1814',
    'sanitize_callback' => 'sanitize_hex_color',
    'transport'         => 'postMessage',
  ));
  $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'rillatype_text_color', array(
    'label'   => __('Text Color', 'rillatype-v2'),
    'section' => 'rillatype_colors',
  )));

  // Text Muted Color
  $wp_customize->add_setting('rillatype_text_muted', array(
    'default'           => '#8B877A',
    'sanitize_callback' => 'sanitize_hex_color',
    'transport'         => 'postMessage',
  ));
  $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'rillatype_text_muted', array(
    'label'   => __('Muted Text Color', 'rillatype-v2'),
    'section' => 'rillatype_colors',
  )));

  // Border Color
  $wp_customize->add_setting('rillatype_border_color', array(
    'default'           => '#E2DDD3',
    'sanitize_callback' => 'sanitize_hex_color',
    'transport'         => 'postMessage',
  ));
  $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'rillatype_border_color', array(
    'label'   => __('Border Color', 'rillatype-v2'),
    'section' => 'rillatype_colors',
  )));

  // ══════ SECTION: Typography ══════
  $wp_customize->add_section('rillatype_typography', array(
    'title' => __('Typography', 'rillatype-v2'),
    'panel' => 'rillatype_panel',
  ));

  // Body Font
  $wp_customize->add_setting('rillatype_body_font', array(
    'default'           => 'system',
    'sanitize_callback' => 'sanitize_text_field',
    'transport'         => 'postMessage',
  ));
  $wp_customize->add_control('rillatype_body_font', array(
    'label'   => __('Body Font', 'rillatype-v2'),
    'section' => 'rillatype_typography',
    'type'    => 'select',
    'choices' => array(
      'system'       => __('System Fonts (Fastest)', 'rillatype-v2'),
      'jakarta'      => __('Plus Jakarta Sans', 'rillatype-v2'),
      'inter'        => __('Inter', 'rillatype-v2'),
      'dm-sans'      => __('DM Sans', 'rillatype-v2'),
      'poppins'      => __('Poppins', 'rillatype-v2'),
      'montserrat'   => __('Montserrat', 'rillatype-v2'),
    ),
  ));

  // Heading Font
  $wp_customize->add_setting('rillatype_heading_font', array(
    'default'           => 'serif',
    'sanitize_callback' => 'sanitize_text_field',
    'transport'         => 'postMessage',
  ));
  $wp_customize->add_control('rillatype_heading_font', array(
    'label'   => __('Heading Font', 'rillatype-v2'),
    'section' => 'rillatype_typography',
    'type'    => 'select',
    'choices' => array(
      'serif'            => __('Georgia (Default)', 'rillatype-v2'),
      'instrument-serif' => __('Instrument Serif', 'rillatype-v2'),
      'playfair'         => __('Playfair Display', 'rillatype-v2'),
      'same-as-body'     => __('Same as Body Font', 'rillatype-v2'),
    ),
  ));

  // ══════ SECTION: Logo ══════
  $wp_customize->add_section('rillatype_logo_section', array(
    'title' => __('Logo', 'rillatype-v2'),
    'panel' => 'rillatype_panel',
  ));

  // Logo Text (fallback when no image)
  $wp_customize->add_setting('rillatype_logo_text', array(
    'default'           => 'Rillatype',
    'sanitize_callback' => 'sanitize_text_field',
    'transport'         => 'postMessage',
  ));
  $wp_customize->add_control('rillatype_logo_text', array(
    'label'   => __('Logo Text', 'rillatype-v2'),
    'section' => 'rillatype_logo_section',
    'type'    => 'text',
  ));

  // ══════ SECTION: Footer ══════
  $wp_customize->add_section('rillatype_footer', array(
    'title' => __('Footer', 'rillatype-v2'),
    'panel' => 'rillatype_panel',
  ));

  // Copyright Text
  $wp_customize->add_setting('rillatype_copyright', array(
    'default'           => '',
    'sanitize_callback' => 'sanitize_text_field',
    'transport'         => 'postMessage',
  ));
  $wp_customize->add_control('rillatype_copyright', array(
    'label'       => __('Copyright Text', 'rillatype-v2'),
    'description' => __('Leave empty for default: © 2026 Rillatype. All rights reserved.', 'rillatype-v2'),
    'section'     => 'rillatype_footer',
    'type'        => 'text',
  ));

  // ══════ SECTION: Social Links ══════
  $wp_customize->add_section('rillatype_social', array(
    'title' => __('Social Links', 'rillatype-v2'),
    'panel' => 'rillatype_panel',
  ));

  $socials = array(
    'instagram' => 'Instagram',
    'twitter'   => 'Twitter / X',
    'pinterest' => 'Pinterest',
    'tiktok'    => 'TikTok',
    'dribbble'  => 'Dribbble',
  );

  foreach ($socials as $key => $label) {
    $wp_customize->add_setting("rillatype_social_{$key}", array(
      'default'           => '',
      'sanitize_callback' => 'esc_url_raw',
      'transport'         => 'postMessage',
    ));
    $wp_customize->add_control("rillatype_social_{$key}", array(
      'label'   => $label . ' URL',
      'section' => 'rillatype_social',
      'type'    => 'url',
    ));
  }
}

// ══════ Dynamic CSS Output ══════
add_action('wp_head', 'rillatype_dynamic_css', 999);
function rillatype_dynamic_css() {
  $accent     = get_theme_mod('rillatype_accent_color', '#C1493A');
  $bg         = get_theme_mod('rillatype_bg_color', '#F4F2ED');
  $text       = get_theme_mod('rillatype_text_color', '#1A1814');
  $muted      = get_theme_mod('rillatype_text_muted', '#8B877A');
  $border     = get_theme_mod('rillatype_border_color', '#E2DDD3');
  $body_font  = get_theme_mod('rillatype_body_font', 'system');
  $head_font  = get_theme_mod('rillatype_heading_font', 'serif');

  // Compute accent-hover (darken by 15%)
  $accent_hover = rillatype_darken_hex($accent, 15);

  // Compute accent-soft (accent at 8% opacity)
  $accent_soft = $accent . '14';

  // Font families
  $font_sans_map = array(
    'system'     => "-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif",
    'jakarta'    => "'Plus Jakarta Sans', system-ui, sans-serif",
    'inter'      => "'Inter', system-ui, sans-serif",
    'dm-sans'    => "'DM Sans', system-ui, sans-serif",
    'poppins'    => "'Poppins', system-ui, sans-serif",
    'montserrat' => "'Montserrat', system-ui, sans-serif",
  );

  $font_head_map = array(
    'serif'            => "Georgia, 'Times New Roman', serif",
    'instrument-serif' => "'Instrument Serif', Georgia, serif",
    'playfair'         => "'Playfair Display', Georgia, serif",
    'same-as-body'     => isset($font_sans_map[$body_font]) ? $font_sans_map[$body_font] : $font_sans_map['system'],
  );

  $font_sans  = isset($font_sans_map[$body_font]) ? $font_sans_map[$body_font] : $font_sans_map['system'];
  $font_head  = isset($font_head_map[$head_font]) ? $font_head_map[$head_font] : $font_head_map['serif'];

  // Google Fonts URL
  $gfonts = array();
  if ($body_font !== 'system') {
    $font_slugs = array(
      'jakarta' => 'Plus+Jakarta+Sans:wght@400;500;600;700;800',
      'inter'   => 'Inter:wght@400;500;600;700',
      'dm-sans' => 'DM+Sans:wght@400;500;600;700',
      'poppins' => 'Poppins:wght@400;500;600;700',
      'montserrat' => 'Montserrat:wght@400;500;600;700;800',
    );
    if (isset($font_slugs[$body_font])) {
      $gfonts[] = 'family=' . $font_slugs[$body_font];
    }
  }
  if ($head_font !== 'serif' && $head_font !== 'same-as-body') {
    $head_slugs = array(
      'instrument-serif' => 'Instrument+Serif:ital@0;1',
      'playfair'         => 'Playfair+Display:wght@400;500;600;700',
    );
    if (isset($head_slugs[$head_font])) {
      $gfonts[] = 'family=' . $head_slugs[$head_font];
    }
  }

  $font_url = '';
  if (!empty($gfonts)) {
    $font_url = 'https://fonts.googleapis.com/css2?' . implode('&', $gfonts) . '&display=swap';
  }
  ?>
  <?php if ($font_url) : ?>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="<?php echo esc_url($font_url); ?>" rel="stylesheet">
  <?php endif; ?>

  <style id="rillatype-dynamic-css">
    :root {
      --accent: <?php echo esc_attr($accent); ?>;
      --accent-hover: <?php echo esc_attr($accent_hover); ?>;
      --accent-soft: <?php echo esc_attr($accent_soft); ?>;
      --bg: <?php echo esc_attr($bg); ?>;
      --text: <?php echo esc_attr($text); ?>;
      --text-muted: <?php echo esc_attr($muted); ?>;
      --border: <?php echo esc_attr($border); ?>;
      --font-sans: <?php echo esc_attr($font_sans); ?>;
      --font-serif: <?php echo esc_attr($font_head); ?>;
    }
  </style>
  <?php
}

// Helper: darken a hex color
function rillatype_darken_hex($hex, $amount = 15) {
  $hex = ltrim($hex, '#');
  if (strlen($hex) === 3) {
    $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
  }
  $r = max(0, hexdec(substr($hex, 0, 2)) - $amount);
  $g = max(0, hexdec(substr($hex, 2, 2)) - $amount);
  $b = max(0, hexdec(substr($hex, 4, 2)) - $amount);
  return sprintf('#%02x%02x%02x', $r, $g, $b);
}

// ══════ Selective Refresh (Live Preview) ══════
add_action('customize_preview_init', 'rillatype_customize_preview_js');
function rillatype_customize_preview_js() {
  wp_enqueue_script(
    'rillatype-customizer',
    get_template_directory_uri() . '/assets/js/customizer.js',
    array('customize-preview'),
    wp_get_theme()->get('Version'),
    true
  );
}
