<?php
/**
 * Plugin Name: Dimax Addons
 * Plugin URI: http://drfuri.com/plugins/dimax-addons.zip
 * Description: Extra elements for Elementor. It was built for Dimax theme.
 * Version: 1.4.0
 * Author: Drfuri
 * Author URI: http://drfuri.com/
 * License: GPL2+
 * Text Domain: dimax
 * Domain Path: /lang/
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

if ( ! defined( 'DIMAX_ADDONS_DIR' ) ) {
	define( 'DIMAX_ADDONS_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'DIMAX_ADDONS_URL' ) ) {
	define( 'DIMAX_ADDONS_URL', plugin_dir_url( __FILE__ ) );
}

require_once DIMAX_ADDONS_DIR . 'class-dimax-addons-plugin.php';

\Dimax\Addons::instance();