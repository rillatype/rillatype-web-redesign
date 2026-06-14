<?php
/**
 * This template is used to display the registration form with [edd_register]
 */
global $edd_register_redirect;

do_action( 'edd_print_errors' ); ?>

<?php if ( ! is_user_logged_in() ) : ?>

<form id="edd_register_form" class="edd_form" action="" method="post">
	<?php do_action( 'edd_register_form_fields_top' ); ?>

		<h3><?php _e( 'Register New Account', 'easy-digital-downloads' ); ?></h3>

		<?php do_action( 'edd_register_form_fields_before' ); ?>

		<div class="form-row">
			<div class="form-group col-md-6">
				<label for="edd-user-login"><?php _e( 'Username', 'easy-digital-downloads' ); ?></label>
			</div>
			<div class="form-group col-md-6">
				<input id="edd-user-login" class="form-control required edd-input" type="text" name="edd_user_login" />
			</div>
		</div>

		<div class="form-row">
			<div class="form-group col-md-6">
				<label for="edd-user-email"><?php _e( 'Email', 'easy-digital-downloads' ); ?></label>
				<label for="edd_user_login"><?php _e( 'Username or Email', 'larisdigital-wp' ); ?></label>
			</div>
			<div class="form-group col-md-6">
				<input id="edd-user-email" class="form-control required edd-input" type="email" name="edd_user_email" />
			</div>
		</div>

		<div class="form-row">
			<div class="form-group col-md-6">
				<label for="edd-user-pass"><?php _e( 'Password', 'easy-digital-downloads' ); ?></label>
			</div>
			<div class="form-group col-md-6">
				<input id="edd-user-pass" class="form-control password required edd-input" type="password" name="edd_user_pass" />
			</div>
		</div>

		<div class="form-row">
			<div class="form-group col-md-6">
				<label for="edd-user-pass2"><?php _e( 'Confirm Password', 'easy-digital-downloads' ); ?></label>
			</div>
			<div class="form-group col-md-6">
				<input id="edd-user-pass2" class="form-control password required edd-input" type="password" name="edd_user_pass2" />
			</div>
		</div>

		<?php do_action( 'edd_register_form_fields_before_submit' ); ?>

		<p>
			<input type="hidden" name="edd_honeypot" value="" />
			<input type="hidden" name="edd_action" value="user_register" />
			<input type="hidden" name="edd_redirect" value="<?php echo esc_url( $edd_register_redirect ); ?>"/>
			<input class="btn btn-primary" name="edd_register_submit" type="submit" value="<?php esc_attr_e( 'Register', 'easy-digital-downloads' ); ?>" />
		</p>

	<?php do_action( 'edd_register_form_fields_after' ); ?>

	<?php do_action( 'edd_register_form_fields_bottom' ); ?>
</form>

<?php else : ?>

	<?php do_action( 'edd_register_form_logged_in' ); ?>

<?php endif; ?>
