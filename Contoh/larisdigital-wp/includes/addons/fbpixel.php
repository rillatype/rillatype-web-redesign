<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_5b07e0b7c057d',
	'title' => esc_html__( 'Facebook Pixel Events', 'larisdigital-wp' ),
	'fields' => array(
		array(
			'key' => 'field_5b07e0ce11943',
			'label' => '',
			'name' => '_fbpixel',
			'type' => 'repeater',
			'instructions' => esc_html__( 'You can add more than one Facebook pixel events on this page.', 'larisdigital-wp' ).'<br/>'.esc_html__( 'Do not forget to add Facebook Pixel IDs to', 'larisdigital-wp' ).'<br/><strong><a href="'.admin_url('customize.php').'">'.esc_html__( 'Appearance - Customize - Theme Settings Integrations - Facebook Pixels', 'larisdigital-wp' ).'</a></strong>',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => 'acf-fbpixel',
				'id' => '',
			),
			'collapsed' => 'field_5b07e0f211944',
			'min' => 0,
			'max' => 0,
			'layout' => 'row',
			'button_label' => esc_html__( 'Add Facebook Pixel Event', 'larisdigital-wp' ),
			'sub_fields' => array(
				array(
					'key' => 'field_5b07e0f211944',
					'label' => 'event',
					'name' => 'event',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'PageView' => 'PageView',
						'ViewContent' => 'ViewContent',
						'AddToCart' => 'AddToCart',
						'InitiateCheckout' => 'InitiateCheckout',
						'AddPaymentInfo' => 'AddPaymentInfo',
						'Purchase' => 'Purchase',
						'AddToWishlist' => 'AddToWishlist',
						'Lead' => 'Lead',
						'CompleteRegistration' => 'CompleteRegistration',
						'custom' => 'Custom Event',
					),
					'default_value' => array(
						0 => 'PageView',
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'ajax' => 0,
					'return_format' => 'value',
					'placeholder' => '',
				),
				array(
					'key' => 'field_5b07e571e5290',
					'label' => 'custom event',
					'name' => 'event_custom',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_5b07e0f211944',
								'operator' => '==',
								'value' => 'custom',
							),
						),
					),
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => 'CustomEventName',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_5b07e14322380',
					'label' => 'value',
					'name' => 'value',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_5b07e0f211944',
								'operator' => '!=',
								'value' => 'PageView',
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
					'key' => 'field_5b07e15a22381',
					'label' => 'currency',
					'name' => 'currency',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_5b07e0f211944',
								'operator' => '!=',
								'value' => 'PageView',
							),
						),
					),
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => larisdigital_fbpixel_default_currency(),
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_5b07e8e9f9887',
					'label' => 'advanced',
					'name' => 'advanced',
					'type' => 'true_false',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_5b07e0f211944',
								'operator' => '!=',
								'value' => 'PageView',
							),
						),
					),
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'message' => esc_html__( 'Add custom parameter', 'larisdigital-wp' ),
					'default_value' => 0,
					'ui' => 0,
					'ui_on_text' => '',
					'ui_off_text' => '',
				),
				array(
					'key' => 'field_5b07e768d6f2a',
					'label' => '&nbsp; &nbsp;',
					'name' => 'params',
					'type' => 'repeater',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_5b07e8e9f9887',
								'operator' => '==',
								'value' => '1',
							),
						),
					),
					'wrapper' => array(
						'width' => '',
						'class' => 'acf-fbpixel-custom-params',
						'id' => '',
					),
					'collapsed' => 'field_5b07e7bdd6f2b',
					'min' => 0,
					'max' => 0,
					'layout' => 'table',
					'button_label' => esc_html__( 'Add Custom Parameter', 'larisdigital-wp' ),
					'sub_fields' => array(
						array(
							'key' => 'field_5b07e7bdd6f2b',
							'label' => 'parameter name',
							'name' => 'name',
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
							'key' => 'field_5b07e7cdd6f2c',
							'label' => 'parameter value',
							'name' => 'value',
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
					),
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
	'menu_order' => 4,
	'position' => 'advanced',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

endif;

function larisdigital_fbpixel_default_currency() {
	if ( class_exists('woocommerce') ) {
		return get_woocommerce_currency();
	}
	return 'USD';
}

add_action( 'larisdigital_fbpixel_wp_head', 'larisdigital_fbpixel_page_wp_head' );
function larisdigital_fbpixel_page_wp_head() {
	if ( ! function_exists('have_rows') ) {
		return;
	}
	if ( ! is_singular() ) {
		return;
	}
	$events = array();
	if( have_rows('_fbpixel') ) :
		while ( have_rows('_fbpixel') ) : the_row();
			$event = get_sub_field('event');
			if ( 'PageView' == $event ) {
				$event = '';
				$track = 'track';
			}
			elseif ( 'custom' == $event ) {
				$event_custom = get_sub_field('event_custom');
				if ( $event_custom ) {
					$event = trim( $event_custom );
					$track = 'trackCustom';
				}
			}
			else {
				$event = trim( $event );
				$track = 'track';
			}
			if ( $event ) {
				$params = array();
				$value = get_sub_field('value');
				$params['value'] = $value ? floatval( $value ) : '0.00';
				$currency = get_sub_field('currency');
				$params['currency'] = $currency ? trim( $currency ) : larisdigital_fbpixel_default_currency();
				$params['source'] = LARISDIGITAL_THEME_SLUG;
				$params['source_action'] = 'page-load';
				$params['source_position'] = 'header';
				$params['version'] = LARISDIGITAL_THEME_VERSION;
				$params['domain'] = str_replace( array('https://www.','http://www.','https://','http://'), '', home_url('/') );
				$params['campaign_url'] = get_queried_object()->post_name;
				$params['content_name'] = get_the_title();
				$params['post_type'] = get_post_type();
				$advanced = get_sub_field('advanced');
				if ( $advanced ) {
					$custom_params = get_sub_field('params');
					if ( !empty( $custom_params ) ) {
						foreach ( $custom_params as $custom_param ) {
							$param_name = isset( $custom_param['name'] ) && $custom_param['name'] ? trim( $custom_param['name'] ) : '';
							$param_value = isset( $custom_param['value'] ) && $custom_param['value'] ? trim( $custom_param['value'] ) : '';
							if ( $param_name && $param_value ) {
								$params[$param_name] = $param_value;
							}
						}
					}
				}
				$events[] = array(
					'event' => $event,
					'track' => $track,
					'params' => $params,
				);
			}
		endwhile;
	endif;
	if ( ! empty( $events ) ) {
?>
<!-- Facebook Pixel Events Code -->
<script>
<?php foreach ( $events as $event) : ?>
fbq('<?php echo $event['track']; ?>', "<?php echo $event['event']; ?>", <?php echo json_encode( $event['params'] ); ?> );
<?php endforeach; ?>
</script>
<!-- End Facebook Pixel Events Code -->
<?php 
	}
}

add_action( 'admin_head', 'larisdigital_fbpixel_admin_head_acf' );
function larisdigital_fbpixel_admin_head_acf() {
	echo '<style>
	.acf-fbpixel .acf-actions { 
		text-align: left; 
	} 
	.acf-fbpixel-custom-params .acf-actions { 
		text-align: left; 
	} 
	.acf-fbpixel-custom-params .acf-actions .button { 
		color: #555;
		border-color: #ccc;
		background: #f7f7f7;
		box-shadow: 0 1px 0 #ccc; 
		text-shadow: none; 
	} 
	.acf-fbpixel-custom-params .acf-actions .button:hover { 
		background: #fafafa;
		border-color: #999;
		color: #23282d;
	}
	</style>';
}
