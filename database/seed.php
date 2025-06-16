<?php
/**
 * Database Seeder Script
 *
 * This script is responsible for creating the database schema and populating
 * it with initial data from JSON files.
 * It uses the Services\Database class to interact with the PostgreSQL database.
 */

// Define PROJECT_ROOT if not already defined (important for paths)
if (!defined('PROJECT_ROOT')) {
    define('PROJECT_ROOT', dirname(__DIR__) . '/');
}

// Load Composer autoloader
require_once PROJECT_ROOT . 'vendor/autoload.php';

use Services\Database;
//use Services\ConfigVarResolver;

echo "Starting database seeding process...\n";

try {
    $db = Database::getInstance();
    $pdo = $db->getConnection(); // Get PDO connection for direct execution of SQL files

    // --- 1. Execute Schema SQL ---
    echo "Creating database schema...\n";
    $schemaSqlPath = PROJECT_ROOT . 'database/schema.sql';
    if (!file_exists($schemaSqlPath)) {
        throw new \Exception("Schema SQL file not found at: " . $schemaSqlPath);
    }
    $schemaSql = file_get_contents($schemaSqlPath);
    $pdo->exec($schemaSql); // Use exec for multiple statements
    echo "Schema created successfully.\n";

    // --- 2. Insert initial data into 'pages' table ---
    echo "Inserting initial page data from JSON...\n";
    $pagesJsonPath = PROJECT_ROOT . 'database/seeds/data/pages.json';
    if (!file_exists($pagesJsonPath)) {
        throw new \Exception("Pages JSON file not found at: " . $pagesJsonPath);
    }
    $pagesJson = file_get_contents($pagesJsonPath);
    $pagesData = json_decode($pagesJson, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new \Exception("Failed to decode pages JSON: " . json_last_error_msg());
    }

    foreach ($pagesData as $page) {
        // Prepare schema_address and schema_same_as as JSON strings
        $schemaAddress = isset($page['schema']['address']) ? json_encode($page['schema']['address']) : null;
        $schemaSameAs = isset($page['schema']['sameAs']) ? json_encode($page['schema']['sameAs']) : null;

        $sql = "INSERT INTO pages (name, title, description, keywords, h1, schema_type, schema_category, schema_address, schema_same_as, noindex)
                VALUES (:name, :title, :description, :keywords, :h1, :schema_type, :schema_category, :schema_address, :schema_same_as, :noindex)
                ON CONFLICT (name) DO UPDATE SET
                    title = EXCLUDED.title,
                    description = EXCLUDED.description,
                    keywords = EXCLUDED.keywords,
                    h1 = EXCLUDED.h1,
                    schema_type = EXCLUDED.schema_type,
                    schema_category = EXCLUDED.schema_category,
                    schema_address = EXCLUDED.schema_address,
                    schema_same_as = EXCLUDED.schema_same_as,
                    noindex = EXCLUDED.noindex;"; // Added ON CONFLICT for idempotency

        $params = [
            ':name'           => $page['name'],
            ':title'          => $page['title'],
            ':description'    => $page['description'],
            ':keywords'       => $page['keywords'],
            ':h1'             => $page['h1'],
            ':schema_type'    => $page['schema']['type'] ?? null,
            ':schema_category' => $page['schema']['category'] ?? null,
            ':schema_address' => $schemaAddress,
            ':schema_same_as' => $schemaSameAs,
            ':noindex'        => (int)($page['noindex'] ?? false)
        ];
        $db->execute($sql, $params);
    }
    echo "Page data inserted/updated successfully.\n";

    // --- 3. Insert initial data into 'sections' table ---
    echo "Inserting initial section data from JSON...\n";
    $sectionsJsonPath = PROJECT_ROOT . 'database/seeds/data/sections.json';
    if (!file_exists($sectionsJsonPath)) {
        throw new \Exception("Sections JSON file not found at: " . $sectionsJsonPath);
    }
    $sectionsJson = file_get_contents($sectionsJsonPath);
    $sectionsData = json_decode($sectionsJson, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new \Exception("Failed to decode sections JSON: " . json_last_error_msg());
    }

    // Resolve variables in initial sections using ConfigVarResolver
    //    $resolver = ConfigVarResolver::getInstance();
    //    $sectionsData = $resolver->resolveArray($sectionsData);

    foreach ($sectionsData as $name => $content) {
        $sql = "INSERT INTO sections (name, content) VALUES (:name, :content)
                ON CONFLICT (name) DO UPDATE SET content = EXCLUDED.content;"; // Added ON CONFLICT for idempotency
        $params = [
            ':name'    => $name,
            ':content' => json_encode($content), // Store content as JSONB
        ];
        $db->execute($sql, $params);
    }
    echo "Section data inserted/updated successfully.\n";

    echo "Database seeding completed.\n";

} catch (\Exception $e) {
    error_log("Database seeding failed: " . $e->getMessage());
    echo "ERROR: Database seeding failed. " . $e->getMessage() . "\n";
    exit(1);
}