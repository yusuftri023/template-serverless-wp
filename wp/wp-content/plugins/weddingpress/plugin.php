<?php

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

/**
 * Shows notice to user if Elementor plugin
 * is not installed or activated or both
 *
 * @since 1.0
 *
 */

function wdp_fail_load() {
    $plugin = 'elementor/elementor.php';

    if ( _is_elementor_installed() ) {
        if ( ! current_user_can( 'activate_plugins' ) ) {
            return;
        }

        $activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin );
        $message = __( 'WeddingPress mewajibkan mengaktifkan Elementor plugin. Silahkan aktifkan sekarang.', 'wdp' );
        $button_text = __( 'Klik Aktivasi Elementor', 'wdp' );

    } else {
        if ( ! current_user_can( 'install_plugins' ) ) {
            return;
        }

        $activation_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );
        $message = sprintf( __( 'WeddingPress mewajibkan menggunakan "Elementor" lakukan install dan aktivasi. Silahkan install elementor.', 'wdp' ), '<strong>', '</strong>' );
        $button_text = __( 'Install Elementor', 'wdp' );
    }

    $button = '<p><a href="' . $activation_url . '" class="button-primary">' . $button_text . '</a></p>';
    
    printf( '<div class="error"><p>%1$s</p>%2$s</div>', esc_html( $message ), $button );
}



/**
 * The admin area, activate and deactivate license, system website information source code from.
 * Credit to Agus Muhammad
 * @link       https://agusmu.com
 * @link       https://landingpress.net
 * @link       https://landingkit.co
 * @link       https://wpbisnis.com
 *
 */



class WeddingPressV3_Plugin {
	
	private $product_slug;

	private $name = 'weddingpress';

	private $url_slug;

	private $license_field_name;

	const SLUG = 'weddingpress';

	const APP_ID = '27995';

