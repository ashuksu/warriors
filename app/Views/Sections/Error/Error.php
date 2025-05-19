<?php

namespace Views\Sections\Error;

use Services\SectionService;
use function Helpers\renderTemplate;

class Error
{
    public static function render($params = [])
    {
        extract($params);

        renderTemplate(__DIR__ . '/template.php', [
            'item' => SectionService::get('error'),
            'section' => 'error',
            'imagePartPath' => APP_PATH . 'assets/images/',
            'itemPath' => __DIR__ . '/item.php',
            'title' => SectionService::get('error', 'title')
        ]);
    }
}