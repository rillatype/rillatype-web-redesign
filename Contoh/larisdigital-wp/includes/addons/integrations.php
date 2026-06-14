<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( !defined( 'LARISDIGITAL_INTEGRATIONS_DB' ) ) {
	define( 'LARISDIGITAL_INTEGRATIONS_DB', 'tokopress_integrations' );
}

function larisdigital_get_integration( $name, $default = false ) {
	$options = get_option( LARISDIGITAL_INTEGRATIONS_DB );
	if ( isset( $options[$name] ) ) {
		return $options[$name];
	}
	return $default;
}

function larisdigital_get_integration_mode() {
	global $larisdigital_integration_mode;
	if ( !empty( $larisdigital_integration_mode ) ) {
		return $larisdigital_integration_mode;
	}
	$mode = '';
	$page_id = '';
	if ( is_front_page() ) {
		$mode = 'frontpage';
		if ( 'page' == get_option( 'show_on_front' ) ) {
			$page_on_front = get_option( 'page_on_front' );
			if ( $page_on_front ) {
				$mode = 'page_home';
				$page_id = $page_on_front;
			}
		}
	}
	elseif ( is_home() ) {
		$mode = 'frontpage';
		if ( 'page' == get_option( 'show_on_front' ) ) {
			$page_for_posts = get_option( 'page_for_posts' );
			if ( $page_for_posts ) {
				$mode = 'page_blog';
				$page_id = $page_for_posts;
			}
		}
	}
	elseif ( is_singular() ) {
		$mode = 'page';
		$page_id = get_queried_object_id();
	}
	if ( class_exists( 'woocommerce' ) ) {
		if ( is_shop() || is_product_category() || is_product_tag() ) {
			$shop_page_id = wc_get_page_id( 'shop' );
			if ( $shop_page_id ) {
				if ( is_shop() ) {
					$mode = 'shop';
				}
				elseif ( is_product_category() ) {
					$mode = 'product_category';
				}
				elseif ( is_product_tag() ) {
					$mode = 'product_tag';
				}
				$page_id = $shop_page_id;
			}
		}
	}
	$larisdigital_integration_mode = array( 
		'mode' => $mode, 
		'page_id' => $page_id 
	);
	return $larisdigital_integration_mode;
}

