<?php
/**
 * Data utility for get, update, delete.
 *
 * @since      1.0.0
 *
 * @package    Awesome_Fetch
 * @subpackage Awesome_Fetch/Api
 */

namespace Awesome_Fetch\Traits;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

trait Data {

	/**
	 * Util method for get saved transient data.
	 *
	 * @return mixed
	 * @since 1.0.0
	 */
	public function get() {
		if ( empty( get_transient( 'awesome_fetch_data' ) ) ) {
			return $this->fetch_data();
		}

		return get_transient( 'awesome_fetch_data' );
	}

	/**
	 * Util method for save fetched data as transient.
	 *
	 * @param string $data json data to be saved in the transient.
	 *
	 * @return bool
	 * @since 1.0.0
	 */
	public function save( $data = '' ): bool {
		return set_transient( 'awesome_fetch_data', $data, HOUR_IN_SECONDS );
	}

	/**
	 * Util method for delete saved transient data.
	 *
	 * @return bool
	 * @since 1.0.0
	 */
	public function delete() {
		return delete_transient( 'awesome_fetch_data' );
	}

}
