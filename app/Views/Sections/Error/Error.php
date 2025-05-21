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
            'title' => SectionService::get('error', 'title')
        ]);
    }
}