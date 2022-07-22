<?php
/**
 * Plugin Name: Razzi Addons
 * Plugin URI: http://drfuri.com/plugins/dimax-addons.zip
 * Description: Extra elements for Elementor. It was built for Razzi theme.
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

if ( ! defined( 'RAZZI_ADDONS_DIR' ) ) {
	define( 'RAZZI_ADDONS_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'RAZZI_ADDONS_URL' ) ) {
	define( 'RAZZI_ADDONS_URL', plugin_dir_url( __FILE__ ) );
}

require_once RAZZI_ADDONS_DIR . 'class-dimax-addons-plugin.php';

\Razzi\Addons::instance();