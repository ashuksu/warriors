<?php
define("APP_TITLE", "Home Page");
$bodyClass = 'home-page';
$sections = ['main-section', 'about', 'faq', 'info'];

$servicePath = 'includes/services/sections/AboutService.php';
require_once $servicePath;

include 'includes/Layout.php';
?>