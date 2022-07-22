<?php

namespace Razzi\Addons\Modules\Product_Tabs;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main class of plugin for admin
 */
class Post_Type  {

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

	const POST_TYPE     = 'dimax_product_tab';
	const TAXONOMY_TAB_TYPE     = 'dimax_product_tab_type';


	/**
	 * Instantiate the object.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
			// Make sure the post types are loaded for imports
		add_action( 'import_start', array( $this, 'register_post_type' ) );
		$this->register_post_type();

	}

	/**
	 * Register product tabs post type
     *
	 * @since 1.0.0
     *
     * @return void
	 */
	public function register_post_type() {
		if(post_type_exists(self::POST_TYPE)) {
			return;
		}

		register_post_type( self::POST_TYPE, array(
			'description'         => esc_html__( 'Product tabs', 'dimax' ),
			'labels'              => array(
				'name'                  => esc_html__( 'Product Tabs', 'dimax' ),
				'singular_name'         => esc_html__( 'Product Tabs', 'dimax' ),
				'menu_name'             => esc_html__( 'Product Tabs', 'dimax' ),
				'all_items'             => esc_html__( 'Product Tabs', 'dimax' ),
				'add_new'               => esc_html__( 'Add New', 'dimax' ),
				'add_new_item'          => esc_html__( 'Add New Product Tabs', 'dimax' ),
				'edit_item'             => esc_html__( 'Edit Product Tabs', 'dimax' ),
				'new_item'              => esc_html__( 'New Product Tabs', 'dimax' ),
				'view_item'             => esc_html__( 'View Product Tabs', 'dimax' ),
				'search_items'          => esc_html__( 'Search product tabs', 'dimax' ),
				'not_found'             => esc_html__( 'No product tabs found', 'dimax' ),
				'not_found_in_trash'    => esc_html__( 'No product tabs found in Trash', 'dimax' ),
				'filter_items_list'     => esc_html__( 'Filter product tabss list', 'dimax' ),
				'items_list_navigation' => esc_html__( 'Product tabs list navigation', 'dimax' ),
				'items_list'            => esc_html__( 'Product tabs list', 'dimax' ),
			),
			'supports'            => array( 'title', 'editor' ),
			'rewrite'             => false,
			'public'              => false,
			'show_ui'             => true,
			'show_in_rest'        => true,
			'show_in_menu'        => 'edit.php?post_type=product',
			'menu_position'       => 20,
			'capability_type'     => 'page',
			'query_var'           => is_admin(),
			'map_meta_cap'        => true,
			'exclude_from_search' => false,
			'hierarchical'        => false,
			'has_archive'         => false,
			'show_in_nav_menus'   => false,
		) );

		register_taxonomy(
			self::TAXONOMY_TAB_TYPE,
			array( self::POST_TYPE ),
			array(
				'hierarchical'      => true,
				'show_ui'           => false,
				'show_in_nav_menus' => false,
				'query_var'         => is_admin(),
				'rewrite'           => false,
				'public'            => true,
				'label'             => _x( 'Product Tabs Type', 'Taxonomy name', 'dimax' ),
			)
		);
	}


}