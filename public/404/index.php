<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Controllers\ErrorController;

define("APP_TITLE", PAGES['main']['title']);
define("PAGE", "error");

ErrorController::index();