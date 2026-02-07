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
        // Updated action name to match your plugin slug
        add_action('admin_post_cartsheild_save_settings', [$this, 'save_settings']);
    }

    public function save_settings()
    {
        // Nonce check
        if (
            ! isset($_POST['cartsheild_nonce']) ||
            ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['cartsheild_nonce'])), 'cartsheild_save_action')
        ) {
            wp_die(esc_html__('Security check failed', 'cartsheild'));
        }

        if (!current_user_can('manage_options')) {
            return;
        }

        $value = isset($_POST['cartsheild_option_name'])
            ? sanitize_text_field(wp_unslash($_POST['cartsheild_option_name']))
            : '';

        update_option('cartsheild_option_name', $value);

        wp_redirect(admin_url('admin.php?page=cartsheild&saved=1'));
        exit;
    }

    public function register_menu()
    {
        add_menu_page(
            'CartSheild',
            'CartSheild',
            'manage_options',
            'cartsheild', // Page slug
            [$this, 'render_admin_page'],
            'dashicons-shield', // Better icon
            56
        );
    }

    public function render_admin_page()
    {
        // Better Practice: In a real app, move this HTML to src/Admin/partials/admin-display.php
?>
        <div class="wrap">
            <h1><?php esc_html_e('CartSheild Settings', 'cartsheild'); ?></h1>

            <?php if (isset($_GET['saved'])) : ?>
                <div class="updated">
                    <p><?php esc_html_e('Saved!', 'cartsheild'); ?></p>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <input type="hidden" name="action" value="cartsheild_save_settings">
                <?php wp_nonce_field('cartsheild_save_action', 'cartsheild_nonce'); ?>

                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="cartsheild_option_name"><?php esc_html_e('Example Setting', 'cartsheild'); ?></label></th>
                        <td>
                            <input type="text" id="cartsheild_option_name" name="cartsheild_option_name" value="<?php echo esc_attr(get_option('cartsheild_option_name', '')); ?>" class="regular-text">
                        </td>
                    </tr>
                </table>

                <?php submit_button(); ?>
            </form>
        </div>
<?php
    }

    public function enqueue_assets($hook)
    {
        if ($hook !== 'toplevel_page_cartsheild') {
            return;
        }

        $asset_file = CARTSHEILD_DIR . 'build/index.asset.php';
        $script_path = CARTSHEILD_URL . 'build/index.js';

        if (file_exists($asset_file)) {
            $asset = include $asset_file;
            wp_enqueue_script(
                $this->plugin_name . '-admin',
                $script_path,
                $asset['dependencies'],
                $asset['version'],
                true
            );
            wp_set_script_translations($this->plugin_name . '-admin', 'cartsheild', CARTSHEILD_DIR . 'languages');
        }
    }
}
