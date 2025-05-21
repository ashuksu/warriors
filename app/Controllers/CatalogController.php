<?php

namespace Controllers;

use Views\Layout;

/**
 * Controller for the catalog page
 * 
 * Handles rendering of the catalog page with its sections
 */
class CatalogController
{
    /**
     * Render the catalog page
     * 
     * Sets up page title and name constants, then renders the layout
     * with catalog and info sections
     * 
     * @return void
     */
    public static function index(): void
    {
        define("APP_TITLE", PAGES['catalog']['title']);
        define("PAGE", PAGES['catalog']['name']);

        Layout::render([
            'sections' => [PAGE, 'info']
        ]);
    }
}