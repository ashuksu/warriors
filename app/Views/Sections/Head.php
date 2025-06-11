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
     * @param array $params Parameters for the head section (expected to be the page's metadata array).
     * @return void
     */
    public static function render(array $params = []): void
    {
        // $params here contains the full page metadata from the database,
        // passed from Layout::render($data) as $data['metadata'].
        $schema = $params['schema'] ?? [];
        $noindex = $params['noindex'] ?? false;
        ?>

		<!DOCTYPE html>
		<html lang="en" <?php if (defined('IS_DEV') && IS_DEV) echo 'data-mode="dev"'; ?>>
		<head>

			<!-- Basic meta tags -->
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<meta http-equiv="X-UA-Compatible" content="ie=edge">

			<!-- Page title -->
			<title><?= $params['title'] ?? APP_TITLE ?></title>

			<!-- SEO meta tags -->
			<meta name="description" content="<?= $params['description'] ?? '' ?>">
			<meta name="keywords" content="<?= $params['keywords'] ?? '' ?>">

			<?php if (!empty($noindex)): ?>
				<meta name="robots" content="noindex, nofollow">
			<?php endif; ?>

			<!-- Open Graph tags -->
			<meta property="og:site_name" content="Warriors">
			<meta property="og:title" content="<?= $params['title'] ?? APP_TITLE ?>">
			<meta property="og:description" content="<?= $params['description'] ?? '' ?>">
			<meta property="og:url" content="<?= 'https://' . DOMAIN . '/' . PAGE ?>">
			<meta property="og:type" content="website">
			<meta property="og:locale" content="en_US">

			<!-- Twitter Card tags -->
			<meta name="twitter:card" content="summary_large_image">
			<meta name="twitter:title" content="<?= $params['title'] ?? APP_TITLE ?>">
			<meta name="twitter:description" content="<?= $params['description'] ?? '' ?>">

			<!-- Schema.org markup -->
		   <?php if (!empty($schema)): ?>
				<script type="application/ld+json">
					{
						"@context": "https://schema.org",
						"@type": "<?= $schema['type'] ?? 'WebPage' ?>",
						"name": "Warriors",
						"description": "<?= $params['description'] ?? '' ?>",
						"url": "<?= 'https://' . DOMAIN . '/' . PAGE ?>",
						"telephone": "<?= PHONE ?? '' ?>",
						"email": "<?= EMAIL ?? '' ?>",
						"category": "<?= $schema['category'] ?? '' ?>"
						<?php if (!empty($schema['address'])): ?>,
							"address": {
								"@type": "PostalAddress",
								"streetAddress": "<?= $schema['address']['streetAddress'] ?? '' ?>",
								"addressLocality": "<?= $schema['address']['addressLocality'] ?? '' ?>",
								"addressRegion": "<?= $schema['address']['addressRegion'] ?? '' ?>",
								"postalCode": "<?= $schema['address']['postalCode'] ?? '' ?>",
								"addressCountry": "<?= $schema['address']['addressCountry'] ?? '' ?>"
							}
						<?php endif; ?>
						<?php if (!empty($schema['sameAs'])): ?>,
							"sameAs": <?= json_encode($schema['sameAs']) ?>
							<?php //TODO: Ensure this is an array [..] ?>
						<?php endif; ?>
					}
				</script>
			<?php endif; ?>

			<!-- Favicon and canonical -->
			<link rel="shortcut icon" href="<?= getPath('favicon.ico') ?>">
			<link rel="canonical" href="<?= 'https://' . DOMAIN . '/' . PAGE ?>">

			<?php
			renderTemplate(__DIR__ . '/head-links.php');
			?>

		</head>

        <?php
    }
}