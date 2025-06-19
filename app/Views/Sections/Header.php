<?php

namespace Views\Sections;

use Helpers\Device;
use Views\Components\Button;
use Views\Components\Image;
use function Helpers\getPath;

/**
 * Header section class
 *
 * Handles rendering of the site header with logo, menu button, and navigation
 */
class Header
{
    /**
     * Render the header section
     *
     * Outputs the header with logo, menu button, and navigation menu
     *
     * @param array $params Parameters for the header section
     * @return void
     */
    public static function render($params = [])
    {
        extract($params);
        ?>

		<header id="header" class="header" role="banner">
			<div class="container">
				<div class="header__inner">
					<a href="<?= APP_PATH ?>" class="logo">

                        <?php
                        echo Image::render([
                            'url' => getPath('dist/assets/images/logo/logo-1.svg'),
                            'alt' => 'logo',
                            'width' => 30,
                            'height' => 30,
                        ]);
                        ?>
					</a>

                    <?php
                    echo Button::render([
                        'class' => 'button button--menu button--transparent',
                        'attr' => 'data-element="menu-open"' . (Device::isDesktop() ? ' hidden' : ''),
                        'content' => '<i></i>',
                        'aria-hidden' => Device::isDesktop(),
                        'aria-label' => 'Open Main Menu',
                        'aria-expanded' => false,
                        'aria-controls' => 'menu',
                        'role' => 'button'
                    ]);

                    Menu::render([]);
                    ?>

				</div>
			</div>
		</header>

        <?php
    }
}