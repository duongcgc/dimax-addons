<?php
/**
 * Elementor init
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Dimax
 */

namespace Dimax\Addons;

/**
 * Integrate with Elementor.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Elementor {

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
	 * Includes files which are not widgets
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function includes() {
		\Dimax\Addons\Auto_Loader::register( [
			'Dimax\Addons\Elementor\Helper'                 => RAZZI_ADDONS_DIR . 'inc/elementor/class-dimax-elementor-helper.php',
			'Dimax\Addons\Elementor\Setup'                  => RAZZI_ADDONS_DIR . 'inc/elementor/class-dimax-elementor-setup.php',
			'Dimax\Addons\Elementor\AjaxLoader'             => RAZZI_ADDONS_DIR . 'inc/elementor/class-dimax-elementor-ajaxloader.php',
			'Dimax\Addons\Elementor\Widgets'                => RAZZI_ADDONS_DIR . 'inc/elementor/class-dimax-elementor-widgets.php',
			'Dimax\Addons\Elementor\Module\Motion_Parallax' => RAZZI_ADDONS_DIR . 'inc/elementor/modules/class-dimax-elementor-motion-parallax.php',
			'Dimax\Addons\Elementor\Controls'               => RAZZI_ADDONS_DIR . 'inc/elementor/controls/class-dimax-elementor-controls.php',
			'Dimax\Addons\Elementor\Page_Settings'          => RAZZI_ADDONS_DIR . 'inc/elementor/class-dimax-elementor-page-settings.php',
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
		$this->get( 'setup' );
		$this->get( 'ajax_loader' );
		$this->get( 'widgets' );
		$this->get( 'controls' );
		$this->get( 'page_settings' );

		if ( ! defined( 'ELEMENTOR_PRO_VERSION' ) ) {
			$this->modules['motion_parallax'] = $this->get( 'motion_parallax' );
		}
	}

	/**
	 * Get Dimax Elementor Class instance
	 *
	 * @since 1.0.0
	 *
	 * @return object
	 */
	public function get( $class ) {
		switch ( $class ) {
			case 'setup':
				return \Dimax\Addons\Elementor\Setup::instance();
				break;
			case 'ajax_loader':
				return \Dimax\Addons\Elementor\AjaxLoader::instance();
				break;
			case 'widgets':
				return \Dimax\Addons\Elementor\Widgets::instance();
				break;
			case 'motion_parallax':
				if ( ! defined( 'ELEMENTOR_PRO_VERSION' ) ) {
					return \Dimax\Addons\Elementor\Module\Motion_Parallax::instance();
				}
				break;
			case 'controls':
				return \Dimax\Addons\Elementor\Controls::instance();
				break;
			case 'page_settings':
				return \Dimax\Addons\Elementor\Page_Settings::instance();
				break;
		}
	}
}
