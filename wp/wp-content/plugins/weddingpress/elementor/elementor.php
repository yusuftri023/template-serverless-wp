<?php

namespace WeddingPress;

use Weddingpress\Elementor\Weddingpress_Widget_Whatsapp;
use Weddingpress\Elementor\Weddingpress_Widget_Countdown_Timer;
use Weddingpress\Elementor\Weddingpress_Widget_Guest_Book;
use Weddingpress\Elementor\Weddingpress_Widget_Timeline;
use Weddingpress\Elementor\Weddingpress_Widget_Audio;
use Weddingpress\Elementor\Weddingpress_Widget_Forms;
use Weddingpress\Elementor\Weddingpress_Widget_Wellcome;
use Weddingpress\Elementor\Weddingpress_Widget_Generatorkit;
use Weddingpress\Elementor\Weddingpress_Widget_Copy;
use Weddingpress\Elementor\Weddingpress_Widget_Senderkit;
use Weddingpress\Elementor\Weddingpress_Widget_Modal_Popup;
use Weddingpress\Elementor\Weddingpress_Widget_Comment_Kit;
use Weddingpress\Elementor\Weddingpress_Widget_Qrcode;
use Weddingpress\Elementor\WeddingPress_Widget_QR_Checkin;
use Weddingpress\Elementor\Weddingpress_Widget_WC_Order;
use Weddingpress\Elementor\Weddingpress_Widget_Date_Kit;
use Weddingpress\Elementor\Weddingpress_Widget_Date_Kit2;
use Weddingpress\Elementor\Weddingpress_Widget_FullScreen;
use Weddingpress\Elementor\Weddingpress_Widget_Kirim_Kit;
use Weddingpress\Elementor\Weddingpress_Widget_Comment_Kit2;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Main Addons Class
 *
 * Register new elementor widget.
 *
 * @since 1.0.0
 */

class WDP_Elementor {

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() {
		$this->add_actions();
	}

	/**
	 * Add Actions
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function add_actions() {

		add_action( 'elementor/init', [ $this, 'on_init' ] );
		add_action( 'elementor/elements/categories_registered', [ $this, 'on_categories_registered' ], 1 );
		add_action( 'elementor/widgets/register', [ $this, 'on_widgets_registered' ], 1 );
		add_action( 'wp_enqueue_scripts', [ $this, 'wdp_enqueue_style'] );
		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'after_enqueue_styles' ] );
		add_action( 'elementor/frontend/after_enqueue_scripts', [ $this, 'after_enqueue_scripts' ] );
		add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'editor_scripts' ] );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_style_scripts' ) );
		add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'register_style_scripts' ) );
		add_action( 'elementor/frontend/before_enqueue_scripts', array( $this, 'register_style_scripts' ) );
		add_action( 'elementor/editor/after_enqueue_scripts', array( $this, 'enqueue_elementor_editor_scripts' ));
		add_action( 'elementor/frontend/before_register_scripts', array($this, 'register_site_scripts'));
		add_action( 'elementor/frontend/after_register_styles', [$this, 'enqueue_site_styles']);
		add_action('elementor/frontend/before_enqueue_scripts', [$this, 'enqueue_site_scripts']);
		add_action('wp_enqueue_scripts', [$this, 'enqueue_qr_code_script']);
        if( class_exists( 'WDP_Sendkit_Widget_Controls' ) ) {$status = get_option( 'wdpsendkit_license_key_status', false );if ( ! in_array( $status, array( 'ok' ) ) ) {return;}
		add_action('wp_ajax_send_text_to_onesender', [$this,'send_text_to_onesender_callback']);
		add_action('wp_ajax_nopriv_send_text_to_onesender', [$this,'send_text_to_onesender_callback']);
		add_action('wp_ajax_send_text_to_starsender', [$this, 'send_text_to_starsender_callback']);
		add_action('wp_ajax_nopriv_send_text_to_starsender', [$this, 'send_text_to_starsender_callback']);
		}
	}

	public function send_text_to_starsender_callback() {
		$wdp_starsender_apikey = get_option( 'wdp_starsender_apikey' );
		$message = isset($_POST['message']) ? $_POST['message'] : '';
		$phone   = isset($_POST['phone']) ? $_POST['phone'] : '';

		$curl = curl_init();
		$pesan = [
			"messageType" => "text",
			"to" => $phone,
			"body" => $message,
			"file" => "",                     
			"delay" => 0, 
			"schedule" => 0            
		];

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://api.starsender.online/api/send',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => json_encode($pesan),
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'Authorization: '. $wdp_starsender_apikey
			),
		));

		$response = curl_exec($curl);
		curl_close($curl);

		wp_send_json($response);
		
	}

	public function send_text_to_onesender_callback() {
		$wdp_onesender_apikey = get_option( 'wdp_onesender_apikey' );
		$wdp_onesender_apiurl = get_option( 'wdp_onesender_apiurl' );

		$postData = isset($_POST['postData']) ? $_POST['postData'] : array();
		$response = wp_remote_post($wdp_onesender_apiurl, [
			'headers' => array(
				'Authorization' => 'Bearer ' . $wdp_onesender_apikey,
				'Content-Type' => 'application/json'
			),
			'body' => json_encode($postData)
		]);
	
		wp_send_json($response);
		
	}
	
	public function enqueue_qr_code_script() {
		wp_enqueue_script(
			'qr-code-styling', 
			'https://unpkg.com/qr-code-styling@1.5.0/lib/qr-code-styling.js', 
			array(), 
			null, 
			true
		);

		wp_enqueue_script('kirimkit', 'https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js', array(), 
		null, 
		true);
		
		wp_enqueue_script('kirimkit', 'https://apis.google.com/js/api.js', array(), 
		null, 
		true);
	}

	/**
	 * Loading site related script that needs all time such as uikit.
	 * @return [type] [description]mn
	 */
	public function enqueue_site_scripts() {
		wp_enqueue_script('bdt-uikit', WEDDINGPRESS_ELEMENTOR_WEB . 'assets/js/modules/bdt-uikit.js', ['jquery'], '3.15.1', true);
	}

