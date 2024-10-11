<?php

namespace RRZE\HelloLenny;

defined('ABSPATH') || exit;

class Shortcode
{

    protected $defaultAttributes;

    public function __construct($defaultAttributes)
    {
        $this->defaultAttributes = $defaultAttributes;
        add_shortcode('rrze-hello-lenny', [$this, 'renderShortcode']);
    }

    public function renderShortcode($attributes = [])
    {
        // Merge user-provided attributes with default values
        $attributes = shortcode_atts($this->defaultAttributes, $attributes);


        // Sanitize parameters
        $attributes['css_classes'] = sanitize_text_field($attributes['css_classes']);
        $attributes['background_color'] = sanitize_text_field($attributes['background_color']);
        $attributes['border_color'] = sanitize_text_field($attributes['border_color']);

        //         echo '<pre>';
        // var_dump($attributes);
        // exit;

        // Enqueue assets
        wp_enqueue_style('lenny-frontend-style');
        wp_enqueue_script('lenny-random-bark');

        // Generate the output
        return $this->generateWuffOutput($attributes);
    }

    public static function generateWuffOutput($attributes)
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
    
        // Add custom CSS classes
        $customClasses = !empty($attributes['css_classes']) ? esc_attr($attributes['css_classes']) : '';
    
        // Create the blockquote with custom styles
        $style = sprintf(
            'background-color: %s; border-color: %s;',
            esc_attr($attributes['background_color']),
            esc_attr($attributes['border_color'])
        );
    
        $output = sprintf('<blockquote class="rrze-hello-lenny %s" lang="%s" style="%s"><p>', $customClasses, esc_attr($lang), $style);
    
        for ($i = 0; $i < $numWuffs; $i++) {
            $randomIndex = array_rand($cssClasses);
            $classString = $cssClasses[$randomIndex];
            $output .= '<span class="' . esc_attr($classString) . '">' . esc_html(__('Wouf!', 'rrze-hello-lenny')) . '</span> ';
        }
    
        $output .= '</p><cite>&#128054; Lenny</cite></blockquote>';
    
        return $output;
    }
    }
