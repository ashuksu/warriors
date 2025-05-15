<?php
define("APP_TITLE", "Contacts Page");
require_once __DIR__ . '/../config.php';
$bodyClass = 'page-contacts';
$sections = ['contacts', 'info'];

require_once PROJECT_ROOT . 'Services/SectionService.php';
$title = SectionService::get('contacts', 'title');
$contacts = SectionService::get('contacts', 'items');
if (!is_array($contacts) || empty($contacts)) $contacts = [];

include PROJECT_ROOT . 'includes/Layout.php';
?>
