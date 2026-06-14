<?php
defined('ABSPATH') || exit;

do_action('woocommerce_before_account_orders', $has_orders);
?>

<div class="account-section">
  <h1 class="account-section__title"><?php esc_html_e('Orders', 'rillatype-v2'); ?></h1>

  <?php if ($has_orders) : ?>

    <div class="account-table-wrap">
      <table class="account-table">
        <thead>
          <tr>
            <th><?php esc_html_e('Order', 'rillatype-v2'); ?></th>
            <th><?php esc_html_e('Date', 'rillatype-v2'); ?></th>
            <th><?php esc_html_e('Status', 'rillatype-v2'); ?></th>
            <th><?php esc_html_e('Total', 'rillatype-v2'); ?></th>
            <th><?php esc_html_e('Actions', 'rillatype-v2'); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($customer_orders->orders as $customer_order) :
            $order      = wc_get_order($customer_order);
            $item_count = $order->get_item_count();
          ?>
            <tr>
              <td data-label="<?php esc_attr_e('Order', 'rillatype-v2'); ?>">
                <a href="<?php echo esc_url($order->get_view_order_url()); ?>">#<?php echo $order->get_order_number(); ?></a>
              </td>
              <td data-label="<?php esc_attr_e('Date', 'rillatype-v2'); ?>"><?php echo wc_format_datetime($order->get_date_created()); ?></td>
              <td data-label="<?php esc_attr_e('Status', 'rillatype-v2'); ?>"><?php echo wc_get_order_status_name($order->get_status()); ?></td>
              <td data-label="<?php esc_attr_e('Total', 'rillatype-v2'); ?>"><?php echo $order->get_formatted_order_total(); ?> for <?php echo esc_html($item_count); ?> item<?php echo $item_count !== 1 ? 's' : ''; ?></td>
              <td data-label="<?php esc_attr_e('Actions', 'rillatype-v2'); ?>">
                <a href="<?php echo esc_url($order->get_view_order_url()); ?>" class="btn btn--sm btn--outline"><?php esc_html_e('View', 'rillatype-v2'); ?></a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <?php do_action('woocommerce_before_account_orders_pagination'); ?>

    <?php if (1 < $customer_orders->max_num_pages) : ?>
      <nav class="account-pagination">
        <?php if ($current_page > 1) : ?>
          <a class="btn btn--outline" href="<?php echo esc_url(wc_get_account_endpoint_url('orders') . 'page/' . ($current_page - 1) . '/'); ?>">← <?php esc_html_e('Previous', 'rillatype-v2'); ?></a>
        <?php endif; ?>
        <?php if ($current_page < $customer_orders->max_num_pages) : ?>
          <a class="btn btn--outline" href="<?php echo esc_url(wc_get_account_endpoint_url('orders') . 'page/' . ($current_page + 1) . '/'); ?>"><?php esc_html_e('Next', 'rillatype-v2'); ?> →</a>
        <?php endif; ?>
      </nav>
    <?php endif; ?>

  <?php else : ?>
    <div class="account-empty">
      <p><?php esc_html_e('No orders yet.', 'rillatype-v2'); ?></p>
      <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="btn btn--primary"><?php esc_html_e('Browse Fonts', 'rillatype-v2'); ?></a>
    </div>
  <?php endif; ?>
</div>

<?php do_action('woocommerce_after_account_orders', $has_orders); ?>
