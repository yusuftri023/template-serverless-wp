<?php

namespace WeddingPress\Elementor;

use Elementor\Controls_Manager;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Wdp_Sticky {

        /**
     * @var    object
     * @access  private
     * @since    1.0.0
     */
    private static $_instance = null;

    public function __construct() {
        $this->init();
	}

    public function init(){
        add_action( 'elementor/frontend/column/before_render', array( $this, 'before_render' ) );
        add_action( 'elementor/element/section/section_advanced/after_section_end', array( $this, 'register_controls' ), 10 );
        add_action( 'elementor/element/column/section_advanced/after_section_end', array( $this, 'register_controls' ), 10 );
        // if ( !class_exists( 'Jet_Engine' ) ) {
        add_action( 'elementor/element/common/_section_style/after_section_end', array( $this, 'register_controls' ), 10, 2);
        // }
        add_action( 'elementor/element/container/section_layout/after_section_end', array( $this,  'register_controls'), 10);
    }

    public function register_controls( $element ) {

        $element->start_controls_section(
            'wdp_sticky_section',
            [
                'label' => 'WeddingPress Sticky',
                'tab'   => Controls_Manager::TAB_ADVANCED
            ]
        );
		
		$element->add_control(
            'wdp_enable_section_sticky',
            [
				'label'        => __( 'Sticky', 'weddingpress' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
                'return_value' => 'yes',
                'render_type'  => 'template',
				'label_on'     => __( 'Yes', 'weddingpress' ),
                'label_off'    => __( 'No', 'weddingpress' ),
                // 'prefix_class' => 'wdp-sticky-section--',
            ]
        );

        $element->add_control(
            'floating_bar_on_position',
            [
                'label' => __( 'Position', 'weddingpress' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => 'Default',
                    'top' => 'Top',
                    'bottom' => 'Bottom'
                ],
                'condition' => [
                    'wdp_enable_section_sticky' => 'yes'
                ],
                'prefix_class' => 'wdp-sticky-section-positon--',
            ]
        );
        
        $element->end_controls_section();

	}

    public function before_render( $element ) {

        $settings = $element->get_settings();
        $data     = $element->get_data();
        $type     = isset( $data['elType'] ) ? $data['elType'] : 'column';
        

        if ( 'column' !== $type && 'container' !== $type) {
            return false;
        }

        if ( isset( $settings['wdp_enable_section_sticky'] ) ) {

            if ( filter_var( $settings['wdp_enable_section_sticky'], FILTER_VALIDATE_BOOLEAN ) ) {

                $element->add_render_attribute( '_wrapper', array(
                    'class'         => 'wdp-column-sticky',
                    'data-type' => $type,
                    'data-top_spacing' => $settings['wdp_sticky_top_spacing'],
                ) );

                $element->sticky_columns[] = $data['id'];
            }
        }

    }

}

