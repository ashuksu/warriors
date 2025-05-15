<?php
define("APP_TITLE", "Catalog Page");
$dir = "../";
$bodyClass = 'page-catalog';
$sections = ['catalog', 'info'];

$servicePath = $dir . 'Services/SectionService.php';
require_once $servicePath;

$title = SectionService::get('catalog', 'title');
$catalog = SectionService::get('catalog', 'items');
if (!is_array($catalog) || empty($catalog)) $catalog = [];

include $dir . 'includes/Layout.php';
?>
