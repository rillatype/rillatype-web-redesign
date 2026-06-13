<?php
if (!$breadcrumb) return;
?>
<nav class="shop-breadcrumb" itemprop="breadcrumb">
  <?php foreach ($breadcrumb as $key => $crumb) : ?>
    <?php if (!empty($crumb[1]) && $key !== array_key_last($breadcrumb)) : ?>
      <a href="<?php echo esc_url($crumb[1]); ?>"><?php echo esc_html($crumb[0]); ?></a>
      <span class="shop-breadcrumb__sep">/</span>
    <?php else : ?>
      <span class="shop-breadcrumb__current"><?php echo esc_html($crumb[0]); ?></span>
    <?php endif; ?>
  <?php endforeach; ?>
</nav>
