<?php

namespace Dimax\Addons\Modules\Catalog_Mode;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main class of plugin for admin
 */
class Settings {

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
		add_filter( 'woocommerce_get_sections_products', array( $this, 'catalog_mode_section' ), 20, 2 );
		add_filter( 'woocommerce_get_settings_products', array( $this, 'catalog_mode_settings' ), 20, 2 );

		if ( get_option( 'rz_catalog_mode' ) != 'yes' ) {
			return;
		}

	}

	/**
	 * Catalog mode section
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function catalog_mode_section( $sections ) {
		$sections['rz_catalog_mode'] = esc_html__( 'Catalog Mode', 'dimax' );

		return $sections;
	}

	/**
	 * Adds settings to product display settings
	 *
	 * @since 1.0.0
	 *
	 * @param array $settings
	 * @param string $section
	 *
	 * @return array
	 */
	public function catalog_mode_settings( $settings, $section ) {
		if ( 'rz_catalog_mode' == $section ) {
			$settings = array();

			$settings[] = array(
				'id'    => 'rz_catalog_mode_options',
				'title' => esc_html__( 'Catalog Mode', 'dimax' ),
				'type'  => 'title',
			);

			$settings[] = array(
				'id'      => 'rz_catalog_mode',
				'title'   => esc_html__( 'Catalog Mode', 'dimax' ),
				'desc'    => esc_html__( 'Enable Catalog Mode', 'dimax' ),
				'type'    => 'checkbox',
				'default' => 'no',
			);

			// Price
			$settings[] = array(
				'name'          => esc_html__( 'Price', 'dimax' ),
				'desc'          => esc_html__( 'Hide in the product loop', 'dimax' ),
				'id'            => 'dimax_product_loop_hide_price',
				'default'       => 'yes',
				'type'          => 'checkbox',
				'checkboxgroup' => 'start',
			);

			if ( function_exists( 'YITH_WCWL' ) ) {
				$settings[] = array(
					'desc'          => esc_html__( 'Hide in the wishlist page', 'dimax' ),
					'id'            => 'dimax_wishlist_hide_price',
					'default'       => 'yes',
					'type'          => 'checkbox',
					'checkboxgroup' => '',
				);
			}

			$settings[] = array(
				'desc'          => esc_html__( 'Hide in the product page', 'dimax' ),
				'id'            => 'dimax_product_hide_price',
				'default'       => 'yes',
				'type'          => 'checkbox',
				'checkboxgroup' => 'end',
			);

			// Add to Cart
			$settings[] = array(
				'name'          => esc_html__( 'Add to Cart', 'dimax' ),
				'desc'          => esc_html__( 'Hide in the product loop', 'dimax' ),
				'id'            => 'dimax_product_loop_hide_atc',
				'default'       => 'yes',
				'type'          => 'checkbox',
				'checkboxgroup' => 'start',
			);

			if ( function_exists( 'YITH_WCWL' ) ) {
				$settings[] = array(
					'desc'          => esc_html__( 'Hide in the wishlist page', 'dimax' ),
					'id'            => 'dimax_wishlist_hide_atc',
					'default'       => 'yes',
					'type'          => 'checkbox',
					'checkboxgroup' => '',
				);
			}

			$settings[] = array(
				'desc'          => esc_html__( 'Hide in the product page', 'dimax' ),
				'id'            => 'dimax_product_hide_atc',
				'default'       => 'yes',
				'type'          => 'checkbox',
				'checkboxgroup' => 'end',
			);

			// Page
			$settings[] = array(
				'name'          => esc_html__( 'Page', 'dimax' ),
				'desc'          => esc_html__( 'Hide in the woocommerce cart page', 'dimax' ),
				'id'            => 'dimax_hide_cart_page',
				'default'       => 'yes',
				'type'          => 'checkbox',
				'checkboxgroup' => 'start',
			);

			$settings[] = array(
				'desc'          => esc_html__( 'Hide in the woocommerce checkout page', 'dimax' ),
				'id'            => 'dimax_hide_checkout_page',
				'default'       => 'yes',
				'type'          => 'checkbox',
				'checkboxgroup' => 'end',
			);

			// User
			$settings[] = array(
				'name'    => esc_html__( 'Apply catalog mode to', 'dimax' ),
				'id'      => 'rz_catalog_mode_user',
				'default' => 'all_user',
				'type'    => 'radio',
				'options' => array(
					'all_user'   => esc_html__( 'All User', 'dimax' ),
					'guest_user' => esc_html__( 'Only guest user', 'dimax' ),
				),
			);

			$settings[] = array(
				'id'   => 'rz_catalog_mode_options',
				'type' => 'sectionend',
			);
		}

		return $settings;
	}
}