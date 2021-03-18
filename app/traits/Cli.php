<?php

namespace Awesome_Fetch\Traits;

trait Cli {

    public function add_cli_commands() {
		if ( class_exists( 'WP_CLI' ) ) {
			\WP_CLI::add_command( 'awesome-fetch', function() {
                $this->fetch_data();
				\WP_CLI::success( "Successfully Fetched data!" );
			});
		}
	}

}