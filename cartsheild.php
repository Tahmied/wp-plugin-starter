<?php

/**
 * Plugin Name:       Cartsheild
 * Plugin URI:        https://cartcarebd.com
 * Description:       Production grade plugin skeleton.
 * Version:           1.0.0
 * Requires PHP:      8.1
 * Author:            Tahmied Hossain
 * Text Domain:       cartsheild
 * Domain Path:       /languages
 */

// Security
if (! defined('ABSPATH')) {
    exit;
}

// Define constants
define('MY_PLUGIN_VERSION', '1.0.0');
define('MY_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('MY_PLUGIN_URL', plugin_dir_url(__FILE__));
define('MY_PLUGIN_FILE', __FILE__);

// Composer autoload
if (file_exists(MY_PLUGIN_DIR . 'vendor/autoload.php')) {
    require_once MY_PLUGIN_DIR . 'vendor/autoload.php';
}

// Activation / deactivation
register_activation_hook(MY_PLUGIN_FILE, ['\MyPlugin\Activator', 'activate']);
register_deactivation_hook(MY_PLUGIN_FILE, ['\MyPlugin\Deactivator', 'deactivate']);

// Boot core
function cart_sheild()
{
    $plugin = new \MyPlugin\Core();
    $plugin->run();
}
cart_sheild();
