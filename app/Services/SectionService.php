<?php

namespace Services;

use Exception;

/**
 * Service class for handling section data operations.
 * Provides caching and error handling for all section data.
 */
class SectionService
{
    protected static $instance = null;
    protected $cache = [];

    /**
     * Private constructor to enforce singleton pattern
     */
    protected function __construct()
    {
    }

    /**
     * Get section data with caching
     *
     * @param string $section Section name (e.g., 'catalog', 'about')
     * @param string|null $type Type of data to return (e.g., 'items', 'title')
     * @param string|null $id Optional ID to retrieve a specific item from an array
     * @param string ...$keys Optional additional keys for accessing nested properties
     * @return mixed Section data based on requested parameters. Returns empty string on error.
     */
    public static function get($section, $type = null, $id = null, ...$keys)
    {
        return self::getInstance()->getSectionData($section, $type, $id, ...$keys);
    }

    /**
     * Get section data with caching.
     * Retrieves data for the specified section and type from the data source.
     * Results are cached to improve performance on subsequent calls.
     *
     * @param string $section Section name (e.g., 'catalog', 'about')
     * @param string|null $type Type of data to return (e.g., 'items', 'title').
     *                          If null, returns the entire section data.
     * @param string|null $id Optional ID to retrieve a specific item from an array
     * @param string ...$keys Optional additional keys for accessing nested properties
     * @return mixed Section data based on requested parameters. Returns empty string on error.
     * @throws Exception Exceptions are caught internally and logged
     */
    protected function getSectionData($section, $type = null, $id = null, ...$keys)
    {
        $cacheKey = $section . ($type !== null ? '_' . $type : '');

        // Add id and keys to cache key if provided
        if ($id !== null) {
            $cacheKey .= '_' . $id;
            if (!empty($keys)) {
                $cacheKey .= '_' . implode('_', $keys);
            }
        }

        // Check if data is already in cache
        if (isset($this->cache[$cacheKey])) {
            return $this->cache[$cacheKey];
        }

        try {
            $data = DataLoader::getInstance()->loadData($section);

            // Cache the entire section data to avoid multiple loads
            if (!isset($this->cache[$section])) {
                $this->cache[$section] = $data[$section] ?? [];
            }

            // Return entire section if type is null
            if ($type === null) {
                $result = $this->cache[$section];
                $this->cache[$cacheKey] = $result;
                return $result;
            }

            // Return specific type if available
            if (!isset($this->cache[$section]) || !isset($this->cache[$section][$type])) {
                $result = '';
            } else {
                $result = $this->cache[$section][$type];
            }

            // If no ID is provided, return the type result
            if ($id === null) {
                $this->cache[$cacheKey] = $result;
                return $result;
            }

            // If result is not an array or is empty, return empty string
            if (!is_array($result) || empty($result)) {
                return '';
            }

            // Find the item with the specified ID
            $item = null;
            foreach ($result as $entry) {
                if (is_array($entry) && isset($entry['id']) && $entry['id'] === $id) {
                    $item = $entry;
                    break;
                }
            }

            // If item not found, return empty string
            if ($item === null) {
                return '';
            }

            // If no additional keys are provided, return the item
            if (empty($keys)) {
                $this->cache[$cacheKey] = $item;
                return $item;
            }

            // Navigate through nested properties
            $value = $item;
            foreach ($keys as $key) {
                if (!is_array($value) || !isset($value[$key])) {
                    $value = '';
                    break;
                }
                $value = $value[$key];
            }

            // Cache and return the final result
            $this->cache[$cacheKey] = $value;
            return $value;
        } catch (Exception $e) {
            error_log('Error loading ' . $section . ' data: ' . $e->getMessage());
            return '';
        }
    }

    /**
     * Get singleton instance
     *
     * @return self
     */
    private static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Clear the cache
     */
    public static function clearCache()
    {
        if (self::$instance !== null) {
            self::$instance->cache = [];
        }
    }
}