	public function __construct() {		
		if ( is_admin() ) {
		$this->product_slug       = strtolower( $this->name  );
		$this->url_slug           = $this->product_slug . '-license';
		$this->license_field_name = $this->url_slug . '-key';
		add_action( 'admin_menu', array( $this, 'menu_settings' ), 99 );
		add_action( 'admin_menu', array( $this, 'license_settings' ), 99 );
		add_action( 'admin_init', array( $this, 'setup_sections' ) );
		add_action( 'admin_init', array( $this, 'setup_fields' ) );
		add_action( 'admin_init', array( $this, 'register_option' ) );
		add_action( 'admin_init', array( $this, 'license_action' ), 20 );
		add_action( 'add_option_'.wdp_connect_key() . '_connect_site_key', array( $this, 'activate_license' ), 20, 2 );
		add_action( 'update_option_'.wdp_connect_key() . '_connect_site_key', array( $this, 'activate_license' ), 20, 2 );
		}
		add_action( 'admin_notices', array( $this, 'show_invalid_license_notice' ) );
		add_action( 'wp_ajax_guestbook_box_submit', [$this, 'guestbook_box_submit'] );
		add_action( 'wp_ajax_nopriv_guestbook_box_submit', [$this, 'guestbook_box_submit'] );
		add_action( 'admin_footer', [ $this, 'output' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_assets' ] );
		add_action( 'admin_init', [ $this, 'activation_process' ]);
		add_action(	'admin_init', [ $this, 'deactivation_process' ]);
		add_action( 'admin_enqueue_scripts', array( $this, 'common_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'common_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'load_meta_data' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'load_meta_data' ) );
		add_action( 'wp_ajax_wdp_oauth_check', array( $this, 'wdp_oauth_check' ) );
	}

	/**
	 * wdp oauth check
	 *
	 * @return array
	 */
	public function wdp_oauth_check() {

		$license_key = $_POST[ 'license_key' ];
		try {

			$params = array(
				'edd_action' => 'check_license',
				'license'    => $license_key,
				'item_id'  	 => self::APP_ID, 
				'url'        => home_url()
			);

			$is_authorize_response = wp_remote_post(
				WEDDINGPRESS_ELEMENTOR_STORE,
				array( 'timeout' => 15, 'sslverify' => false, 'body' => $params )
			);
			
			if ( ! is_wp_error( $is_authorize_response ) ) {
				$is_authorize_response_body = wp_remote_retrieve_body( $is_authorize_response );
				$is_authorize = json_decode( $is_authorize_response_body );
				return wp_send_json( $is_authorize );
			}
		} catch ( \Throwable $th ) {
			return wp_send_json_error( __('Something went wrong!', 'weddingpress'), 400 );
		}
	}

	/**
	 * Load common scripts for frontend and backend
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function common_scripts() {
		wp_enqueue_script( 'wdp-script', WEDDINGPRESS_ELEMENTOR_URL . 'assets/js/license.min.js', array( 'jquery', 'wp-i18n', 'wp-element' ), WEDDINGPRESS_ELEMENTOR_VERSION, true );
		wp_enqueue_style( 'wdp-icon', WEDDINGPRESS_ELEMENTOR_URL . 'assets/css/new-icon.min.css', array(), WEDDINGPRESS_ELEMENTOR_VERSION );
	}

	/**
	 * Load meta data
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function load_meta_data() {
		// Localize scripts.
		$localize_data = apply_filters( 'wdp_localize_data', $this->get_default_localized_data() );
		wp_localize_script( 'wdp-frontend', '_wdpobject', $localize_data );
		wp_localize_script( 'wdp-admin', '_wdpobject', $localize_data );
		wp_localize_script( 'wdp-script', '_wdpobject', $localize_data );

	}

	/**
	 * Load default localized data
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function get_default_localized_data() {
		$home_url = get_home_url();
		$parsed   = parse_url( $home_url );
		$current_user = array();
		$userdata     = get_userdata( get_current_user_id() );

		return array(
			'ajaxurl'                      => admin_url( 'admin-ajax.php' ),
			'home_url'                     => rtrim( get_home_url(), '/' ),
			'site_url'                     => rtrim( get_site_url(), '/' ),
			'site_title'                   => get_bloginfo( 'title' ),
			'code_nonce'                   => wp_create_nonce('activate-license'),
			'member_area'				   => WEDDINGPRESS_ELEMENTOR_STORE,
			'nonce_key'                    => '_wdp_nonce',
			'_wdp_nonce'                   => wp_create_nonce( 'wdp_nonce_action' ),
			'is_admin'                     => is_admin(),
		);

	}

	/**
	 * License Form
	 *
	 * @return void
	 */
	public function license_form() {
		$license_key = $this->get_license_key();
		$this->check_license();
		$is_manual_mode = ( isset( $_GET['mode'] ) && 'manually' === $_GET['mode'] );

		if ( $is_manual_mode ) {
			$this->render_manually_activation_widget( $license_key );
			return;
		}

		$status = get_option( wdp_connect_key() . '_license_key_status', false );
		
		$license_status = get_option(wdp_connect_key() . '_connect_site_data');

		include __DIR__ . '/classes/license-form.php';
	}

	public function wdp_check_license_and_redirect() {
		if (isset($_GET['page']) && $_GET['page'] === 'weddingpress-license' && isset($_GET['mode']) && $_GET['mode'] === 'manually') {
			if($this->is_active()) {
				$redirect_url = admin_url('admin.php?page=weddingpress-license');
				wp_redirect($redirect_url);
				exit;
			}
		}
	}

	public function activation_url($callback_url = ''){
		if (empty($callback_url)) {
			$callback_url = admin_url('admin.php?page=weddingpress-license');
		}

		$url = WEDDINGPRESS_ELEMENTOR_STORE . '/connect/v1/activate/';
		$url = add_query_arg('app_id', rawurlencode(self::APP_ID), $url);
		$url = add_query_arg('app_callback', rawurlencode($callback_url), $url);
		$url = add_query_arg('app_license_key', '', $url);
		$url = add_query_arg('app_nonce', wp_create_nonce('activate-license'), $url);
		$url = add_query_arg('app_page', 'weddingpress-license', $url);

		return $url;
	}

	public function deactivate_url(){
		$url = admin_url('admin.php?page=weddingpress-license');
		$url = add_query_arg('action', 'deactivate_license', $url);
		$url = add_query_arg('nonce', wp_create_nonce('deactivate-license'), $url);
		return $url;
	}

	public function license_expiration_date(){
		$data = get_option(wdp_connect_key() . '_connect_site_data');
		if (!empty($data->expires) && $data->expires !== 'lifetime') {
			return $data->expires;
		}

		return '';
	}

	public function renew_url() {
		$license_key = $this->get_license_key();
		if (empty($license_key)) {
			return '';
		}

		$license_status = get_option(wdp_connect_key() . '_connect_site_data');

		$admin_phone = '6281349405080';
		$wa_number = preg_replace('/[^0-9]/', '', $admin_phone);

		$email  = isset($license_status->customer_email) ? $license_status->customer_email : '';
		$expiry = isset($license_status->expires) ? $license_status->expires : '';
		$site   = get_home_url();

		// WhatsApp message with line breaks
		$message = "Hai Admin, tolong bantu renewal WeddingPress" . "\n\n" .
				"Lisensi WDP: {$license_key}" . "\n\n" .
				"Email: {$email}" . "\n\n" .
				"Web: {$site}" . "\n\n" .
				"Masa aktifnya hingga {$expiry}" . "\n\n" .
				"Terima kasih";

		$link = 'https://api.whatsapp.com/send?phone='.$wa_number;
		$link .= '&text='.rawurlencode($message);


		return $link;
	}

	public function activation_process(){
		if (!isset($_GET['app_activation_success'])) {
			return;
		}

		if (!isset($_GET['app_license_key'])) {
			return;
		}

		if (!isset($_GET['app_page'])) {
			return;
		}

		if (!isset($_GET['app_nonce']) || !wp_verify_nonce($_GET['app_nonce'], 'activate-license')) {
			return;
		}

		$license_key = sanitize_text_field($_GET['app_license_key']);
	
		if (empty($license_key)) {
			return;
		}

		$api_url = WEDDINGPRESS_ELEMENTOR_STORE;
		$api_url = add_query_arg('edd_action', 'check_license', $api_url);
		$api_url = add_query_arg('license', $license_key, $api_url);
		$api_url = add_query_arg('item_name', rawurlencode(WEDDINGPRESS_ELEMENTOR_NAME), $api_url);
		$api_url = add_query_arg('url', home_url(), $api_url);

		$response = wp_remote_get($api_url);
		if (!is_wp_error($response)) {
			$data = json_decode($response['body']);
			if (isset($data->success) && $data->success) {
				if (!empty($data->license) && $data->license === 'valid') {
					update_option( wdp_connect_key() . '_connect_site_key', $license_key);
					update_option( wdp_connect_key() . '_connect_site_data', $data);
				}
			}
		}

		$current_url = remove_query_arg(
			array('app_license_key', 'app_nonce', 'app_activation_success', 'app_page'),
			add_query_arg(array())
		);

		wp_redirect($current_url);
		exit;
	}

	public function deactivation_process(){
		if (!isset($_GET['action']) || $_GET['action'] !== 'deactivate_license') {
			return;
		}

		if (!isset($_GET['nonce']) || !wp_verify_nonce($_GET['nonce'], 'deactivate-license')) {
			wp_die('Invalid security token');
		}

		if (!current_user_can('manage_options')) {
			wp_die('You do not have permission to perform this action');
		}

		$license_key = $this->get_license_key();

		$api_url = WEDDINGPRESS_ELEMENTOR_STORE;
		$api_url = add_query_arg('edd_action', 'deactivate_license', $api_url);
		$api_url = add_query_arg('license', $license_key, $api_url);
		$api_url = add_query_arg('item_name', urlencode(WEDDINGPRESS_ELEMENTOR_NAME), $api_url);
		$api_url = add_query_arg('url', home_url(), $api_url);

		$response = wp_remote_get($api_url);

		$error = '';
		if ( is_wp_error( $response ) ) {
			$error = $response->get_error_message();
		}
		elseif ( 200 !== wp_remote_retrieve_response_code( $response ) ) {
			$code = wp_remote_retrieve_response_code( $response );
			$message = wp_remote_retrieve_response_message( $response );
			if ( empty( $message ) ) {
				$message = __( 'An error occurred, please try again.', 'weddingpress' );
			}
			$error = $message.' (CODE '.$code.')';
		}
		else {
			$license_data = json_decode( wp_remote_retrieve_body( $response ) );
			if ( $license_data && ( $license_data->license == 'deactivated' ) ) {
				delete_option(wdp_connect_key() . '_connect_site_key');
				delete_option(wdp_connect_key() . '_connect_site_data');
				delete_option(wdp_connect_key() . '_connect_key_status');
			}
			else {
				$error = __( 'An error occurred, please try again.', 'weddingpress' );
			}
		}
		if ( ! empty( $error ) ) {
			if ( strpos( $error, 'resolve host' ) !== false ) {
				$error = esc_html__( 'Tidak dapat terhubung ke server lisensi WeddingPress!', 'weddingpress' );
			}
			$error = __( 'License deactivation failed!', 'weddingpress' ).' '.$error;
			$base_url = admin_url( 'admin.php?page=weddingpress-license' );
			$redirect = add_query_arg( array( wdp_connect_key() . '_connect_site_key' => 'false', 'license_error' => urlencode( $error ) ), $base_url );
			wp_redirect( $redirect );
			exit();
		}
		wp_redirect( admin_url( 'admin.php?page=weddingpress-license' ) );
		exit();
	}

	/**
	 * Enqueue admin area scripts and styles.
	 *
	 * @since 1.0.0
	 * @since 1.5.0 Added new assets for new pages.
	 * @since 1.7.0 Added jQuery Confirm library css/js files.
	 *
	 * @param string $hook Current hook.
	 */
	public function enqueue_assets( $hook ) {

		wp_enqueue_style( 'wdp-pro-admin', WEDDINGPRESS_ELEMENTOR_URL . 'assets/css/admin-license.css', array(), WEDDINGPRESS_ELEMENTOR_VERSION );
		wp_enqueue_script( 'wdp-pro-admin', WEDDINGPRESS_ELEMENTOR_URL . 'assets/js/admin-license.js', array( 'jquery' ), WEDDINGPRESS_ELEMENTOR_VERSION, true );

		wp_localize_script(
			'wdp-front',
			'_wdpobject',
			array(
				'ajaxurl'      => admin_url( 'admin-ajax.php' ),
			)
		);

		if ( strpos( $hook, self::SLUG ) === false ) {
			return;
		}

		// Set general body class.
		add_filter(
			'admin_body_class',
			function ( $classes ) {
				$classes .= ' wdp-elementor-admin-page-body';
				$classes .= ' wdp-elementor-lite';
				return $classes;
			}
		);

		// General styles and js.
		wp_enqueue_style(
			'wdp-elementor-admin',
			WEDDINGPRESS_ELEMENTOR_URL . 'assets/css/support.css',
			false,
			WEDDINGPRESS_ELEMENTOR_VERSION
		);

		wp_enqueue_script(
			'wdp-elementor-admin',
			WEDDINGPRESS_ELEMENTOR_URL . 'assets/js/support.js',
			[ 'jquery', 'underscore' ],
			WEDDINGPRESS_ELEMENTOR_VERSION,
			false
		);

	}

	/**
	 * Output menu.
	 *
	 * @since 3.0.0
	 */
	public function output() {

		$screen = get_current_screen();
		$screen_id = isset($screen->id) ? $screen->id : '';
			if ( !in_array( $screen_id, array( 
				'toplevel_page_weddingpress',
				'weddingpress_page_commentkit-settings',
				'weddingpress_page_weddingpress-license',
				'weddingpress_page_commentkit2',
				'weddingpress_page_wdp_wc_settings',
				'weddingpress_page_widget-manager',
			) ) ) {
			return;
		}

		printf(
			'<div id="wdp-elementor-flyout">
				<div id="wdp-elementor-flyout-items">%1$s</div>
				<a href="#" class="wdp-elementor-flyout-button wdp-elementor-flyout-head">
					<div class="wdp-elementor-flyout-label">%2$s</div>
					<figure><img src="%3$s" alt="%2$s"/></figure>
				</a>
			</div>',
			$this->get_items_html(),
			esc_html__( 'Info Link Penting', 'wdp-elementor' ),
			esc_url( WEDDINGPRESS_ELEMENTOR_URL . 'assets/images/wdp-icon.png' )
		);
	}

	/**
	 * Generate menu items HTML.
	 *
	 * @since 3.0.0
	 *
	 * @return string Menu items HTML.
	 */
	private function get_items_html() {

		$items      = array_reverse( $this->menu_items() );
		$items_html = '';

		foreach ( $items as $item_key => $item ) {
			$items_html .= sprintf(
				'<a href="%1$s" target="_blank" rel="noopener noreferrer" class="wdp-elementor-flyout-button wdp-elementor-flyout-item wdp-elementor-flyout-item-%2$d"%5$s%6$s>
					<div class="wdp-elementor-flyout-label">%3$s</div>
					<img src="%4$s" alt="%3$s">
				</a>',
				esc_url( $item['url'] ),
				(int) $item_key,
				esc_html( $item['title'] ),
				esc_url( $item['icon'] ),
				! empty( $item['bgcolor'] ) ? ' style="background-color: ' . esc_attr( $item['bgcolor'] ) . '"' : '',
				! empty( $item['hover_bgcolor'] ) ? ' onMouseOver="this.style.backgroundColor=\'' . esc_attr( $item['hover_bgcolor'] ) . '\'" onMouseOut="this.style.backgroundColor=\'' . esc_attr( $item['bgcolor'] ) . '\'"' : ''
			);
		}

		return $items_html;
	}

	/**
	 * Menu items data.
	 *
	 * @since 3.0.0
	 *
	 * @return array Menu items data.
	 */
	private function menu_items() {

		$icons_url = WEDDINGPRESS_ELEMENTOR_URL . '/assets/images/flyout-menu';

		$items = [
			[
				'title'         => esc_html__( 'Official Channel', 'wdp-elementor' ),
				'url'           => 'https://t.me/weddingpressnet',
				'icon'          => $icons_url . '/star.svg',
				'bgcolor'       => '#c89556',
				'hover_bgcolor' => '#c89556',
			],
			[
				'title' => esc_html__( 'Support & Docs', 'wdp-elementor' ),
				'url'   => 'https://weddingpress.id',
				'icon'  => $icons_url . '/life-ring.svg',
			],
			[
				'title' => esc_html__( 'Promo Terbaru', 'wdp-elementor' ),
				'url'   => 'https://weddingpress.co.id/promo',
				'icon'  => $icons_url . '/facebook.svg',
			],
			[
				'title' => esc_html__( 'Changelog Update', 'wdp-elementor' ),
				'url'   => 'https://weddingpress.id/changelog/',
				'icon'  => $icons_url . '/lightbulb.svg',
			],
		];

		return $items;
	}

	public function is_active() {
		$data = get_option(wdp_connect_key() . '_connect_site_data');
		if (!empty($data->license) && in_array($data->license, array('valid'))) {
		  return true;
		}
		return false;
	}

	public function is_expired() {
		$data = get_option(wdp_connect_key() . '_connect_site_data');
		if (!empty($data->license) && $data->license === 'expired') {
		  return true;
		}
		if (!empty($data->license) && $data->license === 'invalid' && !empty($data->error) && $data->error === 'expired') {
		  return true;
		}
		return false;
	}
	
	public function menu_settings() {
		add_menu_page(
            'WeddingPress',
            'WeddingPress',
            'manage_options',
            'weddingpress',
            array( $this, 'settings_content' ),
            plugins_url( 'weddingpress/assets/img/icon.png' ),
            '3'
        );

	}

	public function license_settings() {
		add_submenu_page(
			'weddingpress',
            'WeddingPress License',
            'License',
            'manage_options',
            'weddingpress-license',
            array( $this, 'license_form' ),
        );
	}

	private function render_manually_activation_widget( $license_key ) {

		$license = trim( wdp_connect_key() . '_connect_site_key' );

		if ( ! $license ) {
			$license_error = 'Silakan masukkan kode lisensi Anda.';
		} 
		else {
			$license_error = $this->check_license();
		}

		$status = get_option( wdp_connect_key() . '_connect_key_status', false );
		if ( empty( $status ) ) {
			$status = 'unknown';
		}

		$license_data = get_option( wdp_connect_key() . '_connect_site_data');
		$license_error = get_option( wdp_connect_key() . '_connect_key_error' );
		if ( isset( $_GET['wdp_license'] ) && $_GET['wdp_license'] == 'false' && isset( $_GET['license_error'] ) && ! empty( $_GET['license_error'] ) ) {
			$license_error = urldecode( stripslashes( $_GET['license_error'] ) );
		}
		?>
		<div class="wrap elementor-admin-page-license">
			<h2><?php _e( 'WeddingPress License', 'weddingpress' ); ?></h2>
			<form method="post" action="options.php" class="elementor-license-box">
				<?php settings_fields( wdp_connect_key() . '_connect_site_key' ); ?>
				<?php wp_nonce_field( WEDDINGPRESS_ELEMENTOR_SLUG . '_nonce', WEDDINGPRESS_ELEMENTOR_SLUG . '_nonce' ); ?>
				<?php if ( empty( $license ) || ( ! empty( $license ) && in_array( $status, array( 'item_name_mismatch', 'invalid_item_id', 'missing', 'invalid' ) ) ) ) : ?>
				<div class="weddingpress-activation-box">
					<h3>
						<?php _e( 'Aktivasi Lisensi', 'weddingpress' ); ?>
							<small>
								<a style="text-decoration: none;" href="https://weddingpress.net/member-area/" target="_blank" class="elementor-connect-link">
									<?php _e( 'Member Area', 'weddingpress' ); ?>
								</a>
							</small>
					</h3>
	                    <p><?php _e( 'Masukkan kode lisensi, untuk mengaktifkan <strong>WeddingPress</strong>, untuk auto update, premium support dan akses WeddingPress template library.' ); ?></p>
	                    <ol>
	                        <li><?php printf( __( 'Masuk <a href="%s" target="_blank">Member Area</a> untuk mendapatkan kode lisensi.' ), 'https://weddingpress.net/member-area/' ); ?></li>
	                        <li><?php _e( __( 'Copy kode lisensi di bawah ini.' ) ); ?></li>
	                        <li><?php _e( __( 'Klik tombol <strong>"Activate License"</strong>.' ) ); ?></li>
	                    </ol>
					<label for="weddingpress-license-key"><?php _e( 'Kode Lisensi', 'weddingpress' ); ?></label>
					<?php if ( $license ) : ?>
						<p>
							License: <strong><span style="color: #091c73;"><?php echo $this->get_hidden_license( $license ); ?></span></strong>
						</p>
					<?php endif; ?>

					<?php if ( ! empty( $license ) &&  ( $license_error ) ) : ?>
						<p>
							Status: <span style="color: #ff0000; font-style: italic;"><?php echo esc_html( $license_error ); ?></span>
						</p>
					<?php endif; ?>

					<input id="<?php echo wdp_connect_key(); ?>_connect_site_key" name="<?php echo wdp_connect_key(); ?>_connect_site_key" type="text" class="regular-text code" value="" placeholder="<?php esc_attr_e( 'masukkan kode lisensi di sini', 'weddingpress' ); ?>" />

					<input type="submit" class="button button-primary" name="submit" value="<?php esc_attr_e( 'Activate License', 'weddingpress' ); ?>"/>	

				</div>	

				<?php else : ?>

				<div class="weddingpress-license-active">
				<div class="weddingpress-active-item">

				<?php if ( in_array( $status, array( 'valid', 'expired' ) ) ) : ?>
						<div class="">
						<i class="dashicons dashicons-thumbs-up"></i>
							<b>Terima kasih, semoga bisnis Anda sukses berkah melimpah</b>
						</div>
					
					<?php $site_count = $license_data->site_count; $license_limit = $license_data->license_limit;
						if ( 0 == $license_limit ) {
							$license_limit = '∞ Unlimited Websites';
						}
						elseif ( $license_limit > 1 ) {
							$license_limit = ''.$site_count.' / '.$license_limit.' Website';
						}
						?>
						<div class="">
								<i class="dashicons dashicons-editor-unlink"></i>
								Aktivasi Lisensi :
								<?php echo $license_limit; ?>
						</div>

						<?php if ( in_array( $status, array( 'valid', 'inactive', 'site_inactive', 'expired' ) ) ) : ?>
						<div class="">
								<i class="dashicons dashicons-clock"></i>
								Masa Aktif :
								<?php if ( isset( $license_data->expires ) && $license_data->expires ) : ?>
									<?php if ( $license_data->expires == 'lifetime' ) : ?>  
										<?php echo esc_html( strtoupper( $license_data->expires ) ); ?>
									<?php else : ?>
										<?php echo date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) ); ?>
									<?php endif; ?>
								<?php endif; ?>                   
							
						</div>

						<?php endif; ?>   
			
				<?php endif; ?>

				</div>
						</div>

						<div class="weddingpress-activation-box">
							<h3><?php _e( 'Status', 'weddingpress' ); ?>:
								<?php if ( in_array( $status, array( 'expired' ) ) ) : ?>
									<span style="color: #ff0000; font-style: italic;"><?php _e( 'Expired' ); ?></span>
								<?php elseif ( in_array( $status, array( 'inactive' ) ) ) : ?>
									<span style="color: #ff0000; font-style: italic;"><?php _e( 'Mismatch' ); ?></span>
								<?php elseif ( in_array( $status, array( 'invalid' ) ) ) : ?>
									<span style="color: #ff0000; font-style: italic;"><?php _e( 'Lisensi tidak valid' ); ?></span>
								<?php elseif ( in_array( $status, array( 'disabled' ) ) ) : ?>
									<span style="color: #ff0000; font-style: italic;"><?php _e( 'Disabled' ); ?></span>
								<?php elseif ( in_array( $status, array( 'valid' ) ) ) : ?>
									<span style="color: #008000; font-style: italic;"><?php _e( 'Active' ); ?></span>
								<?php elseif ( in_array( $status, array( 'unknown' ) ) ) : ?>
									<span style="color: #ff0000; font-style: italic;"><?php _e( 'Pastikan cURL website Anda aktif dan tidak blockir ip server WeddingPress' ); ?></span>
								<?php elseif ( in_array( $status, array( 'site_inactive' ) ) ) : ?>
									<span style="color: #ff0000; font-style: italic;"><?php _e( 'Lisensi Anda sedang tidak aktif di website ini' ); ?></span>
								<?php endif; ?>

								<small>
									<?php printf( __( '<a role="button" class="button button-primary" href="https://weddingpress.net/member-area/" target="_blank">Member Area</a>' ) ); ?>
								</small>
							</h3>

						<?php if ( in_array( $status, array( 'inactive', 'site_inactive', 'unknown' ) ) ) : ?>
							<p class="e-row-stretch e-row-divider-bottom">
								<span>
								<?php echo __( 'Aktifkan website ini dengan kode lisensi lain?', 'weddingpress' ); ?>
								</span>
								<input type="submit" class="button button-secondary" name="weddingpress_license_change" value="Change License"/>
							</p>
							<p class="e-row-stretch">
							<span><?php echo __( 'Aktifkan kode lisensi', 'weddingpress' ); ?></span>
							<input type="submit" class="button button-primary" name="weddingpress_license_activate" value="<?php esc_attr_e( 'Activate License', 'weddingpress' ); ?>"/>	
							</p>
						<?php elseif ( in_array( $status, array( 'valid' ) ) ) : ?>		
							<p class="e-row-stretch">
								<span><?php echo __( 'Nonaktifkan kode lisensi?', 'weddingpress' ); ?></span>
								<input type="submit" class="button button-secondary" name="weddingpress_license_deactivate" value="Deactivate License"/>
							</p>
						<?php endif; ?>	
							
						</div>
						</div>

						<?php endif; ?>
					</form>
				<?php
	
	}

