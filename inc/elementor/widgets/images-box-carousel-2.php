<?php

namespace Razzi\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;
use Razzi\Addons\Elementor\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Images Carousel widget
 */
class Images_Box_Carousel_2 extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'dimax-images-box-carousel-2';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Razzi - Images Box Carousel 2', 'dimax' );
	}

	/**
	 * Retrieve the widget circle.
	 *
	 * @return string Widget circle.
	 */
	public function get_icon() {
		return 'eicon-carousel';
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
			'dimax-frontend'
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


	/**
	 * Section Content
	 */
	protected function section_content() {
		$this->content_settings_controls();
		$this->carousel_settings_controls();
	}

	protected function content_settings_controls() {
		$this->start_controls_section(
			'section_content',
			[ 'label' => esc_html__( 'Content', 'dimax' ) ]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'image',
			[
				'label'   => esc_html__( 'Image', 'dimax' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://via.placeholder.com/170x140/f5f5f5?text=Image',
				],
			]
		);

		$repeater->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'dimax' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'This is title', 'dimax' ),
			]
		);

		$repeater->add_control(
			'desc',
			[
				'label'   => esc_html__( 'Description', 'dimax' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'This is description', 'dimax' ),
			]
		);

		$repeater->add_control(
			'link', [
				'label'         => esc_html__( 'Link', 'dimax' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'dimax' ),
				'description'   => esc_html__( 'Just works if the value of Lightbox is No', 'dimax' ),
				'show_external' => true,
				'default'       => [
					'url'         => '#',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);

		$this->add_control(
			'elements',
			[
				'label'         => esc_html__( 'Items', 'dimax' ),
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'default'       => [
					[
						'title' => esc_html__( 'This is the title', 'dimax' ),
						'image' => [
							'url' => 'https://via.placeholder.com/170x140/f5f5f5?text=Image',
						],
					],[
						'title' => esc_html__( 'This is the title', 'dimax' ),
						'image' => [
							'url' => 'https://via.placeholder.com/170x140/f5f5f5?text=Image',
						],
					],[
						'title' => esc_html__( 'This is the title', 'dimax' ),
						'image' => [
							'url' => 'https://via.placeholder.com/170x140/f5f5f5?text=Image',
						],
					],[
						'title' => esc_html__( 'This is the title', 'dimax' ),
						'image' => [
							'url' => 'https://via.placeholder.com/170x140/f5f5f5?text=Image',
						],
					],[
						'title' => esc_html__( 'This is the title', 'dimax' ),
						'image' => [
							'url' => 'https://via.placeholder.com/170x140/f5f5f5?text=Image',
						],
					],

				],
				'title_field'   => '{{{ title }}}',
				'prevent_empty' => false
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image',
				'default'   => 'full',
			]
		);

		$this->end_controls_section();
	}

	protected function carousel_settings_controls() {
		// Carousel Settings
		$this->start_controls_section(
			'section_carousel_settings',
			[ 'label' => esc_html__( 'Carousel Settings', 'dimax' ) ]
		);
		$this->add_responsive_control(
			'slidesToShow',
			[
				'label'   => esc_html__( 'Slides to show', 'dimax' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 7,
				'desktop_default' => 3,
				'tablet_default' => 3,
				'mobile_default' => 1,
				'frontend_available' => true,
			]
		);
		$this->add_responsive_control(
			'slidesToScroll',
			[
				'label'   => esc_html__( 'Slides to scroll', 'dimax' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 5,
				'desktop_default' => 3,
				'tablet_default' => 3,
				'mobile_default' => 1,
				'frontend_available' => true,
			]
		);

		$this->add_responsive_control(
			'navigation',
			[
				'label'     => esc_html__( 'Navigation', 'dimax' ),
				'type'      => Controls_Manager::SELECT,
				'options' => [
					'none'   => esc_html__( 'None', 'dimax' ),
					'arrows' => esc_html__( 'Arrows', 'dimax' ),
					'dots' 	 => esc_html__( 'Dots', 'dimax' ),
				],
				'default' => 'arrows',
			]
		);

		$this->add_control(
			'infinite',
			[
				'label'     => __( 'Infinite', 'dimax' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'dimax' ),
				'label_on'  => __( 'On', 'dimax' ),
				'return_value' => 'yes',
				'default'   => '',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'     => __( 'Autoplay', 'dimax' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'dimax' ),
				'label_on'  => __( 'On', 'dimax' ),
				'return_value' => 'yes',
				'default'   => 'yes',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label'   => __( 'Autoplay Speed (in ms)', 'dimax' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1000,
				'min'     => 100,
				'step'    => 100,
				'frontend_available' => true,
			]
		);

		$this->end_controls_section(); // End Carousel Settings
	}

	/**
	 * Section Style
	 */
	protected function section_style() {
		$this->section_content_style();
		$this->section_carousel_style();
	}

	/**
	 * Element in Tab Style
	 *
	 * Title
	 */
	protected function section_content_style() {
		// Content
		$this->start_controls_section(
			'section_content_style',
			[
				'label' => __( 'Content', 'dimax' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'img_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'dimax' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'unit' => 'px',
				],
				'range'     => [
					'px' => [
						'min' => -500,
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimax-images-box-carousel-2 .image-item' => 'padding-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => __( 'Padding', 'dimax' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .dimax-images-box-carousel-2 .content-summary' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'content_background_color',
			[
				'label'     => __( 'Background Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-images-box-carousel-2 .content-summary' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'img_border_ra',
			[
				'label'     => esc_html__( 'Border Radius', 'dimax' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .dimax-images-box-carousel-2 .content-img img' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'hover_image',
			[
				'label'        => __( 'Hover Image Animation', 'dimax' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'On', 'dimax' ),
				'label_off'    => __( 'Off', 'dimax' ),
				'return_value' => 'on',
				'default'      => 'on',
				'prefix_class' => 'hover-image-',
			]
		);

		// Title
		$this->add_control(
			'content_style_title',
			[
				'label'     => esc_html__( 'Title', 'dimax' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[
				'label'     => esc_html__( 'Spacing Top', 'dimax' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimax-images-box-carousel-2 .content-summary' => 'padding-top: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .dimax-images-box-carousel-2 .content-title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => __( 'Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-images-box-carousel-2 .content-title' => 'color: {{VALUE}};',
				],
			]
		);

		//Desc
		$this->add_control(
			'desc_style',
			[
				'label'     => esc_html__( 'Description', 'dimax' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'desc_typography',
				'selector' => '{{WRAPPER}} .dimax-images-box-carousel-2 .content-desc',
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label'     => __( 'Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-images-box-carousel-2 .content-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function section_carousel_style() {
		$this->start_controls_section(
			'section_carousel_style',
			[
				'label' => esc_html__( 'Carousel Settings', 'dimax' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'arrows_style_divider',
			[
				'label' => esc_html__( 'Arrows', 'dimax' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		// Arrows
		$this->add_control(
			'arrows_style',
			[
				'label'        => __( 'Options', 'dimax' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'dimax' ),
				'label_on'     => __( 'Custom', 'dimax' ),
				'return_value' => 'yes',
			]
		);

		$this->start_popover();

		$this->add_responsive_control(
			'sliders_arrows_size',
			[
				'label'     => __( 'Size', 'dimax' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimax-images-box-carousel-2 .rz-swiper-button' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'sliders_arrows_width',
			[
				'label'     => __( 'Width', 'dimax' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimax-images-box-carousel-2 .rz-swiper-button' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'sliders_arrows_height',
			[
				'label'     => __( 'Height', 'dimax' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimax-images-box-carousel-2              .rz-swiper-button' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'arrows_spacing',
			[
				'label'      => esc_html__( 'Horizontal Position', 'dimax' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => -100,
						'max' => 200,
					],
				],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .dimax-images-box-carousel-2 .rz-swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .dimax-images-box-carousel-2 .rz-swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'arrows_vertical_position',
			[
				'label'      => esc_html__( 'Vertical Position', 'dimax' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => - 100,
						'max' => 200,
					],
				],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .dimax-images-box-carousel-2 .rz-swiper-button' => 'top: {{SIZE}}{{UNIT}};transform:none;',
				],
			]
		);

		$this->end_popover();

		$this->start_controls_tabs( 'sliders_normal_settings' );

		$this->start_controls_tab( 'sliders_normal', [ 'label' => esc_html__( 'Normal', 'dimax' ) ] );

		$this->add_control(
			'sliders_arrow_color',
			[
				'label'     => esc_html__( 'Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-images-box-carousel-2 .rz-swiper-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'sliders_arrow_bgcolor',
			[
				'label'     => esc_html__( 'Background Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-images-box-carousel-2 .rz-swiper-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'sliders_hover', [ 'label' => esc_html__( 'Hover', 'dimax' ) ] );

		$this->add_control(
			'sliders_arrow_hover_color',
			[
				'label'     => esc_html__( 'Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-images-box-carousel-2 .rz-swiper-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'sliders_arrow_hover_bgcolor',
			[
				'label'     => esc_html__( 'Background Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-images-box-carousel-2 .rz-swiper-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		// Dots
		$this->add_control(
			'dots_style_divider',
			[
				'label' => esc_html__( 'Dots', 'dimax' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'dots_style',
			[
				'label'        => __( 'Options', 'dimax' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'dimax' ),
				'label_on'     => __( 'Custom', 'dimax' ),
				'return_value' => 'yes',
			]
		);

		$this->start_popover();

		$this->add_responsive_control(
			'sliders_dots_gap',
			[
				'label'     => __( 'Gap', 'dimax' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimax-images-box-carousel-2 .swiper-pagination-bullet' => 'margin: 0 {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'sliders_dots_size',
			[
				'label'     => __( 'Size', 'dimax' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimax-images-box-carousel-2 .swiper-pagination-bullet:before' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'sliders_dots_offset_ver',
			[
				'label'     => esc_html__( 'Spacing Top', 'dimax' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimax-images-box-carousel-2 .swiper-pagination' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_popover();

		$this->start_controls_tabs( 'sliders_dots_normal_settings' );

		$this->start_controls_tab( 'sliders_dots_normal', [ 'label' => esc_html__( 'Normal', 'dimax' ) ] );

		$this->add_control(
			'sliders_dots_bgcolor',
			[
				'label'     => esc_html__( 'Background Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-images-box-carousel-2 .swiper-pagination-bullet:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'sliders_dots_active', [ 'label' => esc_html__( 'Active', 'dimax' ) ] );

		$this->add_control(
			'sliders_dots_ac_bgcolor',
			[
				'label'     => esc_html__( 'Background Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-images-box-carousel-2 .swiper-pagination-bullet-active:before, {{WRAPPER}} .dimax-images-box-carousel-2 .swiper-pagination-bullet:hover:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Render circle box widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$nav        = $settings['navigation'];
		$nav_tablet = empty( $settings['navigation_tablet'] ) ? $nav : $settings['navigation_tablet'];
		$nav_mobile = empty( $settings['navigation_mobile'] ) ? $nav : $settings['navigation_mobile'];

		$classes = [
			'dimax-images-box-carousel-2',
			'dimax-swiper-carousel-elementor',
			'navigation-' . $nav,
			'navigation-tablet-' . $nav_tablet,
			'navigation-mobile-' . $nav_mobile,
		];

		$this->add_render_attribute( 'wrapper', 'class', $classes );
		$this->add_render_attribute( 'icon', 'class', 'dimax-products-slider__icon' );

		$output =  array();

		$els = $settings['elements'];
		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<div class="swiper-container">
				<div class="dimax-images-box-carousel-2__inner swiper-wrapper">
		<?php
				if ( ! empty ( $els ) ) {
					foreach ( $els as $index => $item ) {
						$settings['image']      	= $item['image'];

						$image = Group_Control_Image_Size::get_attachment_image_html( $settings );
						$image = $image ? sprintf('<div class="content-img">%s</div>',$image) : '';
						$key_img = 'image_' . $index;

						$btn_full = $item['link']['url'] ? Helper::control_url( $key_img, $item['link'], '', [ 'class' => 'full-box-button' ] ) : '';
						$title = $item['title'] ? sprintf('<div class="content-title">%s</div>',$item['title']) : '';
						$desc = $item['desc'] ? sprintf('<div class="content-desc">%s</div>',$item['desc']) : '';

						$output_content  = $image;
						$output_content .= '<div class="content-summary">';
						$output_content .= $title;
						$output_content .= $desc;
						$output_content .= '</div>';
						$output_content .= $btn_full;

						echo '<div class="elementor-repeater-item-' . esc_attr( $item['_id'] ) . ' image-item swiper-slide">';
							printf( '%s', $output_content );
						echo '</div>';
					}
				}

		?>
				</div>
				<div class="swiper-pagination"></div>
			</div>
			<?php
				echo \Razzi\Addons\Helper::get_svg('chevron-left','rz-swiper-button-prev rz-swiper-button');
				echo \Razzi\Addons\Helper::get_svg('chevron-right', 'rz-swiper-button-next rz-swiper-button');
			?>
		</div>
		<?php
	}
}