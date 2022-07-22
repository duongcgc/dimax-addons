<?php
/**
 * Register post types
 *
 * @package Dimax
 */

namespace Dimax\Addons;

/**
 * Class Dimax_Taxonomies
 */
class Product_Brands {

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
	 * Check if active brand
	 *
	 * @var bool
	 */
	private $active_brand = true;
	private $option = 'product_brand_slug';

	/**
	 * @var string placeholder image
	 */
	public $placeholder_img_src;

	/**
	 * Instantiate the object.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {

		add_action( 'admin_init', array( $this, 'settings_api_init' ) );
		add_action( 'current_screen', array( $this, 'settings_save' ) );
		$this->active_brand = apply_filters( 'dimax_register_brand', true );
		if ( ! $this->active_brand ) {
			return;
		}
		if ( get_option( $this->option ) ) {
			return;
		}
		// Register custom post type and custom taxonomy
		add_action( 'init', array( $this, 'register_brand' ), 100 );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );

		$this->placeholder_img_src = RAZZI_ADDONS_URL . '/img/placeholder.png';
		// Add form
		add_action( 'product_brand_add_form_fields', array( $this, 'add_category_fields' ) );
		add_action( 'product_brand_edit_form_fields', array( $this, 'edit_category_fields' ), 20 );
		add_action( 'created_term', array( $this, 'save_category_fields' ), 20, 3 );
		add_action( 'edit_term', array( $this, 'save_category_fields' ), 20, 3 );

		// Add columns
		add_filter( 'manage_edit-product_brand_columns', array( $this, 'product_brand_columns' ) );
		add_filter( 'manage_product_brand_custom_column', array( $this, 'product_brand_column' ), 10, 3 );

		add_filter( 'woocommerce_sortable_taxonomies', array( $this, 'product_brand_sortable' ) );

	}

	/**
	 * Register custom post type for brand
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function register_brand() {
		// Return if post type is exists
		if ( ! post_type_exists( 'product' ) ) {
			return;
		}

		$labels = array(
			'name'                       => __( 'Product Brands', 'dimax' ),
			'singular_name'              => __( 'Brand', 'dimax' ),
			'menu_name'                  => __( 'Brands', 'dimax' ),
			'all_items'                  => __( 'All Brands', 'dimax' ),
			'edit_item'                  => __( 'Edit Brand', 'dimax' ),
			'view_item'                  => __( 'View Brand', 'dimax' ),
			'update_item'                => __( 'Update Brand', 'dimax' ),
			'add_new_item'               => __( 'Add New Brand', 'dimax' ),
			'new_item_name'              => __( 'New Brand Name', 'dimax' ),
			'parent_item'                => __( 'Parent Brand', 'dimax' ),
			'parent_item_colon'          => __( 'Parent Brand:', 'dimax' ),
			'search_items'               => __( 'Search Brands', 'dimax' ),
			'popular_items'              => __( 'Popular Brands', 'dimax' ),
			'separate_items_with_commas' => __( 'Separate brands with commas', 'dimax' ),
			'add_or_remove_items'        => __( 'Add or remove brands', 'dimax' ),
			'choose_from_most_used'      => __( 'Choose from the most used brands', 'dimax' ),
			'not_found'                  => __( 'No brands found', 'dimax' )
		);

		$permalinks         = get_option( 'product_brand_permalinks' );
		$product_brand_base = empty( $permalinks['product_brand_base'] ) ? _x( 'product-brand', 'slug', 'dimax' ) : $permalinks['product_brand_base'];

		$args = array(
			'hierarchical'          => true,
			'update_count_callback' => '_wc_term_recount',
			'labels'                => $labels,
			'show_ui'               => true,
			'query_var'             => true,
			'rewrite'               => array(
				'slug'         => $product_brand_base,
				'hierarchical' => true,
				'ep_mask'      => EP_PERMALINK
			)
		);

		register_taxonomy( 'product_brand', array( 'product' ), $args );
	}


	/**
	 * Register admin scripts
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function register_admin_scripts( $hook ) {
		$screen = get_current_screen();
		if ( $hook == 'edit-tags.php' && $screen->taxonomy == 'product_brand' || $hook == 'term.php' && $screen->taxonomy == 'product_brand' ) {
			wp_enqueue_media();
			wp_enqueue_script( 'rz_product_brand_js', RAZZI_ADDONS_URL . "/assets/js/admin/brand-taxes.js", array( 'jquery' ), '20190715', true );
		}
	}

	/**
	 * Sortable brand
	 *
	 * @since  1.0.0
	 *
	 * @return array
	 */
	public function product_brand_sortable( $taxonomy ) {
		$taxonomy[] = 'product_brand';

		return $taxonomy;

	}

