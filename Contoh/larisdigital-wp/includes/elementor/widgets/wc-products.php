<?php
namespace ElementorTokoPress\Widgets;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class TP_WC_Products extends Widget_Base {

	public function get_name() {
		return 'tp_wc_products';
	}

	public function get_title() {
		return __( 'TP - WooCommerce Products', 'larisdigital-wp' );
	}

	public function get_icon() {
		return 'eicon-woocommerce';
	}

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
						'featured'		=> __( 'Featured Products', 'larisdigital-wp' ),
						'onsale'		=> __( 'On-sale Products', 'larisdigital-wp' ),
						'bestselling'	=> __( 'Best Selling Products', 'larisdigital-wp' ),
						'toprated'		=> __( 'Top Rated Products', 'larisdigital-wp' ),
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
			for ($i=1; $i <=6; $i++) { 
				$options[$i] = $i;
			}

			$this->add_control(
				'columns',
				[
					'label' 	    => __( 'Number of Products Per Row', 'larisdigital-wp' ),
					'type' 		    => Controls_Manager::SELECT,
					'default' 	    => '4',
					'options' 	    => $options,
					'condition'	    => [
						'carousel!' => 'yes',
					],
					'label_block'	=> true,
				]
			);
			
			$this->add_control(
				'columns_mobile',
				[
					'label' 	    => __( 'Number of Products Per Row (Mobile)', 'larisdigital-wp' ),
					'description'   => __( 'For mobile only, when device viewport width <= 480px', 'larisdigital-wp' ),
					'type' 		    => Controls_Manager::SELECT,
					'default' 	    => 'default',
					'options' 	    => [
						'default'	=> 'default',
						'1'         => '1',
						'2'         => '2',
					],
					'condition'	    => [
						'carousel!'	=> 'yes',
						'columns!'	=> '1',
					],
					'label_block'	=> true,
				]
			);
			
			for ($i=7; $i <=24; $i++) { 
				$options[$i] = $i;
			}

