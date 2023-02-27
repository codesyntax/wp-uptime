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

function add_wp_uptime_page() {
    // Create post object
    $wp_uptime_post = array(
      'post_title'    => wp_strip_all_tags( 'WP Uptime' ),
      'post_name'     => 'ok',
      'post_status'   => 'publish',
      'post_author'   => 1,
      'post_type'     => 'page',
    );

    // Insert the post into the database
    wp_insert_post( $wp_uptime_post );
}

register_activation_hook(__FILE__, 'add_wp_uptime_page');

add_filter( 'page_template', 'wp_uptime_page_template' );
function wp_uptime_page_template( $page_template )
{
    if ( is_page( 'ok' ) ) {
        $page_template = dirname( __FILE__ ) . '/template-uptime.php';
    }
    return $page_template;
}

function remove_wp_uptime_page() {
    $page = get_page_by_path( 'ok' );
    wp_delete_post($page->ID, true);
};
register_deactivation_hook(__FILE__, 'remove_wp_uptime_page');