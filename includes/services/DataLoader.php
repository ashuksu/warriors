<?php

/**
 * Utility class for loading data from JSON files
 * Provides error handling for data loading operations
 */
class DataLoader
{
    private static $instance = null;
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
     * @return DataLoader
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Load data from JSON file
     *
     * @param string $section Section name for error messages (e.g., 'catalog', 'about')
     * @return array Data from JSON file
     * @throws Exception If file cannot be read or JSON is invalid
     */
    public function loadData($section = '')
    {
        $jsonPath = $this->basePath . '/data/data.json';

        if (!file_exists($jsonPath)) {
            throw new Exception($section . ' JSON file not found: ' . $jsonPath);
        }

        $jsonContent = file_get_contents($jsonPath);
        if ($jsonContent === false) {
            throw new Exception('Failed to read ' . $section . ' JSON file');
        }

        $data = json_decode($jsonContent, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Invalid JSON in ' . $section . ' file: ' . json_last_error_msg());
        }

        return $data;
    }
}