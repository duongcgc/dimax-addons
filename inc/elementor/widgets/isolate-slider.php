<?php

namespace Dimax\Addons\Elementor\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Controls_Stack ;
use Dimax\Addons\Elementor\Helper;

/**
 * Elementor isolate slider widget.
 *
 * Elementor widget that displays an eye-catching headlines.
 *
 * @since 1.0.0
 */
class Isolate_Slider extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve isolate slider widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'dimax-isolate-slides';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve isolate slider widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Dimax - Isolate Slider', 'dimax' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve isolate slider widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-post-slider';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the isolate slider widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'dimax' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'isolate', 'slider' ];
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

	// Tab Content
	protected function section_content() {
		$this->section_content_slides();
		$this->section_content_option();
	}

	protected function section_content_slides() {
		$this->start_controls_section(
			'section_slides',
			[
				'label' => esc_html__( 'Slides', 'dimax' ),
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->start_controls_tabs( 'slides_repeater' );

		$repeater->start_controls_tab( 'background', [ 'label' => esc_html__( 'Background', 'dimax' ) ] );

		$repeater->add_responsive_control(
			'banner_background_img',
			[
				'label'    => __( 'Background Slider', 'dimax' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://via.placeholder.com/768X535/cccccc?text=768x535',
				],
				'selectors' => [
					'{{WRAPPER}} .dimax-isolate-slides {{CURRENT_ITEM}}:not(.swiper-lazy) .dimax-isolate-slides__image' => 'background-image: url("{{URL}}");',
				],
			]
		);

		$repeater->add_responsive_control(
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
					'{{WRAPPER}} .dimax-isolate-slides {{CURRENT_ITEM}} .dimax-isolate-slides__image' => 'background-size: {{VALUE}}',
				],
				'condition' => [
					'banner_background_img[url]!' => '',
				],
			]
		);

		$repeater->add_responsive_control(
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
					'{{WRAPPER}} .dimax-isolate-slides {{CURRENT_ITEM}} .dimax-isolate-slides__image' => 'background-position: {{VALUE}};',
				],
				'condition' => [
					'banner_background_img[url]!' => '',
				],

			]
		);

		$repeater->add_responsive_control(
			'background_position_xy',
			[
				'label'              => esc_html__( 'Custom Background Position', 'dimax' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'allowed_dimensions' => [ 'top', 'left' ],
				'size_units'         => [ 'px', '%' ],
				'default'            => [ ],
				'selectors'          => [
					'{{WRAPPER}} .dimax-isolate-slides {{CURRENT_ITEM}} .dimax-isolate-slides__image' => 'background-position: {{LEFT}}{{UNIT}} {{TOP}}{{UNIT}};',
				],
				'condition' => [
					'background_position' => [ 'initial' ],
					'banner_background_img[url]!' => '',
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

		$repeater->add_responsive_control(
			'banner_background_content',
			[
				'label'    => __( 'Background Content', 'dimax' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [],
				'selectors' => [
					'{{WRAPPER}} .dimax-isolate-slides {{CURRENT_ITEM}} .dimax-isolate-slides__wrapper' => 'background-image: url("{{URL}}");',
				],
				'separator'    => 'before',
			]
		);

		$repeater->add_responsive_control(
			'background_size_content',
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
					'{{WRAPPER}} .dimax-isolate-slides {{CURRENT_ITEM}} .dimax-isolate-slides__wrapper' => 'background-size: {{VALUE}}',
				],
				'condition' => [
					'banner_background_content[url]!' => '',
				],
			]
		);

		$repeater->add_responsive_control(
			'background_position_content',
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
					'{{WRAPPER}} .dimax-isolate-slides {{CURRENT_ITEM}} .dimax-isolate-slides__wrapper' => 'background-position: {{VALUE}};',
				],
				'condition' => [
					'banner_background_content[url]!' => '',
				],

			]
		);

		$repeater->add_responsive_control(
			'background_position_xy_content',
			[
				'label'              => esc_html__( 'Custom Background Position', 'dimax' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'allowed_dimensions' => [ 'top', 'left' ],
				'size_units'         => [ 'px', '%' ],
				'default'            => [ ],
				'selectors'          => [
					'{{WRAPPER}} .dimax-isolate-slides {{CURRENT_ITEM}} .dimax-isolate-slides__wrapper' => 'background-position: {{LEFT}}{{UNIT}} {{TOP}}{{UNIT}};',
				],
				'condition' => [
					'background_position_content' => [ 'initial' ],
					'banner_background_content[url]!' => '',
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

		$repeater->add_responsive_control(
			'banner_background_title',
			[
				'label'    => __( 'Background Title', 'dimax' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [],
				'selectors' => [
					'{{WRAPPER}} .dimax-isolate-slides {{CURRENT_ITEM}} .dimax-isolate-slides__title' => 'background-image: url("{{URL}}");',
				],
				'separator'    => 'before',
			]
		);

		$repeater->add_responsive_control(
			'background_size_title',
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
					'{{WRAPPER}} .dimax-isolate-slides {{CURRENT_ITEM}} .dimax-isolate-slides__title' => 'background-size: {{VALUE}}',
				],
				'condition' => [
					'banner_background_title[url]!' => '',
				],
			]
		);

		$repeater->add_responsive_control(
			'background_position_title',
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
					'{{WRAPPER}} .dimax-isolate-slides {{CURRENT_ITEM}} .dimax-isolate-slides__title' => 'background-position: {{VALUE}};',
				],
				'condition' => [
					'banner_background_title[url]!' => '',
				],

			]
		);

		$repeater->add_responsive_control(
			'background_position_xy_title',
			[
				'label'              => esc_html__( 'Custom Background Position', 'dimax' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'allowed_dimensions' => [ 'top', 'left' ],
				'size_units'         => [ 'px', '%' ],
				'default'            => [ ],
				'selectors'          => [
					'{{WRAPPER}} .dimax-isolate-slides {{CURRENT_ITEM}} .dimax-isolate-slides__title' => 'background-position: {{LEFT}}{{UNIT}} {{TOP}}{{UNIT}};',
				],
				'condition' => [
					'background_position_title' => [ 'initial' ],
					'banner_background_title[url]!' => '',
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

		$repeater->end_controls_tab();

		$repeater->start_controls_tab( 'text_content', [ 'label' => esc_html__( 'Content', 'dimax' ) ] );

		$repeater->add_control(
			'before_title',
			[
				'label'       => esc_html__( 'Before Title', 'dimax' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Before Title', 'dimax' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'dimax' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Title', 'dimax' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'after_title',
			[
				'label'       => esc_html__( 'After Title', 'dimax' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'After Title', 'dimax' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'description',
			[
				'label'   => esc_html__( 'Description', 'dimax' ),
				'type'    => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'I am slide content. Click edit button to change this text. ', 'dimax' ),
			]
		);

		$repeater->add_control(
			'button_text',
			[
				'label'   => esc_html__( 'Button Text', 'dimax' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Click Here', 'dimax' ),
			]
		);

		$repeater->add_control(
			'link',
			[
				'label'       => esc_html__( 'Button Link', 'dimax' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'dimax' ),
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'slides',
			[
				'label'      => esc_html__( 'Slides', 'dimax' ),
				'type'       => Controls_Manager::REPEATER,
				'show_label' => true,
				'fields'     => $repeater->get_controls(),
				'default'    => [
					[
						'title'            => esc_html__( 'Slide 1 Heading', 'dimax' ),
						'description'      => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'dimax' ),
					],
					[
						'title'            => esc_html__( 'Slide 2 Heading', 'dimax' ),
						'description'      => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'dimax' ),
					],
					[
						'title'            => esc_html__( 'Slide 3 Heading', 'dimax' ),
						'description'      => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'dimax' ),
					],
				],
			]
		);

		$this->add_responsive_control(
			'slides_height',
			[
				'label'      => esc_html__( 'Height', 'dimax' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 100,
						'max' => 1000,
					],
					'vh' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'default'    => [
					'size' => 535,
				],
				'size_units' => [ 'px', 'vh', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .dimax-isolate-slides .item-slider' => 'height: {{SIZE}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'lazyload',
			[
				'label'     => esc_html__( 'Show Lazyload', 'dimax' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'dimax' ),
				'label_on'  => __( 'On', 'dimax' ),
				'return_value' => 'yes',
				'default'   => '',
				'frontend_available' => true,
			]
		);

		$this->end_controls_section();
	}

	protected function section_content_option() {
		$this->start_controls_section(
			'section_slider_options',
			[
				'label' => esc_html__( 'Slider Options', 'dimax' ),
				'type'  => Controls_Manager::SECTION,
			]
		);

		$this->add_control(
			'effect',
			[
				'label'   => esc_html__( 'Effect', 'dimax' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'fade'   	 => esc_html__( 'Fade', 'dimax' ),
					'slide' 	 => esc_html__( 'Slide', 'dimax' ),
					'cube' 	 	 => esc_html__( 'Cube', 'dimax' ),
					'coverflow'	 => esc_html__( 'Coverflow', 'dimax' ),
				],
				'default' => 'fade',
				'toggle'  => false,
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
				'default' => 'dots',
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'   => esc_html__( 'Autoplay', 'dimax' ),
				'type'    => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'dimax' ),
				'label_off'    => __( 'No', 'dimax' ),
				'return_value' => 'yes',
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

		$this->add_control(
			'infinite',
			[
				'label'   => esc_html__( 'Infinite Loop', 'dimax' ),
				'type'    => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'dimax' ),
				'label_off'    => __( 'No', 'dimax' ),
				'return_value' => 'yes',
				'default'      => '',
				'frontend_available' => true,
			]
		);

		$this->end_controls_section();

	}

	// Tab Style
	protected function section_style() {
		$this->section_style_content();
		$this->section_style_carousel();
	}

	protected function section_style_content() {
		$this->start_controls_section(
			'section_style_content',
			[
				'label' => esc_html__( 'Content', 'dimax' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'slides_vertical_position',
			[
				'label'        => esc_html__( 'Vertical Position', 'dimax' ),
				'type'         => Controls_Manager::CHOOSE,
				'label_block'  => false,
				'default'      => 'center',
				'options'      => [
					'flex-start'    => [
						'title' => esc_html__( 'Top', 'dimax' ),
						'icon'  => 'eicon-v-align-top',
					],
					'center' => [
						'title' => esc_html__( 'Middle', 'dimax' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'flex-end' => [
						'title' => esc_html__( 'Bottom', 'dimax' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'selectors'   => [
					'{{WRAPPER}} .dimax-isolate-slides__wrapper' => 'align-items: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'slides_text_align',
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
				'default'     => 'center',
				'selectors'   => [
					'{{WRAPPER}} .dimax-isolate-slides__wrapper' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'content_width',
			[
				'label'     => esc_html__( 'Content Width', 'dimax' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' 	=> [],
				'selectors' => [
					'{{WRAPPER}} .dimax-isolate-slides__wrapper' => 'flex: 1 1 {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .dimax-isolate-slides__image' => 'flex: 1 1 calc( 100% - {{SIZE}}{{UNIT}} )',
				],
			]
		);

		$this->add_responsive_control(
			'content_bg_color',
			[
				'label'     => __( 'Background Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-isolate-slides__wrapper:before' => 'background-color: {{VALUE}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'slides_padding',
			[
				'label'      => esc_html__( 'Padding', 'dimax' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .dimax-isolate-slides__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .dimax-isolate-slides__wrapper:before' => 'top: {{TOP}}{{UNIT}}; left: {{LEFT}}{{UNIT}}; width: calc( 100% - ( {{RIGHT}}{{UNIT}} + {{LEFT}}{{UNIT}} ) ); height: calc( 100% - ( {{TOP}}{{UNIT}} + {{BOTTOM}}{{UNIT}} ) );',
				],
			]
		);

		$this->add_control(
			'content_before_title',
			[
				'label'     => esc_html__( 'Before Title', 'dimax' ),
				'type'      => Controls_Manager::HEADING,
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'content_before_title_color',
			[
				'label'     => esc_html__( 'Text Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dimax-isolate-slides__before-title' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'content_before_title_typography',
				'selector' => '{{WRAPPER}} .dimax-isolate-slides__before-title',
			]
		);

		$this->add_responsive_control(
			'content_before_title_spacing',
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
					'{{WRAPPER}} .dimax-isolate-slides__before-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'content_title',
			[
				'label'     => esc_html__( 'Title', 'dimax' ),
				'type'      => Controls_Manager::HEADING,
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'content_title_color',
			[
				'label'     => esc_html__( 'Text Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dimax-isolate-slides__title' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'content_title_typography',
				'selector' => '{{WRAPPER}} .dimax-isolate-slides__title',
			]
		);

		$this->add_responsive_control(
			'content_title_spacing',
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
					'{{WRAPPER}} .dimax-isolate-slides__title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'content_after_title',
			[
				'label'     => esc_html__( 'After Title', 'dimax' ),
				'type'      => Controls_Manager::HEADING,
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'content_after_title_color',
			[
				'label'     => esc_html__( 'Text Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dimax-isolate-slides__after-title' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'content_after_title_typography',
				'selector' => '{{WRAPPER}} .dimax-isolate-slides__after-title',
			]
		);

		$this->add_responsive_control(
			'content_after_title_spacing',
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
					'{{WRAPPER}} .dimax-isolate-slides__after-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'content_description',
			[
				'label'     => esc_html__( 'Description', 'dimax' ),
				'type'      => Controls_Manager::HEADING,
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'content_description_color',
			[
				'label'     => esc_html__( 'Text Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dimax-isolate-slides__description' => 'color: {{VALUE}}',

				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'content_description_typography',
				'selector' => '{{WRAPPER}} .dimax-isolate-slides__description',
			]
		);

		$this->add_control(
			'content_buton',
			[
				'label'     => esc_html__( 'Button', 'dimax' ),
				'type'      => Controls_Manager::HEADING,
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'btn_padding',
			[
				'label'      => esc_html__( 'Padding', 'dimax' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .dimax-isolate-slides__button .button-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'btn_typography',
				'selector' => '{{WRAPPER}} .dimax-isolate-slides__button .button-text',
			]
		);

		$this->add_control(
			'btn_color',
			[
				'label'      => esc_html__( 'Color', 'dimax' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .dimax-isolate-slides__button .button-text' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'btn_bgcolor',
			[
				'label'      => esc_html__( 'Background Color', 'dimax' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .dimax-isolate-slides__button .button-text' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'border_style',
			[
				'label'        => __( 'Border', 'dimax' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'dimax' ),
				'label_on'     => __( 'Custom', 'dimax' ),
				'return_value' => 'yes',
			]
		);
		$this->start_popover();

		$this->add_control(
			'content_border_style',
			[
				'label'     => esc_html__( 'Border Style', 'dimax' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'dotted' => esc_html__( 'Dotted', 'dimax' ),
					'dashed' => esc_html__( 'Dashed', 'dimax' ),
					'solid'  => esc_html__( 'Solid', 'dimax' ),
					'none'   => esc_html__( 'None', 'dimax' ),
				],
				'default'   => '',
				'toggle'    => false,
				'selectors' => [
					'{{WRAPPER}} .dimax-isolate-slides__button .button-text' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_border_width',
			[
				'label'     => __( 'Border Width', 'dimax' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 7,
						'min' => 0,
					],
				],
				'default'   => [ ],
				'selectors' => [
					'{{WRAPPER}} .dimax-isolate-slides__button .button-text' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'content_border_color',
			[
				'label'     => __( 'Border Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-isolate-slides__button .button-text' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_popover();

		$this->end_controls_section();

	}

	protected function section_style_carousel() {
		// Arrows
		$this->start_controls_section(
			'section_style_arrows',
			[
				'label' => esc_html__( 'Slider Options', 'dimax' ),
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
					'{{WRAPPER}} .dimax-isolate-slides .rz-swiper-button' => 'font-size: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .dimax-isolate-slides .rz-swiper-button' => 'width: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .dimax-isolate-slides .rz-swiper-button' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .dimax-isolate-slides .rz-swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .dimax-isolate-slides .rz-swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'arrows_spacing_vertical',
			[
				'label'      => esc_html__( 'Vertical Position', 'dimax' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => -100,
						'max' => 200,
					],
				],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .dimax-isolate-slides .rz-swiper-button-prev' => 'top: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .dimax-isolate-slides .rz-swiper-button-next' => 'top: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .dimax-isolate-slides .rz-swiper-button' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .dimax-isolate-slides .rz-swiper-button' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .dimax-isolate-slides .rz-swiper-button:hover' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .dimax-isolate-slides .rz-swiper-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->add_control(
			'sliders_arrow_border',
			[
				'label'        => __( 'Border', 'dimax' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'Default', 'dimax' ),
				'label_on'     => __( 'Custom', 'dimax' ),
				'return_value' => 'yes',
			]
		);
		$this->start_popover();

		$this->add_control(
			'arrow_border_style',
			[
				'label'     => esc_html__( 'Border Style', 'dimax' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'dotted' => esc_html__( 'Dotted', 'dimax' ),
					'dashed' => esc_html__( 'Dashed', 'dimax' ),
					'solid'  => esc_html__( 'Solid', 'dimax' ),
					'none'   => esc_html__( 'None', 'dimax' ),
				],
				'default'   => '',
				'toggle'    => false,
				'selectors' => [
					'{{WRAPPER}} .dimax-isolate-slides .rz-swiper-button' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'arrow_border_width',
			[
				'label'     => __( 'Border Width', 'dimax' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 7,
						'min' => 0,
					],
				],
				'default'   => [ ],
				'selectors' => [
					'{{WRAPPER}} .dimax-isolate-slides .rz-swiper-button' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'arrow_content_border_color',
			[
				'label'     => __( 'Border Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-isolate-slides .rz-swiper-button' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_popover();

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
			'sliders_dots_position',
			[
				'label'     => esc_html__( 'Position', 'dimax' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'right' => esc_html__( 'Right', 'dimax' ),
					'bottom' => esc_html__( 'Bottom', 'dimax' ),
				],
				'default'   => 'right',
				'toggle'    => false,
			]
		);

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
					'{{WRAPPER}} .dimax-isolate-slides .swiper-pagination-bullet' => 'margin: {{SIZE}}{{UNIT}} 0',
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
					'{{WRAPPER}} .dimax-isolate-slides .swiper-pagination-bullet:before' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'sliders_dots_offset_ver',
			[
				'label'     => esc_html__( 'Spacing', 'dimax' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => -100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimax-isolate-slides.dots-position-right .swiper-pagination,
					{{WRAPPER}} .dimax-isolate-slides.dots-position-tablet-right .swiper-pagination,
					{{WRAPPER}} .dimax-isolate-slides.dots-position-mobile-right .swiper-pagination' => 'right: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .dimax-isolate-slides.dots-position-bottom .swiper-pagination,
					{{WRAPPER}} .dimax-isolate-slides.dots-position-tablet-bottom .swiper-pagination,
					{{WRAPPER}} .dimax-isolate-slides.dots-position-mobile-bottom .swiper-pagination' => 'bottom: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .dimax-isolate-slides .swiper-pagination-bullet:before' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .dimax-isolate-slides .swiper-pagination-bullet-active:before, {{WRAPPER}} .dimax-isolate-slides .swiper-pagination-bullet:hover:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Render isolate slider widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['slides'] ) ) {
			return;
		}

		$nav        = $settings['navigation'];
		$nav_tablet = empty( $settings['navigation_tablet'] ) ? $nav : $settings['navigation_tablet'];
		$nav_mobile = empty( $settings['navigation_mobile'] ) ? $nav : $settings['navigation_mobile'];

		$dots_position  = $settings['sliders_dots_position'];
		$dots_tablet 	= empty( $settings['sliders_dots_position_tablet'] ) ? $dots_position : $settings['sliders_dots_position_tablet'];
		$dots_mobile 	= empty( $settings['sliders_dots_position_mobile'] ) ? $dots_position : $settings['sliders_dots_position_mobile'];

		$classes = [
			'dimax-isolate-slides',
			'dimax-swiper-carousel-elementor',
			'dimax-swiper-slider-elementor',
			'navigation-' . $nav,
			'navigation-tablet-' . $nav_tablet,
			'navigation-mobile-' . $nav_mobile,
			'dots-position-' . $dots_position,
			'dots-position-tablet-' . $dots_tablet,
			'dots-position-mobile-' . $dots_mobile,
		];

		$slides      = [];
		$slide_count = 0;

		foreach ( $settings['slides'] as $slide ) {
			$slide_html       = '';

			$slide_html .= '<div class="dimax-isolate-slides__wrapper">';
			$slide_html .= '<div class="dimax-isolate-slides__content">';

			if ( $slide['before_title'] ) {
				$slide_html .= '<div class="dimax-isolate-slides__before-title">' . $slide['before_title'] . '</div>';
			}

			if ( $slide['title'] ) {
				$img_active = $slide['banner_background_title']['url'] != '' ? 'has-background' : '';
				$slide_html .= '<div class="dimax-isolate-slides__title '. esc_attr( $img_active ) .'">' . $slide['title'] . '</div>';
			}

			if ( $slide['after_title'] ) {
				$slide_html .= '<div class="dimax-isolate-slides__after-title">' . $slide['after_title'] . '</div>';
			}

			if ( $slide['description'] ) {
				$slide_html .= '<div class="dimax-isolate-slides__description">' . $slide['description'] . '</div>';
			}

			// Button
			$button_text = $slide['button_text'] ? sprintf('<span class="button-text dimax-button">%s %s</span>', $slide['button_text'], \Dimax\Addons\Helper::get_svg('arrow-right', 'dimax-icon') ) : '';

			$key_btn = 'btn_' . $slide_count;

			$button_text = $slide['link']['url'] ? Helper::control_url( $key_btn, $slide['link'], $button_text, ['class' => 'button-link'] ) : $button_text;

			$slide_html .= '<div class="dimax-isolate-slides__button">';
			if ( $slide['button_text'] ) {
				$slide_html .= $button_text;
			}

			$slide_html .= '</div>';
			$slide_html .= '</div>';

			$slide_html .= '</div>';

			if ( $slide['banner_background_img'] ) {
				$slide_html .= '<div class="dimax-isolate-slides__image"></div>';
			}

			$slide_html = '<div class="slick-slide-inner">' . $slide_html . '</div>';

			$data_lazy_url = $data_lazy_class = $data_lazy_loading = '';

			if ($settings['lazyload'] ) {

				$data_lazy_url = 'data-background="'.$slide['banner_background_img']['url'].'"';
				$data_lazy_loading =  '	<div class="swiper-lazy-preloader"></div>';
				$data_lazy_class = 'swiper-lazy';

			}

			$slides[]   = '<div '. $data_lazy_url .' class="elementor-repeater-item-' . $slide['_id'] . ' item-slider swiper-slide '.$data_lazy_class.'">' . $slide_html . $data_lazy_loading .'</div>';

			$slide_count ++;
		}

		if ($slide_count > 1) {
			$output_pagination	=  \Dimax\Addons\Helper::get_svg('chevron-left','rz-swiper-button-prev rz-swiper-button');
			$output_pagination .= \Dimax\Addons\Helper::get_svg('chevron-right','rz-swiper-button-next rz-swiper-button');
			$output_pagination .= '<div class="swiper-pagination container"></div>';
		} else {
			$output_pagination = '';
		}

		$this->add_render_attribute( 'wrapper', 'class', $classes );

		echo sprintf(
			'<div %s>
				<div class="dimax-isolate-slides__content-wrapper swiper-container">
					<div class="dimax-isolate-slides__inner swiper-wrapper">%s</div>
				</div>
				%s
			</div>',
			$this->get_render_attribute_string( 'wrapper' ),
			implode( '', $slides ),
			$output_pagination
		);
	}
}
