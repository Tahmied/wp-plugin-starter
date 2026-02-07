<?php
if (! defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// delete options
delete_option('my_option_name');
// drop custom tables - use $wpdb to drop if you created them
global $wpdb;
$table = $wpdb->prefix . 'my_custom';
$wpdb->query("DROP TABLE IF EXISTS {$table}");
