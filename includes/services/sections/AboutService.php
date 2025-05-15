<?php

require_once __DIR__ . '/BaseSectionService.php';

/**
 * Service for handling about data operations
 * Provides caching and error handling for about data
 */
class AboutService extends BaseSectionService
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
     * Get about data with caching
     *
     * @param string $type Type of data to return ('items', 'bool', etc.)
     * @return mixed About data based on requested type
     */
    public function getAbout($type = 'items')
    {
        return $this->getSectionData('about', $type);
    }

    /**
     * Get about items with caching (legacy method)
     *
     * @return array About items
     */
    public function getAboutItems()
    {
        return $this->getAbout('items');
    }

}
