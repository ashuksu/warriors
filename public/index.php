<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Services\SectionService;
use Views\Layout;

define("APP_TITLE", "Home Page");
define("PAGE", "main");

$popups = SectionService::get('popup', 'items');

Layout::render([
    'sections' => [PAGE, 'about', 'faq', 'info'],
    'main' => SectionService::get('main'),
    'mainImage' => SectionService::get('main', 'image'),
    'popups'=> $popups,
    'isPopups'=> !empty($popups) && is_array($popups),
    'about' => SectionService::get('about', 'items'),
    'faq' => SectionService::get('faq', 'items'),
    'faqTitle' => SectionService::get('faq', 'title'),
    'info' => SectionService::get('info', 'items', 'info-' . PAGE)
]);