	public function settings_content() {
		$license_key = $this->get_license_key();
		$is_manual_mode = ( isset( $_GET['mode'] ) && 'manually' === $_GET['mode'] );

		if ( $is_manual_mode ) {
			$this->render_manually_activation_widget( $license_key );
			return;
		}

		echo '<div class="wrap">'; 
		echo '<h2>'.esc_html__( 'WeddingPress', 'weddingpress' ).'</h2>';
		echo '<div class="wdp-elementor-form" style="max-width: 630px; background: #fff; margin: 20px 0; padding: 20px;">';
		echo '<form method="POST" action="options.php">';
			settings_fields( 'wdp_elementor' );
			do_settings_sections( 'wdp_elementor' );
			submit_button();
		echo '</form>';
		echo '</div>';
		echo '</div>';
	}

	public function setup_sections() {
		add_settings_section( 'weddingpress_elementor_status', esc_html__( 'Setting', 'weddingpress' ), array(), 'wdp_elementor' );
		
	}
	
	public function license_field() {
		$license = $this->get_license_key();
		$license_status = get_option(wdp_connect_key() . '_connect_site_data');
		?>
		<?php if ($this->is_active()) : ?>
			<?php 
			$expires = '';
			if ( isset( $license_status->expires ) && 'lifetime' != $license_status->expires ) {
				$expires = ', hingga '.date_i18n( get_option( 'date_format' ), strtotime( $license_status->expires, current_time( 'timestamp' ) ) );
			} 
			elseif ( isset( $license_status->expires ) && 'lifetime' == $license_status->expires ) {
				$expires = ', Lisensi Lifetime';
			}
			$site_count = $license_status->site_count;
			$license_limit = $license_status->license_limit;
			if ( 0 == $license_limit ) {
				$license_limit = ', unlimited';
			}
			elseif ( $license_limit > 1 ) {
				$license_limit = ', Anda sudah mengaktifkan lisensi ini untuk '.$site_count.' website dari limit '.$license_limit.' website yang tersedia.';
			}
			if ( $license_status->license == 'expired' ) {
				$renew_link = '<br/><a href="https://weddingpress.co.id/renewal/" target="_blank">klik di sini untuk perpanjang lisensi</a>';
			}
			?>
			<?php if ( $this->is_active() ) : ?>
				<span class="description wdp-elementor-yes">
					<br/>
					<?php echo '<strong>Status:</strong> ✓&nbsp;Kode lisensi&nbsp;'.$license_status->license.$expires; ?>
					<br/>
					<?php echo '<strong>Email anda:</strong> &nbsp;'.$license_status->customer_email; ?>
				</span>
				
				<p class="wdp-elementor-active"><br><a href="<?php echo esc_url($this->deactivate_url());?>" onclick="return confirm(\'Apakah kamu yakin mengahapus lisensi di web ini?? Lisensi akan dihapus.\')" class="button button-error">Deactivate License</a>&nbsp;<a class="button button-primary" href="https://akses.weddingpress.net/member-area/" target="_blank">My Account</a>&nbsp;<a class="button button-secondary" href="https://weddingpress.net/support" target="_blank">Support</a>&nbsp;<a class="button button-secondary" href="https://weddingpress.net/panduan" target="_blank">Tutorial</a>
			<?php elseif ( $this->is_expired() ) : ?>
				<span class="description wdp-elementor-error">
					<br/>
					<?php echo '<strong>'.$license_status->license.'</strong>'.$expires.$license_limit; ?>
				</span>
				<?php echo $renew_link; ?>
			<?php elseif ( $license_status->license == 'no_activations_left' ) : ?>
				<span class="description wdp-elementor-error">
					<br/>
					<?php echo '<strong>lisensi habis</strong>'.$license_limit; ?>
				</span>
			<?php endif; ?>
			
		<?php else : ?>
			<?php foreach ($wdp_licenses as $wdp_license) {

				if (!empty($wdp_license['expiration_date'])) {
				echo '<span>Expires: ' . esc_html($wdp_license['expiration_date']) . '</span> ';
				}

				if (isset($wdp_license['active']) && $wdp_license['active']) {
				if (isset($wdp_license['expired']) && $wdp_license['expired']) {
					if (!empty($wdp_license['renew_url'])) {
					echo '<a href="' . esc_url($wdp_license['renew_url']) . '" class="button button-primary">Renew License</a>';
					}
					if (!empty($wdp_license['activation_url'])) {
					echo '<a href="' . esc_url($wdp_license['activation_url']) . '" class="button button-secondary">Change License</a>';
					}
					if (!empty($wdp_license['deactivate_url'])) {
					echo '<a href="' . esc_url($wdp_license['deactivate_url']) . '" onclick="return confirm(\'Apakah kamu yakin mengahapus lisensi di web ini?? Lisensi akan dihapus.\')" class="button button-error">Deactivate License</a>';
					}
				} else {
					if (!empty($wdp_license['activation_url'])) {
					echo '<a href="' . esc_url($wdp_license['activation_url']) . '" class="button button-secondary">Change License</a>';
					}
					if (!empty($wdp_license['deactivate_url'])) {
					echo '<a href="' . esc_url($wdp_license['deactivate_url']) . '" onclick="return confirm(\'Apakah kamu yakin mengahapus lisensi di web ini?? Lisensi akan dihapus.\')" class="button button-error">Deactivate License</a>';
					}
				}
				} else {
				if (!empty($wdp_license['activation_url'])) {
					echo '<a href="' . esc_url($wdp_license['activation_url']) . '" class="button button-primary">Connect & Activate License</a>';
				}
				}
			}?>
		<?php endif; ?>
		<?php 
	}

