<?php

namespace Views\Sections;

use Views\Sections\Menu;
use Views\Components\Button;
use Views\Components\Image;

class Header
{
    public static function render($params = [])
    {
        extract($params);
        ?>

        <header id="header" class="header">
            <div class="container">
                <div class="header__inner">
                    <a href="<?= APP_PATH ?>" class="logo">

                        <?php
                        Image::render([
                            'url' => APP_PATH . 'assets/images/logo/logo-1.png',
                            'alt' => 'logo',
                            'width' => 30,
                            'height' => 30,
                        ]);
                        ?>
                    </a>

                    <?php
                    Button::render([
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