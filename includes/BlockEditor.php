<?php

namespace RRZE\HelloLenny;

defined('ABSPATH') || exit;

class BlockEditor
{
    protected $defaultAttributes;

    public function __construct($defaultAttributes)
    {
        $this->defaultAttributes = $defaultAttributes;
        add_action('init', [$this, 'registerBlock']);
        add_action('enqueue_block_assets', [$this, 'enqueueBlockAssets']);
    }

    public function registerBlock()
    {
        register_block_type('lenny/quote-block', [
            'editor_script' => 'lenny-block-editor-script',
            'editor_style' => 'lenny-block-editor-style',
            'style' => 'lenny-block-style',
            'render_callback' => [$this, 'renderBlock']
        ]);
    }

    public function enqueueBlockAssets()
    {
        if (!is_admin()) {
            wp_enqueue_style('lenny-block-style');
        }
    }

    public function renderBlock($attributes)
    {
        // Sanitize attributes
        $attributes['css_classes'] = !empty($attributes['cssClasses']) ? sanitize_hex_color($attributes['cssClasses']) : '';
        $attributes['background_color'] = !empty($attributes['backgroundColor']) ? sanitize_hex_color($attributes['backgroundColor']) : '';
        $attributes['border_color'] = !empty($attributes['borderColor']) ? sanitize_hex_color($attributes['borderColor']) : '';
    
        wp_enqueue_script('lenny-random-bark');

        return Shortcode::generateWuffOutput($attributes);
    }
}
