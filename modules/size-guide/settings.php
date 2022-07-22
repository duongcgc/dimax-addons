<?php

namespace Dimax\Addons\Modules\Size_Guide;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main class of plugin for admin
 */
class Settings  {

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

	const POST_TYPE     = 'dimax_size_guide';
	const OPTION_NAME   = 'dimax_size_guide';


	/**
	 * Instantiate the object.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		add_filter( 'woocommerce_get_sections_products', array( $this, 'size_guide_section' ), 10, 2 );
		add_filter( 'woocommerce_get_settings_products', array( $this, 'size_guide_settings' ), 10, 2 );

		// Make sure the post types are loaded for imports
		add_action( 'import_start', array( $this, 'register_post_type' ) );

		if ( get_option( 'dimax_size_guide' ) != 'yes' ) {
			return;
		}

		$this->register_post_type();

		// Handle post columns
		add_filter( sprintf( 'manage_%s_posts_columns', self::POST_TYPE ), array( $this, 'edit_admin_columns' ) );
		add_action( sprintf( 'manage_%s_posts_custom_column', self::POST_TYPE ), array( $this, 'manage_custom_columns' ), 10, 2 );

		// Add meta boxes.
		add_action( 'add_meta_boxes', array( $this, 'meta_boxes' ), 1 );
		add_action( 'save_post', array( $this, 'save_post' ), 10, 2 );

		// Enqueue style and javascript
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );

		// Add JS templates to footer.
		add_action( 'admin_print_scripts', array( $this, 'templates' ) );

		// Add options to product.
		add_filter( 'woocommerce_product_data_tabs', array( $this, 'product_data_tab' ) );
		add_action( 'woocommerce_product_data_panels', array( $this, 'product_data_panel' ) );
		add_action( 'woocommerce_process_product_meta', array( $this, 'process_product_meta' ) );
		add_action( 'wp_ajax_dimax_addons_load_product_size_guide_attributes', array( $this, 'ajax_load_product_size_guide_attributes' ) );
	}

	/**
	 * Add Size Guide settings section to the Products setting tab.
     *
	 * @since 1.0.0
	 *
	 * @param array $sections
	 * @return array
	 */
	public function size_guide_section( $sections ) {
		$sections['dimax_addons_size_guide'] = esc_html__( 'Size Guide', 'dimax' );

		return $sections;
	}

	/**
	 * Adds a new setting field to products tab.
     *
	 * @since 1.0.0
	 *
	 * @param array $settings
	 *
	 * @return array
	 */
	public function size_guide_settings( $settings, $section ) {
		if ( 'dimax_addons_size_guide' != $section ) {
			return $settings;
		}

		$settings_size_guide = array(
			array(
				'name' => esc_html__( 'Size Guide', 'dimax' ),
				'type' => 'title',
				'id'   => self::OPTION_NAME . '_options',
			),
			array(
				'name'    => esc_html__( 'Enable Size Guide', 'dimax' ),
				'desc'    => esc_html__( 'Enable product size guides', 'dimax' ),
				'id'      => self::OPTION_NAME,
				'default' => 'no',
				'type'    => 'checkbox',
				'checkboxgroup' => 'start',
			),
			array(
				'desc'    => esc_html__( 'Enable on variable products only', 'dimax' ),
				'id'      => self::OPTION_NAME . '_variable_only',
				'default' => 'no',
				'type'    => 'checkbox',
				'checkboxgroup' => 'end',
			),
			array(
				'name'    => esc_html__( 'Guide Display', 'dimax' ),
				'id'      => self::OPTION_NAME . '_display',
				'default' => 'tab',
				'class'   => 'wc-enhanced-select',
				'type'    => 'select',
				'options' => array(
					'tab'   => esc_html__( 'In product tabs', 'dimax' ),
					'panel' => esc_html__( 'Panel by clicking on a button', 'dimax' ),
					'popup' => esc_html__( 'Popup by clicking on a button', 'dimax' ),
				),
			),
			array(
				'name'    => esc_html__( 'Button Position', 'dimax' ),
				'id'      => self::OPTION_NAME . '_button_position',
				'default' => 'bellow_summary',
				'class'   => 'wc-enhanced-select',
				'type'    => 'select',
				'options' => array(
					'bellow_summary'   => esc_html__( 'Bellow short description', 'dimax' ),
					'bellow_price'     => esc_html__( 'Bellow price', 'dimax' ),
					'above_button'     => esc_html__( 'Above Add To Cart button', 'dimax' ),
					'bellow_attribute' => esc_html__( 'Bellow the Size attribute (for variable products only)', 'dimax' ),
				),
			),
			array(
				'name'    => esc_html__( 'Attribute Slug', 'dimax' ),
				'id'      => self::OPTION_NAME . '_attribute',
				'default' => 'size',
				'type'    => 'text',
				'desc_tip' => esc_html__( 'This is the slug of a product attribute', 'dimax' ),
			),
			array(
				'name'    => esc_html__( 'Button Text', 'dimax' ),
				'id'      => self::OPTION_NAME . '_button_text',
				'default' => esc_html__('Size Chart', 'dimax'),
				'type'    => 'text',
			),
			array(
				'type' => 'sectionend',
				'id'   => self::OPTION_NAME . '_options',
			),
		);

		return $settings_size_guide;
	}

