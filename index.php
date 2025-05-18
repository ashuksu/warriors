<?php
define("APP_TITLE", "Home Page");
define("PAGE", "main");
require_once __DIR__ . '/config.php';
require_once PROJECT_ROOT . 'app/Services/SectionService.php';

$sections = ['main-section', 'about', 'faq', 'info'];

include PROJECT_ROOT . 'includes/Layout.php';
?>
