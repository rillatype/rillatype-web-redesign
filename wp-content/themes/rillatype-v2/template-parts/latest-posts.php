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

<?php wp_reset_postdata(); ?>