	/**
	 * Register size guide post type
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
			'description'         => esc_html__( 'Product size guide', 'dimax' ),
			'labels'              => array(
				'name'                  => esc_html__( 'Size Guide', 'dimax' ),
				'singular_name'         => esc_html__( 'Size Guide', 'dimax' ),
				'menu_name'             => esc_html__( 'Size Guides', 'dimax' ),
				'all_items'             => esc_html__( 'Size Guides', 'dimax' ),
				'add_new'               => esc_html__( 'Add New', 'dimax' ),
				'add_new_item'          => esc_html__( 'Add New Size Guide', 'dimax' ),
				'edit_item'             => esc_html__( 'Edit Size Guide', 'dimax' ),
				'new_item'              => esc_html__( 'New Size Guide', 'dimax' ),
				'view_item'             => esc_html__( 'View Size Guide', 'dimax' ),
				'search_items'          => esc_html__( 'Search size guides', 'dimax' ),
				'not_found'             => esc_html__( 'No size guide found', 'dimax' ),
				'not_found_in_trash'    => esc_html__( 'No size guide found in Trash', 'dimax' ),
				'filter_items_list'     => esc_html__( 'Filter size guides list', 'dimax' ),
				'items_list_navigation' => esc_html__( 'Size guides list navigation', 'dimax' ),
				'items_list'            => esc_html__( 'Size guides list', 'dimax' ),
			),
			'supports'            => array( 'title', 'editor' ),
			'rewrite'             => false,
			'public'              => false,
			'show_ui'             => true,
			'show_in_rest'        => false,
			'show_in_menu'        => 'edit.php?post_type=product',
			'menu_position'       => 20,
			'capability_type'     => 'page',
			'query_var'           => is_admin(),
			'map_meta_cap'        => true,
			'exclude_from_search' => true,
			'hierarchical'        => false,
			'has_archive'         => false,
			'show_in_nav_menus'   => true,
			'taxonomies'          => array( 'product_cat' ),
		) );
	}

	/**
	 * Add custom column to size guides management screen
	 * Add Thumbnail column
     *
	 * @since 1.0.0
	 *
	 * @param  array $columns Default columns
	 *
	 * @return array
	 */
	public function edit_admin_columns( $columns ) {
		$columns = array_merge( $columns, array(
			'apply_to' => esc_html__( 'Apply to Category', 'dimax' )
		) );

		return $columns;
	}

