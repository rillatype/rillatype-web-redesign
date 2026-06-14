<?php
defined('ABSPATH') || exit;
?>

<div class="account-section">
  <a href="<?php echo esc_url(wc_get_account_endpoint_url('orders')); ?>" class="account-back">← <?php esc_html_e('Back to Orders', 'rillatype-v2'); ?></a>

  <h1 class="account-section__title"><?php printf(esc_html__('Order #%s', 'rillatype-v2'), $order->get_order_number()); ?></h1>

  <div class="order-details">
    <div class="order-details__meta">
      <div class="order-details__meta-item">
        <span class="order-details__label"><?php esc_html_e('Date', 'rillatype-v2'); ?></span>
        <span><?php echo wc_format_datetime($order->get_date_created()); ?></span>
      </div>
      <div class="order-details__meta-item">
        <span class="order-details__label"><?php esc_html_e('Status', 'rillatype-v2'); ?></span>
        <span><?php echo wc_get_order_status_name($order->get_status()); ?></span>
      </div>
      <div class="order-details__meta-item">
        <span class="order-details__label"><?php esc_html_e('Total', 'rillatype-v2'); ?></span>
        <span><?php echo $order->get_formatted_order_total(); ?></span>
      </div>
      <?php if ($order->get_payment_method_title()) : ?>
        <div class="order-details__meta-item">
          <span class="order-details__label"><?php esc_html_e('Payment', 'rillatype-v2'); ?></span>
          <span><?php echo esc_html($order->get_payment_method_title()); ?></span>
        </div>
      <?php endif; ?>
    </div>

    <table class="account-table">
      <thead>
        <tr>
          <th><?php esc_html_e('Product', 'rillatype-v2'); ?></th>
          <th><?php esc_html_e('Total', 'rillatype-v2'); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($order->get_items() as $item_id => $item) :
          $product = $item->get_product();
        ?>
          <tr>
            <td data-label="<?php esc_attr_e('Product', 'rillatype-v2'); ?>">
              <?php echo esc_html($item->get_name()); ?>
              <strong class="order-details__qty">× <?php echo esc_html($item->get_quantity()); ?></strong>
            </td>
            <td data-label="<?php esc_attr_e('Total', 'rillatype-v2'); ?>"><?php echo $order->get_formatted_line_subtotal($item); ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <?php do_action('woocommerce_view_order', $order->get_id()); ?>
  </div>
</div>
