<?php
/**
 * Rillatype V2 — Homepage (Works Without Plugins)
 * Fallback content when ACF/WooCommerce not installed
 */
get_header();

// Debug marker — remove after testing
echo '<!-- RILLATYPE FRONT PAGE LOADED -->';

// Check if plugins are active
$has_acf    = function_exists('get_field');
$has_woo    = class_exists('WooCommerce');
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
