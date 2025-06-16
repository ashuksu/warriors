<?php

namespace Views\Sections\Popup;

use Services\SectionService;
use function Helpers\renderTemplate;

class Popup
{
    public static function render($params = [])
    {
        extract($params);

        $popups = SectionService::get('popup', 'items');

        if (!empty($popups) && is_array($popups)) {
            foreach ($popups as $item) {
                renderTemplate(__DIR__ . '/template.php', [
                    'item' => $item,
                    'button' => $item['button'],
                ]);
            }
        }
    }
}