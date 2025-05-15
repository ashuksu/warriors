<?php
define("APP_TITLE", "Home Page");
$bodyClass = 'home-page';
$sections = ['main-section', 'about', 'faq', 'info'];

$servicePath = 'Services/SectionService.php';
require_once $servicePath;

include 'includes/Layout.php';
?>
