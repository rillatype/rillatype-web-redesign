<?php
/**
 * This template is used to display the login form with [edd_login]
 */
global $edd_login_redirect;
if ( ! is_user_logged_in() ) :

	// Show any error messages after form submission
	edd_print_errors(); ?>
	<form id="edd_login_form" class="edd_form" action="" method="post">
		<h3><?php _e( 'Log into Your Account', 'easy-digital-downloads' ); ?></h3>
		<?php do_action( 'edd_login_fields_before' ); ?>
		<div class="form-row edd-login-username">
			<div class="form-group col-md-6">
				<label for="edd_user_login"><?php _e( 'Username or Email', 'easy-digital-downloads' ); ?></label>
			</div>
			<div class="form-group col-md-6">
				<input name="edd_user_login" id="edd_user_login" class="form-control edd-required edd-input" type="text"/>
			</div>
		</div>
		<div class="form-row edd-login-password">
			<div class="form-group col-md-6">
				<label for="edd_user_pass"><?php _e( 'Password', 'easy-digital-downloads' ); ?></label>
			</div>
			<div class="form-group col-md-6">
				<input name="edd_user_pass" id="edd_user_pass" class="form-control edd-password edd-required edd-input" type="password"/>
			</div>
		</div>
		<p class="edd-login-remember">
			<label><input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php _e( 'Remember Me', 'easy-digital-downloads' ); ?></label>
		</p>
		<p class="edd-login-submit">
			<input type="hidden" name="edd_redirect" value="<?php echo esc_url( $edd_login_redirect ); ?>"/>
			<input type="hidden" name="edd_login_nonce" value="<?php echo esc_attr( wp_create_nonce( 'edd-login-nonce' ) ); ?>"/>
			<input type="hidden" name="edd_action" value="user_login"/>
			<input id="edd_login_submit" type="submit" class="btn btn-primary" value="<?php _e( 'Log In', 'easy-digital-downloads' ); ?>"/>
		</p>
		<p class="edd-lost-password">
			<a href="<?php echo wp_lostpassword_url(); ?>">
				<?php _e( 'Lost Password?', 'easy-digital-downloads' ); ?>
			</a>
		</p>
		<?php do_action( 'edd_login_fields_after' ); ?>
	</form>
<?php else : ?>

	<?php do_action( 'edd_login_form_logged_in' ); ?>

<?php endif; ?>
