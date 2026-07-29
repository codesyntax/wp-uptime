<?php
/**
 * WP Uptime
 *
 * @package     WP Uptime
 * @author      CodeSyntax
 * @copyright   2023 CodeSyntax
 * @license     GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name: WP Uptime
 * Plugin URI:  https://github.com/codesyntax/wp-uptime
 * Description: Editable non-cached monitorization path for Wordpress.
 * Version:     3.0.3
 * Author:      CodeSyntax
 * Author URI:  https://codesyntax.com
 * Text Domain: wp-uptime
 * License:     GPL v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Handle the request directly.
 * By using 'init' at priority 0, we bypass redirects and feed processing.
 */
add_action('init', 'wpuptime_handle_request', 0);
function wpuptime_handle_request()
{
    $endpoint = get_option('wp_uptime_endpoint_path', 'ok');
    if (empty($endpoint)) {
        $endpoint = 'ok';
    }

    // Get the requested path
    $request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $request_path = trim($request_uri, '/');

    /**
     * Check if the path matches our endpoint.
     * We check for:
     * 1. Exact match (e.g., trans.eus/ok)
     * 2. Language-prefixed match (e.g., trans.eus/es/ok, trans.eus/eu/ok)
     */
    $is_match = false;
    if ($request_path === $endpoint) {
        $is_match = true;
    } elseif (preg_match('/^[a-z]{2}\/' . preg_quote($endpoint, '/') . '$/', $request_path)) {
        $is_match = true;
    }

    if ($is_match) {
        include plugin_dir_path(__FILE__) . 'check-connection.php';
        exit;
    }
}

/**
 * Add admin menu.
 */
add_action('admin_menu', 'wpuptime_admin_menu');
function wpuptime_admin_menu()
{
    add_options_page(
        __('WP Uptime Settings', 'wp-uptime'),
        __('WP Uptime', 'wp-uptime'),
        'manage_options',
        'wp-uptime-settings',
        'wpuptime_settings_page'
    );
}

/**
 * Settings page content.
 */
function wpuptime_settings_page()
{
    if (!current_user_can('manage_options')) {
        return;
    }

    $endpoint = get_option('wp_uptime_endpoint_path', 'ok');
    $url = get_site_url(null, $endpoint);
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <h3>
            <?php esc_html_e('Editable non-cached monitorization path for Wordpress', 'wp-uptime'); ?>
        </h3>
        <p>
            <?php esc_html_e('Monitorization path:', 'wp-uptime'); ?> 
            <a href="<?php echo esc_url($url); ?>" target="_blank"><?php echo esc_url($url); ?></a>
        </p>
        <form method="post" action="options.php">
            <?php
            settings_fields('wp_uptime_settings_group');
            do_settings_sections('wp-uptime-settings');
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><?php esc_html_e('Endpoint path', 'wp-uptime'); ?></th>
                    <td>
                        <input type="text" name="wp_uptime_endpoint_path" value="<?php echo esc_attr($endpoint); ?>" class="regular-text">
                        <p class="description"><?php esc_html_e('The slug for your uptime check (e.g., "ok" or "status").', 'wp-uptime'); ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php esc_html_e('OK response value', 'wp-uptime'); ?></th>
                    <td>
                        <textarea name="wp_uptime_response_value" rows="5" cols="50" class="large-text"><?php echo esc_textarea(get_option('wp_uptime_response_value', 'OK')); ?></textarea>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

/**
 * Register settings.
 */
add_action('admin_init', 'wpuptime_register_settings');
function wpuptime_register_settings()
{
    register_setting('wp_uptime_settings_group', 'wp_uptime_endpoint_path', array(
        'sanitize_callback' => 'sanitize_title'
    ));
    register_setting('wp_uptime_settings_group', 'wp_uptime_response_value');
}

/**
 * Load text domain.
 */
add_action('init', 'wpuptime_load_textdomain');
function wpuptime_load_textdomain()
{
    load_plugin_textdomain('wp-uptime', false, dirname(plugin_basename(__FILE__)) . '/languages');
}

/**
 * Activation hook: No longer needs to flush rules.
 */
register_activation_hook(__FILE__, 'wpuptime_activate');
function wpuptime_activate() {
    // Keep for potential legacy cleanups, but no logic needed for direct intercept
}

/**
 * Uninstall hook.
 */
register_uninstall_hook(__FILE__, 'wpuptime_uninstall');
function wpuptime_uninstall()
{
    delete_option('wp_uptime_endpoint_path');
    delete_option('wp_uptime_response_value');
}
