<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Services\SectionService;
use Views\Layout;

define("APP_TITLE", "Contacts Page");
define("PAGE", "contacts");

Layout::render([
    'sections' => ['Contacts'],
    'title' => SectionService::get(PAGE, 'title'),
    'contacts' => SectionService::get(PAGE, 'items')
]);