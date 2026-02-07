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
        add_action('admin_post_cartsheild_save_settings', [$this, 'save_settings']);
    }

    public function save_settings()
    {

        // Nonce check
        if (
            ! isset($_POST['my_plugin_nonce']) ||
            ! wp_verify_nonce(
                sanitize_text_field(wp_unslash($_POST['my_plugin_nonce'])),
                'my_plugin_save_action'
            )
        ) {
            wp_die(esc_html__('Security check failed', 'my-professional-plugin'));
        }

        // Permission check
        if (!current_user_can('manage_options')) {
            return;
        }

        // Sanitize
        $value = isset($_POST['my_option_name'])
            ? sanitize_text_field(wp_unslash($_POST['my_option_name']))
            : '';

        update_option('my_option_name', $value);

        wp_redirect(admin_url('admin.php?page=my-plugin&saved=1'));
        exit;
    }


    public function register_menu()
    {
        add_menu_page(
            'My Plugin',
            'My Plugin',
            'manage_options',
            'my-plugin',
            [$this, 'render_admin_page'],
            'dashicons-admin-generic',
            56
        );
    }

    public function render_admin_page()
    {
?>
        <div class="wrap">
            <h1><?php esc_html_e('My Plugin Settings', 'my-professional-plugin'); ?></h1>

            <?php if (isset($_GET['saved'])) : ?>
                <div class="updated">
                    <p>Saved!</p>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <input type="hidden" name="action" value="my_plugin_save_settings">

                <?php wp_nonce_field('my_plugin_save_action', 'my_plugin_nonce'); ?>

                <input
                    type="text"
                    name="my_option_name"
                    value="<?php echo esc_attr(get_option('my_option_name', '')); ?>">

                <?php submit_button(); ?>
            </form>
        </div>
<?php
    }


    public function enqueue_assets($hook)
    {
        // Only load assets on our page
        if ($hook !== 'toplevel_page_my-plugin') {
            return;
        }

        $asset_file = MY_PLUGIN_DIR . 'build/index.asset.php';
        $script_path = MY_PLUGIN_URL . 'build/index.js';

        if (file_exists($asset_file)) {
            $asset = include $asset_file;
            wp_enqueue_script(
                $this->plugin_name . '-admin',
                $script_path,
                $asset['dependencies'],
                $asset['version'],
                true
            );
            wp_set_script_translations($this->plugin_name . '-admin', 'my-professional-plugin', MY_PLUGIN_DIR . 'languages');

            // enqueue admin stylesheet if exists
            if (file_exists(MY_PLUGIN_DIR . 'build/style-index.css')) {
                wp_enqueue_style(
                    $this->plugin_name . '-admin-style',
                    MY_PLUGIN_URL . 'build/style-index.css',
                    [],
                    $this->version
                );
            }
        }
    }
}
