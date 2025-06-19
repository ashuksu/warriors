<?php

use App\Core\{Container, Router};

/**
 * Application Entry Point
 *
 * This file serves as the main entry point for the application.
 * It initializes the router and resolves the current request.
 */

require_once __DIR__ . '/../vendor/autoload.php';

try {
    $container = Container::getInstance();
    $router = new Router($container);
    $router->resolve();
} catch (Exception $e) {
    error_log($e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());

    if (defined('IS_DEV') && IS_DEV) {
        echo "<h1>An error occurred:</h1>";
        echo "<p>" . $e->getMessage() . "</p>";
        echo "<p>File: " . $e->getFile() . ":" . $e->getLine() . "</p>";
    } else {
        echo "<h1>An error occurred.</h1>";
        echo "<p>Please try again later.</p>";
    }
}