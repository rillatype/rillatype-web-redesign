<?php
namespace ElementorTokoPress\Widgets;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class TP_Image_Gallery extends Widget_Base {

	public function get_name() {
		return 'tp_image_gallery';
	}

	public function get_title() {
		return __( 'TP - Image Gallery', 'larisdigital-wp' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_categories() {
		return [ 'tokopress' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_images',
			[
				'label' => __( 'Images', 'larisdigital-wp' ),
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label' => __( 'Columns', 'larisdigital-wp' ),
				'type' => Controls_Manager::SELECT,
				'desktop_default' => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options' => [
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
			'image',
			[
				'label' => __( 'Choose Image', 'larisdigital-wp' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'link_to',
			[
				'label' => __( 'Link to', 'larisdigital-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none' => __( 'None', 'larisdigital-wp' ),
					'file' => __( 'Media File', 'larisdigital-wp' ),
					'custom' => __( 'Custom URL', 'larisdigital-wp' ),
				],
			]
		);

		$repeater->add_control(
			'link',
			[
				'label' => __( 'Link to', 'larisdigital-wp' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'http://your-link.com', 'larisdigital-wp' ),
				'condition' => [
					'link_to' => 'custom',
				],
				'show_label' => false,
			]
		);

		$repeater->add_control(
			'caption',
			[
				'label' => __( 'Caption', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter your image caption', 'larisdigital-wp' ),
				'title' => __( 'Input image caption here', 'larisdigital-wp' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'images',
			[
				'label' => __( 'Images', 'larisdigital-wp' ),
				'type' => Controls_Manager::REPEATER,
				'show_label' => true,
				'default' => [
					[
						'image' => [ 'url' => Utils::get_placeholder_image_src() ],
						'link_to' => 'none',
						'link' => '',
						'caption' => '',
					],
					[
						'image' => [ 'url' => Utils::get_placeholder_image_src() ],
						'link_to' => 'none',
						'link' => '',
						'caption' => '',
					],
					[
						'image' => [ 'url' => Utils::get_placeholder_image_src() ],
						'link_to' => 'none',
						'link' => '',
						'caption' => '',
					],
				],
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ caption }}}',
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'image', // Actually its `image_size`
				'label' => __( 'Image Size', 'larisdigital-wp' ),
				'default' => 'thumbnail',
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
			'section_slider_options',
			[
				'label' => __( 'Slider / Carousel Options', 'larisdigital-wp' ),
			]
		);

		$this->add_control(
			'carousel',
			[
				'label'	=> __( 'Carousel', 'larisdigital-wp' ),
				'type'	=> Controls_Manager::SWITCHER,
				'label_on'	=> __( 'Yes', 'larisdigital-wp' ),
				'label_off'	=> __( 'No', 'larisdigital-wp' ),
				'return_value'	=> 'yes'
			]
		);

		$this->add_responsive_control(
			'slides_to_scroll',
			[
				'label' => __( 'Slides To Scroll', 'larisdigital-wp' ),
				'type' => Controls_Manager::SELECT,
				'desktop_default' => '1',
				'tablet_default' => '1',
				'mobile_default' => '1',
				'options' => [
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
				'label' => __( 'Adaptive Height', 'larisdigital-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'yes',
				'options' => [
					'yes' => __( 'Yes', 'larisdigital-wp' ),
					'no' => __( 'No', 'larisdigital-wp' ),
				],
				'condition'	=> [
					'carousel'	=> [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'navigation',
			[
				'label' => __( 'Navigation', 'larisdigital-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'both',
				'options' => [
					'both' => __( 'Arrows and Dots', 'larisdigital-wp' ),
					'arrows' => __( 'Arrows', 'larisdigital-wp' ),
					'dots' => __( 'Dots', 'larisdigital-wp' ),
					'none' => __( 'None', 'larisdigital-wp' ),
				],
				'condition'	=> [
					'carousel'	=> [ 'yes' ],
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
				'condition'	=> [
					'carousel'	=> [ 'yes' ],
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
				'condition'	=> [
					'carousel'	=> [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label' => __( 'Autoplay Speed', 'larisdigital-wp' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 5000,
				'condition'	=> [
					'carousel'	=> [ 'yes' ],
				],
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
				'condition'	=> [
					'carousel'	=> [ 'yes' ],
				],
			]
		);

		// $this->add_control(
		// 	'effect',
		// 	[
		// 		'label' => __( 'Effect', 'larisdigital-wp' ),
		// 		'type' => Controls_Manager::SELECT,
		// 		'default' => 'slide',
		// 		'options' => [
		// 			'slide' => __( 'Slide', 'larisdigital-wp' ),
		// 			'fade' => __( 'Fade', 'larisdigital-wp' ),
		// 		],
		//		'condition'	=> [
		//			'carousel'	=> [ 'yes' ],
		//		],
		// 	]
		// );

		$this->add_control(
			'speed',
			[
				'label' => __( 'Animation Speed', 'larisdigital-wp' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 500,
				'condition'	=> [
					'carousel'	=> [ 'yes' ],
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_image',
			[
				'label' => __( 'Image', 'larisdigital-wp' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'item_gap',
			[
				'label' => __( 'Item Gap', 'larisdigital-wp' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'(desktop){{WRAPPER}} .tp-image-gallery-item' => 'width: calc( 100% / {{columns.SIZE}} ); border: {{SIZE}}px solid transparent',
					'(tablet){{WRAPPER}} .tp-image-gallery-item' => 'width: calc( 100% / {{columns_tablet.SIZE}} ); border: {{SIZE}}px solid transparent',
					'(mobile){{WRAPPER}} .tp-image-gallery-item' => 'width: calc( 100% / {{columns_mobile.SIZE}} ); border: {{SIZE}}px solid transparent',
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => __( 'Hover Animation', 'larisdigital-wp' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'label' => __( 'Image Border', 'larisdigital-wp' ),
				'selector' => '{{WRAPPER}} .tp-image-gallery-image img',
			]
		);

		$this->add_control(
			'image_border_radius',
			[
				'label' => __( 'Border Radius', 'larisdigital-wp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tp-image-gallery-image img, {{WRAPPER}} .tp-image-gallery-caption-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'image_box_shadow',
				'selector' => '{{WRAPPER}} .tp-image-gallery-image img',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_caption_box',
			[
				'label' => __( 'Caption Box (Image Overlay)', 'larisdigital-wp' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'label' => __( 'Background Type', 'larisdigital-wp' ),
				'name' => 'caption_box_background',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tp-image-gallery-caption-inner',
			]
		);

		$this->add_responsive_control(
			'caption_box_margin',
			[
				'label' => __( 'Margin', 'larisdigital-wp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tp-image-gallery-caption-inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'caption_box_padding',
			[
				'label' => __( 'Padding', 'larisdigital-wp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tp-image-gallery-caption-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_caption',
			[
				'label' => __( 'Caption Text', 'larisdigital-wp' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'caption_horizontal_position',
			[
				'label' => __( 'Horizontal Position', 'larisdigital-wp' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'default' => 'center',
				'options' => [
					'left' => [
						'title' => __( 'Left', 'larisdigital-wp' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'larisdigital-wp' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'larisdigital-wp' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'prefix_class' => 'tp-image-gallery-caption-pos-h-',
			]
		);

		$this->add_control(
			'caption_vertical_position',
			[
				'label' => __( 'Vertical Position', 'larisdigital-wp' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'default' => 'middle',
				'options' => [
					'top' => [
						'title' => __( 'Top', 'larisdigital-wp' ),
						'icon' => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => __( 'Middle', 'larisdigital-wp' ),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'larisdigital-wp' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'prefix_class' => 'tp-image-gallery-caption-pos-v-',
			]
		);

		$this->add_control(
			'caption_text_align',
			[
				'label' => __( 'Text Align', 'larisdigital-wp' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
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
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .tp-image-gallery-caption-text' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'caption_background',
			[
				'label' => __( 'Background Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-image-gallery-caption-text' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'caption_padding',
			[
				'label' => __( 'Padding', 'larisdigital-wp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tp-image-gallery-caption-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'caption_border_radius',
			[
				'label' => __( 'Border Radius', 'larisdigital-wp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tp-image-gallery-caption-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'caption_color',
			[
				'label' => __( 'Text Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-image-gallery-caption' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'caption_typography',
				'selector' => '{{WRAPPER}} .tp-image-gallery-caption',
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
				'label' => __( 'Arrows', 'larisdigital-wp' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition'	=> [
					'carousel'	=> [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'arrows_color',
			[
				'label' => __( 'Arrows Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-image-gallery-wrapper.tp-image-gallery-carousel .elementor-swiper-button' => 'color: {{VALUE}};',
				],
				'condition'	=> [
					'carousel'	=> [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'arrows_position',
			[
				'label' => __( 'Arrows Position', 'larisdigital-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'outside',
				'options' => [
					'inside' => __( 'Inside', 'larisdigital-wp' ),
					'outside' => __( 'Outside', 'larisdigital-wp' ),
				],
				'condition' => [
					'carousel'	=> [ 'yes' ],
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_responsive_control(
			'arrows_size',
			[
				'label' => __( 'Arrows Size', 'larisdigital-wp' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 35,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tp-image-gallery-wrapper.tp-image-gallery-carousel .elementor-swiper-button' => 'font-size: {{SIZE}}px',
				],
				'condition'	=> [
					'carousel'	=> [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'heading_style_dots',
			[
				'label' => __( 'Dots', 'larisdigital-wp' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition'	=> [
					'carousel'	=> [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'dots_color',
			[
				'label' => __( 'Dots Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-image-gallery-wrapper.tp-image-gallery-carousel .swiper-pagination .swiper-pagination-bullet' => 'background-color: {{VALUE}}; opacity:1;',
				],
				'condition'	=> [
					'carousel'	=> [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'dots_active_color',
			[
				'label' => __( 'Dots Color (active)', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-image-gallery-wrapper.tp-image-gallery-carousel .swiper-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'background-color: {{VALUE}};',
				],
				'condition'	=> [
					'carousel'	=> [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'dots_position',
			[
				'label' => __( 'Dots Position', 'larisdigital-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'outside',
				'options' => [
					'outside' => __( 'Outside', 'larisdigital-wp' ),
					'inside' => __( 'Inside', 'larisdigital-wp' ),
				],
				'condition' => [
					'carousel'	=> [ 'yes' ],
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings();

		if ( empty( $settings['images'] ) ) {
			return;
		}

		$this->add_render_attribute( 'wrapper', 'class', 'tp-image-gallery-wrapper' );

		$this->add_render_attribute( 'wrapper', 'class', 'grid-columns-' . $settings['columns'] );

		$this->add_render_attribute( 'carousel', 'class', 'tp-image-gallery' );

		if ( $settings['carousel'] == 'yes' ) {

			$swiper_class = Plugin::$instance->experiments->is_feature_active( 'e_swiper_latest' ) ? 'swiper' : 'swiper-container';

			$this->add_render_attribute( [
				'carousel' => [
					'class' => 'swiper-wrapper',
				],
				'wrapper' => [
					'class' => 'tp-image-gallery-carousel '.$swiper_class,
				],
			] );

			$carousel_options = [
				'slides_to_show_desktop' 	=> !empty($settings['columns']) ? $settings['columns'] : 3,
				'slides_to_show_tablet'		=> !empty($settings['columns_tablet']) ? $settings['columns_tablet'] : 2,
				'slides_to_show_mobile'		=> !empty($settings['columns_mobile']) ? $settings['columns_mobile'] : 1,
				'slides_to_scroll_desktop'	=> !empty($settings['slides_to_scroll']) ? $settings['slides_to_scroll'] : 1,
				'slides_to_scroll_tablet' 	=> !empty($settings['slides_to_scroll_tablet']) ? $settings['slides_to_scroll_tablet'] : 1,
				'slides_to_scroll_mobile' 	=> !empty($settings['slides_to_scroll_mobile']) ? $settings['slides_to_scroll_mobile'] : 1,
				'adaptiveHeight'           => ( 'no' !== $settings['adaptive_height'] ? true : false ),
				'autoplaySpeed'            => absint( $settings['autoplay_speed'] ),
				'autoplay'                 => ( 'no' !== $settings['autoplay'] ? true : false ),
				'infinite'                 => ( 'no' !== $settings['infinite'] ? true : false ),
				'pauseOnHover'             => ( 'no' !== $settings['pause_on_hover'] ? true : false ),
				'speed'                    => absint( $settings['speed'] ),
				'arrows'                   => ( in_array( $settings['navigation'], [ 'arrows', 'both' ] ) ? true : false ),
				'dots'                     => ( in_array( $settings['navigation'], [ 'dots', 'both' ] ) ? true : false ),
				'fade'                     => false,
				'rtl'                      => ( is_rtl() ? true : false ),
				
			];

			$carousel_classes = [];
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

			$this->add_render_attribute( 'wrapper', ['class' => $carousel_classes] );

			if ( $settings['carousel'] == "yes" ) {
				$this->add_render_attribute( 'carousel', ['data-slider_options' => wp_json_encode( $carousel_options )] );
			}
		}
		else {
			$this->add_render_attribute( 'carousel', 'class', 'clearfix' );
		}

		$slides_count = count( $settings['images'] );

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<div <?php echo $this->get_render_attribute_string( 'carousel' ); ?>>
			<?php 

			foreach ( $settings['images'] as $image ) {

				if ( empty( $image['image']['url'] ) ) {
					continue;
				}

				if ( isset($settings['image_size']) ) {
					$image['image_size'] = $settings['image_size'];
				}

				if ( isset($settings['image_custom_dimension']) ) {
					$image['image_custom_dimension'] = $settings['image_custom_dimension'];
				}

				$has_caption = ! empty( $image['caption'] );

				if ( ! empty( $settings['hover_animation'] ) ) {
					$this->add_render_attribute( 'wrapper', 'class', 'elementor-animation-'.$settings['hover_animation'] );
				}

				$link = $this->get_link_url( $image );
				?>

				<div class="tp-image-gallery-item <?php if ( ! empty( $settings['hover_animation'] ) ) echo 'elementor-animation-'.$settings['hover_animation']; ?> swiper-slide">

					<?php if ( $link ) : ?>
						<a href="<?php echo $link['url']; ?>" <?php if ( ! empty( $link['is_external'] ) ) echo 'target="_blank"'; ?>>
					<?php endif; ?>

					<div class="tp-image-gallery-image">
							<?php echo Group_Control_Image_Size::get_attachment_image_html( $image ); ?>
					</div>

					<?php if ( $has_caption ) : ?>
						<div class="tp-image-gallery-caption-box">
							<div class="tp-image-gallery-caption-inner">
								<div class="tp-image-gallery-caption-text">
									<?php if ( $image['caption'] ) : ?>
										<div class="tp-image-gallery-caption">
											<?php echo $image['caption']; ?>
										</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
					<?php endif; ?>

					<?php if ( $link ) : ?>
						</a>
					<?php endif; ?>

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

	private function get_link_url( $instance ) {
		if ( 'none' === $instance['link_to'] ) {
			return false;
		}

		if ( 'custom' === $instance['link_to'] ) {
			if ( empty( $instance['link']['url'] ) ) {
				return false;
			}
			return $instance['link'];
		}

		return [
			'url' => $instance['image']['url'],
		];
	}
}
