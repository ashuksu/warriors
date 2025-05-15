<?php

require_once __DIR__ . '/../DataLoader.php';

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
            $aboutData = DataLoader::getInstance()->loadData('about');
            $items = $aboutData['about']['items'] ?? [];
            $this->cache['about_items'] = $items;

            return $items;
        } catch (Exception $e) {
            // Log error or handle it appropriately
            error_log('Error loading about data: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Clear the cache
     */
    public function clearCache()
    {
        $this->cache = [];
    }
}