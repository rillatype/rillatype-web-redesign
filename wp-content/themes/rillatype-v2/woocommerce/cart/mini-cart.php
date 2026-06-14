<?php
defined('ABSPATH') || exit;

do_action('woocommerce_before_mini_cart');

// Guard WC cart
if (!function_exists('WC') || !WC()->cart) {
  return;
}
?>

<?php if (!WC()->cart->is_empty()) : ?>

  <ul class="mini-cart__items">
    <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) :
      $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
      $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

      if (!$_product || !$_product->exists() || $cart_item['quantity'] < 1) continue;

      $product_name     = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
      $thumbnail        = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image('thumbnail'), $cart_item, $cart_item_key);
      $product_price    = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
      $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
    ?>
      <li class="mini-cart__item" data-cart-key="<?php echo esc_attr($cart_item_key); ?>">
        <div class="mini-cart__item-img">
          <?php if ($product_permalink) : ?><a href="<?php echo esc_url($product_permalink); ?>"><?php endif; ?>
            <?php echo $thumbnail; ?>
          <?php if ($product_permalink) : ?></a><?php endif; ?>
        </div>
        <div class="mini-cart__item-body">
          <a href="<?php echo esc_url($product_permalink ?: '#'); ?>" class="mini-cart__item-name"><?php echo $product_name; ?></a>
          <span class="mini-cart__item-qty"><?php echo esc_html($cart_item['quantity']); ?> × <?php echo $product_price; ?></span>
        </div>
        <a href="<?php echo esc_url(wc_get_cart_remove_url($cart_item_key)); ?>" class="mini-cart__item-remove" aria-label="<?php esc_attr_e('Remove', 'rillatype-v2'); ?>">✕</a>
      </li>
    <?php endforeach; ?>
  </ul>

  <div class="mini-cart__footer">
    <div class="mini-cart__subtotal">
      <span><?php esc_html_e('Subtotal', 'rillatype-v2'); ?></span>
      <span><?php echo WC()->cart->get_cart_subtotal(); ?></span>
    </div>
    <div class="mini-cart__buttons">
      <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="btn btn--outline btn--block"><?php esc_html_e('View Cart', 'rillatype-v2'); ?></a>
      <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="btn btn--primary btn--block"><?php esc_html_e('Checkout', 'rillatype-v2'); ?></a>
    </div>
  </div>

<?php else : ?>

  <p class="mini-cart__empty"><?php esc_html_e('Your cart is empty.', 'rillatype-v2'); ?></p>

<?php endif; ?>

<?php do_action('woocommerce_after_mini_cart'); ?>
