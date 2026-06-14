<?php
defined('ABSPATH') || exit;

$customer_id = get_current_user_id();
?>

<div class="account-section">
  <h1 class="account-section__title"><?php esc_html_e('Addresses', 'rillatype-v2'); ?></h1>

  <div class="address-grid">
    <div class="address-card">
      <h3 class="address-card__title"><?php esc_html_e('Billing Address', 'rillatype-v2'); ?></h3>
      <div class="address-card__content">
        <?php
        $address = WC()->countries->get_formatted_address(array(
          'first_name' => get_user_meta($customer_id, 'billing_first_name', true),
          'last_name'  => get_user_meta($customer_id, 'billing_last_name', true),
          'company'    => get_user_meta($customer_id, 'billing_company', true),
          'address_1'  => get_user_meta($customer_id, 'billing_address_1', true),
          'address_2'  => get_user_meta($customer_id, 'billing_address_2', true),
          'city'       => get_user_meta($customer_id, 'billing_city', true),
          'state'      => get_user_meta($customer_id, 'billing_state', true),
          'postcode'   => get_user_meta($customer_id, 'billing_postcode', true),
          'country'    => get_user_meta($customer_id, 'billing_country', true),
        ));
        if ($address) {
          echo wp_kses_post($address);
        } else {
          echo '<p class="address-card__empty">' . esc_html__('No billing address set.', 'rillatype-v2') . '</p>';
        }
        ?>
      </div>
      <a href="<?php echo esc_url(wc_get_account_endpoint_url('edit-address') . 'billing/'); ?>" class="btn btn--outline btn--sm"><?php esc_html_e('Edit', 'rillatype-v2'); ?></a>
    </div>

    <div class="address-card">
      <h3 class="address-card__title"><?php esc_html_e('Shipping Address', 'rillatype-v2'); ?></h3>
      <div class="address-card__content">
        <?php
        $address = WC()->countries->get_formatted_address(array(
          'first_name' => get_user_meta($customer_id, 'shipping_first_name', true),
          'last_name'  => get_user_meta($customer_id, 'shipping_last_name', true),
          'company'    => get_user_meta($customer_id, 'shipping_company', true),
          'address_1'  => get_user_meta($customer_id, 'shipping_address_1', true),
          'address_2'  => get_user_meta($customer_id, 'shipping_address_2', true),
          'city'       => get_user_meta($customer_id, 'shipping_city', true),
          'state'      => get_user_meta($customer_id, 'shipping_state', true),
          'postcode'   => get_user_meta($customer_id, 'shipping_postcode', true),
          'country'    => get_user_meta($customer_id, 'shipping_country', true),
        ));
        if ($address) {
          echo wp_kses_post($address);
        } else {
          echo '<p class="address-card__empty">' . esc_html__('No shipping address set.', 'rillatype-v2') . '</p>';
        }
        ?>
      </div>
      <a href="<?php echo esc_url(wc_get_account_endpoint_url('edit-address') . 'shipping/'); ?>" class="btn btn--outline btn--sm"><?php esc_html_e('Edit', 'rillatype-v2'); ?></a>
    </div>
  </div>
</div>
