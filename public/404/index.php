<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Services\SectionService;
use Views\Layout;

define("APP_TITLE", "404 Page");
define("PAGE", "error");

Layout::render([
    'sections' => [PAGE],
    'title' => SectionService::get(PAGE, 'title'),
    'text' => SectionService::get(PAGE, 'text'),
    'image' => SectionService::get(PAGE, 'image'),
    'button' => SectionService::get(PAGE, 'button')
]);
?>
