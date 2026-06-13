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
  $featured_count = get_theme_mod('rillatype_featured_count', 3);
  $query = new WP_Query(array(
    'post_type'      => 'product',
    'posts_per_page' => $featured_count,
    'post_status'    => 'publish',
    'tax_query'      => array(array(
      'taxonomy' => 'product_visibility',
      'field'    => 'name',
      'terms'    => 'featured',
    )),
  ));
  if (!$query->have_posts()) {
    $query = new WP_Query(array(
      'post_type'      => 'product',
      'posts_per_page' => $featured_count,
      'post_status'    => 'publish',
    ));
  }
  if ($query->have_posts()) {
    $featured_products = $query->posts;
  }
}

// Get latest products
$latest_products = array();
if ($has_woo) {
  $latest_count = get_theme_mod('rillatype_latest_count', 8);
  $latest_orderby = get_theme_mod('rillatype_latest_orderby', 'date');
  $latest_args = array(
    'post_type'      => 'product',
    'posts_per_page' => $latest_count,
    'post_status'    => 'publish',
  );
  if ($latest_orderby === 'price') {
    $latest_args['orderby']  = 'meta_value_num';
    $latest_args['meta_key'] = '_price';
    $latest_args['order']    = 'ASC';
  } elseif ($latest_orderby === 'price-desc') {
    $latest_args['orderby']  = 'meta_value_num';
    $latest_args['meta_key'] = '_price';
    $latest_args['order']    = 'DESC';
  } else {
    $latest_args['orderby'] = $latest_orderby;
    $latest_args['order']   = 'DESC';
  }
  $query2 = new WP_Query($latest_args);
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
      <div class="hero__actions">
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
            $full   = $prod ? $prod->get_name() : get_the_title($pid);
            $price  = rillatype_min_price($prod);
            $img_id = $prod ? $prod->get_image_id() : 0;
            $img_url = $img_id ? wp_get_attachment_image_url($img_id, 'medium') : '';
            $style  = $img_url ? 'background-image:url(\'' . esc_url($img_url) . '\');background-size:cover;background-position:center;' : '';
            // Split name on " — ", " – ", or " - " for title / subtitle
            if (preg_match('/^(.+?)\s*[—–]\s*(.+)$/', $full, $m) || preg_match('/^(.+?)\s*-\s*(.+)$/', $full, $m)) {
              $name  = trim($m[1]);
              $sub   = ucwords(strtolower(trim($m[2])));
            } else {
              $name  = $full;
              $sub   = '';
            }
            ?>
            <a href="<?php echo esc_url(get_permalink($pid)); ?>" class="font-card anim-card">
              <div class="font-card__preview" style="<?php echo $style; ?>"></div>
              <div class="font-card__body">
                <div class="font-card__info">
                  <span class="font-card__name"><?php echo esc_html($name); ?></span>
                  <?php if ($sub) : ?>
                    <span class="font-card__style"><?php echo esc_html($sub); ?></span>
                  <?php endif; ?>
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
                <p class="freebie__desc">100% free. Commercial too.</p>
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
      <a href="<?php echo esc_url($has_woo ? get_permalink(wc_get_page_id('shop')) : home_url('/shop/')); ?>" class="section-more">No catch <span class="section-more__icon">→</span></a>
    </div>
  </section>

  <!-- Graphic Assets (hidden) -->

  <!-- Latest releases -->
  <section class="latest" aria-label="Latest releases">
    <div class="container">
      <p class="section-label">Fresh drops</p>
      <div class="font-showcase font-showcase--wide">

        <?php if (!empty($latest_products)) : ?>
          <?php foreach ($latest_products as $p) : ?>
            <?php
            $pid    = $p->ID;
            $prod   = wc_get_product($pid);
            $full   = $prod ? $prod->get_name() : get_the_title($pid);
            $raw_price  = $prod ? ($prod->is_type('variable') ? $prod->get_variation_price('min') : $prod->get_price()) : 0;
            $is_free    = $raw_price !== '' && (float) $raw_price <= 0;
            $price      = rillatype_min_price($prod);
            $img_id = $prod ? $prod->get_image_id() : 0;
            $img_url = $img_id ? wp_get_attachment_image_url($img_id, 'medium') : '';
            $style  = $img_url ? 'background-image:url(\'' . esc_url($img_url) . '\');background-size:cover;background-position:center;' : 'background:#eef0f4;display:flex;align-items:center;justify-content:center;font-size:2rem;font-family:var(--font-serif);';
            if (preg_match('/^(.+?)\s*[—–]\s*(.+)$/', $full, $m) || preg_match('/^(.+?)\s*-\s*(.+)$/', $full, $m)) {
              $name  = trim($m[1]);
              $sub   = ucwords(strtolower(trim($m[2])));
            } else {
              $name  = $full;
              $sub   = '';
            }
            ?>
            <a href="<?php echo esc_url(get_permalink($pid)); ?>" class="font-card anim-card">
              <div class="font-card__preview" style="<?php echo $style; ?>"></div>
              <div class="font-card__body">
                <div class="font-card__info">
                  <span class="font-card__name"><?php echo esc_html($name); ?></span>
                  <?php if ($sub) : ?>
                    <span class="font-card__style"><?php echo esc_html($sub); ?></span>
                  <?php endif; ?>
                </div>
                <?php if ($is_free) : ?>
                  <span class="font-card__badge">Free</span>
                <?php else : ?>
                  <span class="font-card__price"><?php echo $price; ?></span>
                <?php endif; ?>
              </div>
            </a>
          <?php endforeach; ?>
        <?php else : ?>
          <!-- Fallback cards -->
          <?php $lates = array(
            array('name' => 'Bawden', 'sub' => 'Bold Display', 'price' => '$18'),
            array('name' => 'Moyshire', 'sub' => 'Script Font', 'price' => '$16'),
            array('name' => 'Mordial', 'sub' => 'Vintage Serif', 'price' => '$24'),
            array('name' => 'Radiant', 'sub' => 'Sans Serif', 'price' => '$15'),
          ); ?>
          <?php foreach ($lates as $l) : ?>
            <a href="#" class="font-card anim-card">
              <div class="font-card__preview" style="background:#eef0f4;display:flex;align-items:center;justify-content:center;font-size:2rem;font-family:var(--font-serif);">Aa</div>
              <div class="font-card__body">
                <div class="font-card__info">
                  <span class="font-card__name"><?php echo esc_html($l['name']); ?></span>
                  <span class="font-card__style"><?php echo esc_html($l['sub']); ?></span>
                </div>
                <span class="font-card__price"><?php echo esc_html($l['price']); ?></span>
              </div>
            </a>
          <?php endforeach; ?>
        <?php endif; ?>

      </div>
      <a href="<?php echo esc_url($has_woo ? get_permalink(wc_get_page_id('shop')) : home_url('/shop/')); ?>" class="section-more">What dropped <span class="section-more__icon">→</span></a>
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
        <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="section-label section-label--link">From the studio</a>
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
        <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="section-more">More words <span class="section-more__icon">→</span></a>
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
    ['Perfect is', 'overrated.', '<span class="type-morph__italic">Make a mess.</span>'],
    ['Made with', 'coffee and', '<span class="type-morph__italic">bad handwriting.</span>'],
    ['Pick one.', 'Buy once.', '<span class="type-morph__italic">Use forever.</span>']
  ];
  var hIdx = Math.floor(Math.random() * headlines.length);
  var lines = document.querySelectorAll('.type-morph__line');
  showHeadline(hIdx);

  function showHeadline(idx) {
    var data = headlines[idx % headlines.length];
    data.forEach(function(html, i) {
      if (lines[i]) {
        lines[i].style.animation = 'none';
        lines[i].innerHTML = html;
        void lines[i].offsetWidth;
        lines[i].style.animation = 'typeSlide .6s cubic-bezier(.16,1,.3,1) both';
        lines[i].style.animationDelay = (i * 0.12) + 's';
      }
    });
  }

  setInterval(function() {
    hIdx = (hIdx + 1) % headlines.length;
    showHeadline(hIdx);
  }, 5000);
})();
</script>

<?php get_footer(); ?>
