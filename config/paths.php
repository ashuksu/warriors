<?php

/**
 * Centralized path management for the application
 */

// Base paths
define('APP_PATH', $_ENV['APP_PATH'] ?? '/');
define('PROJECT_ROOT', $_ENV['PROJECT_ROOT'] ?? dirname(__DIR__) . '/');

// Vite development server configuration
define('VITE_DEV_SERVER', $_ENV['VITE_DEV_SERVER'] ?? 'http://localhost:5173/');
define('VITE_DEV_CLIENT', VITE_DEV_SERVER . '@vite/client');

// Asset paths
define('ASSETS_PATH', defined('IS_DEV') && IS_DEV ? VITE_DEV_SERVER : APP_PATH);
define('DIST_PATH', APP_PATH . 'dist/');
define('IMAGES_PATH', DIST_PATH . 'assets/images/');
define('STYLES_PATH', DIST_PATH . 'assets/css/');
define('SCRIPTS_PATH', DIST_PATH . 'assets/js/');

/**
 * Check if Vite development server is running
 *
 * @return bool True if the server is running, false otherwise
 */
function isViteServerRunning(): bool
{
    // todo: return true for running vite server; need to check if the server is running
    static $isRunning = null;

    if ($isRunning === null) {
        $isRunning = false;

        // Only check if we're in development mode
        if (defined('IS_DEV') && IS_DEV) {
            $ch = curl_init(VITE_DEV_SERVER);
            curl_setopt($ch, CURLOPT_NOBODY, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec($ch);
            $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $isRunning = $responseCode >= 200 && $responseCode < 300;
        }
    }

    return $isRunning;
}

/**
 * Get the appropriate asset path based on environment
 *
 * @param string $path The relative path to the asset
 * @param bool $isViteModule Whether the asset is a Vite module (only relevant in dev mode)
 * @return string The full path to the asset
 */
function getAssetPath(string $path, bool $isViteModule = false): string
{
    // Use Vite server in dev mode only if it's running
    if (defined('IS_DEV') && IS_DEV && isViteServerRunning()) {
        return VITE_DEV_SERVER . $path;
    }

    return APP_PATH . $path;
}
