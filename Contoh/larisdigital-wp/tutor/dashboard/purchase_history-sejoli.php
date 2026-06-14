<?php
/**
 * Purchase history
 *
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

defined( 'ABSPATH' ) || exit;

if (!function_exists('sejolisa_get_orders')) {
	return;
}

$user_id = get_current_user_id();
$sejoli_orders = sejolisa_get_orders(array('user_id' => $user_id));
$orders = $sejoli_orders['orders'];
?>

<div class="tutor-purchase-history"> 
	<?php if ( tutor_utils()->count( $orders ) ) : ?>
		<div class="tutor-fs-5 tutor-fw-medium tutor-color-black tutor-mb-24"><?php esc_html_e( 'Order History', 'larisdigital-wp' ); ?></div>
		<div class="tutor-table-responsive">
			<table class="tutor-table">
				<thead>
					<th width="10%">
						<?php esc_html_e( 'Order ID', 'larisdigital-wp' ); ?>
					</th>
					<th width="40%">
						<?php esc_html_e( 'Course Name', 'larisdigital-wp' ); ?>
					</th>
					<th>
						<?php esc_html_e( 'Date', 'larisdigital-wp' ); ?>
					</th>
					<th>
						<?php esc_html_e( 'Price', 'larisdigital-wp' ); ?>
					</th>
					<th>
						<?php esc_html_e( 'Status', 'larisdigital-wp' ); ?>
					</th>
				</thead>

				<tbody>
					<?php foreach ( $orders as $order ) : ?>
						<?php
                        $price             = $order->grand_total;
                        $order_status_text = larisdigital_tutor_sejoli_status_label($order->status);
						$status            = $order->status;
						$badge_class       = 'primary';

						switch ( $status ) {
							case 'completed' === $status:
								$badge_class = 'success';
								break;
							case 'refunded' === $status:
								$badge_class = 'danger';
								break;
							case 'cancelled' === $status:
								$badge_class = 'danger';
								break;
						}
						?>
						<tr>
							<td>
								#INV<?php echo esc_html( $order->ID ); ?>
							</td>

							<td>
								<?php echo '<p>'.esc_html($order->product_name).'</p>'; ?>
							</td>

							<td>
								<?php echo date_i18n( get_option( 'date_format' ), strtotime( $order->created_at ) ); ?>
							</td>

							<td>
								<?php echo sejolisa_price_format( $price ); ?>
							</td>

							<td>
								<span class="tutor-badge-label label-<?php echo esc_attr( $badge_class ); ?> tutor-m-4 text-center"><?php echo esc_html( $order_status_text ); ?></span>
							</td>
							
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>

	<?php else : ?>
		<?php tutor_utils()->tutor_empty_state( tutor_utils()->not_found_text() ); ?>
	<?php endif; ?>
</div>
