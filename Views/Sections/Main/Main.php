<?php

namespace Views\Sections\Main;

use Views\Components\Button;

class Main
{
    public static function render($params = [])
    {
        extract($params);

        if (!empty($main) && is_array($main)) {
            ?>

            <section class="section main-section">
                <div class="container">
                    <div class="row">
                        <div class="col col-lg-5 col-md-6 mb-1 mb-md-0">
                            <div class="inner main-section__inner">
                                <h1 class="title main-section__title">
                                    <?= $main['title'] ?>
                                </h1>
                                <p class="main-section__text">
                                    <?= $main['text'] ?>
                                </p>

                                <?php
                                if ($isPopups) {
                                    foreach ($popups as $item) {
                                        Button::render([
                                            'url' => '#popup-' . $item['id'],
                                            'attr' => 'data-element="popup-open"',
                                            'content' => 'Open popup ' . $item['name']
                                        ]);
                                    }
                                }
                                ?>

                            </div>
                        </div>
                        <div class="col col-md-6">
                            <div class="image">
                                <img src="<?= APP_PATH ?>assets/images/<?= $mainImage['name'] ?>"
                                     alt="<?= $mainImage['alt'] ?>"
                                     width="<?= $mainImage['width'] ?>" height="<?= $mainImage['height'] ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <?php
        }
    }
}