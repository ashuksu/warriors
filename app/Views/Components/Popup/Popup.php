<?php

namespace Views\Components\Popup;

use Views\Helpers\RenderHelper;
use Services\SectionService;

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