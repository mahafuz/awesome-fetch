<?php


namespace Awesome_Fetch;


class Data {

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

	public static function get() {
		return get_option( 'awesome_fetch_data', [] );
	}

	public static function save( $data = [] ) {
		dlog("saving");
		return update_option( 'awesome_fetch_data', $data );
	}

}