	/**
	 * Loading site related style from here.
	 * @return [type] [description]
	 */
	public function enqueue_site_styles() {

		wp_enqueue_style('bdt-uikit', WEDDINGPRESS_ELEMENTOR_WEB . 'assets/css/modules/bdt-uikit.css', [], '3.15.1');
		wp_enqueue_style('ep-helper', WEDDINGPRESS_ELEMENTOR_WEB . 'assets/css/modules/ep-helper.css', [], WEDDINGPRESS_ELEMENTOR_VERSION);
	}


	public function register_site_scripts() {

		wp_register_script('ep-timeline', WEDDINGPRESS_ELEMENTOR_WEB . 'assets/js/modules/ep-timeline.js', ['jquery'], WEDDINGPRESS_ELEMENTOR_VERSION, true);

    	wp_register_script('timeline', WEDDINGPRESS_ELEMENTOR_WEB . 'assets/js/modules/timeline.min.js', ['jquery'], null, true);

	}

	/**
     * Register the JavaScript for the Elementor editor area
     *
     * @since    1.0.0
     */
    public function enqueue_elementor_editor_scripts() {

        wp_enqueue_script( 'weddingpress-elementor-editor', WEDDINGPRESS_ELEMENTOR_WEB . 'assets/js/elementor-editor.min.js', array( 'elementor-editor' ), WEDDINGPRESS_ELEMENTOR_VERSION, true );

    }

