<?php

namespace App\Services;

use Exception;

/**
 * Manages all content data including pages and sections.
 * Loads, caches, resolves variables, and provides structured access.
 */
class ContentService
{
    private DataLoaderService $dataLoader;
    private CacheService $cache;
    private ConfigService $configService;

    public function __construct(
        DataLoaderService $dataLoader,
        CacheService $cache,
        ConfigService $configService
    ) {
        $this->dataLoader = $dataLoader;
        $this->cache = $cache;
        $this->configService = $configService;
    }

    /**
     * @throws Exception
     */
    public function get(string $type, string $name, ?string $key = null, ?string $id = null): mixed
    {
        $tableName = $type . 's';
        $cacheKey = "{$tableName}_{$name}";

        $resolvedContent = $this->cache->get($cacheKey);

        if ($resolvedContent === null) {
            $rawContent = $this->dataLoader->load($tableName, $name);

            if (empty($rawContent)) {
                error_log("ContentService: Content '{$type}.{$name}' not found.");
                $this->cache->set($cacheKey, null, $this->configService->get('cache_ttl', 3600));
                return null;
            }

            $resolvedContent = $this->resolveContent($rawContent);

            $this->cache->set($cacheKey, $resolvedContent, $this->configService->get('cache_ttl', 3600));
            error_log("ContentService: '{$type}.{$name}' loaded, resolved and cached.");
        }

        return $this->navigateContent($resolvedContent, $key, $id);
    }

    /**
     * @throws Exception
     */
    public function getAll(string $type): array
    {
        $tableName = $type . 's';
        $cacheKey = "all_{$tableName}";

        $resolvedContents = $this->cache->get($cacheKey);

        if ($resolvedContents === null) {
            $rawContents = $this->dataLoader->loadAll($tableName);

            if (empty($rawContents)) {
                error_log("ContentService: No '{$type}' content found.");
                $this->cache->set($cacheKey, [], $this->configService->get('cache_ttl', 3600));
                return [];
            }

            $resolvedContents = array_map(fn($item) => $this->resolveContent($item), $rawContents);

            $this->cache->set($cacheKey, $resolvedContents, $this->configService->get('cache_ttl', 3600));
            error_log("ContentService: All '{$type}' content loaded, resolved and cached.");
        } else {
            error_log("ContentService: All '{$type}' content loaded from cache.");
        }

        return $resolvedContents;
    }

    /**
     * Recursively resolves content (string or array).
     */
    private function resolveContent(mixed $value): mixed
    {
        if (is_array($value)) {
            foreach ($value as $key => $item) {
                $value[$key] = $this->resolveContent($item);
            }
            return $value;
        }

        if (!is_string($value)) {
            return $value;
        }

        return $this->resolveString($value);
    }

    /**
     * Resolves variable placeholders in a string.
     */
    private function resolveString(string $value): string
    {
        // {{VAR}} syntax
        $value = preg_replace_callback('/\{\{([A-Za-z_][A-Za-z0-9_]*)\}\}/', function($matches) {
            return $this->resolveSingleVariable($matches[1]) ?? $matches[0];
        }, $value);

        // $VAR and CONSTANT_NAME
        return preg_replace_callback('/(\$[A-Za-z_][A-Za-z0-9_]*|\b[A-Z_][A-Z0-9_]*\b)/', function($matches) {
            $token = $matches[0];

            if (str_starts_with($token, '$')) {
                return $this->resolveSingleVariable(substr($token, 1)) ?? $token;
            }

            if (defined($token)) {
                return constant($token);
            }

            return $token;
        }, $value);
    }

    /**
     * Resolves a single variable from config, globals, or constants.
     */
    private function resolveSingleVariable(string $name): ?string
    {
        foreach (['database', 'vite', 'contacts', 'social', null] as $scope) {
            $key = $scope ? "{$scope}.{$name}" : $name;
            $val = $this->configService->get(strtolower($key));
            if ($val !== null) {
                return $val;
            }
        }

        if (isset($GLOBALS[$name])) {
            return $GLOBALS[$name];
        }

        if (defined($name)) {
            return constant($name);
        }

        return null;
    }

    private function navigateContent(mixed $data, ?string $key = null, ?string $id = null): mixed
    {
        if ($key !== null) {
            if (is_array($data) && isset($data[$key])) {
                $data = $data[$key];
            } else {
                error_log("ContentService: Key '{$key}' not found.");
                return null;
            }
        }

        if ($id !== null && is_array($data)) {
            foreach ($data as $item) {
                if (isset($item['id']) && $item['id'] === $id) {
                    return $item;
                }
            }
            error_log("ContentService: ID '{$id}' not found in '{$key}'.");
            return null;
        }

        return $data;
    }
}