	/**
	 * Handle custom column display
     *
	 * @since 1.0.0
	 *
	 * @param  string $column
	 * @param  int    $post_id
	 */
	public function manage_custom_columns( $column, $post_id ) {
		switch ( $column ) {
			case 'apply_to':
				$cats = get_post_meta( $post_id, 'size_guide_category', true );
				$selected = is_array( $cats ) ? 'custom' : $cats;
				$selected = $selected ? $selected : 'none';

				switch ( $selected ) {
					case 'none':
						esc_html_e( 'No Category', 'dimax' );
						break;

					case 'all':
						esc_html_e( 'All Categories', 'dimax' );
						break;

					case 'custom':
						$links = array();

						if ( is_array( $cats ) ) {
							foreach ( $cats as $cat_id ) {
								$cat = get_term( $cat_id, 'product_cat' );
								if( ! is_wp_error( $cat ) && $cat ) {
									$links[] = sprintf( '<a href="%s">%s</a>', esc_url( get_edit_term_link( $cat_id, 'product_cat', 'product' ) ), $cat->name );
								}

							}
						} else {
							$links[] = esc_html_e( 'No Category', 'dimax' );
						}

						echo implode( ', ', $links );
						break;
				}
				break;
		}
	}

	/**
	 * Get option of size guide.
     *
	 * @since 1.0.0
	 *
	 * @param string $option
	 * @param mixed $default
	 *
	 * @return mixed
	 */
	public function get_option( $option = '', $default = false ) {
		if ( ! is_string( $option ) ) {
			return $default;
		}

		if ( empty( $option ) ) {
			return get_option( self::OPTION_NAME, $default );
		}

		return get_option( sprintf( '%s_%s', self::OPTION_NAME, $option ), $default );
	}

	/**
	 * Add meta boxes
	 *
	 * @param object $post
	 */
	public function meta_boxes( $post ) {
		add_meta_box( 'dimax-size-guide-category', esc_html__( 'Apply to Categories', 'dimax' ), array( $this, 'category_meta_box' ), self::POST_TYPE, 'side' );
		add_meta_box( 'dimax-size-guide-tables', esc_html__( 'Tables', 'dimax' ), array( $this, 'tables_meta_box' ), self::POST_TYPE, 'advanced', 'high' );
	}

	/**
	 * Category meta box.
     *
	 * @since 1.0.0
	 *
	 * @param object $post
     *
     * @return void
	 */
	public function category_meta_box( $post ) {
		$cats = get_post_meta( $post->ID, 'size_guide_category', true );
		$selected = is_array( $cats ) ? 'custom' : $cats;
		$selected = $selected ? $selected : 'none';
		?>
		<p>
			<label>
				<input type="radio" name="_size_guide_category" value="none" <?php checked( 'none', $selected ) ?>>
				<?php esc_html_e( 'No category', 'dimax' ); ?>
			</label>
		</p>

		<p>
			<label>
				<input type="radio" name="_size_guide_category" value="all" <?php checked( 'all', $selected ) ?>>
				<?php esc_html_e( 'All Categories', 'dimax' ); ?>
			</label>
		</p>

		<p>
			<label>
				<input type="radio" name="_size_guide_category" value="custom" <?php checked( 'custom', $selected ) ?>>
				<?php esc_html_e( 'Select Categories', 'dimax' ); ?>
			</label>
		</p>

		<div class="taxonomydiv" style="display: none;">
			<div class="tabs-panel">
				<ul class="categorychecklist">
					<?php
					wp_terms_checklist( $post->ID, array(
						'taxonomy'      => 'product_cat',
					) );
					?>
				</ul>
			</div>
		</div>

		<?php
	}

