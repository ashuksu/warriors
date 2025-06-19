<?php

namespace App\Helpers;

/**
 * Simple in-memory file cache class.
 *
 * Provides basic caching functionality for file existence checks
 * or other frequently accessed data to reduce redundant operations.
 */
class FileCache
{
    /**
     * @var array Internal static cache storage.
     */
    private static array $cache = [];

    /**
     * Checks if a key exists in the cache.
     *
     * @param string $key The cache key to check.
     * @return bool True if the key exists, false otherwise.
     */
    public static function has(string $key): bool
    {
        return isset(self::$cache[$key]);
    }

    /**
     * Retrieves a value from the cache by its key.
     *
     * @param string $key The cache key to retrieve.
     * @return mixed|null The cached value, or null if the key does not exist.
     */
    public static function get(string $key)
    {
        return self::$cache[$key] ?? null;
    }

    /**
     * Sets a value in the cache with the given key.
     *
     * @param string $key The cache key.
     * @param mixed $value The value to store in the cache.
     * @return void
     */
    public static function set(string $key, $value): void
    {
        self::$cache[$key] = $value;
    }
}