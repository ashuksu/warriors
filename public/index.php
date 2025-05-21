<?php
/**
 * Application Entry Point
 * 
 * This file serves as the main entry point for the application.
 * It initializes the router and resolves the current request.
 */

require_once __DIR__ . '/../vendor/autoload.php';

$router = new Core\Router();
$router->resolve();