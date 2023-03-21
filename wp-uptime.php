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
 * Version:     2.0.0
 * Author:      CodeSyntax
 * Author URI:  https://codesyntax.com
 * Text Domain: wp-uptime
 * License:     GPL v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

function get_option_or_value($key, $default_value)
{
    $response = get_option($key);
    if (!$response) {
        $response = $default_value;
    }
    return $response;
}

add_action('rest_api_init', function () {
    register_rest_route(
        'wp-uptime',
        '/' . get_option_or_value("wp_uptime_endpoint_path", 'ok') . '/',
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
        echo get_option_or_value("wp_uptime_response_value", 'OK');
    }
}

add_action('admin_menu', 'wp_uptime_menu');
function wp_uptime_menu()
{
    add_menu_page('WP Uptime Settings', 'WP Uptime', 'manage_options', 'wp-uptime-settings', 'wp_uptime_settings_page');
}

function wp_uptime_settings_page()
{
    $url = get_rest_url(null, 'wp-uptime/' . get_option_or_value("wp_uptime_endpoint_path", 'ok') . '/');


    ?>
    <div class="wrap">
        <h1>WP Uptime Settings</h1>
        <h3>
            Editable non-cached monitorization path for Wordpress
        </h3>
        <p>Monitorization path: <a href="<?php echo $url ?>" target="_blank"><?php echo $url ?></a></p>
        <form method="post" action="options.php">
            <?php settings_fields('wp_uptime_settings'); ?>
            <?php do_settings_sections('wp-uptime-settings'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Endpoint path</th>
                    <td><input type="text" name="wp_uptime_endpoint_path"
                            value="<?php echo esc_attr(get_option_or_value('wp_uptime_endpoint_path', 'ok')); ?>"></td>
                </tr>
                <tr valign="top">
                    <th scope="row">OK response value</th>
                    <td>
                        <?php echo "<textarea name='wp_uptime_response_value'>" . esc_attr(get_option_or_value('wp_uptime_response_value', 'OK')) . '</textarea>'; ?>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

add_action('admin_init', 'wp_uptime_settings');

function wp_uptime_settings()
{
    register_setting('wp_uptime_settings', 'wp_uptime_endpoint_path');
    register_setting('wp_uptime_settings', 'wp_uptime_response_value');
}