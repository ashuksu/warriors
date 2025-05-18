<?php

namespace Controllers;

use Services\SectionService;
use Views\Layout;

class ErrorController
{
    public static function index(): void
    {
        Layout::render([
            'sections' => ['error'],
            'title' => SectionService::get('error', 'title'),
            'text' => SectionService::get('error', 'text'),
            'image' => SectionService::get('error', 'image'),
            'button' => SectionService::get('error', 'button')
        ]);
    }
}