<?php

/**
 * Merlin WP configuration file.
 */

if ( ! class_exists( 'Merlin' ) ) {
	return;
}

define( 'MERLIN_VERSION', LARISDIGITAL_THEME_VERSION );

$merlin_config = array(
	'directory'             => 'includes/merlin',
	'merlin_url'            => 'theme-setup',
	'child_action_btn_url'  => 'https://help.tokopress.id/article/225-child-theme',
	'dev_mode'              => true,
	'license_step'          => true,
	'license_required'      => true,
	'license_help_url'      => 'https://www.tokopress.id/my-account/',
	'edd_remote_api_url'    => LARISDIGITAL_API_URL,
	'edd_item_name'			=> LARISDIGITAL_THEME_NAME, 
	'edd_theme_slug'        => LARISDIGITAL_THEME_SLUG,
);

$merlin_strings = array(
	'admin-menu'              	=> esc_html__( 'Theme Setup' , 'larisdigital-wp' ),
	
	'title%s%s%s%s' 		  	=> esc_html__( '%1$s%2$s %3$s Theme &lsaquo; Installation Wizard: %4$s' , 'larisdigital-wp' ),
	'return-to-dashboard'     	=> esc_html__( 'Kembali ke Dashboard Admin WordPress' , 'larisdigital-wp' ),
	'ignore'                  	=> esc_html__( 'NON AKTIFKAN Installation Wizard', 'larisdigital-wp' ),
	
	'btn-skip'                	=> esc_html__( 'Skip', 'larisdigital-wp' ),
	'btn-next'                	=> esc_html__( 'Next', 'larisdigital-wp' ),
	'btn-start'               	=> esc_html__( 'Start', 'larisdigital-wp' ),
	'btn-no'                  	=> esc_html__( 'Cancel', 'larisdigital-wp' ),
	'btn-integration-select'    => esc_html__( 'Select', 'larisdigital-wp' ),
	'btn-plugins-install'     	=> esc_html__( 'Install', 'larisdigital-wp' ),
	'btn-child-install'       	=> esc_html__( 'Install', 'larisdigital-wp' ),
	'btn-content-install'     	=> esc_html__( 'Install', 'larisdigital-wp' ),
	'btn-import'              	=> esc_html__( 'Run Setup' , 'larisdigital-wp' ),
	'btn-license-activate'    	=> esc_html__( 'Activate', 'larisdigital-wp' ),
	'btn-license-skip'        	=> esc_html__( 'Nanti Saja', 'larisdigital-wp' ),

	'welcome-header%s'        	=> esc_html__( '%s Installation Wizard' , 'larisdigital-wp' ),
	'welcome-header-success%s'	=> esc_html__( 'Halo, Selamat Datang Kembali' , 'larisdigital-wp' ),
	'welcome%s'               	=> esc_html__( 'Installation Wizard ini mempermudah Anda untuk setup website, khususnya untuk website WordPress yang baru. Proses ini tidak wajib (opsional) dan membutuhkan waktu cuma beberapa menit saja koq ^_^' , 'larisdigital-wp' ),
	'welcome-success%s'       	=> esc_html__( 'Anda sudah pernah menjalankan Installation Wizard sebelumnya. Jika ingin mengulang proses ini, silahkan tekan tombol "Start".' , 'larisdigital-wp' ),
	
	'child-header'              => esc_html__( 'Install Child Theme' , 'larisdigital-wp' ),
	'child-header-success'      => esc_html__( 'Child Theme Sudah Aktif!' , 'larisdigital-wp' ),
	'child'                     => esc_html__( 'Proses ini mempermudah Anda untuk membuat dan mengaktifkan Child Theme di website ini secara OTOMATIS. Child Theme sangat direkomendasikan, supaya Anda bisa dengan mudah memasukkan custom function ke depannya (jika diperlukan), namun tetap bisa update theme secara otomatis setiap ada update terbaru.' , 'larisdigital-wp' ),
	'child-success%s'           => esc_html__( 'Child Theme sudah berhasil dibuat dan diaktifkan.' , 'larisdigital-wp' ),
	'child-action-link'         => esc_html__( 'Pelajari apa itu Child Theme &rarr;' , 'larisdigital-wp' ),
	'child-json-success%s'      => esc_html__( 'SELAMAT, Child Theme berhasil dibuat dan diaktifkan.' , 'larisdigital-wp' ),
	'child-json-already%s'      => esc_html__( 'SELAMAT, Child Theme sudah aktif.' , 'larisdigital-wp' ),
	
	'license-header%s'        	=> esc_html__( 'Aktivasi Theme' , 'larisdigital-wp' ),
	'license-header-success%s'	=> esc_html__( 'Lisensi Key Sudah Aktif!' , 'larisdigital-wp' ),
	'license%s'               	=> esc_html__( 'Masukkan License Key di bawah ini untuk mengaktifkan theme dan semua fitur di dalamnya, dan sekaligus mengaktifkan fungsi automatic update.' , 'larisdigital-wp' ),
	'license-label'           	=> esc_html__( 'Kode Lisensi:' , 'larisdigital-wp' ),
	'license-success%s'       	=> esc_html__( 'Aktivasi theme sudah berhasil, Anda dapat melakukan langkah selanjutnya!' , 'larisdigital-wp' ),
	'license-json-success%s'  	=> esc_html__( 'License Key berhasil diaktifkan. Semua fitur dan automatic update sudah aktif.', 'larisdigital-wp' ),
	'license-tooltip'         	=> esc_html__( 'Lisensi Key di MyAccount TokoPressID!', 'larisdigital-wp' ),
	
	'integration-header'        => esc_html__( 'Pilih Integrasi Yang Anda Inginkan' , 'larisdigital-wp' ),
	'integration'               => esc_html__( 'Silahkan pilih integrasi yang Anda inginkan, supaya kami bisa menyesuaikan plugin apa yang perlu di-install untuk mempermudah setup selanjutnya' , 'larisdigital-wp' ),
	'integration-success'       => esc_html__( 'Integrasi sudah dipilih, silahkan lanjutkan langkah selanjutnya' , 'larisdigital-wp' ),
	'integration-action-link'   => esc_html__( 'Detail' , 'larisdigital-wp' ),
	
	'plugins-header'            => esc_html__( 'Install Plugin Yang Dibutuhkan' , 'larisdigital-wp' ),
	'plugins-header-success'    => esc_html__( 'Semua Plugin Sudah Aktif!' , 'larisdigital-wp' ),
	'plugins'                   => esc_html__( 'Proses ini mempermudah Anda untuk menginstall dan mengaktifkan semua plugin yang dibutuhkan theme ini secara OTOMATIS. Pastikan koneksi internet Anda aktif untuk bisa men-download plugin.' , 'larisdigital-wp' ),
	'plugins-success%s'         => esc_html__( 'Semua plugin yang dibutuhkan sudah berhasil diaktifkan. Silahkan lanjutkan proses selanjutnya.' , 'larisdigital-wp' ),
	'plugins-action-link'       => esc_html__( 'Detail' , 'larisdigital-wp' ),
	
	'import-header'             => esc_html__( 'Setup Web Jualan' , 'larisdigital-wp' ),
	'import'                    => esc_html__( 'Anda bisa menggunakan proses ini membantu setup web jualan Anda.' , 'larisdigital-wp' ),
	'import_again'              => esc_html__( 'Anda sudah pernah melakukan proses setup web jualan Anda di halaman ini sebelumnya. Jika ingin mengulangi prosesnya, silahkan klik untuk memilih opsi-opsi yang ingin Anda jalankan di bawah ini.' , 'larisdigital-wp' ),
	'import-action-link'        => esc_html__( 'Detail' , 'larisdigital-wp' ),
	
	'ready-header'              => esc_html__( 'Proses Theme Setup Telah Selesai!', 'larisdigital-wp' ),
	'ready%s'                   => esc_html__( 'Terimakasih telah menggunakan theme dari %s. Anda bisa melanjutkan beberapa setup yang diperlukan melalui menu yang tersedia di bawah ini:' , 'larisdigital-wp' ),
	'ready-action-link'         => esc_html__( 'Informasi Lainnya' , 'larisdigital-wp' ),
	'ready-big-button'          => esc_html__( 'Lihat Website Anda' , 'larisdigital-wp' ),
	'ready-link-1'              => '',
	'ready-link-2'              => '',
	'ready-link-3'              => '',
	'ready-link-4'              => '',
	'ready-link-5'              => '',
	'ready-link-6'              => '',
	'ready-link-7'              => wp_kses( sprintf( '<a href="'.admin_url( 'customize.php?autofocus[section]=larisdigital_section_fbpixel' ).'" target="_blank">%s</a>', esc_html__( 'Pasang Facebook Pixel', 'larisdigital-wp' ) ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ),
	'ready-link-8'              => wp_kses( sprintf( '<a href="'.admin_url( 'customize.php' ).'" target="_blank">%s</a>', esc_html__( 'Lihat Theme Settings', 'larisdigital-wp' ) ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ),
	'ready-link-9'              => wp_kses( sprintf( '<a href="%1$s" target="_blank">%2$s</a>', LARISDIGITAL_DOCS_URL, esc_html__( 'Lihat Dokumentasi Theme', 'larisdigital-wp' ) ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ),
	'ready-link-10'              => wp_kses( sprintf( '<a href="%1$s" target="_blank">%2$s</a>', LARISDIGITAL_SUPPORT_URL, esc_html__( 'Kontak Support Kami', 'larisdigital-wp' ) ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ),
);

$larisdigital_integration = get_option( 'tokopress_integration' );
if ( $larisdigital_integration == 'woocommerce' ) {
	$merlin_strings['import-header'] = esc_html__( 'Setup LarisDigital WooCommerce' , 'larisdigital-wp' );
	$merlin_strings['import'] = esc_html__( 'Anda bisa menggunakan proses ini membantu setup web jualan Anda. Setelah itu tinggal upload produk, ganti email akun Paypal, dan Anda sudah siap langsung jualan.' , 'larisdigital-wp' );
	$merlin_strings['ready-link-1'] = wp_kses( sprintf( '<a href="'.admin_url( 'edit.php?post_type=product' ).'" target="_blank">%s</a>', esc_html__( 'Mulai masukkan produk milik Anda', 'larisdigital-wp' ) ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) );
	$merlin_strings['ready-link-2'] = wp_kses( sprintf( '<a href="'.admin_url( 'admin.php?page=wc-settings&tab=checkout' ).'" target="_blank">%s</a>', esc_html__( 'Setup Akun Paypal Untuk Pembayaran', 'larisdigital-wp' ) ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) );
}
elseif ( $larisdigital_integration == 'sejoli' ) {
	if ( !defined( 'SEJOLISA_VERSION') ) {
		$merlin_strings['plugins-header'] = esc_html__( 'Plugin Sejoli Belum Aktif' , 'larisdigital-wp' );
		$merlin_strings['plugins-header-success'] = esc_html__( 'Plugin Sejoli Belum Aktif' , 'larisdigital-wp' );
		$merlin_strings['plugins'] = esc_html__( 'Proses ini mempermudah Anda untuk menginstall dan mengaktifkan semua plugin yang dibutuhkan theme ini secara OTOMATIS. Pastikan koneksi internet Anda aktif untuk bisa men-download plugin. Namun, Ada baiknya Anda menginstall dan mengaktifkan plugin Sejoli terlebih dahulu sebelum Anda melanjutkan proses ini.' , 'larisdigital-wp' );
		$merlin_strings['plugins-success%s'] = esc_html__( 'Ada baiknya Anda menginstall dan mengaktifkan plugin Sejoli terlebih dahulu sebelum Anda melanjutkan proses ini.' , 'larisdigital-wp' );
	}
	$merlin_strings['import-header'] = esc_html__( 'Setup LarisDigital Sejoli' , 'larisdigital-wp' );
	$merlin_strings['import'] = esc_html__( 'Anda bisa menggunakan proses ini membantu setup web jualan Anda dengan LarisDigital dan Sejoli.' , 'larisdigital-wp' );
}

$merlin_wizard = new Merlin(
	// Configure Merlin with custom settings.
	$config = $merlin_config,
	// Text strings.
	$strings = $merlin_strings
);

add_filter( 'merlin_generate_child_style_css', 'larisdigital_merlin_generate_child_style_css', 10, 4 );
function larisdigital_merlin_generate_child_style_css( $output, $slug, $parent, $version ) {
	$output = "/* 
Theme Name: LarisDigital WP Child
Theme URI: https://www.tokopress.id/downloads/larisdigital-woocommerce-wordpress-theme/
Author: TokoPressID
Author URI: https://www.tokopress.id
Description: The Best WooCommerce WordPress Theme Untuk Jualan Produk Digital
Version: {$version}
Template: {$slug}
Tags: one-column, two-columns, blog, e-commerce
License: GNU General Public License v3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

/* Please add your custom CSS code below this line. */



";
	return $output;
}

add_filter( 'merlin_generate_child_functions_php', 'larisdigital_merlin_generate_child_functions_php', 10, 2 );
function larisdigital_merlin_generate_child_functions_php( $output, $slug ) {
	$output = "<?php 
/**
 * LarisDigital WP Child Theme functions and definitions.
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action( 'after_setup_theme', 'larisdigital_load_childtheme_languages', 5 );
function larisdigital_load_childtheme_languages() { 
	/* this theme supports localization */ 
	load_child_theme_textdomain( 'larisdigital-wp', get_stylesheet_directory() . '/languages' );
}

/* Please add your custom functions code below this line. */



";
	return $output;
}

add_filter( 'merlin_generate_child_screenshot', 'larisdigital_merlin_generate_child_screenshot' );
function larisdigital_merlin_generate_child_screenshot() {
	if ( file_exists( get_parent_theme_file_path( '/assets/img/child.jpg' ) ) ) {
		return get_parent_theme_file_path( '/assets/img/child.jpg' );
	}
	return get_parent_theme_file_path( '/assets/img/child.png' );
}

add_filter( 'merlin_step_content_is_active', '__return_true' );

add_filter( 'merlin_get_integration_option', 'larisdigital_merlin_get_integration_option', 10 );
function larisdigital_merlin_get_integration_option( $option ) {
	return 'tokopress_integration';
}

add_filter( 'merlin_get_integrations', 'larisdigital_merlin_get_integrations', 10 );
function larisdigital_merlin_get_integrations( $integrations ) {
	$integrations['woocommerce'] = array(
		'name'            => 'WooCommerce',
		'active'          => true,
	);
	$integrations['sejoli'] = array(
		'name'            => 'Sejoli',
		'active'          => true,
	);
	$integrations['edd'] = array(
		'name'            => 'EasyDigitalDownloads (EDD)',
		'active'          => true,
	);
	$integrations['gumroad'] = array(
		'name'            => 'Gumroad',
		'active'          => true,
	);
	$integrations['shop'] = array(
		'name'            => 'LarisDigital Store (Tanpa Plugin Lain)',
		'active'          => false,
	);
	return $integrations;
}

add_filter( 'merlin_get_base_content', 'larisdigital_merlin_get_base_content', 10, 2 );
function larisdigital_merlin_get_base_content( $content, $selected_import_index ) {
	$integration = get_option( 'tokopress_integration' );

	if ( $integration == 'woocommerce' ) {
		$content['setup_currency'] = array(
			'title'            => esc_html__( 'Setup Mata Uang ke US Dollar (USD)', 'larisdigital-wp' ),
			'description'      => '',
			'pending'          => esc_html__( 'Pending', 'larisdigital-wp' ),
			'installing'       => esc_html__( 'Installing', 'larisdigital-wp' ),
			'success'          => esc_html__( 'Success', 'larisdigital-wp' ),
			'install_callback' => 'larisdigital_merlin_setup_currency',
			'checked'          => 1,
			'data'             => $selected_import_index,
		);
		$content['setup_page_shop'] = array(
			'title'            => esc_html__( 'Setup Halaman Shop di WooCommerce', 'larisdigital-wp' ),
			'description'      => '',
			'pending'          => esc_html__( 'Pending', 'larisdigital-wp' ),
			'installing'       => esc_html__( 'Installing', 'larisdigital-wp' ),
			'success'          => esc_html__( 'Success', 'larisdigital-wp' ),
			'install_callback' => 'larisdigital_merlin_setup_page_shop',
			'checked'          => 1,
			'data'             => $selected_import_index,
		);
		$content['setup_page_cart'] = array(
			'title'            => esc_html__( 'Setup Halaman Cart di WooCommerce', 'larisdigital-wp' ),
			'description'      => '',
			'pending'          => esc_html__( 'Pending', 'larisdigital-wp' ),
			'installing'       => esc_html__( 'Installing', 'larisdigital-wp' ),
			'success'          => esc_html__( 'Success', 'larisdigital-wp' ),
			'install_callback' => 'larisdigital_merlin_setup_page_cart',
			'checked'          => 1,
			'data'             => $selected_import_index,
		);
		$content['setup_page_checkout'] = array(
			'title'            => esc_html__( 'Setup Halaman Checkout di WooCommerce', 'larisdigital-wp' ),
			'description'      => '',
			'pending'          => esc_html__( 'Pending', 'larisdigital-wp' ),
			'installing'       => esc_html__( 'Installing', 'larisdigital-wp' ),
			'success'          => esc_html__( 'Success', 'larisdigital-wp' ),
			'install_callback' => 'larisdigital_merlin_setup_page_checkout',
			'checked'          => 1,
			'data'             => $selected_import_index,
		);
		$content['setup_page_myaccount'] = array(
			'title'            => esc_html__( 'Setup Halaman My Account di WooCommerce', 'larisdigital-wp' ),
			'description'      => '',
			'pending'          => esc_html__( 'Pending', 'larisdigital-wp' ),
			'installing'       => esc_html__( 'Installing', 'larisdigital-wp' ),
			'success'          => esc_html__( 'Success', 'larisdigital-wp' ),
			'install_callback' => 'larisdigital_merlin_setup_page_myaccount',
			'checked'          => 1,
			'data'             => $selected_import_index,
		);
		$content['setup_homepage'] = array(
			'title'            => esc_html__( 'Setup Halaman Shop Jadi Homepage', 'larisdigital-wp' ),
			'description'      => '',
			'pending'          => esc_html__( 'Pending', 'larisdigital-wp' ),
			'installing'       => esc_html__( 'Installing', 'larisdigital-wp' ),
			'success'          => esc_html__( 'Success', 'larisdigital-wp' ),
			'install_callback' => 'larisdigital_merlin_setup_homepage',
			'checked'          => 1,
			'data'             => $selected_import_index,
		);
		$content['setup_blog'] = array(
			'title'            => esc_html__( 'Setup Halaman Blog', 'larisdigital-wp' ),
			'description'      => '',
			'pending'          => esc_html__( 'Pending', 'larisdigital-wp' ),
			'installing'       => esc_html__( 'Installing', 'larisdigital-wp' ),
			'success'          => esc_html__( 'Success', 'larisdigital-wp' ),
			'install_callback' => 'larisdigital_merlin_setup_blog',
			'checked'          => 1,
			'data'             => $selected_import_index,
		);
		$content['setup_product_dummy'] = array(
			'title'            => esc_html__( 'Setup Beberapa Contoh Produk', 'larisdigital-wp' ),
			'description'      => '',
			'pending'          => esc_html__( 'Pending', 'larisdigital-wp' ),
			'installing'       => esc_html__( 'Installing', 'larisdigital-wp' ),
			'success'          => esc_html__( 'Success', 'larisdigital-wp' ),
			'install_callback' => 'larisdigital_merlin_setup_product_dummy',
			'checked'          => 1,
			'data'             => $selected_import_index,
		);
		$content['setup_product_image'] = array(
			'title'            => esc_html__( 'Setup Ukuran Gambar Produk Untuk Optimasi Speed', 'larisdigital-wp' ),
			'description'      => '',
			'pending'          => esc_html__( 'Pending', 'larisdigital-wp' ),
			'installing'       => esc_html__( 'Installing', 'larisdigital-wp' ),
			'success'          => esc_html__( 'Success', 'larisdigital-wp' ),
			'install_callback' => 'larisdigital_merlin_setup_product_image',
			'checked'          => 1,
			'data'             => $selected_import_index,
		);
		$content['setup_shop_catalog'] = array(
			'title'            => esc_html__( 'Non Aktifkan Result Count & Ordering di Shop Page', 'larisdigital-wp' ),
			'description'      => '',
			'pending'          => esc_html__( 'Pending', 'larisdigital-wp' ),
			'installing'       => esc_html__( 'Installing', 'larisdigital-wp' ),
			'success'          => esc_html__( 'Success', 'larisdigital-wp' ),
			'install_callback' => 'larisdigital_merlin_setup_shop_catalog',
			'checked'          => 1,
			'data'             => $selected_import_index,
		);
		$content['setup_sticky_button'] = array(
			'title'            => esc_html__( 'Aktifkan Sticky AddToCart Button', 'larisdigital-wp' ),
			'description'      => '',
			'pending'          => esc_html__( 'Pending', 'larisdigital-wp' ),
			'installing'       => esc_html__( 'Installing', 'larisdigital-wp' ),
			'success'          => esc_html__( 'Success', 'larisdigital-wp' ),
			'install_callback' => 'larisdigital_merlin_setup_sticky_button',
			'checked'          => 1,
			'data'             => $selected_import_index,
		);
		$content['setup_shop_redirect'] = array(
			'title'            => esc_html__( 'Aktifkan Redirect ATC ke Cart Page', 'larisdigital-wp' ),
			'description'      => '',
			'pending'          => esc_html__( 'Pending', 'larisdigital-wp' ),
			'installing'       => esc_html__( 'Installing', 'larisdigital-wp' ),
			'success'          => esc_html__( 'Success', 'larisdigital-wp' ),
			'install_callback' => 'larisdigital_merlin_setup_shop_redirect',
			'checked'          => 1,
			'data'             => $selected_import_index,
		);
		$content['setup_ajax_popup'] = array(
			'title'            => esc_html__( 'Aktifkan Ajax AddToCart Popup', 'larisdigital-wp' ),
			'description'      => '',
			'pending'          => esc_html__( 'Pending', 'larisdigital-wp' ),
			'installing'       => esc_html__( 'Installing', 'larisdigital-wp' ),
			'success'          => esc_html__( 'Success', 'larisdigital-wp' ),
			'install_callback' => 'larisdigital_merlin_setup_ajax_popup',
			'checked'          => 1,
			'data'             => $selected_import_index,
		);
		$content['setup_cart_checkout'] = array(
			'title'            => esc_html__( 'Aktifkan Checkout di Halaman Cart', 'larisdigital-wp' ),
			'description'      => '',
			'pending'          => esc_html__( 'Pending', 'larisdigital-wp' ),
			'installing'       => esc_html__( 'Installing', 'larisdigital-wp' ),
			'success'          => esc_html__( 'Success', 'larisdigital-wp' ),
			'install_callback' => 'larisdigital_merlin_setup_cart_checkout',
			'checked'          => 1,
			'data'             => $selected_import_index,
		);
		$content['setup_checkout_layout'] = array(
			'title'            => esc_html__( 'Setup Layout Halaman Cart/Checkout Simple', 'larisdigital-wp' ),
			'description'      => '',
			'pending'          => esc_html__( 'Pending', 'larisdigital-wp' ),
			'installing'       => esc_html__( 'Installing', 'larisdigital-wp' ),
			'success'          => esc_html__( 'Success', 'larisdigital-wp' ),
			'install_callback' => 'larisdigital_merlin_setup_checkout_layout',
			'checked'          => 1,
			'data'             => $selected_import_index,
		);
		// $content['setup_checkout_guest'] = array(
		// 	'title'            => esc_html__( 'Aktifkan Guest Checkout', 'larisdigital-wp' ),
		// 	'description'      => '',
		// 	'pending'          => esc_html__( 'Pending', 'larisdigital-wp' ),
		// 	'installing'       => esc_html__( 'Installing', 'larisdigital-wp' ),
		// 	'success'          => esc_html__( 'Success', 'larisdigital-wp' ),
		// 	'install_callback' => 'larisdigital_merlin_setup_checkout_guest',
		// 	'checked'          => 1,
		// 	'data'             => $selected_import_index,
		// );
		// $content['setup_checkout_register'] = array(
		// 	'title'            => esc_html__( 'Non Aktifkan Login/Register Di Checkout', 'larisdigital-wp' ),
		// 	'description'      => '',
		// 	'pending'          => esc_html__( 'Pending', 'larisdigital-wp' ),
		// 	'installing'       => esc_html__( 'Installing', 'larisdigital-wp' ),
		// 	'success'          => esc_html__( 'Success', 'larisdigital-wp' ),
		// 	'install_callback' => 'larisdigital_merlin_setup_checkout_register',
		// 	'checked'          => 1,
		// 	'data'             => $selected_import_index,
		// );
		$content['setup_checkout_account'] = array(
			'title'            => esc_html__( 'Aktifkan Simple Account Creation Di Checkout', 'larisdigital-wp' ),
			'description'      => '',
			'pending'          => esc_html__( 'Pending', 'larisdigital-wp' ),
			'installing'       => esc_html__( 'Installing', 'larisdigital-wp' ),
			'success'          => esc_html__( 'Success', 'larisdigital-wp' ),
			'install_callback' => 'larisdigital_merlin_setup_checkout_account',
			'checked'          => 1,
			'data'             => $selected_import_index,
		);
		$content['setup_checkout_fields'] = array(
			'title'            => esc_html__( 'Aktifkan Simple Checkout Fields (No Address)', 'larisdigital-wp' ),
			'description'      => '',
			'pending'          => esc_html__( 'Pending', 'larisdigital-wp' ),
			'installing'       => esc_html__( 'Installing', 'larisdigital-wp' ),
			'success'          => esc_html__( 'Success', 'larisdigital-wp' ),
			'install_callback' => 'larisdigital_merlin_setup_checkout_fields',
			'checked'          => 1,
			'data'             => $selected_import_index,
		);
		$content['setup_checkout_shipping'] = array(
			'title'            => esc_html__( 'Non Aktifkan Shipping di WooCommerce', 'larisdigital-wp' ),
			'description'      => '',
			'pending'          => esc_html__( 'Pending', 'larisdigital-wp' ),
			'installing'       => esc_html__( 'Installing', 'larisdigital-wp' ),
			'success'          => esc_html__( 'Success', 'larisdigital-wp' ),
			'install_callback' => 'larisdigital_merlin_setup_checkout_shipping',
			'checked'          => 1,
			'data'             => $selected_import_index,
		);
		$content['setup_permalink'] = array(
			'title'            => esc_html__( 'Setup Permalink (Jika Belum)', 'larisdigital-wp' ),
			'description'      => '',
			'pending'          => esc_html__( 'Pending', 'larisdigital-wp' ),
			'installing'       => esc_html__( 'Installing', 'larisdigital-wp' ),
			'success'          => esc_html__( 'Success', 'larisdigital-wp' ),
			'install_callback' => 'larisdigital_merlin_setup_permalink',
			'checked'          => 1,
			'data'             => $selected_import_index,
		);
	}
	elseif ( $integration == 'sejoli' ) {
		$content['setup_permalink'] = array(
			'title'            => esc_html__( 'Setup Permalink (Jika Belum)', 'larisdigital-wp' ),
			'description'      => '',
			'pending'          => esc_html__( 'Pending', 'larisdigital-wp' ),
			'installing'       => esc_html__( 'Installing', 'larisdigital-wp' ),
			'success'          => esc_html__( 'Success', 'larisdigital-wp' ),
			'install_callback' => 'larisdigital_merlin_setup_permalink',
			'checked'          => 1,
			'data'             => $selected_import_index,
		);
	}
	return $content;
}

function larisdigital_merlin_setup_currency() {
	update_option( 'woocommerce_currency', 'USD' );
	update_option( 'woocommerce_currency_pos', 'left' );
	update_option( 'woocommerce_price_thousand_sep', ',' );
	update_option( 'woocommerce_price_decimal_sep', '.' );
	update_option( 'woocommerce_price_num_decimals', '0' );
	if ( class_exists('WC_Admin_Notices') ) {
		WC_Admin_Notices::remove_notice( 'install' );
	}
	return true;
}

function larisdigital_merlin_setup_page_shop() {
	larisdigital_merlin_wc_create_page( 'shop', 'woocommerce_shop_page_id', _x( 'Shop', 'Page title', 'larisdigital-wp' ), '', 0 );
	return true;
}

function larisdigital_merlin_setup_page_cart() {
	larisdigital_merlin_wc_create_page( 'cart', 'woocommerce_cart_page_id', _x( 'Cart', 'Page title', 'larisdigital-wp' ), '<!-- wp:shortcode -->[woocommerce_cart]<!-- /wp:shortcode -->', 0 );
	return true;
}

function larisdigital_merlin_setup_page_checkout() {
	larisdigital_merlin_wc_create_page( 'checkout', 'woocommerce_checkout_page_id', _x( 'Checkout', 'Page title', 'larisdigital-wp' ), '<!-- wp:shortcode -->[woocommerce_checkout]<!-- /wp:shortcode -->', 0 );
	return true;
}

function larisdigital_merlin_setup_page_myaccount() {
	larisdigital_merlin_wc_create_page( 'my-account', 'woocommerce_myaccount_page_id', _x( 'My account', 'Page title', 'larisdigital-wp' ), '<!-- wp:shortcode -->[woocommerce_my_account]<!-- /wp:shortcode -->', 0 );
	return true;
}

function larisdigital_merlin_wc_create_page( $slug, $option = '', $page_title = '', $page_content = '', $post_parent = 0 ) {
	global $wpdb;

	$option_value = get_option( $option );

	if ( $option_value > 0 ) {
		$page_object = get_post( $option_value );

		if ( $page_object && 'page' === $page_object->post_type && ! in_array( $page_object->post_status, array( 'pending', 'trash', 'future', 'auto-draft' ), true ) ) {
			if ( strlen( $page_content ) > 0 ) {
				$shortcode = str_replace( array( '<!-- wp:shortcode -->', '<!-- /wp:shortcode -->' ), '', $page_content );
				if ( strpos( $page_object->post_content, $shortcode ) !== false ) {
					// Valid page is already in place.
					return $page_object->ID;
				}
				else {
					$page_content = $page_content.$page_object->post_content;
					$page_data = array(
						'ID'           => $page_object->ID,
						'post_status'  => 'publish',
						'post_content' => $page_content,
					);
					wp_update_post( $page_data );
					return $page_object->ID;
				}
			}
			else {
				// Valid page is already in place.
				return $page_object->ID;
			}
		}
	}

	if ( strlen( $page_content ) > 0 ) {
		// Search for an existing page with the specified page content (typically a shortcode).
		$shortcode = str_replace( array( '<!-- wp:shortcode -->', '<!-- /wp:shortcode -->' ), '', $page_content );
		$valid_page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type='page' AND post_status NOT IN ( 'pending', 'trash', 'future', 'auto-draft' ) AND post_content LIKE %s LIMIT 1;", "%{$shortcode}%" ) );
	} else {
		// Search for an existing page with the specified page slug.
		$valid_page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type='page' AND post_status NOT IN ( 'pending', 'trash', 'future', 'auto-draft' )  AND post_name = %s LIMIT 1;", $slug ) );
	}

	if ( $valid_page_found ) {
		if ( $option ) {
			update_option( $option, $valid_page_found );
		}
		return $valid_page_found;
	}

	// Search for a matching valid trashed page.
	if ( strlen( $page_content ) > 0 ) {
		// Search for an existing page with the specified page content (typically a shortcode).
		$trashed_page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type='page' AND post_status = 'trash' AND post_content LIKE %s LIMIT 1;", "%{$page_content}%" ) );
	} else {
		// Search for an existing page with the specified page slug.
		$trashed_page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type='page' AND post_status = 'trash' AND post_name = %s LIMIT 1;", $slug ) );
	}

	if ( $trashed_page_found ) {
		$page_id   = $trashed_page_found;
		$page_data = array(
			'ID'          => $page_id,
			'post_status' => 'publish',
		);
		wp_update_post( $page_data );
	} else {
		$page_data = array(
			'post_status'    => 'publish',
			'post_type'      => 'page',
			'post_author'    => 1,
			'post_name'      => $slug,
			'post_title'     => $page_title,
			'post_content'   => $page_content,
			'post_parent'    => $post_parent,
			'comment_status' => 'closed',
		);
		$page_id   = wp_insert_post( $page_data );
	}

	if ( $option ) {
		update_option( $option, $page_id );
	}

	return $page_id;
}

function larisdigital_merlin_setup_homepage() {
	$shop_page_id = get_option( 'woocommerce_shop_page_id' );
	if ( !empty( $shop_page_id ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $shop_page_id );
	}
	return true;
}

function larisdigital_merlin_setup_blog() {
	$blog_page_id  = get_page_by_title( 'Blog' );
	if ( empty( $blog_page_id ) ) {
		$blog_page_id = wp_insert_post( array(
			'post_title'    => 'Blog',
			'post_content'  => '',
			'post_status'   => 'publish',
		) );
	}
	if ( !empty( $blog_page_id ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_for_posts', $blog_page_id->ID );
	}
	return true;
}

function larisdigital_merlin_setup_product_dummy() {
	if ( class_exists( 'WC_Product' ) ) {
		for ($i=1; $i <=8 ; $i++) { 
			$product = get_page_by_title('Contoh Produk #'.$i, OBJECT, 'product');
			if ( empty( $product ) ) {
				$objProduct = new WC_Product();
				$objProduct->set_name("Contoh Produk #".$i);
				$objProduct->set_status("publish"); 
				$objProduct->set_catalog_visibility('visible'); 
				$objProduct->set_description("Deskripsi Produk. Keep your readers’ attention by reducing the text blocks. If your readers see a large, ongoing length of text, they are apt to move on. This intimidates the viewers sense of comfort and ease of reading. They will anticipate a more interesting read if they see small chunks of text, that are easy on the eyes.");
				$objProduct->set_short_description("This is your nice & short description to grab attention of your potential buyer.");
				// $objProduct->set_sku("product-sku"); 
				$objProduct->set_price(9);
				$objProduct->set_regular_price(19);
				// $objProduct->set_manage_stock(true);
				// $objProduct->set_stock_quantity(10);
				// $objProduct->set_stock_status('instock'); 
				// $objProduct->set_backorders('no');
				$objProduct->set_reviews_allowed(true);
				$objProduct->set_sold_individually(false);
				$product_id = $objProduct->save();
			}
		}
	}
	return true;
}

function larisdigital_merlin_setup_product_image() {
	update_option( 'woocommerce_single_image_width', '750' );
	update_option( 'woocommerce_thumbnail_image_width', '350' );
	update_option( 'woocommerce_thumbnail_cropping', 'custom' );
	update_option( 'woocommerce_thumbnail_cropping_custom_width', '3' );
	update_option( 'woocommerce_thumbnail_cropping_custom_height', '2' );
	return true;
}

function larisdigital_merlin_setup_shop_header() {
	$shop_page_id = get_option( 'woocommerce_shop_page_id' );
	update_post_meta( $shop_page_id, '_layout_custom', '1' );
	update_post_meta( $shop_page_id, '_header_hide', '1' );
	update_post_meta( $shop_page_id, '_breadcrumb_hide', '1' );
	update_post_meta( $shop_page_id, '_sidebar_layout', 'none' );
	update_post_meta( $shop_page_id, '_title_hide', '1' );
	return true;
}

function larisdigital_merlin_setup_shop_catalog() {
	set_theme_mod( 'larisdigital_wc_shop_result_count_disable', '1' );
	set_theme_mod( 'larisdigital_wc_shop_catalog_ordering_disable', '1' );
	return true;
}

function larisdigital_merlin_setup_sticky_button() {
	if ( defined( 'LARISDIGITAL_INTEGRATIONS_WC_DB' ) ) {
		$options = get_option( LARISDIGITAL_INTEGRATIONS_WC_DB );
		$options['wc_buttonsticky_disable'] = '';
		update_option( LARISDIGITAL_INTEGRATIONS_WC_DB, $options );
	}
	return true;
}

function larisdigital_merlin_setup_shop_redirect() {
	update_option( 'woocommerce_cart_redirect_after_add', 'yes' );
	update_option( 'woocommerce_enable_ajax_add_to_cart', 'no' );
	return true;
}

function larisdigital_merlin_setup_ajax_popup() {
	if ( defined( 'LARISDIGITAL_INTEGRATIONS_WC_DB' ) ) {
		$options = get_option( LARISDIGITAL_INTEGRATIONS_WC_DB );
		$options['wc_cartpopup_disable'] = '';
		update_option( LARISDIGITAL_INTEGRATIONS_WC_DB, $options );
	}
	return true;
}

function larisdigital_merlin_setup_cart_checkout() {
	// make sure cart page is available
	larisdigital_merlin_wc_create_page( 'cart', 'woocommerce_cart_page_id', _x( 'Cart', 'Page title', 'larisdigital-wp' ), '<!-- wp:shortcode -->[woocommerce_cart]<!-- /wp:shortcode -->', 0 );

	$cart_page_id = get_option( 'woocommerce_cart_page_id' );
	if ( $cart_page_id > 0 ) {
		$cart_page = get_post( $cart_page_id );
		$page_content = $cart_page->post_content;
		if ( strpos( $page_content, '[woocommerce_cart]' ) !== false ) {
			if ( strpos( $page_content, '[woocommerce_checkout]' ) === false ) {
				$page_content = str_replace( '[woocommerce_cart]', '[woocommerce_cart][woocommerce_checkout]', $page_content );
				$page_data = array(
					'ID'           => $cart_page_id,
					'post_status'  => 'publish',
					'post_content' => $page_content,
				);
				wp_update_post( $page_data );
			}
		}
	}
	return true;
}

function larisdigital_merlin_setup_checkout_layout() {
	set_theme_mod( 'larisdigital_wc_checkout_layout', 'custom' );
	update_option( 'woocommerce_terms_page_id', '' );
	update_option( 'wp_page_for_privacy_policy', '' );
	$cart_page_id = get_option( 'woocommerce_cart_page_id' );
	update_post_meta( $cart_page_id, '_layout_custom', '1' );
	// update_post_meta( $cart_page_id, '_header_hide', '1' );
	update_post_meta( $cart_page_id, '_breadcrumb_hide', '1' );
	update_post_meta( $cart_page_id, '_footer_widgets_hide', '1' );
	update_post_meta( $cart_page_id, '_sidebar_layout', 'none' );
	update_post_meta( $cart_page_id, '_title_hide', '1' );
	$checkout_page_id = get_option( 'woocommerce_checkout_page_id' );
	update_post_meta( $checkout_page_id, '_layout_custom', '1' );
	// update_post_meta( $checkout_page_id, '_header_hide', '1' );
	update_post_meta( $checkout_page_id, '_breadcrumb_hide', '1' );
	update_post_meta( $checkout_page_id, '_footer_widgets_hide', '1' );
	update_post_meta( $checkout_page_id, '_sidebar_layout', 'none' );
	update_post_meta( $checkout_page_id, '_title_hide', '1' );
	return true;
}

function larisdigital_merlin_setup_checkout_guest() {
	update_option( 'woocommerce_enable_guest_checkout', 'yes' );
	return true;
}

function larisdigital_merlin_setup_checkout_register() {
	update_option( 'woocommerce_enable_signup_and_login_from_checkout', 'no' );
	update_option( 'woocommerce_enable_myaccount_registration', 'no' );
	update_option( 'woocommerce_enable_checkout_login_reminder', 'yes' );
	update_option( 'woocommerce_registration_generate_username', 'yes' );
	update_option( 'woocommerce_registration_generate_password', 'yes' );
	return true;
}

function larisdigital_merlin_setup_checkout_account() {
	update_option( 'woocommerce_enable_guest_checkout', 'no' );
	update_option( 'woocommerce_enable_checkout_login_reminder', 'yes' );
	update_option( 'woocommerce_enable_signup_and_login_from_checkout', 'yes' );
	update_option( 'woocommerce_enable_myaccount_registration', 'no' );
	update_option( 'woocommerce_registration_generate_username', 'yes' );
	update_option( 'woocommerce_registration_generate_password', 'yes' );
	return true;
}

function larisdigital_merlin_setup_checkout_shipping() {
	update_option( 'woocommerce_ship_to_countries', 'disabled' );
	return true;
}

function larisdigital_merlin_setup_checkout_fields() {
	if ( defined( 'LARISDIGITAL_INTEGRATIONS_WC_DB' ) ) {
		$options = get_option( LARISDIGITAL_INTEGRATIONS_WC_DB );
		$options['wc_digitalcheckout_address'] = 'all-address';
		$options['wc_digitalcheckout_company_disable'] = '1';
		$options['wc_digitalcheckout_phone_disable'] = '1';
		$options['wc_digitalcheckout_additional_disable'] = '1';
		update_option( LARISDIGITAL_INTEGRATIONS_WC_DB, $options );
	}
	return true;
}

function larisdigital_merlin_setup_permalink() {
	$permalink = get_option( 'permalink_structure' );
	if ( empty( $permalink ) ) {
		update_option( 'permalink_structure', '/%postname%/' );
	}
	global $wp_rewrite;
	$wp_rewrite->flush_rules( true );
	$wp_rewrite->init();
	if ( function_exists( 'save_mod_rewrite_rules' ) ) {
		save_mod_rewrite_rules();
	}
	if ( function_exists( 'iis7_save_url_rewrite_rules' ) ) {
		iis7_save_url_rewrite_rules();
	}
	return true;
}

add_filter( 'pt-ocdi/import_files', 'larisdigital_ocdi_import_files' );
function larisdigital_ocdi_import_files() {
	$notices = array(
		__( 'Silahkan ke menu "Settings - Permalinks" dan simpan setting Permalink di website untuk menghindari masalah "404 Not Found".', 'larisdigital-wp' ),
		__( 'Gunakan plugin Regenerate Thumbnail untuk menghindari masalah thumbnail yang tidak konsisten, jika ada.', 'larisdigital-wp' ),
	);
	$import_notice = __( 'Setelah proses import demo data selesai 100%, Anda sangat disarankan untuk melakukan hal berikut:', 'larisdigital-wp' ).'<ol><li>'.implode( '</li><li>', $notices ).'</li></ol>';
    return array(
		array(
			'import_file_name'             => 'Demo Import',
			'local_import_file'            => get_parent_theme_file_path( '/includes/demo/01_dummy_contents.xml' ),
			'local_import_widget_file'     => get_parent_theme_file_path( '/includes/demo/02_dummy_widgets.wie' ),
			'local_import_customizer_file' => get_parent_theme_file_path( '/includes/demo/03_dummy_settings.cei' ),
			'import_preview_image_url'     => '',
			'import_notice'                => $import_notice,
		),
	);
}

add_action( 'pt-ocdi/before_content_import', 'larisdigital_ocdi_before_content_import' );
function larisdigital_ocdi_before_content_import( $selected_import ) {

}

add_action( 'pt-ocdi/after_import', 'larisdigital_ocdi_after_import' );
function larisdigital_ocdi_after_import() {
	$main_menu = get_term_by( 'name', 'Header Menu', 'nav_menu' );
	set_theme_mod(
		'nav_menu_locations', array(
			'site-navigation-menu' => $main_menu->term_id,
		)
	);

	$front_page_id = get_page_by_title( 'Homepage' );
	$blog_page_id  = get_page_by_title( 'Blog' );
	if ( !empty( $front_page_id ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $front_page_id->ID );
		if ( !empty( $blog_page_id ) ) {
			update_option( 'page_for_posts', $blog_page_id->ID );
		}
	}

	$shop_page_id = get_page_by_title( 'Shop' );
	$cart_page_id = get_page_by_title( 'Cart' );
	$checkout_page_id = get_page_by_title( 'Checkout' );
	$myaccount_page_id = get_page_by_title( 'My Account' );
	$terms_page_id = get_page_by_title( 'Terms and Conditions' );

	if ( !empty( $shop_page_id ) ) {
		update_option( 'woocommerce_shop_page_id', $shop_page_id->ID );
	}
	if ( !empty( $cart_page_id ) ) {
		update_option( 'woocommerce_cart_page_id', $cart_page_id->ID );
	}
	if ( !empty( $checkout_page_id ) ) {
		update_option( 'woocommerce_checkout_page_id', $checkout_page_id->ID );
	}
	if ( !empty( $myaccount_page_id ) ) {
		update_option( 'woocommerce_myaccount_page_id', $myaccount_page_id->ID );
	}
	if ( !empty( $terms_page_id ) ) {
		update_option( 'woocommerce_terms_page_id', $terms_page_id->ID );
	}

	if ( class_exists('WC_Admin_Notices') ) {
		WC_Admin_Notices::remove_notice( 'install' );
	}

	update_option( 'woocommerce_default_country', 'ID:JK' );
	update_option( 'woocommerce_allowed_countries', 'specific' );
	update_option( 'woocommerce_specific_allowed_countries', array('ID') );
	update_option( 'woocommerce_ship_to_countries', '' );
	update_option( 'woocommerce_default_customer_address', 'base' );
	update_option( 'woocommerce_currency', 'IDR' );
	update_option( 'woocommerce_currency_pos', 'left' );
	update_option( 'woocommerce_price_thousand_sep', '.' );
	update_option( 'woocommerce_price_decimal_sep', ',' );
	update_option( 'woocommerce_price_num_decimals', '0' );
}

add_filter( 'woocommerce_prevent_automatic_wizard_redirect', '__return_true' );

add_action( 'init', 'larisdigital_merlin_remove_elementor_splash' );
function larisdigital_merlin_remove_elementor_splash() { 
	delete_transient( 'elementor_activation_redirect' );
}
