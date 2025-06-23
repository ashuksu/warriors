<?php

namespace App\Services;

/**
 * A simple, high-performance caching service wrapping APCu.
 */
class CacheService
{
    private bool $isEnabled;

    public function __construct()
    {
        $this->isEnabled = extension_loaded('apcu') && apcu_enabled();
    }

    /**
     * Fetch an item from the cache.
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed
    {
        if (!$this->isEnabled) return $default;
        $value = apcu_fetch($key, $success);
        return $success ? $value : $default;
    }

    /**
     * Store an item in the cache.
     * @param string $key
     * @param mixed $data
     * @param int $ttl
     * @return bool
     */
    public function set(string $key, mixed $data, int $ttl = 3600): bool
    {
        if (!$this->isEnabled) return false;
        return apcu_store($key, $data, $ttl);
    }

    /**
     * Clear the entire APCu cache.
     * @return bool
     */
    public function clear(): bool
    {
        if (!$this->isEnabled) {
            return false;
        }
        return apcu_clear_cache();
    }

    /**
     * Delete an item from the cache.
     * @param string $key
     * @return bool
     */
    public function delete(string $key): bool
    {
        if (!$this->isEnabled) {
            return false;
        }
        return apcu_delete($key);
    }
}