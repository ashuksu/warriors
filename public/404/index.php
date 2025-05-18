<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Controllers\ErrorController;

define("APP_TITLE", "404 Page");
define("PAGE", "error");

ErrorController::index();