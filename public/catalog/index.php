<?php

use Services\SectionService;

define("APP_TITLE", "Catalog Page");
define("PAGE", "catalog");
require_once __DIR__ . '/../../config.php';
require_once PROJECT_ROOT . 'app/Services/SectionService.php';

$sections = [PAGE, 'info'];

$title = SectionService::get(PAGE, 'title');
$catalog = SectionService::get(PAGE, 'items');

include PROJECT_ROOT . 'Views/Layout.php';
?>