<?php

namespace Views\Sections\Main;

use Services\SectionService;
use function Helpers\renderTemplate;

class Main
{
    public static function render($params = [])
    {
        extract($params);

        $image = SectionService::get('main', 'image');

        renderTemplate(__DIR__ . '/template.php', [
            'item' => SectionService::get('main'),
            'section' => 'main',
            'image' => $image,
            'imagePath' => APP_PATH . 'assets/images/' . ($image['image'] ?? ''),
            'popups' => $popups,
            'isPopups' => $isPopups,
        ]);
    }
}