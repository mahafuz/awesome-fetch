<?php
/**
 * Register the cli command for refreshing data from the API.
 *
 * @since      1.0.0
 *
 * @package    Awesome_Fetch
 * @subpackage Awesome_Fetch/Api
 */

namespace Awesome_Fetch\Traits;

use WP_CLI;
use function WP_CLI\Utils\make_progress_bar;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

trait Cli {

	/**
	 * Registering the cli command 'awesome-fetch'
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function awf_cli_command() {
		if ( class_exists( 'WP_CLI' ) ) {
			WP_CLI::add_command(
				'awesome-fetch',
				function () {
					$i        = 0;
					$count    = 1;
					$progress = make_progress_bar( 'Refreshing..', $count );

					while ( $i < $count ) {
						$this->fetch_data();
						$progress->tick();
						$i ++;
					}

					$progress->finish();
					WP_CLI::success( 'Successfully refreshed data!' );
				}
			);
		}
	}

}
