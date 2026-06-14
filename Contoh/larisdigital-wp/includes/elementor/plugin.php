<?php
namespace ElementorTokoPress;

use ElementorTokoPress\Controls\TP_Group_Control_Background;

use ElementorTokoPress\Widgets\TP_Heading;
use ElementorTokoPress\Widgets\TP_Button;
use ElementorTokoPress\Widgets\TP_Video;
use ElementorTokoPress\Widgets\TP_Image_Banner;
use ElementorTokoPress\Widgets\TP_Image_Gallery;
use ElementorTokoPress\Widgets\TP_Person_Gallery;
use ElementorTokoPress\Widgets\TP_Search_Form;
// use ElementorTokoPress\Widgets\TP_Newsletter_Form;
use ElementorTokoPress\Widgets\TP_Contact_Form;
use ElementorTokoPress\Widgets\TP_WC_Products;
use ElementorTokoPress\Widgets\TP_EDD_Downloads;
use ElementorTokoPress\Widgets\TP_Store;
use ElementorTokoPress\Widgets\TP_Tutor_Courses;

use ElementorTokoPress\Widgets\TP_Countdown;

use ElementorTokoPress\Widgets\TP_Posts_Grid;
use ElementorTokoPress\Widgets\TP_Slider_Image;
use ElementorTokoPress\Widgets\TP_Slider_Content;
// use ElementorTokoPress\Widgets\TP_Optin;
use ElementorTokoPress\Widgets\TP_Testimonials;
use ElementorTokoPress\Widgets\TP_Pricing_Table;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Main Plugin Class
 *
 * Register new elementor widget.
 *
 * @since 1.0.0
 */
class Plugin {

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() {
		$this->add_actions();
	}

	private function add_actions() {
		add_action( 'elementor/init', [ $this, 'elementor_init' ] );
		add_action( 'elementor/elements/categories_registered', array( $this, 'elementor_categories_registered' ) );
		if ( version_compare( ELEMENTOR_VERSION, '3.5.0', '>=' ) ) {
			add_action( 'elementor/widgets/register', [ $this, 'elementor_widgets_registered' ] );
		}
		else {
			add_action( 'elementor/widgets/widgets_registered', [ $this, 'elementor_widgets_registered' ] );
		}

		if ( class_exists( 'woocommerce' ) && ! defined( 'ELEMENTOR_PRO_VERSION' ) ) {
			add_action( 'init', [ $this, 'register_wc_hooks' ], 9 );
		}
		add_action( 'init', [ $this, 'init' ], 10 );
	}

	public function elementor_init() {
	}

	public function elementor_categories_registered( $elements_manager ) {
		$elements_manager->add_category(
			'tokopress',
			[
				'title' => __( 'TokoPress', 'larisdigital-wp' ),
				'icon' => 'font',
			]
		);
	}

	public function elementor_widgets_registered() {
		$this->include_widgets();
		$this->register_widgets();
	}

	public function init() {
		$template = get_template();
		$template = str_replace( '-wp', '', $template );
		if ( class_exists('woocommerce') ) {
			if ( function_exists( $template.'_wc_setup_shop_page' ) ) {
				call_user_func( $template.'_wc_setup_shop_page' );
			}
			if ( function_exists( $template.'_wc_setup_product_page' ) ) {
				call_user_func( $template.'_wc_setup_product_page' );
			}
			if ( function_exists( $template.'_wc_setup_cart_page' ) ) {
				call_user_func( $template.'_wc_setup_cart_page' );
			}
			if ( function_exists( $template.'_wc_setup_checkout_page' ) ) {
				call_user_func( $template.'_wc_setup_checkout_page' );
			}
		} 
	}

	public function register_wc_hooks() {
		wc()->frontend_includes();
	}

