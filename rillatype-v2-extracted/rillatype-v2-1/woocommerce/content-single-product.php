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
?>

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
        $post_date = get_post_field('post_date', $product->get_id());
        $days_old  = floor((time() - strtotime($post_date)) / DAY_IN_SECONDS);
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
                  $att_names[] = $term ? ucwords($term->name) : ucwords(str_replace('-', ' ', $slug));
                }
                $v_name  = implode(' / ', $att_names);
                $v_price = $v['display_price'];
                $attrs_json = htmlspecialchars(json_encode($v['attributes']), ENT_QUOTES, 'UTF-8');
              ?>
                <label class="license-tier<?php echo $v === reset($variations) ? ' selected' : ''; ?>" data-price="<?php echo esc_attr($v_price); ?>" data-variation="<?php echo esc_attr($v_id); ?>">
                  <input type="radio" name="variation_id" value="<?php echo esc_attr($v_id); ?>" data-attributes='<?php echo $attrs_json; ?>' <?php checked($v === reset($variations)); ?>>
                  <div class="license-tier__row">
                    <div class="license-tier__info">
                      <div class="license-tier__name"><?php echo esc_html($v_name); ?> License</div>
                      <div class="license-tier__desc">Single user, personal & commercial projects</div>
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
          <strong>Lifetime updates</strong> included. <a href="#license-details" style="color:var(--coral);text-decoration:underline;text-underline-offset:2px;">Full license details →</a>
        </p>

        <?php
        $short_desc = $product->get_short_description();
        if ($short_desc) : ?>
          <div class="product-short-desc">
            <?php echo wp_kses_post($short_desc); ?>
          </div>
        <?php endif; ?>

      </div>
    </div>
  </section>

  <!-- Font Playground -->
  <section class="font-playground" aria-label="Try this font">
    <div class="container">
      <p class="section-label product-section-label">Playground</p>
      <div class="tester" role="region" aria-label="Interactive font tester">
        <div class="tester__display" id="tester-display" contenteditable="true" role="textbox" aria-multiline="true" aria-label="Type to preview" tabindex="0">The quick brown fox jumps over the lazy dog</div>
        <p class="tester__hint">Click the text and type. Adjust size & style below.</p>
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
              <input type="range" id="tester-tracking" min="-50" max="200" value="0" step="5" aria-label="Tracking">
              <output id="tester-tracking-value">0</output>
            </div>
          </div>
          <div class="tester__row">
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
              <button class="bg--sand" data-bg="#ede8e0" data-text="#1a1a1a" role="radio" aria-checked="false" title="Sand"></button>
            </div>
          </div>
          <div class="tester__presets" aria-label="Quick text">
            <button data-presets='["The Quick Brown Fox Jumps Over The Lazy Dog","Amazingly Few Discotheques Provide Jukeboxes","Sphinx Of Black Quartz, Judge My Vow","Waltz, Bad Nymph, For Quick Jigs Vex","Pack My Box With Five Dozen Liquor Jugs"]'>Aa Bb Cc</button>
            <button data-presets='["HELLO WORLD","WELCOME TO RILLATYPE","HANDCRAFTED FONTS","MAKE IT BOLD","TYPOGRAPHY MATTERS"]'>ALL CAPS</button>
            <button data-presets='["Handcrafted with love","Designed with passion","For brands with soul","Type that speaks","Every letter tells a story"]'>Phrase</button>
            <button data-presets='["Pack my box with five dozen liquor jugs","How vexingly quick daft zebras jump","The five boxing wizards jump quickly","Crazy Fredrick bought many very exquisite opal jewels","Grumpy wizards make toxic brew for the evil queen and jack"]'>Pangram</button>
          </div>
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
          <p>OTF, TTF, and WOFF2. All fully functional with complete glyph set.</p>
        </div>
        <div class="faq-item">
          <h3>Can I use this for commercial projects?</h3>
          <p>Yes. License covers logos, branding, packaging, merchandise, and client work — no extra fees.</p>
        </div>
        <div class="faq-item">
          <h3>Do I need a separate web license?</h3>
          <p>No. The WOFF2 file is included. Self-host on your website with no pageview limits.</p>
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
            <p class="related-item__name"><?php echo esc_html($rel_product->get_name()); ?></p>
            <p class="related-item__price"><?php echo $rel_product->get_price_html(); ?></p>
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
      <span class="sticky-bar__price"><?php echo $product->get_price_html(); ?></span>
    </div>
    <a href="#add-to-cart-btn" class="sticky-bar__btn">Add to Cart</a>
  </div>
</div>
