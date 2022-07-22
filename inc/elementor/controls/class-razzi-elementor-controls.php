<?php

namespace Dimax\Addons\Elementor;

use Dimax\Addons\Elementor\Control\Autocomplete;
use Dimax\Addons\Elementor\Controls\AjaxLoader;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Controls {

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
		// Include plugin files
		$this->includes();

		// Register controls
		add_action( 'elementor/controls/controls_registered', [ $this, 'register_controls' ] );

		AjaxLoader::instance();
	}

	/**
	 * Include Files
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function includes() {
		\Dimax\Addons\Auto_Loader::register( [
				'Dimax\Addons\Elementor\Controls\AjaxLoader'  => RAZZI_ADDONS_DIR . 'inc/elementor/controls/class-dimax-elementor-controls-ajaxloader.php',
				'Dimax\Addons\Elementor\Control\Autocomplete' => RAZZI_ADDONS_DIR . 'inc/elementor/controls/class-dimax-elementor-autocomplete.php',
			]
		);

	}

	/**
	 * Register autocomplete control
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_controls() {
		$controls_manager = \Elementor\Plugin::$instance->controls_manager;
		$controls_manager->register_control( 'rzautocomplete', \Dimax\Addons\Elementor\Control\Autocomplete::instance() );

	}
}