<?php

namespace Views\Components;
use Views\Components\Image;

class Preloader
{
    public static function render(array $params = [])
    {
        extract($params);

        // default params
        $id = $id ?? 'preloader';
        $class = $class ?? 'preloader';
        $attr = $attr ?? '';
        ?>
        <div id="<?= $id ?>"
             class="<?= $class ?>"
            <?= $attr ?>>

            <?php

            Image::render([
                'url' => APP_PATH . 'assets/images/loader.gif',
                'alt' => 'loader',
                'width' => 100,
                'height' => 100,
                'attr' => 'class="error-image"',
                'noLazy' => true
            ]);
            ?>

        </div>
        <?php
    }
}