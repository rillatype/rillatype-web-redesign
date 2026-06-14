<?php
namespace ElementorTokoPress\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class TP_Countdown extends Widget_Base {

	public function get_name() {
		return 'tp_countdown';
	}

	public function get_title() {
		return __( 'TP - Countdown', 'larisdigital-wp' );
	}

	public function get_icon() {
		return 'eicon-countdown';
	}

	public function get_categories() {
		return [ 'tokopress' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_countdown',
			[
				'label' => __( 'Countdown', 'larisdigital-wp' ),
			]
		);

		$this->add_control(
			'countdown_type',
			[
				'label' => __( 'Countdown Type', 'larisdigital-wp' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'default' => 'fixed',
				'options' => [
					'fixed' => __( 'Fixed End Date', 'larisdigital-wp' ),
					'evergreen' => __( 'Evergreen', 'larisdigital-wp' ),
					'evergreen-cookie' => __( 'Evergreen With Cookie', 'larisdigital-wp' ),
				],
			]
		);

		$this->add_control(
			'countdown',
			[
				'label' => __( 'Countdown End Date', 'larisdigital-wp' ),
				// 'label' => sprintf( __( 'Countdown Date (%s)', 'larisdigital-wp' ), Utils::get_timezone_string() ),
				// 'description' => __( 'Note: Go to Settings - General to change your website timezone.', 'larisdigital-wp' ),
				'type' => Controls_Manager::DATE_TIME,
				'default' => date( 'Y/m/d H:i', strtotime('+1 month') + ( get_option('gmt_offset')*HOUR_IN_SECONDS ) ),
				'condition' => [
					'countdown_type' => 'fixed',
				],
			]
		);

		$countdown_days = range( 0, 7 );
		$countdown_days = array_combine( $countdown_days, $countdown_days );
		for ($i=0; $i < 10 ; $i++) { 
			$countdown_days[$i] = '0'.$i;
		}

		$this->add_control(
			'evergreen_days',
			[
				'label' => __( 'Days', 'larisdigital-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => '1',
				'options' => $countdown_days,
				'condition' => [
					'countdown_type' => ['evergreen','evergreen-cookie'],
				],
			]
		);

		$countdown_hours = range( 0, 23 );
		$countdown_hours = array_combine( $countdown_hours, $countdown_hours );
		for ($i=0; $i < 10 ; $i++) { 
			$countdown_hours[$i] = '0'.$i;
		}

		$this->add_control(
			'evergreen_hours',
			[
				'label' => __( 'Hours', 'larisdigital-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => '0',
				'options' => $countdown_hours,
				'condition' => [
					'countdown_type' => ['evergreen','evergreen-cookie'],
				],
			]
		);

		$countdown_minutes = range( 0, 59 );
		$countdown_minutes = array_combine( $countdown_minutes, $countdown_minutes );
		for ($i=0; $i < 10 ; $i++) { 
			$countdown_minutes[$i] = '0'.$i;
		}

		$this->add_control(
			'evergreen_minutes',
			[
				'label' => __( 'Minutes', 'larisdigital-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => '0',
				'options' => $countdown_minutes,
				'condition' => [
					'countdown_type' => ['evergreen','evergreen-cookie'],
				],
			]
		);

		$this->add_responsive_control(
			'countdown_align',
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
				],
				'selectors' => [
					'{{WRAPPER}} .tp-countdown' => 'text-align: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'heading_days',
			[
				'label' => __( 'Days', 'larisdigital-wp' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'hide_days',
			[
				'label' => __( 'Hide', 'larisdigital-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'prefix_class' => 'tp-countdown-days-',
				'label_on' => 'Hide',
				'label_off' => 'Show',
				'return_value' => 'hide',
			]
		);

		$this->add_control(
			'label_days',
			[
				'label' => __( 'Label', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'days', 'larisdigital-wp' ),
				'condition' => [
					'hide_days' => '',
				],
			]
		);

		$this->add_control(
			'heading_hours',
			[
				'label' => __( 'Hours', 'larisdigital-wp' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'hide_hours',
			[
				'label' => __( 'Hide', 'larisdigital-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'prefix_class' => 'tp-countdown-hours-',
				'label_on' => 'Hide',
				'label_off' => 'Show',
				'return_value' => 'hide',
			]
		);

		$this->add_control(
			'label_hours',
			[
				'label' => __( 'Label', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'hours', 'larisdigital-wp' ),
				'condition' => [
					'hide_hours' => '',
				],
			]
		);

		$this->add_control(
			'heading_minutes',
			[
				'label' => __( 'Minutes', 'larisdigital-wp' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'hide_minutes',
			[
				'label' => __( 'Hide', 'larisdigital-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'prefix_class' => 'tp-countdown-minutes-',
				'label_on' => 'Hide',
				'label_off' => 'Show',
				'return_value' => 'hide',
			]
		);

		$this->add_control(
			'label_minutes',
			[
				'label' => __( 'Label', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'minutes', 'larisdigital-wp' ),
				'condition' => [
					'hide_minutes' => '',
				],
			]
		);

		$this->add_control(
			'heading_seconds',
			[
				'label' => __( 'Seconds', 'larisdigital-wp' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'hide_seconds',
			[
				'label' => __( 'Hide', 'larisdigital-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'prefix_class' => 'tp-countdown-seconds-',
				'label_on' => 'Hide',
				'label_off' => 'Show',
				'return_value' => 'hide',
			]
		);

		$this->add_control(
			'label_seconds',
			[
				'label' => __( 'Label', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'seconds', 'larisdigital-wp' ),
				'condition' => [
					'hide_seconds' => '',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_intro',
			[
				'label' => __( 'Intro Text', 'larisdigital-wp' ),
			]
		);

		$this->add_control(
			'intro',
			[
				'label' => __( 'Text', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => '',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_digits_style',
			[
				'label' => __( 'Countdown Digits', 'larisdigital-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'digits_gap',
			[
				'label' => __( 'Digits Gap', 'larisdigital-wp' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 5,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tp-countdown .count-container' => 'margin: 0 -{{SIZE}}px',
					'(desktop){{WRAPPER}} .tp-countdown .count-box' => 'margin: 0 {{SIZE}}px',
					'(tablet){{WRAPPER}} .tp-countdown .count-box' => 'margin: 0 {{SIZE}}px',
					'(mobile){{WRAPPER}} .tp-countdown .count-box' => 'margin: 0 {{SIZE}}px',
				],
			]
		);

		$this->add_control(
			'digits_text_color',
			[
				'label' => __( 'Text Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-countdown .count-num' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'digits_background_color',
			[
				'label' => __( 'Background Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-countdown .count-num' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'digits_typography',
				'label' => __( 'Typography', 'larisdigital-wp' ),
				'selector' => '{{WRAPPER}} .tp-countdown .count-num',
			]
		);

		$this->add_responsive_control(
			'digits_padding',
			[
				'label' => __( 'Padding', 'larisdigital-wp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tp-countdown .count-num' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'digits_border',
				'label' => __( 'Border', 'larisdigital-wp' ),
				'placeholder' => '0px',
				'default' => '0px',
				'selector' => '{{WRAPPER}} .tp-countdown .count-num',
			]
		);

		$this->add_control(
			'digits_border_radius',
			[
				'label' => __( 'Border Radius', 'larisdigital-wp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tp-countdown .count-num' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_label_style',
			[
				'label' => __( 'Countdown Labels', 'larisdigital-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'labels_text_color',
			[
				'label' => __( 'Text Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-countdown .count-label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'labels_background_color',
			[
				'label' => __( 'Background Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-countdown .count-label' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'labels_typography',
				'label' => __( 'Typography', 'larisdigital-wp' ),
				'selector' => '{{WRAPPER}} .tp-countdown .count-label',
			]
		);

		$this->add_responsive_control(
			'labels_padding',
			[
				'label' => __( 'Padding', 'larisdigital-wp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tp-countdown .count-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'labels_border',
				'label' => __( 'Border', 'larisdigital-wp' ),
				'placeholder' => '0px',
				'default' => '0px',
				'selector' => '{{WRAPPER}} .tp-countdown .count-label',
			]
		);

		$this->add_control(
			'labels_border_radius',
			[
				'label' => __( 'Border Radius', 'larisdigital-wp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tp-countdown .count-label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_intro_style',
			[
				'label' => __( 'Intro Text', 'larisdigital-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'intro_color',
			[
				'label' => __( 'Text Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-countdown .countdown-intro' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'intro_typography',
				'label' => __( 'Typography', 'larisdigital-wp' ),
				'selector' => '{{WRAPPER}} .tp-countdown .countdown-intro',
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings();

		if ( empty( $settings['countdown_type'] ) ) {
			$settings['countdown_type'] = 'fixed';
		}

		if ( $settings['countdown_type'] == 'fixed') {
			if ( empty( $settings['countdown'] ) )
				return;

			$countdown = strtotime( $settings['countdown'] );
			// $countdown = $countdown - ( get_option( 'gmt_offset' )*HOUR_IN_SECONDS );
			$datetime = date( 'm\/d\/Y h:i A', $countdown );
		}
		else {
			$datetime = intval( $settings['evergreen_days'] ) * 24 * 60 * 60 * 1000;
			$datetime = $datetime + intval( $settings['evergreen_hours'] ) * 60 * 60 * 1000;
			$datetime = $datetime + intval( $settings['evergreen_minutes'] ) * 60 * 1000;
		}

		$intro = $settings['intro'] ? '<div class="countdown-intro">' . $settings['intro'] . '</div>' : '';

		$label_days = $settings['label_days'] ? $settings['label_days'] : __( 'days', 'larisdigital-wp' );
		$label_hours = $settings['label_hours'] ? $settings['label_hours'] : __( 'hours', 'larisdigital-wp' );
		$label_minutes = $settings['label_minutes'] ? $settings['label_minutes'] : __( 'minutes', 'larisdigital-wp' );
		$label_seconds = $settings['label_seconds'] ? $settings['label_seconds'] : __( 'seconds', 'larisdigital-wp' );

		$selector = 'tp-countdown-'.$this->get_id();

		$this->add_render_attribute( 'wrapper', 'class', 'tp-countdown' );
		$this->add_render_attribute( 'wrapper', 'data-type', $settings['countdown_type'] );
		$this->add_render_attribute( 'wrapper', 'data-selector', $selector );
		$this->add_render_attribute( 'wrapper', 'data-datetime', $datetime );
		$this->add_render_attribute( 'wrapper', 'data-intro', $settings['intro'] );
		$this->add_render_attribute( 'wrapper', 'data-labeldays', $label_days );
		$this->add_render_attribute( 'wrapper', 'data-labelhours', $label_hours );
		$this->add_render_attribute( 'wrapper', 'data-labelminutes', $label_minutes );
		$this->add_render_attribute( 'wrapper', 'data-labelseconds', $label_seconds );

		?>
 		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<div id="<?php echo $selector; ?>">
				<?php echo $intro; ?>
				<span class="count-container"><span class="count-box count-box-days"><span class="count-num">0</span> <span class="count-label"><?php echo $label_days; ?></span></span> <span class="count-box count-box-hours"><span class="count-num">0</span> <span class="count-label"><?php echo $label_hours; ?></span></span> <span class="count-box count-box-minutes"><span class="count-num">0</span> <span class="count-label"><?php echo $label_minutes; ?></span></span><span class="count-box count-box-seconds"> <span class="count-num">0</span> <span class="count-label"><?php echo $label_seconds; ?></span></span></span>
			</div>
		</div>
		<?php 
	}

}
