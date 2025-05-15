<?php

/**
 * Service for handling about data operations
 * Provides caching and error handling for about data
 */
class AboutService
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
     * @return AboutService
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Get about items with caching
     *
     * @return array About items
     */
    public function getAboutItems()
    {
        if (isset($this->cache['about_items'])) {
            return $this->cache['about_items'];
        }

        try {
            $aboutData = $this->loadAboutData();
            $items = $aboutData['items'] ?? [];
            $this->cache['about_items'] = $items;

            return $items;
        } catch (Exception $e) {
            // Log error or handle it appropriately
            error_log('Error loading about data: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Load about data from JSON file
     *
     * @return array About data
     * @throws Exception If file cannot be read or JSON is invalid
     */
    private function loadAboutData()
    {
        $aboutJsonPath = $this->basePath . '/data/sections/about.json';

        if (!file_exists($aboutJsonPath)) {
            throw new Exception('About JSON file not found: ' . $aboutJsonPath);
        }

        $jsonContent = file_get_contents($aboutJsonPath);
        if ($jsonContent === false) {
            throw new Exception('Failed to read about JSON file');
        }

        $aboutData = json_decode($jsonContent, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Invalid JSON in about file: ' . json_last_error_msg());
        }

        return $aboutData;
    }

    /**
     * Clear the cache
     */
    public function clearCache()
    {
        $this->cache = [];
    }
}