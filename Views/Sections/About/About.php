<?php

namespace Views\Sections\About;

use Views\Helpers\RenderHelper;

class About
{
    public static function render($params = [])
    {
        extract($params);

        if (!empty($about) && is_array($about)) {
            ?>

            <section id="about" class="section about">
                <div class="container">

                    <?php
                    foreach ($about as $index => $item) {
                        RenderHelper::renderTemplate(__DIR__ . '/item.php', [
                            'item' => $item,
                            'imageUrl' => APP_PATH . 'public/assets/images/' . $item['image'],
                            'isReverse' => $index % 2 !== 0
                        ]);
                    }
                    ?>

                </div>
            </section>

            <?php
        }
    }
}
