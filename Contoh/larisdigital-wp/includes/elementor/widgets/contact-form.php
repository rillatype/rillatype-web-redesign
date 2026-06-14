<?php
namespace ElementorTokoPress\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Utils;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class TP_Contact_Form extends Widget_Base {

	public function get_name() {
		return 'tp_contact_form';
	}

	public function get_title() {
		return __( 'TP - Contact Form', 'larisdigital-wp' );
	}

	public function get_icon() {
		return 'eicon-form-horizontal';
	}

	public function get_categories() {
		return [ 'tokopress' ];
	}

	public static function get_default_currency() {
		if ( class_exists('woocommerce') ) {
			return get_woocommerce_currency();
		}
		return 'USD';
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_form',
			[
				'label' => __( 'Contact Form', 'larisdigital-wp' ),
			]
		);

			$this->add_control(
				'form_labels',
				[
					'label' 		=> __( 'Form Labels', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::SWITCHER,
					'label_on' 		=> __( 'Show', 'larisdigital-wp' ),
					'label_off' 	=> __( 'Hide', 'larisdigital-wp' ),
					'return_value' 	=> 'yes',
					'default' 		=> 'yes',
					'separator' 	=> 'none',
				]
			);

			$this->add_control(
				'form_placeholders',
				[
					'label' 		=> __( 'Form Placeholders', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::SWITCHER,
					'label_on' 		=> __( 'Show', 'larisdigital-wp' ),
					'label_off' 	=> __( 'Hide', 'larisdigital-wp' ),
					'return_value' 	=> 'yes',
					'separator' 	=> 'none',
				]
			);

			$this->add_control(
				'show_email_phone',
				[
					'label' => __( 'Show Email & Phone', 'larisdigital-wp' ),
					'type' => Controls_Manager::SELECT,
					'label_block' => true,
					'default' => 'email',
					'options' => [
						'email_phone' => __( 'Email & Phone', 'larisdigital-wp' ),
						'phone_email' => __( 'Phone & Email', 'larisdigital-wp' ),
						'email' => __( 'Email', 'larisdigital-wp' ),
						'phone' => __( 'Phone', 'larisdigital-wp' ),
						'none' => __( 'None', 'larisdigital-wp' ),
					],
				]
			);

			$this->add_control(
				'inline_name_email',
				[
					'label' 		=> __( 'Inline Name & Email field', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::SWITCHER,
					'default' 		=> 'yes',
					'label_on'		=> __( 'Yes', 'larisdigital-wp' ),
					'label_off'		=> __( 'No', 'larisdigital-wp' ),
					'return_value'	=> 'yes',
					'condition' => [
						'show_email_phone' => 'email',
					],
				]
			);

			$this->add_control(
				'inline_name_phone',
				[
					'label' 		=> __( 'Inline Name & Phone field', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::SWITCHER,
					'default' 		=> 'yes',
					'label_on'		=> __( 'Yes', 'larisdigital-wp' ),
					'label_off'		=> __( 'No', 'larisdigital-wp' ),
					'return_value'	=> 'yes',
					'condition' => [
						'show_email_phone' => 'phone',
					],
				]
			);

			$this->add_control(
				'inline_email_phone',
				[
					'label' 		=> __( 'Inline Email & Phone field', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::SWITCHER,
					'default' 		=> 'yes',
					'label_on'		=> __( 'Yes', 'larisdigital-wp' ),
					'label_off'		=> __( 'No', 'larisdigital-wp' ),
					'return_value'	=> 'yes',
					'condition' => [
						'show_email_phone' => ['email_phone','phone_email'],
					],
				]
			);

			$this->add_control(
				'form_email_to',
				[
					'label' 		=> __( 'Email To', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::TEXT,
					'placeholder' 	=> get_option( 'admin_email' ),
					'label_block' 	=> true,
					'separator' 	=> 'before',
				]
			);

			$this->add_control(
				'form_email_subject',
				[
					'label' 		=> __( 'Email Subject', 'larisdigital-wp' ),
					'description' 	=> __( 'You can use %site%, %name%, %email%, %phone% to personalize email subject.', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::TEXT,
					'placeholder' 	=> __( '[%site%] New message from %name% %email% %phone%', 'larisdigital-wp' ),
					'label_block' 	=> true,
					'separator' 	=> 'none',
				]
			);

			$this->add_control(
				'form_email_success',
				[
					'label' 		=> __( 'Success Message', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::TEXT,
					'placeholder' 	=> __( 'Your message was successfully sent.', 'larisdigital-wp' ),
					'label_block' 	=> true,
					'separator' 	=> 'before',
				]
			);

			$this->add_control(
				'form_email_invalid',
				[
					'label' 		=> __( 'Validation Error Message', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::TEXT,
					'placeholder' 	=> __( 'There were one or more errors while submitting the form.', 'larisdigital-wp' ),
					'label_block' 	=> true,
					'separator' 	=> 'none',
				]
			);

			$this->add_control(
				'form_email_error',
				[
					'label' 		=> __( 'Technical Error Message (NOT SENT)', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::TEXT,
					'placeholder' 	=> __( 'There were technical error while submitting the form. Sorry for the inconvenience.', 'larisdigital-wp' ),
					'label_block' 	=> true,
					'separator' 	=> 'none',
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_field_name',
			[
				'label' => __( 'Name Field', 'larisdigital-wp' ),
			]
		);

			$this->add_control(
				'field_name_label',
				[
					'label' 		=> __( 'Label', 'larisdigital-wp' ),
					'type'			=> Controls_Manager::TEXT,
					'default' 		=> __( 'Name', 'larisdigital-wp' ),
					'placeholder' 	=> __( 'Name', 'larisdigital-wp' ),
				]
			);

			$this->add_control(
				'field_name_placeholder',
				[
					'label' 		=> __( 'Placeholder', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::TEXT,
					'default' 		=> __( 'Name', 'larisdigital-wp' ),
					'placeholder' 	=> __( 'Name', 'larisdigital-wp' ),
				]
			);

			$this->add_control(
				'field_name_invalid',
				[
					'label' 		=> __( 'Invalid Message', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::TEXT,
					'default' 		=> __( 'Please enter your name', 'larisdigital-wp' ),
					'placeholder' 	=> __( 'Please enter your name', 'larisdigital-wp' ),
					'label_block' 	=> true,
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_field_email',
			[
				'label' => __( 'Email Field', 'larisdigital-wp' ),
				'condition' => [
					'show_email_phone' => ['email_phone','phone_email','email'],
				],
			]
		);

			$this->add_control(
				'field_email_label',
				[
					'label' 		=> __( 'Label', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::TEXT,
					'default' 		=> __( 'Email', 'larisdigital-wp' ),
					'placeholder' 	=> __( 'Email', 'larisdigital-wp' ),
				]
			);

			$this->add_control(
				'field_email_placeholder',
				[
					'label' 		=> __( 'Placeholder', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::TEXT,
					'default' 		=> __( 'Email', 'larisdigital-wp' ),
					'placeholder' 	=> __( 'Email', 'larisdigital-wp' ),
				]
			);

			$this->add_control(
				'field_email_invalid',
				[
					'label' 		=> __( 'Invalid Message', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::TEXT,
					'default' 		=> __( 'Please enter your valid email address', 'larisdigital-wp' ),
					'placeholder' 	=> __( 'Please enter your valid email address', 'larisdigital-wp' ),
					'label_block' 	=> true,
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_field_phone',
			[
				'label' => __( 'Phone Field', 'larisdigital-wp' ),
				'condition' => [
					'show_email_phone' => ['email_phone','phone_email','phone'],
				],
			]
		);

			$this->add_control(
				'field_phone_label',
				[
					'label' 		=> __( 'Label', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::TEXT,
					'default' 		=> __( 'Phone', 'larisdigital-wp' ),
					'placeholder' 	=> __( 'Email', 'larisdigital-wp' ),
				]
			);

			$this->add_control(
				'field_phone_placeholder',
				[
					'label' 		=> __( 'Placeholder', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::TEXT,
					'default' 		=> __( 'Phone', 'larisdigital-wp' ),
					'placeholder' 	=> __( 'Phone', 'larisdigital-wp' ),
				]
			);

			$this->add_control(
				'field_phone_invalid',
				[
					'label' 		=> __( 'Invalid Phone Number', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::TEXT,
					'default' 		=> __( 'Please enter your valid phone number', 'larisdigital-wp' ),
					'placeholder' 	=> __( 'Please enter your valid phone number', 'larisdigital-wp' ),
					'label_block' 	=> true,
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_field_message',
			[
				'label' => __( 'Message Field', 'larisdigital-wp' ),
			]
		);

			$this->add_control(
				'field_message_label',
				[
					'label' 		=> __( 'Label', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::TEXT,
					'default' 		=> __( 'Message', 'larisdigital-wp' ),
					'placeholder' 	=> __( 'Message', 'larisdigital-wp' ),
				]
			);

			$this->add_control(
				'field_message_placeholder',
				[
					'label' 		=> __( 'Placeholder', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::TEXT,
					'default' 		=> __( 'Message', 'larisdigital-wp' ),
					'placeholder' 	=> __( 'Message', 'larisdigital-wp' ),
				]
			);

			$this->add_control(
				'field_message_invalid',
				[
					'label' 		=> __( 'Invalid Message', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::TEXT,
					'default' 		=> __( 'Please enter your message', 'larisdigital-wp' ),
					'placeholder' 	=> __( 'Please enter your message', 'larisdigital-wp' ),
					'label_block' 	=> true,
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_field_submit',
			[
				'label' => __( 'Submit Button', 'larisdigital-wp' ),
			]
		);

			$this->add_control(
				'field_submit_text',
				[
					'label' => __( 'Text', 'larisdigital-wp' ),
					'type' => Controls_Manager::TEXT,
					'default' => __( 'Submit', 'larisdigital-wp' ),
					'placeholder' => __( 'Submit', 'larisdigital-wp' ),
				]
			);

			$this->add_control(
				'field_submit_align',
				[
					'label' 	=> __( 'Alignment', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::CHOOSE,
					'default' 	=> 'left',
					'options' 	=> [
						'left' 		=> [
							'title' 	=> __( 'Left', 'larisdigital-wp' ),
							'icon'		=> 'eicon-text-align-left',
						],
						'center' 	=> [
							'title' 	=> __( 'Center', 'larisdigital-wp' ),
							'icon' 		=> 'eicon-text-align-center',
						],
						'justify' 	=> [
							'title' 	=> __( 'Justified', 'larisdigital-wp' ),
							'icon' 		=> 'eicon-text-align-justify',
						],
						'right' 	=> [
							'title' 	=> __( 'Right', 'larisdigital-wp' ),
							'icon' 		=> 'eicon-text-align-right',
						],
					],
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_tracking',
			[
				'label' => __( 'Tracking (FB Pixel / Adwords)', 'larisdigital-wp' ),
			]
		);

		$this->start_controls_tabs( 'tabs_tracking' );

		$this->start_controls_tab(
			'tab_tracking_fbpixel',
			[
				'label' => __( 'FB Pixel', 'larisdigital-wp' ),
			]
		);

		$this->add_control(
			'tracking_fbpixel',
			[
				'label' => __( 'Onclick Facebook Pixel', 'larisdigital-wp' ),
				'description' => __( 'When visitor click submit button', 'larisdigital-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'larisdigital-wp' ),
				'label_off' => __( 'No', 'larisdigital-wp' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'tracking_fbpixel_event',
			[
				'label' => __( 'FB Pixel Event', 'larisdigital-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'Lead',
				'options' => [
					'Lead' => __( 'Lead', 'larisdigital-wp' ),
					'ViewContent' => __( 'ViewContent', 'larisdigital-wp' ),
					'AddToCart' => __( 'AddToCart', 'larisdigital-wp' ),
					'InitiateCheckout' => __( 'InitiateCheckout', 'larisdigital-wp' ),
					'AddCustomerInfo' => __( 'AddCustomerInfo', 'larisdigital-wp' ),
					'AddPaymentInfo' => __( 'AddPaymentInfo', 'larisdigital-wp' ),
					'Purchase' => __( 'Purchase', 'larisdigital-wp' ),
					'AddToWishlist' => __( 'AddToWishlist', 'larisdigital-wp' ),
					'CompleteRegistration' => __( 'CompleteRegistration', 'larisdigital-wp' ),
					'custom' => __( 'Custom Event', 'larisdigital-wp' ),
				],
				'label_block' => true,
				'condition' => [
					'tracking_fbpixel!' => '',
				],
			]
		);

		$this->add_control(
			'tracking_fbpixel_event_custom',
			[
				'label' => __( 'FB Pixel Custom Event', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'condition' => [
					'tracking_fbpixel!' => '',
					'tracking_fbpixel_event' => 'custom',
				],
			]
		);

		$this->add_control(
			'tracking_fbpixel_value',
			[
				'label' => __( 'value', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => '0.00',
				'condition' => [
					'tracking_fbpixel!' => '',
					'tracking_fbpixel_event!' => '',
				],
			]
		);

		$this->add_control(
			'tracking_fbpixel_currency',
			[
				'label' => __( 'currency', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => self::get_default_currency(),
				'condition' => [
					'tracking_fbpixel!' => '',
					'tracking_fbpixel_event!' => '',
				],
			]
		);

		$this->add_control(
			'tracking_fbpixel_advanced',
			[
				'label' => __( 'Add custom parameters', 'larisdigital-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'larisdigital-wp' ),
				'label_off' => __( 'No', 'larisdigital-wp' ),
				'return_value' => 'yes',
				'condition' => [
					'tracking_fbpixel!' => '',
					'tracking_fbpixel_event!' => '',
				],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'name',
			[
				'label' => __( 'parameter name', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
			]
		);

		$repeater->add_control(
			'value',
			[
				'label' => __( 'parameter value', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'tracking_fbpixel_params',
			[
				'label' => '',
				'type' => Controls_Manager::REPEATER,
				'show_label' => false,
				'prevent_empty' => false,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ name }}}',
				'condition' => [
					'tracking_fbpixel!' => '',
					'tracking_fbpixel_event!' => '',
					'tracking_fbpixel_advanced!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_tracking_gtag',
			[
				'label' => __( 'AdWords', 'larisdigital-wp' ),
			]
		);

		$this->add_control(
			'tracking_gtag',
			[
				'label' => __( 'Onclick Conversion', 'larisdigital-wp' ),
				'description' => __( 'When visitor click submit button', 'larisdigital-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'larisdigital-wp' ),
				'label_off' => __( 'No', 'larisdigital-wp' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'tracking_gtag_send_to',
			[
				'label' => __( 'send_to (required)', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => '',
				'label_block' => true,
				'condition' => [
					'tracking_gtag!' => '',
				],
			]
		);

		$this->add_control(
			'tracking_gtag_params',
			[
				'label' => __( 'Add additional parameters', 'larisdigital-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'larisdigital-wp' ),
				'label_off' => __( 'No', 'larisdigital-wp' ),
				'return_value' => 'yes',
				'condition' => [
					'tracking_gtag!' => '',
				],
			]
		);

		$this->add_control(
			'tracking_gtag_value',
			[
				'label' => __( 'value', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => '0.00',
				'condition' => [
					'tracking_gtag!' => '',
					'tracking_gtag_params!' => '',
				],
			]
		);

		$this->add_control(
			'tracking_gtag_currency',
			[
				'label' => __( 'currency', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => self::get_default_currency(),
				'condition' => [
					'tracking_gtag!' => '',
					'tracking_gtag_params!' => '',
				],
			]
		);

		$this->add_control(
			'tracking_gtag_transaction_id',
			[
				'label' => __( 'transaction_id', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => '',
				'condition' => [
					'tracking_gtag!' => '',
					'tracking_gtag_params!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_form_style',
			[
				'label' => __( 'Contact Form', 'larisdigital-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'container_width',
			[
				'label' => __( 'Container Max Width (px)', 'larisdigital-wp' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => 300,
						'max' => 2000,
					],
				],
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-tp-form-wrapper' => 'max-width: {{SIZE}}{{UNIT}};margin:0 auto;',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_label_style',
			[
				'label' => __( 'Form Label (If Available)', 'larisdigital-wp' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'label_text_color',
				[
					'label' 	=> __( 'Text Color', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors'	=> [
						'{{WRAPPER}} .elementor-tp-form-wrapper label' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 		=> 'label_typography',
					'label' 	=> __( 'Typography', 'larisdigital-wp' ),
					'global' => [
						'default' => Global_Typography::TYPOGRAPHY_ACCENT,
					],
					'selector' => '{{WRAPPER}} .elementor-tp-form-wrapper label',
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_input_style',
			[
				'label' => __( 'Form Input / Textarea', 'larisdigital-wp' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'input_text_color',
				[
					'label' 	=> __( 'Text Color', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors'	=> [
						'{{WRAPPER}} .elementor-tp-form-wrapper input[type="text"], {{WRAPPER}} .elementor-tp-form-wrapper input[type="email"], {{WRAPPER}} .elementor-tp-form-wrapper textarea' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 		=> 'input_typography',
					'label' 	=> __( 'Typography', 'larisdigital-wp' ),
					'global' => [
						'default' => Global_Typography::TYPOGRAPHY_ACCENT,
					],
					'selector' 	=> '{{WRAPPER}} .elementor-tp-form-wrapper input[type="text"], {{WRAPPER}} .elementor-tp-form-wrapper input[type="email"], {{WRAPPER}} .elementor-tp-form-wrapper textarea',
				]
			);

			$this->add_control(
				'input_background_color',
				[
					'label' 	=> __( 'Background Color', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .elementor-tp-form-wrapper input[type="text"], {{WRAPPER}} .elementor-tp-form-wrapper input[type="email"], {{WRAPPER}} .elementor-tp-form-wrapper textarea' => 'background-color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' 			=> 'input_border',
					'label' 		=> __( 'Border', 'larisdigital-wp' ),
					'placeholder' 	=> '1px',
					'default' 		=> '1px',
					'selector' 		=> '{{WRAPPER}} .elementor-tp-form-wrapper input[type="text"], {{WRAPPER}} .elementor-tp-form-wrapper input[type="email"], {{WRAPPER}} .elementor-tp-form-wrapper textarea',
				]
			);

			$this->add_control(
				'input_border_radius',
				[
					'label' 		=> __( 'Border Radius', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px', '%' ],
					'selectors' 	=> [
						'{{WRAPPER}} .elementor-tp-form-wrapper input[type="text"], {{WRAPPER}} .elementor-tp-form-wrapper input[type="email"], {{WRAPPER}} .elementor-tp-form-wrapper textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'input_text_padding',
				[
					'label' 		=> __( 'Text Padding', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px', 'em', '%' ],
					'selectors' 	=> [
						'{{WRAPPER}} .elementor-tp-form-wrapper input[type="text"], {{WRAPPER}} .elementor-tp-form-wrapper input[type="email"], {{WRAPPER}} .elementor-tp-form-wrapper textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'input_text_margin',
				[
					'label' 		=> __( 'Field Margin', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px', 'em', '%' ],
					'selectors' 	=> [
						'{{WRAPPER}} .elementor-tp-form-wrapper input[type="text"], {{WRAPPER}} .elementor-tp-form-wrapper input[type="email"], {{WRAPPER}} .elementor-tp-form-wrapper textarea' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_button_style',
			[
				'label' => __( 'Form Button', 'larisdigital-wp' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);

			$this->start_controls_tabs( 'tabs_button_style' );

				$this->start_controls_tab(
					'tab_button_normal',
					[
						'label' => __( 'Normal', 'larisdigital-wp' ),
					]
				);

				$this->add_control(
					'button_text_color',
					[
						'label' 	=> __( 'Text Color', 'larisdigital-wp' ),
						'type' 		=> Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .elementor-tp-form-wrapper input[type="submit"], {{WRAPPER}} .elementor-tp-form-wrapper button' => 'color: {{VALUE}};',
						],
					]
				);

				$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'name' 		=> 'typography',
						'label' 	=> __( 'Typography', 'larisdigital-wp' ),
						'global' => [
							'default' => Global_Typography::TYPOGRAPHY_ACCENT,
						],
						'selector' 	=> '{{WRAPPER}} .elementor-tp-form-wrapper input[type="submit"], {{WRAPPER}} .elementor-tp-form-wrapper button',
					]
				);

				$this->add_control(
					'background_color',
					[
						'label' 	=> __( 'Background Color', 'larisdigital-wp' ),
						'type' 		=> Controls_Manager::COLOR,
						'global' => [
							'default' => Global_Colors::COLOR_ACCENT,
						],
						'selectors' => [
							'{{WRAPPER}} .elementor-tp-form-wrapper input[type="submit"], {{WRAPPER}} .elementor-tp-form-wrapper button' => 'background-color: {{VALUE}};',
						],
					]
				);

				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' 			=> 'border',
						'label' 		=> __( 'Border', 'larisdigital-wp' ),
						'placeholder' 	=> '1px',
						'default' 		=> '1px',
						'selector' 		=> '{{WRAPPER}} .elementor-tp-form-wrapper input[type="submit"], {{WRAPPER}} .elementor-tp-form-wrapper button',
					]
				);

				$this->add_control(
					'border_radius',
					[
						'label' 		=> __( 'Border Radius', 'larisdigital-wp' ),
						'type' 			=> Controls_Manager::DIMENSIONS,
						'size_units' 	=> [ 'px', '%' ],
						'selectors' 	=> [
							'{{WRAPPER}} .elementor-tp-form-wrapper input[type="submit"], {{WRAPPER}} .elementor-tp-form-wrapper button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);

				$this->add_control(
					'text_padding',
					[
						'label' 		=> __( 'Text Padding', 'larisdigital-wp' ),
						'type' 			=> Controls_Manager::DIMENSIONS,
						'size_units' 	=> [ 'px', 'em', '%' ],
						'selectors' 	=> [
							'{{WRAPPER}} .elementor-tp-form-wrapper input[type="submit"], {{WRAPPER}} .elementor-tp-form-wrapper button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_button_hover',
					[
						'label' => __( 'Hover', 'larisdigital-wp' ),
					]
				);

				$this->add_control(
					'hover_color',
					[
						'label' 	=> __( 'Text Color', 'larisdigital-wp' ),
						'type' 		=> Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .elementor-tp-form-wrapper input[type="submit"]:hover, {{WRAPPER}} .elementor-tp-form-wrapper button:hover' => 'color: {{VALUE}};',
						],
					]
				);

				$this->add_control(
					'button_background_hover_color',
					[
						'label' 	=> __( 'Background Color', 'larisdigital-wp' ),
						'type' 		=> Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .elementor-tp-form-wrapper input[type="submit"]:hover, {{WRAPPER}} .elementor-tp-form-wrapper button:hover' => 'background-color: {{VALUE}};',
						],
					]
				);

				$this->add_control(
					'button_hover_border_color',
					[
						'label' 	=> __( 'Border Color', 'larisdigital-wp' ),
						'type' 		=> Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .elementor-tp-form-wrapper input[type="submit"]:hover, {{WRAPPER}} .elementor-tp-form-wrapper button:hover' => 'border-color: {{VALUE}};',
						],
					]
				);

				$this->add_control(
					'hover_animation',
					[
						'label' => __( 'Animation', 'larisdigital-wp' ),
						'type' 	=> Controls_Manager::HOVER_ANIMATION,
					]
				);

				$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings();

		$form_email_success = __( 'Your message was successfully sent.', 'larisdigital-wp' );
		if ( trim( $settings['form_email_success'] ) ) {
			$form_email_success = $settings['form_email_success'];
		}

		$form_email_error = __( 'There were technical error while submitting the form. Sorry for the inconvenience.', 'larisdigital-wp' );
		if ( trim( $settings['form_email_error'] ) ) {
			$form_email_error = $settings['form_email_error'];
		}

		$form_email_invalid = __( 'There were one or more errors while submitting the form.', 'larisdigital-wp' );
		if ( trim( $settings['form_email_invalid'] ) ) {
			$form_email_invalid = $settings['form_email_invalid'];
		}

		$labels_class = ! $settings['form_labels'] ? 'elementor-screen-only' : '';

		$show_email = in_array( $settings['show_email_phone'], [ 'email_phone', 'phone_email', 'email' ] ) ? true : false;
		$show_phone = in_array( $settings['show_email_phone'], [ 'email_phone', 'phone_email', 'phone' ] ) ? true : false;

		$field_name_label 			= $settings['field_name_label'];
		$field_name_placeholder 	= $settings['form_placeholders'] ? $settings['field_name_placeholder'] : '';
		$field_name_invalid 		= $settings['field_name_invalid'] ? $settings['field_name_invalid'] : __( 'Please enter your name', 'larisdigital-wp' );
		$field_name_invalid_status 	= false;
		$field_name_value 			= '';

		if ( $show_email ) {
			$field_email_label 			= $settings['field_email_label'];
			$field_email_placeholder 	= $settings['form_placeholders'] ? $settings['field_email_placeholder'] : '';
			$field_email_invalid 		= $settings['field_email_invalid'] ? $settings['field_email_invalid'] : __( 'Please enter your valid email address', 'larisdigital-wp' );
			$field_email_invalid_status = false;
			$field_email_value 			= '';
		}

		if ( $show_phone ) {
			$field_phone_label 			= $settings['field_phone_label'];
			$field_phone_placeholder 	= $settings['form_placeholders'] ? $settings['field_phone_placeholder'] : '';
			$field_phone_invalid 		= $settings['field_phone_invalid'] ? $settings['field_phone_invalid'] : __( 'Please enter your valid phone number', 'larisdigital-wp' );
			$field_phone_invalid_status = false;
			$field_phone_value 			= '';
		}

		$field_message_label 			= $settings['field_message_label'];
		$field_message_placeholder 		= $settings['form_placeholders'] ? $settings['field_message_placeholder'] : '';
		$field_message_invalid 			= $settings['field_message_invalid'] ? $settings['field_message_invalid'] : __( 'Please enter your message', 'larisdigital-wp' );
		$field_message_invalid_status 	= false;
		$field_message_value 			= '';

		$field_important_value 		= '';

		$field_submit_text = $settings['field_submit_text'];
		if ( !$field_submit_text ) {
			$field_submit_text = __( 'Submit', 'larisdigital-wp' );
		}

		$form_invalid 	= false;
		$form_success 	= false;
		$form_error 	= false;
		if ( isset( $_POST['tp-form-id'] ) && $_POST['tp-form-id'] === $this->get_id() ) {
			// var_dump( $_POST );

			$form_email_from 		= 'noreply@'.str_ireplace( 'www.', '', parse_url( home_url('/'), PHP_URL_HOST ) );
			$form_email_from_name 	= get_option( 'blogname' );

			$field_name_value = isset( $_POST['tp-form-name'] ) ? esc_html( $_POST['tp-form-name'] ) : '';
			if ( !$field_name_value ) {
				$field_name_invalid_status = true;
				$form_invalid = true;
			}

			$field_email_value = '';
			if ( $show_email ) {
				$field_email_value = isset( $_POST['tp-form-email'] ) ? esc_html( $_POST['tp-form-email'] ) : '';
				if ( !$field_email_value ) {
					$field_email_invalid_status = true;
					$form_invalid = true;
				}
				else {
					if ( function_exists('is_email') && ! is_email( $field_email_value ) ) {
						$field_email_invalid_status = true;
						$form_invalid = true;
					}
				}
			}

			$field_phone_value = '';
			if ( $show_phone ) {
				$field_phone_value = isset( $_POST['tp-form-phone'] ) ? esc_html( $_POST['tp-form-phone'] ) : '';
				if ( !$field_phone_value ) {
					$field_phone_invalid_status = true;
					$form_invalid = true;
				}
				else {
					if ( strlen( $field_phone_value ) < 6 ) {
						$field_email_invalid_status = true;
						$form_invalid = true;
					}
				}
			}

			$field_message_value = isset( $_POST['tp-form-message'] ) ? esc_html( $_POST['tp-form-message'] ) : '';
			if ( !$field_message_value ) {
				$field_message_invalid_status = true;
				$form_invalid = true;
			}

			$field_important_value = isset( $_POST['tp-form-important'] ) ? esc_html( $_POST['tp-form-important'] ) : '';
			if ( $field_important_value ) {
				$form_invalid = true;
			}

			if ( !$form_invalid ) {

				$form_email_to = get_option( 'admin_email' );
				if ( trim( $settings['form_email_to'] ) ) {
					$form_email_to = $settings['form_email_to'];
				}

				$form_email_subject = __( '[%site%] New message from %name% %email% %phone%', 'larisdigital-wp' );
				if ( trim( $settings['form_email_subject'] ) ) {
					$form_email_subject = $settings['form_email_subject'];
				}
				$form_email_subject = str_replace( '%site%', get_option( 'blogname' ), $form_email_subject );
				$form_email_subject = str_replace( '%name%', $field_name_value, $form_email_subject );
				$form_email_subject = str_replace( '%email%', $field_email_value, $form_email_subject );
				$form_email_subject = str_replace( '%phone%', $field_phone_value, $form_email_subject );

				$ipaddress = '';
				if ( isset($_SERVER['HTTP_CLIENT_IP']) && $_SERVER['HTTP_CLIENT_IP'] )
					$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
				else if( isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] )
					$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
				else if( isset($_SERVER['HTTP_X_FORWARDED']) && $_SERVER['HTTP_X_FORWARDED'] )
					$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
				else if( isset($_SERVER['HTTP_FORWARDED_FOR']) && $_SERVER['HTTP_FORWARDED_FOR'] )
					$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
				else if( isset($_SERVER['HTTP_FORWARDED']) && $_SERVER['HTTP_FORWARDED'] )
					$ipaddress = $_SERVER['HTTP_FORWARDED'];
				else if( isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] )
					$ipaddress = $_SERVER['REMOTE_ADDR'];
				else
					$ipaddress = 'UNKNOWN';
				$useragent = $_SERVER['HTTP_USER_AGENT'];

				$message_headers = array();
				$message_headers[] = 'From: '.$form_email_from_name.' <' . $form_email_from . '>';
				// $message_headers[] = 'Reply-To: '.$field_email_value;

				$message_body = '';
				$message_body .= $field_name_label . " \r\n". $field_name_value . "\r\n\r\n" ;
				if ( $show_email ) {
					$message_body .= $field_email_label . " \r\n". $field_email_value . "\r\n\r\n";
				}
				if ( $show_phone ) {
					$message_body .= $field_phone_label . " \r\n". $field_phone_value . "\r\n\r\n";
				}
				$message_body .= $field_message_label . " \r\n". $field_message_value . "\r\n\r\n";
				$message_body .= __( 'IP Address:', 'larisdigital-wp' ) . " ". $ipaddress . "\r\n";
				$message_body .= __( 'User Agent:', 'larisdigital-wp' ) . " ". $useragent . "\r\n";
				if ( isset( $_POST['tp-form-post-id'] ) && $post_id = esc_html( $_POST['tp-form-post-id'] ) ) {
					$message_body .= __( 'Page:', 'larisdigital-wp' ) . " ". get_permalink($post_id) . "\r\n";
				}

				$message_sent = wp_mail( $form_email_to, $form_email_subject, $message_body, $message_headers );

				$cfdb_posted_data = array();
				$cfdb_posted_data[ $field_name_label ] = $field_name_value;
				if ( $show_email ) {
					$cfdb_posted_data[ $field_email_label ] = $field_email_value;
				}
				if ( $show_phone ) {
					$cfdb_posted_data[ $field_phone_label ] = $field_phone_value;
				}
				$cfdb_posted_data[ $field_message_label ] = $field_message_value;
				$cfdb_posted_data[ __( 'IP Address:', 'larisdigital-wp' ) ] = $ipaddress;
				$cfdb_posted_data[ __( 'User Agent:', 'larisdigital-wp' ) ] = $useragent;
				$cfdb_uploaded_files = array();
				$cfdb_data = (object) array(
					'title' => 'Contact Form',
					'posted_data' => $cfdb_posted_data,
					'uploaded_files' => $cfdb_uploaded_files,
				);

				// Call hook to submit data
				do_action_ref_array('cfdb_submit', array(&$cfdb_data));

				if( $message_sent == true ) {
					$form_success = true;
					$field_name_value = '';
					$field_email_value = '';
					$field_phone_value = '';
					$field_message_value = '';
					$field_important_value = '';
				}
				else {
					$form_error = true;
				}
			}
		}

		$this->add_render_attribute( 'wrapper', 'class', 'elementor-tp-form-wrapper' );
		// if ( ! empty( $settings['form_display'] ) ) {
		// 	$this->add_render_attribute( 'wrapper', 'class', 'elementor-tp-form-display-inline' );
		// }
		if ( ! empty( $settings['field_submit_align'] ) ) {
			$this->add_render_attribute( 'wrapper', 'class', 'elementor-tp-form-button-align-' . $settings['field_submit_align'] );
		}

		$this->add_render_attribute( 'field_name_label', 'for', 'tp-form-name-'.$this->get_id() );
		$this->add_render_attribute( 'field_name_label', 'class', $labels_class );
		$this->add_render_attribute( 'field_name', 'type', 'text' );
		$this->add_render_attribute( 'field_name', 'name', 'tp-form-name' );
		$this->add_render_attribute( 'field_name', 'id', 'tp-form-name-'.$this->get_id() );
		$this->add_render_attribute( 'field_name', 'placeholder', $field_name_placeholder );
		$this->add_render_attribute( 'field_name', 'required', '1' );
		$this->add_render_attribute( 'field_name', 'value', $field_name_value );
		$this->add_render_attribute( 'field_name_wrapper', 'class', 'tp-form-field-name' );
		if ( $settings['inline_name_email'] == 'yes' && in_array( $settings['show_email_phone'], ['email'] ) ) {
			$this->add_render_attribute( 'field_name_wrapper', 'class', 'tp-form-field-left' );
		}
		if ( $settings['inline_name_phone'] == 'yes' && in_array( $settings['show_email_phone'], ['phone'] ) ) {
			$this->add_render_attribute( 'field_name_wrapper', 'class', 'tp-form-field-left' );
		}

		if ( $show_email ) {
			$this->add_render_attribute( 'field_email_label', 'for', 'tp-form-email-'.$this->get_id() );
			$this->add_render_attribute( 'field_email_label', 'class', $labels_class );
			$this->add_render_attribute( 'field_email', 'type', 'email' );
			$this->add_render_attribute( 'field_email', 'name', 'tp-form-email' );
			$this->add_render_attribute( 'field_email', 'id', 'tp-form-email-'.$this->get_id() );
			$this->add_render_attribute( 'field_email', 'placeholder', $field_email_placeholder );
			$this->add_render_attribute( 'field_email', 'required', '1' );
			$this->add_render_attribute( 'field_email', 'value', $field_email_value );
			$this->add_render_attribute( 'field_email_wrapper', 'class', 'tp-form-field-email' );
			if ( $settings['inline_name_email'] == 'yes' && in_array( $settings['show_email_phone'], ['email'] ) ) {
				$this->add_render_attribute( 'field_email_wrapper', 'class', 'tp-form-field-right' );
			}
			if ( $settings['inline_email_phone'] == 'yes' && in_array( $settings['show_email_phone'], ['email_phone'] ) ) {
				$this->add_render_attribute( 'field_email_wrapper', 'class', 'tp-form-field-left' );
			}
			if ( $settings['inline_email_phone'] == 'yes' && in_array( $settings['show_email_phone'], ['phone_email'] ) ) {
				$this->add_render_attribute( 'field_email_wrapper', 'class', 'tp-form-field-right' );
			}
		}

		if ( $show_phone ) {
			$this->add_render_attribute( 'field_phone_label', 'for', 'tp-form-phone-'.$this->get_id() );
			$this->add_render_attribute( 'field_phone_label', 'class', $labels_class );
			$this->add_render_attribute( 'field_phone', 'type', 'text' );
			$this->add_render_attribute( 'field_phone', 'name', 'tp-form-phone' );
			$this->add_render_attribute( 'field_phone', 'id', 'tp-form-phone-'.$this->get_id() );
			$this->add_render_attribute( 'field_phone', 'placeholder', $field_phone_placeholder );
			$this->add_render_attribute( 'field_phone', 'required', '1' );
			$this->add_render_attribute( 'field_phone', 'value', $field_phone_value );
			$this->add_render_attribute( 'field_phone_wrapper', 'class', 'tp-form-field-phone' );
			if ( $settings['inline_name_phone'] == 'yes' && in_array( $settings['show_email_phone'], ['phone'] ) ) {
				$this->add_render_attribute( 'field_phone_wrapper', 'class', 'tp-form-field-right' );
			}
			if ( $settings['inline_email_phone'] == 'yes' && in_array( $settings['show_email_phone'], ['email_phone'] ) ) {
				$this->add_render_attribute( 'field_phone_wrapper', 'class', 'tp-form-field-right' );
			}
			if ( $settings['inline_email_phone'] == 'yes' && in_array( $settings['show_email_phone'], ['phone_email'] ) ) {
				$this->add_render_attribute( 'field_phone_wrapper', 'class', 'tp-form-field-left' );
			}
		}

		$this->add_render_attribute( 'field_message_label', 'for', 'tp-form-message-'.$this->get_id() );
		$this->add_render_attribute( 'field_message_label', 'class', $labels_class );
		$this->add_render_attribute( 'field_message', 'rows', '4' );
		$this->add_render_attribute( 'field_message', 'name', 'tp-form-message' );
		$this->add_render_attribute( 'field_message', 'id', 'tp-form-message-'.$this->get_id() );
		$this->add_render_attribute( 'field_message', 'placeholder', $field_message_placeholder );
		$this->add_render_attribute( 'field_message', 'required', '1' );
		$this->add_render_attribute( 'field_message_wrapper', 'class', 'tp-form-field-message' );

		$this->add_render_attribute( 'field_submit', 'class', 'tp-form-button' );
		$this->add_render_attribute( 'field_submit', 'type', 'submit' );
		$this->add_render_attribute( 'field_submit_wrapper', 'class', 'tp-form-field-submit' );

		if ( $settings['tracking_fbpixel'] == 'yes' ) {
			$tracking_fbpixel_track = 'track';
			$tracking_fbpixel_event = $settings['tracking_fbpixel_event'];
			if ( ! $tracking_fbpixel_event ) {
				$tracking_fbpixel_event = 'Lead';
			}
			if ( $tracking_fbpixel_event == 'custom' && ! empty( $settings['tracking_fbpixel_event_custom'] ) ) {
				$tracking_fbpixel_track = 'trackCustom';
				$tracking_fbpixel_event = trim( $settings['tracking_fbpixel_event_custom'] );
			}
			$tracking_fbpixel_params = [];
			$tracking_fbpixel_params['source'] = 'tokopress-elementor';
			$tracking_fbpixel_params['source_action'] = 'button-click';
			$tracking_fbpixel_params['source_position'] = 'tp-contact-form';
			$tracking_fbpixel_params['version'] = TOKOPRESS_ELEMENTOR_VERSION;
			$tracking_fbpixel_params['domain'] = str_replace( array('https://www.','http://www.','https://','http://'), '', home_url('/') );
			if ( ! empty( $settings['tracking_fbpixel_value'] ) ) {
				$tracking_fbpixel_params['value'] = number_format((float)$settings['tracking_fbpixel_currency'], 2, '.', '');
			}
			else {
				$tracking_fbpixel_params['value'] = 0.00;
			}
			if ( ! empty( $settings['tracking_fbpixel_currency'] ) ) {
				$tracking_fbpixel_params['currency'] = $settings['tracking_fbpixel_currency'];
			}
			else {
				$tracking_fbpixel_params['currency'] = self::get_default_currency();
			}
			if ( ! empty( $settings['tracking_fbpixel_advanced'] ) && ! empty( $settings['tracking_fbpixel_params'] ) ) {
				foreach ( $settings['tracking_fbpixel_params'] as $param ) {
					if ( ! empty( $param['name'] ) && ! empty( $param['value'] ) ) {
						$param_name = trim( $param['name'] );
						$param_value = trim( $param['value'] );
						$tracking_fbpixel_params[ $param_name ] = $param_value;
					}
				}
			}
			$this->add_render_attribute( 'field_submit', 'class', 'button-track-event' );
			$this->add_render_attribute( 'field_submit', 'data-fbtrack', $tracking_fbpixel_track );
			$this->add_render_attribute( 'field_submit', 'data-fbevent', $tracking_fbpixel_event );
			$this->add_render_attribute( 'field_submit', 'data-fbparams', json_encode( $tracking_fbpixel_params ) );
		}

		if ( $settings['tracking_gtag'] == 'yes' && ! empty( $settings['tracking_gtag_send_to'] ) ) {
			$tracking_gtag_track = 'event';
			$tracking_gtag_event = 'conversion';
			$tracking_gtag_params = [];
			$tracking_gtag_params['send_to'] = trim( $settings['tracking_gtag_send_to'] );
			if ( ! empty( $settings['tracking_gtag_params'] ) ) {
				if ( ! empty( $settings['tracking_gtag_value'] ) ) {
					$tracking_gtag_params['value'] = number_format((float)$settings['tracking_gtag_currency'], 2, '.', '');
				}
				else {
					$tracking_gtag_params['value'] = 0.00;
				}
				if ( ! empty( $settings['tracking_gtag_currency'] ) ) {
					$tracking_gtag_params['currency'] = $settings['tracking_gtag_currency'];
				}
				else {
					$tracking_gtag_params['currency'] = self::get_default_currency();
				}
				if ( ! empty( $settings['tracking_gtag_transaction_id'] ) ) {
					$tracking_gtag_params['transaction_id'] = $settings['tracking_gtag_transaction_id'];
				}
			}
			$this->add_render_attribute( 'field_submit', 'class', 'button-track-event' );
			$this->add_render_attribute( 'field_submit', 'data-gttrack', $tracking_gtag_track );
			$this->add_render_attribute( 'field_submit', 'data-gtevent', $tracking_gtag_event );
			$this->add_render_attribute( 'field_submit', 'data-gtparams', json_encode( $tracking_gtag_params, JSON_UNESCAPED_SLASHES ) );
		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php if ( $form_success ) : ?>
				<div class="tp-form-alert tp-form-alert-success alert alert-success">
					<?php echo $form_email_success; ?>
				</div>
			<?php endif; ?>
			<?php if ( $form_invalid ) : ?>
				<div class="tp-form-alert tp-form-alert-error alert alert-danger">
					<?php echo $form_email_invalid; ?>
				</div>
			<?php endif; ?>
			<?php if ( $form_error ) : ?>
				<div class="tp-form-alert tp-form-alert-error alert alert-danger">
					<?php echo $form_email_error; ?>
				</div>
			<?php endif; ?>
			<form class="tp-form" method="post">
				<input type="hidden" name="tp-form-id" value="<?php echo $this->get_id() ?>" />
				<input type="hidden" name="tp-form-post-id" value="<?php echo get_the_ID() ?>" />
				<div class="tp-form-fields-wrapper">
					<div <?php echo $this->get_render_attribute_string( 'field_name_wrapper' ); ?>>
						<label <?php echo $this->get_render_attribute_string( 'field_name_label' ); ?>>
							<?php echo $field_name_label; ?>
						</label>
						<input <?php echo $this->get_render_attribute_string( 'field_name' ); ?>>
						<?php if ( $field_name_invalid_status ) : ?>
							<div class="tp-form-error"><?php echo $field_name_invalid; ?></div>
						<?php endif; ?>
					</div>
					<?php if ( in_array( $settings['show_email_phone'], [ 'email_phone', 'email' ] ) ) : ?>
					<div <?php echo $this->get_render_attribute_string( 'field_email_wrapper' ); ?>>
						<label <?php echo $this->get_render_attribute_string( 'field_email_label' ); ?>>
							<?php echo $field_email_label; ?>
						</label>
						<input <?php echo $this->get_render_attribute_string( 'field_email' ); ?>>
						<?php if ( $field_email_invalid_status ) : ?>
							<div class="tp-form-error"><?php echo $field_email_invalid; ?></div>
						<?php endif; ?>
					</div>
					<?php endif; ?>
					<?php if ( in_array( $settings['show_email_phone'], [ 'email_phone', 'phone_email', 'phone' ] ) ) : ?>
					<div <?php echo $this->get_render_attribute_string( 'field_phone_wrapper' ); ?>>
						<label <?php echo $this->get_render_attribute_string( 'field_phone_label' ); ?>>
							<?php echo $field_phone_label; ?>
						</label>
						<input <?php echo $this->get_render_attribute_string( 'field_phone' ); ?>>
						<?php if ( $field_phone_invalid_status ) : ?>
							<div class="tp-form-error"><?php echo $field_phone_invalid; ?></div>
						<?php endif; ?>
					</div>
					<?php endif; ?>
					<?php if ( in_array( $settings['show_email_phone'], [ 'phone_email' ] ) ) : ?>
					<div <?php echo $this->get_render_attribute_string( 'field_email_wrapper' ); ?>>
						<label <?php echo $this->get_render_attribute_string( 'field_email_label' ); ?>>
							<?php echo $field_email_label; ?>
						</label>
						<input <?php echo $this->get_render_attribute_string( 'field_email' ); ?>>
						<?php if ( $field_email_invalid_status ) : ?>
							<div class="tp-form-error"><?php echo $field_email_invalid; ?></div>
						<?php endif; ?>
					</div>
					<?php endif; ?>
					<div <?php echo $this->get_render_attribute_string( 'field_message_wrapper' ); ?>>
						<label <?php echo $this->get_render_attribute_string( 'field_message_label' ); ?>>
							<?php echo $field_message_label; ?>
						</label>
						<textarea <?php echo $this->get_render_attribute_string( 'field_message' ); ?>><?php echo $field_message_value; ?></textarea>
						<?php if ( $field_message_invalid_status ) : ?>
							<div class="tp-form-error"><?php echo $field_message_invalid; ?></div>
						<?php endif; ?>
					</div>
					<div class="tp-form-field-important">
						<label for="tp-form-important-<?php echo $this->get_id() ?>" class="<?php echo $labels_class; ?>">Important</label>
						<input type="text" name="tp-form-important" id="tp-form-important-<?php echo $this->get_id() ?>" class="" placeholder="Important">
					</div>
					<div class="tp-form-field-submit">
						<button <?php echo $this->get_render_attribute_string( 'field_submit' ); ?>>
							<?php echo $field_submit_text; ?>
						</button>
					</div>
				</div>
			</form>		
		</div>
		<?php 
	}
}
