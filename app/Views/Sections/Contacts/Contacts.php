<?php

namespace Views\Sections\Contacts;

use function Helpers\renderTemplate;

class Contacts
{
    public static function render($params = [])
    {
        extract($params);

        if (!empty($contacts) && is_array($contacts)) {
            renderTemplate(__DIR__ . '/template.php', [
                'contacts' => $contacts,
                'section' => 'contacts',
                'itemPath' => __DIR__ . '/item.php',
                'title' => $title
            ]);
        }
    }
}