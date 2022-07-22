<?php

namespace Dimax\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Dimax\Addons\Elementor\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Icon Box widget
 */
class Products_Tab_Grid extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'dimax-product-tab-grid';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Dimax - Product Tabs Grid', 'dimax' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-tabs';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'dimax' ];
	}

	public function get_script_depends() {
		return [
			'dimax-product-shortcode'
		];
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
	protected function _register_controls() {
		$this->section_content();
		$this->section_style();
	}

	// Tab Content
	protected function section_content() {
		$this->section_products_settings_controls();
		$this->section_pagination_settings_controls();
	}

	// Tab Style
	protected function section_style() {
		$this->section_tab_header_style_controls();
		$this->section_button_style_controls();
		$this->section_pagination_style_controls();
	}

	protected function section_products_settings_controls() {
		$this->start_controls_section(
			'section_products',
			[ 'label' => esc_html__( 'Products', 'dimax' ) ]
		);

		$this->add_control(
			'per_page',
			[
				'label'   => esc_html__( 'Total Products', 'dimax' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 8,
				'min'     => 1,
				'max'     => 50,
				'step'    => 1,
			]
		);

		$this->add_control(
			'columns',
			[
				'label'   => esc_html__( 'Columns', 'dimax' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 4,
				'min'     => 1,
				'max'     => 7,
				'step'    => 1,
			]
		);

		$this->add_control(
			'product_tabs_source',
			[
				'label'   => esc_html__( 'Source', 'dimax' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'special_products' => esc_html__( 'Special Products', 'dimax' ),
					'product_cats'     => esc_html__( 'Product Categories', 'dimax' ),
				],
				'default' => 'special_products',
				'toggle'  => false,
				'separator' => 'before',
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'title', [
				'label'       => esc_html__( 'Title', 'dimax' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'This is heading', 'dimax' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'tab_products',
			[
				'label'   => esc_html__( 'Products', 'dimax' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'recent'       => esc_html__( 'Recent', 'dimax' ),
					'featured'     => esc_html__( 'Featured', 'dimax' ),
					'best_selling' => esc_html__( 'Best Selling', 'dimax' ),
					'top_rated'    => esc_html__( 'Top Rated', 'dimax' ),
					'sale'         => esc_html__( 'On Sale', 'dimax' ),
				],
				'default' => 'recent',
				'toggle'  => false,
			]
		);

		$repeater->add_control(
			'tab_orderby',
			[
				'label'     => esc_html__( 'Order By', 'dimax' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''           => esc_html__( 'Default', 'dimax' ),
					'date'       => esc_html__( 'Date', 'dimax' ),
					'title'      => esc_html__( 'Title', 'dimax' ),
					'menu_order' => esc_html__( 'Menu Order', 'dimax' ),
					'rand'       => esc_html__( 'Random', 'dimax' ),
				],
				'default'   => '',
				'toggle'    => false,
				'condition' => [
					'tab_products' => [ 'recent', 'top_rated', 'sale', 'featured' ],
				],
			]
		);

		$repeater->add_control(
			'tab_order',
			[
				'label'     => esc_html__( 'Order', 'dimax' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''     => esc_html__( 'Default', 'dimax' ),
					'asc'  => esc_html__( 'Ascending', 'dimax' ),
					'desc' => esc_html__( 'Descending', 'dimax' ),
				],
				'default'   => '',
				'toggle'    => false,
				'condition' => [
					'tab_products' => [ 'recent', 'top_rated', 'sale', 'featured' ],
				],
			]
		);

		$repeater->add_control(
			'tab_button_text',
			[
				'label'       => esc_html__( 'Button Text', 'dimax' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
			]
		);

		$repeater->add_control(
			'tab_button_link', [
				'label'         => esc_html__( 'Button Link', 'dimax' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'dimax' ),
				'show_external' => true,
				'default'       => [
					'url'         => '#',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);

		$this->add_control(
			'special_products_tabs',
			[
				'label'         => '',
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'default'       => [
					[
						'title'        => esc_html__( 'New Arrivals', 'dimax' ),
						'tab_products' => 'recent',
						'tab_button_text' => ''
					],
					[
						'title'        => esc_html__( 'Features', 'dimax' ),
						'tab_products' => 'featured',
						'tab_button_text' => ''
					],
					[
						'title'        => esc_html__( 'Top Rated', 'dimax' ),
						'tab_products' => 'top_rated',
						'tab_button_text' => ''
					]
				],
				'title_field'   => '{{{ title }}}',
				'prevent_empty' => false,
				'condition'     => [
					'product_tabs_source' => 'special_products',
				],
			]
		);

		$this->add_control(
			'view_all_cats',
			[
				'label'        => esc_html__( 'View All Categories', 'dimax' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'dimax' ),
				'label_off'    => esc_html__( 'Hide', 'dimax' ),
				'return_value' => 'yes',
				'default'      => '',
				'condition' => [
					'product_tabs_source' => 'product_cats',
				],
			]
		);

		$this->add_control(
			'view_all_cats_text',
			[
				'label'       => esc_html__( 'View All Text', 'dimax' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'All', 'dimax' ),
				'condition' => [
					'product_tabs_source' => 'product_cats',
					'view_all_cats' => 'yes',
				],
			]
		);

		$product_cats = Helper::taxonomy_list();
		$repeater     = new \Elementor\Repeater();

		$repeater->add_control(
			'product_cat', [
				'label'       => esc_html__( 'Category Tab', 'dimax' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => $product_cats,
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'product_cat_btn_text',
			[
				'label'       => esc_html__( 'Button Text', 'dimax' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
			]
		);

		$this->add_control(
			'product_cats_tabs',
			[
				'label'         => esc_html__( 'Category Tabs', 'dimax' ),
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'default'       => [ ],
				'prevent_empty' => false,
				'condition'     => [
					'product_tabs_source' => 'product_cats',
				],
				'title_field'   => '{{{ product_cat }}}',
			]
		);

		$this->add_control(
			'category',
			[
				'label'       => esc_html__( 'Products Category', 'dimax' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'dimax' ),
				'type'        => 'rzautocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => true,
				'source'      => 'product_cat',
				'sortable'    => true,
				'condition'   => [
					'product_tabs_source' => 'special_products',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'product_tags',
			[
				'label'       => esc_html__( 'Products Tags', 'dimax' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'dimax' ),
				'type'        => 'rzautocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => true,
				'source'      => 'product_tag',
				'sortable'    => true,
				'condition'   => [
					'product_tabs_source' => 'special_products',
				],
			]
		);

		$this->add_control(
			'product_brands',
			[
				'label'       => esc_html__( 'Products Brands', 'dimax' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'dimax' ),
				'type'        => 'rzautocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => true,
				'source'      => 'product_brand',
				'sortable'    => true,
				'condition'   => [
					'product_tabs_source' => 'special_products',
				],
			]
		);

		if ( taxonomy_exists( 'product_author' ) ) {
			$this->add_control(
				'product_authors',
				[
					'label'       => esc_html__( 'Products Authors', 'dimax' ),
					'placeholder' => esc_html__( 'Click here and start typing...', 'dimax' ),
					'type'        => 'rzautocomplete',
					'default'     => '',
					'label_block' => true,
					'multiple'    => true,
					'source'      => 'product_author',
					'sortable'    => true,
					'condition'   => [
						'product_tabs_source' => 'special_products',
					],
				]
			);
		}

		$this->add_control(
			'products',
			[
				'label'     => esc_html__( 'Product', 'dimax' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'recent'       => esc_html__( 'Recent', 'dimax' ),
					'featured'     => esc_html__( 'Featured', 'dimax' ),
					'best_selling' => esc_html__( 'Best Selling', 'dimax' ),
					'top_rated'    => esc_html__( 'Top Rated', 'dimax' ),
					'sale'         => esc_html__( 'On Sale', 'dimax' ),
				],
				'default'   => 'recent',
				'toggle'    => false,
				'condition' => [
					'product_tabs_source' => 'product_cats',
				],
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'     => esc_html__( 'Order By', 'dimax' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''           => esc_html__( 'Default', 'dimax' ),
					'date'       => esc_html__( 'Date', 'dimax' ),
					'title'      => esc_html__( 'Title', 'dimax' ),
					'menu_order' => esc_html__( 'Menu Order', 'dimax' ),
					'rand'       => esc_html__( 'Random', 'dimax' ),
				],
				'default'   => '',
				'condition' => [
					'products'            => [ 'recent', 'top_rated', 'sale', 'featured' ],
					'product_tabs_source' => 'product_cats',
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label'     => esc_html__( 'Order', 'dimax' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''     => esc_html__( 'Default', 'dimax' ),
					'asc'  => esc_html__( 'Ascending', 'dimax' ),
					'desc' => esc_html__( 'Descending', 'dimax' ),
				],
				'default'   => '',
				'condition' => [
					'products'            => [ 'recent', 'top_rated', 'sale', 'featured' ],
					'product_tabs_source' => 'product_cats',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function section_pagination_settings_controls() {
		// Pagination Settings
		$this->start_controls_section(
			'section_pagination',
			[
				'label' => esc_html__( 'Pagination', 'dimax' ),
			]
		);

		$this->add_control(
			'pagination_enable',
			[
				'label'        => esc_html__( 'Pagination', 'dimax' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'dimax' ),
				'label_off'    => esc_html__( 'Hide', 'dimax' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		$this->end_controls_section(); // End Pagination Settings
	}

	protected function section_tab_header_style_controls() {
		$this->start_controls_section(
			'section_tab_header_style',
			[
				'label' => esc_html__( 'Tab Header', 'dimax' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'tab_header_space',
			[
				'label'     => __( 'Space', 'dimax' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 150,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimax-products-tabs .tabs-header' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tab_header_space_left',
			[
				'label'     => __( 'Space Left', 'dimax' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 150,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimax-products-tabs .tabs-header' => 'padding-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tab_header_item_space',
			[
				'label'     => __( 'Item Space', 'dimax' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 150,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimax-products-tabs ul.tabs li:not(:first-child)' => 'padding-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .dimax-products-tabs ul.tabs li:not(:last-child)' => 'padding-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tab_header_align',
			[
				'label'       => esc_html__( 'Align', 'dimax' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'flex-start'   => [
						'title' => esc_html__( 'Left', 'dimax' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'dimax' ),
						'icon'  => 'eicon-text-align-center',
					],
					'flex-end'  => [
						'title' => esc_html__( 'Right', 'dimax' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'selectors'   => [
					'{{WRAPPER}} .dimax-products-tabs ul.tabs' => 'justify-content: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'tab_header_divider',
			[
				'label' => '',
				'type'  => Controls_Manager::DIVIDER,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'tab_header_title',
				'selector' => '{{WRAPPER}} .dimax-products-tabs ul.tabs li a',
			]
		);
		$this->add_control(
			'tab_header_title_color',
			[
				'label'     => esc_html__( 'Text Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-products-tabs ul.tabs li a' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'tab_header_active_color',
			[
				'label'     => esc_html__( 'Active Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-products-tabs ul.tabs li a.active' => 'color: {{VALUE}};',
					'{{WRAPPER}} .dimax-products-tabs ul.tabs li a:after' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function section_button_style_controls() {
		// Button Tab Style
		$this->start_controls_section(
			'section_button_style',
			[
				'label' => esc_html__( 'Button', 'dimax' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'button_spacing',
			[
				'label'     => __( 'Spacing', 'dimax' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 150,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimax-products-tabs .tabs-panel .dimax-tabs-button' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_divider',
			[
				'label' => '',
				'type'  => Controls_Manager::DIVIDER,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_text',
				'selector' => '{{WRAPPER}} .dimax-products-tabs .tabs-panel .dimax-tabs-button a',
			]
		);

		$this->add_control(
			'button_color',
			[
				'label'     => esc_html__( 'Text Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-products-tabs .tabs-panel .dimax-tabs-button a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function section_pagination_style_controls() {
		// Pagination Tab Style
		$this->start_controls_section(
			'section_pagination_style',
			[
				'label' => esc_html__( 'Pagination', 'dimax' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'pagination_spacing',
			[
				'label'     => __( 'Spacing', 'dimax' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 150,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimax-products-tabs .ajax-load-products' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'pagination_button_text',
				'selector' => '{{WRAPPER}} .dimax-products-tabs .ajax-load-products',
			]
		);

		$this->add_control(
			'pagination_button_color',
			[
				'label'     => esc_html__( 'Button Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-products-tabs .ajax-load-products' => 'color: {{VALUE}};',
					'{{WRAPPER}} .dimax-products-tabs .ajax-load-products .dimax-gooey span' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pagination_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-products-tabs .ajax-load-products' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render icon box widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$classes = [
			'dimax-products-tabs dimax-products-tabs-grid dimax-tabs woocommerce'
		];

		$this->add_render_attribute( 'wrapper', 'class', $classes );

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php self::get_products_tab( $settings ); ?>
		</div>
		<?php
	}

	public static function get_products_tab( $settings ) {

		$output      = [ ];
		$header_tabs = [ ];
		$tab_content = [ ];

		$header_tabs[] = '<ul class="tabs-header tabs-nav tabs">';
		$i             = 0;
		if ( $settings['product_tabs_source'] == 'special_products' ) {
			$tabs = $settings['special_products_tabs'];

			if ( $tabs ) {
				foreach ( $tabs as $index => $item ) {
					$button_view = $class_active = '';

					if ( $i == 0 ) {
						$class_active = 'active';
					}

					if ( isset( $item['title'] ) ) {
						$header_tabs[] = sprintf( '<li><a href="#" data-href="%s" class="%s">%s</a></li>', esc_attr( $item['tab_products'] ), $class_active, esc_html( $item['title'] ) );
					}

					if ( $item['tab_button_text'] ) {
						$button_view = sprintf( '<div class="dimax-tabs-button">%s</div>', Helper::control_url( $index, $item['tab_button_link'], $item['tab_button_text'], [ 'class' => 'dimax-button--underlined' ] ) );
					}

					$tab_atts = [
						'products'     		=> $item['tab_products'],
						'orderby'      		=> ! empty( $item['tab_orderby'] ) ? $item['tab_orderby'] : '',
						'order'        		=> ! empty( $item['tab_order'] ) ? $item['tab_order'] : '',
						'category'    		=> $settings['category'],
						'tag'    			=> $settings['product_tags'],
						'product_brands'    => $settings['product_brands'],
						'per_page'    		=> $settings['per_page'],
						'columns'      		=> $settings['columns'],
						'paginate'			=> true,
					];

					if ( taxonomy_exists( 'product_author' ) ) {
						$tab_atts['product_authors'] = $settings['product_authors'];
					}

					$results = Helper::products_shortcode( $tab_atts );
					if ( ! $results ) {
						return;
					}

					$product_ids = $results['ids'];

					$btn_loadmore = '';
					if ( $settings['pagination_enable'] == 'yes' ) {
						if ( $results['current_page'] < $results['total_pages']  ) {
							$btn_loadmore = sprintf(
								'<a href="#" class="ajax-load-products dimax-button button-larger" data-page="%s" rel="nofollow">
									<span class="button-text">%s</span>
									<span class="dots dimax-gooey">
										<span></span>
										<span></span>
										<span></span>
									</span>
								</a>',
								esc_attr( $results['current_page'] + 1 ),
								esc_html__( 'Load More', 'dimax' )
							);
						}
					}

					if ( $i == 0 ) {
						$tab_content[] = sprintf(
										'<div class="tabs-panel tabs-%s tab-loaded active" data-settings="%s">',
										esc_attr( $item['tab_products'] ),
										esc_attr( wp_json_encode( $tab_atts ) )
									);

						ob_start();
						wc_setup_loop(
							array(
								'columns'      => $settings['columns']
							)
						);
						Helper::get_template_loop( $product_ids );
						$tab_content[] = ob_get_clean();

						$tab_content[] = wp_kses_post( $button_view );

						$tab_content[] = $btn_loadmore;

						$tab_content[] = '</div>';
					} else {
						$tab_content[] = sprintf(
							'<div class="tabs-panel tabs-%s" data-settings="%s">%s%s</div>',
							esc_attr( $item['tab_products'] ),
							esc_attr( wp_json_encode( $tab_atts ) ),
							wp_kses_post( $button_view ),
							$btn_loadmore
						);
					}

					$i ++;
				}
			}
		} else {
			if ( $settings['view_all_cats'] ) {
				$header_tabs[] = sprintf( '<li><a href="#" data-href="all" class="active">%s</a></li>', $settings['view_all_cats_text'] );

				$tab_atts = [
					'products'     		=> $settings['products'],
					'orderby'      		=> ! empty( $settings['orderby'] ) ? $settings['orderby'] : '',
					'order'        		=> ! empty( $settings['order'] ) ? $settings['order'] : '',
					'category'    		=> '',
					'tag'    			=> $settings['product_tags'],
					'product_brands'    => $settings['product_brands'],
					'per_page'    		=> $settings['per_page'],
					'columns'      		=> $settings['columns'],
					'paginate'			=> true,
				];

				if ( taxonomy_exists( 'product_author' ) ) {
					$tab_atts['product_authors'] = $settings['product_authors'];
				}

				$results = Helper::products_shortcode( $tab_atts );
				if ( ! $results ) {
					return;
				}

				$product_ids = $results['ids'];

				$tab_content[] = sprintf(
					'<div class="tabs-panel tabs-all tab-loaded active" data-settings="%s">',
					esc_attr( wp_json_encode( $tab_atts ) )
				);

				ob_start();
				wc_setup_loop(
					array(
						'columns'      => $settings['columns']
					)
				);
				Helper::get_template_loop( $product_ids );
				$tab_content[] = ob_get_clean();

				$tab_content[] = '</div>';
			}

			$cats = $settings['product_cats_tabs'];
			if ( $cats ) {
				foreach ( $cats as $tab ) {
					$class_active = '';
					if ( $i == 0 && $settings['view_all_cats'] == '' ) {
						$class_active = 'active';
					}

					$term = get_term_by( 'slug', $tab['product_cat'], 'product_cat' );
					if ( ! is_wp_error( $term ) && $term ) {
						$header_tabs[] = sprintf( '<li><a href="#" data-href="%s" class="%s">%s</a></li>', esc_attr( $tab['product_cat'] ), esc_attr($class_active), esc_html( $term->name ) );
					}

					$tab_atts = array(
						'columns'      => $settings['columns'],
						'products'     => $settings['products'],
						'order'        => $settings['order'],
						'orderby'      => $settings['orderby'],
						'per_page'     => intval( $settings['per_page'] ),
						'category'    	=> $tab['product_cat'],
						'paginate'		=> true,
					);

					$results = Helper::products_shortcode( $tab_atts );
					if ( ! $results ) {
						return;
					}

					$product_ids = $results['ids'];

					$btn_loadmore = '';
					if ( $settings['pagination_enable'] == 'yes' ) {
						if ( $results['current_page'] < $results['total_pages']  ) {
							$btn_loadmore = sprintf(
								'<a href="#" class="ajax-load-products dimax-button button-larger" data-page="%s" rel="nofollow">
									<span class="button-text">%s</span>
									<span class="dots dimax-gooey">
										<span></span>
										<span></span>
										<span></span>
									</span>
								</a>',
								esc_attr( $results['current_page'] + 1 ),
								esc_html__( 'Load More', 'dimax' )
							);
						}
					}

					$button_view = '';

					if ( $tab['product_cat_btn_text'] ) {
						$button_view = sprintf( '<div class="dimax-tabs-button"><a class="dimax-button--underlined" href="%s">%s</a></div>', get_category_link( $term->term_id ), esc_html( $tab['product_cat_btn_text'] ) );
					}

					if ( $i == 0 && $settings['view_all_cats'] == '' ) {
						$tab_content[] = sprintf(
							'<div class="tabs-panel tabs-%s tab-loaded active" data-settings="%s">',
							esc_attr( $tab['product_cat'] ),
							esc_attr( wp_json_encode( $tab_atts ) )
						);

						ob_start();
						wc_setup_loop(
							array(
								'columns'      => $settings['columns']
							)
						);
						Helper::get_template_loop( $product_ids );
						$tab_content[] = ob_get_clean();

						$tab_content[] = wp_kses_post( $button_view );

						$tab_content[] = $btn_loadmore;

						$tab_content[] = '</div>';
					} else {
						$tab_content[] = sprintf(
							'<div class="tabs-panel tabs-%s" data-settings="%s">%s%s</div>',
							esc_attr( $tab['product_cat'] ),
							esc_attr( wp_json_encode( $tab_atts ) ),
							wp_kses_post( $button_view ),
							$btn_loadmore
						);
					}

					$i ++;

				}
			}
		}

		$header_tabs[] = '</ul>';

		$output[] = sprintf( '%s<div class="tabs-content">%s</div>', implode( ' ', $header_tabs ), implode( ' ', $tab_content ) );

		echo implode( '', $output );
	}
}