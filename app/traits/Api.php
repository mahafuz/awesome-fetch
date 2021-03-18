<?php

namespace Awesome_Fetch\Traits;

trait Api {

	public function get_data() {
		
		if ( empty( $_GET ) || ! wp_verify_nonce( sanitize_text_field( $_GET['nonce'] ), 'awesome_fetch_nonce' ) ) {
			wp_send_json_error( __( 'Something went wrong. Nonce Issue.', 'awesome-fetch' ) );
        }

		$this->fetch_data();

		die();
	}

	private function fetch_data() {
		$request = wp_remote_get( 'https://miusage.com/v1/challenge/1/' );

		try {
			$response = wp_remote_retrieve_body( $request );
			$this->save($response);
		}catch( Exception $e ) {
			wp_send_json_error(json_encode($e->errorMessage()));
		}
	}

}
