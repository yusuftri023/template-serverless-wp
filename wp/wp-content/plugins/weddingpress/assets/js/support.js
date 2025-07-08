/* globals wp_mail_smtp, jconfirm, ajaxurl */
'use strict';

var WDP = window.WDP || {};
WDP.Admin = WDP.Admin || {};

/**
 * WP Mail SMTP Admin area module.
 *
 * @since 1.6.0
 */
WDP.Admin.Settings = WDP.Admin.Settings || ( function( document, window, $ ) {

	/**
	 * Public functions and properties.
	 *
	 * @since 1.6.0
	 *
	 * @type {object}
	 */
	var app = {

		/**
		 * State attribute showing if one of the plugin settings
		 * changed and was not yet saved.
		 *
		 * @since 1.9.0
		 *
		 * @type {boolean}
		 */
		pluginSettingsChanged: false,

		/**
		 * Start the engine. DOM is not ready yet, use only to init something.
		 *
		 * @since 1.6.0
		 */
		init: function() {

			// Do that when DOM is ready.
			$( app.ready );
		},

		/**
		 * DOM is fully loaded.
		 *
		 * @since 1.6.0
		 */
		ready: function() {

			// If there are screen options we have to move them.
			$( '#screen-meta-links, #screen-meta' ).prependTo( '#wdp-elementor-header-temp' ).show();

			// Flyout Menu.
			app.initFlyoutMenu();
		},

		/**
		 * Flyout Menu (quick links).
		 *
		 * @since 3.0.0
		 */
		initFlyoutMenu: function() {

			// Flyout Menu Elements.
			var $flyoutMenu = $( '#wdp-elementor-flyout' );

			if ( $flyoutMenu.length === 0 ) {
				return;
			}

			var $head = $flyoutMenu.find( '.wdp-elementor-flyout-head' );

			// Click on the menu head icon.
			$head.on( 'click', function( e ) {
				e.preventDefault();
				$flyoutMenu.toggleClass( 'opened' );
			} );

			// Page elements and other values.
			var $wpfooter = $( '#wpfooter' );

			if ( $wpfooter.length === 0 ) {
				return;
			}

			var $overlap = $(
				'.wdp-elementor-page-logs-archive, ' +
				'.wdp-elementor-tab-tools-action-scheduler, ' +
				'.wdp-elementor-page-reports, ' +
				'.wdp-elementor-tab-tools-debug-events, ' +
				'.wdp-elementor-tab-connections'
			);

			// Hide menu if scrolled down to the bottom of the page or overlap some critical controls.
			$( window ).on( 'resize scroll', _.debounce( function() {

				var wpfooterTop = $wpfooter.offset().top,
					wpfooterBottom = wpfooterTop + $wpfooter.height(),
					overlapBottom = $overlap.length > 0 ? $overlap.offset().top + $overlap.height() + 85 : 0,
					viewTop = $( window ).scrollTop(),
					viewBottom = viewTop + $( window ).height();

				if ( wpfooterBottom <= viewBottom && wpfooterTop >= viewTop && overlapBottom > viewBottom ) {
					$flyoutMenu.addClass( 'out' );
				} else {
					$flyoutMenu.removeClass( 'out' );
				}
			}, 50 ) );

			$( window ).trigger( 'scroll' );
		}
	};

	// Provide access to public functions/properties.
	return app;
}( document, window, jQuery ) );

// Initialize.
WDP.Admin.Settings.init();
