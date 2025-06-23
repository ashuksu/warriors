<?php

declare(strict_types=1);

use App\Core\Container;
use App\Core\Router;
use App\Services\ConfigService;

/**
 * Application Entry Point.
 * Handles incoming requests and routes them to the appropriate controller.
 */
try {
    /** @var Container $container */
    $container = require_once __DIR__ . '/../bootstrap/app.php';

    /** @var Router $router */
    $router = $container->get(Router::class);
    $router->resolve();

} catch (Throwable $e) {
    http_response_code(500);
    error_log($e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());

    /** @var ConfigService $configService */
    $configService = $container->get(ConfigService::class);

    if ($configService->get('is_dev')) {
        header('Content-Type: text/plain; charset=utf-8');
        echo "Application Error:\n\n";
        echo $e->getMessage() . "\n\n";
        echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n\n";
        echo $e->getTraceAsString();
    } else {
        echo "<h1>An unexpected error occurred</h1>";
        echo "<p>We are sorry for the inconvenience. Please try again later.</p>";
    }
}