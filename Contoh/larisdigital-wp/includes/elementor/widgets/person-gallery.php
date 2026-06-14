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
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class TP_Person_Gallery extends Widget_Base {

	public function get_name() {
		return 'tp_person_gallery';
	}

	public function get_title() {
		return __( 'TP - Person Gallery', 'larisdigital-wp' );
	}

	public function get_icon() {
		return 'eicon-person';
	}

	public function get_categories() {
		return [ 'tokopress' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_persons',
			[
				'label' => __( 'Person Gallery', 'larisdigital-wp' ),
			]
		);

			$this->add_responsive_control(
				'columns',
				[
					'label' 			=> __( 'Columns', 'larisdigital-wp' ),
					'type' 				=> Controls_Manager::SELECT,
					'desktop_default' 	=> '3',
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
				'image',
				[
					'label' 	=> __( 'Choose Image', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::MEDIA,
					'default' 	=> [
						'url'	=> Utils::get_placeholder_image_src(),
					],
				]
			);

			$repeater->add_control(
				'link_to',
				[
					'label' 	=> __( 'Link to', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::SELECT,
					'default' 	=> 'none',
					'options' 	=> [
						'none'		=> __( 'None', 'larisdigital-wp' ),
						'custom' 	=> __( 'Custom URL', 'larisdigital-wp' ),
					],
				]
			);

			$repeater->add_control(
				'link',
				[
					'label' 		=> __( 'Link to', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::URL,
					'placeholder' 	=> __( 'http://your-link.com', 'larisdigital-wp' ),
					'condition' 	=> [
						'link_to'	=> 'custom',
					],
					'show_label'	=> false,
				]
			);

			$repeater->add_control(
				'caption',
				[
					'label'			=> __( 'Name', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::TEXT,
					'placeholder' 	=> __( 'Your Name', 'larisdigital-wp' ),
					'label_block' 	=> true,
				]
			);

			$repeater->add_control(
				'subcaption',
				[
					'label' 		=> __( 'Job Position', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::TEXT,
					'placeholder' 	=> __( 'Your Position', 'larisdigital-wp' ),
					'label_block' 	=> true,
				]
			);

			$repeater->add_control(
				'description',
				[
					'label' 		=> __( 'Description', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::TEXTAREA,
					'placeholder' 	=> '',
					'label_block' 	=> true,
				]
			);

			$icons_recommended = [
				'fa-brands' => [
					'android',
					'apple',
					'behance',
					'bitbucket',
					'codepen',
					'delicious',
					'deviantart',
					'digg',
					'dribbble',
					'elementor',
					'facebook',
					'flickr',
					'foursquare',
					'free-code-camp',
					'github',
					'gitlab',
					'globe',
					'houzz',
					'instagram',
					'jsfiddle',
					'linkedin',
					'medium',
					'meetup',
					'mix',
					'mixcloud',
					'odnoklassniki',
					'pinterest',
					'product-hunt',
					'reddit',
					'shopping-cart',
					'skype',
					'slideshare',
					'snapchat',
					'soundcloud',
					'spotify',
					'stack-overflow',
					'steam',
					'telegram',
					'thumb-tack',
					'tripadvisor',
					'tumblr',
					'twitch',
					'twitter',
					'viber',
					'vimeo',
					'vk',
					'weibo',
					'weixin',
					'whatsapp',
					'wordpress',
					'xing',
					'yelp',
					'youtube',
					'500px',
				],
				'fa-solid' => [
					'envelope',
					'link',
					'rss',
				],
			];

			$repeater->add_control(
				'social_icon5_1',
				[
					'label' 		=> __( 'Social Icon #1', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::ICONS,
					'fa4compatibility' => 'social_icon_1',
					'label_block' 	=> true,
					'default' => [
						'value' => 'fab fa-facebook',
						'library' => 'fa-brands',
					],
					'recommended' => $icons_recommended,
				]
			);
			$repeater->add_control(
				'social_link_1',
				[
					'label' 		=> __( 'Social Link #1', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::URL,
					'placeholder' 	=> __( 'http://your-link.com', 'larisdigital-wp' ),
					'label_block'	=> true,
					'default'		=> [
						'url'		=> '#',
					],
					'show_external'	=> false,
				]
			);
			$repeater->add_control(
				'social_icon5_2',
				[
					'label' 		=> __( 'Social Icon #2', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::ICONS,
					'fa4compatibility' => 'social_icon_2',
					'label_block' 	=> true,
					'default' => [
						'value' => 'fab fa-twitter',
						'library' => 'fa-brands',
					],
					'recommended' => $icons_recommended,
				]
			);
			$repeater->add_control(
				'social_link_2',
				[
					'label' 		=> __( 'Social Link #2', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::URL,
					'placeholder' 	=> __( 'http://your-link.com', 'larisdigital-wp' ),
					'label_block'	=> true,
					'default'		=> [
						'url'	=> '#',
					],
					'show_external'	=> false,
				]
			);
			$repeater->add_control(
				'social_icon5_3',
				[
					'label' 		=> __( 'Social Icon #3', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::ICONS,
					'fa4compatibility' => 'social_icon_3',
					'label_block' 	=> true,
					'default' => [
						'value' => 'fab fa-linkedin',
						'library' => 'fa-brands',
					],
					'recommended' => $icons_recommended,
				]
			);
			$repeater->add_control(
				'social_link_3',
				[
					'label' 		=> __( 'Social Link #3', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::URL,
					'placeholder' 	=> __( 'http://your-link.com', 'larisdigital-wp' ),
					'label_block'	=> true,
					'default'		=> [
						'url'	=> '#',
					],
					'show_external'	=> false,
				]
			);
			$repeater->add_control(
				'social_icon5_4',
				[
					'label' 		=> __( 'Social Icon #4', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::ICONS,
					'fa4compatibility' => 'social_icon_4',
					'label_block' 	=> true,
					'recommended' => $icons_recommended,
				]
			);
			$repeater->add_control(
				'social_link_4',
				[
					'label' 		=> __( 'Social Link #4', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::URL,
					'placeholder' 	=> __( 'http://your-link.com', 'larisdigital-wp' ),
					'label_block'	=> true,
					'default'		=> [
						'url'	=> '#',
					],
					'show_external'	=> false,
				]
			);
			$repeater->add_control(
				'social_icon5_5',
				[
					'label' 		=> __( 'Social Icon #5', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::ICONS,
					'fa4compatibility' => 'social_icon_5',
					'label_block' 	=> true,
					'recommended' => $icons_recommended,
				]
			);
			$repeater->add_control(
				'social_link_5',
				[
					'label'			=> __( 'Social Link #5', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::URL,
					'placeholder' 	=> __( 'http://your-link.com', 'larisdigital-wp' ),
					'label_block'	=> true,
					'default'		=> [
						'url'	=> '#',
					],
					'show_external'	=> false,
				]
			);

			$this->add_control(
				'persons',
				[
					'label' 		=> __( 'Persons', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::REPEATER,
					'show_label' 	=> true,
					'default' 		=> [
						[
							'image' 		=> [ 'url' => Utils::get_placeholder_image_src() ],
							'link_to' 		=> 'none',
							'link' 			=> '',
							'caption' 		=> 'John Doe',
							'subcaption' 	=> 'Web Designer',
							'description' 	=> 'Lorem ipsum dolor sit amet, vim primis bonorum te. Libris expetenda liberavisse ne pro, pro eirmod volumus at. Ex vix novum accommodare.',
						],
						[
							'image' 		=> [ 'url' => Utils::get_placeholder_image_src() ],
							'link_to' 		=> 'none',
							'link' 			=> '',
							'caption' 		=> 'John Doe',
							'subcaption' 	=> 'Web Developer',
							'description' 	=> 'Lorem ipsum dolor sit amet, vim primis bonorum te. Libris expetenda liberavisse ne pro, pro eirmod volumus at. Ex vix novum accommodare.',
						],
						[
							'image' 		=> [ 'url' => Utils::get_placeholder_image_src() ],
							'link_to' 		=> 'none',
							'link' 			=> '',
							'caption' 		=> 'John Doe',
							'subcaption' 	=> 'UX Expert',
							'description' 	=> 'Lorem ipsum dolor sit amet, vim primis bonorum te. Libris expetenda liberavisse ne pro, pro eirmod volumus at. Ex vix novum accommodare.',
						],
					],
					'fields' 		=> $repeater->get_controls(),
					'title_field' 	=> '{{{ caption }}}',
				]
			);

			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				[
					'name' 		=> 'image', // Actually its `image_size`
					'default' 	=> 'thumbnail',
				]
			);

			$this->add_control(
				'namejob_position',
				[
					'label' 	=> __( 'Name&Job Position', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::SELECT,
					'default' 	=> 'bottom',
					'options' 	=> [
						'bottom'	=> __( 'Bottom', 'larisdigital-wp' ),
						'overlay' 	=> __( 'Overlay', 'larisdigital-wp' ),
					],
				]
			);

			$this->add_control(
				'view',
				[
					'label' 	=> __( 'View', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::HIDDEN,
					'default' 	=> 'traditional',
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

			// $this->add_control(
			// 	'effect',
			// 	[
			// 		'label' 	=> __( 'Effect', 'larisdigital-wp' ),
			// 		'type' 		=> Controls_Manager::SELECT,
			// 		'default' 	=> 'slide',
			// 		'options' 	=> [
			// 			'slide' => __( 'Slide', 'larisdigital-wp' ),
			// 			'fade' 	=> __( 'Fade', 'larisdigital-wp' ),
			// 		],
			//		'condition'	=> [
			//			'carousel'	=> [ 'yes' ],
			//		],
			// 	]
			// );

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
			'section_style_person',
			[
				'label'	=> __( 'Person Gallery', 'larisdigital-wp' ),
				'tab'	=> Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'item_background',
				[
					'label' 	=> __( 'Background Color', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tp-person-gallery-item .tp-person-gallery-inner' => 'background-color: {{VALUE}};',
					]
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
						'(desktop){{WRAPPER}} .tp-person-gallery-item' => 'width: calc( 100% / {{columns.SIZE}} ); padding: {{SIZE}}px',
						'(tablet){{WRAPPER}} .tp-person-gallery-item' => 'width: calc( 100% / {{columns_tablet.SIZE}} ); padding: {{SIZE}}px',
						'(mobile){{WRAPPER}} .tp-person-gallery-item' => 'width: calc( 100% / {{columns_mobile.SIZE}} ); padding: {{SIZE}}px',
					],
				]
			);

			$this->add_responsive_control(
				'item_padding',
				[
					'label' 		=> __( 'Item Padding', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px' ],
					'selectors' 	=> [
						'{{WRAPPER}} .tp-person-gallery-item .tp-person-gallery-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' 		=> 'item_border',
					'label' 	=> __( 'Item Border', 'larisdigital-wp' ),
					'selector' 	=> '{{WRAPPER}} .tp-person-gallery-item .tp-person-gallery-inner',
				]
			);

			$this->add_control(
				'item_border_radius',
				[
					'label' 		=> __( 'Item Border Radius', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px' ],
					'selectors' 	=> [
						'{{WRAPPER}} .tp-person-gallery-item .tp-person-gallery-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' 		=> 'image_border',
					'label' 	=> __( 'Image Border', 'larisdigital-wp' ),
					'selector' 	=> '{{WRAPPER}} .tp-banner-image img',
				]
			);

			$this->add_control(
				'image_border_radius',
				[
					'label' 		=> __( 'Border Radius', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px', '%' ],
					'selectors' 	=> [
						'{{WRAPPER}} .tp-banner-image img, {{WRAPPER}} .tp-banner-caption-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' 		=> 'image_box_shadow',
					'selector' 	=> '{{WRAPPER}} .tp-banner-image img',
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_caption_box',
			[
				'label' => __( 'Image Overlay', 'larisdigital-wp' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'label' => __( 'Background Type', 'larisdigital-wp' ),
					'name' 		=> 'caption_box_background',
					'types' 	=> [ 'classic', 'gradient' ],
					'selector' 	=> '{{WRAPPER}} .tp-banner-caption-inner',
				]
			);

			$this->add_responsive_control(
				'caption_box_margin',
				[
					'label' 		=> __( 'Margin', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px', '%' ],
					'selectors' 	=> [
						'{{WRAPPER}} .tp-banner-caption-inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'caption_box_padding',
				[
					'label' 		=> __( 'Padding', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px', 'em', '%' ],
					'selectors' 	=> [
						'{{WRAPPER}} .tp-banner-caption-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_caption',
			[
				'label' => __( 'Name&Job', 'larisdigital-wp' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_responsive_control(
				'namejob_align',
				[
					'label' 	=> __( 'Name&Job Alignment', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::CHOOSE,
					'options' 	=> [
						'left' 		=> [
							'title'	=> __( 'Left', 'larisdigital-wp' ),
							'icon' 	=> 'eicon-text-align-left',
						],
						'center'	=> [
							'title' => __( 'Center', 'larisdigital-wp' ),
							'icon' 	=> 'eicon-text-align-center',
						],
						'right' 	=> [
							'title' => __( 'Right', 'larisdigital-wp' ),
							'icon' 	=> 'eicon-text-align-right',
						],
					],
					'condition' => [
						'namejob_position!' => 'overlay',
					],
					'selectors' => [
						'{{WRAPPER}} .tp-person-namejob' => 'text-align: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'caption_horizontal_position',
				[
					'label' 		=> __( 'Horizontal Position', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::CHOOSE,
					'label_block' 	=> false,
					'default' 		=> 'center',
					'options' 		=> [
						'left' 		=> [
							'title' => __( 'Left', 'larisdigital-wp' ),
							'icon' 	=> 'eicon-h-align-left',
						],
						'center' 	=> [
							'title' => __( 'Center', 'larisdigital-wp' ),
							'icon' 	=> 'eicon-h-align-center',
						],
						'right' 	=> [
							'title' => __( 'Right', 'larisdigital-wp' ),
							'icon' 	=> 'eicon-h-align-right',
						],
					],
					'prefix_class' 	=> 'tp-banner-caption-pos-h-',
					'condition' 	=> [
						'namejob_position'	=> 'overlay',
					],
				]
			);

			$this->add_control(
				'caption_vertical_position',
				[
					'label' 		=> __( 'Vertical Position', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::CHOOSE,
					'label_block' 	=> false,
					'default' 		=> 'middle',
					'options' 		=> [
						'top' 		=> [
							'title' => __( 'Top', 'larisdigital-wp' ),
							'icon' 	=> 'eicon-v-align-top',
						],
						'middle' 	=> [
							'title' => __( 'Middle', 'larisdigital-wp' ),
							'icon' 	=> 'eicon-v-align-middle',
						],
						'bottom' 	=> [
							'title' => __( 'Bottom', 'larisdigital-wp' ),
							'icon' 	=> 'eicon-v-align-bottom',
						],
					],
					'prefix_class' 	=> 'tp-banner-caption-pos-v-',
					'condition' 	=> [
						'namejob_position'	=> 'overlay',
					],
				]
			);

			$this->add_control(
				'caption_text_align',
				[
					'label' 		=> __( 'Text Align', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::CHOOSE,
					'label_block' 	=> false,
					'options' 		=> [
						'left'		=> [
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
					],
					'default' 		=> 'center',
					'selectors' 	=> [
						'{{WRAPPER}} .tp-banner-caption-text' => 'text-align: {{VALUE}}',
					],
					'condition' 	=> [
						'namejob_position'	=> 'overlay',
					],
				]
			);

			$this->add_control(
				'caption_background',
				[
					'label' 	=> __( 'Background Color', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors'	=> [
						'{{WRAPPER}} .tp-banner-caption-text' => 'background-color: {{VALUE}};',
					],
					'condition'	=> [
						'namejob_position'	=> 'overlay',
					],
				]
			);

			$this->add_responsive_control(
				'caption_padding',
				[
					'label' 		=> __( 'Padding', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px', 'em', '%' ],
					'selectors' 	=> [
						'{{WRAPPER}} .tp-banner-caption-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'		=> [
						'namejob_position'	=> 'overlay',
					],
				]
			);

			$this->add_control(
				'caption_border_radius',
				[
					'label' 		=> __( 'Border Radius', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px', '%' ],
					'selectors' 	=> [
						'{{WRAPPER}} .tp-banner-caption-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition' 	=> [
						'namejob_position'	=> 'overlay',
					],
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
				'caption_color',
				[
					'label' 	=> __( 'Text Color', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tp-banner-caption, {{WRAPPER}} .tp-person-name' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 		=> 'caption_typography',
					'selector' 	=> '{{WRAPPER}} .tp-banner-caption, {{WRAPPER}} .tp-person-name',
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
				'subcaption_color',
				[
					'label' 	=> __( 'Text Color', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tp-banner-subcaption, {{WRAPPER}} .tp-person-job' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 		=> 'subcaption_typography',
					'selector' 	=> '{{WRAPPER}} .tp-banner-subcaption, {{WRAPPER}} .tp-person-job',
					'global' => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_detail',
			[
				'label' => __( 'Description', 'larisdigital-wp' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_responsive_control(
				'detail_align',
				[
					'label' => __( 'Description Alignment', 'larisdigital-wp' ),
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
						'{{WRAPPER}} .tp-person-detail' => 'text-align: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'detail_color',
				[
					'label' 	=> __( 'Text Color', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tp-person-detail' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 		=> 'detail_typography',
					'selector' 	=> '{{WRAPPER}} .tp-person-detail',
					'global' => [
						'default' => Global_Typography::TYPOGRAPHY_TEXT,
					],
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_social',
			[
				'label' => __( 'Socials Icon', 'larisdigital-wp' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_responsive_control(
				'social_align',
				[
					'label' 	=> __( 'Socials Alignment', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::CHOOSE,
					'options'	=> [
						'left'		=> [
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
					],
					'default' 	=> 'left',
					'selectors' => [
						'{{WRAPPER}} .tp-person-gallery .tp-person-social' => 'text-align: {{VALUE}}',
					],
				]
			);

			$this->start_controls_tabs( 'tabs_button_style' );

				$this->start_controls_tab(
					'tab_social_normal',
					[
						'label' => __( 'Normal', 'larisdigital-wp' ),
					]
				);

				$this->add_control(
					'social_color_bg_normal',
					[
						'label' 	=> __( 'Background Color', 'larisdigital-wp' ),
						'type' 		=> Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .tp-person-social a' => 'background-color: {{VALUE}};',
						],
					]
				);

				$this->add_control(
					'social_color_normal',
					[
						'label' 	=> __( 'Text Color', 'larisdigital-wp' ),
						'type' 		=> Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .tp-person-social a' => 'color: {{VALUE}};',
							'{{WRAPPER}} .tp-person-social a svg' => 'fill: {{VALUE}};',
						],
					]
				);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_social_hover',
					[
						'label' => __( 'Hover', 'larisdigital-wp' ),
					]
				);

				$this->add_control(
					'social_color_bg_hover',
					[
						'label' 	=> __( 'Background Color (hover)', 'larisdigital-wp' ),
						'type' 		=> Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .tp-person-social a:hover' => 'background-color: {{VALUE}};',
						],
					]
				);

				$this->add_control(
					'social_color_hover',
					[
						'label' 	=> __( 'Text Color (hover)', 'larisdigital-wp' ),
						'type' 		=> Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .tp-person-social a:hover' => 'color: {{VALUE}};',
							'{{WRAPPER}} .tp-person-social a:hover svg' => 'fill: {{VALUE}};',
						],
					]
				);

				$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->add_control(
				'social_space',
				[
					'label' 		=> __( 'Space Between Icons', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::SLIDER,
					'default'		=> [
						'size'	=> 5,
					],
					'range'			=> [
						'px'	=> [
							'min'	=> 0,
							'max'	=> 100,
						],
					],
					'size_units'	=> [ 'px' ],
					'selectors'		=> [
							'{{WRAPPER}} .tp-person-social a' => 'margin: 0 {{SIZE}}{{UNIT}} 0 {{SIZE}}{{UNIT}};',
						],
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' 		=> 'social_border',
					'label' 	=> __( 'Border', 'larisdigital-wp' ),
					'selector' 	=> '{{WRAPPER}} .tp-person-social a',
				]
			);

			$this->add_control(
				'social_border_radius',
				[
					'label' 		=> __( 'Border Radius', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px', '%' ],
					'selectors' 	=> [
						'{{WRAPPER}} .tp-person-social a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'social_padding',
				[
					'label' 		=> __( 'Padding', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::DIMENSIONS,
					'size_units' 	=> [ 'px' ],
					'selectors' 	=> [
						'{{WRAPPER}} .tp-person-social a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' 		=> 'social_box_shadow',
					'selector' 	=> '{{WRAPPER}} .tp-person-social a',
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
						'{{WRAPPER}} .tp-person-gallery-wrapper.tp-person-gallery-carousel .elementor-swiper-button' => 'color: {{VALUE}};',
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
					'condition'	=> [
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
					'default'	=> [
						'size'	=> 35,
					],
					'range' => [
						'px'	=> [
							'min'	=> 0,
							'max'	=> 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .tp-person-gallery-wrapper.tp-person-gallery-carousel .elementor-swiper-button' => 'font-size: {{SIZE}}px',
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
						'{{WRAPPER}} .tp-person-gallery-wrapper.tp-person-gallery-carousel .swiper-pagination .swiper-pagination-bullet' => 'background-color: {{VALUE}}; opacity:1;',
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
					'selectors'	=> [
						'{{WRAPPER}} .tp-person-gallery-wrapper.tp-person-gallery-carousel .swiper-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'background-color: {{VALUE}};',
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
						'outside' 	=> __( 'Outside', 'larisdigital-wp' ),
						'inside' 	=> __( 'Inside', 'larisdigital-wp' ),
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

		if ( empty( $settings['persons'] ) ) {
			return;
		}

		$this->add_render_attribute( 'wrapper', 'class', 'tp-person-gallery-wrapper' );

		$this->add_render_attribute( 'wrapper', 'class', 'grid-columns-' . $settings['columns'] );

		$this->add_render_attribute( 'carousel', 'class', 'tp-person-gallery' );

		if ( $settings['carousel'] == 'yes' ) {

			$swiper_class = Plugin::$instance->experiments->is_feature_active( 'e_swiper_latest' ) ? 'swiper' : 'swiper-container';

			$this->add_render_attribute( [
				'carousel' => [
					'class' => 'swiper-wrapper',
				],
				'wrapper' => [
					'class' => 'tp-person-gallery-carousel '.$swiper_class,
				],
			] );

			$carousel_options = [
				'slides_to_show_desktop' 	=> !empty($settings['columns']) ? $settings['columns'] : 3,
				'slides_to_show_tablet'		=> !empty($settings['columns_tablet']) ? $settings['columns_tablet'] : 2,
				'slides_to_show_mobile'		=> !empty($settings['columns_mobile']) ? $settings['columns_mobile'] : 1,
				'slides_to_scroll_desktop'	=> !empty($settings['slides_to_scroll']) ? $settings['slides_to_scroll'] : 1,
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
				'fade' 						=> false,
				'rtl' 						=> ( is_rtl() ? true : false ),
				
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

		$slides_count = count( $settings['persons'] );

		?>

		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<div <?php echo $this->get_render_attribute_string( 'carousel' ); ?>>
			<?php 

			foreach ( $settings['persons'] as $person ) {

				if ( empty( $person['image']['url'] ) ) {
					continue;
				}

				if ( isset($settings['image_size']) ) {
					$person['image_size'] = $settings['image_size'];
				}

				if ( isset($settings['image_custom_dimension']) ) {
					$person['image_custom_dimension'] = $settings['image_custom_dimension'];
				}

				$has_caption = ! empty( $person['caption'] ) || ! empty( $person['subcaption'] );

				if ( ! empty( $settings['hover_animation'] ) ) {
					$this->add_render_attribute( 'wrapper', 'class', 'elementor-animation-'.$settings['hover_animation'] );
				}

				$link = $this->get_link_url( $person );
				?>

				<div class="tp-person-gallery-item swiper-slide">
					<div class="tp-person-gallery-inner">
						<div class="tp-person-gallery-image <?php if ( ! empty( $settings['hover_animation'] ) ) echo 'elementor-animation-'.$settings['hover_animation']; ?>">

							<?php if ( $link ) : ?>
								<a href="<?php echo $link['url']; ?>" <?php if ( ! empty( $link['is_external'] ) ) echo 'target="_blank"'; ?>>
							<?php endif; ?>

							<div class="tp-banner-image">
									<?php echo Group_Control_Image_Size::get_attachment_image_html( $person ); ?>
							</div>
							
							<?php if ( 'overlay' == $settings['namejob_position'] ) : ?>
							<div class="tp-banner-caption-box">
								<div class="tp-banner-caption-inner">
									<?php if ( $has_caption && $settings['namejob_position'] == 'overlay' ) : ?>
										<div class="tp-banner-caption-text">
											<?php if ( $person['caption'] ) : ?>
												<div class="tp-banner-caption">
													<?php echo $person['caption']; ?>
												</div>
											<?php endif; ?>
											<?php if ( $person['subcaption'] ) : ?>
												<div class="tp-banner-subcaption">
													<?php echo $person['subcaption']; ?>
												</div>
											<?php endif; ?>
										</div>
									<?php endif; ?>
								</div>
							</div>
							<?php endif; ?>

							<?php if ( $link ) : ?>
								</a>
							<?php endif; ?>

						</div>

						<?php if ( $settings['namejob_position'] !== 'overlay' ) : ?>
						<div class="tp-person-namejob">
							<?php if ( $person['caption'] ) : ?>
								<h3 class="tp-person-name">
									<?php echo $person['caption']; ?>
								</h3>
							<?php endif; ?>
							<?php if ( $person['subcaption'] ) : ?>
								<p class="tp-person-job">
									<?php echo $person['subcaption']; ?>
								</p>
							<?php endif; ?>
						</div>
						<?php endif; ?>

						<div class="tp-person-detail">
							<?php if ( $person['description'] ) : ?>
								<p class="tp-person-description">
									<?php echo $person['description']; ?>
								</p>
							<?php endif; ?>
							
							<p class="tp-person-social">
							<?php
							for ( $soc_num=1;$soc_num<=5;$soc_num++ ) {
								$icon_migrated = isset( $person['__fa4_migrated']['social_icon5_' . $soc_num] );
								$icon_is_new = empty( $person['social_icon_' . $soc_num] ) && Icons_Manager::is_migration_allowed();
								if ( ! empty( $person['social_icon_' . $soc_num] ) || ! empty( $person['social_icon5_' . $soc_num]['value'] ) ) {
									$social_link = isset( $person['social_link_' . $soc_num]['url'] ) ? $person['social_link_' . $soc_num]['url'] : '#';
									echo '<a href="' . esc_url( $social_link ) . '">';
									if ( $icon_is_new || $icon_migrated ) {
										Icons_Manager::render_icon( $person['social_icon5_' . $soc_num], [ 'aria-hidden' => 'true' ] );
									}
									else {
										echo '<i class="' . esc_attr( $person['social_icon_' . $soc_num] ) . '" aria-hidden="true"></i>';
									}
									echo '</a> &nbsp; &nbsp;';
								}
							}
							?>
							</p>

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
