<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Controllers\HomeController;

define("APP_TITLE", "Home Page");
define("PAGE", "main");

HomeController::index();