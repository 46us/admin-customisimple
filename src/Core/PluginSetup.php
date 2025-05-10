<?php

namespace AdminCustomisimple\Core;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use AdminCustomisimple\Core\SettingsFieldBuilder;

class PluginSetup
{
    private $settings_field_builder;

    public function __construct()
    {
        $this->settings_field_builder = new SettingsFieldBuilder();
    }

    /**
     * Initialize the plugin setup.
     */
    public function init()
    {
        // Add new submenu in Settings named Simple Customizer
        add_action('admin_menu', [ $this,'add_admin_menu'] );

        // Add settings section and fields
        add_action('admin_init', [ $this,'setting_init'] );
    }

    /**
     * Add a submenu under Tools for the Simple Customizer.
     */
    public function add_admin_menu()
    {
        add_management_page(
            'Simple Customizer', // Page title
            'Simple Customizer', // Menu title
            'manage_options',    // Capability
            'admin-customisimple', // Menu slug
            [$this, 'render_settings_page'] // Callback function
        );
    }

    /**
     * Initialize the creation of settings sections and form fields for the Simple Customizer setting page.
     */
    public function setting_init()
    {
        register_setting('admin_customisimple_group', 'ac_options');

        add_settings_section(
            'simple_customizer_main_section',
            'Custom Admin Settings',
            [$this, 'render_settings_section'],
            'admin_customisimple'
        );

        // Add setting field to collapse admin menu
        $this->settings_field_builder->create_field(
            'checkbox',
            'collapse_menu',
            'Collapse Admin Menu',
            'When you turn this setting ON, the admin manu will be collapsed by default.'
        );

        // Add setting field to remove WordPress menu from admin bar
        $this->settings_field_builder->create_field(
            'checkbox',
            'remove_wp_menu',
            'Remove WordPress Menu from Admin Bar',
            'Turn this setting ON to remove WordPress menu from the admin bar.'
        );

        // Add setting field to remove WordPress version text from footer
        $this->settings_field_builder->create_field(
            'checkbox',
            'remove_wp_version_text',
            'Remove WordPress Version Text from Footer',
            'Turn this setting ON to remove WordPress version text from the admin footer.'
        );

        // Add setting field to modify footer text
        $this->settings_field_builder->create_field(
            'textarea',
            'footer_text',
            'Modify Footer Text',
            'Enter your own text to replace the "Thank you for creating with WordPress" text in the admin footer. You can use HTML tags here.'
        );
    }

    public function render_settings_section()
    {
        // Render the settings section description here
        echo '<p>Bellow settings will change the looks of your admin page in some area.</p>';
    }

    public function render_settings_page()
    {
        // Check if the user has the required capability
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
            exit;
        }

        // Render the settings page content
        echo '<div class="wrap">';
        echo '<h1>Simple Customizer</h1>';
        echo '<p>Customize your site admin interface easily.</p>';
        echo $this->render_settings_form();
        echo '<div id="root"></div>';
        echo '</div>';
    }

    public function render_settings_form()
    {
        // Render the settings form here
        echo '<form method="post" action="options.php">';
        settings_fields('admin_customisimple_group');
        do_settings_sections('admin_customisimple');
        submit_button();
        echo '</form>';
    }
}