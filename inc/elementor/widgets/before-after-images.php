<?php

namespace Dimax\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Before After Images widget
 */
class Before_After_Images extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'dimax-before-after-images';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Dimax - Image Comparison', 'dimax' );
	}

	/**
	 * Retrieve the widget circle.
	 *
	 * @return string Widget circle.
	 */
	public function get_icon() {
		return 'eicon-image-before-after';
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
			'image-slide',
			'eventmove',
			'dimax-frontend'
		];
	}

	public function get_style_depends() {
		return [
			'image-slide-css'
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
		$this->start_controls_section(
			'section_content',
			[ 'label' => esc_html__( 'Content', 'dimax' ) ]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'be_image',
			[
				'label'   => esc_html__( 'Before Image', 'dimax' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://via.placeholder.com/970x530/f1f1f1?text=Image',
				],
			]
		);

		$repeater->add_control(
			'af_image',
			[
				'label'   => esc_html__( 'After Image', 'dimax' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://via.placeholder.com/970x530/f1f1f1?text=Image',
				],
			]
		);

		$this->add_control(
			'elements',
			[
				'label'         => '',
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'default'       => [
					[

					],[

					]
				],
				'prevent_empty' => false
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image',
				'default'   => 'full',
				'separator' => 'none',
			]
		);


		$this->end_controls_section();

		$this->section_content_option();
	}

	protected function section_content_option() {
		$this->start_controls_section(
			'section_slider_options',
			[
				'label' => esc_html__( 'Slider Options', 'dimax' ),
				'type'  => Controls_Manager::SECTION,
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
				'label'   => esc_html__( 'Autoplay', 'dimax' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'delay',
			[
				'label'     => esc_html__( 'Delay', 'dimax' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 3000,
				'description' => esc_html__('Delay between transitions (in ms). If this parameter is not specified, auto play will be disabled', 'dimax'),
				'conditions' => [
					'terms' => [
						[
							'name'  => 'autoplay',
							'value' => 'yes',
						]
					],
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label'     => esc_html__( 'Autoplay Speed', 'dimax' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 1000,
				'frontend_available' => true,
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Section Style
	 */

	protected function section_style() {
		// Content
		$this->start_controls_section(
			'section_content_style',
			[
				'label' => __( 'Content', 'dimax' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => esc_html__( 'Padding', 'dimax' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => [],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .dimax-before-after-images' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'badges_style',
			[
				'label' => esc_html__( 'Badges', 'dimax' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'badges_spacing',
			[
				'label'     => esc_html__( 'Spacing Vertical', 'dimax' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimax-before-after-images .imageslide-label' => 'top: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'badges_typography',
				'selector' => '{{WRAPPER}} .dimax-before-after-images .imageslide-label',
			]
		);

		$this->add_control(
			'badges_color',
			[
				'label'     => __( 'Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-before-after-images .imageslide-label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badges_bgcolor',
			[
				'label'     => __( 'Background Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-before-after-images .imageslide-label' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'badges_padding',
			[
				'label'      => esc_html__( 'Padding', 'dimax' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => [],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .dimax-before-after-images .imageslide-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'line_control_style',
			[
				'label' => esc_html__( 'Line Control', 'dimax' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'line_control_color',
			[
				'label'     => __( 'Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-before-after-images .imageslide-container' => '--rz-image-slide-bg-control: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'line_control_icon_color',
			[
				'label'     => __( 'Icon Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-before-after-images .imageslide-handle .dimax-icon' => '--rz-stroke-svg-dark: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->section_style_carousel();
	}

	protected function section_style_carousel() {
		// Arrows
		$this->start_controls_section(
			'section_style_arrows',
			[
				'label' => esc_html__( 'Slider Option', 'dimax' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Arrows
		$this->add_control(
			'arrow_style_heading',
			[
				'label' => esc_html__( 'Arrows', 'dimax' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

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
					'{{WRAPPER}} .dimax-before-after-images .rz-swiper-button' => 'font-size: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .dimax-before-after-images .rz-swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .dimax-before-after-images .rz-swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .dimax-before-after-images .rz-swiper-button' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .dimax-before-after-images .rz-swiper-button' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .dimax-before-after-images .rz-swiper-button:hover' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .dimax-before-after-images .rz-swiper-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		// Dots
		$this->add_control(
			'dots_style_heading',
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
					'{{WRAPPER}} .dimax-before-after-images .swiper-pagination-bullet' => 'margin: 0 {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .dimax-before-after-images .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
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
						'min' => -100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimax-before-after-images .swiper-pagination' => 'margin-top: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .dimax-before-after-images .swiper-pagination-bullet:before' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .dimax-before-after-images .swiper-pagination-bullet-active:before, {{WRAPPER}} .dimax-before-after-images .swiper-pagination-bullet:hover:before' => 'background-color: {{VALUE}};',
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
			'dimax-before-after-images swiper-container',
			'dimax-swiper-carousel-elementor',
			'navigation-' . $nav,
			'navigation-tablet-' . $nav_tablet,
			'navigation-mobile-' . $nav_mobile,
		];

		$this->add_render_attribute( 'wrapper', 'class', $classes );

		$output  = array();

		$els = $settings['elements'];

		$overlay = sprintf('<div class="imageslide-label imageslide-before-label">'.esc_html__('Before', 'dimax').'</div>
							<div class="imageslide-label imageslide-after-label">'.esc_html__('After', 'dimax').'</div>');

		$handler = '<div class="imageslide-handle">'.\Dimax\Addons\Helper::get_svg('move-left-right', 'dimax-icon', 'widget').'</div>';

		if ( ! empty ( $els ) ) {
			foreach ( $els as $index => $item ) {

				$be_image = $af_image ='';
				if ($item['be_image']) {
					$settings['image']      = $item['be_image'];
					$be_image = Group_Control_Image_Size::get_attachment_image_html( $settings );
				}

				if ($item['af_image']) {
					$settings['image']      = $item['af_image'];
					$af_image = Group_Control_Image_Size::get_attachment_image_html( $settings );
				}

				$image =  sprintf('<div class="box-thumbnail swiper-slide">%s%s%s%s</div>',$be_image, $af_image,$overlay, $handler);

				$output[] = $image;
			}
		}

		$output_arrow = \Dimax\Addons\Helper::get_svg('chevron-left', 'rz-swiper-button-prev rz-swiper-button');
		$output_arrow .= \Dimax\Addons\Helper::get_svg('chevron-right', 'rz-swiper-button-next rz-swiper-button');

		echo sprintf(
			'<div %s>
				<div class="dimax-before-after-images__inner swiper-wrapper"> %s</div>  %s<div class="swiper-pagination"></div>
			</div>',
			$this->get_render_attribute_string( 'wrapper' ),
			implode('', $output),
			$output_arrow
		);
	}
}