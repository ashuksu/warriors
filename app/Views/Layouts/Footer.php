<?php

namespace Views\Layouts;

use Views\Components\Image;

class Footer
{
    public static function render($params = [])
    {
        extract($params);
        ?>

        <footer id="footer" class="footer">
            <div class="container">
                <div class="inner inner-style footer__inner">
                    <a href="<?= APP_PATH ?>" class="logo">

                        <?php
                        Image::render([
                            'url' => APP_PATH . 'assets/images/logo/logo-3.png',
                            'alt' => 'logo-footer',
                            'width' => 70,
                            'height' => 70,
                        ]);
                        ?>

                    </a>
                    <p class="footer__text">
                        Copyright © <?= date("Y"); ?>
                    </p>
                    <a href="<?= $LINK ?>" class="footer__link link" target="_blank">
                        ASHUKSU
                    </a>
                </div>
            </div>
        </footer>

        <?php
    }
}