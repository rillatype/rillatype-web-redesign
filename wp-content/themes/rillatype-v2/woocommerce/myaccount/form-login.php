<?php
defined('ABSPATH') || exit;

do_action('woocommerce_before_customer_login_form');
?>

<div class="account-auth">
  <div class="container">
    <div class="account-auth__inner">

      <div class="account-auth__card">
        <h1 class="account-auth__title"><?php esc_html_e('Sign In', 'rillatype-v2'); ?></h1>

        <form class="account-auth__form" method="post">
          <?php do_action('woocommerce_login_form_start'); ?>

          <p class="form-field">
            <label for="username"><?php esc_html_e('Email', 'rillatype-v2'); ?></label>
            <input type="text" name="username" id="username" autocomplete="username" required />
          </p>
          <p class="form-field">
            <label for="password"><?php esc_html_e('Password', 'rillatype-v2'); ?></label>
            <input type="password" name="password" id="password" autocomplete="current-password" required />
          </p>

          <?php do_action('woocommerce_login_form'); ?>

          <p class="form-field form-field--action">
            <label class="form-checkbox">
              <input name="rememberme" type="checkbox" value="forever" />
              <span><?php esc_html_e('Remember me', 'rillatype-v2'); ?></span>
            </label>
          </p>

          <p class="form-field">
            <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
            <button type="submit" class="btn btn--primary btn--block" name="login" value="<?php esc_attr_e('Sign In', 'rillatype-v2'); ?>"><?php esc_html_e('Sign In', 'rillatype-v2'); ?></button>
          </p>

          <?php do_action('woocommerce_login_form_end'); ?>

          <p class="account-auth__link">
            <a href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php esc_html_e('Forgot your password?', 'rillatype-v2'); ?></a>
          </p>
        </form>
      </div>

      <div class="account-auth__divider">
        <span><?php esc_html_e('or', 'rillatype-v2'); ?></span>
      </div>

      <div class="account-auth__card">
        <h2 class="account-auth__title"><?php esc_html_e('Create Account', 'rillatype-v2'); ?></h2>

        <form class="account-auth__form" method="post">
          <?php do_action('woocommerce_register_form_start'); ?>

          <p class="form-field">
            <label for="reg_email"><?php esc_html_e('Email', 'rillatype-v2'); ?></label>
            <input type="email" name="email" id="reg_email" autocomplete="email" required />
          </p>
          <p class="form-field">
            <label for="reg_password"><?php esc_html_e('Password', 'rillatype-v2'); ?></label>
            <input type="password" name="password" id="reg_password" autocomplete="new-password" required />
          </p>

          <?php do_action('woocommerce_register_form'); ?>

          <p class="form-field">
            <?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
            <button type="submit" class="btn btn--primary btn--block" name="register" value="<?php esc_attr_e('Create Account', 'rillatype-v2'); ?>"><?php esc_html_e('Create Account', 'rillatype-v2'); ?></button>
          </p>

          <?php do_action('woocommerce_register_form_end'); ?>
        </form>
      </div>

    </div>
  </div>
</div>

<?php do_action('woocommerce_after_customer_login_form'); ?>
