<?php
defined('ABSPATH') || exit;
?>
<div class="woocommerce-order">
  <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo esc_html__('Thank you. Your order has been received.', 'woocommerce'); ?></p>
  <ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">
    <li class="woocommerce-order-overview__order order">
      <?php esc_html_e('Order number:', 'woocommerce'); ?>
      <strong><?php echo $order ? esc_html($order->get_order_number()) : ''; ?></strong>
    </li>
    <li class="woocommerce-order-overview__date date">
      <?php esc_html_e('Date:', 'woocommerce'); ?>
      <strong><?php echo $order ? esc_html(wc_format_datetime($order->get_date_created())) : ''; ?></strong>
    </li>
    <li class="woocommerce-order-overview__total total">
      <?php esc_html_e('Total:', 'woocommerce'); ?>
      <strong><?php echo $order ? $order->get_formatted_order_total() : ''; ?></strong>
    </li>
    <?php if ($order && $order->get_payment_method_title()) : ?>
    <li class="woocommerce-order-overview__payment method">
      <?php esc_html_e('Payment method:', 'woocommerce'); ?>
      <strong><?php echo wp_kses_post($order->get_payment_method_title()); ?></strong>
    </li>
    <?php endif; ?>
  </ul>
  <?php do_action('woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id()); ?>
  <?php do_action('woocommerce_thankyou', $order->get_id()); ?>
</div>
