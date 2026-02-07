<?php

namespace Cartcarebd\Cartsheild\Admin;

class Admin
{
    private string $plugin_name;
    private string $version;

    public function __construct(string $plugin_name, string $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        // Note: We removed the 'save_settings' action because React handles data differently
    }

    public function register_menu()
    {
        add_menu_page(
            'CartSheild',
            'CartSheild',
            'manage_options',
            'cartsheild',
            [$this, 'render_admin_page'],
            'dashicons-shield',
            56
        );
    }

    public function render_admin_page()
    {
        // 1. Output a test message to prove PHP is running
        echo '<h1>DEBUG MODE: The Container Should Be Below</h1>';

        // 2. Output the React Container
        echo '<div id="cartsheild-admin-app"></div>';

        // 3. Output a hidden timestamp so we know if the file updated
        echo '';
    }

    public function enqueue_assets($hook)
    {
        // 1. Safety check
        $asset_file = CARTSHEILD_DIR . 'build/index.asset.php';
        if (!file_exists($asset_file)) {
            return;
        }

        // 2. Include the asset file
        $asset = include $asset_file;

        // 3. FORCE the dependency manually
        // We add 'wp-element' (which is WordPress's version of React)
        // We add 'wp-i18n' (for translations)
        $dependencies = array_merge($asset['dependencies'], ['wp-element', 'wp-i18n']);

        // 4. Enqueue with the fixed dependencies
        wp_enqueue_script(
            'cartsheild-admin-script',
            CARTSHEILD_URL . 'build/index.js',
            $dependencies, // <--- USING OUR FORCED LIST
            $asset['version'],
            true
        );

        // 5. Enqueue CSS
        if (file_exists(CARTSHEILD_DIR . 'build/index.css')) {
            wp_enqueue_style(
                'cartsheild-admin-style',
                CARTSHEILD_URL . 'build/index.css',
                [],
                $asset['version']
            );
        }

        // 6. Load Translations
        wp_set_script_translations('cartsheild-admin-script', 'cartsheild', CARTSHEILD_DIR . 'languages');
    }
}