	/**
	 * Add  field in 'Settings' > 'Writing'
	 * for enabling CPT functionality.
     *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function settings_api_init() {
		add_settings_section(
			'dimax_brand_section',
			'<span id="brand-options">' . esc_html__( 'Product brand', 'dimax' ) . '</span>',
			array( $this, 'writing_section_html' ),
			'writing'
		);

		add_settings_field(
			$this->option,
			'<span class="brand-options">' . esc_html__( 'Product brand', 'dimax' ) . '</span>',
			array( $this, 'disable_field_html' ),
			'writing',
			'dimax_brand_section'
		);
		register_setting(
			'writing',
			$this->option,
			'intval'
		);

		add_settings_field(
			'product_brand_slug',
			'<label for="product_brand_slug">' . esc_html__( 'Product brand base', 'dimax' ) . '</label>',
			array( $this, 'product_brand_slug_input' ),
			'permalink',
			'optional'
		);

		register_setting(
			'permalink',
			'product_brand_slug',
			'sanitize_text_field'
		);
	}

	/**
	 * Show a slug input box.
     *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function product_brand_slug_input() {
		$permalinks = get_option( 'product_brand_permalinks' );
		$brand_base = isset( $permalinks['product_brand_base'] ) ? $permalinks['product_brand_base'] : '';
		?>
        <input name="product_brand_slug" type="text" class="regular-text code"
               value="<?php echo esc_attr( $brand_base ); ?>"
               placeholder="<?php echo esc_attr_x( 'product-brand', 'slug', 'dimax' ) ?>"/>
		<?php
	}

	/**
	 * Save the settings.
     *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function settings_save() {
		if ( ! is_admin() ) {
			return;
		}

		if ( ! $screen = get_current_screen() ) {
			return;
		}

		if ( 'options-permalink' != $screen->id ) {
			return;
		}

		$permalinks = get_option( 'product_brand_permalinks' );

		if ( isset( $_POST['product_brand_slug'] ) ) {
			$permalinks['product_brand_base'] = $this->sanitize_permalink( trim( $_POST['product_brand_slug'] ) );
		}

		update_option( 'product_brand_permalinks', $permalinks );
	}

	/**
	 * Sanitize permalink
	 *
	 * @param string $value
	 *
	 * @return string
	 */
	private function sanitize_permalink( $value ) {
		global $wpdb;

		$value = $wpdb->strip_invalid_text_for_column( $wpdb->options, 'option_value', $value );

		if ( is_wp_error( $value ) ) {
			$value = '';
		}

		$value = esc_url_raw( $value );
		$value = str_replace( 'http://', '', $value );

		return untrailingslashit( $value );
	}

