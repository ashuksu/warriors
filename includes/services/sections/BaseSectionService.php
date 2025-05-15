<?php

require_once __DIR__ . '/../DataLoader.php';

/**
 * Base service class for handling section data operations.
 * Provides common functionality for all section services including
 * caching, error handling, and data retrieval.
 *
 * @abstract
 */
abstract class BaseSectionService
{
    protected static $instance = null;
    protected $cache = [];
    protected $basePath;

    /**
     * Protected constructor to enforce singleton pattern.
     * Initializes the base path for the service.
     * This constructor should be called by child classes.
     *
     * @protected
     */
    protected function __construct()
    {
        // Get the base path of the application
        $this->basePath = dirname(dirname(dirname(__FILE__)));
    }

    /**
     * Get section data with caching.
     * Retrieves data for the specified section and type from the data source.
     * Results are cached to improve performance on subsequent calls.
     *
     * @param string $section Section name (e.g., 'catalog', 'about')
     * @param string|null $type Type of data to return (e.g., 'items', 'title'). 
     *                          If null, returns the entire section data.
     * @return mixed Section data based on requested type. Returns empty string on error.
     * @throws Exception Exceptions are caught internally and logged
     */
    protected function getSectionData($section, $type = null)
    {
        $cacheKey = $section . ($type !== null ? '_' . $type : '');

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

            // Cache the result for this specific type
            $this->cache[$cacheKey] = $result;
            return $result;
        } catch (Exception $e) {
            error_log('Error loading ' . $section . ' data: ' . $e->getMessage());
            return '';
        }
    }

    /**
     * Clear the cache.
     * Removes all cached data for this service instance,
     * forcing subsequent calls to getSectionData to fetch fresh data.
     *
     * @return void
     */
    public function clearCache()
    {
        $this->cache = [];
    }
}
