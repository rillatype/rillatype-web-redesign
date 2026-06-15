<?php
defined('ABSPATH') || exit;

$checkout = WC()->checkout();

do_action('woocommerce_before_checkout_form', $checkout);

if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
  echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
  return;
}
?>

<style>
/* debug */
.woocommerce-checkout .shop_table.woocommerce-checkout-review-order-table tfoot th,
.woocommerce-checkout .shop_table.woocommerce-checkout-review-order-table tfoot td {
  padding: 24px 16px !important;
}
.woocommerce-checkout .shop_table.woocommerce-checkout-review-order-table tfoot .order-total th,
.woocommerce-checkout .shop_table.woocommerce-checkout-review-order-table tfoot .order-total td {
  padding: 32px 16px 16px !important;
  border-top: 2px solid #e0553d !important;
  color: #1a1a1a !important;
  font-size: 18px !important;
}
#order_review {
  padding: 40px !important;
}
</style>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

  <div class="checkout-fields">
    <?php if ($checkout->get_checkout_fields()) : ?>
      <?php do_action('woocommerce_checkout_before_customer_details'); ?>
      <div class="col2-set" id="customer_details">
        <div class="col-1">
          <?php do_action('woocommerce_checkout_billing'); ?>
        </div>
        <div class="col-2">
          <?php do_action('woocommerce_checkout_shipping'); ?>
        </div>
      </div>
      <?php do_action('woocommerce_checkout_after_customer_details'); ?>
    <?php endif; ?>
  </div>

  <div class="checkout-summary">
    <?php do_action('woocommerce_checkout_before_order_review_heading'); ?>
    <h3 id="order_review_heading"><?php esc_html_e('Your order', 'woocommerce'); ?></h3>
    <?php do_action('woocommerce_checkout_before_order_review'); ?>
    <div id="order_review" class="woocommerce-checkout-review-order">
      <?php do_action('woocommerce_checkout_order_review'); ?>
    </div>
    <?php do_action('woocommerce_checkout_after_order_review'); ?>
  </div>

</form>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>
