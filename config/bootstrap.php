<?php
// Bootstrap file for the application
// This file is responsible for setting up the application environment

// Load configuration
require_once dirname(__DIR__) . '/config/config.php';

// Register autoloader
spl_autoload_register(function ($class) {
    // Convert namespace to file path
    $file = PROJECT_ROOT . str_replace('\\', '/', $class) . '.php';
    
    // Check if file exists
    if (file_exists($file)) {
        require_once $file;
        return true;
    }
    
    return false;
});

// Initialize error handling
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set default timezone
date_default_timezone_set('UTC');
?>