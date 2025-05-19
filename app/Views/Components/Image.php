<?php

namespace Views\Components;

/**
 * Component for rendering images
 */
class Image
{
    /**
     * Render image element
     *
     * @param array $params {
     *     @type string $url Image URL
     *     @type string $imagePath Alternative image path
     *     @type string $alt Alt text
     *     @type int $width Image width
     *     @type int $height Image height
     *     @type string $attr Additional HTML attributes
     *     @type bool $noLazy Disable lazy loading
     * }
     * @return string Rendered HTML
     */
    public static function render(array $params = []): string
    {
        extract($params);

        // default params
        $url = $imagePath ?? $url ?? '#';
        $alt = $alt ?? 'image';
        $width = $width ?? 600;
        $height = $height ?? 600;
        $attr = $attr ?? '';
        $lazyLoad = isset($noLazy) && $noLazy ? '' : 'loading="lazy"';

        // Escape attribute values
        $url = htmlspecialchars($url, ENT_QUOTES);
        $alt = htmlspecialchars($alt, ENT_QUOTES);

        ob_start(); ?>
        <img src="<?= $url ?>"
             alt="<?= $alt ?>"
             width="<?= $width ?>"
             height="<?= $height ?>"
            <?= $attr ?>
            <?= $lazyLoad ?>>
        <?php
        return ob_get_clean();
    }
}