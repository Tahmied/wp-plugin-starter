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

// Define constants (Renamed to be specific to your plugin)
define('CARTSHEILD_VERSION', '1.0.0');
define('CARTSHEILD_DIR', plugin_dir_path(__FILE__));
define('CARTSHEILD_URL', plugin_dir_url(__FILE__));
define('CARTSHEILD_FILE', __FILE__);

// Composer autoload
if (file_exists(CARTSHEILD_DIR . 'vendor/autoload.php')) {
    require_once CARTSHEILD_DIR . 'vendor/autoload.php';
}

// Activation / deactivation (FIXED NAMESPACES)
register_activation_hook(CARTSHEILD_FILE, ['\Cartcarebd\Cartsheild\Activator', 'activate']);
register_deactivation_hook(CARTSHEILD_FILE, ['\Cartcarebd\Cartsheild\Deactivator', 'deactivate']);

// Boot core
function run_cart_sheild()
{
    $plugin = new \Cartcarebd\Cartsheild\Core();
    $plugin->run();
}
run_cart_sheild();
