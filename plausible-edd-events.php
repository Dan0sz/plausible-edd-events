<?php
/**
 * Plugin Name: Plausible Analytics - Custom EDD Events
 * Description: Custom plugin which fires custom events (specific to EDD) to track in Plausible Analytics.
 * Version: 1.0.0
 * Author: Daan from Daan.dev
 * Author URI: https://daan.dev
 * Plugin URI: https://github.com/Dan0sz/plausible-edd-events
 */

defined( 'ABSPATH' ) || exit;

/**
 * Define constants.
 */
define( 'PLAUSIBLE_EDD_EVENTS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'PLAUSIBLE_EDD_EVENTS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * Takes care of loading classes on demand.
 *
 * @param $class
 *
 * @return mixed|void
 */
require_once PLAUSIBLE_EDD_EVENTS_PLUGIN_DIR . 'vendor/autoload.php';

/**
 * Check if Easy Digital Downloads has loaded yet, and if so, Go!
 */
if ( defined( 'EDD_PLUGIN_FILE' ) ) {
	$plausible_edd_events = new Plausible\EDDEvents\Init();
}
