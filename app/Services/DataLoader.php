<?php

namespace Services;

use Exception; // For error handling

/**
 * DataLoader class
 * Responsible for loading dynamic data, typically from the database.
 */
class DataLoader
{
    private static ?DataLoader $instance = null;
    private array $cache = []; // Simple cache for loaded data to avoid redundant DB calls
    private Database $db;

    /**
     * Private constructor to prevent direct instantiation.
     * Initializes the database connection.
     *
     * @throws Exception If database connection fails during instantiation.
     */
    private function __construct()
    {
        try {
            $this->db = Database::getInstance();
        } catch (Exception $e) {
            error_log("DataLoader: Database connection failed: " . $e->getMessage());
            throw new Exception("DataLoader: Could not connect to database for data loading.", 0, $e);
        }
    }

    /**
     * Get the singleton instance of DataLoader.
     *
     * @return DataLoader
     */
    public static function getInstance(): DataLoader
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Load section data by name from the database.
     * The 'content' column is stored as JSONB and parsed into a PHP array.
     *
     * @param string $sectionName The name of the section to load (e.g., 'about', 'menu').
     * @return array The parsed section content, or an empty array if not found or decoding fails.
     * @throws Exception If database query fails.
     */
    public function loadSectionData(string $sectionName): array
    {
        // Check cache first to prevent redundant database queries
        if (isset($this->cache[$sectionName])) {
            return $this->cache[$sectionName];
        }

        $sql = "SELECT content FROM sections WHERE name = :name LIMIT 1";
        $params = [':name' => $sectionName];

        $result = $this->db->query($sql, $params);

        if (empty($result) || !isset($result[0]['content'])) {
            error_log("DataLoader: Section data for '{$sectionName}' not found in database.");
            // Cache as empty to avoid repeated lookups
            $this->cache[$sectionName] = [];
            return [];
        }

        $content = json_decode($result[0]['content'], true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log("DataLoader: Failed to decode JSON for section '{$sectionName}': " . json_last_error_msg());
            // Cache as empty on decode failure
            $this->cache[$sectionName] = [];
            return [];
        }

        // Cache as empty on decode failure
        $this->cache[$sectionName] = $content; // Cache the successful result

        return $content;
    }
}