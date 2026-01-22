<?php
/**
 * Plugin Name: Plausible Analytics - Custom EDD Events
 * Description: Custom plugin which fires custom events (specific to EDD) to track in Plausible Analytics.
 * Version: 1.0.0
 * Author: Daan from Daan.dev
 * Author URI: https://daan.dev
 * Plugin URI: https://github.com/Dan0sz/plausible-edd-events
 */

class BrevoHoneypot {
	/**
	 * @var string $honeypot_name
	 */
	private $honeypot_name;
	
	/**
	 *
	 */
	public function __construct() {
		$this->honeypot_name = apply_filters( 'brevo_honeypot_name', 'come_and_get_it' );
		
		/**
		 * Run before 'mailin', which runs at default priority (10).
		 */
		add_action( 'init', [ $this, 'init' ], 9 );
	}
	
	/**
	 * @return void
	 */
	public function init() {
		if ( ! empty( $_POST[ $this->honeypot_name ] ) ) {
			$_POST['sib_action']      = 'bot';
			$_POST['sib_form_action'] = 'bot';
		}
	}
}

new BrevoHoneypot();