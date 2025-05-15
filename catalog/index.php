<?php
define("APP_TITLE", "Catalog Page");
$dir = "../";
$bodyClass = 'page-catalog';
$sections = ['catalog', 'info'];

// Load catalog items
$servicePath = $dir . 'includes/services/sections/CatalogService.php';
require_once $servicePath;
$catalog = CatalogService::getInstance()->getCatalogItems();
$title = CatalogService::getInstance()->getCatalogTitle();

include $dir . 'includes/Layout.php';
?>
