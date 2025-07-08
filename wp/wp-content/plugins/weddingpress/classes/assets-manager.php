<?php

namespace WDP\Elementor;

use Elementor\Core\Settings\Manager as SettingsManager;

defined('ABSPATH') || die();

class Assets_Manager {

	/**
	 * Bind hook and run internal methods here
	 */
	public static function init() {
		add_action('elementor/editor/after_enqueue_scripts', [__CLASS__, 'editor_enqueue']);
	}


	public static function get_dark_stylesheet_url() {
		return WEDDINGPRESS_ELEMENTOR_URL . 'assets/css/editor-dark.min.css';
	}

	public static function enqueue_dark_stylesheet() {
		$theme = SettingsManager::get_settings_managers('editorPreferences')->get_model()->get_settings('ui_theme');

		if ('light' !== $theme) {
			$media_queries = 'all';

			if ('auto' === $theme) {
				$media_queries = '(prefers-color-scheme: dark)';
			}

			wp_enqueue_style(
				'wdp-editor-dark',
				self::get_dark_stylesheet_url(),
				[
					'elementor-editor',
				],
				WEDDINGPRESS_ELEMENTOR_VERSION,
				$media_queries
			);
		}
	}

	/**
	 * Enqueue editor assets
	 *
	 * @return void
	 */
	public static function editor_enqueue() {

		wp_enqueue_script(
			'wdp-editor',
			WEDDINGPRESS_ELEMENTOR_URL . 'assets/js/editor.min.js',
			['elementor-editor', 'jquery'],
			WEDDINGPRESS_ELEMENTOR_VERSION,
			true
		);

		Library_Manager::enqueue_assets();

		/**
		 * Make sure to enqueue this at the end
		 * otherwise it may not work properly
		 */
		self::enqueue_dark_stylesheet();

		$localize_data = [
			'editor_nonce'            => wp_create_nonce('wdp_editor_nonce'),
			'dark_stylesheet_url'     => self::get_dark_stylesheet_url(),
			'ASSETS_URL' => WEDDINGPRESS_ELEMENTOR_URL
		];

		wp_localize_script(
			'wdp-editor',
			'WDPEditor',
			$localize_data
		);
	}

}

Assets_Manager::init();
