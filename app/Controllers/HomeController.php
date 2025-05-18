<?php

namespace Controllers;

use Services\SectionService;
use Views\Layout;

class HomeController
{
    public static function index(): void
    {
        $popups = SectionService::get('popup', 'items');

        Layout::render([
            'sections' => ['main', 'about', 'faq', 'info'],
            'main' => SectionService::get('main'),
            'mainImage' => SectionService::get('main', 'image'),
            'popups' => $popups,
            'isPopups' => !empty($popups) && is_array($popups),
            'about' => SectionService::get('about', 'items'),
            'faq' => SectionService::get('faq', 'items'),
            'faqTitle' => SectionService::get('faq', 'title'),
            'info' => SectionService::get('info', 'items', 'info-main')
        ]);
    }
}