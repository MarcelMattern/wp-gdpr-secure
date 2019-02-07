<?php
/*
Plugin Name: DSGVO/GDPR Secure
Plugin URI: https://www.coffee-code.de
Description: Silence
Author: Marcel Mattern
Author URI: https://www.coffee-code.de
Version: 0.1
 */

define( 'GDPR_PATH', plugin_dir_path( __FILE__ ) );

class DSGVO_GDPR
{
    /**
     * Construct the plugin object
     */
    public function __construct()
    {
        add_action('admin_init', array(&$this, 'admin_init'));
        add_action('admin_menu', array(&$this, 'add_menu'));
        add_action('wp_enqueue_scripts', array(&$this, 'gdpr_scripts_styles'));
    }

    /**
     * Activate the plugin
     */
    public static function activate()
    {
           //add_action('admin_notices', 'activate_notice');
        new DSGVO_Message("DSGVO/GDPR wurde aktiviert, DANKESCHÖN!");
    }

    /**
     * Deactivate the plugin
     */
    public static function deactivate()
    {
            // Do nothing
    }

    public function admin_init()
    {
        $this->init_settings();
    }

    public function init_settings()
    {
        $args = array(
            'type' => 'string', 
            'sanitize_callback' => 'sanitize_text_field',
            'default' => NULL,
        );
        $args2 = array(
            'type' => 'string', 
            'sanitize_callback' => 'sanitize2_text_field',
            'default' => NULL,
        );
        $args3 = array(
            'type' => 'string', 
            'sanitize_callback' => 'sanitize3_text_field',
            'default' => NULL,
        );
        $args4 = array(
            'type' => 'string', 
            'sanitize_callback' => 'sanitize4_text_field',
            'default' => NULL,
        );
        
        register_setting('dsgvo_gdpr-group', 'warning_title');
        register_setting('dsgvo_gdpr-group', 'warning_text');
        register_setting('dsgvo_gdpr-group', 'warning_btn_text');
        register_setting('dsgvo_gdpr-group', 'yt_privacy_link');
        register_setting('dsgvo_gdpr-group', 'maps_privacy_link');
    }

    public function add_menu()
    {
        add_options_page('DSGVO/GDPR Settings', 'DSGVO/GDPR', 'manage_options', 'dsgvo_gdpr', array(&$this, 'plugin_settings_page'));
    }

    public function plugin_settings_page()
    {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }

        // Render the settings template
        include(sprintf("%s/templates/settings.php", dirname(__FILE__)));
    }

    public function gdpr_scripts_styles()
    {
        // Scripts
        wp_register_script('gdpr-dsgvo-secure', plugins_url('/dsgvo-gdpr-secure/assets/js/script.min.js'), array('jquery'), '', true);
        wp_enqueue_script('gdpr-dsgvo-secure');

        wp_register_script('gdpr-dsgvo-secure-user', plugins_url('/dsgvo-gdpr-secure/assets/js/script_edit.min.js'), array('jquery'), '', false);
        wp_enqueue_script('gdpr-dsgvo-secure-user');
        
        // Styles
        wp_register_style('gdpr-dsgvo-secure', plugins_url('/dsgvo-gdpr-secure/assets/css/gdpr.min.css'));
        wp_enqueue_style('gdpr-dsgvo-secure');
    }
}

class DSGVO_Message
{
    private $_message;

    function __construct($message)
    {
        $this->_message = $message;
        add_action('admin_notices', array(&$this, 'render'));
    }

    function render()
    {
        printf('<div class="updated">%s</div>', $this->_message);
    }
}

// Installation and uninstallation hooks
//register_activation_hook(__FILE__, array('DSGVO_GDPR', 'activate'));
//register_deactivation_hook(__FILE__, array('DSGVO_GDPR', 'deactivate'));

// instantiate the plugin class
$DSGVO_GDPR = new DSGVO_GDPR();

if (isset($DSGVO_GDPR)) {
    // Add the settings link to the plugins page
    function plugin_settings_link($links)
    {
        $settings_link = '<a href="options-general.php?page=dsgvo_gdpr&tab=ga">Settings</a>';
        array_unshift($links, $settings_link);
        return $links;
    }

    $plugin = plugin_basename(__FILE__);
    add_filter("plugin_action_links_$plugin", 'plugin_settings_link');
}