<?php
if (!function_exists('render_button')) {
    /**
     * Get HTML markup for a button.
     *
     * This function generates HTML markup for a button element based on the provided options.
     *
     * @param array $options An associative array containing options for the button:
     *                      - 'url' (string): The URL the button should link to. Default is '#'.
     *                      - 'class' (string): Additional CSS classes for the button. Default is ''.
     *                         $class = 'button--close'; $class = 'button--menu' with $content = '<i></i>'
     *                      - 'attr' (string): Additional HTML attributes for the button. Default is ''.
     *                      - 'content' (string): The content/text of the button. Default is ''.
     *
     * @return string The HTML markup for the button.
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
