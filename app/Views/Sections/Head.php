<?php

namespace Views\Sections;

use function Helpers\getPath;
use function Helpers\renderTemplate;

/**
 * Head section class
 *
 * Handles rendering of the HTML head section with meta-tags, CSS, and JavaScript resources
 */
class Head
{
    /**
     * Render the HTML head section
     *
     * Outputs the DOCTYPE, HTML tag, and head section with all necessary meta-tags,
     * stylesheets, fonts, and scripts for the page
     *
     * @param array $params Parameters for the head section (title, etc.)
     * @return void
     */
    public static function render($params = [])
    {
        extract($params);
        ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <!-- Basic meta tags -->
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">

            <!-- Page title and favicon -->
            <title><?= APP_TITLE ?></title>
            <link rel="shortcut icon" href="<?= getPath('favicon.ico') ?>">

            <?php
            renderTemplate(__DIR__ . '/head-links.php', []);
            ?>

        </head>

        <?php
    }
}