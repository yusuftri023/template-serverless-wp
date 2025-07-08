<?php

namespace WeddingPress\elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class WeddingPress_Widget_Kirim_Kit extends Widget_Base
{

    public function get_name()
    {
        return 'weddingpress-kirim-kit';
    }

    public function get_title()
    {
        return __('Kirim Kit', 'weddingpress');
    }

    public function get_icon()
    {
        return 'wdp_icon eicon-kit-details';
    }

    public function get_categories()
    {
        return ['weddingpress'];
    }

    public function get_style_depends()
    {
        return ['kirim-kit'];
    }

    public function get_script_depends()
    {
        return ['kirim-kit'];
    }

    public function get_custom_help_url()
    {
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

     protected function register_controls()
     {
         $this->start_controls_section(
             'section_field_name',
             [
                 'label' => __('General', 'weddingpress'),
             ]
         );
 
         $this->add_control(
             'important_description',
             [
                 'raw' => __('<b>Info:</b> Link undangan, cukup ketikkan slug undangan, contoh: https://wedding.domain/send/?id=namamempelai', 'weddingpress'),
                 'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                 'render_type'     => 'ui',
                 'type'            => Controls_Manager::RAW_HTML,
             ]
         );
 
         $this->add_control(
             'important_description2',
             [
                 'raw' => __('<b>Untuk penggunaan iframe</b>, gunakan penulisan link undangan dengan slug <b>?link=</b><br>contoh: wedding.domain/send/?link=https://customdomain.com<br><br>*tanpa tanda "/" di akhir link custom domain', 'weddingpress'),
                 'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                 'render_type'     => 'ui',
                 'type'            => Controls_Manager::RAW_HTML,
             ]
         );
 
         $this->add_control(
             'important_description3',
             [
                 'raw' => __('<b>Note:</b> Untuk slug *send adalah permalink halaman kirim undangan yang anda buat.<br><br>Untuk penulisan baris baru (↵), gunakan (\n) pada template ucapan.', 'weddingpress'),
                 'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                 'render_type'     => 'ui',
                 'type'            => Controls_Manager::RAW_HTML,
             ]
         );
 
         $this->add_control(
             'hide_muslim',
             [
                 'label' => __('Button Muslim', 'weddingpress'),
                 'type' => Controls_Manager::SWITCHER,
                 'separator' => 'before',
                 'label_on' => 'Hide',
                 'label_off' => 'Show',
                 'return_value' => 'hide',
             ]
         );
 
         $this->add_control(
             'label_muslim',
             [
                 'label' => __( 'Label Button Muslim', 'weddingpress' ),
                 'type' => Controls_Manager::TEXT,
                 'default' => 'Muslim',
                 'placeholder' => '',
                 'label_block' => true,
                 'condition' => [
                     'label_muslim!' =>  'hide',
                 ],
                 'dynamic' => [
                     'active' => true,
                 ],
             ]
         );
 
         $this->add_control(
             'hide_nasrani',
             [
                 'label' => __('Button Nasrani', 'weddingpress'),
                 'type' => Controls_Manager::SWITCHER,
                 'label_on' => 'Hide',
                 'label_off' => 'Show',
                 'return_value' => 'hide',
             ]
         );
 
         $this->add_control(
             'label_nasrani',
             [
                 'label' => __( 'Label Button Nasrani', 'weddingpress' ),
                 'type' => Controls_Manager::TEXT,
                 'default' => 'Nasrani',
                 'placeholder' => '',
                 'label_block' => true,
                 'condition' => [
                     'label_nasrani!' =>  'hide',
                 ],
                 'dynamic' => [
                     'active' => true,
                 ],
             ]
         );
 
         $this->add_control(
             'hide_hindu',
             [
                 'label' => __('Button Hindu', 'weddingpress'),
                 'type' => Controls_Manager::SWITCHER,
                 'label_on' => 'Hide',
                 'label_off' => 'Show',
                 'return_value' => 'hide',
             ]
         );
 
         $this->add_control(
             'label_hindu',
             [
                 'label' => __( 'Label Button Hindu', 'weddingpress' ),
                 'type' => Controls_Manager::TEXT,
                 'default' => 'Hindu',
                 'placeholder' => '',
                 'label_block' => true,
                 'condition' => [
                     'label_hindu!' =>  'hide',
                 ],
                 'dynamic' => [
                     'active' => true,
                 ],
             ]
         );
 
         $this->add_control(
             'hide_formal',
             [
                 'label' => __('Button Formal', 'weddingpress'),
                 'type' => Controls_Manager::SWITCHER,
                 'label_on' => 'Hide',
                 'label_off' => 'Show',
                 'return_value' => 'hide',
             ]
         );
 
         $this->add_control(
             'label_formal',
             [
                 'label' => __( 'Label Button Formal', 'weddingpress' ),
                 'type' => Controls_Manager::TEXT,
                 'default' => 'Formal',
                 'placeholder' => '',
                 'label_block' => true,
                 'condition' => [
                     'label_formal!' =>  'hide',
                 ],
                 'dynamic' => [
                     'active' => true,
                 ],
             ]
         );
 
         $this->add_control(
             'hide_custom',
             [
                 'label' => __('Button Custom', 'weddingpress'),
                 'type' => Controls_Manager::SWITCHER,
                 'label_on' => 'Hide',
                 'label_off' => 'Show',
                 'return_value' => 'hide',
                 'default' => 'hide',
             ]
         );
 
         $this->add_control(
             'custom',
             [
                 'label' => __( 'Label Button Custom', 'weddingpress' ),
                 'type' => Controls_Manager::TEXT,
                 'default' => 'Utlah',
                 'placeholder' => '',
                 'label_block' => true,
                 'condition' => [
                     'hide_custom!' =>  'hide',
                 ],
                 'dynamic' => [
                     'active' => true,
                 ],
             ]
         );
 
         $this->add_control(
             'message',
             [
                 'label' => __('Template Ucapan Formal', 'weddingpress'),
                 'type' => Controls_Manager::TEXTAREA,
                 'rows' => '6',
                 'default' => 'Tanpa mengurangi rasa hormat, perkenankan kami mengundang Bapak/Ibu/Saudara/i *[nama]* untuk menghadiri acara kami.\n\n*Berikut link undangan kami*, untuk info lengkap dari acara bisa kunjungi :\n\n[link-undangan]\n\nMerupakan suatu kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan untuk hadir dan memberikan doa restu.\n\n*Mohon maaf perihal undangan hanya di bagikan melalui pesan ini.*\n\nDan agar selalu menjaga kesehatan bersama serta datang pada waktu yang telah ditentukan.*\n\nTerima kasih banyak atas perhatiannya.',
                 'placeholder' => 'Masukan Text',
                 'label_block' => true,
                 'separator' => 'before',
             ]
         );
 
         $this->add_control(
             'message2',
             [
                 'label' => __('Template Ucapan Muslim', 'weddingpress'),
                 'type' => Controls_Manager::TEXTAREA,
                 'rows' => '6',
                 'default' => '_Assalamualaikum Warahmatullahi Wabarakatuh_\n\nTanpa mengurangi rasa hormat, perkenankan kami mengundang Bapak/Ibu/Saudara/i *[nama]* untuk menghadiri acara kami.\n\n*Berikut link undangan kami*, untuk info lengkap dari acara bisa kunjungi :\n\n[link-undangan]\n\nMerupakan suatu kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan untuk hadir dan memberikan doa restu.\n\n*Mohon maaf perihal undangan hanya di bagikan melalui pesan ini.*\n\nDan agar selalu menjaga kesehatan bersama serta datang pada waktu yang telah ditentukan.*\n\nTerima kasih banyak atas perhatiannya.\n\n_Wassalamualaikum Warahmatullahi Wabarakatuh_',
                 'placeholder' => 'Masukan Text',
                 'label_block' => true,
             ]
         );
 
         $this->add_control(
             'message3',
             [
                 'label' => __('Template Ucapan Nasrani', 'weddingpress'),
                 'type' => Controls_Manager::TEXTAREA,
                 'rows' => '6',
                 'default' => 'Kepada Yth.\n*[nama]*\n\nSalam Sejahtera Bagi Kita Semua. Tuhan membuat segala sesuatu indah pada waktunya dan mempersatukan kami dalam suatu ikatan pernikahan kudus, semoga Tuhan memberkati dalam mengiringi pernikahan kami.\n\nTanpa mengurangi rasa hormat, perkenankan kami mengundang Bapak/Ibu/Saudara/i: untuk menghadiri acara kami.\n\nBerikut link undangan kami:\n\n[link-undangan]\n\nMerupakan suatu kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan untuk hadir dan memberikan doa restu.\n\n*Mohon maaf perihal undangan hanya di bagikan melalui pesan ini.*\n\nDan agar selalu menjaga kesehatan bersama serta datang pada waktu yang telah ditentukan.* Semoga kita semua diberikan kesehatan dan tetap dibawah lindungan-Nya.\n\nTerima kasih.',
                 'placeholder' => 'Masukan Text',
                 'label_block' => true,
             ]
         );
 
         $this->add_control(
             'message4',
             [
                 'label' => __('Template Ucapan Hindu', 'weddingpress'),
                 'type' => Controls_Manager::TEXTAREA,
                 'rows' => '6',
                 'default' => 'Kepada Yth.\n*[nama]*\n\nOm Swastiastu\n\nTanpa mengurangi rasa hormat, perkenankan kami mengundang Bapak/Ibu/Saudara/i, teman sekaligus sahabat, untuk menghadiri acara pernikahan kami :\n\nBerikut link undangan kami untuk info lengkap dari acara bisa kunjungi :\n\n[link-undangan]\n\nMerupakan suatu kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan untuk hadir dan memberikan doa restu.\n\nMohon maaf perihal undangan hanya di bagikan melalui pesan ini. Dan agar selalu menjaga kesehatan bersama serta datang pada waktu yang telah ditentukan. Terima kasih banyak atas perhatiannya.\n\nOm Shanti, Shanti, Shanti, Om.',
                 'placeholder' => 'Masukan Text',
                 'label_block' => true,
             ]
         );
 
         $this->add_control(
             'message5',
             [
                 'label' => __('Template Ucapan Custom', 'weddingpress'),
                 'type' => Controls_Manager::TEXTAREA,
                 'rows' => '6',
                 'default' => 'Kepada Yth.\n*[nama]*\n\nTanpa mengurangi rasa hormat, perkenankan kami mengundang Bapak/Ibu/Saudara/i, teman sekaligus sahabat, untuk menghadiri acara ulang tahun anak kami :\n\nBerikut link undangan kami untuk info lengkap dari acara bisa kunjungi :\n\n[link-undangan]\n\nMerupakan suatu kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan untuk hadir dan memberikan doa.\n\nMohon maaf perihal undangan hanya di bagikan melalui pesan ini. Dan agar selalu menjaga kesehatan bersama serta datang pada waktu yang telah ditentukan. Terima kasih banyak atas perhatiannya.',
                 'placeholder' => 'Masukan Text',
                 'label_block' => true,
             ]
         );
 
         $this->end_controls_section();
 
         if( class_exists( 'WDP_Sendkit_Widget_Controls' ) ) {$status = get_option( 'wdpsendkit_license_key_status', false );
         if ( ! in_array( $status, array( 'ok' ) ) ) {return;}
         $this->start_controls_section(
             'section_wa_notif',
             [
                 'label' => esc_html__( 'WhatsApp Sender', 'weddingpress' ),
             ]
         );
 
         $this->add_control(
             'enable_wa_notif',
             [
                 'label' => __( 'Aktifkan WhatsApp Sender', 'weddingpress' ),
                 'type' => Controls_Manager::SWITCHER,
                 'default' => 'disable',
                 'options' => [
                     'enable' => __( 'Yes', 'weddingpress' ),
                     'disable' => __( 'No', 'weddingpress' ),
                 ],
                 'separator' => 'before',
             ]
         );
 
         $this->add_control(
             'wa_gateway',
             [
                 'label' => __( 'WA Gateway', 'weddingpress' ),
                 'type' => Controls_Manager::SELECT,
                 'options' => [
                     '' => '— ' . __( 'Select', 'weddingpress' ) . ' —',
                     'starsender' => __( 'Starsender', 'weddingpress' ),
                     'onesender' => __( 'Onesender', 'weddingpress' ),
                 ],
                 'default' => '',
                 'condition' => [
                     'enable_wa_notif'    =>  'yes',
                 ],
             ]
         );
 
         $this->add_control(
             'delay_minutes',
             [
                 'label' => __( 'Delay Send Bulk', 'weddingpress' ),
                 'description' => __( 'Delay dalam hitungan Detik', "weddingpress" ),
                 'type' => Controls_Manager::NUMBER,
                 'min' => 10,
                 'max' => 90,
                 'step' => 1,
                 'default' => 10,
                 'condition' => [
                     'enable_wa_notif'    =>  'yes',
                 ],
             ]
         );
 
         $this->end_controls_section();
         }
 
         $this->start_controls_section(
             'button_section_style',
             [
                 'label' => __( 'Button', 'weddingpress' ),
                 'tab' => Controls_Manager::TAB_STYLE,
             ]
         );
 
         $this->add_responsive_control(
             'button_space_between',
             [
                 'label' => esc_html__( 'Space Between', 'weddingpress' ),
                 'type' => Controls_Manager::SLIDER,
                 'size_units' => [ 'px', 'em', 'rem', 'custom' ],
                 'range' => [
                     'em' => [
                         'max' => 50,
                     ],
                 ],
                 'selectors' => [
                     '{{WRAPPER}} .btn-sm' => 'margin-left: {{SIZE}}{{UNIT}}',
                 ],
             ]
         );
 
         $this->add_responsive_control(
             'button_top_between',
             [
                 'label' => esc_html__( 'Button Padding Top', 'weddingpress' ),
                 'type' => Controls_Manager::SLIDER,
                 'size_units' => [ 'px', 'em', 'rem', 'custom' ],
                 'range' => [
                     'em' => [
                         'max' => 20,
                     ],
                 ],
                 'selectors' => [
                     '{{WRAPPER}} .btn-sm' => 'margin-top: {{SIZE}}{{UNIT}}',
                 ],
             ]
         );
 
         $this->add_responsive_control(
             'space_between',
             [
                 'label' => esc_html__( 'Button padding', 'weddingpress' ),
                 'type' => Controls_Manager::SLIDER,
                 'size_units' => [ 'px', 'em', 'rem', 'custom' ],
                 'range' => [
                     'em' => [
                         'max' => 50,
                     ],
                 ],
                 'selectors' => [
                     '{{WRAPPER}} .btn-sm' => 'padding: {{SIZE}}{{UNIT}}',
                 ],
             ]
         );
 
         $this->end_controls_section();

        /* Button Google sheet */

        $this->start_controls_section(
            'sheet_section_style',
            [
                'label' => __( 'Button Import Google Sheet', 'weddingpress' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'sheet_typography',
                'selector' => '{{WRAPPER}} .btn-secondary-sheet',
            ]
        );

        $this->start_controls_tabs( 
            'tabs_button_style_sheet' 
        );

        $this->start_controls_tab(
            'sheet_tab_button_formal',
            [
                'label' => __( 'Normal', 'weddingpress' ),
            ]
        );

        $this->add_control(
            'sheet_button_text_color',
            [
                'label' => __( 'Text Color', 'weddingpress' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .btn-secondary-sheet' => 'fill: {{VALUE}}; color: {{VALUE}};',
                ],
                'default' => '#fff'
            ]
        );

        $this->add_control(
            'sheet_background_color',
            [
                'label' => __( 'Background Color', 'weddingpress' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .btn-secondary-sheet' => 'background-color: {{VALUE}};',
                ],
                'default' => '#198754'
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'sheet_tab_button_hover',
            [
                'label' => __( 'Hover', 'weddingpress' ),
            ]
        );

        $this->add_control(
            'sheet_hover_color',
            [
                'label' => __( 'Text Color', 'weddingpress' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .btn-secondary-sheet:hover, {{WRAPPER}} .btn-secondary-sheet:focus' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .btn-secondary-sheet:hover svg, {{WRAPPER}} .btn-secondary-sheet:focus svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'sheet_button_background_hover_color',
            [
                'label' => __( 'Background Color', 'weddingpress' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .btn-secondary-sheet:hover, {{WRAPPER}} .btn-secondary-sheet:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'sheet_button_hover_border_color',
            [
                'label' => __( 'Border Color', 'weddingpress' ),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .btn-secondary-sheet:hover, {{WRAPPER}} .btn-secondary-sheet:focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'sheet_border',
                'selector' => '{{WRAPPER}} .btn-secondary-sheet',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'sheet_border_radius',
            [
                'label' => __( 'Border Radius', 'weddingpress' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .btn-secondary-sheet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'sheet_button_box_shadow',
                'selector' => '{{WRAPPER}} .btn-secondary-sheet',
            ]
        );

        $this->add_responsive_control(
            'sheet_text_padding',
            [
                'label' => __( 'Text Padding', 'weddingpress' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .btn-secondary-sheet' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();

        /* Button import csv */

        $this->start_controls_section(
            'csv_section_style',
            [
                'label' => __( 'Button Import Excel', 'weddingpress' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'csv_typography',
                'selector' => '{{WRAPPER}} .btn-secondary-excel',
            ]
        );

        $this->start_controls_tabs( 
            'tabs_button_style_csv' 
        );

        $this->start_controls_tab(
            'csv_tab_button_formal',
            [
                'label' => __( 'Normal', 'weddingpress' ),
            ]
        );

        $this->add_control(
            'csv_button_text_color',
            [
                'label' => __( 'Text Color', 'weddingpress' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .btn-secondary-excel' => 'fill: {{VALUE}}; color: {{VALUE}};',
                ],
                'default' => '#fff'
            ]
        );

        $this->add_control(
            'csv_background_color',
            [
                'label' => __( 'Background Color', 'weddingpress' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .btn-secondary-excel' => 'background-color: {{VALUE}};',
                ],
                'default' => '#0d6efd'
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'csv_tab_button_hover',
            [
                'label' => __( 'Hover', 'weddingpress' ),
            ]
        );

        $this->add_control(
            'csv_hover_color',
            [
                'label' => __( 'Text Color', 'weddingpress' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .btn-secondary-excel:hover, {{WRAPPER}} .btn-secondary-excel:focus' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .btn-secondary-excel:hover svg, {{WRAPPER}} .btn-secondary-excel:focus svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'csv_button_background_hover_color',
            [
                'label' => __( 'Background Color', 'weddingpress' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .btn-secondary-excel:hover, {{WRAPPER}} .btn-secondary-excel:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'csv_button_hover_border_color',
            [
                'label' => __( 'Border Color', 'weddingpress' ),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .btn-secondary-excel:hover, {{WRAPPER}} .btn-secondary-excel:focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'csv_border',
                'selector' => '{{WRAPPER}} .btn-secondary-excel',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'csv_border_radius',
            [
                'label' => __( 'Border Radius', 'weddingpress' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .btn-secondary-excel' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'csv_button_box_shadow',
                'selector' => '{{WRAPPER}} .btn-secondary-excel',
            ]
        );

        $this->add_responsive_control(
            'csv_text_padding',
            [
                'label' => __( 'Text Padding', 'weddingpress' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .btn-secondary-excel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();

        // Button Bulk Send

        $this->start_controls_section(
            'bulk_section_style',
            [
                'label' => __( 'Button Bulk Send', 'weddingpress' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'bulk_typography',
                'selector' => '{{WRAPPER}} .btn-secondary-bulk',
            ]
        );

        $this->start_controls_tabs( 
            'tabs_button_style_bulk' 
        );

        $this->start_controls_tab(
            'bulk_tab_button_formal',
            [
                'label' => __( 'Normal', 'weddingpress' ),
            ]
        );

        $this->add_control(
            'bulk_button_text_color',
            [
                'label' => __( 'Text Color', 'weddingpress' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .btn-secondary-bulk' => 'fill: {{VALUE}}; color: {{VALUE}};',
                ],
                'default' => '#fff'
            ]
        );

        $this->add_control(
            'bulk_background_color',
            [
                'label' => __( 'Background Color', 'weddingpress' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .btn-secondary-bulk' => 'background-color: {{VALUE}};',
                ],
                'default' => '#198754'
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'bulk_tab_button_hover',
            [
                'label' => __( 'Hover', 'weddingpress' ),
            ]
        );

        $this->add_control(
            'bulk_hover_color',
            [
                'label' => __( 'Text Color', 'weddingpress' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .btn-secondary-bulk:hover, {{WRAPPER}} .btn-secondary-bulk:focus' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .btn-secondary-bulk:hover svg, {{WRAPPER}} .btn-secondary-bulk:focus svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'bulk_button_background_hover_color',
            [
                'label' => __( 'Background Color', 'weddingpress' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .btn-secondary-bulk:hover, {{WRAPPER}} .btn-secondary-bulk:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'bulk_button_hover_border_color',
            [
                'label' => __( 'Border Color', 'weddingpress' ),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .btn-secondary-bulk:hover, {{WRAPPER}} .btn-secondary-bulk:focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'bulk_border',
                'selector' => '{{WRAPPER}} .btn-secondary-bulk',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'bulk_border_radius',
            [
                'label' => __( 'Border Radius', 'weddingpress' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .btn-secondary-bulk' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'bulk_button_box_shadow',
                'selector' => '{{WRAPPER}} .btn-secondary-bulk',
            ]
        );

        $this->add_responsive_control(
            'bulk_text_padding',
            [
                'label' => __( 'Text Padding', 'weddingpress' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .btn-secondary-bulk' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();
 
         /* Button Formal */
 
         $this->start_controls_section(
             'formal_section_style',
             [
                 'label' => __( 'Button Formal', 'weddingpress' ),
                 'tab' => Controls_Manager::TAB_STYLE,
             ]
         );
 
         $this->add_group_control(
             Group_Control_Typography::get_type(),
             [
                 'name' => 'formal_typography',
                 'selector' => '{{WRAPPER}} .btn-primary',
             ]
         );
 
         $this->start_controls_tabs( 
             'tabs_button_style_formal' 
         );
 
         $this->start_controls_tab(
             'formal_tab_button_formal',
             [
                 'label' => __( 'Normal', 'weddingpress' ),
             ]
         );
 
         $this->add_control(
             'formal_button_text_color',
             [
                 'label' => __( 'Text Color', 'weddingpress' ),
                 'type' => Controls_Manager::COLOR,
                 'default' => '',
                 'selectors' => [
                     '{{WRAPPER}} .btn-primary' => 'fill: {{VALUE}}; color: {{VALUE}};',
                 ],
             ]
         );
 
         $this->add_control(
             'formal_background_color',
             [
                 'label' => __( 'Background Color', 'weddingpress' ),
                 'type' => Controls_Manager::COLOR,
                 'selectors' => [
                     '{{WRAPPER}} .btn-primary' => 'background-color: {{VALUE}};',
                 ],
             ]
         );
 
         $this->end_controls_tab();
 
         $this->start_controls_tab(
             'formal_tab_button_hover',
             [
                 'label' => __( 'Hover', 'weddingpress' ),
             ]
         );
 
         $this->add_control(
             'formal_hover_color',
             [
                 'label' => __( 'Text Color', 'weddingpress' ),
                 'type' => Controls_Manager::COLOR,
                 'selectors' => [
                     '{{WRAPPER}} .btn-primary:hover, {{WRAPPER}} .btn-primary:focus' => 'color: {{VALUE}};',
 
                 ],
             ]
         );
 
         $this->add_control(
             'formal_button_background_hover_color',
             [
                 'label' => __( 'Background Color', 'weddingpress' ),
                 'type' => Controls_Manager::COLOR,
                 'selectors' => [
                     '{{WRAPPER}} .btn-primary:hover, {{WRAPPER}} .btn-primary:focus' => 'background-color: {{VALUE}};',
                 ],
             ]
         );
 
         $this->add_control(
             'formal_button_hover_border_color',
             [
                 'label' => __( 'Border Color', 'weddingpress' ),
                 'type' => Controls_Manager::COLOR,
                 'condition' => [
                     'border_border!' => '',
                 ],
                 'selectors' => [
                     '{{WRAPPER}} .btn-primary:hover, {{WRAPPER}} .btn-primary:focus' => 'border-color: {{VALUE}};',
                 ],
             ]
         );
 
         $this->end_controls_tabs();
 
         $this->add_group_control(
             Group_Control_Border::get_type(),
             [
                 'name' => 'formal_border',
                 'selector' => '{{WRAPPER}} .btn-primary',
                 'separator' => 'before',
             ]
         );
 
         $this->add_control(
             'formal_border_radius',
             [
                 'label' => __( 'Border Radius', 'weddingpress' ),
                 'type' => Controls_Manager::DIMENSIONS,
                 'size_units' => [ 'px', '%' ],
                 'selectors' => [
                     '{{WRAPPER}} .btn-primary' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                 ],
             ]
         );
 
         $this->add_group_control(
             Group_Control_Box_Shadow::get_type(),
             [
                 'name' => 'formal_button_box_shadow',
                 'selector' => '{{WRAPPER}} .btn-primary',
             ]
         );
 
         $this->add_responsive_control(
             'formal_text_padding',
             [
                 'label' => __( 'Text Padding', 'weddingpress' ),
                 'type' => Controls_Manager::DIMENSIONS,
                 'size_units' => [ 'px', 'em', '%' ],
                 'selectors' => [
                     '{{WRAPPER}} .btn-primary' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                 ],
                 'separator' => 'before',
             ]
         );
 
         $this->end_controls_section();
 
         /* Button Muslim */
 
         $this->start_controls_section(
             'section_style',
             [
                 'label' => __( 'Button Muslim', 'weddingpress' ),
                 'tab' => Controls_Manager::TAB_STYLE,
             ]
         );
 
         $this->add_group_control(
             Group_Control_Typography::get_type(),
             [
                 'name' => 'typography',
                 'selector' => '{{WRAPPER}} .btn-success',
             ]
         );
 
         $this->start_controls_tabs( 'tabs_button_style' );
 
         $this->start_controls_tab(
             'tab_button_formal',
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
                     '{{WRAPPER}} .btn-success' => 'fill: {{VALUE}}; color: {{VALUE}};',
                 ],
             ]
         );
 
         $this->add_control(
             'background_color',
             [
                 'label' => __( 'Background Color', 'weddingpress' ),
                 'type' => Controls_Manager::COLOR,
                 'selectors' => [
                     '{{WRAPPER}} .btn-success' => 'background-color: {{VALUE}};',
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
                     '{{WRAPPER}} .btn-success:hover, {{WRAPPER}} .btn-success:focus' => 'color: {{VALUE}};',
                     '{{WRAPPER}} .btn-success:hover svg, {{WRAPPER}} .btn-success:focus svg' => 'fill: {{VALUE}};',
                 ],
             ]
         );
 
         $this->add_control(
             'button_background_hover_color',
             [
                 'label' => __( 'Background Color', 'weddingpress' ),
                 'type' => Controls_Manager::COLOR,
                 'selectors' => [
                     '{{WRAPPER}} .btn-success:hover, {{WRAPPER}} .btn-success:focus' => 'background-color: {{VALUE}};',
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
                     '{{WRAPPER}} .btn-success:hover, {{WRAPPER}} .btn-success:focus' => 'border-color: {{VALUE}};',
                 ],
             ]
         );
 
         $this->end_controls_tabs();
 
         $this->add_group_control(
             Group_Control_Border::get_type(),
             [
                 'name' => 'border',
                 'selector' => '{{WRAPPER}} .btn-success',
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
                     '{{WRAPPER}} .btn-success' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                 ],
             ]
         );
 
         $this->add_group_control(
             Group_Control_Box_Shadow::get_type(),
             [
                 'name' => 'button_box_shadow',
                 'selector' => '{{WRAPPER}} .btn-success',
             ]
         );
 
         $this->add_responsive_control(
             'text_padding',
             [
                 'label' => __( 'Text Padding', 'weddingpress' ),
                 'type' => Controls_Manager::DIMENSIONS,
                 'size_units' => [ 'px', 'em', '%' ],
                 'selectors' => [
                     '{{WRAPPER}} .btn-success' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                 ],
                 'separator' => 'before',
             ]
         );
 
         $this->end_controls_section();
 
 
 
         /* Button Nasrani */
 
         $this->start_controls_section(
             'nasrani_section_style',
             [
                 'label' => __( 'Button Nasrani', 'weddingpress' ),
                 'tab' => Controls_Manager::TAB_STYLE,
             ]
         );
 
         $this->add_group_control(
             Group_Control_Typography::get_type(),
             [
                 'name' => 'nasrani_typography',
                 'selector' => '{{WRAPPER}} .btn-secondary',
             ]
         );
 
         $this->start_controls_tabs( 
             'tabs_button_style_nasrani' 
         );
 
         $this->start_controls_tab(
             'nasrani_tab_button_formal',
             [
                 'label' => __( 'Normal', 'weddingpress' ),
             ]
         );
 
         $this->add_control(
             'nasrani_button_text_color',
             [
                 'label' => __( 'Text Color', 'weddingpress' ),
                 'type' => Controls_Manager::COLOR,
                 'default' => '',
                 'selectors' => [
                     '{{WRAPPER}} .btn-secondary' => 'fill: {{VALUE}}; color: {{VALUE}};',
                 ],
             ]
         );
 
         $this->add_control(
             'nasrani_background_color',
             [
                 'label' => __( 'Background Color', 'weddingpress' ),
                 'type' => Controls_Manager::COLOR,
                 'selectors' => [
                     '{{WRAPPER}} .btn-secondary' => 'background-color: {{VALUE}};',
                 ],
             ]
         );
 
         $this->end_controls_tab();
 
         $this->start_controls_tab(
             'nasrani_tab_button_hover',
             [
                 'label' => __( 'Hover', 'weddingpress' ),
             ]
         );
 
         $this->add_control(
             'nasrani_hover_color',
             [
                 'label' => __( 'Text Color', 'weddingpress' ),
                 'type' => Controls_Manager::COLOR,
                 'selectors' => [
                     '{{WRAPPER}} .btn-secondary:hover, {{WRAPPER}} .btn-secondary:focus' => 'color: {{VALUE}};',
                     '{{WRAPPER}} .btn-secondary:hover svg, {{WRAPPER}} .btn-secondary:focus svg' => 'fill: {{VALUE}};',
                 ],
             ]
         );
 
         $this->add_control(
             'nasrani_button_background_hover_color',
             [
                 'label' => __( 'Background Color', 'weddingpress' ),
                 'type' => Controls_Manager::COLOR,
                 'selectors' => [
                     '{{WRAPPER}} .btn-secondary:hover, {{WRAPPER}} .btn-secondary:focus' => 'background-color: {{VALUE}};',
                 ],
             ]
         );
 
         $this->add_control(
             'nasrani_button_hover_border_color',
             [
                 'label' => __( 'Border Color', 'weddingpress' ),
                 'type' => Controls_Manager::COLOR,
                 'condition' => [
                     'border_border!' => '',
                 ],
                 'selectors' => [
                     '{{WRAPPER}} .btn-secondary:hover, {{WRAPPER}} .btn-secondary:focus' => 'border-color: {{VALUE}};',
                 ],
             ]
         );
 
         $this->end_controls_tabs();
 
         $this->add_group_control(
             Group_Control_Border::get_type(),
             [
                 'name' => 'nasrani_border',
                 'selector' => '{{WRAPPER}} .btn-secondary',
                 'separator' => 'before',
             ]
         );
 
         $this->add_control(
             'nasrani_border_radius',
             [
                 'label' => __( 'Border Radius', 'weddingpress' ),
                 'type' => Controls_Manager::DIMENSIONS,
                 'size_units' => [ 'px', '%' ],
                 'selectors' => [
                     '{{WRAPPER}} .btn-secondary' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                 ],
             ]
         );
 
         $this->add_group_control(
             Group_Control_Box_Shadow::get_type(),
             [
                 'name' => 'nasrani_button_box_shadow',
                 'selector' => '{{WRAPPER}} .btn-secondary',
             ]
         );
 
         $this->add_responsive_control(
             'nasrani_text_padding',
             [
                 'label' => __( 'Text Padding', 'weddingpress' ),
                 'type' => Controls_Manager::DIMENSIONS,
                 'size_units' => [ 'px', 'em', '%' ],
                 'selectors' => [
                     '{{WRAPPER}} .btn-secondary' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                 ],
                 'separator' => 'before',
             ]
         );
 
         $this->end_controls_section();
 
         /* Button Hindu */
 
         $this->start_controls_section(
             'hindu_section_style',
             [
                 'label' => __( 'Button Hindu', 'weddingpress' ),
                 'tab' => Controls_Manager::TAB_STYLE,
             ]
         );
 
         $this->add_group_control(
             Group_Control_Typography::get_type(),
             [
                 'name' => 'hindu_typography',
                 'selector' => '{{WRAPPER}} .btn-warning',
             ]
         );
 
         $this->start_controls_tabs( 
             'tabs_button_style_hindu' 
         );
 
         $this->start_controls_tab(
             'hindu_tab_button_hindu',
             [
                 'label' => __( 'Normal', 'weddingpress' ),
             ]
         );
 
         $this->add_control(
             'hindu_button_text_color',
             [
                 'label' => __( 'Text Color', 'weddingpress' ),
                 'type' => Controls_Manager::COLOR,
                 'default' => '',
                 'selectors' => [
                     '{{WRAPPER}} .btn-warning' => 'fill: {{VALUE}}; color: {{VALUE}};',
                 ],
             ]
         );
 
         $this->add_control(
             'hindu_background_color',
             [
                 'label' => __( 'Background Color', 'weddingpress' ),
                 'type' => Controls_Manager::COLOR,
                 'selectors' => [
                     '{{WRAPPER}} .btn-warning' => 'background-color: {{VALUE}};',
                 ],
             ]
         );
 
         $this->end_controls_tab();
 
         $this->start_controls_tab(
             'hindu_tab_button_hover',
             [
                 'label' => __( 'Hover', 'weddingpress' ),
             ]
         );
 
         $this->add_control(
             'hindu_hover_color',
             [
                 'label' => __( 'Text Color', 'weddingpress' ),
                 'type' => Controls_Manager::COLOR,
                 'selectors' => [
                     '{{WRAPPER}} .btn-warning:hover, {{WRAPPER}} .btn-warning:focus' => 'color: {{VALUE}};',
                     '{{WRAPPER}} .btn-warning:hover svg, {{WRAPPER}} .btn-warning:focus svg' => 'fill: {{VALUE}};',
                 ],
             ]
         );
 
         $this->add_control(
             'hindu_button_background_hover_color',
             [
                 'label' => __( 'Background Color', 'weddingpress' ),
                 'type' => Controls_Manager::COLOR,
                 'selectors' => [
                     '{{WRAPPER}} .btn-warning:hover, {{WRAPPER}} .btn-warning:focus' => 'background-color: {{VALUE}};',
                 ],
             ]
         );
 
         $this->add_control(
             'hindu_button_hover_border_color',
             [
                 'label' => __( 'Border Color', 'weddingpress' ),
                 'type' => Controls_Manager::COLOR,
                 'condition' => [
                     'border_border!' => '',
                 ],
                 'selectors' => [
                     '{{WRAPPER}} .btn-warning:hover, {{WRAPPER}} .btn-warning:focus' => 'border-color: {{VALUE}};',
                 ],
             ]
         );
 
         $this->end_controls_tabs();
 
         $this->add_group_control(
             Group_Control_Border::get_type(),
             [
                 'name' => 'hindu_border',
                 'selector' => '{{WRAPPER}} .btn-warning',
                 'separator' => 'before',
             ]
         );
 
         $this->add_control(
             'hindu_border_radius',
             [
                 'label' => __( 'Border Radius', 'weddingpress' ),
                 'type' => Controls_Manager::DIMENSIONS,
                 'size_units' => [ 'px', '%' ],
                 'selectors' => [
                     '{{WRAPPER}} .btn-warning' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                 ],
             ]
         );
 
         $this->add_group_control(
             Group_Control_Box_Shadow::get_type(),
             [
                 'name' => 'hindu_button_box_shadow',
                 'selector' => '{{WRAPPER}} .btn-warning',
             ]
         );
 
         $this->add_responsive_control(
             'hindu_text_padding',
             [
                 'label' => __( 'Text Padding', 'weddingpress' ),
                 'type' => Controls_Manager::DIMENSIONS,
                 'size_units' => [ 'px', 'em', '%' ],
                 'selectors' => [
                     '{{WRAPPER}} .btn-warning' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                 ],
                 'separator' => 'before',
             ]
         );
 
         $this->end_controls_section();
 
         /* Button Costum */
 
         $this->start_controls_section(
             'custom_section_style',
             [
                 'label' => __( 'Button Custom', 'weddingpress' ),
                 'tab' => Controls_Manager::TAB_STYLE,
             ]
         );
 
         $this->add_group_control(
             Group_Control_Typography::get_type(),
             [
                 'name' => 'custom_typography',
                 'selector' => '{{WRAPPER}} .btn-danger',
             ]
         );
 
         $this->start_controls_tabs( 
             'tabs_button_style_custom' 
         );
 
         $this->start_controls_tab(
             'custom_tab_button_custom',
             [
                 'label' => __( 'Normal', 'weddingpress' ),
             ]
         );
 
         $this->add_control(
             'custom_button_text_color',
             [
                 'label' => __( 'Text Color', 'weddingpress' ),
                 'type' => Controls_Manager::COLOR,
                 'default' => '',
                 'selectors' => [
                     '{{WRAPPER}} .btn-danger' => 'fill: {{VALUE}}; color: {{VALUE}};',
                 ],
             ]
         );
 
         $this->add_control(
             'custom_background_color',
             [
                 'label' => __( 'Background Color', 'weddingpress' ),
                 'type' => Controls_Manager::COLOR,
                 'selectors' => [
                     '{{WRAPPER}} .btn-danger' => 'background-color: {{VALUE}};',
                 ],
             ]
         );
 
         $this->end_controls_tab();
 
         $this->start_controls_tab(
             'custom_tab_button_hover',
             [
                 'label' => __( 'Hover', 'weddingpress' ),
             ]
         );
 
         $this->add_control(
             'custom_hover_color',
             [
                 'label' => __( 'Text Color', 'weddingpress' ),
                 'type' => Controls_Manager::COLOR,
                 'selectors' => [
                     '{{WRAPPER}} .btn-danger:hover, {{WRAPPER}} .btn-danger:focus' => 'color: {{VALUE}};',
                     '{{WRAPPER}} .btn-danger:hover svg, {{WRAPPER}} .btn-danger:focus svg' => 'fill: {{VALUE}};',
                 ],
             ]
         );
 
         $this->add_control(
             'custom_button_background_hover_color',
             [
                 'label' => __( 'Background Color', 'weddingpress' ),
                 'type' => Controls_Manager::COLOR,
                 'selectors' => [
                     '{{WRAPPER}} .btn-danger:hover, {{WRAPPER}} .btn-danger:focus' => 'background-color: {{VALUE}};',
                 ],
             ]
         );
 
         $this->add_control(
             'custom_button_hover_border_color',
             [
                 'label' => __( 'Border Color', 'weddingpress' ),
                 'type' => Controls_Manager::COLOR,
                 'condition' => [
                     'border_border!' => '',
                 ],
                 'selectors' => [
                     '{{WRAPPER}} .btn-danger:hover, {{WRAPPER}} .btn-danger:focus' => 'border-color: {{VALUE}};',
                 ],
             ]
         );
 
         $this->end_controls_tabs();
 
         $this->add_group_control(
             Group_Control_Border::get_type(),
             [
                 'name' => 'custom_border',
                 'selector' => '{{WRAPPER}} .btn-danger',
                 'separator' => 'before',
             ]
         );
 
         $this->add_control(
             'custom_border_radius',
             [
                 'label' => __( 'Border Radius', 'weddingpress' ),
                 'type' => Controls_Manager::DIMENSIONS,
                 'size_units' => [ 'px', '%' ],
                 'selectors' => [
                     '{{WRAPPER}} .btn-danger' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                 ],
             ]
         );
 
         $this->add_group_control(
             Group_Control_Box_Shadow::get_type(),
             [
                 'name' => 'custom_button_box_shadow',
                 'selector' => '{{WRAPPER}} .btn-danger',
             ]
         );
 
         $this->add_responsive_control(
             'custom_text_padding',
             [
                 'label' => __( 'Text Padding', 'weddingpress' ),
                 'type' => Controls_Manager::DIMENSIONS,
                 'size_units' => [ 'px', 'em', '%' ],
                 'selectors' => [
                     '{{WRAPPER}} .btn-danger' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                 ],
                 'separator' => 'before',
             ]
         );
 
         $this->end_controls_section();
 
         /* Button Create */
 
         $this->start_controls_section(
             'create_section_style',
             [
                 'label' => __( 'Button Buat Daftar', 'weddingpress' ),
                 'tab' => Controls_Manager::TAB_STYLE,
             ]
         );
 
         $this->add_group_control(
             Group_Control_Typography::get_type(),
             [
                 'name' => 'create_typography',
                 'selector' => '{{WRAPPER}} .btn-dark',
             ]
         );
 
         $this->start_controls_tabs( 
             'tabs_button_style_create' 
         );
 
         $this->start_controls_tab(
             'create_tab_button_create',
             [
                 'label' => __( 'Normal', 'weddingpress' ),
             ]
         );
 
         $this->add_control(
             'create_button_text_color',
             [
                 'label' => __( 'Text Color', 'weddingpress' ),
                 'type' => Controls_Manager::COLOR,
                 'default' => '',
                 'selectors' => [
                     '{{WRAPPER}} .btn-dark' => 'fill: {{VALUE}}; color: {{VALUE}};',
                 ],
             ]
         );
 
         $this->add_control(
             'create_background_color',
             [
                 'label' => __( 'Background Color', 'weddingpress' ),
                 'type' => Controls_Manager::COLOR,
                 'selectors' => [
                     '{{WRAPPER}} .btn-dark' => 'background-color: {{VALUE}};',
                 ],
             ]
         );
 
         $this->end_controls_tab();
 
         $this->start_controls_tab(
             'create_tab_button_hover',
             [
                 'label' => __( 'Hover', 'weddingpress' ),
             ]
         );
 
         $this->add_control(
             'create_hover_color',
             [
                 'label' => __( 'Text Color', 'weddingpress' ),
                 'type' => Controls_Manager::COLOR,
                 'selectors' => [
                     '{{WRAPPER}} .btn-dark:hover, {{WRAPPER}} .btn-dark:focus' => 'color: {{VALUE}};',
                     '{{WRAPPER}} .btn-dark:hover svg, {{WRAPPER}} .btn-dark:focus svg' => 'fill: {{VALUE}};',
                 ],
             ]
         );
 
         $this->add_control(
             'create_button_background_hover_color',
             [
                 'label' => __( 'Background Color', 'weddingpress' ),
                 'type' => Controls_Manager::COLOR,
                 'selectors' => [
                     '{{WRAPPER}} .btn-dark:hover, {{WRAPPER}} .btn-dark:focus' => 'background-color: {{VALUE}};',
                 ],
             ]
         );
 
         $this->add_control(
             'create_button_hover_border_color',
             [
                 'label' => __( 'Border Color', 'weddingpress' ),
                 'type' => Controls_Manager::COLOR,
                 'condition' => [
                     'border_border!' => '',
                 ],
                 'selectors' => [
                     '{{WRAPPER}} .btn-dark:hover, {{WRAPPER}} .btn-dark:focus' => 'border-color: {{VALUE}};',
                 ],
             ]
         );
 
         $this->end_controls_tabs();
 
         $this->add_group_control(
             Group_Control_Border::get_type(),
             [
                 'name' => 'create_border',
                 'selector' => '{{WRAPPER}} .btn-dark',
                 'separator' => 'before',
             ]
         );
 
         $this->add_control(
             'create_border_radius',
             [
                 'label' => __( 'Border Radius', 'weddingpress' ),
                 'type' => Controls_Manager::DIMENSIONS,
                 'size_units' => [ 'px', '%' ],
                 'selectors' => [
                     '{{WRAPPER}} .btn-dark' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                 ],
             ]
         );
 
         $this->add_group_control(
             Group_Control_Box_Shadow::get_type(),
             [
                 'name' => 'create_button_box_shadow',
                 'selector' => '{{WRAPPER}} .btn-dark',
             ]
         );
 
         $this->add_responsive_control(
             'create_text_padding',
             [
                 'label' => __( 'Text Padding', 'weddingpress' ),
                 'type' => Controls_Manager::DIMENSIONS,
                 'size_units' => [ 'px', 'em', '%' ],
                 'selectors' => [
                     '{{WRAPPER}} .btn-dark' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                 ],
                 'separator' => 'before',
             ]
         );
 
         $this->end_controls_section();
 
     }
 
     protected function render()
     {
         $settings = $this->get_settings_for_display();
         if( class_exists( 'WDP_Sendkit_Widget_Controls' ) ) {$status = get_option( 'wdpsendkit_license_key_status', false );
         if ( ! in_array( $status, array( 'ok' ) ) ) {return;}
         $wdp_google_sheets_apikey = get_option( 'wdp_google_sheets_api' );
         $delay_minutes = $settings['delay_minutes'] ? intval($settings['delay_minutes']) : 1;
 
         if(isset($settings['wa_gateway'])){
             $wa_gateway = $settings['wa_gateway'];
             update_post_meta( intval(get_the_ID()), 'wa_gateway', $wa_gateway);
         } else {
             update_post_meta( intval(get_the_ID()), 'wa_gateway', 'no');	
         }
         ?>
         <script>
         function importExcel(){var fileInput=document.getElementById('import_excel');var file=fileInput.files[0];var reader=new FileReader();reader.onload=function(e){var data=new Uint8Array(e.target.result);var workbook=XLSX.read(data,{type:'array'});var firstSheet=workbook.Sheets[workbook.SheetNames[0]];var contacts=XLSX.utils.sheet_to_json(firstSheet,{header:1});var contactTextarea=document.getElementById('contact');var contactNamesPhones=contacts.slice(1).map(function(row){if(row[0]&&row[1]){return row[0]+' - '+row[1]}}).filter(Boolean).join('\n');contactTextarea.value=contactNamesPhones};reader.readAsArrayBuffer(file)}
         function importGoogleSheet(){var sheetUrl=document.getElementById('google_sheet_url').value;var sheetId=extractSheetId(sheetUrl);var apiKey='<?php echo $wdp_google_sheets_apikey;?>';var url=`https://sheets.googleapis.com/v4/spreadsheets/${sheetId}/values/Sheet1?key=${apiKey}`;fetch(url).then(response=>response.json()).then(data=>{var rows=data.values;var contactTextarea=document.getElementById('contact');var contactNamesPhones=rows.slice(1).map(function(row){if(row[0]&&row[1]){return row[0]+' - '+row[1]}}).filter(Boolean).join('\n');contactTextarea.value=contactNamesPhones}).catch(error=>console.error('Error fetching Google Sheets data:',error))}
         function extractSheetId(url){var regex=/\/spreadsheets\/d\/([a-zA-Z0-9-_]+)/;var match=url.match(regex);return match?match[1]:null}
         </script><?php
         };?>
         <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet">
         <style>
             .gb-flex{display:inline-flex;width:280px;column-gap:3px}@media screen and (max-width:728px){.gb-flex{display:inline-block;width:auto}.wdp-mobile{padding-top:10px;}.wdp-btn-mobile{width:100%;}}.btn-opsi{font-size:11px;padding:2px 6px}.copy-btn{background:#ffc107;color:#000}.copy-btn:hover{background:#d39e00;color:#000}.table-bordered td{padding:0.2rem!important}.custom{font-size:12px;padding:5px 10px;margin:2px 2px}.hapus{background:#dc3545;color:#fff;text-decoration:none!important}.wa{background:#198754;color:#fff;text-decoration:none!important}.fb{background:#0d6efd;color:#fff;text-decoration:none!important}.link{background:#000;color:#fff;text-decoration:none!important}.textcopy{background:#ffc107;color:#fff;text-decoration:none!important}.hapus:hover{background:#dc3545;color:#fff;opacity:.7}.wa:hover{background:#198754;color:#fff;opacity:.7;text-decoration:none!important}.fb:hover{background:#0d6efd;color:#fff;opacity:.7;text-decoration:none!important}.link:hover{background:#000;color:#fff;opacity:.7;text-decoration:none!important}.textcopy:hover{background:#ffc107;color:#fff;opacity:.7;text-decoration:none!important}.button-group{text-align:center;margin-top:6px;margin-bottom:12px}label{text-align:center}.btn-sm{min-width:1.8em;padding:.30em;margin-left:10px;cursor:pointer}.btn-sm1{min-width:1.8em;padding:.30em;cursor:pointer}
         </style>
         <div id="__root">
             <div class="gb-notify">
                 <div data-content="notify-message">Text berhasil di copy, silahkan pastekan di kolom chat</div>
             </div>
             <div class="container-sm gb-container gb-space-y-6 md:gb-space-y-10">
                 <div class="wrap-item form-input">
                     <div class="gb-w-full">
                         <div class="card">
                             <div class="card-body gb-flex-col">
                                 <div class="form-group">
                                 <div class="row">
                                     <div class="col">
                                         <label for="contact">Silahkan Masukan Nama Tamu</label>
                                         <p>* Gunakan baris baru (<kbd>&crarr;</kbd>)  untuk memisahkan nama yang akan Anda undang.</p>
                                     </div>
                                     <div class="col-md-2 mb-3">
                                         <label for="invitation_url">Pilih</label>
                                         <select class="form-control d-block w-100" id="invitation_url" name="invitation_url" data-content="invitation_url" required="">
                                         <option value="?to=" data-value="?to=">to</option>
                                         <option value="?dear=" data-value="?dear=">dear</option>
                                         <option value="?kepada=" data-value="?kepada=">kepada</option>
                                         </select>
                                     </div>
                                 </div>
                                     <textarea name="contact" class="form-control" id="contact" cols="30" rows="5" data-content="contact" placeholder="Nama Tamu"></textarea>
                                     <?php if(isset($settings['enable_wa_notif']) &&  $settings['enable_wa_notif'] == 'yes'){ if( class_exists( 'WDP_Sendkit_Widget_Controls' ) ) {$status = get_option('wdpsendkit_license_key_status', false );if ( ! in_array( $status, array( 'ok' ) ) ) {return;} ?>
                                     <div class="row" style="padding-top: 20px; padding-bottom: 20px;">
                                         <div class="col-md-6">
                                             <div class="form-group">
                                                 <input type="file" id="import_excel" class="form-control">
                                                 <button type="button" class="btn btn-secondary-excel mt-2 wdp-btn-mobile" onclick="importExcel()">Import Excel</button>
                                             </div>
                                         </div>
                                         <div class="col-md-6 wdp-mobile">
                                             <div class="form-group">
                                                 <input type="text" id="google_sheet_url" class="form-control" placeholder="Paste Google Sheet URL here">
                                                 <button type="button" class="btn btn-secondary-sheet mt-2 wdp-btn-mobile" onclick="importGoogleSheet()">Import Google Sheets</button>
                                             </div>
                                         </div>
                                     </div><?php }};?>
                                 </div>
                                 <div class="form-group">
                                     <div class="gb-mb-3">
                                         <label for="message">Silahkan Masukan Text Pengantar</label>
                                         <p>* Isikan text ini [link-undangan] pada text pengantar agar otomatis tercantumkan link kehalaman undangan.</p>
                                         <p>* Anda juga bisa menggunakan [nama] untuk menyertakan nama yang Anda undang.</p>
                                     </div>
                                     <label for="message" style="margin-top:1.5rem">Pilih Ucapan Text Pengantar</label>
                                     <div class="button-group">
                                         <?php if (!$settings['hide_formal']) :?>
                                         <button id="text1" onclick="changeText('<?php echo $settings['message']; ?>')" class="btn btn-primary btn-sm" type="button"><?php echo $settings['label_formal'];?></button>
                                         <?php endif;?>
                                         <?php if (!$settings['hide_muslim']) :?>
                                         <button id="text2" onclick="changeText('<?php echo $settings['message2']; ?>')" class="btn btn-success btn-sm" type="button"><?php echo $settings['label_muslim'];?></button>
                                         <?php endif;?>   
                                         <?php if (!$settings['hide_nasrani']) :?> 
                                         <button id="text3" onclick="changeText('<?php echo $settings['message3']; ?>')" class="btn btn-secondary btn-sm" type="button"><?php echo $settings['label_nasrani'];?></button>
                                         <?php endif;?>
                                         <?php if (!$settings['hide_hindu']) :?>
                                         <button id="text4" onclick="changeText('<?php echo $settings['message4']; ?>')" class="btn btn-warning btn-sm" type="button"><?php echo $settings['label_hindu'];?></button>
                                         <?php endif;?>
                                         <?php if (!$settings['hide_custom']) :?>
                                         <button id="text5" onclick="changeText('<?php echo $settings['message5']; ?>')" class="btn btn-danger btn-sm" type="button"><?php echo $settings['custom'];?></button>
                                         <?php endif;?>
                                     </div>
                                     <textarea name="message" class="form-control" id="message" cols="30" rows="20" data-content="message" placeholder="Masukan kata pengantar">
                                     </textarea>
                                 </div>
                                 <div class="button-submit mt-3" style="text-align: center;">
                                     <button class="btn btn-dark" type="button" data-content="button-submit">Buat Daftar Nama Tamu</button>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
 
                 <div class="wrap-item mt-5">
                     <div class="gb-w-full card ">
                         <div class="card-body">
                             <div class="gb-w-full">
                                 <div class="gb-mb-3">
                                     <h3 class="gb-font-bold">Daftar Nama Tamu</h3>
                                     <p></p>
                                 </div>
                                 <table class="table table-striped">
                                     <thead class="table-dark">
                                         <tr>
                                             <th>No</th>
                                             <th>Tamu</th>
                                             <th style="width:165px !important;">Opsi</th>
                                         </tr>
                                     </thead>
                                     <tbody id="body--contact" data-content="body--contact">
                                     </tbody>
                                 </table>
                                 <?php if( class_exists( 'WDP_Sendkit_Widget_Controls' ) ) {$status = get_option( 'wdpsendkit_license_key_status', false );if ( ! in_array( $status, array( 'ok' ) ) ) {return;} ?>
                                 <?php if(isset($settings['enable_wa_notif']) &&  $settings['enable_wa_notif'] == 'yes'){?>
                                 <div class="button-submit mt-3 sendbulk" style="text-align: center;">
                                     <button class="btn btn-secondary-bulk" type="button" data-content="button-bulk">Bulk Send</button>
                                 </div>
                                 <p id="progress-text"></p>
                                 <?php };?>
                                 <?php };?>
                             </div>
                         </div>
 
                     </div>
                 </div>
             </div>
 
         </div>
 
         <script>
             function changeText(newText) {
                 var textarea = document.getElementById('message');
                 textarea.value = newText;
             }
         </script>
         <script type='text/javascript' id="guest-var">
            var wa_gateway = '<?php echo $wa_gateway; ?>';
            var delayMinutes = '<?php echo $delay_minutes; ?>';
            var settingDear = 'dear';
            window.guestInvitationData = {
                key: 'guestBookStorage-unikKey',
                template: "Tanpa mengurangi rasa hormat, perkenankan kami mengundang Bapak/Ibu/Saudara/i *[nama]* untuk menghadiri acara kami.\n\n*Berikut link undangan kami*, untuk info lengkap dari acara bisa kunjungi :\n\n[link-undangan]\n\nMerupakan suatu kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan untuk hadir dan memberikan doa restu.\n\n*Mohon maaf perihal undangan hanya di bagikan melalui pesan ini.*\n\nDan karena suasana masih pandemi, diharapkan untuk *tetap menggunakan masker dan datang pada jam yang telah ditentukan.*\n\nTerima kasih banyak atas perhatiannya.",
                invitationLink: "<?php 
                if (isset($_GET['id'])) {
                    $id = get_home_url() .'/'. sanitize_text_field($_GET['id']);
                    
                }
                if (isset($_GET['link'])) {
                    $iframe = isset($_GET['link'])?$_GET['link']:'';
                }
                goto link;
                echo get_home_url(); 
                if (isset($_GET['link']) || isset($_GET['id'])) {
                    link: echo $iframe ?? $id;
                } 
                ;?>",
                to: 'settingDear',
            }
         </script>
         <script>
         var pilihType = '?to=';
         jQuery(`select[id=invitation_url] option[value="${pilihType}"]`).prop('selected', true);
         jQuery('select[id=invitation_url]').data('invitation_url',pilihType);
         </script>
         <?php
     }
 
}