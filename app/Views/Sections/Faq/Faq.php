<?php

namespace Views\Sections\Faq;

use Views\Helpers\RenderHelper;

class Faq
{
    public static function render($params = [])
    {
        extract($params);

        if (!empty($faq) && is_array($faq)) {
            ?>

            <section id="faq" class="section faq">
                <div class="container">
                    <div class="inner inner-style faq__inner">
                        <h2 class="title text-center wow pixFadeUp" data-wow-delay="0.2s">
                            <?= $faqTitle ?>
                        </h2>
                        <div class="faq__list">

                            <?php
                            foreach ($faq as $index => $item) {
                                RenderHelper::renderTemplate(__DIR__ . '/item.php', [
                                    'item' => $item,
                                    'index' => $index,
                                    '$setActiveClass' => $index === 0 ? 'active' : ''
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