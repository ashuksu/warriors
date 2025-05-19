<?php

namespace Views\Sections\Contacts;

use Services\SectionService;
use function Helpers\renderTemplate;

class Contacts
{
    public static function render($params = [])
    {
        extract($params);

        renderTemplate(__DIR__ . '/template.php', [
            'contacts' => SectionService::get('contacts', 'items'),
            'section' => 'contacts',
            'itemPath' => __DIR__ . '/item.php',
            'title' => SectionService::get(PAGE, 'title')
        ]);
    }
}