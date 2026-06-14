<?php
get_header();
?>

<main id="main" class="site-main page-main">
  <div class="container">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class('page-article'); ?>>
        <h1 class="page-title"><?php the_title(); ?></h1>
        <div class="page-content">
          <?php the_content(); ?>
        </div>
      </article>
    <?php endwhile; endif; ?>
  </div>
</main>

<?php
get_footer();
