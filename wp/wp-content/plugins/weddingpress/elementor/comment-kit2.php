<?php

namespace WeddingPress\elementor;

// Elementor Classes.
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Utils;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Weddingpress_Widget_Comment_Kit2 extends Widget_Base {

	public function get_name() {
		return 'weddingpress-kit2';
	}

	public function get_title() {
		return __( 'Comment Kit 2', 'weddingpress' );
	}

	public function get_icon() {
		return 'wdp_icon eicon-testimonial';
	}

	public function get_categories() {
		return [ 'weddingpress' ];
	}
	
	public function get_keywords() {
		return [ 'Comment Box, buku tamu, ucapan selamat' ];
	}

    public function get_custom_help_url() {
        return 'https://member.elementorkit.net';
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
            'section_product',
            [
                'label' => __( 'Comment Kit 2', 'weddingpress' ),
            ]
        );

        $this->add_control(
			'important_description',
			[
				'raw' => __( '<b>PENTING!:</b> Widget Comment Kit 2, pastikan sudah mensetting comment di wordpress. Custom style ada di menu Comment Kit 2', 'weddingpress'),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				'render_type'     => 'ui',
				'type'            => Controls_Manager::RAW_HTML,
			]
		);

        $this->add_control(
            'style_type',
            [
                'label' => __( 'Style', 'weddingpress' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => '— ' . __( 'Select', 'weddingpress' ) . ' —',
                    'facebook' => __( 'Facebook', 'weddingpress' ),
                    'golden' => __( 'Golden', 'weddingpress' ),
                    'dark' => __( 'Dark', 'weddingpress' ),
                    'custom' => __( 'Custom', 'weddingpress' ),
                    
                ],
                'default' => 'facebook',

            ]
        );

        $this->end_controls_section();

		$this->start_controls_section(
            'section_ck2_additional',
            [
                'label' => esc_html__('Additional Options', 'weddingpress')
            ]
        );

		$this->add_control(
			'ck2_text_translate',
			[
				'label' => esc_html__( 'Transalations', 'weddingpress' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
            'ck2_comments_text',
            [
                'label'       => esc_html__('Comments', 'weddingpress'),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => '',
                'default'     => 'Comments',
				'dynamic' => [
					'active' => true,
				],
            ]
        );

		$this->add_control(
            'ck2_hadir_text',
            [
                'label'       => esc_html__('Hadir', 'weddingpress'),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => '',
                'default'     => 'Hadir',
				'dynamic' => [
					'active' => true,
				],
            ]
        );

		$this->add_control(
            'ck2_tidak_hadir_text',
            [
                'label'       => esc_html__('Tidak Hadir', 'weddingpress'),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => '',
                'default'     => 'Tidak Hadir',
				'dynamic' => [
					'active' => true,
				],
            ]
        );

		$this->add_control(
            'ck2_ragu_text',
            [
                'label'       => esc_html__('Masih Ragu', 'weddingpress'),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => '',
                'default'     => 'Masih Ragu',
				'dynamic' => [
					'active' => true,
				],
            ]
        );

		$this->add_control(
            'ck2_nama_text',
            [
                'label'       => esc_html__('Nama', 'weddingpress'),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => '',
                'default'     => 'Nama',
				'dynamic' => [
					'active' => true,
				],
            ]
        );

		$this->add_control(
            'ck2_ucapan_text',
            [
                'label'       => esc_html__('Ucapan', 'weddingpress'),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => '',
                'default'     => 'Ucapan',
				'dynamic' => [
					'active' => true,
				],
            ]
        );

		$this->add_control(
            'ck2_konfirmasi_text',
            [
                'label'       => esc_html__('Konfirmasi Kehadiran', 'weddingpress'),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => '',
                'default'     => 'Konfirmasi Kehadiran',
				'dynamic' => [
					'active' => true,
				],
            ]
        );

		$this->add_control(
            'ck2_kirim_text',
            [
                'label'       => esc_html__('Kirim', 'weddingpress'),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => '',
                'default'     => 'Kirim',
				'dynamic' => [
					'active' => true,
				],
            ]
        );

		$this->add_control(
            'ck2_previous_text',
            [
				'raw' => __( '<b>Previous</b> edit di Comment Kit 2 Settings', 'weddingpress'),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				'render_type'     => 'ui',
				'type'            => Controls_Manager::RAW_HTML,
            ]
        );

		$this->add_control(
            'ck2_next_text',
            [
				'raw' => __( '<b>Next</b> edit di Comment Kit 2 Settings', 'weddingpress'),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				'render_type'     => 'ui',
				'type'            => Controls_Manager::RAW_HTML,
            ]
        );

        $this->add_control(
            'show_avatar',
            [
                'label'   => esc_html__('Avatar', 'weddingpress'),
				'type' => Controls_Manager::SWITCHER,
                'label_off' => esc_html__( 'Hide', 'weddingpress'),
                'label_on' => esc_html__( 'Show', 'weddingpress' ),
                'frontend_available' => true,
                'return_value' => 'yes',
                'default' => 'yes',
				'separator' => 'before',
            ]
        );

		$this->add_control(
			'attendence',
			[
				'label' => __( 'Attendence', 'weddingpress' ),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => esc_html__( 'Hide', 'weddingpress'),
                'label_on' => esc_html__( 'Show', 'weddingpress' ),
                'frontend_available' => true,
                'return_value' => 'yes',
                'default' => 'yes',
			]
		);

        $this->add_control(
            'show_date',
            [
                'label'   => esc_html__('Show Date', 'weddingpress'),
				'type' => Controls_Manager::SWITCHER,
                'label_off' => esc_html__( 'Hide', 'weddingpress'),
                'label_on' => esc_html__( 'Show', 'weddingpress' ),
                'frontend_available' => true,
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        
        $this->end_controls_section();

        $this->start_controls_section(
            'ck2_styles_general',
            [
                'label' => esc_html__( 'Body', 'weddingpress' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'ck2_styles_background',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .cui-wrapper',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
					// 'color' => [
					// 	'global' => [
					// 		'default' => '',
					// 	],
					// ],
				],
	
			]
		);

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
            'name' => 'ck2_styles_typography',
            'label' => __('Typography', 'weddingpress'),
            'selector' =>
                '{{WRAPPER}} .cui-wrapper .cui-wrap-link a.cui-link, {{WRAPPER}} .cui-wrapper.cui-wrap-form .cui-container-form input[type=button].cui-form-btn, .cui-wrapper .cui-wrap-form .cui-container-form input[type=submit]',
            'separator' => 'before',
        ]);

        $this->add_control('
			ck2_styles_color', [
            'label' => __('Text Color', 'weddingpress'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .cui-wrapper .cui-wrap-link a.cui-link' =>
                    'color: {{VALUE}};',
            ],
            'separator' => 'before',
        ]);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'body_border',
				'selector' => '{{WRAPPER}} .cui-wrapper.cui-border',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'ck2_styles_border_radius_body',
			[
				'label' => esc_html__( 'Border Radius', 'weddingpress' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .cui-wrapper.cui-border' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'ck2_body_styles_box_shadow',
				'selector' => '{{WRAPPER}} .cui-wrapper.cui-border',
                'separator' => 'before',
			]
		);
    
        $this->end_controls_section();


        $this->start_controls_section(
            'section_style',
			[
				'label' => esc_html__( 'Button', 'weddingpress' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector' => '{{WRAPPER}} .cui-wrapper .cui-wrap-form .cui-container-form input[type=button].cui-form-btn, .cui-wrapper .cui-wrap-form .cui-container-form input[type=submit]',
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => esc_html__( 'Alignment', 'weddingpress' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' => esc_html__( 'Left', 'weddingpress' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'weddingpress' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'weddingpress' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .cui-wrapper .cui-wrap-form .cui-container-form p.form-submit' => 'text-align: {{options}} !important;',
				],

			]
		);

		$this->start_controls_tabs( 'tabs_button_style', [
		] );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => esc_html__( 'Normal', 'weddingpress' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label' => esc_html__( 'Text Color', 'weddingpress' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .cui-wrapper .cui-wrap-form .cui-container-form input[type=button].cui-form-btn, {{WRAPPER}} .cui-wrapper .cui-wrap-form .cui-container-form input[type="submit"]' => 'fill: {{VALUE}}; color: {{VALUE}};',
				],

			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'button_background',
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .cui-wrapper .cui-wrap-form .cui-container-form input[type=button].cui-form-btn, {{WRAPPER}} .cui-wrapper .cui-wrap-form .cui-container-form input[type="submit"]',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],

			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'button_border',
				'selector' => '{{WRAPPER}} .cui-wrapper .cui-wrap-form .cui-container-form input[type=button].cui-form-btn, .cui-wrapper .cui-wrap-form .cui-container-form input[type=submit]',
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => esc_html__( 'Hover', 'weddingpress' ),
			]
		);

		$this->add_control(
			'hover_color',
			[
				'label' => esc_html__( 'Text Color', 'weddingpress' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cui-wrapper .cui-wrap-form .cui-container-form input[type=button].cui-form-btn:hover, {{WRAPPER}} .cui-wrapper .cui-wrap-form .cui-container-form input[type="submit"]:hover' => 'fill: {{VALUE}}; color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
            'button_background_hover_color',
            [
                'label' => __('Background Color', 'weddingpress'),
                'type' => Controls_Manager::COLOR,
                'selectors' => ['
                    {{WRAPPER}} .cui-wrapper .cui-wrap-form .cui-container-form input[type=button].cui-form-btn:hover, {{WRAPPER}} .cui-wrapper .cui-wrap-form .cui-container-form input[type="submit"]:hover' => 'background: {{VALUE}};',
                ],
            ]
        );

		$this->add_control(
			'button_hover_border_color',
			[
				'label' => esc_html__( 'Border Color', 'weddingpress' ),
				'type' => Controls_Manager::COLOR,
                'selectors' => ['
                    {{WRAPPER}} .cui-wrapper .cui-wrap-form .cui-container-form input[type=button].cui-form-btn:hover, {{WRAPPER}} .cui-wrapper .cui-wrap-form .cui-container-form input[type="submit"]:hover' => 'border-color: {{VALUE}};',
                ],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'weddingpress' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .cui-wrapper .cui-wrap-form .cui-container-form input[type=button].cui-form-btn, .cui-wrapper .cui-wrap-form .cui-container-form input[type=submit]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .cui-wrapper .cui-wrap-form .cui-container-form input[type=button].cui-form-btn, .cui-wrapper .cui-wrap-form .cui-container-form input[type=submit]',
			]
		);

		$this->add_responsive_control(
			'text_padding',
			[
				'label' => esc_html__( 'Padding', 'weddingpress' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .cui-wrapper .cui-wrap-form .cui-container-form input[type=button].cui-form-btn, .cui-wrapper .cui-wrap-form .cui-container-form input[type=submit]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'ck2_styles_form',
            [
                'label' => esc_html__( 'Form fields', 'weddingpress' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
			'ck2_styles_form_background',
			[
				'label' => esc_html__( 'Background Color', 'weddingpress' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .cui-wrapper .cui-wrap-form .cui-container-form input[type=text], {{WRAPPER}} .cui-wrapper .cui-wrap-form .cui-container-form textarea.cui-textarea, {{WRAPPER}} .cui-wrapper .cui-wrap-form .cui-container-form select.cui-select' => 'background: {{VALUE}};',
				],
			]
		);

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
            'name' => 'ck2_styles_form_typography',
            'label' => __('Typography', 'weddingpress'),
            'selector' =>
                '{{WRAPPER}} .cui-wrapper .cui-wrap-form .cui-container-form select.cui-select, {{WRAPPER}} .cui-wrapper .cui-wrap-form .cui-container-form select.cui-select, {{WRAPPER}} .cui-wrapper .cui-wrap-form .cui-container-form input[type=text], {{WRAPPER}} .cui-wrapper.cui-facebook .cui-wrap-form .cui-container-form textarea.cui-textarea, {{WRAPPER}} .cui-wrapper.cui-dark .cui-wrap-form .cui-container-form textarea.cui-textarea, {{WRAPPER}} .cui-wrapper .cui-wrap-form .cui-container-form textarea.cui-textarea',
        ]);

        $this->add_control('ck2_styles_form_color', [
            'label' => __('Text Color', 'weddingpress'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .cui-wrapper .cui-wrap-form .cui-container-form input[type=text], {{WRAPPER}} .cui-wrapper .cui-wrap-form .cui-container-form textarea.cui-textarea' =>
                    'color: {{VALUE}};',
            ],
        ]);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'ck2_styles_form_border_color',
				'selector' => '{{WRAPPER}} .cui-wrapper .cui-wrap-form .cui-container-form input[type=text], {{WRAPPER}} .cui-wrapper .cui-wrap-form .cui-container-form textarea.cui-textarea, {{WRAPPER}} .cui-wrapper .cui-wrap-form .cui-container-form select.cui-select',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'ck2_styles_border_radius_form',
			[
				'label' => esc_html__( 'Border Radius', 'weddingpress' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .cui-wrapper .cui-wrap-form .cui-container-form input#author, .cui-wrapper .cui-wrap-form .cui-container-form input#email, .cui-wrapper .cui-wrap-form .cui-container-form input#url, {{WRAPPER}} .cui-wrapper .cui-wrap-form .cui-container-form textarea.cui-textarea, {{WRAPPER}} .cui-wrapper .cui-wrap-form .cui-container-form select.cui-select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'ck2_form_styles_box_shadow',
				'selector' => '{{WRAPPER}} .cui-wrapper.cui-border',
			]
		);
    
        $this->end_controls_section();

        $this->start_controls_section(
            'ck2_styles_comment',
            [
                'label' => esc_html__( 'Comment', 'weddingpress' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'ck2_styles_comment_background',
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .cui-wrapper ul.cui-container-comments',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
					'color' => [
						'global' => [
							'default' => '',
						],
					],
				],
			]
		);

		$this->add_control(
			'ck2_styles_comment_background_even',
			[
				'label' => esc_html__( 'Background even', 'weddingpress' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .cui-container-comments li:nth-child(even)' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'ck2_styles_comment_background_odd',
			[
				'label' => esc_html__( 'Background odd', 'weddingpress' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .cui-container-comments li:nth-child(odd)' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'ck2_styles_comment_border_even',
				'selector' => '{{WRAPPER}} .cui-wrapper ul.cui-container-comments li.cui-item-comment',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'ck2_styles_comment_padding',
			[
				'label' => esc_html__( 'Height', 'weddingpress' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh', 'dvh', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'vh' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'vh',
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .cui-box' => 'max-height: {{SIZE}}{{UNIT}}',
				],
				'description' => sprintf(
					esc_html__( 'Pengaturan Height berfungsi jika Pagination OFF', 'weddingpress' ),
					'<code>',
					'</code>'
				),
			]
		);

		$this->add_responsive_control(
			'ck2_styles_comment_padding_content',
			[
				'label' => esc_html__( 'Padding Wrap', 'weddingpress' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .cui-wrapper ul.cui-container-comments li.cui-item-comment .cui-comment-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'ck2_styles_comment_padding_content_wrap',
			[
				'label' => esc_html__( 'Padding Content', 'weddingpress' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .cui-wrapper ul.cui-container-comments li.cui-item-comment .cui-comment' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'ck2_text_heading',
			[
				'label' => esc_html__( 'Guest', 'weddingpress' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'ck2_guest_color',
			[
				'label' => esc_html__( 'Color', 'weddingpress' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cui-wrapper ul.cui-container-comments li.cui-item-comment .cui-comment-content .cui-comment-info a.cui-commenter-name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'ck2_guest_typography',
				'selector' => '{{WRAPPER}} .cui-wrapper ul.cui-container-comments li.cui-item-comment .cui-comment-content .cui-comment-info a.cui-commenter-name',
				'exclude' => [
					'line_height',
				],
			]
		);

        $this->add_control(
			'ck2_time_heading',
			[
				'label' => esc_html__( 'Time', 'weddingpress' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'ck2_time_color',
			[
				'label' => esc_html__( 'Color', 'weddingpress' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cui-comment-time' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'ck2_time_typography',
				'selector' => '{{WRAPPER}} .cui-comment-time',
				'exclude' => [
					'line_height',
				],
			]
		);

        $this->add_control(
			'ck2_content_heading',
			[
				'label' => esc_html__( 'Content', 'weddingpress' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'ck2_content_color',
			[
				'label' => esc_html__( 'Color', 'weddingpress' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cui-wrapper ul.cui-container-comments li.cui-item-comment .cui-comment-content .cui-comment-text p' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'ck2_content_typography',
				'selector' => '{{WRAPPER}} .cui-wrapper ul.cui-container-comments li.cui-item-comment .cui-comment-content .cui-comment-text p',
				'exclude' => [
					'line_height',
				],
			]
		);

        $this->add_control(
			'ck2_avatar_heading',
			[
				'label' => esc_html__( 'Avatar', 'weddingpress' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
            'ck2_image_size',
            [
                'label'     => esc_html__('Size', 'weddingpress'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 28,
                ],
                'range'     => [
                    'px' => [
                        'min'  => 28,
                        'max'  => 100,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .cui-wrapper ul.cui-container-comments li.cui-item-comment .cui-comment-avatar img' => 'max-width: {{SIZE}}px; max-height: {{SIZE}}px',
                ],
            ]
        );

        $this->add_control(
            'ck2_image_opacity',
            [
                'label'     => esc_html__('Opacity', 'weddingpress'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 1,
                ],
                'range'     => [
                    'px' => [
                        'min'  => 0.1,
                        'max'  => 1,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .cui-wrapper ul.cui-container-comments li.cui-item-comment .cui-comment-avatar img' => 'opacity: {{SIZE}}; height: 100px',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'ck2_image_border',
                'label'       => esc_html__('Border', 'weddingpress'),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .cui-wrapper ul.cui-container-comments li.cui-item-comment .cui-comment-avatar img',
            ]
        );

        $this->add_responsive_control(
            'ck2_image_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'weddingpress'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .cui-wrapper ul.cui-container-comments li.cui-item-comment .cui-comment-avatar img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow: hidden;',
                ],
            ]
        );

		$this->add_control(
			'ck2_links_heading',
			[
				'label' => esc_html__( 'Links', 'weddingpress' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
			'ck2_edit_color',
			[
				'label' => esc_html__( 'Edit', 'weddingpress' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cui-wrapper ul.cui-container-comments li.cui-item-comment .cui-comment-content .cui-comment-actions a' => 'color: {{VALUE}};',
				],
                'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'ck2_ink_typography',
				'selector' => '{{WRAPPER}} .cui-wrapper ul.cui-container-comments li.cui-item-comment .cui-comment-content .cui-comment-actions a',
				'exclude' => [
					'line_height',
				],
			]
		);
    
        $this->end_controls_section();

		$this->start_controls_section(
			'ck2_badge_hadir_style',
			[
				'label' => __('Hadir', 'weddingpress'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'ck2_hadir_color',
			[
				'label' => __( 'Color', 'weddingpress' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cui_card-hadir'  => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'ck2_hadir_count',
			[
				'label' => esc_html__( 'Number Count', 'weddingpress' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'ck2_hadir_count_typography',
				'selector' => '{{WRAPPER}} .cui_card-hadir span:first-child',
				'exclude' => [
					'line_height',
				],
			]
		);

		$this->add_control(
			'ck2_count_hadir_text',
			[
				'label' => esc_html__( 'Text Hadir', 'weddingpress' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'ck2_hadir_typography',
				'selector' => '{{WRAPPER}} .cui_card-hadir span:last-child',
				'exclude' => [
					'line_height',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'ck2_hadir_background',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .cui_card-hadir',
				'separator' => 'before',
			]
		);
        
    	$this->end_controls_section();
    
		$this->start_controls_section(
			'ck2_badge_tidak_hadir_style',
			[
				'label' => __('Tidak Hadir', 'weddingpress'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'ck2_tidak_hadir_color',
			[
				'label' => __( 'Color', 'weddingpress' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cui_card-tidak_hadir'  => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'ck2_tidak_hadir_count',
			[
				'label' => esc_html__( 'Number Count', 'weddingpress' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'ck2_tidak_hadir_count_typography',
				'selector' => '{{WRAPPER}} .cui_card-tidak_hadir span:first-child',
				'exclude' => [
					'line_height',
				],
			]
		);

		$this->add_control(
			'ck2_count_tidak_hadir_text',
			[
				'label' => esc_html__( 'Text Tidak Hadir', 'weddingpress' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'ck2_tidak_hadir_typography',
				'selector' => '{{WRAPPER}} .cui_card-tidak_hadir span:last-child',
				'exclude' => [
					'line_height',
				],
			]
		);
			
		$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'ck2_tidak_hadir_background',
					'types' => [ 'classic', 'gradient' ],
					'selector' => '{{WRAPPER}} .cui_card-tidak_hadir',
					'separator' => 'before',
				]
			);
			
		$this->end_controls_section();

		$this->start_controls_section(
			'ck2_ragu_style',
			[
				'label' => __('Masih Ragu', 'weddingpress'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'ck2_ragu_color',
			[
				'label' => __( 'Color', 'weddingpress' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cui_card-masih_ragu'  => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'ck2_ragu_count',
			[
				'label' => esc_html__( 'Number Count', 'weddingpress' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'ck2_ragu_count_typography',
				'selector' => '{{WRAPPER}} .cui_card-masih_ragu span:first-child',
				'exclude' => [
					'line_height',
				],
			]
		);

		$this->add_control(
			'ck2_count_ragu_text',
			[
				'label' => esc_html__( 'Text Ragu', 'weddingpress' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'ck2_ragu_typography',
				'selector' => '{{WRAPPER}} .cui_card-masih_ragu span:last-child',
				'exclude' => [
					'line_height',
				],
			]
		);
		
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'ck2_ragu_background',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .cui_card-masih_ragu',
				'separator' => 'before',
			]
		);
		
			
		$this->end_controls_section();
			
		$this->start_controls_section(
			'ck2_form_wrapper',
			[
				'label' => __('Form Wrapper', 'weddingpress'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'ck2_form_wrapper_border',
				'selector' => '{{WRAPPER}} .cui-wrap-form',
			]
		);

    	$this->end_controls_section();

		$this->start_controls_section(
			'ck2_form_pagination',
			[
				'label' => __('Pagination', 'weddingpress'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'ck2_form_pagination_text_color',
			[
				'label' => __( 'Previous Color', 'weddingpress' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cui-wrapper .cui-holder a.jp-previous.jp-disabled, .cui-wrapper .cui-holder a.jp-previous.jp-disabled:hover'  => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'ck2_form_pagination_text_next_color',
			[
				'label' => __( 'Next Color', 'weddingpress' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cui-wrapper .cui-holder a.jp-next'  => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'ck2_form_pagination_num_color',
			[
				'label' => __( 'Number Color', 'weddingpress' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cui-wrapper .cui-holder a, .cui-wrapper .cui-holder a:link, .cui-wrapper .cui-holder a:visited'  => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'ck2_form_pagination_typography',
				'selector' => '{{WRAPPER}} .cui-wrapper .cui-holder a.jp-previous.jp-disabled, .cui-wrapper .cui-holder a.jp-previous.jp-disabled:hover, .cui-wrapper .cui-holder a.jp-next.jp-disabled, .cui-wrapper .cui-holder a.jp-next.jp-disabled:hover, {{WRAPPER}} .cui-wrapper .cui-holder a, .cui-wrapper .cui-holder a:link, .cui-wrapper .cui-holder a:visited',
				'exclude' => [
					'line_height',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'ck2_form_pagination_background',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .cui-wrapper .cui-holder',
				'exclude' => [
					'image',
				],
			]
		);

    	$this->end_controls_section();
    }

    private function get_shortcode() {
        $settings = $this->get_settings();
        
        // $get = $settings['page_num'];
        $style = $settings['style_type'];
        $page = $style = $settings['style_type'];

        return '[ck2 style="'.$style.'"]';

    }

    protected function render() {
		global $post;
		setup_postdata( $post );
        $shortcode = $this->get_shortcode();
        $settings = $this->get_settings_for_display();

		$comments = $settings['ck2_comments_text'];
		$hadir = $settings['ck2_hadir_text'];
		$tidak_hadir = $settings['ck2_tidak_hadir_text'];
		$ragu = $settings['ck2_ragu_text'];
		$nama = $settings['ck2_nama_text'];
		$ucapan = $settings['ck2_ucapan_text'];
		$konfirmasi = $settings['ck2_konfirmasi_text'];
		$kirim = $settings['ck2_kirim_text'];

        $id = $this->get_id();

        if ( empty( $shortcode ) ) {
            return;
        }

        $html = do_shortcode( $shortcode );

        echo $html;

        $page = isset($settings['pagination']) ? $settings['pagination'] : 'yes';

        if ('yes' === $page) {

            ?>
            <style>
                .cui-wrapper .cui-holder {
                    display: block !important;
                }
            </style>

            <?php
        
        ?>

        
        <?php

        }

        $attendence = isset($settings['attendence']) ? $settings['attendence'] : 'yes';
        
        if (!('yes' === $attendence)) {
            ?>
            <style>
                .cui-comment-attendence {
                    display: none;
                }
                .cui-wrap-select {
                    display: none;
                }
                .cui-wrapper .cui-wrap-form .cui-container-form .cui-wrap-submit {
                    margin-bottom: 10px;
                    margin-top: 15px;
                }
            </style>

            <?php
        }

		$date = isset($settings['show_date']) ? $settings['show_date'] : 'yes';
        
        if (!('yes' === $date)) {
            ?>
            <style>
               .cui-comment-time{
                    display: none !important;
                }
            </style>

            <?php
        }

		$avatar = isset($settings['show_avatar']) ? $settings['show_avatar'] : 'yes';
        
        if (!('yes' === $avatar)) {
            ?>
            <style>.cui-comment-content{margin-left: 0!important;}.cui-comment-avatar{display:none !important;}</style>
            <?php
        }

		$postID = get_the_ID();

		?>
		<script>

			var txt=document.getElementById('cui-link-<?= $postID?>').innerHTML;
			var pos = txt
			.replace(/Comments/g, "<?php echo esc_attr($comments)?>")
			document.getElementById('cui-link-<?= $postID?>').innerHTML = pos;
			
			var txt1=document.getElementById('invitation-count-<?= $postID?>').innerHTML;
			var pos1 = txt1
			.replace(/Hadir/g, "<?php echo esc_attr($hadir)?>")
			.replace(/Tidak hadir/g, "<?php echo esc_attr($tidak_hadir)?>")
			.replace(/Masih Ragu/g, "<?php echo esc_attr($ragu)?>");
			document.getElementById('invitation-count-<?= $postID?>').innerHTML = pos1;

			var txt2=document.getElementById('commentform-<?= $postID?>').innerHTML;
			var pos2 = txt2
			.replace(/Nama/g, "<?php echo esc_attr($nama)?>")
			.replace(/Ucapan/g, "<?php echo esc_attr($ucapan)?>")
			.replace(/Konfirmasi Kehadiran/g, "<?php echo esc_attr($konfirmasi)?>")
			.replace(/Datang/g, "<?php echo esc_attr($hadir)?>")
			.replace(/Absen/g, "<?php echo esc_attr($tidak_hadir)?>")
			.replace(/Mungkin/g, "<?php echo esc_attr($ragu)?>")
			.replace(/Kirim/g, "<?php echo esc_attr($kirim)?>");
			document.getElementById('commentform-<?= $postID?>').innerHTML = pos2;

		</script>
        
        <?php
        
    }

    public function render_plain_content() {
        echo $this->get_shortcode();
    }

}
