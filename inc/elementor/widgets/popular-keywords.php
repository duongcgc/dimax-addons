<?php

namespace Razzi\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Group_Control_Background;
use Razzi\Addons\Elementor\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Popular Keywords widget
 */
class Popular_Keywords extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'dimax-popular-keywords';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Razzi - Popular Keywords', 'dimax' );
	}

	/**
	 * Retrieve the widget circle.
	 *
	 * @return string Widget circle.
	 */
	public function get_icon() {
		return 'eicon-link';
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
			[ 'label' => esc_html__( 'Content', 'dimax' ) ]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'dimax' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'This is title', 'dimax' ),
				'separator' => 'after',
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'button_text',
			[
				'label'       => esc_html__( 'Button Text', 'dimax' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Button Text', 'dimax' ),
			]
		);

		$repeater->add_control(
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

		$this->add_control(
			'elements',
			[
				'label' 		=> esc_html__( 'Keywords', 'dimax' ),
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'default'       => [
					[
						'button_text' => esc_html__( 'Button Text 1', 'dimax' ),
					],[
						'button_text' => esc_html__( 'Button Text 2', 'dimax' ),
					],[
						'button_text' => esc_html__( 'Button Text 3', 'dimax' ),
					],[
						'button_text' => esc_html__( 'Button Text 4', 'dimax' ),
					],[
						'button_text' => esc_html__( 'Button Text 5', 'dimax' ),
					],[
						'button_text' => esc_html__( 'Button Text 6', 'dimax' ),
					],
				],
				'title_field'   => '{{{ button_text }}}',
				'prevent_empty' => false
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

		$this->add_control(
			'background_heading',
			[
				'label' => esc_html__( 'Background', 'dimax' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'banners_background',
				'label'    => __( 'Background', 'dimax' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .dimax-popular-keywords',
				'fields_options'  => [
					'background' => [
						'default' => 'classic',
					],
					'color' => [
						'default' => '#ff6f61',
					],
				],
			]
		);

		$this->add_control(
			'content_width',
			[
				'label'   => esc_html__( 'Content Width', 'dimax' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'box'   => esc_html__( 'Box', 'dimax' ),
					'full' 	 => esc_html__( 'Full Width', 'dimax' ),
				],
				'default' => 'box',
				'separator' => 'before',
				'toggle'  => false,
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
					'{{WRAPPER}} .dimax-popular-keywords' => 'text-align: {{VALUE}}',
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
					'{{WRAPPER}} .dimax-popular-keywords' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Els
		$this->start_controls_section(
			'section_content_els_title_style',
			[
				'label' => __( 'Title', 'dimax' ),
				'tab'   => Controls_Manager::TAB_STYLE,
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
					'{{WRAPPER}} .dimax-popular-keywords .heading-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .dimax-popular-keywords .heading-title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => __( 'Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-popular-keywords .heading-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_els_links_style',
			[
				'label' => __( 'Links', 'dimax' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'link_min_width',
			[
				'label'     => esc_html__( 'Min Width', 'dimax' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 250,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimax-popular-keywords .button-text' => 'min-width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'links_padding',
			[
				'label'      => esc_html__( 'Padding', 'dimax' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => [],
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .dimax-popular-keywords .button-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'links_gap',
			[
				'label'      => __( 'Gap', 'dimax' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .dimax-popular-keywords .dimax-popular-keywords__inner' => 'margin: -{{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .dimax-popular-keywords .button-link' => 'padding: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'link_typography',
				'selector' => '{{WRAPPER}} .dimax-popular-keywords .button-text',
			]
		);

		$this->start_controls_tabs(
			'style_links_content'
		);

		$this->start_controls_tab(
			'normal_links_style',
			[
				'label' => __( 'Normal', 'dimax' ),
			]
		);

		$this->add_control(
			'link_color',
			[
				'label'     => __( 'Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-popular-keywords .button-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'link_border_color',
			[
				'label'     => __( 'Border Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-popular-keywords .button-text' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'link_bg_color',
			[
				'label'     => __( 'Background Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-popular-keywords .button-text' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'hover_links_style',
			[
				'label' => __( 'Hover', 'dimax' ),
			]
		);

		$this->add_control(
			'hover_link_color',
			[
				'label'     => __( 'Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-popular-keywords .button-text:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_link_border_color',
			[
				'label'     => __( 'Border Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-popular-keywords .button-text:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_link_bg_color',
			[
				'label'     => __( 'Background Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-popular-keywords .button-text:hover' => 'background-color: {{VALUE}};',
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

		$classes = [
			'dimax-popular-keywords',
		];

		$this->add_render_attribute( 'wrapper', 'class', $classes );

		$heading_title = $settings['title'] ? sprintf('<h3 class="heading-title">%s</h3>',$settings['title']) : '';

		$output  = array();

		$els = $settings['elements'];

		if ( ! empty ( $els ) ) {
			foreach ( $els as $index => $item ) {

				$key_btn = 'btn_' . $index;
				$button_text = $item['button_text'] ? sprintf('<span class="button-text dimax-button button-outline">%s</span>',$item['button_text']) : '';

				$button_text = $item['link']['url'] ? Helper::control_url( $key_btn, $item['link'], $button_text, [ 'class' => 'button-link' ] ) : sprintf( '<div class="button-link">%s</div>', $button_text );

				$output[] = $button_text;

			}
		}

		$class_content = $settings['content_width'] == 'box' ? 'container' : 'container-full';

		echo sprintf(
			'<div %s>
				<div class="%s">
					%s
					<div class="dimax-popular-keywords__inner"> %s</div>
				</div>
			</div>',
			$this->get_render_attribute_string( 'wrapper' ),
			esc_attr($class_content),
			$heading_title,
			implode('', $output)
		);
	}
}