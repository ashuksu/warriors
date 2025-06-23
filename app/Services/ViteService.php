<?php

namespace App\Services;

use RuntimeException;

/**
 * Service for Vite asset integration.
 * Handles asset path resolution for development and production builds.
 */
class ViteService
{
    private string $manifestFile;
    private ?array $manifest = null;
    private bool $isDev;
    private string $viteDevServer;
    private string $appPath;
    private string $distPath;

    public function __construct(ConfigService $configService)
    {
        $this->isDev = $configService->get('is_dev');
        $this->viteDevServer = $configService->get('vite.server');
        $this->manifestFile = $configService->get('vite.manifest_file');
        $this->appPath = $configService->get('app_path');
        $this->distPath = $configService->get('vite.dist');
    }

    /**
     * Gets the asset path for a given file.
     *
     * In development mode, returns the Vite development server URL for the file.
     * In production, returns the hashed filename from the manifest file.
     *
     * @param string $file Source file path (e.g., 'src/styles/main.scss', 'src/js/modules/Menu.js').
     * @return string URL to the processed asset.
     * @throws RuntimeException If Vite manifest is not found in production mode.
     */
    public function getAssetPath(string $file): string
    {
        if ($this->isDev) {
            return $this->viteDevServer . $file;
        }

        $manifest = $this->getManifest();

        if ($manifest === null) {
            throw new RuntimeException('Vite manifest file not found in production. Please run `npm run build` first.');
        }

        // Check if the file exists directly as a key in the manifest
        if (isset($manifest[$file])) {
            return $this->distPath . $manifest[$file]['file'];
        }

        // Fallback: Check for imported files where the key might contain the file path
        foreach ($manifest as $key => $value) {
            if (str_contains($key, $file)) {
                return $this->distPath . $value['file'];
            }
        }

        // Fallback: If not found, return the original path through dist and log a warning
        error_log("Asset {$file} not found in Vite manifest. Returning original dist path.");
        return $this->distPath . $file;
    }

    /**
     * Gets Vite manifest file contents, with internal caching.
     *
     * @return array|null Manifest data as an array, or null if file does not exist.
     */
    private function getManifest(): ?array
    {
        if ($this->manifest !== null) {
            return $this->manifest;
        }

        if (!file_exists($this->manifestFile)) {
            return null;
        }

        $this->manifest = json_decode(file_get_contents($this->manifestFile), true);
        return $this->manifest;
    }
}