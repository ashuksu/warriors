<?php
if (!function_exists('render_button')) {
    /**
     * Get HTML markup for a button.
     *
     * This function generates HTML markup for a button element based on the provided options.
     *
     * @param array $options An associative array containing options for the button:
     *                      - 'button_url' (string): The URL the button should link to. Default is '#'.
     *                      - 'button_class' (string): Additional CSS classes for the button. Default is ''.
     *                      - 'button_attr' (string): Additional HTML attributes for the button. Default is ''.
     *                      - 'button_content' (string): The content/text of the button. Default is ''.
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

        $html = '<a href="' . $url . '" class="btn ' . $class . '" ' . $attr . '>';
        $html .= $content . '</a>';

        echo $html;
    }
}
?>