	public static function get_license_key(){
		return trim( get_option(wdp_connect_key() . '_connect_site_key') );
	}

	public static function get_hidden_license() {
		$input_string = get_option( wdp_connect_key() . '_connect_site_key' );
		$start = 6;
		$length = mb_strlen( $input_string ) - $start - 6;
		$mask_string = preg_replace( '/\S/', '*', $input_string );
		$mask_string = mb_substr( $mask_string, $start, $length );
		$input_string = substr_replace( $input_string, $mask_string, $start, $length );

		return $input_string;
	}


	/**
	 * Registers the option used to store the license key in the options table.
	 *
	 * since 1.0.0
	 */
	public function register_option() {
		register_setting(
			wdp_connect_key() . '_connect_site_key',
			wdp_connect_key() . '_connect_site_key',
			array( $this, 'sanitize_license' )
		);
	}


	/**
	 * Sanitizes the license key.
	 *
	 * since 1.0.0
	 *
	 * @param string $new License key that was submitted.
	 * @return string $new Sanitized license key.
	 */
	public function sanitize_license( $new ) {
		$old = get_option( wdp_connect_key() . '_connect_site_key' );
		if ( $old && $old != $new ) {
			// New license has been entered, so must reactivate
			delete_option( wdp_connect_key() . '_connect_key_status' );
			delete_option( wdp_connect_key() . '_connect_site_data' );
			delete_option( wdp_connect_key() . '_connect_key_error' );
		}
		return $new;
	}


