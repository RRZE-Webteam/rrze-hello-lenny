<?php

namespace RRZE\HelloLenny;

/**
 * Plugin Name: RRZE Hello Lenny
 * Description: A plugin inspired by Hello Dolly, using both a shortcode and a Gutenberg block.
 * Version: 1.0
 * Requires at least: 6.6
 * Requires PHP:      8.2
 * Author:            RRZE-Webteam
 * Author URI:        https://blogs.fau.de/webworking/
 * License:           GNU General Public License v2
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.html
 * Domain Path:       /languages
 * Text Domain: rrze-hello-lenny
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Generate the output
function generate_wuff_output() {
    $lang = get_bloginfo('language');

    $numWuffs = rand(1, 4);

    $cssClasses = [
        'wuff-ucfirst',
        'wuff-uppercase',
        'wuff-lowercase',
        'wuff-small',
        'wuff-large',
        'wuff-xlarge'
    ];

    $output = '<blockquote class="rrze-hello-lenny" lang="' . esc_attr($lang) . '"><p>';

    for ($i = 0; $i < $numWuffs; $i++) {
        $selectedClasses = [];
        $numClasses = rand(1, count($cssClasses));

        $randomKeys = array_rand($cssClasses, $numClasses);
        if (is_array($randomKeys)) {
            foreach ($randomKeys as $key) {
                $selectedClasses[] = $cssClasses[$key];
            }
        } else {
            $selectedClasses[] = $cssClasses[$randomKeys];
        }

        $classString = implode(' ', $selectedClasses);

        $output .= '<span class="' . esc_attr($classString) . '">' . esc_html(__('Wouf!', 'rrze-hello-lenny')) . '</span> ';
        }

    $output .= '</p><cite>&#128054; Lenny</cite></blockquote>';

    return $output;
}

// Shortcode Functionality for Classic Editor
function lenny_shortcode()
{
    return generate_wuff_output();
}
add_shortcode('lenny_quote', __NAMESPACE__ . '\lenny_shortcode');

// Register Gutenberg Block for Block Editor
function lenny_block_register_block()
{
    load_plugin_textdomain('rrze-hello-lenny', false, dirname(plugin_basename(__FILE__)) . '/languages');

    if (! is_admin()) {
        wp_register_style(
            'lenny-block-style',
            plugins_url('build/frontend.css', __FILE__),
            [],
            filemtime(plugin_dir_path(__FILE__) . 'build/frontend.css')
        );
    }

    if (! function_exists('register_block_type')) {
        return;
    }

    wp_register_script(
        'lenny-block-editor-script',
        plugins_url('build/block.js', __FILE__),
        ['wp-blocks', 'wp-element', 'wp-editor'],
        filemtime(plugin_dir_path(__FILE__) . 'build/block.js'),
        true        
    );

    wp_register_style(
        'lenny-block-editor-style',
        plugins_url('build/editor.css', __FILE__),
        [],
        filemtime(plugin_dir_path(__FILE__) . 'build/editor.css')
    );

    register_block_type('lenny/quote-block', [
        'editor_script' => 'lenny-block-editor-script',
        'editor_style' => 'lenny-block-editor-style',
        'style' => 'lenny-block-style',
        'render_callback' => __NAMESPACE__ . '\lenny_block_render_callback',
    ]);
}
add_action('init', __NAMESPACE__ . '\lenny_block_register_block');

// Server-side Rendering of the Block
function lenny_block_render_callback($attributes)
{
    return generate_wuff_output();
}
