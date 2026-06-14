<?php
/**
 * This template is used to display the profile editor with [edd_profile_editor]
 */
global $current_user;

if ( is_user_logged_in() ):
	$user_id      = get_current_user_id();
	$first_name   = get_user_meta( $user_id, 'first_name', true );
	$last_name    = get_user_meta( $user_id, 'last_name', true );
	$display_name = $current_user->display_name;
	$address      = edd_get_customer_address( $user_id );
	$states       = edd_get_shop_states( $address['country'] );
	$state 		  = $address['state'];

	if ( edd_is_cart_saved() ): ?>
		<?php $restore_url = add_query_arg( array( 'edd_action' => 'restore_cart', 'edd_cart_token' => edd_get_cart_token() ), edd_get_checkout_uri() ); ?>
		<div class="edd_success edd-alert edd-alert-success"><strong><?php _e( 'Saved cart','larisdigital-wp' ); ?>:</strong> <?php printf( __( 'You have a saved cart, <a href="%s">click here</a> to restore it.', 'larisdigital-wp' ), esc_url( $restore_url ) ); ?></div>
	<?php endif; ?>

	<?php if ( isset( $_GET['updated'] ) && $_GET['updated'] == true && ! edd_get_errors() ): ?>
		<div class="edd_success edd-alert edd-alert-success"><strong><?php _e( 'Success','larisdigital-wp' ); ?>:</strong> <?php _e( 'Your profile has been edited successfully.', 'larisdigital-wp' ); ?></div>
	<?php endif; ?>

	<?php edd_print_errors(); ?>

	<?php do_action( 'edd_profile_editor_before' ); ?>

	<form id="edd_profile_editor_form" class="edd_form" action="<?php echo edd_get_current_page_url(); ?>" method="post">

		<?php do_action( 'edd_profile_editor_fields_top' ); ?>

		<div id="edd_profile_personal_fieldset" class="mb-4">

			<h3 id="edd_profile_name_label"><?php _e( 'Change your Name', 'larisdigital-wp' ); ?></h3>

			<div class="form-row" id="edd_profile_first_name_wrap">
				<div class="form-group col-md-6">
					<label for="edd_first_name"><?php _e( 'First Name', 'larisdigital-wp' ); ?></label>
				</div>
				<div class="form-group col-md-6">
					<input name="edd_first_name" id="edd_first_name" class="form-control text edd-input" type="text" value="<?php echo esc_attr( $first_name ); ?>" />
				</div>
			</div>

			<div class="form-row" id="edd_profile_last_name_wrap">
				<div class="form-group col-md-6">
					<label for="edd_last_name"><?php _e( 'Last Name', 'larisdigital-wp' ); ?></label>
				</div>
				<div class="form-group col-md-6">
					<input name="edd_last_name" id="edd_last_name" class="form-control text edd-input" type="text" value="<?php echo esc_attr( $last_name ); ?>" />
				</div>
			</div>

			<div class="form-row" id="edd_profile_display_name_wrap">
				<div class="form-group col-md-6">
					<label for="edd_display_name"><?php _e( 'Display Name', 'larisdigital-wp' ); ?></label>
				</div>
				<div class="form-group col-md-6">
					<select name="edd_display_name" id="edd_display_name" class="form-control select edd-select">
						<?php if ( ! empty( $current_user->first_name ) ): ?>
						<option <?php selected( $display_name, $current_user->first_name ); ?> value="<?php echo esc_attr( $current_user->first_name ); ?>"><?php echo esc_html( $current_user->first_name ); ?></option>
						<?php endif; ?>
						<option <?php selected( $display_name, $current_user->user_nicename ); ?> value="<?php echo esc_attr( $current_user->user_nicename ); ?>"><?php echo esc_html( $current_user->user_nicename ); ?></option>
						<?php if ( ! empty( $current_user->last_name ) ): ?>
						<option <?php selected( $display_name, $current_user->last_name ); ?> value="<?php echo esc_attr( $current_user->last_name ); ?>"><?php echo esc_html( $current_user->last_name ); ?></option>
						<?php endif; ?>
						<?php if ( ! empty( $current_user->first_name ) && ! empty( $current_user->last_name ) ): ?>
						<option <?php selected( $display_name, $current_user->first_name . ' ' . $current_user->last_name ); ?> value="<?php echo esc_attr( $current_user->first_name . ' ' . $current_user->last_name ); ?>"><?php echo esc_html( $current_user->first_name . ' ' . $current_user->last_name ); ?></option>
						<option <?php selected( $display_name, $current_user->last_name . ' ' . $current_user->first_name ); ?> value="<?php echo esc_attr( $current_user->last_name . ' ' . $current_user->first_name ); ?>"><?php echo esc_html( $current_user->last_name . ' ' . $current_user->first_name ); ?></option>
						<?php endif; ?>
					</select>
					<?php do_action( 'edd_profile_editor_name' ); ?>
				</div>
			</div>

			<?php do_action( 'edd_profile_editor_after_name' ); ?>

			<div class="form-row" id="edd_profile_primary_email_wrap">
				<div class="form-group col-md-6">
					<label for="edd_email"><?php _e( 'Primary Email Address', 'larisdigital-wp' ); ?></label>
				</div>
				<div class="form-group col-md-6">
					<?php $customer = new EDD_Customer( $user_id, true ); ?>
					<?php if ( $customer->id > 0 ) : ?>

						<?php if ( 1 === count( $customer->emails ) ) : ?>
							<input name="edd_email" id="edd_email" class="form-control text edd-input required" type="email" value="<?php echo esc_attr( $customer->email ); ?>" />
						<?php else: ?>
							<?php
								$emails           = array();
								$customer->emails = array_reverse( $customer->emails, true );

								foreach ( $customer->emails as $email ) {
									$emails[ $email ] = $email;
								}

								$email_select_args = array(
									'options'          => $emails,
									'name'             => 'edd_email',
									'id'               => 'edd_email',
									'selected'         => $customer->email,
									'show_option_none' => false,
									'show_option_all'  => false,
								);

								echo EDD()->html->select( $email_select_args );
							?>
						<?php endif; ?>
					<?php else: ?>
						<input name="edd_email" id="edd_email" class="form-control text edd-input required" type="email" value="<?php echo esc_attr( $current_user->user_email ); ?>" />
					<?php endif; ?>

					<?php do_action( 'edd_profile_editor_email' ); ?>
				</div>
			</div>

			<?php if ( $customer->id > 0 && count( $customer->emails ) > 1 ) : ?>
				<div class="form-row" id="edd_profile_emails_wrap">
						<label for="edd_emails"><?php _e( 'Additional Email Addresses', 'larisdigital-wp' ); ?></label>
					</div>
					<div class="form-group col-md-6">
						<ul class="edd-profile-emails">
						<?php foreach ( $customer->emails as $email ) : ?>
							<?php if ( $email === $customer->email ) { continue; } ?>
							<li class="edd-profile-email">
								<?php echo esc_html( $email ); ?>
								<span class="actions">
									<?php
										$remove_url = wp_nonce_url(
											add_query_arg(
												array(
													'email'      => rawurlencode( $email ),
													'edd_action' => 'profile-remove-email',
													'redirect'   => esc_url( edd_get_current_page_url() ),
												)
											),
											'edd-remove-customer-email'
										);
									?>
									<a href="<?php echo esc_url( $remove_url ); ?>" class="delete"><?php _e( 'Remove', 'larisdigital-wp' ); ?></a>
								</span>
							</li>
						<?php endforeach; ?>
						</ul>
					</div>
				</div>
			<?php endif; ?>

			<?php do_action( 'edd_profile_editor_after_email' ); ?>

		</div>

		<?php do_action( 'edd_profile_editor_after_personal_fields' ); ?>

		<div id="edd_profile_address_fieldset" class="mb-4">

			<h3 id="edd_profile_billing_address_label"><?php _e( 'Change your Billing Address', 'larisdigital-wp' ); ?></h3>

			<div class="form-row" id="edd_profile_billing_address_line_1_wrap">
				<div class="form-group col-md-6">
					<label for="edd_address_line1"><?php _e( 'Line 1', 'larisdigital-wp' ); ?></label>
				</div>
				<div class="form-group col-md-6">
					<input name="edd_address_line1" id="edd_address_line1" class="form-control text edd-input" type="text" value="<?php echo esc_attr( $address['line1'] ); ?>" />
				</div>
			</div>

			<div class="form-row" id="edd_profile_billing_address_line_2_wrap">
				<div class="form-group col-md-6">
					<label for="edd_address_line2"><?php _e( 'Line 2', 'larisdigital-wp' ); ?></label>
				</div>
				<div class="form-group col-md-6">
					<input name="edd_address_line2" id="edd_address_line2" class="form-control text edd-input" type="text" value="<?php echo esc_attr( $address['line2'] ); ?>" />
				</div>
			</div>

			<div class="form-row" id="edd_profile_billing_address_city_wrap">
				<div class="form-group col-md-6">
					<label for="edd_address_city"><?php _e( 'City', 'larisdigital-wp' ); ?></label>
				</div>
				<div class="form-group col-md-6">
					<input name="edd_address_city" id="edd_address_city" class="form-control text edd-input" type="text" value="<?php echo esc_attr( $address['city'] ); ?>" />
				</div>
			</div>

			<div class="form-row" id="edd_profile_billing_address_postal_wrap">
				<div class="form-group col-md-6">
					<label for="edd_address_zip"><?php _e( 'Zip / Postal Code', 'larisdigital-wp' ); ?></label>
				</div>
				<div class="form-group col-md-6">
					<input name="edd_address_zip" id="edd_address_zip" class="form-control text edd-input" type="text" value="<?php echo esc_attr( $address['zip'] ); ?>" />
				</div>
			</div>

			<div class="form-row" id="edd_profile_billing_address_country_wrap">
				<div class="form-group col-md-6">
					<label for="edd_address_country"><?php _e( 'Country', 'larisdigital-wp' ); ?></label>
				</div>
				<div class="form-group col-md-6">
					<select name="edd_address_country" id="edd_address_country" class="form-control select edd-select" data-nonce="<?php echo wp_create_nonce( 'edd-country-field-nonce' ); ?>">
						<?php foreach( edd_get_country_list() as $key => $country ) : ?>
						<option value="<?php echo esc_attr( $key ); ?>"<?php selected( $address['country'], $key ); ?>><?php echo esc_html( $country ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>

			<div class="form-row" id="edd_profile_billing_address_state_wrap">
				<div class="form-group col-md-6">
					<label for="edd_address_state"><?php _e( 'State / Province', 'larisdigital-wp' ); ?></label>
				</div>
				<div class="form-group col-md-6">
					<?php if( ! empty( $states ) ) : ?>
						<select name="edd_address_state" id="edd_address_state" class="form-control select edd-select">
							<?php
								foreach( $states as $state_code => $state_name ) {
									echo '<option value="' . esc_attr( $state_code ) . '"' . selected( $state_code, $state, false ) . '>' . esc_html( $state_name ) . '</option>';
								}
							?>
						</select>
					<?php else : ?>
						<input name="edd_address_state" id="edd_address_state" class="text edd-input" type="text" value="<?php echo esc_attr( $state ); ?>" />
					<?php endif; ?>

					<?php do_action( 'edd_profile_editor_address' ); ?>
				</div>
			</div>

			<?php do_action( 'edd_profile_editor_after_address' ); ?>

		</div>

		<?php do_action( 'edd_profile_editor_after_address_fields' ); ?>

		<div id="edd_profile_password_fieldset" class="mb-4">

			<h3 id="edd_profile_password_label"><?php _e( 'Change your Password', 'larisdigital-wp' ); ?></h3>

			<div class="form-row" id="edd_profile_password_wrap">
				<div class="form-group col-md-6">
					<label for="edd_user_pass"><?php _e( 'New Password', 'larisdigital-wp' ); ?></label>
				</div>
				<div class="form-group col-md-6">
					<input name="edd_new_user_pass1" id="edd_new_user_pass1" class="form-control password edd-input" type="password"/>
				</div>
			</div>

			<div class="form-row" id="edd_profile_confirm_password_wrap">
				<div class="form-group col-md-6">
					<label for="edd_user_pass"><?php _e( 'Re-enter Password', 'larisdigital-wp' ); ?></label>
				</div>
				<div class="form-group col-md-6">
					<input name="edd_new_user_pass2" id="edd_new_user_pass2" class="form-control password edd-input" type="password"/>
					<?php do_action( 'edd_profile_editor_password' ); ?>
				</div>
			</div>

			<?php do_action( 'edd_profile_editor_after_password' ); ?>

		</div>

		<?php do_action( 'edd_profile_editor_after_password_fields' ); ?>

		<div id="edd_profile_submit_fieldset" class="mb-4">

			<p id="edd_profile_submit_wrap">
				<input type="hidden" name="edd_profile_editor_nonce" value="<?php echo esc_attr( wp_create_nonce( 'edd-profile-editor-nonce' ) ); ?>"/>
				<input type="hidden" name="edd_action" value="edit_user_profile" />
				<input type="hidden" name="edd_redirect" value="<?php echo esc_url( edd_get_current_page_url() ); ?>" />
				<input name="edd_profile_editor_submit" id="edd_profile_editor_submit" type="submit" class="btn btn-primary" value="<?php _e( 'Save Changes', 'larisdigital-wp' ); ?>"/>
			</p>

		</div>

		<?php do_action( 'edd_profile_editor_fields_bottom' ); ?>

	</form><!-- #edd_profile_editor_form -->

	<?php do_action( 'edd_profile_editor_after' ); ?>

	<?php
else:
	do_action( 'edd_profile_editor_logged_out' );
endif;
