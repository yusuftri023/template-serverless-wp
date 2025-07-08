<?php
/**
 * Responsible for setting up constants, classes and templates.
 *
 * @author  IdeaBox
 * @package Elementor Widget Manager/Loader
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ADDONS_WIDGET_WEDDINGPRESS_URL', trailingslashit( plugin_dir_url(__FILE__)));
define( 'ADDONS_WIDGET_WEDDINGPRESS_PATH', trailingslashit( plugin_dir_url(__FILE__)));

/**
 * All function loads from this class Widget_Manager_Loader.
 */
class  Widget_Manager_Loader {
	/**
	 * For automatically loading action and filters.
	 */
	public function __construct() {

		// Enqueue style and script.
		add_action( 'admin_enqueue_scripts', array( $this, 'register_script' ), 999 );

		// Action to register setting for get_option function.
		add_action( 'init', array( $this, 'register_plugin_settings' ) );

		// Adding widget manager option to elementor.
		add_action( 'admin_menu', array( $this, 'register_widget_manager_menu' ), 700 );
	}

	/**
	 * For registering script and stylesheet.
	 *
	 * @param string $hook To check if the current page.
	 * @return void
	 */
	public function register_script( $hook ) {

		// Register setting for this page only.
		if ( 'weddingpress_page_widget-manager' === $hook ) {
			wp_enqueue_style( 'ewm-style', ADDONS_WIDGET_WEDDINGPRESS_URL . 'build/admin.css', array( 'wp-components' ), WEDDINGPRESS_ELEMENTOR_VERSION, false );
			wp_enqueue_script( 'ewm-script', ADDONS_WIDGET_WEDDINGPRESS_URL . 'build/admin.js', array( 'wp-components', 'wp-element', 'wp-api', 'wp-i18n' ), WEDDINGPRESS_ELEMENTOR_VERSION, true );

			// Calling elementor widget manager class with its public variable.
			wp_localize_script( 'ewm-script', 'ewm_widgets', Elementor_Widget_Manager::instance()->get_registered_widgets() );
		}
	}


	/**
	 * Registering widget manager.
	 *
	 * @return void
	 */
	public function register_widget_manager_menu() {
		// Adding sub-menu to elementor.
		add_submenu_page(
			'weddingpress', // Parent slug.
			__( 'Widget Manager', 'el-widget-manager' ), // Page title.
			__( 'Widget Manager', 'el-widget-manager' ), // Menu title.
			'manage_options', // Capability.
			'widget-manager', // Menu slug.
			array( $this, 'render_widget_manager_page' ) // Callback function.
		);
	}

	/**
	 * Includes widget manager page from react.
	 *
	 * @return void
	 */
	public function render_widget_manager_page() {
		echo "<div id='ewm-setting-root'></div>";
	}

	/**
	 * Registering widget settings in rest-api.
	 *
	 * @return void
	 */
	public function register_plugin_settings() {
		register_setting(
			'ewm-settings-group',
			'ewm_widget',
			array(
				'show_in_rest' => array(
					'schema' => array(
						'type'  => 'array',
						'items' => array(
							'type' => 'string',
						),
					),
				),
				'default'      => array(),
			)
		);
	}
}


$widget_manager_loader = new Widget_Manager_Loader();
