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
            'collection' => SectionService::get('catalog', 'items'),
            'section' => 'catalog',
            'title' => SectionService::get('catalog', 'title'),
            'imagePartPath' => APP_PATH . 'dist/assets/images/items/'
        ]);
    }
}