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
if (!defined('IS_DEV')) {
    define('IS_DEV', ($_ENV['IS_DEV'] ?? 'false') === 'true');
}

// Base paths
if (!defined('APP_PATH')) {
    define('APP_PATH', $_ENV['APP_PATH'] ?? '/');
}
if (!defined('PROJECT_ROOT')) {
    define('PROJECT_ROOT', ($_ENV['PROJECT_ROOT'] ?? dirname(__DIR__)) . '/');
}

// Vite development server configuration
if (!defined('VITE_DEV_SERVER')) {
    define('VITE_DEV_SERVER', $_ENV['VITE_DEV_SERVER'] ?? 'http://localhost:5173/');
}
if (!defined('VITE_DEV_CLIENT')) {
    define('VITE_DEV_CLIENT', VITE_DEV_SERVER . '@vite/client');
}

// Asset paths
if (!defined('ASSETS_PATH')) {
    define('ASSETS_PATH', (defined('IS_DEV') && IS_DEV) ? VITE_DEV_SERVER : APP_PATH);
}
if (!defined('DIST_PATH')) {
    define('DIST_PATH', APP_PATH . 'dist/');
}
if (!defined('IMAGES_PATH')) {
    define('IMAGES_PATH', DIST_PATH . 'assets/images/');
}
if (!defined('STYLES_PATH')) {
    define('STYLES_PATH', DIST_PATH . 'assets/css/');
}
if (!defined('SCRIPTS_PATH')) {
    define('SCRIPTS_PATH', DIST_PATH . 'assets/js/');
}

// Site configuration
if (!defined('DOMAIN')) {
    define('DOMAIN', $_ENV['DOMAIN'] ?? 'warriors.example.com');
}
if (!defined('LINK')) {
    define('LINK', $_ENV['LINK'] ?? 'https://github.com/username/');
}
if (!defined('EMAIL')) {
    define('EMAIL', $_ENV['EMAIL'] ?? 'info@example.com');
}
if (!defined('TELEGRAM')) {
    define('TELEGRAM', $_ENV['TELEGRAM'] ?? 'https://t.me/yourtelegram');
}
if (!defined('PHONE')) {
    define('PHONE', $_ENV['PHONE'] ?? '+1234567890');
}
if (!defined('ADDRESS')) {
    define('ADDRESS', $_ENV['ADDRESS'] ?? '123 Warrior Street, City, Country');
}
if (!defined('COMPANY_NAME')) {
    define('COMPANY_NAME', $_ENV['COMPANY_NAME'] ?? 'Warriors Inc.');
}

// Social media links
if (!defined('SOCIAL_FACEBOOK')) {
    define('SOCIAL_FACEBOOK', $_ENV['SOCIAL_FACEBOOK'] ?? '#');
}
if (!defined('SOCIAL_INSTAGRAM')) {
    define('SOCIAL_INSTAGRAM', $_ENV['SOCIAL_INSTAGRAM'] ?? '#');
}
if (!defined('SOCIAL_TWITTER')) {
    define('SOCIAL_TWITTER', $_ENV['SOCIAL_TWITTER'] ?? '#');
}
if (!defined('SOCIAL_LINKEDIN')) {
    define('SOCIAL_LINKEDIN', $_ENV['SOCIAL_LINKEDIN'] ?? '#');
}
if (!defined('SOCIAL_YOUTUBE')) {
    define('SOCIAL_YOUTUBE', $_ENV['SOCIAL_YOUTUBE'] ?? '#');
}
if (!defined('SOCIAL_TELEGRAM')) {
    define('SOCIAL_TELEGRAM', $_ENV['SOCIAL_TELEGRAM'] ?? '#');
}

// Google Analytics (optional)
if (!defined('GA_TRACKING_ID')) {
    define('GA_TRACKING_ID', $_ENV['GA_TRACKING_ID'] ?? null);
}

// Load other constants after basic path configurations
require_once __DIR__ . '/constants.php';