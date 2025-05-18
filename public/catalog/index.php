<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Controllers\CatalogController;

define("APP_TITLE", PAGES['main']['title']);
define("PAGE", "catalog");

CatalogController::index();