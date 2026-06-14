<?php
namespace ElementorTokoPress\Widgets;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Utils;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class TP_Posts_Grid extends Widget_Base {

	public function get_name() {
		return 'tp_posts_grid';
	}

	public function get_title() {
		return __( 'TP - Posts Grid', 'larisdigital-wp' );
	}

	public function get_icon() {
		return 'eicon-post-list';
	}

	public function get_categories() {
		return [ 'tokopress' ];
	}

	public static function get_post_categories() {
		$categories = array( '' => __( '- All Categories -', 'larisdigital-wp' ) );
		$terms = get_terms( array( 'taxonomy' => 'category' ) );
		
		if ( !empty($terms) ) {
			foreach ( $terms as $term ) {
				$categories[$term->slug] = $term->name;
			}
		}
		return $categories;
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_posts',
			[
				'label' => __( 'Posts Grid', 'larisdigital-wp' ),
			]
		);

			$this->add_control(
				'category',
				[
					'label'		=> __( 'Category', 'larisdigital-wp' ),
					'type'		=> Controls_Manager::SELECT,
					'options'	=> self::get_post_categories(),
				]
			);

			$options = array();
			for ($i=1; $i <=6; $i++) { 
				$options[$i] = $i;
			}

			$this->add_responsive_control(
				'columns',
				[
					'label'				=> __( 'Columns Per Row', 'larisdigital-wp' ),
					'type'				=> Controls_Manager::SELECT,
					'desktop_default'	=> '3',
					'tablet_default' 	=> '2',
					'mobile_default' 	=> '1',
					'options' 			=> $options,
				]
			);
		
			for ($i=7; $i <=24; $i++) { 
				$options[$i] = $i;
			}

			$this->add_control(
				'per_page',
				[
					'label' 	=> __( 'Number of Posts', 'larisdigital-wp' ),
					'type' 		=> Controls_Manager::SELECT,
					'default' 	=> '6',
					'options' 	=> $options,
				]
			);

			$this->add_control(
				'sticky',
				[
					'label'			=> __( 'Hide Sticky Posts', 'larisdigital-wp' ),
					'type'			=> Controls_Manager::SWITCHER,
					'label_on'		=> __( 'show', 'larisdigital-wp' ),
					'label_off'		=> __( 'hide', 'larisdigital-wp' ),
					'return_value'	=> 1
				]
			);

			$this->add_control(
				'orderby',
				[
					'label' 	=> __( 'Order By', 'larisdigital-wp' ),
					'type'		=> Controls_Manager::SELECT,
					'default'	=> 'date',
					'options'	=> [
						'date' 	=> __( 'Published Date', 'larisdigital-wp' ),
						'title' => __( 'Title', 'larisdigital-wp' ),
						'rand' 	=> __( 'Random', 'larisdigital-wp' ),
					],
				]
			);

			$this->add_control(
				'order',
				[
					'label'		=> __( 'Order', 'larisdigital-wp' ),
					'type'		=> Controls_Manager::SELECT,
					'default'	=> 'DESC',
					'options'	=> [
						'DESC'	=> __( 'DESC (high to low)', 'larisdigital-wp' ),
						'ASC'	=> __( 'ASC (low to high)', 'larisdigital-wp' ),
					],
				]
			);

