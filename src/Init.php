<?php
/**
 *
 */

namespace Plausible\EDDEvents;

class Init {
	/**
	 * Initialize the plugin.
	 */
	public function __construct() {
		$this->init();
	}
	
	/**
	 * Action/filter hooks.
	 *
	 * @return void
	 */
	private function init() {
		add_action( 'plugins_loaded', 'load_checkout_script', 501 );
	}
	
	/**
	 * Loads custom JS scripts in EDD's checkout.
	 *
	 * @return void
	 */
	public function load_checkout_script() {
		if ( ! edd_is_checkout() ) {
			return;
		}
		
		$suffix = $this->get_script_suffix();
		
		wp_enqueue_script(
			'plausible-edd-events',
			PLAUSIBLE_EDD_EVENTS_PLUGIN_URL . "assets/js/plausible-edd-events$suffix.js",
			[
				'edd-checkout-global',
				'plausible-analytics'
			],
			filemtime( PLAUSIBLE_EDD_EVENTS_PLUGIN_DIR . "assets/js/plausible-edd-events$suffix.js" ),
			true
		);
	}
	
	/**
	 * Checks if debugging is enabled for local machines.
	 *
	 * @return string .min | ''
	 */
	private function get_script_suffix() {
		return defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	}
}
