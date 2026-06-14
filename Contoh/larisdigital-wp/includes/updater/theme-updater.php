<?php
/**
 * Easy Digital Downloads Theme Updater
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Includes the files needed for the theme updater
if ( !class_exists( 'LarisDigital_Theme_Updater_Admin' ) ) {
	include( dirname( __FILE__ ) . '/theme-updater-admin.php' );
}

// Loads the updater classes
global $larisdigital_updater;
$larisdigital_updater = new LarisDigital_Theme_Updater_Admin(

	// Config settings
	$config = array(
		'remote_api_url' => LARISDIGITAL_API_URL,
		'download_id'    => LARISDIGITAL_API_ID,
		'item_name'      => LARISDIGITAL_THEME_NAME,
		'theme_slug'     => LARISDIGITAL_THEME_SLUG,
		'version'        => LARISDIGITAL_THEME_VERSION,
		'author'         => 'TokoPressID',
		'renew_url'      => '',
		'beta'           => false,
	),

	// Strings
	$strings = array(
		'theme-license'             => __( 'Theme License', 'larisdigital-wp' ),
		'enter-key'                 => __( 'Silahkan masukkan kode lisensi Anda.', 'larisdigital-wp' ),
		'enter-key-placeholder'     => __( 'masukkan kode lisensi di sini', 'larisdigital-wp' ),
		'license-key'               => __( 'Kode Lisensi Anda', 'larisdigital-wp' ),
		'license-action'            => __( 'License Action', 'larisdigital-wp' ),
		'deactivate-license'        => __( 'Deactivate', 'larisdigital-wp' ),
		'activate-license'          => __( 'Activate', 'larisdigital-wp' ),
		'change-license'            => __( 'Ganti Lisensi', 'larisdigital-wp' ),
		'status-unknown'            => __( 'Status lisensi tidak diketahui.', 'larisdigital-wp' ),
		'renew'                     => __( 'Renew?', 'larisdigital-wp' ),
		'unlimited'                 => __( 'unlimited', 'larisdigital-wp' ),
		'license-key-is-active'     => __( 'Kode lisensi AKTIF.', 'larisdigital-wp' ),
		'expires%s'                 => __( 'Kadaluarsa %s.', 'larisdigital-wp' ),
		'expires-never'             => __( 'Lisensi LIFETIME.', 'larisdigital-wp' ),
		'%1$s/%2$-sites'            => __( 'Anda sudah mengaktifkan lisensi ini untuk %1$s website dari limit %2$s website yang tersedia.', 'larisdigital-wp' ),
		'license-key-expired-%s'    => __( 'Kode lisensi kadaluarsa %s.', 'larisdigital-wp' ),
		'license-key-expired'       => __( 'Kode lisensi telah kadaluarsa.', 'larisdigital-wp' ),
		'license-keys-do-not-match' => __( 'Kode lisensi TIDAK COCOK.', 'larisdigital-wp' ),
		'license-is-inactive'       => __( 'Lisensi TIDAK AKTIF.', 'larisdigital-wp' ),
		'license-key-is-disabled'   => __( 'Kode lisensi telah dinonaktifkan.', 'larisdigital-wp' ),
		'site-is-inactive'          => __( 'Lisensi tidak aktif di website ini.', 'larisdigital-wp' ),
		'license-status-unknown'    => __( 'Status lisensi tidak diketahui.', 'larisdigital-wp' ),
		'update-notice'             => __( "Dengan mengupdate WordPress Theme ini, Anda bisa saja kehilangan modifikasi yang Ada lakukan di theme ini, khususnya jika Anda sudah melakukan modifikasi di theme ini. Klik 'Cancel' untuk batal, 'OK' untuk update.", 'larisdigital-wp' ),
		'update-available'          => __('<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'larisdigital-wp' ),
	)

);
