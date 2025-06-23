<?php

namespace App\Views\Sections;

use App\Core\Container;
use App\Services\ConfigService;
use App\Services\TemplateService;
use App\Services\ViteService;
use Exception;

/**
 * Head section class
 * Handles rendering of the HTML head section with meta-tags, CSS, and JavaScript resources
 */
class Head
{
    /**
     * Render the HTML head section
     *
     * Outputs the DOCTYPE, HTML tag, and head section with all necessary meta-tags,
     * stylesheets, fonts, and scripts for the page.
     * @param Container $container The DI container.
     * @return void
     * @throws Exception
     */
    public static function render(Container $container): void
    {
        $pageData = $container->getPageData();

        /** @var ConfigService $configService */
        $configService = $container->get(ConfigService::class);

        /** @var TemplateService $templateService */
        $templateService = $container->get(TemplateService::class);

        /** @var ViteService $viteService */
        $viteService = $container->get(ViteService::class);

        $schema = $pageData['schema'] ?? [];
        $noindex = $pageData['noindex'] ?? false;
        ?>

        <!DOCTYPE html>
        <html lang="en" <?php if ($configService->get('is_dev')) echo 'data-mode="dev"'; ?>>
        <head>

            <!-- Basic meta tags -->
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">

            <!-- Page title -->
            <title><?= $pageData['title'] ?? $configService->get('contacts.company_name', 'Default Title') ?></title>

            <!-- SEO meta tags -->
            <meta name="description" content="<?= $pageData['description'] ?? '' ?>">
            <meta name="keywords" content="<?= $pageData['keywords'] ?? '' ?>">

            <?php if (!empty($noindex)): ?>
                <meta name="robots" content="noindex, nofollow">
            <?php endif; ?>

			<!-- Open Graph tags -->
			<meta property="og:site_name" content="<?= $configService->get('contacts.company_name', 'Warriors') ?>">
			<meta property="og:title" content="<?= $pageData['title'] ?? $configService->get('contacts.company_name', 'Default Title') ?>">
			<meta property="og:description" content="<?= $pageData['description'] ?? '' ?>">
			<meta property="og:url" content="<?= 'https://' . $configService->get('domain') . '/' . ($pageData['name'] === 'home' ? '' : $pageData['name']) ?>">
			<meta property="og:type" content="<?= $schema['type'] ?? 'website' ?>">
			<meta property="og:locale" content="en_US">
			<meta property="og:image" content="<?= $viteService->getAssetPath('dist/assets/images/logo/logo-1.svg') ?>">

			<!-- Twitter Card tags -->
			<meta name="twitter:card" content="summary_large_image">
			<meta name="twitter:title" content="<?= $pageData['title'] ?? $configService->get('contacts.company_name', 'Default Title') ?>">
			<meta name="twitter:description" content="<?= $pageData['description'] ?? '' ?>">

			<!-- Schema.org markup -->
		   <?php if (!empty($schema)): ?>
				<script type="application/ld+json">
					{
                        "@context": "https://schema.org",
                        "@type": "<?= $schema['type'] ?? 'WebPage' ?>",
                        "name": "<?= $configService->get('contacts.company_name', 'Warriors') ?>",
                        "description": "<?= $pageData['description'] ?? '' ?>",
                        "url": "<?= 'https://' . $configService->get('domain') . '/' . ($pageData['name'] === 'home' ? '' : $pageData['name']) ?>",
                        "telephone": "<?= $configService->get('contacts.phone') ?? '' ?>",
                        "email": "<?= $configService->get('contacts.email') ?? '' ?>",
                        "category": "<?= $schema['category'] ?? '' ?>",
						<?php if (!empty($schema['address'])): ?>
							"address": {
								"@type": "PostalAddress",
								"streetAddress": "<?= $schema['address']['streetAddress'] ?? '' ?>",
								"addressLocality": "<?= $schema['address']['addressLocality'] ?? '' ?>",
								"addressRegion": "<?= $schema['address']['addressRegion'] ?? '' ?>",
								"postalCode": "<?= $schema['address']['postalCode'] ?? '' ?>",
								"addressCountry": "<?= $schema['address']['addressCountry'] ?? '' ?>"
							},
						<?php endif; ?>
						<?php if (!empty($schema['sameAs'])): ?>
							"sameAs": <?= json_encode($schema['sameAs']) ?>
						<?php endif; ?>
					}
				</script>
			<?php endif; ?>

			<!-- Favicon and canonical -->
            <link rel="shortcut icon" href="<?= $viteService->getAssetPath('favicon.ico') ?>">
            <link rel="canonical" href="<?= 'https://' . $configService->get('domain') . '/' . ($pageData['name'] === 'home' ? '' : $pageData['name']) ?>">

			<?php
            $templateService->render(__DIR__ . '/head-links.php', [
                'configService' => $configService,
                'viteService' => $viteService,
                'pageDataName' => $pageData['name'] ?? 'home'
            ]);
			?>

		</head>

        <?php
    }
}