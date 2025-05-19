<?php

namespace Views\Sections\Catalog;

use function Helpers\renderTemplate;

class Catalog
{
    public static function render($params = [])
    {
        extract($params);

        if (!empty($catalog) && is_array($catalog)) {
            renderTemplate(__DIR__ . '/template.php', [
                'catalog' => $catalog,
                'section' => 'catalog',
                'itemPath' => __DIR__ . '/item.php',
                'title' => $title,
                'imagePartPath' => APP_PATH . 'assets/images/items/'
            ]);
        }
    }
}