	/**
	 * Makes a call to the API.
	 *
	 * @since 1.0.0
	 *
	 * @param array $api_params to be used for wp_remote_get.
	 * @return array $response decoded JSON response.
	 */
	public function get_api_response( $api_params ) {
		$response = wp_remote_post( WEDDINGPRESS_ELEMENTOR_STORE, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );
		return $response;
	}


	/**
	 * Activates the license key.
	 *
	 * @since 1.0.0
	 */
	public function activate_license() {

		if (
			!isset($_POST['_wp_http_referer']) ||
			strpos($_POST['_wp_http_referer'], '/wp-admin/admin.php?page=weddingpress-license&mode=manually') === false
		) {
			return false;
		}

		$license = trim( get_option( wdp_connect_key() . '_connect_site_key' ) );
		$api_params = array(
			'edd_action' => 'activate_license',
			'license'    => $license,
			'item_name'  => urlencode( WEDDINGPRESS_ELEMENTOR_NAME ),  
			'url'        => home_url()
		);
		$response = $this->get_api_response( $api_params );
		$error = '';
		if ( is_wp_error( $response ) ) {
			$error = $response->get_error_message();
		}
		elseif ( 200 !== wp_remote_retrieve_response_code( $response ) ) {
			$code = wp_remote_retrieve_response_code( $response );
			$message = wp_remote_retrieve_response_message( $response );
			if ( empty( $message ) ) {
				$message = __( 'An error occurred, please try again.', 'weddingpress' );
			}
			$error = $message.' (CODE '.$code.')';
		}
		else {
			$license_data = json_decode( wp_remote_retrieve_body( $response ) );
			if ( 'valid' != $license_data->license ) {
				switch( $license_data->license ) {
					case 'expired' :
						$error = sprintf(
							__( 'Kode lisensi Anda telah kadaluarsa pada %s.', 'weddingpress' ),
							date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) )
						);
						break;
					case 'revoked' :
						$error = __( 'Kode lisensi Anda telah dinonaktifkan dan tidak dapat dipergunakan lagi.', 'weddingpress' );
						break;
					case 'missing' :
						$error = __( 'Lisensi tidak valid.', 'weddingpress' );
						break;
					case 'invalid' :
						$error = __( 'Lisensi tidak valid.', 'weddingpress' );
						break;
					case 'site_inactive' :
						$error = __( 'Lisensi Anda sedang tidak aktif di website ini.', 'weddingpress' );
						break;
					case 'item_name_mismatch' :
						$error = sprintf( __( 'Kode lisensi tidak valid untuk %s, silakan ganti dengan kode lisensi yang valid.', 'weddingpress' ), WEDDINGPRESS_ELEMENTOR_NAME );
						break;
					case 'invalid_item_id' :
						$error = sprintf( __( 'Kode lisensi tidak valid untuk %s, silakan ganti dengan kode lisensi yang valid.', 'weddingpress' ), WEDDINGPRESS_ELEMENTOR_NAME );
						break;
					case 'no_activations_left':
						$error = __( 'Kode lisensi Anda telah mencapai batas limit aktivasi lisensi.', 'weddingpress' );
						break;
					default :
						$error = __( 'An error occurred, please try again.', 'weddingpress' );
						break;
				}
			}
		}
		if ( ! empty( $error ) ) {
			if ( strpos( $error, 'resolve host' ) !== false ) {
				$error = esc_html__( 'Tidak dapat terhubung ke server lisensi WeddingPress!', 'weddingpress' );
			}
			update_option( wdp_connect_key() . '_connect_key_error', $error );
		}
		else {
			delete_option( wdp_connect_key() . '_connect_key_error' );
		}
		if ( isset( $license_data ) && $license_data && isset( $license_data->license ) ) {
			update_option( wdp_connect_key() . '_connect_key_status', $license_data->license );
			update_option( wdp_connect_key() . '_connect_site_data', $license_data );
		}
		wp_redirect( admin_url( 'admin.php?page=weddingpress-license&mode=manually' ) );
		exit();
	}


	/**
	 * Deactivates the license key.
	 *
	 * @since 1.0.0
	 */
	public function deactivate_license() {
		$license = $this->get_license_key();
		$api_params = array(
			'edd_action' => 'deactivate_license',
			'license'    => $license,
			'item_name'  => urlencode( WEDDINGPRESS_ELEMENTOR_NAME ), 
			'url'        => home_url()
		);
		$response = $this->get_api_response( $api_params );
		$error = '';
		if ( is_wp_error( $response ) ) {
			$error = $response->get_error_message();
		}
		elseif ( 200 !== wp_remote_retrieve_response_code( $response ) ) {
			$code = wp_remote_retrieve_response_code( $response );
			$message = wp_remote_retrieve_response_message( $response );
			if ( empty( $message ) ) {
				$message = __( 'An error occurred, please try again.', 'weddingpres' );
			}
			$error = $message.' (CODE '.$code.')';
		}
		else {
			$license_data = json_decode( wp_remote_retrieve_body( $response ) );
			if ( $license_data && ( $license_data->license == 'deactivated' ) ) {
				delete_option( wdp_connect_key() . '_connect_site_key' );
				delete_option( wdp_connect_key() . '_connect_site_data' );
				delete_option( wdp_connect_key() . '_connect_key_error' );
			}
			else {
				$error = __( 'An error occurred, please try again.', 'weddingpres' );
			}
		}
		if ( ! empty( $error ) ) {
			if ( strpos( $error, 'resolve host' ) !== false ) {
				$error = esc_html__( 'Tidak dapat terhubung ke server lisensi WeddingPres!', 'weddingpres' );
			}
			$error = __( 'License deactivation failed!', 'weddingpres' ).' '.$error;
			$base_url = admin_url( 'admin.php?page=weddingpress-license&mode=manually' );
			$redirect = add_query_arg( array( 'wdp_license' => 'false', 'license_error' => urlencode( $error ) ), $base_url );
			wp_redirect( $redirect );
			exit();
		}
		wp_redirect( admin_url( 'admin.php?page=weddingpress-license&mode=manually' ) );
		exit();
	}


	/**
	 * Change the license key.
	 *
	 * @since 1.0.0
	 */
	public static function change_license() {

		delete_option( wdp_connect_key() . '_connect_site_key' );
		delete_option( wdp_connect_key() . '_connect_key_status' );
		delete_option( wdp_connect_key() . '_connect_site_data' );
		delete_option( wdp_connect_key() . '_connect_key_error' );

		wp_redirect( admin_url( 'admin.php?page=weddingpress&mode=manually' ) );
		exit();

	}


	/**
	 * Checks if a license action was submitted.
	 *
	 * @since 1.0.0
	 */
	public function license_action() {

		if ( isset( $_POST[ 'wdp_license_activate' ] ) ) {
			if ( check_admin_referer( WEDDINGPRESS_ELEMENTOR_SLUG . '_nonce', WEDDINGPRESS_ELEMENTOR_SLUG . '_nonce' ) ) {
				$this->activate_license();
			}
		}

		if ( isset( $_POST['wdp_license_deactivate'] ) ) {
			if ( check_admin_referer( WEDDINGPRESS_ELEMENTOR_SLUG . '_nonce', WEDDINGPRESS_ELEMENTOR_SLUG . '_nonce' ) ) {
				$this->deactivate_license();
			}
		}

		if ( isset( $_POST['wdp_license_change'] ) ) {
			if ( check_admin_referer( WEDDINGPRESS_ELEMENTOR_SLUG . '_nonce', WEDDINGPRESS_ELEMENTOR_SLUG . '_nonce' ) ) {
				$this->change_license();
			}
		}

	}


	/**
	 * Checks if license is valid and gets expire date.
	 *
	 * @since 1.0.0
	 *
	 * @return string $message License status message.
	 */
	public function check_license() {
		$license = trim( get_option( wdp_connect_key() . '_connect_site_key' ) );
		$api_url = WEDDINGPRESS_ELEMENTOR_STORE;
		$api_url = add_query_arg(array(
		  'edd_action' => 'check_license',
		  'license' => $license,
		  'item_name' => urlencode( WEDDINGPRESS_ELEMENTOR_NAME ), 
		  'url' => home_url()
		), $api_url);
	  
		$response = wp_remote_get($api_url);

		$error = '';
		if ( is_wp_error( $response ) ) {
			$error = $response->get_error_message();
		}
		elseif ( 200 !== wp_remote_retrieve_response_code( $response ) ) {
			$code = wp_remote_retrieve_response_code( $response );
			$message = wp_remote_retrieve_response_message( $response );
			if ( empty( $message ) ) {
				$message = __( 'An error occurred, please try again.', 'weddingpres' );
			}
			$error = $message.' (CODE '.$code.')';
		}
		else {
			$license_data = json_decode( wp_remote_retrieve_body( $response ) );
		
			if ( 'valid' != $license_data->license ) {
				switch( $license_data->license ) {
					case 'expired' :
						$error = sprintf(
							__( 'Kode lisensi Anda telah kadaluarsa pada %s.', 'weddingpres' ),
							date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) )
						);
						break;
					case 'revoked' :
						$error = __( 'Kode lisensi Anda telah dinonaktifkan dan tidak dapat dipergunakan lagi.', 'weddingpres' );
						break;
					case 'missing' :
						$error = __( 'Lisensi tidak valid.', 'weddingpres' );
						break;
					case 'invalid' :
						$error = __( 'Lisensi tidak valid.', 'weddingpres' );
						break;
					case 'site_inactive' :
						$error = __( 'Lisensi Anda sedang tidak aktif di website ini.', 'weddingpres' );
						break;
					case 'item_name_mismatch' :
						$error = sprintf( __( 'Kode lisensi tidak valid untuk %s, silakan ganti dengan kode lisensi yang valid.', 'weddingpres' ), WEDDINGPRESS_ELEMENTOR_NAME );
						break;
					case 'invalid_item_id' :
						$error = sprintf( __( 'Kode lisensi tidak valid untuk %s, silakan ganti dengan kode lisensi yang valid.', 'weddingpres' ), WEDDINGPRESS_ELEMENTOR_NAME );
						break;
					case 'no_activations_left':
						$error = __( 'Kode lisensi Anda telah mencapai batas limit aktivasi lisensi.', 'weddingpres' );
						break;
					default :
						$error = __( 'An error occurred, please try again.', 'weddingpres' );
						break;
				}
			}
		}
		if ( ! empty( $error ) ) {
			if ( strpos( $error, 'resolve host' ) !== false ) {
				$error = esc_html__( 'Tidak dapat terhubung ke server lisensi WeddingPres!', 'weddingpres' );
			}
			update_option( wdp_connect_key() . '_connect_key_error', $error );
		}
		else {
			delete_option( wdp_connect_key() . '_connect_key_error' );
		}
		if ( isset( $license_data ) && $license_data && isset( $license_data->license ) ) {
			update_option( wdp_connect_key() . '_connect_key_status', $license_data->license );
			update_option( wdp_connect_key() . '_connect_site_data', $license_data );
		}
		return $error;
	}
	
	public function status_field() {
		echo '<p><strong>Cek status sistem website anda, agar elementor bisa berkerja dengan optimal</strong></p>';
		echo '<p>WeddingPress Version : <span class="wdp-elementor-yes"><i class="dashicons dashicons-thumbs-up"></i>&nbsp;'.WEDDINGPRESS_ELEMENTOR_VERSION.'</span></p>';
		
		echo '<p>Elementor Version : <span class="wdp-elementor-yes"><i class="dashicons dashicons-thumbs-up"></i>&nbsp;'.ELEMENTOR_VERSION.'</span></p>';

		$phpmemory = ini_get( 'memory_limit' );
		$phpmemory_num = str_replace( 'M', '', $phpmemory );
		if ( $phpmemory_num >= 256 ) {
			echo '<p>PHP Memory Limit : <span class="wdp-elementor-yes"><i class="dashicons dashicons-thumbs-up"></i>&nbsp;'.$phpmemory.'</span></p>';
		}
		else {
			echo '<p>PHP Memory Limit : <span class="wdp-elementor-error"><i class="dashicons dashicons-warning"></i>&nbsp;'.$phpmemory.'</span></p>';
			echo '<p style="color: #7d8183;font-size: 0.9em">PHP Memory Limit minimum 64M ke atas, direkomendasikan 256M, supaya semua fitur berjalan dengan baik. <a href="https://weddingpress.net/panduan" target="_blank" style="color: #ff0000; text-decoration: none;">' . __( 'Cek disini panduannya', 'templatepress' ) . '</a></i>';
		}

		$wpmemory = WP_MEMORY_LIMIT;
		$wpmemory_num = str_replace( 'M', '', $wpmemory );
		if ( $wpmemory_num >= 256 ) {
			echo '<p>WordPress Memory Limit : <span class="wdp-elementor-yes"><i class="dashicons dashicons-thumbs-up"></i>&nbsp;'.$wpmemory.'</span></p>';
		}
		else {
			echo '<p>WordPress Memory Limit : <span class="wdp-elementor-error"><i class="dashicons dashicons-warning"></i>&nbsp;'.$wpmemory.'</span></p>';
			echo '<p style="color: #7d8183;font-size: 0.9em">WordPress Memory Limit minimum  256M, supaya semua fitur berjalan dengan baik. <a href="https://weddingpress.net/panduan" target="_blank" style="color: #ff0000; text-decoration: none;">' . __( 'Cek disini panduannya', 'templatepress' ) . '</a></i>';
		}


		$maxexectime = ini_get( 'max_execution_time' );
		if ( $maxexectime >= 300 ) {
			echo '<p>PHP Max Execution Time : <span class="wdp-elementor-yes"><i class="dashicons dashicons-thumbs-up"></i>&nbsp;'.$maxexectime.'</span></p>';
		}
		else {
			echo '<p>PHP Max Execution Time : <span class="wdp-elementor-error"><i class="dashicons dashicons-warning"></i>&nbsp;'.$maxexectime.'</span></p>';
			echo '<p style="color: #7d8183;font-size: 0.9em">PHP Max Execution Time direkomendasikan 300, supaya semua fitur berjalan dengan baik. <a href="https://weddingpress.net/panduan" target="_blank" style="color: #ff0000; text-decoration: none;">' . __( 'Cek disini panduannya', 'templatepress' ) . '</a></i>';

			
		}

		$maxinputvars = ini_get( 'max_input_vars' );
		$check['data'] = $maxinputvars;
		if ( $maxinputvars >= 1000 ) {
			echo '<p>PHP Max Input Time : <span class="wdp-elementor-yes"><i class="dashicons dashicons-thumbs-up"></i>&nbsp;'.$check['data'].'</span></p>';
		}
		else {
			echo '<p>PHP Max Input Time : <span class="wdp-elementor-error"><i class="dashicons dashicons-warning"></i>&nbsp;'.$check['data'].'</span></p>';
			echo '<p style="color: #7d8183;font-size: 0.9em">PHP Max Input Time direkomendasikan 1000, supaya semua fitur berjalan dengan baik. <a href="https://weddingpress.net/panduan" target="_blank" style="color: #ff0000; text-decoration: none;">' . __( 'Cek disini panduannya', 'templatepress' ) . '</a></i>';
			
		}

		$postmaxsize = ini_get( 'post_max_size' );
		$check['data'] = $postmaxsize;
		if ( $postmaxsize >= 64 ) {
			echo '<p>PHP Post Max Size : <span class="wdp-elementor-yes"><i class="dashicons dashicons-thumbs-up"></i>&nbsp;'.$check['data'].'</span></p>';
		}
		else {
			echo '<p>PHP Post Max Size : <span class="wdp-elementor-error"><i class="dashicons dashicons-warning"></i>&nbsp;'.$check['data'].'</span></p>';
			echo '<p style="color: #7d8183;font-size: 0.9em">PHP Post Max Size minimum 64M ke atas, direkomendasikan 64M, supaya semua fitur berjalan dengan baik. <a href="https://weddingpress.net/panduan" target="_blank" style="color: #ff0000; text-decoration: none;">' . __( 'Cek disini panduannya', 'templatepress' ) . '</a></i>';
			
		}

		$maxuploadsize = wp_max_upload_size();
		$check['data'] = size_format( $maxuploadsize );
		if ( $maxuploadsize >= 64000000 ) {
			echo '<p>Max Upload Size : <span class="wdp-elementor-yes"><i class="dashicons dashicons-thumbs-up"></i>&nbsp;'.$check['data'].'</span></p>';
		}
		else {
			echo '<p>Max Upload Size : <span class="wdp-elementor-error"><i class="dashicons dashicons-warning"></i>&nbsp;'.$check['data'].'</span></p>';
			echo '<p style="color: #7d8183;font-size: 0.9em">Max Upload Size minimum 64M ke atas, direkomendasikan 64M, supaya semua fitur berjalan dengan baik. <a href="https://weddingpress.net/panduan" target="_blank" style="color: #ff0000; text-decoration: none;">' . __( 'Cek disini panduannya', 'templatepress' ) . '</a></i>';
		}

		$curlversion = curl_version();
		$check['data'] = $curlversion['version'].', '.$curlversion['ssl_version'];
		echo '<p>cURL Version : <span class="wdp-elementor-yes"><i class="dashicons dashicons-thumbs-up"></i>&nbsp;'.$check['data'].'</span></p>';

		if ( $this->is_active() ) {
			$response = wp_remote_get( 'https://weddingpress.co.id/wp-json/wdp/v1/info', [
				'timeout' => 60,
				'body' => [
					'api_version' => WEDDINGPRESS_ELEMENTOR_VERSION,
					'site_lang' => get_bloginfo( 'language' ),
				],
			]
			);

			if ( is_wp_error( $response ) ) {
				echo '<p>WeddingPress Library : <span class="wdp-elementor-error"><i class="dashicons dashicons-dismiss"></i>&nbsp;NOT CONNECTED'. $response->get_error_message() .'</span></p>';
			}

			$http_response_code = wp_remote_retrieve_response_code( $response );

			if ( 200 !== (int) $http_response_code ) {
			$error_msg = 'HTTP Error (' . $http_response_code . ')';
				echo '<p>WeddingPress Library : <span class="wdp-elementor-error"><i class="dashicons dashicons-dismiss"></i>&nbsp;NOT CONNECTED'. $error_msg .'</span></p>';
			}

			$library_data = json_decode( wp_remote_retrieve_body( $response ), true );

			if ( empty( $library_data ) ) {
				echo '<p>WeddingPress Library : <span class="wdp-elementor-error"><i class="dashicons dashicons-dismiss"></i>&nbsp;NOT CONNECTED</span></p>';
				echo '<p style="color: #7d8183;font-size: 0.9em">tidak ada template yang tersedia, silahkan hubungi support!</p>';
			}
			else {
				echo '<p>WeddingPress Library : <span class="wdp-elementor-yes"><i class="dashicons dashicons-yes-alt"></i>&nbsp;CONNECTED</span></p>';
				echo '<p class="wdp-elementor-yes">Alhamdulillah! WeddingPress siap untuk digunakan.</p>';
			}
			

			$library_template = 0;
			$library_block = 0;
			if ( isset( $library_data['templates'] ) && !empty($library_data['templates']) ) {
				foreach ( $library_data['templates'] as $template ) {
					if ( $template['type'] == 'section' ) {
						$library_template++;
					}
				}
			}
			if ( isset( $library_data['tags'] ) && !empty($library_data['tags']) ) {
				foreach ( $library_data['tags'] as $template ) {
					$library_block++;
				}
			}
			if ( $library_template || $library_block ) {
				$library_template ? $library_template.' templates' : '';
				echo '<p>WeddingPress Templates : <span class="wdp-elementor-yes"><i class="dashicons dashicons-admin-page"></i>&nbsp;'.$library_template.' Templates</span></p>';
				$library_block ? $library_block.' blocks/sections' : '';
				echo '<p>WeddingPress Categories Templates : <span class="wdp-elementor-yes"><i class="dashicons dashicons-open-folder"></i>&nbsp;'.$library_block.' Categories</span></p>';
			}
		}
	}

	public function setup_fields() {
		$fields = array(
			array(
				'label' => esc_html__( 'Licensi', 'weddingpress' ),
				'id' => wdp_connect_key() . '_connect_site_key',
				'type' => 'license',
				'section' => 'weddingpress_elementor_license',
			)
		);
		
		$fields[] = array(
			'label' => esc_html__( 'System Info', 'weddingpress' ),
			'id' => 'weddingpress_status',
			'type' => 'status',
			'section' => 'weddingpress_elementor_status',
		);

		if ( $this->is_active() ) {
			$fields[] = array(
				'label'       => esc_html__( 'Pilih CommentKit Versi', 'weddingpress' ),
				'id'          => 'comment_type',
				'desc'        => '',
				'type'        => 'select',
				'default'     => 'none',
				'options'     => array(
					'none' => 'None',
					'commentkit' => 'Comment Kit 1',
					'commentkit2'  => 'Comment Kit 2',
				),
				'section'     => 'weddingpress_elementor_status',
			);
			$fields[] = array(
				'label'       => esc_html__( 'WeddingPress Sticky', 'weddingpress' ),
				'id'          => 'sticky_type',
				'desc'        => '',
				'type'        => 'select',
				'default'     => 'show',
				'options'     => array(
					'show' => 'Aktif',
					'hide'  => 'Non Aktif',
				),
				'section'     => 'weddingpress_elementor_status',
			);
		
		}

		foreach( $fields as $field ){
			add_settings_field( $field['id'], $field['label'], array( $this, 'field_callback' ), 'wdp_elementor', $field['section'], $field );
			if ( 'note' != $field['type'] ) {
				if ( false === strpos( $field['id'], '[' ) ) {
					register_setting( 'wdp_elementor', $field['id'] );
				}
				else {
					$a = explode( '[', $field['id'] );
					$b = trim( $a[0] );
					register_setting( 'wdp_elementor', $b );
				}
			}
		}
		
	}

	public function guestbook_box_submit(){		
		
		if(empty($_POST['guestbook-name'])) wp_die();
		if(empty($_POST['guestbook-message'])) wp_die();
		
		$data_array = get_option('post_guestbook_box_data'.$_POST['id'],array());		
		$data = array(
			'name' => $_POST['guestbook-name'],
			'message' => $_POST['guestbook-message'],
			'confirm' => $_POST['confirm'],
		);
		
		$data_array[] = $data;
		update_option('post_guestbook_box_data'.$_POST['id'], $data_array);
		$avatar = $_POST['avatar'];
		
		?>						
			<div class="user-guestbook">
				<div><img src="<?php echo $avatar; ?>"></div>
				<div class="guestbook">
					<a class="guestbook-name"><?php echo str_replace("\\", "", htmlspecialchars ($data['name']))?></a><span class="wdp-confirm"><i class="fas fa-check-circle"></i> <?php echo $data['confirm']?></span>
					<div class="guestbook-message"><?php echo str_replace("\\", "", htmlspecialchars ($data['message']))?></div>
				</div>
			</div>
		
		<?php 
		
		wp_die();
	}

	public function field_callback( $field ) {
		if ( false === strpos( $field['id'], '[' ) ) {
			$value = get_option( $field['id'] );
		}
		else {
			$a = explode( '[', $field['id'] );
			$b = trim( $a[0] );
			$c = trim( str_replace( ']', '', $a[1] ) );
			$d = get_option( $b );
			$value = isset( $d[$c] ) ? $d[$c] : false;
		}
		$defaults = array(
			'label'			=> '',
			'label2'		=> '',
			'type'			=> 'text',
			'default'		=> '',
			'desc'			=> '',
			'placeholder'	=> '',
			'field_class'	=> '',
		);
		$field = wp_parse_args( $field, $defaults );
		$field['db'] = $field['id'];
		$field['id'] = str_replace( array( '[', ']' ), '_', $field['id'] );
		switch ( $field['type'] ) {
			case 'license':
				$this->license_field();
				break;
			case 'status':
				$this->status_field();
				break;
			case 'note':
				printf( '<label for="%1$s">%2$s</label><br/>',
					$field['id'],
					$field['label2']
				);
				break;
			case 'select':
				if( ! empty ( $field['options'] ) && is_array( $field['options'] ) ) {
					$attr = '';
					$options = '';
					foreach( $field['options'] as $key => $label ) {
						$options.= sprintf( '<option value="%s" %s>%s</option>',
							$key,
							selected( $value, $key, false ),
							$label
						);
					}
					printf( '<select name="%1$s" id="%2$s" class="%3$s" %4$s>%5$s</select>',
						$field['db'],
						$field['id'],
						$field['field_class'],
						$attr,
						$options
					);
				}
				break;
			default:
				printf( '<input name="%1$s" id="%2$s" class="%3$s" type="%4$s" placeholder="%5$s" value="%6$s" />',
					$field['db'],
					$field['id'],
					$field['field_class'],
					$field['type'],
					$field['placeholder'],
					$value
				);
		}
		if( $desc = $field['desc'] ) {
			printf( '<p class="description">%s </p>', $desc );
		}
	}

	public function show_invalid_license_notice(){
        if ( !$this->is_active()){
            $class = 'notice notice-error';
            $message = sprintf(__( '<strong>Terima kasih sudah menggunakan WeddingPress</strong> Silahkan %s Aktivasi Lisensi %s untuk mendapatkan update otomatis, support teknis, dan akses WeddingPress.', 'weddingpress' ), " <a href='".admin_url('admin.php?page=weddingpress-license')."'>", '</a>');

            printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), $message );
        }
    }
	
}