add_filter( 'larisdigital_customize_controls', 'larisdigital_customize_controls_integrations' );
function larisdigital_customize_controls_integrations( $controls ) {

	$controls['larisdigital_panel_integrations'] = array(
		'title'    => esc_html__( 'Theme Settings - Integrations', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_panel_integrations',
		'type'     => 'panel',
		'priority' => 16,
	);

	return $controls;

}

add_filter( 'larisdigital_customize_controls', 'larisdigital_customize_controls_fbpixel' );
function larisdigital_customize_controls_fbpixel( $controls ) {

	$controls['larisdigital_section_fbpixel'] = array(
		'title'    => esc_html__( 'Facebook Pixel', 'larisdigital-wp' ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-success larisdigital-alert-with-icon">
							<span class="dashicons dashicons-megaphone"></span> '.esc_html__( 'We support multiple Facebook Pixel IDs (maximum 5 different IDs) for all pages on this website.', 'larisdigital-wp' ).'
							</p>',
		'setting'  => 'larisdigital_section_fbpixel',
		'panel'    => 'larisdigital_panel_integrations',
		'type'     => 'section',
		'priority' => 200,
	);

	for ($i=1; $i <=5 ; $i++) { 
		$controls['fbpixel_'.$i] = array(
			'label'    => sprintf( esc_html__( 'Facebook Pixel ID #%s', 'larisdigital-wp' ), $i ),
			'setting'  => 'fbpixel_'.$i,
			'setting_type' => 'option_mod',
			'setting_db' => LARISDIGITAL_INTEGRATIONS_DB,
			'section'  => 'larisdigital_section_fbpixel',
			'type'     => 'text',
		);
	}

	$controls['fbpixel_noscript_disable'] = array(
		'label'    => esc_html__( 'Disable Facebook Pixel <noscript> code', 'larisdigital-wp' ),
		'setting'  => 'fbpixel_noscript_disable',
		'setting_type' => 'option_mod',
		'setting_db' => LARISDIGITAL_INTEGRATIONS_DB,
		'section'  => 'larisdigital_section_fbpixel',
		'type'     => 'checkbox',
	);

	$controls['fbpixel_autoconfig_enable'] = array(
		'label'    => esc_html__( 'Enable Facebook Pixel autoConfig (ex Microdata)', 'larisdigital-wp' ),
		'setting'  => 'fbpixel_autoconfig_enable',
		'setting_type' => 'option_mod',
		'setting_db' => LARISDIGITAL_INTEGRATIONS_DB,
		'section'  => 'larisdigital_section_fbpixel',
		'type'     => 'checkbox',
	);

	return $controls;
}

add_filter( 'larisdigital_customize_controls', 'larisdigital_customize_controls_google_adwords' );
function larisdigital_customize_controls_google_adwords( $controls ) {

	$controls['larisdigital_section_google_adwords'] = array(
		'title'    => esc_html__( 'Google Ads (Adwords)', 'larisdigital-wp' ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-success larisdigital-alert-with-icon">
							<span class="dashicons dashicons-megaphone"></span> '.esc_html__( 'We support multiple Google Ads (Adwords) - Global Site Tag IDs (maximum 5 different IDs) for all pages on this website.', 'larisdigital-wp' ).'
							</p>',
		'setting'  => 'larisdigital_section_google_adwords',
		'panel'    => 'larisdigital_panel_integrations',
		'type'     => 'section',
		'priority' => 210,
	);

	// $controls['larisdigital_warning_google_adwords'] = array(
	// 	'label'		=> '',
	// 	'description' => esc_html__( 'We use the latest Google gtag.js technology. All gtag.js events will be recorded simultaneously, both on Google Ads (Adwords) and Google Analytics.', 'larisdigital-wp' ),
	// 	'setting'  	=> 'larisdigital_warning_google_adwords',
	// 	'section'	=> 'larisdigital_section_google_adwords',
	// 	'type'   	=> 'warning',
	// );

	for ($i=1; $i <=5 ; $i++) { 
		$controls['google_adwords_'.$i] = array(
			'label'    => sprintf( esc_html__( 'Global Site Tag ID #%s', 'larisdigital-wp' ), $i ),
			'setting'  => 'google_adwords_'.$i,
			'setting_type' => 'option_mod',
			'setting_db' => LARISDIGITAL_INTEGRATIONS_DB,
			'section'  => 'larisdigital_section_google_adwords',
			'type'     => 'text',
			'input_attrs' => array(
				'placeholder' => 'AW-XXXXXXXX',
			),
		);
	}

	return $controls;
}

add_filter( 'larisdigital_customize_controls', 'larisdigital_customize_controls_google_analytics' );
function larisdigital_customize_controls_google_analytics( $controls ) {

	$controls['larisdigital_section_google_analytics'] = array(
		'title'    => esc_html__( 'Google Analytics', 'larisdigital-wp' ),
		'description' => '<p class="larisdigital-alert larisdigital-alert-success larisdigital-alert-with-icon">
							<span class="dashicons dashicons-megaphone"></span> '.esc_html__( 'We use the latest Google gtag.js technology for Google Analytics.', 'larisdigital-wp' ).'
							</p>',
		'setting'  => 'larisdigital_section_google_analytics',
		'panel'    => 'larisdigital_panel_integrations',
		'type'     => 'section',
		'priority' => 220,
	);

	// $controls['larisdigital_warning_google_analytics'] = array(
	// 	'label'		=> '',
	// 	'description' => esc_html__( 'We use the latest Google gtag.js technology. All gtag.js events will be recorded simultaneously, both on Google Ads (Adwords) and Google Analytics.', 'larisdigital-wp' ),
	// 	'setting'  	=> 'larisdigital_warning_google_analytics',
	// 	'section'	=> 'larisdigital_section_google_analytics',
	// 	'type'   	=> 'warning',
	// );

	$controls['google_analytics'] = array(
		'label'    => esc_html__( 'Google Analytics - Tracking ID', 'larisdigital-wp' ),
		'setting'  => 'google_analytics',
		'setting_type' => 'option_mod',
		'setting_db' => LARISDIGITAL_INTEGRATIONS_DB,
		'section'  => 'larisdigital_section_google_analytics',
		'type'     => 'text',
		'input_attrs' => array(
			'placeholder' => 'UA-XXXXXXXX-1',
		),
	);

	return $controls;
}

add_action( 'larisdigital_customize_controls', 'larisdigital_customize_controls_google_tag_manager' );
function larisdigital_customize_controls_google_tag_manager( $controls ) {

	$controls['larisdigital_section_google_tag_manager'] = array(
		'title'    => esc_html__( 'Google Tag Manager', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_section_google_tag_manager',
		'panel'    => 'larisdigital_panel_integrations',
		'type'     => 'section',
		'priority' => 230,
	);

	$controls['google_tag_manager'] = array(
		'label'    => esc_html__( 'Google Tag Manager - Container ID', 'larisdigital-wp' ),
		'setting'  => 'google_tag_manager',
		'setting_type' => 'option_mod',
		'setting_db' => LARISDIGITAL_INTEGRATIONS_DB,
		'section'  => 'larisdigital_section_google_tag_manager',
		'type'     => 'text',
		'input_attrs' => array(
			'placeholder' => 'GTM-XXXXXX',
		),
	);

	$controls['google_tag_manager_noscript_enable'] = array(
		'label'    => esc_html__( 'Enable Google Tag Manager <noscript> code', 'larisdigital-wp' ),
		'setting'  => 'google_tag_manager_noscript_enable',
		'setting_type' => 'option_mod',
		'setting_db' => LARISDIGITAL_INTEGRATIONS_DB,
		'section'  => 'larisdigital_section_google_tag_manager',
		'type'     => 'checkbox',
	);

	return $controls;
}

add_filter( 'larisdigital_customize_controls', 'larisdigital_customize_controls_histats' );
function larisdigital_customize_controls_histats( $controls ) {

	$controls['larisdigital_section_histats'] = array(
		'title'    => esc_html__( 'Histats', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_section_histats',
		'panel'    => 'larisdigital_panel_integrations',
		'type'     => 'section',
		'priority' => 240,
	);

	$controls['histats'] = array(
		'label'    => esc_html__( 'Histats - Website ID', 'larisdigital-wp' ),
		'setting'  => 'histats',
		'setting_type' => 'option_mod',
		'setting_db' => LARISDIGITAL_INTEGRATIONS_DB,
		'section'  => 'larisdigital_section_histats',
		'type'     => 'text',
	);

	return $controls;
}

add_filter( 'larisdigital_customize_controls', 'larisdigital_customize_controls_statcounter' );
function larisdigital_customize_controls_statcounter( $controls ) {

	$controls['larisdigital_section_statcounter'] = array(
		'title'    => esc_html__( 'StatCounter', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_section_statcounter',
		'panel'    => 'larisdigital_panel_integrations',
		'type'     => 'section',
		'priority' => 250,
	);

	$controls['statcounter_project'] = array(
		'label'    => esc_html__( 'Statcounter - Project ID', 'larisdigital-wp' ),
		'setting'  => 'statcounter_project',
		'setting_type' => 'option_mod',
		'setting_db' => LARISDIGITAL_INTEGRATIONS_DB,
		'section'  => 'larisdigital_section_statcounter',
		'type'     => 'text',
	);

	$controls['statcounter_security'] = array(
		'label'    => esc_html__( 'Statcounter - Security ID', 'larisdigital-wp' ),
		'setting'  => 'statcounter_security',
		'setting_type' => 'option_mod',
		'setting_db' => LARISDIGITAL_INTEGRATIONS_DB,
		'section'  => 'larisdigital_section_statcounter',
		'type'     => 'text',
	);

	return $controls;
}

add_filter( 'larisdigital_customize_controls', 'larisdigital_customize_controls_custom_script' );
function larisdigital_customize_controls_custom_script( $controls ) {

	$controls['larisdigital_section_header_script'] = array(
		'title'    => esc_html__( 'Custom Header Script', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_section_header_script',
		'panel'    => 'larisdigital_panel_integrations',
		'type'     => 'section',
		'priority' => 800,
	);

	$controls['script_header'] = array(
		'label'    => esc_html__( 'Custom Header Script', 'larisdigital-wp' ),
		'setting'  => 'script_header',
		'setting_type' => 'option_mod',
		'setting_db' => LARISDIGITAL_INTEGRATIONS_DB,
		'section'  => 'larisdigital_section_header_script',
		'type'     => 'textarea-unfiltered',
	);

	$controls['larisdigital_section_footer_script'] = array(
		'title'    => esc_html__( 'Custom Footer Script', 'larisdigital-wp' ),
		'setting'  => 'larisdigital_section_footer_script',
		'panel'    => 'larisdigital_panel_integrations',
		'type'     => 'section',
		'priority' => 900,
	);

	$controls['script_footer'] = array(
		'label'    => esc_html__( 'Custom Footer Script', 'larisdigital-wp' ),
		'setting'  => 'script_footer',
		'setting_type' => 'option_mod',
		'setting_db' => LARISDIGITAL_INTEGRATIONS_DB,
		'section'  => 'larisdigital_section_footer_script',
		'type'     => 'textarea-unfiltered',
	);

	return $controls;
}

add_action( 'wp_head', 'larisdigital_integrations_wp_head', 100 );
function larisdigital_integrations_wp_head() {
	$integrations = get_option( LARISDIGITAL_INTEGRATIONS_DB );

	$fbpixel_ids = array();
	for ($i=1; $i <=5 ; $i++) { 
		if ( isset( $integrations['fbpixel_'.$i] ) && $integrations['fbpixel_'.$i] ) {
			$fbpixel_id = trim( $integrations['fbpixel_'.$i] );
			if ( $fbpixel_id ) {
				$fbpixel_ids[$fbpixel_id] = $fbpixel_id;
			}
		}
	}
	$fbpixel_ids = apply_filters( 'larisdigital_fbpixel_ids', $fbpixel_ids );

	$fbpixel_autoconfig = isset( $integrations['fbpixel_autoconfig_enable'] ) && $integrations['fbpixel_autoconfig_enable'] ? true : false;

	if ( ! empty( $fbpixel_ids ) ) {
?>
<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','https://connect.facebook.net/en_US/fbevents.js');
<?php foreach ( $fbpixel_ids as $fbpixel_id ) : ?>
<?php if ( ! $fbpixel_autoconfig ) : ?>
fbq('set', 'autoConfig', 'false', '<?php echo esc_attr( $fbpixel_id ); ?>');
<?php endif; ?>
fbq('init', '<?php echo esc_attr( $fbpixel_id ); ?>');
<?php endforeach; ?>
fbq('track', 'PageView', {
	"source": "<?php echo LARISDIGITAL_THEME_SLUG; ?>",
	"version": "<?php echo LARISDIGITAL_THEME_VERSION; ?>"
});
</script>
<!-- End Facebook Pixel Code -->
<?php 
	}

	$fbpixel_active = ! empty( $fbpixel_ids ) ? true : false;
	$fbpixel_active = apply_filters( 'larisdigital_fbpixel_active', $fbpixel_active );

	if ( $fbpixel_active ) {
		do_action( 'larisdigital_fbpixel_wp_head' );
	}

	global $larisdigital_fbpixel_ids, $larisdigital_fbpixel_active;
	$larisdigital_fbpixel_ids = $fbpixel_ids;
	$larisdigital_fbpixel_active = $fbpixel_active;

	$gtag_ids = array();
	if ( isset( $integrations['google_analytics'] ) && $integrations['google_analytics'] ) {
		$google_analytics = trim( $integrations['google_analytics'] );
		if ( $google_analytics ) {
			$gtag_ids[$google_analytics] = $google_analytics;
		}
	}
	for ($i=1; $i <=5 ; $i++) { 
		if ( isset( $integrations['google_adwords_'.$i] ) && $integrations['google_adwords_'.$i] ) {
			$google_adwords_id = trim( $integrations['google_adwords_'.$i] );
			if ( $google_adwords_id ) {
				if ( strpos( $google_adwords_id, 'AW-' ) === false ) {
					$google_adwords_id = 'AW-'.$google_adwords_id;
				}
				$gtag_ids[$google_adwords_id] = $google_adwords_id;
			}
		}
	}
	$gtag_ids = apply_filters( 'larisdigital_gtag_ids', $gtag_ids );

	global $larisdigital_gtag_ids;
	$larisdigital_gtag_ids = $gtag_ids;

	if ( ! empty( $gtag_ids ) ) {
		$gtag_base_id = reset( $gtag_ids );
		if ( $gtag_base_id ) {
?>
<!-- Global site tag (gtag.js) - AdWords & Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr( $gtag_base_id ); ?>"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
<?php foreach ( $gtag_ids as $gtag_id ) : ?>
  gtag('config', '<?php echo esc_attr( $gtag_id ); ?>');
<?php endforeach; ?>
</script>
<!-- End Global site tag (gtag.js) - AdWords & Analytics -->
<?php 
		}
	}

	$gtag_active = ! empty( $gtag_ids ) ? true : false;
	$gtag_active = apply_filters( 'larisdigital_gtag_active', $gtag_active );

	if ( $gtag_active ) {
		do_action( 'larisdigital_gtag_wp_head' );
	}

	global $larisdigital_gtag_ids, $larisdigital_gtag_active;
	$larisdigital_gtag_ids = $gtag_ids;
	$larisdigital_gtag_active = $gtag_active;

	if ( isset( $integrations['google_tag_manager'] ) && $integrations['google_tag_manager'] ) {
		$google_tag_manager = trim( $integrations['google_tag_manager'] );
		if ( $google_tag_manager ) {
?>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','<?php echo esc_attr( $google_tag_manager ); ?>');</script>
<!-- End Google Tag Manager -->
<?php 
		}
	}

	if ( isset( $integrations['script_header'] ) && $integrations['script_header'] ) {
		$script_header = trim( $integrations['script_header'] );
		if ( $script_header ) {
			echo $script_header."\n";
		}
	}

	do_action( 'larisdigital_custom_script_wp_head' );
}

add_action( 'wp_footer', 'larisdigital_integrations_wp_footer', 100 );
function larisdigital_integrations_wp_footer() {
	$integrations = get_option( LARISDIGITAL_INTEGRATIONS_DB );

	global $larisdigital_fbpixel_ids, $larisdigital_fbpixel_active;

	$fbpixel_noscript = isset( $integrations['fbpixel_noscript_disable'] ) && $integrations['fbpixel_noscript_disable'] ? false : true;

	if ( $fbpixel_noscript ) {
		$fbpixel_ids = $larisdigital_fbpixel_ids;
		if ( ! empty( $fbpixel_ids ) ) {
			foreach ( $fbpixel_ids as $fbpixel_id ) {
?>
<!-- Facebook Pixel Code -->
<noscript><img height="1" width="1" alt="fbpx" style="display:none" src="https://www.facebook.com/tr?id=<?php echo esc_attr( $fbpixel_id ); ?>&ev=PageView&noscript=1" /></noscript>
<!-- End Facebook Pixel Code -->
<?php 
			}
		}
	}

	if ( $larisdigital_fbpixel_active ) {
		do_action( 'larisdigital_fbpixel_wp_footer' );
	}

	global $larisdigital_gtag_ids, $larisdigital_gtag_active;

	if ( $larisdigital_gtag_active ) {
		do_action( 'larisdigital_gtag_wp_footer' );
	}

	if ( isset( $integrations['script_footer'] ) && $integrations['script_footer'] ) {
		$script_footer = trim( $integrations['script_footer'] );
		if ( $script_footer ) {
			echo $script_footer."\n";
		}
	}

	do_action( 'larisdigital_custom_script_wp_footer' );

	if ( isset( $integrations['histats'] ) && $integrations['histats'] ) {
		$histats = trim( $integrations['histats'] );
		if ( $histats ) {
?>
<!-- Histats.com  START  (aync)-->
<script type="text/javascript">var _Hasync= _Hasync|| [];
_Hasync.push(['Histats.start', '1,<?php echo esc_attr( $histats ); ?>,4,0,0,0,00010000']);
_Hasync.push(['Histats.fasi', '1']);
_Hasync.push(['Histats.track_hits', '']);
(function() {
var hs = document.createElement('script'); hs.type = 'text/javascript'; hs.async = true;
hs.src = ('//s10.histats.com/js15_as.js');
(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(hs);
})();</script>
<noscript><a href="/" target="_blank"><img  src="//sstatic1.histats.com/0.gif?<?php echo esc_attr( $histats ); ?>&101" alt="hit counter script" border="0"></a></noscript>
<!-- Histats.com  END  -->
<?php 
		}
	}

	if ( isset( $integrations['statcounter_project'] ) && $integrations['statcounter_project'] && isset( $integrations['statcounter_security'] ) && $integrations['statcounter_security'] ) {
		$statcounter_project = trim( $integrations['statcounter_project'] );
		$statcounter_security = trim( $integrations['statcounter_security'] );
		if ( $statcounter_project && $statcounter_security ) {
?>
<!-- Start of StatCounter Code for Default Guide -->
<script type="text/javascript">
var sc_project=<?php echo esc_attr( $statcounter_project ); ?>; 
var sc_invisible=1; 
var sc_security="<?php echo esc_attr( $statcounter_security ); ?>"; 
var scJsHost = (("https:" == document.location.protocol) ?
"https://secure." : "http://www.");
document.write("<sc"+"ript type='text/javascript' src='" +
scJsHost+
"statcounter.com/counter/counter.js'></"+"script>");
</script>
<noscript><div class="statcounter"><a title="web analytics"
href="http://statcounter.com/" target="_blank"><img
class="statcounter"
src="//c.statcounter.com/<?php echo esc_attr( $statcounter_project ); ?>/0/<?php echo esc_attr( $statcounter_security ); ?>/1/" alt="web
analytics"></a></div></noscript>
<!-- End of StatCounter Code for Default Guide -->
<?php 
		}
	}

}

add_action( 'larisdigital_body_before', 'larisdigital_integrations_larisdigital_body_before', 1 );
function larisdigital_integrations_larisdigital_body_before() {
	$integrations = get_option( LARISDIGITAL_INTEGRATIONS_DB );

	if ( isset( $integrations['google_tag_manager_noscript_enable'] ) && $integrations['google_tag_manager_noscript_enable'] ) {
		if ( isset( $integrations['google_tag_manager'] ) && $integrations['google_tag_manager'] ) {
			$google_tag_manager = trim( $integrations['google_tag_manager'] );
			if ( $google_tag_manager ) {
?>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo esc_attr( $google_tag_manager ); ?>"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php 
			}
		}
	}
}
