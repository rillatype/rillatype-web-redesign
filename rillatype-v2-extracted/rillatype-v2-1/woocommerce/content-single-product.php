<?php
global $product;
if (!$product) return;

$name = $product->get_name();
if (preg_match('/^(.+?)\s*[—–]\s*(.+)$/', $name, $m) || preg_match('/^(.+?)\s*-\s*(.+)$/', $name, $m)) {
  $title = trim($m[1]);
  $sub   = ucwords(strtolower(trim($m[2])));
} else {
  $title = $name;
  $sub   = '';
}

$attachment_ids = $product->get_gallery_image_ids();
if ($product->get_image_id()) {
  array_unshift($attachment_ids, $product->get_image_id());
}
$attachment_ids = array_unique($attachment_ids);

$is_variable = $product->is_type('variable');
$variations  = $is_variable ? $product->get_available_variations() : [];
$variation_ids = $is_variable ? $product->get_children() : [];

$tester_font_from_attachment = function ($attachment_id) {
  $attachment_id = absint($attachment_id);
  if (!$attachment_id) return null;

  $font_url = wp_get_attachment_url($attachment_id);
  if (!$font_url) return null;

  $font_path = get_attached_file($attachment_id);
  $ext = strtolower(pathinfo($font_path ?: $font_url, PATHINFO_EXTENSION));
  $format = $ext === 'otf' ? 'opentype' : ($ext === 'ttf' ? 'truetype' : $ext);

  return array(
    'url'    => $font_url,
    'format' => $format,
  );
};

// Collect all fonts from _font_data metabox rows (native Product Preview).
$fonts = array();
$font_rows = absint(get_post_meta($product->get_id(), '_font_data', true));
if ($font_rows) {
  for ($i = 0; $i < $font_rows; $i++) {
    $font_name = get_post_meta($product->get_id(), '_font_data_' . $i . '_name', true);
    if (!$font_name) continue;

    $font_id = get_post_meta($product->get_id(), '_font_data_' . $i . '_font_web', true);
    if (!$font_id) {
      $font_id = get_post_meta($product->get_id(), '_font_data_' . $i . '_font', true);
    }
    if (!$font_id) continue;

    $fd = $tester_font_from_attachment($font_id);
    if (!$fd) continue;

    $fonts[] = array(
      'name'   => $font_name,
      'url'    => $fd['url'],
      'format' => $fd['format'],
      'family' => 'RillatypeFont_' . $product->get_id() . '_' . $i,
    );
  }
}

// Fallback chain if _font_data is empty.
if (empty($fonts)) {
  $fallback_url = '';

  if (!empty($variation_ids)) {
    foreach ($variation_ids as $variation_id) {
      $variation_font_url = get_post_meta($variation_id, '_rillatype_tester_font_url', true);
      if ($variation_font_url) { $fallback_url = $variation_font_url; break; }
    }
  }
  if (!$fallback_url) { $fallback_url = get_post_meta($product->get_id(), '_rillatype_tester_font_url', true); }
  if (!$fallback_url && function_exists('get_field')) { $fallback_url = get_field('specimen_regular_url', $product->get_id()); }
  if (!$fallback_url && $product->is_downloadable()) {
    foreach ($product->get_downloads() as $d) {
      if (preg_match('/\.(otf|ttf|woff2?)(\?.*)?$/i', $d->get_file())) { $fallback_url = $d->get_file(); break; }
    }
  }
  if (!$fallback_url && !empty($variation_ids)) {
    foreach ($variation_ids as $variation_id) {
      $vp = wc_get_product($variation_id);
      if (!$vp || !$vp->is_downloadable()) continue;
      foreach ($vp->get_downloads() as $d) {
        if (preg_match('/\.(otf|ttf|woff2?)(\?.*)?$/i', $d->get_file())) { $fallback_url = $d->get_file(); break 2; }
      }
    }
  }

  if ($fallback_url) {
    $ext = strtolower(pathinfo(parse_url($fallback_url, PHP_URL_PATH) ?: '', PATHINFO_EXTENSION));
    $format = $ext === 'otf' ? 'opentype' : ($ext === 'ttf' ? 'truetype' : $ext);
    $fonts[] = array(
      'name'   => $sub ? $title . ' — ' . $sub : $title,
      'url'    => $fallback_url,
      'format' => $format,
      'family' => 'RillatypeFont_' . $product->get_id() . '_0',
    );
  }
}

