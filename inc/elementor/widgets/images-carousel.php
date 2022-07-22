<?php

namespace Dimax\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;
use Dimax\Addons\Elementor\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Images Carousel widget
 */
class Images_Carousel extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'dimax-images-carousel';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Dimax - Images Box Carousel', 'dimax' );
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

		$this->add_control(
			'heading',
			[
				'label'     => esc_html__( 'Heading', 'dimax' ),
				'type'      => Controls_Manager::TEXT,
				'separator' => 'after',
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'type',
			[
				'label'     => esc_html__( 'Type', 'dimax' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'image'     	=> esc_html__( 'Image', 'dimax' ),
					'text' 	 		=> esc_html__( 'Text', 'dimax' ),
				],
				'default'   => 'image',
			]
		);

		$repeater->add_control(
			'image',
			[
				'label'   => esc_html__( 'Image', 'dimax' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://via.placeholder.com/100x100/f5f5f5?text=Image',
				],
				'condition'   => [
					'type' => 'image',
				],
			]
		);

		$repeater->add_control(
			'text',
			[
				'label'       => esc_html__( 'Text', 'dimax' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( '#Text', 'dimax' ),
				'condition'   => [
					'type' => 'text',
				],
			]
		);

		$repeater->add_control(
			'text_color',
			[
				'label'      => esc_html__( 'Color', 'dimax' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .dimax-images-carousel {{CURRENT_ITEM}} .content-text' => 'color: {{VALUE}}',
				],
				'condition'   => [
					'type' => 'text',
				],
			]
		);

		$repeater->add_control(
			'text_bgcolor',
			[
				'label'      => esc_html__( 'Background Color', 'dimax' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .dimax-images-carousel {{CURRENT_ITEM}} .content-text' => 'background-color: {{VALUE}}',
				],
				'condition'   => [
					'type' => 'text',
				],
			]
		);

		$repeater->add_control(
			'subtitle',
			[
				'label'       => esc_html__( 'Subtitle', 'dimax' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'This is subtitle', 'dimax' ),
				'separator' => 'before',
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

		$repeater->add_control(
			'icon_status',
			[
				'label'        => __( 'Icon', 'dimax' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'dimax' ),
				'label_off'    => __( 'Hide', 'dimax' ),
				'return_value' => 'show',
				'default'      => '',
			]
		);

		$repeater->add_control(
			'icon_type',
			[
				'label' => esc_html__( 'Icon type', 'dimax' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'image' => esc_html__( 'Image', 'dimax' ),
					'icon' 	=> esc_html__( 'Icon', 'dimax' ),
					'external' 	=> esc_html__( 'External', 'dimax' ),
				],
				'default' => 'icon',
				'conditions' => [
					'terms' => [
						[
							'name' => 'icon_status',
							'value' => 'show',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'selected_icon',
			[
				'label' => esc_html__( 'Icon', 'dimax' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'fa-solid',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'icon_type',
							'value' => 'icon',
						],
						[
							'name' => 'icon_status',
							'value' => 'show',
						],
					],
				],
			]
		);

		$repeater->add_control(
			'icon_image',
			[
				'label' => esc_html__( 'Choose Image', 'dimax' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'icon_type',
							'value' => 'image',
						],
						[
							'name' => 'icon_status',
							'value' => 'show',
						],
					],
				],
			]
		);


		$repeater->add_control(
			'external_url',
			[
				'label' => esc_html__( 'External URL', 'dimax' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic' => [
					'active' => true,
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'icon_type',
							'value' => 'external',
						],
						[
							'name' => 'icon_status',
							'value' => 'show',
						],
					],
				],
			]
		);


		$this->add_control(
			'elements',
			[
				'label'         => esc_html__( 'Images', 'dimax' ),
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'default'       => [
					[
						'title' => esc_html__( 'This is the title', 'dimax' ),
						'image' => [
							'url' => 'https://via.placeholder.com/100x100/f5f5f5?text=Image',
						],
					],[
						'title' => esc_html__( 'This is the title', 'dimax' ),
						'image' => [
							'url' => 'https://via.placeholder.com/100x100/f5f5f5?text=Image',
						],
					],[
						'title' => esc_html__( 'This is the title', 'dimax' ),
						'image' => [
							'url' => 'https://via.placeholder.com/100x100/f5f5f5?text=Image',
						],
					],[
						'title' => esc_html__( 'This is the title', 'dimax' ),
						'image' => [
							'url' => 'https://via.placeholder.com/100x100/f5f5f5?text=Image',
						],
					],[
						'title' => esc_html__( 'This is the title', 'dimax' ),
						'image' => [
							'url' => 'https://via.placeholder.com/100x100/f5f5f5?text=Image',
						],
					],

				],
				'title_field'   => '{{{ title }}}',
				'prevent_empty' => false
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

		$this->add_control(
			'slidesPerViewAuto',
			[
				'label'     => __( 'Slides per view auto', 'dimax' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'dimax' ),
				'label_on'  => __( 'On', 'dimax' ),
				'default'   => '',
				'frontend_available' => true,
				'prefix_class' => 'dimax-images-carousel__slidesperviewauto-'
			]
		);

		$this->add_responsive_control(
			'slide_spacing_right',
			[
				'label'     => __( 'Spacing', 'dimax' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 1500,
						'min' => 0,
					],
				],
				'desktop_default' => [
					'size' => 501,
					'unit' => 'px',
				],
				'tablet_default' => [
					'size' => 0,
					'unit' => 'px',
				],
				'mobile_default' => [
					'size' => 0,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}}.dimax-images-carousel__slidesperviewauto-yes .dimax-images-carousel' => 'margin-right: -{{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.dimax-images-carousel__slidesperviewauto-yes ul.products li.swiper-item-empty' => 'width: {{SIZE}}{{UNIT}} !important;',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'slidesPerViewAuto',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'slidesToShow',
			[
				'label'   => esc_html__( 'Slides to show', 'dimax' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 7,
				'desktop_default' => 5,
				'tablet_default' => 4,
				'mobile_default' => 3,
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
				'desktop_default' => 5,
				'tablet_default' => 4,
				'mobile_default' => 3,
				'frontend_available' => true,
			]
		);

		$this->add_responsive_control(
			'navigation',
			[
				'label'     => esc_html__( 'Navigation', 'dimax' ),
				'type'      => Controls_Manager::SELECT,
				'options' => [
					'none'      => esc_html__( 'None', 'dimax' ),
					'arrows'    => esc_html__( 'Arrows', 'dimax' ),
					'dots' 	    => esc_html__( 'Dots', 'dimax' ),
					'scrollbar' => esc_html__( 'Scrollbar', 'dimax' ),
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
		$this->section_general_style();
		$this->section_content_style();
		$this->section_carousel_style();
	}

	protected function section_general_style() {
		// Content
		$this->start_controls_section(
			'section_general_style',
			[
				'label' => __( 'General', 'dimax' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs(
			'style_tabs_general'
		);

		$this->start_controls_tab(
			'content_img',
			[
				'label' => __( 'Image', 'dimax' ),
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

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'image',
				'default'   => 'full',
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
					'{{WRAPPER}} .dimax-images-carousel .content-img img' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'content_style_text',
			[
				'label' => __( 'Text Box', 'dimax' ),
			]
		);

		$this->add_responsive_control(
			'text_border_ra',
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
					'{{WRAPPER}} .dimax-images-carousel .content-text' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'box_text_width',
			[
				'label'     => esc_html__( 'Width', 'dimax' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .dimax-images-carousel .content-text' => 'width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'box_text_height',
			[
				'label'     => esc_html__( 'Height', 'dimax' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimax-images-carousel .content-text' => 'height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'text_color_ge',
			[
				'label'      => esc_html__( 'Color', 'dimax' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .dimax-images-carousel .content-text' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'text_bgcolor_ge',
			[
				'label'      => esc_html__( 'Background Color', 'dimax' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .dimax-images-carousel .content-text' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

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
		$this->add_control(
			'heading_divider',
			[
				'label' => __( 'Heading', 'dimax' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .dimax-images-carousel .dimax-images-carousel__heading',
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label'     => __( 'Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-images-carousel .dimax-images-carousel__heading' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'heading_spacing',
			[
				'label'     => esc_html__( 'Spacing Bottom', 'dimax' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 150,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimax-images-carousel .dimax-images-carousel__heading' => 'padding-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'content_skew',
			[
				'label'     => __( 'Skew', 'dimax' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'dimax' ),
				'label_on'  => __( 'On', 'dimax' ),
				'default'   => '',
				'frontend_available' => true,
				'prefix_class' => 'dimax-images-carousel__skew--',
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'image_background_color',
			[
				'label'     => __( 'Background Color Image', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}.dimax-images-carousel__skew--yes .dimax-images-carousel .content-img' => 'background-color: {{VALUE}};',
				],
				'condition'   => [
					'content_skew' => 'yes',
				],
			]
		);

		$this->add_control(
			'content_background_color',
			[
				'label'     => __( 'Background Color Content', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-images-carousel .content-summary' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_spacing',
			[
				'label'     => esc_html__( 'Spacing Top', 'dimax' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 150,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimax-images-carousel .content-summary' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->start_controls_tabs(
			'style_tabs_content'
		);

		$this->start_controls_tab(
			'style_tabs_sub',
			[
				'label' => __( 'Subtitle', 'dimax' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'subtitle_typography',
				'selector' => '{{WRAPPER}} .dimax-images-carousel .content-subtitle',
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label'     => __( 'Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-images-carousel .content-subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'sub_spacing',
			[
				'label'     => esc_html__( 'Spacing Bottom', 'dimax' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 150,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimax-images-carousel .content-subtitle' => 'padding-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_tab();

		// Title
		$this->start_controls_tab(
			'content_style_title',
			[
				'label' => __( 'Title', 'dimax' ),
			]
		);

		$this->add_responsive_control(
			'title_padding',
			[
				'label'      => __( 'Padding', 'dimax' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .dimax-images-carousel .content-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .dimax-images-carousel .content-title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => __( 'Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-images-carousel .content-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

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
			'carousel_style_divider',
			[
				'label' => __( 'Scrollbar', 'dimax' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'scrollbar_align',
			[
				'label'       => esc_html__( 'Alignment', 'dimax' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'left'       => [
						'title' => esc_html__( 'Left', 'dimax' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'dimax' ),
						'icon'  => 'eicon-text-align-center',
					],
				],
				'default'     => '',
				'selectors_dictionary' => [
					'left' 		=> 'margin-left: 15px; margin-right: 0;',
					'center'   	=> 'margin-left: auto; margin-right: auto;',
				],
				'selectors' => [
					'{{WRAPPER}} .dimax-images-carousel .swiper-scrollbar' => '{{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'scrollbar_max_width',
			[
				'label'     => __( 'Max Width', 'dimax' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'     => [
					'px' => [
						'max' => 1500,
						'min' => 0,
					],
					'%' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimax-images-carousel .swiper-scrollbar' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'scrollbar_spacing',
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
					'{{WRAPPER}} .dimax-images-carousel .swiper-scrollbar' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'scrollbar_color',
			[
				'label'     => esc_html__( 'Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-images-carousel .swiper-scrollbar' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'scrollbar_active_color',
			[
				'label'     => esc_html__( 'Active Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-images-carousel .swiper-scrollbar-drag' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'arrows_style_divider',
			[
				'label' => esc_html__( 'Arrows', 'dimax' ),
				'type'  => Controls_Manager::HEADING,
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'arrows_position',
			[
				'label'        => esc_html__( 'Position', 'dimax' ),
				'type'         => Controls_Manager::CHOOSE,
				'label_block'  => false,
				'default'      => 'center',
				'options'      => [
					'top'   => [
						'title' => esc_html__( 'Top', 'dimax' ),
						'icon'  => 'eicon-v-align-top',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'dimax' ),
						'icon'  => 'eicon-v-align-middle',
					],
				],
				'prefix_class' => 'dimax--v-position-',
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
					'{{WRAPPER}} .dimax-images-carousel .rz-swiper-button' => 'font-size: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .dimax-images-carousel .rz-swiper-button' => 'width: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .dimax-images-carousel              .rz-swiper-button' => 'height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .dimax-images-carousel .rz-swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .dimax-images-carousel .rz-swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.dimax--v-position-top .dimax-images-carousel .dimax-images-carousel__group--arrows' => 'right: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .dimax-images-carousel .rz-swiper-button' => 'top: {{SIZE}}{{UNIT}};transform:none;',
					'{{WRAPPER}}.dimax--v-position-top .dimax-images-carousel .dimax-images-carousel__group--arrows' => 'top: {{SIZE}}{{UNIT}};transform:none;',
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
					'{{WRAPPER}} .dimax-images-carousel .rz-swiper-button' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .dimax-images-carousel .rz-swiper-button' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .dimax-images-carousel .rz-swiper-button:hover' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .dimax-images-carousel .rz-swiper-button:hover' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .dimax-images-carousel .swiper-pagination-bullet' => 'margin: 0 {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .dimax-images-carousel .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .dimax-images-carousel .swiper-pagination' => 'margin-top: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .dimax-images-carousel .swiper-pagination-bullet:before' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .dimax-images-carousel .swiper-pagination-bullet-active:before, {{WRAPPER}} .dimax-images-carousel .swiper-pagination-bullet:hover:before' => 'background-color: {{VALUE}};',
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
			'dimax-images-carousel',
			'dimax-swiper-carousel-elementor',
			'navigation-' . $nav,
			'navigation-tablet-' . $nav_tablet,
			'navigation-mobile-' . $nav_mobile,
		];

		$this->add_render_attribute( 'wrapper', 'class', $classes );
		$this->add_render_attribute( 'icon', 'class', 'dimax-products-slider__icon' );

		$output =  array();

		$heading = $settings['heading'] ? sprintf('<div class="dimax-images-carousel__heading">%s</div>', $settings['heading'] ) : '';

		$els = $settings['elements'];
		$class_cols = $settings['slidesPerViewAuto'] == 'yes' ? 'col-flex-xs-'.intval(12/$settings['slidesToShow']) : '';
		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php echo $heading ?>
			<div class="swiper-container">
				<div class="dimax-images-carousel__inner swiper-wrapper">
		<?php
				if ( ! empty ( $els ) ) {
					foreach ( $els as $index => $item ) {

						$settings['image']      	= $item['image'];

						$image = Group_Control_Image_Size::get_attachment_image_html( $settings );
						$image = $image ? sprintf('<div class="content-img">%s</div>',$image) : '';

						$key_img = 'image_' . $index;

						$btn_full = $item['link']['url'] ? Helper::control_url( $key_img, $item['link'], '', [ 'class' => 'full-box-button' ] ) : '';

						$subtitle = $item['subtitle'] ? sprintf('<div class="content-subtitle">%s</div>',$item['subtitle']) : '';
						$title = $item['title'] ? sprintf('<div class="content-title">%s</div>',$item['title']) : '';
						$box_text = $item['text'] ? sprintf('<div class="content-text">%s</div>',$item['text']) : '';

						$output_content  = $item['type'] == 'image' ? $image : $box_text;
						$output_content .= '<div class="content-summary">';
						$output_content .= $subtitle;
						$output_content .= $title;
						$output_content .= '</div>';
						$output_content .= $btn_full;

						if ( ! isset( $settings['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
							$settings['icon'] = 'fa fa-star';
						}

						$has_icon = ! empty( $settings['icon'] );

						if ( $has_icon ) {
							$this->add_render_attribute( 'i', 'class', $settings['icon'] );
							$this->add_render_attribute( 'i', 'aria-hidden', 'true' );
						}

						if ( ! $has_icon && ! empty( $item['selected_icon']['value'] ) ) {
							$has_icon = true;
						}

						$migrated = isset( $item['__fa4_migrated']['selected_icon'] );
						$is_new = ! isset( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

						echo '<div class="elementor-repeater-item-' . esc_attr( $item['_id'] ) . ' image-item swiper-slide ' . esc_attr( $class_cols ) . '">';
							printf( '%s', $output_content );
							if ( $has_icon || ! empty( $item['icon_image']['url'] ) || ! empty( $item['external_url'] ) ) {
								if ( $item['icon_type'] === 'image' ) {
									?><span <?php $this->print_render_attribute_string( 'icon' ); ?>><?php
										echo sprintf( '<img alt="%s" src="%s">', esc_attr( $item['title'] ), esc_url( $item['icon_image']['url'] ) );
									?></span><?php
								} if ( $item['icon_type'] === 'external' ) {
									?><span <?php $this->print_render_attribute_string( 'icon' ); ?>><?php
										echo '<img src="' . $item['external_url'] . '" alt="' . $item['title'] . '" />';
									?></span><?php
								} else {
									if ( $is_new || $migrated ) {
										$this->add_render_attribute( 'icon', 'class', 'dimax-svg-icon' );
										?><span <?php $this->print_render_attribute_string( 'icon' ); ?>><?php
											Icons_Manager::render_icon( $item['selected_icon'], [ 'aria-hidden' => 'true' ] );
										?></span><?php
									} elseif ( ! empty( $settings['icon'] ) ) {
										?>
										<span <?php $this->print_render_attribute_string( 'icon' ); ?>>
											<i <?php $this->print_render_attribute_string( 'i' ); ?>></i>
										</span>
										<?php
									}
								}
							}
						echo '</div>';
					}

					if ( $settings['slidesPerViewAuto'] == 'yes' ) {
						if ( $settings['slidesToShow'] != 1 || $settings['slidesToScroll'] != 1 ) {
							echo '<div class="swiper-item-empty swiper-slide ' . esc_attr( $class_cols ) . '"></div>';
						}
					}
				}

		?>
				</div>
				<div class="swiper-pagination"></div>
				<div class="swiper-scrollbar"></div>
			</div>
			<?php
				echo '<div class="dimax-images-carousel__group--arrows">';
				echo \Dimax\Addons\Helper::get_svg('chevron-left','rz-swiper-button-prev rz-swiper-button');
				echo \Dimax\Addons\Helper::get_svg('chevron-right', 'rz-swiper-button-next rz-swiper-button');
				echo '</div>';
			?>
		</div>
		<?php
	}
}