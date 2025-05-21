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

// Define IS_DEV first as it's used by other constants
define('IS_DEV', ($_ENV['IS_DEV'] ?? 'false') === 'true');

// Base paths
define('APP_PATH', $_ENV['APP_PATH'] ?? '/');
define('PROJECT_ROOT', ($_ENV['PROJECT_ROOT'] ?? dirname(__DIR__)) . '/');

// Vite development server configuration
define('VITE_DEV_SERVER', $_ENV['VITE_DEV_SERVER'] ?? 'http://localhost:5173/');
define('VITE_DEV_CLIENT', VITE_DEV_SERVER . '@vite/client');

// Asset paths
define('ASSETS_PATH', (defined('IS_DEV') && IS_DEV) ? VITE_DEV_SERVER : APP_PATH);
define('DIST_PATH', APP_PATH . 'dist/');
define('IMAGES_PATH', DIST_PATH . 'assets/images/');
define('STYLES_PATH', DIST_PATH . 'assets/css/');
define('SCRIPTS_PATH', DIST_PATH . 'assets/js/');

// Site configuration
define('DOMAIN', $_ENV['DOMAIN'] ?? 'warriors.example.com');
define('LINK', $_ENV['LINK'] ?? 'https://github.com/username/');
define('EMAIL', $_ENV['EMAIL'] ?? 'email@example.com');
define('TELEGRAM', $_ENV['TELEGRAM'] ?? 'https://t.me/username');
