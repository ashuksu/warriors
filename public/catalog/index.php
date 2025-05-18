<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Controllers\CatalogController;

define("APP_TITLE", "Catalog Page");
define("PAGE", "catalog");

CatalogController::index();