<?php
if (!function_exists('render_button')) {
    /**
     * Renders an HTML button using anchor tag.
     *
     * @param array $options {
     *     Button configuration options.
     *
     * @type string $url ID or URL for the button link (default: '#')
     * @type string $class CSS modifier classes. Base 'button' class is auto-included.
     *      Common modifiers: button--plus, button--close, button--menu,
     *      button--transparent (default: '')
     * @type string $attr Additional HTML attributes, e.g. data-button="toggle" (default: '')
     * @type string $content Button inner content - text or HTML (default: '')
     *
     * @example
     * render_button([
     *     'url' => 'faq-content-',
     *     'class' => 'button--plus button--transparent',
     *     'attr' => 'data-button="toggle"',
     *     'content' => 'Open'
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
