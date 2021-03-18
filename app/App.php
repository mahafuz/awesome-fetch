<?php


namespace Awesome_Fetch;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class App {
	
	use \Awesome_Fetch\Traits\Api;
	use \Awesome_Fetch\Traits\Data;
	use \Awesome_Fetch\Traits\Cli;

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
		add_action( 'wp_ajax_awesome_fetch_get_data', [ $this, 'get_data' ] );
		add_action( 'wp_ajax_nopriv_awesome_fetch_get_data', [ $this, 'get_data' ] );

		$this->add_cli_commands();
	}

	public function register_scripts() {

		$screen = get_current_screen();

		if( 'toplevel_page_awesome-fetch' === $screen->id ) {
			wp_enqueue_style(
				'awesome-fetch',
				AWF_PLUGIN_URL . 'assets/css/awesome-fetch.css', null,
				'1.0.0', 'all'
			);
			wp_enqueue_script(
				'awesome-fetch',
				AWF_PLUGIN_URL . 'assets/js/awesome-fetch.js', [ 'jquery' ],
				'1.0.0', true
			);
			wp_enqueue_script(
				'data-refresh',
				AWF_PLUGIN_URL . 'assets/js/data-refresh.js', [ 'jquery' ],
				'1.0.0', true
			);
			wp_localize_script(
				'awesome-fetch',
				'AwesomeFetch',
				[
					'ajax_url' => admin_url( 'admin-ajax.php' ),
					'nonce'  	=> wp_create_nonce( 'awesome_fetch_nonce' ),
					'send_request'	=> boolval(empty($this->get()))
				]
			);
		}

	}

	public function frontend_scripts() {

		wp_enqueue_style(
			'awesome-fetch',
			AWF_PLUGIN_URL . 'assets/css/awesome-fetch.css', null,
			'1.0.0', 'all'
		);

		wp_enqueue_script(
			'awesome-fetch',
			AWF_PLUGIN_URL . 'assets/js/awesome-fetch.js', [ 'jquery' ],
			'1.0.0', true
		);

		wp_localize_script(
			'awesome-fetch',
			'AwesomeFetch',
			[
				'ajax_url' 	=> admin_url( 'admin-ajax.php' ),
				'nonce'  	=> wp_create_nonce( 'awesome_fetch_nonce' ),
				'send_request'	=> boolval(empty($this->get()))
			]
		);
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
		$context_dashboard = true;
		include AWF_PLUGIN_PATH . 'app/views/admin-layout.php';
	}

	public function awesome_fetch_shortcode() {
		ob_start();
		include AWF_PLUGIN_PATH . 'app/views/admin-layout.php';
		return ob_get_clean();
	}
}
