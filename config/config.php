<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

define('APP_PATH', $_ENV['APP_PATH'] ?? '/');
define('PROJECT_ROOT', $_ENV['PROJECT_ROOT'] ?? dirname(__DIR__) . '/');
define('DOMAIN', $_ENV['DOMAIN'] ?? 'warriors.example.com');
define('LINK', $_ENV['LINK'] ?? 'https://github.com/username/');
define('EMAIL', $_ENV['EMAIL'] ?? 'email@example.com');
define('TELEGRAM', $_ENV['TELEGRAM'] ?? 'https://t.me/username');
define('IS_DEV', ($_ENV['IS_DEV'] ?? 'false') === 'true');