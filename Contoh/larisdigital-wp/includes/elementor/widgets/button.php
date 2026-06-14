<?php
namespace ElementorTokoPress\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class TP_Button extends Widget_Base {

	public function get_name() {
		return 'tp_button';
	}

	public function get_title() {
		return __( 'TP - Button', 'larisdigital-wp' );
	}

	public function get_icon() {
		return 'eicon-button';
	}

	public function get_categories() {
		return [ 'tokopress' ];
	}

	public static function get_button_sizes() {
		return [
			'xs' => __( 'Extra Small', 'larisdigital-wp' ),
			'sm' => __( 'Small', 'larisdigital-wp' ),
			'md' => __( 'Medium', 'larisdigital-wp' ),
			'lg' => __( 'Large', 'larisdigital-wp' ),
			'xl' => __( 'Extra Large', 'larisdigital-wp' ),
		];
	}

	public static function get_button_link_to() {
		$link_to = [
			'url' => __( 'Custom URL', 'larisdigital-wp' ),
			'whatsapp' => __( 'WhatsApp', 'larisdigital-wp' ),
			'page' => __( 'Page', 'larisdigital-wp' ),
		];
		if ( class_exists('woocommerce') ) {
			$link_to['wc-product'] = __( 'WooCommerce - Product', 'larisdigital-wp' );
			$link_to['wc-atc'] = __( 'WooCommerce - AddToCart (Simple Product)', 'larisdigital-wp' );
		}
		return $link_to;
	}

	public static function get_pages() {
		$pages = array();
		$args = array(
			'post_type' => 'page',
			'posts_per_page' => '50',
			'orderby' => 'date',
			'order' => 'DESC',
		);
		$posts = get_posts( $args );
		if ( !empty($posts) ) {
			foreach ( $posts as $post ) {
				$pages[$post->ID] = $post->post_title.' (ID#'.$post->ID.')';
			}
		}
		return $pages;
	}

	public static function get_products() {
		$products = array();
		$args = array(
			'post_type' => 'product',
			'posts_per_page' => '50',
			'orderby' => 'date',
			'order' => 'DESC',
		);
		$posts = get_posts( $args );
		if ( !empty($posts) ) {
			foreach ( $posts as $post ) {
				$products[$post->ID] = $post->post_title.' (ID#'.$post->ID.')';
			}
		}
		return $products;
	}

	public static function get_products_simple() {
		$products = array();
		$args = array(
			'post_type' => 'product',
			'posts_per_page' => '50',
			'orderby' => 'date',
			'order' => 'DESC',
			'tax_query' => array(
				array(
					'taxonomy' => 'product_type',
					'field'    => 'slug',
					'terms'    => 'simple',
				),
			),
		);
		$posts = get_posts( $args );
		if ( !empty($posts) ) {
			foreach ( $posts as $post ) {
				$products[$post->ID] = $post->post_title.' (ID#'.$post->ID.')';
			}
		}
		return $products;
	}