			$this->add_control(
				'per_page',
				[
					'label' 	    => __( 'Number of Products To Show', 'larisdigital-wp' ),
					'type' 		    => Controls_Manager::SELECT,
					'default' 	    => '4',
					'options' 	    => $options,
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
						'price' 		=> __( 'Price', 'larisdigital-wp' ),
						'popularity' 	=> __( 'Popularity', 'larisdigital-wp' ),
						'rating' 		=> __( 'Rating', 'larisdigital-wp' ),
						'rand' 			=> __( 'Random', 'larisdigital-wp' ),
						'menu_order' 	=> __( 'Menu Order', 'larisdigital-wp' ),
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

			$this->add_control(
				'hide_free',
				[
					'label' 		=> __( 'Hide Free Products', 'larisdigital-wp' ),
					'type'			=> Controls_Manager::SWITCHER,
					'label_on'		=> __( 'Yes', 'larisdigital-wp' ),
					'label_off'		=> __( 'No', 'larisdigital-wp' ),
					'return_value'	=> 'yes'
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

		$this->start_controls_section(
			'section_slider_warning',
			[
				'label'     => __( 'Slider / Carousel Options', 'larisdigital-wp' ),
				'condition'	=> [
					'pagination' => 'yes',
				]
			]
		);

		$this->add_control(
			'carousel_warning',
			[
				'type'              => Controls_Manager::RAW_HTML,
				'raw'               => __( 'Slider / Carousel Options are not available because Paginations is active!', 'larisdigital-wp' ),
				'content_classes'	=> 'elementor-panel-alert elementor-panel-alert-info',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_slider_options',
			[
				'label'     => __( 'Slider / Carousel Options', 'larisdigital-wp' ),
				'condition'	=> [
					'pagination' => '',
				]
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
				'slides_to_show',
				[
					'label' 			=> __( 'Slides To Show', 'larisdigital-wp' ),
					'type' 				=> Controls_Manager::SELECT,
					'desktop_default' 	=> '4',
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
					'condition'			=> [
						'carousel' => 'yes',
					],
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
					'condition'			=> [
						'carousel' => 'yes',
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
						'carousel' => 'yes',
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
						'carousel' => 'yes',
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
						'carousel' => 'yes',
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
						'carousel' => 'yes',
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
						'carousel' => 'yes',
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
						'carousel' => 'yes',
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
						'carousel' => 'yes',
					],
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_navigation',
			[
				'label'     => __( 'Slider / Navigation', 'larisdigital-wp' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition'	=> [
					'carousel' => 'yes',
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
						'navigation' => [ 'arrows', 'both' ],
					],
				]
			);

			$this->add_control(
				'arrows_color',
				[
					'label' 	=> __( 'Arrows Color', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tp-wc-products-wrapper.tp-wc-products-carousel .elementor-swiper-button' => 'color: {{VALUE}};',
					],
					'condition'	=> [
						'navigation' => [ 'arrows', 'both' ],
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
						'navigation' => [ 'arrows', 'both' ],
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
					'range' 	=> [
						'px'	=> [
							'min'	=> 0,
							'max'	=> 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .tp-wc-products-wrapper.tp-wc-products-carousel .elementor-swiper-button' => 'font-size: {{SIZE}}px',
					],
					'condition'	=> [
						'navigation' => [ 'arrows', 'both' ],
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
						'navigation' => [ 'dots', 'both' ],
					],
				]
			);

			$this->add_control(
				'dots_color',
				[
					'label' 	=> __( 'Dots Color', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tp-wc-products-wrapper.tp-wc-products-carousel .swiper-pagination .swiper-pagination-bullet' => 'background-color: {{VALUE}}; opacity:1;',
					],
					'condition'	=> [
						'navigation' => [ 'dots', 'both' ],
					],
				]
			);

			$this->add_control(
				'dots_active_color',
				[
					'label' 	=> __( 'Dots Color (active)', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::COLOR,
					'selectors'	=> [
						'{{WRAPPER}} .tp-wc-products-wrapper.tp-wc-products-carousel .swiper-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'background-color: {{VALUE}};',
					],
					'condition'	=> [
						'navigation' => [ 'dots', 'both' ],
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
						'navigation' => [ 'dots', 'both' ],
					],
				]
			);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings();

		global $woocommerce_loop;

		if ( $settings['show'] == 'incategory' && !$settings['category'] )
			return;

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

		if ( $settings['pagination'] == 'yes' ) {
			$query_args['no_found_rows'] = false;
		} else {
			$query_args['no_found_rows'] = 1;
		}

		// hidden free products
		if ( $settings['hide_free'] == 'yes' ) {
			$query_args['meta_query'][] = array(
				'key'     => '_price',
				'value'   => 0,
				'compare' => '>',
				'type'    => 'DECIMAL',
			);
		}

		// orderby query
		if ( $settings['show'] != 'toprated' ) {
			switch ( $settings['orderby'] ) {
				case 'price' :
					$query_args['meta_key'] = '_price';
					$query_args['orderby']  = 'meta_value_num';
					$query_args['order']  	= $settings['order'];
					break;
				case 'rand' :
					$query_args['orderby']  = 'rand';
					break;
				case 'sales' :
					$query_args['meta_key'] = 'total_sales';
					$query_args['orderby']  = 'meta_value_num';
					break;
				case 'rating' :
					$query_args['meta_key'] = '_wc_average_rating';
					$query_args['orderby'] = array(
						'meta_value_num' => $settings['order'],
						'ID'             => 'ASC',
					);
					break;
				case 'popularity' :
					$query_args['meta_key'] = 'total_sales';
					$query_args['orderby']  = 'meta_value_num';
					$query_args['order']  	= 'desc';
					break;
				default :
					$query_args['orderby']  = $settings['orderby'];
					$query_args['order']  	= $settings['order'];
			}
		}

		// filterby query
		switch ( $settings['show'] ) {
			case 'featured' :

				$meta_query  = \WC()->query->get_meta_query();
			    $tax_query   = \WC()->query->get_tax_query();
			    $tax_query[] = array(
			        'taxonomy' => 'product_visibility',
			        'field'    => 'name',
			        'terms'    => 'featured',
			        'operator' => 'IN',
			    );

				$query_args['meta_query'] = $meta_query;
				$query_args['tax_query']  = $tax_query;
				
				$query_args['order']  	  = $settings['order'];
				break;
			case 'onsale' :
				$product_ids_on_sale    = wc_get_product_ids_on_sale();
				$product_ids_on_sale[]  = 0;
				$query_args['post__in'] = $product_ids_on_sale;
				break;
			case 'bestselling' :
				$query_args['meta_key'] = 'total_sales';
				$query_args['orderby']  = 'meta_value_num';
				$query_args['order']  	= 'desc';
				break;
			case 'toprated' :
				$query_args['meta_key'] = '_wc_average_rating';
				$query_args['orderby']  = array(
					'meta_value_num' => 'DESC',
					'ID'             => 'ASC',
				);
				break;
			case 'incategory' :
				$query_args['tax_query'] = array(
					array(
						'taxonomy' 		=> 'product_cat',
						'terms' 		=> array_map( 'sanitize_title', explode( ',', $settings['category'] ) ),
						'field' 		=> 'slug',
						'operator' 		=> 'IN',
					)
				);
				break;
		}

		$query_args['meta_query'] = WC()->query->get_meta_query();

		$query_args['tax_query'][] = array(
			array(
				'taxonomy' => 'product_visibility',
				'field'    => 'name',
				'terms'    => 'exclude-from-catalog',
				'operator' => 'NOT IN',
			),
		);

		$this->query = new \WP_Query( $query_args );
		$query = $this->query;

		$woocommerce_loop['columns'] = $settings['columns'];

		$this->add_render_attribute( 'wrapper', 'class', 'tp-wc-products-wrapper' );

		$this->add_render_attribute( 'wrapper', 'class', 'woocommerce' );

		$this->add_render_attribute( 'inner', 'class', 'tp-wc-products' );

		if ( $settings['pagination'] !== 'yes' ) {
			if ( $settings['carousel'] == 'yes' ) {
				$direction = is_rtl() ? 'rtl' : 'ltr';
				$this->add_render_attribute( 'wrapper', 'dir', $direction );

				$swiper_class = Plugin::$instance->experiments->is_feature_active( 'e_swiper_latest' ) ? 'swiper' : 'swiper-container';

				$this->add_render_attribute( [
					'inner' => [
						'class' => 'swiper-wrapper',
					],
					'wrapper' => [
						'class' => 'tp-wc-products-carousel '.$swiper_class,
					],
				] );

				$carousel_options = [
					'slides_to_show_desktop' 	=> !empty($settings['slides_to_show']) ? $settings['slides_to_show'] : 4,
					'slides_to_show_tablet'		=> !empty($settings['slides_to_show_tablet']) ? $settings['slides_to_show_tablet'] : 2,
					'slides_to_show_mobile'		=> !empty($settings['slides_to_show_mobile']) ? $settings['slides_to_show_mobile'] : 1,
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

				$this->add_render_attribute( 'wrapper', [
					'class' => $carousel_classes,
				] );

				$this->add_render_attribute( 'inner', ['data-slider_options' => wp_json_encode( $carousel_options )] );

				add_filter( 'post_class', array( $this, 'set_row_post_class' ), 10,2 );
			}
		}

		$this->add_render_attribute( 'inner', 'class', 'products columns-mobile-' . esc_attr( $settings['columns_mobile'] ) . ' columns-' . esc_attr( $settings['columns'] ) );

		if ( $query->have_posts() ) :
			$total_pages = $query->max_num_pages;
		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>

			<?php
			echo '<ul ' . $this->get_render_attribute_string( 'inner' ) . '>';
			
			while ( $query->have_posts() ) {
				$query->the_post();
				
				wc_get_template_part( 'content', 'product' );
			}
			woocommerce_product_loop_end();
			
			woocommerce_reset_loop();

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
			else {
				if ( $settings['carousel'] == "yes" ) {
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
				}
			}

			wp_reset_postdata();
			?>
			
		</div>
		<?php
		endif;
	}

	static function set_row_post_class( $classes, $product ) {
		$classes[] = 'swiper-slide';
		return $classes;
	}
}
