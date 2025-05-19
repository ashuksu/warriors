<?php

namespace Views\Sections\Catalog;

use Services\SectionService;
use function Helpers\renderTemplate;

class Catalog
{
    public static function render($params = [])
    {
        extract($params);

        renderTemplate(__DIR__ . '/template.php', [
            'catalog' => SectionService::get('catalog', 'items'),
            'section' => 'catalog',
            'itemPath' => __DIR__ . '/item.php',
            'title' => SectionService::get('catalog', 'title'),
            'imagePartPath' => APP_PATH . 'assets/images/items/'
        ]);
    }
}