<?php
/**
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

?>

<h2><?php _e('Purchase History', 'larisdigital-wp'); ?></h2>

<?php
$orders = tutils()->get_orders_by_user_id();
$monetize_by = tutils()->get_option('monetize_by');
if ($monetize_by === 'sejoli') {
    $user_id = get_current_user_id();
    $sejoli_orders = sejolisa_get_orders(array('user_id' => $user_id));
    $orders = $sejoli_orders['orders'];
}

if (tutils()->count($orders)){
	?>
    <div class="responsive-table-wrap">
        <table class="tutor-table table">
            <tr>
                <th><?php _e('ID', 'larisdigital-wp'); ?></th>
                <th><?php _e('Products', 'larisdigital-wp'); ?></th>
                <th><?php _e('Amount', 'larisdigital-wp'); ?></th>
                <th><?php _e('Status', 'larisdigital-wp'); ?></th>
                <th><?php _e('Date', 'larisdigital-wp'); ?></th>
            </tr>
            <?php
            foreach ($orders as $order) {
                if ($monetize_by === 'wc') {
                    $id = '#'.$order->ID;
                    $wc_order = wc_get_order($order->ID);
                    $price = tutils()->tutor_price($wc_order->get_total());
                    $status = tutils()->order_status_context($order->post_status);
                    $date = $order->post_date;
                } 
                else if ($monetize_by === 'edd') {
                    $id = '#'.$order->ID;
                    $edd_order = edd_get_payment($order->ID);
                    $price = edd_currency_filter( edd_format_amount( $edd_order->total ), edd_get_payment_currency_code( $order->ID ) );
                    $status = $edd_order->status_nicename;
                    $date = $order->post_date;
                } 
                else if ($monetize_by === 'sejoli') {
                    $id = 'INV'.$order->ID;
                    $price = 'Rp'.tutils()->tutor_price($order->grand_total);
                    $status = larisdigital_tutor_sejoli_status_label($order->status);
                    $date = $order->created_at;
                }
                ?>
                <tr>
                    <td><?php echo esc_html($id); ?></td>
                    <td>
                        <?php
                        if ($monetize_by === 'sejoli') {
                            echo '<p>'.esc_html($order->product_name).'</p>';
                        }
                        else {
                            $courses = tutils()->get_course_enrolled_ids_by_order_id($order->ID);
                            if (tutils()->count($courses)){
                                foreach ($courses as $course){
                                    echo '<p>'.get_the_title($course['course_id']).'</p>';
                                }
                            }
                        }
                        ?>
                    </td>
                    <td><?php echo esc_html($price); ?></td>
                    <td><?php echo esc_html($status); ?></td>

                    <td>
                        <?php echo date_i18n(get_option('date_format'), strtotime($date)) ?>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
    </div>

	<?php
}else{
	echo _e('No purchase history available', 'larisdigital-wp');
}

?>
