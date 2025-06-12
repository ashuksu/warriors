<?php
/**
 * Application Constants
 *
 * This file defines application-wide constants, serving as whitelists
 * and configuration settings for various functionalities.
 */

// PAGES constant is now loaded dynamically from the database via Router.php.

if (!defined('ALLOWED_IMAGE_DOMAINS')) {
    /**
     * ALLOWED_IMAGE_DOMAINS - Whitelist for external image domains.
     *
     * This constant defines a list of trusted domains from which external images
     * are permitted to be loaded or processed by the application.
     * Any image URL originating from a domain NOT present in this list
     * should be rejected or handled as unauthorized.
     */
    define("ALLOWED_IMAGE_DOMAINS", [
        'images.unsplash.com',
        'googleusercontent.com',
        'youtube.com', // Added for clarity, assuming YouTube might be a source
    ]);
}