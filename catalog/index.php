<?php
define("APP_TITLE", "Catalog Page");
$dir = "../";
$bodyClass = 'page-catalog';
$sections = ['catalog', 'info'];

$servicePath = $dir . 'includes/services/sections/CatalogService.php';
require_once $servicePath;

$title = CatalogService::get('title');
$catalog = CatalogService::get('items');
if (!is_array($catalog) || empty($catalog)) $catalog = [];

include $dir . 'includes/Layout.php';
?>
