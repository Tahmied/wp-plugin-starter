<?php

namespace MyPlugin;

use MyPlugin\Admin\Admin;
use MyPlugin\Public\FrontEnd;

class Core
{

    protected Loader $loader;
    protected string $plugin_name;
    protected string $version;

    public function __construct()
    {
        $this->plugin_name = 'my-professional-plugin';
        $this->version = MY_PLUGIN_VERSION;
        $this->loader = new Loader();

        $this->define_admin_hooks();
        $this->define_public_hooks();
        $this->define_rest_api();
    }

    private function define_admin_hooks()
    {
        $admin = new Admin($this->plugin_name, $this->version);
        // Use loader to register hooks: pass instance and method name
        $this->loader->add_action('admin_menu', $admin, 'register_menu');
        $this->loader->add_action('admin_enqueue_scripts', $admin, 'enqueue_assets');
    }

    private function define_public_hooks()
    {
        $public = new FrontEnd($this->plugin_name, $this->version);
        $this->loader->add_action('wp_enqueue_scripts', $public, 'enqueue_assets');
    }

    private function define_rest_api()
    {
        // Example: hook to rest_api_init to register REST routes (create a class in includes/api)
        $this->loader->add_action('rest_api_init', new \MyPlugin\Api\Routes(), 'register_routes');
    }

    public function run()
    {
        $this->loader->run();
    }
}
