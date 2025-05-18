<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Controllers\ContactsController;

define("APP_TITLE", "Contacts Page");
define("PAGE", "contacts");

ContactsController::index();