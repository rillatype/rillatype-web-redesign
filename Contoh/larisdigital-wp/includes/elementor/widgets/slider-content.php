<?php
namespace ElementorTokoPress\Widgets;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Utils;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class TP_Slider_Content extends Widget_Base {

	public function get_name() {
		return 'tp_slider_content';
	}

	public function get_title() {
		return __( 'TP - Content Slider', 'larisdigital-wp' );
	}

	public function get_icon() {
		return 'eicon-slideshow';
	}

	public function get_categories() {
		return [ 'tokopress' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_slider',
			[
				'label' => __( 'Slider Items', 'larisdigital-wp' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'slider_heading',
			[
				'label' => __( 'Heading', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Slider Heading', 'larisdigital-wp' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'slider_description',
			[
				'label' => __( 'Description', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'larisdigital-wp' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'slider_button',
			[
				'label' => __( 'Button', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Click Me', 'larisdigital-wp' ),
			]
		);

		$repeater->add_control(
			'slider_link',
			[
				'label' => __( 'Link', 'larisdigital-wp' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'http://your-link.com', 'larisdigital-wp' ),
			]
		);

		$repeater->add_control(
			'slider_image',
			[
				'label' => __( 'Image', 'larisdigital-wp' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'slider',
			[
				'label' => __( 'Slider Items', 'larisdigital-wp' ),
				'type' => Controls_Manager::REPEATER,
				'show_label' => true,
				'default' => [
					[
						'slider_heading' => __( 'Slider 1 Heading', 'larisdigital-wp' ),
						'slider_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
						'slider_button' => __( 'Click Me', 'larisdigital-wp' ),
						'slider_link' => '#',
						'slider_image' => [ 'url' => Utils::get_placeholder_image_src() ],
					],
					[
						'slider_heading' => __( 'Slider 2 Heading', 'larisdigital-wp' ),
						'slider_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
						'slider_button' => __( 'Click Me', 'larisdigital-wp' ),
						'slider_link' => '#',
						'slider_image' => [ 'url' => Utils::get_placeholder_image_src() ],
					],
					[
						'slider_heading' => __( 'Slider 3 Heading', 'larisdigital-wp' ),
						'slider_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
						'slider_button' => __( 'Click Me', 'larisdigital-wp' ),
						'slider_link' => '#',
						'slider_image' => [ 'url' => Utils::get_placeholder_image_src() ],
					],
				],
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ slider_heading }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_slider_options',
			[
				'label' => __( 'Slider Options', 'larisdigital-wp' ),
			]
		);

		$this->add_control(
			'adaptive_height',
			[
				'label' => __( 'Adaptive Height', 'larisdigital-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'no',
				'options' => [
					'no' => __( 'No', 'larisdigital-wp' ),
					'yes' => __( 'Yes', 'larisdigital-wp' ),
				],
			]
		);

		$this->add_control(
			'image_stretch',
			[
				'label' => __( 'Image Stretch', 'larisdigital-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'no',
				'options' => [
					'no' => __( 'No', 'larisdigital-wp' ),
					'yes' => __( 'Yes', 'larisdigital-wp' ),
				],
			]
		);

		$this->add_control(
			'navigation',
			[
				'label' => __( 'Navigation', 'larisdigital-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'dots',
				'options' => [
					'arrows' => __( 'Arrows', 'larisdigital-wp' ),
					'dots' => __( 'Dots', 'larisdigital-wp' ),
					'both' => __( 'Arrows and Dots', 'larisdigital-wp' ),
					'none' => __( 'None', 'larisdigital-wp' ),
				],
			]
		);

		$this->add_control(
			'pause_on_hover',
			[
				'label' => __( 'Pause on Hover', 'larisdigital-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'yes',
				'options' => [
					'yes' => __( 'Yes', 'larisdigital-wp' ),
					'no' => __( 'No', 'larisdigital-wp' ),
				],
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label' => __( 'Autoplay', 'larisdigital-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'yes',
				'options' => [
					'yes' => __( 'Yes', 'larisdigital-wp' ),
					'no' => __( 'No', 'larisdigital-wp' ),
				],
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label' => __( 'Autoplay Speed', 'larisdigital-wp' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 5000,
			]
		);

		$this->add_control(
			'infinite',
			[
				'label' => __( 'Infinite Loop', 'larisdigital-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'yes',
				'options' => [
					'yes' => __( 'Yes', 'larisdigital-wp' ),
					'no' => __( 'No', 'larisdigital-wp' ),
				],
			]
		);

		$this->add_control(
			'effect',
			[
				'label' => __( 'Effect', 'larisdigital-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'slide',
				'options' => [
					'slide' => __( 'Slide', 'larisdigital-wp' ),
					'fade' => __( 'Fade', 'larisdigital-wp' ),
				],
			]
		);

		$this->add_control(
			'speed',
			[
				'label' => __( 'Animation Speed', 'larisdigital-wp' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 500,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_heading',
			[
				'label' => __( 'Slide Heading', 'larisdigital-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'slide_heading_color',
			[
				'label' => __( 'Text Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-slider-heading' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'slide_heading_typography',
				'label' => __( 'Typography', 'larisdigital-wp' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .tp-slider-heading',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_description',
			[
				'label' => __( 'Slide Description', 'larisdigital-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'slide_description_color',
			[
				'label' => __( 'Text Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-slider-description' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'slide_description_typography',
				'label' => __( 'Typography', 'larisdigital-wp' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
				'selector' => '{{WRAPPER}} .tp-slider-description',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			[
				'label' => __( 'Slide Button', 'larisdigital-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'slide_button_color',
			[
				'label' => __( 'Text Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-button.tp-slider-button, {{WRAPPER}} .elementor-button.tp-slider-button:hover, {{WRAPPER}} .elementor-button.tp-slider-button:focus, {{WRAPPER}} .elementor-button.tp-slider-button:visited' => 'color: {{VALUE}}',
					'{{WRAPPER}} .elementor-button.tp-slider-button' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'slide_button_typography',
				'label' => __( 'Typography', 'larisdigital-wp' ),
				'selector' => '{{WRAPPER}} .elementor-button.tp-slider-button',
			]
		);

		$this->add_control(
			'slide_button_border_width',
			[
				'label' => __( 'Border Width', 'larisdigital-wp' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-button.tp-slider-button' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'slide_button_border_radius',
			[
				'label' => __( 'Border Radius', 'larisdigital-wp' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-button.tp-slider-button' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);

		$this->start_controls_tabs( 'slide_button_tabs' );

		$this->start_controls_tab( 'slide_button_normal', [ 'label' => __( 'Normal', 'larisdigital-wp' ) ] );

		$this->add_control(
			'slide_button_text_color',
			[
				'label' => __( 'Text Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-button.tp-slider-button, {{WRAPPER}} .elementor-button.tp-slider-button:visited' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'slide_button_border_color',
			[
				'label' => __( 'Border Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-button.tp-slider-button, {{WRAPPER}} .elementor-button.tp-slider-button:visited' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'slide_button_background_color',
			[
				'label' => __( 'Background Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-button.tp-slider-button, {{WRAPPER}} .elementor-button.tp-slider-button:visited' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'slide_button_hover', [ 'label' => __( 'Hover', 'larisdigital-wp' ) ] );

		$this->add_control(
			'slide_button_hover_text_color',
			[
				'label' => __( 'Text Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-button.tp-slider-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'slide_button_hover_border_color',
			[
				'label' => __( 'Border Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-button.tp-slider-button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'slide_button_hover_background_color',
			[
				'label' => __( 'Background Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-button.tp-slider-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_navigation',
			[
				'label' => __( 'Navigation', 'larisdigital-wp' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'navigation' => [ 'arrows', 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'heading_style_arrows',
			[
				'label' => __( 'Arrows', 'larisdigital-wp' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_color',
			[
				'label' => __( 'Arrows Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-slider-content-wrapper .elementor-swiper-button' => 'color: {{VALUE}};',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_position',
			[
				'label' => __( 'Arrows Position', 'larisdigital-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'inside',
				'options' => [
					'inside' => __( 'Inside', 'larisdigital-wp' ),
					'outside' => __( 'Outside', 'larisdigital-wp' ),
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_size',
			[
				'label' => __( 'Arrows Size', 'larisdigital-wp' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 60,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tp-slider-content-wrapper .elementor-swiper-button' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'heading_style_dots',
			[
				'label' => __( 'Dots', 'larisdigital-wp' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_color',
			[
				'label' => __( 'Dots Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-slider-content-wrapper .swiper-pagination .swiper-pagination-bullet' => 'background-color: {{VALUE}}; opacity:1;',
				],
			]
		);

		$this->add_control(
			'dots_active_color',
			[
				'label' => __( 'Dots Color (active)', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-slider-content-wrapper .swiper-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_position',
			[
				'label' => __( 'Dots Position', 'larisdigital-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'inside',
				'options' => [
					'inside' => __( 'Inside', 'larisdigital-wp' ),
					'outside' => __( 'Outside', 'larisdigital-wp' ),
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings();

		if ( empty( $settings['slider'] ) )
			return;

		$slides = [];
		foreach ( $settings['slider'] as $slider ) {
			$slide_left = '';
			if ( $slide_heading = $slider['slider_heading'] ) {
				$slide_left .= '<div class="tp-slider-heading">'.$slide_heading.'</div>';
			}
			if ( $slider_description = $slider['slider_description'] ) {
				$slide_left .= '<div class="tp-slider-description">'.$slider_description.'</div>';
			}
			if ( $slider_button = $slider['slider_button'] ) {
				$slide_link = $slider['slider_link']['url'] ? esc_url( $slider['slider_link']['url'] ) : '#';
				$slide_left .= '<a href="'.$slide_link.'" class="tp-slider-button elementor-button elementor-size-sm">'.$slider_button.'</a>';
			}
			if ( $slide_left ) {
				$slide_left = '<div class="tp-slider-content">'.$slide_left.'</div>';
			}
			$slide_right = '';
			if ( $slide_image = $slider['slider_image']['url'] ) {
				$slide_right .= '<img class="slick-slide-image swiper-slide-image" src="' . esc_url( $slide_image ) . '" alt="" />';
			}
			$slides[] = '<div class="swiper-slide"><div class="slick-slide-inner">
			<div class="elementor-section-content-middle elementor-reverse-mobile">
				<div class="elementor-container elementor-column-gap-no">
					<div class="elementor-row">
						<div class="elementor-column elementor-col-50">
							<div class="elementor-column-wrap">
								'.$slide_left.'
							</div>
						</div>
						<div class="elementor-column elementor-col-50">
							<div class="elementor-column-wrap">
								'.$slide_right.'
							</div>
						</div>
					</div>
				</div>
			</div>
			</div></div>';
		}

		if ( empty( $slides ) ) {
			return;
		}

		$direction = is_rtl() ? 'rtl' : 'ltr';

		$swiper_class = Plugin::$instance->experiments->is_feature_active( 'e_swiper_latest' ) ? 'swiper' : 'swiper-container';

		$this->add_render_attribute( [
			'slider' => [
				'class' => 'swiper-wrapper',
			],
			'wrapper' => [
				'class' => 'tp-slider-content-wrapper '.$swiper_class,
				'dir'	=> $direction
			],
		] );


		$slider_options = [
			'slidesToShow'   => absint( 1 ),
			'autoplaySpeed'  => absint( $settings['autoplay_speed'] ),
			'autoplay'       => ( 'no' !== $settings['autoplay'] ? true : false ),
			'infinite'       => ( 'no' !== $settings['infinite'] ? true : false ),
			'pauseOnHover'   => ( 'no' !== $settings['pause_on_hover'] ? true : false ),
			'speed'          => absint( $settings['speed'] ),
			'arrows'         => ( in_array( $settings['navigation'], [ 'arrows', 'both' ] ) ? true : false ),
			'dots'           => ( in_array( $settings['navigation'], [ 'dots', 'both' ] ) ? true : false ),
			'fade'           => ( 'slide' !== $settings['effect'] ? true : false ),
			'adaptiveHeight' => ( 'no' !== $settings['adaptive_height'] ? true : false ),
			'rtl'            => ( is_rtl() ? true : false ),
		];

		$slider_classes = [];
		$slider_classes[] = 'tp-swiper-on';

		if ( in_array( $settings['navigation'], [ 'arrows', 'both' ] ) ) {
			$show_arrows = true;
			$slider_classes[] = 'navigation-arrows-' . $settings['arrows_position'];
		}
		else {
			$show_arrows = false;
		}

		if ( in_array( $settings['navigation'], [ 'dots', 'both' ] ) ) {
			$show_dots = true;
			$slider_classes[] = 'navigation-dots-' . $settings['dots_position'];
		}
		else {
			$show_dots = false;
		}

		if ( "yes" == $settings['image_stretch'] ) {
			$this->add_render_attribute( 'slider', 'class', 'swiper-image-stretch' );
		}

		$this->add_render_attribute( 'wrapper', [ 'class' => $slider_classes ] );

		$this->add_render_attribute( 'slider', 'class', 'tp-content-slider' );

		$this->add_render_attribute( 'slider', [ 'data-slider_options' => wp_json_encode( $slider_options ) ] );

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<div <?php echo $this->get_render_attribute_string( 'slider' ); ?>>
				<?php echo implode( '', $slides ); ?>
			</div>
			<?php //if ( $settings['carousel'] == "yes" ) :
				if ( $show_dots ) : ?>
					<div class="swiper-pagination"></div>
				<?php endif; ?>
				<?php if ( $show_arrows ) : ?>
					<div class="elementor-swiper-button elementor-swiper-button-prev">
						<i class="eicon-chevron-left" aria-hidden="true"></i>
						<span class="elementor-screen-only"><?php _e( 'Previous', 'larisdigital-wp' ); ?></span>
					</div>
					<div class="elementor-swiper-button elementor-swiper-button-next">
						<i class="eicon-chevron-right" aria-hidden="true"></i>
						<span class="elementor-screen-only"><?php _e( 'Next', 'larisdigital-wp' ); ?></span>
					</div>
				<?php endif;
			//endif; ?>
		</div>
		<?php
	}
}
