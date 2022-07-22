<?php
/**
 * Dimax Addons Modules functions and definitions.
 *
 * @package Dimax
 */

namespace Dimax\Addons\Modules\Related_Products;

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
			'Dimax\Addons\Modules\Related_Products\Frontend'        => DIMAX_ADDONS_DIR . 'modules/related-products/frontend.php',
			'Dimax\Addons\Modules\Related_Products\Settings'    	=> DIMAX_ADDONS_DIR . 'modules/related-products/settings.php',
			'Dimax\Addons\Modules\Related_Products\Product_Options'    	=> DIMAX_ADDONS_DIR . 'modules/related-products/product-options.php',
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
			\Dimax\Addons\Modules\Related_Products\Settings::instance();

			if ( get_option( 'rz_custom_related_products' ) == 'yes' ) {
				\Dimax\Addons\Modules\Related_Products\Product_Options::instance();
			}
		}

		add_action('template_redirect', array( $this, 'template_hooks') );

	}

	/**
	 * Template hooks
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function template_hooks() {
		if( ! is_singular( 'product' ) ) {
			return;
		}

		if ( get_option( 'rz_related_products', 'yes' ) == 'yes' ) {
			\Dimax\Addons\Modules\Related_Products\Frontend::instance();
		} else {
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
		}
	}

}
