<?php

namespace Views\Sections\About;

use function Helpers\renderTemplate;

class About
{
    public static function render($params = [])
    {
        extract($params);

        if (!empty($about) && is_array($about)) {
            renderTemplate(__DIR__ . '/template.php', [
                'about' => $about,
                'section' => 'about',
                'itemPath' => __DIR__ . '/item.php',
                'imagePartPath' => APP_PATH . 'assets/images/'
            ]);
        }
    }
}
