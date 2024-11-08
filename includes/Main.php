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
        $config = new Config($this->pluginFile);
        $default_attributes = $config::getDefaultAttributes();
        $shortcode = new Shortcode($default_attributes);
        $blockeditor = new BlockEditor($default_attributes);
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
            plugin_dir_url($this->pluginFile) . 'assets/js/random-bark.js',
            ['jquery'],
            $this->pluginVersion,
            true
        );

        wp_register_style(
            'lenny-frontend-style',
            plugins_url('build/hello-lenny/style-index.css', plugin_basename($this->pluginFile)),
            [],
            $this->pluginVersion
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