function wdp_cek_input_global($param){
	return filter_input(
		INPUT_GET, 
		$param, 
		FILTER_CALLBACK, 
		['options' => 'sanitize_text_field']
	);
}

if(check_is_active()) : if ( did_action( 'elementor/loaded' ) ) {
	include_once( WEDDINGPRESS_ELEMENTOR_PATH . '/elementor/elementor.php' ); } 
endif;

add_action('wp_head', 'weddingpress_preview_elementor');
function weddingpress_preview_elementor() {

    if ( isset( $_GET['elementor-preview'] ) && $_GET['elementor-preview'] ) {
        ?>
        <style>
            #unmute-sound {
                display: block !important;
            }
            #mute-sound {
                display: block !important;
            }
        </style>
        <?php    
    }

}

function get_current_post_id() {
        if (isset(\Elementor\Plugin::instance()->documents)) {
            return \Elementor\Plugin::instance()->documents->get_current()->get_main_id();
        }
        return get_the_ID();
}

function wdp_find_element_recursive($elements, $element_id) {
    foreach ($elements as $element) {
        if ($element_id === $element['id']) {
            return $element;
        }
        if (!empty($element['elements'])) {
            $element = wdp_find_element_recursive($element['elements'], $element_id);
            if ($element) {
                return $element;
            }
        }
    }
    return \false;
}

if ( ! function_exists( 'is_plugin_active' ) ) {
	include_once ABSPATH . 'wp-admin/includes/plugin.php';
}

if ( is_wdp_woocommerce_active() ) {
add_filter( 'wdp_woo_elements_js_localize', 'js_localize' );
}

/**
 * Load Quick View Product.
 *
 * @since 1.3.3
 * @param array $localize localize.
 * @access public
 */
function js_localize( $localize ) {
    
	$localize['is_cart']           = is_cart();
	$localize['is_single_product'] = is_product();
	$localize['view_cart']         = esc_attr__( 'View cart', 'wdp' );
	$localize['cart_url']          = apply_filters( 'wdp_woocommerce_add_to_cart_redirect', wc_get_cart_url() );
	
	return $localize;
}


/**
 * Is WooCommerce active
 *
 * @return bool
 */
function is_wdp_woocommerce_active() {
	if ( class_exists( 'WooCommerce' ) || is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
		return true;
	}
	return false;
}