	private function include_widgets() {
		require_once ( __DIR__ . '/widgets/heading.php' );
		require_once ( __DIR__ . '/widgets/button.php' );
		require_once ( __DIR__ . '/widgets/video.php' );
		require_once ( __DIR__ . '/widgets/image-banner.php' );
		require_once ( __DIR__ . '/widgets/image-gallery.php' );
		require_once ( __DIR__ . '/widgets/person-gallery.php' );
		require_once ( __DIR__ . '/widgets/search-form.php' );
		require_once ( __DIR__ . '/widgets/newsletter-form.php' );
		require_once ( __DIR__ . '/widgets/contact-form.php' );
		if ( function_exists( 'WC' ) ) {
			require_once ( __DIR__ . '/widgets/wc-products.php' );
		}
		if ( class_exists( 'Easy_Digital_Downloads' ) ) {
			require_once ( __DIR__ . '/widgets/edd-downloads.php' );
		}
		if ( ! ( class_exists( 'woocommerce' ) || class_exists( 'Easy_Digital_Downloads' ) ) ) {
			require_once ( __DIR__ . '/widgets/store.php' );
		}
		if ( defined( 'TUTOR_VERSION') ) {
			if ( version_compare( TUTOR_VERSION, '2.0.0', '>=' ) )  {
				require_once ( __DIR__ . '/widgets/tutor-courses.php' );
			}
			else {
				require_once ( __DIR__ . '/widgets/tutor-courses-v1.php' );
			}
		}
		require_once ( __DIR__ . '/widgets/countdown.php' );

		require_once ( __DIR__ . '/widgets/posts-grid.php' );
		require_once ( __DIR__ . '/widgets/slider-image.php' );
		require_once ( __DIR__ . '/widgets/slider-content.php' );
		// require_once ( __DIR__ . '/widgets/optin.php' );
		require_once ( __DIR__ . '/widgets/testimonials.php' );
		require_once ( __DIR__ . '/widgets/pricing-table.php' );
	}

	private function register_widgets() {
		if ( version_compare( ELEMENTOR_VERSION, '3.5.0', '>=' ) ) {
			\Elementor\Plugin::$instance->widgets_manager->register( new TP_Heading() );
			\Elementor\Plugin::$instance->widgets_manager->register( new TP_Button() );
			\Elementor\Plugin::$instance->widgets_manager->register( new TP_Video() );
			\Elementor\Plugin::$instance->widgets_manager->register( new TP_Image_Banner() );
			\Elementor\Plugin::$instance->widgets_manager->register( new TP_Image_Gallery() );
			\Elementor\Plugin::$instance->widgets_manager->register( new TP_Person_Gallery() );
			\Elementor\Plugin::$instance->widgets_manager->register( new TP_Search_Form() );
			// \Elementor\Plugin::$instance->widgets_manager->register( new TP_Newsletter_Form() );
			\Elementor\Plugin::$instance->widgets_manager->register( new TP_Contact_Form() );
			if ( function_exists( 'WC' ) ) {
				\Elementor\Plugin::$instance->widgets_manager->register( new TP_WC_Products() );
			}
			if ( class_exists( 'Easy_Digital_Downloads' ) ) {
				\Elementor\Plugin::$instance->widgets_manager->register( new TP_EDD_Downloads() );
			}
			if ( ! ( class_exists( 'woocommerce' ) || class_exists( 'Easy_Digital_Downloads' ) ) ) {
				\Elementor\Plugin::$instance->widgets_manager->register( new TP_Store() );
			}
			if ( defined( 'TUTOR_VERSION') ) {
				\Elementor\Plugin::$instance->widgets_manager->register( new TP_Tutor_Courses() );
			}
			\Elementor\Plugin::$instance->widgets_manager->register( new TP_Countdown() );

			\Elementor\Plugin::$instance->widgets_manager->register( new TP_Posts_Grid() );
			\Elementor\Plugin::$instance->widgets_manager->register( new TP_Slider_Image() );
			\Elementor\Plugin::$instance->widgets_manager->register( new TP_Slider_Content() );
			// \Elementor\Plugin::$instance->widgets_manager->register( new TP_Optin() );
			\Elementor\Plugin::$instance->widgets_manager->register( New TP_Testimonials() );
			\Elementor\Plugin::$instance->widgets_manager->register( New TP_Pricing_Table() );
		}
		else {
			\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TP_Heading() );
			\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TP_Button() );
			\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TP_Video() );
			\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TP_Image_Banner() );
			\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TP_Image_Gallery() );
			\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TP_Person_Gallery() );
			\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TP_Search_Form() );
			// \Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TP_Newsletter_Form() );
			\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TP_Contact_Form() );
			if ( function_exists( 'WC' ) ) {
				\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TP_WC_Products() );
			}
			if ( class_exists( 'Easy_Digital_Downloads' ) ) {
				\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TP_EDD_Downloads() );
			}
			if ( ! ( class_exists( 'woocommerce' ) || class_exists( 'Easy_Digital_Downloads' ) ) ) {
				\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TP_Store() );
			}
			if ( defined( 'TUTOR_VERSION') ) {
				\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TP_Tutor_Courses() );
			}
			\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TP_Countdown() );

			\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TP_Posts_Grid() );
			\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TP_Slider_Image() );
			\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TP_Slider_Content() );
			// \Elementor\Plugin::$instance->widgets_manager->register_widget_type( new TP_Optin() );
			\Elementor\Plugin::$instance->widgets_manager->register_widget_type( New TP_Testimonials() );
			\Elementor\Plugin::$instance->widgets_manager->register_widget_type( New TP_Pricing_Table() );
		}
	}
}

new Plugin();
