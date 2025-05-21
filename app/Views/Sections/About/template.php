<section id="<?= $section ?? '' ?>" class="section <?= $section ?? '' ?>">
    <div class="container">

        <?php

        use function Helpers\renderTemplate;
        use function Helpers\getPath;

        if (!empty($collection) && is_array($collection)) {
            foreach ($collection as $index => $item) {
                renderTemplate($itemPath ?? __DIR__ . '/item.php', [
                    'item' => $item,
                    'isReverse' => $index % 2 !== 0,
                    'image' => getPath('dist/assets/images/' . ($item['image'] ?? '')),
                ]);
            }
        }
        ?>

    </div>
</section>