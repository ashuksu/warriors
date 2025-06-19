<?php

namespace App\Helpers;

use App\Helpers\FileCache;

/**
 * Helper functions for the application
 *
 * This file contains a collection of utility functions to assist
 * with common application tasks, including templating, asset path resolution,
 * caching, file existence checks, and URL validation.
 */

/**
 * Render a template file with provided parameters.
 *
 * Extracts the parameters into local variables within the template's scope
 * and includes the template file, making the parameters directly accessible.
 *
 * @param string $templatePath Absolute path to the template file.
 * @param array $params Associative array of parameters to be extracted
 * as variables in the template. Defaults to an empty array.
 * @return void
 */
function renderTemplate(string $templatePath, array $params = []): void
{
    extract($params);
    require $templatePath;
}

/**
 * Get the appropriate asset path based on the application environment.
 *
 * In development mode (IS_DEV defined and true), it prepends the Vite development
 * server URL. Otherwise, it uses the application's base path.
 *
 * @param string $path The relative path to the asset (e.g., 'dist/css/style.css').
 * @return string The full, resolved URL or path to the asset.
 *
 * @uses IS_DEV      Global constant: true if in development mode, false otherwise.
 * @uses VITE_DEV_SERVER Global constant: Base URL of the Vite development server (e.g., 'http://localhost:5173/').
 * @uses APP_PATH    Global constant: Base path/URL of the application (e.g., '/').
 */
function getPath(string $path): string
{
    // Use Vite server in dev mode only if it's running
    if (defined('IS_DEV') && IS_DEV) {
        return VITE_DEV_SERVER . $path;
    }

    return APP_PATH . $path;
}

/**
 * Checks if a file exists on the server's file system, utilizing a cache.
 * It resolves paths relative to the document root and handles Vite dev server URLs.
 * This function focuses *only* on checking local file system existence.
 *
 * @param string $path File path or URL to check for existence.
 * @return string|false The path to the found file (relative to DOCUMENT_ROOT),
 * or `false` if the file does not exist locally.
 * Note: It does NOT handle external URLs directly. External URL check
 * should happen *before* calling this function or in the calling context.
 *
 * @uses FileCache::has() To check if the file existence is already cached.
 * @uses FileCache::get() To retrieve cached file existence status.
 * @uses FileCache::set() To store the file existence status in cache.
 * @uses IS_DEV      Global constant: true if in development mode.
 * @uses VITE_DEV_SERVER Global constant: Base URL of the Vite development server.
 * @uses PROJECT_ROOT Global constant: Absolute path to the project root directory.
 * @uses $_SERVER['DOCUMENT_ROOT'] Server variable pointing to the document root directory.
 */
function fileExists(string $path): string|bool
{
    if (FileCache::has($path)) {
        return FileCache::get($path);
    }

    $originalPath = $path;
    $cleanPath = ltrim($path, '/');

    if (empty($cleanPath)) {
        FileCache::set($originalPath, false);
        return false;
    }

    // In dev mode, if the path contains the Vite server URL, strip it to check local file system
    if (defined('IS_DEV') && IS_DEV && defined('VITE_DEV_SERVER') && strpos($cleanPath, VITE_DEV_SERVER) === 0) {
        $cleanPath = str_replace(VITE_DEV_SERVER, '', $cleanPath);
        $cleanPath = ltrim($cleanPath, '/'); // Clean again after replacement
    }

    $result = false;
    $fullLocalPath = '';

    if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $cleanPath)) {
        $fullLocalPath = $_SERVER['DOCUMENT_ROOT'] . '/' . $cleanPath;
    } else if (defined('PROJECT_ROOT') && str_starts_with($cleanPath, 'src/') && file_exists(PROJECT_ROOT . $cleanPath)) {
        $fullLocalPath = PROJECT_ROOT . $cleanPath;
    }

    $fullLocalPath = str_replace('//', '/', $fullLocalPath);

    if (!empty($fullLocalPath) && file_exists($fullLocalPath)) {
        $result = $cleanPath;
    }

    FileCache::set($originalPath, $result);

    return $result;
}

/**
 * Validates if a given URL belongs to a list of allowed external domains.
 *
 * This function performs several checks:
 * 1. Basic URL format validation.
 * 2. Ensures the URL uses HTTP or HTTPS.
 * 3. Prevents validation for URLs pointing to the current host or defined domain.
 * 4. Checks if the URL's host is present in the `ALLOWED_IMAGE_DOMAINS` whitelist.
 *
 * @param string $url The URL string to validate.
 * @return bool True if the URL is from an allowed external domain, false otherwise.
 *
 * @uses ALLOWED_IMAGE_DOMAINS Global constant: An array of whitelisted external domains.
 * @uses $_SERVER['HTTP_HOST'] Server variable representing the current host.
 * @uses DOMAIN          Global constant: The primary domain of the application.
 * @uses IS_DEV          Global constant: true if in development mode.
 * @uses VITE_DEV_SERVER Global constant: Base URL of the Vite development server.
 */
function validateExternalUrl(string $url): bool
{
    // Basic URL format validation
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        return false;
    }

    // Ensure it's an HTTP/HTTPS URL
    if (!preg_match('/^https?:\/\//i', $url)) {
        return false;
    }

    $urlParts = parse_url($url);
    $host = $urlParts['host'] ?? '';

    // If no host is found, or it's an internal URL, it's not an external allowed domain.
    // Explicitly check if it's our own domain, current host, or Vite dev server.
    if (empty($host) || $host === $_SERVER['HTTP_HOST'] || (defined('DOMAIN') && $host === DOMAIN)) {
        return false;
    }

    // Check if it's the Vite development server URL in dev mode
    if (defined('IS_DEV') && IS_DEV && defined('VITE_DEV_SERVER') && strpos($url, VITE_DEV_SERVER) === 0) {
        return false;
    }

    // Check if the ALLOWED_IMAGE_DOMAINS constant is defined and is an array.
    if (!defined('ALLOWED_IMAGE_DOMAINS') || !is_array(ALLOWED_IMAGE_DOMAINS)) {
        // Log an error or handle misconfiguration if this constant is missing/invalid.
        return false;
    }

    // Finally, check if the host is in the whitelist.
    return in_array($host, ALLOWED_IMAGE_DOMAINS);
}