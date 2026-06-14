<?php
namespace ElementorTokoPress\Controls;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class TP_Group_Control_Background extends Group_Control_Base {

	protected static $fields;

	private static $background_types;

	public static function get_type() {
		return 'tp_background';
	}

	public static function get_background_types() {
		if ( null === self::$background_types ) {
			self::$background_types = self::init_background_types();
		}

		return self::$background_types;
	}

	private static function init_background_types() {
		return [
			'none' => [
				'title' => _x( 'None', 'Background Control', 'larisdigital-wp' ),
				'icon' => 'fa fa-ban',
			],
			'classic' => [
				'title' => _x( 'Classic', 'Background Control', 'larisdigital-wp' ),
				'icon' => 'fa fa-paint-brush',
			],
			'gradient' => [
				'title' => _x( 'Gradient', 'Background Control', 'larisdigital-wp' ),
				'icon' => 'fa fa-barcode',
			],
		];
	}

	public function init_fields() {
		$fields = [];

		$fields['background'] = [
			'label' => _x( 'Background Type', 'Background Control', 'larisdigital-wp' ),
			'type' => Controls_Manager::CHOOSE,
			'label_block' => true,
		];

		$fields['color'] = [
			'label' => _x( 'Color', 'Background Control', 'larisdigital-wp' ),
			'type' => Controls_Manager::COLOR,
			'default' => 'rgba(0,32,178,0.5)',
			'title' => _x( 'Background Color', 'Background Control', 'larisdigital-wp' ),
			'selectors' => [
				'{{SELECTOR}}' => 'background-color: {{VALUE}};',
			],
			'condition' => [
				'background' => [ 'classic', 'gradient' ],
			],
		];

		$fields['color_stop'] = [
			'label' => _x( 'Location', 'Background Control', 'larisdigital-wp' ),
			'type' => Controls_Manager::SLIDER,
			'size_units' => [ '%' ],
			'default' => [
				'unit' => '%',
				'size' => 0,
			],
			'render_type' => 'ui',
			'condition' => [
				'background' => [ 'gradient' ],
			],
			'of_type' => 'gradient',
		];

		$fields['color_b'] = [
			'label' => _x( 'Second Color', 'Background Control', 'larisdigital-wp' ),
			'type' => Controls_Manager::COLOR,
			'default' => 'rgba(242,0,60,0.5)',
			'render_type' => 'ui',
			'condition' => [
				'background' => [ 'gradient' ],
			],
			'of_type' => 'gradient',
		];

		$fields['color_b_stop'] = [
			'label' => _x( 'Location', 'Background Control', 'larisdigital-wp' ),
			'type' => Controls_Manager::SLIDER,
			'size_units' => [ '%' ],
			'default' => [
				'unit' => '%',
				'size' => 100,
			],
			'render_type' => 'ui',
			'condition' => [
				'background' => [ 'gradient' ],
			],
			'of_type' => 'gradient',
		];

		$fields['gradient_type'] = [
			'label' => _x( 'Type', 'Background Control', 'larisdigital-wp' ),
			'type' => Controls_Manager::SELECT,
			'options' => [
				'linear' => _x( 'Linear', 'Background Control', 'larisdigital-wp' ),
				'radial' => _x( 'Radial', 'Background Control', 'larisdigital-wp' ),
			],
			'default' => 'linear',
			'render_type' => 'ui',
			'condition' => [
				'background' => [ 'gradient' ],
			],
			'of_type' => 'gradient',
		];

		$fields['gradient_angle'] = [
			'label' => _x( 'Angle', 'Background Control', 'larisdigital-wp' ),
			'type' => Controls_Manager::SLIDER,
			'size_units' => [ 'deg' ],
			'default' => [
				'unit' => 'deg',
				'size' => 180,
			],
			'range' => [
				'deg' => [
					'step' => 10,
				],
			],
			'selectors' => [
				'{{SELECTOR}}' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
			],
			'condition' => [
				'background' => [ 'gradient' ],
				'gradient_type' => 'linear',
			],
			'of_type' => 'gradient',
		];

		$fields['gradient_position'] = [
			'label' => _x( 'Position', 'Background Control', 'larisdigital-wp' ),
			'type' => Controls_Manager::SELECT,
			'options' => [
				'center center' => _x( 'Center Center', 'Background Control', 'larisdigital-wp' ),
				'center left' => _x( 'Center Left', 'Background Control', 'larisdigital-wp' ),
				'center right' => _x( 'Center Right', 'Background Control', 'larisdigital-wp' ),
				'top center' => _x( 'Top Center', 'Background Control', 'larisdigital-wp' ),
				'top left' => _x( 'Top Left', 'Background Control', 'larisdigital-wp' ),
				'top right' => _x( 'Top Right', 'Background Control', 'larisdigital-wp' ),
				'bottom center' => _x( 'Bottom Center', 'Background Control', 'larisdigital-wp' ),
				'bottom left' => _x( 'Bottom Left', 'Background Control', 'larisdigital-wp' ),
				'bottom right' => _x( 'Bottom Right', 'Background Control', 'larisdigital-wp' ),
			],
			'default' => 'center center',
			'selectors' => [
				'{{SELECTOR}}' => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
			],
			'condition' => [
				'background' => [ 'gradient' ],
				'gradient_type' => 'radial',
			],
			'of_type' => 'gradient',
		];

		return $fields;
	}

	protected function get_child_default_args() {
		return [
			'types' => [ 'none', 'classic' ],
		];
	}

	protected function filter_fields() {
		$fields = parent::filter_fields();

		$args = $this->get_args();

		foreach ( $fields as &$field ) {
			if ( isset( $field['of_type'] ) && ! in_array( $field['of_type'], $args['types'] ) ) {
				unset( $field );
			}
		}

		return $fields;
	}

	protected function prepare_fields( $fields ) {
		$args = $this->get_args();

		$background_types = self::get_background_types();

		$choose_types = [];

		foreach ( $args['types'] as $type ) {
			if ( isset( $background_types[ $type ] ) ) {
				$choose_types[ $type ] = $background_types[ $type ];
			}
		}

		$fields['background']['options'] = $choose_types;

		return parent::prepare_fields( $fields );
	}
}
