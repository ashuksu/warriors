<?php
define("APP_TITLE", "Catalog Page");
$dir = "../";
$bodyClass = 'page-catalog';
$sections = ['catalog', 'info'];

// Load catalog items
$servicePath = $dir . 'includes/services/CatalogService.php';
require_once $servicePath;
$catalog = CatalogService::getInstance()->getCatalogItems() ?? [];

include $dir . 'includes/Layout.php';
?>
