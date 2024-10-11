<?php

namespace RRZE\HelloLenny;

defined('ABSPATH') || exit;

class Shortcode
{
    public function __construct($pluginFile)
    {
        add_shortcode('rrze-hello-lenny', [$this, 'renderShortcode']);
    }

    public function renderShortcode()
    {
        // Enqueue assets
        wp_enqueue_style('lenny-frontend-style');
        wp_enqueue_script('lenny-random-bark');

        return $this->generateWuffOutput();
    }

    public static function generateWuffOutput()
    {
        $lang = get_bloginfo('language');
        $numWuffs = rand(1, 4);
    
        $cssClasses = [
            'wouf-ucfirst',
            'wouf-uppercase',
            'wouf-lowercase',
            'wouf-small',
            'wouf-large',
            'wouf-xlarge'
        ];
    
        $output = '<blockquote class="rrze-hello-lenny" lang="' . esc_attr($lang) . '"><p>';
    
        for ($i = 0; $i < $numWuffs; $i++) {
            // Randomly select one CSS class
            $randomIndex = array_rand($cssClasses);
            $classString = $cssClasses[$randomIndex];
        
            // Create the "Wouf!" span with the selected class
            $output .= '<span class="' . esc_attr($classString) . '">' . esc_html(__('Wouf!', 'rrze-hello-lenny')) . '</span> ';
        }
    
        $output .= '</p><cite>&#128054; Lenny</cite></blockquote>';
    
        return $output;
    }
    }
