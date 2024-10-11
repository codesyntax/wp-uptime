<?php

/**
 * WP Uptime
 *
 * @package     WP Uptime
 * @author      CodeSYntax
 * @copyright   2023 CodeSyntax
 * @license     GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name: WP Uptime
 * Plugin URI:  https://github.com/codesyntax/wp-uptime
 * Description: Editable non-cached monitorization path for Wordpress.
 * Version:     4.0.0
 * Author:      CodeSyntax
 * Author URI:  https://codesyntax.com
 * Text Domain: wp-uptime
 * License:     GPL v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

require_once plugin_dir_path(__FILE__) . 'admin.php';
require_once plugin_dir_path(__FILE__) . 'utils.php';

function wp_uptime_query_var($public_query_vars)
{
    $public_query_vars[] = "wp_uptime";
    return $public_query_vars;
}

function wp_uptime_request($wp)
{
    if (isset($wp->query_vars["wp_uptime"]) && "true" === $wp->query_vars["wp_uptime"]) {
        include('check-connection.php');
    }
}

function wp_uptime_endpoint_rewrite()
{
    add_rewrite_rule("^" . get_option_or_value("wp_uptime_endpoint_path", 'ok') . "$", "index.php?wp_uptime=true", "top");

    flush_rewrite_rules();
}


function run_wp_uptime_endpoint()
{
    add_filter("query_vars", "wp_uptime_query_var", 10, 1);
    add_action("parse_request", "wp_uptime_request", 10, 1);
    add_action("init", "wp_uptime_endpoint_rewrite", 10);
}

run_wp_uptime_endpoint();
