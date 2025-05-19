<?php

namespace Controllers;

use Views\Layout;

class CatalogController
{
    public static function index(): void
    {
        define("APP_TITLE", PAGES['main']['title']);
        define("PAGE", "catalog");

        Layout::render([
            'sections' => ['catalog', 'info']
        ]);
    }
}