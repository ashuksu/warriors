<?php
/**
 * Main configuration file
 * 
 * Loads environment variables and defines application constants.
 * This file should be included at the beginning of the application bootstrap process.
 */
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

// Define IS_DEV first as it's used in paths.php
define('IS_DEV', ($_ENV['IS_DEV'] ?? 'false') === 'true');

// Load centralized path configuration
require_once __DIR__ . '/paths.php';

define('DOMAIN', $_ENV['DOMAIN'] ?? 'warriors.example.com');
define('LINK', $_ENV['LINK'] ?? 'https://github.com/username/');
define('EMAIL', $_ENV['EMAIL'] ?? 'email@example.com');
define('TELEGRAM', $_ENV['TELEGRAM'] ?? 'https://t.me/username');
