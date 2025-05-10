<?php

namespace AdminCustomisimple\Admin;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Customizer
{
    private $ac_options;

    public function init()
    {
        // Initialize the options
        $this->ac_options = get_option('ac_options');
        // Add actions and filters here
        add_action('admin_footer', [$this, 'collapse_menu']);
        add_action('admin_bar_menu', [$this, 'remove_wp_admin_bar_menu'], 999);
        add_filter('admin_footer_text', [$this, 'modify_footer'], 10);
        add_filter('update_footer', [$this, 'remove_wordpress_version_text'], 20);
    }

    public function collapse_menu()
    {
        if (!isset($this->ac_options['collapse_menu']) || $this->ac_options['collapse_menu'] != 1) {
            return; // Do not collapse if the option is not set
        }

        // Collapse the menu for all other admin pages
        echo '<script id="customisimple-collapse-menu">
            document.addEventListener("DOMContentLoaded", function() {
                const body = document.body;
                if (!body.classList.contains("folded")) {
                    body.classList.add("folded");
                }
            });
        </script>';
    }

    public function remove_wp_admin_bar_menu($wp_admin_bar)
    {
        if (!isset($this->ac_options['remove_wp_menu']) || $this->ac_options['remove_wp_menu'] != 1) {
            return; // Do not remove the WP logo if the option is not set
        }

        // Remove the WordPress menu from the admin bar
        $wp_admin_bar->remove_node('wp-logo');
    }

    public function modify_footer($text)
    {
        if (!isset($this->ac_options['footer_text']) || trim($this->ac_options['footer_text']) != '') {
            return $text; // Do not modify the footer text if the option is not set
        }

        $text = wp_kses_post($this->ac_options['footer_text']); // Sanitize the custom footer text

        return $text;
    }

    public function remove_wordpress_version_text($text)
    {
        $noneed_to_remove = !isset($this->ac_options['remove_wp_version_text']) || $this->ac_options['remove_wp_version_text'] != 1;

        return $noneed_to_remove ? $text : ''; // Remove the WordPress version text if the option is set
    }
}
