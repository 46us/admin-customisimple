<?php

namespace AdminCustomisimple\Core;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class SettingsFieldBuilder
{
    public function create_field($type, $id, $label, $description = '')
    {
        $args = [
            'type' => $type,
            'id' => $id,
            'label_for' => $id,
        ];

        if ($description) {
            $args['description'] = $description;
        }

        add_settings_field(
            $id,
            $label,
            [$this, 'render_field'],
            'admin_customisimple',
            'simple_customizer_main_section',
            $args
        );
    }

    public function render_field($args)
    {
        if (!isset($args['type']) || $args['type'] === '') {
            return;
        }

        switch ($args['type']) {
            case 'text':
            case 'checkbox':
                $this->render_input_field($args);
                break;
            case 'textarea':
                $this->render_textarea_field($args);
                break;
        }
    }

    public function render_input_field($args)
    {
        $value = get_option('ac_options');
    
        $input = '<input type="' . esc_attr($args['type']) . '" id="' . esc_attr($args['id']) . '" name="ac_options[' . esc_attr($args['id']) . ']" ';

        // Filter whether to add "value" attribute or "checked" attribute, based on field type
        if ($args['type'] === 'checkbox') {
            $checkbox_value = isset($value[$args['id']]) ?? 0;
            $input .= 'value="1" ' . checked($checkbox_value, 1, false);
        } else {
            $text_value = isset($value[$args['id']]) ?? '';
            $input .= 'value="' . esc_attr($text_value) . '"';
        }

        $input .= ' />';

        // Render description if provided
        if (isset($args['description']) && $args['description'] !== '') {
            $input .= '<p class="description">' . esc_html($args['description']) . '</p>';
        }

        echo $input;
    }

    public function render_textarea_field($args)
    {
        $value = get_option('ac_options')[$args['id']];
        $input = '<textarea id="' . esc_attr($args['id']) . '" name="ac_options[' . esc_attr($args['id']) . ']" rows="5" cols="50">' . esc_textarea($value) . '</textarea>';
        // Render description if provided
        if (isset($args['description']) && $args['description'] !== '') {
            $input .= '<p class="description">' . esc_html($args['description']) . '</p>';
        }
        echo $input;
    }
}
