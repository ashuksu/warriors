<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Services\SectionService;
use Views\Layout;

define("APP_TITLE", "Home Page");
define("PAGE", "main");

Layout::render([
    'sections' => ['MainSection', 'About', 'faq', 'info'],
    'faq' => SectionService::get('faq', 'items'),
    'faqTitle' => SectionService::get('faq', 'title'),
    'info' => SectionService::get('info', 'items', 'info-' . PAGE)
]);