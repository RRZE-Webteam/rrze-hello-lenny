<?php

namespace RRZE\HelloLenny;

/**
 * Plugin Name:     RRZE Hello Lenny
 * Plugin URI:      https://github.com/RRZE-Webteam/rrze-hello-lenny/
 * Description:     A plugin inspired by Hello Dolly, using both a shortcode and a Gutenberg block.
 * Version: 1.1.3
 * Requires at least: 6.6
 * Requires PHP:      8.2
 * Author:          RRZE Webteam
 * Author URI:      https://blogs.fau.de/webworking/
 * License:         GNU General Public License v2
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.html
 * Domain Path:     /languages
 * Text Domain:     rrze-hello-lenny
 */


defined('ABSPATH') || exit;

// Plugin requirements
const REQUIRED_PHP_VERSION = '8.2';
const REQUIRED_WP_VERSION = '6.6';

// Autoload classes
spl_autoload_register(function ($class) {
    $prefix = __NAMESPACE__;
    $base_dir = __DIR__ . '/includes/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});


// Activation and deactivation hooks
register_activation_hook(__FILE__, __NAMESPACE__ . '\activate');
register_deactivation_hook(__FILE__, __NAMESPACE__ . '\deactivate');

// Loaded action hook
add_action('plugins_loaded', __NAMESPACE__ . '\onLoaded');

/**
 * Load text domain for translations.
 */
function loadTextDomain()
{
    load_plugin_textdomain('rrze-hello-lenny', false, dirname(plugin_basename(__FILE__)) . '/languages');
}

/**
 * Check system requirements.
 */
function system_requirements()
{
    $error = '';
    if (version_compare(PHP_VERSION, REQUIRED_PHP_VERSION, '<')) {
        /* translators: 1: current PHP version, 2: required PHP version */
        $error = sprintf(__('The server is running PHP version %1$s. The Plugin requires at least PHP version %2$s.', 'rrze-typesettings'), PHP_VERSION, RRZE_PHP_VERSION);
    } elseif (version_compare($GLOBALS['wp_version'], REQUIRED_WP_VERSION, '<')) {
        /* translators: 1: current WordPress version, 2: required WordPress version */
        $error = sprintf(__('The server is running WordPress version %1$s. The Plugin requires at least WordPress version %2$s.', 'rrze-typesettings'), $GLOBALS['wp_version'], RRZE_WP_VERSION);
    }
    return $error;
}

/**
 * Activation hook.
 */
function activate()
{
    // Load text domain
    loadTextDomain();

    // Check system requirements
    if ($error = system_requirements()) {
        deactivate_plugins(plugin_basename(__FILE__));
        wp_die(esc_html($error));
    }

    // Other activation tasks can be added here, e.g., flush rewrite rules
}

/**
 * Deactivation hook.
 */
function deactivate()
{
    // Any deactivation tasks can be added here
}

/**
 * Main plugin loaded function.
 */
function onLoaded()
{
    // Load text domain
    loadTextDomain();

    // Check system requirements
    if ($error = system_requirements()) {
        $pluginName = get_plugin_data(__FILE__)['Name'];
        $tag = is_network_admin() ? 'network_admin_notices' : 'admin_notices';
        add_action($tag, function () use ($pluginName, $error) {
            printf('<div class="notice notice-error"><p>%1$s: %2$s</p></div>', esc_html($pluginName), esc_html($error));
        });
        return;
    }

    // Initialize the main plugin class
    $main = new Main(__FILE__);
    $main->onLoaded();
}
