<?php
/**
 * Rendering the admin page.
 *
 * @since 1.0.0
 * @package Awesome_Fetch
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

list( 'title' => $table_title, 'data' => $data ) = json_decode( $this->get(), true );
list( 'headers' => $headers, 'rows' => $rows )   = $data;
?>
<div class="awesome-fetch-data-wrap wrap">
	<h1 class="screen-reader-text"><?php esc_html__( 'Awesome Fetch', 'awesome-fetch' ); ?></h1>

	<div class="awesome-fetch-header">
	<?php if ( $table_title ) : ?>
		<h2><?php echo esc_attr( $table_title ); ?></h2>
	<?php endif; ?>
	<?php if ( 'dashboard' === $this->context ) : ?>
		<button id="awf-refresh-button" class="button button-primary"><?php esc_html_e( 'Refresh', 'awesome-fetch' ); ?></button>
	<?php endif; ?>
	</div>

<?php if ( $headers ) : ?>
	<form class="awf-data-form">
		<table class="wp-list-table widefat fixed striped">
		<thead>
			<tr>
			<?php foreach ( $headers as $header ) : ?>
				<th><span><?php echo esc_attr( $header ); ?></span></th>
			<?php endforeach; ?>
			</tr>
		</thead>

			<tbody>
			<?php foreach ( $rows as $row ) : ?>
				<tr>
					<td># <span><?php echo esc_attr( $row['id'] ); ?></span></td>
					<td><span><?php echo esc_attr( $row['fname'] ); ?></span></td>
					<td><span><?php echo esc_attr( $row['lname'] ); ?></span></td>
					<td><span><?php echo esc_attr( $row['email'] ); ?></span></td>
					<td><span><?php echo esc_attr( gmdate( 'm/d/Y', intval( $row['date'] ) ) ); ?></span></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</form>
<?php endif; ?>
</div>
