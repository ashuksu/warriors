<section id="<?= $section ?? '' ?>" class="section catalog <?= $section ?? '' ?>">
    <div class="container">
        <div class="inner catalog__inner">
            <h1 class="title mb-3 text-center wow pixFadeUp" data-wow-delay="0.2s">
                <?= $title ?? '' ?>
            </h1>

            <div class="catalog__grid">

                <?php

                use function Helpers\renderTemplate;

                if (!empty($collection) && is_array($collection)) {
                    foreach ($collection as $item) {
                        renderTemplate($itemPath ?? __DIR__ . '/item.php', [
                            'item' => $item,
                            'image' => ($imagePartPath ?? (APP_PATH . 'dist/assets/images/')) . ($item['image'] ?? '')
                        ]);
                    }
                }
                ?>

            </div>
        </div>
    </div>
</section>