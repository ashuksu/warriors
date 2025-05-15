<?php

require_once __DIR__ . '/BaseSectionService.php';

/**
 * Service for handling catalog data operations.
 * Provides caching and error handling for catalog data.
 * Implements the singleton pattern for efficient resource usage.
 *
 * @see BaseSectionService
 */
class CatalogService extends BaseSectionService
{
    protected static $instance = null;

    /**
     * Protected constructor to enforce singleton pattern.
     * Initializes the service by calling the parent constructor.
     *
     * @protected
     * @see BaseSectionService::__construct()
     */
    protected function __construct()
    {
        parent::__construct();
    }

    /**
     * Get singleton instance of the CatalogService.
     * Creates a new instance if one doesn't exist yet.
     *
     * @return CatalogService The singleton instance
     * @static
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Static helper method to get any catalog data.
     * Provides a convenient way to access catalog data without
     * explicitly creating an instance of the service.
     *
     * @param string $type Type of data to return (e.g., 'items', 'title')
     * @return mixed Catalog data based on requested type. Returns empty string on error.
     * @static
     * @see BaseSectionService::getSectionData()
     */
    public static function get($type)
    {
        return self::getInstance()->getSectionData('catalog', $type);
    }
}
