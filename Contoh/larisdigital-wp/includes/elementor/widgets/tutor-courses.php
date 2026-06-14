<?php
namespace ElementorTokoPress\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class TP_Tutor_Courses extends Widget_Base {

	public function get_name() {
		return 'tp_tutor_courses';
	}

	public function get_title() {
		return __( 'TP - TutorLMS Courses', 'larisdigital-wp' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	// public function get_script_depends() {
	// 	return [ 'jquery-slick' ];
	// }

	public function get_categories() {
		return [ 'tokopress' ];
	}

	public static function get_product_categories() {
		$categories = array( '' => __( '- All Categories -', 'larisdigital-wp' ) );
		$terms = get_terms( array( 'taxonomy' => 'course-category' ) );
		
		if ( !empty($terms) ) {
			foreach ( $terms as $term ) {
				$categories[$term->term_id] = $term->name;
			}
		}
		
		return $categories;
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_products',
			[
				'label'	=> __( 'Courses Setting', 'larisdigital-wp' ),
			]
		);

			$this->add_control(
				'show',
				[
					'label'		    => __( 'Filter By', 'larisdigital-wp' ),
					'type'		    =>Controls_Manager::SELECT,
					'default'	    => 'all',
					'options'	    => [
						'all'			=> __( 'All Courses', 'larisdigital-wp' ),
						'incategory'	=> __( 'Courses In A Category', 'larisdigital-wp' ),
					],
					'label_block'	=> true,
				]
			);

			$this->add_control(
				'category',
				[
					'label' 	    => __( 'Category', 'larisdigital-wp' ),
					'type' 		    => Controls_Manager::SELECT,
					'options' 	    => self::get_product_categories(),
					'condition'	    => [
						'show' => 'incategory',
					],
					'label_block'	=> true,
				]
			);

			$options = array();
			for ($i=1; $i <=24; $i++) { 
				$options[$i] = $i;
			}

			$this->add_control(
				'per_page',
				[
					'label' 	    => __( 'Number of Courses To Show', 'larisdigital-wp' ),
					'type' 		    => Controls_Manager::SELECT,
					'default' 	    => '6',
					'options' 	    => $options,
					'label_block'	=> true,
				]
			);

			$this->add_control(
				'columns',
				[
					'label' 	    => __( 'Number of Courses Per Row', 'larisdigital-wp' ).'<br>'.__( '(does not work on preview)', 'larisdigital-wp' ),
					'type' 		    => Controls_Manager::SELECT,
					'default' 	    => 'default',
					'options' 	    => [
						'default'	=> 'default',
						'1'         => '1',
						'2'         => '2',
						'3'         => '3',
						'4'         => '4',
					],
					'label_block'	=> true,
				]
			);
			
			$this->add_control(
				'orderby',
				[
					'label' 		=> __( 'Order By', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::SELECT,
					'default' 		=> 'date',
					'options' 		=> [
						'date' 			=> __( 'Date', 'larisdigital-wp' ),
						'title' 		=> __( 'Title', 'larisdigital-wp' ),
						'id' 			=> __( 'ID', 'larisdigital-wp' ),
						'rand' 			=> __( 'Random', 'larisdigital-wp' ),
					],
					'condition'		=> [
						'show' => [ 'all', 'featured', 'onsale', 'incategory' ],
					],
					'label_block'	=> true,
				]
			);

			$this->add_control(
				'order',
				[
					'label' 		=> __( 'Order', 'larisdigital-wp' ),
					'type' 			=> Controls_Manager::SELECT,
					'default' 		=> 'desc',
					'options' 		=> [
						'desc'	=> __( 'Descending (Z - A)', 'larisdigital-wp' ),
						'asc'	=> __( 'Ascending (A - Z)', 'larisdigital-wp' ),
					],
					'condition'		=> [
						'show'		=> [ 'all', 'featured', 'onsale', 'incategory' ],
						'orderby!'	=> 'popularity',
					],
					'label_block' 	=> true,
				]
			);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings();

		$shortcode_args = '';
		$shortcode_args .= ' course_filter=""';
		$shortcode_args .= ' show_pagination=""';

		if ( $settings['show'] == 'incategory' && $settings['category'] > 0 ) {
			$shortcode_args .= ' category="'.$settings['category'].'"';
		}

		if ( $settings['columns'] && $settings['columns'] != 'default' ) {
			$shortcode_args .= ' column_per_row="'.$settings['columns'].'"';
		}

		$shortcode_args .= ' count="'.$settings['per_page'].'"';

		$shortcode_args .= ' orderby="'.$settings['orderby'].'"';

		$shortcode_args .= ' order="'.$settings['order'].'"';

		$shortcode = '[tutor_course'.$shortcode_args.']';

		echo do_shortcode($shortcode);

	}
}
