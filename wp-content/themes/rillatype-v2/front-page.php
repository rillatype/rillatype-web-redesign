<?php
/**
 * Rillatype V2 — Homepage
 * Design based on index-playful-v2.html
 */
get_header();

// Check if plugins are active
$has_acf    = function_exists('get_field');
$has_woo    = class_exists('WooCommerce');

// Get freebies (free products, show random 3)
$freebies = array();
if ($has_woo) {
  $free_q = new WP_Query(array(
    'post_type'      => 'product',
    'posts_per_page' => 3,
    'post_status'    => 'publish',
    'orderby'        => 'rand',
    'meta_query'     => array(array(
      'key'   => '_price',
      'value' => '0',
    )),
    'tax_query'      => array(array(
      'taxonomy' => 'product_type',
      'field'    => 'slug',
      'terms'    => 'simple',
    )),
  ));
  if ($free_q->have_posts()) {
    $freebies = $free_q->posts;
  }
}
?>

<main id="main" class="site-main front-page">

  <!-- ═══════ HERO ═══════ -->
  <section class="hero-section">
    <div class="hero-grid container">
      <div class="hero-content">
        <h1 class="hero-title">Where type meets craft.</h1>
        <p class="hero-text">Premium display & text fonts for designers who refuse to compromise.</p>
        <a href="<?php echo esc_url(home_url('/shop')); ?>" class="button button-primary">Browse Fonts</a>
      </div>
      <div class="hero-image">
        <div class="hero-image-placeholder"></div>
      </div>
    </div>
  </section>

  <!-- ═══════ FEATURED ═══════ -->
  <?php if ($has_woo) : ?>
    <?php
    $featured_products = wc_get_products(array(
      'limit'    => 3,
      'orderby'  => 'date',
      'order'    => 'DESC',
      'status'   => 'publish',
    ));
    if (!empty($featured_products)) :
    ?>
  <section class="section section-featured">
    <div class="container">
      <p class="section-label">Featured Specimens</p>
      <div class="product-grid grid-3">
        <?php foreach ($featured_products as $p) : ?>
          <a href="<?php echo esc_url(get_permalink($p->get_id())); ?>" class="product-card">
            <div class="product-card__image">
              <?php echo $p->get_image('rillatype-font-preview'); ?>
            </div>
            <div class="product-card__body">
              <div class="product-card__info">
                <span class="product-card__name"><?php echo esc_html($p->get_name()); ?></span>
                <span class="product-card__style"><?php echo esc_html(wp_strip_all_tags(wc_get_product_category_list($p->get_id()))); ?></span>
              </div>
              <span class="product-card__price"><?php echo $p->get_price_html(); ?></span>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
    <?php endif; ?>
  <?php else : ?>
  <!-- Fallback: No WooCommerce -->
  <section class="section section-featured">
    <div class="container">
      <p class="section-label">Featured Specimens</p>
      <div class="product-grid grid-3">
        <div class="product-card product-card--placeholder">
          <div class="product-card__image"><div class="placeholder-image"></div></div>
          <div class="product-card__body">
            <div class="product-card__info">
              <span class="product-card__name">Serif Display</span>
              <span class="product-card__style">serif, display</span>
            </div>
            <span class="product-card__price">$24</span>
          </div>
        </div>
        <div class="product-card product-card--placeholder">
          <div class="product-card__image"><div class="placeholder-image"></div></div>
          <div class="product-card__body">
            <div class="product-card__info">
              <span class="product-card__name">Sans Modern</span>
              <span class="product-card__style">sans-serif</span>
            </div>
            <span class="product-card__price">$18</span>
          </div>
        </div>
        <div class="product-card product-card--placeholder">
          <div class="product-card__image"><div class="placeholder-image"></div></div>
          <div class="product-card__body">
            <div class="product-card__info">
              <span class="product-card__name">Script Elegant</span>
              <span class="product-card__style">script</span>
            </div>
            <span class="product-card__price">$20</span>
          </div>
        </div>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <!-- ═══════ CATEGORIES ═══════ -->
  <section class="categories-section">
    <div class="container">
      <p class="section-label">Browse by style</p>
      <div class="categories-bar">
        <?php if ($has_woo) : ?>
          <?php
          $product_cats = get_terms(array(
            'taxonomy'   => 'product_cat',
            'hide_empty' => true,
            'parent'     => 0,
          ));
          if (!empty($product_cats) && !is_wp_error($product_cats)) :
            foreach ($product_cats as $cat) : ?>
              <a href="<?php echo esc_url(get_term_link($cat)); ?>" class="category-pill">
                <?php echo esc_html($cat->name); ?>
                <small><?php echo $cat->count; ?></small>
              </a>
            <?php endforeach;
          else :
            $default_cats = array('Serif', 'Sans Serif', 'Display', 'Script', 'Monospace', 'Variable');
            foreach ($default_cats as $cat) : ?>
              <a href="#" class="category-pill"><?php echo esc_html($cat); ?></a>
            <?php endforeach;
          endif;
        else :
          $default_cats = array('Serif', 'Sans Serif', 'Display', 'Script', 'Monospace', 'Variable');
          foreach ($default_cats as $cat) : ?>
            <a href="#" class="category-pill"><?php echo esc_html($cat); ?></a>
          <?php endforeach;
        endif; ?>
      </div>
    </div>
  </section>

  <!-- ═══════ FONT TESTER ═══════ -->
  <section class="section font-tester-section">
    <div class="container">
      <p class="section-label">Try a font</p>
      <p class="tester-text">Type your message and see it come to life.</p>
      <div class="font-tester" id="font-tester">
        <div class="font-tester-preview-box">The quick brown fox jumps over the lazy dog</div>
        <div class="font-tester-controls-group">
          <input type="text" class="font-tester-input" placeholder="Type something..." value="The quick brown fox jumps over the lazy dog">
          <div class="font-tester-slider-group">
            <label for="tester-size">Size <span id="tester-size-val">40</span>px</label>
            <input type="range" class="font-tester-slider" id="tester-size" min="12" max="96" value="40" step="1">
          </div>
          <div class="font-tester-style-buttons">
            <button class="font-tester-style-btn is-active" data-weight="normal" data-style="normal">Regular</button>
            <button class="font-tester-style-btn" data-weight="bold" data-style="normal">Bold</button>
            <button class="font-tester-style-btn" data-weight="normal" data-style="italic">Italic</button>
            <button class="font-tester-style-btn" data-weight="bold" data-style="italic">Bold Italic</button>
          </div>
          <div class="font-tester-preset-buttons">
            <button class="font-tester-preset-btn" data-text="The quick brown fox jumps over the lazy dog">Sphinx</button>
            <button class="font-tester-preset-btn" data-text="ABCDEFGHIJKLMNOPQRSTUVWXYZ">Uppercase</button>
            <button class="font-tester-preset-btn" data-text="abcdefghijklmnopqrstuvwxyz">Lowercase</button>
            <button class="font-tester-preset-btn" data-text="0123456789">Numbers</button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ═══════ JOURNAL ═══════ -->
  <section class="section section-journal">
    <div class="container">
      <div class="blog-box">
        <p class="section-label">Journal</p>
        <div class="blog-list">
          <?php
          $journal_query = new WP_Query(array(
            'post_type'      => 'post',
            'posts_per_page' => 3,
            'ignore_sticky_posts' => true,
          ));
          if ($journal_query->have_posts()) :
            while ($journal_query->have_posts()) : $journal_query->the_post(); ?>
              <a href="<?php the_permalink(); ?>" class="blog-link">
                <span class="blog-link__date"><?php echo get_the_date('M j'); ?></span>
                <span class="blog-link__title"><?php the_title(); ?></span>
                <span class="blog-link__arrow">→</span>
              </a>
            <?php endwhile;
            wp_reset_postdata();
          else : ?>
            <a href="#" class="blog-link">
              <span class="blog-link__date">—</span>
              <span class="blog-link__title">No journal entries yet</span>
              <span class="blog-link__arrow">→</span>
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>

  <!-- ═══════ LICENSE & PERKS ═══════ -->
  <section class="process" aria-label="License and perks">
    <div class="container">
      <h2 class="section-label">License &amp; perks</h2>
      <div class="process__grid">
        <div class="process__step">
          <div class="process__icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
          </div>
          <h3>Commercial License</h3>
          <p>Use it anywhere. Personal, client, commercial. No extra fees, no expiry.</p>
        </div>
        <div class="process__step">
          <div class="process__icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="4 7 4 4 20 4 20 7"/><line x1="12" y1="4" x2="12" y2="20"/><line x1="8" y1="20" x2="16" y2="20"/></svg>
          </div>
          <h3>OTF &amp; TTF</h3>
          <p>Print and screen ready. Tested, subset, delivered.</p>
        </div>
        <div class="process__step">
          <div class="process__icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l2.4 7.2L22 12l-7.6 2.8L12 22l-2.4-7.2L2 12l7.6-2.8z"/></svg>
          </div>
          <h3>Bonus Extras</h3>
          <p>Illustrations, logo templates, alternates — varies per font.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ═══════ FREE STUFF ═══════ -->
  <section class="freebies" aria-label="Free fonts">
    <div class="container">
      <h2 class="section-label">Free stuff</h2>
      <div class="freebies__grid">

        <?php if (!empty($freebies)) : ?>
          <?php foreach ($freebies as $i => $p) : if ($i >= 3) break; ?>
            <?php
            $pid    = $p->ID;
            $prod   = wc_get_product($pid);
            $name   = $prod ? $prod->get_name() : get_the_title($pid);
            $img_id = $prod ? $prod->get_image_id() : 0;
            $img_url = $img_id ? wp_get_attachment_image_url($img_id, 'medium') : '';
            $free_preview_class = $img_url ? '' : array('freebie__preview--swashes', 'freebie__preview--ornaments', 'freebie__preview--sample')[$i];
            ?>
            <a href="<?php echo esc_url(get_permalink($pid)); ?>" class="freebie anim-card">
              <span class="freebie__badge">Free</span>
              <?php if ($img_url) : ?>
                <div class="freebie__preview"><img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($name); ?>" loading="lazy"></div>
              <?php else : ?>
                <div class="freebie__preview <?php echo esc_attr($free_preview_class); ?>">Aa</div>
              <?php endif; ?>
              <div class="freebie__body">
                <p class="freebie__name"><?php echo esc_html($name); ?></p>
                <p class="freebie__desc">100% free. Commercial too.</p>
              </div>
            </a>
          <?php endforeach; ?>
        <?php else : ?>
          <?php $fallback_freebies = array(
            array('name' => 'Radiant Summertime', 'color' => '#f0e8f8', 'desc' => 'Warm display font. Full lowercase + numerals.', 'preview' => 'freebie__preview--swashes'),
            array('name' => 'Daisy Hotline', 'color' => '#fef2ef', 'desc' => 'Playful script font. Includes alternates.', 'preview' => 'freebie__preview--ornaments'),
            array('name' => 'Mango Sample', 'color' => '#e8f0ec', 'desc' => 'Try before you buy. Full specimen set.', 'preview' => 'freebie__preview--sample'),
          ); ?>
          <?php foreach ($fallback_freebies as $f) : ?>
            <a href="#" class="freebie anim-card">
              <span class="freebie__badge">Free</span>
              <div class="freebie__preview <?php echo $f['preview']; ?>" style="display:flex;align-items:center;justify-content:center;font-size:2rem;font-weight:700;font-family:var(--font-serif);">Aa</div>
              <div class="freebie__body">
                <p class="freebie__name"><?php echo esc_html($f['name']); ?></p>
                <p class="freebie__desc"><?php echo esc_html($f['desc']); ?></p>
              </div>
            </a>
          <?php endforeach; ?>
        <?php endif; ?>

      </div>
      <a href="<?php echo esc_url(home_url('/product-category/freebies/')); ?>" class="section-more">No catch <span class="section-more__icon">→</span></a>
    </div>
  </section>

  <!-- ═══════ CUSTOM LICENSE ═══════ -->
  <section class="section section-license">
    <div class="container">
      <div class="license-cta__box">
        <div class="license-cta__text">
          <h3>Need something custom?</h3>
          <p>We do custom type commissions, exclusive licenses, and brand font packages. One-off or full family.</p>
        </div>
        <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="license-cta__btn">Talk to us →</a>
      </div>
    </div>
  </section>

</main>

<script>
(function(){
  var s = document.getElementById('tester-size');
  var v = document.getElementById('tester-size-val');
  if (s && v) {
    s.addEventListener('input', function(){ v.textContent = this.value; });
  }
})();
</script>

<?php
get_footer();
