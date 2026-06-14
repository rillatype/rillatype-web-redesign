<?php
defined('ABSPATH') || exit;

do_action('woocommerce_before_available_downloads');
?>

<div class="account-section">
  <h1 class="account-section__title"><?php esc_html_e('Downloads', 'rillatype-v2'); ?></h1>

  <?php if ($downloads) : ?>

    <div class="account-table-wrap">
      <table class="account-table">
        <thead>
          <tr>
            <th><?php esc_html_e('Font', 'rillatype-v2'); ?></th>
            <th><?php esc_html_e('Remaining', 'rillatype-v2'); ?></th>
            <th><?php esc_html_e('Expires', 'rillatype-v2'); ?></th>
            <th><?php esc_html_e('Download', 'rillatype-v2'); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($downloads as $download) : ?>
            <tr>
              <td data-label="<?php esc_attr_e('Font', 'rillatype-v2'); ?>">
                <?php echo esc_html($download['product_name']); ?>
              </td>
              <td data-label="<?php esc_attr_e('Remaining', 'rillatype-v2'); ?>">
                <?php echo is_numeric($download['downloads_remaining']) ? esc_html($download['downloads_remaining']) : esc_html__('∞', 'rillatype-v2'); ?>
              </td>
              <td data-label="<?php esc_attr_e('Expires', 'rillatype-v2'); ?>">
                <?php if (!empty($download['access_expires'])) : ?>
                  <?php echo date_i18n(get_option('date_format'), strtotime($download['access_expires'])); ?>
                <?php else : ?>
                  <?php esc_html_e('Never', 'rillatype-v2'); ?>
                <?php endif; ?>
              </td>
              <td data-label="<?php esc_attr_e('Download', 'rillatype-v2'); ?>">
                <a href="<?php echo esc_url($download['download_url']); ?>" class="btn btn--sm btn--primary"><?php esc_html_e('Download', 'rillatype-v2'); ?></a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

  <?php else : ?>
    <div class="account-empty">
      <p><?php esc_html_e('No downloads available yet.', 'rillatype-v2'); ?></p>
      <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="btn btn--primary"><?php esc_html_e('Browse Fonts', 'rillatype-v2'); ?></a>
    </div>
  <?php endif; ?>
</div>

<?php do_action('woocommerce_after_available_downloads'); ?>
