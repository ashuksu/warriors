<?php

namespace Views\Sections\Faq;

use Services\SectionService;
use function Helpers\renderTemplate;

class Faq
{
    public static function render($params = [])
    {
        extract($params);

        renderTemplate(__DIR__ . '/template.php', [
            'collection' => SectionService::get('faq', 'items'),
            'section' => 'faq',
            'title' => SectionService::get('faq', 'title')
        ]);

    }
}