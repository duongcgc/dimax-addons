<?php

namespace Razzi\Addons\Elementor\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Utils;
use Elementor\Widget_Base;

/**
 * Elementor button widget.
 *
 * Elementor widget that displays a button with the ability to control every
 * aspect of the button design.
 *
 * @since 1.0.0
 */
class Button extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve button widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'dimax-button';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve button widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Razzi - Button', 'dimax' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve button widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-button';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the button widget belongs to.
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
	 * Get button sizes.
	 *
	 * Retrieve an array of button sizes for the button widget.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @return array An array containing button sizes.
	 */
	public static function get_button_sizes() {
		return [
			''        => __( 'Default', 'dimax' ),
			'smaller' => __( 'Small', 'dimax' ),
			'medium'  => __( 'Medium', 'dimax' ),
			'larger'  => __( 'Large', 'dimax' ),
		];
	}

	/**
	 * Register button widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 3.1.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_button',
			[
				'label' => __( 'Button', 'dimax' ),
			]
		);

		$this->add_control(
			'button_style',
			[
				'label'   => __( 'Style', 'dimax' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''          => __( 'Normal', 'dimax' ),
					'outline'   => __( 'Outline', 'dimax' ),
					'underline' => __( 'Underline', 'dimax' ),
				],
			]
		);

		$this->add_control(
			'text',
			[
				'label'       => __( 'Text', 'dimax' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'     => __( 'Click here', 'dimax' ),
				'placeholder' => __( 'Click here', 'dimax' ),
			]
		);

		$this->add_control(
			'link',
			[
				'label'       => __( 'Link', 'dimax' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'https://your-link.com', 'dimax' ),
				'default'     => [
					'url' => '#',
				],
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'   => __( 'Alignment', 'dimax' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' => __( 'Left', 'dimax' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'  => [
						'title' => __( 'Center', 'dimax' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'   => [
						'title' => __( 'Right', 'dimax' ),
						'icon'  => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'dimax' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'default' => '',
				'prefix_class' => 'elementor%s-align-',
			]
		);

		$this->add_control(
			'size',
			[
				'label'          => __( 'Size', 'dimax' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '',
				'options'        => self::get_button_sizes(),
				'style_transfer' => true,
			]
		);

		$this->add_control(
			'selected_icon',
			[
				'label'            => __( 'Icon', 'dimax' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'skin'             => 'inline',
				'label_block'      => false,
			]
		);

		$this->add_control(
			'icon_align',
			[
				'label'     => __( 'Icon Position', 'dimax' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'left',
				'options'   => [
					'left'  => __( 'Before', 'dimax' ),
					'right' => __( 'After', 'dimax' ),
				],
				'condition' => [
					'selected_icon[value]!' => '',
				],
			]
		);

		$this->add_control(
			'icon_indent',
			[
				'label'     => __( 'Icon Spacing', 'dimax' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dimax-button .dimax-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .dimax-button .dimax-align-icon-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_css_id',
			[
				'label'       => __( 'Button ID', 'dimax' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'     => '',
				'title'       => __( 'Add your custom id WITHOUT the Pound key. e.g: my-id', 'dimax' ),
				'description' => __( 'Please make sure the ID is unique and not used elsewhere on the page this form is displayed. This field allows <code>A-z 0-9</code> & underscore chars without spaces.', 'dimax' ),
				'separator'   => 'before',

			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Button', 'dimax' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography',
				'selector' => '{{WRAPPER}} .dimax-button',
			]
		);


		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => __( 'Normal', 'dimax' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => __( 'Text Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .dimax-button' => 'fill: {{VALUE}};color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_color',
			[
				'label'     => __( 'Background Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dimax-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => __( 'Hover', 'dimax' ),
			]
		);

		$this->add_control(
			'hover_color',
			[
				'label'     => __( 'Text Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dimax-button:hover, {{WRAPPER}} .dimax-button:focus'         => 'color: {{VALUE}};',
					'{{WRAPPER}} .dimax-button:hover svg, {{WRAPPER}} .dimax-button:focus svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label'     => __( 'Background Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dimax-button:hover, {{WRAPPER}} .dimax-button:focus' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => __( 'Border Color', 'dimax' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .dimax-button:hover, {{WRAPPER}} .dimax-button:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'border',
				'selector'  => '{{WRAPPER}} .dimax-button',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label'      => __( 'Border Radius', 'dimax' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .dimax-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'text_padding',
			[
				'label'      => __( 'Padding', 'dimax' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .dimax-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render button widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();


		if ( ! empty( $settings['link']['url'] ) ) {
			$this->add_link_attributes( 'button', $settings['link'] );
			$this->add_render_attribute( 'button', 'class', 'dimax-button-link' );
		}

		$this->add_render_attribute( 'button', 'class', 'dimax-button' );

		if ( ! empty( $settings['button_css_id'] ) ) {
			$this->add_render_attribute( 'button', 'id', $settings['button_css_id'] );
		}

		if ( ! empty( $settings['size'] ) ) {
			$this->add_render_attribute( 'button', 'class', 'button-' . $settings['size'] );
		}

		if ( ! empty( $settings['button_style'] ) ) {
			$this->add_render_attribute( 'button', 'class', 'button-' . $settings['button_style'] );
		}

		?>
        <a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
			<?php $this->render_text(); ?>
        </a>
		<?php
	}

	/**
	 * Render button widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 2.9.0
	 * @access protected
	 */
	protected function content_template() {
	}

	/**
	 * Render button text.
	 *
	 * Render button widget text.
	 *
	 * @since 1.5.0
	 * @access protected
	 */
	protected function render_text() {
		$settings = $this->get_settings_for_display();
		$is_new   = Icons_Manager::is_migration_allowed();
		$this->add_render_attribute( [
			'content-wrapper' => [
				'class' => 'dimax-button-content-wrapper',
			],
			'icon-align'      => [
				'class' => [
					'dimax-svg-icon',
					'dimax-align-icon-' . $settings['icon_align'],
				],
			],
			'text'            => [
				'class' => 'dimax-button-text',
			],
		] );

		$this->add_inline_editing_attributes( 'text', 'none' );
		$button_text = sprintf('<span %s>%s</span>', $this->get_render_attribute_string( 'text' ), $settings['text']);
		?>
		<?php
			if($settings['icon_align'] == 'right') {
				echo $button_text;
			}
		?>
		<?php if (  ! empty( $settings['selected_icon']['value'] ) ) : ?>
            <span <?php echo $this->get_render_attribute_string( 'icon-align' ); ?>>
				<?php if ( $is_new ) :
					Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
				endif; ?>
			</span>
		<?php endif; ?>
		<?php
			if($settings['icon_align'] != 'right') {
				echo $button_text;
			}
	}

}
