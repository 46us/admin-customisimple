<?php
/*
Plugin Name: Admin Customisimple
Description: A plugin to do simple customization of WordPress admin interface.
Version: 1.0
Author: Devagus
License: GPL2
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Autoload dependencies.
require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';

// Initialize the plugin.
use AdminCustomisimple\Core\PluginInit;

function admin_customisimple_init() {
    $plugin = new PluginInit();
    $plugin->init();
    $plugin->run_customizer();
}
add_action('plugins_loaded', 'admin_customisimple_init');
