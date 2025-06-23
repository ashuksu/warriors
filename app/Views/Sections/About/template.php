<section id="<?= $section ?? '' ?>" class="section <?= $section ?? '' ?>">
    <div class="container">

        <?php
        if (!empty($collection) && is_array($collection)) {
            foreach ($collection as $index => $item) {
                $templateService->render(__DIR__ . '/item.php', [
                    'item' => $item,
                    'isReverse' => $index % 2 !== 0,
                    'image' => $viteService->getAssetPath('dist/assets/images/' . ($item['image'] ?? ''))
                ]);
            }
        }
        ?>

    </div>
</section>