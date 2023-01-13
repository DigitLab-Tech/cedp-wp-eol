<?php

namespace CEDP\WPEOL\App;

use CEDP\WPEOL\App\Views\SettingsView;
use CEDP\WPEOL\App\Controllers\AjaxAdminController;
use CEDP\WPEOL\App\Controllers\ShortcodeController;

class CEDPWpEoL
{
    protected SettingsView $settingsView;
    protected AjaxAdminController $ajaxAdminController;
    protected ShortcodeController $shortcodeController;

    public function __construct()
    {
        $this->settingsView = new SettingsView();
        $this->ajaxAdminController = new AjaxAdminController();
        $this->shortcodeController = new ShortcodeController();
        $this->start();
    }
 

    public function start()
    {
        add_action('admin_menu', [$this, 'add_setting_menu']);
        add_action('admin_init', [$this, 'register_settings']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue']);
        add_action('wp_ajax_endoflife_sync', [$this->ajaxAdminController, 'endoflife_sync']);
        add_shortcode('wpversion', [$this->shortcodeController, 'execute']);
        register_uninstall_hook(CEDP_WP_EOL_BASE_FILE, [get_called_class(), 'uninstall']);
    }

    public function add_setting_menu(){
        add_submenu_page(
            'options-general.php', 
            'CEDP WP EOL', 
            'CEDP WP EOL', 
            'manage_options', 
            'cedp_wp_eol', 
            [$this->settingsView, 'Render']
        );
    }

    public function enqueue_admin()
    {
        wp_enqueue_style('cedp-version-admin-css', CEDP_WP_EOL_URL . 'assets/css/admin-style.css', [], filemtime(CEDP_WP_EOL_PATH . '/assets/css/admin-style.css'), 'all');
        wp_enqueue_script('cedp-version-admin-js', CEDP_WP_EOL_URL . 'assets/js/admin-script.js', [], filemtime(CEDP_WP_EOL_PATH . '/assets/js/admin-script.js'), true);
    }

    public function enqueue(){
        wp_enqueue_style('cedp-version-css', CEDP_WP_EOL_URL . 'assets/css/style.css', [], filemtime(CEDP_WP_EOL_PATH . '/assets/css/style.css'), 'all');
    }

    public function register_settings() {
        register_setting('cedp_version_options', 'cedp_version_last_endoflife_sync_timestamp', [
            'type' => 'string',
            'default' => '',
        ]);

        register_setting('cedp_version_options', 'cedp_version_last_endoflife_sync_datetime', [
            'type' => 'string',
            'default' => '',
        ]);

        register_setting('cedp_version_options', 'cedp_version_endoflife_json', [
            'type' => 'string',
            'default' => '',
        ]);
    }

    public static function uninstall(){
        delete_option('cedp_version_last_endoflife_sync_timestamp');
        delete_option('cedp_version_last_endoflife_sync_datetime');
        delete_option('cedp_version_endoflife_json');
    }
}
