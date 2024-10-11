<?php

namespace RRZE\HelloLenny;

defined('ABSPATH') || exit;

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

    /**
     * The version of the plugin.
     * @var string
     */
    protected $pluginVersion;    

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
        $this->setPluginVersion();

        add_action('init', [$this, 'registerAssets']);
        add_action('enqueue_block_assets', [$this, 'enqueueAssets']);

        // Initialize Shortcode and BlockEditor
        new Shortcode($this->pluginFile);
        new BlockEditor($this->pluginFile);
    }

    /**
     * Set the version of the plugin.
     * @return string The version of the plugin
     */
    protected function setPluginVersion()
    {
        $pluginData = get_file_data($this->pluginFile, ['Version' => 'Version'], false);
        $this->pluginVersion = $pluginData['Version'] ?? '1.0.0';
    }    

    /**
     * Register assets.
     */
    public function registerAssets()
    {
        // Register scripts and styles
        wp_register_script(
            'lenny-random-bark',
            plugins_url('src/js/random-bark.js', plugin_basename($this->pluginFile)),
            ['jquery'],
            filemtime(plugin_dir_path($this->pluginFile) . 'src/js/random-bark.js') ?: $this->pluginVersion,
            true
        );

        wp_register_style(
            'lenny-frontend-style',
            plugins_url('build/frontend.css', plugin_basename($this->pluginFile)),
            [],
            filemtime(plugin_dir_path($this->pluginFile) . 'build/frontend.css') ?: $this->pluginVersion
        );

        wp_register_script(
            'lenny-block-editor-script',
            plugins_url('build/block.js', plugin_basename($this->pluginFile)),
            ['wp-blocks', 'wp-element', 'wp-editor'],
            filemtime(plugin_dir_path($this->pluginFile) . 'build/block.js') ?: $this->pluginVersion,
            true
        );

        wp_register_style(
            'lenny-block-editor-style',
            plugins_url('build/editor.css', plugin_basename($this->pluginFile)),
            [],
            filemtime(plugin_dir_path($this->pluginFile) . 'build/editor.css') ?: $this->pluginVersion
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
