<?php

namespace App\Helpers;

/**
 * Vite integration helper class
 *
 * Provides functionality to integrate Vite assets (CSS and JavaScript)
 * into the application, handling both development and production modes.
 * Supports processing of SCSS, CSS, and JavaScript files.
 */
class Vite
{
    /**
     * Path to the Vite manifest file
     *
     * @var string
     */
    private static string $manifestFile = __DIR__ . '/../../public/dist/.vite/manifest.json';

    /**
     * Cached manifest data
     *
     * @var array|null
     */
    private static ?array $manifest = null;

    /**
     * Get the asset path for a file, handling both development and production environments
     *
     * Takes a source file path and returns the appropriate URL:
     * - In development: Returns Vite dev server URL for the file
     * - In production: Returns the hashed filename from the manifest
     *
     * Supports various file types including
     * - CSS files (src/css/style.css, src/css/libs/animate.min.css)
     * - SCSS files (src/scss/main.scss)
     * - JavaScript files (src/js/modules/Menu.js, src/js/modules/utils/Toggle.js)
     *
     * @param string $file Source file path (e.g., 'src/scss/criticalStyles.scss', 'src/js/modules/Menu.js')
     * @return string URL to the processed asset
     * @throws \RuntimeException When a manifest file is not found in production mode
     */
    public static function getAssetPath(string $file): string
    {
        // Development mode
        if (defined('IS_DEV') && IS_DEV) {
            return VITE_DEV_SERVER . $file;
        }

        // Production mode
        $manifest = self::getManifest();
        if (!$manifest) {
            throw new \RuntimeException('Vite manifest file not found. Please run npm run build first.');
        }

        // Check if the file exists directly in the manifest
        if (isset($manifest[$file])) {
            return DIST_PATH . $manifest[$file]['file'];
        }

        // Check for imported files that might have different keys in the manifest
        foreach ($manifest as $key => $value) {
            // Check if the file is part of the key (for imported modules)
            if (strpos($key, $file) !== false) {
                return DIST_PATH . $value['file'];
            }
        }

        // If the file not found in manifest, return the original path through dist
        // This is a fallback and should log a warning in production
        trigger_error("Asset {$file} not found in Vite manifest", E_USER_WARNING);
        return DIST_PATH . $file;
    }

    /**
     * Get the Vite manifest file contents
     *
     * Reads and caches the manifest file that contains mappings of original
     * filenames to hashed filenames for production builds.
     *
     * @return array|null The manifest data as an array, or null if the file doesn't exist
     */
    private static function getManifest(): ?array
    {
        if (self::$manifest !== null) {
            return self::$manifest;
        }

        if (!file_exists(self::$manifestFile)) {
            return null;
        }

        self::$manifest = json_decode(file_get_contents(self::$manifestFile), true);
        return self::$manifest;
    }
}