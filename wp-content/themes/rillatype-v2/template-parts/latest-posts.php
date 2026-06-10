<?php
/**
 * Latest posts list template part.
 * Displays the 3 most recent posts with title and date.
 */

$latest = new WP_Query(array(
  'posts_per_page'      => 3,
  'no_found_rows'       => true,
  'ignore_sticky_posts' => true,
));

if (!$latest->have_posts()) {
  return;
}
?>

<section class="latest-posts">
  <h2 class="latest-posts__heading">
    <?php esc_html_e('Latest from the journal', 'rillatype-v2'); ?>
  </h2>

  <ul class="latest-posts__list">
    <?php while ($latest->have_posts()) : $latest->the_post(); ?>
      <li class="latest-posts__item">
        <article>
          <h3 class="latest-posts__title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
          </h3>
          <time class="latest-posts__date" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
            <?php echo esc_html(get_the_date()); ?>
          </time>
        </article>
      </li>
    <?php endwhile; ?>
  </ul>
</section>

<style>
.latest-posts {
  margin: var(--spacing-lg, 4rem) 0;
}

.latest-posts__heading {
  font-family: var(--font-heading, Georgia, serif);
  font-size: 1.25rem;
  font-weight: 400;
  margin: 0 0 var(--spacing-md, 2rem);
  color: var(--color-text, #1A1814);
}

.latest-posts__list {
  list-style: none;
  padding: 0;
  margin: 0;
}

.latest-posts__item {
  padding: var(--spacing-sm, 1rem) 0;
  border-bottom: 1px solid var(--color-gray-200, #E2DFD7);
}

.latest-posts__item:first-child {
  padding-top: 0;
}

.latest-posts__item:last-child {
  border-bottom: 0;
  padding-bottom: 0;
}

.latest-posts__title {
  font-family: var(--font-heading, Georgia, serif);
  font-size: 1.125rem;
  font-weight: 400;
  margin: 0 0 0.25rem;
}

.latest-posts__title a {
  color: var(--color-text, #1A1814);
  text-decoration: none;
}

.latest-posts__title a:hover {
  color: var(--color-accent, #C1493A);
}

.latest-posts__date {
  font-family: var(--font-ui, sans-serif);
  font-size: 0.75rem;
  text-transform: uppercase;
  letter-spacing: 0.06em;
  color: var(--color-gray-400, #8C887D);
}
</style>

<?php wp_reset_postdata(); ?>
