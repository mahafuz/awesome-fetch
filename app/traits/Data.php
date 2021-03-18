<?php

namespace Awesome_Fetch\Traits;

trait Data {

	public function get() {
		return get_transient( 'awesome_fetch_data' );
	}

	public function save( $data = [] ) {
		return set_transient( 'awesome_fetch_data', $data, HOUR_IN_SECONDS );
	}

}
