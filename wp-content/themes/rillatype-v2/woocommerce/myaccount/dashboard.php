<?php
defined('ABSPATH') || exit;
?>

<div class="account-dashboard">
  <p class="account-dashboard__greeting">
    <?php
    printf(
      esc_html__('Welcome back, %s.', 'rillatype-v2'),
      '<strong>' . esc_html($current_user->display_name) . '</strong>'
    );
    ?>
  </p>

  <p class="account-dashboard__intro">
    <?php esc_html_e('From your account dashboard you can view your recent orders, manage your shipping and billing addresses, and edit your password and account details.', 'rillatype-v2'); ?>
  </p>

  <div class="account-dashboard__grid">
    <a href="<?php echo esc_url(wc_get_account_endpoint_url('orders')); ?>" class="dashboard-card">
      <span class="dashboard-card__icon">📦</span>
      <span class="dashboard-card__label"><?php esc_html_e('Orders', 'rillatype-v2'); ?></span>
    </a>
    <a href="<?php echo esc_url(wc_get_account_endpoint_url('downloads')); ?>" class="dashboard-card">
      <span class="dashboard-card__icon">⬇</span>
      <span class="dashboard-card__label"><?php esc_html_e('Downloads', 'rillatype-v2'); ?></span>
    </a>
    <a href="<?php echo esc_url(wc_get_account_endpoint_url('edit-address')); ?>" class="dashboard-card">
      <span class="dashboard-card__icon">📍</span>
      <span class="dashboard-card__label"><?php esc_html_e('Addresses', 'rillatype-v2'); ?></span>
    </a>
    <a href="<?php echo esc_url(wc_get_account_endpoint_url('edit-account')); ?>" class="dashboard-card">
      <span class="dashboard-card__icon">👤</span>
      <span class="dashboard-card__label"><?php esc_html_e('Account Details', 'rillatype-v2'); ?></span>
    </a>
  </div>

  <?php do_action('woocommerce_account_dashboard'); ?>
</div>