	/**
	 * Category thumbnail fields.
     *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function add_category_fields() {
		?>
        <div class="form-field" id="product-brand-thumb-box">
            <label><?php esc_html_e( 'Thumbnail', 'dimax' ); ?></label>

            <div id="product_brand_thumb" class="product-brand-thumb"
                 data-rel="<?php echo esc_url( $this->placeholder_img_src ); ?>">
                <img src="<?php echo esc_url( $this->placeholder_img_src ); ?>" width="60px" height="60px"/></div>
            <div class="product-brand-thumb-box">
                <input type="hidden" id="product_brand_thumb_id" name="product_brand_thumb_id"/>
                <button type="button"
                        class="upload_image_button button"><?php esc_html_e( 'Upload/Add image', 'dimax' ); ?></button>
                <button type="button"
                        class="remove_image_button button"><?php esc_html_e( 'Remove image', 'dimax' ); ?></button>
            </div>
            <div class="clear"></div>
        </div>
		<?php
	}

	/**
	 * Edit category thumbnail field.
	 *
	 * @param mixed $term Term (category) being edited
     *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function edit_category_fields( $term ) {
		$thumbnail_id = '';
		if ( function_exists( 'get_term_meta' ) ) {
			$thumbnail_id = absint( get_term_meta( $term->term_id, 'brand_thumbnail_id', true ) );
		}

		if ( $thumbnail_id ) {
			$image = wp_get_attachment_thumb_url( $thumbnail_id );
		} else {
			$image = $this->placeholder_img_src;
		}
		?>
        <tr class="form-field product-brand-thumb" id="product-brand-thumb-box">
            <th scope="row" valign="top"><label><?php esc_html_e( 'Thumbnail', 'dimax' ); ?></label></th>
            <td>
                <div id="product_brand_thumb" class="product-brand-thumb"
                     data-rel="<?php echo esc_url( $this->placeholder_img_src ); ?>">
                    <img src="<?php echo esc_url( $image ); ?>" width="60px" height="60px"/>
                </div>
                <div class="product-brand-thumb-box">
                    <input type="hidden" id="product_brand_thumb_id" name="product_brand_thumb_id"
                           value="<?php echo esc_attr( $thumbnail_id ); ?>"/>
                    <button type="button"
                            class="upload_image_button button"><?php esc_html_e( 'Upload/Add image', 'dimax' ); ?></button>
                    <button type="button"
                            class="remove_image_button button"><?php esc_html_e( 'Remove image', 'dimax' ); ?></button>
                </div>
                <div class="clear"></div>
            </td>
        </tr>
		<?php
	}

	/**
	 * save_category_fields function.
	 *
	 * @param mixed $term_id Term ID being saved
	 * @param mixed $tt_id
	 * @param string $taxonomy
     *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function save_category_fields( $term_id, $tt_id = '', $taxonomy = '' ) {
		if ( isset( $_POST['product_brand_thumb_id'] ) && 'product_brand' === $taxonomy && function_exists( 'update_term_meta' ) ) {
			update_term_meta( $term_id, 'brand_thumbnail_id', absint( $_POST['product_brand_thumb_id'] ) );
		}
	}

	/**
	 * Thumbnail column added to category admin.
	 *
	 * @param mixed $columns
	 *
	 * @since  1.0.0
	 *
	 * @return array
	 */
	public function product_brand_columns( $columns ) {
		$new_columns = array();

		if ( isset( $columns['cb'] ) ) {
			$new_columns['cb'] = $columns['cb'];
			unset( $columns['cb'] );
		}

		$new_columns['thumb'] = esc_html__( 'Image', 'dimax' );

		return array_merge( $new_columns, $columns );
	}

	/**
	 * Thumbnail column value added to category admin.
	 *
	 * @param string $columns
	 * @param string $column
	 * @param int $id
	 *
	 * @since  1.0.0
	 *
	 * @return string
	 */
	public function product_brand_column( $columns, $column, $id ) {
		if ( 'thumb' == $column ) {

			$thumbnail_id = get_term_meta( $id, 'brand_thumbnail_id', true );

			if ( $thumbnail_id ) {
				$image = wp_get_attachment_thumb_url( $thumbnail_id );
			} else {
				$image = $this->placeholder_img_src;
			}

			// Prevent esc_url from breaking spaces in urls for image embeds
			// Ref: https://core.trac.wordpress.org/ticket/23605
			$image = str_replace( ' ', '%20', $image );

			$columns .= '<img src="' . esc_url( $image ) . '" alt="' . esc_attr__( 'Thumbnail', 'dimax' ) . '" class="wp-post-image" height="48" width="120" />';

		}

		return $columns;
	}

	/**
	 * Add writing setting section
     *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function writing_section_html() {
		?>
        <p>
			<?php esc_html_e( 'Use these settings to disable custom types of content on your site', 'dimax' ); ?>
        </p>
		<?php
	}

	/**
	 * HTML code to display a checkbox true/false option
	 * for the Services CPT setting.
     *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function disable_field_html() {
		?>

        <label for="<?php echo esc_attr( $this->option ); ?>">
            <input name="<?php echo esc_attr( $this->option ); ?>"
                   id="<?php echo esc_attr( $this->option ); ?>" <?php checked( get_option( $this->option ), true ); ?>
                   type="checkbox" value="1"/>
			<?php esc_html_e( 'Disable Brand for this site.', 'dimax' ); ?>
        </label>

		<?php
	}
}
