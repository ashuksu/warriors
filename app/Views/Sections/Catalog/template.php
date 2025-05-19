<section id="<?= $section ?? '' ?>" class="section catalog <?= $section ?? '' ?>">
    <div class="container">
        <div class="inner catalog__inner">
            <h1 class="title mb-3 text-center wow pixFadeUp" data-wow-delay="0.2s">
                <?= $title ?? '' ?>
            </h1>

            <div class="catalog__grid">

                <?php

                use function Helpers\renderTemplate;

                if (!empty($catalog) && is_array($catalog)) {
                    foreach ($catalog as $item) {
                        renderTemplate($itemPath, [
                            'item' => $item,
                            'image' => ($imagePartPath ?? "") . ($item['image'] ?? ''),
                        ]);
                    }
                }
                ?>

            </div>
        </div>
    </div>
</section>