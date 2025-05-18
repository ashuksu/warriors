<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Controllers\ContactsController;

define("APP_TITLE", PAGES['main']['title']);
define("PAGE", "contacts");

ContactsController::index();