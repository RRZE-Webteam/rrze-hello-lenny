<?php

namespace RRZE\HelloLenny;

defined('ABSPATH') || exit;

class Config
{
    protected $pluginFile;

    public function __construct($pluginFile)
    {
        $this->pluginFile = $pluginFile;
    }

    public static function getDefaultAttributes()
    {
        return [
            'css_classes' => '',
            'background_color' => '#ffffff',
            'border_color' => '#000000',
            'text_color' => '#000000'
        ];
    }
}
