<?php
define("APP_TITLE", "404 Page");
require_once __DIR__ . '/../config.php';
$bodyClass = 'page-error';
$sections = ['error'];

require_once PROJECT_ROOT . 'Services/SectionService.php';
$title = SectionService::get('error', 'title');
$text = SectionService::get('error', 'text');
$image = SectionService::get('error', 'image');
$button = SectionService::get('error', 'button');

include PROJECT_ROOT . 'includes/Layout.php';
?>
