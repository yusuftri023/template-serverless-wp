<?php

namespace WeddingPress\Elementor;

use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Icons_Manager;
use WeddingPress\Elementor\Skins;

class WeddingPress_Widget_Timeline extends Widget_Base {

	public function get_name() {
		return 'weddingpress-timeline';
	}

	public function get_title() {
		return __( 'Timeline', 'weddingpress' );
	}

	public function get_icon() {
		return 'wdp_icon eicon-time-line';
	}

	public function get_categories() {
		return [ 'weddingpress' ];
	}

	public function get_style_depends() {
        return ['ep-timeline', 'ep-font'];
    }

    public function get_script_depends() {
        return ['timeline', 'ep-timeline', 'bdt-uikit'];
    }

	public function get_custom_help_url() {
        return 'https://weddingpress.net/panduan';
	}

    public function register_skins() {
        $this->add_skin(new Skins\Skin_Olivier($this));
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
            'section_content_layout',
            [
                'label' => esc_html__('Layout Settings', 'weddingpress'),
            ]
        );

        $this->add_control(
            'timeline_align',
            [
                'label'     => esc_html__('Layout', 'weddingpress'),
                'type'      => Controls_Manager::CHOOSE,
                'default'   => 'center',
                'toggle'    => false,
                'options'   => [
                    'left'   => [
                        'title' => esc_html__('Left', 'weddingpress'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'weddingpress'),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'right'  => [
                        'title' => esc_html__('Right', 'weddingpress'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'condition' => [
                    '_skin' => '',
                ]
            ]
        );

        $this->add_control(
            'visible_items',
            [
                'label'     => esc_html__('Visible Items', 'weddingpress'),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 4,
                'condition' => [
                    '_skin' => 'bdt-olivier',
                ],
                //Neo - Added Dynamic Tags
				'dynamic' => [
					'active' => true,
				],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
			'twae_content_section',
			[
				'label' => __( 'Timeline Story Contents', 'weddingpress' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'twae_story_title',
			[
				'label' => __( 'Story Title', 'weddingpress' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Timeline Story',
                //Neo - Added Dynamic Tags
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'twae_date_label',
			[
				'label' => __( 'Story Date', 'weddingpress' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '31 December 2018',
                //Neo - Added Dynamic Tags
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'twae_description',
			[
				'label' => __( 'Description', 'weddingpress' ),
				'type'    => Controls_Manager::WYSIWYG,
				'default' => 'Add Description Here',
                //Neo - Added Dynamic Tags
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'twae_image',
			[
				'label' => __( 'Choose Image', 'weddingpress' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'description' => __('Image Size will not work with default image','weddingpress'),
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
                //Neo - Added Dynamic Tags
				'dynamic' => [
					'active' => true,
				],
			]
		);
			
		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'twae_thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'separator' => 'none',
			]
		);

		$repeater->add_control(
			'twae_story_icon',
			[
				'label' => __( 'Icon', 'weddingpress' ),
				'type' => \Elementor\Controls_Manager::ICONS,
                'fa4compatibility' => 'timeline_icon',
                'default'          => [
                    'value'   => 'fas fa-heart',
                    'library' => 'fa-solid',
                ],
			]
		);		

        $repeater->add_control(
            'timeline_link_hide',
            [
                'label'       => esc_html__('Show Button Link', 'weddingpress'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $repeater->add_control(
            'timeline_text',
            [
                'label'       => esc_html__('Button Text', 'weddingpress'),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => '',
                'default'     => 'Selengkapnya',
                'condition' => [
                    'timeline_link_hide' => 'yes',
                ],
                //Neo - Added Dynamic Tags
				'dynamic' => [
					'active' => true,
				],
            ]
        );

		$repeater->add_control(
            'timeline_link',
            [
                'label'       => esc_html__('Button Link', 'weddingpress'),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => 'https://weddingpress.net',
                'default'     => '',
                'condition' => [
                    'timeline_link_hide' => 'yes',
                ],
                //Neo - Added Dynamic Tags
				'dynamic' => [
					'active' => true,
				],
            ]
        );
        

		$this->add_control(
			'twae_list',
			[
				
				'label' => __( 'Custom Content', 'weddingpress' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'twae_story_title' => __( 'Awal Bertemu', 'weddingpress' ),
						'twae_description' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Erat enim res aperta. Ne discipulum abducam, times. Primum quid tu dicis breve? An haec ab eo non dicuntur?','weddingpress'),
						'twae_date_label'   => __('8 Jul 1994','weddingpress'),
					],
					[
						'twae_story_title' => __( 'Acara Lamaran', 'weddingpress' ),
						'twae_description' => __('Aliter homines, aliter philosophos loqui putas oportere? Sin aliud quid voles, postea. Mihi enim satis est, ipsis non satis. Negat enim summo bono afferre incrementum diem. Quod ea non occurrentia fingunt, vincunt Aristonem.','weddingpress'),
						'twae_date_label'   => __('5 Feb 2005','weddingpress'),
					],
					[
						'twae_story_title' => __( 'Acara Resepsi', 'weddingpress' ),
						'twae_description' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.','weddingpress'),
						'twae_date_label'   => __('4 Aug 2007','weddingpress'),
					],
				],
				'title_field' => '{{{ twae_story_title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
            'section_content_button',
            [
                'label'     => esc_html__('Readmore Button', 'weddingpress'),
                'condition' => [
                    'show_readmore' => 'yes',
                ],
            ]
        );

        // $this->add_control(
        //     'readmore_text',
        //     [
        //         'label'       => esc_html__('Read More Text', 'weddingpress'),
        //         'type'        => Controls_Manager::TEXT,
        //         'label_block' => true,
        //         'default'     => esc_html__('Selengkapnya', 'weddingpress'),
        //         'placeholder' => esc_html__('Selengkapnya', 'weddingpress'),
        //     ]
        // );

        $this->add_control(
            'button_size',
            [
                'label'   => __('Button Size', 'weddingpress'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'sm',
                'options' => [
                    'xs' => __('Extra Small', 'weddingpress'),
                    'sm' => __('Small', 'weddingpress'),
                    'md' => __('Medium', 'weddingpress'),
                    'lg' => __('Large', 'weddingpress'),
                    'xl' => __('Extra Large', 'weddingpress'),
                ]
            ]
        );

        $this->add_control(
            'button_icon',
            [
                'label'            => esc_html__('Button Icon', 'weddingpress'),
                'type'             => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'label_block' => false,
                'skin' => 'inline'
            ]
        );

        $this->add_control(
            'icon_align',
            [
                'label'     => esc_html__('Icon Position', 'weddingpress'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'right',
                'options'   => [
                    'left'  => esc_html__('Left', 'weddingpress'),
                    'right' => esc_html__('Right', 'weddingpress'),
                ],
                'condition' => [
                    'button_icon[value]!' => '',
                ],
            ]
        );

        $this->add_control(
            'icon_indent',
            [
                'label'     => esc_html__('Icon Spacing', 'weddingpress'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 8,
                ],
                'range'     => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'condition' => [
                    'button_icon[value]!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .weddingpress-timeline .bdt-button-icon-align-right' => is_rtl() ? 'margin-right: {{SIZE}}{{UNIT}};' : 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .weddingpress-timeline .bdt-button-icon-align-left'  => is_rtl() ? 'margin-left: {{SIZE}}{{UNIT}};' : 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_content_additional',
            [
                'label' => esc_html__('Additional Options', 'weddingpress')
            ]
        );

        $this->add_control(
            'show_image',
            [
                'label'   => esc_html__('Image', 'weddingpress'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label'   => esc_html__('Title', 'weddingpress'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'title_link',
            [
                'label'     => esc_html__('Title Link', 'weddingpress'),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_meta',
            [
                'label'   => esc_html__('Date', 'weddingpress'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_excerpt',
            [
                'label'   => esc_html__('Show Text', 'weddingpress'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'item_animation',
            [
                'label' => esc_html__('Scroll Animation', 'weddingpress'),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );
        
        $this->end_controls_section();



		$this->start_controls_section(
            'section_style_item',
            [
                'label' => esc_html__('Item', 'weddingpress'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'item_background_color',
            [
                'label'     => esc_html__('Background Color', 'weddingpress'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#f3f3f3',
                'selectors' => [
                    '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-item-main'                  => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-arrow'                      => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .weddingpress-timeline-item--top .weddingpress-timeline-content:after'    => 'border-top-color: {{VALUE}};',
                    '{{WRAPPER}} .weddingpress-timeline-item--bottom .weddingpress-timeline-content:after' => 'border-bottom-color: {{VALUE}};',
                    '{{WRAPPER}} .weddingpress-timeline--mobile .weddingpress-timeline-content:after'      => 'border-right-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'item_shadow',
                'selector' => '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-item-main',
            ]
        );

        $this->add_control(
            'timeline_line_color',
            [
                'label'     => esc_html__('Line Color', 'weddingpress'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .weddingpress-timeline-divider, {{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-line span, {{WRAPPER}} .weddingpress-timeline:not(.weddingpress-timeline--horizontal):before' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-item:after, {{WRAPPER}} .weddingpress-timeline.weddingpress-timeline-skin-default .weddingpress-timeline-item-main-wrapper .weddingpress-timeline-icon span' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'timeline_line_width',
            [
                'label'     => __('Line Width', 'weddingpress'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 20,
                    ],
                ],
                'default'   => [
                    'size' => 4,
                ],
                'selectors' => [
                    '{{WRAPPER}} .weddingpress-timeline-divider'                               => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-line span' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .weddingpress-timeline-skin-olivier .weddingpress-timeline-item:after, {{WRAPPER}} .weddingpress-timeline.weddingpress-timeline-skin-default .weddingpress-timeline-item-main-wrapper .weddingpress-timeline-line span' => 'border-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_padding',
            [
                'label'      => esc_html__('Padding', 'weddingpress'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-desc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'item_border',
                'label'       => esc_html__('Border', 'weddingpress'),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-item-main',
            ]
        );

        $this->add_responsive_control(
            'item_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'weddingpress'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-item-main' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_icon',
            [
                'label'     => esc_html__('Icon', 'weddingpress'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    '_skin' => ''
                ]
            ]
        );

        $this->start_controls_tabs('tabs_icon_style');

        $this->start_controls_tab(
            'tab_icon_normal',
            [
                'label' => esc_html__('Normal', 'weddingpress'),
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label'     => esc_html__('Color', 'weddingpress'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-icon'     => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_background',
            [
                'label'     => esc_html__('Background Color', 'weddingpress'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-icon span' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'icon_shadow',
                'selector' => '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-icon span'
            ]
        );

        $this->add_responsive_control(
            'icon_width',
            [
                'label'     => __('Width', 'weddingpress'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 60,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-icon span' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_show',
            [
                'label'   => esc_html__('Show Icon', 'weddingpress'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label'     => __('Icon Size', 'weddingpress'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 35,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-icon span i, {{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-icon span' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'icon_show' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'icon_border',
                'label'       => esc_html__('Border', 'weddingpress'),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-icon span',
            ]
        );

        $this->add_responsive_control(
            'icon_border_radius',
            [
                'label'     => __('Border Radius', 'weddingpress'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default'   => [
                    'size' => 50,
                    'unit' => '%',
                ],
                'selectors' => [
                    '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-icon span' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_icon_hover',
            [
                'label' => esc_html__('Hover', 'weddingpress'),
            ]
        );

        $this->add_control(
            'icon_hover_color',
            [
                'label'     => esc_html__('Color', 'weddingpress'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-icon:hover, {{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-icon span:hover' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'icon_hover_background_color',
            [
                'label'     => esc_html__('Background Color', 'weddingpress'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-icon span:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_hover_border_color',
            [
                'label'     => esc_html__('Border Color', 'weddingpress'),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-icon span:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_date',
            [
                'label' => esc_html__('Date in Line', 'weddingpress'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'date_background_color',
            [
                'label'     => esc_html__('Background Color', 'weddingpress'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#f3f3f3;',
                'selectors' => [
                    '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-date span' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'date_color',
            [
                'label'     => esc_html__('Color', 'weddingpress'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-date span' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'date_shadow',
                'selector' => '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-date span',
            ]
        );

        $this->add_responsive_control(
            'date_padding',
            [
                'label'      => esc_html__('Padding', 'weddingpress'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default'    => [
                    'top'    => '10',
                    'right'  => '15',
                    'bottom' => '10',
                    'left'   => '15',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-date span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'date_border',
                'label'       => esc_html__('Border', 'weddingpress'),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-date span',
            ]
        );

        $this->add_responsive_control(
            'date_radius',
            [
                'label'      => esc_html__('Border Radius', 'weddingpress'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default'    => [
                    'top'    => '2',
                    'right'  => '2',
                    'bottom' => '2',
                    'left'   => '2',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-date span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow: hidden;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'date_typography',
                'label'    => esc_html__('Typography', 'weddingpress'),
                'selector' => '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-date',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_image',
            [
                'label'     => esc_html__('Image', 'weddingpress'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_image' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'         => 'thumbnail_size',
                'label'        => esc_html__('Image Size', 'weddingpress'),
                'exclude'      => ['custom'],
                'default'      => 'medium',
                'prefix_class' => 'weddingpress-timeline-thumbnail-size-',
            ]
        );

        $this->add_responsive_control(
            'image_ratio',
            [
                'label'     => esc_html__('Image Height', 'weddingpress'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 265,
                ],
                'range'     => [
                    'px' => [
                        'min'  => 50,
                        'max'  => 500,
                        'step' => 5,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-thumbnail img' => 'height: {{SIZE}}px',
                ],
            ]
        );

        $this->add_control(
            'image_opacity',
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
                    '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-thumbnail img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_padding',
            [
                'label'      => esc_html__('Padding', 'weddingpress'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default'    => [
                    'top'    => '20',
                    'right'  => '20',
                    'bottom' => '0',
                    'left'   => '20',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-thumbnail' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'image_border',
                'label'       => esc_html__('Border', 'weddingpress'),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-thumbnail img',
            ]
        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'weddingpress'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-thumbnail img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow: hidden;',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_title',
            [
                'label'     => esc_html__('Title', 'weddingpress'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__('Color', 'weddingpress'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-title *' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'label'    => esc_html__('Typography', 'weddingpress'),
                'selector' => '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-title *',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_meta',
            [
                'label'     => esc_html__('Date', 'weddingpress'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_meta' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'meta_color',
            [
                'label'     => esc_html__('Color', 'weddingpress'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#bbbbbb',
                'selectors' => [
                    '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-meta *' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'meta_typography',
                'label'    => esc_html__('Typography', 'weddingpress'),
                'selector' => '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-meta *',
            ]
        );

        $this->add_control(
            'meta_spacing',
            [
                'label'     => __('Spacing', 'weddingpress'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default'   => [
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-meta' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_excerpt',
            [
                'label'     => esc_html__('Text', 'weddingpress'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_excerpt' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'excerpt_color',
            [
                'label'     => esc_html__('Color', 'weddingpress'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#888888',
                'selectors' => [
                    '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-excerpt' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'excerpt_typography',
                'label'    => esc_html__('Typography', 'weddingpress'),
                'selector' => '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-excerpt',
            ]
        );

        $this->add_control(
            'excerpt_spacing',
            [
                'label'     => __('Spacing', 'weddingpress'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default'   => [
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-excerpt' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_readmore',
            [
                'label'     => esc_html__('Readmore Button', 'weddingpress'),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('tabs_readmore_style');

        $this->start_controls_tab(
            'tab_readmore_normal',
            [
                'label' => esc_html__('Normal', 'weddingpress'),
            ]
        );

        $this->add_control(
            'readmore_color',
            [
                'label'     => esc_html__('Color', 'weddingpress'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-readmore'     => 'color: {{VALUE}};',
                    '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-readmore svg'     => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'readmore_background',
            [
                'label'     => esc_html__('Background Color', 'weddingpress'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-readmore' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'readmore_shadow',
                'selector' => '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-readmore',
            ]
        );

        $this->add_control(
            'readmore_padding',
            [
                'label'      => esc_html__('Padding', 'weddingpress'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-readmore' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'readmore_border',
                'label'       => esc_html__('Border', 'weddingpress'),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-readmore',
            ]
        );

        $this->add_responsive_control(
            'readmore_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'weddingpress'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-readmore' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow: hidden;',
                ],
            ]
        );

        $this->add_control(
            'readmore_spacing',
            [
                'label'     => __('Spacing', 'weddingpress'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default'   => [
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-readmore' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'readmore_typography',
                'label'    => esc_html__('Typography', 'weddingpress'),
                'selector' => '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-readmore',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_readmore_hover',
            [
                'label' => esc_html__('Hover', 'weddingpress'),
            ]
        );

        $this->add_control(
            'readmore_hover_color',
            [
                'label'     => esc_html__('Color', 'weddingpress'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-readmore:hover'     => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-readmore:hover svg'     => 'fill: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'readmore_hover_background',
            [
                'label'     => esc_html__('Background Color', 'weddingpress'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-readmore:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'readmore_hover_border_color',
            [
                'label'     => esc_html__('Border Color', 'weddingpress'),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'readmore_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-readmore:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'readmore_hover_animation',
            [
                'label' => esc_html__('Animation', 'weddingpress'),
                'type'  => Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_navigation_button',
            [
                'label'     => esc_html__('Navigation Button', 'weddingpress'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    '_skin' => 'bdt-olivier',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_navigation_button_style');

        $this->start_controls_tab(
            'tab_navigation_button_normal',
            [
                'label' => esc_html__('Normal', 'weddingpress'),
            ]
        );

        $this->add_control(
            'navigation_button_color',
            [
                'label'     => esc_html__('Icon Color', 'weddingpress'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-nav-button:before' => 'border-top-color: {{VALUE}}; border-left-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'navigation_button_background',
            [
                'label'     => esc_html__('Background Color', 'weddingpress'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .weddingpress-timeline-nav-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'navigation_button_shadow',
                'selector' => '{{WRAPPER}} .weddingpress-timeline-nav-button',
            ]
        );

        $this->add_responsive_control(
            'navigation_button_padding',
            [
                'label'      => esc_html__('Padding', 'weddingpress'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .weddingpress-timeline-nav-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'navigation_button_border',
                'label'       => esc_html__('Border', 'weddingpress'),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .weddingpress-timeline-nav-button',
            ]
        );

        $this->add_responsive_control(
            'navigation_button_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'weddingpress'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .weddingpress-timeline-nav-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};overflow: hidden;',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_navigation_button_hover',
            [
                'label' => esc_html__('Hover', 'weddingpress'),
            ]
        );

        $this->add_control(
            'navigation_button_hover_color',
            [
                'label'     => esc_html__('Icon Color', 'weddingpress'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .weddingpress-timeline .weddingpress-timeline-nav-button:hover:before' => 'border-top-color: {{VALUE}}; border-left-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'navigation_button_hover_background',
            [
                'label'     => esc_html__('Background Color', 'weddingpress'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .weddingpress-timeline-nav-button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'navigation_button_hover_border_color',
            [
                'label'     => esc_html__('Border Color', 'weddingpress'),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'navigation_button_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .weddingpress-timeline-nav-button:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

	}

    public function render_excerpt($item = []) {

        if (!$this->get_settings('show_excerpt')) {
            return;
        }

        $settings = $this->get_settings_for_display();

        ?>
            <div class="weddingpress-timeline-excerpt">
        	<?php echo do_shortcode($item['twae_description']); ?>
            </div>
        <?php
        
    }

    public function render_readmore($item = []) {

        // if ($readmore_link_hide = 'yes') {
        //     return;
        // }

        $settings = $this->get_settings_for_display();
        $readmore_link_hide = $item['timeline_link_hide'];
        $readmore_link = $item['timeline_link'];
        $readmore_text = $item['timeline_text'];

        $this->add_render_attribute(
            [
                'timeline-readmore' => [
                    'href'  => esc_url($readmore_link),
                    'class' => [
                        'weddingpress-timeline-readmore',
                        'elementor-button',
                        'elementor-size-' . esc_attr($settings['button_size']),
                        $settings['readmore_hover_animation'] ? 'elementor-animation-' . $settings['readmore_hover_animation'] : ''
                    ],
                ]
            ],
            '',
            '',
            true
        );

        if (!isset($settings['icon']) && !Icons_Manager::is_migration_allowed()) {
            // add old default
            $settings['icon'] = 'fas fa-arrow-right';
        }

        $migrated = isset($settings['__fa4_migrated']['button_icon']);
        $is_new   = empty($settings['icon']) && Icons_Manager::is_migration_allowed();
        if($readmore_link_hide == 'yes'){
        ?>
        <a <?php echo $this->get_render_attribute_string('timeline-readmore'); ?>>
            <?php echo esc_html($readmore_text); ?>

            <?php if (isset($settings['button_icon']['value'])) : ?>
                <span class="bdt-button-icon-align-<?php echo esc_attr($settings['icon_align']); ?>">

                    <?php if ($is_new || $migrated) :
                        Icons_Manager::render_icon($settings['button_icon'], ['aria-hidden' => 'true', 'class' => 'fa-fw']);
                    else : ?>
                        <i class="<?php echo esc_attr($settings['icon']); ?>" aria-hidden="true"></i>
                    <?php endif; ?>

                </span>
            <?php endif; ?>
        </a>
        <?php
        }

    }

    public function render_image($item = []) {

        if (!$this->get_settings('show_image')) {
            return;
        }

        $settings = $this->get_settings_for_display();
		$image_url = ($item['twae_image']['url']) ?: '';
		$title     = $item['twae_story_title'];
        

        if ($image_url) {
        ?>
            <div class="weddingpress-timeline-thumbnail">
                <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($title); ?>">
            </div>
        <?php
        }
    }

    public function render_title($item = []) {
    if (!$this->get_settings('show_title')) {
        return;
    }

    $settings = $this->get_settings_for_display();
    $title_link = $item['timeline_link'];
    $title      = $item['twae_story_title'];

    $this->add_render_attribute('weddingpress-timeline-title', 'class', 'weddingpress-timeline-title', true);


    $this->add_render_attribute('weddingpress-timeline-title', 'class', 'weddingpress-timeline-title', true);

    ?>
    <div <?php echo $this->get_render_attribute_string('weddingpress-timeline-title'); ?>>
        <?php if ($settings['title_link']) : ?>
            <a href="<?php echo esc_url($title_link); ?>" title="<?php echo esc_html($title); ?>">
                <?php echo esc_html($title); ?>
            </a>
        <?php else : ?>
            <span><?php echo esc_html($title); ?></span>
        <?php endif; ?>
    </div>
    <?php

    }
    
    public function render_meta($align, $item = []) {

        if (!$this->get_settings('show_meta')) {
            return;
        }

        $settings = $this->get_settings_for_display();

        $hidden_class = ('center' == $align) ? 'bdt-hidden@m' : '';
        $meta_date    = '<li class="' . $hidden_class . '">' . esc_attr(get_the_date('d F Y')) . '</li>';
        $meta_list    = '<li>' . get_the_category_list(', ') . '</li>';

    ?>
        <ul class="weddingpress-timeline-meta bdt-subnav bdt-flex-middle">

            <li><?php echo esc_attr($item['twae_date_label']); ?></li>

        </ul>
    <?php

    }

    public function render_item($item_parallax, $align, $item = []) {

    ?>
        <div class="weddingpress-timeline-item-main" <?php printf($item_parallax); ?>>
            <?php $this->render_image($item); ?>
            <div class="weddingpress-timeline-desc bdt-padding">
                <?php $this->render_title($item); ?>
                <?php $this->render_meta($align, $item); ?>
                <?php $this->render_excerpt($item); ?>
                <?php $this->render_readmore($item); ?>
            </div>
        </div>
    <?php

    }

    public function render_date($align = 'left', $item = []) {

        $settings      = $this->get_settings_for_display();
        $date_parallax = '';
		$timeline_date = $item['twae_date_label'];
        
        if ($settings['item_animation']) {
            if ($align == 'right') {
                $date_parallax = ' bdt-parallax="opacity: 0,1;x: -200,0;viewport: 0.5;"';
            } else {
                $date_parallax = ' bdt-parallax="opacity: 0,1;x: 200,0;viewport: 0.5;"';
            }
        }

    	?>
        <div class="weddingpress-timeline-item bdt-width-1-2@m bdt-visible@m">
            <div class="weddingpress-timeline-date bdt-text-<?php echo esc_attr($align); ?>" <?php echo esc_attr($date_parallax); ?>>
                <span><?php echo esc_attr($timeline_date); ?></span>
            </div>
        </div>
        <?php

    }


    function render_post_format() {
		$settings = $this->get_settings_for_display();

        $this->add_render_attribute('timeline-icon', 'class', 'weddingpress-timeline-icon');

        if ($settings['item_animation']) {
            $this->add_render_attribute('timeline-icon', 'bdt-parallax', 'scale: 0.5,1; viewport: 0.5;');
        }

		?>
        <div <?php $this->print_render_attribute_string('timeline-icon'); ?>>
            <?php if ( has_post_format( 'aside' ) ) : ?>
                <span><i class="ep-icon-aside" aria-hidden="true"></i></span>
            <?php elseif ( has_post_format( 'gallery' ) ) : ?>
                <span><i class="ep-icon-gallery" aria-hidden="true"></i></span>
            <?php elseif ( has_post_format( 'link' ) ) : ?>
                <span><i class="ep-icon-link" aria-hidden="true"></i></span>
            <?php elseif ( has_post_format( 'image' ) ) : ?>
                <span><i class="ep-icon-image" aria-hidden="true"></i></span>
            <?php elseif ( has_post_format( 'quote' ) ) : ?>
                <span><i class="ep-icon-quote" aria-hidden="true"></i></span>
            <?php elseif ( has_post_format( 'status' ) ) : ?>
                <span><i class="ep-icon-status" aria-hidden="true"></i></span>
            <?php elseif ( has_post_format( 'video' ) ) : ?>
                <span><i class="ep-icon-video" aria-hidden="true"></i></span>
            <?php elseif ( has_post_format( 'audio' ) ) : ?>
                <span><i class="ep-icon-music" aria-hidden="true"></i></span>
            <?php elseif ( has_post_format( 'chat' ) ) : ?>
                <span><i class="ep-icon-chat" aria-hidden="true"></i></span>
            <?php else : ?>
                <span><i class="ep-icon-post" aria-hidden="true"></i></span>
            <?php endif; ?>
        </div>
		<?php
	}

    public function render_post() {
        $settings               = $this->get_settings_for_display();
        $id                     = $this->get_id();
        $align                  = $settings['timeline_align'];

        if ($settings['item_animation']) {
            $this->add_render_attribute('vertical_line_parallax', 'bdt-parallax', 'opacity: 0,1;viewport: 0.5;"');
        }

        if (isset($settings['posts_limit']) and $settings['posts_per_page'] == 6) {
            $limit = $settings['posts_limit'];
        } else {
            $limit = $settings['posts_per_page'];
        }

        $this->query_posts($limit);

        $wp_query = $this->get_query();

        if (!$wp_query->found_posts) {
            return;
        }

        if ($wp_query->have_posts()) :

            $this->add_render_attribute(
                [
                    'bdt-timeline' => [
                        'id'    => 'bdt-timeline-' . esc_attr($id),
                        'class' => [
                            'bdt-timeline',
                            'bdt-timeline-skin-default',
                            'bdt-timeline-' . esc_attr($align)
                        ]
                    ]
                ]
            );

            if ('yes' == $settings['icon_show']) {
                $this->add_render_attribute('bdt-timeline', 'class', 'bdt-timeline-icon-yes');
            }

        ?>
            <div <?php echo $this->get_render_attribute_string('bdt-timeline'); ?>>
                <div class="bdt-grid bdt-grid-collapse">
                    <?php
                    $bdt_count = 0;
                    while ($wp_query->have_posts()) : $wp_query->the_post();

                        $bdt_count++;
                        $post_format = get_post_format() ?: 'standard';
                        $item_part   = ($bdt_count % 2 === 0) ? 'right' : 'left';

                        if ('center' == $align) {
                            $parallax_direction = ($bdt_count % 2 === 0) ? '' : '-';

                            $item_parallax = ($settings['item_animation']) ? ' bdt-parallax="opacity:0,1;x:' . $parallax_direction . '200,0;viewport: 0.5;"' : '';
                        } elseif ('right' == $align) {
                            $item_parallax = ($settings['item_animation']) ? ' bdt-parallax="opacity: 0,1;x: -200,0;viewport: 0.5;"' : '';
                        } else {
                            $item_parallax = ($settings['item_animation']) ? ' bdt-parallax="opacity: 0,1;x: 200,0;viewport: 0.5;"' : '';
                        }

                        if ($bdt_count % 2 === 0 and 'center' == $align) : ?>
                            <?php $this->render_date('right', ''); ?>
                        <?php endif; ?>

                        <div class="<?php echo ('center' == $align) ? ' bdt-width-1-2@m ' : 'bdt-width-1-1 '; ?>bdt-timeline-item <?php echo esc_attr($item_part) . '-part'; ?>">

                            <div class="bdt-timeline-item-main-wrapper">
                                <div class="bdt-timeline-line">
                                    <span <?php $this->print_render_attribute_string('vertical_line_parallax'); ?>></span>
                                </div>
                                <div class="bdt-timeline-item-main-container">
                                    
                                    <?php $this->render_post_format(); ?>

                                    <?php $this->render_item($item_parallax, $align, ''); ?>

                                </div>
                            </div>
                        </div>

                        <?php if ($bdt_count % 2 === 1 and ('center' == $align)) : ?>
                            <?php $this->render_date('left', ''); ?>
                        <?php endif; ?>

                    <?php endwhile;
                    wp_reset_postdata(); ?>
                </div>
            </div>

        <?php endif;

    }

    public function render_custom() {
        $id             = $this->get_id();
        $settings       = $this->get_settings_for_display();
        $timeline_items = $settings['twae_list'];

        $align                  = $settings['timeline_align'];
        $vertical_line_parallax = ($settings['item_animation']) ? ' bdt-parallax="opacity: 0,1;viewport: 0.2;"' : '';

        $this->add_render_attribute('weddingpress-timeline-custom', 'id', 'weddingpress-timeline-' . esc_attr($id));
        $this->add_render_attribute('weddingpress-timeline-custom', 'class', 'weddingpress-timeline weddingpress-timeline-skin-default');
        $this->add_render_attribute('weddingpress-timeline-custom', 'class', 'weddingpress-timeline-' . esc_attr($align));

        ?>
        <div <?php echo $this->get_render_attribute_string('weddingpress-timeline-custom'); ?>>
            <div class="bdt-grid bdt-grid-collapse" bdt-grid>
                <?php
                $bdt_count = 0;
                foreach ($timeline_items as $item) :
                    $bdt_count++;

                    if (!isset($item['timeline_icon']) && !Icons_Manager::is_migration_allowed()) {
                        // add old default
                        $item['timeline_icon'] = 'fas fa-file-alt';
                    }

                    $migrated = isset($item['__fa4_migrated']['twae_story_icon']);
                    $is_new   = empty($item['timeline_icon']) && Icons_Manager::is_migration_allowed();

                    if ('center' == $align) {
                        $parallax_direction = ($bdt_count % 2 === 0) ? '' : '-';
                        $item_parallax      = ($settings['item_animation']) ? ' bdt-parallax="opacity:0,1;x:' . $parallax_direction . '200,0;viewport: 0.5;"' : '';
                    } elseif ('right' == $align) {
                        $item_parallax = ($settings['item_animation']) ? ' bdt-parallax="opacity: 0,1;x: -200,0;viewport: 0.5;"' : '';
                    } else {
                        $item_parallax = ($settings['item_animation']) ? ' bdt-parallax="opacity: 0,1;x: 200,0;viewport: 0.5;"' : '';
                    }

                    $item_part = ($bdt_count % 2 === 0) ? 'right' : 'left';

                    if ($bdt_count % 2 === 0 and 'center' == $align) : ?>
                        <?php $this->render_date('right', $item); ?>
                    <?php endif; ?>


                    <div class="<?php echo ('center' == $align) ? ' bdt-width-1-2@m ' : ' '; ?>weddingpress-timeline-item <?php echo esc_attr($item_part) . '-part'; ?>">

                        <div class="weddingpress-timeline-item-main-wrapper">
                            <div class="weddingpress-timeline-line">
                                <span <?php echo esc_attr($vertical_line_parallax);?> ></span>
                            </div>
                            <div class="weddingpress-timeline-item-main-container">
                                <?php $item_scrollspy = ($settings['item_animation']) ? ' bdt-scrollspy="cls: bdt-animation-scale-up;"' : ''; ?>

                                <div class="weddingpress-timeline-icon" <?php echo esc_attr($item_scrollspy); ?>>

                                    <span>

                                        <?php if ('yes' == $settings['icon_show']) : ?>
                                            <?php if ($is_new || $migrated) :
                                                Icons_Manager::render_icon($item['twae_story_icon'], ['aria-hidden' => 'true']);
                                            else : ?>
                                                <i class="<?php echo esc_attr($item['timeline_icon']); ?>" aria-hidden="true"></i>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                    </span>

                                </div>
                                <?php $this->render_item($item_parallax, $align, $item); ?>
                            </div>
                        </div>
                    </div>

                    <?php if ($bdt_count % 2 === 1 and ('center' == $align)) : ?>
                        <?php $this->render_date('', $item); ?>
                    <?php endif; ?>

                <?php endforeach; ?>

                <?php wp_reset_postdata(); ?>

            </div>
        </div>
    <?php
    }

    public function render() {

        $settings = $this->get_settings_for_display();

        $this->render_custom();

    }

}

