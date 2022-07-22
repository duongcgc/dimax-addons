<?php
/**
 * Dimax Addons Modules functions and definitions.
 *
 * @package Dimax
 */

namespace Dimax\Addons;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Addons Modules
 */
class Modules {

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
			'Dimax\Addons\Modules\Size_Guide\Module'    			=> DIMAX_ADDONS_DIR . 'modules/size-guide/module.php',
			'Dimax\Addons\Modules\Catalog_Mode\Module'    			=> DIMAX_ADDONS_DIR . 'modules/catalog-mode/module.php',
			'Dimax\Addons\Modules\Product_Deals\Module'    			=> DIMAX_ADDONS_DIR . 'modules/product-deals/module.php',
			'Dimax\Addons\Modules\Buy_Now\Module'    				=> DIMAX_ADDONS_DIR . 'modules/buy-now/module.php',
			'Dimax\Addons\Modules\Mega_Menu\Module'    				=> DIMAX_ADDONS_DIR . 'modules/mega-menu/module.php',
			'Dimax\Addons\Modules\Products_Filter\Module'     		=> DIMAX_ADDONS_DIR . 'modules/products-filter/module.php',
			'Dimax\Addons\Modules\Related_Products\Module'    		=> DIMAX_ADDONS_DIR . 'modules/related-products/module.php',
			'Dimax\Addons\Modules\Product_Tabs\Module'    			=> DIMAX_ADDONS_DIR . 'modules/product-tabs/module.php',
			'Dimax\Addons\Modules\Ajax'    							=> DIMAX_ADDONS_DIR . 'modules/ajax.php',
			'Dimax\Addons\Modules\Shortcodes' 						=> DIMAX_ADDONS_DIR . 'modules/shortcodes.php',
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
			\Dimax\Addons\Modules\Ajax::instance();
		}

		\Dimax\Addons\Modules\Buy_Now\Module::instance();
		\Dimax\Addons\Modules\Catalog_Mode\Module::instance();
		\Dimax\Addons\Modules\Mega_Menu\Module::instance();
		\Dimax\Addons\Modules\Product_Deals\Module::instance();
		\Dimax\Addons\Modules\Products_Filter\Module::instance();
		\Dimax\Addons\Modules\Size_Guide\Module::instance();
		\Dimax\Addons\Modules\Related_Products\Module::instance();
		\Dimax\Addons\Modules\Product_Tabs\Module::instance();
		\Dimax\Addons\Modules\Shortcodes::instance();
	}

}
