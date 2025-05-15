<?php

require_once __DIR__ . '/BaseSectionService.php';

/**
 * Service for handling catalog data operations
 * Provides caching and error handling for catalog data
 */
class CatalogService extends BaseSectionService
{
    protected static $instance = null;

    /**
     * Protected constructor to enforce singleton pattern
     */
    protected function __construct()
    {
        parent::__construct();
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
     * Get catalog data with caching
     *
     * @param string $type Type of data to return ('items', 'title', etc.)
     * @return mixed Catalog data based on requested type
     */
    public function getData($type = 'items')
    {
        return $this->getSectionData('catalog', $type);
    }
}
