<?php

namespace Controllers;

use Services\SectionService;
use Views\Layout;

class CatalogController
{
    public static function index(): void
    {
        define("APP_TITLE", PAGES['main']['title']);
        define("PAGE", "catalog");

        Layout::render([
            'sections' => ['catalog', 'info'],
            'title' => SectionService::get('catalog', 'title'),
            'catalog' => SectionService::get('catalog', 'items'),
            'info' => SectionService::get('info', 'items', 'info-catalog')
        ]);
    }
}