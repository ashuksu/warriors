<?php

namespace Views\Sections\About;

use Services\SectionService;
use function Helpers\renderTemplate;

class About
{
    public static function render($params = [])
    {
        extract($params);

        renderTemplate(__DIR__ . '/template.php', [
            'collection' => SectionService::get('about', 'items'),
            'section' => 'about'
        ]);
    }
}
