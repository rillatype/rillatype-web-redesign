<?php
/**
 * Rillatype V2 — Homepage
 * Design based on index-playful-v2.html
 */
get_header();

// Helper: show only the minimum/standard price, not variable ranges
function rillatype_min_price($product) {
  if (!$product) return '';
  if ($product->is_type('variable')) {
    return wc_price($product->get_variation_price('min'));
  }
  return $product->get_price_html();
}

// Check if plugins are active
$has_acf = function_exists('get_field');
$has_woo = class_exists('WooCommerce');

// Get featured products (max 3)
$featured_products = array();
if ($has_woo) {
  $query = new WP_Query(array(
    'post_type'      => 'product',
    'posts_per_page' => 3,
    'post_status'    => 'publish',
  ));
  if ($query->have_posts()) {
    $featured_products = $query->posts;
  }
}

// Get latest products (max 4)
$latest_products = array();
if ($has_woo) {
  $query2 = new WP_Query(array(
    'post_type'      => 'product',
    'posts_per_page' => 4,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
  ));
  if ($query2->have_posts()) {
    $latest_products = $query2->posts;
  }
}

// Get freebies (free products, or fallback set)
$freebies = array();
if ($has_woo) {
  $free_q = new WP_Query(array(
    'post_type'      => 'product',
    'posts_per_page' => 3,
    'post_status'    => 'publish',
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

// Get categories
$product_cats = array();
if ($has_woo) {
  $terms = get_terms(array(
    'taxonomy'   => 'product_cat',
    'hide_empty' => false,
  ));
  if (!empty($terms) && !is_wp_error($terms)) {
    $product_cats = $terms;
  }
}

// Get latest posts (max 3)
$latest_posts = array();
$pq = new WP_Query(array(
  'posts_per_page'      => 3,
  'no_found_rows'       => true,
  'ignore_sticky_posts' => true,
));
if ($pq->have_posts()) {
  $latest_posts = $pq->posts;
}
?>

<main id="main">

  <!-- Hero — animated type -->
  <section class="hero" aria-label="Welcome">
    <div class="hero__bg"></div>
    <div class="hero__inner container">
      <p class="hero__tag">The un-curated type foundry</p>
      <div class="type-morph" id="type-morph">
        <span class="type-morph__line">Fonts for</span>
        <span class="type-morph__line">the messy,</span>
        <span class="type-morph__line type-morph__italic">the bold, the real.</span>
      </div>
      <button class="hero__shuffle" id="shuffle-btn" aria-label="Shuffle headline">
        <span>↻</span> Shuffle
      </button>
      <div class="hero__cta-row">
        <a href="<?php echo esc_url($has_woo ? get_permalink(wc_get_page_id('shop')) : home_url('/shop/')); ?>" class="hero__cta">Browse fonts →</a>
      </div>
    </div>
  </section>

  <!-- Featured — clean 3-col -->
  <section class="featured" aria-label="Featured fonts">
    <div class="container">
      <p class="section-label">Featured specimens</p>
      <div class="font-showcase">

        <?php if (!empty($featured_products)) : ?>
          <?php foreach ($featured_products as $p) : $pid = $p->ID; ?>
            <?php
            $prod   = wc_get_product($pid);
            $name   = $prod ? $prod->get_name() : get_the_title($pid);
            $price  = rillatype_min_price($prod);
            $img_id = $prod ? $prod->get_image_id() : 0;
            $cat_t  = strip_tags(wc_get_product_category_list($pid));
            $img_url = $img_id ? wp_get_attachment_image_url($img_id, 'medium') : '';
            $style  = $img_url ? 'background-image:url(\'' . esc_url($img_url) . '\');background-size:cover;background-position:center;' : '';
            ?>
            <a href="<?php echo esc_url(get_permalink($pid)); ?>" class="font-card anim-card">
              <div class="font-card__preview" style="<?php echo $style; ?>"></div>
              <div class="font-card__body">
                <div class="font-card__info">
                  <span class="font-card__name"><?php echo esc_html($name); ?></span>
                  <span class="font-card__style"><?php echo esc_html($cat_t ?: 'font'); ?></span>
                </div>
                <span class="font-card__price"><?php echo $price; ?></span>
              </div>
            </a>
          <?php endforeach; ?>
        <?php else : ?>
          <!-- Fallback placeholders -->
          <?php $fallback_fonts = array(
            array('name' => 'Sample Serif', 'style' => 'serif', 'price' => '$18', 'color' => '#fef0e0'),
            array('name' => 'Crimson Queen', 'style' => 'bold display', 'price' => '$22', 'color' => '#eaf0e4'),
            array('name' => 'Baldock', 'style' => 'vintage serif', 'price' => '$20', 'color' => '#f4eaf4'),
          ); ?>
          <?php foreach ($fallback_fonts as $f) : ?>
            <a href="#" class="font-card anim-card">
              <div class="font-card__preview" style="background:<?php echo $f['color']; ?>;display:flex;align-items:center;justify-content:center;color:#3d2a1a;font-size:2rem;font-weight:700;font-family:var(--font-serif);">Aa</div>
              <div class="font-card__body">
                <div class="font-card__info">
                  <span class="font-card__name"><?php echo esc_html($f['name']); ?></span>
                  <span class="font-card__style"><?php echo esc_html($f['style']); ?></span>
                </div>
                <span class="font-card__price"><?php echo esc_html($f['price']); ?></span>
              </div>
            </a>
          <?php endforeach; ?>
        <?php endif; ?>

      </div>
    </div>
  </section>

  <!-- License & perks -->
  <section class="process" aria-label="License and perks">
    <div class="container">
      <p class="section-label">License &amp; perks</p>
      <div class="process__grid">
        <div class="process__step">
          <div class="process__icon">📜</div>
          <h3>Commercial License</h3>
          <p>Use it anywhere. Personal, client, commercial. No extra fees, no expiry.</p>
        </div>
        <div class="process__step">
          <div class="process__icon">🔤</div>
          <h3>OTF &amp; TTF</h3>
          <p>Print and screen ready. Tested, subset, delivered.</p>
        </div>
        <div class="process__step">
          <div class="process__icon">🎁</div>
          <h3>Bonus Extras</h3>
          <p>Illustrations, logo templates, alternates — varies per font.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Freebies -->
  <section class="freebies" aria-label="Free fonts">
    <div class="container">
      <p class="section-label">Free stuff</p>
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
              <div class="freebie__preview <?php echo esc_attr($free_preview_class); ?>" style="<?php echo $img_url ? 'background-image:url(\'' . esc_url($img_url) . '\');background-size:cover;background-position:center;' : ''; ?>"></div>
              <div class="freebie__body">
                <p class="freebie__name"><?php echo esc_html($name); ?></p>
                <p class="freebie__desc">Premium quality. Free for personal use.</p>
              </div>
            </a>
          <?php endforeach; ?>
        <?php else : ?>
          <!-- Fallback freebies -->
          <?php $freebies = array(
            array('name' => 'Radiant Summertime', 'color' => '#f0e8f8', 'desc' => 'Warm display font. Full lowercase + numerals.', 'preview' => 'freebie__preview--swashes'),
            array('name' => 'Daisy Hotline', 'color' => '#fef2ef', 'desc' => 'Playful script font. Includes alternates.', 'preview' => 'freebie__preview--ornaments'),
            array('name' => 'Mango Sample', 'color' => '#e8f0ec', 'desc' => 'Try before you buy. Full specimen set.', 'preview' => 'freebie__preview--sample'),
          ); ?>
          <?php foreach ($freebies as $f) : ?>
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
    </div>
  </section>

  <!-- Graphic Assets -->
  <section class="other-products" aria-label="Graphic assets">
    <div class="container">
      <p class="section-label">Graphic assets</p>
      <div class="other-products__grid">
        <a href="<?php echo esc_url(home_url('/product-category/graphic/')); ?>" class="product-type">
          <div class="product-type__icon">🎨</div>
          <h3>Social Media Templates</h3>
          <p>Ready-to-use Canva &amp; PSD templates for Instagram, Pinterest, and Facebook posts.</p>
        </a>
        <a href="<?php echo esc_url(home_url('/product-category/graphic/')); ?>" class="product-type">
          <div class="product-type__icon">✏️</div>
          <h3>Branding Kits</h3>
          <p>Logo templates, color palettes, and mockup sets for designers and small businesses.</p>
        </a>
        <a href="<?php echo esc_url(home_url('/product-category/font/')); ?>" class="product-type">
          <div class="product-type__icon">🔤</div>
          <h3>Font Bundles</h3>
          <p>Coming soon — curated font packs at bundle pricing. Stay tuned.</p>
        </a>
      </div>
    </div>
  </section>

  <!-- Latest releases -->
  <section class="latest" aria-label="Latest releases">
    <div class="container">
      <p class="section-label">Fresh drops</p>
      <div class="latest__grid">

        <?php if (!empty($latest_products)) : ?>
          <?php foreach ($latest_products as $p) : ?>
            <?php
            $pid    = $p->ID;
            $prod   = wc_get_product($pid);
            $name   = $prod ? $prod->get_name() : get_the_title($pid);
            $raw_price  = $prod ? ($prod->is_type('variable') ? $prod->get_variation_price('min') : $prod->get_price()) : 0;
            $is_free    = $raw_price !== '' && (float) $raw_price <= 0;
            $price      = rillatype_min_price($prod);
            $img_id = $prod ? $prod->get_image_id() : 0;
            $img_url = $img_id ? wp_get_attachment_image_url($img_id, 'medium') : '';
            $style  = $img_url ? 'background-image:url(\'' . esc_url($img_url) . '\');background-size:cover;background-position:center;' : 'background:#eef0f4;display:flex;align-items:center;justify-content:center;font-size:2rem;font-family:var(--font-serif);';
            ?>
            <a href="<?php echo esc_url(get_permalink($pid)); ?>" class="latest__item anim-card">
              <div class="latest__preview" style="<?php echo $style; ?>"><?php echo $img_url ? '' : 'Aa'; ?></div>
              <div class="latest__body">
                <p class="latest__name"><?php echo esc_html($name); ?></p>
                <?php if ($is_free) : ?>
                  <span class="latest__badge">Free</span>
                <?php else : ?>
                  <p class="latest__price"><?php echo $price; ?></p>
                <?php endif; ?>
              </div>
            </a>
          <?php endforeach; ?>
        <?php else : ?>
          <!-- Fallback -->
          <?php $lates = array(
            array('name' => 'Bawden', 'price' => '$18', 'style' => 'background:#eef0f4;'),
            array('name' => 'Moyshire', 'price' => '$16', 'style' => 'background:#f7f0e4;'),
            array('name' => 'Mordial', 'price' => '$24', 'style' => 'background:#eef2f6;'),
            array('name' => 'Radiant', 'price' => '$15', 'style' => 'background:#f2eee8;'),
          ); ?>
          <?php foreach ($lates as $l) : ?>
            <a href="#" class="latest__item anim-card">
              <div class="latest__preview" style="<?php echo $l['style']; ?>display:flex;align-items:center;justify-content:center;font-size:2rem;font-family:var(--font-serif);">Aa</div>
              <div class="latest__body">
                <p class="latest__name"><?php echo esc_html($l['name']); ?></p>
                <p class="latest__price"><?php echo esc_html($l['price']); ?></p>
              </div>
            </a>
          <?php endforeach; ?>
        <?php endif; ?>

      </div>
    </div>
  </section>

  <!-- Categories -->
  <section class="categories" aria-label="Categories">
    <div class="container">
      <p class="section-label">Browse by style</p>
      <div class="categories__cloud">
        <?php if (!empty($product_cats)) : ?>
          <?php foreach ($product_cats as $cat) : ?>
            <a href="<?php echo esc_url(get_term_link($cat)); ?>" class="categories__pill anim-card">
              <?php echo esc_html($cat->name); ?> <small><?php echo esc_html($cat->count); ?></small>
            </a>
          <?php endforeach; ?>
        <?php else : ?>
          <a href="#" class="categories__pill anim-card">Display <small>12</small></a>
          <a href="#" class="categories__pill anim-card">Script <small>8</small></a>
          <a href="#" class="categories__pill anim-card">Handwritten <small>6</small></a>
          <a href="#" class="categories__pill anim-card">Sans <small>10</small></a>
          <a href="#" class="categories__pill anim-card">Serif <small>5</small></a>
          <a href="#" class="categories__pill anim-card">Freebies <small>4</small></a>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- Blog -->
  <section class="blog-section" aria-label="Blog">
    <div class="container">
      <div class="blog-box">
        <p class="section-label">From the studio</p>
        <div class="blog-list">
          <?php if (!empty($latest_posts)) : ?>
            <?php foreach ($latest_posts as $p) : ?>
              <a href="<?php echo esc_url(get_permalink($p->ID)); ?>" class="blog-link">
                <span class="blog-link__date"><?php echo get_the_date(get_option('date_format'), $p->ID); ?></span>
                <span class="blog-link__title"><?php echo esc_html(get_the_title($p->ID)); ?></span>
                <span class="blog-link__arrow">→</span>
              </a>
            <?php endforeach; ?>
          <?php else : ?>
            <div class="blog-link">
              <span class="blog-link__date">—</span>
              <span class="blog-link__title">No journal entries yet.</span>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>

  <!-- Custom License -->
  <section class="license-cta" aria-label="Custom license">
    <div class="container">
      <div class="license-cta__box">
        <div class="license-cta__text">
          <h3>Need something custom?</h3>
          <p>We do custom type commissions, exclusive licenses, and brand font packages. One-off or full family.</p>
        </div>
        <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="license-cta__btn">Talk to us <span class="arrow">→</span></a>
      </div>
    </div>
  </section>

</main>

<script>
(function(){
  var headlines = [
    ['Fonts for', 'the messy,', '<span class="type-morph__italic">the bold, the real.</span>'],
    ['Not another', 'sans serif.', '<span class="type-morph__italic">\u2014 probably.</span>'],
    ['Good letters', 'do not need', '<span class="type-morph__italic">an intro.</span>'],
    ['Un-curated,', 'un-filtered.', '<span class="type-morph__italic">\u2014 just drawn.</span>'],
    ['From our', 'desk to', '<span class="type-morph__italic">your project.</span>']
  ];
  var hIdx = 0;
  var btn = document.getElementById('shuffle-btn');
  if (btn) {
    btn.addEventListener('click', function() {
      hIdx = (hIdx + 1) % headlines.length;
      var lines = document.querySelectorAll('.type-morph__line');
      headlines[hIdx].forEach(function(html, i) {
        if (lines[i]) {
          lines[i].style.animation = 'none';
          lines[i].innerHTML = html;
          void lines[i].offsetWidth;
          lines[i].style.animation = 'typeSlide .6s cubic-bezier(.16,1,.3,1) both';
          lines[i].style.animationDelay = (i * 0.12) + 's';
        }
      });
    });
  }
})();
</script>

<?php get_footer(); ?>
