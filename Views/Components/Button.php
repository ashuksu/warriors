<?php
namespace Views\Components;

class Button {
    /**
     * Renders a button using an anchor tag with configurable options
     *
     * @param array{
     *     url?: string,
     *     class?: string,
     *     attr?: string,
     *     content?: string
     * } $options Button configuration
     *
     * @return void Echoes HTML button
     */
    public static function render($options = []) {
        // default params
        $url = $options['url'] ?? '#';
        $class = $options['class'] ?? '';
        $attr = $options['attr'] ?? '';
        $content = $options['content'] ?? '';
        $button_html = '<a href="' . $url . '" class="button ' . $class . '" ' . $attr . '>';
        $button_html .= $content . '</a>';

        echo $button_html;
    }
}