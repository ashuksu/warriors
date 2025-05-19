<?php

namespace Views\Sections\Info;

class Info
{
    public static function render($params = [])
    {
        extract($params);

        if (!empty($info) && is_array($info)):
            ?>

            <section id="info" class="section info mt-auto">
                <div class="container">
                    <div class="inner inner-style text-center info__inner wow pixFadeUp" data-wow-delay="0.2s">
                        <h2 class="title">
                            <?= $info['title'] ?>
                        </h2>
                        <p class="text-justify">
                            <?= $info['text'] ?>
                        </p>
                    </div>
                </div>
            </section>

        <?php
        endif;
    }
}