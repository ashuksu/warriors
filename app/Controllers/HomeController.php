<?php

namespace Controllers;

use Views\Layout;

/**
 * Controller for the home page
 * 
 * Handles rendering of the main page with its sections
 */
class HomeController
{
    /**
     * Render the home page
     * 
     * Sets up page title and name constants, then renders the layout
     * with main, about, faq, and info sections
     * 
     * @return void
     */
    public static function index(): void
    {
        define("APP_TITLE", PAGES['main']['title']);
        define("PAGE", "main");

        Layout::render([
            'sections' => [PAGE, 'about', 'faq', 'info'],
        ]);
    }
}