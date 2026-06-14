<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_filter( 'larisdigital_whatsapp_message_default', 'larisdigital_id_whatsapp_message_default' );
function larisdigital_id_whatsapp_message_default( $default ) {
	return 'Halo %site_name%, saya tertarik dengan %product_title%, terimakasih.';
}

add_filter( 'larisdigital_customize_controls', 'larisdigital_id_customize_controls', 999 );
function larisdigital_id_customize_controls( $controls ) {
	if ( isset( $controls['larisdigital_heading_browser_color'] ) ) {
		$controls['larisdigital_heading_browser_color']['description'] = '<p class="larisdigital-alert larisdigital-alert-warning larisdigital-alert-with-icon"><span class="dashicons dashicons-warning"></span> Fitur ini bisa digunakan untuk memberikan warna tab browser di perangkat mobile, khususnya Android.</p>';
	}
	if ( isset( $controls['larisdigital_heading_favicon'] ) ) {
		$controls['larisdigital_heading_favicon']['description'] = '<p class="larisdigital-alert larisdigital-alert-warning larisdigital-alert-with-icon"><span class="dashicons dashicons-warning"></span> Favicon adalah gambar / icon kecil yang terlihat di tab browser, bookmark, dkk. <br><br> Silahkan upload gambar dengan bentuk persegi (square) dengan ukuran minimal 512x512 pixel.</p>';
	}
	if ( isset( $controls['larisdigital_panel_settings'] ) ) {
		$controls['larisdigital_panel_settings']['description'] = '<p class="larisdigital-alert larisdigital-alert-warning larisdigital-alert-with-icon"><span class="dashicons dashicons-warning"></span> Panel "Theme Settings - General" berisi semua opsi yang berhubungan dengan basic theme, mulai dari basic font (typography), top bar di paling atas, hingga footer di paling bawah.</p>';
	}
	if ( isset( $controls['larisdigital_wc_panel_settings'] ) ) {
		$controls['larisdigital_wc_panel_settings']['description'] = '<p class="larisdigital-alert larisdigital-alert-warning larisdigital-alert-with-icon"><span class="dashicons dashicons-warning"></span> Panel "Theme Settings - WooCommerce" berisi semua opsi yang berhubungan dengan fitur di WooCommerce.</p>';
	}
	if ( isset( $controls['larisdigital_panel_integrations'] ) ) {
		$controls['larisdigital_panel_integrations']['description'] = '<p class="larisdigital-alert larisdigital-alert-warning larisdigital-alert-with-icon"><span class="dashicons dashicons-warning"></span> Panel "Theme Settings - Integrations" berisi semua opsi yang berhubungan dengan semua integrasi dengan pihak ketiga.</p>';
	}
	if ( class_exists( 'WPBisnis_WhatsApp_Rotator_Init' ) ) {
		if ( isset( $controls['larisdigital_heading_whatsapp_rotator'] ) ) {
			$controls['larisdigital_heading_whatsapp_rotator']['description'] = '<p class="larisdigital-alert larisdigital-alert-warning larisdigital-alert-with-icon"><span class="dashicons dashicons-warning"></span> Anda sedang menggunakan plugin WPBisnis WhatsApp Rotator. Silahkan ke halaman settings plugin tersebut jika ingin mengganti WhatsApp link di shop page dan single product dengan WhatsApp Rotator dari plugin tersebut.</p>';
		}
	}
	return $controls;
}

add_action( 'customize_register', 'larisdigital_id_customize_register', 999 );
function larisdigital_id_customize_register( $wp_customize ) {
	$wp_customize->get_control( 'site_icon' )->description = '';
}
