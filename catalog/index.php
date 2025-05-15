<?php
define("APP_TITLE", "Catalog Page");
$dir = "../";
$bodyClass = 'page-catalog';
$sections = ['catalog', 'info'];

// Load catalog data
$servicePath = $dir . 'includes/services/sections/CatalogService.php';
require_once $servicePath;
$catalog = CatalogService::getInstance()->getData('items');
$title = CatalogService::getInstance()->getData('title');

include $dir . 'includes/Layout.php';
?>
