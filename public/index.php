<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Controllers\HomeController;

define("APP_TITLE", PAGES['main']['title']);
define("PAGE", "main");

HomeController::index();