<?php
namespace ElementorTokoPress\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class TP_Newsletter_Form extends Widget_Base {

	public function get_name() {
		return 'tp_newsletter_form';
	}

	public function get_title() {
		return __( 'TP - Newsletter Form', 'larisdigital-wp' );
	}

	public function get_icon() {
		return 'eicon-form-horizontal';
	}

	public function get_categories() {
		return [ 'tokopress' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_form',
			[
				'label' => __( 'Newsletter Form', 'larisdigital-wp' ),
			]
		);

		$this->add_control(
			'field_email_placeholder',
			[
				'label' => __( 'Email Placeholder', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => __( 'Your email address', 'larisdigital-wp' ),
				'placeholder' => __( 'Your email address', 'larisdigital-wp' ),
			]
		);

		$this->add_control(
			'field_submit_text',
			[
				'label' => __( 'Button Text', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => __( 'Subscribe', 'larisdigital-wp' ),
				'placeholder' => __( 'Subscribe', 'larisdigital-wp' ),
			]
		);

		$this->add_control(
			'field_submit_position',
			[
				'label' => __( 'Button Position', 'larisdigital-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'bottom',
				'options' => [
					'bottom' => __( 'Bottom', 'larisdigital-wp' ),
					'inline' => __( 'Inline', 'larisdigital-wp' ),
				],
			]
		);

		$this->add_control(
			'field_submit_align',
			[
				'label' => __( 'Button Alignment', 'larisdigital-wp' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'left',
				'options' => [
					'left' => [
						'title' => __( 'Left', 'larisdigital-wp' ),
						'icon' => 'eicon-text-align-left',
					],
					'fullwidth' => [
						'title' => __( 'Justified', 'larisdigital-wp' ),
						'icon' => 'eicon-text-align-justify',
					],
					'right' => [
						'title' => __( 'Right', 'larisdigital-wp' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'condition' => [
					'field_submit_position' => 'bottom',
				],
			]
		);

		$this->add_control(
			'field_submit_icon5',
			[
				'label' => __( ' Button Icon', 'larisdigital-wp' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'field_submit_icon',
				'label_block' => true,
			]
		);

		$this->add_control(
			'field_submit_icon_align',
			[
				'label' => __( 'Icon Position', 'larisdigital-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left' => __( 'Before', 'larisdigital-wp' ),
					'right' => __( 'After', 'larisdigital-wp' ),
				],
				'condition' => [
					'field_submit_icon5[value]!' => '',
				],
			]
		);

		$this->add_control(
			'field_submit_icon_indent',
			[
				'label' => __( 'Icon Spacing', 'larisdigital-wp' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					'field_submit_icon5[value]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .tp-form-align-icon-right.tp-form-button-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tp-form-align-icon-left.tp-form-button-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'field_submit_icon_rotate',
			[
				'label' => __( 'Rotate Icon', 'larisdigital-wp' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'deg' ],
				'default' => [
					'size' => 0,
					'unit' => 'deg',
				],
				'condition' => [
					'field_submit_icon5[value]!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} button i, {{WRAPPER}} button svg' => 'transform: rotate({{SIZE}}{{UNIT}});',
					'{{WRAPPER}} button svg' => 'width: 1em;',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_form_style',
			[
				'label' => __( 'Form', 'larisdigital-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'form_padding',
			[
				'label' => __( 'Form Padding', 'larisdigital-wp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-tp-form-wrapper form' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'form_background_color',
			[
				'label' => __( 'Background Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-tp-form-wrapper form' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_input_style',
			[
				'label' => __( 'Form Input', 'larisdigital-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'input_text_color',
			[
				'label' => __( 'Text Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-tp-form-wrapper input[type="text"], {{WRAPPER}} .elementor-tp-form-wrapper input[type="email"]' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-tp-form-wrapper input::-webkit-input-placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-tp-form-wrapper input::-moz-placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-tp-form-wrapper input:-ms-input-placeholder' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'input_typography',
				'label' => __( 'Typography', 'larisdigital-wp' ),
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
				'label' => __( 'Form Button', 'larisdigital-wp' ),
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
					'{{WRAPPER}} .elementor-tp-form-wrapper button svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'label' => __( 'Typography', 'larisdigital-wp' ),
				'selector' => '{{WRAPPER}} .elementor-tp-form-wrapper input[type="submit"], {{WRAPPER}} .elementor-tp-form-wrapper button',
			]
		);

		$this->add_control(
			'background_color',
			[
				'label' => __( 'Background Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
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
		if ( ! empty( $settings['field_submit_position'] ) ) {
			$this->add_render_attribute( 'wrapper', 'class', 'elementor-tp-form-button-pos-' . $settings['field_submit_position'] );
		}
		if ( ! empty( $settings['field_submit_align'] ) ) {
			$this->add_render_attribute( 'wrapper', 'class', 'elementor-tp-form-button-align-' . $settings['field_submit_align'] );
		}

		$this->add_render_attribute( 'field_email', 'type', 'email' );
		$this->add_render_attribute( 'field_email', 'name', 'tp-form-email' );
		$this->add_render_attribute( 'field_email', 'required', '1' );
		$this->add_render_attribute( 'field_email', 'placeholder', $settings['field_email_placeholder'] );
		$this->add_render_attribute( 'field_email', 'value', '' );

		$this->add_render_attribute( 'button-icon', 'class', 'tp-form-align-icon-' . $settings['field_submit_icon_align'] );
		$this->add_render_attribute( 'button-icon', 'class', 'tp-form-button-icon' );

		$icon_migrated = isset( $settings['__fa4_migrated']['field_submit_icon5'] );
		$icon_is_new = empty( $settings['field_submit_icon'] ) && Icons_Manager::is_migration_allowed();
		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<form class="tp-form" method="post">
				<div class="tp-form-fields-wrapper">
					<div class="tp-form-field-email">
						<input <?php echo $this->get_render_attribute_string( 'field_email' ); ?>>
					</div>
					<div class="tp-form-field-submit">
						<button type="submit" class="tp-form-button">
							<?php if ( ! empty( $settings['field_submit_icon'] ) || ! empty( $settings['field_submit_icon5']['value'] ) ) : ?>
							<span <?php echo $this->get_render_attribute_string( 'button-icon' ); ?>>
								<?php if ( $icon_is_new || $icon_migrated ) : ?>
									<?php Icons_Manager::render_icon( $settings['field_submit_icon5'], [ 'aria-hidden' => 'true' ] ); ?>
								<?php else : ?>
									<i class="<?php echo esc_attr( $settings['field_submit_icon'] ); ?>" aria-hidden="true"></i>
								<?php endif; ?>
							</span>
							<?php endif; ?>
							<?php echo $settings['field_submit_text']; ?>
						</button>
					</div>
				</div>
			</form>		
		</div>
		<?php 
	}
}
