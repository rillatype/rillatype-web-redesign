<?php
namespace ElementorTokoPress\Widgets;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Utils;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class TP_Slider_Image extends Widget_Base {

	public function get_name() {
		return 'tp_slider_image';
	}

	public function get_title() {
		return __( 'TP - Image Slider', 'larisdigital-wp' );
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
				'label'	=> __( 'Slider Items', 'larisdigital-wp' ),
			]
		);

			$repeater = new Repeater();

			$repeater->add_control(
				'image',
				[
					'label' 	=> __( 'Image', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::MEDIA,
					'default' 	=> [
						'url' 	=> Utils::get_placeholder_image_src(),
					],
				]
			);

			$repeater->add_control(
				'slider_caption',
				[
					'label'         => __( 'Caption', 'larisdigital-wp' ),
					'type'          => Controls_Manager::TEXT,
					'default'       => __( 'Slider Caption', 'larisdigital-wp' ),
					'label_block'	=> true,
				]
			);

			$repeater->add_control(
				'slider_link',
				[
					'label'         => __( 'Link', 'larisdigital-wp' ),
					'type'          => Controls_Manager::URL,
					'placeholder'	=> __( 'http://your-link.com', 'larisdigital-wp' ),
				]
			);

			$this->add_control(
				'slider',
				[
					'label'         => __( 'Slider Items', 'larisdigital-wp' ),
					'type'          => Controls_Manager::REPEATER,
					'show_label'	=> true,
					'default'       => [
						[
							'image'             => [ 'url' => Utils::get_placeholder_image_src() ],
							'slider_caption'	=> __( 'Slider 1 Caption', 'larisdigital-wp' ),
							'slider_link'       => '#',
						],
						[
							'image'             => [ 'url' => Utils::get_placeholder_image_src() ],
							'slider_caption'    => __( 'Slider 2 Caption', 'larisdigital-wp' ),
							'slider_link'       => '#',
						],
						[
							'image'             => [ 'url' => Utils::get_placeholder_image_src() ],
							'slider_caption'    => __( 'Slider 3 Caption', 'larisdigital-wp' ),
							'slider_link'       => '#',
						],
					],
					'fields'        => $repeater->get_controls(),
					'title_field'   => '{{{ slider_caption }}}',
				]
			);

			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				[
					'name'      => 'image', // Actually its `image_size`
					'label'     => __( 'Image Size', 'larisdigital-wp' ),
					'default'	=> 'large',
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_slider_options',
			[
				'label'	=> __( 'Slider Options', 'larisdigital-wp' ),
			]
		);

			$this->add_control(
				'adaptive_height',
				[
					'label'     => __( 'Adaptive Height', 'larisdigital-wp' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'yes',
					'options'   => [
						'yes'	=> __( 'Yes', 'larisdigital-wp' ),
						'no'	=> __( 'No', 'larisdigital-wp' ),
					],
				]
			);

			$this->add_control(
				'image_stretch',
				[
					'label'     => __( 'Image Stretch', 'larisdigital-wp' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'yes',
					'options'   => [
						'yes'	=> __( 'Yes', 'larisdigital-wp' ),
						'no'	=> __( 'No', 'larisdigital-wp' ),
					],
				]
			);

			$this->add_control(
				'navigation',
				[
					'label'      => __( 'Navigation', 'larisdigital-wp' ),
					'type'       => Controls_Manager::SELECT,
					'default'    => 'both',
					'options'    => [
						'both'      => __( 'Arrows and Dots', 'larisdigital-wp' ),
						'arrows'	=> __( 'Arrows', 'larisdigital-wp' ),
						'dots'      => __( 'Dots', 'larisdigital-wp' ),
						// 'thumb'	    => __( 'Image Thumbnail', 'larisdigital-wp' ),
						'none'      => __( 'None', 'larisdigital-wp' ),
					],
				]
			);

			$this->add_control(
				'pause_on_hover',
				[
					'label'     => __( 'Pause on Hover', 'larisdigital-wp' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'yes',
					'options'   => [
						'yes'   => __( 'Yes', 'larisdigital-wp' ),
						'no'    => __( 'No', 'larisdigital-wp' ),
					],
				]
			);

			$this->add_control(
				'autoplay',
				[
					'label'     => __( 'Autoplay', 'larisdigital-wp' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'yes',
					'options'	=> [
						'yes'	=> __( 'Yes', 'larisdigital-wp' ),
						'no'	=> __( 'No', 'larisdigital-wp' ),
					],
				]
			);

			$this->add_control(
				'autoplay_speed',
				[
					'label'     => __( 'Autoplay Speed', 'larisdigital-wp' ),
					'type'      => Controls_Manager::NUMBER,
					'default'	=> 5000,
				]
			);

			$this->add_control(
				'infinite',
				[
					'label'     => __( 'Infinite Loop', 'larisdigital-wp' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'yes',
					'options'	=> [
						'yes'	=> __( 'Yes', 'larisdigital-wp' ),
						'no'	=> __( 'No', 'larisdigital-wp' ),
					],
				]
			);

			$this->add_control(
				'effect',
				[
					'label'     => __( 'Effect', 'larisdigital-wp' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'slide',
					'options'	=> [
						'slide'	=> __( 'Slide', 'larisdigital-wp' ),
						'fade'	=> __( 'Fade', 'larisdigital-wp' ),
					],
				]
			);

			$this->add_control(
				'speed',
				[
					'label'     => __( 'Animation Speed', 'larisdigital-wp' ),
					'type'      => Controls_Manager::NUMBER,
					'default'	=> 500,
				]
			);

		$this->end_controls_section();

		// $this->start_controls_section(
		// 	'section_slider_thumb_nav',
		// 	[
		// 		'label'	    => __( 'Thumbnail Image Options', 'larisdigital-wp' ),
		// 		'condition'	=> [
		// 			'navigation'	=> [ 'thumb' ],
		// 		],
		// 	]	
		// );

		// 	$this->add_control(
		// 		'columns',
		// 		[
		// 			'label'     => __( 'Columns', 'larisdigital-wp' ),
		// 			'type'      => Controls_Manager::SELECT,
		// 			'default'   => '5',
		// 			'options'	=> [
		// 				'1' => '1',
		// 				'2' => '2',
		// 				'3' => '3',
		// 				'4' => '4',
		// 				'5' => '5',
		// 				'6' => '6',
		// 			],
		// 		]
		// 	);

		// $this->end_controls_section();

		$this->start_controls_section(
			'section_style_caption',
			[
				'label'	=> __( 'Image Caption', 'larisdigital-wp' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'caption_horizontal_position',
				[
					'label'         => __( 'Horizontal Position', 'larisdigital-wp' ),
					'type'          => Controls_Manager::CHOOSE,
					'label_block'   => false,
					'default'       => 'center',
					'options'       => [
						'left'      => [
							'title' => __( 'Left', 'larisdigital-wp' ),
							'icon'	=> 'eicon-h-align-left',
						],
						'center'	=> [
							'title' => __( 'Center', 'larisdigital-wp' ),
							'icon'	=> 'eicon-h-align-center',
						],
						'right'     => [
							'title' => __( 'Right', 'larisdigital-wp' ),
							'icon'	=> 'eicon-h-align-right',
						],
					],
					'prefix_class'  => 'tp-image-slider-caption-pos-h-',
				]
			);

			$this->add_control(
				'caption_vertical_position',
				[
					'label'         => __( 'Vertical Position', 'larisdigital-wp' ),
					'type'          => Controls_Manager::CHOOSE,
					'label_block'	=> false,
					'default'       => 'bottom',
					'options'       => [
						'top'       => [
							'title'	=> __( 'Top', 'larisdigital-wp' ),
							'icon'	=> 'eicon-v-align-top',
						],
						'middle'    => [
							'title' => __( 'Middle', 'larisdigital-wp' ),
							'icon'	=> 'eicon-v-align-middle',
						],
						'bottom'    => [
							'title' => __( 'Bottom', 'larisdigital-wp' ),
							'icon'	=> 'eicon-v-align-bottom',
						],
					],
					'prefix_class'	=> 'tp-image-slider-caption-pos-v-',
				]
			);

			$this->add_responsive_control(
				'caption_padding',
				[
					'label'         => __( 'Padding', 'larisdigital-wp' ),
					'type'          => Controls_Manager::DIMENSIONS,
					'size_units'    => [ 'px', 'em', '%' ],
					'selectors'     => [
						'{{WRAPPER}} .tp-image-slider-wrapper .tp-slide-image-caption' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'caption_margin',
				[
					'label'         => __( 'Margin', 'larisdigital-wp' ),
					'type'          => Controls_Manager::DIMENSIONS,
					'size_units'	=> [ 'px', 'em', '%' ],
					'selectors'     => [
						'{{WRAPPER}} .tp-image-slider-wrapper .tp-slide-image-caption' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'caption_background',
				[
					'label'     => __( 'Background Color', 'larisdigital-wp' ),
					'type'      => Controls_Manager::COLOR,
					'selectors'	=> [
						'{{WRAPPER}} .tp-image-slider-wrapper .tp-slide-image-caption' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'caption_color',
				[
					'label'     => __( 'Text Color', 'larisdigital-wp' ),
					'type'      => Controls_Manager::COLOR,
					'selectors'	=> [
						'{{WRAPPER}} .tp-image-slider-wrapper .tp-slide-image-caption' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'caption_typography',
					'label'     => __( 'Typography', 'larisdigital-wp' ),
					'global' => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector'  => '{{WRAPPER}} .tp-image-slider-wrapper .tp-slide-image-caption',
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_navigation',
			[
				'label'     => __( 'Navigation', 'larisdigital-wp' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition'	=> [
					'navigation'	=> [ 'arrows', 'dots', 'both' ],
				],
			]
		);

			$this->add_control(
				'heading_style_arrows',
				[
					'label'     => __( 'Arrows', 'larisdigital-wp' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition'	=> [
						'navigation'	=> [ 'arrows', 'both' ],
					],
				]
			);

			$this->add_control(
				'arrows_color',
				[
					'label'     => __( 'Arrows Color', 'larisdigital-wp' ),
					'type'      => Controls_Manager::COLOR,
					'selectors'	=> [
						'{{WRAPPER}} .tp-image-slider-wrapper .elementor-swiper-button' => 'color: {{VALUE}};',
					],
					'condition' => [
						'navigation'	=> [ 'arrows', 'both' ],
					],
				]
			);

			$this->add_control(
				'arrows_position',
				[
					'label'     => __( 'Arrows Position', 'larisdigital-wp' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'inside',
					'options'   => [
						'inside'	=> __( 'Inside', 'larisdigital-wp' ),
						'outside'	=> __( 'Outside', 'larisdigital-wp' ),
					],
					'condition'	=> [
						'navigation'	=> [ 'arrows', 'both' ],
					],
				]
			);

			$this->add_control(
				'arrows_size',
				[
					'label'     => __( 'Arrows Size', 'larisdigital-wp' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px'	=> [
							'min'	=> 20,
							'max'	=> 60,
						],
					],
					'selectors'	=> [
						'{{WRAPPER}} .tp-image-slider-wrapper .elementor-swiper-button' => 'font-size: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'navigation'	=> [ 'arrows', 'both' ],
					],
				]
			);

			$this->add_control(
				'heading_style_dots',
				[
					'label'     => __( 'Dots', 'larisdigital-wp' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'navigation'	=> [ 'dots', 'both' ],
					],
				]
			);

			$this->add_control(
				'dots_color',
				[
					'label'     => __( 'Dots Color', 'larisdigital-wp' ),
					'type'      => Controls_Manager::COLOR,
					'selectors'	=> [
						'{{WRAPPER}} .tp-image-slider-wrapper .swiper-pagination .swiper-pagination-bullet' => 'background-color: {{VALUE}}; opacity:1;',
					],
					'condition'	=> [
						'navigation'	=> [ 'dots', 'both' ],
					],
				]
			);

			$this->add_control(
				'dots_active_color',
				[
					'label'     => __( 'Dots Color (active)', 'larisdigital-wp' ),
					'type'      => Controls_Manager::COLOR,
					'selectors'	=> [
						'{{WRAPPER}} .tp-image-slider-wrapper .swiper-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'background-color: {{VALUE}};',
					],
					'condition'	=> [
						'navigation'	=> [ 'dots', 'both' ],
					],
				]
			);

			$this->add_control(
				'dots_position',
				[
					'label'     => __( 'Dots Position', 'larisdigital-wp' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'inside',
					'options'   => [
						'inside'	=> __( 'Inside', 'larisdigital-wp' ),
						'outside'	=> __( 'Outside', 'larisdigital-wp' ),
					],
					'condition' => [
						'navigation'	=> [ 'dots', 'both' ],
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
		$slides_nav = [];
		foreach ( $settings['slider'] as $slider ) {
			
			$slide_html = '';

			if ( empty( $slider['image']['url'] ) ) {
				continue;
			}

			if ( isset($settings['image_size']) ) {
				$slider['image_size'] = $settings['image_size'];
			}

			if ( isset($settings['image_custom_dimension']) ) {
				$slider['image_custom_dimension'] = $settings['image_custom_dimension'];
			}

			$slide_html = Group_Control_Image_Size::get_attachment_image_html( $slider );

			if ( $slide_html ) {
				$slide_html = sprintf( '<div class="slide-image swiper-slide-image">%s</div>', $slide_html );
			}

			if ( $slider['image']['id'] ) {
				$slide_nav_image = wp_get_attachment_image( $slider['image']['id'], 'thumbnail' );
			} else {
				$slide_nav_image = Group_Control_Image_Size::get_attachment_image_html( $slider );
			}

			if ( $slide_html ) {
				$slides_nav[] = '<div class="swiper-slide"><div class="slick-slide-inner">' . $slide_nav_image . '</div></div>';
			}

			if ( $slide_caption = $slider['slider_caption'] ) {
				$slide_html .= '<div class="tp-slide-image-caption-box">';
				$slide_html .= '<div class="tp-slide-image-caption-inner">';
				$slide_html .= '<div class="tp-slide-image-caption">'.$slide_caption.'</div>';
				$slide_html .= '</div>';
				$slide_html .= '</div>';
			}

			if ( $slide_link = $slider['slider_link']['url'] ) {
				$target = '';
				if ( ! empty( $slider['slider_link']['is_external'] ) ) {
					$target = ' target="_blank"';
				}
				$slide_html = sprintf( '<a href="%s"%s>%s</a>', esc_url( $slide_link ), $target, $slide_html );
			}

			if ( $slide_html ) {
				$slides[] = '<div class="swiper-slide"><div class="slick-slide-inner">' . $slide_html . '</div></div>';
			}

		}

		if ( empty( $slides ) ) {
			return;
		}

		if ( "yes" == $settings['image_stretch'] ) {
			$this->add_render_attribute( 'slider', [ 'class' => 'swiper-image-stretch' ] );
		}

		$direction = is_rtl() ? 'rtl' : 'ltr';

		$swiper_class = Plugin::$instance->experiments->is_feature_active( 'e_swiper_latest' ) ? 'swiper' : 'swiper-container';

		$this->add_render_attribute( [
			'slider' => [
				'class' => 'swiper-wrapper',
			],
			'wrapper' => [
				'class' => 'tp-image-slider-wrapper '.$swiper_class,
				'dir'	=> $direction
			],
		] );

		$slider_base_options = [
			'autoplaySpeed'	    => absint( $settings['autoplay_speed'] ),
			'autoplay'          => ( 'no' !== $settings['autoplay'] ? true : false ),
			'infinite'          => ( 'no' !== $settings['infinite'] ? true : false ),
			'pauseOnHover'      => ( 'no' !== $settings['pause_on_hover'] ? true : false ),
			'speed'             => absint( $settings['speed'] ),
			'arrows'            => ( in_array( $settings['navigation'], [ 'arrows', 'both' ] ) ? true : false ),
			'dots'              => ( in_array( $settings['navigation'], [ 'dots', 'both' ] ) ? true : false ),
			'fade'              => ( 'slide' !== $settings['effect'] ? true : false ),
			'adaptiveHeight'	=> ( 'no' !== $settings['adaptive_height'] ? true : false ),
			'rtl'               => is_rtl() ? true : false,
		];

		$slider_base_classes = [];
		$slider_base_classes[] = 'tp-swiper-on';

		if ( in_array( $settings['navigation'], [ 'arrows', 'both' ] ) ) {
			$show_arrows = true;
			$slider_base_classes[] = 'navigation-arrows-' . $settings['arrows_position'];
		}
		else {
			$show_arrows = false;
		}

		if ( in_array( $settings['navigation'], [ 'dots', 'both' ] ) ) {
			$show_dots = true;
			$slider_base_classes[] = 'navigation-dots-' . $settings['dots_position'];
		}
		else {
			$show_dots = false;
		}

		$slider_options = $slider_base_options;
		// if ( "thumb" == $settings['navigation'] ) {
		// 	$slider_options['asNavFor'] = true;
		// }
		// $slider_options['sliderSyncing'] = ("thumb" == $settings['navigation'] ? true : false);
		$slider_options['slidesToShow'] = absint( 1 );

		$slider_classes = $slider_base_classes;

		$this->add_render_attribute( 'wrapper', [ 'class' => $slider_classes ] );

		$this->add_render_attribute( 'slider', 'class', 'tp-image-slider' );

		$this->add_render_attribute( 'slider', [ 'data-slider_options' => wp_json_encode( $slider_options ) ] );

		// if ( "thumb" == $settings['navigation'] ) {
		// 	$slider_nav_classes = $slider_base_classes;
		// 	$slider_nav_classes[] = 'swiper-container tp-image-slider-nav';

		// 	// $slider_nav_options = $slider_base_options;
		// 	$slider_nav_options = [
		// 		'slidesToShow' => absint( $settings['columns'] ),
		// 		'loop' => true
		// 	];

		// 	$this->add_render_attribute( 'slider_nav', [
		// 		'class' => $slider_nav_classes,
		// 		'data-slider_nav_options' => wp_json_encode( $slider_nav_options ),
		// 	] );
		// }

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<div <?php echo $this->get_render_attribute_string( 'slider' ); ?>>
				<?php echo implode( '', $slides ); ?>
			</div>

			<?php if ( "thumb" == $settings['navigation'] ) : ?>
				<div <?php echo $this->get_render_attribute_string( 'slider_nav' ); ?>>
					<div class="swiper-wrapper">
						<?php echo implode( '', $slides_nav ); ?>
					</div>
				</div>
			<?php else : ?>
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
