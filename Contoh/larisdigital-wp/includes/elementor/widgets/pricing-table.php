<?php
namespace ElementorTokoPress\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Utils;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class TP_Pricing_Table extends Widget_Base {

	public function get_name() {
		return 'tp_pricing_table';
	}

	public function get_title() {
		return __( 'TP - Pricing Table', 'larisdigital-wp' );
	}

	public function get_icon() {
		return 'eicon-price-table';
	}

	public function get_categories() {
		return [ 'tokopress' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_table_pricing',
			[
				'label'	=> __( 'Pricing Table', 'larisdigital-wp' )
			]
		);

			$this->add_responsive_control(
				'columns',
				[
					'label' 			=> __( 'Columns', 'larisdigital-wp' ),
					'type' 				=> Controls_Manager::SELECT,
					'desktop_default' 	=> '4',
					'tablet_default' 	=> '2',
					'mobile_default' 	=> '1',
					'options' 			=> [
						'1' => '1',
						'2' => '2',
						'3' => '3',
						'4' => '4',
						'5' => '5',
						'6' => '6',
					],
				]
			);

			$repeater = new Repeater();

			$repeater->add_control(
				'title',
				[
					'label'			=> __( 'Title', 'larisdigital-wp' ),
					'type'			=> Controls_Manager::TEXT,
					'default'		=> 'Table Title',
					'placeholder'	=> __( 'Table Title', 'larisdigital-wp' ),
					'label_block'	=> true,
				]
			);

			$repeater->add_control(
				'currency_symbol',
				[
					'label'			=> __( 'Currency Symbol', 'larisdigital-wp' ),
					'type'			=> Controls_Manager::TEXT,
					'default'		=> '$',
					'placeholder'	=> __( 'Currency Symbol', 'larisdigital-wp' ),
				]
			);

			$repeater->add_control(
				'price',
				[
					'label'			=> __( 'Price', 'larisdigital-wp' ),
					'type'			=> Controls_Manager::TEXT,
					'default'		=> '35.99',
				]
			);

			$repeater->add_control(
				'plan_separator',
				[
					'label'			=> __( 'Separator', 'larisdigital-wp' ),
					'type'			=> Controls_Manager::TEXT,
					'default'		=> '/',
				]
			);

			$repeater->add_control(
				'plan_name',
				[
					'label'			=> __( 'Plan', 'larisdigital-wp' ),
					'type'			=> Controls_Manager::TEXT,
					'default'		=> __( 'Month', 'larisdigital-wp' ),
				]
			);

			$repeater->add_control(
				'feature_list_1',
				[
					'label'			=> __( 'Feature Name #1', 'larisdigital-wp' ),
					'type'			=> Controls_Manager::TEXT,
					'default'		=> __( '10 Videos To Upload', 'larisdigital-wp' ),
					'label_block'	=> true,
				]
			);

			$repeater->add_control(
				'feature_list_2',
				[
					'label'			=> __( 'Feature Name #2', 'larisdigital-wp' ),
					'type'			=> Controls_Manager::TEXT,
					'default'		=> __( '5 Contacts', 'larisdigital-wp' ),
					'label_block'	=> true,
				]
			);

			$repeater->add_control(
				'feature_list_3',
				[
					'label'			=> __( 'Feature Name #3', 'larisdigital-wp' ),
					'type'			=> Controls_Manager::TEXT,
					'default'		=> __( '15 Messages', 'larisdigital-wp' ),
					'label_block'	=> true,
				]
			);

			$repeater->add_control(
				'feature_list_4',
				[
					'label'			=> __( 'Feature Name #4', 'larisdigital-wp' ),
					'type'			=> Controls_Manager::TEXT,
					'default'		=> __( '14 Days Trial', 'larisdigital-wp' ),
					'label_block'	=> true,
				]
			);

			$repeater->add_control(
				'feature_list_5',
				[
					'label'			=> __( 'Feature Name #5', 'larisdigital-wp' ),
					'type'			=> Controls_Manager::TEXT,
					'label_block'	=> true,
				]
			);

			$repeater->add_control(
				'feature_list_6',
				[
					'label'			=> __( 'Feature Name #6', 'larisdigital-wp' ),
					'type'			=> Controls_Manager::TEXT,
					'label_block'	=> true,
				]
			);

			$repeater->add_control(
				'feature_list_7',
				[
					'label'			=> __( 'Feature Name #7', 'larisdigital-wp' ),
					'type'			=> Controls_Manager::TEXT,
					'label_block'	=> true,
				]
			);

			$repeater->add_control(
				'feature_list_8',
				[
					'label'			=> __( 'Feature Name #8', 'larisdigital-wp' ),
					'type'			=> Controls_Manager::TEXT,
					'label_block'	=> true,
				]
			);

			$repeater->add_control(
				'feature_list_9',
				[
					'label'			=> __( 'Feature Name #9', 'larisdigital-wp' ),
					'type'			=> Controls_Manager::TEXT,
					'label_block'	=> true,
				]
			);

			$repeater->add_control(
				'feature_list_10',
				[
					'label'			=> __( 'Feature Name #10', 'larisdigital-wp' ),
					'type'			=> Controls_Manager::TEXT,
					'label_block'	=> true,
				]
			);

			$repeater->add_control(
				'button_text',
				[
					'label'			=> __( 'Button Text', 'larisdigital-wp' ),
					'type'			=> Controls_Manager::TEXT,
					'default'		=> __( 'Get Started', 'larisdigital-wp' ),
				]
			);

			$repeater->add_control(
				'button_url',
				[
					'label'			=> __( 'Button URL', 'larisdigital-wp' ),
					'type'			=> Controls_Manager::URL,
					'placeholder'	=> __( 'http://your-link.com/', 'larisdigital-wp' ),
					'show_label'	=> true,
					'condition'		=> [
						'button_text!'	=> '',
					]
				]
			);

			$this->add_control(
				'pricing_tables',
				[
					'label'			=> __( 'Pricing Table', 'larisdigital-wp' ),
					'type'			=> Controls_Manager::REPEATER,
					'show_label'	=> true,
					'default'		=> [
						[
							'title'				=> __( 'Table Title', 'larisdigital-wp' ),
							'currency_symbol'	=> '$',
							'price'				=> '35.99',
							'plan_separator'	=> '/',
							'plan_name'			=> __( 'Month', 'larisdigital-wp' ),
							'feature_list_1'	=> __( '10 Videos To Upload', 'larisdigital-wp' ),
							'feature_list_2'	=> __( '5 Contacts', 'larisdigital-wp' ),
							'feature_list_3'	=> __( '15 Messages', 'larisdigital-wp' ),
							'feature_list_4'	=> __( '14 Days Trial', 'larisdigital-wp' ),
							'button_text'		=> __( 'Get Started', 'larisdigital-wp' ),
							'button_url'		=> '#',	
						],
						[
							'title'				=> __( 'Table Title', 'larisdigital-wp' ),
							'currency_symbol'	=> '$',
							'price'				=> '35.99',
							'plan_separator'	=> '/',
							'plan_name'			=> __( 'Month', 'larisdigital-wp' ),
							'feature_list_1'	=> __( '10 Videos To Upload', 'larisdigital-wp' ),
							'feature_list_2'	=> __( '5 Contacts', 'larisdigital-wp' ),
							'feature_list_3'	=> __( '15 Messages', 'larisdigital-wp' ),
							'feature_list_4'	=> __( '14 Days Trial', 'larisdigital-wp' ),
							'button_text'		=> __( 'Get Started', 'larisdigital-wp' ),
							'button_url'		=> '#',	
						],
						[
							'title'				=> __( 'Table Title', 'larisdigital-wp' ),
							'currency_symbol'	=> '$',
							'price'				=> '35.99',
							'plan_separator'	=> '/',
							'plan_name'			=> __( 'Month', 'larisdigital-wp' ),
							'feature_list_1'	=> __( '10 Videos To Upload', 'larisdigital-wp' ),
							'feature_list_2'	=> __( '5 Contacts', 'larisdigital-wp' ),
							'feature_list_3'	=> __( '15 Messages', 'larisdigital-wp' ),
							'feature_list_4'	=> __( '14 Days Trial', 'larisdigital-wp' ),
							'button_text'		=> __( 'Get Started', 'larisdigital-wp' ),
							'button_url'		=> '#',	
						],
						[
							'title'				=> __( 'Table Title', 'larisdigital-wp' ),
							'currency_symbol'	=> '$',
							'price'				=> '35.99',
							'plan_separator'	=> '/',
							'plan_name'			=> __( 'Month', 'larisdigital-wp' ),
							'feature_list_1'	=> __( '10 Videos To Upload', 'larisdigital-wp' ),
							'feature_list_2'	=> __( '5 Contacts', 'larisdigital-wp' ),
							'feature_list_3'	=> __( '15 Messages', 'larisdigital-wp' ),
							'feature_list_4'	=> __( '14 Days Trial', 'larisdigital-wp' ),
							'button_text'		=> __( 'Get Started', 'larisdigital-wp' ),
							'button_url'		=> '#',	
						],
					],
					'fields'			=> $repeater->get_controls(),
					'title_field'	=> '{{ title }}',
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_table_style',
			[
				'label'	=> __( 'Pricing Table', 'larisdigital-wp' ),
				'tab'	=> Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_responsive_control(
				'table_align',
				[
					'label' 	=> __( 'Alignment', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::CHOOSE,
					'default'	=> 'center',
					'options' 	=> [
						'left'		=> [
							'title'		=> __( 'Left', 'larisdigital-wp' ),
							'icon'		=> 'eicon-text-align-left',
						],
						'center'	=> [
							'title'		=> __( 'Center', 'larisdigital-wp' ),
							'icon'		=> 'eicon-text-align-center',
						],
						'right'		=> [
							'title'		=> __( 'Right', 'larisdigital-wp' ),
							'icon'		=> 'eicon-text-align-right',
						],
					],
					'selectors'	=> [
						'{{WRAPPER}} .tp-pricing-table'	=> 'text-align: {{VALUE}};',
					],
				]
			);

			$this->add_responsive_control(
				'item_padding',
				[
					'label' 		=> __( 'Padding', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px' ],
					'selectors' 	=> [
						'{{WRAPPER}} .tp-pricing-table .tp-pricing-item .tp-pricing-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'item_gap',
				[
					'label' 	=> __( 'Item Gap', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::SLIDER,
					'default'	=> [
						'size'	=> 10,
					],
					'range' 	=> [
						'px'	=> [
							'min'	=> 0,
							'max'	=> 100,
						],
					],
					'selectors'	=> [
						'{{WRAPPER}} .tp-pricing-table-wrapper' => 'margin: 0 -{{SIZE}}px',
						'(desktop){{WRAPPER}} .tp-pricing-table .tp-pricing-item' => 'width: calc( 100% / {{columns.SIZE}} ); padding: {{SIZE}}px',
						'(tablet){{WRAPPER}} .tp-pricing-table .tp-pricing-item' => 'width: calc( 100% / {{columns_tablet.SIZE}} ); padding: {{SIZE}}px',
						'(mobile){{WRAPPER}} .tp-pricing-table .tp-pricing-item' => 'width: calc( 100% / {{columns_mobile.SIZE}} ); padding: {{SIZE}}px',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'		=> 'table_border',
					'selector'	=> '{{WRAPPER}} .tp-pricing-table .tp-pricing-item .tp-pricing-inner',
				]
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'	=> 'table_box_shadow',
					'selector'	=> '{{WRAPPER}} .tp-pricing-table .tp-pricing-item .tp-pricing-inner',
				]
			);

			$this->add_control(
				'table_border_radius',
				[
					'label' => __( 'Border Radius', 'larisdigital-wp' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors' => [
						'{{WRAPPER}} .tp-pricing-table .tp-pricing-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .tp-pricing-table .tp-pricing-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} 0 0;',
					],
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_title_style',
			[
				'label'	=> __( 'Title', 'larisdigital-wp' ),
				'tab'	=> Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'title_background',
				[
					'label'		=> __( 'Background Color', 'larisdigital-wp' ),
					'type'		=> Controls_Manager::COLOR,
					'selectors'	=> [
						'{{WRAPPER}} .tp-pricing-title' => 'background-color: {{VALUE}};'
					]
				]
			);

			$this->add_responsive_control(
				'title_padding',
				[
					'label' 		=> __( 'Padding', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px' ],
					'default' 		=> [
						'top' 		=> 20,
						'right' 	=> 0,
						'bottom' 	=> 20,
						'left' 		=> 0,
						'unit' 		=> 'px',
					],
					'selectors' 	=> [
						'{{WRAPPER}} .tp-pricing-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'title_color',
				[
					'label'		=> __( 'Text Color', 'larisdigital-wp' ),
					'type'		=> Controls_Manager::COLOR,
					'selectors'	=> [
						'{{WRAPPER}} .tp-pricing-title' => 'color: {{VALUE}};'
					],
					'separator'	=> 'before',
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'		=> 'title_typography',
					'selector'	=> '{{WRAPPER}} .tp-pricing-title',
					'global' => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_price_style',
			[
				'label'	=> __( 'Pricing', 'larisdigital-wp' ),
				'tab'	=> Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'price_background',
				[
					'label'		=> __( 'Background Color', 'larisdigital-wp' ),
					'type'		=> Controls_Manager::COLOR,
					'selectors'	=> [
						'{{WRAPPER}} .tp-pricing-price' => 'background-color: {{VALUE}};'
					]
				]
			);

			$this->add_responsive_control(
				'price_padding',
				[
					'label' 		=> __( 'Padding', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px' ],
					'default' 		=> [
						'top' 		=> 20,
						'right' 	=> 0,
						'bottom' 	=> 20,
						'left' 		=> 0,
						'unit' 		=> 'px',
					],
					'selectors' 	=> [
						'{{WRAPPER}} .tp-pricing-price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'currency_symbol_heading',
				[
					'label'		=> __( 'Currency Symbol', 'larisdigital-wp' ),
					'type'		=> Controls_Manager::HEADING,
					'separator'	=> 'before',
				]
			);

				$this->add_control(
					'currency_symbol_color',
					[
						'label'		=> __( 'Color', 'larisdigital-wp' ),
						'type'		=> Controls_Manager::COLOR,
						'selectors'	=> [
							'{{WRAPPER}} .tp-pricing-price .tp-price-symbol' => 'color: {{VALUE}};',
						],
					]
				);

				$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'name'		=> 'currency_symbol_typography',
						'selector'	=> '{{WRAPPER}} .tp-pricing-price .tp-price-symbol',
						'global' => [
							'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
						],
					]
				);

				$this->add_control(
					'currency_vertical_position',
					[
						'label'			=> __( 'Vertica Position', 'larisdigital-wp' ),
						'type'			=> Controls_Manager::CHOOSE,
						'label_block'	=> false,
						'options'		=> [
							'top'		=> [
								'title'	=> __( 'Top', 'larisdigital-wp' ),
								'icon'	=> 'eicon-v-align-top',
							],
							'middle'	=> [
								'title'	=> __( 'Middle', 'larisdigital-wp' ),
								'icon'	=> 'eicon-v-align-middle',
							],
							'bottom'	=> [
								'title'	=> __( 'Bottom', 'larisdigital-wp' ),
								'icon'	=> 'eicon-v-align-bottom',
							],
						],
						'default'		=> 'top',
						'selectors_dictionary'	=> [
							'top'		=> 'flex-start',
							'middle'	=> 'center',
							'bottom'	=> 'flex-end',
						],
						'selectors'		=> [
							'{{WRAPPER}} .tp-pricing-price .tp-price-symbol' => 'align-self: {{VALUE}}',
						],
					]
				);

			$this->add_control(
				'price_heading',
				[
					'label'		=> __( 'Price', 'larisdigital-wp' ),
					'type'		=> Controls_Manager::HEADING,
					'separator'	=> 'before',
				]
			);

				$this->add_control(
					'price_color',
					[
						'label'		=> __( 'Color', 'larisdigital-wp' ),
						'type'		=> Controls_Manager::COLOR,
						'selectors'	=> [
							'{{WRAPPER}} .tp-pricing-price .tp-price-nominal' => 'color: {{VALUE}};',
						],
					]
				);

				$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'name'		=> 'price_typography',
						'selector'	=> '{{WRAPPER}} .tp-pricing-price .tp-price-nominal',
						'global' => [
							'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
						],
					]
				);

			$this->add_control(
				'plan_heading',
				[
					'label'		=> __( 'Plan', 'larisdigital-wp' ),
					'type'		=> Controls_Manager::HEADING,
					'separator'	=> 'before',
				]
			);

				$this->add_control(
					'plan_color',
					[
						'label'		=> __( 'Color', 'larisdigital-wp' ),
						'type'		=> Controls_Manager::COLOR,
						'selectors'	=> [
							'{{WRAPPER}} .tp-pricing-price .tp-pricing-plan-separator, {{WRAPPER}} .tp-pricing-price .tp-price-plan-name' => 'color: {{VALUE}};',
						],
					]
				);

				$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'name'		=> 'plan_typography',
						'selector'	=> '{{WRAPPER}} .tp-pricing-price .tp-pricing-plan-separator, {{WRAPPER}} .tp-pricing-price .tp-price-plan-name',
						'global' => [
							'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
						],
					]
				);

				$this->add_control(
					'plan_vertical_position',
					[
						'label'			=> __( 'Vertica Position', 'larisdigital-wp' ),
						'type'			=> Controls_Manager::CHOOSE,
						'label_block'	=> false,
						'options'		=> [
							'top'		=> [
								'title'	=> __( 'Top', 'larisdigital-wp' ),
								'icon'	=> 'eicon-v-align-top',
							],
							'middle'	=> [
								'title'	=> __( 'Middle', 'larisdigital-wp' ),
								'icon'	=> 'eicon-v-align-middle',
							],
							'bottom'	=> [
								'title'	=> __( 'Bottom', 'larisdigital-wp' ),
								'icon'	=> 'eicon-v-align-bottom',
							],
						],
						'default'		=> 'bottom',
						'selectors_dictionary'	=> [
							'top'		=> 'flex-start',
							'middle'	=> 'center',
							'bottom'	=> 'flex-end',
						],
						'selectors'		=> [
							'{{WRAPPER}} .tp-pricing-price .tp-pricing-plan-separator' => 'align-self: {{VALUE}}',
							'{{WRAPPER}} .tp-pricing-price .tp-price-plan-name' => 'align-self: {{VALUE}}',
						],
					]
				);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_feature_style',
			[
				'label'	=> __( 'Features', 'larisdigital-wp' ),
				'tab'	=> Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'features_background',
				[
					'label'		=> __( 'Background Color', 'larisdigital-wp' ),
					'type'		=> Controls_Manager::COLOR,
					'selectors'	=> [
						'{{WRAPPER}} .tp-pricing-feature-list' => 'background-color: {{VALUE}};'
					]
				]
			);

			$this->add_responsive_control(
				'features_padding',
				[
					'label' 		=> __( 'Padding', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px' ],
					'default' 		=> [
						'top' 		=> 20,
						'right' 	=> 0,
						'bottom' 	=> 20,
						'left' 		=> 0,
						'unit' 		=> 'px',
					],
					'selectors' 	=> [
						'{{WRAPPER}} .tp-pricing-feature-list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'features_color',
				[
					'label'		=> __( 'Color', 'larisdigital-wp' ),
					'type'		=> Controls_Manager::COLOR,
					'selectors'	=> [
						'{{WRAPPER}} .tp-pricing-feature-list .tp-feature-list' => 'color: {{VALUE}};',
					],
					'separator'	=> 'before',
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'		=> 'features_typography',
					'selector'	=> '{{WRAPPER}} .tp-pricing-feature-list .tp-feature-list',
					'global' => [
						'default' => Global_Typography::TYPOGRAPHY_TEXT,
					],
				]
			);

			$this->add_responsive_control(
				'features_list_padding',
				[
					'label' 		=> __( 'Item Padding', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px' ],
					'default' 		=> [
						'top' 		=> 10,
						'right' 	=> 0,
						'bottom' 	=> 10,
						'left' 		=> 0,
						'unit' 		=> 'px',
					],
					'selectors' 	=> [
						'{{WRAPPER}} .tp-pricing-feature-list .tp-feature-list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'feature_list_divider',
				[
					'label' 		=> __( 'Divider', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::SWITCHER,
					'return_value' 	=> 'yes',
					'default' 		=> 'yes',
					'separator' 	=> 'before',
				]
			);

			$this->add_control(
				'feature_list_divider_style',
				[
					'label' 		=> __( 'Style', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::SELECT,
					'options' 		=> [
						'solid' 	=> __( 'Solid', 'larisdigital-wp' ),
						'double' 	=> __( 'Double', 'larisdigital-wp' ),
						'dotted' 	=> __( 'Dotted', 'larisdigital-wp' ),
						'dashed' 	=> __( 'Dashed', 'larisdigital-wp' ),
					],
					'default' 		=> 'solid',
					'condition' 	=> [
						'feature_list_divider' => 'yes',
					],
					'selectors' 	=> [
						'{{WRAPPER}} .tp-pricing-feature-list .tp-feature-list' => 'border-bottom-style: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'feature_list_divider_color',
				[
					'label' 	=> __( 'Color', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::COLOR,
					'default' 	=> '#7a7a7a',
					'global' => [
						'default' => Global_Colors::COLOR_TEXT,
					],
					'condition' => [
						'feature_list_divider' => 'yes',
					],
					'selectors' => [
						'{{WRAPPER}} .tp-pricing-feature-list .tp-feature-list' => 'border-bottom-color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'feature_list_divider_weight',
				[
					'label' 	=> __( 'Weight', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::SLIDER,
					'default' 	=> [
						'size' 	=> 1,
						'unit' 	=> 'px',
					],
					'range'		=> [
						'px'	=> [
							'min'	=> 1,
							'max'	=> 10,
						],
					],
					'condition'	=> [
						'feature_list_divider' => 'yes',
					],
					'selectors'	=> [
						'{{WRAPPER}} .tp-pricing-feature-list .tp-feature-list' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
					],
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_button_style',
			[
				'label'	=> __( 'Button', 'larisdigital-wp' ),
				'tab'	=> Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'button_box_bg_color',
				[
					'label' 	=> __( 'Background Color', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tp-pricing-button' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_responsive_control(
				'button_box_padding',
				[
					'label' 		=> __( 'Padding', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px', '%', 'em' ],
					'selectors' 	=> [
						'{{WRAPPER}} .tp-pricing-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'button_size',
				[
					'label' 	=> __( 'Button Size', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::SELECT,
					'default' 	=> 'md',
					'options' 	=> [
						'xs'	=> __( 'Extra Small', 'larisdigital-wp' ),
						'sm'	=> __( 'Small', 'larisdigital-wp' ),
						'md'	=> __( 'Medium', 'larisdigital-wp' ),
						'lg'	=> __( 'Large', 'larisdigital-wp' ),
						'xl'	=> __( 'Extra Large', 'larisdigital-wp' ),
					],
					'separator'	=> 'before',
				]
			);

			$this->add_responsive_control(
				'button_align',
				[
					'label' 	=> __( 'Button Alignment', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::CHOOSE,
					'default'	=> 'center',
					'options' 	=> [
						'left'		=> [
							'title'		=> __( 'Left', 'larisdigital-wp' ),
							'icon'		=> 'eicon-text-align-left',
						],
						'center'	=> [
							'title'		=> __( 'Center', 'larisdigital-wp' ),
							'icon'		=> 'eicon-text-align-center',
						],
						'justify'	=> [
							'title'		=> __( 'Justify', 'larisdigital-wp' ),
							'icon'		=> 'eicon-text-align-justify',
						],
						'right'		=> [
							'title'		=> __( 'Right', 'larisdigital-wp' ),
							'icon'		=> 'eicon-text-align-right',
						],
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'button_typography',
					'label' => __( 'Typography', 'larisdigital-wp' ),
					'selector' => '{{WRAPPER}} .tp-pricing-button a.elementor-button',
				]
			);

			$this->start_controls_tabs( 'tabs_price_button_style' );

				$this->start_controls_tab(
					'tab_button_normal',
					[
						'label' => __( 'Normal', 'larisdigital-wp' ),
					]
				);

					$this->add_control(
						'button_text_color',
						[
							'label' => __( 'Text Color', 'larisdigital-wp' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .tp-pricing-button a.elementor-button' => 'color: {{VALUE}};',
							],
						]
					);

					$this->add_control(
						'button_background_color',
						[
							'label' => __( 'Background Color', 'larisdigital-wp' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .tp-pricing-button a.elementor-button' => 'background-color: {{VALUE}};',
							],
						]
					);

					$this->add_group_control(
						Group_Control_Border::get_type(),
						[
							'name'	=> 'button_border',
							'selector'	=> '{{WRAPPER}} .tp-pricing-button a.elementor-button',
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
						'button_hover_color',
						[
							'label' => __( 'Text Color', 'larisdigital-wp' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .tp-pricing-button a.elementor-button:hover' => 'color: {{VALUE}};',
							],
						]
					);

					$this->add_control(
						'button_background_hover_color',
						[
							'label' => __( 'Background Color', 'larisdigital-wp' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .tp-pricing-button a.elementor-button:hover' => 'background-color: {{VALUE}};',
							],
						]
					);

					$this->add_control(
						'button_hover_animation',
						[
							'label' => __( 'Animation', 'larisdigital-wp' ),
							'type' => Controls_Manager::HOVER_ANIMATION,
						]
					);

					$this->add_group_control(
						Group_Control_Border::get_type(),
						[
							'name'	=> 'button_border_hover',
							'selector'	=> '{{WRAPPER}} .tp-pricing-button a.elementor-button:hover',
						]
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->add_control(
				'button_border_radius',
				[
					'label' => __( 'Border Radius', 'larisdigital-wp' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors' => [
						'{{WRAPPER}} .tp-pricing-button a.elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings();

		$this->add_render_attribute( 'wrapper', 'class', 'tp-pricing-table-wrapper' );

		$this->add_render_attribute( 'wrapper', 'class', 'grid-columns-' . $settings['columns'] );

		$this->add_render_attribute( 'wrapper-inner', 'class', 'tp-pricing-table' );
		$this->add_render_attribute( 'wrapper-inner', 'class', 'clearfix' );

		?>

		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<div <?php echo $this->get_render_attribute_string( 'wrapper-inner' ); ?>>

				<?php foreach ( $settings['pricing_tables'] as $pricing_table_id => $pricing_table ) : ?>

					<?php
					$button_url = $pricing_table['button_url']['url'];
					$button_target = ( !empty( $pricing_table['button_link']['is_external'] ) ? "_blank" : "" );
					$button_follow = ( !empty( $pricing_table['button_link']['nofollow'] ) ? "nofollow" : "" );
					if ( !empty( $button_url ) ) {
						$this->add_render_attribute( 'button-wrapper-'.$pricing_table_id, 'class', 'tp-pricing-button' );

						$this->add_render_attribute( 'button-wrapper-'.$pricing_table_id, 'class', 'tp-pricing-button-' . $settings['button_align'] );

						$this->add_render_attribute( 'button-data-'.$pricing_table_id, 'href', esc_url( $button_url ) );
						$this->add_render_attribute( 'button-data-'.$pricing_table_id, 'class', 'elementor-button-text' );
						$this->add_render_attribute( 'button-data-'.$pricing_table_id, 'target', $button_target );
						$this->add_render_attribute( 'button-data-'.$pricing_table_id, 'rel', $button_follow );

						$this->add_render_attribute( 'button-data-'.$pricing_table_id, 'class', 'elementor-button-link' );
						$this->add_render_attribute( 'button-data-'.$pricing_table_id, 'class', 'elementor-button' );
						$this->add_render_attribute( 'button-data-'.$pricing_table_id, 'class', 'elementor-size-' . $settings['button_size'] );

						if ( $settings['button_hover_animation'] ) {
							$this->add_render_attribute( 'button-data-'.$pricing_table_id, 'class', 'elementor-animation-' . $settings['button_hover_animation'] );
						}
					}
					?>
					
					<div class="tp-pricing-item">
						<div class="tp-pricing-inner">
						
							<?php if ( !empty( $pricing_table['title'] ) ) : ?>
								<div class="tp-pricing-title">
									<?php echo $pricing_table['title']; ?>
								</div>
							<?php endif; ?>

							<div class="tp-pricing-price">
								<?php if ( !empty( $pricing_table['currency_symbol'] ) ) : ?>
									<span class="tp-price-symbol">
										<?php echo $pricing_table['currency_symbol']; ?>
									</span>
								<?php endif; ?>
								<?php if ( !empty( $pricing_table['price'] ) ) : ?>
									<span class="tp-price-nominal">
										<?php echo $pricing_table['price']; ?>
									</span>
								<?php endif; ?>
								<?php if ( !empty( $pricing_table['plan_separator'] ) ) : ?>
									<span class="tp-pricing-plan-separator">
										&nbsp;
										<?php echo $pricing_table['plan_separator']; ?>
										&nbsp;
									</span>
							<?php endif ?>
								<?php if ( !empty( $pricing_table['plan_name'] ) ) : ?>
									<span class="tp-price-plan-name">
										<?php echo $pricing_table['plan_name']; ?>
									</span>
								<?php endif; ?>
							</div>

							<ul class="tp-pricing-feature-list">
								<?php if ( !empty( $pricing_table['feature_list_1'] ) ) : ?>
									<li class="tp-feature-list"><?php echo $pricing_table['feature_list_1']; ?></li>
								<?php endif; ?>
								<?php if ( !empty( $pricing_table['feature_list_2'] ) ) : ?>
									<li class="tp-feature-list"><?php echo $pricing_table['feature_list_2']; ?></li>
								<?php endif; ?>
								<?php if ( !empty( $pricing_table['feature_list_3'] ) ) : ?>
									<li class="tp-feature-list"><?php echo $pricing_table['feature_list_3']; ?></li>
								<?php endif; ?>
								<?php if ( !empty( $pricing_table['feature_list_4'] ) ) : ?>
									<li class="tp-feature-list"><?php echo $pricing_table['feature_list_4']; ?></li>
								<?php endif; ?>
								<?php if ( !empty( $pricing_table['feature_list_5'] ) ) : ?>
									<li class="tp-feature-list"><?php echo $pricing_table['feature_list_5']; ?></li>
								<?php endif; ?>
								<?php if ( !empty( $pricing_table['feature_list_6'] ) ) : ?>
									<li class="tp-feature-list"><?php echo $pricing_table['feature_list_6']; ?></li>
								<?php endif; ?>
								<?php if ( !empty( $pricing_table['feature_list_7'] ) ) : ?>
									<li class="tp-feature-list"><?php echo $pricing_table['feature_list_7']; ?></li>
								<?php endif; ?>
								<?php if ( !empty( $pricing_table['feature_list_8'] ) ) : ?>
									<li class="tp-feature-list"><?php echo $pricing_table['feature_list_8']; ?></li>
								<?php endif; ?>
								<?php if ( !empty( $pricing_table['feature_list_9'] ) ) : ?>
									<li class="tp-feature-list"><?php echo $pricing_table['feature_list_9']; ?></li>
								<?php endif; ?>
								<?php if ( !empty( $pricing_table['feature_list_10'] ) ) : ?>
									<li class="tp-feature-list"><?php echo $pricing_table['feature_list_10']; ?></li>
								<?php endif; ?>
							</ul>

							<?php if ( '' != $button_url ) : ?>
								<div <?php echo $this->get_render_attribute_string( 'button-wrapper-'.$pricing_table_id ); ?>>
									<a <?php echo $this->get_render_attribute_string( 'button-data-'.$pricing_table_id ); ?>>
										<?php echo $pricing_table['button_text']; ?>
									</a>
								</div>
							<?php endif; ?>
						</div>
					</div>

				<?php endforeach; ?>

			</div>
		</div>

		<?php
	}

}