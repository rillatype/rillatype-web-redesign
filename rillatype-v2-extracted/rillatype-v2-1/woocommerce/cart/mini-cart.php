<?php
if (!defined('ABSPATH')) exit;
$items = WC()->cart->get_cart();
?>
<ul class="mini-cart">
  <?php foreach ($items as $key => $item) : ?>
    <?php $product = $item['data']; ?>
    <li class="mini-cart__item">
      <span class="mini-cart__name"><?php echo esc_html($product->get_name()); ?></span>
      <span class="mini-cart__qty">x<?php echo esc_html($item['quantity']); ?></span>
    </li>
  <?php endforeach; ?>
</ul>
