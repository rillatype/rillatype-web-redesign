<?php
global $wp_query;
if ($wp_query->max_num_pages <= 1) return;

$big = 999999999;
$current = max(1, get_query_var('paged'));
$total = $wp_query->max_num_pages;
?>
<nav class="pagination" aria-label="Page navigation">
  <?php for ($i = 1; $i <= $total; $i++) :
    if ($i === $current) : ?>
      <span class="current"><?php echo $i; ?></span>
    <?php else : ?>
      <a href="<?php echo esc_url(get_pagenum_link($i)); ?>"><?php echo $i; ?></a>
    <?php endif;
  endfor; ?>
</nav>
