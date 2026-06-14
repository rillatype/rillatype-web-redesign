<?php
defined('ABSPATH') || exit;

global $product;

if (empty($product)) {
  return;
}

// Gallery images
$image_id      = $product->get_image_id();
$gallery_ids   = $product->get_gallery_image_ids();
$all_images    = [];
if ($image_id) {
  $all_images[] = $image_id;
}
foreach ($gallery_ids as $gid) {
  $all_images[] = $gid;
}

$categories    = wc_get_product_category_list($product->get_id(), ', ');
$tags          = wc_get_product_tag_list($product->get_id(), ' ');
$price         = $product->get_price();
$regular_price = $product->get_regular_price();
$sale_price    = $product->get_sale_price();
$price_html    = $product->get_price_html();
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class('', $product); ?>>

  <!-- Breadcrumbs -->
  <div class="container">
    <nav class="breadcrumbs" aria-label="Breadcrumb">
      <a href="<?php echo esc_url(home_url('/')); ?>">Home</a><span>/</span>
      <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>">Shop</a><span>/</span>
      <?php echo $categories ? wp_kses_post($categories) : '<span>' . esc_html($product->get_name()) . '</span>'; ?>
    </nav>
  </div>

  <!-- Product Hero -->
  <section class="product-hero">
    <div class="container">
      <div class="product-hero__grid">

        <!-- Preview slider -->
        <div class="slider-wrap" id="slider" tabindex="0" role="region" aria-label="Product previews">
          <div class="slider-track" id="slider-track">
            <?php foreach ($all_images as $i => $img_id) :
              $url = wp_get_attachment_image_url($img_id, 'full');
              $alt = get_post_meta($img_id, '_wp_attachment_image_alt', true) ?: $product->get_name() . ' preview ' . ($i + 1);
              if ($url) : ?>
                <img src="<?php echo esc_url($url); ?>" alt="<?php echo esc_attr($alt); ?>" loading="<?php echo $i === 0 ? 'eager' : 'lazy'; ?>">
              <?php endif; ?>
            <?php endforeach; ?>
            <?php if (empty($all_images)) : ?>
              <img src="<?php echo esc_url(wc_placeholder_img_src('full')); ?>" alt="<?php esc_attr_e('Product placeholder', 'rillatype-v2'); ?>">
            <?php endif; ?>
          </div>
          <button class="slider-btn slider-btn--prev" id="slider-prev" aria-label="<?php esc_attr_e('Previous preview', 'rillatype-v2'); ?>">‹</button>
          <button class="slider-btn slider-btn--next" id="slider-next" aria-label="<?php esc_attr_e('Next preview', 'rillatype-v2'); ?>">›</button>
          <div class="slider-dots" id="slider-dots" role="tablist" aria-label="<?php esc_attr_e('Preview navigation', 'rillatype-v2'); ?>"></div>
        </div>

        <!-- Info -->
        <div class="product-info">
          <span class="product-badge"><?php esc_html_e('New', 'rillatype-v2'); ?></span>
          <h1 class="product-title"><?php the_title(); ?></h1>
          <?php if ($product->get_short_description()) : ?>
            <p class="product-title__sub"><?php echo esc_html($product->get_short_description()); ?></p>
          <?php endif; ?>

          <?php do_action('woocommerce_single_product_summary'); ?>

          <p class="product-guarantee">
            <strong><?php esc_html_e('Lifetime updates', 'rillatype-v2'); ?></strong>
            <?php esc_html_e('included. Full license details →', 'rillatype-v2'); ?>
          </p>
        </div>

      </div>
    </div>
  </section>

  <!-- Font Playground -->
  <section class="font-playground" aria-label="<?php esc_attr_e('Try this font', 'rillatype-v2'); ?>">
    <div class="container">
      <p class="section-label"><?php esc_html_e('Playground', 'rillatype-v2'); ?></p>
      <div class="tester" role="region" aria-label="<?php esc_attr_e('Interactive font tester', 'rillatype-v2'); ?>"
           data-font-name="<?php echo esc_attr($product->get_name()); ?>"
           data-specimen-url="<?php echo esc_attr(get_field('specimen_regular_url') ?: ''); ?>"
           data-specimen-bold="<?php echo esc_attr(get_field('specimen_bold_url') ?: ''); ?>">
        <div class="tester__display" id="tester-display" contenteditable="true" role="textbox" aria-multiline="true" aria-label="<?php esc_attr_e('Type to preview', 'rillatype-v2'); ?>" tabindex="0"><?php esc_html_e('The quick brown fox jumps over the lazy dog', 'rillatype-v2'); ?></div>
        <p class="tester__hint"><?php esc_html_e('Click the text above to type your own words.', 'rillatype-v2'); ?></p>
        <div class="tester__controls">
          <div class="tester__row">
            <div class="tester__slider">
              <label for="tester-size"><?php esc_html_e('Size', 'rillatype-v2'); ?></label>
              <input type="range" id="tester-size" min="12" max="200" value="64" step="1" aria-label="<?php esc_attr_e('Font size', 'rillatype-v2'); ?>">
              <output id="tester-size-value">64px</output>
            </div>
            <div class="tester__slider">
              <label for="tester-leading"><?php esc_html_e('Lead', 'rillatype-v2'); ?></label>
              <input type="range" id="tester-leading" min="50" max="250" value="110" step="5" aria-label="<?php esc_attr_e('Leading', 'rillatype-v2'); ?>">
              <output id="tester-leading-value">1.1</output>
            </div>
            <div class="tester__slider">
              <label for="tester-tracking"><?php esc_html_e('Track', 'rillatype-v2'); ?></label>
              <input type="range" id="tester-tracking" min="-50" max="200" value="0" step="5" aria-label="<?php esc_attr_e('Tracking', 'rillatype-v2'); ?>">
              <output id="tester-tracking-value">0</output>
            </div>
          </div>
          <div class="tester__row">
            <select class="tester__font-select" id="tester-font">
              <option value="TesterFont"><?php echo esc_html($product->get_name()); ?></option>
            </select>
            <div class="tester__align" role="radiogroup" aria-label="<?php esc_attr_e('Alignment', 'rillatype-v2'); ?>">
              <button data-align="left" role="radio" aria-checked="false" aria-label="<?php esc_attr_e('Align left', 'rillatype-v2'); ?>" title="<?php esc_attr_e('Left', 'rillatype-v2'); ?>">
                <svg width="18" height="14" viewBox="0 0 18 14" fill="none"><rect x="0" y="0" width="14" height="2" rx="1" fill="currentColor"/><rect x="0" y="4" width="10" height="2" rx="1" fill="currentColor"/><rect x="0" y="8" width="16" height="2" rx="1" fill="currentColor"/><rect x="0" y="12" width="12" height="2" rx="1" fill="currentColor"/></svg>
              </button>
              <button class="active" data-align="center" role="radio" aria-checked="true" aria-label="<?php esc_attr_e('Align center', 'rillatype-v2'); ?>" title="<?php esc_attr_e('Center', 'rillatype-v2'); ?>">
                <svg width="18" height="14" viewBox="0 0 18 14" fill="none"><rect x="2" y="0" width="14" height="2" rx="1" fill="currentColor"/><rect x="4" y="4" width="10" height="2" rx="1" fill="currentColor"/><rect x="1" y="8" width="16" height="2" rx="1" fill="currentColor"/><rect x="3" y="12" width="12" height="2" rx="1" fill="currentColor"/></svg>
              </button>
              <button data-align="right" role="radio" aria-checked="false" aria-label="<?php esc_attr_e('Align right', 'rillatype-v2'); ?>" title="<?php esc_attr_e('Right', 'rillatype-v2'); ?>">
                <svg width="18" height="14" viewBox="0 0 18 14" fill="none"><rect x="4" y="0" width="14" height="2" rx="1" fill="currentColor"/><rect x="8" y="4" width="10" height="2" rx="1" fill="currentColor"/><rect x="2" y="8" width="16" height="2" rx="1" fill="currentColor"/><rect x="6" y="12" width="12" height="2" rx="1" fill="currentColor"/></svg>
              </button>
            </div>
            <div class="tester__bgs">
              <label><?php esc_html_e('Bg', 'rillatype-v2'); ?></label>
              <button class="bg--white active" data-bg="#f7f3ee" data-text="#1a1a1a" role="radio" aria-checked="true" title="<?php esc_attr_e('Light', 'rillatype-v2'); ?>"></button>
              <button class="bg--dark" data-bg="#1a1a1a" data-text="#fff" role="radio" aria-checked="false" title="<?php esc_attr_e('Dark', 'rillatype-v2'); ?>"></button>
              <button class="bg--coral" data-bg="#e0553d" data-text="#fff" role="radio" aria-checked="false" title="<?php esc_attr_e('Coral', 'rillatype-v2'); ?>"></button>
              <button class="bg--sand" data-bg="#ede8e0" data-text="#1a1a1a" role="radio" aria-checked="false" title="<?php esc_attr_e('Sand', 'rillatype-v2'); ?>"></button>
            </div>
          </div>
          <div class="tester__presets" aria-label="<?php esc_attr_e('Quick text', 'rillatype-v2'); ?>">
            <button data-presets='["The Quick Brown Fox Jumps Over The Lazy Dog","Amazingly Few Discotheques Provide Jukeboxes","Sphinx Of Black Quartz, Judge My Vow","Waltz, Bad Nymph, For Quick Jigs Vex","Pack My Box With Five Dozen Liquor Jugs"]'><?php esc_html_e('Aa Bb Cc', 'rillatype-v2'); ?></button>
            <button data-presets='["HELLO WORLD","WELCOME TO RILLATYPE","HANDCRAFTED FONTS","MAKE IT BOLD","TYPOGRAPHY MATTERS"]'><?php esc_html_e('ALL CAPS', 'rillatype-v2'); ?></button>
            <button data-presets='["Handcrafted with love","Designed with passion","For brands with soul","Type that speaks","Every letter tells a story"]'><?php esc_html_e('Phrase', 'rillatype-v2'); ?></button>
            <button data-presets='["Pack my box with five dozen liquor jugs","How vexingly quick daft zebras jump","The five boxing wizards jump quickly","Crazy Fredrick bought many very exquisite opal jewels","Grumpy wizards make toxic brew for the evil queen and jack"]'><?php esc_html_e('Pangram', 'rillatype-v2'); ?></button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Glyph Map -->
  <section class="glyph-section" aria-label="<?php esc_attr_e('Character set', 'rillatype-v2'); ?>">
    <div class="container">
      <button class="section-label glyph-toggle" id="glyph-toggle" aria-expanded="false">
        <span><?php esc_html_e('Character set', 'rillatype-v2'); ?></span>
        <span class="glyph-toggle__icon">+</span>
      </button>
      <div class="glyph-controls" id="glyph-controls" style="display:none;">
        <div class="tester__slider" style="margin-bottom:var(--space-md);max-width:300px;">
          <label for="glyph-size"><?php esc_html_e('Size', 'rillatype-v2'); ?></label>
          <input type="range" id="glyph-size" min="12" max="60" value="18" step="1">
          <output id="glyph-size-value">18px</output>
        </div>
        <div class="glyph-grid" id="glyph-grid">
          <?php
          $glyphs = array_merge(
            range('A', 'Z'), range('a', 'z'),
            ['0','1','2','3','4','5','6','7','8','9'],
            ['!','?','.',',',':',';','-','_','@','#','$','%','&','*','(',')','[',']','{','}','/','\\','|','~']
          );
          foreach ($glyphs as $g) :
            $display = ($g === '&') ? '&amp;' : esc_html($g);
            ?>
            <span class="glyph-cell"><?php echo $display; ?></span>
          <?php endforeach; ?>
        </div>
        <p style="font-size:13px;color:var(--text-muted);margin-top:var(--space-md);display:none;" id="glyph-count">
          <?php esc_html_e('180+ glyphs — uppercase, lowercase, numbers, punctuation, and extras. Works for most Latin-based projects.', 'rillatype-v2'); ?>
        </p>
      </div>
    </div>
  </section>

  <!-- Description -->
  <section class="product-desc" aria-label="<?php esc_attr_e('About this font', 'rillatype-v2'); ?>">
    <div class="container">
      <div class="product-desc__inner">
        <p class="section-label"><?php esc_html_e('About', 'rillatype-v2'); ?></p>
        <?php the_content(); ?>
      </div>
    </div>
  </section>

  <!-- Tags -->
  <?php if ($tags) : ?>
  <section class="product-tags" style="padding:0 0 var(--space-2xl);">
    <div class="container">
      <div class="tags-list">
        <?php echo wp_kses_post($tags); ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <!-- Specs -->
  <section class="product-specs">
    <div class="container">
      <p class="section-label"><?php esc_html_e('Specifications', 'rillatype-v2'); ?></p>
      <dl class="specs-grid">
        <dt><?php esc_html_e('Formats', 'rillatype-v2'); ?></dt>
        <dd><?php echo esc_html(get_field('font_formats') ?: 'OTF, TTF'); ?></dd>
        <dt><?php esc_html_e('Glyphs', 'rillatype-v2'); ?></dt>
        <dd><?php echo esc_html(get_field('glyphs_count') ?: '350+'); ?></dd>
        <dt><?php esc_html_e('Styles', 'rillatype-v2'); ?></dt>
        <dd><?php echo esc_html(get_field('available_weights') ?: 'Regular'); ?></dd>
        <dt><?php esc_html_e('Languages', 'rillatype-v2'); ?></dt>
        <dd><?php esc_html_e('60+ Latin-based', 'rillatype-v2'); ?></dd>
        <dt><?php esc_html_e('License', 'rillatype-v2'); ?></dt>
        <dd><a href="<?php echo esc_url(home_url('/font-license/')); ?>"><?php esc_html_e('See license options →', 'rillatype-v2'); ?></a></dd>
        <dt><?php esc_html_e('Designer', 'rillatype-v2'); ?></dt>
        <dd>Rillatype Studio</dd>
      </dl>
    </div>
  </section>

  <!-- Lightbox -->
  <div class="lightbox" id="lightbox" role="dialog" aria-label="<?php esc_attr_e('Full preview', 'rillatype-v2'); ?>" aria-modal="true">
    <button class="lightbox__close" id="lb-close" aria-label="<?php esc_attr_e('Close', 'rillatype-v2'); ?>">✕</button>
    <button class="lightbox__nav lightbox__nav--prev" id="lb-prev" aria-label="<?php esc_attr_e('Previous', 'rillatype-v2'); ?>">‹</button>
    <img id="lb-img" src="" alt="<?php esc_attr_e('Full preview', 'rillatype-v2'); ?>">
    <button class="lightbox__nav lightbox__nav--next" id="lb-next" aria-label="<?php esc_attr_e('Next', 'rillatype-v2'); ?>">›</button>
    <span class="lightbox__counter" id="lb-counter"></span>
  </div>

  <!-- Related Products -->
  <?php
  $related_ids = wc_get_related_products($product->get_id(), 3);
  if ($related_ids) :
    $related_posts = new WP_Query(array(
      'post__in'       => $related_ids,
      'post_type'      => 'product',
      'posts_per_page' => 3,
    ));
    if ($related_posts->have_posts()) :
  ?>
  <section class="product-related" aria-label="<?php esc_attr_e('Similar fonts', 'rillatype-v2'); ?>">
    <div class="container">
      <p class="section-label"><?php esc_html_e('You might also like', 'rillatype-v2'); ?></p>
      <div class="related-grid">
        <?php while ($related_posts->have_posts()) : $related_posts->the_post();
          global $product;
          $rel_img = $product->get_image_id() ? wp_get_attachment_image_url($product->get_image_id(), 'medium') : wc_placeholder_img_src('medium');
        ?>
        <a href="<?php the_permalink(); ?>" class="related-item">
          <div class="related-item__img" style="background-image:url('<?php echo esc_url($rel_img); ?>');"></div>
          <p class="related-item__name"><?php the_title(); ?></p>
          <p class="related-item__price"><?php echo $product->get_price_html(); ?></p>
        </a>
        <?php endwhile; ?>
      </div>
    </div>
  </section>
  <?php
      wp_reset_postdata();
    endif;
  endif;
  ?>

  <!-- Font Pairing (static for now — can be ACF later) -->
  <section class="font-pairing" aria-label="<?php esc_attr_e('Font pairing suggestions', 'rillatype-v2'); ?>">
    <div class="container">
      <p class="section-label"><?php esc_html_e('Pairs well with', 'rillatype-v2'); ?></p>
      <div class="pairing-grid">
        <div class="pairing-card">
          <div class="pairing-card__img" style="background:var(--bg-alt);"></div>
          <div class="pairing-card__body">
            <h3><?php esc_html_e('Coming soon', 'rillatype-v2'); ?></h3>
            <p><?php esc_html_e('Font pairing suggestions will appear here once configured.', 'rillatype-v2'); ?></p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FAQ -->
  <section class="product-faq">
    <div class="container">
      <p class="section-label"><?php esc_html_e('FAQ', 'rillatype-v2'); ?></p>
      <div class="faq-list">
        <div class="faq-item">
          <h3><?php esc_html_e('What file formats are included?', 'rillatype-v2'); ?></h3>
          <p><?php esc_html_e('OTF and TTF. Both are fully functional with complete glyph set — ready for print, web, and desktop use.', 'rillatype-v2'); ?></p>
        </div>
        <div class="faq-item">
          <h3><?php esc_html_e('Can I use this for commercial projects?', 'rillatype-v2'); ?></h3>
          <p><?php esc_html_e('Yes. The Standard license covers logos, branding, packaging, merchandise, and client work — no extra fees.', 'rillatype-v2'); ?></p>
        </div>
        <div class="faq-item">
          <h3><?php esc_html_e('How do I install the font?', 'rillatype-v2'); ?></h3>
          <p><?php esc_html_e('Download the ZIP, extract, double-click the .ttf or .otf file, and hit "Install". Works on Mac and Windows.', 'rillatype-v2'); ?></p>
        </div>
      </div>
    </div>
  </section>

</div>

<!-- Sticky Cart Bar -->
<div class="sticky-bar" id="sticky-bar">
  <div class="sticky-bar__inner">
    <div class="sticky-bar__info">
      <?php if ($image_id) : ?>
        <img src="<?php echo esc_url(wp_get_attachment_image_url($image_id, 'thumbnail')); ?>" alt="" class="sticky-bar__thumb" loading="lazy">
      <?php endif; ?>
      <span class="sticky-bar__name"><?php the_title(); ?></span>
      <span class="sticky-bar__price" id="sticky-price"><?php echo wp_kses_post(wc_price($price)); ?></span>
    </div>
    <button class="sticky-bar__btn" id="sticky-btn"><?php esc_html_e('Add to Cart', 'rillatype-v2'); ?></button>
  </div>
</div>
