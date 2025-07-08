<?php
/**
 * Plugin base class
 *
 * @package WDP
 */
namespace WDP\Elementor;

use Elementor\Controls_Manager;
use Elementor\Elements_Manager;

defined( 'ABSPATH' ) || die();

class Base {

	private static $instance = null;

	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
			self::$instance->init();
		}
		return self::$instance;
	}

	public function init() {
		$this->include_files();
	}


	public function include_files() {
		include_once( WEDDINGPRESS_ELEMENTOR_PATH . 'classes/assets-manager.php' );
		if ( is_user_logged_in() ) {
			include_once( WEDDINGPRESS_ELEMENTOR_PATH . 'classes/library-manager.php' );
			include_once( WEDDINGPRESS_ELEMENTOR_PATH . 'classes/library-source.php' );
		}
	}

}
