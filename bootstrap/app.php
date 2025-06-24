<?php

declare(strict_types=1);

/**
 * Application Bootstrap.
 * Initializes core components and loads configurations.
 */

use App\Core\Container;
use Dotenv\Dotenv;

$projectRoot = __DIR__;
while (!file_exists($projectRoot . '/vendor/autoload.php') && $projectRoot !== '/') {
    $projectRoot = dirname($projectRoot);
}

require_once $projectRoot. '/vendor/autoload.php';

try {
    $dotenv = Dotenv::createImmutable($projectRoot);
    $dotenv->load();
} catch (Throwable $e) {
    error_log("Dotenv failed to load: " . $e->getMessage());
}

$container = Container::getInstance();
$container->registerServices();

return $container;