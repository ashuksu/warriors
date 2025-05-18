<?php

namespace Views\Sections\Catalog;

use Views\Helpers\RenderHelper;

class Catalog
{
    public static function render($params = [])
    {
        extract($params);
        ?>

        <section class="section catalog">
            <div class="container">
                <div class="inner catalog__inner">
                    <h1 class="title mb-3 text-center wow pixFadeUp" data-wow-delay="0.2s">
                        <?= $title ?>
                    </h1>

                    <div class="catalog__grid">

                        <?php
                        if (!empty($catalog) && is_array($catalog)) {
                            foreach ($catalog as $item) {
                                RenderHelper::renderTemplate(__DIR__ . '/item.php', [
                                    'imageUrl' => APP_PATH . 'public/assets/images/items/' . $item['image']
                                ]);
                            }
                        }
                        ?>

                    </div>
                </div>
            </div>
        </section>
        <?php
    }
}