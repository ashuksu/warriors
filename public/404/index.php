<?php

use Services\SectionService;

define("APP_TITLE", "404 Page");
define("PAGE", "error");
require_once __DIR__ . '/../../config.php';
require_once PROJECT_ROOT . 'app/Services/SectionService.php';

$sections = [PAGE];

$title = SectionService::get(PAGE, 'title');
$text = SectionService::get(PAGE, 'text');
$image = SectionService::get(PAGE, 'image');
$button = SectionService::get(PAGE, 'button');

include PROJECT_ROOT . 'Views/Layout.php';
?>