<?php


namespace Awesome_Fetch;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class App {
	
	use \Awesome_Fetch\Traits\Api;
	use \Awesome_Fetch\Traits\Data;

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

		add_action( 'admin_menu', [ $this, 'add_menu_page' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'register_scripts' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'frontend_scripts' ] );
		add_shortcode( 'awf_table', [ $this, 'awesome_fetch_shortcode' ] );

		if( empty($this->get()) ) {
			add_action( 'wp_ajax_awesome_fetch_get_data', [ $this, 'get_data' ] );
			add_action( 'wp_ajax_nopriv_awesome_fetch_get_data', [ $this, 'get_data' ] );
		}
	}

	public function register_scripts() {

		$screen = get_current_screen();

		if( 'toplevel_page_awesome-fetch' === $screen->id && empty( $this->get() ) ) {
			wp_enqueue_script(
				'awesome-fetch',
				AWF_PLUGIN_URL . 'assets/js/awesome-fetch.js', [ 'jquery' ],
				'1.0.0', true
			);
			wp_localize_script(
				'awesome-fetch',
				'AwesomeFetch',
				[
					'ajax_url' => admin_url( 'admin-ajax.php' )
				]
			);
		}

	}

	public function frontend_scripts() {

		if( empty( $this->get() ) ) {
			wp_enqueue_script(
				'awesome-fetch',
				AWF_PLUGIN_URL . 'assets/js/awesome-fetch.js', [ 'jquery' ],
				'1.0.0', true
			);

			wp_localize_script(
				'awesome-fetch',
				'AwesomeFetch',
				[
					'ajax_url' => admin_url( 'admin-ajax.php' )
				]
			);
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
		include AWF_PLUGIN_PATH . 'app/views/admin-layout.php';
	}

	public function awesome_fetch_shortcode() {
		ob_start();
		include AWF_PLUGIN_PATH . 'app/views/admin-layout.php';
		return ob_get_clean();
	}

	public function add_cli_commands() {
		if ( class_exists( 'WP_CLI' ) ) {
			\WP_CLI::add_command( 'awesome-fetch', function() {
				\WP_CLI::success( "Successfully Fetched data!" );
			});
		}
	}
}
