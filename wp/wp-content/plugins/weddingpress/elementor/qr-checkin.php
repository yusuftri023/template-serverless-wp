<?php

namespace WeddingPress\elementor;

// Elementor Classes.
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Utils;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class WeddingPress_Widget_QR_Checkin extends Widget_Base
{

	public function get_name()
	{
		return 'wdp-qrcode-checkin';
	}

	public function get_title()
	{
		return __('QR Code Checkin', 'weddingpress');
	}

	public function get_icon()
	{
		return 'wdp_icon eicon-barcode';
	}

	public function get_categories()
	{
		return ['weddingpress'];
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

    protected function register_controls() {
        $this->start_controls_section(
			'qr_checkin',
			[
				'label' => __('QR Code Checkin', 'weddingpress'),
			]
		);

        $this->add_control(
            'type_link',
            [
                'label' => __('Type QR Code', 'weddingpress'),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'name' => __('Name', 'weddingpress'),
                    'link' => __('Link', 'weddingpress'),
                ),
                'default' => 'name', 
            ]
        );

		
		$this->add_control(
            "param_qr_checkin",
            [
                'label' => esc_html__( 'Parameter', 'weddingpress' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'to',
                'options' => [
                    'to' => esc_html__( 'to', 'weddingpress' ),
                    'dear' => esc_html__( 'dear', 'weddingpress' ),
					'kepada' => esc_html__( 'kepada', 'weddingpress' ),
                ],
                'description' => __( 'Default parameter <b>to<b>', "weddingpress" ),
                "condition" => [
                    "type_link" => "name",
                ],
            ]
        );
        $this->add_control(
            'detail_type_link',
            [
                'label' => __('Type QR Code', 'weddingpress'),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'currentlink' => __('Link Halaman', 'weddingpress'),
                    'customlink' => __('Link Custom', 'weddingpress'),
                ),
                'default' => 'currentlink',
                "condition" => [
                    "type_link" => "link",
                ],
            ]
        );
        $this->add_control(
            "show_link",
            [
                "label" => __("Link", "weddingpress"),
                "type" => Controls_Manager::URL,
                "placeholder" => "https://weddingpress.co.id",
                'show_external' => false,
                'default' => [
                    'url' => 'https://weddingpress.co.id',
                    'is_external' => false,
                    'nofollow' => false,
                ],
                'description' => __( 'Link url', "weddingpress" ),
                "label_block" => true,
                'frontend_available' => true,
				
				'dynamic' => [
					'active' => true,
				],
                "condition" => [
                    "detail_type_link" => "customlink",
                    "type_link" => "link",
                ],
            ]
        );
        $this->add_control('wdp_qr_logo',[
                'label' => __( 'Gunakan Custom Icon', 'weddingpress' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '_useblank' => __( 'Tanpa Icon', 'weddingpress' ),
                    '_useimagelogo' => __( 'Custom Image', 'weddingpress' ),
					'_useweblogo' => __( 'Website Icon', 'weddingpress' ),  
                ],
                'default' => '_useblank',
                'description' => __( 'Icon di tengah QR Code', "weddingpress" ),
                "label_block" => true,
                "separator" => "before",
            ]
        );
        $this->add_control(
			'wdp_qr_logo_image',
			[
				'label'      => __( 'Logo QR', 'weddingpress' ),
				'type'       => Controls_Manager::MEDIA,
				'default'    => [
					'url' 	 => Utils::get_placeholder_image_src()
				],
				'dynamic'    => [
					'active' => true
                ],
                'condition'  => [
                    'wdp_qr_logo' => '_useimagelogo'
                ],
                'frontend_available' => true,
			]
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'thumbnail',
				'default'   => 'full',
				'condition' => [
                    'wdp_qr_logo' => '_useimagelogo'
                ]
			]
		);
		$this->add_control('type_qr_checkin',[
                'label' => __( 'Type QR Code', 'weddingpress' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'rounded' => __( 'Rounded', 'weddingpress' ),
					'square' => __( 'Square', 'weddingpress' ),
                    'dots' => __( 'Dots', 'weddingpress' ),        
					'classy' => __( 'Classy', 'weddingpress' ),   
					'classy-rounded' => __( 'Classy Rounded', 'weddingpress' ),      
					'extra-rounded' => __( 'Extra Rounded', 'weddingpress' ),   
                ],
                'default' => 'rounded',
                "label_block" => true,
                "separator" => "before",
            ]
        );

		$this->add_control("size_qr_checkin", [
                "label" => __("Size QR", "weddingpress"),
                'description' => __( 'Size range <b>150 - 250<b>', "weddingpress" ),
				"type" => Controls_Manager::NUMBER,
                'min' => 10,
				'max' => 250,
				'step' => 1,
				'default' => 150,
                'placeholder' => '150',
                
				'dynamic' => [
					'active' => true,
				],
                "separator" => "before",
            ]
        );

		$this->add_responsive_control("align_qr", [
            "label" => __("Alignment", "weddingpress"),
            "type" => Controls_Manager::CHOOSE,
            "options" => [
                "left" => [
                    "title" => __("Left", "weddingpress"),
                    "icon" => "eicon-text-align-left",
                ],
                "center" => [
                    "title" => __("Center", "weddingpress"),
                    "icon" => "eicon-text-align-center",
                ],
                "right" => [
                    "title" => __("Right", "weddingpress"),
                    "icon" => "eicon-text-align-right",
                ],
            ],
            "toggle" => true,
            "default" => "center",
            "selectors" => [
                "{{WRAPPER}} .qr_code" => "text-align: {{VALUE}};",
            ],
        ]);
		
        $this->end_controls_section();

		$this->start_controls_section("section_style_image", [
            "label" => __("Size Qr Checkin", "weddingpress"),
            "tab" => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_responsive_control("transform", [
            "label" => __("Width", "weddingpress"),
            "type" => Controls_Manager::SLIDER,
            "default" => [
                "size" => 1,
				"max" => 1,
            ],
            "range" => [
                "px" => [
                    "max" => 1,
                    "step" => 0.01,
                ],
            ],
            "selectors" => [
                "{{WRAPPER}} .qr_code" =>
                    "transform: scale({{SIZE}});",
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section(
            "style_qr_checkin",

            [
                "label" => __("Ubah Warna", "elkit"),

                "tab" => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            "color_qr_checkin",
            [
                "label" => __("Warna QR Code", "elkit"),
				'default' => '#000',
                "type" => Controls_Manager::COLOR,
            ]
        );

        $this->end_controls_section();
        
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $param = sanitize_text_field($settings['param_qr_checkin']);
        
        // Generate a random ID
        $rid = wp_rand(100, 999);
    
        // Determine the QR content
        if ($settings['type_link'] === 'link') {
            if ($settings['detail_type_link'] === 'customlink') {
                $qr_content = isset($settings['show_link']['url']) ? esc_url_raw($settings['show_link']['url']) : false;
            } else {
                $url_parts = wp_parse_url(home_url());
                $qr_content = esc_url($url_parts['scheme'] . '://' . $url_parts['host'] . add_query_arg(NULL, NULL));
            }
        } else {
            $qr_content = isset($_GET[$param]) ? sanitize_text_field($_GET[$param]) : false;
        }
    
        // Determine the logo URL
        if ($settings['wdp_qr_logo'] === '_useimagelogo') {
            $web_logo = isset($settings['wdp_qr_logo_image']['url']) ? esc_url_raw($settings['wdp_qr_logo_image']['url']) : false;
        } elseif ($settings['wdp_qr_logo'] === '_useweblogo') {
            $web_logo = esc_url(wp_get_attachment_url(get_theme_mod('custom_logo')));
        } else {
            $web_logo = '';
        }
        ?>
    
        <style>
            .qr_code img {
                display: inline !important;
            }
            .qr_code svg {
                width: auto;
                height: auto;
                fill: currentColor;
                display: inline-block;
                vertical-align: middle;
            }
        </style>
        <script type="text/javascript" src="https://unpkg.com/qr-code-styling@1.5.0/lib/qr-code-styling.js"></script>
        <script>
        function loadQRCodeStylingScript(callback) {
            const script = document.createElement('script');
            script.src = 'https://unpkg.com/qr-code-styling@1.5.0/lib/qr-code-styling.js';
            script.type = 'text/javascript';
            script.onload = callback;
            document.head.appendChild(script);
        }

        function initializeQRCode() {
            const qrCode = new QRCodeStyling({
                width: 300,
                height: 300,
                type: "svg",
                data: "https://example.com",
                // Additional options...
            });
            qrCode.append(document.getElementById('qr_code'));
        }

        // Load the script and then initialize the QR code
        loadQRCodeStylingScript(initializeQRCode);

        </script>
        <div id="qr_code_<?php echo esc_attr($rid); ?>" class="qr_code"></div>
        <script type="text/javascript">
            const qr_code_<?php echo esc_js($rid); ?> = new QRCodeStyling({
                width: <?php echo esc_js($settings['size_qr_checkin']); ?>,
                height: <?php echo esc_js($settings['size_qr_checkin']); ?>,
                type: "svg",
                data: "<?php echo esc_js($qr_content); ?>",
                image: "<?php echo esc_js($web_logo); ?>",
                qrOptions: {
                    errorCorrectionLevel: "Q"
                },
                dotsOptions: {
                    color: "<?php echo esc_js($settings['color_qr_checkin']); ?>",
                    type: "<?php echo esc_js($settings['type_qr_checkin']); ?>" 
                },
                backgroundOptions: {
                    color: "#FFF"
                },
                imageOptions: {
                    imageSize: 0.3,
                    crossOrigin: "anonymous",
                    margin: 2
                }
            });
            qr_code_<?php echo esc_js($rid); ?>.append(document.getElementById("qr_code_<?php echo esc_js($rid); ?>"));
        </script>
        <?php
    }
    
}