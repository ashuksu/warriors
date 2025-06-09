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
	<html lang="en" <?php if (defined('IS_DEV') && IS_DEV) echo 'data-mode="dev"'; ?>>
	<head>

		<!-- Basic meta tags -->
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">

		<!-- Page title -->
		<title><?= PAGES[PAGE]['title'] ?? APP_TITLE ?></title>

		<!-- SEO meta tags -->
		<meta name="description" content="<?= PAGES[PAGE]['description'] ?? '' ?>">
		<meta name="keywords" content="<?= PAGES[PAGE]['keywords'] ?? '' ?>">
        <?php if (!empty(PAGES[PAGE]['noindex'])): ?>
			<meta name="robots" content="noindex, nofollow">
        <?php endif; ?>

		<!-- Open Graph tags -->
		<meta property="og:site_name" content="Warriors">
		<meta property="og:title" content="<?= PAGES[PAGE]['title'] ?? APP_TITLE ?>">
		<meta property="og:description" content="<?= PAGES[PAGE]['description'] ?? '' ?>">
		<meta property="og:url" content="<?= 'https://' . DOMAIN . '/' . PAGE ?>">
		<meta property="og:type" content="website">
		<meta property="og:locale" content="en_US">

		<!-- Twitter Card tags -->
		<meta name="twitter:card" content="summary_large_image">
		<meta name="twitter:title" content="<?= PAGES[PAGE]['title'] ?? APP_TITLE ?>">
		<meta name="twitter:description" content="<?= PAGES[PAGE]['description'] ?? '' ?>">

		<!-- Schema.org markup -->
        <?php if (!empty(PAGES[PAGE]['schema'])): ?>
			<script type="application/ld+json">
				{
                    "@context": "https://schema.org",
                    "@type": "<?= PAGES[PAGE]['schema']['type'] ?>",
                    "name": "Warriors",
                    "description": "<?= PAGES[PAGE]['description'] ?>",
                    "url": "<?= 'https://' . DOMAIN . '/' . PAGE ?>",
                    "telephone": "<?= PHONE ?? '' ?>",
                    "email": "<?= EMAIL ?>",
                    "category": "<?= PAGES[PAGE]['schema']['category'] ?>"
                <?php if (!empty(PAGES[PAGE]['schema']['address'])): ?>,
                    "address": {
                        "@type": "PostalAddress",
                        "streetAddress": "<?= PAGES[PAGE]['schema']['address']['streetAddress'] ?>",
                        "addressLocality": "<?= PAGES[PAGE]['schema']['address']['addressLocality'] ?>",
                        "addressRegion": "<?= PAGES[PAGE]['schema']['address']['addressRegion'] ?>",
                        "postalCode": "<?= PAGES[PAGE]['schema']['address']['postalCode'] ?>",
                        "addressCountry": "<?= PAGES[PAGE]['schema']['address']['addressCountry'] ?>"
                    }
                    <?php endif; ?>
                    <?php if (!empty(PAGES[PAGE]['schema']['sameAs'])): ?>,
                    "sameAs": "<?= json_encode(PAGES[PAGE]['schema']['sameAs']) ?>"
                <?php endif; ?>
				}
			</script>
        <?php endif; ?>

		<!-- Favicon and canonical -->
		<link rel="shortcut icon" href="<?= getPath('favicon.ico') ?>">
		<link rel="canonical" href="<?= 'https://' . DOMAIN . '/' . PAGE ?>">

        <?php
        renderTemplate(__DIR__ . '/head-links.php', []);
        ?>

	</head>

        <?php
    }
}