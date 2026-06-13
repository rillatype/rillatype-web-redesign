<?php
global $product;
if (!$product) return;
$name = $product->get_name();
$price = $product->get_price_html();
$img_url = get_the_post_thumbnail_url($product->get_id(), 'medium');
$is_free = $product->get_price() !== '' && (float) $product->get_price() <= 0;
$raw_price = $product->is_type('variable') ? $product->get_variation_price('min') : $product->get_price();
$has_free_class = $raw_price !== '' && (float) $raw_price <= 0;
if (preg_match('/^(.+?)\s*[—–]\s*(.+)$/', $name, $m) || preg_match('/^(.+?)\s*-\s*(.+)$/', $name, $m)) {
  $title = trim($m[1]);
  $sub   = ucwords(strtolower(trim($m[2])));
} else {
  $title = $name;
  $sub   = '';
}
?>
<a href="<?php the_permalink(); ?>" class="font-card anim-card">
  <?php if ($img_url) : ?>
    <div class="font-card__preview"><img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($title); ?>" loading="lazy"></div>
  <?php else : ?>
    <div class="font-card__preview" style="display:flex;align-items:center;justify-content:center;font-size:2rem;font-family:var(--font-serif);background:#eef0f4;">Aa</div>
  <?php endif; ?>
  <div class="font-card__body">
    <div class="font-card__info">
      <span class="font-card__name"><?php echo esc_html($title); ?></span>
      <?php if ($sub) : ?>
        <span class="font-card__style"><?php echo esc_html($sub); ?></span>
      <?php endif; ?>
    </div>
    <?php if ($has_free_class) : ?>
      <span class="font-card__badge">Free</span>
    <?php else : ?>
      <span class="font-card__price"><?php echo $price; ?></span>
    <?php endif; ?>
  </div>
</a>
