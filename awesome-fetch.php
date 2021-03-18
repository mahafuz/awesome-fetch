<?php
/**
 * Plugin Name:     Awesome Fetch
 * Plugin URI:      https://awesomemotive.com/career/developer-applicant-challenge/
 * Description:     A simple plugin that retrieves data from a remote endpoint and display.
 * Author:          Mahafuz
 * Author URI:      https://github.com/mahafuz
 * Text Domain:     awesome-fetch
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Awesome_Fetch
 */

use Awesome_Fetch\App;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

define( 'AWF_PLUGIN_FILE', __FILE__ );
define( 'AWF_PLUGIN_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'AWF_PLUGIN_URL', trailingslashit( plugins_url( '/', __FILE__ ) ) );


/**
 * Including spl autoloader globally.
 *
 * @since 1.0.0
 */
require_once AWF_PLUGIN_PATH . '/vendor/autoload.php';


/**
 * Run the plugin after all other plugins.
 *
 * @since 1.0.0
 */
add_action(
	'plugins_loaded',
	function () {
		App::instance();
	}
);
