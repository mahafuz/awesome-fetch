<?php

namespace Awesome_Fetch\Traits;

trait Api {

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
