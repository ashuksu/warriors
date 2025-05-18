<?php
if (!function_exists('render_button')) {
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
     *
     * @example
     * render_button([
     *     'url' => '#section',
     *     'class' => 'button--primary',
     *     'attr' => 'data-element="toggle"',
     *     'content' => 'Read more'
     * ]);
     */
    function render_button($options)
    {
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
?>
