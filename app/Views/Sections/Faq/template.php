<section id="<?= $section ?? '' ?>" class="section faq <?= $section ?? '' ?>">
    <div class="container">
        <div class="inner inner-style faq__inner">
            <h2 class="title text-center wow pixFadeUp" data-wow-delay="0.2s">
                <?= $title ?? '' ?>
            </h2>
            <div class="faq__list">

                <?php

                use function App\Helpers\renderTemplate;

                if (!empty($collection) && is_array($collection)) {
                    foreach ($collection as $index => $item) {
                        renderTemplate($itemPath ?? __DIR__ . '/item.php', [
                            'item' => $item,
                            'index' => $index,
                            'setActiveClass' => $index === 0 ? 'active' : ''
                        ]);
                    }
                }
                ?>

            </div>
        </div>
    </div>
</section>