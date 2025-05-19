<section id="<?= $section ?? '' ?>" class="section <?= $section ?? '' ?>">
    <div class="container">

        <?php

        use function Helpers\renderTemplate;

        if (!empty($about) && is_array($about)) {
            foreach ($about as $index => $item) {
                renderTemplate($itemPath, [
                    'item' => $item,
                    'isReverse' => $index % 2 !== 0,
                    'image' => ($imagePartPath ?? "") . ($item['image'] ?? ''),
                ]);
            }
        }
        ?>

    </div>
</section>