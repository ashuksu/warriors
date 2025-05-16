<?php
define("APP_TITLE", "Catalog Page");
define("PAGE", "catalog");
require_once __DIR__ . '/../config.php';
require_once PROJECT_ROOT . 'Services/SectionService.php';

$sections = [PAGE, 'info'];

$title = SectionService::get(PAGE, 'title');
$catalog = SectionService::get(PAGE, 'items');

include PROJECT_ROOT . 'includes/Layout.php';
?>
