<?php

namespace Services;

use Exception;

require_once __DIR__ . '/ConfigVarResolver.php';

/**
 * Utility class for loading data from JSON files
 * Provides error handling for data loading operations
 */
class DataLoader
{
    private static $instance = null;

    /**
     * Private constructor to enforce singleton pattern
     */
    private function __construct()
    {
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
        $jsonPath = PROJECT_ROOT . 'app/Models/Data/data.json';

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

        // Resolve config variables in the data
        $data = ConfigVarResolver::getInstance()->resolveArray($data);

        return $data;
    }
}
