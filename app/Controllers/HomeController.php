<?php

namespace Controllers;

use Views\Layout;

class HomeController
{
    public static function index(): void
    {
        define("APP_TITLE", PAGES['main']['title']);
        define("PAGE", "main");

        Layout::render([
            'sections' => [PAGE, 'about', 'faq', 'info'],
        ]);
    }
}