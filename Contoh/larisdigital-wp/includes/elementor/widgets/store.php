<?php
namespace ElementorTokoPress\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class TP_Store extends Widget_Base {

	public function get_name() {
		return 'tp_shop';
	}

	public function get_title() {
		return __( 'TP - Store', 'larisdigital-wp' );
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
		$terms = get_terms( array( 'taxonomy' => 'product_cat' ) );
		
		if ( !empty($terms) ) {
			foreach ( $terms as $term ) {
				$categories[$term->slug] = $term->name;
			}
		}
		
		return $categories;
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_products',
			[
				'label'	=> __( 'Products Setting', 'larisdigital-wp' ),
			]
		);

			$this->add_control(
				'show',
				[
					'label'		    => __( 'Filter By', 'larisdigital-wp' ),
					'type'		    =>Controls_Manager::SELECT,
					'default'	    => 'all',
					'options'	    => [
						'all'			=> __( 'All Products', 'larisdigital-wp' ),
						'incategory'	=> __( 'Products In A Category', 'larisdigital-wp' ),
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
					'label' 	    => __( 'Number of Products To Show', 'larisdigital-wp' ),
					'type' 		    => Controls_Manager::SELECT,
					'default' 	    => '6',
					'options' 	    => $options,
					'label_block'	=> true,
				]
			);

			$this->add_control(
				'columns',
				[
					'label' 	    => __( 'Number of Products Per Row', 'larisdigital-wp' ),
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
				'columns_tablet',
				[
					'label' 	    => __( 'Number of Products Per Row (Tablet)', 'larisdigital-wp' ),
					'type' 		    => Controls_Manager::SELECT,
					'default' 	    => 'default',
					'options' 	    => [
						'default'	=> 'default',
						'1'         => '1',
						'2'         => '2',
						'3'         => '3',
					],
					'label_block'	=> true,
				]
			);

			$this->add_control(
				'columns_mobile',
				[
					'label' 	    => __( 'Number of Products Per Row (Mobile)', 'larisdigital-wp' ),
					'type' 		    => Controls_Manager::SELECT,
					'default' 	    => 'default',
					'options' 	    => [
						'default'	=> 'default',
						'1'         => '1',
						'2'         => '2',
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

		$this->start_controls_section(
			'section_pagination_options',
			[
				'label'	=> __( 'Pagination', 'larisdigital-wp' ),
			]
		);

			$this->add_control(
				'pagination',
				[
					'label'	        => __( 'Show Pagination', 'larisdigital-wp' ),
					'type'	        => Controls_Manager::SWITCHER,
					'label_on'	    => __( 'Yes', 'larisdigital-wp' ),
					'label_off'	    => __( 'No', 'larisdigital-wp' ),
					'return_value'	=> 'yes',
				]
			);

			$this->add_control(
				'pagination_align',
				[
					'label'     => __( 'Alignment', 'larisdigital-wp' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => [
						'left'	    => [
							'title'	=> __( 'Left', 'larisdigital-wp' ),
							'icon'  => 'eicon-text-align-left',
						],
						'center'	=> [
							'title' => __( 'Center', 'larisdigital-wp' ),
							'icon'  => 'eicon-text-align-center',
						],
						'right'     => [
							'title' => __( 'Right', 'larisdigital-wp' ),
							'icon'  => 'eicon-text-align-right',
						],
					],
					'default'   => 'center',
					'condition'	=> [
						'pagination' => 'yes'
					]
				]
			);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings();

		if ( get_query_var( 'paged' ) ) {
			$page = get_query_var( 'paged' );
		}
		elseif ( get_query_var( 'page' ) ) {
			$page = get_query_var( 'page' );
		}
		else {
			$page = 1;
		}

		$offset = ( $page - 1 ) * $settings['per_page'];

		// default query args
		$query_args = array(
			'posts_per_page'	=> $settings['per_page'],
			'paged'			    => $page,
			'offset' 		    => $offset,
			'post_status'       => 'publish',
			'post_type'         => 'product',
			'meta_query'        => array()
		);

		if ( $settings['show'] == 'incategory' && $settings['category'] ) {
			$query_args['tax_query'] = array(
				array(
					'taxonomy' 		=> 'product_cat',
					'terms' 		=> array_map( 'sanitize_title', explode( ',', $settings['category'] ) ),
					'field' 		=> 'slug',
					'operator' 		=> 'IN',
				)
			);
		}

		$query_args['orderby']  = $settings['orderby'];
		$query_args['order'] = $settings['order'];

		if ( $settings['pagination'] == 'yes' ) {
			$query_args['no_found_rows'] = false;
		} else {
			$query_args['no_found_rows'] = 1;
		}

		$columns = $settings['columns'];
		if ( !$columns || $columns == 'default' ) {
			$columns = 3;
		}
		elseif ( $columns > 4 ) {
			$columns = 4;
		}
		$columns = intval(12/$columns);

		$columns_tablet = $settings['columns_tablet'];
		if ( !$columns_tablet || $columns_tablet == 'default' ) {
			$columns_tablet = 2;
		}
		elseif ( $columns_tablet > 3 ) {
			$columns_tablet = 3;
		}
		$columns_tablet = intval(12/$columns_tablet);

		$columns_mobile = $settings['columns_mobile'];
		if ( !$columns_mobile || $columns_mobile == 'default' ) {
			$columns_mobile = 1;
		}
		elseif ( $columns_mobile > 2 ) {
			$columns_mobile = 2;
		}
		$columns_mobile = intval(12/$columns_mobile);

		$this->query = new \WP_Query( $query_args );
		$query = $this->query;

		$this->add_render_attribute( 'wrapper', 'class', 'tp-shop-wrapper' );
		$this->add_render_attribute( 'wrapper', 'class', 'clearfix' );

		$this->add_render_attribute( 'carousel', 'class', 'tp-shop-products' );

		if ( $query->have_posts() ) :
			$total_pages = $query->max_num_pages;
		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<div <?php echo $this->get_render_attribute_string( 'carousel' ); ?>>

				<div class="row">

				<?php while ( $query->have_posts() ) : $query->the_post(); ?>

					<div class="col-<?php echo esc_attr($columns_mobile); ?> col-md-<?php echo esc_attr($columns_tablet); ?> col-lg-<?php echo esc_attr($columns); ?> mb-2">
						<?php get_template_part( 'store/block-content-shop' ); ?>
					</div>

				<?php endwhile; ?>

				</div>

				<?php

				if ( $settings['pagination'] == 'yes' ) {
					echo '<nav class="paging-navigation" aria-label="'.esc_html__( 'Paging navigation', 'larisdigital-wp' ).'">';
					    	$paginate_args = array(
					            'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
					            'total'        => $total_pages,
					            'current'      => max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) ),
					            'format'       => '',
					            'type'         => 'list',
								'alignment'		=> $settings['pagination_align'],
					        );
					        echo larisdigital_paginate_links( $paginate_args );
					echo '</nav>';
				}

				wp_reset_postdata();
				?>
			</div>
		</div>
		<?php
		endif;


	}
}
