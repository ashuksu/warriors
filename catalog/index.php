<?php
define("APP_TITLE", "Catalog Page");
require_once __DIR__ . '/../config.php';
$bodyClass = 'page-catalog';
$sections = ['catalog', 'info'];

require_once PROJECT_ROOT . 'Services/SectionService.php';
$title = SectionService::get('catalog', 'title');
$catalog = SectionService::get('catalog', 'items');
if (!is_array($catalog) || empty($catalog)) $catalog = [];

include PROJECT_ROOT . 'includes/Layout.php';
?>
