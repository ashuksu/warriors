<?php
define("APP_TITLE", "Contacts Page");
define("PAGE", "contacts");
require_once __DIR__ . '/../config.php';
require_once PROJECT_ROOT . 'Services/SectionService.php';

$sections = [PAGE, 'info'];

$title = SectionService::get(PAGE, 'title');
$contacts = SectionService::get(PAGE, 'items');

include PROJECT_ROOT . 'includes/Layout.php';
?>
