<?php
global $wpdb;
$result = $wpdb->check_connection();


if ($result) {
    header('Content-Type: text/plain; charset=utf-8');
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');
    echo get_option_or_value("wp_uptime_response_value", 'OK');
}