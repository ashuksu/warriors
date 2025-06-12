<?php

namespace Controllers;

use Views\Layout;
use Exception;

/**
 * Base controller class
 *
 * Provides core functionality for all controllers:
 * - Page metadata management
 * - Constants initialization
 * - Layout rendering
 */
abstract class BaseController
{
    protected array $metadata;
    protected string $pageName;

    /**
     * @param array $pageMetadata Complete page metadata fetched from the database
     * @throws Exception If critical metadata is missing
     */
    public function __construct(array $pageMetadata)
    {
        // Ensure essential metadata is present
        if (!isset($pageMetadata['name']) || !isset($pageMetadata['title'])) {
            throw new Exception("Missing essential page metadata (name or title).");
        }

        $this->metadata = $pageMetadata;
        $this->pageName = $pageMetadata['name']; // Assign page name (PAGE) from metadata

        $this->setConstants();
    }

    /**
     * Set required application constants based on current page metadata.
     *
     * @return void
     */
    protected function setConstants(): void
    {
        if (!defined('APP_TITLE')) {
            define("APP_TITLE", $this->metadata['title']);
        }

        if (!defined('PAGE')) {
            define("PAGE", $this->pageName);
        }
    }

    /**
     * Render page sections
     *
     * @param array $sections Sections to render
     * @return void
     */
    protected function render(array $sections): void
    {
        Layout::render([
            'sections' => $sections,
            'metadata' => $this->metadata
        ]);
    }

    /**
     * Main page action
     *
     * @return void
     */
    abstract public function index(): void;
}