<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

[ 'title' => $title, 'data' => $data ] = json_decode($this->get(), true);
[ 'headers' => $headers, 'rows' => $rows ] = $data;

?>

<div class="awesome-fetch-data-wrap wrap">
    <h1 class="screen-reader-text"><?php esc_html__( 'Awesome Fetch', 'awesome-fetch' ); ?></h1>
    <h2><?= esc_attr( $title ); ?></h2>

    <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
                <?php foreach( $headers as $header ) : ?>
                    <th><span><?= esc_attr($header); ?></span></th>
                <?php endforeach; ?>
            </tr>
        </thead>

        <tbody>
            <?php foreach( $rows as $row ) : ?>
                <tr>
                    <td># <span><?= esc_attr($row['id']); ?></span></td>
                    <td><span><?= esc_attr($row['fname']); ?></span></td>
                    <td><span><?= esc_attr($row['lname']); ?></span></td>
                    <td><span><?= esc_attr($row['email']); ?></span></td>
                    <td><span><?= esc_attr($row['date']); ?></span></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>