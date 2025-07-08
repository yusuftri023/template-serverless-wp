<?php

namespace WeddingPress\elementor;

// Elementor Classes.
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Global_Colors;
use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Modules\DynamicTags\Module as TagsModule;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

/**
 * Class Countdown.
 */
class WeddingPress_Widget_Countdown_Timer extends Widget_Base {

	public function get_name() {
		return 'weddingpress-countdown';
	}

	public function get_title() {
		return __( 'Countdown', 'weddingpress' );
	}

	public function get_icon() {
		return 'wdp_icon eicon-countdown';
	}
	
	public function get_categories() {
		return [ 'weddingpress' ];
	}

	public function get_script_depends() {
        return [ 'weddingpress-wdp' ];
    }

	public function get_custom_help_url() {
        return 'https://weddingpress.net/panduan';
	}

	/**
     * Register button widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 0.1.0
     * @access protected
     */
	
	protected function register_controls() {

		
  		$this->start_controls_section(
  			'wpkoi_elements_section_countdown_settings_general',
  			[
  				'label' => esc_html__( 'Countdown Settings', 'weddingpress' )
  			]
  		);
		
		$this->add_control(
			'wpkoi_elements_countdown_due_time',
			[
				'label' => esc_html__( 'Countdown Target Date', 'weddingpress' ),
				'type' => Controls_Manager::DATE_TIME,
				'default' => date("Y-m-d", strtotime("+ 1 day")),
				'description' => esc_html__( 'Set the target date and time', 'weddingpress' ),
				'dynamic' => [
					'active' => true,
					'categories' => array(
						TagsModule::POST_META_CATEGORY,
					),
				],
			]
		);

		$this->add_control(
			'wpkoi_elements_countdown_label_view',
			[
				'label' => esc_html__( 'Position', 'weddingpress' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'wpkoi-elements-countdown-label-block',
				'options' => [
					'wpkoi-elements-countdown-label-block' => esc_html__( 'Block', 'weddingpress' ),
					'wpkoi-elements-countdown-label-inline' => esc_html__( 'Inline', 'weddingpress' ),
				],
			]
		);

		$this->add_responsive_control(
			'wpkoi_elements_countdown_label_padding_left',
			[
				'label' => esc_html__( 'Left spacing', 'weddingpress' ),
				'type' => Controls_Manager::SLIDER,
				'description' => esc_html__( 'Use when you select inline labels', 'weddingpress' ),
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-countdown-label' => 'padding-left:{{SIZE}}px;',
				],
				'condition' => [
					'wpkoi_elements_countdown_label_view' => 'wpkoi-elements-countdown-label-inline',
				],
			]
		);

		$this->add_control(
			'wpkoi_elements_countdown_days',
			[
				'label' => esc_html__( 'Display Days', 'weddingpress' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'wpkoi_elements_countdown_days_label',
			[
				'label' => esc_html__( 'Label for Days', 'weddingpress' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Hari', 'weddingpress' ),
				'condition' => [
					'wpkoi_elements_countdown_days' => 'yes',
				],
                //Neo - Added Dynamic Tags
				'dynamic' => [
					'active' => true,
				],
			]
		);
		

		$this->add_control(
			'wpkoi_elements_countdown_hours',
			[
				'label' => esc_html__( 'Display Hours', 'weddingpress' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'wpkoi_elements_countdown_hours_label',
			[
				'label' => esc_html__( 'Label for Hours', 'weddingpress' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Jam', 'weddingpress' ),
				'condition' => [
					'wpkoi_elements_countdown_hours' => 'yes',
				],
                //Neo - Added Dynamic Tags
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'wpkoi_elements_countdown_minutes',
			[
				'label' => esc_html__( 'Display Minutes', 'weddingpress' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'wpkoi_elements_countdown_minutes_label',
			[
				'label' => esc_html__( 'Label for Minutes', 'weddingpress' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Menit', 'weddingpress' ),
				'condition' => [
					'wpkoi_elements_countdown_minutes' => 'yes',
				],
                //Neo - Added Dynamic Tags
				'dynamic' => [
					'active' => true,
				],
			]
		);
			
		$this->add_control(
			'wpkoi_elements_countdown_seconds',
			[
				'label' => esc_html__( 'Display Seconds', 'weddingpress' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'wpkoi_elements_countdown_seconds_label',
			[
				'label' => esc_html__( 'Label for Seconds', 'weddingpress' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Detik', 'weddingpress' ),
				'condition' => [
					'wpkoi_elements_countdown_seconds' => 'yes',
				],
                //Neo - Added Dynamic Tags
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'wpkoi_elements_countdown_separator_heading',
			[
				'label' => __( 'Countdown Separator', 'weddingpress' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'wpkoi_elements_countdown_separator',
			[
				'label' => esc_html__( 'Display Separator', 'weddingpress' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'wpkoi-elements-countdown-show-separator',
				'default' => '',
			]
		);


		$this->end_controls_section();
		
		$this->start_controls_section(
			'wpkoi_elements_section_countdown_styles_general',
			[
				'label' => esc_html__( 'Countdown Styles', 'weddingpress' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_responsive_control(
			'wpkoi_elements_countdown_spacing',
			[
				'label' => esc_html__( 'Space Between Boxes', 'weddingpress' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 15,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-countdown-item > div' => 'margin-right:{{SIZE}}px; margin-left:{{SIZE}}px;',
					'{{WRAPPER}} .wpkoi-elements-countdown-container' => 'margin-right: -{{SIZE}}px; margin-left: -{{SIZE}}px;',
				],
			]
		);
		
		$this->add_responsive_control(
			'wpkoi_elements_countdown_container_margin_bottom',
			[
				'label' => esc_html__( 'Space Below Container', 'weddingpress' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-countdown-container' => 'margin-bottom:{{SIZE}}px;',
				],
			]
		);
		
		$this->add_responsive_control(
			'wpkoi_elements_countdown_box_padding',
			[
				'label' => esc_html__( 'Padding', 'weddingpress' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-countdown-item > div' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'wpkoi_elements_countdown_box_border',
				'label' => esc_html__( 'Border', 'weddingpress' ),
				'selector' => '{{WRAPPER}} .wpkoi-elements-countdown-item > div',
			]
		);

		$this->add_control(
			'wpkoi_elements_countdown_box_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'weddingpress' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-countdown-item > div' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);
		
		$this->end_controls_section();
		
		
		$this->start_controls_section(
			'wpkoi_elements_section_countdown_styles_content',
			[
				'label' => esc_html__( 'Color &amp; Typography', 'weddingpress' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'wpkoi_elements_countdown_box_bg_heading',
			[
				'label' => __( 'Element Background', 'weddingpress' ),
				'type' => Controls_Manager::HEADING,
			]
		);
		
		$this->add_control(
			'wpkoi_elements_countdown_background',
			[
				'label' => esc_html__( 'Element Background Color', 'weddingpress' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#111111',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-countdown-item > div' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'wpkoi_elements_countdown_digits_heading',
			[
				'label' => __( 'Countdown Digits', 'weddingpress' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'wpkoi_elements_countdown_digits_color',
			[
				'label' => esc_html__( 'Digits Color', 'weddingpress' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-countdown-digits' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             	'name' => 'wpkoi_elements_countdown_digit_typography',
				'label'                 => esc_html__( 'Typography', 'weddingpress' ),
				'global'                => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector' => '{{WRAPPER}} .wpkoi-elements-countdown-digits',
			]
		);	

		$this->add_control(
			'wpkoi_elements_countdown_label_heading',
			[
				'label' => __( 'Countdown Labels', 'weddingpress' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'wpkoi_elements_countdown_label_color',
			[
				'label' => esc_html__( 'Label Color', 'weddingpress' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-countdown-label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             	'name' => 'wpkoi_elements_countdown_label_typography',
				'label'                 => esc_html__( 'Typography', 'weddingpress' ),
				'global'                => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector' => '{{WRAPPER}} .wpkoi-elements-countdown-label',
			]
		);	


		$this->add_control(
			'wpkoi_elements_countdown_separator_c_heading',
			[
				'label' => __( 'Separator', 'weddingpress' ),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'wpkoi_elements_countdown_separator' => 'wpkoi-elements-countdown-show-separator',
				],
			]
		);

		$this->add_control(
			'wpkoi_elements_countdown_separator_color',
			[
				'label' => esc_html__( 'Separator Color', 'weddingpress' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'wpkoi_elements_countdown_separator' => 'wpkoi-elements-countdown-show-separator',
				],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-countdown-digits::after' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             	'name' => 'wpkoi_elements_countdown_separator_typography',
				'label'                 => esc_html__( 'Typography', 'weddingpress' ),
				'global'                => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector' => '{{WRAPPER}} .wpkoi-elements-countdown-digits::after',
				'condition' => [
					'wpkoi_elements_countdown_separator' => 'wpkoi-elements-countdown-show-separator',
				],
			]
		);	

		$this->end_controls_section();

	}


	/**
   * Render the widget output on the frontend.
   *
   * Written in PHP and used to generate the final HTML.
   *
   * @since 1.1.0
   *
   * @access protected
   */

	protected function render( ) {
		
      //$settings = $this->get_settings();
      $settings = $this->get_settings_for_display();
		
		$get_due_date =  esc_attr($settings['wpkoi_elements_countdown_due_time']);
		$due_date = date("M d Y G:i:s", strtotime($get_due_date));
	?>

	<div class="wpkoi-elements-countdown-wrapper">
		<div class="wpkoi-elements-countdown-container <?php echo esc_attr($settings['wpkoi_elements_countdown_label_view'] ); ?> <?php echo esc_attr($settings['wpkoi_elements_countdown_separator'] ); ?>">		
			<ul id="wpkoi-elements-countdown-<?php echo esc_attr($this->get_id()); ?>" class="wpkoi-elements-countdown-items" data-date="<?php echo esc_attr($due_date) ; ?>">
			    <?php if ( ! empty( $settings['wpkoi_elements_countdown_days'] ) ) : ?><li class="wpkoi-elements-countdown-item"><div class="wpkoi-elements-countdown-days"><span data-days class="wpkoi-elements-countdown-digits">00</span><?php if ( ! empty( $settings['wpkoi_elements_countdown_days_label'] ) ) : ?><span class="wpkoi-elements-countdown-label"><?php echo esc_attr($settings['wpkoi_elements_countdown_days_label'] ); ?></span><?php endif; ?></div></li><?php endif; ?>
			    <?php if ( ! empty( $settings['wpkoi_elements_countdown_hours'] ) ) : ?><li class="wpkoi-elements-countdown-item"><div class="wpkoi-elements-countdown-hours"><span data-hours class="wpkoi-elements-countdown-digits">00</span><?php if ( ! empty( $settings['wpkoi_elements_countdown_hours_label'] ) ) : ?><span class="wpkoi-elements-countdown-label"><?php echo esc_attr($settings['wpkoi_elements_countdown_hours_label'] ); ?></span><?php endif; ?></div></li><?php endif; ?>
			   <?php if ( ! empty( $settings['wpkoi_elements_countdown_minutes'] ) ) : ?><li class="wpkoi-elements-countdown-item"><div class="wpkoi-elements-countdown-minutes"><span data-minutes class="wpkoi-elements-countdown-digits">00</span><?php if ( ! empty( $settings['wpkoi_elements_countdown_minutes_label'] ) ) : ?><span class="wpkoi-elements-countdown-label"><?php echo esc_attr($settings['wpkoi_elements_countdown_minutes_label'] ); ?></span><?php endif; ?></div></li><?php endif; ?>
			   <?php if ( ! empty( $settings['wpkoi_elements_countdown_seconds'] ) ) : ?><li class="wpkoi-elements-countdown-item"><div class="wpkoi-elements-countdown-seconds"><span data-seconds class="wpkoi-elements-countdown-digits">00</span><?php if ( ! empty( $settings['wpkoi_elements_countdown_seconds_label'] ) ) : ?><span class="wpkoi-elements-countdown-label"><?php echo esc_attr($settings['wpkoi_elements_countdown_seconds_label'] ); ?></span><?php endif; ?></div></li><?php endif; ?>
			</ul>
			<div class="clearfix"></div>
		</div>
	</div>


	<script type="text/javascript">
	jQuery(document).ready(function ($) {
		'use strict';
		$("#wpkoi-elements-countdown-<?php echo esc_attr($this->get_id()); ?>").countdown();
	});
	</script>
	
	<?php
	
	}

	/**
   * Render the widget output in the editor.
   *
   * Written as a Backbone JavaScript template and used to generate the live preview.
   *
   * @since 1.1.0
   *
   * @access protected
   */
	protected function content_template() {
	}

}