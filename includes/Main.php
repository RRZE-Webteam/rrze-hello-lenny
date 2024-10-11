<?php

namespace RRZE\HelloLenny;

defined('ABSPATH') || exit;

use RRZE\HelloLenny\Config;
use RRZE\HelloLenny\Shortcode;
use RRZE\HelloLenny\BlockEditor;

/**
 * Main class
 */
class Main
{
    /**
     * The full path and file name of the plugin file.
     * @var string
     */
    protected $pluginFile;

    protected $settings;

    /**
     * Assign values to variables.
     * @param string $pluginFile Path and file name of the plugin file
     */
    public function __construct($pluginFile)
    {
        $this->pluginFile = $pluginFile;
    }

    /**
     * This method is called when the class is instantiated.
     */
    public function onLoaded()
    {
        add_action('init', [$this, 'registerAssets']);
        add_action('enqueue_block_assets', [$this, 'enqueueAssets']);

        // Initialize Shortcode and BlockEditor
        $config = new Config($this->pluginFile);
        $default_attributes = $config::getDefaultAttributes();
        $shortcode = new Shortcode($default_attributes);
        $blockeditor = new BlockEditor($default_attributes);
    }

    /**
     * Get the plugin version from the main plugin file.
     */
    protected function getPluginVersion()
    {
        $pluginData = get_file_data($this->pluginFile, ['Version' => 'Version'], false);
        return $pluginData['Version'] ?? '1.0.0';
    }

    /**
     * Register assets.
     */
    public function registerAssets()
    {
        $pluginVersion = $this->getPluginVersion();

        // Register scripts and styles
        wp_register_script(
            'lenny-random-bark',
            plugins_url('src/js/random-bark.js', plugin_basename($this->pluginFile)),
            ['jquery'],
            file_exists(plugin_dir_path($this->pluginFile) . 'src/js/random-bark.js') ? filemtime(plugin_dir_path($this->pluginFile) . 'src/js/random-bark.js') : $pluginVersion,
            true
        );

        wp_register_style(
            'lenny-frontend-style',
            plugins_url('build/frontend.css', plugin_basename($this->pluginFile)),
            [],
            file_exists(plugin_dir_path($this->pluginFile) . 'build/frontend.css') ? filemtime(plugin_dir_path($this->pluginFile) . 'build/frontend.css') : $pluginVersion
        );

        wp_register_script(
            'lenny-block-editor-script',
            plugins_url('build/block.js', plugin_basename($this->pluginFile)),
            ['wp-blocks', 'wp-element', 'wp-editor'],
            file_exists(plugin_dir_path($this->pluginFile) . 'build/block.js') ? filemtime(plugin_dir_path($this->pluginFile) . 'build/block.js') : $pluginVersion,
            true
        );

        wp_register_style(
            'lenny-block-editor-style',
            plugins_url('build/editor.css', plugin_basename($this->pluginFile)),
            [],
            file_exists(plugin_dir_path($this->pluginFile) . 'build/editor.css') ? filemtime(plugin_dir_path($this->pluginFile) . 'build/editor.css') : $pluginVersion
        );
    }

    /**
     * Enqueue assets.
     */
    public function enqueueAssets()
    {
        // Enqueue registered assets for block editor and frontend
        wp_enqueue_script('lenny-random-bark');
        wp_enqueue_style('lenny-frontend-style');
    }
}
