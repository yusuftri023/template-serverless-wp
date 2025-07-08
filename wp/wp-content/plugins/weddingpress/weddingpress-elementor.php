<?php
/**
 * Plugin Name: WeddingPress
 * Plugin URI: https://weddingpress.net
 * Description: Plugin Elementor Templates for Wedding by WeddingPress.
 * Version: 3.2.1.1
 * Author: WeddingPress
 * Author URI: https://weddingpress.net
 *
 *
 *
 * * WeddingPress incorporates codes from:
 * - Elementor Widget Manager (c) IdeaBox, license: GPL v2, https://github.com/helloideabox/elementor-widget-manager
 * - Countdown Timer for Elementor (c) FlickDevs, license: GPL v2, https://wordpress.org/plugins/countdown-timer-for-elementor/
 * - Cool Timeline Addon For Elementor Page Builder (c) Cool Plugins, license: GPL v2, https://wordpress.org/plugins/cool-timeline-addon-for-elementor/
 * - Unlimited Elementor Inner Sections By BoomDevs, Copyright (c) BoomDevs, license: GPL v2, https://wordpress.org/plugins/unlimited-elementor-inner-sections-by-boomdevs
 * - LandingPress, Copyright (c) LandingPress, license: GPL v3, https://www.landingpress.net/
 * - Dynamic Content for Elementor (c) Dynamic.ooo, license: GPL v3, https://www.dynamic.ooo/
 * - Exclusive Addons Elementor (c) DevsCred.com, license: GPL v3, https://exclusiveaddons.com/
 * - CommentPress (c) Max López, license: GPL v2
 * - PowerPack, Copyright (c) Team IdeaBox - PowerPack Elements, license: GPL v3, http://powerpackelements.com
 * 
 */

use WeddingPress\Elementor\Wdp_Sticky;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( !defined( 'WEDDINGPRESS_ELEMENTOR_NAME' ) ) {
	define( 'WEDDINGPRESS_ELEMENTOR_NAME', 'WeddingPress V3' );
}
if ( !defined( 'WEDDINGPRESS_ELEMENTOR_STORE' ) ) {
	define( 'WEDDINGPRESS_ELEMENTOR_STORE', 'https://akses.weddingpress.net/' );
}
if ( !defined( 'WEDDINGPRESS_ELEMENTOR_URL_FILE' ) ) {
	define( 'WEDDINGPRESS_ELEMENTOR_URL_FILE', plugins_url( '/', __FILE__ ) );
}
if ( !defined( 'WEDDINGPRESS_ELEMENTOR_PATH' ) ) {
	define( 'WEDDINGPRESS_ELEMENTOR_PATH', plugin_dir_path( __FILE__ ) );
}
if ( !defined( 'WEDDINGPRESS_ELEMENTOR_DIRECTORY' ) ) {
	define( 'WEDDINGPRESS_ELEMENTOR_DIRECTORY', plugin_dir_path( __FILE__ ) );
}
if ( !defined( 'WEDDINGPRESS_ELEMENTOR_WEB' ) ) {
	define( 'WEDDINGPRESS_ELEMENTOR_WEB', plugin_dir_url( __FILE__ ) );
}
if ( !defined( 'WEDDINGPRESS_ELEMENTOR_URL' ) ) {
	define( 'WEDDINGPRESS_ELEMENTOR_URL', plugin_dir_url( __FILE__ ) );
}
if ( !defined( 'WEDDINGPRESS_ELEMENTOR_VERSION' ) ) {
	define( 'WEDDINGPRESS_ELEMENTOR_VERSION', '3.2.1.1' );
}
if ( !defined( 'WEDDINGPRESS_ELEMENTOR_PLUGIN' ) ) {
	define( 'WEDDINGPRESS_ELEMENTOR_PLUGIN', true );
}
define('WEDDINGPRESS_ELEMENTOR_SLUG', 'weddingpress');


if( !class_exists( 'WeddingPress_Updater' ) ) {
	include( dirname( __FILE__ ) . '/plugin-updater.php' );
}

require WEDDINGPRESS_ELEMENTOR_PATH . 'class.php';

/**
 * Check if Elementor is installed
 *
 * @since 1.0
 *
 */
