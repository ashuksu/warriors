<?php

namespace Controllers;

use Views\Layout;
use Services\SectionService;

class ErrorController
{
    public static function index(): void
    {
        define("APP_TITLE", PAGES['main']['title']);
        define("PAGE", "error");

        Layout::render([
            'sections' => ['error'],
            'title' => SectionService::get('error', 'title'),
            'text' => SectionService::get('error', 'text'),
            'image' => SectionService::get('error', 'image'),
            'button' => SectionService::get('error', 'button')
        ]);
    }
}