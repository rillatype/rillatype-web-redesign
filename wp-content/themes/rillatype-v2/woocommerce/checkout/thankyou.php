<?php
defined('ABSPATH') || exit;
?>

<div class="thankyou-page">
  <div class="container">

    <?php if ($order) : ?>

      <?php if ($order->has_status('failed')) : ?>

        <div class="thankyou-status thankyou-status--failed">
          <span class="thankyou-status__icon">✕</span>
          <h1><?php esc_html_e('Payment Failed', 'rillatype-v2'); ?></h1>
          <p><?php esc_html_e('Something went wrong. You can try again or contact support.', 'rillatype-v2'); ?></p>
          <a href="<?php echo esc_url($order->get_checkout_payment_url()); ?>" class="btn btn--primary"><?php esc_html_e('Try Again', 'rillatype-v2'); ?></a>
        </div>

      <?php else : ?>

        <div class="thankyou-status thankyou-status--success">
          <span class="thankyou-status__icon">✓</span>
          <h1><?php esc_html_e('Thank You!', 'rillatype-v2'); ?></h1>
          <p><?php esc_html_e('Your order has been received.', 'rillatype-v2'); ?></p>
        </div>

        <ul class="thankyou-details">
          <li>
            <span class="thankyou-details__label"><?php esc_html_e('Order', 'rillatype-v2'); ?></span>
            <span class="thankyou-details__value">#<?php echo $order->get_order_number(); ?></span>
          </li>
          <li>
            <span class="thankyou-details__label"><?php esc_html_e('Date', 'rillatype-v2'); ?></span>
            <span class="thankyou-details__value"><?php echo wc_format_datetime($order->get_date_created()); ?></span>
          </li>
          <li>
            <span class="thankyou-details__label"><?php esc_html_e('Total', 'rillatype-v2'); ?></span>
            <span class="thankyou-details__value"><?php echo $order->get_formatted_order_total(); ?></span>
          </li>
          <li>
            <span class="thankyou-details__label"><?php esc_html_e('Email', 'rillatype-v2'); ?></span>
            <span class="thankyou-details__value"><?php echo $order->get_billing_email(); ?></span>
          </li>
        </ul>

        <div class="thankyou-actions">
          <a href="<?php echo esc_url($order->get_view_order_url()); ?>" class="btn btn--outline"><?php esc_html_e('View Order', 'rillatype-v2'); ?></a>
          <a href="<?php echo esc_url(get_permalink(wc_get_page_id('myaccount'))); ?>" class="btn btn--outline"><?php esc_html_e('My Account', 'rillatype-v2'); ?></a>
        </div>

        <?php do_action('woocommerce_thankyou', $order->get_id()); ?>

      <?php endif; ?>

    <?php else : ?>

      <div class="thankyou-status">
        <h1><?php esc_html_e('Order Received', 'rillatype-v2'); ?></h1>
        <p><?php esc_html_e('Thank you. Your order has been received.', 'rillatype-v2'); ?></p>
      </div>

    <?php endif; ?>

  </div>
</div>
