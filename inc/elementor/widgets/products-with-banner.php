<?php

namespace Razzi\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Group_Control_Image_Size;
use Razzi\Addons\Elementor\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Products With Banner widget
 */
class Products_With_Banner extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'dimax-products-with-banner';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Razzi - Products With Banner', 'dimax' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-inner-section';
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
		$scripts = [
			'dimax-product-shortcode'
		];

		return $scripts;
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
		$this->section_banner_settings_controls();
		$this->section_products_settings_controls();
	}

	// Tab Style
	protected function section_style() {
		$this->section_banner_style_controls();
	}

	protected function section_banner_settings_controls() {
		$this->start_controls_section(
			'section_banner',
			[ 'label' => esc_html__( 'Banner', 'dimax' ) ]
		);

		$this->add_control(
			'banner_image',
			[
				'label'   => esc_html__( 'Background Image', 'dimax' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [],
			]
		);

		$this->add_control(
			'background_overlay',
			[
				'label'      => esc_html__( 'Background Overlay', 'dimax' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .dimax-products-with-banner .masonry-banner-content .banner-image:before' => 'background-color: {{VALUE}}',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image',
				'default'   => 'full',
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'dimax' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'This is title', 'dimax' ),
				'label_block' => true,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'description',
			[
				'label'       => esc_html__( 'Description', 'dimax' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'This is description', 'dimax' ),
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'       => esc_html__( 'Button Text', 'dimax' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
			]
		);

		$this->add_control(
			'banner_link', [
				'label'         => esc_html__( 'Link', 'dimax' ),
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
			'link_type',
			[
				'label'   => esc_html__( 'Link Type', 'dimax' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'only' => esc_html__( 'Only button text', 'dimax' ),
					'all'  => esc_html__( 'All banner', 'dimax' ),
				],
				'default' => 'all',
				'toggle'  => false,
			]
		);

		$this->end_controls_section();
	}

	protected function section_products_settings_controls() {
		$this->start_controls_section(
			'section_products',
			[ 'label' => esc_html__( 'Products', 'dimax' ) ]
		);

		$this->add_control(
			'limit',
			[
				'label'   => esc_html__( 'Limit', 'dimax' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 6,
				'min'     => 2,
				'max'     => 38,
				'step'    => 1,
			]
		);

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
			]
		);

		$this->add_control(
			'product_category',
			[
				'label'       => esc_html__( 'Product Categories', 'dimax' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'dimax' ),
				'type'        => 'rzautocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => true,
				'source'      => 'product_cat',
				'sortable'    => true,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'product_tag',
			[
				'label'       => esc_html__( 'Products Tags', 'dimax' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'dimax' ),
				'type'        => 'rzautocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => true,
				'source'      => 'product_tag',
				'sortable'    => true,
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
				]
			);
		}

		$this->add_control(
			'attributes_divider',
			[
				'label' => esc_html__( 'Attributes', 'dimax' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'show_category',
			[
				'label'     => esc_html__( 'Category', 'dimax' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'dimax' ),
				'label_on'  => __( 'Show', 'dimax' ),
				'return_value' => 'show',
				'default'   => '',
			]
		);

		$this->add_control(
			'show_rating',
			[
				'label'     => esc_html__( 'Rating', 'dimax' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'dimax' ),
				'label_on'  => __( 'Show', 'dimax' ),
				'return_value' => 'show',
				'default'   => '',
			]
		);

		$this->add_control(
			'show_quickview',
			[
				'label'     => esc_html__( 'Quick View', 'dimax' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'dimax' ),
				'label_on'  => __( 'Show', 'dimax' ),
				'return_value' => 'show',
				'default'   => '',
			]
		);

		$this->add_control(
			'show_addtocart',
			[
				'label'     => esc_html__( 'Add To Cart', 'dimax' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'dimax' ),
				'label_on'  => __( 'Show', 'dimax' ),
				'return_value' => 'show',
				'default'   => '',
			]
		);

		$this->add_control(
			'show_wishlist',
			[
				'label'     => esc_html__( 'Wishlist', 'dimax' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'dimax' ),
				'label_on'  => __( 'Show', 'dimax' ),
				'return_value' => 'show',
				'default'   => '',
			]
		);

		$this->add_control(
			'show_badges',
			[
				'label'     => esc_html__( 'Badges', 'dimax' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'dimax' ),
				'label_on'  => __( 'Show', 'dimax' ),
				'return_value' => 'show',
				'default'   => '',
			]
		);

		$this->add_control(
			'show_atc_mobile',
			[
				'label'     => esc_html__( 'Show Add to Cart Button on Mobile', 'dimax' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'dimax' ),
				'label_on'  => __( 'Show', 'dimax' ),
				'return_value' => 'show',
				'default'   => 'show',
				'conditions' => [
					'terms' => [
						[
							'name' => 'show_addtocart',
							'value' => 'show',
						],
					],
				],
			]
		);

		$this->add_control(
			'show_featured_icons_mobile',
			[
				'label'     => esc_html__( 'Show Featured Icons Mobile', 'dimax' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'dimax' ),
				'label_on'  => __( 'Show', 'dimax' ),
				'return_value' => 'show',
				'default'   => 'show',
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'show_addtocart',
							'value' => 'show',
						],
						[
							'name' => 'show_quickview',
							'value' => 'show',
						],
						[
							'name' => 'show_wishlist',
							'value' => 'show',
						],
					],
				],
			]
		);

		$this->add_control(
			'product_link_type',
			[
				'label'   => esc_html__( 'Link Type', 'dimax' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'only' => esc_html__( 'Only title product', 'dimax' ),
					'all'  => esc_html__( 'All product', 'dimax' ),
				],
				'default' => 'only',
				'toggle'  => false,
			]
		);

		$this->end_controls_section();
	}

	protected function section_banner_style_controls() {
		// Content Style
		$this->start_controls_section(
			'section_banner_style',
			[
				'label' => esc_html__( 'Banner', 'dimax' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'vertical_position',
			[
				'label'                => esc_html__( 'Vertical Position', 'dimax' ),
				'type'                 => Controls_Manager::CHOOSE,
				'label_block'          => false,
				'options'              => [
					'top'    => [
						'title' => esc_html__( 'Top', 'dimax' ),
						'icon'  => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => esc_html__( 'Middle', 'dimax' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'dimax' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'selectors'            => [
					'{{WRAPPER}} .dimax-products-with-banner .masonry-banner-content .banner-content' => 'justify-content: {{VALUE}}',
				],
				'selectors_dictionary' => [
					'top'    => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'text_align',
			[
				'label'       => esc_html__( 'Text Align', 'dimax' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'left'   => [
						'title' => esc_html__( 'Left', 'dimax' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'dimax' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'dimax' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'selectors'   => [
					'{{WRAPPER}} .dimax-products-with-banner .masonry-banner-content .banner-content' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'content_padding_repeater',
			[
				'label'      => esc_html__( 'Padding', 'dimax' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .dimax-products-with-banner .masonry-banner-content .banner-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'title_heading_name',
			[
				'label' => esc_html__( 'Title', 'dimax' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'      => esc_html__( ' Color', 'dimax' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .dimax-products-with-banner .dimax-banner__title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .dimax-products-with-banner .dimax-banner__title',
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'dimax' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimax-products-with-banner .dimax-banner__title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'desc_heading_name',
			[
				'label' => esc_html__( 'Description', 'dimax' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'      => esc_html__( 'Color', 'dimax' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .dimax-products-with-banner .dimax-banner__description' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .dimax-products-with-banner .dimax-banner__description',
			]
		);

		$this->add_responsive_control(
			'description_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'dimax' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimax-products-with-banner .dimax-banner__description' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'btn_heading_name',
			[
				'label' => esc_html__( 'Button', 'dimax' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'btn_custom_color',
			[
				'label'      => esc_html__( 'Color', 'dimax' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .dimax-products-with-banner .dimax-banner__button a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'btn_typography',
				'selector' => '{{WRAPPER}} .dimax-products-with-banner .dimax-banner__button a',
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
			'dimax-products-with-banner',
			$settings['show_category'] != '' ? 'show-category' : '',
			$settings['show_rating'] != '' ? 'show-rating' : '',
			$settings['show_quickview'] != '' ? 'show-quickview' : '',
			$settings['show_addtocart'] != '' ? 'show-addtocart' : '',
			$settings['show_wishlist'] != '' ? 'show-wishlist' : '',
			$settings['show_badges'] != '' ? 'show-badges' : '',
			$settings['show_quickview'] == '' && $settings['show_addtocart'] == '' && $settings['show_wishlist'] == '' ? 'btn-hidden' : '',
			$settings['product_link_type'] == 'only' ? '' : 'product-link-type-all',
		];

		$this->add_render_attribute( 'wrapper', [
			'class' 			=> $classes,
			'data-nonce' 		=> wp_create_nonce( 'dimax_get_products' )
		] );

		$attr = [
			'products' 			=> $settings['products'],
			'orderby'  			=> $settings['orderby'],
			'order'    			=> $settings['order'],
			'category'    		=> $settings['product_category'],
			'tag'    			=> $settings['product_tag'],
			'product_brands'    => $settings['product_brands'],
			'limit'    			=> $settings['limit'],
		];

		if ( taxonomy_exists( 'product_author' ) ) {
			$attr['product_authors'] = $settings['product_authors'];
		}

		$results = Helper::products_shortcode( $attr );
		if ( ! $results ) {
			return;
		}

		$product_ids = $results['ids'];
		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php
				self::get_template_masonry_loop( $product_ids, 'product-masonry', $settings['show_atc_mobile'], $settings['show_featured_icons_mobile'], $settings );
			?>
		</div>
		<?php
	}

	/**
	 * Loop over products
	 *
	 * @param array $products_ids
	 */
	public static function get_template_masonry_loop( $products_ids, $template, $atc_mobile, $featured_mobile, $settings ) {
		update_meta_cache( 'post', $products_ids );
		update_object_term_cache( $products_ids, 'product' );

		$original_post = $GLOBALS['post'];

		$class_mobile = '';
		if ( $atc_mobile == 'show' ) {
			$class_mobile = 'mobile-show-atc';
		}
		if ( $featured_mobile == 'show' ) {
			$class_mobile .= ' mobile-show-featured-icons';
		}

		if( class_exists('\Razzi\Helper') && method_exists('\Razzi\Helper', 'get_option') ) {
			if ( $mobile_pl_col = intval( \Razzi\Helper::get_option( 'mobile_landscape_product_columns' ) ) ) {
				$class_mobile .= ' mobile-pl-col-' . $mobile_pl_col;
			}

			if ( $mobile_pp_col = intval( \Razzi\Helper::get_option( 'mobile_portrait_product_columns' ) ) ) {
				$class_mobile .= ' mobile-pp-col-' . $mobile_pp_col;
			}
		}

		echo '<ul class="products product-loop-layout-7 product-loop-center shortcode-element layout-masonry dimax-products-with-banner__content '. esc_attr( $class_mobile ) .'">';
		$i = 0;
		foreach ( $products_ids as $product_id ) {

			if( $i == 1 ) {
				self::get_banner_html( $settings );
			}
			$i++;

			$GLOBALS['post'] = get_post( $product_id ); // WPCS: override ok.
			setup_postdata( $GLOBALS['post'] );
			wc_get_template_part( 'content', $template );
		}

		$GLOBALS['post'] = $original_post; // WPCS: override ok.

		echo '</ul>';

		wp_reset_postdata();

	}

	public static function get_banner_html( $settings ) {
		if ( empty( $settings ) ) {
			return;
		}

		$banner_html = '';

		if( $settings['link_type'] == 'all' && $settings['banner_link']['url'] ) {
			$banner_html .= '<a class="has-link masonry-banner-content" href="'. $settings['banner_link']['url'] .'">';
		} else {
			$banner_html .= '<div class="masonry-banner-content">';
		}

		if ( $settings['banner_image']['url'] ) {
			$settings['image']      = $settings['banner_image'];

			$image = Group_Control_Image_Size::get_attachment_image_html( $settings );
			$banner_html .= $image ? sprintf('<div class="banner-image">%s</div>',$image) : '';
		}

		$banner_html .= '<span class="banner-content">';

		if ( $settings['title'] ) {
			$banner_html .= '<span class="dimax-banner__title">' . $settings['title'] . '</span>';
		}

		if ( $settings['description'] ) {
			$banner_html .= '<span class="dimax-banner__description">' . $settings['description'] . '</span>';
		}

		if ( $settings['button_text'] ) {

			$button_text = $settings['button_text'] . \Razzi\Addons\Helper::get_svg('arrow-right');

			if( $settings['link_type'] == 'only' && $settings['banner_link']['url'] ) {
				$banner_html .= sprintf( '<span class="dimax-banner__button">%s</span>', Helper::control_url( 'button' ,$settings['banner_link'], $button_text, [ 'class' => 'dimax-button button-normal' ] ) );
			} else {
				$banner_html .= sprintf( '<span class="dimax-banner__button dimax-button button-normal">%s</span>', $button_text );
			}
		}

		$banner_html .= '</span>';

		if( $settings['link_type'] == 'all' && $settings['banner_link']['url'] ) {
			$banner_html .= '</a>';
		} else {
			$banner_html .= '</div>';
		}

		echo '<li class="product has-banner"><div class="dimax-banner__masonry">' . $banner_html . '</div></li>';

	}
}