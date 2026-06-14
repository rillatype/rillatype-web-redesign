<?php
namespace ElementorTokoPress\Widgets;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
// use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Utils;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class TP_Testimonials extends Widget_Base {
	
	public function get_name() {
		return 'tp_testimonials';
	}

	public function get_title() {
		return __( 'TP - Testimonials', 'larisdigital-wp' );
	}

	public function get_icon() {
		return 'eicon-posts-ticker';
	}

	public function get_categories() {
		return [ 'tokopress' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_testimonials',
			[
				'label' => __( 'Testimonials', 'larisdigital-wp' ),
			]
		);

			$this->add_responsive_control(
				'columns',
				[
					'label' 			=> __( 'Columns', 'larisdigital-wp' ),
					'type' 				=> Controls_Manager::SELECT,
					'desktop_default' 	=> '1',
					'tablet_default' 	=> '1',
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
				'quote',
				[
					'label' 		=> __( 'Testimonisl', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::TEXTAREA,
					'placeholder' 	=> __( 'Your Quote', 'larisdigital-wp' ),
					'label_block' 	=> true,
				]
			);

			$repeater->add_control(
				'name',
				[
					'label' 		=> __( 'Name', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::TEXT,
					'placeholder' 	=> __( 'Your Name', 'larisdigital-wp' ),
					'label_block' 	=> true,
				]
			);

			$repeater->add_control(
				'job',
				[
					'label' 		=> __( 'Job Position', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::TEXT,
					'placeholder' 	=> __( 'Your Position', 'larisdigital-wp' ),
					'label_block' 	=> true,
				]
			);

			$repeater->add_control(
				'avatar',
				[
					'label' 	=> __( 'Choose Image', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::MEDIA,
					'default' 	=> [
						'url'	=> Utils::get_placeholder_image_src(),
					],
				]
			);

			$this->add_control(
				'testimonials',
				[
					'label' 		=> __( 'Testimonial', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::REPEATER,
					'show_label' 	=> true,
					'default' 		=> [
						[
							'quote' 	=> 'Lorem ipsum dolor sit amet, vim primis bonorum te. Libris expetenda liberavisse ne pro, pro eirmod volumus at. Ex vix novum accommodare.',
							'name' 		=> 'John Doe',
							'job' 		=> 'Web Designer',
							'avatar' 	=> [ 'url' => Utils::get_placeholder_image_src() ],
						],
						[
							'quote' 	=> 'Lorem ipsum dolor sit amet, vim primis bonorum te. Libris expetenda liberavisse ne pro, pro eirmod volumus at. Ex vix novum accommodare.',
							'name' 		=> 'John Doe',
							'job' 		=> 'Web Designer',
							'avatar' 	=> [ 'url' => Utils::get_placeholder_image_src() ],
						],
						[
							'quote' 	=> 'Lorem ipsum dolor sit amet, vim primis bonorum te. Libris expetenda liberavisse ne pro, pro eirmod volumus at. Ex vix novum accommodare.',
							'name' 		=> 'John Doe',
							'job' 		=> 'Web Designer',
							'avatar' 	=> [ 'url' => Utils::get_placeholder_image_src() ],
						],
					],
					'fields' 		=> $repeater->get_controls(),
					'title_field' 	=> '{{{ name }}}',
				]
			);

			$this->add_control(
				'avatar_position',
				[
					'label'		=> __( 'Image Position', 'larisdigital-wp' ),
					'type'		=> Controls_Manager::CHOOSE,
					'default'	=> 'left',
					'options'	=> [
						'left'	=> [
							'title'	=> __( 'Left', 'larisdigital-wp' ),
							'icon'	=> 'eicon-h-align-left'
						],
						'top'	=> [
							'title'	=> __( 'Top', 'larisdigital-wp' ),
							'icon'	=> 'eicon-v-align-top'
						],
						'right'	=> [
							'title'	=> __( 'Right', 'larisdigital-wp' ),
							'icon'	=> 'eicon-h-align-right'
						],
					],
					'prefix_class' => 'tp-testimonial-avatar-',
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_slider_options',
			[
				'label' => __( 'Slider / Carousel Options', 'larisdigital-wp' ),
			]
		);

			$this->add_control(
				'carousel',
				[
					'label'			=> __( 'Carousel', 'larisdigital-wp' ),
					'type'			=> Controls_Manager::SWITCHER,
					'default'		=> 'yes',
					'label_on'		=> __( 'Yes', 'larisdigital-wp' ),
					'label_off'		=> __( 'No', 'larisdigital-wp' ),
					'return_value'	=> 'yes'
				]
			);

			$this->add_responsive_control(
				'slides_to_scroll',
				[
					'label' 			=> __( 'Slides To Scroll', 'larisdigital-wp' ),
					'type' 				=> Controls_Manager::SELECT,
					'desktop_default' 	=> '1',
					'tablet_default' 	=> '1',
					'mobile_default' 	=> '1',
					'options' 			=> [
						'1' => '1',
						'2' => '2',
						'3' => '3',
						'4' => '4',
						'5' => '5',
						'6' => '6',
					],
					'condition'	=> [
						'carousel'	=> [ 'yes' ],
					],
				]
			);

			$this->add_control(
				'adaptive_height',
				[
					'label' 	=> __( 'Adaptive Height', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::SELECT,
					'default' 	=> 'yes',
					'options' 	=> [
						'yes' 	=> __( 'Yes', 'larisdigital-wp' ),
						'no' 	=> __( 'No', 'larisdigital-wp' ),
					],
					'condition'	=> [
						'carousel'	=> [ 'yes' ],
					],
				]
			);

			$this->add_control(
				'navigation',
				[
					'label' 	=> __( 'Navigation', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::SELECT,
					'default' 	=> 'both',
					'options' 	=> [
						'both' 		=> __( 'Arrows and Dots', 'larisdigital-wp' ),
						'arrows' 	=> __( 'Arrows', 'larisdigital-wp' ),
						'dots' 		=> __( 'Dots', 'larisdigital-wp' ),
						'none' 		=> __( 'None', 'larisdigital-wp' ),
					],
					'condition'	=> [
						'carousel'	=> [ 'yes' ],
					],
				]
			);

			$this->add_control(
				'pause_on_hover',
				[
					'label' 	=> __( 'Pause on Hover', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::SELECT,
					'default' 	=> 'yes',
					'options' 	=> [
						'yes' 	=> __( 'Yes', 'larisdigital-wp' ),
						'no' 	=> __( 'No', 'larisdigital-wp' ),
					],
					'condition'	=> [
						'carousel'	=> [ 'yes' ],
					],
				]
			);

			$this->add_control(
				'autoplay',
				[
					'label' 	=> __( 'Autoplay', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::SELECT,
					'default' 	=> 'yes',
					'options' 	=> [
						'yes' 	=> __( 'Yes', 'larisdigital-wp' ),
						'no' 	=> __( 'No', 'larisdigital-wp' ),
					],
					'condition'	=> [
						'carousel'	=> [ 'yes' ],
					],
				]
			);

			$this->add_control(
				'autoplay_speed',
				[
					'label' 	=> __( 'Autoplay Speed', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::NUMBER,
					'default' 	=> 5000,
					'condition'	=> [
						'carousel'	=> [ 'yes' ],
					],
				]
			);

			$this->add_control(
				'infinite',
				[
					'label' 	=> __( 'Infinite Loop', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::SELECT,
					'default' 	=> 'yes',
					'options' 	=> [
						'yes' 	=> __( 'Yes', 'larisdigital-wp' ),
						'no' 	=> __( 'No', 'larisdigital-wp' ),
					],
					'condition'	=> [
						'carousel'	=> [ 'yes' ],
					],
				]
			);

			$this->add_control(
				'effect',
				[
					'label' 	=> __( 'Effect', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::SELECT,
					'default' 	=> 'slide',
					'options' 	=> [
						'slide' => __( 'Slide', 'larisdigital-wp' ),
						'fade' 	=> __( 'Fade', 'larisdigital-wp' ),
					],
					'condition'	=> [
						'carousel'	=> [ 'yes' ],
					],
				]
			);

			$this->add_control(
				'speed',
				[
					'label' 	=> __( 'Animation Speed', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::NUMBER,
					'default' 	=> 500,
					'condition'	=> [
						'carousel'	=> [ 'yes' ],
					],
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_testimonials',
			[
				'label'	=> __( 'Testimonials', 'larisdigital-wp' ),
				'tab'	=> Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_responsive_control(
				'testimonials_align',
				[
					'label' 	=> __( 'Alignment', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::CHOOSE,
					'options' 	=> [
						'left' 		=> [
							'title' => __( 'Left', 'larisdigital-wp' ),
							'icon' 	=> 'eicon-text-align-left',
						],
						'center' 	=> [
							'title' => __( 'Center', 'larisdigital-wp' ),
							'icon' 	=> 'eicon-text-align-center',
						],
						'right' 	=> [
							'title' => __( 'Right', 'larisdigital-wp' ),
							'icon' 	=> 'eicon-text-align-right',
						],
						'justify' => [
							'title' => __( 'Justified', 'larisdigital-wp' ),
							'icon' => 'eicon-text-align-justify',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .tp-testimonials-wrapper' => 'text-align: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'item_gap',
				[
					'label' 	=> __( 'Item Gap', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::SLIDER,
					'default' 	=> [
						'size' 	=> 10,
					],
					'range' 	=> [
						'px'	=> [
							'min'	=> 0,
							'max'	=> 100,
						],
					],
					'selectors'	=> [
						'{{WRAPPER}} .tp-testimonials' => 'margin: 0 -{{SIZE}}px',
						'(desktop){{WRAPPER}} .tp-testimonial-item' => 'width: calc( 100% / {{columns.SIZE}} ); padding: {{SIZE}}px',
						'(tablet){{WRAPPER}} .tp-testimonial-item' => 'width: calc( 100% / {{columns_tablet.SIZE}} ); padding: {{SIZE}}px',
						'(mobile){{WRAPPER}} .tp-testimonial-item' => 'width: calc( 100% / {{columns_mobile.SIZE}} ); padding: {{SIZE}}px',
					],
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_quote',
			[
				'label' => __( 'Testimonial', 'larisdigital-wp' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'quote_color',
				[
					'label' 	=> __( 'Text Color', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tp-testimonials .tp-testimonial-text' => 'color: {{VALUE}};',
					],
					'global' => [
						'default' => Global_Colors::COLOR_SECONDARY,
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 		=> 'quote_typography',
					'selector' 	=> '{{WRAPPER}} .tp-testimonials .tp-testimonial-text',
					'global' => [
						'default' => Global_Typography::TYPOGRAPHY_TEXT,
					],
				]
			);

			$this->add_responsive_control(
				'quote_box_margin',
				[
					'label' 		=> __( 'Margin', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px', '%' ],
					'selectors' 	=> [
						'{{WRAPPER}} .tp-testimonials .tp-testimonial-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_name_job',
			[
				'label' => __( 'Name & Job', 'larisdigital-wp' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'heading_style_name',
				[
					'label' 	=> __( 'Name', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_control(
				'quote_name_color',
				[
					'label' 	=> __( 'Text Color', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tp-testimonials .tp-testimonial-name' => 'color: {{VALUE}};',
					],
					'global' => [
						'default' => Global_Colors::COLOR_SECONDARY,
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 		=> 'quote_name_typography',
					'selector' 	=> '{{WRAPPER}} .tp-testimonials .tp-testimonial-name',
					'global' => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
				]
			);

			$this->add_control(
				'heading_style_job',
				[
					'label' 	=> __( 'Job', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_control(
				'quote_job_color',
				[
					'label' 	=> __( 'Text Color', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tp-testimonials .tp-testimonial-job' => 'color: {{VALUE}};',
					],
					'global' => [
						'default' => Global_Colors::COLOR_TEXT,
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 		=> 'quote_job_typography',
					'selector' 	=> '{{WRAPPER}} .tp-testimonials .tp-testimonial-job',
					'global' => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_avatar',
			[
				'label'	=> __( 'Image', 'larisdigital-wp' ),
				'tab'	=> Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' 		=> 'avatar_border',
					'label' 	=> __( 'Image Border', 'larisdigital-wp' ),
					'selector' 	=> '{{WRAPPER}} .tp-testimonials .tp-testimonial-avatar img',
				]
			);

			$this->add_control(
				'avatar_border_radius',
				[
					'label' 		=> __( 'Border Radius', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px', '%' ],
					'selectors' 	=> [
						'{{WRAPPER}} .tp-testimonials .tp-testimonial-avatar img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' 		=> 'avatar_box_shadow',
					'selector' 	=> '{{WRAPPER}} .tp-testimonials .tp-testimonial-avatar img',
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_navigation',
			[
				'label' => __( 'Slider / Navigation', 'larisdigital-wp' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition'	=> [
					'carousel'	=> [ 'yes' ],
				],
			]
		);

			$this->add_control(
				'heading_style_arrows',
				[
					'label' 	=> __( 'Arrows', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::HEADING,
					'separator' => 'before',
					'condition'	=> [
						'carousel'	=> [ 'yes' ],
					],
				]
			);

			$this->add_control(
				'arrows_color',
				[
					'label' 	=> __( 'Arrows Color', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tp-testimonials-wrapper.tp-testimonials-carousel .elementor-swiper-button' => 'color: {{VALUE}};',
					],
					'condition'	=> [
						'carousel'	=> [ 'yes' ],
					],
				]
			);

			$this->add_control(
				'arrows_position',
				[
					'label' 	=> __( 'Arrows Position', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::SELECT,
					'default' 	=> 'outside',
					'options' 	=> [
						'inside' 	=> __( 'Inside', 'larisdigital-wp' ),
						'outside' 	=> __( 'Outside', 'larisdigital-wp' ),
					],
					'condition' => [
						'carousel'	=> [ 'yes' ],
						'navigation'	=> [ 'arrows', 'both' ],
					],
				]
			);

			$this->add_responsive_control(
				'arrows_size',
				[
					'label' 	=> __( 'Arrows Size', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::SLIDER,
					'default' 	=> [
						'size'	=> 35,
					],
					'range' 	=> [
						'px' 	=> [
							'min'	=> 0,
							'max'	=> 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .tp-testimonials-wrapper.tp-testimonials-carousel .elementor-swiper-button' => 'font-size: {{SIZE}}px',
					],
					'condition'	=> [
						'carousel'	=> [ 'yes' ],
					],
				]
			);

			$this->add_control(
				'heading_style_dots',
				[
					'label' 	=> __( 'Dots', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::HEADING,
					'separator' => 'before',
					'condition'	=> [
						'carousel'	=> [ 'yes' ],
					],
				]
			);

			$this->add_control(
				'dots_color',
				[
					'label' 	=> __( 'Dots Color', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tp-testimonials-wrapper.tp-testimonials-carousel .swiper-pagination .swiper-pagination-bullet' => 'background-color: {{VALUE}}; opacity: 1;',
					],
					'condition'	=> [
						'carousel'	=> [ 'yes' ],
					],
				]
			);

			$this->add_control(
				'dots_active_color',
				[
					'label' 	=> __( 'Dots Color (active)', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tp-testimonials-wrapper.tp-testimonials-carousel .swiper-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'background-color: {{VALUE}};',
					],
					'condition'	=> [
						'carousel'	=> [ 'yes' ],
					],
				]
			);

			$this->add_control(
				'dots_position',
				[
					'label' 	=> __( 'Dots Position', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::SELECT,
					'default' 	=> 'outside',
					'options'	=> [
						'outside'	=> __( 'Outside', 'larisdigital-wp' ),
						'inside'	=> __( 'Inside', 'larisdigital-wp' ),
					],
					'condition'	=> [
						'carousel'	=> [ 'yes' ],
						'navigation'	=> [ 'dots', 'both' ],
					],
				]
			);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings();

		if ( empty( $settings['testimonials'] ) ) {
			return;
		}

		$this->add_render_attribute( 'wrapper', 'class', 'tp-testimonials-wrapper' );

		$this->add_render_attribute( 'wrapper', 'class', 'grid-columns-' .$settings['columns'] );

		$this->add_render_attribute( 'carousel', 'class', 'tp-testimonials' );

		if ( 'yes' == $settings['carousel'] ) {

			$swiper_class = Plugin::$instance->experiments->is_feature_active( 'e_swiper_latest' ) ? 'swiper' : 'swiper-container';

			$this->add_render_attribute( [
				'carousel' => [
					'class' => 'swiper-wrapper',
				],
				'wrapper' => [
					'class' => 'tp-testimonials-carousel '.$swiper_class,
				],
			] );

			$carousel_options = [
				'slides_to_show_desktop' 	=> !empty($settings['columns']) ? $settings['columns'] : 1,
				'slides_to_show_tablet'		=> !empty($settings['columns_tablet']) ? $settings['columns_tablet'] : 1,
				'slides_to_show_mobile'		=> !empty($settings['columns_mobile']) ? $settings['columns_mobile'] : 1,
				'slides_to_scroll_desktop' 	=> !empty($settings['slides_to_scroll']) ? $settings['slides_to_scroll'] : 1,
				'slides_to_scroll_tablet' 	=> !empty($settings['slides_to_scroll_tablet']) ? $settings['slides_to_scroll_tablet'] : 1,
				'slides_to_scroll_mobile' 	=> !empty($settings['slides_to_scroll_mobile']) ? $settings['slides_to_scroll_mobile'] : 1,
				'adaptiveHeight' 			=> ( 'no' !== $settings['adaptive_height'] ? true : false ),
				'autoplaySpeed' 			=> absint( $settings['autoplay_speed'] ),
				'autoplay' 					=> ( 'no' !== $settings['autoplay'] ? true : false ),
				'infinite' 					=> ( 'no' !== $settings['infinite'] ? true : false ),
				'pauseOnHover' 				=> ( 'no' !== $settings['pause_on_hover'] ? true : false ),
				'speed' 					=> absint( $settings['speed'] ),
				'arrows' 					=> ( in_array( $settings['navigation'], [ 'arrows', 'both' ] ) ? true : false ),
				'dots' 						=> ( in_array( $settings['navigation'], [ 'dots', 'both' ] ) ? true : false ),
				'fade' 						=> ( 'fade' == $settings['effect'] ? true : false ),
				'rtl' 						=> ( is_rtl() ? true : false ),
				
			];

			$carousel_classes 	= [];
			$carousel_classes[] = 'tp-swiper-on';

			if ( in_array( $settings['navigation'], [ 'arrows', 'both' ] ) ) {
				$show_arrows = true;
				$carousel_classes[] = 'navigation-arrows-' . $settings['arrows_position'];
			}
			else {
				$show_arrows = false;
			}

			if ( in_array( $settings['navigation'], [ 'dots', 'both' ] ) ) {
				$show_dots = true;
				$carousel_classes[] = 'navigation-dots-' . $settings['dots_position'];
			}
			else {
				$show_dots = false;
			}

			$this->add_render_attribute( 'wrapper', 'class', $carousel_classes );

			$this->add_render_attribute( 'carousel', [
				'data-slider_options' => wp_json_encode( $carousel_options ),
			] );
		} else {
			$this->add_render_attribute( 'carousel', 'class', 'clearfix' );
		}

		$slides_count = count( $settings['testimonials'] );

		?>
			
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<div <?php echo $this->get_render_attribute_string( 'carousel' ); ?>>
				<?php
				foreach ( $settings['testimonials'] as $testimonial ) {
					?>
					<div class="tp-testimonial-item swiper-slide">
						<blockquote class="tp-testimonial-text">
							<?php echo wpautop( $testimonial['quote'] ); ?>
						</blockquote>
						<div class="tp-testimonial-details">

							<div class="tp-testimonial-avatar">
								<?php
									if ( $testimonial['avatar']['id'] ) {
										echo wp_get_attachment_image( $testimonial['avatar']['id'], array( 50,50 ) );
									} else {
										echo '<img width="50" height="50" src="' . Utils::get_placeholder_image_src() .'">';
									}
								?>
							</div>
							<div class="tp-testimonial-name-job">
								<div class="tp-testimonial-name">
									<?php echo esc_html( $testimonial['name'] ); ?>
								</div>
								<div class="tp-testimonial-job">
									<?php echo esc_html( $testimonial['job'] ); ?>
								</div>
							</div>

						</div>
					</div>
					<?php
				}
				?>
			</div>
			<?php if ( 'yes' == $settings['carousel'] && 1 < $slides_count ) : ?>
				<?php if ( $show_dots ) : ?>
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
				<?php endif; ?>
			<?php endif; ?>
		</div>

		<?php
	}

}