$has_fonts = !empty($fonts);
?>

<?php if ($has_fonts) : ?>
  <style>
    <?php foreach ($fonts as $f) : ?>
    @font-face {
      font-family: '<?php echo esc_html($f['family']); ?>';
      src: url("<?php echo esc_url_raw($f['url']); ?>") format('<?php echo esc_attr($f['format']); ?>');
      font-weight: 400;
      font-style: normal;
      font-display: swap;
    }
    <?php endforeach; ?>
  </style>
<?php endif; ?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class('', $product); ?>>

  <!-- Breadcrumbs -->
  <nav class="breadcrumbs product-breadcrumbs" aria-label="Breadcrumb">
    <a href="<?php echo esc_url(home_url('/')); ?>">Home</a><span>/</span>
    <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>">Shop</a><span>/</span>
    <span aria-current="page"><?php echo esc_html($title); ?></span>
  </nav>

  <!-- Product Hero -->
  <section class="product-hero">
    <div class="product-hero__grid">

      <!-- Gallery slider -->
      <div class="slider-wrap" id="product-slider">
        <div class="slider-track" id="slider-track">
          <?php if (!empty($attachment_ids)) : ?>
            <?php foreach ($attachment_ids as $i => $img_id) :
              $img_url = wp_get_attachment_image_url($img_id, 'full');
              $img_alt = get_post_meta($img_id, '_wp_attachment_image_alt', true);
            ?>
              <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($img_alt ?: $title . ' preview ' . ($i + 1)); ?>" loading="<?php echo $i < 2 ? 'eager' : 'lazy'; ?>">
            <?php endforeach; ?>
          <?php else : ?>
            <img src="<?php echo esc_url(wc_placeholder_img_src('full')); ?>" alt="<?php echo esc_attr($title); ?>">
          <?php endif; ?>
        </div>
        <?php if (count($attachment_ids) > 1) : ?>
          <button class="slider-btn slider-btn--prev" id="slider-prev" aria-label="Previous preview">‹</button>
          <button class="slider-btn slider-btn--next" id="slider-next" aria-label="Next preview">›</button>
          <div class="slider-dots" id="slider-dots"></div>
        <?php endif; ?>
      </div>

      <!-- Info panel -->
      <div class="product-info">
        <?php
        $post_time = get_post_time('U', true, $product->get_id());
        $days_old  = $post_time ? floor((time() - $post_time) / 86400) : 31;
        if ($days_old <= 30) : ?>
          <span class="product-badge">New</span>
        <?php endif; ?>
        <h1 class="product-title"><?php echo esc_html($title); ?></h1>
        <?php if ($sub) : ?>
          <p class="product-title__sub"><?php echo esc_html($sub); ?></p>
        <?php endif; ?>

        <?php if ($is_variable && !empty($variations)) : ?>
          <form class="variations-form" method="post" enctype="multipart/form-data">
            <div class="license-select">
              <span class="license-select__label">Choose your license</span>
              <?php foreach ($variations as $v) :
                $v_id    = $v['variation_id'];
                $att_names = [];
                foreach ($v['attributes'] as $tax => $slug) {
                  if (empty($slug)) continue;
                  $tax_name = str_replace('attribute_', '', $tax);
                  $term = get_term_by('slug', $slug, $tax_name);
                  $raw_name = $term ? $term->name : $slug;
                  $raw_name = preg_replace('/\s+license$/i', '', str_replace(['-', '_'], ' ', $raw_name));
                  $att_names[] = ucwords(strtolower(trim($raw_name))) . ' License';
                }
                $v_name  = implode(' / ', $att_names);
                $v_price = $v['display_price'];
                $attrs_json = htmlspecialchars(json_encode($v['attributes']), ENT_QUOTES, 'UTF-8');
              ?>
                <label class="license-tier<?php echo $v === reset($variations) ? ' selected' : ''; ?>" data-price="<?php echo esc_attr($v_price); ?>" data-variation="<?php echo esc_attr($v_id); ?>">
                  <input type="radio" name="variation_id" value="<?php echo esc_attr($v_id); ?>" data-attributes='<?php echo $attrs_json; ?>' <?php checked($v === reset($variations)); ?>>
                  <div class="license-tier__row">
                    <div class="license-tier__info">
                      <div class="license-tier__name"><?php echo esc_html($v_name); ?></div>
                      <div class="license-tier__desc"><?php
                        $desc_map = array(
                          'standard'  => 'Single user, up to 5 commercial projects.',
                          'extended'  => 'Unlimited projects, @font-face, up to 10 users.',
                          'webfont'   => 'Website embedding & e-books, up to 100K views.',
                          'app'       => 'Use in 1 app or game with unlimited in-app views.',
                          'broadcast' => 'Unlimited video, TV, film & motion graphics.',
                          'corporate' => 'Unlimited everything for your organization.',
                        );
                        $v_lower = strtolower($v_name);
                        $matched_desc = '';
                        foreach ($desc_map as $key => $desc) {
                          if (strpos($v_lower, $key) !== false) {
                            $matched_desc = $desc;
                            break;
                          }
                        }
                        echo $matched_desc ? esc_html($matched_desc) : esc_html__('Personal & commercial use.', 'rillatype-v2');
                      ?></div>
                    </div>
                    <span class="license-tier__price"><?php echo wc_price($v_price); ?></span>
                  </div>
                </label>
              <?php endforeach; ?>
            </div>

            <input type="hidden" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>">
            <input type="hidden" name="product_id" value="<?php echo esc_attr($product->get_id()); ?>">

            <div class="product-actions">
              <?php
              $first_price = !empty($variations) ? $variations[0]['display_price'] : 0;
              ?>
              <button type="submit" class="btn btn-primary single_add_to_cart_button" id="add-to-cart-btn">
                Add to Cart — <?php echo wc_price($first_price); ?>
              </button>
            </div>
          </form>

        <?php else : ?>
          <?php woocommerce_template_single_add_to_cart(); ?>
        <?php endif; ?>

        <p class="product-guarantee">
          <strong>Lifetime updates</strong> included. <a href="<?php echo esc_url(home_url('/license/')); ?>" style="color:var(--coral);text-decoration:underline;text-underline-offset:2px;">Full license details →</a>
        </p>

      </div>
    </div>
  </section>

  <!-- Font Playground -->
  <section class="font-playground" aria-label="Try this font">
    <div class="container">
      <p class="section-label product-section-label">Playground</p>
      <div class="tester" role="region" aria-label="Interactive font tester" data-fonts='<?php echo $has_fonts ? htmlspecialchars(json_encode($fonts), ENT_QUOTES, 'UTF-8') : '[]'; ?>' data-font-loaded="<?php echo $has_fonts ? 'yes' : 'no'; ?>">
        <div class="tester__controls">
          <div class="tester__row">
            <div class="tester__slider">
              <label for="tester-size">Size</label>
              <input type="range" id="tester-size" min="12" max="200" value="64" step="1" aria-label="Font size">
              <output id="tester-size-value">64px</output>
            </div>
            <div class="tester__slider">
              <label for="tester-leading">Lead</label>
              <input type="range" id="tester-leading" min="50" max="250" value="110" step="5" aria-label="Leading">
              <output id="tester-leading-value">1.1</output>
            </div>
            <div class="tester__slider">
              <label for="tester-tracking">Track</label>
              <input type="range" id="tester-tracking" min="-50" max="200" value="0" step="1" aria-label="Tracking">
              <output id="tester-tracking-value">0.00</output>
            </div>
          </div>
          <div class="tester__row">
            <select class="tester__font-select" id="tester-font" aria-label="Font style">
              <?php foreach ($fonts as $i => $f) : ?>
              <option value="<?php echo esc_attr($f['family']); ?>"<?php echo $i === 0 ? ' selected' : ''; ?>><?php echo esc_html($f['name']); ?></option>
              <?php endforeach; ?>
            </select>
            <div class="tester__align" role="radiogroup" aria-label="Alignment">
              <button data-align="left" role="radio" aria-checked="false" aria-label="Align left" title="Left">
                <svg width="18" height="14" viewBox="0 0 18 14" fill="none"><rect x="0" y="0" width="14" height="2" rx="1" fill="currentColor"/><rect x="0" y="4" width="10" height="2" rx="1" fill="currentColor"/><rect x="0" y="8" width="16" height="2" rx="1" fill="currentColor"/><rect x="0" y="12" width="12" height="2" rx="1" fill="currentColor"/></svg>
              </button>
              <button class="active" data-align="center" role="radio" aria-checked="true" aria-label="Align center" title="Center">
                <svg width="18" height="14" viewBox="0 0 18 14" fill="none"><rect x="2" y="0" width="14" height="2" rx="1" fill="currentColor"/><rect x="4" y="4" width="10" height="2" rx="1" fill="currentColor"/><rect x="1" y="8" width="16" height="2" rx="1" fill="currentColor"/><rect x="3" y="12" width="12" height="2" rx="1" fill="currentColor"/></svg>
              </button>
              <button data-align="right" role="radio" aria-checked="false" aria-label="Align right" title="Right">
                <svg width="18" height="14" viewBox="0 0 18 14" fill="none"><rect x="4" y="0" width="14" height="2" rx="1" fill="currentColor"/><rect x="8" y="4" width="10" height="2" rx="1" fill="currentColor"/><rect x="2" y="8" width="16" height="2" rx="1" fill="currentColor"/><rect x="6" y="12" width="12" height="2" rx="1" fill="currentColor"/></svg>
              </button>
            </div>
            <div class="tester__bgs">
              <label>Bg</label>
              <button class="bg--white active" data-bg="#f7f3ee" data-text="#1a1a1a" role="radio" aria-checked="true" title="Light"></button>
              <button class="bg--dark" data-bg="#1a1a1a" data-text="#fff" role="radio" aria-checked="false" title="Dark"></button>
              <button class="bg--coral" data-bg="#e0553d" data-text="#fff" role="radio" aria-checked="false" title="Coral"></button>
              <button class="bg--sand" data-bg="#6b4c3a" data-text="#fff" role="radio" aria-checked="false" title="Brown"></button>
            </div>
            <button class="tester__reset" id="tester-reset" title="Reset defaults">↺</button>
          </div>
          <div class="tester__presets" aria-label="Quick text">
            <button data-presets='["The Quick Brown Fox Jumps Over The Lazy Dog","Amazingly Few Discotheques Provide Jukeboxes","Sphinx Of Black Quartz, Judge My Vow","Waltz, Bad Nymph, For Quick Jigs Vex","Pack My Box With Five Dozen Liquor Jugs"]'>Aa Bb Cc</button>
            <button data-presets='["HELLO WORLD","WELCOME TO RILLATYPE","HANDCRAFTED FONTS","MAKE IT BOLD","TYPOGRAPHY MATTERS"]'>ALL CAPS</button>
            <button data-presets='["Handcrafted with love","Designed with passion","For brands with soul","Type that speaks","Every letter tells a story"]'>Phrase</button>
            <button data-presets='["Pack my box with five dozen liquor jugs","How vexingly quick daft zebras jump","The five boxing wizards jump quickly","Crazy Fredrick bought many very exquisite opal jewels","Grumpy wizards make toxic brew for the evil queen and jack"]'>Pangram</button>
          </div>
        </div>
        <div class="tester__display" id="tester-display" contenteditable="true" role="textbox" aria-multiline="true" aria-label="Type to preview" tabindex="0">The quick brown fox jumps over the lazy dog</div>
        <p class="tester__hint">Click the text and type. Adjust size & style above.</p>
      </div>
    </div>
  </section>

  <!-- Character Set -->
  <section class="glyph-section" aria-label="Character set">
    <div class="container">
      <button class="section-label product-section-label glyph-toggle" id="glyph-toggle" aria-expanded="false">
        <span>Character set</span>
        <span class="glyph-toggle__icon">+</span>
      </button>
      <div class="glyph-panel" id="glyph-panel" style="display:none;">
        <div class="glyph-controls">
          <?php if ($has_fonts && count($fonts) > 0) : ?>
          <select class="tester__font-select glyph-font-select" id="glyph-font" aria-label="Font">
            <?php foreach ($fonts as $i => $f) : ?>
            <option value="<?php echo esc_attr($f['family']); ?>"<?php echo $i === 0 ? ' selected' : ''; ?>><?php echo esc_html($f['name']); ?></option>
            <?php endforeach; ?>
          </select>
          <?php endif; ?>
          <div class="tester__slider" style="max-width:220px;">
            <label for="glyph-size">Size</label>
            <input type="range" id="glyph-size" min="12" max="72" value="20" step="1" aria-label="Glyph size">
            <output id="glyph-size-value">20px</output>
          </div>
        </div>
        <div class="glyph-grid" id="glyph-grid">
          <span class="glyph-cell">A</span><span class="glyph-cell">B</span><span class="glyph-cell">C</span>
          <span class="glyph-cell">D</span><span class="glyph-cell">E</span><span class="glyph-cell">F</span>
          <span class="glyph-cell">G</span><span class="glyph-cell">H</span><span class="glyph-cell">I</span>
          <span class="glyph-cell">J</span><span class="glyph-cell">K</span><span class="glyph-cell">L</span>
          <span class="glyph-cell">M</span><span class="glyph-cell">N</span><span class="glyph-cell">O</span>
          <span class="glyph-cell">P</span><span class="glyph-cell">Q</span><span class="glyph-cell">R</span>
          <span class="glyph-cell">S</span><span class="glyph-cell">T</span><span class="glyph-cell">U</span>
          <span class="glyph-cell">V</span><span class="glyph-cell">W</span><span class="glyph-cell">X</span>
          <span class="glyph-cell">Y</span><span class="glyph-cell">Z</span>
          <span class="glyph-cell">a</span><span class="glyph-cell">b</span><span class="glyph-cell">c</span>
          <span class="glyph-cell">d</span><span class="glyph-cell">e</span><span class="glyph-cell">f</span>
          <span class="glyph-cell">g</span><span class="glyph-cell">h</span><span class="glyph-cell">i</span>
          <span class="glyph-cell">j</span><span class="glyph-cell">k</span><span class="glyph-cell">l</span>
          <span class="glyph-cell">m</span><span class="glyph-cell">n</span><span class="glyph-cell">o</span>
          <span class="glyph-cell">p</span><span class="glyph-cell">q</span><span class="glyph-cell">r</span>
          <span class="glyph-cell">s</span><span class="glyph-cell">t</span><span class="glyph-cell">u</span>
          <span class="glyph-cell">v</span><span class="glyph-cell">w</span><span class="glyph-cell">x</span>
          <span class="glyph-cell">y</span><span class="glyph-cell">z</span>
          <span class="glyph-cell">0</span><span class="glyph-cell">1</span><span class="glyph-cell">2</span>
          <span class="glyph-cell">3</span><span class="glyph-cell">4</span><span class="glyph-cell">5</span>
          <span class="glyph-cell">6</span><span class="glyph-cell">7</span><span class="glyph-cell">8</span>
          <span class="glyph-cell">9</span>
          <span class="glyph-cell">!</span><span class="glyph-cell">?</span><span class="glyph-cell">.</span>
          <span class="glyph-cell">,</span><span class="glyph-cell">:</span><span class="glyph-cell">;</span>
          <span class="glyph-cell">-</span><span class="glyph-cell">_</span><span class="glyph-cell">@</span>
          <span class="glyph-cell">#</span><span class="glyph-cell">$</span><span class="glyph-cell">%</span>
          <span class="glyph-cell">&amp;</span><span class="glyph-cell">*</span><span class="glyph-cell">(</span>
          <span class="glyph-cell">)</span><span class="glyph-cell">[</span><span class="glyph-cell">]</span>
          <span class="glyph-cell">{</span><span class="glyph-cell">}</span><span class="glyph-cell">/</span>
          <span class="glyph-cell">\</span><span class="glyph-cell">|</span><span class="glyph-cell">~</span>
        </div>
      </div>
    </div>
  </section>

  <!-- Description -->
  <section class="product-desc" aria-label="About this product">
    <div class="container">
      <p class="section-label product-section-label">About</p>
      <div class="product-desc__inner">
        <?php the_content(); ?>
      </div>
    </div>
  </section>

  <!-- Specs -->
  <?php
  $attributes = $product->get_attributes();
  if (!empty($attributes) && !$product->is_type('variable')) : ?>
  <section class="product-specs">
    <div class="container">
      <p class="section-label product-section-label">Specifications</p>
      <dl class="specs-grid">
        <?php foreach ($attributes as $attr) :
          if ($attr->is_taxonomy()) {
            $terms = wc_get_product_terms($product->get_id(), $attr->get_name(), array('fields' => 'names'));
            $value = implode(', ', $terms);
          } else {
            $value = $attr->get_data()['value'];
          }
          if (empty($value)) continue;
          $label = wc_attribute_label($attr->get_name());
        ?>
          <dt><?php echo esc_html($label); ?></dt>
          <dd><?php echo esc_html($value); ?></dd>
        <?php endforeach; ?>
      </dl>
    </div>
  </section>
  <?php endif; ?>

  <!-- FAQ -->
  <section class="product-faq">
    <div class="container">
      <p class="section-label product-section-label">FAQ</p>
      <div class="faq-list">
        <div class="faq-item">
          <h3>What file formats are included?</h3>
          <p>OTF and TTF — fully functional with complete glyph set.</p>
        </div>
        <div class="faq-item">
          <h3>Can I use this for commercial projects?</h3>
          <p>Yes. License covers logos, branding, packaging, merchandise, and client work — no extra fees.</p>
        </div>
        <div class="faq-item">
          <h3>Can I use these fonts on my website?</h3>
          <p>Yes. OTF and TTF both work with @font-face for self-hosted web use with no pageview limits.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Related Products -->
  <?php
  $related = wc_get_related_products($product->get_id(), 6);
  if (!empty($related)) : ?>
  <section class="product-related" aria-label="Similar products">
    <div class="container">
      <p class="section-label product-section-label">You might also like</p>
      <div class="related-grid">
        <?php foreach ($related as $rel_id) :
          $rel_product = wc_get_product($rel_id);
          if (!$rel_product) continue;
          $rel_img = $rel_product->get_image_id() ? wp_get_attachment_image_url($rel_product->get_image_id(), 'medium') : wc_placeholder_img_src('medium');
        ?>
          <a href="<?php echo esc_url(get_permalink($rel_id)); ?>" class="related-item">
            <div class="related-item__img" style="background-image:url('<?php echo esc_url($rel_img); ?>');"></div>
            <div class="related-item__body">
              <p class="related-item__name"><?php echo esc_html($rel_product->get_name()); ?></p>
              <p class="related-item__price"><?php echo rillatype_min_price($rel_product); ?></p>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

