<?php

namespace App\Views\Sections;

use App\Core\Container;
use App\Services\ConfigService;
use App\Services\ViteService;
use App\Views\Components\Image;
use Exception;

/**
 * Footer section class
 * Handles rendering of the site footer with logo, copyright information, and links
 */
class Footer
{
    /**
     * Render the footer section
     *
     * Outputs the footer with logo, copyright text, and external links
     *
     * @param Container $container The DI container.
     * @return void
     * @throws Exception
     */
    public static function render(Container $container): void
    {
        /** @var ConfigService $configService */
        $configService = $container->get(ConfigService::class);

        /** @var ViteService $viteService */
        $viteService = $container->get(ViteService::class);
        ?>

		<footer id="footer" class="footer" role="contentinfo">
			<div class="container">
				<div class="inner inner-style footer__inner">
					<a href="<?= $configService->get('app_path') ?>" class="logo">

                        <?php
                        echo Image::render([
                            'url' => $viteService->getAssetPath('dist/assets/images/logo/logo-3.svg'),
                            'alt' => 'logo-footer',
                            'width' => 70,
                            'height' => 70,
                        ]);
                        ?>

					</a>
					<p class="footer__text">
						Copyright © <?= date("Y"); ?>
					</p>
					<a href="https://github.com/ashuksu"
					   class="footer__link link"
					   target="_blank"
					   rel="noopener noreferrer"
					   aria-label="Go to GitHub">
						ASHUKSU
					</a>
				</div>
			</div>
		</footer>

        <?php
    }
}