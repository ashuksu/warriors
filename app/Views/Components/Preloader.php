<?php

namespace Views\Components;

use Views\Components\Image;
use function Helpers\getPath;

/**
 * Component for rendering preloader
 */
class Preloader
{
    /**
     * Render preloader element
     *
     * @param array $params {
     * @type string $id Preloader ID
     * @type string $class CSS classes
     * @type string $attr Additional HTML attributes
     * }
     * @return string Rendered HTML
     */
    public static function render(array $params = []): string
    {
        extract($params);

        // default params
        $id = $id ?? 'preloader';
        $class = $class ?? 'preloader';
        $attr = $attr ?? '';
        ob_start(); ?>

		<div id="<?= htmlspecialchars($id, ENT_QUOTES) ?>"
			 class="<?= htmlspecialchars($class, ENT_QUOTES) ?>"
            <?= $attr ?>>

            <?php echo Image::render([
                'url' => getPath('dist/assets/images/loader.gif'),
                'alt' => 'loader',
                'width' => 100,
                'height' => 100,
                'attr' => 'class="error-image"',
                'noLazy' => true
            ]) ?>

		</div>

        <?php
        return ob_get_clean();
    }
}