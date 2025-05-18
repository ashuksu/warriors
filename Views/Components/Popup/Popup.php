<?php

namespace Views\Components\Popup;

use Services\SectionService;
use Views\Helpers\RenderHelper;

class Popup
{
    public static function render($params = [])
    {
        extract($params);

        $popups = SectionService::get('popup', 'items');

        if (!empty($popups) && is_array($popups)) {
            foreach ($popups as $item) {
                RenderHelper::renderTemplate(__DIR__ . '/template.php', [
                    'item' => $item,
                ]);
            }
        }
    }
}