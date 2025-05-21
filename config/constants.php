<?php
/**
 * Application constants
 * 
 * Defines constants used throughout the application.
 * Currently, contains page definitions with their names and titles.
 */

/**
 * PAGES - Array of page configurations
 * 
 * Each page has:
 * - name: Internal identifier for the page
 * - title: Display title for the page
 */
define("PAGES", [
    'main' => [
        'name' => 'main',
        'title' => 'Home Page'
    ],
    'catalog' => [
        'name' => 'catalog',
        'title' => 'Catalog Page'
    ],
    'contacts' => [
        'name' => 'contacts',
        'title' => 'Contacts Page'
    ],
    'error' => [
        'name' => 'error',
        'title' => '404 Page'
    ]
]);