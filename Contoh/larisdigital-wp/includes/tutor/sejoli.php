<?php 
/**
 * Shop Filters, frontend only
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( !defined( 'TUTOR_VERSION') ) {
	return;
}

if ( !defined( 'SEJOLISA_VERSION') ) {
	return;
}

add_filter( 'tutor_monetization_options', 'larisdigital_tutor_sejoli_monetization_options' );
function larisdigital_tutor_sejoli_monetization_options( $options ) {
	$options['sejoli'] = esc_html__('Sejoli (LarisDigital)', 'larisdigital-wp');
	return $options;
}

add_action( 'add_meta_boxes', 'larisdigital_tutor_sejoli_register_meta_box' );
function larisdigital_tutor_sejoli_register_meta_box() {
	if ( ! larisdigital_tutor_sejoli_is_monetized() ) {
		return;
	}
	add_meta_box( 'tutor-attach-product', esc_html__('LarisDigital - Sell Course With Sejoli', 'larisdigital-wp'), 'larisdigital_tutor_sejoli_add_product_metabox', 'courses', 'advanced', 'high' );
}

function larisdigital_tutor_sejoli_add_product_metabox() {
	if ( ! larisdigital_tutor_sejoli_is_monetized() ) {
		return;
	}
	if ( ! function_exists('tutor_utils')) {
		return;
	}
	$_tutor_course_price_type = tutor_utils()->price_type();
?>

<div class="tutor-row tutor-mt-16 tutor-mb-16">
	<div class="tutor-col-12 tutor-col-sm-5 tutor-col-lg-4">
		<label class="tutor-fs-6 tutor-fw-medium">
			<?php _e( 'Course Type', 'larisdigital-wp' ); ?> <br />
		</label>
	</div>
	<div class="tutor-col-12 tutor-col-sm-7 tutor-col-lg-8 tutor-d-flex">
		<div class="tutor-form-check tutor-mr-16">
			<input type="radio" id="tutor_coursePrice_paid" class="tutor-form-check-input" name="tutor_course_price_type" value="paid" <?php checked( $_tutor_course_price_type, 'paid' ); ?>/>
			<label for="tutor_coursePrice_paid"><?php _e( 'Paid (via Sejoli)', 'larisdigital-wp' ); ?></label>
		</div>
		<div class="tutor-form-check tutor-mr-16">
			<input type="radio" id="tutor_coursePrice_free" class="tutor-form-check-input" name="tutor_course_price_type" value="free" <?php $_tutor_course_price_type ? checked( $_tutor_course_price_type, 'free' ) : checked( 'true', 'true' ); ?>/>
			<label for="tutor_coursePrice_free"><?php _e( 'Free', 'larisdigital-wp' ); ?></label>
		</div>
	</div>
</div>

<div class="tutor-row tutor-mt-16 tutor-mb-16">
	<div class="tutor-col-12 tutor-col-md-5 tutor-col-lg-4">
		<label class="tutor-fs-6 tutor-fw-medium">
			<?php _e( 'Select product', 'larisdigital-wp' ); ?> <br />
			<p class="text-muted">(<?php _e( 'When selling the course', 'larisdigital-wp' ); ?>)</p>
		</label>
	</div>
	<div class="tutor-col-12 tutor-col-md-7 tutor-col-lg-8">
		<?php
		$products = larisdigital_tutor_sejoli_get_products_db();
		$product_id = tutor_utils()->get_course_product_id();
		?>

		<select name="_tutor_course_product_id" class="tutor-form-select tutor_select2 no-tutor-dropdown" required>
			<option value="-1"><?php _e( 'Select a Product', 'larisdigital-wp' ); ?></option>
			<?php
			foreach ($products as $product){
				if ($product->ID == $product_id){
					echo "<option value='{$product->ID}' ".selected($product->ID, $product_id)." >{$product->post_title}</option>";
				}
				$usedProduct = tutor_utils()->product_belongs_with_course($product->ID);
				if ( ! $usedProduct){
					echo "<option value='{$product->ID}' ".selected($product->ID, $product_id)." >{$product->post_title}</option>";
				}
			}
			?>
		</select>
		<?php if ( !empty( $product_id ) ) : ?>
			<!-- <a href="<?php echo esc_url( get_edit_post_link($product_id ) ); ?>" target="_blank"><?php _e('Edit Sejoli Product', 'larisdigital-wp'); ?></a> <br /> -->
		<?php else : ?>
			<a href="<?php echo esc_url( admin_url('post-new.php?post_type=sejoli-product') ); ?>" target="_blank"><?php _e('Create Sejoli Product', 'larisdigital-wp'); ?></a> <br />
		<?php endif; ?>
		<p class="tutor-input-feedback tutor-has-icon">
			<i class="tutor-icon-info-circle-outline-filled tutor-input-feedback-icon tutor-fs-5"></i>
			<?php _e("Select a Sejoli product if you want to sell your course. The sale will be handled by Sejoli.", 'larisdigital-wp'); ?>
		</p>
	</div>
</div>

<?php 
}

add_action( 'save_post_courses', 'larisdigital_tutor_sejoli_course_meta' );

function larisdigital_tutor_sejoli_course_meta($post_ID) {
	if ( ! larisdigital_tutor_sejoli_is_monetized() ) {
		return;
	}
	if ( ! function_exists('tutor_utils')) {
		return;
	}
	$product_id = tutor_utils()->avalue_dot('_tutor_course_product_id', $_POST);

	if ($product_id === '-1') {
		delete_post_meta($post_ID, '_tutor_course_product_id');
	} 
	else {
		$product_id = (int) $product_id;
		if ($product_id) {
			update_post_meta($post_ID, '_tutor_course_product_id', $product_id);
			update_post_meta($product_id, '_tutor_product', 'yes');
		}
	}
}

// add_action( 'save_post_sejoli-product', 'larisdigital_tutor_sejoli_product_meta' );
// function larisdigital_tutor_sejoli_product_meta($post_ID) {
// 	if ( ! larisdigital_tutor_sejoli_is_monetized() ) {
// 		return;
// 	}
// 	if ( ! function_exists('tutor_utils')) {
// 		return;
// 	}
// 	$is_tutor_product = tutor_utils()->avalue_dot('_tutor_product', $_POST);
// 	if ($is_tutor_product === 'on') {
// 		update_post_meta($post_ID, '_tutor_product', 'yes');
// 	} 
// 	else {
// 		delete_post_meta($post_ID, '_tutor_product');
// 	}
// }

add_filter('is_course_purchasable', 'larisdigital_tutor_sejoli_is_course_purchasable', 10, 2);
function larisdigital_tutor_sejoli_is_course_purchasable($bool, $course_id) {
	if ( ! larisdigital_tutor_sejoli_is_monetized() ) {
		return $bool;
	}

	$course_id = tutor_utils()->get_post_id($course_id);
	$has_product_id = get_post_meta($course_id, '_tutor_course_product_id', true);
	if ($has_product_id) {
		return true;
	}
	return false;
}

add_filter( 'get_tutor_course_price', 'larisdigital_tutor_sejoli_get_course_price', 10, 2);
function larisdigital_tutor_sejoli_get_course_price($price, $course_id) {
	if ( ! larisdigital_tutor_sejoli_is_monetized() ) {
		return $price;
	}

	$price = null;

	if (tutor_utils()->is_course_purchasable($course_id)) {
		$product_id = tutor_utils()->get_course_product_id($course_id);
		$price = get_post_meta( $product_id, '_price', true );
		if ($price) {
			return 'Rp '.number_format( $price, 0, ',', '.' );
		}
	}

	return $price;
}

add_filter( 'tutor_course_sell_by', 'larisdigital_tutor_sejoli_course_sell_by' );
function larisdigital_tutor_sejoli_course_sell_by() {
	return 'sejoli';
}

add_filter( 'tutor_enroll_required_login_class', 'larisdigital_tutor_sejoli_enroll_required_login' );
function larisdigital_tutor_sejoli_enroll_required_login( $class ) {
	if ( larisdigital_tutor_sejoli_is_monetized() ) {
		return '';
	}
	return $class;
}

function larisdigital_tutor_sejoli_do_enroll( $course_id, $user_id ) {
	if (empty($course_id)) {
		return;
	}
	if (empty($user_id)) {
		return;
	}

	$if_has_enrolled = tutor_utils()->is_enrolled($course_id, $user_id);
	if ($if_has_enrolled) {
		return;
	}

	do_action('tutor_before_enroll', $course_id);

	$title = __('Course Enrolled', 'larisdigital-wp')." &ndash; ".date_i18n(get_option('date_format')) .' @ '.date_i18n(get_option('time_format') ) ;
	$enroll_data = apply_filters('tutor_enroll_data',
		array(
			'post_type'     => 'tutor_enrolled',
			'post_title'    => $title,
			'post_status'   => 'completed',
			'post_author'   => $user_id,
			'post_parent'   => $course_id,
		)
	);

	$is_enrolled = wp_insert_post( $enroll_data );
	if ($is_enrolled) {
		do_action('tutor_after_enroll', $course_id, $is_enrolled);

		if($enroll_data['post_status'] == 'completed'){
			do_action('tutor_after_enrolled', $course_id, $user_id, $is_enrolled);
		}

		tutor_utils()->course_enrol_status_change($is_enrolled, 'completed');
		update_user_meta( $user_id, '_is_tutor_student', tutor_time() );

		do_action('tutor_enrollment/after/complete', $is_enrolled);
	}
}

add_action( 'sejoli/order/set-status/completed', 'larisdigital_tutor_sejoli_order_complete', 4 );
function larisdigital_tutor_sejoli_order_complete(array $order_data) {
	if ( ! larisdigital_tutor_sejoli_is_monetized() ) {
		return;
	}
	$order_id = $order_data['ID'];
	$product_id = $order_data['product_id'];
	$user_id = $order_data['user_id'];
	$if_has_course = tutor_utils()->product_belongs_with_course($product_id);
	if (!empty($if_has_course->post_id)) {
		$course_id = $if_has_course->post_id;
		larisdigital_tutor_sejoli_do_enroll( $course_id, $user_id );
	}
}

add_action( 'sejoli/order/set-status/cancelled', 'larisdigital_tutor_sejoli_cancel_enroll', 4 );
add_action( 'sejoli/order/set-status/refunded', 'larisdigital_tutor_sejoli_cancel_enroll', 4 );
function larisdigital_tutor_sejoli_cancel_enroll(array $order_data) {
	if ( ! larisdigital_tutor_sejoli_is_monetized() ) {
		return;
	}
	$order_id = $order_data['ID'];
	$product_id = $order_data['product_id'];
	$user_id = $order_data['user_id'];
	$if_has_course = tutor_utils()->product_belongs_with_course($product_id);
	if ($if_has_course) {
		$course_id = $if_has_course->post_id;
		$has_any_enrolled = tutor_utils()->has_any_enrolled($course_id, $user_id);
		if ($has_any_enrolled) {
			tutor_utils()->cancel_course_enrol($course_id, $user_id);
		}
	}
}

add_action( 'wp', 'larisdigital_tutor_sejoli_check_enroll', 1 );
function larisdigital_tutor_sejoli_check_enroll() {
	if ( ! larisdigital_tutor_sejoli_is_monetized() ) {
		return;
	}
	if ( ! is_user_logged_in()) {
		return;
	}
	if ( ! is_singular('courses')) {
		return;
	}

	$has_content_access = tutor_utils()->has_enrolled_content_access('courses');
	if ($has_content_access) {
		return;
	}

	$course_id = get_the_ID();
	$product_id = tutor_utils()->get_course_product_id();
	if (empty($product_id)) {
		return;
	}

	$user_id = get_current_user_id();
	$user_access = sejolisa_get_user_access_products($user_id);

	$need_access = false;
	if ( isset( $user_access[$product_id] ) ) {
		$need_access = true;
	}

	if ( $need_access ) {
		larisdigital_tutor_sejoli_do_enroll( $course_id, $user_id );
	}
}

add_filter('tutor_dashboard/nav_ui_items', 'larisdigital_tutor_sejoli_dashboard_nav');
function larisdigital_tutor_sejoli_dashboard_nav( $nav_items ) {
	if ( ! larisdigital_tutor_sejoli_is_monetized() ) {
		return $nav_items;
	}
	if ( isset($nav_items['earning']) ) {
		unset($nav_items['earning']);
	}
	if ( isset($nav_items['withdraw']) ) {
		unset($nav_items['withdraw']);
	}
	return $nav_items;
} 

function larisdigital_tutor_sejoli_is_monetized() {
	if ( !defined( 'SEJOLISA_VERSION') ) {
		return false;
	}
	if ( ! function_exists('tutor_utils')) {
		return false;
	}
	$monetize_by = tutor_utils()->get_option('monetize_by');
	return ( $monetize_by == 'sejoli' ? true : false );
}

function larisdigital_tutor_sejoli_is_product( $product_id ) {
	if ( !defined( 'SEJOLISA_VERSION') ) {
		return false;
	}

	$post_type = get_post_type( $product_id );

	return ( $post_type == 'sejoli-product' ? true : false );
}

function larisdigital_tutor_sejoli_get_products_db() {
	global $wpdb;
	$query = $wpdb->get_results("SELECT ID, post_title from {$wpdb->posts} WHERE post_status = 'publish' AND post_type = 'sejoli-product' ");

	return $query;
}

function larisdigital_tutor_sejoli_status_label( $status ) {
	$status_label = [
		'on-hold'     		=> __('Menunggu pembayaran', 'larisdigital-wp'),
		'payment-confirm' 	=> __('Pembayaran dikonfirmasi', 'larisdigital-wp'),
		'in-progress' 		=> __('Pesanan diproses', 'larisdigital-wp'),
		'shipping'    		=> __('Proses pengiriman', 'larisdigital-wp'),
		'completed'   		=> __('Selesai', 'larisdigital-wp'),
		'refunded'    		=> __('Refund', 'larisdigital-wp'),
		'cancelled'   		=> __('Batal', 'larisdigital-wp')
	];
	if (isset($status_label[$status])) {
		return $status_label[$status];
	}
	else {
		return __('Unknown', 'larisdigital-wp');
	}
}

function larisdigital_tutor_sejoli_fullcheck_enroll() {
	if ( ! larisdigital_tutor_sejoli_is_monetized() ) {
		return;
	}
	if ( ! is_user_logged_in()) {
		return;
	}

	$user_id = get_current_user_id();
	$user_access = sejolisa_get_user_access_products($user_id);

	if (!empty($user_access)) {
		foreach ($user_access as $product_id => $access) {
			$if_has_course = tutor_utils()->product_belongs_with_course($product_id);
			if (!empty($if_has_course->post_id)) {
				$course_id = $if_has_course->post_id;
				larisdigital_tutor_sejoli_do_enroll( $course_id, $user_id );
			}
		}
	}
}

add_filter('tutor_get_template_path', 'larisdigital_tutor_sejoli_purchase_history', 10, 2 );
function larisdigital_tutor_sejoli_purchase_history( $template_location, $template ) {
	$template_allowed = [
		'dashboard/purchase_history',
		'dashboard.purchase_history',
	];

	if (!in_array($template, $template_allowed)) {
		return $template_location;
	}

	$monetize_by = tutor_utils()->get_option( 'monetize_by' );
	if ($monetize_by !== 'sejoli') {
		return $template_location;
	}

	$template_location_in_theme = trailingslashit( get_stylesheet_directory() ) . "tutor/{$template}-sejoli.php";
	if ( ! file_exists( $template_location_in_theme ) ) {
		$template_location_in_theme = trailingslashit( get_template_directory() ) . "tutor/{$template}-sejoli.php";
	}

	if ( file_exists( $template_location_in_theme ) ) {
		$template_location = $template_location_in_theme;
	}

	return $template_location;
}

add_action( 'tutor_load_template_before', 'larisdigital_tutor_sejoli_run_fullcheck_enroll', 10, 2 );
function larisdigital_tutor_sejoli_run_fullcheck_enroll( $template, $variables ) {
	$template_allowed = [
		'dashboard/purchase_history',
		'dashboard.purchase_history',
		'dashboard/enrolled-courses',
		'dashboard.enrolled-courses',
	];

	if (!in_array($template, $template_allowed)) {
		return $template;
	}

	if ( function_exists('larisdigital_tutor_sejoli_fullcheck_enroll')) {
		larisdigital_tutor_sejoli_fullcheck_enroll();
	}
}
