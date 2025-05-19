<?php

namespace Views\Components;

class Image
{
    public static function render(array $params = [])
    {
        extract($params);

        // default params
        $url = $imagePath ?? $url ?? '#';
        $alt = $alt ?? 'image';
        $width = $width ?? 600;
        $height = $height ?? 600;
        $attr = $attr ?? '';
        $lazyLoad = isset($noLazy) && $noLazy ? '' : 'loading="lazy"';
        ?>
        <img src="<?= $url ?>"
             alt="<?= $alt ?>"
             width="<?= $width ?>"
             height="<?= $height ?>"
            <?= $attr ?>
            <?= $lazyLoad ?>>
        <?php
    }
}