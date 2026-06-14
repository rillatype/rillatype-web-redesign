<?php
get_header();

$shop_title   = woocommerce_page_title(false);
$is_main_shop = is_shop();
?>

<section class="archive-shop" aria-label="Font archive">
  <div class="container">

    <?php do_action('woocommerce_before_main_content'); ?>

    <p class="section-label">
      <?php echo $is_main_shop ? 'All fonts' : esc_html($shop_title); ?>
    </p>

    <?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
      <h1 class="archive-shop__title">
        <?php echo $is_main_shop ? 'Browse fonts' : esc_html($shop_title); ?>
      </h1>
    <?php endif; ?>

    <?php if ($is_main_shop) : ?>
      <?php
      $cats = get_terms(array(
        'taxonomy' => 'product_cat',
        'hide_empty' => true,
        'parent' => 0,
      ));
      if (!empty($cats) && !is_wp_error($cats)) :
      ?>
      <nav class="categories__cloud" aria-label="Font categories">
        <?php foreach ($cats as $cat) : ?>
          <a href="<?php echo esc_url(get_term_link($cat)); ?>" class="categories__pill anim-card">
            <?php echo esc_html($cat->name); ?>
            <small><?php echo esc_html($cat->count); ?></small>
          </a>
        <?php endforeach; ?>
      </nav>
      <?php endif; ?>
    <?php endif; ?>

    <?php if (woocommerce_product_loop()) : ?>

      <div class="archive-shop__toolbar">
        <?php do_action('woocommerce_before_shop_loop'); ?>
      </div>

      <?php
      woocommerce_product_loop_start();

      if (wc_get_loop_prop('total')) {
        while (have_posts()) {
          the_post();
          wc_get_template_part('content', 'product');
        }
      }

      woocommerce_product_loop_end();
      ?>

      <?php do_action('woocommerce_after_shop_loop'); ?>

    <?php else : ?>
      <?php do_action('woocommerce_no_products_found'); ?>
    <?php endif; ?>

  </div>
</section>

<?php get_footer(); ?>