	public function register_style_scripts() {
		
		wp_register_style(
			'wdp-woocommerce',
			WEDDINGPRESS_ELEMENTOR_WEB . 'assets/css/woocommerce.min.css',
			array(),
			WEDDINGPRESS_ELEMENTOR_VERSION
		);

		wp_register_style(
			'ep-timeline',
			WEDDINGPRESS_ELEMENTOR_WEB . 'assets/css/modules/ep-timeline.css',
			array(),
			WEDDINGPRESS_ELEMENTOR_VERSION
		);

		wp_register_style(
			'ep-font',
			WEDDINGPRESS_ELEMENTOR_WEB . 'assets/css/modules/ep-font.css',
			array(),
			WEDDINGPRESS_ELEMENTOR_VERSION
		);

		wp_register_script(
			'wdp-woocommerce',
			WEDDINGPRESS_ELEMENTOR_WEB . 'assets/js/woocommerce.min.js',
			array(
				'jquery',
			),
			WEDDINGPRESS_ELEMENTOR_VERSION,
			true
		);

		$wdp_woo_localize = apply_filters(
			'wdp_woo_elements_js_localize',
			array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'get_product_nonce' => wp_create_nonce( 'wdp-product-nonce' ),
			)
		);
		wp_localize_script( 'wdp-woocommerce', 'wdp_woo_products_script', $wdp_woo_localize );
		
	}


	/**
	 * On Init
	 *
	 * @since 0.1.0
	 *
	 * @access public
	 */
	public function on_init() {

		require_once ( WEDDINGPRESS_ELEMENTOR_PATH . 'elementor/skins/skin-olivier.php' );

	}

	/**

	 * On Categories Registered
	 *
	 * @since 0.1.0
	 *
	 * @access public
	 */

	public function on_categories_registered( $elements_manager ) {
		$elements_manager->add_category(
			'weddingpress',
			[
				'title' => __( 'Weddingpress', 'weddingpress' ),
				'icon' => 'font',
			]
		);
	}

	public function editor_scripts() {
		wp_enqueue_style( "wdp-editor-icon", WEDDINGPRESS_ELEMENTOR_URL . '/assets/css/editor.css' );
	}

 	public function wdp_enqueue_style() {
		wp_register_script( 'wdp-swiper-js', WEDDINGPRESS_ELEMENTOR_WEB  . 'assets/js/wdp-swiper.min.js',array('jquery'),null, true );	
		wp_register_script( 'weddingpress-qr', WEDDINGPRESS_ELEMENTOR_WEB  . 'assets/js/qr-code.js', array('jquery'),null, true );
		wp_enqueue_script( 'wdp-swiper-js' );	
		wp_enqueue_script( 'weddingpress-qr' );
		
		if ( ! \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			wp_enqueue_script( 'wdp-horizontal-js' );
		}

		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			// Output custom CSS
			echo '<div class="elementor-widget-container" style="transform: unset !important;"</div>';
		}
		wp_enqueue_style( 'exad-main-style', WEDDINGPRESS_ELEMENTOR_WEB  . 'assets/css/exad-styles.min.css' );
        wp_enqueue_script( 'exad-main-script', WEDDINGPRESS_ELEMENTOR_WEB . 'assets/js/exad-scripts.min.js', array('jquery'), WEDDINGPRESS_ELEMENTOR_VERSION, true );
		
	}
	
	public function after_enqueue_styles() {
		wp_enqueue_style(
			'weddingpress-wdp',
			WEDDINGPRESS_ELEMENTOR_URL . 'assets/css/wdp.css',
			[],
			WEDDINGPRESS_ELEMENTOR_VERSION
		);

		wp_enqueue_style(
			'kirim-kit',
			WEDDINGPRESS_ELEMENTOR_WEB . 'assets/css/guest-book.css',
			array(),
			WEDDINGPRESS_ELEMENTOR_VERSION
		);

	}

	public function after_enqueue_scripts() {
		wp_enqueue_script(
			'weddingpress-wdp',
			WEDDINGPRESS_ELEMENTOR_WEB . 'assets/js/wdp.min.js',
			[
				'jquery',
			],
			WEDDINGPRESS_ELEMENTOR_VERSION,
			true
		);


		wp_enqueue_script(
			'kirim-kit',
		 	WEDDINGPRESS_ELEMENTOR_WEB . 'assets/js/guest-form.js',
		 	array(
		 		'jquery',
		 	),
		 	WEDDINGPRESS_ELEMENTOR_VERSION,
		 	true
		);

		wp_localize_script('kirim-kit', 'sendkit_ajax', array(
			'ajax_url' => admin_url('admin-ajax.php'),
		));
		
		wp_localize_script( 'weddingpress-wdp', 'cevar', array(
			'ajax_url' => admin_url('admin-ajax.php'), 
			'plugin_url' => WEDDINGPRESS_ELEMENTOR_WEB, 
		));

	}

	/**
	 * On Widgets Registered
	 *
	 * @since 0.1.0
	 *
	 * @access public
	 */

	public function on_widgets_registered() {
		$this->includes();
		$this->register_widget();
	}

	/**
	 * Includes
	 *
	 * @since 0.1.0
	 *
	 * @access private
	 */
	private function includes() {
		require_once ( WEDDINGPRESS_ELEMENTOR_PATH . 'elementor/whatsapp.php' );
		require_once ( WEDDINGPRESS_ELEMENTOR_PATH . 'elementor/countdown-timer.php' );
		require_once ( WEDDINGPRESS_ELEMENTOR_PATH . 'elementor/guest-book.php' );
		require_once ( WEDDINGPRESS_ELEMENTOR_PATH . 'elementor/timeline.php' );
		require_once ( WEDDINGPRESS_ELEMENTOR_PATH . 'elementor/audio.php' );
		require_once ( WEDDINGPRESS_ELEMENTOR_PATH . 'elementor/forms.php' );
		require_once ( WEDDINGPRESS_ELEMENTOR_PATH . 'elementor/wellcome.php' );
		require_once ( WEDDINGPRESS_ELEMENTOR_PATH . 'elementor/generator-kit.php' );
		require_once ( WEDDINGPRESS_ELEMENTOR_PATH . 'elementor/copy.php' );
		require_once ( WEDDINGPRESS_ELEMENTOR_PATH . 'elementor/senderkit.php' );
		require_once ( WEDDINGPRESS_ELEMENTOR_PATH . 'elementor/modal-popup.php' );
		require_once ( WEDDINGPRESS_ELEMENTOR_PATH . 'elementor/comment-kit.php' );
		require_once ( WEDDINGPRESS_ELEMENTOR_PATH . 'elementor/qrcode.php' );
		require_once ( WEDDINGPRESS_ELEMENTOR_PATH . 'elementor/qr-checkin.php' );
		if ( function_exists( 'WC' ) ) {
		require_once ( WEDDINGPRESS_ELEMENTOR_PATH . 'elementor/woo-add-to-cart.php' );
		}
		require_once ( WEDDINGPRESS_ELEMENTOR_PATH . 'elementor/date-kit.php' );
		require_once ( WEDDINGPRESS_ELEMENTOR_PATH . 'elementor/date-kit2.php' );
		require_once ( WEDDINGPRESS_ELEMENTOR_PATH . 'elementor/fullscreen.php' );
		require_once ( WEDDINGPRESS_ELEMENTOR_PATH . 'elementor/kirim-kit.php' );
		require_once ( WEDDINGPRESS_ELEMENTOR_PATH . 'elementor/comment-kit2.php' );

	}

	/**
	 * Register Widget
	 *
	 * @since 0.1.0
	 *
	 * @access private
	 */
	private function register_widget() {
		\Elementor\Plugin::$instance->widgets_manager->register( new Weddingpress_Widget_Whatsapp() );
		\Elementor\Plugin::$instance->widgets_manager->register( new Weddingpress_Widget_Countdown_Timer() );
		\Elementor\Plugin::$instance->widgets_manager->register( new Weddingpress_Widget_Guest_Book() );
		\Elementor\Plugin::$instance->widgets_manager->register( new Weddingpress_Widget_Timeline() );
		\Elementor\Plugin::$instance->widgets_manager->register( new Weddingpress_Widget_Audio() );
		\Elementor\Plugin::$instance->widgets_manager->register( new Weddingpress_Widget_Forms() );
		\Elementor\Plugin::$instance->widgets_manager->register( new Weddingpress_Widget_Wellcome() );
		\Elementor\Plugin::$instance->widgets_manager->register( new Weddingpress_Widget_Generatorkit() );
		\Elementor\Plugin::$instance->widgets_manager->register( new Weddingpress_Widget_Copy() );
		\Elementor\Plugin::$instance->widgets_manager->register( new Weddingpress_Widget_Senderkit() );
		\Elementor\Plugin::$instance->widgets_manager->register( new Weddingpress_Widget_Modal_Popup() );
		\Elementor\Plugin::$instance->widgets_manager->register( new Weddingpress_Widget_Comment_Kit() );
		\Elementor\Plugin::$instance->widgets_manager->register( new Weddingpress_Widget_Comment_Kit2() );
		\Elementor\Plugin::$instance->widgets_manager->register( new Weddingpress_Widget_Qrcode() );
		\Elementor\Plugin::$instance->widgets_manager->register( new WeddingPress_Widget_QR_Checkin() );
		if ( function_exists( 'WC' ) ) {
		\Elementor\Plugin::$instance->widgets_manager->register( new Weddingpress_Widget_WC_Order() );
		}
		\Elementor\Plugin::$instance->widgets_manager->register( new Weddingpress_Widget_Date_Kit() );
		\Elementor\Plugin::$instance->widgets_manager->register( new Weddingpress_Widget_Date_Kit2() );
		\Elementor\Plugin::$instance->widgets_manager->register( new Weddingpress_Widget_FullScreen() );
		\Elementor\Plugin::$instance->widgets_manager->register( new Weddingpress_Widget_Kirim_Kit() );

	}
	
}

new WDP_Elementor();