			$this->add_control(
				'readmore',
				[
					'label'			=> __( 'Read More Text', 'larisdigital-wp' ),
					'type'			=> Controls_Manager::TEXT,
					'default'		=> __( 'Read More', 'larisdigital-wp' ),
					'placeholder'	=> __( 'Read More', 'larisdigital-wp' ),
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_thumbnail',
			[
				'label'	=> __( 'Thumbnail', 'larisdigital-wp' ),
			]
		);

			$this->add_control(
				'post_thumbnail',
				[
					'label'			=> __( 'Post Thumbnail', 'larisdigital-wp' ),
					'type'			=> Controls_Manager::SWITCHER,
					'default'		=> 'yes',
					'label_on'		=> __( 'yes', 'larisdigital-wp' ),
					'label_off'		=> __( 'no', 'larisdigital-wp' ),
					'return_value'	=> 'yes'
				]
			);

			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				[
					'name'		=> 'image', // Actually its `image_size`
					'label'		=> __( 'Thumbnail Size', 'larisdigital-wp' ),
					'default'	=> 'post-thumbnail',
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
						'pagination'	=> [ 'yes' ]
					]
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_slider_options',
			[
				'label' => __( 'Slider Options', 'larisdigital-wp' ),
				'condition' => [
					'pagination' => [ '' ]
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
					'return_value'	=> 'yes',
					'default'		=> 'no',
				]
			);

			$this->add_responsive_control(
				'slides_to_scroll',
				[
					'label'				=> __( 'Slides To Scroll', 'larisdigital-wp' ),
					'type'				=> Controls_Manager::SELECT,
					'desktop_default'	=> '1',
					'tablet_default'	=> '1',
					'mobile_default'	=> '1',
					'options'			=> [
						'1' => '1',
						'2' => '2',
						'3' => '3',
						'4' => '4',
						'5' => '5',
						'6' => '6',
					],
				]
			);

			$this->add_control(
				'adaptive_height',
				[
					'label'		=> __( 'Adaptive Height', 'larisdigital-wp' ),
					'type'		=> Controls_Manager::SELECT,
					'default'	=> 'yes',
					'options'	=> [
						'yes'	=> __( 'Yes', 'larisdigital-wp' ),
						'no'	=> __( 'No', 'larisdigital-wp' ),
					],
				]
			);

			$this->add_control(
				'navigation',
				[
					'label'		=> __( 'Navigation', 'larisdigital-wp' ),
					'type'		=> Controls_Manager::SELECT,
					'default'	=> 'both',
					'options'	=> [
						'both'		=> __( 'Arrows and Dots', 'larisdigital-wp' ),
						'arrows'	=> __( 'Arrows', 'larisdigital-wp' ),
						'dots'		=> __( 'Dots', 'larisdigital-wp' ),
						'none'		=> __( 'None', 'larisdigital-wp' ),
					],
				]
			);

			$this->add_control(
				'pause_on_hover',
				[
					'label'		=> __( 'Pause on Hover', 'larisdigital-wp' ),
					'type'		=> Controls_Manager::SELECT,
					'default'	=> 'yes',
					'options'	=> [
						'yes'	=> __( 'Yes', 'larisdigital-wp' ),
						'no'	=> __( 'No', 'larisdigital-wp' ),
					],
				]
			);

			$this->add_control(
				'autoplay',
				[
					'label'		=> __( 'Autoplay', 'larisdigital-wp' ),
					'type'		=> Controls_Manager::SELECT,
					'default'	=> 'yes',
					'options'	=> [
						'yes'	=> __( 'Yes', 'larisdigital-wp' ),
						'no'	=> __( 'No', 'larisdigital-wp' ),
					],
				]
			);

			$this->add_control(
				'autoplay_speed',
				[
					'label'		=> __( 'Autoplay Speed', 'larisdigital-wp' ),
					'type'		=> Controls_Manager::NUMBER,
					'default'	=> 5000,
				]
			);

			$this->add_control(
				'infinite',
				[
					'label'		=> __( 'Infinite Loop', 'larisdigital-wp' ),
					'type'		=> Controls_Manager::SELECT,
					'default'	=> 'yes',
					'options'	=> [
						'yes'	=> __( 'Yes', 'larisdigital-wp' ),
						'no'	=> __( 'No', 'larisdigital-wp' ),
					],
				]
			);

			$this->add_control(
				'effect',
				[
					'label'		=> __( 'Effect', 'larisdigital-wp' ),
					'type'		=> Controls_Manager::SELECT,
					'default'	=> 'slide',
					'options'	=> [
						'slide'	=> __( 'Slide', 'larisdigital-wp' ),
						'fade'	=> __( 'Fade', 'larisdigital-wp' ),
					],
				]
			);

			$this->add_control(
				'speed',
				[
					'label'		=> __( 'Animation Speed', 'larisdigital-wp' ),
					'type'		=> Controls_Manager::NUMBER,
					'default'	=> 500,
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_posts',
			[
				'label'	=> __( 'Posts Grid', 'larisdigital-wp' ),
				'tab'	=> Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'item_gap',
				[
					'label'		=> __( 'Item Gap', 'larisdigital-wp' ),
					'type'		=> Controls_Manager::SLIDER,
					'default'	=> [
						'size'	=> 10,
					],
					'range'		=> [
						'px'	=> [
							'min'	=> 0,
							'max'	=> 100,
						],
					],
					'selectors' => [
						'(desktop){{WRAPPER}} .tp-posts-grid li' => 'width: calc( 100% / {{columns.SIZE}} ); padding: {{SIZE}}px',
						'(tablet){{WRAPPER}} .tp-posts-grid li' => 'width: calc( 100% / {{columns_tablet.SIZE}} ); padding: {{SIZE}}px',
						'(mobile){{WRAPPER}} .tp-posts-grid li' => 'width: calc( 100% / {{columns_mobile.SIZE}} ); padding: {{SIZE}}px',
					],
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_title',
			[
				'label'	=> __( 'Post Title', 'larisdigital-wp' ),
				'tab'	=> Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'title_color',
				[
					'label'		=> __( 'Text Color', 'larisdigital-wp' ),
					'type'		=> Controls_Manager::COLOR,
					'selectors'	=> [
						'{{WRAPPER}} .tp-posts-grid-wrapper li h4 a' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'		=> 'title_typography',
					'label'		=> __( 'Typography', 'larisdigital-wp' ),
					'global' => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector'	=> '{{WRAPPER}} .tp-posts-grid-wrapper li h4 a',
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_excerpt',
			[
				'label'	=> __( 'Post Excerpt', 'larisdigital-wp' ),
				'tab'	=> Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'excerpt_color',
				[
					'label'		=> __( 'Text Color', 'larisdigital-wp' ),
					'type'		=> Controls_Manager::COLOR,
					'selectors'	=> [
						'{{WRAPPER}} .tp-posts-grid-wrapper li p' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'		=> 'excerpt_typography',
					'label'		=> __( 'Typography', 'larisdigital-wp' ),
					'global' => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector'	=> '{{WRAPPER}} .tp-posts-grid-wrapper li p',
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_readmore',
			[
				'label'	=> __( 'Read More Link', 'larisdigital-wp' ),
				'tab'	=> Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'readmore_color',
				[
					'label'		=> __( 'Text Color', 'larisdigital-wp' ),
					'type'		=> Controls_Manager::COLOR,
					'selectors'	=> [
						'{{WRAPPER}} .tp-posts-grid-wrapper li .readmore' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'		=> 'readmore_typography',
					'label'		=> __( 'Typography', 'larisdigital-wp' ),
					'selector'	=> '{{WRAPPER}} .tp-posts-grid-wrapper li .readmore',
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
					'pagination'	=> [ '' ]
				]
			]
		);

			$this->add_control(
				'heading_style_arrows',
				[
					'label' => __( 'Arrows', 'larisdigital-wp' ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_control(
				'arrows_color',
				[
					'label' => __( 'Arrows Color', 'larisdigital-wp' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tp-posts-grid-wrapper.tp-posts-grid-carousel .elementor-swiper-button' => 'color: {{VALUE}};',
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
						'{{WRAPPER}} .tp-posts-grid-wrapper.tp-posts-grid-carousel .elementor-swiper-button' => 'font-size: {{SIZE}}px',
					],
				]
			);

			$this->add_control(
				'heading_style_dots',
				[
					'label' => __( 'Dots', 'larisdigital-wp' ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_control(
				'dots_color',
				[
					'label' => __( 'Dots Color', 'larisdigital-wp' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tp-posts-grid-wrapper.tp-posts-grid-carousel .swiper-pagination .swiper-pagination-bullet' => 'background-color: {{VALUE}}; opacity:1;',
					],
				]
			);

			$this->add_control(
				'dots_active_color',
				[
					'label' => __( 'Dots Color (active)', 'larisdigital-wp' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tp-posts-grid-wrapper.tp-posts-grid-carousel .swiper-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'background-color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'dots_position',
				[
					'label'		=> __( 'Dots Position', 'larisdigital-wp' ),
					'type'		=> Controls_Manager::SELECT,
					'default'	=> 'outside',
					'options'	=> [
						'outside'	=> __( 'Outside', 'larisdigital-wp' ),
						'inside'	=> __( 'Inside', 'larisdigital-wp' ),
					],
					'condition'	=> [
						'navigation'	=> [ 'dots', 'both' ],
					],
				]
			);

		$this->end_controls_section();

	}

	protected function render() {
		$settings 	= $this->get_settings();

		$columns 	= absint( $settings['columns'] ) > 0 ? absint( $settings['columns'] ) : 3;
		$per_page 	= absint( $settings['per_page'] ) > 0 ? absint( $settings['per_page'] ) : 6;
		$orderby 	= $settings['orderby'] ? $settings['orderby'] : 'date';
		$order 		= $settings['order'] ? $settings['order'] : 'DESC';
		$sticky 	= $settings['sticky'] ? 0 : 1;

		$args = array( 
			'post_type'				=> 'post',
			'posts_per_page' 		=> $per_page,
			'orderby' 				=> $orderby,
			'order' 				=> $order,
			'ignore_sticky_posts'	=> $sticky,
			'post_status'			=> 'publish'
		);
		if ( $settings['category'] ) {
			$args['category_name'] = $settings['category'];
		}

		if ( $settings['pagination'] == 'yes' ) {
			$page = max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );
			$offset = ( $page - 1 ) * $per_page;

			$args['paged'] = $page;
			$args['offset'] = $offset;
		}

		$thumbnail = [];

		if ( isset($settings['image_size']) && $settings['image_size'] ) {
			$thumbnail['image_size'] = $settings['image_size'];
		}
		else {
			$thumbnail['image_size'] = 'post-thumbnail';
		}

		if ( isset($settings['image_custom_dimension']) ) {
			$thumbnail['image_custom_dimension'] = $settings['image_custom_dimension'];
		}

		$this->add_render_attribute( 'wrapper', 'class', 'tp-posts-grid-wrapper' );

		$this->add_render_attribute( 'wrapper', 'class', 'grid-columns-' . $columns );

		$this->add_render_attribute( 'carousel', 'class', 'tp-posts-grid' );

		if ( $settings['pagination'] !== 'yes' ) {
			if ( $settings['carousel'] == 'yes' ) {

				$swiper_class = Plugin::$instance->experiments->is_feature_active( 'e_swiper_latest' ) ? 'swiper' : 'swiper-container';

				$this->add_render_attribute( [
					'carousel' => [
						'class' => 'swiper-wrapper',
					],
					'wrapper' => [
						'class' => 'tp-posts-grid-carousel '.$swiper_class,
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

				$this->add_render_attribute( 'carousel', ['data-slider_options' => wp_json_encode( $carousel_options )] );
				
				$this->add_render_attribute( 'inner', 'class', 'swiper-slide' );
			}

		}

		$this->add_render_attribute( 'carousel', 'class', 'clearfix' );

		$the_query = new \WP_Query( $args );
		if ( $the_query->have_posts() ) : ?>

			<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
				<ul <?php echo $this->get_render_attribute_string( 'carousel' ); ?>>
				
					<?php
					while ( $the_query->have_posts() ) :
						$the_query->the_post();
						?>
						
						<li <?php echo $this->get_render_attribute_string( 'inner' ); ?>>
							<?php if ( has_post_thumbnail() && "yes" == $settings['post_thumbnail'] ) : ?>
								<a href="<?php echo get_permalink(); ?>" title="">
								<?php $thumbnail['image'] = [ 'id' => get_post_thumbnail_id() ]; ?>
								<?php echo Group_Control_Image_Size::get_attachment_image_html( $thumbnail ); ?>
								</a>
							<?php endif; ?>
							
							<?php the_title( sprintf( '<h4><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' ); ?>
							
							<?php
							$excerpt = wp_trim_words( get_the_excerpt(), 25, '&hellip;' );
							$excerpt = strip_tags( $excerpt );
							if ( $excerpt ) : ?>
								<p><?php echo $excerpt; ?></p>
							<?php endif; ?>

							<?php if ( $settings['readmore'] ) : ?>
								<a class="readmore" href="<?php echo get_permalink(); ?>"><?php echo $settings['readmore']; ?></a>
							<?php endif; ?>
						</li>
					
					<?php endwhile; ?>
			
				</ul>
				<?php
				if ( $settings['pagination'] == 'yes' ) {
					echo '<nav class="paging-navigation" aria-label="'.esc_html__( 'Paging navigation', 'larisdigital-wp' ).'">';
					    	$paginate_args = array(
					            'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
					            'total'        => $the_query->max_num_pages,
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
				/* Restore original Post Data */
				wp_reset_postdata();

				?></div><?php
		endif;

	}
}
