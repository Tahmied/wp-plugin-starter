<?php

namespace MyPlugin\Public;

class FrontEnd
{
    private string $plugin_name;
    private string $version;

    public function __construct(string $plugin_name, string $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function enqueue_assets()
    {
        // Example: enqueue public CSS/JS if needed
        if (file_exists(MY_PLUGIN_DIR . 'public/css/public.css')) {
            wp_enqueue_style($this->plugin_name . '-public-style', MY_PLUGIN_URL . 'public/css/public.css', [], $this->version);
        }
    }
}
