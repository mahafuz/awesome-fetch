<?php

namespace Awesome_Fetch\Traits;
trait Cli {

	public function add_cli_commands() {
		if ( class_exists( 'WP_CLI' ) ) {
			\WP_CLI::add_command( 'awesome-fetch', function () {
				$count = 1;
				$progress = \WP_CLI\Utils\make_progress_bar( 'Refreshing..', $count );
				$i = 0;
				while( $i < $count ) {
					$this->fetch_data();
					$progress->tick();
					$i++;
				}
				
				$progress->finish();
				\WP_CLI::success( "Successfully refreshed data!" );
			} );
		}
	}

}