	/**
	 * Tables meta box.
	 * Content will be filled by js.
     *
	 * @since 1.0.0
	 *
	 * @param object $post
	 */
	public function tables_meta_box( $post ) {
		$tables = get_post_meta( $post->ID, 'size_guides', true );
		$tables = $tables ? $tables : array(
			'names' => array( '' ),
			'tabs' => array( __( 'Table 1', 'dimax' ) ),
			'tables' => array( '[["",""],["",""]]' ),
			'descriptions' => array( '' ),
			'information' => array( '' ),
		);
		wp_localize_script( 'dimax-size-guide', 'dimaxSizeGuideTables', $tables );
		?>

		<div id="dimax-size-guide-tabs" class="dimax-size-guide-tabs">
			<div class="dimax-size-guide-tabs--tabs">
				<div class="dimax-size-guide-table-tabs--tab add-new-tab" data-title="<?php esc_attr_e( 'Table', 'dimax' ) ?>"><span class="dashicons dashicons-plus"></span></div>
			</div>
		</div>

		<?php
	}

	/**
	 * Save meta box content.
     *
	 * @since 1.0.0
	 *
	 * @param int $post_id
	 * @param object $post
     *
	 * @return void
	 */
	public function save_post( $post_id, $post ) {
		// If not the flex post.
		if ( self::POST_TYPE != $post->post_type ) {
			return;
		}

		// Check if user has permissions to save data.
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
		}

		// Check if not an autosave.
        if ( wp_is_post_autosave( $post_id ) ) {
            return;
		}

		if ( ! empty( $_POST['_size_guide_category'] ) ) {
			if ( 'custom' == $_POST['_size_guide_category'] && ! empty( $_POST['tax_input'] ) && ! empty( $_POST['tax_input']['product_cat'] ) ) {
				$cat_ids = array_map( 'intval', $_POST['tax_input']['product_cat'] );
				update_post_meta( $post_id, 'size_guide_category', $cat_ids );

				wp_set_post_terms( $post_id, $cat_ids, 'product_cat' );
			} else {
				update_post_meta( $post_id, 'size_guide_category', $_POST['_size_guide_category'] );
			}
		}

