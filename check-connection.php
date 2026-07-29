<?php
if (!defined('ABSPATH')) {
    exit;
}

global $wpdb;

/**
 * 1. Check database connection and responsiveness
 * Using a simple and safe check to avoid 500 errors.
 */
$db_responsive = false;
try {
    if (isset($wpdb) && is_object($wpdb) && method_exists($wpdb, 'check_connection')) {
        if ($wpdb->check_connection()) {
            // Test query
            $test = $wpdb->get_var("SELECT 1");
            if ($test == 1) {
                $db_responsive = true;
            }
        }
    }
} catch (Exception $e) {
    $db_responsive = false;
}

/**
 * 2. Check if the site is in maintenance mode
 */
$is_maintenance = file_exists(ABSPATH . '.maintenance');

// Final health check
$is_healthy = $db_responsive && !$is_maintenance;

// Allow external checks via filter if someone wants to hook into it
$is_healthy = apply_filters('wpuptime_health_check', $is_healthy);

// Set headers to prevent caching
header('Content-Type: text/plain; charset=utf-8');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

if ($is_healthy) {
    echo get_option('wp_uptime_response_value', 'OK');
} else {
    // Return 503 Service Unavailable if any check fails
    header('HTTP/1.1 503 Service Unavailable');
    
    if (!$db_responsive) {
        echo 'Error: Database is not responding';
    } elseif ($is_maintenance) {
        echo 'Error: Site is in maintenance mode';
    } else {
        echo 'Error: Site health check failed';
    }
}
exit;
