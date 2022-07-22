<?php
/**
 * Dimax Addons Modules functions and definitions.
 *
 * @package Dimax
 */

namespace Dimax\Addons\Modules\Product_Deals;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Addons Modules
 */
class Module {

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
		$this->includes();
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
		\Dimax\Addons\Auto_Loader::register( [
			'Dimax\Addons\Modules\Product_Deals\Frontend'        => DIMAX_ADDONS_DIR . 'modules/product-deals/frontend.php',
			'Dimax\Addons\Modules\Product_Deals\Settings'    	=> DIMAX_ADDONS_DIR . 'modules/product-deals/settings.php',
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
		if ( is_admin() ) {
			\Dimax\Addons\Modules\Product_Deals\Settings::instance();
		}

		if ( get_option( 'rz_product_deals' ) == 'yes' ) {
			\Dimax\Addons\Modules\Product_Deals\Frontend::instance();
		}
	}

}
