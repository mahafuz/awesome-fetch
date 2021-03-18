<?php
/**
 * Responsible for fetching data from the API.
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

trait Api {

	/**
	 * Verify nonce for the ajax endpoint and fetch_data
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function get_data() {
		if ( empty( $_GET['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['nonce'] ) ), 'awesome_fetch_nonce' ) ) {
			wp_send_json_error( __( 'Something went wrong. Nonce Issue.', 'awesome-fetch' ) );
		}

		$this->fetch_data();
	}

	/**
	 * Fetch the actual data from the API and save data in WordPress
	 * transient.
	 *
	 * @api https://miusage.com/v1/challenge/1/
	 * @since 1.0.0
	 * @return void
	 */
	private function fetch_data() {
		$request = wp_remote_get( 'https://miusage.com/v1/challenge/1/' );

		try {
			$response = wp_remote_retrieve_body( $request );
			$this->save( $response );
		} catch ( Exception $e ) {
			wp_send_json_error( wp_json_encode( $e->errorMessage() ) );
		}
	}

}