		if ( ! empty( $_POST['_size_guides'] ) ) {
			update_post_meta( $post_id, 'size_guides', $_POST['_size_guides'] );
		}
	}

	/**
	 * Load scripts and style in admin area
     *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function admin_scripts( $hook ) {
		$screen = get_current_screen();

		if ( in_array( $hook, array( 'post-new.php', 'post.php' ) ) && self::POST_TYPE == $screen->post_type ) {
			wp_enqueue_style( 'dimax-size-guide', RAZZI_ADDONS_URL . 'modules/size-guide/assets/css/size-guide-admin.css' );

			wp_enqueue_script( 'dimax-size-guide', RAZZI_ADDONS_URL . 'modules/size-guide/assets/js/size-guide.js', array( 'jquery', 'wp-util' ),'1.0', true );
		}

		if ( in_array( $hook, array( 'post-new.php', 'post.php' ) ) && 'product' == $screen->post_type ) {
			wp_enqueue_style( 'dimax-product-size-guide', RAZZI_ADDONS_URL . 'modules/size-guide/assets/css/product-size-guide-admin.css' );

			wp_enqueue_script( 'dimax-product-size-guide', RAZZI_ADDONS_URL . 'modules/size-guide/assets/js/product-size-guide.js', array( 'jquery' ),'1.0', true );
		}

		if ( 'woocommerce_page_wc-settings' == $screen->base && ! empty( $_GET['section'] ) && 'dimax_addons_size_guide' == $_GET['section'] ) {
			wp_enqueue_script( 'dimax-size-guide', RAZZI_ADDONS_URL . 'modules/size-guide/assets/js/size-guide-settings.js', array( 'jquery' ),'1.0', true );
		}
	}

	/**
	 * Tab templates
     *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function templates() {
		?>
		<script type="text/html" id="tmpl-dimax-size-guide-tab">
			<div class="dimax-size-guide-table-tabs--tab" data-tab="{{data.index}}">
				<span class="dimax-size-guide-table-tabs--tab-text">{{data.tab}}</span>
				<input type="text" name="_size_guides[tabs][]" value="{{data.tab}}" class="hidden">
				<span class="dashicons dashicons-edit edit-button"></span>
				<span class="dashicons dashicons-yes confirm-button"></span>
			</div>
		</script>

		<script type="text/html" id="tmpl-dimax-size-guide-panel">
			<div class="dimax-size-guide-table-editor" data-tab="{{data.index}}">
				<p>
					<label>
						<?php esc_html_e( 'Table Name', 'dimax' ); ?><br/>
						<input type="text" name="_size_guides[names][]" class="widefat" value="{{data.name}}">
					</label>
				</p>

				<p>
					<label>
						<?php esc_html_e( 'Description', 'dimax' ) ?>
						<textarea name="_size_guides[descriptions][]" class="widefat" rows="6">{{data.description}}</textarea>
					</label>
				</p>

				<p><label><?php esc_html_e( 'Table', 'dimax' ) ?></label></p>

				<textarea name="_size_guides[tables][]" class="widefat dimax-size-guide-table hidden">{{{data.table}}}</textarea>

				<p>
					<label>
						<?php esc_html_e( 'Additional Information', 'dimax' ) ?>
						<textarea name="_size_guides[information][]" class="widefat" rows="6">{{{data.information}}}</textarea>
					</label>
				</p>

				<p class="delete-table-p">
					<a href="#" class="delete-table"><?php esc_html_e( 'Delete Table', 'dimax' ) ?></a>
				</p>
			</div>
		</script>

		<?php
	}

		/**
	 * Add new product data tab for size guide
	 *
	 * @param array $tabs
	 *
	 * @return array
	 */
	public function product_data_tab( $tabs ) {
		$tabs['dimax_size_guide'] = array(
			'label'    => esc_html__( 'Size Guide', 'dimax' ),
			'target'   => 'dimax-size-guide',
			'class'    => array( 'dimax-size-guide', ),
			'priority' => 62,
		);

		return $tabs;
	}


	/**
	 * Outputs the size guide panel
     *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function product_data_panel() {
		global $post, $thepostid, $product_object;

		$thepostid = empty( $thepostid ) ? $post->ID : $thepostid;
		$default_display = get_option( self::OPTION_NAME . '_display', 'tab' );
		$default_positon = get_option( self::OPTION_NAME . '_button_position', 'bellow_summary' );

		$display_options = array(
			'tab'   => esc_html__( 'In product tabs', 'dimax' ),
			'panel' => esc_html__( 'Panel by clicking on a button', 'dimax' ),
			'popup' => esc_html__( 'Popup by clicking on a button', 'dimax' ),
		);

		$button_options = array(
			'bellow_summary'   => esc_html__( 'Bellow short description', 'dimax' ),
			'bellow_price'     => esc_html__( 'Bellow price', 'dimax' ),
			'above_button'     => esc_html__( 'Above Add To Cart button', 'dimax' ),
			'bellow_attribute' => esc_html__( 'Bellow the Size attribute', 'dimax' ),
		);

		$product_size_guide = get_post_meta( $thepostid, 'dimax_size_guide', true );
		$product_size_guide = wp_parse_args( $product_size_guide, array(
			'guide'           => '',
			'display'         => '',
			'button_position' => '',
			'attribute'       => '',
		) );

		$guides = get_posts( array(
			'post_type'      => self::POST_TYPE,
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC',
			'fields'         => 'ids',
		) );

		$guide_options = array(
			'' => esc_html__( '--Default--', 'dimax' ),
			'none' => esc_html__( '--No Size Guide--', 'dimax' ),
		);
		foreach ( $guides as $guide ) {
			$guide_options[ $guide ] = get_post_field( 'post_title', $guide );
		}

		$attributes   = $product_object->get_attributes( 'edit' );
		$attribute_options = array();
		foreach ( $attributes as $attribute ) {
			if ( ! $attribute->get_variation() ) {
				continue;
			}

			$option_value = $attribute->get_name();
			$option_name =  $option_value;

			if ( $attribute->get_id() ) {
				$taxonomy = wc_get_attribute( $attribute->get_id() );
				$option_name = $taxonomy ? $taxonomy->name : $option_name;
			}

			$attribute_options[ $option_value ] = $option_name;
		}
		?>

		<div id="dimax-size-guide" class="panel woocommerce_options_panel hidden" data-nonce="<?php echo esc_attr( wp_create_nonce( 'dimax_size_guide' ) ) ?>">
			<div class="options_group">
				<?php
				woocommerce_wp_select( array(
					'id'      => 'dimax_size_guide-guide',
					'name'    => 'dimax_size_guide[guide]',
					'value'   => $product_size_guide['guide'],
					'label'   => esc_html__( 'Size Guide', 'dimax' ),
					'options' => $guide_options,
				) );
				?>
			</div>

			<div class="options_group">
				<?php
				woocommerce_wp_select( array(
					'id'      => 'dimax_size_guide-display',
					'name'    => 'dimax_size_guide[display]',
					'value'   => $product_size_guide['display'],
					'label'   => esc_html__( 'Size Guide Display', 'dimax' ),
					'options' => array_merge( array( '' => esc_html__( 'Default', 'dimax' ) . ' (' . $display_options[ $default_display ] . ')' ), $display_options ),
				) );

				woocommerce_wp_select( array(
					'id'      => 'dimax_size_guide-button_position',
					'name'    => 'dimax_size_guide[button_position]',
					'value'   => $product_size_guide['button_position'],
					'label'   => esc_html__( 'Button Position', 'dimax' ),
					'options' => array_merge( array( '' => esc_html__( 'Default', 'dimax' ) . ' (' . $button_options[ $default_positon ] . ')' ), $button_options ),
				) );

				if ( ! empty( $attribute_options ) ) {
					woocommerce_wp_select( array(
						'id'      => 'dimax_size_guide-attribute',
						'name'    => 'dimax_size_guide[attribute]',
						'value'   => $product_size_guide['attribute'],
						'label'   => esc_html__( 'Attribute', 'dimax' ),
						'options' => $attribute_options,
					) );
				}
				?>
			</div>
		</div>

		<?php
	}

	/**
	 * Save product data of selected size guide
	 *
	 * @param int $post_id
     *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function process_product_meta( $post_id ) {
		if ( isset( $_POST['dimax_size_guide'] ) ) {
			update_post_meta( $post_id, 'dimax_size_guide', $_POST['dimax_size_guide'] );
		}
	}

	/**
	 * Ajax load product variation attributes.
     *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function ajax_load_product_size_guide_attributes() {
		check_ajax_referer( 'dimax_size_guide', 'security' );

		if ( ! current_user_can( 'edit_products' ) || empty( $_POST['product_id'] ) ) {
			wp_die( -1 );
		}

		// Set $post global so its available, like within the admin screens.
		global $post;

		$product_id     = absint( $_POST['product_id'] );
		$post           = get_post( $product_id ); // phpcs:ignore
		$product_object = wc_get_product( $product_id );

		$product_size_guide = get_post_meta( $product_id, 'dimax_size_guide', true );
		$product_size_guide = wp_parse_args( $product_size_guide, array(
			'guide'           => '',
			'display'         => '',
			'button_position' => '',
			'attribute'       => '',
		) );

		$attributes   = $product_object->get_attributes( 'edit' );
		$attribute_options = array();
		foreach ( $attributes as $attribute ) {
			if ( ! $attribute->get_variation() ) {
				continue;
			}

			$option_value = $attribute->get_name();
			$option_name  = $option_value;

			if ( $attribute->get_id() ) {
				$taxonomy = wc_get_attribute( $attribute->get_id() );
				$option_name = $taxonomy ? $taxonomy->name : $option_name;
			}

			$attribute_options[ $option_value ] = $option_name;
		}

		woocommerce_wp_select( array(
			'id'      => 'dimax_size_guide-attribute',
			'name'    => 'dimax_size_guide[attribute]',
			'value'   => $product_size_guide['attribute'],
			'label'   => esc_html__( 'Attribute', 'dimax' ),
			'options' => $attribute_options,
		) );

		wp_die();
	}
}