<?php
get_header();

$hero_title       = get_field('hero_title') ?: 'Where type meets craft.';
$hero_text        = get_field('hero_text') ?: 'Premium display & text fonts for designers who refuse to compromise.';
$hero_image       = get_field('hero_image');
$hero_cta_text    = get_field('hero_cta_text') ?: 'Browse Fonts';
$hero_cta_url     = get_field('hero_cta_url') ?: home_url('/shop');

$featured_fonts_title = get_field('featured_fonts_title') ?: 'Featured Fonts';
$featured_fonts       = get_field('featured_fonts');

$categories_title = get_field('categories_title') ?: 'Browse by Category';
$categories        = get_field('font_categories');

$latest_title     = get_field('latest_releases_title') ?: 'Latest Releases';
$latest_fonts     = get_field('latest_releases');

$tester_title     = get_field('tester_title') ?: 'Try a font';
$tester_text      = get_field('tester_text') ?: 'Type your message and see it come to life.';
?>

<main id="main" class="site-main front-page">

  <section class="hero-section">
    <div class="hero-grid container">
      <div class="hero-content">
        <h1 class="hero-title"><?php echo esc_html($hero_title); ?></h1>
        <p class="hero-text"><?php echo esc_html($hero_text); ?></p>
        <a href="<?php echo esc_url($hero_cta_url); ?>" class="button button-primary"><?php echo esc_html($hero_cta_text); ?></a>
      </div>
      <div class="hero-image">
        <?php if ($hero_image) : ?>
          <img src="<?php echo esc_url($hero_image['url']); ?>" alt="<?php echo esc_attr($hero_image['alt'] ?: $hero_title); ?>">
        <?php else : ?>
          <div class="hero-image-placeholder"></div>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <section class="featured-fonts-section">
    <div class="container">
      <h2 class="section-title"><?php echo esc_html($featured_fonts_title); ?></h2>
      <div class="font-grid grid-3">
        <?php if (!empty($featured_fonts)) : ?>
          <?php foreach ($featured_fonts as $font) : ?>
            <div class="font-card">
              <?php if (!empty($font['image'])) : ?>
                <img src="<?php echo esc_url($font['image']['url']); ?>" alt="<?php echo esc_attr($font['title'] ?? ''); ?>">
              <?php endif; ?>
              <h3><?php echo esc_html($font['title'] ?? ''); ?></h3>
              <?php if (!empty($font['description'])) : ?>
                <p><?php echo esc_html($font['description']); ?></p>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        <?php else : ?>
          <?php for ($i = 1; $i <= 3; $i++) : ?>
            <div class="font-card font-card-placeholder">
              <div class="placeholder-image"></div>
              <h3>Font Name <?php echo $i; ?></h3>
              <p>Description of this premium typeface and its best use cases.</p>
            </div>
          <?php endfor; ?>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <section class="categories-section">
    <div class="container">
      <h2 class="section-title"><?php echo esc_html($categories_title); ?></h2>
      <div class="categories-bar">
        <?php if (!empty($categories)) : ?>
          <?php foreach ($categories as $cat) : ?>
            <a href="<?php echo esc_url($cat['link'] ?? '#'); ?>" class="category-link">
              <?php echo esc_html($cat['name'] ?? ''); ?>
            </a>
          <?php endforeach; ?>
        <?php else : ?>
          <?php
          $default_cats = array('Serif', 'Sans Serif', 'Display', 'Script', 'Monospace', 'Variable');
          foreach ($default_cats as $cat) : ?>
            <a href="#" class="category-link"><?php echo esc_html($cat); ?></a>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <section class="latest-releases-section">
    <div class="container">
      <h2 class="section-title"><?php echo esc_html($latest_title); ?></h2>
      <div class="font-grid grid-3">
        <?php if (!empty($latest_fonts)) : ?>
          <?php foreach ($latest_fonts as $font) : ?>
            <div class="font-card">
              <?php if (!empty($font['image'])) : ?>
                <img src="<?php echo esc_url($font['image']['url']); ?>" alt="<?php echo esc_attr($font['title'] ?? ''); ?>">
              <?php endif; ?>
              <h3><?php echo esc_html($font['title'] ?? ''); ?></h3>
              <?php if (!empty($font['description'])) : ?>
                <p><?php echo esc_html($font['description']); ?></p>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        <?php else : ?>
          <?php for ($i = 1; $i <= 3; $i++) : ?>
            <div class="font-card font-card-placeholder">
              <div class="placeholder-image"></div>
              <h3>New Release <?php echo $i; ?></h3>
              <p>Our latest typeface, freshly crafted for discerning designers.</p>
            </div>
          <?php endfor; ?>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <section class="font-tester-section">
    <div class="container container-narrow">
      <h2 class="section-title"><?php echo esc_html($tester_title); ?></h2>
      <p class="tester-text"><?php echo esc_html($tester_text); ?></p>
      <div class="font-tester" id="font-tester">
        <input type="text" id="tester-input" class="tester-input" placeholder="Type something..." value="The quick brown fox">
        <div class="tester-preview" id="tester-preview">The quick brown fox</div>
      </div>
    </div>
  </section>

  <section class="journal-section">
    <div class="container">
      <h2 class="section-title"><?php esc_html_e('Journal', 'rillatype-v2'); ?></h2>
      <div class="journal-grid grid-3">
        <?php
        $journal_query = new WP_Query(array(
          'post_type'      => 'post',
          'posts_per_page' => 3,
          'ignore_sticky_posts' => true,
        ));
        if ($journal_query->have_posts()) :
          while ($journal_query->have_posts()) : $journal_query->the_post(); ?>
            <article class="journal-card">
              <?php if (has_post_thumbnail()) : ?>
                <div class="journal-thumb"><?php the_post_thumbnail('medium'); ?></div>
              <?php endif; ?>
              <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
              <p><?php echo wp_trim_words(get_the_excerpt() ?: get_the_content(), 20); ?></p>
              <a href="<?php the_permalink(); ?>" class="journal-read-more"><?php esc_html_e('Read More', 'rillatype-v2'); ?></a>
            </article>
          <?php endwhile;
          wp_reset_postdata();
        else : ?>
          <?php for ($i = 1; $i <= 3; $i++) : ?>
            <article class="journal-card journal-card-placeholder">
              <div class="placeholder-image"></div>
              <h3>Journal Entry <?php echo $i; ?></h3>
              <p>Stories from the world of type design, typography, and visual culture.</p>
              <a href="#" class="journal-read-more"><?php esc_html_e('Read More', 'rillatype-v2'); ?></a>
            </article>
          <?php endfor; ?>
        <?php endif; ?>
      </div>
    </div>
  </section>

</main>

<?php
get_footer();
