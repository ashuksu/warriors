<?php

namespace App\Services;

use Exception;

/**
 * Loads raw data from database tables.
 * Decodes JSON content columns when applicable.
 */
class DataLoaderService
{
    private DatabaseService $db;

    public function __construct(DatabaseService $db)
    {
        $this->db = $db;
    }

    /**
     * Loads and parses content data by name from a specified table.
     *
     * This method fetches a single item's raw data. For 'sections' table,
     * it expects content in a JSONB column named 'content' and decodes it.
     * For other tables (like 'pages'), it fetches the entire row.
     *
     * @param string $tableName The name of the database table (e.g., 'pages', 'sections').
     * @param string $itemName The name of the item to load (e.g., page 'home', section 'about').
     * @return array Parsed content or the full row, or an empty array if not found or decoding fails.
     * @throws Exception If a database query fails.
     */
    public function load(string $tableName, string $itemName): array
    {
        // If fetching from 'sections', we expect a 'content' JSONB column.
        if ($tableName === 'sections') {
            $sql = "SELECT content FROM {$tableName} WHERE name = :name LIMIT 1";
            $params = [':name' => $itemName];

            try {
                $result = $this->db->query($sql, $params);
            } catch (Exception $e) {
                error_log("DataLoaderService: Database query failed for '{$tableName}.{$itemName}': " . $e->getMessage());
                throw $e;
            }

            if (empty($result) || !isset($result[0]['content'])) {
                error_log("DataLoaderService: Data for '{$tableName}.{$itemName}' not found or content column is missing.");
                return [];
            }

            $content = json_decode($result[0]['content'], true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                error_log("DataLoaderService: Failed to decode JSON for '{$tableName}.{$itemName}': " . json_last_error_msg());
                return [];
            }
            return $content;
        }

        // For other tables (like 'pages'), fetch the entire row directly.
        $sql = "SELECT * FROM {$tableName} WHERE name = :name LIMIT 1";
        $params = [':name' => $itemName];

        try {
            $result = $this->db->query($sql, $params);
            return $result[0] ?? []; // Return the first row or an empty array
        } catch (Exception $e) {
            error_log("DataLoaderService: Database query failed for '{$tableName}.{$itemName}': " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Loads all rows from a specified table.
     *
     * @param string $tableName The name of the database table.
     * @return array All loaded rows.
     * @throws Exception If a database query fails.
     */
    public function loadAll(string $tableName): array
    {
        $sql = "SELECT * FROM {$tableName}";
        try {
            return $this->db->query($sql);
        } catch (Exception $e) {
            error_log("DataLoaderService: Database query failed for '{$tableName}': " . $e->getMessage());
            throw $e;
        }
    }
}