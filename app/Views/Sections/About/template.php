<section id="<?= $section ?? '' ?>" class="section <?= $section ?? '' ?>">
    <div class="container">

        <?php

        use function Helpers\renderTemplate;

        if (!empty($about) && is_array($about)) {
            foreach ($about as $index => $item) {
                renderTemplate($itemPath ?? __DIR__ . '/item.php', [
                    'item' => $item,
                    'isReverse' => $index % 2 !== 0,
                    'image' => ($imagePartPath ?? APP_PATH . 'assets/images/') . ($item['image'] ?? '')
                ]);
            }
        }
        ?>

    </div>
</section>