<?php

namespace MyPlugin;

class Activator
{
    public static function activate()
    {
        // Example: create DB tables or default options.
        if (! current_user_can('activate_plugins')) {
            return;
        }
        // Example default option
        add_option('my_plugin_installed', time());
        // Flush rewrite rules if needed
        flush_rewrite_rules();
    }
}
