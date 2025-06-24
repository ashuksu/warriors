<?php

namespace App\Services;

use App\Services\CacheService;
use App\Services\ConfigService;
use RuntimeException;
use Exception;

/**
 * Service for Vite asset integration.
 * Handles asset path resolution for development and production builds.
 */
class PathService
{
    private string $manifestFile;
    private ?array $manifest = null;
    private bool $isDev;
    private string $viteDevServer;
    private string $appPath;
    private string $projectRoot;
    private string $distPath;
    private ConfigService $configService;
    private CacheService $cacheService;

    public function __construct(ConfigService $configService, CacheService $cacheService)
    {
        $this->configService = $configService;
        $this->cacheService = $cacheService;
        $this->appPath = $configService->get('app_path');
        $this->projectRoot = $configService->get('project_root');
        $this->distPath = $configService->get('vite.dist');
        $this->manifestFile = $configService->get('vite.manifest_file');
        $this->viteDevServer = $configService->get('vite.server');
        $this->isDev = $configService->get('is_dev');
    }

    /**
     * Get the appropriate asset path based on the application environment.
     *
     * In development mode (IS_DEV defined and true), it prepends the Vite development
     * server URL. Otherwise, it uses the application's base path.
     *
     * @param string $path The relative path to the asset (e.g., 'dist/css/style.css').
     * @return string The full, resolved URL or path to the asset.
     */
    function getPath(string $path): string
    {
        if ($this->isDev) return $this->viteDevServer . $path;
        return $this->appPath . $path;
    }

    /**
     * Gets the asset path for a given file.
     *
     * In development mode, return the Vite development server URL for the file.
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

        $manifest = $this->getViteManifest();

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
     * @return array|null Manifest data as an array, or null if a file does not exist.
     */
    private function getViteManifest(): ?array
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

    /**
     * Checks if a file exists on the server's file system, using a cache.
     * It resolves paths relative to the document root and handles Vite dev server URLs.
     * This function focuses *only* on checking local file system existence.
     *
     * @param string $path File path or URL to check for existence.
     * @return string|false The path to the found file (relative to DOCUMENT_ROOT),
     * or `false` if the file does not exist locally.
     * Note: It does NOT handle external URLs directly. External URL check
     * should happen *before* calling this function or in the calling context.
     * @throws Exception
     */
    public function fileExists(string $path): string|bool
    {
        $cacheKey = 'file_exists_' . md5($path);
        $cachedResult = $this->cacheService->get($cacheKey);

        if ($cachedResult !== null) {
            return $cachedResult;
        }

        $cleanPath = ltrim($path, '/');

        if (empty($cleanPath)) {
            $this->cacheService->set($cacheKey, false);
            return false;
        }

        // In dev mode, if the path contains the Vite server URL, strip it to check a local file system
        if ($this->isDev && str_starts_with($cleanPath, $this->viteDevServer)) {
            $cleanPath = str_replace($this->viteDevServer, '', $cleanPath);
            $cleanPath = ltrim($cleanPath, '/');
        }

        $result = false;
        $fullLocalPath = '';

        if (isset($_SERVER['DOCUMENT_ROOT']) && (file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $cleanPath))) {
            $fullLocalPath = $_SERVER['DOCUMENT_ROOT'] . '/' . $cleanPath;
        } else if (str_starts_with($cleanPath, 'src/') && (file_exists($this->projectRoot . $cleanPath))) {
            $fullLocalPath = $this->projectRoot . $cleanPath;
        }

        $fullLocalPath = str_replace('//', '/', $fullLocalPath);

        if (!empty($fullLocalPath) && file_exists($fullLocalPath)) {
            $result = $cleanPath;
        }

        $this->cacheService->set($cacheKey, $result);

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
     * @throws Exception
     */
    public function validateExternalUrl(string $url): bool
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
        if (empty($host) || $host === ($_SERVER['HTTP_HOST'] ?? '') || $host === $this->configService->get('domain')) {
            return false;
        }

        // Check if it's the Vite development server URL in dev mode
        if ($this->isDev && str_starts_with($url, $this->viteDevServer)) {
            return false;
        }

        $allowedImageDomains = $this->configService->get('images.allowed_domains');

        // Check if the ALLOWED_IMAGE_DOMAINS constant is defined and is an array.
        if (!is_array($allowedImageDomains) || empty($allowedImageDomains)) {
            // Log an error or handle misconfiguration if this setting is missing/invalid.
            error_log("ConfigService: 'images.allowed_domains' is not configured or is empty. External image validation will fail.");
            return false;
        }

        // Finally, check if the host is in the allowlist.
        return in_array($host, $allowedImageDomains);
    }
}