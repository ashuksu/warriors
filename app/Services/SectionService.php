<?php

namespace App\Services;

use Exception;

/**
 * SectionService class
 * Manages access to section data, retrieving it via DataLoader and resolving variables.
 */
class SectionService
{
    private static ?SectionService $instance = null;
    private DataLoader $dataLoader;
    private ConfigVarResolver $configVarResolver;

    /**
     * Private constructor to prevent direct instantiation.
     * Initializes dependencies.
     */
    private function __construct()
    {
        $this->dataLoader = DataLoader::getInstance();
        $this->configVarResolver = ConfigVarResolver::getInstance();
    }

    /**
     * Get the singleton instance of SectionService.
     *
     * @return SectionService
     */
    public static function getInstance(): SectionService
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Statically retrieve and resolve section data.
     *
     * @param string $sectionName The name of the section (e.g., 'menu', 'popup').
     * @param string|null $key Optional key to retrieve a specific part of the section's content.
     * @param string|null $id Optional ID for items within a collection (e.g., 'popup', 'items', 'p002').
     * @return mixed The requested section data, or null if not found.
     * @throws Exception If an error occurs during data loading or resolution.
     */
    public static function get(string $sectionName, ?string $key = null, ?string $id = null): mixed
    {
        $instance = self::getInstance();
        return $instance->getSectionData($sectionName, $key, $id);
    }

    /**
     * Internal method to retrieve, resolve, and navigate section data.
     *
     * @param string $sectionName The name of the section.
     * @param string|null $key Optional key within the section content.
     * @param string|null $id Optional ID within a collection under the key.
     * @return mixed The requested data, or null if not found.
     * @throws Exception If data cannot be loaded or resolved.
     */
    private function getSectionData(string $sectionName, ?string $key = null, ?string $id = null): mixed
    {
        // Load the entire section content from the database via DataLoader
        $sectionContent = $this->dataLoader->loadSectionData($sectionName); // THIS IS THE KEY CHANGE FROM loadData()

        if (empty($sectionContent)) {
            error_log("SectionService: Section '{$sectionName}' not found or is empty after loading.");
            return null; // Return null if the section itself is not found
        }

        // Resolve variables within the loaded section content (e.g., {{APP_PATH}})
        $resolvedContent = $this->configVarResolver->resolveArray($sectionContent);

        // Navigate through the content based on provided key and id
        $data = $resolvedContent;

        if ($key !== null) {
            if (isset($data[$key])) {
                $data = $data[$key];
            } else {
                error_log("SectionService: Key '{$key}' not found in section '{$sectionName}'.");
                return null;
            }
        }

        if ($id !== null) {
            if (is_array($data)) {
                foreach ($data as $item) {
                    if (isset($item['id']) && $item['id'] === $id) {
                        return $item;
                    }
                }
                error_log("SectionService: ID '{$id}' not found within key '{$key}' of section '{$sectionName}'.");
            } else {
                error_log("SectionService: Attempted to search by ID '{$id}' on non-array data for section '{$sectionName}' and key '{$key}'.");
            }

            return null;
        }

        return $data;
    }
}