	public static function get_default_currency() {
		if ( class_exists('woocommerce') ) {
			return get_woocommerce_currency();
		}
		return 'USD';
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_button_layout',
			[
				'label' => __( 'Layout', 'larisdigital-wp' ),
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => __( 'Alignment', 'larisdigital-wp' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' => __( 'Left', 'larisdigital-wp' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'larisdigital-wp' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'larisdigital-wp' ),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'larisdigital-wp' ),
						'icon' => 'eicon-text-align-justify',
					],
					'horizontal' => [
						'title' => __( 'Horizontal', 'larisdigital-wp' ),
						'icon' => 'eicon-columns',
					],
				],
				'prefix_class' => 'elementor%s-align-',
			]
		);

		$this->add_control(
			'size',
			[
				'label' => __( 'Size', 'larisdigital-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'sm',
				'options' => self::get_button_sizes(),
			]
		);

		$this->add_control(
			'sticky_button',
			[
				'label' => __( 'Sticky', 'larisdigital-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'larisdigital-wp' ),
				'label_off' => __( 'No', 'larisdigital-wp' ),
				'return_value' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_button_primary',
			[
				'label' => __( 'Primary Button', 'larisdigital-wp' ),
			]
		);

		$this->add_control(
			'primary_text',
			[
				'label' => __( 'Text', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => __( 'Primary Button', 'larisdigital-wp' ),
				'placeholder' => __( 'Primary Button', 'larisdigital-wp' ),
			]
		);

		$this->add_control(
			'primary_link_to',
			[
				'label' => __( 'Link To', 'larisdigital-wp' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'options' => self::get_button_link_to(),
				'default' => 'url',
			]
		);

		$this->add_control(
			'primary_link',
			[
				'label' => __( 'Custom URL', 'larisdigital-wp' ),
				'type' => Controls_Manager::URL,
				'label_block' => true,
				'placeholder' => 'http://your-link.com',
				'condition' => [
					'primary_link_to' => 'url',
				],
			]
		);

		$this->add_control(
			'primary_whatsapp',
			[
				'label' => __( 'WhatsApp Number', 'larisdigital-wp' ),
				'type' => Controls_Manager::URL,
				'label_block' => true,
				'placeholder' => 'Example: 0812345678',
				'default' => [
					'is_external' => '',
					'nofollow' => 'on',
				],
				'condition' => [
					'primary_link_to' => 'whatsapp',
				],
			]
		);

		$this->add_control(
			'primary_whatsapp_message',
			[
				'label' => __( 'WhatsApp Message / Greeting Text', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'condition' => [
					'primary_link_to' => 'whatsapp',
				],
			]
		);

		$this->add_control(
			'primary_page',
			[
				'label' => __( 'Select Page (Last 50)', 'larisdigital-wp' ),
				'type' => Controls_Manager::SELECT2,
				'options' => self::get_pages(),
				'label_block' => true,
				'condition' => [
					'primary_link_to' => 'page',
				],
			]
		);

		if ( class_exists('woocommerce') ) {
			$this->add_control(
				'primary_wc_product',
				[
					'label' => __( 'Select Product (Last 50)', 'larisdigital-wp' ),
					'type' => Controls_Manager::SELECT2,
					'options' => self::get_products(),
					'label_block' => true,
					'condition' => [
						'primary_link_to' => 'wc-product',
					],
				]
			);

			$this->add_control(
				'primary_wc_atc',
				[
					'label' => __( 'Select Product (Last 50)', 'larisdigital-wp' ),
					'type' => Controls_Manager::SELECT2,
					'options' => self::get_products_simple(),
					'label_block' => true,
					'condition' => [
						'primary_link_to' => 'wc-atc',
					],
				]
			);
		}

		$this->add_control(
			'primary_icon5',
			[
				'label' => __( 'Icon', 'larisdigital-wp' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'primary_icon',
				'label_block' => true,
			]
		);

		$this->add_control(
			'primary_icon_align',
			[
				'label' => __( 'Icon Position', 'larisdigital-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left' => __( 'Before', 'larisdigital-wp' ),
					'right' => __( 'After', 'larisdigital-wp' ),
				],
				'condition' => [
					'primary_icon5[value]!' => '',
				],
			]
		);

		$this->add_control(
			'primary_icon_indent',
			[
				'label' => __( 'Icon Spacing', 'larisdigital-wp' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					'primary_icon5[value]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .tp-button-primary .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tp-button-primary .elementor-align-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'primary_icon_rotate',
			[
				'label' => __( 'Rotate Icon', 'larisdigital-wp' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'deg' ],
				'default' => [
					'size' => 0,
					'unit' => 'deg',
				],
				'condition' => [
					'primary_icon5[value]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .tp-button-primary i, {{WRAPPER}} .tp-button-primary svg' => 'transform: rotate({{SIZE}}{{UNIT}});',
					'{{WRAPPER}} .tp-button-primary svg' => 'width: 1em;',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_primary_tracking' );

		$this->start_controls_tab(
			'tab_primary_fbpixel',
			[
				'label' => __( 'FB Pixel', 'larisdigital-wp' ),
			]
		);

		$this->add_control(
			'primary_fbpixel',
			[
				'label' => __( 'Onclick Facebook Pixel', 'larisdigital-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'larisdigital-wp' ),
				'label_off' => __( 'No', 'larisdigital-wp' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'primary_fbpixel_event',
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
					'primary_fbpixel!' => '',
				],
			]
		);

		$this->add_control(
			'primary_fbpixel_event_custom',
			[
				'label' => __( 'FB Pixel Custom Event', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'condition' => [
					'primary_fbpixel!' => '',
					'primary_fbpixel_event' => 'custom',
				],
			]
		);

		$this->add_control(
			'primary_fbpixel_value',
			[
				'label' => __( 'value', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => '0.00',
				'condition' => [
					'primary_fbpixel!' => '',
					'primary_fbpixel_event!' => '',
				],
			]
		);

		$this->add_control(
			'primary_fbpixel_currency',
			[
				'label' => __( 'currency', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => self::get_default_currency(),
				'condition' => [
					'primary_fbpixel!' => '',
					'primary_fbpixel_event!' => '',
				],
			]
		);

		$this->add_control(
			'primary_fbpixel_advanced',
			[
				'label' => __( 'Add custom parameters', 'larisdigital-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'larisdigital-wp' ),
				'label_off' => __( 'No', 'larisdigital-wp' ),
				'return_value' => 'yes',
				'condition' => [
					'primary_fbpixel!' => '',
					'primary_fbpixel_event!' => '',
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
			'primary_fbpixel_params',
			[
				'label' => '',
				'type' => Controls_Manager::REPEATER,
				'show_label' => false,
				'prevent_empty' => false,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ name }}}',
				'condition' => [
					'primary_fbpixel!' => '',
					'primary_fbpixel_event!' => '',
					'primary_fbpixel_advanced!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_primary_gtag',
			[
				'label' => __( 'AdWords', 'larisdigital-wp' ),
			]
		);

		$this->add_control(
			'primary_gtag',
			[
				'label' => __( 'Onclick Conversion', 'larisdigital-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'larisdigital-wp' ),
				'label_off' => __( 'No', 'larisdigital-wp' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'primary_gtag_send_to',
			[
				'label' => __( 'send_to (required)', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => '',
				'label_block' => true,
				'condition' => [
					'primary_gtag!' => '',
				],
			]
		);

		$this->add_control(
			'primary_gtag_params',
			[
				'label' => __( 'Add additional parameters', 'larisdigital-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'larisdigital-wp' ),
				'label_off' => __( 'No', 'larisdigital-wp' ),
				'return_value' => 'yes',
				'condition' => [
					'primary_gtag!' => '',
				],
			]
		);

		$this->add_control(
			'primary_gtag_value',
			[
				'label' => __( 'value', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => '0.00',
				'condition' => [
					'primary_gtag!' => '',
					'primary_gtag_params!' => '',
				],
			]
		);

		$this->add_control(
			'primary_gtag_currency',
			[
				'label' => __( 'currency', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => self::get_default_currency(),
				'condition' => [
					'primary_gtag!' => '',
					'primary_gtag_params!' => '',
				],
			]
		);

		$this->add_control(
			'primary_gtag_transaction_id',
			[
				'label' => __( 'transaction_id', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => '',
				'condition' => [
					'primary_gtag!' => '',
					'primary_gtag_params!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'larisdigital-wp' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_button_secondary',
			[
				'label' => __( 'Secondary Button', 'larisdigital-wp' ),
			]
		);

		$this->add_control(
			'secondary_show',
			[
				'label' => __( 'Secondary Button', 'larisdigital-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'larisdigital-wp' ),
				'label_off' => __( 'Hide', 'larisdigital-wp' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'separator' => 'none',
			]
		);

		$this->add_control(
			'secondary_text',
			[
				'label' => __( 'Text', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => __( 'Secondary Button', 'larisdigital-wp' ),
				'placeholder' => __( 'Secondary Button', 'larisdigital-wp' ),
			]
		);

		$this->add_control(
			'secondary_link_to',
			[
				'label' => __( 'Link To', 'larisdigital-wp' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'options' => self::get_button_link_to(),
				'default' => 'url',
			]
		);

		$this->add_control(
			'secondary_link',
			[
				'label' => __( 'Custom URL', 'larisdigital-wp' ),
				'type' => Controls_Manager::URL,
				'label_block' => true,
				'placeholder' => 'http://your-link.com',
				'condition' => [
					'secondary_link_to' => 'url',
				],
			]
		);

		$this->add_control(
			'secondary_whatsapp',
			[
				'label' => __( 'WhatsApp Number', 'larisdigital-wp' ),
				'type' => Controls_Manager::URL,
				'label_block' => true,
				'placeholder' => 'Example: 0812345678',
				'default' => [
					'is_external' => '',
					'nofollow' => 'on',
				],
				'condition' => [
					'secondary_link_to' => 'whatsapp',
				],
			]
		);

		$this->add_control(
			'secondary_whatsapp_message',
			[
				'label' => __( 'WhatsApp Message / Greeting Text', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'condition' => [
					'secondary_link_to' => 'whatsapp',
				],
			]
		);

		$this->add_control(
			'secondary_page',
			[
				'label' => __( 'Select Page', 'larisdigital-wp' ),
				'type' => Controls_Manager::SELECT2,
				'options' => self::get_pages(),
				'label_block' => true,
				'condition' => [
					'secondary_link_to' => 'page',
				],
			]
		);

		if ( class_exists('woocommerce') ) {
			$this->add_control(
				'secondary_wc_product',
				[
					'label' => __( 'Select Product', 'larisdigital-wp' ),
					'type' => Controls_Manager::SELECT2,
					'options' => self::get_products(),
					'label_block' => true,
					'condition' => [
						'secondary_link_to' => 'wc-product',
					],
				]
			);

			$this->add_control(
				'secondary_wc_atc',
				[
					'label' => __( 'Select Product', 'larisdigital-wp' ),
					'type' => Controls_Manager::SELECT2,
					'options' => self::get_products_simple(),
					'label_block' => true,
					'condition' => [
						'secondary_link_to' => 'wc-atc',
					],
				]
			);
		}

		$this->add_control(
			'secondary_icon5',
			[
				'label' => __( 'Icon', 'larisdigital-wp' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'secondary_icon',
				'label_block' => true,
			]
		);

		$this->add_control(
			'secondary_icon_align',
			[
				'label' => __( 'Icon Position', 'larisdigital-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left' => __( 'Before', 'larisdigital-wp' ),
					'right' => __( 'After', 'larisdigital-wp' ),
				],
				'condition' => [
					'secondary_icon5[value]!' => '',
				],
			]
		);

		$this->add_control(
			'secondary_icon_indent',
			[
				'label' => __( 'Icon Spacing', 'larisdigital-wp' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					'secondary_icon5[value]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .tp-button-secondary .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tp-button-secondary .elementor-align-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'secondary_icon_rotate',
			[
				'label' => __( 'Rotate Icon', 'larisdigital-wp' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'deg' ],
				'default' => [
					'size' => 0,
					'unit' => 'deg',
				],
				'condition' => [
					'secondary_icon5[value]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .tp-button-secondary i, {{WRAPPER}} .tp-button-secondary svg' => 'transform: rotate({{SIZE}}{{UNIT}});',
					'{{WRAPPER}} .tp-button-secondary svg' => 'width: 1em;',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_secondary_tracking' );

		$this->start_controls_tab(
			'tab_secondary_fbpixel',
			[
				'label' => __( 'FB Pixel', 'larisdigital-wp' ),
			]
		);

		$this->add_control(
			'secondary_fbpixel',
			[
				'label' => __( 'Onclick Facebook Pixel', 'larisdigital-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'larisdigital-wp' ),
				'label_off' => __( 'No', 'larisdigital-wp' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'secondary_fbpixel_event',
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
					'secondary_fbpixel!' => '',
				],
			]
		);

		$this->add_control(
			'secondary_fbpixel_event_custom',
			[
				'label' => __( 'FB Pixel Custom Event', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'condition' => [
					'secondary_fbpixel!' => '',
					'secondary_fbpixel_event' => 'custom',
				],
			]
		);

		$this->add_control(
			'secondary_fbpixel_value',
			[
				'label' => __( 'value', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => '0.00',
				'condition' => [
					'secondary_fbpixel!' => '',
					'secondary_fbpixel_event!' => '',
				],
			]
		);

		$this->add_control(
			'secondary_fbpixel_currency',
			[
				'label' => __( 'currency', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => self::get_default_currency(),
				'condition' => [
					'secondary_fbpixel!' => '',
					'secondary_fbpixel_event!' => '',
				],
			]
		);

		$this->add_control(
			'secondary_fbpixel_advanced',
			[
				'label' => __( 'Add custom parameters', 'larisdigital-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'larisdigital-wp' ),
				'label_off' => __( 'No', 'larisdigital-wp' ),
				'return_value' => 'yes',
				'condition' => [
					'secondary_fbpixel!' => '',
					'secondary_fbpixel_event!' => '',
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
			'secondary_fbpixel_params',
			[
				'label' => '',
				'type' => Controls_Manager::REPEATER,
				'show_label' => false,
				'prevent_empty' => false,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ name }}}',
				'condition' => [
					'secondary_fbpixel!' => '',
					'secondary_fbpixel_event!' => '',
					'secondary_fbpixel_advanced!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_secondary_gtag',
			[
				'label' => __( 'AdWords', 'larisdigital-wp' ),
			]
		);

		$this->add_control(
			'secondary_gtag',
			[
				'label' => __( 'Onclick Conversion', 'larisdigital-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'larisdigital-wp' ),
				'label_off' => __( 'No', 'larisdigital-wp' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'secondary_gtag_send_to',
			[
				'label' => __( 'send_to (required)', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => '',
				'label_block' => true,
				'condition' => [
					'secondary_gtag!' => '',
				],
			]
		);

		$this->add_control(
			'secondary_gtag_params',
			[
				'label' => __( 'Add additional parameters', 'larisdigital-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'larisdigital-wp' ),
				'label_off' => __( 'No', 'larisdigital-wp' ),
				'return_value' => 'yes',
				'condition' => [
					'secondary_gtag!' => '',
				],
			]
		);

		$this->add_control(
			'secondary_gtag_value',
			[
				'label' => __( 'value', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => '0.00',
				'condition' => [
					'secondary_gtag!' => '',
					'secondary_gtag_params!' => '',
				],
			]
		);

		$this->add_control(
			'secondary_gtag_currency',
			[
				'label' => __( 'currency', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => self::get_default_currency(),
				'condition' => [
					'secondary_gtag!' => '',
					'secondary_gtag_params!' => '',
				],
			]
		);

		$this->add_control(
			'secondary_gtag_transaction_id',
			[
				'label' => __( 'transaction_id', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => '',
				'condition' => [
					'secondary_gtag!' => '',
					'secondary_gtag_params!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_sticky_style',
			[
				'label' => __( 'Sticky', 'larisdigital-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'sticky_button' => 'yes',
				],
			]
		);

		$this->add_control(
			'sticky_bg_color',
			[
				'label' => __( 'Background Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'sticky_button' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-button-sticky' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_primary_button_style',
			[
				'label' => __( 'Primary Button', 'larisdigital-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'primary_typography',
				'label' => __( 'Typography', 'larisdigital-wp' ),
				'selector' => '{{WRAPPER}} a.elementor-button.tp-button-primary',
			]
		);

		$this->start_controls_tabs( 'tabs_primary_button_style' );

		$this->start_controls_tab(
			'tab_primary_button_normal',
			[
				'label' => __( 'Normal', 'larisdigital-wp' ),
			]
		);

		$this->add_control(
			'primary_text_color',
			[
				'label' => __( 'Text Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.elementor-button.tp-button-primary' => 'color: {{VALUE}};',
					'{{WRAPPER}} a.elementor-button.tp-button-primary svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'primary_background_color',
			[
				'label' => __( 'Background Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.elementor-button.tp-button-primary' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_primary_button_hover',
			[
				'label' => __( 'Hover', 'larisdigital-wp' ),
			]
		);

		$this->add_control(
			'primary_hover_color',
			[
				'label' => __( 'Text Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.elementor-button.tp-button-primary:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} a.elementor-button.tp-button-primary:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'primary_background_hover_color',
			[
				'label' => __( 'Background Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.elementor-button.tp-button-primary:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'primary_hover_border_color',
			[
				'label' => __( 'Border Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'primary_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} a.elementor-button.tp-button-primary:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'primary_hover_animation',
			[
				'label' => __( 'Animation', 'larisdigital-wp' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'primary_border',
				'label' => __( 'Border', 'larisdigital-wp' ),
				'placeholder' => '1px',
				'default' => '1px',
				'selector' => '{{WRAPPER}} .elementor-button.tp-button-primary',
			]
		);

		$this->add_control(
			'primary_border_radius',
			[
				'label' => __( 'Border Radius', 'larisdigital-wp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} a.elementor-button.tp-button-primary' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'primary_button_box_shadow',
				'selector' => '{{WRAPPER}} .elementor-button.tp-button-primary',
			]
		);

		$this->add_control(
			'primary_text_padding',
			[
				'label' => __( 'Text Padding', 'larisdigital-wp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} a.elementor-button.tp-button-primary' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_secondary_button_style',
			[
				'label' => __( 'Secondary Button', 'larisdigital-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'secondary_typography',
				'label' => __( 'Typography', 'larisdigital-wp' ),
				'selector' => '{{WRAPPER}} a.elementor-button.tp-button-secondary',
			]
		);

		$this->start_controls_tabs( 'tabs_secondary_button_style' );

		$this->start_controls_tab(
			'tab_secondary_button_normal',
			[
				'label' => __( 'Normal', 'larisdigital-wp' ),
			]
		);

		$this->add_control(
			'secondary_text_color',
			[
				'label' => __( 'Text Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.elementor-button.tp-button-secondary' => 'color: {{VALUE}};',
					'{{WRAPPER}} a.elementor-button.tp-button-secondary svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'secondary_background_color',
			[
				'label' => __( 'Background Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.elementor-button.tp-button-secondary' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_secondary_button_hover',
			[
				'label' => __( 'Hover', 'larisdigital-wp' ),
			]
		);

		$this->add_control(
			'secondary_hover_color',
			[
				'label' => __( 'Text Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.elementor-button.tp-button-secondary:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} a.elementor-button.tp-button-secondary:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'secondary_background_hover_color',
			[
				'label' => __( 'Background Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.elementor-button.tp-button-secondary:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'secondary_hover_border_color',
			[
				'label' => __( 'Border Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'secondary_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} a.elementor-button.tp-button-secondary:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'secondary_hover_animation',
			[
				'label' => __( 'Animation', 'larisdigital-wp' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'secondary_border',
				'label' => __( 'Border', 'larisdigital-wp' ),
				'placeholder' => '1px',
				'default' => '1px',
				'selector' => '{{WRAPPER}} .elementor-button.tp-button-secondary',
			]
		);

		$this->add_control(
			'secondary_border_radius',
			[
				'label' => __( 'Border Radius', 'larisdigital-wp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} a.elementor-button.tp-button-secondary' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'secondary_button_box_shadow',
				'selector' => '{{WRAPPER}} .elementor-button.tp-button-secondary',
			]
		);

		$this->add_control(
			'secondary_text_padding',
			[
				'label' => __( 'Text Padding', 'larisdigital-wp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} a.elementor-button.tp-button-secondary' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings();

		$this->add_render_attribute( 'wrapper', 'class', 'elementor-button-wrapper' );

		if ( $settings['sticky_button'] == 'yes' ) {
			$this->add_render_attribute( 'wrapper', 'class', 'elementor-button-sticky' );
		}

		if ( $settings['secondary_show'] == 'yes' ) {
			$this->add_render_attribute( 'wrapper', 'class', 'elementor-button-double' );
		}
		else {
			$this->add_render_attribute( 'wrapper', 'class', 'elementor-button-single' );
		}

		$primary_button = [
			'url' => '#',
			'is_external' => '',
			'nofollow' => 'on',
		];
		if ( $settings['primary_link_to'] == 'whatsapp' ) {
			if ( ! empty( $settings['primary_whatsapp']['url'] ) ) {
				$primary_button = $settings['primary_whatsapp'];
				$primary_button['url'] = preg_replace('/^8/','08', $primary_button['url']);
				$primary_button['url'] = preg_replace('/[^0-9]/', '', $primary_button['url']);
				$primary_button['url'] = preg_replace('/^620/','62', $primary_button['url']);
				$primary_button['url'] = preg_replace('/^0/','62', $primary_button['url']);
				$primary_button['url'] = 'https://api.whatsapp.com/send?phone='.$primary_button['url'];
				if ( ! empty( $settings['primary_whatsapp_message'] ) ) {
					$primary_button['url'] .= '&text='.rawurlencode($settings['primary_whatsapp_message']);
				}
			}
		}
		elseif ( $settings['primary_link_to'] == 'page' ) {
			if ( ! empty( $settings['primary_page'] ) ) {
				$primary_button['url'] = get_permalink( $settings['primary_page'] );
				if ( ! empty( $primary_button['url'] ) ) {
					$primary_button['nofollow'] = '';
				}
			}
		}
		elseif ( $settings['primary_link_to'] == 'wc-product' ) {
			if ( class_exists('woocommerce') ) {
				if ( ! empty( $settings['primary_wc_product'] ) ) {
					$primary_button['url'] = get_permalink( $settings['primary_wc_product'] );
					if ( ! empty( $primary_button['url'] ) ) {
						$primary_button['nofollow'] = '';
					}
				}
			}
		}
		elseif ( $settings['primary_link_to'] == 'wc-atc' ) {
			if ( class_exists('woocommerce') ) {
				if ( ! empty( $settings['primary_wc_atc'] ) ) {
					$primary_button['url'] = add_query_arg( 'add-to-cart', $settings['primary_wc_atc'], wc_get_page_permalink( 'cart' ) );
				}
			}
		}
		else {
			if ( ! empty( $settings['primary_link']['url'] ) ) {
				$primary_button = $settings['primary_link'];
				$primary_button['url'] = esc_url( $primary_button['url'] );
			}
		}
		$this->add_render_attribute( 'primary-button', 'href', $primary_button['url'] );
		$this->add_render_attribute( 'primary-button', 'class', 'elementor-button-link' );
		if ( ! empty( $primary_button['is_external'] ) ) {
			$this->add_render_attribute( 'primary-button', 'target', '_blank' );
		}
		if ( ! empty( $primary_button['nofollow'] ) ) {
			$this->add_render_attribute( 'primary-button', 'rel', 'nofollow' );
		}

		$this->add_render_attribute( 'primary-button', 'class', 'elementor-button' );
		$this->add_render_attribute( 'primary-button', 'class', 'tp-button-primary' );

		if ( ! empty( $settings['size'] ) ) {
			$this->add_render_attribute( 'primary-button', 'class', 'elementor-size-' . $settings['size'] );
		}

		if ( $settings['primary_hover_animation'] ) {
			$this->add_render_attribute( 'primary-button', 'class', 'elementor-animation-' . $settings['primary_hover_animation'] );
		}

		$this->add_render_attribute( 'primary-content-wrapper', 'class', 'elementor-button-content-wrapper' );
		$this->add_render_attribute( 'primary-icon-align', 'class', 'elementor-align-icon-' . $settings['primary_icon_align'] );
		$this->add_render_attribute( 'primary-icon-align', 'class', 'elementor-button-icon' );

		if ( $settings['primary_fbpixel'] == 'yes' ) {
			$primary_fbpixel_track = 'track';
			$primary_fbpixel_event = $settings['primary_fbpixel_event'];
			if ( ! $primary_fbpixel_event ) {
				$primary_fbpixel_event = 'Lead';
			}
			if ( $primary_fbpixel_event == 'custom' && ! empty( $settings['primary_fbpixel_event_custom'] ) ) {
				$primary_fbpixel_track = 'trackCustom';
				$primary_fbpixel_event = trim( $settings['primary_fbpixel_event_custom'] );
			}
			$primary_fbpixel_params = [];
			$primary_fbpixel_params['source'] = 'tokopress-elementor';
			$primary_fbpixel_params['source_action'] = 'button-click';
			$primary_fbpixel_params['source_position'] = 'tp-button-primary';
			$primary_fbpixel_params['version'] = TOKOPRESS_ELEMENTOR_VERSION;
			$primary_fbpixel_params['domain'] = str_replace( array('https://www.','http://www.','https://','http://'), '', home_url('/') );
			if ( ! empty( $settings['primary_fbpixel_value'] ) ) {
				$primary_fbpixel_params['value'] = number_format((float)$settings['primary_fbpixel_value'], 2, '.', '');
			}
			else {
				$primary_fbpixel_params['value'] = 0.00;
			}
			if ( ! empty( $settings['primary_fbpixel_currency'] ) ) {
				$primary_fbpixel_params['currency'] = $settings['primary_fbpixel_currency'];
			}
			else {
				$primary_fbpixel_params['currency'] = self::get_default_currency();
			}
			if ( ! empty( $settings['primary_fbpixel_advanced'] ) && ! empty( $settings['primary_fbpixel_params'] ) ) {
				foreach ( $settings['primary_fbpixel_params'] as $param ) {
					if ( ! empty( $param['name'] ) && ! empty( $param['value'] ) ) {
						$param_name = trim( $param['name'] );
						$param_value = trim( $param['value'] );
						$primary_fbpixel_params[ $param_name ] = $param_value;
					}
				}
			}
			$this->add_render_attribute( 'primary-button', 'class', 'button-track-event' );
			$this->add_render_attribute( 'primary-button', 'data-fbtrack', $primary_fbpixel_track );
			$this->add_render_attribute( 'primary-button', 'data-fbevent', $primary_fbpixel_event );
			$this->add_render_attribute( 'primary-button', 'data-fbparams', json_encode( $primary_fbpixel_params ) );
		}

		if ( $settings['primary_gtag'] == 'yes' && ! empty( $settings['primary_gtag_send_to'] ) ) {
			$primary_gtag_track = 'event';
			$primary_gtag_event = 'conversion';
			$primary_gtag_params = [];
			$primary_gtag_params['send_to'] = trim( $settings['primary_gtag_send_to'] );
			if ( ! empty( $settings['primary_gtag_params'] ) ) {
				if ( ! empty( $settings['primary_gtag_value'] ) ) {
					$primary_gtag_params['value'] = number_format((float)$settings['primary_gtag_currency'], 2, '.', '');
				}
				else {
					$primary_gtag_params['value'] = 0.00;
				}
				if ( ! empty( $settings['primary_gtag_currency'] ) ) {
					$primary_gtag_params['currency'] = $settings['primary_gtag_currency'];
				}
				else {
					$primary_gtag_params['currency'] = self::get_default_currency();
				}
				if ( ! empty( $settings['primary_gtag_transaction_id'] ) ) {
					$primary_gtag_params['transaction_id'] = $settings['primary_gtag_transaction_id'];
				}
			}
			$this->add_render_attribute( 'primary-button', 'class', 'button-track-event' );
			$this->add_render_attribute( 'primary-button', 'data-gttrack', $primary_gtag_track );
			$this->add_render_attribute( 'primary-button', 'data-gtevent', $primary_gtag_event );
			$this->add_render_attribute( 'primary-button', 'data-gtparams', json_encode( $primary_gtag_params, JSON_UNESCAPED_SLASHES ) );
		}

		if ( $settings['secondary_show'] == 'yes' ) {

			$secondary_button = [
				'url' => '#',
				'is_external' => '',
				'nofollow' => 'on',
			];
			if ( $settings['secondary_link_to'] == 'whatsapp' ) {
				if ( ! empty( $settings['secondary_whatsapp']['url'] ) ) {
					$secondary_button = $settings['secondary_whatsapp'];
					$secondary_button['url'] = preg_replace('/^8/','08', $secondary_button['url']);
					$secondary_button['url'] = preg_replace('/[^0-9]/', '', $secondary_button['url']);
					$secondary_button['url'] = preg_replace('/^620/','62', $secondary_button['url']);
					$secondary_button['url'] = preg_replace('/^0/','62', $secondary_button['url']);
					$secondary_button['url'] = 'https://api.whatsapp.com/send?phone='.$secondary_button['url'];
					if ( ! empty( $settings['secondary_whatsapp_message'] ) ) {
						$secondary_button['url'] .= '&text='.rawurlencode($settings['secondary_whatsapp_message']);
					}
				}
			}
			elseif ( $settings['secondary_link_to'] == 'page' ) {
				if ( ! empty( $settings['secondary_page'] ) ) {
					$secondary_button['url'] = get_permalink( $settings['secondary_page'] );
					if ( ! empty( $secondary_button['url'] ) ) {
						$secondary_button['nofollow'] = '';
					}
				}
			}
			elseif ( $settings['secondary_link_to'] == 'wc-product' ) {
				if ( class_exists('woocommerce') ) {
					if ( ! empty( $settings['secondary_wc_product'] ) ) {
						$secondary_button['url'] = get_permalink( $settings['secondary_wc_product'] );
						if ( ! empty( $secondary_button['url'] ) ) {
							$secondary_button['nofollow'] = '';
						}
					}
				}
			}
			elseif ( $settings['secondary_link_to'] == 'wc-atc' ) {
				if ( class_exists('woocommerce') ) {
					if ( ! empty( $settings['secondary_wc_atc'] ) ) {
						$secondary_button['url'] = add_query_arg( 'add-to-cart', $settings['secondary_wc_atc'], wc_get_page_permalink( 'cart' ) );
					}
				}
			}
			else {
				if ( ! empty( $settings['secondary_link']['url'] ) ) {
					$secondary_button = $settings['secondary_link'];
					$secondary_button['url'] = esc_url( $secondary_button['url'] );
				}
			}
			$this->add_render_attribute( 'secondary-button', 'href', $secondary_button['url'] );
			$this->add_render_attribute( 'secondary-button', 'class', 'elementor-button-link' );
			if ( ! empty( $secondary_button['is_external'] ) ) {
				$this->add_render_attribute( 'secondary-button', 'target', '_blank' );
			}
			if ( ! empty( $secondary_button['nofollow'] ) ) {
				$this->add_render_attribute( 'secondary-button', 'rel', 'nofollow' );
			}

			$this->add_render_attribute( 'secondary-button', 'class', 'elementor-button' );
			$this->add_render_attribute( 'secondary-button', 'class', 'tp-button-secondary' );

			if ( ! empty( $settings['size'] ) ) {
				$this->add_render_attribute( 'secondary-button', 'class', 'elementor-size-' . $settings['size'] );
			}

			if ( $settings['secondary_hover_animation'] ) {
				$this->add_render_attribute( 'secondary-button', 'class', 'elementor-animation-' . $settings['secondary_hover_animation'] );
			}

			$this->add_render_attribute( 'secondary-content-wrapper', 'class', 'elementor-button-content-wrapper' );
			$this->add_render_attribute( 'secondary-icon-align', 'class', 'elementor-align-icon-' . $settings['secondary_icon_align'] );
			$this->add_render_attribute( 'secondary-icon-align', 'class', 'elementor-button-icon' );

			if ( $settings['secondary_fbpixel'] == 'yes' ) {
				$secondary_fbpixel_track = 'track';
				$secondary_fbpixel_event = $settings['secondary_fbpixel_event'];
				if ( ! $secondary_fbpixel_event ) {
					$secondary_fbpixel_event = 'Lead';
				}
				if ( $secondary_fbpixel_event == 'custom' && ! empty( $settings['secondary_fbpixel_event_custom'] ) ) {
					$secondary_fbpixel_track = 'trackCustom';
					$secondary_fbpixel_event = trim( $settings['secondary_fbpixel_event_custom'] );
				}
				$secondary_fbpixel_params = [];
				$secondary_fbpixel_params['source'] = 'tokopress-elementor';
				$secondary_fbpixel_params['source_action'] = 'button-click';
				$secondary_fbpixel_params['source_position'] = 'tp-button-secondary';
				$secondary_fbpixel_params['version'] = TOKOPRESS_ELEMENTOR_VERSION;
				$secondary_fbpixel_params['domain'] = str_replace( array('https://www.','http://www.','https://','http://'), '', home_url('/') );
				if ( ! empty( $settings['secondary_fbpixel_value'] ) ) {
					$secondary_fbpixel_params['value'] = number_format((float)$settings['secondary_fbpixel_value'], 2, '.', '');
				}
				else {
					$secondary_fbpixel_params['value'] = 0.00;
				}
				if ( ! empty( $settings['secondary_fbpixel_currency'] ) ) {
					$secondary_fbpixel_params['currency'] = $settings['secondary_fbpixel_currency'];
				}
				else {
					$secondary_fbpixel_params['currency'] = self::get_default_currency();
				}
				if ( ! empty( $settings['secondary_fbpixel_advanced'] ) && ! empty( $settings['secondary_fbpixel_params'] ) ) {
					foreach ( $settings['secondary_fbpixel_params'] as $param ) {
						if ( ! empty( $param['name'] ) && ! empty( $param['value'] ) ) {
							$param_name = trim( $param['name'] );
							$param_value = trim( $param['value'] );
							$secondary_fbpixel_params[ $param_name ] = $param_value;
						}
					}
				}
				$this->add_render_attribute( 'secondary-button', 'class', 'button-track-event' );
				$this->add_render_attribute( 'secondary-button', 'data-fbtrack', $secondary_fbpixel_track );
				$this->add_render_attribute( 'secondary-button', 'data-fbevent', $secondary_fbpixel_event );
				$this->add_render_attribute( 'secondary-button', 'data-fbparams', json_encode( $secondary_fbpixel_params ) );
			}

			if ( $settings['secondary_gtag'] == 'yes' && ! empty( $settings['secondary_gtag_send_to'] ) ) {
				$secondary_gtag_track = 'event';
				$secondary_gtag_event = 'conversion';
				$secondary_gtag_params = [];
				$secondary_gtag_params['send_to'] = trim( $settings['secondary_gtag_send_to'] );
				if ( ! empty( $settings['secondary_gtag_params'] ) ) {
					if ( ! empty( $settings['secondary_gtag_value'] ) ) {
						$secondary_gtag_params['value'] = number_format((float)$settings['secondary_gtag_currency'], 2, '.', '');
					}
					else {
						$secondary_gtag_params['value'] = 0.00;
					}
					if ( ! empty( $settings['secondary_gtag_currency'] ) ) {
						$secondary_gtag_params['currency'] = $settings['secondary_gtag_currency'];
					}
					else {
						$secondary_gtag_params['currency'] = self::get_default_currency();
					}
					if ( ! empty( $settings['secondary_gtag_transaction_id'] ) ) {
						$secondary_gtag_params['transaction_id'] = $settings['secondary_gtag_transaction_id'];
					}
				}
				$this->add_render_attribute( 'secondary-button', 'class', 'button-track-event' );
				$this->add_render_attribute( 'secondary-button', 'data-gttrack', $secondary_gtag_track );
				$this->add_render_attribute( 'secondary-button', 'data-gtevent', $secondary_gtag_event );
				$this->add_render_attribute( 'secondary-button', 'data-gtparams', json_encode( $secondary_gtag_params, JSON_UNESCAPED_SLASHES ) );
			}

		}

		$primary_icon_migrated = isset( $settings['__fa4_migrated']['primary_icon5'] );
		$primary_icon_is_new = empty( $settings['primary_icon'] ) && Icons_Manager::is_migration_allowed();
		$secondary_icon_migrated = isset( $settings['__fa4_migrated']['secondary_icon5'] );
		$secondary_icon_is_new = empty( $settings['secondary_icon'] ) && Icons_Manager::is_migration_allowed();
		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<a <?php echo $this->get_render_attribute_string( 'primary-button' ); ?>>
				<span <?php echo $this->get_render_attribute_string( 'primary-content-wrapper' ); ?>>
					<?php if ( ! empty( $settings['primary_icon'] ) || ! empty( $settings['primary_icon5']['value'] ) ) : ?>
					<span <?php echo $this->get_render_attribute_string( 'primary-icon-align' ); ?>>
						<?php if ( $primary_icon_is_new || $primary_icon_migrated ) : ?>
							<?php Icons_Manager::render_icon( $settings['primary_icon5'], [ 'aria-hidden' => 'true' ] ); ?>
						<?php else : ?>
							<i class="<?php echo esc_attr( $settings['primary_icon'] ); ?>" aria-hidden="true"></i>
						<?php endif; ?>
					</span>
					<?php endif; ?>
					<span class="elementor-button-text"><?php echo $settings['primary_text']; ?></span>
				</span>
			</a>
			<?php if ( $settings['secondary_show'] == 'yes' ) : ?>
			<a <?php echo $this->get_render_attribute_string( 'secondary-button' ); ?>>
				<span <?php echo $this->get_render_attribute_string( 'secondary-content-wrapper' ); ?>>
					<?php if ( ! empty( $settings['secondary_icon'] ) || ! empty( $settings['secondary_icon5']['value'] ) ) : ?>
					<span <?php echo $this->get_render_attribute_string( 'secondary-icon-align' ); ?>>
						<?php if ( $secondary_icon_is_new || $secondary_icon_migrated ) : ?>
							<?php Icons_Manager::render_icon( $settings['secondary_icon5'], [ 'aria-hidden' => 'true' ] ); ?>
						<?php else : ?>
							<i class="<?php echo esc_attr( $settings['secondary_icon'] ); ?>" aria-hidden="true"></i>
						<?php endif; ?>
					</span>
					<?php endif; ?>
					<span class="elementor-button-text"><?php echo $settings['secondary_text']; ?></span>
				</span>
			</a>
			<?php endif; ?>
		</div>
		<?php
	}
}
