<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Services\SectionService;
use Views\Layout;

define("APP_TITLE", "Home Page");
define("PAGE", "main");

Layout::render([
    'sections' => ['main-section', 'about', 'faq', 'info']
]);