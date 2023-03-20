<?php
/**
 * WP Uptime
 *
 * @package     WPUptime
 * @author      CodeSYntax
 * @copyright   2023 CodeSyntax
 * @license     GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name: WPUptime
 * Plugin URI:  https://github.com/codesyntax/wp-uptime
 * Description: Editable non-cached monitorization path for Wordpress.
 * Version:     1.0.0
 * Author:      CodeSyntax
 * Author URI:  https://codesyntax.com
 * Text Domain: wp-uptime
 * License:     GPL v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */


add_action('rest_api_init', function () {
    register_rest_route(
        'wp-uptime',
        '/ok/',
        array(
            'methods' => 'GET',
            'callback' => 'wp_uptime_route_handler',
        )
    );
});

function wp_uptime_route_handler($request)
{
    global $wpdb;
    $result = $wpdb->check_connection();
    if ($result) {
        echo 'OK';
    }
}