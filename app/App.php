<?php
/**
 * Responsible for initiating and running the plugin core functionality.
 *
 * @since      1.0.0
 *
 * @package    Awesome_Fetch
 * @subpackage Awesome_Fetch/App
 */

namespace Awesome_Fetch;

use Awesome_Fetch\Traits\Api;
use Awesome_Fetch\Traits\Cli;
use Awesome_Fetch\Traits\Data;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/**
 *
 * Registers the dashboard page with the WordPress Api, fetch data from the API, and renders
 * the content by including the markup from its associative view.
 *
 * @since      1.0.0
 *
 * @package    Awesome_Fetch
 * @subpackage Awesome_Fetch/App
 * @author      Mahafuz <m.mahfuz.me@gmail.com>
 */
class App {

	use Api;
	use Data;
	use Cli;

	/**
	 * Single instance of the class
	 *
	 * @var \App
	 * @since 1.0.0
	 */
	private static $instance = null;

	/**
	 * Contains the screen context.
	 *
	 * @access    private
	 * @var    string
	 */
	private $context = false;

	/**
	 * Register this methods with the WordPress API
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_menu_page' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_scripts' ) );

		add_action( 'wp_ajax_awesome_fetch_get_data', array( $this, 'get_data' ) );
		add_action( 'wp_ajax_nopriv_awesome_fetch_get_data', array( $this, 'get_data' ) );

		add_shortcode( 'awf_table', array( $this, 'awesome_fetch_shortcode' ) );
		add_action( 'cli_init', array( $this, 'awf_cli_command' ) );
	}

	/**
	 * Returns single instance of the class
	 *
	 * @return \App
	 * @since 1.0.0
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Enqueues all files specifically for the dashboard.
	 *
	 * @since    1.0.0
	 */
	public function admin_scripts() {
		$screen = get_current_screen();

		if ( 'toplevel_page_awesome-fetch' === $screen->id ) {
			wp_enqueue_style(
				'awesome-fetch',
				AWF_PLUGIN_URL . 'assets/css/awesome-fetch.css',
				null,
				'1.0.0',
				'all'
			);
			wp_enqueue_script(
				'awesome-fetch',
				AWF_PLUGIN_URL . 'assets/js/awesome-fetch.js',
				array( 'jquery' ),
				'1.0.0',
				true
			);
			wp_enqueue_script(
				'data-refresh',
				AWF_PLUGIN_URL . 'assets/js/data-refresh.js',
				array( 'jquery' ),
				'1.0.0',
				true
			);
			wp_localize_script(
				'awesome-fetch',
				'AwesomeFetch',
				array(
					'ajax_url'     => admin_url( 'admin-ajax.php' ),
					'nonce'        => wp_create_nonce( 'awesome_fetch_nonce' ),
				)
			);
		}
	}

	/**
	 * Enqueues all files specifically for the frontend.
	 *
	 * @since    1.0.0
	 */
	public function frontend_scripts() {
		wp_enqueue_style(
			'awesome-fetch',
			AWF_PLUGIN_URL . 'assets/css/awesome-fetch.css',
			null,
			'1.0.0',
			'all'
		);

		wp_enqueue_script(
			'awesome-fetch',
			AWF_PLUGIN_URL . 'assets/js/awesome-fetch.js',
			array( 'jquery' ),
			'1.0.0',
			true
		);

		wp_localize_script(
			'awesome-fetch',
			'AwesomeFetch',
			array(
				'ajax_url'     => admin_url( 'admin-ajax.php' ),
				'nonce'        => wp_create_nonce( 'awesome_fetch_nonce' ),
			)
		);
	}

	/**
	 * The function responsible for creating the dashboard page.
	 *
	 * @since    1.0.0
	 */
	public function add_menu_page() {
		add_menu_page(
			__( 'Awesome Fetch', 'awesome-fetch' ),
			_x( 'Awesome Fetch', 'Display fetched data from api', 'awesome-fetch' ),
			'manage_options',
			'awesome-fetch',
			array( $this, 'awesome_fetch_display' )
		);
	}

	/**
	 * Renders the content of the dashboard page.
	 *
	 * @since    1.0.0
	 */
	public function awesome_fetch_display() {
		$this->context = 'dashboard';
		include AWF_PLUGIN_PATH . 'app/views/admin-layout.php';
	}

	/**
	 * The function responsible for creating data display table shortcode.
	 *
	 * @return mixed
	 * @since    1.0.0
	 */
	public function awesome_fetch_shortcode() {
		ob_start();
		include AWF_PLUGIN_PATH . 'app/views/admin-layout.php';

		return ob_get_clean();
	}
}
