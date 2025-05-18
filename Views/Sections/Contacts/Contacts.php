<?php

namespace Views\Sections\Contacts;

use Views\Helpers\RenderHelper;

class Contacts
{
    public static function render($params = [])
    {
        extract($params);

        if (!empty($contacts) && is_array($contacts)) {
            ?>

            <section class="section contacts">
                <div class="container">
                    <div class="inner">
                        <h1 class="title text-center mb-3 wow pixFadeUp" data-wow-delay="0.2s">
                            <?= $title ?>
                        </h1>

                        <div class="row contacts__list wow pixFadeUp" data-wow-delay="0.3s">

                            <?php
                            foreach ($contacts as $index => $item) {
                                RenderHelper::renderTemplate(__DIR__ . '/item.php', [
                                    'item' => $item,
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