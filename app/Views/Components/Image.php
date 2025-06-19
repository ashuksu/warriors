<?php

namespace App\Views\Components;

use function App\Helpers\getPath;
use function App\Helpers\fileExists;
use function App\Helpers\validateExternalUrl;

/**
 * Responsive image component with WebP support
 *
 * Features:
 * - WebP format with fallback formats
 * - Multiple responsive sizes (1200, 800, 400)
 * - Lazy loading with configurable priority
 * - External URL validation
 * - File existence caching
 * - Broken image fallback
 */
class Image
{
    private const EXT = 'webp';
    private const SKIP_PROCESSING_FORMATS = ['svg', 'gif', 'webp'];
    private const FILES_SIZES = [1200, 800, 400];
    private const FALLBACK_IMAGE_SIZE = 800;
    private const BROKEN_IMAGE_PATH = 'broken-image.svg';
    private const DEFAULT_SIZES_ATTR = '(min-width: 1200px) 1200px, (min-width: 800px) calc(100vw - 30px), (min-width: 400px) calc(100vw - 30px), calc(100vw - 30px)';

    private static string $fallbackImagePath = '';
    private const DIST_STATUS_ATTR = 'data-not-dist="not from dist/"';

    /**
     * Render a responsive image with appropriate attributes
     *
     * @param array{
     * url?: string,            Path to image or external URL
     * alt?: string,            Alt text for the image
     * width?: int,            Image width
     * height?: int,            Image height
     * attr?: string,            Additional HTML attributes
     * srcset?: string,        Custom srcset attribute
     * sizes?: string,        Custom sizes attribute
     * fetchpriority?:string,    Resource loading priority
     * decoding?: string,        Image decoding mode
     * noLazy?:                bool Disable lazy loading
     * } $params
     * @return string HTML image tag
     */
    public static function render(array $params = []): string
    {
        $alt = !empty($params['alt']) ? htmlspecialchars($params['alt'], ENT_QUOTES) : 'image';
        $width = $params['width'] ?? 600;
        $height = $params['height'] ?? 600;
        $attr = ($params['attr'] ?? '');
        $url = $params['url'] ?? '';
        $pathInfo = pathinfo($url);

        if (!$url
            || empty($params['url'])
            || !isset($pathInfo['dirname'])
            || !isset($pathInfo['filename'])
            || !isset($pathInfo['extension'])) {

            return self::renderImage(
                getPath(self::BROKEN_IMAGE_PATH),
                $alt,
                $width,
                $height,
                $attr,
                $params);
        }

        $originalExt = strtolower($pathInfo['extension']);

        // Handle external URLs
        if (validateExternalUrl($url)) {
            return self::renderImage(
                htmlspecialchars($url, ENT_QUOTES),
                $alt,
                $width,
                $height,
                $attr,
                $params
            );
        }

        $fallbackImage = self::updateImage($url) === false ? getPath(self::BROKEN_IMAGE_PATH) : self::updateImage($url);

        $statusSrc = (self::updateImage($url) !== false && $fallbackImage === self::transformAssetUrl($url)) ? self::DIST_STATUS_ATTR : '';

        self::setFallbackImagePath($fallbackImage);

        // Handle non-processable formats
        if (in_array($originalExt, self::SKIP_PROCESSING_FORMATS)) {
            return self::renderImage(
                self::getFallbackImagePath(),
                $alt,
                $width,
                $height,
                $attr . $statusSrc,
                $params
            );
        }

        // Handle local images with processing
        $fallbackImagePath = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '-' . self::FALLBACK_IMAGE_SIZE . '.' . $originalExt;

        $fallbackImage = self::updateImage($fallbackImagePath) === false ? $fallbackImage : self::updateImage($fallbackImagePath);

        $statusSrc = (self::updateImage($fallbackImagePath) === false && $fallbackImage === self::transformAssetUrl($url)) ? self::DIST_STATUS_ATTR : '';

        self::setFallbackImagePath($fallbackImage);

        $responsiveAttrs = is_array(self::getOptimizedFilesPaths($pathInfo))
            ? self::getResponsiveAttributes(self::getOptimizedFilesPaths($pathInfo))
            : [];

        return self::renderImage(
            self::getFallbackImagePath(),
            $alt,
            $width,
            $height,
            $attr . $statusSrc,
            $params,
            $responsiveAttrs
        );
    }

    /**
     * Set fallback image path
     */
    public static function setFallbackImagePath(string $path): void
    {
        self::$fallbackImagePath = $path;
    }

    /**
     * Get fallback image path
     */
    public static function getFallbackImagePath(): string
    {
        return self::$fallbackImagePath ?: getPath(self::BROKEN_IMAGE_PATH);
    }

