<?php

namespace Awesome_Fetch;

class Api {

	/**
	 * Single instance of the class
	 *
	 * @var \Api
	 * @since 1.0.0
	 */
	private static $instance = null;


	/**
	 * Returns single instance of the class
	 *
	 * @return \Api
	 * @since 1.0.0
	 */
	public static function instance() {
		if ( self::$instance === null ) {
			return self::$instance = new self();
		}

		return self::$instance;
	}

	public function __construct() {

		if( empty(Data::get()) ) {
			add_action( 'wp_ajax_awesome_fetch_get_data', [ $this, 'get_data' ] );
			add_action( 'wp_ajax_nopriv_awesome_fetch_get_data', [ $this, 'get_data' ] );
		}
		
	}

	public static function get_data() {

		$request = wp_remote_get( 'https://miusage.com/v1/challenge/1/' );

		try {
			$response = wp_remote_retrieve_body( $request );
			Data::save($response);
		}catch( Exception $e ) {
			wp_send_json_error(json_encode($e->errorMessage()));
		}

		// die();
	}

}
