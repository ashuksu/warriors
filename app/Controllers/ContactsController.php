<?php

namespace Controllers;

use Views\Layout;

/**
 * Controller for the contacts page
 * 
 * Handles rendering of the contacts page with its sections
 */
class ContactsController
{
    /**
     * Render the contacts page
     * 
     * Sets up page title and name constants, then renders the layout
     * with contacts and info sections
     * 
     * @return void
     */
    public static function index(): void
    {
        define("APP_TITLE", PAGES['contacts']['title']);
        define("PAGE", PAGES['contacts']['name']);

        Layout::render([
            'sections' => [PAGE, 'info']
        ]);
    }
}