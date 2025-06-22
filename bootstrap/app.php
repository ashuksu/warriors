<?php

declare(strict_types=1);

/**
 * Application Bootstrap.
 * Initializes core components and loads configurations.
 */

use App\Core\Container;
use Dotenv\Dotenv;
use App\Services\ConfigService;
use Throwable;

if (!defined('PROJECT_ROOT')) {
    define('PROJECT_ROOT', dirname(__DIR__));
}

require_once PROJECT_ROOT . '/vendor/autoload.php';

try {
    $dotenv = Dotenv::createImmutable(PROJECT_ROOT);
    $dotenv->load();
} catch (Throwable $e) {
    error_log("Dotenv failed to load: " . $e->getMessage());
}

$container = Container::getInstance();
$container->registerServices();

return $container;