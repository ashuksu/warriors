<?php

namespace Views\Sections\Info;

use Services\SectionService;
use function Helpers\renderTemplate;

class Info
{
    public static function render($params = [])
    {
        extract($params);

        renderTemplate(__DIR__ . '/template.php', [
            'item' => SectionService::get('info', 'items', 'info-' . PAGE),
            'section' => 'info',
        ]);
    }
}