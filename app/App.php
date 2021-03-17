<?php


namespace Awesome_Fetch;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class App {

	/**
	 * Single instance of the class
	 *
	 * @var \App
	 * @since 1.0.0
	 */
	private static $instance = null;

	/**
	 * Returns single instance of the class
	 *
	 * @return \App
	 * @since 1.0.0
	 */
	public static function instance() {
		if ( self::$instance === null ) {
			return self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 *  Contains api data.
	 *
	 * @var         \Api
	 * @access      protected
	 * @since       1.0.0
	 */
	protected $api_data;

	public function __construct() {
		$api = new Api();
		add_action( 'admin_menu', [ $this, 'add_menu_page' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_action('awesome_fetch_update_data_cron_hook', [ $api,'get_data' ]);
		$this->scheduled_update_data();

		// \WP_CLI::add_command( 'awesome-fetch', function() use ($api) {
		// 	$api::get_data();
		// 	\WP_CLI::success( "Successfully Fetched data!" );
		// });
	}

	public function enqueue_scripts() {

		$screen = get_current_screen();

		wp_register_script(
			'awesome-fetch',
			AWF_PLUGIN_URL . 'assets/js/awesome-fetch.js', [ 'jquery' ],
			'1.0.0', true
		);

		if( 'toplevel_page_awesome-fetch' === $screen->id) {
			wp_enqueue_script( 'awesome-fetch' );
		}

	}

	public function add_menu_page() {

		add_menu_page(
			__( 'Awesome Fetch', 'awesome-fetch' ),
			_x('Awesome Fetch', 'Display fetched data from api', 'awesome-fetch'),
			'manage_options',
			'awesome-fetch',
			array($this, 'awesome_fetch_display')
		);

	}

	public function awesome_fetch_display() {
		echo "hello world";
	}

	/**
	 * Check if there is a hook in the cron
	 */
	public function scheduled_update_data()
	{
		if ( ! wp_next_scheduled( 'awesome_fetch_update_data_cron_hook' ) && ! wp_installing()  ) {
			wp_schedule_event( time(), 'hourly', 'awesome_fetch_update_data_cron_hook' );
		}
	}
}
