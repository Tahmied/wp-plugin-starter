<?php

namespace Cartcarebd\Cartsheild;

use Cartcarebd\Cartsheild\Admin\Admin;
use Cartcarebd\Cartsheild\Public\FrontEnd;
use Cartcarebd\Cartsheild\Api\Routes;

class Core
{
    protected Loader $loader;
    protected string $plugin_name;
    protected string $version;

    public function __construct()
    {
        $this->plugin_name = 'cartsheild'; // Standardized slug
        $this->version = CARTSHEILD_VERSION; // Updated Constant
        $this->loader = new Loader();

        $this->define_admin_hooks();
        $this->define_public_hooks();
        $this->define_rest_api();
    }

    private function define_admin_hooks()
    {
        $admin = new Admin($this->plugin_name, $this->version);
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
        // Ensure you have created src/Api/Routes.php with correct namespace!
        $this->loader->add_action('rest_api_init', new Routes(), 'register_routes');
    }

    public function run()
    {
        $this->loader->run();
    }
}
