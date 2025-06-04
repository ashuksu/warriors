<?php
/**
 * Application Constants
 *
 * This file defines application-wide constants, serving as whitelists
 * and configuration settings for various functionalities.
 */

/**
 * PAGES - Array of page configurations.
 *
 * This constant acts as a whitelist for predefined application pages.
 * Each entry is an associative array defining specific properties for a page.
 *
 * Structure of Each Page Entry:
 * - 'name': (string) Internal identifier for the page.
 * - 'title': (string) Display title for the page, used in browser tabs and SEO.
 * - 'description': (string) A concise SEO description for the page.
 * - 'keywords': (string) Comma-separated SEO keywords relevant to the page content.
 * - 'h1': (string) The main heading (<h1>) displayed on the page.
 * - 'schema': (array) Structured data (Schema.org) for SEO. Contains:
 * - 'type': (string) The Schema.org type (e.g., 'Organization', 'ItemList').
 * - 'category': (string) A specific category for the schema type.
 * - (Optional) 'address': (array) Physical address details (e.g., for 'Organization').
 * - (Optional) 'sameAs': (array) URLs of social media profiles or related web presences.
 * - 'noindex': (bool, optional) If true, indicates that search engines should not index this page.
 * Defaults to false if not present.
 */
define("PAGES", [
    'home' => [
        'name' => 'home',
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

/**
 * ALLOWED_IMAGE_DOMAINS - Whitelist for external image domains.
 *
 * This constant defines a list of trusted domains from which external images
 * are permitted to be loaded or processed by the application.
 * Any image URL originating from a domain NOT present in this list
 * should be rejected or handled as a broken/unauthorized image.
 * This helps prevent potential security vulnerabilities (e.g., SSRF)
 * and ensures content integrity.
 */
define("ALLOWED_IMAGE_DOMAINS", [
    'images.unsplash.com',
    'img.youtube.com', // Note: This entry format might need adjustment for actual domain matching (e.g., just 'googleusercontent.com')
]);