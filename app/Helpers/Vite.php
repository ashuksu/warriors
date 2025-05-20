<?php

namespace App\Helpers;

/**
 * Vite integration helper class
 * 
 * Provides functionality to integrate Vite assets (CSS and JavaScript)
 * into the application, handling both development and production modes.
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
     * Get all assets (styles and scripts) for the application
     * 
     * In development mode, returns links to the Vite dev server.
     * In production mode, reads the manifest file to get the hashed asset filenames.
     * 
     * @return array Array with 'styles' and 'scripts' keys containing asset information
     * @throws \RuntimeException If manifest file is not found in production mode
     */
    public static function assets(): array
    {
        if (defined('IS_DEV') && IS_DEV && isViteServerRunning()) {
            return [
                'styles' => [
                    ['href' => getAssetPath('src/scss/main.scss')],
                    ['href' => getAssetPath('src/css/style.css')],
                    ['href' => getAssetPath('src/css/criticalStyles.css')]
                ],
                'scripts' => [
                    ['src' => VITE_DEV_CLIENT, 'type' => 'module'],
                    ['src' => getAssetPath('src/js/script.js'), 'type' => 'module']
                ]
            ];
        }

        $manifest = self::getManifest();

        if (!$manifest) {
            throw new \RuntimeException('Vite manifest file not found. Please run npm run build first.');
        }

        $styles = [];
        $scripts = [];

        foreach ($manifest as $entry => $file) {
            if (str_ends_with($entry, '.css') || str_ends_with($entry, '.scss')) {
                $styles[] = ['href' => '/dist/' . $file['file']];
            } else if (str_ends_with($entry, '.js')) {
                $scripts[] = [
                    'src' => '/dist/' . $file['file'],
                    'type' => 'module'
                ];
            }
        }

        return [
            'styles' => $styles,
            'scripts' => $scripts
        ];
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