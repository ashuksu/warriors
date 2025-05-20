<section id="<?= $section ?? '' ?>" class="section error <?= $section ?? '' ?>">
    <div class="container">
        <div class="inner error__inner text-center">
            <h1 class="title mb-3 wow pixFadeUp" data-wow-delay="0.2s">
                <?= $title ?? '' ?>
            </h1>

            <?php

            use function Helpers\renderTemplate;

            if (!empty($item) && is_array($item)) {

                renderTemplate($itemPath ?? __DIR__ . '/item.php', [
                    'text' => $item['text'],
                    'image' => getAssetPath('dist/assets/images/' . ($item['image']['image'] ?? '')),
                    'item' => $item['image'],
                    'button' => $item['button']
                ]);
            }
            ?>

        </div>
    </div>
</section>