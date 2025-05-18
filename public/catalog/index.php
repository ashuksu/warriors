<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Services\SectionService;
use Views\Layout;

define("APP_TITLE", "Catalog Page");
define("PAGE", "catalog");

Layout::render([
    'sections' => [PAGE, 'info'],
    'title' => SectionService::get(PAGE, 'title'),
    'catalog' => SectionService::get(PAGE, 'items')
]);