if ( ! function_exists( '_is_elementor_installed' ) ) {
    function _is_elementor_installed() {
        $file_path = 'elementor/elementor.php';
        $installed_plugins = get_plugins();
        return isset( $installed_plugins[ $file_path ] );
    }
}


function wdp_init() {
    // Notice if the Elementor is not active
    if ( ! did_action( 'elementor/loaded' ) ) {
        add_action( 'admin_notices', 'wdp_fail_load' );
        return;
    }
}

add_action('plugins_loaded', 'wdp_check_elkit'); function wdp_check_elkit() { if(defined('ELKIT_VERSION')) : add_action('admin_notices', 'cek_elkit_is_active'); function cek_elkit_is_active() {
        ?><div class='notice notice-error'>
        <p><b><?php _e('ELKIT V2 Aktif!', 'wdp'); ?></b></p>
        <p>Gunakan salah satu plugin WeddingPress atau Elkit supaya tidak memperberat loading Elementor. <b>Silakan Deactivate plugin WeddingPress.</b></p>
        </div><?php } else : if ( check_is_active() ) : if ( did_action( 'elementor/loaded' ) ) { require WEDDINGPRESS_ELEMENTOR_PATH . '/base.php'; \WDP\Elementor\Base::instance(); require WEDDINGPRESS_ELEMENTOR_PATH . '/classes/functions.php'; } endif; require_once dirname( __FILE__ ) . '/plugin.php'; if ( check_is_active() ) { if ( class_exists( 'woocommerce') && did_action( 'elementor/loaded' ) ) { require_once dirname( __FILE__ ) . '/addons/woocommerce/woocommerce-setup.php'; WDP_WooCommerce::instance(); include_once( WEDDINGPRESS_ELEMENTOR_PATH . '/elementor/woocommerce.php' );} $comment = get_option( 'comment_type' ); if ( $comment == 'commentkit' ) { include_once( WEDDINGPRESS_ELEMENTOR_PATH . '/addons/comment-kit/comment-kit.php' ); } elseif( $comment == 'commentkit2' ) { include_once( WEDDINGPRESS_ELEMENTOR_PATH . '/addons/comment-kit2/comment-kit2.php' ); } } new WeddingPressV3_Plugin(); endif; } if (did_action('elementor/loaded')) { if (check_is_active()) : include_once( WEDDINGPRESS_ELEMENTOR_PATH . '/addons/elementor-widget-manager/elementor-widget-manager.php' ); Elementor_Widget_Manager::instance(); endif; } if ( check_is_active() ) : add_action( 'init', 'updater');endif; function updater() { $license_key = trim( get_option( 'weddingpress_license' ) ); if ( ! $license_key ) { return; } if( ! is_admin() || ! class_exists( 'WeddingPress_Updater' ) ) {return; } $edd_updater = new WeddingPress_Updater( WEDDINGPRESS_ELEMENTOR_STORE, __FILE__, array( 'version' => WEDDINGPRESS_ELEMENTOR_VERSION, 'license' => $license_key, 'item_name' => WEDDINGPRESS_ELEMENTOR_NAME, 'author' => 'WeddingPress', 'beta' => false ) );}   


add_filter( 'plugin_action_links', 'wdp_add_action_plugin', 10, 5 );
function wdp_add_action_plugin( $actions, $plugin_file ) 
{
   static $plugin;
   if (!isset($plugin))
        $plugin = plugin_basename(__FILE__);
   if ($plugin == $plugin_file) {
      $settings = array('settings' => '<a href="' . admin_url( 'admin.php?page=weddingpress-license&mode=manually' ) . '" style="color:#39b54a; font-weight:500;">' . __( 'License', 'weddingpress' ) . '</a>');
      $actions = array_merge($settings, $actions);
   }
     
   return $actions;
}

function wdp_init_options() {
    $retrieved_options = get_option( 'sticky_type' );
    if (  empty($retrieved_options ) ) {
        update_option( 'sticky_type', 'show' );
    }
}
add_action( 'plugins_loaded', 'wdp_init_options' );


function autoloader() {
    require_once( dirname( __FILE__ ) . '/extensions/sticky.php');
}
spl_autoload_register('autoloader');
$sticky = get_option( 'sticky_type' ); if ( $sticky == 'show' ) {
$userwdp = new Wdp_Sticky();
}


