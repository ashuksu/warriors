<?php

namespace Views\Sections\Main;

use Services\SectionService;
use function Helpers\renderTemplate;

class Main
{
    public static function render($params = [])
    {
        extract($params);

        $popups = SectionService::get('popup', 'items');
        $image = SectionService::get('main', 'image');

        renderTemplate(__DIR__ . '/template.php', [
            'item' => SectionService::get('main'),
            'section' => 'main',
            'image' => $image,
            'imagePath' => getAssetPath('dist/assets/images/' . ($image['image'] ?? '')),
            'popups' => $popups,
            'isPopups' => !empty($popups) && is_array($popups),
        ]);
    }
}