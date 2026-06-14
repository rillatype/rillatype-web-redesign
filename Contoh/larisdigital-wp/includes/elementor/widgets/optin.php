<?php
namespace ElementorTokoPress\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Utils;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class TP_Optin extends Widget_Base {

	public function get_name() {
		return 'tp_optin';
	}

	public function get_title() {
		return __( 'TP - Opt-in Form', 'larisdigital-wp' );
	}

	public function get_icon() {
		return 'eicon-dual-button';
	}

	public function get_categories() {
		return [ 'tokopress' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_optin',
			[
				'label' => __( 'Opt-in Form', 'larisdigital-wp' ),
			]
		);

		$this->add_control(
			'optin',
			[
				'label' => __( 'Opt-in Form Code', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXTAREA,
				'placeholder' => __( 'Enter your optin form code here', 'larisdigital-wp' ),
				'show_label' => true,
			]
		);

		$this->add_control(
			'optin_display',
			[
				'label' => __( 'Display', 'larisdigital-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => __( 'Default', 'larisdigital-wp' ),
					'fullwidth' => __( 'Full Width', 'larisdigital-wp' ),
					'inline' => __( 'Inline', 'larisdigital-wp' ),
				],
			]
		);

		$this->add_control(
			'optin_width',
			[
				'label' => __( 'Opt-in Width', 'larisdigital-wp' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 300,
						'max' => 1600,
					],
				],
				'size_units' => [ 'px' ],
				'default' => [
					'size' => '300',
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-tp-form-wrapper input[type="text"], {{WRAPPER}} .elementor-tp-form-wrapper input[type="email"], {{WRAPPER}} .elementor-tp-form-wrapper textarea, .elementor-tp-form-wrapper .contact-form input[type="text"], {{WRAPPER}} .elementor-tp-form-wrapper .contact-form input[type="email"], {{WRAPPER}} .elementor-tp-form-wrapper .contact-form textarea, {{WRAPPER}} .elementor-tp-form-wrapper.elementor-button-width-input input[type="submit"], {{WRAPPER}} .elementor-tp-form-wrapper.elementor-button-width-input button' => 'min-width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'optin_display' => [ 'default' ],
				],
				'show_label' => true,
				'separator' => 'none',
			]
		);

		$this->add_control(
			'button_width',
			[
				'label' => __( 'Button Width', 'larisdigital-wp' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'default' => __( 'Default', 'larisdigital-wp' ),
					'input' => __( 'Input Width', 'larisdigital-wp' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_label_style',
			[
				'label' => __( 'Opt-in Label (If Available)', 'larisdigital-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'label_text_color',
			[
				'label' => __( 'Text Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-tp-form-wrapper label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'label_typography',
				'label' => __( 'Typography', 'larisdigital-wp' ),
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
				'label' => __( 'Opt-in Input', 'larisdigital-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'input_text_color',
			[
				'label' => __( 'Text Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-tp-form-wrapper input[type="text"], {{WRAPPER}} .elementor-tp-form-wrapper input[type="email"], {{WRAPPER}} .elementor-tp-form-wrapper textarea' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'input_typography',
				'label' => __( 'Typography', 'larisdigital-wp' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector' => '{{WRAPPER}} .elementor-tp-form-wrapper input[type="text"], {{WRAPPER}} .elementor-tp-form-wrapper input[type="email"], {{WRAPPER}} .elementor-tp-form-wrapper textarea',
			]
		);

		$this->add_control(
			'input_background_color',
			[
				'label' => __( 'Background Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-tp-form-wrapper input[type="text"], {{WRAPPER}} .elementor-tp-form-wrapper input[type="email"], {{WRAPPER}} .elementor-tp-form-wrapper textarea' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'input_border',
				'label' => __( 'Border', 'larisdigital-wp' ),
				'placeholder' => '1px',
				'default' => '1px',
				'selector' => '{{WRAPPER}} .elementor-tp-form-wrapper input[type="text"], {{WRAPPER}} .elementor-tp-form-wrapper input[type="email"], {{WRAPPER}} .elementor-tp-form-wrapper textarea',
			]
		);

		$this->add_control(
			'input_border_radius',
			[
				'label' => __( 'Border Radius', 'larisdigital-wp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-tp-form-wrapper input[type="text"], {{WRAPPER}} .elementor-tp-form-wrapper input[type="email"], {{WRAPPER}} .elementor-tp-form-wrapper textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'input_text_padding',
			[
				'label' => __( 'Text Padding', 'larisdigital-wp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-tp-form-wrapper input[type="text"], {{WRAPPER}} .elementor-tp-form-wrapper input[type="email"], {{WRAPPER}} .elementor-tp-form-wrapper textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_button_style',
			[
				'label' => __( 'Opt-in Button', 'larisdigital-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
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
				'label' => __( 'Text Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-tp-form-wrapper input[type="submit"], {{WRAPPER}} .elementor-tp-form-wrapper button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'label' => __( 'Typography', 'larisdigital-wp' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector' => '{{WRAPPER}} .elementor-tp-form-wrapper input[type="submit"], {{WRAPPER}} .elementor-tp-form-wrapper button',
			]
		);

		$this->add_control(
			'background_color',
			[
				'label' => __( 'Background Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
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
				'name' => 'border',
				'label' => __( 'Border', 'larisdigital-wp' ),
				'placeholder' => '1px',
				'default' => '1px',
				'selector' => '{{WRAPPER}} .elementor-tp-form-wrapper input[type="submit"], {{WRAPPER}} .elementor-tp-form-wrapper button',
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => __( 'Border Radius', 'larisdigital-wp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-tp-form-wrapper input[type="submit"], {{WRAPPER}} .elementor-tp-form-wrapper button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'text_padding',
			[
				'label' => __( 'Text Padding', 'larisdigital-wp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
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
				'label' => __( 'Text Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-tp-form-wrapper input[type="submit"]:hover, {{WRAPPER}} .elementor-tp-form-wrapper button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label' => __( 'Background Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-tp-form-wrapper input[type="submit"]:hover, {{WRAPPER}} .elementor-tp-form-wrapper button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label' => __( 'Border Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-tp-form-wrapper input[type="submit"]:hover, {{WRAPPER}} .elementor-tp-form-wrapper button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => __( 'Animation', 'larisdigital-wp' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings();

		$this->add_render_attribute( 'wrapper', 'class', 'elementor-tp-form-wrapper' );
		if ( ! empty( $settings['optin_display'] ) ) {
			$this->add_render_attribute( 'wrapper', 'class', 'elementor-tp-form-display-' . $settings['optin_display'] );
		}
		if ( ! empty( $settings['button_width'] ) ) {
			$this->add_render_attribute( 'wrapper', 'class', 'elementor-button-width-' . $settings['button_width'] );
		}
		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php echo do_shortcode( $settings['optin'] ); ?>
		</div>
		<?php 
	}
}
