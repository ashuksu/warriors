<?php

declare(strict_types=1);

use Dotenv\Dotenv;

$projectRoot = __DIR__;
while (!file_exists($projectRoot . '/vendor/autoload.php') && $projectRoot !== '/') {
    $projectRoot = dirname($projectRoot);
}

require_once $projectRoot . '/vendor/autoload.php';

try {
    $dotenv = Dotenv::createImmutable($projectRoot);
    $dotenv->load();
} catch (Throwable $e) {
    // It's okay if .env doesn't exist, environment variables from Docker or system will be used.
    error_log("Dotenv failed to load: " . $e->getMessage());
}

return [
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/database/migrations',
        'seeds'      => '%%PHINX_CONFIG_DIR%%/database/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment'     => 'development',
        'development' => [
            'adapter'   => getenv('DB_CONNECTION') ?: 'pgsql',
            'host'      => getenv('DB_HOST') ?: 'db',
            'name'      => getenv('DB_DATABASE') ?: 'myapp_db',
            'user'      => getenv('DB_USERNAME') ?: 'myuser',
            'pass'      => getenv('DB_PASSWORD') ?: 'mypassword',
            'port'      => getenv('DB_PORT') ?: '5432',
            'charset'   => 'utf8',
        ]
    ],
    'version_order' => 'creation'
];