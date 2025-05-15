<?php

/**
 * Service for handling catalog data operations
 * Provides caching and error handling for catalog data
 */
class CatalogService
{
    private static $instance = null;
    private $cache = [];
    private $basePath;

    /**
     * Private constructor to enforce singleton pattern
     */
    private function __construct()
    {
        // Get the base path of the application
        $this->basePath = dirname(dirname(dirname(__FILE__)));
    }

    /**
     * Get singleton instance
     *
     * @return CatalogService
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Get catalog items with caching
     *
     * @return array Catalog items
     */
    public function getCatalogItems()
    {
        // Check if data is already cached
        if (isset($this->cache['catalog_items'])) {
            return $this->cache['catalog_items'];
        }

        try {
            $catalogData = $this->loadCatalogData();
            $items = $catalogData['items'] ?? [];

            // Cache the result
            $this->cache['catalog_items'] = $items;

            return $items;
        } catch (Exception $e) {
            // Log error or handle it appropriately
            error_log('Error loading catalog data: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Load catalog data from JSON file
     *
     * @return array Catalog data
     * @throws Exception If file cannot be read or JSON is invalid
     */
    private function loadCatalogData()
    {
        $catalogJsonPath = $this->basePath . '/data/sections/catalog.json';

        if (!file_exists($catalogJsonPath)) {
            throw new Exception('Catalog JSON file not found: ' . $catalogJsonPath);
        }

        $jsonContent = file_get_contents($catalogJsonPath);
        if ($jsonContent === false) {
            throw new Exception('Failed to read catalog JSON file');
        }

        $catalogData = json_decode($jsonContent, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Invalid JSON in catalog file: ' . json_last_error_msg());
        }

        return $catalogData;
    }

    /**
     * Clear the cache
     */
    public function clearCache()
    {
        $this->cache = [];
    }
}