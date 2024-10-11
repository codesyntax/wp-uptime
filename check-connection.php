<?php
global $wpdb;

// Check the connection:
if (!$wpdb->check_connection($allow_bail = false)) {
    die(__("No DB connection"));
} else {
    header('Content-Type: text/plain; charset=utf-8');
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');
    echo get_option_or_value("wp_uptime_response_value", 'OK');
}
exit;
