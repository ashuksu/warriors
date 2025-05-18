<?php

namespace Controllers;

use Services\SectionService;
use Views\Layout;

class CatalogController
{
    public static function index(): void
    {
        Layout::render([
            'sections' => ['catalog', 'info'],
            'title' => SectionService::get('catalog', 'title'),
            'catalog' => SectionService::get('catalog', 'items'),
            'info' => SectionService::get('info', 'items', 'info-catalog')
        ]);
    }
}