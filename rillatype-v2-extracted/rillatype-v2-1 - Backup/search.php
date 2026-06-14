<?php
get_header();
?>

<main id="main" class="site-main search-main">
  <div class="container">
    <h1 class="search-title">
      <?php
      printf(
        esc_html__('Search results for: %s', 'rillatype-v2'),
        '<strong>' . get_search_query() . '</strong>'
      );
      ?>
    </h1>

    <?php if (have_posts()) : ?>
      <div class="search-results">
        <?php while (have_posts()) : the_post(); ?>
          <article id="post-<?php the_ID(); ?>" <?php post_class('search-item'); ?>>
            <h2 class="search-item__title">
              <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h2>
            <p class="search-item__excerpt"><?php echo get_the_excerpt(); ?></p>
            <span class="search-item__type"><?php echo get_post_type_object(get_post_type())->labels->singular_name ?? get_post_type(); ?></span>
          </article>
        <?php endwhile; ?>
      </div>
      <?php the_posts_pagination(); ?>
    <?php else : ?>
      <div class="search-empty">
        <p><?php esc_html_e('Nothing found. Try a different search term.', 'rillatype-v2'); ?></p>
        <?php get_search_form(); ?>
      </div>
    <?php endif; ?>
  </div>
</main>

<?php
get_footer();
