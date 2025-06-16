<?php

require_once __DIR__ . '/vendor/autoload.php';

// Include your application's autoloader
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/app/Helpers/helpers.php';
require_once __DIR__ . '/app/Helpers/Vite.php';

try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
} catch (\Throwable $e) {
    // It's okay if .env doesn't exist, we'll use fallbacks.
}

return [
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/database/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/database/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'development' => [
            'adapter' => getenv('DB_CONNECTION') ?: 'pgsql',
            'host' => getenv('DB_HOST') ?: 'db',
            'name' => getenv('DB_DATABASE') ?: 'myapp_db',
            'user' => getenv('DB_USERNAME') ?: 'myuser',
            'pass' => getenv('DB_PASSWORD') ?: 'mypassword',
            'port' => getenv('DB_PORT') ?: '5432',
            'charset' => 'utf8',
        ]
    ],
    'version_order' => 'creation'
];