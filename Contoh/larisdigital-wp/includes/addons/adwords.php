<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_5b08a9477f618',
	'title' => esc_html__( 'Google Ads (Adwords) Conversions', 'larisdigital-wp' ),
	'fields' => array(
		array(
			'key' => 'field_5b08a9478bd49',
			'label' => '',
			'name' => '_adwords',
			'type' => 'repeater',
			'instructions' => esc_html__( 'You can add more than one Google Ads (Adwords) conversion tracking events on this page.', 'larisdigital-wp' ).'<br/>'.esc_html__( 'Go to "Measurement - Conversions" menu on your Google Ads (Adwords) dashboard to create your conversion action.', 'larisdigital-wp' ),
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => 'acf-adwords',
				'id' => '',
			),
			'collapsed' => 'field_5b08a947909a1',
			'min' => 0,
			'max' => 0,
			'layout' => 'row',
			'button_label' => esc_html__( 'Add Google Ads (Adwords) Conversion', 'larisdigital-wp' ),
			'sub_fields' => array(
				array(
					'key' => 'field_5b08a947909a1',
					'label' => 'send_to',
					'name' => 'send_to',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_5b08a94790acf',
					'label' => '&nbsp;',
					'name' => 'additional',
					'type' => 'true_false',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'message' => esc_html__( 'Add additional parameters', 'larisdigital-wp' ),
					'default_value' => 0,
					'ui' => 0,
					'ui_on_text' => '',
					'ui_off_text' => '',
				),
				array(
					'key' => 'field_5b08a94790a4a',
					'label' => 'value',
					'name' => 'value',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_5b08a94790acf',
								'operator' => '==',
								'value' => '1',
							),
						),
					),
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '0.00',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_5b08a94790a86',
					'label' => 'currency',
					'name' => 'currency',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_5b08a94790acf',
								'operator' => '==',
								'value' => '1',
							),
						),
					),
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => larisdigital_adwords_default_currency(),
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_5b08abf682df6',
					'label' => 'transaction_id',
					'name' => 'transaction_id',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_5b08a94790acf',
								'operator' => '==',
								'value' => '1',
							),
						),
					),
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'post',
			),
		),
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'page',
			),
		),
	),
	'menu_order' => 5,
	'position' => 'advanced',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

endif;

function larisdigital_adwords_default_currency() {
	if ( class_exists('woocommerce') ) {
		return get_woocommerce_currency();
	}
	return 'USD';
}

add_action( 'larisdigital_gtag_wp_head', 'larisdigital_adwords_page_wp_head' );
function larisdigital_adwords_page_wp_head() {
	if ( ! function_exists('have_rows') ) {
		return;
	}
	if ( ! is_singular() ) {
		return;
	}
	$events = array();
	if( have_rows('_adwords') ) :
		while ( have_rows('_adwords') ) : the_row();
			$send_to = get_sub_field('send_to');
			$send_to = trim( $send_to );
			if ( $send_to ) {
				$event = array();
				$event['send_to'] = $send_to;
				$additional = get_sub_field('additional');
				if ( $additional ) {
					$value = get_sub_field('value');
					if ( $value ) {
						$event['value'] = floatval( $value );
						$currency = get_sub_field('currency');
						$event['currency'] = $currency ? trim( $currency ) : larisdigital_adwords_default_currency();
					}
					$transaction_id = get_sub_field('transaction_id');
					if ( $transaction_id ) {
						$event['transaction_id'] = trim( $transaction_id );
					}
				}
				$events[] = $event;
			}
		endwhile;
	endif;
	if ( ! empty( $events ) ) {
?>
<!-- Conversion Tracking Events Code -->
<script>
<?php foreach ( $events as $event) : ?>
gtag('event', 'conversion', <?php echo json_encode( $event, JSON_UNESCAPED_SLASHES ); ?>);
<?php endforeach; ?>
</script>
<!-- End Conversion Tracking Events Code -->
<?php 
	}
}

add_filter( 'larisdigital_gtag_ids', 'larisdigital_adwords_page_gtag_ids' );
function larisdigital_adwords_page_gtag_ids( $gtag_ids ) {
	if ( ! function_exists('have_rows') ) {
		return $gtag_ids;
	}
	if ( ! is_singular() ) {
		return $gtag_ids;
	}
	$events = array();
	if( have_rows('_adwords') ) :
		while ( have_rows('_adwords') ) : the_row();
			$send_to = get_sub_field('send_to');
			$send_to = trim( $send_to );
			if ( $send_to ) {
				$send_to2 = explode( '/', $send_to );
				if ( isset( $send_to2[0] ) && strpos($send_to2[0], 'AW-') !== false ) {
					$gtag_ids[$send_to2[0]] = trim( $send_to2[0] );
				}
			}
		endwhile;
	endif;
	return $gtag_ids;
}

add_action( 'admin_head', 'larisdigital_adwords_admin_head_acf' );
function larisdigital_adwords_admin_head_acf() {
	echo '<style>
	.acf-adwords .acf-actions { 
		text-align: left; 
	} 
	</style>';
}
