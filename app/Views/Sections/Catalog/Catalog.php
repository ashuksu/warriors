<?php

namespace Views\Sections\Catalog;

use function Helpers\renderTemplate;

class Catalog
{
    public static function render($params = [])
    {
        extract($params);

        if (!empty($catalog) && is_array($catalog)) {
            ?>

            <section class="section catalog">
                <div class="container">
                    <div class="inner catalog__inner">
                        <h1 class="title mb-3 text-center wow pixFadeUp" data-wow-delay="0.2s">
                            <?= $title ?>
                        </h1>

                        <div class="catalog__grid">

                            <?php
                            foreach ($catalog as $item) {
                                renderTemplate(__DIR__ . '/item.php', [
                                    'imageUrl' => APP_PATH . 'assets/images/items/' . $item['image']
                                ]);
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </section>

            <?php
        }
    }
}