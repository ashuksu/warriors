<?php

namespace Views\Sections\About;

use function Helpers\renderTemplate;

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
                        renderTemplate(__DIR__ . '/item.php', [
                            'item' => $item,
                            'imageUrl' => APP_PATH . 'assets/images/' . $item['image'],
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
