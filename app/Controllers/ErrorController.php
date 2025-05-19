<?php

namespace Controllers;

use Views\Layout;

class ErrorController
{
    public static function index(): void
    {
        define("APP_TITLE", PAGES['main']['title']);
        define("PAGE", "error");

        Layout::render([
            'sections' => [PAGE],
        ]);
    }
}