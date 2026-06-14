<?php
defined('ABSPATH') || exit;

// Guard WC cart
if (!function_exists('WC') || !WC()->cart) {
  return;
}

do_action('woocommerce_before_checkout_form', $checkout);

if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
  echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'rillatype-v2')));
  return;
}
?>

<div class="checkout-page">
  <div class="container">
    <h1 class="checkout-page__title"><?php esc_html_e('Checkout', 'rillatype-v2'); ?></h1>

    <form name="checkout" method="post" class="checkout-form" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">
      <div class="checkout-form__layout">

        <div class="checkout-form__fields">

          <?php if ($checkout->get_checkout_fields()) : ?>
            <?php do_action('woocommerce_checkout_before_customer_details'); ?>

            <div class="checkout-section">
              <h2 class="checkout-section__title"><?php esc_html_e('Contact & Billing', 'rillatype-v2'); ?></h2>
              <?php do_action('woocommerce_checkout_billing'); ?>
            </div>

            <div class="checkout-section">
              <h2 class="checkout-section__title"><?php esc_html_e('Additional Information', 'rillatype-v2'); ?></h2>
              <?php do_action('woocommerce_checkout_shipping'); ?>
            </div>

            <?php do_action('woocommerce_checkout_after_customer_details'); ?>
          <?php endif; ?>

        </div>

        <div class="checkout-form__sidebar">

          <div class="checkout-sidebar-card">
            <h2 class="checkout-sidebar-card__title"><?php esc_html_e('Your Order', 'rillatype-v2'); ?></h2>

            <?php do_action('woocommerce_checkout_before_order_review_heading'); ?>
            <?php do_action('woocommerce_checkout_before_order_review'); ?>

            <div id="order_review" class="woocommerce-checkout-review-order">
              <table class="checkout-review-table">
                <thead>
                  <tr>
                    <th><?php esc_html_e('Product', 'rillatype-v2'); ?></th>
                    <th><?php esc_html_e('Subtotal', 'rillatype-v2'); ?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) :
                    $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                    if ($_product && $_product->exists() && $cart_item['quantity'] > 0) :
                      $product_name = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
                  ?>
                    <tr>
                      <td class="checkout-review-table__name"><?php echo $product_name; ?><strong class="checkout-review-table__qty"> × <?php echo esc_html($cart_item['quantity']); ?></strong></td>
                      <td class="checkout-review-table__total"><?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); ?></td>
                    </tr>
                  <?php endif; endforeach; ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th><?php esc_html_e('Subtotal', 'rillatype-v2'); ?></th>
                    <td><?php wc_cart_totals_subtotal_html(); ?></td>
                  </tr>
                  <tr class="checkout-review-table__order-total">
                    <th><?php esc_html_e('Total', 'rillatype-v2'); ?></th>
                    <td><?php wc_cart_totals_order_total_html(); ?></td>
                  </tr>
                </tfoot>
              </table>

              <?php woocommerce_checkout_payment(); ?>
            </div>

            <?php do_action('woocommerce_checkout_after_order_review'); ?>
          </div>

        </div>

      </div>
    </form>
  </div>
</div>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>
