<?php

namespace Views\Layouts;

use Views\Components\Button;

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
                        <img src="<?= APP_PATH ?>assets/images/logo/logo-1.png" width="30" height="30"
                             alt="logo">
                    </a>

                    <?php
                    Button::render([
                        'class' => 'button button--menu button--transparent',
                        'attr' => 'data-element="menu-open"',
                        'content' => '<i></i>',
                    ]);
                    ?>

                    <!--                    include PROJECT_ROOT . 'Views/Components/menu.php'-->
                </div>
            </div>
        </header>

        <?php
    }
}