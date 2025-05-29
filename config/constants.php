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
 * - description: SEO description for the page
 * - keywords: SEO keywords for the page
 * - h1: Main heading for the page
 * - schema: Structured data for the page
 * - noindex: Optional flag to exclude the page from search engine indexing
 */
define("PAGES", [
    'main' => [
        'name' => 'main',
        'title' => 'Home Page | Warriors',
        'description' => 'Warriors - lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        'keywords' => 'warriors, business solutions, professional services, expert team, important words',
        'h1' => 'Professional Business Solutions',
        'schema' => [
            'type' => 'Organization',
            'category' => 'Business Services',
            'address' => [
                'streetAddress' => 'Your Street Address',
                'addressLocality' => 'City',
                'addressRegion' => 'Region',
                'postalCode' => 'Postal Code',
                'addressCountry' => 'Country'
            ],
            'sameAs' => [
                'https://facebook.com/warriors',
                'https://twitter.com/warriors',
                'https://linkedin.com/company/warriors'
            ]
        ]
    ],
    'catalog' => [
        'name' => 'catalog',
        'title' => 'Catalog Page | Warriors',
        'description' => 'The  Catalog of Warriors - lorem ipsum dolor sit amet, consectetur adipiscing elit.',
        'keywords' => 'catalog warriors, business solutions, warriors services',
        'h1' => 'Our Services Catalog',
        'schema' => [
            'type' => 'ItemList',
            'category' => 'Services'
        ]
    ],
    'contacts' => [
        'name' => 'contacts',
        'title' => 'Contacts Page | Warriors',
        'description' => 'Contact Warriors team for professional business solutions.',
        'keywords' => 'contact warriors, business support, professional consultation',
        'h1' => 'Contact Us',
        'schema' => [
            'type' => 'ContactPage',
            'category' => 'Contact Information'
        ]
    ],
    'error' => [
        'name' => 'error',
        'title' => '404 Page | Warriors',
        'description' => 'The requested page could not be found. Return to Warriors homepage.',
        'keywords' => 'error, 404, page not found',
        'h1' => 'Page Not Found',
        'noindex' => true
    ]
]);