</div>

<!-- Lightbox overlay -->
<div class="lightbox" id="lightbox" role="dialog" aria-label="Full preview">
  <button class="lightbox__close" id="lb-close" aria-label="Close">✕</button>
  <button class="lightbox__nav lightbox__nav--prev" id="lb-prev" aria-label="Previous">‹</button>
  <img id="lb-img" src="" alt="Full preview">
  <button class="lightbox__nav lightbox__nav--next" id="lb-next" aria-label="Next">›</button>
  <span class="lightbox__counter" id="lb-counter"></span>
</div>

<!-- Sticky cart bar -->
<div class="sticky-bar" id="sticky-bar">
  <div class="sticky-bar__inner">
    <div class="sticky-bar__info">
      <?php
      $thumb_id = $product->get_image_id();
      if ($thumb_id) :
        $thumb_url = wp_get_attachment_image_url($thumb_id, 'thumbnail');
      ?>
        <img src="<?php echo esc_url($thumb_url); ?>" alt="" class="sticky-bar__thumb" loading="lazy">
      <?php endif; ?>
      <span class="sticky-bar__name"><?php echo esc_html($title); ?></span>
      <span class="sticky-bar__price"><?php echo rillatype_min_price($product); ?></span>
    </div>
    <button type="button" class="sticky-bar__btn">Add to Cart</button>
  </div>
</div>
