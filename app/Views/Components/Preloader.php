<?php

namespace App\Views\Components;

use App\Views\Components\Image;
use Exception;

/**
 * Component for rendering preloader.
 */
class Preloader
{
    /**
     * Renders preloader element
     *
     * @type string $id Preloader ID
     * @type string $class CSS classes
     * @type string $attr Additional HTML attributes
     * @return string Rendered HTML
     * @throws Exception
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

            <?php
            echo Image::render([
                'url' => $pathService->getPath('dist/assets/images/loader.webp'),
                'alt' => 'loader',
                'width' => 100,
                'height' => 100,
                'attr' => 'class="error-image"',
                'noLazy' => true,
                'fetchpriority' => 'high'
            ]);
            ?>

		</div>

        <?php
        return ob_get_clean();
    }
}