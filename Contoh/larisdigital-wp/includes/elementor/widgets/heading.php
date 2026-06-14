<?php
namespace ElementorTokoPress\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class TP_Heading extends Widget_Base {

	public function get_name() {
		return 'tp_heading';
	}

	public function get_title() {
		return __( 'TP - Heading', 'larisdigital-wp' );
	}

	public function get_icon() {
		return 'eicon-t-letter';
	}

	public function get_categories() {
		return [ 'tokopress' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_layout',
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
					'left' => [
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
				],
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_heading',
			[
				'label' => __( 'Heading', 'larisdigital-wp' ),
			]
		);

		$this->add_control(
			'heading',
			[
				'label' => __( 'Heading', 'larisdigital-wp' ),
				'type' => Controls_Manager::WYSIWYG,
				'placeholder' => __( 'Enter your heading', 'larisdigital-wp' ),
				'default' => __( 'This is heading', 'larisdigital-wp' ),
			]
		);

		$this->add_control(
			'heading_tag',
			[
				'label' => __( 'HTML Tag', 'larisdigital-wp' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => __( 'H1', 'larisdigital-wp' ),
					'h2' => __( 'H2', 'larisdigital-wp' ),
					'h3' => __( 'H3', 'larisdigital-wp' ),
					'h4' => __( 'H4', 'larisdigital-wp' ),
					'h5' => __( 'H5', 'larisdigital-wp' ),
					'h6' => __( 'H6', 'larisdigital-wp' ),
					'div' => __( 'div', 'larisdigital-wp' ),
					'span' => __( 'span', 'larisdigital-wp' ),
					'p' => __( 'p', 'larisdigital-wp' ),
				],
				'default' => 'h2',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_subheading',
			[
				'label' => __( 'Subheading', 'larisdigital-wp' ),
			]
		);

		$this->add_control(
			'subheading_show',
			[
				'label' => __( 'Subheading', 'larisdigital-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'larisdigital-wp' ),
				'label_off' => __( 'Hide', 'larisdigital-wp' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'separator' => 'none',
			]
		);

		$this->add_control(
			'subheading',
			[
				'label' => __( 'Subheading', 'larisdigital-wp' ),
				'type' => Controls_Manager::WYSIWYG,
				'placeholder' => __( 'Enter your subheading', 'larisdigital-wp' ),
				'default' => __( 'This is subheading', 'larisdigital-wp' ),
			]
		);

		$this->add_control(
			'subheading_tag',
			[
				'label' => __( 'HTML Tag', 'larisdigital-wp' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => __( 'H1', 'larisdigital-wp' ),
					'h2' => __( 'H2', 'larisdigital-wp' ),
					'h3' => __( 'H3', 'larisdigital-wp' ),
					'h4' => __( 'H4', 'larisdigital-wp' ),
					'h5' => __( 'H5', 'larisdigital-wp' ),
					'h6' => __( 'H6', 'larisdigital-wp' ),
					'div' => __( 'div', 'larisdigital-wp' ),
					'span' => __( 'span', 'larisdigital-wp' ),
					'p' => __( 'p', 'larisdigital-wp' ),
				],
				'default' => 'p',
			]
		);

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
			'section_heading_style',
			[
				'label' => __( 'Heading', 'larisdigital-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label' => __( 'Text Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-heading' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'heading_typography',
				'selector' => '{{WRAPPER}} .tp-heading',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_subheading_style',
			[
				'label' => __( 'Subheading', 'larisdigital-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'subheading_color',
			[
				'label' => __( 'Text Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-subheading' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subheading_typography',
				'selector' => '{{WRAPPER}} .tp-subheading',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings();

		if ( empty( $settings['heading'] ) )
			return;

		$this->add_render_attribute( 'heading', 'class', 'tp-heading' );

		$heading = wp_kses( $settings['heading'], array(
			'a' => array(
				'href' => array(),
				'title' => array(),
				'target' => array(),
			),
			'span' => array(
				'class' => array(),
				'style' => array(),
			),
			'br' => array(),
			'em' => array(),
			'strong' => array(),
			'del' => array(),
		) );

		printf( '<%1$s %2$s>%3$s</%1$s>', $settings['heading_tag'], $this->get_render_attribute_string( 'heading' ), $heading );

		if ( $settings['subheading_show'] == 'yes' && ! empty( $settings['subheading'] ) ) {

			$this->add_render_attribute( 'subheading', 'class', 'tp-subheading' );

			$subheading = wp_kses( $settings['subheading'], array(
				'a' => array(
					'href' => array(),
					'title' => array(),
					'target' => array(),
				),
				'span' => array(
					'class' => array(),
					'style' => array(),
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
				'del' => array(),
			) );

			printf( '<%1$s %2$s>%3$s</%1$s>', $settings['subheading_tag'], $this->get_render_attribute_string( 'subheading' ), $subheading );

		}
	}
}
