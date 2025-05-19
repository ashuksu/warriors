<?php

namespace Views\Sections;

use Views\Sections\Menu;
use Views\Components\Button;
use Views\Components\Image;

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

        <header id="header" class="header">
            <div class="container">
                <div class="header__inner">
                    <a href="<?= APP_PATH ?>" class="logo">

                        <?php
                        echo Image::render([
                            'url' => APP_PATH . 'assets/images/logo/logo-1.png',
                            'alt' => 'logo',
                            'width' => 30,
                            'height' => 30,
                        ]);
                        ?>
                    </a>

                    <?php
                    echo Button::render([
                        'class' => 'button button--menu button--transparent',
                        'attr' => 'data-element="menu-open"',
                        'content' => '<i></i>',
                    ]);

                    Menu::render([]);
                    ?>

                </div>
            </div>
        </header>

        <?php
    }
}