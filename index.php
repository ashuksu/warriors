<?php
define("APP_TITLE", "Home Page");
require_once __DIR__ . '/config.php';
$bodyClass = 'home-page';
$sections = ['main-section', 'about', 'faq', 'info'];

$servicePath = PROJECT_ROOT . 'Services/SectionService.php';
require_once $servicePath;

include PROJECT_ROOT . 'includes/Layout.php';
?>
