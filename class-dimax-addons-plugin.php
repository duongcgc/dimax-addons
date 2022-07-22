<?php
/**
 * Dimax Addons init
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Dimax
 */

namespace Dimax;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Dimax Addons init
 *
 * @since 1.0.0
 */
class Addons {

	/**
	 * Instance
	 *
	 * @var $instance
	 */
	private static $instance;

	/**
	 * Initiator
	 *
	 * @since 1.0.0
	 * @return object
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Instantiate the object.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'load_templates' ) );
	}

	/**
	 * Load Templates
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function load_templates() {
		$this->includes();
		spl_autoload_register( '\Dimax\Addons\Auto_Loader::load' );

		$this->add_actions();
	}

	/**
	 * Includes files
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function includes() {
		// Auto Loader
		require_once RAZZI_ADDONS_DIR . 'class-dimax-addons-autoloader.php';
		\Dimax\Addons\Auto_Loader::register( [
			'Dimax\Addons\Helper'         => RAZZI_ADDONS_DIR . 'class-dimax-addons-helper.php',
			'Dimax\Addons\Widgets'        => RAZZI_ADDONS_DIR . 'inc/widgets/class-dimax-addons-widgets.php',
			'Dimax\Addons\Modules'        => RAZZI_ADDONS_DIR . 'modules/modules.php',
			'Dimax\Addons\Elementor'      => RAZZI_ADDONS_DIR . 'inc/elementor/class-dimax-elementor.php',
			'Dimax\Addons\Product_Brands' => RAZZI_ADDONS_DIR . 'inc/backend/class-dimax-addons-product-brand.php',
			'Dimax\Addons\Product_Authors'=> RAZZI_ADDONS_DIR . 'inc/backend/class-dimax-addons-product-author.php',
			'Dimax\Addons\Importer'       => RAZZI_ADDONS_DIR . 'inc/backend/class-dimax-addons-importer.php',
		] );
	}

	/**
	 * Add Actions
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	protected function add_actions() {
		// Before init action.
		do_action( 'before_dimax_init' );

		$this->get( 'product_brand' );
		$this->get( 'product_author' );

		$this->get( 'importer' );

		// Elmentor
		$this->get( 'elementor' );

		// Modules
		$this->get( 'modules' );

		// Widgets
		$this->get( 'widgets' );

		add_action( 'after_setup_theme', array( $this, 'addons_init' ), 20 );

		// Init action.
		do_action( 'after_dimax_init' );
	}

	/**
	 * Get Dimax Addons Class instance
	 *
	 * @since 1.0.0
	 *
	 * @return object
	 */
	public function get( $class ) {
		switch ( $class ) {
			case 'product_brand':
				if ( class_exists( 'WooCommerce' ) ) {
					return \Dimax\Addons\Product_Brands::instance();
				}
				break;
			case 'product_author':
				if ( class_exists( 'WooCommerce' ) ) {
					return \Dimax\Addons\Product_Authors::instance();
				}
				break;
			case 'importer':
				if ( is_admin() ) {
					return \Dimax\Addons\Importer::instance();
				}
				break;
			case 'elementor':
				if ( did_action( 'elementor/loaded' ) ) {
					return \Dimax\Addons\Elementor::instance();
				}
				break;

			case 'modules':
				return \Dimax\Addons\Modules::instance();
				break;

			case 'widgets':
				return \Dimax\Addons\Widgets::instance();
				break;
		}
	}

	/**
	 * Get Dimax Addons Language
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function addons_init() {
		load_plugin_textdomain( 'dimax', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
	}
}
