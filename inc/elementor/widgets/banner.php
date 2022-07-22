<?php

namespace Dimax\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Widget_Base;
use Elementor\Controls_Stack;
use Dimax\Addons\Elementor\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Banner Small widget
 */
class Banner extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'dimax-banner';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Dimax - Banner', 'dimax' );
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

	public function get_script_depends() {
		return [
			'dimax-coundown',
			'dimax-frontend',
			'dimax-elementor'
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

	protected function section_content() {
		$this->start_controls_section(
			'section_content',
			[ 'label' => esc_html__( 'Banner', 'dimax' ) ]
		);

		$this->add_control(
			'image',
			[
				'label'   => esc_html__( 'Image', 'dimax' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://via.placeholder.com/1056x521/f1f1f1?text=Banner Image',
				],
			]
		);

		$this->add_control(
			'due_date',
			[
				'label'   => esc_html__( 'CountDown', 'dimax' ),
				'type'    => Controls_Manager::DATE_TIME,
				'default' => '',
			]
		);

		$this->add_control(
			'sub_title',
			[
				'label'   => esc_html__( 'Sub Title', 'dimax' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => '',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title',
			[
				'label'   => esc_html__( 'Title', 'dimax' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'This is title', 'dimax' ),
			]
		);

		$this->add_control(
			'description',
			[
				'label'   => esc_html__( 'Description', 'dimax' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => '',
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'   => esc_html__( 'Button text', 'dimax' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Button Text', 'dimax' ),
			]
		);

		$this->add_control(
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
			'button_text_2',
			[
				'label'   => esc_html__( 'Button text 2', 'dimax' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
			]
		);

		$this->add_control(
			'link_2', [
				'label'         => esc_html__( 'Link 2', 'dimax' ),
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
			'show_default_icon',
			[
				'label'        => esc_html__( 'Show Button Icon', 'dimax' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => __( 'Off', 'dimax' ),
				'label_on'     => __( 'On', 'dimax' ),
				'return_value' => 'yes',
				'default'      => 'yes'
			]
		);

		$this->add_control(
			'text_box',
			[
				'label'       => esc_html__( 'Box Sale Before Text', 'dimax' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your text', 'dimax' ),
				'label_block' => true,
				'default'     => '',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'price_box',
			[
				'label'       => esc_html__( 'Box Sale Text', 'dimax' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your text', 'dimax' ),
				'label_block' => true,
				'default'     => '',
			]
		);

		$this->add_control(
			'unit_box',
			[
				'label'       => esc_html__( 'Box Sale Unit', 'dimax' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your text', 'dimax' ),
				'label_block' => true,
				'default'     => '',
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

	// Tab Style
	protected function section_style() {
		$this->section_style_banner();
		$this->section_style_content();
		$this->section_style_sale();
	}

	protected function section_style_banner() {
		// Banner
		$this->start_controls_section(
			'section_style_banner',
			[
				'label' => esc_html__( 'Banner', 'dimax' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label'     => esc_html__( 'Height', 'dimax' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [],
				'range'     => [
					'px' => [
						'min' => 100,
						'max' => 600,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimax-banner-content' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'banner_padding',
			[
				'label'      => esc_html__( 'Padding', 'dimax' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => [],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .dimax-banner-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'banner_horizontal_position',
			[
				'label'        => esc_html__( 'Horizontal Position', 'dimax' ),
				'type'         => Controls_Manager::CHOOSE,
				'label_block'  => false,
				'default'      => 'left',
				'options'      => [
					'left'   => [
						'title' => esc_html__( 'Left', 'dimax' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'dimax' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'dimax' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'prefix_class' => 'dimax--h-position-',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'banner_vertical_position',
			[
				'label'        => esc_html__( 'Vertical Position', 'dimax' ),
				'type'         => Controls_Manager::CHOOSE,
				'label_block'  => false,
				'default'      => 'middle',
				'options'      => [
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
				'prefix_class' => 'dimax--v-position-',
			]
		);

		$this->add_control(
			'banner_text_align',
			[
				'label'       => esc_html__( 'Text Align', 'dimax' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					''       => [
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
					'{{WRAPPER}} .dimax-banner-content-inner' => 'text-align: {{VALUE}}',
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
					'{{WRAPPER}} .dimax-banner__featured-image' => 'background-position: {{VALUE}};',
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
					'{{WRAPPER}} .dimax-banner__featured-image' => 'background-position: {{LEFT}}{{UNIT}} {{TOP}}{{UNIT}};',
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
					'{{WRAPPER}} .dimax-banner__featured-image' => 'background-repeat: {{VALUE}}',
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
					'{{WRAPPER}} .dimax-banner__featured-image' => 'background-size: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'background_overlay',
			[
				'label'      => esc_html__( 'Background Overlay', 'dimax' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .dimax-banner__featured-image::before' => 'background-color: {{VALUE}}',
				]
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
			'content_spacing',
			[
				'label'      => esc_html__( 'Padding', 'dimax' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => [],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .dimax-banner-content-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'content_bg',
			[
				'label'     => __( 'Background Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-banner-content-inner' => 'background-color: {{VALUE}};',
				],
			]
		);

		// sub title
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
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimax-banner-content__sub-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'subtitle_typography',
				'selector' => '{{WRAPPER}} .dimax-banner-content__sub-title',
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label'     => __( 'Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-banner-content__sub-title' => 'color: {{VALUE}};',
				],
			]
		);

		// title
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
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimax-banner-content__title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .dimax-banner-content__title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => __( 'Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-banner-content__title' => 'color: {{VALUE}};',
				],
			]
		);

		// Description
		$this->add_control(
			'content_style_des',
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
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimax-banner-content__description' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'desc_typography',
				'selector' => '{{WRAPPER}} .dimax-banner-content__description',
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label'     => __( 'Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-banner-content__description' => 'color: {{VALUE}};',
				],
			]
		);

		// button
		$this->add_control(
			'content_style_button',
			[
				'label' => __( 'Button', 'dimax' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'button_style',
			[
				'label'      => esc_html__( 'Button Style', 'dimax' ),
				'type'       => Controls_Manager::SELECT,
				'options'    => [
					'style_1' => esc_html__( 'Style 1', 'dimax' ),
					'style_2'  => esc_html__( 'Style 2', 'dimax' ),
				],
				'default'    => 'style_1',
			]
		);

		$this->add_responsive_control(
			'btn_padding',
			[
				'label'      => esc_html__( 'Padding', 'dimax' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => [],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .dimax-banner-content__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'btn_spacing',
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
					'{{WRAPPER}} .dimax-banner__button-2' => 'margin-left: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'btn_typography',
				'selector' => '{{WRAPPER}} .dimax-banner-content__button',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'btn_border',
				'label' => __( 'Border', 'dimax' ),
				'selector' => '{{WRAPPER}} .dimax-banner-content__button.button-normal',
				'conditions' => [
					'terms' => [
						[
						'name' => 'button_style',
						'value' => 'style_1',
						],
					],
				],
			]
		);

		$this->add_control(
			'btn_bg_color',
			[
				'label'     => __( 'background Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-banner-content__button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_color',
			[
				'label'     => __( 'Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-banner-content__button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'content_style_button_hover',
			[
				'label' => __( 'Button Hover', 'dimax' ),
				'type'      => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'btn_bg_color_hover',
			[
				'label'     => __( 'background Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-banner-content__button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_color_hover',
			[
				'label'     => __( 'Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-banner-content__button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'section_style_countdown',
			[
				'label' => __( 'CountDown', 'dimax' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'countdown_spacing',
			[
				'label'     => esc_html__( 'Spacing Bottom', 'dimax' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 250,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimax-banner .dimax-banner-content__countdown' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'countdown_color',
			[
				'label'     => __( 'Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-banner .timer .digits' => 'color: {{VALUE}};',
					'{{WRAPPER}} .dimax-banner .timer .divider' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function section_style_sale() {
		$this->start_controls_section(
			'section_style_sale',
			[
				'label' => __( 'Sale', 'dimax' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Before Text', 'dimax' ),
				'name'     => 'regular_typography',
				'selector' => '{{WRAPPER}} .dimax-banner-content__sale--text',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label'    => esc_html__( 'Text', 'dimax' ),
				'name'     => 'sale_price_typography',
				'selector' => '{{WRAPPER}} .dimax-banner-content__sale--number',
			]
		);

		$this->add_control(
			'sale_color',
			[
				'label'     => esc_html__( 'Text Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dimax-banner-content__sale' => 'color: {{VALUE}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'sale_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dimax-banner-content__sale' => 'background-color: {{VALUE}}',

				],
			]
		);

		$this->add_responsive_control(
			'price_box_position_top',
			[
				'label'      => esc_html__( 'Spacing Top', 'dimax' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'max' => 150,
						'min' => 0,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .dimax-banner-content__sale' => 'top: {{SIZE}}{{UNIT}}',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'price_box_position_right',
			[
				'label'      => esc_html__( 'Spacing Right', 'dimax' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'max' => 150,
						'min' => 0,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .dimax-banner-content__sale' => 'right: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'price_box_width',
			[
				'label'      => esc_html__( 'Width (px)', 'dimax' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'max' => 250,
						'min' => 50,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .dimax-banner-content__sale' => 'width: {{SIZE}}{{UNIT}}',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'price_box_height',
			[
				'label'      => esc_html__( 'Height (px)', 'dimax' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'max' => 250,
						'min' => 50,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .dimax-banner-content__sale' => 'height: {{SIZE}}{{UNIT}}',
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
			'dimax-banner',
		];

		$this->add_render_attribute( 'wrapper', 'class', $classes );

		$link_icon = $settings['show_default_icon'] ? \Dimax\Addons\Helper::get_svg( 'arrow-right', 'dimax-icon' ) : '';

		$button_text = $settings['button_text'] ? sprintf('%s%s',$settings['button_text'], $link_icon) : '';

		$button_text_2 = $settings['button_text_2'] ? sprintf('%s%s',$settings['button_text_2'], $link_icon) : '';

		$btn_full = '';
		if ( $settings['link']['url'] ) :

			$button_class = $settings['button_style'] == 'style_2' ? 'dimax-banner-content__button dimax-button--underlined' : 'dimax-banner-content__button dimax-button button-normal';

			$btn_full = $settings['link_type'] == 'all' ? Helper::control_url( 'btn_full', $settings['link'], '', [ 'class' => 'dimax-banner-content__button-link' ] ) : '';

			$button_text = ! empty($button_text  ) ? Helper::control_url( 'btn', $settings['link'], $button_text, [ 'class' => $button_class ] ) : '';
		endif;

		//btn-2
		if ( $settings['link_2']['url'] ) :

			$button_class = $settings['button_style'] == 'style_2' ? 'dimax-banner-content__button dimax-banner__button-2 dimax-button--underlined' : 'dimax-banner-content__button dimax-banner__button-2 dimax-button button-normal';

			$btn_full = $settings['link_type'] == 'all' ? Helper::control_url( 'btn_full', $settings['link_2'], '', [ 'class' => 'dimax-banner-content__button-link' ] ) : '';

			$button_text_2 = ! empty($button_text_2  ) ? Helper::control_url( 'btn', $settings['link_2'], $button_text_2, [ 'class' => $button_class ] ) : '';
		endif;

		$second = 0;
		if ( $settings['due_date'] ) {
			$second_current  = strtotime( current_time( 'Y/m/d H:i:s' ) );
			$second_discount = strtotime( $this->get_settings( 'due_date' ) );

			if ( $second_discount > $second_current ) {
				$second = $second_discount - $second_current;
			}

			$second = apply_filters( 'dimax_countdown_shortcode_second', $second );
		}

		$dataText = \Dimax\Addons\Helper::get_countdown_texts();

		$this->add_render_attribute( 'countdown', 'data-expire', [$second] );
		$this->add_render_attribute( 'countdown', 'data-text', wp_json_encode( $dataText ) );

		$countdown = $settings['due_date'] ? sprintf( '<div class="dimax-banner-content__countdown dimax-countdown" %s></div>', $this->get_render_attribute_string( 'countdown' ) ) : '';
		$sub_title = $settings['sub_title'] ? sprintf( '<h5 class="dimax-banner-content__sub-title">%s</h5>', $settings['sub_title'] ) : '';
		$title = $settings['title'] ? sprintf( '<h4 class="dimax-banner-content__title">%s</h4>', $settings['title'] ) : '';
		$description = $settings['description'] ? sprintf( '<div class="dimax-banner-content__description">%s</div>', $settings['description'] ) : '';

		// Sale
		$text_sale = $settings['text_box'] ? sprintf( '<div class="dimax-banner-content__sale--text">%s</div>', $settings['text_box'] ) : '';
		$unit_sale = $settings['unit_box'] ? sprintf( '<span class="dimax-banner-content__sale--unit">%s</span>', $settings['unit_box'] ) : '';
		$num_sale  = $settings['price_box'] ? sprintf( '<div class="dimax-banner-content__sale--number">%s%s</div>', $settings['price_box'], $unit_sale ) : '';

		$html_sale = $text_sale == '' && $num_sale == '' ? '' : sprintf( '<div class="dimax-banner-content__sale">%s %s</div>', $text_sale, $num_sale );

		$bg_image = $settings['image'];
		$output = '';
		if( $bg_image && isset($bg_image['url']) ) {
			$image_bg = $bg_image['url'];
			if (function_exists('jetpack_photon_url')) {
				$image_bg = jetpack_photon_url($image_bg);
			}
			$output .= sprintf('<div class="dimax-banner__featured-image" style="background-image: url(%s)"></div>', esc_url( $image_bg ));
		}

		$output .= '<div class="dimax-banner-content">';
		$output .= '<div class="dimax-banner-content-inner">';
		$output .= $countdown;
		$output .= $sub_title;
		$output .= $title;
		$output .= $description;
		$output .= '<div class="dimax-banner-button-group">';
		$output .= $button_text;
		$output .= $button_text_2;
		$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';
		$output .= $html_sale;
		$output .= $btn_full;

		echo sprintf(
			'<div %s> %s</div>',
			$this->get_render_attribute_string( 'wrapper' ),
			$output
		);
	}
}