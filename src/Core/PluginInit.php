<?php

namespace AdminCustomisimple\Core;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use AdminCustomisimple\Core\PluginSetup;
use AdminCustomisimple\Admin\Customizer;

class PluginInit
{
    public function init()
    {
        $plugin_setup = new PluginSetup();
        $plugin_setup->init();
    }

    public function run_customizer()
    {
        $customizer = new Customizer();
        $customizer->init();
    }
}