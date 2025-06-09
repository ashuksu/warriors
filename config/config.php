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
define('EMAIL', $_ENV['EMAIL'] ?? 'info@example.com');
define('TELEGRAM', $_ENV['TELEGRAM'] ?? 'https://t.me/yourtelegram');
define('PHONE', $_ENV['PHONE'] ?? '+1234567890');
define('ADDRESS', $_ENV['ADDRESS'] ?? '123 Warrior Street, City, Country');
define('COMPANY_NAME', $_ENV['COMPANY_NAME'] ?? 'Warriors Inc.');

// Social media links
define('SOCIAL_FACEBOOK', $_ENV['SOCIAL_FACEBOOK'] ?? '#');
define('SOCIAL_INSTAGRAM', $_ENV['SOCIAL_INSTAGRAM'] ?? '#');
define('SOCIAL_TWITTER', $_ENV['SOCIAL_TWITTER'] ?? '#');
define('SOCIAL_LINKEDIN', $_ENV['SOCIAL_LINKEDIN'] ?? '#');
define('SOCIAL_YOUTUBE', $_ENV['SOCIAL_YOUTUBE'] ?? '#');
define('SOCIAL_TELEGRAM', $_ENV['SOCIAL_TELEGRAM'] ?? '#');

// Google Analytics (optional)
define('GA_TRACKING_ID', $_ENV['GA_TRACKING_ID'] ?? null);

// Load other constants after basic path configurations
require_once __DIR__ . '/constants.php';