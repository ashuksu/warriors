<?php

namespace Controllers;

use Views\Layout;

/**
 * Controller for the error page
 * 
 * Handles rendering of the error page when a route is not found
 */
class ErrorController
{
    /**
     * Render the error page
     * 
     * Sets up page title and name constants, then renders the layout
     * with the error section
     * 
     * @return void
     */
    public static function index(): void
    {
        define("APP_TITLE", PAGES['error']['title']);
        define("PAGE", PAGES['error']['name']);

        Layout::render([
            'sections' => [PAGE],
        ]);
    }
}