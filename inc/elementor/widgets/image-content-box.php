<?php

namespace Razzi\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Controls_Stack;
use Razzi\Addons\Elementor\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Banner Box widget
 */
class Image_Content_Box extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'dimax-image-content-box';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Razzi - Image Content Box', 'dimax' );
	}

	/**
	 * Retrieve the widget circle.
	 *
	 * @return string Widget circle.
	 */
	public function get_icon() {
		return 'eicon-banner';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'dimax' ];
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
			[ 'label' => esc_html__( 'Image Content Box', 'dimax' ) ]
		);

		$this->add_control(
			'image',
			[
				'label'   => esc_html__( 'Image', 'dimax' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://via.placeholder.com/1056x521/f1f1f1?text=1056x521',
				],
				'selectors' => [
					'{{WRAPPER}} .dimax-image-content-box__bg' => 'background-image: url("{{URL}}");',
				],
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label'       => esc_html__( 'Sub Title', 'dimax' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'This is sub title', 'dimax' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'dimax' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'This is title', 'dimax' ),
			]
		);

		$this->add_control(
			'desc',
			[
				'label'       => esc_html__( 'Desc', 'dimax' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'This is desc', 'dimax' ),
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'       => esc_html__( 'Button Text', 'dimax' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Button Text', 'dimax' ),
			]
		);

		$this->add_control(
			'show_default_icon',
			[
				'label'     => esc_html__( 'Show Button Icon', 'dimax' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'dimax' ),
				'label_on'  => __( 'On', 'dimax' ),
				'return_value' => 'yes',
				'default'   => 'yes'
			]
		);

		$this->add_control(
			'link', [
				'label'         => esc_html__( 'Button Link', 'dimax' ),
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

		$this->end_controls_section();
	}

	/**
	 * Section Style
	 */

	protected function section_style() {
		$this->section_style_general();
		$this->section_style_content();
		$this->section_style_image();
	}

	protected function section_style_general() {
		// General
		$this->start_controls_section(
			'section_general_style',
			[
				'label' => __( 'Image Content Box', 'dimax' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'content_bg_color',
			[
				'label'     => __( 'Background Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-widget-container' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function section_style_content() {
		// Content
		$this->start_controls_section(
			'section_content_style',
			[
				'label' => __( 'Content', 'dimax' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'content_width',
			[
				'label'     => esc_html__( 'Width', 'dimax' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .dimax-image-content-box__left' => 'flex: 0 0 {{SIZE}}%; max-width: {{SIZE}}%',
					'{{WRAPPER}} .dimax-image-content-box__right' => 'flex: 0 0 calc(100% - {{SIZE}}%); max-width: calc(100% - {{SIZE}}%)',
					'{{WRAPPER}} .dimax-image-position-left .dimax-image-content-box__bg' => 'width: calc(100% - {{SIZE}}%);',
				],
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
					'{{WRAPPER}} .dimax-image-content-box__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
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
				'default'     => '',
				'selectors'   => [
					'{{WRAPPER}} .dimax-image-content-box__content' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'content_style_subtitle',
			[
				'label' => __( 'Subtitle', 'dimax' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'subtitle_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'dimax' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimax-image-content-box .subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'subtitle_typography',
				'selector' => '{{WRAPPER}} .dimax-image-content-box .subtitle',
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label'     => __( 'Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-image-content-box .subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'content_style_title',
			[
				'label' => __( 'Title', 'dimax' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
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
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimax-image-content-box .banner-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .dimax-image-content-box .banner-title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => __( 'Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-image-content-box .banner-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'content_style_desc',
			[
				'label' => __( 'Description', 'dimax' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'desc_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'dimax' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimax-image-content-box .banner-desc' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'desc_typography',
				'selector' => '{{WRAPPER}} .dimax-image-content-box .banner-desc',
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label'     => __( 'Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-image-content-box .banner-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'content_style_button',
			[
				'label' => __( 'Button', 'dimax' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'btn_typography',
				'selector' => '{{WRAPPER}} .dimax-image-content-box .button-text',
			]
		);

		$this->add_control(
			'btn_color',
			[
				'label'     => __( 'Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-image-content-box .button-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_bg_color',
			[
				'label'     => __( 'Background Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-image-content-box .button-text' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function section_style_image() {
		// Image
		$this->start_controls_section(
			'section_image_style',
			[
				'label' => __( 'Image', 'dimax' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'image_position',
			[
				'label'       => esc_html__( 'Text Align', 'dimax' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'left'   => [
						'title' => esc_html__( 'Left', 'dimax' ),
						'icon'  => 'eicon-text-align-left',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'dimax' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'     => 'right',
			]
		);

		$this->add_responsive_control(
			'image_top_spacing',
			[
				'label'     => esc_html__( 'Top Spacing', 'dimax' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimax-image-content-box .dimax-image-content-box__bg' => 'transform: translateY({{SIZE}}{{UNIT}})',
					'{{WRAPPER}} .dimax-image-content-box' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'image_hide_mobile',
			[
				'label'     => esc_html__( 'Hide on Mobile', 'dimax' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'dimax' ),
				'label_on'  => __( 'On', 'dimax' ),
				'return_value' => 'yes',
				'default'   => 'yes'
			]
		);

		$this->add_responsive_control(
			'image_height',
			[
				'label'     => esc_html__( 'Height', 'dimax' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimax-image-content-box .dimax-image-content-box__bg' => 'height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'background_position',
			[
				'label'     => esc_html__( 'Background Position', 'dimax' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''              => esc_html__( 'Default', 'dimax' ),
					'left top'      => esc_html__( 'Left Top', 'dimax' ),
					'left center'   => esc_html__( 'Left Center', 'dimax' ),
					'left bottom'   => esc_html__( 'Left Bottom', 'dimax' ),
					'right top'     => esc_html__( 'Right Top', 'dimax' ),
					'right center'  => esc_html__( 'Right Center', 'dimax' ),
					'right bottom'  => esc_html__( 'Right Bottom', 'dimax' ),
					'center top'    => esc_html__( 'Center Top', 'dimax' ),
					'center center' => esc_html__( 'Center Center', 'dimax' ),
					'center bottom' => esc_html__( 'Center Bottom', 'dimax' ),
					'initial' 		=> esc_html__( 'Custom', 'dimax' ),
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-image-content-box__bg' => 'background-position: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'background_position_xy',
			[
				'label'              => esc_html__( 'Custom Background Position', 'dimax' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'allowed_dimensions' => [ 'top', 'left' ],
				'size_units'         => [ 'px', '%' ],
				'default'            => [ ],
				'selectors'          => [
					'{{WRAPPER}} .dimax-image-content-box__bg' => 'background-position: {{LEFT}}{{UNIT}} {{TOP}}{{UNIT}};',
				],
				'condition' => [
					'background_position' => [ 'initial' ],
				],
				'required' => true,
				'device_args' => [
					Controls_Stack::RESPONSIVE_TABLET => [
						'condition' => [
							'background_position_tablet' => [ 'initial' ],
						],
					],
					Controls_Stack::RESPONSIVE_MOBILE => [
						'condition' => [
							'background_position_mobile' => [ 'initial' ],
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'background_repeat',
			[
				'label'     => esc_html__( 'Background Repeat', 'dimax' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'no-repeat',
				'options'   => [
					'no-repeat' => esc_html__( 'No-repeat', 'dimax' ),
					'repeat' 	=> esc_html__( 'Repeat', 'dimax' ),
					'repeat-x'  => esc_html__( 'Repeat-x', 'dimax' ),
					'repeat-y'  => esc_html__( 'Repeat-y', 'dimax' ),
				],
				'selectors' => [
					'{{WRAPPER}} .dimax-image-content-box__bg' => 'background-repeat: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'background_size',
			[
				'label'     => esc_html__( 'Background Size', 'dimax' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'cover',
				'options'   => [
					'cover'   => esc_html__( 'Cover', 'dimax' ),
					'contain' => esc_html__( 'Contain', 'dimax' ),
					'auto'    => esc_html__( 'Auto', 'dimax' ),
				],
				'selectors' => [
					'{{WRAPPER}} .dimax-image-content-box__bg' => 'background-size: {{VALUE}}',
				],
			]
		);



		$this->end_controls_section();
	}

	/**
	 * Render circle box widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$classes = [
			'dimax-image-content-box container',
			$settings['image_position'] == 'left' ? 'dimax-image-position-left' : ''
		];

		$this->add_render_attribute( 'wrapper', 'class', $classes );

		$link_icon = $settings['show_default_icon'] ? \Razzi\Addons\Helper::get_svg('arrow-right', 'dimax-icon') : '';

		$button_text = $settings['button_text'] ? sprintf('%s%s',$settings['button_text'], $link_icon) : '';

		$button_text = $settings['link']['url'] ? Helper::control_url( 'btn', $settings['link'], $button_text, [ 'class' => 'button-text dimax-button' ] ) : sprintf( '<div class="button-link">%s</div>', $button_text );

		$subtitle = $settings['subtitle'] ? sprintf('<div class="subtitle">%s</div>',$settings['subtitle']) : '';
		$title = $settings['title'] ? sprintf('<h2 class="banner-title">%s</h2>',$settings['title']) : '';
		$desc = $settings['desc'] ? sprintf('<div class="banner-desc">%s</div>',$settings['desc']) : '';

		echo sprintf(
			'<div %s>
				<div class="row-flex">
					<div class="col-flex dimax-image-content-box__left col-flex-md-5 col-flex-sm-6 col-flex-xs-12">
						<div class="dimax-image-content-box__content">
							 %s %s %s %s
						</div>
					</div>
					<div class="col-flex dimax-image-content-box__right col-flex-md-7 col-flex-sm-6 col-flex-xs-12 %s">
						<div class="dimax-image-content-box__bg"></div>
					</div>
				</div>
			</div>',
			$this->get_render_attribute_string( 'wrapper' ),
			$subtitle,$title, $desc, $button_text,
			$settings['image_hide_mobile'] == 'yes' ? 'hidden-xs' : ''
		);
	}
}