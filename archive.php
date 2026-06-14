<?php
get_header();
?>

<main id="main" class="site-main archive-main">
  <div class="container">
    <?php if (have_posts()) : ?>
      <h1 class="archive-title">
        <?php
        if (is_category()) {
          single_cat_title();
        } elseif (is_tag()) {
          printf(esc_html__('Tag: %s', 'rillatype-v2'), single_tag_title('', false));
        } elseif (is_author()) {
          printf(esc_html__('Author: %s', 'rillatype-v2'), get_the_author());
        } elseif (is_day()) {
          printf(esc_html__('Day: %s', 'rillatype-v2'), get_the_date());
        } elseif (is_month()) {
          printf(esc_html__('Month: %s', 'rillatype-v2'), get_the_date('F Y'));
        } elseif (is_year()) {
          printf(esc_html__('Year: %s', 'rillatype-v2'), get_the_date('Y'));
        } else {
          esc_html_e('Archives', 'rillatype-v2');
        }
        ?>
      </h1>

      <div class="archive-list">
        <?php while (have_posts()) : the_post(); ?>
          <article id="post-<?php the_ID(); ?>" <?php post_class('archive-item'); ?>>
            <h2 class="archive-item__title">
              <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h2>
            <p class="archive-item__meta">
              <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date()); ?></time>
            </p>
            <div class="archive-item__excerpt">
              <?php the_excerpt(); ?>
            </div>
          </article>
        <?php endwhile; ?>
      </div>

      <?php the_posts_pagination(); ?>

    <?php else : ?>
      <div class="archive-empty">
        <h1 class="archive-title"><?php esc_html_e('Nothing found', 'rillatype-v2'); ?></h1>
        <p><?php esc_html_e('No posts in this archive yet.', 'rillatype-v2'); ?></p>
      </div>
    <?php endif; ?>
  </div>
</main>

<?php
get_footer();
