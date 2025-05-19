<?php

namespace Views\Sections\Error;

use Services\SectionService;
use function Helpers\renderTemplate;

class Error
{
    public static function render($params = [])
    {
        extract($params);

        $error = SectionService::get('error');

        renderTemplate(__DIR__ . '/template.php', [
            'item' => $error,
            'section' => 'error',
            'itemPath' => __DIR__ . '/item.php',
            'title' => $error['title'],
            'imagePartPath' => APP_PATH . 'assets/images/',
        ]);
    }
}