<?php

namespace App\Views\Sections;

use App\Core\Container;
use App\Services\DeviceService;
use App\Services\PathService;
use App\Services\ConfigService;
use App\Views\Components\Button;
use App\Views\Components\Image;
use Exception;

/**
 * Header section class
 * Handles rendering of the site header with logo, menu button, and navigation
 */
class Header
{
    /**
     * Render the header section
     *
     * Outputs the header with logo, menu button, and navigation menu
     *
     * @param Container $container The DI container.
     * @return void
     * @throws Exception
     */
    public static function render(Container $container): void
    {
        /** @var ConfigService $configService */
        $configService = $container->get(ConfigService::class);

        /** @var PathService $pathService */
        $pathService = $container->get(PathService::class);

        /** @var DeviceService $deviceService */
        $deviceService = $container->get(DeviceService::class);
        ?>

		<header id="header" class="header" role="banner">
			<div class="container">
				<div class="header__inner">
					<a href="<?= $configService->get('app_path') ?>" class="logo">

                        <?php
                        echo Image::render([
                            'url' => $pathService->getPath('dist/assets/images/logo/logo-1.svg'),
                            'alt' => 'logo',
                            'width' => 30,
                            'height' => 30,
                        ]);
                        ?>
					</a>

                    <?php
                    echo Button::render([
                        'class' => 'button button--menu button--transparent',
                        'attr' => 'data-element="menu-open"' . ($deviceService->isDesktop() ? ' hidden' : ''),
                        'content' => '<i></i>',
                        'aria-hidden' => $deviceService->isDesktop(),
                        'aria-label' => 'Open Main Menu',
                        'aria-expanded' => false,
                        'aria-controls' => 'menu',
                        'role' => 'button'
                    ]);

                    Menu::render($container);
                    ?>

				</div>
			</div>
		</header>

        <?php
    }
}