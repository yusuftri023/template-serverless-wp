<?php

namespace WeddingPress\elementor;

use Elementor\Icons_Manager;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Utils;
use Elementor\Widget_Base;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class WeddingPress_Widget_Date_Kit2 extends Widget_Base {

	public function get_name() {
		return 'weddingpress-datekit2';
	}

	public function get_title() {
		return __( 'Date Kit 2', 'weddingpress' );
	}

	public function get_icon() {
		return 'wdp_icon eicon-calendar';
	}
	
	public function get_categories() {
		return [ 'weddingpress' ];
	}

	// public function get_script_depends() {
 //        return [ 'weddingpress-wdp' ];
 //    }

	public function get_custom_help_url() {
        return 'https://weddingpress.net/panduan';
	}

	public static function get_button_sizes() {
		return [
			'xs' => __( 'Extra Small', 'weddingpress' ),
			'sm' => __( 'Small', 'weddingpress' ),
			'md' => __( 'Medium', 'weddingpress' ),
			'lg' => __( 'Large', 'weddingpress' ),
			'xl' => __( 'Extra Large', 'weddingpress' ),
		];
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
				'section_info_datekit',
				[
					'label' => __( 'Informasi', 'weddingpress' ),
				]
		);
         $this->add_control(
            'important_description',
            [
                'raw' => __( '<b>Info:</b> Widget ini hanya untuk digunakan dengan data dari Custom FIelds Dynamic Tags<br>Silahkan Gunakan Date Kit versi pertama untuk penggunaan normal', 'weddingpress'),
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                'render_type'     => 'ui',
                'type'            => Controls_Manager::RAW_HTML,
            ]
        );
        $this->end_controls_section();
		$this->start_controls_section(
				'section_button',
				[
					'label' => __( 'Button', 'weddingpress' ),
				]
		);
		$this->add_control(
				'button_type',
				[
					'label' => __( 'Type', 'weddingpress' ),
					'type' => Controls_Manager::SELECT,
					'default' => '',
					'options' => [
						'' => __( 'Default', 'weddingpress' ),
						'info' => __( 'Info', 'weddingpress' ),
						'success' => __( 'Success', 'weddingpress' ),
						'warning' => __( 'Warning', 'weddingpress' ),
						'danger' => __( 'Danger', 'weddingpress' ),
					],
					'prefix_class' => 'elementor-button-',
				]
		);

		$this->add_control(
				'text',
				[
					'label' => __( 'Text', 'weddingpress' ),
					'type' => Controls_Manager::TEXT,
					'default' => __( 'Simpan di Kalender', 'weddingpress' ),
					'placeholder' => __( 'Simpan di Kalender', 'weddingpress' ),
                    //Neo - Added Dynamic Tags
    				'dynamic' => [
    					'active' => true,
    				],
				]
		);

		$this->add_control(
				'link',
				[
					'label' => __( 'Link', 'weddingpress' ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before',
                    //Neo - Added Dynamic Tags
    				'dynamic' => [
    					'active' => true,
    				],
				]
		);
		$this->add_control(
				'is_external',
				[
					'label' => __( 'Open in a new window', 'weddingpress' ),
					'type' => Controls_Manager::SWITCHER,
				]
		);
		$this->add_control(
				'nofollow',
				[
					'label' => __( 'Add nofollow', 'weddingpress' ),
					'type' => Controls_Manager::SWITCHER,
				]
		);
		$this->add_control(
				'download',
				[
					'label' => __( 'Force Download', 'weddingpress' ),
					'type' => Controls_Manager::SWITCHER,
					'separator' => 'after',
				]
		);

		$this->add_responsive_control(
				'align',
				[
					'label' => __( 'Alignment', 'weddingpress' ),
					'type' => Controls_Manager::CHOOSE,
					'options' => [
						'left' => [
							'title' => __( 'Left', 'weddingpress' ),
							'icon' => 'eicon-text-align-left',
						],
						'center' => [
							'title' => __( 'Center', 'weddingpress' ),
							'icon' => 'eicon-text-align-center',
						],
						'right' => [
							'title' => __( 'Right', 'weddingpress' ),
							'icon' => 'eicon-text-align-right',
						],
						'justify' => [
							'title' => __( 'Justified', 'weddingpress' ),
							'icon' => 'eicon-text-align-justify',
						],
					],
					'prefix_class' => 'elementor%s-align-',
					'default' => 'center',
				]
		);

		$this->add_control(
				'size',
				[
					'label' => __( 'Size', 'weddingpress' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'sm',
					'options' => self::get_button_sizes(),
					'style_transfer' => true,
				]
		);

		$this->add_control(
				'selected_icon',
				[
					'label' => __( 'Icon', 'weddingpress' ),
					'type' => Controls_Manager::ICONS,
					'label_block' => true,
					'fa4compatibility' => 'icon',
				]
		);

		$this->add_control(
			'icon_align',
			[
				'label' => esc_html__( 'Icon Position', 'weddingpress' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => is_rtl() ? 'row-reverse' : 'row',
				'options' => [
					'row' => [
						'title' => esc_html__( 'Start', 'weddingpress' ),
						'icon' => "eicon-h-align-left",
					],
					'row-reverse' => [
						'title' => esc_html__( 'End', 'weddingpress' ),
						'icon' => "eicon-h-align-right",
					],
				],
				'selectors_dictionary' => [
					'left' => is_rtl() ? 'row-reverse' : 'row',
					'right' => is_rtl() ? 'row' : 'row-reverse',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-button-content-wrapper' => 'flex-direction: {{VALUE}};',
				],

			]
		);

		$this->add_control(
			'icon_indent',
			[
				'label' => esc_html__( 'Icon Spacing', 'weddingpress' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'max' => 50,
					],
					'em' => [
						'max' => 5,
					],
					'rem' => [
						'max' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-button .elementor-button-content-wrapper' => 'gap: {{SIZE}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
				'view',
				[
					'label' => __( 'View', 'weddingpress' ),
					'type' => Controls_Manager::HIDDEN,
					'default' => 'traditional',
				]
		);

		$this->end_controls_section();

		$this->start_controls_section(
				'section_style',
				[
					'label' => __( 'Button', 'weddingpress' ),
					'tab' => Controls_Manager::TAB_STYLE,
				]
		);

		$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'typography',
					'selector' => '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button',
				]
		);

		$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				[
					'name' => 'text_shadow',
					'selector' => '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button',
				]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
				'tab_button_normal',
				[
					'label' => __( 'Normal', 'weddingpress' ),
				]
		);

		$this->add_control(
				'button_text_color',
				[
					'label' => __( 'Text Color', 'weddingpress' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'fill: {{VALUE}}; color: {{VALUE}};',
					],
				]
		);

		$this->add_control(
				'background_color',
				[
					'label' => __( 'Background Color', 'weddingpress' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'background-color: {{VALUE}};',
					],
				]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
				'tab_button_hover',
				[
					'label' => __( 'Hover', 'weddingpress' ),
				]
		);

		$this->add_control(
				'hover_color',
				[
					'label' => __( 'Text Color', 'weddingpress' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover, {{WRAPPER}} a.elementor-button:focus, {{WRAPPER}} .elementor-button:focus' => 'color: {{VALUE}};',
						'{{WRAPPER}} a.elementor-button:hover svg, {{WRAPPER}} .elementor-button:hover svg, {{WRAPPER}} a.elementor-button:focus svg, {{WRAPPER}} .elementor-button:focus svg' => 'fill: {{VALUE}};',
					],
				]
		);

		$this->add_control(
				'button_background_hover_color',
				[
					'label' => __( 'Background Color', 'weddingpress' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover, {{WRAPPER}} a.elementor-button:focus, {{WRAPPER}} .elementor-button:focus' => 'background-color: {{VALUE}};',
					],
				]
		);

		$this->add_control(
				'button_hover_border_color',
				[
					'label' => __( 'Border Color', 'weddingpress' ),
					'type' => Controls_Manager::COLOR,
					'condition' => [
						'border_border!' => '',
					],
					'selectors' => [
						'{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover, {{WRAPPER}} a.elementor-button:focus, {{WRAPPER}} .elementor-button:focus' => 'border-color: {{VALUE}};',
					],
				]
		);

		$this->add_control(
				'hover_animation',
				[
					'label' => __( 'Hover Animation', 'weddingpress' ),
					'type' => Controls_Manager::HOVER_ANIMATION,
				]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'border',
					'selector' => '{{WRAPPER}} .elementor-button',
					'separator' => 'before',
				]
		);

		$this->add_control(
				'border_radius',
				[
					'label' => __( 'Border Radius', 'weddingpress' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors' => [
						'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
		);

		$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'button_box_shadow',
					'selector' => '{{WRAPPER}} .elementor-button',
				]
		);

		$this->add_responsive_control(
				'text_padding',
				[
					'label' => __( 'Padding', 'weddingpress' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator' => 'before',
				]
		);

		$this->end_controls_section();

		$this->start_controls_section(
				'section_calendar_d',
				[
					'label' => __( 'Calendar', 'weddingpress' ),
				]
		);
        $this->add_control(
            'important_description_date_kit_2',
            [
                'raw' => __( '<b>Info:</b> Widget ini hanya untuk digunakan dengan data dari Custom FIelds Dynamic Tags<br>Silahkan Gunakan Date Kit versi pertama untuk penggunaan normal', 'weddingpress'),
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                'render_type'     => 'ui',
                'type'            => Controls_Manager::RAW_HTML,
            ]
        );
		$format = array(
			'gcalendar' => 'Google Calendar',
			'ics' => 'ICS (iCal, Outlook, etc)',
		);
		// $this->add_control(
		// 		'wdp_calendar_format',
		// 		[
		// 			'label' => __( 'Type', 'weddingpress' ),
		// 			'type' => Controls_Manager::CHOOSE,
		// 			'options' => [
		// 				'gcalendar' => [
		// 					'title' => __( 'Google Calendar', 'weddingpress' ),
		// 					'icon' => 'eicon-globe',
		// 				],
		// 				'ics' => [
		// 					'title' => __( 'ICS (iCal, Outlook, etc)', 'weddingpress' ),
		// 					'icon' => 'fa fa-calendar',
		// 				],
		// 			],
		// 			'label_block' => true,
		// 			'default' => 'gcalendar',
		// 			'toggle' => false,
		// 		]
		// );

		$this->add_control(
				'wdp_calendar_title_d', [
					'label' => __( 'Title', 'weddingpress' ),
					'type' => Controls_Manager::TEXT,
					'label_block' => true,
                    //Neo - Added Dynamic Tags
    				'dynamic' => [
    					'active' => true,
    				],
				]
		);

		$this->add_control(
				'wdp_calendar_datetime_format_d',
				[
					'label' => __( 'Datetime Field', 'weddingpress' ),
					'type' => Controls_Manager::CHOOSE,
					'options' => [
						'picker' => [
							'title' => __( 'Static Datetime Picker', 'weddingpress' ),
							'icon' => 'eicon-date',
						],

					],
					'label_block' => true,
					'default' => 'picker',
					'toggle' => false,
				]
		);
		$this->add_control(
				'wdp_calendar_datetime_start_d', [
					'label' => __( 'DateTime Start', 'weddingpress' ),
					'type' => Controls_Manager::DATE_TIME,
					'label_block' => true,
					'condition' => [
						'wdp_calendar_datetime_format_d' => 'picker',
					],
					//Neo - added dynamic tags
    				'dynamic' => [
    					'active' => true,
    				],
					
				]
		);
		$this->add_control(
				'wdp_calendar_datetime_end_d', [
					'label' => __( 'DateTime End', 'weddingpress' ),
					'type' => Controls_Manager::DATE_TIME,
					'label_block' => true,
					'condition' => [
						'wdp_calendar_datetime_format_d' => 'picker',
					],
					//Neo - added dynamic tags
    				'dynamic' => [
    					'active' => true,
    				],
				]
		);
		$this->add_control(
				'wdp_calendar_datetime_string_format_d', [
					'label' => __( 'DateTime Format', 'weddingpress' ),
					'type' => Controls_Manager::TEXT,
					'default' => 'Y-m-d H:i',
					'placeholder' => 'Y-m-d H:i',
					'label_block' => true,
					'condition' => [
						'wdp_calendar_datetime_format_d' => 'string',
					],
                    //Neo - Added Dynamic Tags
    				'dynamic' => [
    					'active' => true,
    				],
				]
		);
		$this->add_control(
				'wdp_calendar_datetime_start_string_d', [
					'label' => __( 'DateTime Start', 'weddingpress' ),
					'type' => Controls_Manager::TEXT,
					'label_block' => true,
					'condition' => [
						'wdp_calendar_datetime_format_d' => 'string',
					],
                    //Neo - Added Dynamic Tags
    				'dynamic' => [
    					'active' => true,
    				],
				]
		);
		$this->add_control(
				'wdp_calendar_datetime_end_string_d', [
					'label' => __( 'DateTime End', 'weddingpress' ),
					'type' => Controls_Manager::TEXT,
					'label_block' => true,
					'condition' => [
						'wdp_calendar_datetime_format_d' => 'string',
					],
                    //Neo - Added Dynamic Tags
    				'dynamic' => [
    					'active' => true,
    				],
				]
		);

		$this->add_control(
				'wdp_calendar_description_d', [
					'label' => __( 'Description', 'weddingpress' ),
					'type' => Controls_Manager::WYSIWYG,
                    //Neo - Added Dynamic Tags
    				'dynamic' => [
    					'active' => true,
    				],
				]
		);
		$this->add_control(
				'wdp_calendar_location_d', [
					'label' => __( 'Location', 'weddingpress' ),
					'type' => Controls_Manager::TEXT,
					'label_block' => true,
                    //Neo - Added Dynamic Tags
    				'dynamic' => [
    					'active' => true,
    				],
				]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		// if ( $settings['wdp_calendar_format'] == 'ics' ) {
		// 	$cal_url = ELKIT_URL_FILE . 'elementor/ics.php';
		// 	$cal_url .= '?post_id=' . get_current_post_id();
		// 	$cal_url .= '&element_id=' . $this->get_id();
		// 	if ( is_singular() ) {
		// 		$cal_url .= '&queried_id=' . get_the_ID();
		// 	}
		// } else {
			$cal_url = 'https://www.google.com/calendar/render?action=TEMPLATE';

			if ( $settings['wdp_calendar_title_d'] ) {
				$cal_url .= '&text=' . urlencode( $settings['wdp_calendar_title_d'] );
			}
			if ( $settings['wdp_calendar_description_d'] ) {
				$cal_url .= '&details=' . urlencode( $settings['wdp_calendar_description_d'] );
			}
			if ( $settings['wdp_calendar_location_d'] ) {
				$cal_url .= '&location=' . urlencode( $settings['wdp_calendar_location_d'] );
			}

			// FORMAT
			$date_format = $settings['wdp_calendar_datetime_string_format_d'];
			if ( empty( $date_format ) ) {
				$date_format = 'Y-m-d H:i';
			}
			// START
			$start = ( $settings['wdp_calendar_datetime_format_d'] != 'string' ) ? $settings['wdp_calendar_datetime_start_d'] : $settings['wdp_calendar_datetime_start_string_d'];
			$start = str_replace("T"," ",$start);
			if (\DateTime::createFromFormat('Y-m-d H:i:s', $start) !== false) {
              if(strlen($start) == 19) {
              	$start = substr_replace($start, '', 16);
              }
            }
			$init_start = $start;
			if ( empty( $start ) ) {
				$start = new \DateTime();
			} else {
				$start = \DateTime::createFromFormat( $date_format, $start );
			}
			if ( $start ) {
				$cal_url .= '&dates=' . urlencode( get_gmt_from_date( $start->format( 'Y-m-d H:i' ), 'Ymd\\THi00\\Z' ) );
			}
			// END
			$end = ( $settings['wdp_calendar_datetime_format_d'] != 'string' ) ? $settings['wdp_calendar_datetime_end_d'] : $settings['wdp_calendar_datetime_end_string_d'];
			$end = str_replace("T"," ",$end);
			if (\DateTime::createFromFormat('Y-m-d H:i:s', $end) !== false) {
              if(strlen($end) == 19) {
              	$end = substr_replace($end, '', 16);
              }
            }
			$init_end = $end;
			if ( empty( $end ) && $start ) {
				$end = new \DateTime( $start->format( 'Y-m-d H:i' ) );
				$end = $end->modify( '+ 1 day' );
			} elseif ( empty( $end ) && ! $start ) {
				$end = new \DateTime();
			} else {
				$end = \DateTime::createFromFormat( $date_format, $end );
			}
			if ( $end ) {
				$cal_url .= '%2F' . urlencode( get_gmt_from_date( $end->format( 'Y-m-d H:i' ), 'Ymd\\THi00\\Z' ) );
			}

			if ( ( ! $start || ! $end ) && \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
				?>
				<div class="elementor-alert elementor-alert-danger">
					<h5 class="elementor-alert-title">Warning</h5>
					<b>Field ini hanya bisa diisi menggunakan data dinamis</b><br>
					<?php if ( ! $start ) {
						?><b>Gunakan Dynamic Tags <i class="eicon-database" aria-hidden="true"></i> untuk isi tanggal dengan format Y-m-d H:i</b><br>Data yang terbaca: <?php echo $init_start; ?><br><?php } ?>
				<?php if ( ! $end ) {
					?>End date salah: <b>Gunakan Dynamic Tags <i class="eicon-database" aria-hidden="true"></i> untuk isi tanggal dengan format Y-m-d H:i</b><?php } ?>
				</div>
				<?php
			}
			if ( get_option( 'timezone_string' ) ) {
				$cal_url .= '&ctz=' . get_option( 'timezone_string' );
			}
		// }

		$this->add_render_attribute( 'wrapper', 'class', 'elementor-button-wrapper' );
		$this->add_render_attribute( 'button', 'href', $cal_url );
		$this->add_render_attribute( 'button', 'class', 'elementor-button-link' );
		$this->add_render_attribute( 'button', 'target', '_blank' );
		$this->add_render_attribute( 'button', 'rel', 'nofollow' );
		$this->add_render_attribute( 'button', 'class', 'elementor-button' );
		$this->add_render_attribute( 'button', 'role', 'button' );

		if ( ! empty( $settings['size'] ) ) {
			$this->add_render_attribute( 'button', 'class', 'elementor-size-' . sanitize_text_field( $settings['size'] ) );
		}

		if ( $settings['hover_animation'] ) {
			$this->add_render_attribute( 'button', 'class', 'elementor-animation-' . sanitize_text_field( $settings['hover_animation'] ) );
		}
		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
		<?php $this->render_text(); ?>
			</a>
		</div>
		<?php
	}

	protected function render_text() {
		$settings = $this->get_settings_for_display();

		$migrated = isset( $settings['__fa4_migrated']['selected_icon'] );
		$is_new = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

		if ( ! $is_new && empty( $settings['icon_align'] ) ) {
			// @todo: remove when deprecated
			// added as bc in 2.6
			//old default
			$settings['icon_align'] = $this->get_settings( 'icon_align' );
		}

		$this->add_render_attribute([
			'content-wrapper' => [
				'class' => [ 'elementor-button-content-wrapper', 'wdp-flexbox' ],
			],
			'icon' => [
				'class' => 'elementor-button-icon',
			],
			'text' => [
				'class' => 'elementor-button-text',
			],
		]);

		$this->add_inline_editing_attributes( 'text', 'none' );
		?>
		<span <?php echo $this->get_render_attribute_string( 'content-wrapper' ); ?>>
				<?php if ( ! empty( $settings['icon'] ) || ! empty( $settings['selected_icon']['value'] ) ) : ?>
				<span <?php echo $this->get_render_attribute_string( 'icon-align' ); ?>>
					<?php
					if ( $is_new || $migrated ) :
						Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
					else :
						?>
						<i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
				<?php endif; ?>
				</span>
		<?php endif; ?>
			<span <?php echo $this->get_render_attribute_string( 'text' ); ?>><?php echo wp_kses_post( $settings['text'] ); ?></span>
		</span>
		<?php
	}

	public function on_import( $element ) {
		return Icons_Manager::on_import_migration( $element, 'icon', 'selected_icon' );
	}

}
