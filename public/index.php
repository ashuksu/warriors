<?php
// Define page-specific constants
define('APP_TITLE', 'Home Page');
define('PAGE', 'main');

// Include the bootstrap file
require_once dirname(__DIR__) . '/config/bootstrap.php';

// Initialize the application
$app = new \App\Controllers\HomeController();
$app->index();
?>
