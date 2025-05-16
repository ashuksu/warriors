<?php
/**
 * Button component
 * 
 * This file provides the render_button function for rendering configurable anchor-based buttons.
 */

/**
 * Renders a button with the specified configuration
 * 
 * @param array $config Button configuration
 * @param string $config['url'] The URL for the button
 * @param string $config['text'] The text to display on the button (optional)
 * @param string $config['class'] Additional CSS classes for the button (optional)
 * @param string $config['attr'] Additional HTML attributes for the button (optional)
 * @param string $config['icon'] Icon to display in the button (optional)
 * @return void
 */
function render_button($config) {
    // Default values
    $url = $config['url'] ?? '#';
    $text = $config['text'] ?? '';
    $class = $config['class'] ?? '';
    $attr = $config['attr'] ?? '';
    $icon = $config['icon'] ?? '';
    
    // Build the button HTML
    $buttonHtml = '<a href="' . $url . '" class="button ' . $class . '" ' . $attr . '>';
    
    if ($icon) {
        $buttonHtml .= '<span class="button__icon">' . $icon . '</span>';
    }
    
    if ($text) {
        $buttonHtml .= '<span class="button__text">' . $text . '</span>';
    }
    
    $buttonHtml .= '</a>';
    
    // Output the button HTML
    echo $buttonHtml;
}