    /**
     * Get updated image path of BROKEN_IMAGE
     */
    public static function updateImage(string $url): string|bool
    {
        $result = false;
        $Image = fileExists($url);
        $originalImage = fileExists(self::transformAssetUrl($url));

        if ($Image !== false) {
            $result = getPath($Image);
        } else if ($originalImage !== false) {
            $result = getPath($originalImage);
        }

        return $result;
    }

    /**
     * Transforms the asset URL, replacing '/dist/' with '/src/' only if '/dist/'
     * is at the beginning of the path after the domain or at the beginning of a relative path.
     *
     * @param string $url The URL of the asset (e.g. "http://localhost:5173/dist/assets/images/item.svg" or "/dist/assets/images/items.svg")
     * @return string The transformed URL
     */
    private static function transformAssetUrl(string $url): string
    {
        $parts = parse_url($url);

        $scheme = $parts['scheme'] ?? '';
        $host = $parts['host'] ?? '';
        $port = $parts['port'] ?? '';
        $path = $parts['path'] ?? '';
        $query = $parts['query'] ?? '';
        $fragment = $parts['fragment'] ?? '';

        $baseUrl = '';
        if (!empty($scheme) && !empty($host)) {
            $baseUrl .= $scheme . '://' . $host;
            if (!empty($port)) {
                $baseUrl .= ':' . $port;
            }
        }

        // Check if the path starts with '/dist/'
        if (str_starts_with($path, '/dist/')) {
            // Replace '/dist/' with '/src/' only at the beginning of the path
            $newPath = '/src/' . substr($path, strlen('/dist/'));
        } else {
            $newPath = $path;
        }

        $newUrl = $baseUrl . $newPath;
        if (!empty($query)) {
            $newUrl .= '?' . $query;
        }
        if (!empty($fragment)) {
            $newUrl .= '#' . $fragment;
        }

        return $newUrl;
    }

    /**
     * Generate responsive image HTML tag
     */
    private static function renderImage(
        string $src,
        string $alt,
        int    $width,
        int    $height,
        string $attr,
        array  $params,
        array  $responsiveAttrs = []
    ): string
    {
        $loadingAttrs = self::getLoadingAttributes($params);

        ob_start(); ?>
		<img src="<?= htmlspecialchars($src, ENT_QUOTES) ?>"
            <?= $responsiveAttrs['srcset'] ?? '' ?>
            <?= $responsiveAttrs['sizes'] ?? '' ?>
			 alt="<?= $alt ?>"
			 width="<?= htmlspecialchars((string)$width, ENT_QUOTES) ?>"
			 height="<?= htmlspecialchars((string)$height, ENT_QUOTES) ?>"
            <?= trim($loadingAttrs['fetchpriority']); ?>
            <?= trim($loadingAttrs['loading']); ?>
            <?= trim($loadingAttrs['decoding']); ?>
            <?= $attr ?>>
        <?php
        return trim(preg_replace('/\s+/', ' ', ob_get_clean()));
    }

    /**
     * Get file paths for original and processed images
     */
    private static function getOptimizedFilesPaths(array $pathInfo): string|array
    {
        $filePathList = [];
        $fallbackCount = 0;

        foreach (self::FILES_SIZES as $size) {
            $filePathList[$size] = $pathInfo['dirname'] . '/' . $pathInfo['filename'] .
                '-' . $size . '.' . self::EXT;

            if (!fileExists($filePathList[$size])) {
                $filePathList[$size] = self::getFallbackImagePath();
                $fallbackCount++;
            }
        }

        return $fallbackCount === count(self::FILES_SIZES) ? self::getFallbackImagePath() : $filePathList;
    }

    /**
     * Get loading-related attributes
     */
    private static function getLoadingAttributes(array $params): array
    {
        $fetchpriority = !empty($params['fetchpriority'])
            ? 'fetchpriority="' . htmlspecialchars($params['fetchpriority'], ENT_QUOTES) . '"'
            : '';

        $loading = (!isset($params['fetchpriority']) || $params['fetchpriority'] !== 'high' && empty($params['noLazy']))
            ? 'loading="lazy"' : '';

        $decoding = 'decoding="' . htmlspecialchars($params['decoding'] ?? 'async', ENT_QUOTES) . '"';

        return compact('fetchpriority', 'loading', 'decoding');
    }

    /**
     * Get responsive image attributes
     */
    private static function getResponsiveAttributes(array $filesPaths): array
    {
        $srcsetEntries = [];

        foreach ($filesPaths as $size => $path) {
            $srcsetEntries[] = "$path {$size}w";
        }

        return [
            'srcset' => !empty($srcsetEntries)
                ? 'srcset="' . implode(', ', $srcsetEntries) . '"'
                : '',
            'sizes' => !empty($srcsetEntries)
                ? 'sizes="' . self::DEFAULT_SIZES_ATTR . '"'
                : ''
        ];
    }
}