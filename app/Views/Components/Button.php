<?php

namespace Views\Components;

/**
 * Button component class
 * 
 * Provides functionality to render HTML buttons or links with button styling
 */
class Button
{
    /**
     * Renders a button using an anchor tag with configurable options
     *
     * @param array{
     *     url?: string,
     *     class?: string,
     *     attr?: string,
     *     content?: string,
     *     tag?: string
     * } $params Button configuration
     *
     * @return string HTML button
     */
    public static function render(array $params = []): string
    {
        extract($params);

        // default params
        $url = $url ?? '#';
        $class = isset($class) ? "button {$class}" : 'button';
        $attr = $attr ?? '';
        $content = $content ?? '';
        $tag = $tag ?? 'link';

        // Resolve variables in URL
        if (is_string($url) && strpos($url, '$') !== false) {
            $url = \Services\ConfigVarResolver::getInstance()->resolveValue($url);
        }

        $url = htmlspecialchars($url, ENT_QUOTES);
        $class = htmlspecialchars($class, ENT_QUOTES);

        ob_start(); ?>
        <?php if ($tag === 'button'): ?>

            <button class="<?= $class ?>" <?= $attr ?>><?= $content ?></button>

        <?php else: ?>

            <a href="<?= $url ?>" class="<?= $class ?>" <?= $attr ?>><?= $content ?></a>

        <?php endif;
        return ob_get_clean();
    }
}