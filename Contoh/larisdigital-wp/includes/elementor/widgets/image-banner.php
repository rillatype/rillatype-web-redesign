<?php
namespace ElementorTokoPress\Widgets;

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

class TP_Image_Banner extends Widget_Base {

	public function get_name() {
		return 'tp_image_banner';
	}

	public function get_title() {
		return __( 'TP - Image', 'larisdigital-wp' );
	}

	public function get_icon() {
		return 'eicon-image';
	}

	public function get_categories() {
		return [ 'tokopress' ];
	}

	public static function get_default_currency() {
		if ( class_exists('woocommerce') ) {
			return get_woocommerce_currency();
		}
		return 'USD';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_image',
			[
				'label' => __( 'Image', 'larisdigital-wp' ),
			]
		);

		$this->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'larisdigital-wp' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'image', // Actually its `image_size`
				'label' => __( 'Image Size', 'larisdigital-wp' ),
				'default' => 'large',
			]
		);

		$this->add_control(
			'link_to',
			[
				'label' => __( 'Link to', 'larisdigital-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'custom',
				'options' => [
					'custom' => __( 'Custom URL', 'larisdigital-wp' ),
					'file' => __( 'Media File', 'larisdigital-wp' ),
					'none' => __( 'None', 'larisdigital-wp' ),
				],
			]
		);

		$this->add_control(
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
			'section_caption',
			[
				'label' => __( 'Caption', 'larisdigital-wp' ),
			]
		);

		$this->add_control(
			'caption',
			[
				'label' => __( 'Caption', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter your banner caption', 'larisdigital-wp' ),
				'title' => __( 'Input banner caption here', 'larisdigital-wp' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'subcaption',
			[
				'label' => __( 'Subcaption', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter your banner subcaption', 'larisdigital-wp' ),
				'title' => __( 'Input banner subcaption here', 'larisdigital-wp' ),
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_tracking',
			[
				'label' => __( 'Tracking (FB Pixel / Adwords)', 'larisdigital-wp' ),
				'condition' => [
					'link_to' => 'custom',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_tracking' );

		$this->start_controls_tab(
			'tab_tracking_fbpixel',
			[
				'label' => __( 'FB Pixel', 'larisdigital-wp' ),
			]
		);

		$this->add_control(
			'tracking_fbpixel',
			[
				'label' => __( 'Onclick Facebook Pixel', 'larisdigital-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'larisdigital-wp' ),
				'label_off' => __( 'No', 'larisdigital-wp' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'tracking_fbpixel_event',
			[
				'label' => __( 'FB Pixel Event', 'larisdigital-wp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'Lead',
				'options' => [
					'Lead' => __( 'Lead', 'larisdigital-wp' ),
					'ViewContent' => __( 'ViewContent', 'larisdigital-wp' ),
					'AddToCart' => __( 'AddToCart', 'larisdigital-wp' ),
					'InitiateCheckout' => __( 'InitiateCheckout', 'larisdigital-wp' ),
					'AddCustomerInfo' => __( 'AddCustomerInfo', 'larisdigital-wp' ),
					'AddPaymentInfo' => __( 'AddPaymentInfo', 'larisdigital-wp' ),
					'Purchase' => __( 'Purchase', 'larisdigital-wp' ),
					'AddToWishlist' => __( 'AddToWishlist', 'larisdigital-wp' ),
					'CompleteRegistration' => __( 'CompleteRegistration', 'larisdigital-wp' ),
					'custom' => __( 'Custom Event', 'larisdigital-wp' ),
				],
				'label_block' => true,
				'condition' => [
					'tracking_fbpixel!' => '',
				],
			]
		);

		$this->add_control(
			'tracking_fbpixel_event_custom',
			[
				'label' => __( 'FB Pixel Custom Event', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'condition' => [
					'tracking_fbpixel!' => '',
					'tracking_fbpixel_event' => 'custom',
				],
			]
		);

		$this->add_control(
			'tracking_fbpixel_value',
			[
				'label' => __( 'value', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => '0.00',
				'condition' => [
					'tracking_fbpixel!' => '',
					'tracking_fbpixel_event!' => '',
				],
			]
		);

		$this->add_control(
			'tracking_fbpixel_currency',
			[
				'label' => __( 'currency', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => self::get_default_currency(),
				'condition' => [
					'tracking_fbpixel!' => '',
					'tracking_fbpixel_event!' => '',
				],
			]
		);

		$this->add_control(
			'tracking_fbpixel_advanced',
			[
				'label' => __( 'Add custom parameters', 'larisdigital-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'larisdigital-wp' ),
				'label_off' => __( 'No', 'larisdigital-wp' ),
				'return_value' => 'yes',
				'condition' => [
					'tracking_fbpixel!' => '',
					'tracking_fbpixel_event!' => '',
				],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'name',
			[
				'label' => __( 'parameter name', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
			]
		);

		$repeater->add_control(
			'value',
			[
				'label' => __( 'parameter value', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'tracking_fbpixel_params',
			[
				'label' => '',
				'type' => Controls_Manager::REPEATER,
				'show_label' => false,
				'prevent_empty' => false,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ name }}}',
				'condition' => [
					'tracking_fbpixel!' => '',
					'tracking_fbpixel_event!' => '',
					'tracking_fbpixel_advanced!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_tracking_gtag',
			[
				'label' => __( 'AdWords', 'larisdigital-wp' ),
			]
		);

		$this->add_control(
			'tracking_gtag',
			[
				'label' => __( 'Onclick Conversion', 'larisdigital-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'larisdigital-wp' ),
				'label_off' => __( 'No', 'larisdigital-wp' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'tracking_gtag_send_to',
			[
				'label' => __( 'send_to (required)', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => '',
				'label_block' => true,
				'condition' => [
					'tracking_gtag!' => '',
				],
			]
		);

		$this->add_control(
			'tracking_gtag_params',
			[
				'label' => __( 'Add additional parameters', 'larisdigital-wp' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'larisdigital-wp' ),
				'label_off' => __( 'No', 'larisdigital-wp' ),
				'return_value' => 'yes',
				'condition' => [
					'tracking_gtag!' => '',
				],
			]
		);

		$this->add_control(
			'tracking_gtag_value',
			[
				'label' => __( 'value', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => '0.00',
				'condition' => [
					'tracking_gtag!' => '',
					'tracking_gtag_params!' => '',
				],
			]
		);

		$this->add_control(
			'tracking_gtag_currency',
			[
				'label' => __( 'currency', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => self::get_default_currency(),
				'condition' => [
					'tracking_gtag!' => '',
					'tracking_gtag_params!' => '',
				],
			]
		);

		$this->add_control(
			'tracking_gtag_transaction_id',
			[
				'label' => __( 'transaction_id', 'larisdigital-wp' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => '',
				'condition' => [
					'tracking_gtag!' => '',
					'tracking_gtag_params!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_image',
			[
				'label' => __( 'Image', 'larisdigital-wp' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'container_width',
			[
				'label' => __( 'Container Max Width (px)', 'larisdigital-wp' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => 300,
						'max' => 2000,
					],
				],
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .tp-image-banner' => 'max-width: {{SIZE}}{{UNIT}};margin:0 auto;',
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
				'selector' => '{{WRAPPER}} .tp-banner-image img',
			]
		);

		$this->add_control(
			'image_border_radius',
			[
				'label' => __( 'Border Radius', 'larisdigital-wp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tp-banner-image img, {{WRAPPER}} .tp-banner-caption-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'image_box_shadow',
				'selector' => '{{WRAPPER}} .tp-banner-image img',
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
				'selector' => '{{WRAPPER}} .tp-banner-caption-inner',
			]
		);

		$this->add_responsive_control(
			'caption_box_margin',
			[
				'label' => __( 'Margin', 'larisdigital-wp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tp-banner-caption-inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .tp-banner-caption-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'prefix_class' => 'tp-banner-caption-pos-h-',
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
				'prefix_class' => 'tp-banner-caption-pos-v-',
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
					'{{WRAPPER}} .tp-banner-caption-text' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'caption_background',
			[
				'label' => __( 'Background Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-banner-caption-text' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .tp-banner-caption-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .tp-banner-caption-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_caption_style' );

		$this->start_controls_tab( 'tab_caption_style', [ 'label' => __( 'Caption', 'larisdigital-wp' ) ] );

		$this->add_control(
			'caption_color',
			[
				'label' => __( 'Text Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-banner-caption' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'caption_typography',
				'selector' => '{{WRAPPER}} .tp-banner-caption',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'tab_subcaption_style', [ 'label' => __( 'Subcaption', 'larisdigital-wp' ) ] );

		$this->add_control(
			'subcaption_color',
			[
				'label' => __( 'Text Color', 'larisdigital-wp' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-banner-subcaption' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subcaption_typography',
				'selector' => '{{WRAPPER}} .tp-banner-subcaption',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings();

		if ( empty( $settings['image']['url'] ) ) {
			return;
		}

		$has_caption = ! empty( $settings['caption'] ) || ! empty( $settings['subcaption'] );

		$this->add_render_attribute( 'wrapper', 'class', 'tp-image-banner' );
		if ( ! empty( $settings['hover_animation'] ) ) {
			$this->add_render_attribute( 'wrapper', 'class', 'elementor-animation-'.$settings['hover_animation'] );
		}

		$link = $this->get_link_url( $settings );

		if ( $link ) {
			$this->add_render_attribute( 'link', 'href', $link['url'] );

			if ( ! empty( $link['is_external'] ) ) {
				$this->add_render_attribute( 'link', 'target', '_blank' );
			}
		}

		if ( $settings['link_to'] == 'custom' && $settings['tracking_fbpixel'] == 'yes' ) {
			$tracking_fbpixel_track = 'track';
			$tracking_fbpixel_event = $settings['tracking_fbpixel_event'];
			if ( ! $tracking_fbpixel_event ) {
				$tracking_fbpixel_event = 'Lead';
			}
			if ( $tracking_fbpixel_event == 'custom' && ! empty( $settings['tracking_fbpixel_event_custom'] ) ) {
				$tracking_fbpixel_track = 'trackCustom';
				$tracking_fbpixel_event = trim( $settings['tracking_fbpixel_event_custom'] );
			}
			$tracking_fbpixel_params = [];
			$tracking_fbpixel_params['source'] = 'tokopress-elementor';
			$tracking_fbpixel_params['source_action'] = 'button-click';
			$tracking_fbpixel_params['source_position'] = 'tp-image';
			$tracking_fbpixel_params['version'] = TOKOPRESS_ELEMENTOR_VERSION;
			$tracking_fbpixel_params['domain'] = str_replace( array('https://www.','http://www.','https://','http://'), '', home_url('/') );
			if ( ! empty( $settings['tracking_fbpixel_value'] ) ) {
				$tracking_fbpixel_params['value'] = number_format((float)$settings['tracking_fbpixel_currency'], 2, '.', '');
			}
			else {
				$tracking_fbpixel_params['value'] = 0.00;
			}
			if ( ! empty( $settings['tracking_fbpixel_currency'] ) ) {
				$tracking_fbpixel_params['currency'] = $settings['tracking_fbpixel_currency'];
			}
			else {
				$tracking_fbpixel_params['currency'] = self::get_default_currency();
			}
			if ( ! empty( $settings['tracking_fbpixel_advanced'] ) && ! empty( $settings['tracking_fbpixel_params'] ) ) {
				foreach ( $settings['tracking_fbpixel_params'] as $param ) {
					if ( ! empty( $param['name'] ) && ! empty( $param['value'] ) ) {
						$param_name = trim( $param['name'] );
						$param_value = trim( $param['value'] );
						$tracking_fbpixel_params[ $param_name ] = $param_value;
					}
				}
			}
			$this->add_render_attribute( 'link', 'class', 'button-track-event' );
			$this->add_render_attribute( 'link', 'data-fbtrack', $tracking_fbpixel_track );
			$this->add_render_attribute( 'link', 'data-fbevent', $tracking_fbpixel_event );
			$this->add_render_attribute( 'link', 'data-fbparams', json_encode( $tracking_fbpixel_params ) );
		}

		if ( $settings['link_to'] == 'custom' && $settings['tracking_gtag'] == 'yes' && ! empty( $settings['tracking_gtag_send_to'] ) ) {
			$tracking_gtag_track = 'event';
			$tracking_gtag_event = 'conversion';
			$tracking_gtag_params = [];
			$tracking_gtag_params['send_to'] = trim( $settings['tracking_gtag_send_to'] );
			if ( ! empty( $settings['tracking_gtag_params'] ) ) {
				if ( ! empty( $settings['tracking_gtag_value'] ) ) {
					$tracking_gtag_params['value'] = number_format((float)$settings['tracking_gtag_currency'], 2, '.', '');
				}
				else {
					$tracking_gtag_params['value'] = 0.00;
				}
				if ( ! empty( $settings['tracking_gtag_currency'] ) ) {
					$tracking_gtag_params['currency'] = $settings['tracking_gtag_currency'];
				}
				else {
					$tracking_gtag_params['currency'] = self::get_default_currency();
				}
				if ( ! empty( $settings['tracking_gtag_transaction_id'] ) ) {
					$tracking_gtag_params['transaction_id'] = $settings['tracking_gtag_transaction_id'];
				}
			}
			$this->add_render_attribute( 'link', 'class', 'button-track-event' );
			$this->add_render_attribute( 'link', 'data-gttrack', $tracking_gtag_track );
			$this->add_render_attribute( 'link', 'data-gtevent', $tracking_gtag_event );
			$this->add_render_attribute( 'link', 'data-gtparams', json_encode( $tracking_gtag_params, JSON_UNESCAPED_SLASHES ) );
		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>

			<?php if ( $link ) : ?>
				<a <?php echo $this->get_render_attribute_string( 'link' ); ?>>
			<?php endif; ?>

			<div class="tp-banner-image">
					<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings ); ?>
			</div>

			<div class="tp-banner-caption-box">
				<div class="tp-banner-caption-inner">
					<?php if ( $has_caption ) : ?>
						<div class="tp-banner-caption-text">
							<?php if ( $settings['caption'] ) : ?>
								<div class="tp-banner-caption">
									<?php echo $settings['caption']; ?>
								</div>
							<?php endif; ?>
							<?php if ( $settings['subcaption'] ) : ?>
								<div class="tp-banner-subcaption">
									<?php echo $settings['subcaption']; ?>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>

			<?php if ( $link ) : ?>
				</a>
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
				return [
					'url' => '#',
				];
			}
			return $instance['link'];
		}

		return [
			'url' => $instance['image']['url'],
		];
	}
}
