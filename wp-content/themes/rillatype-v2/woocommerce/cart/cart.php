<?php
defined('ABSPATH') || exit;

do_action('woocommerce_before_cart');

// Guard WC cart
if (!function_exists('WC') || !WC()->cart) {
  return;
}
?>

<div class="cart-page">
  <div class="container">
    <h1 class="cart-page__title"><?php esc_html_e('Your Cart', 'rillatype-v2'); ?></h1>

    <?php if (WC()->cart->is_empty()) : ?>
      <div class="cart-empty">
        <p class="cart-empty__icon">🛒</p>
        <p class="cart-empty__text"><?php esc_html_e('Your cart is empty.', 'rillatype-v2'); ?></p>
        <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="btn btn--primary"><?php esc_html_e('Browse Fonts', 'rillatype-v2'); ?></a>
      </div>
    <?php else : ?>

      <form class="cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
        <div class="cart-form__layout">

          <div class="cart-form__items">
            <ul class="cart-items">
              <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) :
                $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                if (!$_product || !$_product->exists() || $cart_item['quantity'] < 1) continue;

                $product_name      = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
                $thumbnail         = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image('medium'), $cart_item, $cart_item_key);
                $product_price     = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                $product_subtotal  = apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key);
                $permalink         = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
              ?>
                <li class="cart-item" data-cart-key="<?php echo esc_attr($cart_item_key); ?>">
                  <div class="cart-item__img">
                    <?php if ($permalink) : ?><a href="<?php echo esc_url($permalink); ?>"><?php endif; ?>
                      <?php echo $thumbnail; ?>
                    <?php if ($permalink) : ?></a><?php endif; ?>
                  </div>
                  <div class="cart-item__body">
                    <div class="cart-item__info">
                      <h3 class="cart-item__name">
                        <?php if ($permalink) : ?><a href="<?php echo esc_url($permalink); ?>"><?php endif; ?>
                          <?php echo $product_name; ?>
                        <?php if ($permalink) : ?></a><?php endif; ?>
                      </h3>
                      <p class="cart-item__meta">
                        <?php echo wc_get_formatted_cart_item_data($cart_item); ?>
                      </p>
                    </div>
                    <div class="cart-item__actions">
                      <div class="cart-item__qty">
                        <?php
                        if ($_product->is_sold_individually()) {
                          echo '<span class="cart-item__qty-label">1</span>';
                        } else {
                          woocommerce_quantity_input(array(
                            'input_name'   => "cart[{$cart_item_key}][qty]",
                            'input_value'  => $cart_item['quantity'],
                            'max_value'    => $_product->get_max_purchase_quantity(),
                            'min_value'    => '0',
                            'product_name' => $_product->get_name(),
                          ));
                        }
                        ?>
                      </div>
                      <span class="cart-item__subtotal"><?php echo $product_subtotal; ?></span>
                      <a href="<?php echo esc_url(wc_get_cart_remove_url($cart_item_key)); ?>" class="cart-item__remove" aria-label="<?php esc_attr_e('Remove', 'rillatype-v2'); ?>">✕</a>
                    </div>
                  </div>
                </li>
              <?php endforeach; ?>
            </ul>

            <div class="cart-form__actions">
              <button type="submit" class="btn btn--outline" name="update_cart" value="<?php esc_attr_e('Update Cart', 'rillatype-v2'); ?>"><?php esc_html_e('Update Cart', 'rillatype-v2'); ?></button>
              <?php do_action('woocommerce_cart_actions'); ?>
              <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
            </div>
          </div>

          <div class="cart-form__totals">
            <div class="cart-totals-card">
              <h2 class="cart-totals-card__title"><?php esc_html_e('Order Summary', 'rillatype-v2'); ?></h2>
              <div class="cart-totals-card__rows">
                <div class="cart-totals-card__row">
                  <span><?php esc_html_e('Subtotal', 'rillatype-v2'); ?></span>
                  <span><?php wc_cart_totals_subtotal_html(); ?></span>
                </div>
                <?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>
                  <div class="cart-totals-card__row cart-totals-card__row--coupon">
                    <span><?php wc_cart_totals_coupon_label($coupon); ?></span>
                    <span><?php wc_cart_totals_coupon_html($coupon); ?></span>
                  </div>
                <?php endforeach; ?>
                <?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>
                  <div class="cart-totals-card__row">
                    <?php woocommerce_cart_totals_shipping_html(); ?>
                  </div>
                <?php endif; ?>
                <div class="cart-totals-card__row cart-totals-card__row--total">
                  <span><?php esc_html_e('Total', 'rillatype-v2'); ?></span>
                  <span><?php wc_cart_totals_order_total_html(); ?></span>
                </div>
              </div>
              <div class="cart-totals-card__cta">
                <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="btn btn--primary btn--block"><?php esc_html_e('Proceed to Checkout', 'rillatype-v2'); ?></a>
              </div>
              <?php if (wc_coupons_enabled()) : ?>
                <div class="cart-totals-card__coupon">
                  <p class="cart-totals-card__coupon-toggle" id="coupon-toggle"><?php esc_html_e('Have a coupon?', 'rillatype-v2'); ?></p>
                  <div class="cart-totals-card__coupon-form" id="coupon-form" style="display:none;">
                    <input type="text" name="coupon_code" placeholder="<?php esc_attr_e('Coupon code', 'rillatype-v2'); ?>" />
                    <button type="submit" class="btn btn--outline" name="apply_coupon" value="<?php esc_attr_e('Apply', 'rillatype-v2'); ?>"><?php esc_html_e('Apply', 'rillatype-v2'); ?></button>
                    <?php do_action('woocommerce_cart_coupon'); ?>
                  </div>
                </div>
              <?php endif; ?>
            </div>
          </div>

        </div>
      </form>

      <?php do_action('woocommerce_after_cart'); ?>

    <?php endif; ?>
  </div>
</div>

<script>
(function(){
  var toggle = document.getElementById('coupon-toggle');
  if (toggle) {
    toggle.addEventListener('click', function(){
      var form = document.getElementById('coupon-form');
      if (form) form.style.display = form.style.display === 'none' ? 'flex' : 'none';
    });
  }
})();
</script>
