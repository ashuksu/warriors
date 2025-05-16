<?php
// Define the application path
define('APP_PATH', '/');
define('PROJECT_ROOT', dirname(__DIR__) . '/');
define('APP_TITLE', 'Home Page');
define('PAGE', 'main');

// Include the bootstrap file
require_once PROJECT_ROOT . 'config/bootstrap.php';

// Initialize the application
$app = new \App\Controllers\HomeController();
$app->index();
?>