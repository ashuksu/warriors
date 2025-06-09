<?php

namespace Controllers;

use Views\Layout;

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
    protected string $page;

    /**
     * @param string $page Page identifier from PAGES constant
     */
    public function __construct(string $page)
    {
        $this->page = $page;
        $this->metadata = PAGES[$page];
        $this->setConstants();
    }

    /**
     * Set required application constants
     *
     * @return void
     */
    protected function setConstants(): void
    {
        if (!defined('APP_TITLE')) {
            define("APP_TITLE", $this->metadata['title']);
        }

        if (!defined('PAGE')) {
            define("PAGE", $this->metadata['name']);
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