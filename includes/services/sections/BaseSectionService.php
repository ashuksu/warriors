<?php

require_once __DIR__ . '/../DataLoader.php';

/**
 * Base service class for handling section data operations
 * Provides common functionality for all section services
 */
abstract class BaseSectionService
{
    protected static $instance = null;
    protected $cache = [];
    protected $basePath;

    /**
     * Private constructor to enforce singleton pattern
     */
    protected function __construct()
    {
        // Get the base path of the application
        $this->basePath = dirname(dirname(dirname(__FILE__)));
    }

    /**
     * Get section data with caching
     *
     * @param string $section Section name (e.g., 'catalog', 'about')
     * @param string $type Type of data to return (e.g., 'items', 'title')
     * @return mixed Section data based on requested type
     */
    protected function getSectionData($section, $type = 'items')
    {
        $cacheKey = $section . '_' . $type;

        // Check if data is already cached
        if (isset($this->cache[$cacheKey])) {
            return $this->cache[$cacheKey];
        }

        try {
            $data = DataLoader::getInstance()->loadData($section);
            $result = $data[$section][$type] ?? [];

            // Cache the result
            $this->cache[$cacheKey] = $result;

            return $result;
        } catch (Exception $e) {
            // Log error or handle it appropriately
            error_log('Error loading ' . $section . ' data: ' . $e->getMessage());

            // Return appropriate default value based on type
            if ($type === 'title') {
                return '';
            } elseif (is_numeric($type) || $type === 'counter') {
                return 0;
            } elseif ($type === 'bool') {
                return false;
            } else {
                return [];
            }
        }
    }

    /**
     * Universal method to get any section data
     *
     * @param string $section Section name (e.g., 'catalog', 'about', 'another')
     * @param string $type Type of data to return (e.g., 'items', 'title', 'bool')
     * @return mixed Section data based on requested type
     */
    public function getSection($section, $type = 'items')
    {
        return $this->getSectionData($section, $type);
    }

    /**
     * Clear the cache
     */
    public function clearCache()
    {
        $this->cache = [];
    }
}
